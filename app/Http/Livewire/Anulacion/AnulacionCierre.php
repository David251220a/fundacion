<?php

namespace App\Http\Livewire\Anulacion;

use App\Models\CierreCaja;
use App\Models\IngresoMatricula;
use App\Models\IngresoVarios;
use App\Models\Pago;
use Carbon\Carbon;
use Livewire\Component;

class AnulacionCierre extends Component
{
    public $ver_detalle = 0, $año, $cierre_id, $data = [];

    protected $listeners = ['anular'];

    public function mount()
    {
        $fecha_actual = Carbon::now();
        $this->año = date('Y', strtotime($fecha_actual));
    }

    public function render()
    {
        return view('livewire.anulacion.anulacion-cierre');
    }

    public function buscar()
    {
        $cierre = str_replace('.', '', $this->cierre_id);
        $this->data = CierreCaja::find($cierre);
        $this->ver_detalle = 1;
    }

    public function anular()
    {
        $cierre_id = str_replace('.', '', $this->cierre_id);
        $cierre = CierreCaja::find($cierre_id);

        $cierre->estado_id = 2;
        $cierre->modif_user_id = auth()->user()->id;
        $cierre->update();

        foreach ($cierre->ingresos as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        foreach ($cierre->egresos as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $ingresos = IngresoMatricula::where('estado_id', 1)
        ->where('procesado', 1)
        ->where('cierre_caja_id', $cierre_id)
        ->get();

        foreach ($ingresos as $item) {
            $item->cierre_caja_id = 0;
            $item->procesado = 0;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $ingresos_varios = IngresoVarios::where('estado_id', 1)
        ->where('procesado', 1)
        ->where('cierre_caja_id', $cierre_id)
        ->get();

        foreach ($ingresos_varios as $item) {
            $item->cierre_caja_id = 0;
            $item->procesado = 0;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $pago = Pago::where('estado_id', 1)
        ->where('procesado', 1)
        ->where('cierre_caja_id', $cierre_id)
        ->get();

        foreach ($pago as $item) {
            $item->cierre_caja_id = 0;
            $item->procesado = 0;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $this->emit('correcto', 'Cierre anulado con exito');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->reset('data');
        $this->reset('cierre_id');
        $this->ver_detalle = 0;
        $fecha_actual = Carbon::now();
        $this->año = date('Y', strtotime($fecha_actual));

    }
}
