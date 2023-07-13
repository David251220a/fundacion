<?php

namespace App\Http\Livewire\Profesor;

use App\Models\CursoAEstado;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use App\Models\Persona;
use Livewire\Component;

class ProfesorShow extends Component
{
    public $curso_id, $curso_precio;
    public $documento, $estado_curso = 99;

    public function mount(CursoHabilitado $cursoHabilitado)
    {
        $this->curso_id = $cursoHabilitado->id;
        $this->curso_precio = number_format($cursoHabilitado->precio, 0, ".", ".");
    }

    public function render()
    {
        $documento = null;
        $alumno_id = 0;
        if(!(empty($this->documento))){
            $documento = str_replace('.', '', $this->documento);
            $persona = Persona::where('documento', $documento)->first();
            if(!(empty($persona))){
                if(!(empty($persona->alumno))){
                    $alumno_id = $persona->alumno->id;
                }
            }

        }

        if ($this->estado_curso == 99){
            if(!(empty($this->documento))){
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->where('alumno_id', $alumno_id)
                ->get();
            }else{
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->get();
            }

        }else{
            if(!(empty($this->documento))){
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->where('alumno_id', $alumno_id)
                ->where('curso_a_estado_id', $this->estado_curso)
                ->get();
            }else{
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->where('curso_a_estado_id', $this->estado_curso)
                ->get();
            }

        }

        $total_saldo = $alumnos->sum('saldo');
        $estado = CursoAEstado::all();
        return view('livewire.profesor.profesor-show', compact('estado', 'alumnos', 'total_saldo'));
    }
}
