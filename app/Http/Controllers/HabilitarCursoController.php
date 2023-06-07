<?php

namespace App\Http\Controllers;

use App\Models\CursoHabilitado;
use Illuminate\Http\Request;

class HabilitarCursoController extends Controller
{
    public function index()
    {
        $data = CursoHabilitado::take(1000)
        ->orderBy('created_at', 'DESC')
        ->paginate(50);
        return view('habilitar.index', compact('data'));
    }

    public function create()
    {
        return view('habilitar.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit(CursoHabilitado $cursoHabilitado)
    {

    }
}
