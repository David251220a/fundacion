<?php

namespace App\Http\Controllers;

use App\Models\TipoCurso;
use Illuminate\Http\Request;

class TipoCursoController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:tipocurso.index')->only('index');
        $this->middleware('permission:tipocurso.create')->only('create');
        $this->middleware('permission:tipocurso.store')->only('store');
        $this->middleware('permission:tipocurso.show')->only('show');
        $this->middleware('permission:tipocurso.edit')->only('edit');
        $this->middleware('permission:tipocurso.update')->only('update');
    }

    public function index()
    {
        return view('tipo_curso.index');
    }
}
