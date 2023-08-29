<?php

namespace App\Http\Livewire\ConsultaGeneral;

use App\Models\PagoVarios;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class OtrosPagos extends Component
{
    public $fecha_desde, $fecha_hasta, $total_pago;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $listeners = ['anular_pago'];

    public function mount()
    {
        $this->fecha_desde = date('Y-m-d', strtotime(Carbon::now()));
        $this->fecha_hasta = $this->fecha_desde;
    }

    public function render()
    {
        $this->total_pago = 0;
        $data = [];

        if(($this->fecha_desde) && ($this->fecha_hasta)){
            $data = PagoVarios::join('pagos AS a', 'pago_varios.pago_id', '=', 'a.id')
            ->select('pago_varios.*', 'a.fecha')
            ->where('pago_varios.estado_id', 1)
            ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
            ->orderBy('pago_varios.created_at', 'DESC')
            ->paginate(20);

            $this->total_pago = PagoVarios::join('pagos AS a', 'pago_varios.pago_id', '=', 'a.id')
            ->select('pago_varios.*', 'a.fecha')
            ->where('pago_varios.estado_id', 1)
            ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
            ->sum('pago_varios.importe');
        }

        return view('livewire.consulta-general.otros-pagos', compact('data'));
    }

    public function buscar_varios()
    {
        $this->render();
    }
}
