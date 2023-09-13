<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnulacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:anulacion.cursos')->only('cursos');
        $this->middleware('permission:anulacion.ingreso_varios')->only('ingresos_varios');
        $this->middleware('permission:anulacion.anticipo')->only('anticipo');
        $this->middleware('permission:anulacion.otros_pago')->only('otros_pago');
    }

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

    public function otros_pagos()
    {
        return view('anulacion.otros_pagos');
    }
}
