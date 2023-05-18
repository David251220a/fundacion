<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
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

    public function new()
    {
        $data = Noticia::where('publicado', 1)
        ->where('estado_id', 1)
        ->latest()
        ->take(1000)
        ->paginate(1);

        return view('www.noticia', compact('data'));
    }

    public function new_detalle($slug)
    {
        $data = Noticia::where('slug', $slug)->first();
        return view('www.new_detalle', compact('data'));
    }

}
