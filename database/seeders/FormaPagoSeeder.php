<?php

namespace Database\Seeders;

use App\Models\FormaPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormaPago::create([
            'descripcion' => 'EFECTIVO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        FormaPago::create([
            'descripcion' => 'TRANSFERENCIA BANCARIA',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        FormaPago::create([
            'descripcion' => 'GIRO - TELEFONIA',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
