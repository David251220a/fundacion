<?php

namespace App\Http\Livewire\IngresoMatricula;

use App\Models\Curso;
use App\Models\IngresoMatricula;
use App\Models\Persona;
use App\Models\TipoCurso;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Person;
use Livewire\Component;

class IngresoIndex extends Component
{
    public $fecha_actual, $curso_id, $tipo_curso_id, $documento, $caso, $recibo;
    public $ver_recibo, $ver_documento, $ver_fecha;

    protected $listeners = ['render', 'filtro'];

    public function mount()
    {
        $fecha_actual = Carbon::now();
        $this->fecha_actual = date('Y-m-d', strtotime($fecha_actual));
        $this->caso = 1;
        $this->ver_recibo = 'none';
        $this->ver_documento = 'none';
        $this->ver_fecha = 'block';
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

        if($this->caso == 2){
            $data = $this->datos_recibo();
        }

        if($this->caso == 3){
            $data = $this->datos_documentos();
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

    public function datos_recibo()
    {
        $data = IngresoMatricula::where('numero_recibo', $this->recibo)
        ->paginate(50);

        return $data;
    }

    public function datos_documentos()
    {
        $documento = str_replace('.', '', $this->documento);
        $persona = Persona::where('documento', $documento)->first();
        if(!(empty($persona))){
            $alumno_id = $persona->alumno->id;
        }else{
            $alumno_id = null;
        }

        $data = IngresoMatricula::where('alumno_id', $alumno_id)
        ->paginate(50);

        return $data;
    }

    public function filtro($id)
    {
        $this->caso = $id;

        if($id == 1){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'none';
        }

        if($id == 2){
            $this->ver_fecha = 'none';
            $this->ver_recibo = 'block';
            $this->ver_documento = 'none';
        }

        if($id == 3){
            $this->ver_fecha = 'none';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'block';
        }
    }
}
