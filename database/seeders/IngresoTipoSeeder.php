<?php

namespace Database\Seeders;

use App\Models\IngresoTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngresoTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IngresoTipo::create([
            'descripcion' => 'MATRICULA',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        IngresoTipo::create([
            'descripcion' => 'CERTIFICADO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        IngresoTipo::create([
            'descripcion' => 'INSUMO CURSO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        IngresoTipo::create([
            'descripcion' => 'INGRESO VARIOS',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

    }
}
