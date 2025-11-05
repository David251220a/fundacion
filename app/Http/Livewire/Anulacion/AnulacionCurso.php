<?php

namespace App\Http\Livewire\Anulacion;

use App\Models\CursoAlumno;
use App\Models\IngresoMatricula;
use Carbon\Carbon;
use Livewire\Component;

class AnulacionCurso extends Component
{
    public $ver_detalle = 0, $año, $numero_recibo, $data = [];

    protected $listeners = ['anular'];

    public function mount()
    {
        $fecha_actual = Carbon::now();
        $this->año = date('Y', strtotime($fecha_actual));
    }

    public function render()
    {
        return view('livewire.anulacion.anulacion-curso');
    }

    public function buscar()
    {
        if (empty($this->año)){
            return false;
        }

        if (empty($this->numero_recibo)){
            return false;
        }

        $año = str_replace('.', '', $this->año);
        $numero = str_replace('.', '', $this->numero_recibo);
        $this->data =IngresoMatricula::where('año', $año)
        ->where('numero_recibo', $numero)
        ->first();

        $this->ver_detalle = 1;
    }

    public function anular()
    {

        $ingreso = IngresoMatricula::find($this->data->id);
        $ingreso->estado_id = 2;
        $ingreso->modif_user_id = auth()->user()->id;
        $ingreso->update();

        foreach ($ingreso->detalle as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();

            $cursoAlumno = CursoAlumno::where('alumno_id', $item->alumno_id)
            ->where('curso_habilitado_id', $item->curso_habilitado_id)
            ->where('estado_id', 1)
            ->first();

            if($ingreso->tipo_cobro == 1){
                $cursoAlumno->monto_abonado = $cursoAlumno->monto_abonado - $item->monto_pagado;
                if($item->total_descuento > 0){
                    $cursoAlumno->saldo = $cursoAlumno->saldo + $item->monto_pagado + $item->total_descuento;
                    $cursoAlumno->total_descuento = 0;
                    $cursoAlumno->porcentaje_aplicado = 0;
                    $cursoAlumno->estado_id = 1;
                    $cursoAlumno->modif_user_id = auth()->user()->id;
                    $cursoAlumno->update();
                }else{
                    $cursoAlumno->saldo = $cursoAlumno->saldo + $item->monto_pagado;
                    $cursoAlumno->total_descuento = 0;
                    $cursoAlumno->porcentaje_aplicado = 0;
                    $cursoAlumno->estado_id = 1;
                    $cursoAlumno->modif_user_id = auth()->user()->id;
                    $cursoAlumno->update();
                }

            }else{
                $cursoAlumno->certificado_pagado = $cursoAlumno->certificado_pagado - $item->monto_pagado;
                $cursoAlumno->certificado_saldo = $cursoAlumno->certificado_saldo + $item->monto_pagado;
                $cursoAlumno->estado_id = 1;
                $cursoAlumno->modif_user_id = auth()->user()->id;
                $cursoAlumno->update();
            }
        }

        $this->emit('correcto', 'Boleta de recibo anulada con exito.');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->reset('data');
        $this->reset('numero_recibo');
        $this->ver_detalle = 0;
        $fecha_actual = Carbon::now();
        $this->año = date('Y', strtotime($fecha_actual));

    }

}
