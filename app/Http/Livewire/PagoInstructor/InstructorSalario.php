<?php

namespace App\Http\Livewire\PagoInstructor;

use App\Models\CursoHabilitado;
use App\Models\FormaPago;
use App\Models\Pago;
use App\Models\PagoInstructor;
use App\Models\SalarioInstructor;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class InstructorSalario extends Component
{

    public $titulo, $instructor, $salario = [], $curso, $reporte_id = 0, $pago, $anticipo_detalle = [];
    public $codigo = 0, $concepto_id = [], $monto_concepto = [], $descripcion_concepto = [], $neto=0, $neto_salario=0, $egreso=0;
    public $e_concepto_id = [], $e_monto_concepto = [], $e_descripcion_concepto = [], $monto_anticipo = 0, $forma_pago, $forma_pago_id = 1;

    use WithPagination;

    protected $listeners = ['datos', 'datos_anticipo'];

    public function mount()
    {
        $this->titulo = 'Editar Salario';
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = $this->forma_pago[0]->id;
    }

    protected $paginationTheme = 'bootstrap';

    public function render()
    {

        // $cursos = CursoHabilitado::where('concluido', 0)
        // ->where('instructor_id', '>', 1)
        // ->where('estado_id', 1)
        // ->paginate(20);

        $cursos = SalarioInstructor::where('salario_concepto_id', 1)
        ->where('concluido', 0)
        ->where('estado_id', 1)
        ->where('procesado', 0)
        ->paginate(20);

        return view('livewire.pago-instructor.instructor-salario', compact('cursos'));
    }

    public function datos($curso_habilitado_id)
    {
        $this->codigo = 1;
        $this->cambiar_titulo();
        $this->curso = CursoHabilitado::find($curso_habilitado_id);
        $this->instructor = $this->curso->instructor;
        $salario = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('estado_id', 1)
        ->where('importe','>', 0)
        ->get();

        $this->anticipo_detalle = PagoInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('salario_concepto_id', 2)
        ->where('estado_id', 1)
        ->take(5)
        ->get();

        if(count($salario) <= 0){
            SalarioInstructor::create([
                'instructor_id' => $this->instructor->id,
                'curso_habilitado_id' => $this->curso->id,
                'forma_pago_id' => 1,
                'salario_concepto_id' => 1,
                'importe' => 1,
                'tipo' => 1,
                'concluido' => 0,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $this->salario = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('estado_id', 1)
        ->where('importe','>', 0)
        ->get();

        foreach($this->salario AS $item){
            if ($item->concepto->tipo == 1){
                $this->concepto_id[] = $item->salario_concepto_id;
                $this->monto_concepto[] = number_format($item->importe, 0, ".", ".");
                $this->descripcion_concepto[] = $item->concepto->descripcion;
                $this->neto = $this->neto + $item->importe;
            }

            if ($item->concepto->tipo == 2){
                $this->e_concepto_id[] = $item->id;
                $this->e_monto_concepto[] = number_format($item->importe, 0, ".", ".");
                $this->e_descripcion_concepto[] = $item->concepto->descripcion;
                $this->neto = $this->neto - $item->importe;
            }
        }

        $this->neto = number_format($this->neto, 0, ".", ".");
    }

    public function datos_anticipo($curso_habilitado_id)
    {
        $this->codigo = 0;
        $this->cambiar_titulo();
        $this->curso = CursoHabilitado::find($curso_habilitado_id);
        $this->instructor = $this->curso->instructor;

        $salario = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('estado_id', 1)
        ->where('importe','>', 0)
        ->get();

        if(count($salario) <= 0){
            SalarioInstructor::create([
                'instructor_id' => $this->instructor->id,
                'curso_habilitado_id' => $this->curso->id,
                'forma_pago_id' => 1,
                'salario_concepto_id' => 1,
                'importe' => 1,
                'tipo' => 1,
                'concluido' => 0,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $this->salario = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('estado_id', 1)
        ->where('importe','>', 0)
        ->get();

        $this->neto_salario = number_format($this->salario->where('tipo', 1)->sum('importe'), 0, ".", ".");
        $this->egreso = number_format($this->salario->where('tipo', 2)->sum('importe'), 0, ".", ".");
        $this->neto = number_format($this->salario->where('tipo', 1)->sum('importe') - $this->salario->where('tipo', 2)->sum('importe') , 0, ".", ".");


    }

    public function update()
    {
        for ($i=0; $i < count($this->concepto_id); $i++) {

            if($this->concepto_id[$i] == 1){
                if($this->monto_concepto[$i] == 0){
                    $this->emit('mensaje_error', 'El importe de remuneracion no puede ser cero.');
                    $this->resetUI();
                    return false;
                }

                if(empty($this->monto_concepto[$i])){
                    $this->emit('mensaje_error', 'El importe de remuneracion no puede ser vacio.');
                    $this->resetUI();
                    return false;
                }
            }

            $salario = SalarioInstructor::where('instructor_id', $this->instructor->id)
            ->where('curso_habilitado_id', $this->curso->id)
            ->where('salario_concepto_id', $this->concepto_id[$i])
            ->first();

            $salario->importe = str_replace('.', '', $this->monto_concepto[$i]);
            $salario->update();
        }

        $this->emit('correcto', 'Salario actualizado con exito.');
        $this->resetUI();
    }

    public function save()
    {
        $anticipo = str_replace('.', '', $this->monto_anticipo);
        if($anticipo == 0){
            $this->emit('mensaje_error', 'El monto del anticpo no puede ser cero.');
            $this->resetUI();
            return false;
        }

        if(empty($anticipo)){
            $this->emit('mensaje_error', 'El monto del anticipo no puede ser vacio.');
            $this->resetUI();
            return false;
        }

        $neto = str_replace('.', '', $this->neto);
        if($neto <= 0){
            $this->emit('mensaje_error', 'No puedo solicitar un anticipo.');
            $this->resetUI();
            return false;
        }

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = Pago::where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo = $numero_recibo + 1;

        $pago = Pago::create([
            'pago_tipo_id' => 6,
            'fecha' => $fecha_actual,
            'mes' => $mes,
            'año' => $anio,
            'importe' => $anticipo,
            'forma_pago_id' => $this->forma_pago_id,
            'procesado' => 0,
            'sucursal' => '0000',
            'general' => '0000',
            'factura_numero' => 0,
            'numero_recibo' => $numero_recibo,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $pago->pago_instructor()->create([
            'instructor_id' => $this->instructor->id,
            'curso_habilitado_id' => $this->curso->id,
            'salario_concepto_id' => 2,
            'importe' => $anticipo,
            'tipo' => 2,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $aux_existe = SalarioInstructor::where('instructor_id', $this->instructor->id)
        ->where('curso_habilitado_id', $this->curso->id)
        ->where('salario_concepto_id', 2)
        ->first();

        if(empty($aux_existe)){
            SalarioInstructor::create([
                'instructor_id' => $this->instructor->id,
                'curso_habilitado_id' => $this->curso->id,
                'forma_pago_id' => 1,
                'salario_concepto_id' => 2,
                'importe' => $anticipo,
                'concluido' => 0,
                'tipo' => 2,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }else{
            $aux_existe->importe = $aux_existe->importe + $anticipo;
            $aux_existe->modif_user_id = auth()->user()->id;
            $aux_existe->update();
        }

        $this->reporte_id = $pago->id;
        $this->pago = $pago;
        $this->emit('reporte', 'Se cargo con exito el anticipo.');
    }

    public function cambiar_titulo()
    {
        if($this->codigo == 0){
            $this->titulo = 'Agregar Anticipo';
        }

        if($this->codigo == 1){
            $this->titulo = 'Editar Salario';
        }

    }

    public function resetUI()
    {
        $this->reset('curso');
        $this->reset('instructor');
        $this->reset('salario');
        $this->reset('concepto_id');
        $this->reset('monto_concepto');
        $this->anticipo_detalle = [];
        $this->reset('descripcion_concepto');
        $this->reset('e_concepto_id');
        $this->reset('e_monto_concepto');
        $this->reset('e_descripcion_concepto');
        $this->reset('pago');
        $this->codigo = 0;
        $this->egreso = 0;
        $this->reporte_id = 0;

        $this->neto = 0;
        $this->neto_salario = 0;
        $this->monto_anticipo = 0;
        $this->forma_pago_id = 1;
        $this->cambiar_titulo();
        $this->emit('reloadClassCSs');

    }
}
