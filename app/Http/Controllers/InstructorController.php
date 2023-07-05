<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use App\Models\Instructor;
use App\Models\Partido;
use App\Models\Persona;
use App\Models\PersonaFamilia;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:instructor.index')->only('index');
        $this->middleware('permission:instructor.create')->only('create');
        $this->middleware('permission:instructor.store')->only('store');
        $this->middleware('permission:instructor.edit')->only('edit');
        $this->middleware('permission:instructor.update')->only('update');
        $this->middleware('permission:instructor.update')->only('update');
        $this->middleware('permission:instructor.add_nuevo')->only('add_nuevo');
        $this->middleware('permission:instructor.add_nuevo')->only('add_nuevo_post');
        $this->middleware('permission:instructor.validar')->only('validar');
        $this->middleware('permission:instructor.validar')->only('validar');
    }

    public function index()
    {
        $data = Instructor::take(500)
        ->get();

        return view('instructor.index', compact('data'));
    }

    public function create(Request $request)
    {
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        $documento = str_replace('.', '', $request->documento);
        return view('instructor.create', compact('tipo_familia', 'partido', 'estado_civil', 'documento'));
    }

    public function store(Request $request)
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
        $partido = $request->partido;

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

        Instructor::create([
            'persona_id' => $persona->id,
            'firma' => '',
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('instructor.index')->with('message', 'Se ha creado con exito el instrucor.');
    }

    public function show(Instructor $instructor)
    {

    }

    public function edit(Instructor $instructor)
    {
        $data = $instructor->persona;
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('instructor.edit', compact('data', 'tipo_familia', 'partido', 'estado_civil', 'instructor'));
    }

    public function update(Instructor $instructor, Request $request)
    {
        $persona = $instructor->persona;

        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'documento' => 'required|unique:personas,documento,'. $persona->id,
        ]);

        $persona->update([
            'documento' => str_replace('.', '', $request->documento),
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'sexo' => $request->sexo,
            'celular' => $request->celular,
            'pais_id' => $request->pais_id,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'departamento_id' => $request->departamento_id,
            'ciudad_id' => $request->ciudad_id,
            'barrio_id' => $request->barrio_id,
            'email' => $request->email,
            'estado_id' => $request->estado_id,
            'estado_civil_id' => $request->estado_civil_id,
            // 'partido_id' => $request->partido_id,
            'partido_id' => 1,
            'modif_user_id' => auth()->user()->id,
        ]);

        $instructor->update([
            'modif_user_id' => auth()->user()->id,
        ]);

        $nombre_familiar = $request->nombre_familiar;
        $apellido_familiar = $request->apellido_familiar;
        $tipo_familia = $request->tipo_familia;
        $partido = $request->partido;
        $familia_id = $request->familia_id;

        $aux_familia = PersonaFamilia::where('persona_id', $persona->id)->where('estado_id', 1)->get();
        foreach ($aux_familia as $item) {
            $item->update([
                'estado_id' => 2,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        if($nombre_familiar)
        {
            for ($i=0; $i < count($nombre_familiar); $i++) {

                if($familia_id[$i] == 0){
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
                }else{
                    $familia = PersonaFamilia::find($familia_id[$i]);
                    $familia->update([
                        'estado_id' => 1,
                        'modif_user_id' => auth()->user()->id,
                    ]);
                }
            }
        }

        return redirect()->route('instructor.edit', $instructor)->with('message', 'Instructor Actualizado.');
    }

    public function validar()
    {
        return view('instructor.validar');
    }

    public function validar_post(Request $request)
    {
        $documento = str_replace('.', '', $request->documento);
        $persona = Persona::where('documento', $documento)
        ->first();
        if(empty($persona->instructor))
        {
            $instructor = null;
        }else{
            $instructor = $persona->alumno;
        }

        if($instructor){
            return redirect()->route('instructor.edit', $instructor);
        }else{
            if($persona === null){
                return redirect()->route('instructor.create', [ 'documento' => $documento]);
            }else{
                return redirect()->route('instructor.add_nuevo', $persona);
            }
        }
    }

    public function add_nuevo(Persona $persona)
    {
        $data = $persona;
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('instructor.add', compact('data', 'tipo_familia', 'partido', 'estado_civil'));
    }

    public function add_nuevo_post(Persona $persona, Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'documento' => 'required|unique:personas,documento,'. $persona->id,
        ]);

        $persona->update([
            'documento' => str_replace('.', '', $request->documento),
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'sexo' => $request->sexo,
            'celular' => $request->celular,
            'pais_id' => $request->pais_id,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'departamento_id' => $request->departamento_id,
            'ciudad_id' => $request->ciudad_id,
            'barrio_id' => $request->barrio_id,
            'estado_id' => $request->estado_id,
            'email' => $request->email,
            'estado_civil_id' => $request->estado_civil_id,
            // 'partido_id' => $request->partido_id,
            'partido_id' => 1,
            'modif_user_id' => auth()->user()->id,
        ]);


        $instructor = Instructor::create([
            'persona_id' => $persona->id,
            'firma' => '',
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $nombre_familiar = $request->nombre_familiar;
        $apellido_familiar = $request->apellido_familiar;
        $tipo_familia = $request->tipo_familia;
        // $partido = $request->partido;
        $familia_id = $request->familia_id;

        $aux_familia = PersonaFamilia::where('persona_id', $persona->id)->where('estado_id', 1)->get();
        foreach ($aux_familia as $item) {
            $item->update([
                'estado_id' => 2,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        if($nombre_familiar)
        {
            for ($i=0; $i < count($nombre_familiar); $i++) {

                if($familia_id[$i] == 0){
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
                }else{
                    $familia = PersonaFamilia::find($familia_id[$i]);
                    $familia->update([
                        'estado_id' => 1,
                        'modif_user_id' => auth()->user()->id,
                    ]);
                }
            }
        }

        return redirect()->route('instructor.index')->with('message', 'Instructor creado con exito.');
    }
}
