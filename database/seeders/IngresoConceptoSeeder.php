<?php

namespace Database\Seeders;

use App\Models\IngresoConcepto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngresoConceptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IngresoConcepto::create([
            'descripcion' => 'FOLLETO OPERADOR BASICO',
            'precio' => 15000,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        IngresoConcepto::create([
            'descripcion' => 'HARINA',
            'precio' => 15000,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        IngresoConcepto::create([
            'descripcion' => 'MOLDE PARA TORTAS',
            'precio' => 15000,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);
    }
}
