<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultaGeneralController extends Controller
{
    public function curso_deuda(Request $request)
    {

        return view('consulta.curso_deuda');

    }
}
