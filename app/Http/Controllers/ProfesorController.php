<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsistenciaMotivo;
use App\Models\CursoAlumno;
use App\Models\CursoAlumnoAsistencia;
use App\Models\CursoHabilitado;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profesor = $user->persona->instructor;
        if(empty($profesor)){
            return redirect()->route('home')->with('No tiene un perfil creado para ser instructor.');
        }

        $curso_activos = CursoHabilitado::where('instructor_id', $profesor->id)
        ->where('concluido', 0)
        ->where('estado_id', 1)
        ->get();

        return view('profesor.index', compact('profesor', 'curso_activos'));
    }

    public function show(CursoHabilitado $cursoHabilitado)
    {
        $user = auth()->user();
        $profesor = $user->persona->instructor;

        $alumnos_cursando = CursoAlumno::where('curso_habilitado_id', $cursoHabilitado->id)
        ->whereIn('curso_a_estado_id', [1, 2])
        ->get();

        $asistencia_fecha = Asistencia::where('curso_habilitado_id', $cursoHabilitado->id)
        ->where('estado_id', 1)
        ->orderBy('fecha_asistencia', 'ASC')
        ->get();

        $asistencia = CursoAlumnoAsistencia::where('curso_habilitado_id', $cursoHabilitado->id)
        ->orderBy('fecha', 'ASC')
        ->get();

        return view('profesor.show', compact('cursoHabilitado', 'profesor', 'alumnos_cursando', 'asistencia_fecha'
        , 'asistencia'));
    }

    public function asistencia(CursoHabilitado $cursoHabilitado)
    {

        $fecha_actual = Carbon::now();
        $motivo = AsistenciaMotivo::where('estado_id', 1)->get();
        return view('profesor.asistencia', compact('cursoHabilitado', 'motivo', 'fecha_actual'));
    }

    public function asistencia_post(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $request->validate([
            'fecha' => 'required',
        ]);

        $asistencia = $request->asistencia;
        $alumno_id = $request->alumno_id;
        $asistencia_valor = $request->asistencia_valor;
        $fecha = $request->fecha;
        $fecha_fin = $cursoHabilitado->periodo_hasta;
        $fecha_actual = Carbon::now();

        // VALIDAD SI LA FECHA ES MAYOR A LA FECHA FIN DE CURSO
        if($fecha > $fecha_fin){
            return redirect()->back()->withInput()->withErrors('La fecha ingresada supera la fecha final del curso.');
        }
        // VALIDA SI LA FECHA ES MENOR A LA FECHA DE INICIO DE CURSO
        if($fecha < $cursoHabilitado->periodo_desde){
            return redirect()->back()->withInput()->withErrors('La fecha ingresada es menor a la fecha de inicio de curso.');
        }
        // VALIDAD QUE LA FECHA SEA MENOR A LA FECHA ACTUAL
        if($fecha_actual < $fecha){
            return redirect()->back()->withInput()->withErrors('La fecha no puede superar a la fecha actual.');
        }

        $dias['0'] = ($cursoHabilitado->domingo == 1 ? '1' : 0);
        $dias['1'] = ($cursoHabilitado->lunes == 1 ? '2' : 0);
        $dias['2'] = ($cursoHabilitado->martes == 1 ? '3' : 0);
        $dias['3'] = ($cursoHabilitado->miercoles == 1 ? '4' : 0);
        $dias['4'] = ($cursoHabilitado->jueves == 1 ? '5' : 0);
        $dias['5'] = ($cursoHabilitado->viernes == 1 ? '6' : 0);
        $dias['6'] = ($cursoHabilitado->sabado == 1 ? '7' : 0);
        $dia = $this->saber_dia($fecha);
        $llama_asistencia = 0;

        for ($i=0; $i < 7; $i++) {
            if($dias[$i] == $dia['dia']){
                $llama_asistencia = 1;
            }
        }

        if($llama_asistencia === 0){
            return redirect()->back()->withInput()->withErrors('Esta fecha no corresponde al dia que se deba de tener una clase.');
        }

        // VALIDA SI YA HAY DEUPLICACION DE CLASE Y DIA
        $exites_clase = Asistencia::where('fecha_asistencia', $fecha)
        ->where('curso_habilitado_id', $cursoHabilitado->id)
        ->first();

        if(!(empty($exites_clase))){
            return redirect()->back()->withInput()->withErrors('Ya se llamo lista en esta fecha: '. $fecha .'.');
        }

        // PREGUNTA SI LA CLASE FUE SUSPENDIDA
        if($request->suspender == 0){
            // VALIDA SI NO HAY NINGUN ALUMNO PRESENTE
            if(empty($asistencia)){
                return redirect()->back()->withInput()->withErrors('Debe seleccionar por lo menos alumno.');
            }
            // CREA UN REGISTRO DE ASISTENCIA DE CLASE
            Asistencia::create([
                'curso_habilitado_id' => $cursoHabilitado->id,
                'fecha_asistencia' => $fecha,
                'asistencia_motivo_id' => 1,
                'observacion' => 'Clase desarrollada sin inconvenientes.',
                'clase' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
            // RECORRE LA ASISTENCIA Y ALUMNI Y GUARDA EN SU TABLA
            for ($i=0; $i < count($alumno_id) ; $i++) {
                $presente = $asistencia_valor[$i];

                CursoAlumnoAsistencia::create([
                    'curso_habilitado_id' => $cursoHabilitado->id,
                    'alumno_id' => $alumno_id[$i],
                    'fecha' => $fecha,
                    'asistencia' => $presente,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);

                if($presente == 1){
                    $aux_alumno = CursoAlumno::where('curso_habilitado_id', $cursoHabilitado->id)
                    ->where('alumno_id', $alumno_id[$i])
                    ->first();

                    $aux_alumno->update([
                        'curso_a_estado_id' => 2,
                        'modif_user_id' => auth()->user()->id,
                    ]);
                }
            }
        }else{
            Asistencia::create([
                'curso_habilitado_id' => $cursoHabilitado->id,
                'fecha_asistencia' => $fecha,
                'asistencia_motivo_id' => $request->motivo,
                'observacion' => $request->observacion,
                'clase' => 0,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);

            $fecha_fin = Carbon::parse($fecha_fin);
            $fecha_fin = $fecha_fin->addWeeks(2);
            $cursoHabilitado->periodo_hasta = $fecha_fin;
            $cursoHabilitado->update();

        }

        return redirect()->route('profesor.show', $cursoHabilitado)->with('message', 'Asistencia cargado con exito.');
    }

    public function calificar(CursoHabilitado $cursoHabilitado)
    {
        return view('profesor.calificar', compact('cursoHabilitado'));
    }

    public function calificar_post(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $auxiliar = $request->asistencia;
        $alumno_id = $request->alumno_id;
        $calificacion = $request->asistencia_valor;
        if(empty($auxiliar)){
            return redirect()->back()->withInput()->withErrors('Debe seleccionar por lo menos alumno.');
        }

        for ($i=0; $i < count($alumno_id) ; $i++) {
            $presente = $calificacion[$i];

            $cursoAlumno = CursoAlumno::where('curso_habilitado_id', $cursoHabilitado->id)
            ->where('alumno_id', $alumno_id[$i])
            ->where('estado_id', 1)
            ->first();

            $cursoAlumno->update([
                'aprobado' => $presente,
                'modif_user_id' => auth()->user()->id,
            ]);

        }

        $cursoHabilitado->concluido = 1;
        $cursoHabilitado->update();

        return redirect()->route('profesor.index')->with('message', 'Calificacion de alumnos completado.');
    }
}
