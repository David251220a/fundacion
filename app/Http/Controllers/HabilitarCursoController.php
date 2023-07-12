<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\CursoAEstado;
use App\Models\CursoAlumno;
use App\Models\CursoAlumnoAsistencia;
use App\Models\CursoHabilitado;
use App\Models\Noticia;
use App\Models\NoticiaFile;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabilitarCursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:habilitado.index')->only('index');
        $this->middleware('permission:habilitado.create')->only('create');
        $this->middleware('permission:habilitado.store')->only('store');
        $this->middleware('permission:habilitado.edit')->only('edit');
        $this->middleware('permission:habilitado.update')->only('update');
        $this->middleware('permission:habilitado.show')->only('show');
    }

    public function index()
    {
        $data = CursoHabilitado::take(1000)
        ->orderBy('created_at', 'DESC')
        ->paginate(50);
        return view('habilitar.index', compact('data'));
    }

    public function create()
    {
        $periodo = Periodo::all();
        return view('habilitar.create', compact('periodo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periodo_desde'  => 'required',
            'periodo_hasta' => 'required',
            'duracion' => 'required',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
            'portada' => 'required|image|mimes:jpeg,png,jpg',
            'curso_id' => 'required',
        ]);

        $lunes = ($request->lunes == 'on' ? 1 : 0);
        $martes = ($request->martes == 'on' ? 1 : 0);
        $miercoles = ($request->miercoles == 'on' ? 1 : 0);
        $jueves = ($request->jueves == 'on' ? 1 : 0);
        $viernes = ($request->viernes == 'on' ? 1 : 0);
        $sabado = ($request->sabado == 'on' ? 1 : 0);
        $domingo = ($request->domingo == 'on' ? 1 : 0);

        if(($lunes == 0) && ($martes == 0) && ($miercoles == 0) && ($jueves == 0) && ($viernes == 0) && ($sabado == 0) && ($domingo == 0) ){
            return redirect()->back()->withInput()->withErrors('Debe seleccionar un dia');
        }

        if($request->publicar == 2){
            if(empty($request->descripcion)){
                return redirect()->back()->withInput()->withErrors('Si desea publicar el curso en las noticias debe de tener una descripcion para que sirva de titulo.');
            }

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


        $curso = CursoHabilitado::create([
            'tipo_curso_id' => $request->tipo_curso_id,
            'curso_id' => $request->curso_id,
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
            $tipo = Curso::find($request->curso_id);
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

        return redirect()->route('habilitado.index')->with('message', 'Curso habilitado con exito.');
    }

    public function edit(CursoHabilitado $cursoHabilitado)
    {
        $periodo = Periodo::all();
        return view('habilitar.edit', compact('periodo', 'cursoHabilitado'));
    }

    public function show(CursoHabilitado $cursoHabilitado)
    {
        $estados_alumno = CursoAEstado::all();
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

        return view('habilitar.show', compact('cursoHabilitado', 'estados_alumno', 'alumnos_cursando', 'asistencia_fecha', 'asistencia'));
    }

    public function update(CursoHabilitado $cursoHabilitado, Request $request)
    {
        $request->validate([
            'periodo_desde'  => 'required',
            'periodo_hasta' => 'required',
            'duracion' => 'required',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
            'portada' => 'image|mimes:jpeg,png,jpg',
            'curso_id' => 'required',
        ]);

        $lunes = ($request->lunes == 'on' ? 1 : 0);
        $martes = ($request->martes == 'on' ? 1 : 0);
        $miercoles = ($request->miercoles == 'on' ? 1 : 0);
        $jueves = ($request->jueves == 'on' ? 1 : 0);
        $viernes = ($request->viernes == 'on' ? 1 : 0);
        $sabado = ($request->sabado == 'on' ? 1 : 0);
        $domingo = ($request->domingo == 'on' ? 1 : 0);

        if(($lunes == 0) && ($martes == 0) && ($miercoles == 0) && ($jueves == 0) && ($viernes == 0) && ($sabado == 0) && ($domingo == 0) ){
            return redirect()->back()->withInput()->withErrors('Debe seleccionar un dia');
        }

        if($request->publicar == 2){
            if(empty($request->observacion)){
                return redirect()->back()->withInput()->withErrors('Si desea publicar el curso en las noticias debe de tener una observacion para que sirva de contenido.');
            }
        }

        $cursoHabilitado->tipo_curso_id = $request->tipo_curso_id;
        $cursoHabilitado->curso_id = $request->curso_id;
        $cursoHabilitado->periodo_id = $request->periodo_id;
        $cursoHabilitado->instructor_id = $request->instructor_id;
        $cursoHabilitado->descripcion = $request->descripcion;
        $cursoHabilitado->observacion = $request->observacion;
        $cursoHabilitado->periodo_desde = $request->periodo_desde;
        $cursoHabilitado->periodo_hasta = $request->periodo_hasta;
        $cursoHabilitado->duracion = str_replace('.', '', $request->duracion);
        $cursoHabilitado->hora_entrada = $request->hora_entrada;
        $cursoHabilitado->hora_salida = $request->hora_salida;
        $cursoHabilitado->precio  = str_replace('.', '', $request->precio);
        $cursoHabilitado->lunes = $lunes;
        $cursoHabilitado->martes = $martes;
        $cursoHabilitado->miercoles = $miercoles;
        $cursoHabilitado->jueves = $jueves;
        $cursoHabilitado->viernes = $viernes;
        $cursoHabilitado->sabado = $sabado;
        $cursoHabilitado->domingo = $domingo;
        if($request->portada)
        {
            $filePath = $request->file('portada')->store('public/curso_habilitado');
            $cursoHabilitado->portada = $filePath;
        }
        $cursoHabilitado->estado_id = $request->estado_id;
        $cursoHabilitado->modif_user_id = auth()->user()->id;

        $cursoHabilitado->update();

        return redirect()->route('habilitado.edit', $cursoHabilitado)->with('message', 'Curso habilitado con exito.');
    }
}
