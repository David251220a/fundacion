<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\CursoHabilitado;
use App\Models\EstadoCivil;
use App\Models\Partido;
use App\Models\Persona;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;

class CursoAlumnoController extends Controller
{
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
            return redirect()->route('cursoAlumno.crear_alumno', $cursoHabilitado);
        }else{
            if(empty($persona->alumno)){
                Alumno::create([
                    'persona_id' => $persona->id,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }
        }

        $alumno = $persona->alumno;
        return redirect()->route('cursoAlumno.agregar_alumno', [$cursoHabilitado, $alumno])->with('message', 'Alumno inscrito con exito.');

    }

    public function crear_alumno(CursoHabilitado $cursoHabilitado)
    {
        $tipo_familia = TipoFamilia::all();
        $partido = Partido::all();
        $estado_civil = EstadoCivil::all();
        return view('cursoAlumno.create', compact('tipo_familia', 'partido', 'estado_civil', 'cursoHabilitado'));
    }

    public function crear_alumno_post(CursoHabilitado $cursoHabilitado, Request $request)
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

        $alumno = Alumno::create([
            'persona_id' => $persona->id,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('cursoAlumno.agregar_alumno', [$cursoHabilitado, $alumno])->with('message', 'Alumno inscrito con exito.');
    }
}
