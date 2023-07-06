<?php

namespace App\Http\Livewire\Agenda;

use App\Models\Agenda;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\EstadoCivil;
use App\Models\Persona;
use Carbon\Carbon;
use Livewire\Component;

class Agendar extends Component
{
    public $curso, $curso_id = 0;
    public $mensaje_error, $buscar_documento, $ver_error = 0;

    public $documento, $nombre, $apellido, $email, $fecha_nacimiento, $celular, $sexo = 0, $estado_civil_id = 1, $alumno_id;

    protected $rules = [
        'documento' => 'required',
        'nombre' => 'required',
        'apellido' => 'required',
    ];

    public function mount(Curso $curso)
    {
        $this->curso = $curso;
    }

    public function render()
    {
        $data = Agenda::where('curso_id', $this->curso->id)
        ->where('curso_a_estado_id', 4)
        ->get();

        $estado_civil = EstadoCivil::all();
        return view('livewire.agenda.agendar', compact('data', 'estado_civil'));
    }

    public function save()
    {
        $this->validate();

        if(empty($this->fecha_nacimiento)){
            $fecha_nacimiento = '1990-01-01';
        }else{
            $fecha_nacimiento = $this->fecha_nacimiento;
        }
        $persona = Persona::create([
            'documento' => str_replace('.', '', $this->documento),
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'direccion' => '',
            'sexo' => $this->sexo,
            'celular' => $this->celular,
            'pais_id' => 1,
            'fecha_nacimiento' => $fecha_nacimiento,
            'departamento_id' => 1,
            'ciudad_id' => 1,
            'barrio_id' => 1,
            'email' => $this->email,
            'estado_id' => 1,
            'estado_civil_id' => $this->estado_civil_id,
            'partido_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $alumno = Alumno::create([
            'persona_id' => $persona->id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $fecha_actual = Carbon::now();

        Agenda::create([
            'curso_id' => $this->curso->id,
            'curso_modulo_id' => $this->curso->curso_modulo_id,
            'tipo_curso_id' => $this->curso->tipo_curso_id,
            'alumno_id' => $alumno->id,
            'curso_a_estado_id' => 4,
            'fecha_agenda' => $fecha_actual,
            'observacion' => '',
            'contacto' => 0,
            'fecha_contacto' => null,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);
        $this->resetUI();
        $this->emit('guardado', 'Se agendo el alumno con exito.');
    }

    public function continuar()
    {
        $this->ver_error = 0;
        if(empty($this->buscar_documento)){
            $this->ver_error = 1;
            $this->mensaje_error = 'El documento a buscar no puede estar vacio.';
            return false;
        }

        if($this->buscar_documento == 0){
            $this->mensaje_error = 'El documento no puede ser cero.';
            $this->ver_error = 1;
            return false;
        }

        $persona = Persona::where('documento', str_replace('.', '', $this->buscar_documento))
        ->first();

        if($persona){
            $this->documento = $this->buscar_documento;
            $this->nombre = $persona->nombre;
            $this->apellido = $persona->apellido;
            $this->sexo = $persona->sexo;
            $this->estado_civil_id = $persona->estado_civil_id;
            $this->email = $persona->email;
            $this->fecha_nacimiento = $persona->fecha_nacimiento;
            $this->celular = $persona->celular;

            if(empty($persona->alumno)){
                $alumno = Alumno::create([
                    'persona_id' => $persona->id,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
                $this->alumno_id = $alumno->id;
            }else{
                $this->alumno_id = $persona->alumno->id;
            }

            $this->emit('confirmar_creacion', 'crear');
        }else{
            $this->documento = $this->buscar_documento;
            $this->emit('crear', 'crear');
        }
    }


    public function confirmar()
    {

        $fecha_actual = Carbon::now();

        Agenda::create([
            'curso_id' => $this->curso->id,
            'curso_modulo_id' => $this->curso->curso_modulo_id,
            'tipo_curso_id' => $this->curso->tipo_curso_id,
            'alumno_id' => $this->alumno_id,
            'curso_a_estado_id' => 4,
            'fecha_agenda' => $fecha_actual,
            'observacion' => '',
            'contacto' => 0,
            'fecha_contacto' => null,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $persona = Persona::where('documento', str_replace('.', '', $this->buscar_documento))
        ->first();

        $persona->celular = $this->celular;
        $persona->email = $this->email;
        $persona->modif_user_id = auth()->user()->id;
        $persona->update();
        $this->resetUI();
        $this->emit('guardado', 'Se agendo el alumno con exito.');
    }

    public function resetUI()
    {
        $this->ver_error = 0;
        $this->reset('documento');
        $this->reset('nombre');
        $this->reset('apellido');
        $this->reset('celular');
        $this->reset('email');
        $this->reset('fecha_nacimiento');
        $this->reset('buscar_documento');
        $this->emit('reloadClassCSs');
    }
}
