<?php

namespace App\Http\Livewire\Unidad;

use App\Models\UnidadMedida;
use Livewire\Component;

class UnidadIndex extends Component
{
    public $titulo, $accion=1,$descripcion, $estado;

    public function mount(){
        $this->cambiar();
    }


    public function render()
    {
        return view('livewire.unidad.unidad-index');
    }

    public function buscar_datos($id){
        $accion = 2;
        $this->cambiar();
        $unidad= UnidadMedida::find($id);
        $this->descripcion = $unidad->descripcion;
        $this->estado = $unidad->estado_id;
    }


    public function cambiar(){
        if($this->accion == 1){
            $this->titulo = 'Agregar Unidad de Medida';
        }else{
            $this->titulo = 'Editar Unidad de Medida';
        }
    }

    public function resetUI()
    {
        $this->reset('descripcion');
        $this->estado = 1;
        $this->accion = 1;
        $this->emit('reloadClassCSs', 'agrega');
    }
}
