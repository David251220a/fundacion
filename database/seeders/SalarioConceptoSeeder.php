<?php

namespace Database\Seeders;

use App\Models\SalarioConcepto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalarioConceptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalarioConcepto::create([
            'descripcion' => 'REMUNERACION',
            'tipo' => 1,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        SalarioConcepto::create([
            'descripcion' => 'ANTICIPO',
            'tipo' => 2,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
