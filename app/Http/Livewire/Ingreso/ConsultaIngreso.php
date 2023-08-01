<?php

namespace App\Http\Livewire\Ingreso;

use App\Models\Alumno;
use App\Models\CuentaVario;
use App\Models\Curso;
use App\Models\CursoInAlumno;
use App\Models\CursoIngreso;
use App\Models\IngresoConcepto;
use App\Models\IngresoVarios;
use App\Models\Persona;
use App\Models\TipoCurso;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Psy\CodeCleaner\AssignThisVariablePass;

class ConsultaIngreso extends Component
{
    public $fecha_actual, $fecha_hasta, $caso, $ver_recibo, $ver_documento, $ver_fecha, $documento, $recibo, $ingreso;
    public $aux_familia, $ver_familia, $aux_familia_id, $ver_curso, $aux_curso_id, $aux_curso, $totales= 0, $valor_id = 0;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['render', 'filtro', 'ver_recibo', 'anular', 'actualizar_curso'];

    public function mount()
    {
        $fecha_actual = Carbon::now();
        $this->fecha_actual = date('Y-m-d', strtotime($fecha_actual));
        $this->fecha_hasta = date('Y-m-d', strtotime($fecha_actual));
        $this->caso = 1;
        $this->ver_recibo = 'none';
        $this->ver_documento = 'none';
        $this->ver_familia = 'none';
        $this->ver_curso = 'none';
        $this->ver_fecha = 'block';
        $this->cargar_familia();
        $this->cargar_curso();
    }

    public function render()
    {
        $ingreso_concepto =IngresoConcepto::orderBy('descripcion', 'ASC')->get();

        if($this->caso == 1){
            $data = $this->datos_fecha();
        }

        if($this->caso == 2){
            $data = $this->datos_recibo();
        }

        if($this->caso == 3){
            $data = $this->datos_documentos();
        }

        if($this->caso == 4){
            $data = $this->datos_familia();
        }

        if($this->caso == 5){
            $data = $this->datos_curso();
        }

        return view('livewire.ingreso.consulta-ingreso', compact('data', 'ingreso_concepto'));
    }

    public function filtro($id)
    {
        $this->caso = $id;

        if($id == 1){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'none';
            $this->ver_familia = 'none';
            $this->ver_curso = 'none';
        }

        if($id == 2){
            $this->ver_fecha = 'none';
            $this->ver_recibo = 'block';
            $this->ver_documento = 'none';
            $this->ver_familia = 'none';
            $this->ver_curso = 'none';
        }

        if($id == 3){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'block';
            $this->ver_familia = 'none';
            $this->ver_curso = 'none';
        }

        if($id == 4){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'none';
            $this->ver_curso = 'none';
            $this->ver_familia = 'block';
        }

        if($id == 5){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'none';
            $this->ver_familia = 'block';
            $this->ver_curso = 'block';
        }
    }


    public function cargar_familia()
    {
        $this->aux_familia = TipoCurso::all();
        $this->aux_familia_id = $this->aux_familia[0]->id;
    }

    public function cargar_curso()
    {
        $this->aux_curso = Curso::where('tipo_curso_id', $this->aux_familia_id)
        ->get();
        $this->aux_curso_id = $this->aux_curso[0]->id;
    }

    public function datos_fecha()
    {
        $data = IngresoVarios::where('estado_id', 1)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->orderBy('id', 'DESC')
        ->paginate(50);

        $this->totales = IngresoVarios::where('estado_id', 1)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->sum('total_pagado');

        return $data;
    }

    public function datos_recibo()
    {
        $data = IngresoVarios::where('numero_recibo', $this->recibo)
        ->where('estado_id', 1)
        ->orderBy('id', 'DESC')
        ->paginate(50);
        // ->get();

        $this->totales = IngresoVarios::where('numero_recibo', $this->recibo)
        ->where('estado_id', 1)
        ->sum('total_pagado');

        return $data;
    }

    public function datos_documentos()
    {
        $documento = str_replace('.', '', $this->documento);
        $persona = Persona::where('documento', $documento)->first();

        if(empty($persona)){
            $persona_id = null;
        }else{
            $persona_id = $persona->id;
        }
        $data = IngresoVarios::where('persona_id', $persona_id)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->where('estado_id', 1)
        ->orderBy('id', 'DESC')
        ->paginate(50);
        // ->get();

        $this->totales = IngresoVarios::where('persona_id', $persona_id)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->where('estado_id', 1)
        ->sum('total_pagado');

        return $data;
    }

