<?php

namespace App\Http\Controllers;

use App\Models\CuentaVario;
use App\Models\CuentaVarioDetalle;
use App\Models\FormaPago;
use App\Models\IngresoConcepto;
use App\Models\IngresoVarios;
use App\Models\IngresoVariosDetalle;
use App\Models\Persona;
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

    public function buscar_post(Request $request)
    {

        $documento = str_replace('.', '', $request->documento);
        $persona = Persona::where('documento', $documento)->first();
        if(empty($persona)){
            return redirect()->back()->withInput()->withErrors('No existe la persona con este numero de cedula: ' . $request->documento);
        }else{
            return redirect()->route('ingreso_varios.ingreso_persona', $persona);
        }

    }

    public function ingreso_persona(Persona $persona)
    {
        $ingreso_concepto = IngresoConcepto::orderBy('descripcion', 'ASC')->get();
        $forma_pago = FormaPago::all();
        return view('ingreso_Varios.ingreso', compact('persona', 'ingreso_concepto', 'forma_pago'));
    }

    public function crear_ingreso_concepto(Request $request)
    {
        $descripcion_concepto = $request->descripcion_concepto;
        $precio_concepto = str_replace('.', '', $request->precio_concepto);
        IngresoConcepto::create([
            'descripcion' => $descripcion_concepto,
            'precio' => $precio_concepto,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $data = IngresoConcepto::orderBy('descripcion', 'ASC')->get();

        return response()->json($data);
    }

    public function ingreso_persona_post(Persona $persona, Request $request)
    {
        $request->validate([
            'total_a_pagar' => 'required',
            'monto_a_pagar' => 'required',
        ]);

        $total_a_pagar = str_replace('.', '', $request->total_a_pagar);
        $monto_a_pagar = str_replace('.', '', $request->monto_a_pagar);
        $forma_pago = $request->forma_pago;
        if($total_a_pagar == 0){
            return redirect()->back()->withInput()->withErrors('El total a pagar no puede ser cero por favor agregue los productos a comprar.');
        }

        $concepto = $request->env_descripcion_id;
        $precio = str_replace('.', '', $request->env_precio);
        $cantidad = str_replace('.', '', $request->env_cantidad);
        $precio_total = str_replace('.', '', $request->env_precio_total);

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = IngresoVarios::where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo += 1;

        $ingreso = IngresoVarios::create([
            'persona_id' => $persona->id,
            'forma_pago_id' => $forma_pago,
            'fecha_ingreso' => $fecha_actual,
            'mes' => $mes,
            'año' => $anio,
            'numero_recibo' => $numero_recibo,
            'sucursal' => '000',
            'general' => '000',
            'factura_numero' => '0000000',
            'total_pagado' => $monto_a_pagar,
            'comprobante' => '',
            'cuenta_padre' => 0,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $aux_monto = $monto_a_pagar;
        for ($i=0; $i < count($concepto); $i++) {
            $saldo = 0;
            if($aux_monto >= $precio_total[$i]){
                $pagar = $precio_total[$i];
                $aux_monto = $aux_monto - $precio_total[$i];
                $saldo = 0;
            }else{
                if($aux_monto < $precio_total[$i]){
                    $pagar = $aux_monto;
                    $saldo = $precio_total[$i] - $aux_monto;
                    $aux_monto = 0;
                }else{
                    if($aux_monto == 0){
                        $pagar = 0;
                        $saldo = $precio_total[$i];
                        $aux_monto = 0;
                    }
                }
            }

            $ingreso_detalle = IngresoVariosDetalle::create([
                'persona_id' => $persona->id,
                'ingreso_vario_id' => $ingreso->id,
                'ingreso_concepto_id' => $concepto[$i],
                'descripcion' => '',
                'precio_unitario' => $precio[$i],
                'cantidad' => $cantidad[$i],
                'total_pagar' => $precio_total[$i],
                'monto_pagado' => $pagar,
                'saldo' => $saldo,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        if($total_a_pagar != $monto_a_pagar){

            $cuenta = CuentaVario::create([
                'persona_id' => $persona->id,
                'forma_pago_id' => $forma_pago,
                'ingreso_vario_id' => $ingreso->id,
                'fecha_ingreso' => $fecha_actual,
                'mes' => $mes,
                'año' => $anio,
                'numero_recibo' => $numero_recibo,
                'sucursal' => '000',
                'general' => '000',
                'factura_numero' => '0000000',
                'total_pagado' => $monto_a_pagar,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);

            $aux_monto = $monto_a_pagar;
            for ($i=0; $i < count($concepto); $i++) {
                $saldo = 0;
                if($aux_monto >= $precio_total[$i]){
                    $pagar = $precio_total[$i];
                    $aux_monto = $aux_monto - $precio_total[$i];
                    $saldo = 0;
                }else{
                    if($aux_monto < $precio_total[$i]){
                        $pagar = $aux_monto;
                        $saldo = $precio_total[$i] - $aux_monto;
                        $aux_monto = 0;
                    }else{
                        if($aux_monto == 0){
                            $pagar = 0;
                            $saldo = $precio_total[$i];
                            $aux_monto = 0;
                        }
                    }
                }

                $cuenta_detalle = CuentaVarioDetalle::create([
                    'persona_id' => $persona->id,
                    'cuenta_vario_id' => $cuenta->id,
                    'ingreso_concepto_id' => $concepto[$i],
                    'descripcion' => '',
                    'precio_unitario' => $precio[$i],
                    'cantidad' => $cantidad[$i],
                    'total_pagar' => $precio_total[$i],
                    'monto_pagado' => $pagar,
                    'saldo' => $saldo,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }
        }

        return redirect()->route('ingreso_varios.ver_recibo', $ingreso)->with('message', 'Se realizo con exito el cobro.');
    }

    public function ver_recibo(IngresoVarios $ingreso)
    {

        return view('ingreso_varios.recibo', compact('ingreso'));
    }
}
