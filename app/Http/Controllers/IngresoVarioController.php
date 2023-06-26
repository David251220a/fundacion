<?php

namespace App\Http\Controllers;

use App\Models\IngresoConcepto;
use App\Models\IngresoVarios;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IngresoVarioController extends Controller
{
    public function index(Request $request)
    {
        return view('ingreso_varios.index');
    }

    public function consulta(Request $request)
    {
        $ingreso_concepto =IngresoConcepto::orderBy('descripcion', 'ASC')->get();

        if((!empty($request->buscar))){
            $buscar = $request->buscar;
            if($buscar == 1){
                $fecha_actual = $request->fecha;
                $data = $this->buscar_datos_fecha($fecha_actual);
            }
        }else{
            $fecha_actual = Carbon::now();
            $fecha_actual = date('Y-m-d', strtotime($fecha_actual));
            $buscar = 1;
            $data = $this->buscar_datos_fecha($fecha_actual);
        }

        return view('ingreso_varios.consulta', compact('ingreso_concepto', 'buscar', 'fecha_actual'));
    }

    public function buscar_datos_fecha($fecha)
    {
        $data = IngresoVarios::where('estado_id', 1)
        ->where('fecha_ingreso', $fecha)
        ->get();

        return $data;
    }

    public function buscar()
    {
        return view('ingreso_varios.buscar');
    }
}
