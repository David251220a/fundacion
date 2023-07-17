<?php

namespace App\Http\Livewire\IngresoMatricula;

use App\Models\Alumno;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use App\Models\FormaPago;
use App\Models\IngresoMatricula;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class IngresoCurso extends Component
{

    public $alumno, $forma_pago_id, $cursoAlumno, $titulo, $comprobante, $monto_pagar, $total_pagar_modal, $ingreso, $valor_id = 0;
    public $precio_certificado, $cer_comprobante, $cer_total_pagar_modal, $documento_modal, $nombre_modal;

    use WithFileUploads;

    protected $listeners = ['datos'];

    protected $rules = [
        'total_pagar_modal' => 'required',
        'comprobante' => 'image|mimes:jpeg,png,jpg,gif'
    ];

    public function mount(Alumno $alumno)
    {
        $this->alumno = $alumno;
        $this->forma_pago_id = 1;
        $this->titulo = 'Cobro Curso';
    }

    public function render()
    {
        $curso = CursoAlumno::where('alumno_id', $this->alumno->id)
        ->whereNotIn('curso_a_estado_id', [4, 5, 6])
        ->where('saldo', '>', 0)
        ->get();

        $certificado = CursoAlumno::where('alumno_id', $this->alumno->id)
        ->whereNotIn('curso_a_estado_id', [4, 5, 6])
        ->where('certificado_saldo', '>', 0)
        ->get();

        $forma_pago = FormaPago::all();

        return view('livewire.ingreso-matricula.ingreso-curso', compact('curso', 'forma_pago', 'certificado'));
    }

    public function detalle($curso)
    {
        $curso = CursoAlumno::find($curso);
        $this->cursoAlumno = $curso;
        $this->monto_pagar = number_format($curso->saldo, 0, ".", ".");
        $this->total_pagar_modal = $this->monto_pagar;
        $this->precio_certificado = number_format($curso->certificado_saldo, 0, ".", ".");
        $this->emit('abrir_modal', 'dale');
    }

    public function save()
    {
        if($this->comprobante){
            $filePath = $this->comprobante->store('public/comprobante');
            $this->validate();
        }else{
            $filePath = '';
            $this->validate([
                'total_pagar_modal' => 'required',
            ]);
        }


        $total_pagar = str_replace('.', '', $this->total_pagar_modal);

        if($total_pagar == 0){
            $this->emit('mensaje_error', 'El total a pagar no pueder ser 0.');
            $this->resetUI();

            return false;
        }

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
            'alumno_id' => $this->alumno->id,
            'fecha_ingreso' => $fecha_actual,
            'forma_pago_id' => $this->forma_pago_id,
            'año' => $anio,
            'mes' => $mes,
            'tipo_cobro' => 1,
            'numero_recibo' => $numero_recibo,
            'sucursal' => '000',
            'general' => '000',
            'factura_numero' => 0,
            'total_pagado' => $total_pagar,
            'comprobante' => $filePath,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $monto_total =  str_replace('.', '', $this->monto_pagar);
        $ingreso->detalle()->create([
            'curso_habilitado_id' => $cursoAlumno->curso_habilitado_id,
            'alumno_id' => $this->alumno->id,
            'monto_total' => $monto_total,
            'monto_pagado' => $total_pagar,
            'saldo' => ($monto_total - $total_pagar),
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $cursoAlumno->monto_abonado = $cursoAlumno->monto_abonado + $total_pagar;
        $cursoAlumno->saldo = $cursoAlumno->saldo - $total_pagar;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $ingreso->id;
        $this->emit('ver_recibo', 'recibo');
        $this->render();
    }

    public function datos(CursoAlumno $cursoAlumno)
    {
        $this->cursoAlumno = $cursoAlumno;
        $this->documento_modal = number_format($cursoAlumno->alumno->persona->documento, 0, ".", ".");
        $this->nombre_modal = $cursoAlumno->alumno->persona->nombre . ' ' . $cursoAlumno->alumno->persona->apellido;
        $this->cursoAlumno = $cursoAlumno;
        $this->precio_certificado = number_format($cursoAlumno->certificado_saldo, 0, ".", ".");
        $this->cer_total_pagar_modal = $this->precio_certificado;

    }

    public function save_certificado()
    {
        if($this->cer_comprobante){
            $filePath = $this->cer_comprobante->store('public/comprobante');
            $this->validate([
                'cer_total_pagar_modal' => 'required',
                'cer_comprobante' => 'image|mimes:jpeg,png,jpg,gif'
            ]);
        }else{
            $filePath = '';
            $this->validate([
                'cer_total_pagar_modal' => 'required',
            ]);
        }

        $total_pagar = str_replace('.', '', $this->cer_total_pagar_modal);

        if($total_pagar == 0){
            $this->emit('mensaje_error', 'El total a pagar no pueder ser 0.');
            $this->resetUI();

            return false;
        }

        $cursoAlumno = $this->cursoAlumno;
        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoMatricula::where('año', $anio)
        ->max('numero_recibo');
        $numero_recibo += 1;

        $ingreso = IngresoMatricula::create([
            'alumno_id' => $cursoAlumno->alumno_id,
            'fecha_ingreso' => $fecha_actual,
            'forma_pago_id' => $this->forma_pago_id,
            'año' => $anio,
            'mes' => $mes,
            'tipo_cobro' => 2,
            'numero_recibo' => $numero_recibo,
            'sucursal' => '000',
            'general' => '000',
            'factura_numero' => 0,
            'total_pagado' => $total_pagar,
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
            'monto_pagado' => $total_pagar,
            'saldo' => ($monto_total - $total_pagar),
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $cursoAlumno->certificado_pagado = $cursoAlumno->certificado_pagado + $total_pagar;
        $cursoAlumno->certificado_saldo = $cursoAlumno->certificado_saldo - $total_pagar;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $ingreso->id;

        $this->resetUI();
        $this->emit('ver_recibo', 'Cobro realizado con exito.');
    }

    public function resetUI()
    {
        $this->reset('total_pagar_modal');
        $this->reset('monto_pagar');
        $this->reset('comprobante');
        $this->reset('cursoAlumno');
        $this->forma_pago_id = 1;
        $this->emit('reloadClassCSs');

    }
}
