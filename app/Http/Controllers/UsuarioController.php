<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:usuario.index')->only('index');
        $this->middleware('permission:usuario.create')->only('create');
        $this->middleware('permission:usuario.store')->only('store');
        $this->middleware('permission:usuario.edit')->only('edit');
        $this->middleware('permission:usuario.update')->only('update');
    }

    public function index(Request $request)
    {
        $search = str_replace(',', '', $request->search);
        if (empty($search)){
            $data = User::orderBy('name', 'ASC')
            ->get();
        }else{
            $data = User::where('documento', $search)
            ->orWhere('name', 'LIKE', '%'. $search . '%')
            ->orderBy('name', 'ASC')
            ->get();
        }

        return view('usuario.index', compact('data', 'search'));
    }

    public function create()
    {
        $role = Role::get();
        return view('usuario.create', compact('role'));
    }

    public function edit(User $user)
    {
        $role = Role::get();
        return view('usuario.edit', compact('user', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $documento = str_replace('.', '', $request->documento);
        $validar_email = User::where('email', $request->email)->first();
        if($validar_email){
            return redirect()->back()->withInput()->withErrors('Ya se registro un usuario con este email: '. $request->email .'!.');
        }
        // $existe_ci = Persona::where('documento', $documento)->first();
        // if(empty($existe_ci)){
        //     return redirect()->back()->withInput()
        //     ->withErrors('No existe persona con este documento: '. $request->documento .'!.');
        // }
        // $existe_user_con_ci = User::where('documento', $documento)->first();
        // if($existe_user_con_ci){
        //     return redirect()->back()->withInput()
        //     ->withErrors('Ya existe un usuario con este CI: ' . $request->documento. ' pertenece al Usuario: '. $existe_user_con_ci->name .'!.');
        // }

        if (preg_match('/[a-zA-Z]+.*[0-9]+|[0-9]+.*[a-zA-Z]+/', $request->password)) {
            if(strlen($request->password) < 6){
                return redirect()->back()->withInput()
            ->withErrors('La contraseña debe contener al menos de 6 caracteres!.');
            }
        } else {
            return redirect()->back()->withInput()
            ->withErrors('La contraseña debe contener letras y numero. Ejemplo: Holamundo123!.');
        }

        $user = User::create([
            'documento' => $documento,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles($request->rol);
        return redirect()->route('user.index')->with('message', 'Se creo el usuario con exito ' . $user->name . '!.');
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'documento' => 'required|unique:users,documento,'.$user->id .',id',
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id .',id',
        ]);

        $documento = str_replace('.', '', $request->documento);

        // $existe_ci = Persona::where('documento', $documento)->first();
        // if(empty($existe_ci)){
        //     return redirect()->back()->withInput()
        //     ->withErrors('No existe persona con este documento: '. $request->documento .'!.');
        // }

        $user->documento = str_replace('.', '', $request->documento);
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password){
            if (preg_match('/[a-zA-Z]+.*[0-9]+|[0-9]+.*[a-zA-Z]+/', $request->password)) {
                if(strlen($request->password) < 6){
                    return redirect()->back()->withInput()
                ->withErrors('La contraseña debe contener al menos de 6 caracteres!.');
                }
            } else {
                return redirect()->back()->withInput()
                ->withErrors('La contraseña debe contener letras y numero. Ejemplo: Holamundo123!.');
            }

            $user->password = bcrypt($request->password);
        }

        $user->update();
        $user->syncRoles($request->rol);
        return redirect()->route('user.index')->with('message', 'Se edito con exito el usuario: ' . $user->name . '!.');
    }

}
