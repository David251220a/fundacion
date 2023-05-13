<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function inicio()
    {
        return view('welcome');
    }

    public function nosotros()
    {
        return view('www.nosotros');
    }

    public function cursos()
    {
        return view('www.cursos');
    }

    public function contacto()
    {
        return view('www.contacto');
    }
}
