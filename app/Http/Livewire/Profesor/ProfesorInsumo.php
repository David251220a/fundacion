<?php

namespace App\Http\Livewire\Profesor;

use App\Models\CursoHabilitado;
use Carbon\Carbon;
use Livewire\Component;

class ProfesorInsumo extends Component
{

    public $cursoHabilitado, $curso_id, $fecha;

    public function mount(CursoHabilitado $cursoHabilitado)
    {
        $this->cursoHabilitado = $cursoHabilitado;
        $this->curso_id = $cursoHabilitado->id;

        $fecha_actual = Carbon::now();
        $this->fecha = (date('Y-m-d', strtotime($fecha_actual)));
    }

    public function render()
    {
        $alumnos = $this->cursoHabilitado->alumnos_cursando;
        $this->cursoHabilitado = CursoHabilitado::find($this->curso_id);
        return view('livewire.profesor.profesor-insumo', compact('alumnos'));
    }
}
