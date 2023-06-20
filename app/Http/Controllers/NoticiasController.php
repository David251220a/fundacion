<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\NoticiaFile;
use App\Models\NoticiaTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'slug' => 'required',
            'contenido' => 'required',
            'tags' => 'required',
        ]);
        $fecha = date('dmY');
        $fecha_actual = date('Y-m-d');
        $cont = Noticia::where(DB::raw('CAST(created_at AS DATE)'), $fecha_actual)->count();
        $slug = $request->slug . '-' . $fecha . '-' . $cont;

        $noticias = Noticia::create([
            'titulo' => $request->titulo,
            'slug' => $slug,
            'contenido' => $request->contenido,
            'feed_facebook' => $request->facebook,
            'feed_instagram' => $request->instagram,
            'portada' => $request->portada,
            'publicado' => $request->publicado,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $filePath = '';
        if($request->file_1)
        {
            $filePath = $request->file('file_1')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticias->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $filePath = '';
        if($request->file_2)
        {
            $filePath = $request->file('file_2')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticias->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $filePath = '';
        if($request->file_3)
        {
            $filePath = $request->file('file_3')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticias->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $filePath = '';
        if($request->file_4)
        {
            $filePath = $request->file('file_4')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticias->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $filePath = '';
        if($request->file_5)
        {
            $filePath = $request->file_5;
            NoticiaFile::create([
                'noticia_id' => $noticias->id,
                'file' => $filePath,
                'tipo' => 2,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        foreach($noticias->tag as $item)
        {
            $item->estado_id = 2;
            $item->update();
        }

        $tags = $request->tags;
        for ($i=0; $i < count($tags) ; $i++) {
            NoticiaTag::updateOrCreate
            ([
                'noticia_id' => $noticias->id,
                'tag_id' => $tags[$i],
            ]
            , [
                'noticia_id' => $noticias->id,
                'tag_id' => $tags[$i],
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        return redirect()->route('noticias.index')->with('message', 'Se ha creado con exito la noticia!.');
    }

    public function show($slug)
    {
        $data = Noticia::where('slug', $slug)->first();
        return view('noticias.show', compact('data'));
    }

    public function edit($noticia)
    {
        $data = Noticia::find($noticia);
        $tags = Tag::where('estado_id', 1)->get();
        return view('noticias.edit', compact('data', 'tags'));
    }

    public function update(Noticia $noticia, Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'slug' => 'required',
            'contenido' => 'required',
            'tags' => 'required',
        ]);

        $fecha = date('dmY');
        $fecha_actual = date('Y-m-d');
        $cont = Noticia::where(DB::raw('CAST(created_at AS DATE)'), $fecha_actual)->count();
        $slug = $request->slug;
        // dd($request->all(), $fecha_actual);
        $noticia->update([
            'titulo' => $request->titulo,
            'slug' => $slug,
            'contenido' => $request->contenido,
            'feed_facebook' => $request->facebook,
            'feed_instagram' => $request->instagram,
            'portada' => $request->portada,
            'publicado' => $request->publicado,
            'modif_user_id' => auth()->user()->id,
        ]);

        $filePath = '';
        if($request->file_1)
        {
            $filePath = $request->file('file_1')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticia->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $filePath = '';
        if($request->file_2)
        {
            $filePath = $request->file('file_2')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticia->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $filePath = '';
        if($request->file_3)
        {
            $filePath = $request->file('file_3')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticia->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $filePath = '';
        if($request->file_4)
        {
            $filePath = $request->file('file_4')->store('public/noticias');
            NoticiaFile::create([
                'noticia_id' => $noticia->id,
                'file' => $filePath,
                'tipo' => 1,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $file_video = 0;
        if(count($noticia->file_video) > 0){
            $file_video = $noticia->file_video[0]->id;
        }

        $estado_id = 1;
        $des = $request->file_5;
        if(empty($request->file_5)){
            $estado_id = 2;
            $des = ' ';
        }

        NoticiaFile::updateOrCreate
        ([
            'noticia_id' => $noticia->id,
            'tipo' => 2,
        ]
        , [
            'file' => $des = ' ',
            'estado_id' => $estado_id,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $tags = $request->tags;
        for ($i=0; $i < count($tags) ; $i++) {
            NoticiaTag::updateOrCreate
            ([
                'noticia_id' => $noticia->id,
                'tag_id' => $tags[$i],
            ]
            , [
                'tag_id' => $tags[$i],
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        if($request->fotos){
            $fotos_elimadas = $request->fotos;
            for ($i=0; $i < count($fotos_elimadas) ; $i++) {
                $file_fotos = NoticiaFile::find($fotos_elimadas[$i]);
                $file_fotos->estado_id = 2;
                $file_fotos->update();
            }
        }


        return redirect()->route('noticias.index')->with('message', 'Se edito con exito la noticia!.');
    }
}

