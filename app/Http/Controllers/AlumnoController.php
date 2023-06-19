<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\EstadoCivil;
use App\Models\Partido;
use App\Models\Persona;
use App\Models\PersonaFamilia;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $search = str_replace('.', '', $request->search);
        if($request->search)
        {
            $data = Alumno::join('personas AS a', 'alumnos.persona_id', '=', 'a.id')
            ->select('alumnos.*')
            ->where('a.documento', $search)
            ->orderBy('a.documento')
            ->paginate(50);
        }else{
            $data = Alumno::join('personas AS a', 'alumnos.persona_id', '=', 'a.id')
            ->select('alumnos.*')
            ->orderBy('a.documento')
            ->paginate(50);
        }
        return view('alumno.index', compact('data', 'search'));
    }

    public function create()
    {
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('alumno.create', compact('tipo_familia', 'partido', 'estado_civil'));
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

        Alumno::create([
            'persona_id' => $persona->id,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('alumno.index')->with('message', 'Se ha creado con exito el alumno.');
    }

    public function edit(Alumno $alumno)
    {
        $data = $alumno->persona;
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('alumno.edit', compact('data', 'tipo_familia', 'partido', 'estado_civil', 'alumno'));
    }

    public function update(Alumno $alumno, Request $request)
    {
        $persona = $alumno->persona;

        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'documento' => 'required|unique:personas,documento,'. $persona->id,
        ]);

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

        $alumno->update([
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

        return redirect()->route('alumno.edit', $alumno)->with('message', 'Alumno Actualizado.');
    }

    public function validar()
    {
        return view('alumno.validar');
    }

    public function validar_post(Request $request)
    {
        $documento = str_replace('.', '', $request->documento);
        $persona = Persona::where('documento', $documento)
        ->first();

        if(empty($persona->alumno))
        {
            $alumno = null;
        }else{
            $alumno = $persona->alumno;
        }


        if($alumno != null){
            return redirect()->route('alumno.edit', $alumno);
        }else{
            if($persona === null){
                return redirect()->route('alumno.create');
            }else{
                return redirect()->route('alumno.add_nuevo', $persona);
            }

        }
    }

    public function add_nuevo(Persona $persona)
    {
        $data = $persona;
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('alumno.add', compact('data', 'tipo_familia', 'partido', 'estado_civil'));
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


        Alumno::create([
            'persona_id' => $persona->id,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
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

        return redirect()->route('alumno.index')->with('message', 'Alumno creado con exito.');
    }
}
