<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnidadMedida;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadMedida::create([
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
