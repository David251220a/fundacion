<?php

namespace Database\Seeders;

use App\Models\EstadoCivil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoCivil::create([
            'descripcion' => 'SOLTERO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        EstadoCivil::create([
            'descripcion' => 'CASADO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        EstadoCivil::create([
            'descripcion' => 'DIVORCIADO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        EstadoCivil::create([
            'descripcion' => 'VIUDO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
