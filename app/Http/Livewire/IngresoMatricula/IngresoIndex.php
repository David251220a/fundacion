<?php

namespace App\Http\Livewire\IngresoMatricula;

use App\Models\Curso;
use App\Models\CursoAlumno;
use App\Models\IngresoMatricula;
use App\Models\Persona;
use App\Models\TipoCurso;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class IngresoIndex extends Component
{
    public $fecha_actual, $curso_id, $tipo_curso_id, $documento, $caso, $recibo, $ingreso;
    public $ver_recibo, $ver_documento, $ver_fecha;

    protected $listeners = ['render', 'filtro', 'ver_recibo', 'anular'];
    protected $paginationTheme = 'bootstrap';

    use WithPagination;

    public function updatingSearch(){
        $this->resetPage();
    }

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
        ->where('estado_id', 1)
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
        ->where('estado_id', 1)
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

    public function ver_recibo($ingreso_id)
    {
        $this->ingreso = IngresoMatricula::find($ingreso_id);
    }

    public function anular($ingreso_id)
    {
        $ingreso = IngresoMatricula::find($ingreso_id);
        $ingreso->estado_id = 2;
        $ingreso->modif_user_id = auth()->user()->id;
        $ingreso->update();

        foreach ($ingreso->detalle as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();

            $cursoAlumno = CursoAlumno::where('alumno_id', $item->alumno_id)
            ->where('curso_habilitado_id', $item->curso_habilitado_id)
            ->where('estado_id', 1)
            ->first();

            if($ingreso->tipo_cobro == 1){
                $cursoAlumno->monto_abonado = $cursoAlumno->monto_abonado - $item->monto_pagado;
                $cursoAlumno->saldo = $cursoAlumno->saldo + $item->monto_pagado;
                $cursoAlumno->estado_id = 1;
                $cursoAlumno->modif_user_id = auth()->user()->id;
                $cursoAlumno->update();
            }else{
                $cursoAlumno->certificado_pagado = $cursoAlumno->certificado_pagado - $item->monto_pagado;
                $cursoAlumno->certificado_saldo = $cursoAlumno->certificado_saldo + $item->monto_pagado;
                $cursoAlumno->estado_id = 1;
                $cursoAlumno->modif_user_id = auth()->user()->id;
                $cursoAlumno->update();
            }


            $this->resetUI();
            $this->render();
        }
    }

    public function resetUI()
    {
        $this->reset('ingreso');
    }


}
