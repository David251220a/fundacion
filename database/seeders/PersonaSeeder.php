<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persona = Persona::create([
            'documento' => 0,
            'nombre' => 'SIN ESPECIFICAR',
            'apellido' => 'SIN ESPECIFICAR',
            'direccion' => '',
            'sexo' => '1',
            'celular' => '',
            'pais_id' => 1,
            'fecha_nacimiento' => '1990-01-01',
            'departamento_id' => 1,
            'ciudad_id' => 1,
            'barrio_id' => 1,
            'estado_id' => 1,
            'estado_civil_id' => 1,
            'partido_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        Instructor::create([
            'persona_id' => $persona->id,
            'firma' => '',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);
    }
}
