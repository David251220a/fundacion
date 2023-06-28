<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class IngresoMatriculaController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ingreso_matricula.index')->only('index');
        $this->middleware('permission:ingreso_matricula.cobro_alumno')->only('cobro_curso');
    }

    public function index()
    {

        return view('ingreso_curso.index');
    }

    public function cobro_curso(Alumno $alumno)
    {
        $persona = $alumno->persona;
        return view('ingreso_curso.cobro', compact('alumno', 'persona'));
    }
}
