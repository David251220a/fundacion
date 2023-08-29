<?php

namespace App\Http\Livewire\ConsultaGeneral;

use App\Models\Instructor;
use App\Models\Pago;
use App\Models\PagoInstructor;
use App\Models\Persona;
use App\Models\SalarioInstructor;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PagoInstructores extends Component
{

    public $search, $fecha_desde, $fecha_hasta, $total_pago_instructor;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $listeners = ['anular_instructor'];

    public function mount()
    {
        $this->fecha_desde = date('Y-m-d', strtotime(Carbon::now()));
        $this->fecha_hasta = $this->fecha_desde;
    }

    public function render()
    {

        $data = [];
        $this->total_pago_instructor = 0;

        if($this->search){
            $data = $this->documento_fecha();
        }

        if(($this->fecha_desde) && ($this->fecha_hasta)){
            $data = $this->solo_fecha();
        }

        return view('livewire.consulta-general.pago-instructores', compact('data'));
    }


    public function documento_fecha()
    {
        $data = [];
        $documento = str_replace('.', '', $this->search);
        $persona = Persona::where('documento', $documento)->first();
        if ($persona) {
            $instructor = Instructor::where('persona_id', $persona->id)->first();
            if ($instructor) {
                $data = PagoInstructor::join('pagos AS a', 'pago_instructors.pago_id', '=', 'a.id')
                ->select('pago_instructors.*', 'a.fecha')
                ->where('pago_instructors.estado_id', 1)
                ->where('pago_instructors.instructor_id', $instructor->id)
                ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
                ->orderBy('pago_instructors.created_at', 'DESC')
                ->paginate(20);

                $this->total_pago_instructor = PagoInstructor::join('pagos AS a', 'pago_instructors.pago_id', '=', 'a.id')
                ->select('pago_instructors.*', 'a.fecha')
                ->where('pago_instructors.estado_id', 1)
                ->where('pago_instructors.instructor_id', $instructor->id)
                ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
                ->sum('pago_instructors.importe');
            }

        }

        return $data;
    }

    public function buscar_instructor()
    {
        $this->render();
    }

    public function solo_fecha()
    {
        $data = PagoInstructor::join('pagos AS a', 'pago_instructors.pago_id', '=', 'a.id')
        ->select('pago_instructors.*', 'a.fecha')
        ->where('pago_instructors.estado_id', 1)
        ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
        ->orderBy('pago_instructors.created_at', 'DESC')
        ->paginate(20);

        $this->total_pago_instructor = PagoInstructor::join('pagos AS a', 'pago_instructors.pago_id', '=', 'a.id')
        ->select('pago_instructors.*', 'a.fecha')
        ->where('pago_instructors.estado_id', 1)
        ->whereBetween('a.fecha', [$this->fecha_desde, $this->fecha_hasta])
        ->orderBy('pago_instructors.created_at', 'DESC')
        ->sum('pago_instructors.importe');

        return $data;

    }

    public function anular_instructor(Pago $pago)
    {

        if($pago->pago_tipo_id == 6){

            $aux = PagoInstructor::where('instructor_id', $pago->pago_instructor[0]->instructor_id)
            ->where('curso_habilitado_id', $pago->pago_instructor[0]->curso_habilitado_id)
            ->where('estado_id', 1)
            ->where('salario_concepto_id', 1)
            ->first();

            if($aux){
                $this->emit('mensaje_error', 'No puede anular este anticipo si ya se ha realizado el pago del instructor.');
                return false;
            }

            $pago->estado_id = 2;
            $pago->modif_user_id = auth()->user()->id;
            $pago->update();
            foreach ($pago->pago_instructor as $item) {
                $item->estado_id = 2;
                $item->modif_user_id = auth()->user()->id;
                $item->update();
            }

            $salario = SalarioInstructor::where('instructor_id', $pago->pago_instructor[0]->instructor_id)
            ->where('curso_habilitado_id', $pago->pago_instructor[0]->curso_habilitado_id)
            ->where('estado_id', 1)
            ->where('salario_concepto_id', 2)
            ->first();

            $calculo_nuevo = $salario->importe - $pago->importe;
            if($calculo_nuevo < 0){
                $calculo_nuevo = 0;
            }
            $salario->importe = $calculo_nuevo;
            $salario->modif_user_id = auth()->user()->id;
            $salario->update();

            $this->emit('correcto', 'Anulado con exito.');
            return false;
        }

        $pago->estado_id = 2;
        $pago->modif_user_id = auth()->user()->id;
        $pago->update();

        foreach ($pago->pago_instructor as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $salario = SalarioInstructor::where('instructor_id', $pago->pago_instructor[0]->instructor_id)
        ->where('curso_habilitado_id', $pago->pago_instructor[0]->curso_habilitado_id)
        ->where('estado_id', 1)
        ->get();

        foreach ($salario as $item) {
            $item->procesado = 0;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $this->emit('correcto', 'Anulado con exito.');
    }
}
