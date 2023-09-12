<?php

namespace App\Http\Livewire\Anulacion;

use App\Models\Alumno;
use App\Models\CuentaVario;
use App\Models\CursoInAlumno;
use App\Models\IngresoVarios;
use Carbon\Carbon;
use Livewire\Component;

class AnulacionIngreso extends Component
{
    public $ver_detalle = 0, $año, $numero_recibo, $data = [];

    protected $listeners = ['anular'];

    public function mount()
    {
        $fecha_actual = Carbon::now();
        $this->año = date('Y', strtotime($fecha_actual));
    }

    public function render()
    {
        return view('livewire.anulacion.anulacion-ingreso');
    }

    public function buscar()
    {
        if (empty($this->año)){
            return false;
        }

        if (empty($this->numero_recibo)){
            return false;
        }

        $año = str_replace('.', '', $this->año);
        $numero = str_replace('.', '', $this->numero_recibo);

        $this->data = IngresoVarios::where('año', $año)
        ->where('numero_recibo', $numero)
        ->first();

        $this->ver_detalle = 1;
    }

    public function anular()
    {
        $es_hijo = 0;
        $ingreso = IngresoVarios::find($this->data->id);

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

        $this->emit('correcto', 'Se ha anulado con exito.');
        $this->resetUI();

    }

    public function resetUI()
    {
        $this->reset('data');
        $this->reset('numero_recibo');
        $this->ver_detalle = 0;
        $fecha_actual = Carbon::now();
        $this->año = date('Y', strtotime($fecha_actual));

    }
}
