<?php

namespace Database\Seeders;

use App\Models\Barrio;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Pai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatosPaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pais = Pai::create([
            'descripcion' => 'PARAGUAY',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        $departamento = Departamento::create([
            'descripcion' => 'ASUNCION',
            'pais_id' => $pais->id,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        $ciudad = Ciudad::create([
            'descripcion' => 'LIMPIO',
            'pais_id' => $pais->id,
            'departamento_id' => $departamento->id,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        $barrio = Barrio::create([
            'descripcion' => 'SIN ESPECIFICAR',
            'pais_id' => $pais->id,
            'departamento_id' => $departamento->id,
            'ciudad_id' => $ciudad->id,
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
