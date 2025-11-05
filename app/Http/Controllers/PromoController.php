<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:promo.index')->only('index');
        $this->middleware('permission:promo.create')->only('create');
        $this->middleware('permission:promo.create')->only('store');
        $this->middleware('permission:promo.edit')->only('edit');
        $this->middleware('permission:promo.edit')->only('update');
    }


    public function index()
    {
        $data = Promo::where('estado_id', 1)
        ->limit(1000)
        ->get();
        return view('promo.index', compact('data'));
    }

    public function create()
    {
        return view('promo.create');
    }

    public function edit(Promo $promo)
    {
        return view('promo.edit', compact('promo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'procentaje' => 'required|numeric'
        ]);

        $selecciono = 0;
        $lunes = 0;
        $martes = 0;
        $miercoles = 0;
        $jueves = 0;
        $viernes = 0;
        $sabado = 0;
        $domingo = 0;

        if ($request->procentaje == 0){
            return redirect()->back()->withErrors('El procentaje debe ser mayor a cero.');
        }

        if($request->lunes == 'on'){
            $lunes = 1;
            $selecciono = 1;
        }

        if($request->martes == 'on'){
            $martes = 1;
            $selecciono = 1;
        }

        if($request->miercoles == 'on'){
            $miercoles = 1;
            $selecciono = 1;
        }

        if($request->jueves == 'on'){
            $jueves = 1;
            $selecciono = 1;
        }

        if($request->viernes == 'on'){
            $viernes = 1;
            $selecciono = 1;
        }

        if($request->sabado == 'on'){
            $sabado = 1;
            $selecciono = 1;
        }
        if($request->domingo == 'on'){
            $domingo = 1;
            $selecciono = 1;
        }

        if ($selecciono == 0){
            return redirect()->back()->withErrors('Debe seleccionar un dia');
        }

        Promo::create([
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'porcentaje' => $request->procentaje,
            'lunes' => $lunes,
            'martes' => $martes,
            'miercoles' => $miercoles,
            'jueves' => $jueves,
            'viernes' => $viernes,
            'sabado' => $sabado,
            'domingo' => $domingo,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('promo.index')->with('messaje', 'Promo creado con exito');
    }

    public function update(Promo $promo, Request $request)
    {
            $request->validate([
            'descripcion' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'procentaje' => 'required|numeric'
        ]);

        $selecciono = 0;
        $lunes = 0;
        $martes = 0;
        $miercoles = 0;
        $jueves = 0;
        $viernes = 0;
        $sabado = 0;
        $domingo = 0;

        if ($request->procentaje == 0){
            return redirect()->back()->withErrors('El procentaje debe ser mayor a cero.');
        }

        if($request->lunes == 'on'){
            $lunes = 1;
            $selecciono = 1;
        }

        if($request->martes == 'on'){
            $martes = 1;
            $selecciono = 1;
        }

        if($request->miercoles == 'on'){
            $miercoles = 1;
            $selecciono = 1;
        }

        if($request->jueves == 'on'){
            $jueves = 1;
            $selecciono = 1;
        }

        if($request->viernes == 'on'){
            $viernes = 1;
            $selecciono = 1;
        }

        if($request->sabado == 'on'){
            $sabado = 1;
            $selecciono = 1;
        }
        if($request->domingo == 'on'){
            $domingo = 1;
            $selecciono = 1;
        }

        if ($selecciono == 0){
            return redirect()->back()->withErrors('Debe seleccionar un dia');
        }

        $promo->update([
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'porcentaje' => $request->procentaje,
            'lunes' => $lunes,
            'martes' => $martes,
            'miercoles' => $miercoles,
            'jueves' => $jueves,
            'viernes' => $viernes,
            'sabado' => $sabado,
            'domingo' => $domingo,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('promo.index')->with('messaje', 'Promo editado con exito');
    }

}
