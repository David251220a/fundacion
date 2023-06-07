<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\TipoCurso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $data = Curso::orderBy('id', 'DESC')
        ->get();

        return view('curso.index', compact('data'));
    }

    public function create()
    {
        $tipo_curso = TipoCurso::where('estado_id', 1)->get();
        return view('curso.create', compact('tipo_curso'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'tipo_curso_id' => 'required',
        ]);

        Curso::create([
            'descripcion' => $request->descripcion,
            'tipo_curso_id' => $request->tipo_curso_id,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('curso.index')->with('message', 'Curso creado con exito.');
    }

    public function edit(Curso $curso)
    {
        $tipo_curso = TipoCurso::get();
        return view('curso.edit', compact('curso', 'tipo_curso'));
    }

    public function update(Curso $curso, Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'tipo_curso_id' => 'required',
        ]);

        $curso->update([
            'descripcion' => $request->descripcion,
            'tipo_curso_id' => $request->tipo_curso_id,
            'estado_id' => $request->estado_id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('curso.index')->with('message', 'Curso editado con exito.');
    }
}
