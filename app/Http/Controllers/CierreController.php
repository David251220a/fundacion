<?php

namespace App\Http\Controllers;

use App\Models\CierreCaja;
use App\Models\Egreso;
use App\Models\Ingreso;
use App\Models\IngresoMatricula;
use App\Models\IngresoVarios;
use App\Models\Pago;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CierreController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:cierre.cajero')->only('cajero');
        $this->middleware('permission:cierre.cajero')->only('cajero_post');
        $this->middleware('permission:cierre.cajero_ver')->only('cajero_ver');
        $this->middleware('permission:cierre.falta_cierre')->only('falta_cierre');
        $this->middleware('permission:cierre.cierre_gerente')->only('cierre_gerente');
        $this->middleware('permission:cierre.cierre_gerente')->only('cierre_gerente_post');
        $this->middleware('permission:cierre.consulta_gerente')->only('consulta_gerente');
    }

    public function cajero()
    {
        $user = auth()->user();
        $fecha_actual = Carbon::now();
        $fecha = date('Y-m-d', strtotime($fecha_actual));

        $matricula = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 1)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $certificado = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 2)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $insumo = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '<>', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $ingreso_vario = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '=', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $pago = Pago::where('user_id', $user->id)
        ->where('estado_id', 1)
        ->whereNotIn('pago_tipo_id', [1, 2])
        ->where('fecha', $fecha)
        ->where('procesado', 0)
        ->select('forma_pago_id', 'fecha', 'pago_tipo_id', DB::raw('SUM(importe) AS total'))
        ->groupBy('forma_pago_id', 'fecha', 'pago_tipo_id')
        ->get();

        return view('cierre.cajero', compact('matricula', 'certificado', 'insumo', 'ingreso_vario', 'pago', 'user'));
    }

    public function cajero_post(Request $request)
    {

        $ingreso = str_replace('.', '', $request->ingreso);
        $egreso = str_replace('.', '', $request->egreso);
        $observacion = $request->observacion;
        $user = auth()->user();

        if(($ingreso == 0) && ($egreso == 0)) {
            return redirect()->back()->withInput()->withErrors('No hay registro para el cierre de caja');
        }

        $fecha_actual = Carbon::now();
        $fecha = date('Y-m-d', strtotime($fecha_actual));

        $cierre = CierreCaja::create([
            'fecha' => $fecha,
            'total_ingreso' => $ingreso,
            'total_egreso' => $egreso,
            'observacion' => $observacion,
            'cajero' => auth()->user()->id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $matricula = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 1)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($matricula as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 1,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $certificado = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 2)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($certificado as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 2,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $insumo = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '<>', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($insumo as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 3,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $ingreso_vario = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '=', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($ingreso_vario as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 4,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }


        $pago = Pago::where('user_id', $user->id)
        ->where('estado_id', 1)
        ->whereNotIn('pago_tipo_id', [1, 2])
        ->where('fecha', $fecha)
        ->where('procesado', 0)
        ->select('forma_pago_id', 'fecha', 'pago_tipo_id', DB::raw('SUM(importe) AS total'))
        ->groupBy('forma_pago_id', 'fecha', 'pago_tipo_id')
        ->get();

        foreach ($pago as $item) {
            Egreso::create([
                'cierre_caja_id' => $cierre->id,
                'pago_tipo_id' => $item->pago_tipo_id,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        // ACTUALIZA A PROCESADO
        $ingresos_matricula = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->get();

        foreach ($ingresos_matricula as $item) {
            $item->procesado = 1;
            $item->cierre_caja_id = $cierre->id;
            $item->modif_user_id = $user->id;
            $item->update();
        }

        $ingreso = IngresoVarios::where('fecha_ingreso', $fecha)
        ->where('estado_id', 1)
        ->where('procesado', 0)
        ->where('user_id', $user->id)
        ->get();

        foreach ($ingreso as $item) {
            $item->procesado = 1;
            $item->cierre_caja_id = $cierre->id;
            $item->modif_user_id = $user->id;
            $item->update();
        }

        $pago = Pago::where('user_id', $user->id)
        ->where('estado_id', 1)
        ->where('fecha', $fecha)
        ->where('procesado', 0)
        ->get();

        foreach ($pago as $item){
            $item->procesado = 1;
            $item->cierre_caja_id = $cierre->id;
            $item->modif_user_id = $user->id;
            $item->update();
        }

        return redirect()->route('cierre.cajero_ver', $cierre)->with('message', 'Cierre realizado con exito.');

    }

    public function cajero_ver(CierreCaja $cierreCaja)
    {
        $user = auth()->user();
        return view('cierre.show', compact('cierreCaja', 'user'));
    }

    public function falta_cierre()
    {

        $fecha_actual = Carbon::now();
        $fecha = date('Y-m-d', strtotime($fecha_actual));

        $matricula = IngresoMatricula::where('fecha_ingreso', $fecha)
        ->where('estado_id', 1)
        ->where('procesado', 0)
        ->select('user_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('user_id', 'fecha_ingreso')
        ->get();

        $insumo = IngresoVarios::where('fecha_ingreso', $fecha)
        ->where('estado_id', 1)
        ->where('procesado', 0)
        ->select('user_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('user_id', 'fecha_ingreso')
        ->get();

        $pago = Pago::where('estado_id', 1)
        ->where('procesado', 0)
        ->whereNotIn('pago_tipo_id', [1, 2])
        ->where('fecha', $fecha)
        ->select('user_id', 'fecha', DB::raw('SUM(importe) AS total'))
        ->groupBy('user_id', 'fecha')
        ->get();

        $data = CierreCaja::where('estado_id', 1)
        ->where('fecha', $fecha)
        ->get();

        return view('cierre.falta_cierre', compact('matricula', 'insumo', 'pago', 'data', 'fecha_actual'));
    }

    public function cierre_gerente(User $user)
    {
        $fecha_actual = Carbon::now();
        $fecha = date('Y-m-d', strtotime($fecha_actual));

        $matricula = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 1)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $certificado = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 2)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $insumo = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '<>', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $ingreso_vario = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '=', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        $pago = Pago::where('user_id', $user->id)
        ->where('estado_id', 1)
        ->where('fecha', $fecha)
        ->whereNotIn('pago_tipo_id', [1, 2])
        ->where('procesado', 0)
        ->select('forma_pago_id', 'fecha', 'pago_tipo_id', DB::raw('SUM(importe) AS total'))
        ->groupBy('forma_pago_id', 'fecha', 'pago_tipo_id')
        ->get();

        return view('cierre.cierre_gerente', compact('matricula', 'certificado', 'insumo', 'ingreso_vario', 'pago', 'user'));
    }

    public function cierre_gerente_post(User $user, Request $request)
    {
        $ingreso = str_replace('.', '', $request->ingreso);
        $egreso = str_replace('.', '', $request->egreso);
        $observacion = $request->observacion;

        if(($ingreso == 0) && ($egreso == 0)) {
            return redirect()->back()->withInput()->withErrors('No hay registro para el cierre de caja');
        }

        $fecha_actual = Carbon::now();
        $fecha = date('Y-m-d', strtotime($fecha_actual));

        $cierre = CierreCaja::create([
            'fecha' => $fecha,
            'total_ingreso' => $ingreso,
            'total_egreso' => $egreso,
            'observacion' => $observacion,
            'cajero' => $user->id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $matricula = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 1)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($matricula as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 1,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $certificado = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('tipo_cobro', 2)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($certificado as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 2,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $insumo = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '<>', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($insumo as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 3,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        $ingreso_vario = IngresoVarios::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->where('fecha_ingreso', $fecha)
        ->where('curso_ingreso_id', '=', 0)
        ->select('forma_pago_id', 'fecha_ingreso', DB::raw('SUM(total_pagado) AS total'))
        ->groupBy('forma_pago_id', 'fecha_ingreso')
        ->get();

        foreach ($ingreso_vario as $item) {
            Ingreso::create([
                'cierre_caja_id' => $cierre->id,
                'ingreso_tipo_id' => 4,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }


        $pago = Pago::where('user_id', $user->id)
        ->where('estado_id', 1)
        ->where('fecha', $fecha)
        ->whereNotIn('pago_tipo_id', [1, 2])
        ->where('procesado', 0)
        ->select('forma_pago_id', 'fecha', 'pago_tipo_id', DB::raw('SUM(importe) AS total'))
        ->groupBy('forma_pago_id', 'fecha', 'pago_tipo_id')
        ->get();

        foreach ($pago as $item) {
            Egreso::create([
                'cierre_caja_id' => $cierre->id,
                'pago_tipo_id' => $item->pago_tipo_id,
                'forma_pago_id' => $item->forma_pago_id,
                'fecha' => $fecha,
                'importe' => $item->total,
                'estado_id' => 1,
                'user_id' => auth()->user()->id,
                'modif_user_id' => auth()->user()->id,
            ]);
        }

        // ACTUALIZA A PROCESADO
        $ingresos_matricula = IngresoMatricula::where('estado_id', 1)
        ->where('user_id', $user->id)
        ->where('procesado', 0)
        ->get();

        foreach ($ingresos_matricula as $item) {
            $item->procesado = 1;
            $item->cierre_caja_id = $cierre->id;
            $item->modif_user_id = $user->id;
            $item->update();
        }

        $ingreso = IngresoVarios::where('fecha_ingreso', $fecha)
        ->where('estado_id', 1)
        ->where('procesado', 0)
        ->where('user_id', $user->id)
        ->get();

        foreach ($ingreso as $item) {
            $item->procesado = 1;
            $item->cierre_caja_id = $cierre->id;
            $item->modif_user_id = $user->id;
            $item->update();
        }

        $pago = Pago::where('user_id', $user->id)
        ->where('estado_id', 1)
        ->whereNotIn('pago_tipo_id', [1, 2])
        ->where('fecha', $fecha)
        ->where('procesado', 0)
        ->get();

        foreach ($pago as $item){
            $item->procesado = 1;
            $item->cierre_caja_id = $cierre->id;
            $item->modif_user_id = $user->id;
            $item->update();
        }

        return redirect()->route('cierre.falta_cierre')->with('message', 'Cierre realizado con exito.');
    }

    public function consulta_gerente()
    {
        return view('cierre.consulta');
    }
}
