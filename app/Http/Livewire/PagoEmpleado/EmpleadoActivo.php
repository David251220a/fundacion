<?php

namespace App\Http\Livewire\PagoEmpleado;

use App\Models\Empleado;
use App\Models\Persona;
use App\Models\SalarioEmpleado;
use App\Models\SalarioPago;
use Faker\Provider\ar_EG\Person;
use Livewire\Component;
use Livewire\WithPagination;

class EmpleadoActivo extends Component
{
    public $titulo, $titulo_dos, $buscar_documento, $persona, $nombre, $documento, $apellido, $remuneracion = 0, $celular, $email;
    public $salario_pago_id, $estado_id, $salario_pago;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['continuar'];

    public function mount()
    {
        $this->titulo = 'Buscar Persona';
        $this->salario_pago = SalarioPago::all();
        $this->salario_pago_id = 4;
    }
    public function render()
    {
        $data = Empleado::join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->where('empleados.estado_id', 1)
        ->select('empleados.*', 'personas.documento', 'personas.nombre', 'personas.apellido')
        ->orderBy('personas.documento')
        ->paginate(20);

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

    public function resetUI()
    {
        $this->reset('buscar_documento');
        $this->reset('persona');
        $this->reset('celular');
        $this->reset('email');
        $this->reset('nombre');
        $this->reset('documento');
        $this->reset('apellido');
        $this->remuneracion = 0;
        $this->salario_pago_id = 4;
        $this->emit('reloadClassCSs');
    }
}
