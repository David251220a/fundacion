<?php

namespace App\Http\Livewire\Habilitado;

use App\Models\CursoAEstado;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use App\Models\FormaPago;
use App\Models\IngresoMatricula;
use App\Models\Persona;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListadoCurso extends Component
{

    public $curso_id, $documento, $curso_precio, $comprobante, $observacion_modal, $estado_a_id, $estado_curso = 99;
    public $documento_modal, $forma_pago_id = 1, $nombre_modal, $total_pagar_modal = 0;
    public $cursoAlumno;

    use WithFileUploads;

    protected $listeners = ['render', 'datos'];

    protected $rules = [
        'total_pagar_modal' => 'required',
        'comprobante' => 'image|mimes:jpeg,png,jpg,gif'
    ];

    public function mount(CursoHabilitado $cursoHabilitado)
    {
        $this->curso_id = $cursoHabilitado->id;
        $this->curso_precio = number_format($cursoHabilitado->precio, 0, ".", ".");
    }

    public function render()
    {
        $documento = null;
        $alumno_id = 0;
        if(!(empty($this->documento))){
            $documento = str_replace('.', '', $this->documento);
            $persona = Persona::where('documento', $documento)->first();
            if(!(empty($persona))){
                if(!(empty($persona->alumno))){
                    $alumno_id = $persona->alumno->id;
                }
            }

        }

        $forma_pago = FormaPago::all();

        if ($this->estado_curso == 99){
            if(!(empty($this->documento))){
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->where('alumno_id', $alumno_id)
                ->get();
            }else{
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->get();
            }

        }else{
            if(!(empty($this->documento))){
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->where('alumno_id', $alumno_id)
                ->where('curso_a_estado_id', $this->estado_curso)
                ->get();
            }else{
                $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                ->where('curso_a_estado_id', $this->estado_curso)
                ->get();
            }

        }

        $estado = CursoAEstado::all();

        return view('livewire.habilitado.listado-curso', compact('alumnos', 'estado', 'forma_pago'));
    }


    public function datos(CursoAlumno $cursoAlumno)
    {
        $this->curso_precio = number_format($cursoAlumno->saldo, 0, ".", ".");
        $this->documento_modal = number_format($cursoAlumno->alumno->persona->documento, 0, ".", ".");
        $this->nombre_modal = $cursoAlumno->alumno->persona->nombre . ' ' . $cursoAlumno->alumno->persona->apellido;
        $this->estado_a_id = $cursoAlumno->curso_a_estado_id;
        $this->cursoAlumno = $cursoAlumno;
    }


    public function save()
    {
        $this->validate();

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
        $numero_recibo = IngresoMatricula::where('mes', $mes)
        ->where('año', $anio)
        ->max('numero_recibo');
        $numero_recibo += 1;

        if($this->comprobante){
            $filePath = $this->comprobante->store('public/comprobante');
        }else{
            $filePath = '';
        }

        $ingreso = IngresoMatricula::create([
            'alumno_id' => $cursoAlumno->alumno_id,
            'fecha_ingreso' => $fecha_actual,
            'forma_pago_id' => $this->forma_pago_id,
            'año' => $anio,
            'mes' => $mes,
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

        $monto_total = str_replace('.', '', $this->curso_precio);
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

        $cursoAlumno->monto_abonado = $cursoAlumno->monto_abonado + $total_pagar;
        $cursoAlumno->saldo = $cursoAlumno->saldo - $total_pagar;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();

        $this->resetUI();
        $this->emit('cobro_exito', 'Cobro realizado con exito.');
    }

    public function save_estado()
    {
        $cursoAlumno = $this->cursoAlumno;
        $cursoAlumno->curso_a_estado_id = $this->estado_a_id;
        $cursoAlumno->observacion = $this->observacion_modal;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();

        $this->resetUI();
        $this->emit('estado_exito', 'Se actualizo con exito el alumno.');
    }

    public function resetUI()
    {
        $this->reset('curso_precio');
        $this->reset('documento_modal');
        $this->reset('nombre_modal');
        $this->reset('cursoAlumno');
        $this->reset('total_pagar_modal');
        $this->reset('observacion_modal');
        $this->forma_pago_id = 1;
        $this->emit('reloadClassCSs');

    }
}
