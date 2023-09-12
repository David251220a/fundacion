<?php

namespace App\Http\Livewire\Anulacion;

use App\Models\Pago;
use App\Models\SalarioEmpleado;
use App\Models\SalarioInstructor;
use Carbon\Carbon;
use Livewire\Component;

class AnulacionAnticipo extends Component
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
        return view('livewire.anulacion.anulacion-anticipo');
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
        ->whereIn('pago_tipo_id', [5, 6])
        ->first();

        $this->ver_detalle = 1;
    }

    public function anular()
    {
        $pago = Pago::find($this->data->id);

        $pago->estado_id = 2;
        $pago->modif_user_id = auth()->user()->id;
        $pago->update();

        if($pago->pago_tipo_id == 5){
            foreach ($pago->pago_empleado as $item) {
                $item->estado_id = 2;
                $item->modif_user_id = auth()->user()->id;
                $item->update();
            }

            $salario = SalarioEmpleado::where('empleado_id', $item->empleado_id)
            ->where('salario_concepto_id', 2)
            ->first();

            $salario->importe = $salario->importe - $item->importe;
            $salario->modif_user_id = auth()->user()->id;
            $salario->update();

        }

        if($pago->pago_tipo_id == 6){
            foreach ($pago->pago_instructor as $item) {
                $item->estado_id = 2;
                $item->modif_user_id = auth()->user()->id;
                $item->update();

                $salario = SalarioInstructor::where('instructor_id', $item->instructor_id)
                ->where('curso_habilitado_id', $item->curso_habilitado_id)
                ->where('salario_concepto_id', 2)
                ->first();

                $salario->importe = $salario->importe - $item->importe;
                $salario->modif_user_id = auth()->user()->id;
                $salario->update();
            }
        }

        $this->emit('correcto', 'Anticipo anulado con exito.');
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
