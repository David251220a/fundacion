<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngresoMatriculaController extends Controller
{
    public function index()
    {

        return view('ingreso_curso.index');
    }
}
