<?php

namespace App\Http\Livewire\ConsultaGeneral;

use App\Models\CursoAlumno;
use App\Models\FormaPago;
use App\Models\IngresoMatricula;
use App\Models\Persona;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CursoDeuda extends Component
{

    public $titulo, $forma_pago_id, $forma_pago, $comprobante, $monto_pagar, $total_pagar_modal, $ingreso, $valor_id = 0;
    public $guardando = false, $cursoAlumno, $search;

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $rules = [
        'comprobante' => 'image|mimes:jpeg,png,jpg,gif'
    ];

    protected $listeners = ['exonerar'];

    public function mount()
    {
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = $this->forma_pago[0]->id;
        $this->titulo = 'Cobro de Curso';
    }

    public function render()
    {
        if(empty($this->search)){
            $data = CursoAlumno::where('saldo', '>' , 0)
            ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
            ->where('estado_id', 1)
            ->paginate(15);
        }else{
            $persona = Persona::where('documento', str_replace('.', '', $this->search))
            ->first();

            if(empty($persona)){
                $data = CursoAlumno::where('saldo', '>' , 0)
                ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
                ->where('estado_id', 1)
                ->paginate(15);
            }else{
                $data = CursoAlumno::where('saldo', '>' , 0)
                ->where('alumno_id', $persona->alumno->id)
                ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
                ->where('estado_id', 1)
                ->paginate(15);
            }
        }



        return view('livewire.consulta-general.curso-deuda', compact('data'));
    }

    public function detalle(CursoAlumno $cursoAlumno)
    {
        $this->monto_pagar = number_format($cursoAlumno->saldo, 0, ".", ".");
        $this->total_pagar_modal = $this->monto_pagar;
        $this->cursoAlumno = $cursoAlumno;
    }

    public function save()
    {
        if($this->comprobante){
            $this->validate();
        }

        $total = str_replace('.', '', $this->total_pagar_modal);

        if(empty($this->total_pagar_modal)){
            $this->emit('mensaje_error', 'El total a pagar no puede estar vacio.');
            $this->resetUI();
            return false;
        }

        if($total == 0){
            $this->emit('mensaje_error', 'El total a pagar no puede ser cero.');
            $this->resetUI();
            return false;
        }

        // $this->guardando = false;

        $cursoAlumno = $this->cursoAlumno;
        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoMatricula::where('año', $anio)
        ->max('numero_recibo');
        $numero_recibo += 1;

        if($this->comprobante){
            $filePath = $this->comprobante->store('public/comprobante');
        }else{
            $filePath = '';
        }

        $ingreso = IngresoMatricula::create([
            'alumno_id' => $this->cursoAlumno->alumno_id,
            'fecha_ingreso' => $fecha_actual,
            'forma_pago_id' => $this->forma_pago_id,
            'año' => $anio,
            'mes' => $mes,
            'tipo_cobro' => 1,
            'numero_recibo' => $numero_recibo,
            'sucursal' => '000',
            'general' => '000',
            'factura_numero' => 0,
            'total_pagado' => $total,
            'comprobante' => $filePath,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $monto_total =  str_replace('.', '', $this->monto_pagar);
        $ingreso->detalle()->create([
            'curso_habilitado_id' => $cursoAlumno->curso_habilitado_id,
            'alumno_id' => $this->cursoAlumno->alumno_id,
            'monto_total' => $monto_total,
            'monto_pagado' => $total,
            'saldo' => ($monto_total - $total),
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $cursoAlumno->monto_abonado = $cursoAlumno->monto_abonado + $total;
        $cursoAlumno->saldo = $cursoAlumno->saldo - $total;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $ingreso->id;
        // $this->guardando = true;
        $this->emit('reporte', 'recibo');
    }

    public function exonerar(CursoAlumno $cursoAlumno)
    {
        $cursoAlumno->exoneracion = 1;
        $cursoAlumno->saldo = 0;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();
        $this->emit('correcto', 'Exonerado con exito.');
    }

    public function resetUI()
    {
        $this->reset('comprobante');
        $this->reset('monto_pagar');
        $this->reset('total_pagar_modal');
        $this->reset('ingreso');
        $this->valor_id = 0;
        $this->guardando = false;
        $this->forma_pago_id = $this->forma_pago[0]->id;

    }
}
