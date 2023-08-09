<?php

namespace Database\Seeders;

use App\Models\SalarioPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalarioPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalarioPago::create([
            'descripcion' => 'DIARIO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        SalarioPago::create([
            'descripcion' => 'SEMANAL',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        SalarioPago::create([
            'descripcion' => 'QUINCENAL',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        SalarioPago::create([
            'descripcion' => 'MENSUAL',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

    }
}
