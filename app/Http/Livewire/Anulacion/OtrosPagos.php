<?php

namespace App\Http\Livewire\Anulacion;

use App\Models\Pago;
use Carbon\Carbon;
use Livewire\Component;

class OtrosPagos extends Component
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
        return view('livewire.anulacion.otros-pagos');
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

        $this->data = Pago::where('año', $año)
        ->where('numero_recibo', $numero)
        ->where('pago_tipo_id', 4)
        ->first();

        $this->ver_detalle = 1;
    }

    public function anular()
    {

        $pago = Pago::find($this->data->id);
        $pago->estado_id = 2;
        $pago->modif_user_id = auth()->user()->id;
        $pago->update();

        foreach ($pago->pago_varios as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $this->emit('correcto', 'Pago anulado.');
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
