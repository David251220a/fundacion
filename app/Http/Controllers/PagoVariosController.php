<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoVariosController extends Controller
{
    public function index()
    {
        return view('pago.varios');
    }
}
