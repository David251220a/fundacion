<?php

namespace App\Http\Livewire\PagoInstructor;

use App\Models\CierreCaja;
use App\Models\Pago;
use App\Models\SalarioInstructor;
use Livewire\Component;

class HistoricoPago extends Component
{


    protected $listeners = ['anular'];

    public function render()
    {
        $data = Pago::where('estado_id', 1)
        ->where('pago_tipo_id', 2)
        ->paginate(20);

        return view('livewire.pago-instructor.historico-pago', compact('data'));
    }

    public function anular($id)
    {
        $instructor = [];
        $curso_habilitado = [];
        $pago = Pago::find($id);

        $pago->estado_id = 2;
        $pago->modif_user_id = auth()->user()->id;
        $pago->update();

        foreach ($pago->pago_instructor as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();

            $instructor = $item->instructor;
            $curso_habilitado = $item->curso_habilitado;
        }

        $sal = SalarioInstructor::where('instructor_id', $instructor->id)
        ->where('curso_habilitado_id', $curso_habilitado->id)
        ->where('estado_id', 1)
        ->get();

        foreach ($sal as $item) {
            $item->procesado = 0;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $cierre = CierreCaja::find($pago->cierre_caja_id);
        $cierre->estado_id = 2;
        $cierre->modif_user_id = auth()->user()->id;
        $cierre->update();

        foreach ($cierre->egresos as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $this->emit('correcto', 'Pago Instructor anulado con exito');
    }
}
