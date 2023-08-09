<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoInstructorController extends Controller
{
    public function index()
    {
        return view('pago.instructor.index');
    }
}
