<?php

namespace App\Http\Livewire\IngresoMatricula;

use App\Models\Curso;
use App\Models\CursoAlumno;
use App\Models\FormaPago;
use App\Models\IngresoMatricula;
use App\Models\Persona;
use App\Models\TipoCurso;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class IngresoIndex extends Component
{
    public $fecha_actual, $fecha_hasta, $curso_id, $tipo_curso_id, $documento, $caso, $recibo, $ingreso;
    public $ver_recibo, $ver_documento, $ver_fecha, $ver_familia, $ver_curso, $valor_id = 0, $total_general = 0;
    public $aux_familia, $aux_familia_id, $aux_curso, $aux_curso_id, $forma_pago, $forma_pago_id;
    public $desde, $hasta;

    protected $listeners = ['render', 'filtro', 'ver_recibo', 'anular', 'actualizar_curso'];
    protected $paginationTheme = 'bootstrap';

    use WithPagination;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function mount()
    {
        $fecha_actual = Carbon::now();
        $this->fecha_actual = date('Y-m-d', strtotime($fecha_actual));
        $this->fecha_hasta = date('Y-m-d', strtotime($fecha_actual));
        $this->caso = 1;
        $this->ver_recibo = 'none';
        $this->ver_documento = 'none';
        $this->ver_familia = 'none';
        $this->ver_curso = 'none';
        $this->ver_fecha = 'block';
        $this->cargar_familia();
        $this->cargar_curso();
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = 999;
        $this->rango_saber();
    }

    public function render()
    {

        $this->rango_saber();

        if($this->caso == 1){
            // dd($this->desde, $this->hasta);
            $data = $this->datos_fecha();
        }

        if($this->caso == 2){
            $data = $this->datos_recibo();
        }

        if($this->caso == 3){
            $data = $this->datos_documentos();
        }

        if($this->caso == 4){
            $data = $this->datos_familia();
        }

        if($this->caso == 5){
            $data = $this->datos_curso();
        }


        return view('livewire.ingreso-matricula.ingreso-index', compact('data'));
    }

    public function cargar_familia()
    {
        $this->aux_familia = TipoCurso::all();
        $this->aux_familia_id = $this->aux_familia[0]->id;
    }

    public function cargar_curso()
    {
        $this->aux_curso = Curso::where('tipo_curso_id', $this->aux_familia_id)
        ->get();
        if(count($this->aux_curso) > 0){
            $this->aux_curso_id = $this->aux_curso[0]->id;
        }else{
            $this->aux_curso_id = 0;
        }
    }

    public function datos_fecha()
    {
        $fecha = date('Y-m-d', strtotime($this->fecha_actual));
        $fecha_hasta = date('Y-m-d', strtotime($this->fecha_hasta));
        $data = IngresoMatricula::whereBetween('fecha_ingreso', [$fecha, $fecha_hasta])
        ->whereBetween('forma_pago_id', [$this->desde, $this->hasta])
        ->where('estado_id', 1)
        ->orderBy('fecha_ingreso', 'DESC')
        ->paginate(50);

        $suma = IngresoMatricula::whereBetween('fecha_ingreso', [$fecha, $fecha_hasta])
        ->whereBetween('forma_pago_id', [$this->desde, $this->hasta])
        ->where('estado_id', 1)
        ->orderBy('fecha_ingreso', 'DESC')
        ->sum('total_pagado');

        $this->total_general = $suma;

        return $data;
    }

    public function datos_familia()
    {
        $fecha = date('Y-m-d', strtotime($this->fecha_actual));
        $fecha_hasta = date('Y-m-d', strtotime($this->fecha_hasta));

        $data = IngresoMatricula::join('ingreso_matricula_detalles AS a', 'ingreso_matriculas.id', '=', 'a.ingreso_matricula_id')
        ->join('curso_habilitados AS b', 'a.curso_habilitado_id', '=', 'b.id')
        ->select('ingreso_matriculas.*')
        ->whereBetween('ingreso_matriculas.fecha_ingreso', [$fecha, $fecha_hasta])
        ->whereBetween('ingreso_matriculas.forma_pago_id', [$this->desde, $this->hasta])
        ->where('ingreso_matriculas.estado_id', 1)
        ->where('b.tipo_curso_id', $this->aux_familia_id)
        ->orderBy('ingreso_matriculas.created_at', 'DESC')
        ->paginate(50);

        $suma = IngresoMatricula::join('ingreso_matricula_detalles AS a', 'ingreso_matriculas.id', '=', 'a.ingreso_matricula_id')
        ->join('curso_habilitados AS b', 'a.curso_habilitado_id', '=', 'b.id')
        ->select('ingreso_matriculas.*')
        ->whereBetween('ingreso_matriculas.fecha_ingreso', [$fecha, $fecha_hasta])
        ->whereBetween('ingreso_matriculas.forma_pago_id', [$this->desde, $this->hasta])
        ->where('ingreso_matriculas.estado_id', 1)
        ->where('b.tipo_curso_id', $this->aux_familia_id)
        ->orderBy('ingreso_matriculas.created_at', 'DESC')
        ->sum('total_pagado');

        $this->total_general = $suma;

        return $data;
    }

    public function datos_curso()
    {
        $fecha = date('Y-m-d', strtotime($this->fecha_actual));
        $fecha_hasta = date('Y-m-d', strtotime($this->fecha_hasta));
        $data = IngresoMatricula::join('ingreso_matricula_detalles AS a', 'ingreso_matriculas.id', '=', 'a.ingreso_matricula_id')
        ->join('curso_habilitados AS b', 'a.curso_habilitado_id', '=', 'b.id')
        ->select('ingreso_matriculas.*')
        ->whereBetween('ingreso_matriculas.fecha_ingreso', [$fecha, $fecha_hasta])
        ->whereBetween('ingreso_matriculas.forma_pago_id', [$this->desde, $this->hasta])
        ->where('ingreso_matriculas.estado_id', 1)
        ->where('b.curso_id', $this->aux_curso_id)
        ->orderBy('ingreso_matriculas.created_at', 'DESC')
        ->paginate(50);

        $suma = IngresoMatricula::join('ingreso_matricula_detalles AS a', 'ingreso_matriculas.id', '=', 'a.ingreso_matricula_id')
        ->join('curso_habilitados AS b', 'a.curso_habilitado_id', '=', 'b.id')
        ->select('ingreso_matriculas.*')
        ->whereBetween('ingreso_matriculas.fecha_ingreso', [$fecha, $fecha_hasta])
        ->whereBetween('ingreso_matriculas.forma_pago_id', [$this->desde, $this->hasta])
        ->where('ingreso_matriculas.estado_id', 1)
        ->where('b.curso_id', $this->aux_curso_id)
        ->orderBy('ingreso_matriculas.created_at', 'DESC')
        ->sum('total_pagado');

        $this->total_general = $suma;

        return $data;
    }

    public function datos_recibo()
    {
        $data = IngresoMatricula::where('numero_recibo', $this->recibo)
        ->where('estado_id', 1)
        ->whereBetween('forma_pago_id', [$this->desde, $this->hasta])
        ->paginate(50);

        $suma = IngresoMatricula::where('numero_recibo', $this->recibo)
        ->where('estado_id', 1)
        ->whereBetween('forma_pago_id', [$this->desde, $this->hasta])
        ->sum('total_pagado');

        $this->total_general = $suma;

        return $data;
    }

    public function datos_documentos()
    {
        $documento = str_replace('.', '', $this->documento);
        $persona = Persona::where('documento', $documento)->first();
        if(!(empty($persona))){
            $alumno_id = $persona->alumno->id;
        }else{
            $alumno_id = null;
        }

        $data = IngresoMatricula::where('alumno_id', $alumno_id)
        ->where('estado_id', 1)
        ->whereBetween('forma_pago_id', [$this->desde, $this->hasta])
        ->paginate(50);

        $suma = IngresoMatricula::where('alumno_id', $alumno_id)
        ->whereBetween('forma_pago_id', [$this->desde, $this->hasta])
        ->where('estado_id', 1)
        ->sum('total_pagado');

        $this->total_general = $suma;

        return $data;
    }

    public function filtro($id)
    {
        $this->caso = $id;

        if($id == 1){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'none';
            $this->ver_familia = 'none';
            $this->ver_curso = 'none';
        }

        if($id == 2){
            $this->ver_fecha = 'none';
            $this->ver_recibo = 'block';
            $this->ver_documento = 'none';
            $this->ver_familia = 'none';
            $this->ver_curso = 'none';
        }

        if($id == 3){
            $this->ver_fecha = 'none';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'block';
            $this->ver_familia = 'none';
            $this->ver_curso = 'none';
        }

        if($id == 4){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'none';
            $this->ver_familia = 'block';
            $this->ver_curso = 'none';
        }

        if($id == 5){
            $this->ver_fecha = 'block';
            $this->ver_recibo = 'none';
            $this->ver_documento = 'none';
            $this->ver_familia = 'block';
            $this->ver_curso = 'block';
        }
    }

    public function ver_recibo($ingreso_id)
    {
        $this->ingreso = IngresoMatricula::find($ingreso_id);
        $this->valor_id = $this->ingreso->id;
    }

    public function anular($ingreso_id)
    {
        $ingreso = IngresoMatricula::find($ingreso_id);
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
                $cursoAlumno->saldo = $cursoAlumno->saldo + $item->monto_pagado;
                $cursoAlumno->estado_id = 1;
                $cursoAlumno->modif_user_id = auth()->user()->id;
                $cursoAlumno->update();
            }else{
                $cursoAlumno->certificado_pagado = $cursoAlumno->certificado_pagado - $item->monto_pagado;
                $cursoAlumno->certificado_saldo = $cursoAlumno->certificado_saldo + $item->monto_pagado;
                $cursoAlumno->estado_id = 1;
                $cursoAlumno->modif_user_id = auth()->user()->id;
                $cursoAlumno->update();
            }
        }

        $this->resetUI();
        $this->render();
    }

    public function actualizar_curso()
    {
        $this->cargar_curso();
    }

    public function rango_saber()
    {
        if($this->forma_pago_id == 999){
            $this->desde = 1;
            $this->hasta = 999;
        }else{
            $this->desde = $this->forma_pago_id;
            $this->hasta = $this->forma_pago_id;
        }

    }

    public function resetUI()
    {
        $this->reset('ingreso');
    }


}
