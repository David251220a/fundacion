<?php

namespace App\Http\Livewire\PagoInstructor;

use App\Models\CierreCaja;
use App\Models\CursoHabilitado;
use App\Models\Egreso;
use App\Models\FormaPago;
use App\Models\Pago;
use App\Models\SalarioInstructor;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class InstructorPago extends Component
{

    public $total_general = 0, $ingreso, $egreso, $pago, $reporte_id = 0;
    public $curso, $instructor, $neto=0, $neto_salario=0, $forma_pago, $forma_pago_id = 1;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->forma_pago = FormaPago::all();
    }

    public function render()
    {
        $fecha_actual = Carbon::now();
        $fecha = date('Y-m-d', strtotime($fecha_actual));

        $data = SalarioInstructor::where('salario_concepto_id', 1)
        ->where('concluido', 1)
        ->where('fecha_concluido', '<=', $fecha)
        ->where('estado_id', 1)
        ->where('procesado', 0)
        ->paginate(20);

        return view('livewire.pago-instructor.instructor-pago', compact('data'));
    }

    public function datos_salario($id)
    {
        $this->curso = CursoHabilitado::find($id);
        $this->instructor = $this->curso->instructor;

        $this->ingreso = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('estado_id', 1)
        ->where('importe','>', 0)
        ->where('tipo', 1)
        ->get();

        $this->egreso = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('estado_id', 1)
        ->where('importe','>', 0)
        ->where('tipo', 2)
        ->get();

    }

    public function save_salario()
    {
        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = Pago::where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo = $numero_recibo + 1;
        $neto = $this->ingreso->sum('importe') - $this->egreso->sum('importe');

        $cierre = CierreCaja::create([
            'fecha' => $fecha_actual,
            'total_ingreso' => 0,
            'total_egreso' => $neto,
            'observacion' => 'PAGO PROFESOR',
            'cajero' => auth()->user()->id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $pago = Pago::create([
            'pago_tipo_id' => 2,
            'fecha' => $fecha_actual,
            'mes' => $mes,
            'año' => $anio,
            'importe' => $neto,
            'forma_pago_id' => $this->forma_pago_id,
            'procesado' => 1,
            'sucursal' => '0000',
            'general' => '0000',
            'factura_numero' => 0,
            'numero_recibo' => $numero_recibo,
            'cierre_caja_id' => $cierre->id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        Egreso::create([
            'cierre_caja_id' => $cierre->id,
            'pago_tipo_id' => 2,
            'forma_pago_id' => $this->forma_pago_id,
            'fecha' => $fecha_actual,
            'importe' => $neto,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $pago->pago_instructor()->create([
            'instructor_id' => $this->instructor->id,
            'curso_habilitado_id' => $this->curso->id,
            'salario_concepto_id' => 1,
            'importe' => $neto,
            'tipo' => 1,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $sal = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('estado_id', 1)
        ->get();

        foreach ($sal as $item) {
            $item->procesado = 1;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $this->reporte_id = $pago->id;
        $this->pago = $pago;
        $this->emit('reporte_salario', 'Se cargo con exito el anticipo.');

    }

    public function resetUI()
    {
        $this->reset('ingreso');
        $this->reset('egreso');
        $this->reset('curso');
        $this->reset('instructor');
        $this->reset('pago');
        $this->reporte_id = 0;
        $this->emit('reloadClassCSs');
    }
}
