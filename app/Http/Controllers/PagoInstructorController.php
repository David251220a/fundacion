<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoInstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pago_instructor.index')->only('index');
    }

    public function index()
    {
        return view('pago.instructor.index');
    }
}
