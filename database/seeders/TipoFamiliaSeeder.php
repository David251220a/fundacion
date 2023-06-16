<?php

namespace Database\Seeders;

use App\Models\TipoFamilia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoFamiliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoFamilia::create([
            'descripcion' => 'MADRE',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        TipoFamilia::create([
            'descripcion' => 'PADRE',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        TipoFamilia::create([
            'descripcion' => 'HERMANO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        TipoFamilia::create([
            'descripcion' => 'HIJO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        TipoFamilia::create([
            'descripcion' => 'TIO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        TipoFamilia::create([
            'descripcion' => 'PRIMO/A',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

    }
}
