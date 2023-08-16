<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoEmpleadoController extends Controller
{
    public function index()
    {
        return view('pago.empleado.index');
    }

}
