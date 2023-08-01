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
    public $s_insumo_id, $s_descripcion, $s_precio = 0, $s_activar= true;
    public $editar_insumo_id, $editar_descripcion, $editar_precio = 0, $editar_fecha, $editar_id = 0, $editar_estado;
    public $descripcion_concepto, $precio_concepto = 0;

    use WithFileUploads;

    protected $listeners = ['datos_insumo', 'datos_clase_insumo', 'cambiar_valor'];

    public function mount(CursoHabilitado $cursoHabilitado)
    {
        $this->cursoHabilitado = $cursoHabilitado;
        $this->curso_id = $cursoHabilitado->id;
        $this->saldos = 1;
        $fecha_actual = Carbon::now();
        $this->fecha = (date('Y-m-d', strtotime($fecha_actual)));
        $this->insumos = IngresoConcepto::where('estado_id', 1)->where('tipo', 2)->get();
        $this->insumo_id = $this->insumos[0]->id;
        $this->precio = number_format($this->insumos[0]->precio, 0, ".", ".");
        $this->s_precio = number_format($this->insumos[0]->precio, 0, ".", ".");
        $this->s_insumo_id = $this->insumos[0]->id;
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = $this->forma_pago[0]->id;
    }

    public function render()
    {
        $alumnos = $this->cursoHabilitado->alumnos_cursando;
        $this->cursoHabilitado = CursoHabilitado::find($this->curso_id);
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

        if(!(empty($exite_insumo))){
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


    public function save_mucho()
    {

        $this->validate([
            's_precio' => 'required'
        ]);

        $this->s_activar= false;

        $fecha_inicial = Carbon::parse($this->cursoHabilitado->periodo_desde);

        if(str_replace('.', '', $this->s_precio) == 0){
            $this->resetUI();
            $this->emit('validacion', 'El precio no puede ser 0');
            return false;
        }

        $aux_fecha_inicial = $fecha_inicial;

        for ($i=1; $i <= 6; $i++) {

            $insumo = CursoIngreso::create([
                'curso_habilitado_id' => $this->cursoHabilitado->id,
                'ingreso_concepto_id' => $this->s_insumo_id,
                'fecha' => $aux_fecha_inicial->format('Y-m-d'),
                'descripcion' => $this->s_descripcion,
                'utilizado' => 0,
                'clase' => $i,
                'precio' => str_replace('.', '', $this->s_precio),
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);

            $alumnos = $this->cursoHabilitado->alumnos_cursando;
            foreach ($alumnos as $item) {
                CursoInAlumno::create([
                    'curso_ingreso_id' => $insumo->id,
                    'alumno_id' => $item->alumno_id,
                    'total_pagar' => str_replace('.', '', $this->s_precio),
                    'total_pagado' => 0,
                    'saldo' => str_replace('.', '', $this->s_precio),
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }

            $nuevo = $aux_fecha_inicial->addWeeks(1);
            $aux_fecha_inicial = $nuevo;
            // dd($fecha_inicial->format('d/m/Y'), $nuevo->format('d/m/Y'));

        }

        $this->resetUI();
        $this->emit('confirma_ingreso', 'Se añadido insumo para las clases siguientes.');
    }

    public function update(CursoIngreso $cursoIngreso)
    {
        $this->validate([
            'editar_fecha' => 'required',
            'editar_precio' => 'required'
        ]);

        if(str_replace('.', '', $this->editar_precio) == 0){
            $this->resetUI();
            $this->emit('validacion', 'El precio no puede ser 0');
            return false;
        }

        $detalle = CursoInAlumno::where('curso_ingreso_id', $cursoIngreso->id)
        ->where('estado_id', 1)
        ->where('total_pagado', '>', '0')
        ->get();

        if($this->editar_estado == 2){
            if(count($detalle)){
                $this->resetUI();
                $this->emit('validacion', 'No puede anular este insumo por que ya hay cobros realizados.');
                return false;
            }else{
                $cursoIngreso->update([
                    'ingreso_concepto_id' => $this->editar_insumo_id,
                    'descripcion' => $this->editar_descripcion,
                    'utilizado' => 0,
                    'precio' => str_replace('.', '', $this->editar_precio),
                    'estado_id' => $this->editar_estado,
                    'modif_user_id' => auth()->user()->id,
                ]);

                foreach ($cursoIngreso->alumnos as $item) {
                    $item->estado_id = 2;
                    $item->update();
                }
            }
        }else{

            if(count($detalle)){
                if(str_replace('.', '', $this->editar_precio) < $cursoIngreso->precio ){
                    $this->resetUI();
                    $this->emit('validacion', 'No puede poner un monto menor al precio inicial por que hay cobros realizados.');
                    return false;
                }
            }

            if(str_replace('.', '', $this->editar_precio) == $cursoIngreso->precio){
                $cursoIngreso->update([
                    'ingreso_concepto_id' => $this->editar_insumo_id,
                    'descripcion' => $this->editar_descripcion,
                    'utilizado' => 0,
                    'precio' => str_replace('.', '', $this->editar_precio),
                    'estado_id' => $this->editar_estado,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }else{

                $cursoIngreso->update([
                    'ingreso_concepto_id' => $this->editar_insumo_id,
                    'descripcion' => $this->editar_descripcion,
                    'utilizado' => 0,
                    'precio' => str_replace('.', '', $this->editar_precio),
                    'estado_id' => $this->editar_estado,
                    'modif_user_id' => auth()->user()->id,
                ]);

                foreach ($cursoIngreso->alumnos as $item) {
                    $item->total_pagar = str_replace('.', '', $this->editar_precio);
                    $item->saldo = str_replace('.', '', $this->editar_precio) - $item->total_pagado;
                    $item->update();
                }
            }

        }


        $this->resetUI();
        $this->emit('confirma_ingreso', 'Se editado insumo correctamente.');
    }

    public function agregar_concepto()
    {
        if(empty($this->descripcion_concepto)){
            $this->resetUI();
            $this->emit('validacion', 'La descripcion de concepto no puede estar vacio.');
            return false;
        }

        $precio = str_replace('.', '', $this->precio_concepto);

        if(empty($this->precio_concepto)){
            $this->resetUI();
            $this->emit('validacion', 'El precio no puede estar vacio.');
            return false;
        }

        if($precio == 0){
            $this->resetUI();
            $this->emit('validacion', 'El precio no puede ser cero.');
            return false;
        }

        IngresoConcepto::create([
            'descripcion' => $this->descripcion_concepto,
            'precio' => str_replace('.', '', $this->precio_concepto),
            'tipo' => 2,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);
        $this->insumos = IngresoConcepto::where('estado_id', 1)->where('tipo', 2)->get();
        $this->resetUI();
        $this->emit('confirma_ingreso', 'Se agregado concepto insumo correctamente.');
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

    public function datos_clase_insumo($id)
    {
        $insumo = CursoIngreso::find($id);
        $this->editar_descripcion = $insumo->descripcion;
        $this->editar_insumo_id = $insumo->ingreso_concepto_id;
        $this->editar_precio = number_format($insumo->precio, 0, ".", ".");
        $this->editar_fecha = $insumo->fecha;
        $this->editar_id = $insumo->id;
        $this->editar_estado = $insumo->estado_id;
    }

    public function cambiar_valor($id)
    {
        $concepto = IngresoConcepto::find($id);
        $this->precio = number_format($concepto->precio, 0, ".", ".");
        $this->s_precio = number_format($concepto->precio, 0, ".", ".");
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
            'curso_ingreso_id' => $ingreso_Curso->id,
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
        $this->reset('s_descripcion');
        $this->reset('nombre_modal');
        $this->reset('documento_modal');
        $this->reset('editar_estado');
        $this->reset('editar_descripcion');
        $this->reset('editar_fecha');
        $this->reset('editar_id');
        $this->reset('descripcion_concepto');
        $this->precio_concepto = 0;
        $this->editar_precio = 0;
        $this->curso_precio = 0;
        $this->total_pagar_modal = 0;
        $this->cursoAIngreso = 0;
        $this->insumo_id = $this->insumos[0]->id;
        $this->s_insumo_id = $this->insumos[0]->id;
        $this->precio = number_format($this->insumos[0]->precio, 0, ".", ".");
        $this->s_precio = number_format($this->insumos[0]->precio, 0, ".", ".");
        $this->editar_insumo_id = $this->insumos[0]->id;
        $fecha_actual = Carbon::now();
        $this->fecha = (date('Y-m-d', strtotime($fecha_actual)));
        $this->s_activar= true;
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
