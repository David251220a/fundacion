<?php

namespace Database\Seeders;

use App\Models\Insumo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insumo::create([
            'descripcion' => 'AGUA',
            'precio' => 80000,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        Insumo::create([
            'descripcion' => 'ANDE',
            'precio' => 80000,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        Insumo::create([
            'descripcion' => 'INTERNET',
            'precio' => 80000,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);
    }
}
