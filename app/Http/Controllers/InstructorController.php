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
    public function index()
    {
        $data = Instructor::take(500)
        ->get();

        return view('instructor.index', compact('data'));
    }

    public function create()
    {
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('instructor.create', compact('tipo_familia', 'partido', 'estado_civil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'documento' => 'required|unique:personas,documento',
        ]);

        $persona = Persona::create([
            'documento' => $request->documento,
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
            'estado_civil_id' => $request->estado_civil_id,
            'partido_id' => $request->partido_id,
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
                    'partido_id' => $partido[$i],
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
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'documento' => 'required|unique:personas,documento,'. $instructor->id,
        ]);

        $persona = $instructor->persona;

        $persona->update([
            'documento' => $request->documento,
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
            'estado_civil_id' => $request->estado_civil_id,
            'partido_id' => $request->partido_id,
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
                        'partido_id' => $partido[$i],
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
}
