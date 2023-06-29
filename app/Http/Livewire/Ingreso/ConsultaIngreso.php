<?php

namespace App\Http\Livewire\Ingreso;

use App\Models\CuentaVario;
use App\Models\IngresoConcepto;
use App\Models\IngresoVarios;
use App\Models\Persona;
use Carbon\Carbon;
use IntlChar;
use Livewire\Component;
use Livewire\WithPagination;

class ConsultaIngreso extends Component
{
    public $fecha_actual, $caso, $ver_recibo, $ver_documento, $ver_fecha, $documento, $recibo, $ingreso;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['render', 'filtro', 'ver_recibo', 'anular'];

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

        return view('livewire.ingreso.consulta-ingreso', compact('data', 'ingreso_concepto'));
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

    public function datos_fecha()
    {
        $data = IngresoVarios::where('estado_id', 1)
        ->where('fecha_ingreso', $this->fecha_actual)
        ->get();

        return $data;
    }

    public function datos_recibo()
    {
        $data = IngresoVarios::where('numero_recibo', $this->recibo)
        ->where('estado_id', 1)
        ->get();

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
        ->where('estado_id', 1)
        ->get();

        return $data;
    }

    public function ver_recibo($ingreso_id)
    {
        $this->ingreso = IngresoVarios::find($ingreso_id);
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

        $this->resetUI();
        $this->render();
    }

    public function resetUI()
    {
        $this->reset('ingreso');
    }
}
