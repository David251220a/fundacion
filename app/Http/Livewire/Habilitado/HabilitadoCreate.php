<?php

namespace App\Http\Livewire\Habilitado;

use App\Models\Curso;
use App\Models\Instructor;
use App\Models\TipoCurso;
use Livewire\Component;

class HabilitadoCreate extends Component
{
    public $tipo_curso_id, $curso_id ;


    public function render()
    {
        $tipo_curso = TipoCurso::where('estado_id', 1)
        ->get();

        $curso = Curso::where('tipo_curso_id', $tipo_curso[0]->id)
        ->where('estado_id', 1)
        ->get();

        $instructor = Instructor::where('estado_id', 1)->get();
        return view('livewire.habilitado.habilitado-create', compact('tipo_curso', 'curso', 'instructor'));
    }
}
