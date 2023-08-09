<?php

namespace Database\Seeders;

use App\Models\PagoTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagoTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PagoTipo::create([
            'descripcion' => 'PAGO EMPLEADO',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        PagoTipo::create([
            'descripcion' => 'PAGO INSTRUCTORES',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        PagoTipo::create([
            'descripcion' => 'PAGO PROVEEDORES',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);

        PagoTipo::create([
            'descripcion' => 'OTROS PAGOS',
            'estado_id' => 1,
            'user_id' => 1,
            'modif_user_id' => 1
        ]);
    }
}
