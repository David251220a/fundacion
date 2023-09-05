<?php

namespace App\Http\Livewire\PagoEmpleado;

use App\Models\Empleado;
use App\Models\FormaPago;
use App\Models\Pago;
use App\Models\PagoEmpleado;
use App\Models\Persona;
use App\Models\SalarioEmpleado;
use App\Models\SalarioPago;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class EmpleadoActivo extends Component
{
    public $titulo, $titulo_dos, $buscar_documento, $persona, $nombre, $documento, $apellido, $remuneracion = 0, $celular, $email, $reporte_id = 0, $pago;
    public $salario_pago_id, $estado_id, $salario_pago, $forma_pago, $forma_pago_id, $concepto_ingreso = [], $concepto_egreso= [], $monto_ingreso= [], $monto_egreso= [];
    public $descripcion_ingreso = [], $descripcion_egreso = [], $empleado, $neto_empleado, $anticipo_forma_pago_id, $monto_anticipo = 0;
    public $total_ingreso = 0, $total_egreso = 0, $total_neto = 0, $anticipo_detalle = [];

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['continuar', 'delete'];

    public function mount()
    {
        $this->titulo = 'Buscar Persona';
        $this->salario_pago = SalarioPago::all();
        $this->salario_pago_id = 4;
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = 1;
        $this->anticipo_forma_pago_id = 1;
    }
    public function render()
    {
        $data = Empleado::join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->where('empleados.estado_id', 1)
        ->select('empleados.*', 'personas.documento', 'personas.nombre', 'personas.apellido')
        ->orderBy('personas.documento')
        ->paginate(20);

        $this->totales();
        return view('livewire.pago-empleado.empleado-activo', compact('data'));
    }

    public function continuar()
    {
        $documento = str_replace('.', '', $this->buscar_documento);
        if($documento <= 0){
            $this->emit('mensaje_error', 'El documento de la persona no puede ser cero.');
            $this->resetUI();
            return false;
        }

        if(empty($documento)){
            $this->emit('mensaje_error', 'El documento de la persona no ser vacio.');
            $this->resetUI();
            return false;
        }

        $aux = Persona::where('documento', $documento)->first();
        $this->documento = number_format($documento, 0, ".", ".");
        if(!(empty($aux))){

            $this->nombre = $aux->nombre;
            $this->apellido = $aux->apellido;
            $this->celular = $aux->celular;
            $this->email = $aux->email;
            $this->remuneracion = 0;
            $this->persona = $aux;

            $emple = Empleado::where('persona_id', $aux->id)->first();
            if (!(empty($emple))) {
                $this->emit('mensaje_error', 'Esta persona ya existe en la empleado. Revise en "Empleado Inactivo" si no lo encuentra.');
                $this->resetUI();
                return false;
            }

        }
        $this->titulo_dos = 'Agregar Empleado';

        $this->emit('añadir_empleado', 'Añade o crear persona');


    }

    public function totales()
    {
        $data = Empleado::where('estado_id', 1)
        ->get();
        $ingreso = 0;
        $egreso = 0;
        foreach ($data as $item) {
            $ingreso += $item->ingreso->where('salario_concepto_id', 1)->sum('importe');
            $egreso += $item->egreso->sum('importe');
        }

        $this->total_ingreso = number_format($ingreso, 0, ".", ".");
        $this->total_egreso = number_format($egreso, 0, ".", ".");
        $this->total_neto = number_format($ingreso - $egreso, 0, ".", ".");
    }

    public function edit($id)
    {
        $this->empleado = Empleado::find($id);

        $this->documento = number_format($this->empleado->persona->documento, 0, ".", ".");
        $this->nombre = $this->empleado->persona->nombre;
        $this->apellido = $this->empleado->persona->apellido;
        $this->salario_pago_id = $this->empleado->salario_pago_id;
        $this->anticipo_detalle = PagoEmpleado::where('salario_concepto_id', 2)
        ->where('estado_id', 1)
        ->where('empleado_id', $this->empleado->id)
        ->take(5)
        ->get();

        foreach($this->empleado->ingreso AS $item){
            $this->concepto_ingreso[] = $item->salario_concepto_id;
            $this->monto_ingreso[] = number_format($item->importe, 0, ".", ".");
            $this->descripcion_ingreso[] = $item->concepto->descripcion;
            $this->neto_empleado = $this->neto_empleado + $item->importe;
        }

        foreach($this->empleado->egreso AS $item){
            $this->concepto_egreso[] = $item->salario_concepto_id;
            $this->monto_egreso[] = number_format($item->importe, 0, ".", ".");
            $this->descripcion_egreso[] = $item->concepto->descripcion;
            $this->neto_empleado = $this->neto_empleado - $item->importe;
        }
    }

    public function update_empleado()
    {
        for ($i=0; $i < count($this->concepto_ingreso) ; $i++) {

            if($this->concepto_ingreso[$i] == 1){
                if($this->monto_ingreso[$i] == 0){
                    $this->emit('mensaje_error', 'El importe de remuneracion no puede ser cero.');
                    $this->resetUI();
                    return false;
                }
            }

            if(empty($this->monto_ingreso[$i])){
                $this->emit('mensaje_error', 'El importe de remuneracion no puede ser vacio.');
                $this->resetUI();
                return false;
            }

            $empleado = Empleado::find($this->empleado->id);
            $empleado->salario_pago_id = $this->salario_pago_id;
            $empleado->modif_user_id = auth()->user()->id;
            $empleado->update();


            $salario = SalarioEmpleado::where('empleado_id', $this->empleado->id)
            ->where('salario_concepto_id', $this->concepto_ingreso[$i])
            ->first();

            $salario->forma_pago_id = $this->forma_pago_id;
            $salario->importe = str_replace('.', '', $this->monto_ingreso[$i]);
            $salario->modif_user_id = auth()->user()->id;
            $salario->update();

        }

        $this->emit('correcto', 'Salario actualizado con exito.');
        $this->resetUI();
    }

    public function save_empleado()
    {
        if(empty($this->persona)){
            if(empty($this->nombre)){
                $this->emit('mensaje_error', 'El nombre del empleado no ser vacio.');
                $this->resetUI();
                return false;
            }

            if(empty($this->apellido)){
                $this->emit('mensaje_error', 'El apellido del empleado no ser vacio.');
                $this->resetUI();
                return false;
            }

            $persona = Persona::create([
                'documento' => str_replace('.', '', $this->documento),
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'direccion' => '',
                'sexo' => 0,
                'celular' => $this->celular,
                'pais_id' => 1,
                'fecha_nacimiento' => '1990-01-01',
                'departamento_id' => 1,
                'ciudad_id' => 1,
                'barrio_id' => 1,
                'email' => $this->email,
                'estado_id' => 1,
                'estado_civil_id' => 1,
                'partido_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);

            $this->persona = $persona;
        }else{
            $persona = Persona::find($this->persona->id);
            $persona->celular = $this->celular;
            $persona->email = $this->email;
            $persona->update();
        }

        if(empty($this->remuneracion)){
            $this->emit('mensaje_error', 'La remuneracion del empleado no pueder ser vacio.');
            $this->resetUI();
            return false;
        }

        $remuneracion = str_replace('.', '', $this->remuneracion);

        if($remuneracion <= 0){
            $this->emit('mensaje_error', 'La remuneracion del empleado no pueder ser vacio.');
            $this->resetUI();
            return false;
        }

        $empleado = Empleado::create([
            'persona_id' => $this->persona->id,
            'salario_pago_id' => $this->salario_pago_id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $salario = SalarioEmpleado::create([
            'empleado_id' => $empleado->id,
            'forma_pago_id' => 1,
            'salario_concepto_id' => 1,
            'importe' => $remuneracion,
            'tipo' => 1,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $this->emit('correcto', 'Se creo con existo al empleado.');
        $this->resetUI();
    }

    public function grabar_anticipo()
    {
        $monto = str_replace('.', '', $this->monto_anticipo);
        if(empty($this->monto_anticipo)){
            $this->emit('mensaje_error', 'El anticipo no puede estar vacio.');
            $this->resetUI();
            return false;
        }

        if($monto == 0){
            $this->emit('mensaje_error', 'El anticipo no puede ser cero.');
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
            'pago_tipo_id' => 5,
            'fecha' => $fecha_actual,
            'mes' => $mes,
            'año' => $anio,
            'importe' => $monto,
            'forma_pago_id' => $this->anticipo_forma_pago_id,
            'procesado' => 0,
            'sucursal' => '0000',
            'general' => '0000',
            'factura_numero' => 0,
            'numero_recibo' => $numero_recibo,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $pago->pago_empleado()->create([
            'empleado_id' => $this->empleado->id,
            'salario_concepto_id' => 2,
            'salario_base' => $this->empleado->salario->sum('importe'),
            'importe' => $monto,
            'tipo' => 2,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $salario = SalarioEmpleado::where('empleado_id', $this->empleado->id)
        ->where('salario_concepto_id', 2)
        ->first();

        if(empty($salario)){
            SalarioEmpleado::create([
                'empleado_id' => $this->empleado->id,
                'salario_concepto_id' => 2,
                'importe' => $monto,
                'tipo' => 2,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }else{
            $salario->importe = $salario->importe + $monto;
            $salario->modif_user_id = auth()->user()->id;
            $salario->update();
        }

        $this->pago = $pago;
        $this->reporte_id = $pago->id;
        $this->emit('reporte', 'Se cargo con exito el anticipo.');

    }


    public function delete($id)
    {
        $empleado = Empleado::find($id);
        $empleado->estado_id = 2;
        $empleado->modif_user_id = auth()->user()->id;
        $empleado->update();

        foreach ($empleado->todos as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $this->emit('correcto', 'Empleado eliminado con exito.');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->reset('buscar_documento');
        $this->reset('persona');
        $this->reset('celular');
        $this->reset('email');
        $this->reset('nombre');
        $this->reset('documento');
        $this->reset('apellido');
        $this->reset('concepto_ingreso');
        $this->reset('monto_ingreso');
        $this->reset('descripcion_ingreso');
        $this->reset('concepto_egreso');
        $this->reset('monto_egreso');
        $this->reset('descripcion_egreso');
        $this->reset('empleado');
        $this->reset('pago');
        $this->reset('anticipo_detalle');
        $this->remuneracion = 0;
        $this->salario_pago_id = 4;
        $this->forma_pago_id = 1;
        $this->neto_empleado = 0;
        $this->anticipo_forma_pago_id = 1;
        $this->monto_anticipo = 0;
        $this->reporte_id = 0;
        $this->totales();
        $this->emit('reloadClassCSs');
    }
}
