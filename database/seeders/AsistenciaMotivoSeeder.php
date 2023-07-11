<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use App\Models\AsistenciaMotivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsistenciaMotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AsistenciaMotivo::create([
            'descripcion' => 'SIN ESPECIFICAR',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        AsistenciaMotivo::create([
            'descripcion' => 'FERIADO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        AsistenciaMotivo::create([
            'descripcion' => 'DIA DE LLUVIA',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        AsistenciaMotivo::create([
            'descripcion' => 'INDISPONIBILIDAD DE INSTRUCTOR',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        AsistenciaMotivo::create([
            'descripcion' => 'EVENTOS',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
