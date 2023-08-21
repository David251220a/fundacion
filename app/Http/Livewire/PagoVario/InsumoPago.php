<?php

namespace App\Http\Livewire\PagoVario;

use App\Models\PagoVarios;
use Livewire\Component;

class InsumoPago extends Component
{
    public function render()
    {
        $data = PagoVarios::where('estado_id', 1)
        ->latest()
        ->take(50)
        ->get();
        return view('livewire.pago-vario.insumo-pago', compact('data'));
    }
}
