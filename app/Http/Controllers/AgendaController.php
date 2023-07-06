<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Curso;
use App\Models\TipoCurso;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {

        $familia = TipoCurso::where('estado_id', 1)->orderBy('descripcion', 'ASC')->get();

        return view('agenda.index', compact('familia'));
    }

    public function show(TipoCurso $tipoCurso)
    {
        $cursos = Curso::where('tipo_curso_id', $tipoCurso->id)->orderBy('descripcion', 'ASC')
        ->orderBy('curso_modulo_id', 'ASC')
        ->where('estado_id', 1)
        ->get();
        return view('agenda.show', compact('cursos', 'tipoCurso'));
    }

    public function agenda(Curso $curso)
    {
        return view('agenda.agenda', compact('curso'));
    }
}
