<?php

namespace App\Http\Livewire\Ingreso;

use App\Models\CuentaVario;
use App\Models\CuentaVarioDetalle;
use App\Models\FormaPago;
use App\Models\IngresoVarios;
use App\Models\IngresoVariosDetalle;
use App\Models\Persona;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class IngresoPendiente extends Component
{
    public $persona, $forma_pago_id, $comprobante, $monto_pagar, $total_pagar_modal, $cuenta, $ingreso, $titulo, $valor_id = 0;

    use WithFileUploads;

    protected $listeners = ['detalle', 'render'];

    protected $rules = [
        'total_pagar_modal' => 'required',
        'comprobante' => 'image|mimes:jpeg,png,jpg,gif'
    ];

    public function mount(Persona $persona)
    {
        $this->persona = $persona;
        $this->titulo = 'Cobro Pendiente';
    }

    public function render()
    {
        $pendiente = CuentaVario::where('persona_id', $this->persona->id)
        ->where('estado_id', 1)
        ->orderBy('id', 'DESC')
        ->get();

        $forma_pago = FormaPago::all();
        $this->forma_pago_id = 1;

        return view('livewire.ingreso.ingreso-pendiente', compact('pendiente', 'forma_pago'));
    }

    public function detalle($ingreso)
    {
        $this->cuenta = CuentaVario::find($ingreso);
        $this->monto_pagar = number_format($this->cuenta->detalle->sum('saldo'), 0, ".", ".");
        $this->total_pagar_modal = $this->monto_pagar;
        $this->emit('abrir_modal', 'dale');
    }

    public function save()
    {
        if($this->comprobante){
            $filePath = $this->comprobante->store('public/comprobante');
            $this->validate();
        }else{
            $filePath = '';
            $this->validate([
                'total_pagar_modal' => 'required',
            ]);
        }

        $total_pagar = str_replace('.', '', $this->total_pagar_modal);

        if($total_pagar == 0){
            $this->emit('mensaje_error', 'El total a pagar no pueder ser 0.');
            $this->resetUI();

            return false;
        }

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoVarios::where('año', $anio)
        ->max('numero_recibo');

        if($this->comprobante){
            $filePath = $this->comprobante->store('public/comprobante');
        }else{
            $filePath = '';
        }

        $numero_recibo += 1;
        $monto_a_pagar = str_replace('.', '', $this->total_pagar_modal);

        $ingreso = IngresoVarios::create([
            'persona_id' => $this->persona->id,
            'forma_pago_id' => $this->forma_pago_id,
            'fecha_ingreso' => $fecha_actual,
            'mes' => $mes,
            'año' => $anio,
            'numero_recibo' => $numero_recibo,
            'sucursal' => '000',
            'general' => '000',
            'factura_numero' => '0000000',
            'total_pagado' => $monto_a_pagar,
            'comprobante' => '',
            'cuenta_padre' => $this->cuenta->ingreso_vario_id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $aux_monto = $monto_a_pagar;
        $grabar = 1;
        foreach ($this->cuenta->detalle_pago as $item) {
            $saldo = 0;
            $total_pagar = $item->saldo;
            if($aux_monto >= $total_pagar){
                $pagar = $total_pagar;
                $aux_monto = $aux_monto - $total_pagar;
                $saldo = 0;
            }else{
                if($aux_monto < $total_pagar){
                    $pagar = $aux_monto;
                    $saldo = $total_pagar - $aux_monto;
                    $aux_monto = 0;
                }else{
                    if($aux_monto == 0){
                        $pagar = 0;
                        $saldo = $total_pagar;
                        $aux_monto = 0;
                    }
                }
            }

            if($grabar == 1){
                $ingreso_detalle = IngresoVariosDetalle::create([
                    'persona_id' => $this->persona->id,
                    'ingreso_vario_id' => $ingreso->id,
                    'ingreso_concepto_id' => $item->ingreso_concepto_id,
                    'descripcion' => '',
                    'precio_unitario' => $item->precio_unitario,
                    'cantidad' => $item->cantidad,
                    'total_pagar' => $total_pagar,
                    'monto_pagado' => $pagar,
                    'saldo' => $saldo,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);

                $item->monto_pagado = $item->monto_pagado + $pagar;
                $item->saldo = $saldo;
                $item->modif_user_id = auth()->user()->id;
                $item->update();
            }

            if($aux_monto == 0){
                $grabar = 0;
            }
        }
        $cuenta = $this->cuenta;
        $completo = CuentaVarioDetalle::where('cuenta_vario_id', $cuenta->id)->sum('saldo');
        $cuenta->total_pagado = $cuenta->total_pagado + $monto_a_pagar;
        $cuenta->modif_user_id = auth()->user()->id;
        if($completo == 0){
            $cuenta->estado_id = 2;
        }
        $cuenta->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $this->ingreso->id;
        $this->emit('ver_recibo', 'recibo');
        $this->render();
    }

    public function confirmar()
    {

    }

    public function resetUI()
    {
        $this->reset('total_pagar_modal');
        $this->reset('monto_pagar');
        $this->reset('comprobante');
        $this->reset('cuenta');
        $this->reset('ingreso');
        $this->forma_pago_id = 1;
        $this->emit('reloadClassCSs');

    }
}
