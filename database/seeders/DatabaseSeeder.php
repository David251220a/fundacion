<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\IngresoTipo;
use App\Models\PagoTipo;
use App\Models\SalarioPago;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleSeeder::class);

        //  User::create([
        //      'name' => 'Admin',
        //      'documento' => '4918642',
        //      'email' => 'admin@dev',
        //      'password' => Hash::make('admin123456'),
        //  ])->assignRole('admin');

         $this->call([
            // EstadoSeeder::class,
            // TagsSeeder::class,
            // DatosPaisSeeder::class,
            // EstadoCivilSeeder::class,
            // CursoAlumnoEstadoSeeder::class,
            // PartidoSeeder::class,
            // PeriodoSeeder::class,
            // TipoFamiliaSeeder::class,
            // FormaPagoSeeder::class,
            // PersonaSeeder::class,
            // IngresoConceptoSeeder::class,
            // CursoModuloSeeder::class,
            // AsistenciaMotivoSeeder::class,
            // UnidadMedidaSeeder::class,
            // PagoTipoSeeder::class,
            // SalarioConceptoSeeder::class,
            // SalarioPagoSeeder::class,
            // InsumoSeeder::class,
            IngresoTipoSeeder::class,
        ]);
    }
}
