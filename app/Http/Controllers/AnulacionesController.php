<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnulacionesController extends Controller
{
    public function cursos()
    {
        return view('anulacion.cursos');
    }

    public function ingresos_varios()
    {
        return view('anulacion.ingreso_varios');
    }

    public function anticipo()
    {
        return view('anulacion.anticipo');
    }
}
