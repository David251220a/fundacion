<?php

namespace App\Http\Livewire\Agenda;

use App\Models\Agenda;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\EstadoCivil;
use App\Models\Persona;
use App\Models\TipoCurso;
use Carbon\Carbon;
use Livewire\Component;

class General extends Component
{

    public $familia, $familia_id, $curso, $curso_id, $data;
    public $modal_familia, $modal_familia_id, $modal_curso, $modal_curso_id;
    public $mensaje_error, $buscar_documento, $ver_error = 0;
    public $documento, $nombre, $apellido, $email, $fecha_nacimiento, $celular, $sexo = 0, $estado_civil_id = 1, $alumno_id;

    protected $listeners = ['actualizar', 'eliminar', 'modal_actualizar'];

    public function mount()
    {
        $this->carga_familiar();
        $this->carga_datos();
        $this->modal_carga_familiar();
    }

    protected $rules = [
        'documento' => 'required',
        'nombre' => 'required',
        'apellido' => 'required',
    ];

    public function render()
    {
        $estado_civil = EstadoCivil::all();
        return view('livewire.agenda.general', compact('estado_civil'));
    }

    public function carga_familiar()
    {
        $this->familia = TipoCurso::where('estado_id', 1)
        ->orderBy('descripcion', 'ASC')
        ->get();

        $this->familia_id = $this->familia[0]->id;
        $this->carga_curso();
    }

    public function modal_carga_familiar()
    {
        $this->modal_familia = TipoCurso::where('estado_id', 1)
        ->orderBy('descripcion', 'ASC')
        ->get();

        $this->modal_familia_id = $this->familia[0]->id;
        $this->modal_carga_curso();
    }

    public function carga_curso()
    {
        $this->curso = Curso::where('estado_id', 1)
        ->where('tipo_curso_id', $this->familia_id)
        ->orderBy('descripcion', 'ASC')
        ->orderBy('curso_modulo_id', 'ASC')
        ->get();

        if(empty($this->curso)){
            $this->curso_id = null;
        }elseif (count($this->curso) == 0){
            $this->curso_id = null;
        }else{
            $this->curso_id = $this->curso[0]->id;
        }
    }

    public function modal_carga_curso()
    {
        $this->modal_curso = Curso::where('estado_id', 1)
        ->where('tipo_curso_id', $this->modal_familia_id)
        ->orderBy('descripcion', 'ASC')
        ->orderBy('curso_modulo_id', 'ASC')
        ->get();

        if(empty($this->modal_curso)){
            $this->modal_curso_id = null;
        }elseif (count($this->modal_curso) == 0){
            $this->modal_curso_id = null;
        }else{
            $this->modal_curso_id = $this->modal_curso[0]->id;
        }
    }

    public function carga_datos()
    {
        $this->data = Agenda::where('curso_id', $this->curso_id)
        ->where('curso_a_estado_id', 4)
        ->where('estado_id', 1)
        ->get();
    }

    public function actualizar()
    {
        $this->carga_curso();
    }

    public function modal_actualizar()
    {
        $this->modal_carga_curso();
    }

    public function confirmar()
    {

        $fecha_actual = Carbon::now();

        $existe = Agenda::where('alumno_id', $this->alumno_id)
        ->where('curso_id', $this->modal_curso_id)
        ->where('curso_a_estado_id', 4)
        ->first();

        if(empty($this->modal_curso_id)){
            $this->resetUI();
            $this->emit('existe_general', 'Debe de seleccionar un curso.');
            return false;
        }

        $datos_curso = Curso::find($this->modal_curso_id);

        if (empty($existe)) {
            Agenda::create([
                'curso_id' => $datos_curso->id,
                'curso_modulo_id' => $datos_curso->curso_modulo_id,
                'tipo_curso_id' => $datos_curso->tipo_curso_id,
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
            $this->emit('guardado_general', 'Se agendo el alumno con exito.');
        } else {
            $this->resetUI();
            $this->emit('existe_general', 'El alumno ya esta agendado.');
        }

        $this->carga_datos();

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

            $this->emit('confirmar_creacion_general', 'crear');
        }else{
            $this->documento = $this->buscar_documento;
            $this->emit('crear', 'crear');
        }
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

        $this->alumno_id = $alumno->id;
        $this->emit('confirmar_creacion_general', 'crear');

    }

    public function eliminar($id)
    {
        $alumno = Agenda::find($id);
        $alumno->curso_a_estado_id = 6;
        $alumno->update();

        $this->carga_datos();
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
