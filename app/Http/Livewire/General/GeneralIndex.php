<?php

namespace App\Http\Livewire\General;

use App\Models\Curso;
use App\Models\CursoHabilitado;
use App\Models\TipoCurso;
use Livewire\Component;
use Livewire\WithPagination;

class GeneralIndex extends Component
{
    public  $familia_id, $curso_id = 0, $cur, $cursos;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $this->cursos = CursoHabilitado::where('concluido', 0)
        ->where('estado_id', 1)
        ->get();

        $familia = TipoCurso::where('estado_id', 1)->get();
        $this->familia_id =$familia[0]->id;

        $this->cur = Curso::where('tipo_curso_id', $this->familia_id)
        ->where('estado_id', 1)
        ->get();

        return view('livewire.general.general-index', compact('familia'));
    }

    public function filtro()
    {
        dd($this->curso_id);
    }
}
