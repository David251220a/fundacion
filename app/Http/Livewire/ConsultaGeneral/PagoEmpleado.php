<?php

namespace App\Http\Livewire\ConsultaGeneral;

use App\Models\Empleado;
use App\Models\PagoEmpleado as ModelsPagoEmpleado;
use App\Models\Persona;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PagoEmpleado extends Component
{
    public $search, $fecha_desde, $fecha_hasta, $total_pago_empleado;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $listeners = ['anular_empleado'];

    public function mount()
    {
        $this->fecha_desde = date('Y-m-d', strtotime(Carbon::now()));
        $this->fecha_hasta = $this->fecha_desde;
    }

    public function render()
    {
        $data = [];
        $this->total_pago_empleado = 0;

        if($this->search){
            $data = $this->documento_fecha();
        }

        if(($this->fecha_desde) && ($this->fecha_hasta)){
            $data = $this->solo_fecha();
        }

        return view('livewire.consulta-general.pago-empleado', compact('data'));
    }

    public function documento_fecha()
    {
        $data = [];
        $documento = str_replace('.', '', $this->search);
        $persona = Persona::where('documento', $documento)->first();
        if ($persona) {
            $empleado = Empleado::where('persona_id', $persona->id)->first();
            if ($empleado) {
                $data = ModelsPagoEmpleado::join('pagos AS a', 'pago_empleados.pago_id', '=', 'a.id')
                ->select('pago_empleados.*', 'a.fecha')
                ->where('pago_empleados.estado_id', 1)
                ->where('pago_empleados.empleado_id', $empleado->id)
                ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
                ->orderBy('pago_empleados.created_at', 'DESC')
                ->paginate(20);

                $this->total_pago_empleado = ModelsPagoEmpleado::join('pagos AS a', 'pago_empleados.pago_id', '=', 'a.id')
                ->select('pago_empleados.*', 'a.fecha')
                ->where('pago_empleados.estado_id', 1)
                ->where('pago_empleados.empleado_id', $empleado->id)
                ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
                ->sum('pago_empleados.importe');
            }

        }

        return $data;
    }

    public function buscar_empleado()
    {
        $this->render();
    }

    public function solo_fecha()
    {
        $data = ModelsPagoEmpleado::join('pagos AS a', 'pago_empleados.pago_id', '=', 'a.id')
        ->select('pago_empleados.*', 'a.fecha')
        ->where('pago_empleados.estado_id', 1)
        ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
        ->orderBy('pago_empleados.created_at', 'DESC')
        ->paginate(20);

        $this->total_pago_empleado = ModelsPagoEmpleado::join('pagos AS a', 'pago_empleados.pago_id', '=', 'a.id')
        ->select('pago_empleados.*', 'a.fecha')
        ->where('pago_empleados.estado_id', 1)
        ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
        ->sum('pago_empleados.importe');

        return $data;

    }
}
