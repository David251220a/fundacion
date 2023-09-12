<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultaGeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:consulta.curso_deuda')->only('curso_deuda');
        $this->middleware('permission:consulta.pago')->only('pago');
    }

    public function curso_deuda(Request $request)
    {

        return view('consulta.curso_deuda');

    }

    public function pago()
    {
        return view('consulta.pago');
    }
}
