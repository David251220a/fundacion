<?php

namespace App\Http\Livewire\Habilitado;

use App\Models\Asistencia;
use App\Models\CursoHabilitado;
use App\Models\CursoInAlumno;
use App\Models\CursoIngreso;
use App\Models\FormaPago;
use App\Models\IngresoConcepto;
use App\Models\IngresoVarios;
use App\Models\IngresoVariosDetalle;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListadoInsumo extends Component
{

    public $curso_id, $curso_precio = 0, $saldos = 1, $cursoHabilitado, $insumos;
    public $insumo_id, $descripcion, $precio = 0, $fecha, $ingreso, $valor_id = 0;
    public $nombre_modal, $forma_pago, $forma_pago_id, $comprobante, $total_pagar_modal = 0, $documento_modal, $cursoAIngreso=0;

    use WithFileUploads;

    protected $listeners = ['datos_insumo'];

    public function mount(CursoHabilitado $cursoHabilitado)
    {
        $this->cursoHabilitado = $cursoHabilitado;
        $this->curso_id = $cursoHabilitado->id;
        $this->saldos = 1;
        $fecha_actual = Carbon::now();
        $this->fecha = (date('Y-m-d', strtotime($fecha_actual)));
        $this->insumos = IngresoConcepto::where('estado_id', 1)->where('tipo', 2)->get();
        $this->insumo_id = $this->insumos[0]->id;
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = $this->forma_pago[0]->id;
    }

    public function render()
    {
        $alumnos = $this->cursoHabilitado->alumnos_cursando;
        return view('livewire.habilitado.listado-insumo', compact('alumnos'));
    }

    public function save()
    {

        $this->validate([
            'fecha' => 'required',
            'precio' => 'required'
        ]);

        $fecha = $this->fecha;
        $fecha_fin = $this->cursoHabilitado->periodo_hasta;
        $fecha_actual = Carbon::now();
        $fecha_actual = date('Y-m-d', strtotime($fecha_actual));

        // VALIDAD SI LA FECHA ES MAYOR A LA FECHA FIN DE CURSO
        if($fecha > $fecha_fin){
            $this->resetUI();
            $this->emit('validacion', 'La fecha ingresada supera la fecha final del curso.');
            return false;
        }
        // VALIDA SI LA FECHA ES MENOR A LA FECHA DE INICIO DE CURSO
        if($fecha < $this->cursoHabilitado->periodo_desde){
            $this->resetUI();
            $this->emit('validacion', 'La fecha ingresada es menor a la fecha de inicio de curso.');
            return false;
        }
        // VALIDAD QUE LA FECHA SEA MENOR A LA FECHA ACTUAL

        // if(!($fecha_actual == $fecha)){
            if($fecha_actual > $fecha){
                $this->resetUI();
                $this->emit('validacion', 'La fecha no debe ser menor a la fecha actual.');
                return false;
            }
        // }


        if(str_replace('.', '', $this->precio) == 0){
            $this->resetUI();
            $this->emit('validacion', 'El precio no puede ser 0');
            return false;
        }

        $dias['0'] = ($this->cursoHabilitado->domingo == 1 ? '1' : 0);
        $dias['1'] = ($this->cursoHabilitado->lunes == 1 ? '2' : 0);
        $dias['2'] = ($this->cursoHabilitado->martes == 1 ? '3' : 0);
        $dias['3'] = ($this->cursoHabilitado->miercoles == 1 ? '4' : 0);
        $dias['4'] = ($this->cursoHabilitado->jueves == 1 ? '5' : 0);
        $dias['5'] = ($this->cursoHabilitado->viernes == 1 ? '6' : 0);
        $dias['6'] = ($this->cursoHabilitado->sabado == 1 ? '7' : 0);
        $dia = $this->saber_dia($fecha);
        $llama_asistencia = 0;

        for ($i=0; $i < 7; $i++) {
            if($dias[$i] == $dia['dia']){
                $llama_asistencia = 1;
            }
        }

        if($llama_asistencia === 0){
            $this->resetUI();
            $this->emit('validacion', 'Esta fecha no corresponde al dia que se deba de tener una clase.');
            return false;
        }

        // VALIDA SI YA HAY DEUPLICACION DE CLASE Y DIA
        $exite_insumo = CursoIngreso::where('fecha', $fecha)
        ->where('curso_habilitado_id', $this->cursoHabilitado->id)
        ->where('estado_id', 1)
        ->first();

        if(!(empty($exites_clase))){
            $aux = date('d/m/Y', strtotime($this->fecha));
            $this->resetUI();
            $this->emit('validacion', 'Ya se cargo un insumo para esta fecha: ' . $aux .'.');
            return false;
        }

        $clase = Asistencia::where('curso_habilitado_id', $this->cursoHabilitado->id)
        ->where('estado_id', 1)
        ->where('asistencia_motivo_id', 1)
        ->where('fecha_asistencia', '<=', $fecha)
        ->count();

        $clase = $clase + 1;

        $insumo = CursoIngreso::create([
            'curso_habilitado_id' => $this->cursoHabilitado->id,
            'ingreso_concepto_id' => $this->insumo_id,
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
            'utilizado' => 0,
            'clase' => $clase,
            'precio' => str_replace('.', '', $this->precio),
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $alumnos = $this->cursoHabilitado->alumnos_cursando;
        foreach ($alumnos as $item) {
            CursoInAlumno::create([
                'curso_ingreso_id' => $insumo->id,
                'alumno_id' => $item->alumno_id,
                'total_pagar' => str_replace('.', '', $this->precio),
                'total_pagado' => 0,
                'saldo' => str_replace('.', '', $this->precio),
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $this->resetUI();
        $this->emit('confirma_ingreso', 'Se añadido insumo para la clase en fecha.');
    }

    public function datos_insumo($id)
    {
        $cursoIngreso = CursoInAlumno::find($id);
        $this->cursoAIngreso = $cursoIngreso->id;
        $this->curso_precio = number_format($cursoIngreso->saldo, 0, ".", ".");
        $this->total_pagar_modal = $this->curso_precio;
        $this->nombre_modal = $cursoIngreso->alumno->persona->nombre . ' ' . $cursoIngreso->alumno->persona->apellido;
        $this->documento_modal = $cursoIngreso->alumno->persona->documento;

    }


    public function cobrar()
    {
        if($this->comprobante){
            $filePath = $this->comprobante->store('public/comprobante');
            $this->validate([
                'total_pagar_modal' => 'required',
                'comprobante' => 'image|mimes:jpeg,png,jpg,gif'
            ]);
        }else{
            $filePath = '';
            $this->validate([
                'total_pagar_modal' => 'required',
            ]);
        }

        $total_pagar = str_replace('.', '', $this->total_pagar_modal);

        if($total_pagar == 0){
            $this->emit('validacion', 'El total a pagar no pueder ser 0.');
            $this->resetUI();

            return false;
        }

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoVarios::where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo += 1;

        $cursoInAlumno = CursoInAlumno::find($this->cursoAIngreso);
        $ingreso_Curso = CursoIngreso::find($cursoInAlumno->curso_ingreso_id);

        // INGRESA LA CABEZERA DE INGRESO VARIOS
        $ingreso = IngresoVarios::create([
            'persona_id' => $cursoInAlumno->alumno->persona->id,
            'forma_pago_id' => $this->forma_pago_id,
            'fecha_ingreso' => $fecha_actual,
            'mes' => $mes,
            'año' => $anio,
            'numero_recibo' => $numero_recibo,
            'sucursal' => '000',
            'general' => '000',
            'factura_numero' => '0000000',
            'total_pagado' => $total_pagar,
            'comprobante' => '',
            'cuenta_padre' => 0,
            'tipo_curso_id' => $ingreso_Curso->cursoHabilitado->tipo_curso_id,
            'curso_id' => $ingreso_Curso->cursoHabilitado->curso_id,
            'curso_habilitado_id' => $ingreso_Curso->curso_habilitado_id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);
        // INGRESA EL DETALLE DE INGRESO VARIOS
        $ingreso_detalle = IngresoVariosDetalle::create([
            'persona_id' => $cursoInAlumno->alumno->persona->id,
            'ingreso_vario_id' => $ingreso->id,
            'ingreso_concepto_id' => $ingreso_Curso->ingreso_concepto_id,
            'descripcion' => $ingreso_Curso->descripcion,
            'precio_unitario' => $ingreso_Curso->precio,
            'cantidad' => 1,
            'total_pagar' => $ingreso_Curso->precio,
            'monto_pagado' => $total_pagar,
            'saldo' => $ingreso_Curso->precio - $total_pagar,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $cursoInAlumno->total_pagado = $cursoInAlumno->total_pagado + $total_pagar;
        $cursoInAlumno->saldo = $cursoInAlumno->saldo - $total_pagar;
        $cursoInAlumno->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $ingreso->id;
        $this->resetUI();
        $this->emit('cobro_insumo_exitoso', 'Cobro realizado con exito.');

    }

    public function resetUI()
    {
        $this->reset('descripcion');
        $this->reset('nombre_modal');
        $this->reset('documento_modal');
        $this->precio = 0;
        $this->curso_precio = 0;
        $this->total_pagar_modal = 0;
        $this->cursoAIngreso = 0;
        $fecha_actual = Carbon::now();
        $this->fecha = (date('Y-m-d', strtotime($fecha_actual)));
        $this->emit('reloadClassCSs');

    }

    public function saber_dia($t_day)
    {
        $data = [];
        $data['dia'] = 0;
        $data['nombre_dia']="";
        $day = date("l", strtotime($t_day));
        switch ($day) {
            case "Sunday":
                $data['dia'] = 1;
                $data['nombre_dia'] = "Domingo";
                break;
            case "Monday":
                $data['dia'] = 2;
                $data['nombre_dia'] = "Lunes";
                break;
            case "Tuesday":
                $data['dia'] = 3;
                $data['nombre_dia'] = "Martes";
                break;
            case "Wednesday":
                $data['dia'] = 4;
                $data['nombre_dia'] = "Miercoles";
            break;
            case "Thursday":
                $data['dia'] = 5;
                $data['nombre_dia'] = "Jueves";
                break;
            case "Friday":
                $data['dia'] = 6;
                $data['nombre_dia'] = "Viernes";
                break;
            case "Saturday":
                $data['dia'] = 7;
                $data['nombre_dia'] = "Sabado";
            break;
        }

        return $data;

    }
}
