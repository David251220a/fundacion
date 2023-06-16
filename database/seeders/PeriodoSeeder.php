<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periodo::create([
            'descripcion' => 'MESES',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        Periodo::create([
            'descripcion' => 'SEMANAS',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        Periodo::create([
            'descripcion' => 'DIAS',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        Periodo::create([
            'descripcion' => 'AÑO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
