<?php

namespace App\Http\Livewire\IngresoMatricula;

use App\Models\Curso;
use App\Models\IngresoMatricula;
use App\Models\TipoCurso;
use Carbon\Carbon;
use Livewire\Component;

class IngresoIndex extends Component
{
    public $fecha_actual, $curso_id, $tipo_curso_id, $documento, $caso;

    public function mount()
    {
        $fecha_actual = Carbon::now();
        $this->fecha_actual = date('Y-m-d', strtotime($fecha_actual));
        $this->caso = 1;
    }

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

        if($this->caso == 1){
            $data = $this->datos_fecha();
        }

        $this->curso_id = $curso[0]->id;

        return view('livewire.ingreso-matricula.ingreso-index', compact('tipo_curso', 'curso', 'data'));
    }


    public function datos_fecha()
    {
        $fecha = date('Y-m-d', strtotime($this->fecha_actual));
        $data = IngresoMatricula::where('fecha_ingreso', $fecha)
        ->where('estado_id', 1)
        ->orderBy('fecha_ingreso', 'DESC')
        ->paginate(50);

        return $data;
    }

    public function por_fecha($id)
    {
        $this->caso = $id;
    }
}
