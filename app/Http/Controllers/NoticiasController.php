<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Tag;
use Illuminate\Http\Request;

class NoticiasController extends Controller
{
    public function index()
    {
        $noticias = Noticia::where('estado_id', 1)
        ->take(1000)
        ->latest()
        ->get();

        return view('noticias.index', compact('noticias'));
    }

    public function create()
    {
        $tags = Tag::where('estado_id', 1)->get();
        return view('noticias.create', compact('tags'));
    }
}
