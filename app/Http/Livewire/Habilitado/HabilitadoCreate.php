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
        $id = 0;
        if(empty($this->tipo_curso_id)){
            $id = $tipo_curso[0]->id;
        }else{
            $id = $this->tipo_curso_id;
        }

        $curso = Curso::where('tipo_curso_id', $id)
        ->where('estado_id', 1)
        ->get();

        // $this->curso_id = $curso[0]->id;

        $instructor = Instructor::where('estado_id', 1)->get();

        return view('livewire.habilitado.habilitado-create', compact('tipo_curso', 'curso', 'instructor'));
    }
}
