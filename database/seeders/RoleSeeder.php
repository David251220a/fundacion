<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);


        $permission = Permission::create(['name' => 'rol.index', 'descripcion' => 'Rol Ver Listado'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'rol.create', 'descripcion' => 'Rol Crear'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'rol.edit', 'descripcion' => 'Rol Editar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'rol.show', 'descripcion' => 'Rol Ver'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'rol.update', 'descripcion' => 'Rol Actualizar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'rol.store', 'descripcion' => 'Rol Guardar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'rol.delete', 'descripcion' => 'Rol Elimnar'])->syncRoles($admin);

        $permission = Permission::create(['name' => 'usuario.index', 'descripcion' => 'Usuario Ver Listado'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'usuario.create', 'descripcion' => 'Usuario Crear'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'usuario.edit', 'descripcion' => 'Usuario Editar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'usuario.show', 'descripcion' => 'Usuario Ver'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'usuario.update', 'descripcion' => 'Usuario Actualizar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'usuario.store', 'descripcion' => 'Usuario Guardar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'usuario.delete', 'descripcion' => 'Usuario Elimnar'])->syncRoles($admin);


        $permission = Permission::create(['name' => 'habilitado.index', 'descripcion' => 'Habilitacion de Curso: Ver Listado'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'habilitado.create', 'descripcion' => 'Habilitacion de Curso: Crear'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'habilitado.edit', 'descripcion' => 'Habilitacion de Curso: Editar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'habilitado.show', 'descripcion' => 'Habilitacion de Curso: Ver'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'habilitado.update', 'descripcion' => 'Habilitacion de Curso: Actualizar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'habilitado.store', 'descripcion' => 'Habilitacion de Curso: Guardar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'habilitado.delete', 'descripcion' => 'Habilitacion de Curso: Elimnar'])->syncRoles($admin);

        $permission = Permission::create(['name' => 'curso.index', 'descripcion' => 'Curso: Ver Listado'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'curso.create', 'descripcion' => 'Curso: Crear'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'curso.edit', 'descripcion' => 'Curso: Editar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'curso.show', 'descripcion' => 'Curso: Ver'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'curso.update', 'descripcion' => 'Curso: Actualizar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'curso.store', 'descripcion' => 'Curso: Guardar'])->syncRoles($admin);
        $permission = Permission::create(['name' => 'curso.delete', 'descripcion' => 'Curso: Elimnar'])->syncRoles($admin);
    }
}
