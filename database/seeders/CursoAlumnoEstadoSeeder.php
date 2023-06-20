<?php

namespace Database\Seeders;

use App\Models\CursoAEstado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoAlumnoEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CursoAEstado::create([
            'descripcion' => 'INSCRITO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        CursoAEstado::create([
            'descripcion' => 'CURSANDO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        CursoAEstado::create([
            'descripcion' => 'CONCLUIDO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        CursoAEstado::create([
            'descripcion' => 'AGENDADO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        CursoAEstado::create([
            'descripcion' => 'PENDIENTE',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        CursoAEstado::create([
            'descripcion' => 'CANCELADO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);
    }
}
