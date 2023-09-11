<?php

namespace App\Http\Livewire\Cierre;

use App\Models\CierreCaja;
use App\Models\Egreso;
use App\Models\Ingreso;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndexCierre extends Component
{
    public $desde_fecha, $hasta_fecha, $datos_g = [];

    public function mount()
    {
        $fecha = Carbon::now();
        $this->desde_fecha = date('Y-m-d', strtotime($fecha));
        $this->hasta_fecha = $this->desde_fecha;
    }

    public function render()
    {
        $data = Ingreso::whereBetween('fecha', [$this->desde_fecha, $this->hasta_fecha])
        ->where('estado_id', 1)
        ->select('forma_pago_id', 'ingreso_tipo_id', DB::raw('SUM(importe) AS total'))
        ->groupBy('forma_pago_id', 'ingreso_tipo_id')
        ->get();

        $data_e = Egreso::whereBetween('fecha', [$this->desde_fecha, $this->hasta_fecha])
        ->where('estado_id', 1)
        ->select('forma_pago_id', 'pago_tipo_id', DB::raw('SUM(importe) AS total'))
        ->groupBy('forma_pago_id', 'pago_tipo_id')
        ->get();

        $this->datos_grafico();

        return view('livewire.cierre.index-cierre', compact('data', 'data_e'));
    }

    public function datos_grafico()
    {
        $this->datos_g = CierreCaja::where('estado_id', 1)
        ->whereBetween('fecha', [$this->desde_fecha, $this->hasta_fecha])
        ->select(DB::raw('SUM(total_ingreso) AS Ingreso', DB::raw('SUM(total_egreso) AS Egreso')))
        ->first();
    }

}
