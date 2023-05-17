<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'descripcion' => 'Cursos',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        Tag::create([
            'descripcion' => 'Eventos',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        Tag::create([
            'descripcion' => 'Cursos Promocion',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);

        Tag::create([
            'descripcion' => 'Conmemoracion',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1,
        ]);
    }
}
