<?php

namespace App\Http\Controllers;

use App\Models\CierreCaja;
use App\Models\Egreso;
use App\Models\Empleado;
use App\Models\FormaPago;
use App\Models\Pago;
use App\Models\PagoEmpleado;
use App\Models\SalarioCierre;
use App\Models\SalarioCierreDetalle;
use App\Models\SalarioEmpleado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoEmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pago_empleados.index')->only('index');
        $this->middleware('permission:pago_empleados.create')->only('create');
        $this->middleware('permission:pago_empleados.create')->only('store');
        $this->middleware('permission:pago_empleados.show')->only('show');
    }

    public function index()
    {
        $data_pago = SalarioCierre::where('estado_id', 1)
        ->take(12)
        ->latest()
        ->get();

        return view('pago.empleado.index', compact('data_pago'));
    }

    public function create()
    {
        $data = Empleado::where('estado_id', 1)
        ->get();

        $mayor = Pago::where('estado_id', 1)
        ->where('pago_tipo_id', 1)
        ->select('fecha')
        ->max('fecha');


        if(empty($mayor)){
            $mes  = date('m', strtotime(Carbon::now()));
            $año  = date('Y', strtotime(Carbon::now()));
        }else{

            $mes  = date('m', strtotime(Carbon::now()));
            $año  = date('Y', strtotime(Carbon::now()));
        }

        $forma_pago = FormaPago::all();

        return view('pago.empleado.create', compact('data', 'forma_pago', 'mes', 'año'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'mes' => 'required',
        //     'anio' => 'required',
        // ]);

        // *------ SE COMENTA ESTA PARTE POR QUE EL COBRO ES SEMANAL

        // $existe = Pago::where('estado_id', 1)
        // ->where('pago_tipo_id', 1)
        // ->where('mes', $request->mes)
        // ->where('año', $request->anio)
        // ->first();

        // if (!(empty($existe))) {
        //     return redirect()->back()->withInput()->withErrors('Ya existe un cierre de planilla con este mes y año:'. $mes .'/'. $año . '.');
        // }

        // $año = $request->anio;
        // $mes = $request->mes;

        $fecha_actual = Carbon::now();
        $año = intval(date('Y', strtotime($fecha_actual)));
        $mes = intval(date('m', strtotime($fecha_actual)));
        $numero_recibo = Pago::where('año', $año)
        ->max('numero_recibo');

        $aux_fecha = $año . "-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . '01';
        $fecha = date('Y-m-d', strtotime($fecha_actual));
        $data = Empleado::where('estado_id', 1)
        ->get();

        $cierre = CierreCaja::create([
            'fecha' => $fecha_actual,
            'total_ingreso' => 0,
            'total_egreso' => str_replace('.', '', $request->neto_importe),
            'observacion' => 'PAGO EMPLEADOS',
            'cajero' => auth()->user()->id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        Egreso::create([
            'cierre_caja_id' => $cierre->id,
            'pago_tipo_id' => 1,
            'forma_pago_id' => $request->forma_pago_id,
            'fecha' => $fecha_actual,
            'importe' => str_replace('.', '', $request->neto_importe),
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $pago = Pago::create([
            'pago_tipo_id' => 1,
            'fecha' => $fecha,
            'mes' => $mes,
            'año' => $año,
            'importe' => str_replace('.', '', $request->neto_importe),
            'forma_pago_id' => $request->forma_pago_id,
            'procesado' => 1,
            'sucursal' => '0000',
            'general' => '0000',
            'factura_numero' => 0,
            'numero_recibo' => $numero_recibo,
            'cierre_caja_id' => $cierre->id,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        foreach ($data as $item) {
            foreach ($item->ingreso->where('salario_concepto_id', 1) as $ingre) {
                $pago->pago_empleado()->create([
                    'empleado_id' => $item->id,
                    'salario_concepto_id' => $ingre->salario_concepto_id,
                    'salario_base' => $ingre->importe,
                    'importe' => $ingre->importe - $item->egreso->sum('importe'),
                    'tipo' => 1,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);
            }
        }

        $total_salario = SalarioEmpleado::where('estado_id', 1)
        ->where('tipo', 1)
        ->sum('importe');

        $total_descuento = SalarioEmpleado::where('estado_id', 1)
        ->where('tipo', 2)
        ->sum('importe');

        $cierre = SalarioCierre::create([
            'forma_pago_id' => $request->forma_pago_id,
            'pago_tipo_id' => 1,
            'pago_id' => $pago->id,
            'salario_pago_id' => 1,
            'fecha_cierre' => $fecha,
            'total_salario' => $total_salario,
            'total_descuento' => $total_descuento,
            'total_neto' => ($total_salario - $total_descuento),
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        foreach ($data as $item) {
            foreach ($item->todos as $concepto) {
                SalarioCierreDetalle::create([
                    'salario_cierre_id' => $cierre->id,
                    'empleado_id' => $item->id,
                    'salario_concepto_id' => $concepto->salario_concepto_id,
                    'importe' => $concepto->importe,
                    'tipo' => $concepto->tipo,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);

                if($concepto->salario_concepto_id == 2){
                    $concepto->importe = 0;
                    $concepto->modif_user_id = auth()->user()->id;
                    $concepto->update();
                }
            }
        }

        return redirect()->route('pago_empleados.index')->with('message', 'Cierra planilla realizado con exito.');
    }

    public function show($pago)
    {
        $data = SalarioCierre::find($pago);

        $empleado = SalarioCierreDetalle::where('salario_cierre_id', $data->id)
        ->where('estado_id', 1)
        ->select('empleado_id')
        ->groupBy('empleado_id')
        ->get();

        $salario = SalarioCierreDetalle::where('salario_cierre_id', $data->id)
        ->where('tipo', 1)
        ->where('estado_id', 1)
        ->select('empleado_id', DB::raw('SUM(importe) AS salario'))
        ->groupBy('empleado_id')
        ->get();

        $egreso = SalarioCierreDetalle::where('salario_cierre_id', $data->id)
        ->where('tipo', 2)
        ->where('estado_id', 1)
        ->select('empleado_id', DB::raw('SUM(importe) AS egreso'))
        ->groupBy('empleado_id')
        ->get();

        return view('pago.empleado.show', compact('data', 'salario', 'empleado', 'egreso'));
    }

    public function anular($pago)
    {
        $salarioCierre = SalarioCierre::find($pago);
        $salarioCierre->estado_id = 2;
        $salarioCierre->modif_user_id = auth()->user()->id;
        $salarioCierre->update();

        foreach ($salarioCierre->detalle as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();

            $salario = SalarioEmpleado::where('empleado_id', $item->empleado_id)
            ->where('salario_concepto_id', $item->salario_concepto_id)
            ->first();

            $salario->importe = $item->importe;
            $salario->modif_user_id = auth()->user()->id;
            $salario->update();
        }

        $pago = Pago::find($salarioCierre->pago_id);
        $pago->estado_id = 2;
        $pago->modif_user_id = auth()->user()->id;
        $pago->update();

        foreach ($pago->pago_empleado as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        $cierre = CierreCaja::find($pago->cierre_caja_id);
        $cierre->estado_id = 2;
        $cierre->modif_user_id = auth()->user()->id;
        $cierre->update();

        foreach ($cierre->egresos as $item) {
            $item->estado_id = 2;
            $item->modif_user_id = auth()->user()->id;
            $item->update();
        }

        return redirect()->route('pago_empleados.index')->with('message', 'Se ha anulado con exito el cierre de planilla');

    }

}
