<?php

namespace App\Http\Livewire\General;

use App\Models\Curso;
use App\Models\CursoHabilitado;
use App\Models\TipoCurso;
use Livewire\Component;
use Livewire\WithPagination;

class GeneralIndex extends Component
{
    public  $familia, $familia_id, $curso_id = 0, $cur, $cursos, $seleccionado = 0;

    use WithPagination;

    protected $paginationTheme = 'actualizar';

    protected $listeners = ['actualizar'];

    public function mount()
    {
        $this->cursos = CursoHabilitado::where('concluido', 0)
        ->where('estado_id', 1)
        ->get();

        $this->familia = TipoCurso::where('estado_id', 1)->get();
        $this->familia_id =$this->familia[0]->id;

        $this->cur = Curso::where('tipo_curso_id', $this->familia_id)
        ->where('estado_id', 1)
        ->get();
    }

    public function render()
    {
        return view('livewire.general.general-index');
    }

    public function filtro()
    {
        if($this->curso_id == 0){
            $this->cursos = CursoHabilitado::where('concluido', 0)
            ->where('tipo_curso_id', $this->familia_id)
            ->where('estado_id', 1)
            ->get();
        }else{
            $this->cursos = CursoHabilitado::where('concluido', 0)
            ->where('curso_id', $this->curso_id)
            ->where('estado_id', 1)
            ->get();
        }
    }

    public function actualizar()
    {
        $this->cur = Curso::where('tipo_curso_id', $this->familia_id)
        ->where('estado_id', 1)
        ->get();

        $this->curso_id = 0;
    }

    public function seleecionar($seleccionado)
    {
        $this->seleccionado = $seleccionado;
    }
}
