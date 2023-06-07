<?php

namespace App\Http\Controllers;

use App\Models\TipoCurso;
use Illuminate\Http\Request;

class TipoCursoController extends Controller
{
    public function index()
    {
        return view('tipo_curso.index');
    }
}
