<?php

namespace App\Http\Livewire\PagoVario;

use App\Models\Insumo;
use Livewire\Component;

class InsumoInactivo extends Component
{

    protected $listeners = ['activar'];

    public function render()
    {
        $data = Insumo::where('estado_id', 2)->get();
        return view('livewire.pago-vario.insumo-inactivo', compact('data'));
    }

    public function activar(Insumo $insumo)
    {
        $insumo->estado_id = 1;
        $insumo->modif_user_id = auth()->user()->id;
        $insumo->update();

        $this->emit('correcto', 'Insumo activado con exito.');
    }
}
