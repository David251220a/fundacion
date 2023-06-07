<?php

namespace App\Http\Livewire\TipoCurso;

use App\Models\TipoCurso;
use Livewire\Component;

class TipoCursoIndex extends Component
{
    public $descripcion , $estado = 1, $tipo_id = 0;

    protected $rules = [
        'descripcion' => 'required',
    ];

    protected $listeners = ['save', 'editar'];

    public function render()
    {
        $data = TipoCurso::orderBy('id', 'DESC')->get();
        return view('livewire.tipo-curso.tipo-curso-index', compact('data'));

    }

    public function save()
    {
        $this->validate();

        TipoCurso::create([
            'descripcion' => $this->descripcion,
            'estado_id' => $this->estado,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $this->reset('descripcion');
        $this->emit('tipo-add', 'Tipo Curso Agregado');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->reset('descripcion');
        $this->tipo_id = 0;
        $this->emit('reloadClassCSs', 'agrega');
    }


    public function editar(TipoCurso $tipoCurso)
    {
        $this->descripcion = $tipoCurso->descripcion;
        $this->estado = $tipoCurso->estado_id;
        $this->tipo_id = $tipoCurso->id;
        $this->emit('mostrar-edit', 've');
    }

    public function actualizar(TipoCurso $tipoCurso)
    {
        $this->validate();

        $tipoCurso->descripcion = $this->descripcion;
        $tipoCurso->estado_id = $this->estado;
        $tipoCurso->modif_user_id = auth()->user()->id;
        $tipoCurso->update();
        $this->emit('mostrar-actualizado', 'Tipo Curso Editado');
        $this->resetUI();
    }

}
