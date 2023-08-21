<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoVariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pago_varios.index')->only('index');
    }

    public function index()
    {
        return view('pago.varios');
    }
}
