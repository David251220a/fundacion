<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\AsistenciaMotivo;
use App\Models\CursoAlumno;
use App\Models\CursoAlumnoAsistencia;
use App\Models\CursoHabilitado;
use App\Models\CursoInAlumno;
use App\Models\CursoIngreso;
use App\Models\EstadoCivil;
use App\Models\FormaPago;
use App\Models\IngresoMatricula;
use App\Models\Partido;
use App\Models\Persona;
use App\Models\TipoFamilia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CursoAlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cursoAlumno.buscar')->only('buscar');
        $this->middleware('permission:cursoAlumno.buscar')->only('buscar_post');
        $this->middleware('permission:cursoAlumno.agregar_alumno')->only('agregar_alumno');
        $this->middleware('permission:cursoAlumno.agregar_alumno')->only('agregar_alumno_post');
        $this->middleware('permission:cursoAlumno.crear_alumno')->only('crear_alumno');
        $this->middleware('permission:cursoAlumno.crear_alumno')->only('crear_alumno_post');
        $this->middleware('permission:cursoAlumno.asistencia')->only('asistencia');
        $this->middleware('permission:cursoAlumno.asistencia')->only('asistencia_post');
    }

    public function buscar(CursoHabilitado $cursoHabilitado)
    {
        return view('cursoAlumno.buscar', compact('cursoHabilitado'));
    }

    public function buscar_post(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $request->validate([
            'documento' => 'required',
        ]);

        $documento = str_replace('.', '', $request->documento);
        $persona = Persona::where('documento', $documento)->first();

        if(empty($persona)){
            return redirect()->route('cursoAlumno.crear_alumno', ['cursoHabilitado' => $cursoHabilitado, 'documento'=> $documento]);
        }else{
            if(empty($persona->alumno)){
                $alumno = Alumno::create([
                    'persona_id' => $persona->id,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);

                $aux = $alumno->id;
            }else{
                $aux = $persona->alumno->id;
            }
        }

        $alumno = Alumno::find($aux);

        $curso_alumno = CursoAlumno::where('alumno_id', $alumno->id)
        ->where('curso_habilitado_id', $cursoHabilitado->id)
        ->first();

        if(!(empty($curso_alumno))){
            return redirect()->route('cursoAlumno.buscar', $cursoHabilitado)->with('message', 'El alumno con este numero de cedula ya esta inscrito en este curso.');
        }

        return redirect()->route('cursoAlumno.agregar_alumno', [$cursoHabilitado, $alumno]);

    }

    public function crear_alumno(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        $documento = str_replace('.', '', $request->documento);
        return view('cursoAlumno.create', compact('tipo_familia', 'partido', 'estado_civil', 'cursoHabilitado', 'documento'));
    }

    public function crear_alumno_post(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'documento' => 'required|unique:personas,documento',
        ]);

        if(empty($request->fecha)){
            $fecha_nacimiento = '1990-01-01';
        }else{
            $fecha_nacimiento = $request->fecha_nacimiento;
        }

        $persona = Persona::create([
            'documento' => str_replace('.', '', $request->documento),
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'sexo' => $request->sexo,
            'celular' => $request->celular,
            'pais_id' => $request->pais_id,
            'fecha_nacimiento' => $fecha_nacimiento,
            'departamento_id' => $request->departamento_id,
            'ciudad_id' => $request->ciudad_id,
            'barrio_id' => $request->barrio_id,
            'estado_id' => $request->estado_id,
            'email' => $request->email,
            'estado_civil_id' => $request->estado_civil_id,
            // 'partido_id' => $request->partido_id,
            'partido_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $nombre_familiar = $request->nombre_familiar;
        $apellido_familiar = $request->apellido_familiar;
        $tipo_familia = $request->tipo_familia;
        // $partido = $request->partido;

        if($nombre_familiar)
        {
            for ($i=0; $i < count($nombre_familiar); $i++) {
                $persona->familiares()->create([
                    'nombre' => $nombre_familiar[$i],
                    'apellido' => $apellido_familiar[$i],
                    'tipo_familia_id' => $tipo_familia[$i],
                    // 'partido_id' => $partido[$i],
                    'partido_id' => 1,
                    'estado_id' => $request->estado_id,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }
        }

        $alumno = Alumno::create([
            'persona_id' => $persona->id,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('cursoAlumno.agregar_alumno', [$cursoHabilitado, $alumno])->with('message', 'Alumno creado con exito.');
    }

    public function agregar_alumno(CursoHabilitado $cursoHabilitado, Alumno $alumno)
    {
        $forma_pago = FormaPago::all();

        return view('cursoAlumno.inscribir', compact('cursoHabilitado', 'alumno', 'forma_pago'));
    }

    public function agregar_alumno_post(CursoHabilitado $cursoHabilitado, Alumno $alumno, Request $request)
    {
        $monto_abonado = ( empty($request->total_pagar) ? 0 : str_replace('.', '', $request->total_pagar));

        $persona = $alumno->persona;
        $persona->celular = $request->celular;
        $persona->modif_user_id = auth()->user()->id;
        $persona->update();

        $cursoAlumno = CursoAlumno::create([
            'curso_habilitado_id' => $cursoHabilitado->id,
            'curso_a_estado_id' => 1,
            'alumno_id' => $alumno->id,
            'total_pagar' => $cursoHabilitado->precio,
            'monto_abonado' => $monto_abonado,
            'saldo' => ($cursoHabilitado->precio - $monto_abonado),
            'certificado_monto' => $cursoHabilitado->precio_certificado,
            'certificado_pagado' => 0,
            'certificado_saldo' => $cursoHabilitado->precio_certificado,
            'aprobado' => 0,
            'certificado' => '',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoMatricula::where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo += 1;

        if($monto_abonado > 0){
            $ingreso = IngresoMatricula::create([
                'alumno_id' => $alumno->id,
                'fecha_ingreso' => $fecha_actual,
                'forma_pago_id' => $request->forma_pago_id,
                'año' => $anio,
                'mes' => $mes,
                'numero_recibo' => $numero_recibo,
                'sucursal' => '000',
                'general' => '000',
                'factura_numero' => 0,
                'total_pagado' => $monto_abonado,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);

            $ingreso->detalle()->create([
                'curso_habilitado_id' => $cursoHabilitado->id,
                'alumno_id' => $alumno->id,
                'monto_total' => $cursoHabilitado->precio,
                'monto_pagado' => $monto_abonado,
                'saldo' => ($cursoHabilitado->precio - $monto_abonado),
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $existe_insumo = CursoIngreso::where('curso_habilitado_id', $cursoHabilitado->id)
        ->where('fecha','>=',date('Y-m-d', strtotime($fecha_actual)))
        ->where('estado_id', 1)
        ->get();

        foreach ($existe_insumo as $item) {
            CursoInAlumno::create([
                'curso_ingreso_id' => $item->id,
                'alumno_id' => $alumno->id,
                'total_pagar' => str_replace('.', '', $item->precio),
                'total_pagado' => 0,
                'saldo' => str_replace('.', '', $item->precio),
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        return redirect()->route('habilitado.show', $cursoHabilitado)->with('message', 'Alumno inscrito con exito.');
    }

    public function asistencia(CursoHabilitado $cursoHabilitado)
    {
        $fecha_actual = Carbon::now();
        $motivo = AsistenciaMotivo::where('estado_id', 1)->get();
        return view('cursoAlumno.asistencia', compact('cursoHabilitado', 'fecha_actual', 'motivo'));
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
                return redirect()->back()->withInput()->withErrors('Debe seleccionar por lo menos alumno');
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
                }else{

                    $contar_ausencia = CursoAlumnoAsistencia::where('alumno_id', $alumno_id[$i])
                    ->where('curso_habilitado_id', $cursoHabilitado->id)
                    ->where('asistencia', 0)
                    ->count();


                    if ($contar_ausencia >= 2) {
                        $alumnoCuenta = CursoAlumno::where('alumno_id', $alumno_id[$i])
                        ->where('curso_habilitado_id', $cursoHabilitado->id)
                        ->first();

                        if ($alumnoCuenta->reactivado == 0){
                            $aux_alumno = CursoAlumno::where('curso_habilitado_id', $cursoHabilitado->id)
                            ->where('alumno_id', $alumno_id[$i])
                            ->first();

                            $aux_alumno->update([
                                'curso_a_estado_id' => 6,
                                'modif_user_id' => auth()->user()->id,
                            ]);
                        }
                    }
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
            $cursoHabilitado->modif_user_id = auth()->user()->id;
            $cursoHabilitado->update();

            $ingreso = CursoIngreso::where('curso_habilitado_id', $cursoHabilitado->id)
            ->where('fecha', '>=', $fecha)
            ->where('estado_id', 1)
            ->get();

            foreach ($ingreso as $item) {
                $fecha_viejo = Carbon::parse($item->fecha);
                $fecha_nuevo = $fecha_viejo->addWeeks(1);
                $item->fecha = $fecha_nuevo;
                $item->modif_user_id = auth()->user()->id;
                $item->update();
            }

        }

        return redirect()->route('habilitado.show', $cursoHabilitado)->with('message', 'Asistencia cargada con exito.');

    }

}
