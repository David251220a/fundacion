<?php

namespace Database\Seeders;

use App\Models\CursoModulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CursoModulo::create([
            'descripcion' => 'TALLER',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        CursoModulo::create([
            'descripcion' => 'MODULO 1',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        CursoModulo::create([
            'descripcion' => 'MODULO 2',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);


        CursoModulo::create([
            'descripcion' => 'MODULO 3',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        CursoModulo::create([
            'descripcion' => 'MODULO 3',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        CursoModulo::create([
            'descripcion' => 'MODULO 4',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
