<?php

namespace App\Http\Livewire\Habilitado;

use App\Models\Alumno;
use App\Models\CursoAEstado;
use App\Models\CursoAlumno;
use App\Models\CursoHabilitado;
use App\Models\FormaPago;
use App\Models\IngresoMatricula;
use App\Models\IngresoMatriculaDetalle;
use App\Models\Persona;
use App\Models\Promo;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListadoCurso extends Component
{

    public $curso_id, $documento, $curso_precio, $comprobante, $observacion_modal, $estado_a_id, $estado_curso = 99;
    public $documento_modal, $forma_pago_id = 1, $cer_forma_pago_id=1, $nombre_modal, $total_pagar_modal = 0;
    public $cursoAlumno, $documento_e_modal, $nombre_e_modal, $cuenta = [];
    public $precio_certificado, $cer_comprobante, $cer_total_pagar_modal, $ingreso, $valor_id = 0, $saldos, $promo, $existe_promo, $descuento, $porcentaje;
    use WithFileUploads;

    protected $listeners = ['render', 'datos', 'estado_cuenta'];

    protected $rules = [
        'total_pagar_modal' => 'required',
        'comprobante' => 'image|mimes:jpeg,png,jpg,gif'
    ];

    public function mount(CursoHabilitado $cursoHabilitado)
    {
        $this->curso_id = $cursoHabilitado->id;
        $this->curso_precio = number_format($cursoHabilitado->precio, 0, ".", ".");
        $this->saldos = 1;
        $this->existe_promo = 0;
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
                if($this->saldos == 1){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('alumno_id', $alumno_id)
                    ->get();
                }elseif($this->saldos == 2){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('alumno_id', $alumno_id)
                    ->where('saldo', '>', 0)
                    ->get();
                }else{
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('alumno_id', $alumno_id)
                    ->where('saldo', 0)
                    ->get();
                }

            }else{

                if($this->saldos == 1){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->whereBetween('curso_a_estado_id', [1, 2])
                    ->get();
                }elseif($this->saldos == 2){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->whereBetween('curso_a_estado_id', [1, 2])
                    ->where('saldo', '>', 0)
                    ->get();
                }else{
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->whereBetween('curso_a_estado_id', [1, 2])
                    ->where('saldo', 0)
                    ->get();
                }

            }

        }else{
            if(!(empty($this->documento))){
                if($this->saldos == 1){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('alumno_id', $alumno_id)
                    ->where('curso_a_estado_id', $this->estado_curso)
                    ->get();
                }elseif($this->saldos == 2){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('alumno_id', $alumno_id)
                    ->where('curso_a_estado_id', $this->estado_curso)
                    ->where('saldo', '>', 0)
                    ->get();
                }else{
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('alumno_id', $alumno_id)
                    ->where('curso_a_estado_id', $this->estado_curso)
                    ->where('saldo', 0)
                    ->get();
                }
            }else{

                if($this->saldos == 1){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('curso_a_estado_id', $this->estado_curso)
                    ->get();
                }elseif($this->saldos == 2){
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('curso_a_estado_id', $this->estado_curso)
                    ->where('saldo', '>', 0)
                    ->get();
                }else{
                    $alumnos = CursoAlumno::where('curso_habilitado_id', $this->curso_id)
                    ->where('curso_a_estado_id', $this->estado_curso)
                    ->where('saldo', 0)
                    ->get();
                }
            }

        }

        $total_saldo = $alumnos->sum('saldo');
        $estado = CursoAEstado::all();

        return view('livewire.habilitado.listado-curso', compact('alumnos', 'estado', 'forma_pago', 'total_saldo'));
    }


    public function datos(CursoAlumno $cursoAlumno)
    {
        $this->recuperar_promo();
        $this->descuento = 0;
        $this->porcentaje = 0;
        $fecha_inscripcion = $cursoAlumno->created_at->format('Y-m-d');
        $fecha = Carbon::now();
        $fecha_actual= $fecha->format('Y-m-d');
        $fecha_curso_creacion = $cursoAlumno->curso_habilitado->created_at->format('Y-m-d');
        $aplica = false;
        if($this->existe_promo == 1){
            if ($fecha >= $fecha_curso_creacion){
                if ($cursoAlumno->monto_abonado == 0){
                    $aplica = true;
                }
            }
        }

        if ($aplica == true){
            $descuento = round(($cursoAlumno->total_pagar * $this->promo->porcentaje) / 100);
            $precio = $cursoAlumno->total_pagar - $descuento;
            $this->porcentaje = $this->promo->porcentaje;
            $this->descuento = number_format($descuento, 0, ".", ".");
            $this->curso_precio = number_format($precio, 0, ".", ".");
        }else{
            $this->existe_promo = 0;
            $this->descuento = 0;
            $this->porcentaje = 0;
            $this->curso_precio = number_format($cursoAlumno->saldo, 0, ".", ".");
        }
        $this->documento_modal = number_format($cursoAlumno->alumno->persona->documento, 0, ".", ".");
        $this->nombre_modal = $cursoAlumno->alumno->persona->nombre . ' ' . $cursoAlumno->alumno->persona->apellido;
        $this->estado_a_id = $cursoAlumno->curso_a_estado_id;
        $this->cursoAlumno = $cursoAlumno;
        $this->precio_certificado = number_format($cursoAlumno->certificado_saldo, 0, ".", ".");
        $this->cer_total_pagar_modal = $this->precio_certificado;
    }

    public function estado_cuenta(CursoAlumno $cursoAlumno, Alumno $alumno)
    {
        $this->nombre_e_modal = $cursoAlumno->alumno->persona->nombre . ' ' . $cursoAlumno->alumno->persona->apellido;
        $this->documento_e_modal = number_format($cursoAlumno->alumno->persona->documento, 0, ".", ".");
        $this->cursoAlumno = $cursoAlumno;
        $this->cuenta = IngresoMatriculaDetalle::where('curso_habilitado_id', $cursoAlumno->curso_habilitado_id)
        ->where('alumno_id', $alumno->id)
        ->where('estado_id', 1)
        ->get();
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


        $curso_precio = str_replace('.', '', $this->curso_precio);
        $total_pagar = str_replace('.', '', $this->total_pagar_modal);
        $monto_total = $this->cursoAlumno->saldo;

        if($total_pagar == 0){
            $this->emit('mensaje_error', 'El total a pagar no pueder ser 0.');
            $this->resetUI();
            return false;
        }

        if ($total_pagar > $curso_precio){
            $this->emit('mensaje_error', 'El total a pagar mayor al saldo.');
            $this->resetUI();
            return false;
        }

        $porcentaje = 0;
        $descuento = 0;

        if($this->existe_promo == 1){
            $porcentaje = $this->porcentaje;
            $descuento = str_replace('.', '', $this->descuento);

            if(($monto_total - $descuento) != $total_pagar){
                $porcentaje = 0;
                $descuento = 0;
                $curso_precio = $this->cursoAlumno->saldo;
            }
        }

        $saldo_curso = $monto_total - ($descuento + $total_pagar);

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
            'alumno_id' => $cursoAlumno->alumno_id,
            'fecha_ingreso' => $fecha_actual,
            'forma_pago_id' => $this->forma_pago_id,
            'tipo_cobro' => 1,
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

        $ingreso->detalle()->create([
            'curso_habilitado_id' => $cursoAlumno->curso_habilitado_id,
            'alumno_id' => $cursoAlumno->alumno_id,
            'monto_total' => $monto_total,
            'monto_pagado' => $total_pagar,
            'saldo' => $saldo_curso,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
            'total_descuento' => $descuento,
            'porcentaje_aplicado' => $porcentaje,
        ]);

        $cursoAlumno->monto_abonado = $cursoAlumno->monto_abonado + $total_pagar;
        $cursoAlumno->saldo = $cursoAlumno->saldo - ($total_pagar + $descuento);
        $cursoAlumno->total_descuento = $descuento;
        $cursoAlumno->porcentaje_aplicado = $porcentaje;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        $cursoAlumno->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $ingreso->id;

        $this->resetUI();
        $this->emit('cobro_exito', 'Cobro realizado con exito.');
    }

    public function save_estado()
    {
        $cursoAlumno = $this->cursoAlumno;
        $cursoAlumno->curso_a_estado_id = $this->estado_a_id;
        $cursoAlumno->observacion = $this->observacion_modal;
        $cursoAlumno->modif_user_id = auth()->user()->id;
        if($this->estado_a_id == 2){
            $cursoAlumno->reactivado = 1;
        }else{
            $cursoAlumno->reactivado = 0;
        }
        $cursoAlumno->update();

        $this->resetUI();
        $this->emit('estado_exito', 'Se actualizo con exito el alumno.');
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
            'forma_pago_id' => $this->cer_forma_pago_id,
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
        $this->emit('cobro_exito', 'Cobro realizado con exito.');
    }

    public function resetUI()
    {
        $this->reset('curso_precio');
        $this->reset('documento_modal');
        $this->reset('nombre_modal');
        $this->reset('documento_e_modal');
        $this->reset('nombre_e_modal');
        $this->reset('cursoAlumno');
        $this->reset('total_pagar_modal');
        $this->reset('observacion_modal');
        $this->reset('precio_certificado');
        $this->reset('cer_total_pagar_modal');
        $this->reset('promo');
        $this->forma_pago_id = 1;
        $this->cer_forma_pago_id = 1;
        $this->emit('reloadClassCSs');

    }

    public function recuperar_promo()
    {
        $fecha = Carbon::now();
        $fecha_actual= $fecha->format('Y-m-d');
        $dia = date('N');
        $colDia = [
            1 => 'lunes',
            2 => 'martes',
            3 => 'miercoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sabado',
            7 => 'domingo',
        ][$dia];

        $this->promo = Promo::query()
        ->where('estado_id', 1)
        ->whereDate('fecha_inicio', '<=', $fecha_actual)
        ->whereDate('fecha_fin', '>=', $fecha_actual)
        ->where($colDia, 1)
        ->orderBy('id')
        ->first();

        if($this->promo){
            $this->existe_promo = 1;
        }else{
            $this->existe_promo = 0;
        }

    }
}
