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

class CertificadoDeuda extends Component
{
    public $titulo, $cer_forma_pago_id, $forma_pago, $cer_comprobante, $precio_certificado, $cer_total_pagar_modal, $ingreso, $valor_id = 0;
    public $guardando = false, $cursoAlumno, $search, $documento_modal, $nombre_modal, $nombre_id='recibo_comprobante_certificado', $deudacertificado;

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $rules = [
        'cer_comprobante' => 'image|mimes:jpeg,png,jpg,gif'
    ];

    public function mount()
    {
        $this->forma_pago = FormaPago::all();
        $this->cer_forma_pago_id = $this->forma_pago[0]->id;
        $this->titulo = 'Cobro de Curso';
    }

    public function render()
    {
        $this->deudacertificado = 0;

        if(empty($this->search)){
            $data = CursoAlumno::where('certificado_saldo', '>' , 0)
            ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
            ->where('estado_id', 1)
            ->orderBy('curso_habilitado_id', 'DESC')
            ->paginate(15);

            $aux = CursoAlumno::where('certificado_saldo', '>' , 0)
            ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
            ->where('estado_id', 1)
            ->get();
        }else{
            $persona = Persona::where('documento', str_replace('.', '', $this->search))
            ->first();

            if(empty($persona)){
                $data = CursoAlumno::where('certificado_saldo', '>' , 0)
                ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
                ->where('estado_id', 1)
                ->orderBy('curso_habilitado_id', 'DESC')
                ->paginate(15);

                $aux = CursoAlumno::where('certificado_saldo', '>' , 0)
                ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
                ->where('estado_id', 1)
                ->get();
            }else{
                $data = CursoAlumno::where('certificado_saldo', '>' , 0)
                ->where('alumno_id', $persona->alumno->id)
                ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
                ->where('estado_id', 1)
                ->orderBy('curso_habilitado_id', 'DESC')
                ->paginate(15);

                $aux = CursoAlumno::where('certificado_saldo', '>' , 0)
                ->where('alumno_id', $persona->alumno->id)
                ->whereIn('curso_a_estado_id', [1, 2, 3, 7])
                ->where('estado_id', 1)
                ->get();
            }
        }

        $this->deudacertificado = number_format($aux->sum('certificado_saldo'), 0, ".", ".");
        return view('livewire.consulta-general.certificado-deuda', compact('data'));
    }

    public function detalle_certificado(CursoAlumno $cursoAlumno)
    {
        $this->documento_modal = number_format($cursoAlumno->alumno->persona->documento, 0, ".", ".");
        $this->nombre_modal = $cursoAlumno->alumno->persona->nombre . ' ' . $cursoAlumno->alumno->persona->apellido;
        $this->precio_certificado = number_format($cursoAlumno->certificado_saldo, 0, ".", ".");
        $this->cer_total_pagar_modal = $this->precio_certificado;
        $this->cursoAlumno = $cursoAlumno;

    }

    public function save_certificado()
    {
        if($this->cer_comprobante){
            $this->validate();
        }

        $total = str_replace('.', '', $this->cer_total_pagar_modal);

        if(empty($this->cer_total_pagar_modal)){
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

        if($this->cer_comprobante){
            $filePath = $this->comprobante->store('public/comprobante');
        }else{
            $filePath = '';
        }

        $ingreso = IngresoMatricula::create([
            'alumno_id' => $cursoAlumno->alumno_id,
            'fecha_ingreso' => $fecha_actual,
            'forma_pago_id' => $this->cer_forma_pago_id,
            'año' => $anio,
            'mes' => $mes,
            'tipo_cobro' => 2,
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

        $monto_total = str_replace('.', '', $this->precio_certificado);
        $ingreso->detalle()->create([
            'curso_habilitado_id' => $cursoAlumno->curso_habilitado_id,
            'alumno_id' => $cursoAlumno->alumno_id,
            'monto_total' => $monto_total,
            'monto_pagado' => $total,
            'saldo' => ($monto_total - $total),
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $cursoAlumno->certificado_pagado = $cursoAlumno->certificado_pagado + $total;
        $cursoAlumno->certificado_saldo = $cursoAlumno->certificado_saldo - $total;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $ingreso->id;
        $this->emit('reporte_cert', 'recibo');
    }

    public function resetUI()
    {
        $this->reset('cer_comprobante');
        $this->reset('precio_certificado');
        $this->reset('cer_total_pagar_modal');
        $this->reset('ingreso');
        $this->reset('documento_modal');
        $this->reset('nombre_modal');
        $this->valor_id = 0;
        $this->guardando = false;
        $this->cer_forma_pago_id = $this->forma_pago[0]->id;

    }

}
