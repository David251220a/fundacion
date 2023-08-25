<?php

namespace App\Http\Livewire\ConsultaGeneral;

use App\Models\CursoInAlumno;
use App\Models\CursoIngreso;
use App\Models\FormaPago;
use App\Models\IngresoVarios;
use App\Models\IngresoVariosDetalle;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class InsumoDeuda extends Component
{
    public $search, $cursoInAlumno, $valor_id = 0, $ingreso, $documento_modal, $nombre_modal, $forma_pago_id, $forma_pago;
    public $nombre_id, $curso_precio, $total_pagar_modal, $comprobante, $total_saldo;
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $rules = [
        'comprobante' => 'image|mimes:jpeg,png,jpg,gif'
    ];

    protected $listeners = ['exonerar_insumo'];

    public function mount()
    {
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = $this->forma_pago[0]->id;
        $this->nombre_id = 'recibo_insumo_cobro';
    }

    public function render()
    {
        $fecha = Carbon::now();
        $fecha_actual = date('Y-m-d', strtotime($fecha));
        $this->total_saldo = 0;

        if(empty($this->search)){
            $data = CursoIngreso::join('curso_in_alumnos', 'curso_ingresos.id', '=', 'curso_in_alumnos.curso_ingreso_id')
            ->join('alumnos', 'curso_in_alumnos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('curso_in_alumnos.estado_id', 1)
            ->where('curso_in_alumnos.saldo', '>', 0)
            ->where('curso_ingresos.fecha', '<=', $fecha_actual)
            ->select('curso_in_alumnos.*', 'curso_ingresos.fecha', 'curso_ingresos.curso_habilitado_id', 'personas.documento', 'personas.nombre', 'personas.apellido')
            ->orderBy('personas.documento', 'ASC')
            ->orderBy('curso_ingresos.fecha', 'ASC')
            ->paginate(15);

            $aux = CursoIngreso::join('curso_in_alumnos', 'curso_ingresos.id', '=', 'curso_in_alumnos.curso_ingreso_id')
            ->join('alumnos', 'curso_in_alumnos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('curso_in_alumnos.estado_id', 1)
            ->where('curso_in_alumnos.saldo', '>', 0)
            ->where('curso_ingresos.fecha', '<=', $fecha_actual)
            ->select('curso_in_alumnos.*', 'curso_ingresos.fecha', 'curso_ingresos.curso_habilitado_id', 'personas.documento', 'personas.nombre', 'personas.apellido')
            ->orderBy('personas.documento', 'ASC')
            ->orderBy('curso_ingresos.fecha', 'ASC')
            ->get();
        }else{
            $data = CursoIngreso::join('curso_in_alumnos', 'curso_ingresos.id', '=', 'curso_in_alumnos.curso_ingreso_id')
            ->join('alumnos', 'curso_in_alumnos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('curso_in_alumnos.estado_id', 1)
            ->where('curso_in_alumnos.saldo', '>', 0)
            ->where('curso_ingresos.fecha', '<=', $fecha_actual)
            ->where('personas.documento', str_replace('.', '', $this->search))
            ->select('curso_in_alumnos.*', 'curso_ingresos.fecha', 'curso_ingresos.curso_habilitado_id', 'personas.documento', 'personas.nombre', 'personas.apellido')
            ->orderBy('personas.documento', 'ASC')
            ->orderBy('curso_ingresos.fecha', 'ASC')
            ->paginate(15);

            $aux = CursoIngreso::join('curso_in_alumnos', 'curso_ingresos.id', '=', 'curso_in_alumnos.curso_ingreso_id')
            ->join('alumnos', 'curso_in_alumnos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('curso_in_alumnos.estado_id', 1)
            ->where('curso_in_alumnos.saldo', '>', 0)
            ->where('curso_ingresos.fecha', '<=', $fecha_actual)
            ->where('personas.documento', str_replace('.', '', $this->search))
            ->select('curso_in_alumnos.*', 'curso_ingresos.fecha', 'curso_ingresos.curso_habilitado_id', 'personas.documento', 'personas.nombre', 'personas.apellido')
            ->orderBy('personas.documento', 'ASC')
            ->orderBy('curso_ingresos.fecha', 'ASC')
            ->get();
        }

        foreach ($aux as $item) {
            if (count($item->cursoHabilitado->alumnos_cursando->where('alumno_id', $item->alumno_id)->whereIn('curso_a_estado_id', [1, 2, 3, 7])) > 0){
                $this->total_saldo += $item->saldo;
            }
        }

        $this->total_saldo = number_format($this->total_saldo, 0, ".", ".");

        return view('livewire.consulta-general.insumo-deuda', compact('data'));
    }

    public function detalle_insumo(CursoInAlumno $cursoInAlumno)
    {
        $this->cursoInAlumno = $cursoInAlumno;
        $this->curso_precio = number_format($cursoInAlumno->saldo, 0, ".", ".");
        $this->total_pagar_modal = $this->curso_precio;
        $this->documento_modal = number_format($cursoInAlumno->alumno->persona->documento, 0, ".", ".");
        $this->nombre_modal = $cursoInAlumno->alumno->persona->nombre . ' ' . $cursoInAlumno->alumno->persona->apellido;
    }

    public function buscar_insumo(){
        $this->render();
    }

    public function cobrar()
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

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoVarios::where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo += 1;

        $cursoInAlumno = $this->cursoInAlumno;
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
            'total_pagado' => $total,
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
            'monto_pagado' => $total,
            'saldo' => $ingreso_Curso->precio - $total,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $cursoInAlumno->total_pagado = $cursoInAlumno->total_pagado + $total;
        $cursoInAlumno->saldo = $cursoInAlumno->saldo - $total;
        $cursoInAlumno->update();

        $this->ingreso = $ingreso;
        $this->valor_id = $ingreso->id;
        $this->emit('reporte_insumo', 'recibo');
    }

    public function exonerar_insumo(CursoInAlumno $cursoInAlumno)
    {
        $cursoInAlumno->exoneracion = 1;
        $cursoInAlumno->saldo = 0;
        $cursoInAlumno->modif_user_id = auth()->user()->id;
        $cursoInAlumno->update();
        $this->emit('correcto', 'Exonerado con exito.');
    }

    public function resetUI()
    {
        $this->reset('cursoInAlumno');
        $this->reset('documento_modal');
        $this->reset('nombre_modal');
        $this->reset('curso_precio');
        $this->reset('total_pagar_modal');
        $this->reset('ingreso');
        $this->reset('comprobante');
        $this->valor_id = 0;
        $this->forma_pago_id = $this->forma_pago[0]->id;

    }
}
