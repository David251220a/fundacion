<?php

namespace Database\Seeders;

use App\Models\Partido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partido::create([
            'descripcion' => 'SIN ESPECIFICAR',
            'alias' => 'SIN',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);


        Partido::create([
            'descripcion' => 'PARTIDO COLORADO',
            'alias' => 'ANR',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        Partido::create([
            'descripcion' => 'PARTIDO LIBERAL',
            'alias' => 'PLRA',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
