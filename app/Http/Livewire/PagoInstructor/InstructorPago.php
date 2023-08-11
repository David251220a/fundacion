<?php

namespace App\Http\Livewire\PagoInstructor;

use Livewire\Component;
use Livewire\WithPagination;

class InstructorPago extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.pago-instructor.instructor-pago');
    }
}
