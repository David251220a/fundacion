<?php

namespace App\Http\Livewire\Persona;

use App\Models\Barrio;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Pai;
use App\Models\Persona;
use Livewire\Component;

class EditarPersona extends Component
{
    public $pais_id, $departamento_id = 0, $ciudad_id = 0, $barrio_id = 0, $descripcion_pais, $descripcion_departamento, $descripcion_ciudad, $descripcion_barrio;
    public $pais = [], $departamento = [], $ciudad = [], $barrio = [];
    public $nombre_pais, $nombre_departamento, $nombre_ciudad, $persona;

    protected $listeners = ['updatedPais', 'updatedDepartamento', 'nombres', 'updatedCiudad'];

    protected $rules = [
        'descripcion_pais' => 'required||unique:pais,descripcion',
    ];

    public function mount(Persona $persona)
    {
        $this->persona = $persona;
        $this->pais = Pai::all();
        $this->pais_id = $persona->pais_id;

        $this->departamento = Departamento::where('pais_id', $this->pais_id)->get();
        $this->departamento_id = $persona->departamento_id;

        $this->ciudad = Ciudad::where('pais_id', $this->pais_id)
        ->where('departamento_id', $this->departamento_id)
        ->get();
        $this->ciudad_id = $persona->ciudad_id;

        $this->barrio = Barrio::where('ciudad_id', $this->ciudad_id)->get();
        $this->barrio_id = $this->persona->barrio_id;

        $this->nombres();
    }

    public function updatedPais(){
        $this->departamento = Departamento::where('pais_id', $this->pais_id)->get();
        if($this->departamento->count() > 0){
            $this->departamento_id = $this->departamento[0]->id;
        }else{
            $this->departamento_id = 0;
        }

        $this->ciudad = Ciudad::where('pais_id', $this->pais_id)
        ->where('departamento_id', $this->departamento_id)
        ->get();

        if($this->ciudad->count() > 0){
            $this->ciudad_id = $this->ciudad[0]->id;
        }else{
            $this->ciudad_id = 0;
        }
        $this->nombres();
    }

    public function updatedDepartamento(){
        $this->ciudad = Ciudad::where('pais_id', $this->pais_id)
        ->where('departamento_id', $this->departamento_id)
        ->get();

        if($this->ciudad->count() > 0){
            $this->ciudad_id = $this->ciudad[0]->id;
        }else{
            $this->ciudad_id = 0;
        }
        $this->nombres();
    }

    public function updatedCiudad(){

        $this->barrio = Barrio::where('ciudad_id', $this->ciudad_id)->get();
        $this->nombres();
    }

    public function render()
    {
        return view('livewire.persona.editar-persona');
    }

    public function save()
    {
        $this->validate();

        $pais_a= Pai::create([
            'descripcion' => $this->descripcion_pais,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $dep= $pais_a->departamento()->create([
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $ciudad_add = $dep->ciudad()->create([
            'pais_id' => $pais_a->id,
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $ciudad_add->barrio()->create([
            'pais_id' => $pais_a->id,
            'departamento_id' => $dep->id,
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $this->mount($this->persona);
        $this->reset('descripcion_pais');
        $this->emit('pais-add', 'Pais Agregado');
    }

    public function save_departamento(){

        if(empty($this->descripcion_departamento)){
            $this->emit('departamento-error', 'El nombre del departamento no puede ser vacio!.');
            return false;
        }

        $existe_departamento = Departamento::where('pais_id', $this->pais_id)
        ->where('descripcion', '=', $this->descripcion_departamento)
        ->first();

        if(!(empty($existe_departamento))){
            $this->emit('departamento-error', 'Ya existe departamento con este nombre, dentro de este pais!.');
            return false;
        }

        $dep = Departamento::create([
            'pais_id' => $this->pais_id,
            'descripcion' => $this->descripcion_departamento,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $ciudad_add = $dep->ciudad()->create([
            'pais_id' => $this->pais_id,
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $ciudad_add->barrio()->create([
            'pais_id' => $this->pais_id,
            'departamento_id' => $dep->id,
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);


        $this->updatedPais();
        $this->reset('descripcion_departamento');
        $this->emit('departamento-add', 'Departamento Agregado');
    }

    public function save_ciudad(){

        if(empty($this->descripcion_ciudad)){
            $this->emit('ciudad-error', 'El nombre de la ciudad no puede ser vacio!.');
            return false;
        }

        $existe_ciudad = Ciudad::where('pais_id', $this->pais_id)
        ->where('departamento_id', $this->departamento_id)
        ->where('descripcion', '=', $this->descripcion_ciudad)->first();

        if(!(empty($existe_ciudad))){
            $this->emit('ciudad-error', 'El nombre de la ciudad ya existe!.');
            return false;
        }

        $ciudad_add = Ciudad::create([
            'pais_id' => $this->pais_id,
            'departamento_id' => $this->departamento_id,
            'descripcion' => $this->descripcion_ciudad,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $ciudad_add->barrio()->create([
            'pais_id' => $this->pais_id,
            'departamento_id' => $this->departamento_id,
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $this->updatedDepartamento();
        $this->reset('descripcion_ciudad');
        $this->emit('ciudad-add', 'Ciudad Agregado');

    }

    public function save_barrio(){

        if(empty($this->descripcion_barrio)){
            $this->emit('barrio-error', 'El nombre del barrio no puede ser vacio!.');
            return false;
        }

        $existe = Barrio::where('pais_id', $this->pais_id)
        ->where('departamento_id', $this->departamento_id)
        ->where('ciudad_id', $this->ciudad_id)
        ->where('descripcion', '=', $this->descripcion_barrio)
        ->first();

        if(!(empty($existe))){
            $this->emit('barrio-error', 'El nombre del barrio ya existe!.');
            return false;
        }

        Barrio::create([
            'pais_id' => $this->pais_id,
            'departamento_id' => $this->departamento_id,
            'ciudad_id' => $this->ciudad_id,
            'descripcion' => $this->descripcion_barrio,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $this->updatedCiudad();
        $this->reset('descripcion_barrio');
        $this->emit('barrio-add', 'Barrio Agregado');

    }

    public function nombres(){
        $_pais = Pai::find($this->pais_id);
        $_departamento = Departamento::find($this->departamento_id);
        $_ciudad = Ciudad::find($this->ciudad_id);
        $this->nombre_pais = $_pais->descripcion;
        $this->nombre_ciudad = $_ciudad->descripcion;
        if($_departamento){
            $this->nombre_departamento = $_departamento->descripcion;
            // $this->nombre_ciudad = $_ciudad->descripcion;
        }else{
            $this->nombre_departamento = "";
        }

    }


    public function resetUI()
    {
        $this->reset('descripcion_pais');
        $this->reset('descripcion_departamento');
        $this->reset('descripcion_ciudad');
        $this->reset('descripcion_barrio');
        $this->emit('reloadClassCSs');
    }

}
