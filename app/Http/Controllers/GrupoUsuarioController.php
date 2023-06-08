<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GrupoUsuarioController extends Controller
{

    public function __construct()
    {
        // $this->middleware('permission:role.index')->only('index');
        // $this->middleware('permission:role.create')->only('create');
        // $this->middleware('permission:role.store')->only('store');
        // $this->middleware('permission:role.edit')->only('edit');
        // $this->middleware('permission:role.update')->only('update');
    }

    public function index()
    {
        $data = Role::get();
        return view('roles.index', compact('data'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $role = Role::create($request->all());
        return redirect()->route('role.edit', $role)->with(['message' => 'Registro exitoso!']);
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('descripcion', 'ASC')->get();
        return view('roles.edit', [
            'data' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions);
        $role->name = $request->name;
        $role->save();
        return redirect()->route('role.index')->with(['message' => 'Registro exitoso!']);
    }
}
