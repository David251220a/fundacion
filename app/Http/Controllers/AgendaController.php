<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Curso;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use App\Models\Instructor;
use App\Models\Noticia;
use App\Models\NoticiaFile;
use App\Models\Periodo;
use App\Models\TipoCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function index()
    {

        $familia = TipoCurso::where('estado_id', 1)->orderBy('descripcion', 'ASC')->get();

        return view('agenda.index', compact('familia'));
    }

    public function show(TipoCurso $tipoCurso)
    {
        $cursos = Curso::where('tipo_curso_id', $tipoCurso->id)->orderBy('descripcion', 'ASC')
        ->orderBy('curso_modulo_id', 'ASC')
        ->where('estado_id', 1)
        ->get();
        return view('agenda.show', compact('cursos', 'tipoCurso'));
    }

    public function agenda(Curso $curso)
    {
        return view('agenda.agenda', compact('curso'));
    }

    public function habilitar(Curso $curso)
    {
        $periodo = Periodo::all();
        $instructor = Instructor::where('estado_id', 1)->get();
        if(count($curso->agendado) <= 0){
            return redirect()->back()->withInput()->withErrors('Debe estar por lo menos un alumno agendado para habilitar el curso.');
        }
        return view('agenda.habilitar', compact('curso', 'periodo', 'instructor'));
    }

    public function habilitar_post(Curso $curso, Request $request)
    {
        $request->validate([
            'periodo_desde'  => 'required',
            'periodo_hasta' => 'required',
            'duracion' => 'required',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
            'portada' => 'image|mimes:jpeg,png,jpg',
        ]);

        $lunes = ($request->lunes == 'on' ? 1 : 0);
        $martes = ($request->martes == 'on' ? 1 : 0);
        $miercoles = ($request->miercoles == 'on' ? 1 : 0);
        $jueves = ($request->jueves == 'on' ? 1 : 0);
        $viernes = ($request->viernes == 'on' ? 1 : 0);
        $sabado = ($request->sabado == 'on' ? 1 : 0);
        $domingo = ($request->domingo == 'on' ? 1 : 0);
        $alumnos = $request->alumno_id;
        $inscripto = $request->inscribir;

        if(empty($inscripto)){
            return redirect()->back()->withInput()->withErrors('Debe seleccionar los alumnos que van a inscribirse');
        }

        if(($lunes == 0) && ($martes == 0) && ($miercoles == 0) && ($jueves == 0) && ($viernes == 0) && ($sabado == 0) && ($domingo == 0) ){
            return redirect()->back()->withInput()->withErrors('Debe seleccionar un dia');
        }

        if($request->publicar == 2){
            if(empty($request->observacion)){
                return redirect()->back()->withInput()->withErrors('Si desea publicar el curso en las noticias debe de tener una observacion para que sirva de contenido.');
            }
        }
        $filePath = '';
        if($request->portada)
        {
            $filePath = $request->file('portada')->store('public/curso_habilitado');
        }else{
            $filePath = '';
        }

        $cursoHabilitado = CursoHabilitado::create([
            'tipo_curso_id' => $curso->familia->id,
            'curso_id' => $curso->id,
            'periodo_id' => $request->periodo_id,
            'instructor_id' => $request->instructor_id,
            'descripcion' => $request->descripcion,
            'observacion' => $request->observacion,
            'periodo_desde' => $request->periodo_desde,
            'periodo_hasta' => $request->periodo_hasta,
            'duracion' => str_replace('.', '', $request->duracion),
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'precio'  => str_replace('.', '', $request->precio),
            'lunes' => $lunes,
            'martes' => $martes,
            'miercoles' => $miercoles,
            'jueves' => $jueves,
            'viernes' => $viernes,
            'sabado' => $sabado,
            'domingo' => $domingo,
            'portada' => $filePath,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        if($request->publicar == 2){
            $tipo = $curso;
            $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', strtolower($tipo->descripcion));
            $fecha = date('dmY');
            $fecha_actual = date('Y-m-d');
            $cont = Noticia::where(DB::raw('CAST(created_at AS DATE)'), $fecha_actual)->count();
            $slug = $slug . '-' . $fecha . '-' . $cont;

            $noticias = Noticia::create([
                'titulo' => $request->descripcion,
                'slug' => $slug,
                'contenido' => $request->observacion,
                'feed_facebook' => '',
                'feed_instagram' => '',
                'portada' => 1,
                'publicado' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);

            NoticiaFile::create([
                'noticia_id' => $noticias->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        for ($i=0; $i < count($inscripto) ; $i++) {
            $aux_si = ($inscripto[$i] == 'on' ? 1 : 0);
            if($aux_si == 1){
                $cursoAlumno = CursoAlumno::create([
                    'curso_habilitado_id' => $cursoHabilitado->id,
                    'curso_a_estado_id' => 1,
                    'alumno_id' => $alumnos[$i],
                    'total_pagar' => $cursoHabilitado->precio,
                    'monto_abonado' => 0,
                    'saldo' => $cursoHabilitado->precio,
                    'aprobado' => 0,
                    'certificado' => '',
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);

                $agendado_alumno = Agenda::where('alumno_id', $alumnos[$i])
                ->where('curso_a_estado_id', 4)
                ->where('curso_id', $curso->id)
                ->first();

                $agendado_alumno->estado_id = 2;
                $agendado_alumno->curso_a_estado_id = 1;
                $agendado_alumno->update();
            }
        }

        return redirect()->route('habilitado.show', $cursoHabilitado)->with('message', 'Curso habilitado con exito.');
    }

    public function general()
    {
        return view('agenda.general');
    }

}
