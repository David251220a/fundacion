<?php

namespace App\Http\Livewire\Habilitado;

use App\Models\Curso;
use App\Models\CursoHabilitado;
use App\Models\TipoCurso;
use Livewire\Component;
use Livewire\WithPagination;

class HabilitadoIndex extends Component
{
    public $tipo_curso;
    public $tipo_curso_id = 0;

    public $curso;
    public $curso_id = 0;
    public $anio;
    public $anios;
    

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->tipo_curso = TipoCurso::all();
        $this->tipo_curso_id = 0;
        $this->curso = Curso::where('tipo_curso_id', $this->tipo_curso_id)
        ->get();
        $this->cargarCursos();
        $this->anio = '';
        $this->anios = collect(range(now()->year, now()->year - 5));
    }

    public function updatedCursoId()
    {
        $this->resetPage();
    }

    public function updatedTipoCursoId($value)
    {
        $this->cargarCursos();
        $this->resetPage();
    }

    public function updatedAnio()
    {
        $this->resetPage();
    }
    public function render()
    {
        $data = CursoHabilitado::query()
        ->where('estado_id', 1)
        ->when($this->tipo_curso_id != 0, fn($q) => $q->where('tipo_curso_id', $this->tipo_curso_id))
        ->when($this->curso_id != 0, fn($q) => $q->where('curso_id', $this->curso_id))
        ->when($this->anio != '', function ($q) {
            $q->whereBetween('periodo_desde', [
                $this->anio . '-01-01',
                $this->anio . '-12-31',
            ]);
        }, function ($q) {
            $q->where('periodo_desde', '>=', now()->subYears(5)->startOfYear());
        })
        ->latest()
        ->simplePaginate(50);

        return view('livewire.habilitado.habilitado-index', compact('data'));
    }

    public function cargarCursos()
    {
        if ($this->tipo_curso_id == 0) {
            $this->curso = Curso::all();
            $this->curso_id = 0;
        } else {
            $this->curso = Curso::where('tipo_curso_id', $this->tipo_curso_id)->get();
            $this->curso_id = 0;
        }
    }

    public function filtrar()
    {

        $this->resetPage();
    }
}