    public function datos_familia ()
    {
        $data = IngresoVarios::where('estado_id', 1)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->where('tipo_curso_id', $this->aux_familia_id)
        ->orderBy('id', 'DESC')
        ->paginate(50);
        // ->get();

        $this->totales = IngresoVarios::where('estado_id', 1)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->where('tipo_curso_id', $this->aux_familia_id)
        ->sum('total_pagado');


        return $data;
    }

    public function datos_curso()
    {
        $data = IngresoVarios::where('estado_id', 1)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->where('curso_id', $this->aux_curso_id)
        ->orderBy('id', 'DESC')
        ->paginate(50);
        // ->get();

        $this->totales = IngresoVarios::where('estado_id', 1)
        ->whereBetween('fecha_ingreso', [$this->fecha_actual, $this->fecha_hasta])
        ->where('curso_id', $this->aux_curso_id)
        ->sum('total_pagado');

        return $data;
    }

    public function ver_recibo($ingreso_id)
    {
        $this->ingreso = IngresoVarios::find($ingreso_id);
        $this->valor_id = $this->ingreso->id;
    }

    public function anular($ingreso_id)
    {
        $es_hijo = 0;
        $ingreso = IngresoVarios::find($ingreso_id);

        $es_hijo = $ingreso->cuenta_padre;

        $ingreso->estado_id = 2;
        $ingreso->modif_user_id = auth()->user()->id;
        $ingreso->update();

        foreach ($ingreso->detalle as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        if($ingreso->curso_ingreso_id == 0){

            if($es_hijo > 0){
                $cuenta = CuentaVario::where('ingreso_vario_id', $ingreso->cuenta_padre)
                ->first();

                $cuenta->total_pagado = $cuenta->total_pagado - $ingreso->total_pagado;
                $cuenta->estado_id = 1;
                $cuenta->modif_user_id = auth()->user()->id;
                $cuenta->update();

                $continuar = 0;
                $aux_total_pagado = $ingreso->total_pagado;
                foreach ($cuenta->detalle as $item) {
                    if($item->saldo != $item->total_pagar){
                        if($aux_total_pagado > $item->monto_pagado){
                            $monto_pagado = 0;
                            $saldo = $item->total_pagar;
                            $aux_total_pagado = $aux_total_pagado - $item->monto_pagado;
                        }elseif($aux_total_pagado < $item->monto_pagado){
                            $monto_pagado = $item->monto_pagado - $aux_total_pagado;
                            $saldo = $item->saldo + $aux_total_pagado;
                            $aux_total_pagado = 0;
                        }elseif($aux_total_pagado == 0){
                            $continuar = 1;
                        }
                        if($continuar == 0){
                            $item->monto_pagado = $monto_pagado;
                            $item->saldo = $saldo;
                            $item->estado_id = 1;
                            $item->modif_user_id = auth()->user()->id;
                            $item->update();
                        }

                        if ($aux_total_pagado == 0){
                            $continuar = 1;
                        }
                    }
                }



            }

            $encontrar = CuentaVario::where('ingreso_vario_id', $ingreso->id)->first();
            if(!(empty($encontrar))){
                if($es_hijo == 1){
                    $encontrar->estado_id = 1;
                }else{
                    $encontrar->estado_id = 2;
                }

                $encontrar->total_pagado = 0;
                $encontrar->modif_user_id = auth()->user()->id;
                $encontrar->update();

                foreach($encontrar->detalle as $item){
                    $item->estado_id = 2;
                    $item->modif_user_id = auth()->user()->id;
                    $item->update();
                }
            }

        }else{

            $alumno = Alumno::where('persona_id', $ingreso->persona_id)
            ->first();

            $cursoIngreso = CursoInAlumno::where('curso_ingreso_id', $ingreso->curso_ingreso_id)
            ->where('alumno_id', $alumno->id)
            ->where('estado_id', 1)
            ->first();

            $cursoIngreso->total_pagado = $cursoIngreso->total_pagado - $ingreso->total_pagado;
            $cursoIngreso->saldo = $cursoIngreso->saldo + $ingreso->total_pagado;
            $cursoIngreso->update();

        }

        $this->resetUI();
        $this->render();
    }


    public function actualizar_curso()
    {
        $this->cargar_curso();
    }

    public function resetUI()
    {
        $this->reset('ingreso');
        $this->valor_id = 0;
    }
}
