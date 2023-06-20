<?php

namespace App\Http\Livewire\Habilitado;

use App\Models\CursoAEstado;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use Livewire\Component;

class ListadoCurso extends Component
{

    public $curso_id, $estado_curso = 99;

    public function mount(CursoHabilitado $cursoHabilitado)
    {
        $this->curso_id = $cursoHabilitado->id;
    }

    public function render()
    {
        if ($this->estado_curso == 99){
            $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
            ->get();
        }else{
            $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
            ->where('curso_a_estado_id', $this->estado_curso)
            ->get();
        }

        $estado = CursoAEstado::all();

        return view('livewire.habilitado.listado-curso', compact('alumnos', 'estado'));
    }
}
