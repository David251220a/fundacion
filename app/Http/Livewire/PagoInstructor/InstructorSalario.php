<?php

namespace App\Http\Livewire\PagoInstructor;

use App\Models\CursoHabilitado;
use Livewire\Component;

class InstructorSalario extends Component
{
    public function render()
    {

        $cursos = CursoHabilitado::where('concluido', 0)
        ->where('instructor_id', '>', 1)
        ->where('estado_id', 1)
        ->paginate(20);

        return view('livewire.pago-instructor.instructor-salario', compact('cursos'));
    }
}
