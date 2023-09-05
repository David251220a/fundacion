<?php

namespace App\Http\Livewire\PagoEmpleado;

use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithPagination;

class EmpleadoInactivo extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['activar'];

    public function render()
    {
        $data = Empleado::join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->where('empleados.estado_id', 2)
        ->select('empleados.*', 'personas.documento', 'personas.nombre', 'personas.apellido')
        ->orderBy('personas.documento')
        ->paginate(20);

        return view('livewire.pago-empleado.empleado-inactivo', compact('data'));
    }

    public function activar($id)
    {
        $empleado = Empleado::find($id);
        $empleado->estado_id = 1;
        $empleado->modif_user_id = auth()->user()->id;
        $empleado->update();

        foreach ($empleado->todos_inactivos as $item) {
            $item->estado_id = 1;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $this->emit('correcto', 'Empleado activado con exito.');
    }
}
