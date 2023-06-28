<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\CursoModulo;
use App\Models\TipoCurso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:curso.index')->only('index');
        $this->middleware('permission:curso.create')->only('create');
        $this->middleware('permission:curso.store')->only('store');
        $this->middleware('permission:curso.show')->only('show');
        $this->middleware('permission:curso.edit')->only('edit');
        $this->middleware('permission:curso.update')->only('update');
    }

    public function index()
    {
        $data = Curso::orderBy('id', 'DESC')
        ->get();

        return view('curso.index', compact('data'));
    }

    public function create()
    {
        $tipo_curso = TipoCurso::where('estado_id', 1)->get();
        $modulo = CursoModulo::all();
        return view('curso.create', compact('tipo_curso', 'modulo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'tipo_curso_id' => 'required',
            'curso_modulo_id' => 'required',
        ]);

        Curso::create([
            'descripcion' => $request->descripcion,
            'tipo_curso_id' => $request->tipo_curso_id,
            'curso_modulo_id' => $request->curso_modulo_id,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('curso.index')->with('message', 'Curso creado con exito.');
    }

    public function edit(Curso $curso)
    {
        $tipo_curso = TipoCurso::get();
        $modulo = CursoModulo::all();
        return view('curso.edit', compact('curso', 'tipo_curso', 'modulo'));
    }

    public function update(Curso $curso, Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'tipo_curso_id' => 'required',
            'curso_modulo_id' => 'required',
        ]);

        $curso->update([
            'descripcion' => $request->descripcion,
            'tipo_curso_id' => $request->tipo_curso_id,
            'curso_modulo_id' => $request->curso_modulo_id,
            'estado_id' => $request->estado_id,
            'modif_user_id' => auth()->user()->id,
        ]);

        return redirect()->route('curso.index')->with('message', 'Curso editado con exito.');
    }
}
