<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\FormaPago;
use App\Models\Pago;
use App\Models\PagoEmpleado;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $data_pago = Pago::where('pago_tipo_id', 1)
        ->where('estado_id', 1)
        ->take(12)
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
            $mes = 8;
            $año = 2023;
        }else{

            $mes  = date('m', strtotime($mayor)) + 1;
            $año  = date('Y', strtotime($mayor));
            if($mes == 12){
                $mes = 1;
                $año = $año + 1;
            }

        }

        $forma_pago = FormaPago::all();

        return view('pago.empleado.create', compact('data', 'forma_pago', 'mes', 'año'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mes' => 'required',
            'anio' => 'required',
        ]);

        $existe = Pago::where('estado_id', 1)
        ->where('pago_tipo_id', 1)
        ->where('mes', $request->mes)
        ->where('año', $request->anio)
        ->first();

        $año = $request->anio;
        $mes = $request->mes;

        if (!(empty($existe))) {
            return redirect()->back()->withInput()->withErrors('Ya existe un cierre de planilla con este mes y año:'. $mes .'/'. $año . '.');
        }

        $fecha_actual = Carbon::now();
        $aux_anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = Pago::where('año', $aux_anio)
        ->max('numero_recibo');

        $aux_fecha = $año . "-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . '01';
        $fecha = date('Y-m-d', strtotime($aux_fecha));
        $data = Empleado::where('estado_id', 1)
        ->get();


        $pago = Pago::create([
            'pago_tipo_id' => 1,
            'fecha' => $fecha,
            'mes' => $mes,
            'año' => $año,
            'importe' => str_replace('.', '', $request->neto_importe),
            'forma_pago_id' => $request->forma_pago_id,
            'procesado' => 0,
            'sucursal' => '0000',
            'general' => '0000',
            'factura_numero' => 0,
            'numero_recibo' => $numero_recibo,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        foreach ($data as $item) {
            foreach ($item->ingreso->where('salario_concepto_id', 1) as $ingre) {
                $pago->pago_empleado()->create([
                    'empleado_id' => $item->id,
                    'salario_concepto_id' => $ingre->salario_concepto_id,
                    'importe' => $ingre->importe - $item->egreso->sum('importe'),
                    'tipo' => 1,
                    'estado_id' => 1,
                    'user_id' => auth()->user()->id,
                    'modif_user_id' => auth()->user()->id,
                ]);

                foreach ($item->egreso->where('salario_concepto_id', 2) as $egre) {
                    $egre->importe = 0;
                    $egre->modif_user_id = auth()->user()->id;
                    $egre->update();
                }
            }

        }
        return redirect()->route('pago_empleados.index')->with('message', 'Cierra planilla realizado con exito.');
    }

    public function show(Pago $pago)
    {
        $anticipo = PagoEmpleado::join('pagos AS a', 'pago_empleados.pago_id', '=', 'a.id')
        ->where('a.estado_id', 1)
        ->where('pago_empleados.salario_concepto_id', 2)
        ->where('a.mes', $pago->mes)
        ->where('a.año', $pago->año)
        ->select('pago_empleados.*', 'a.mes', 'a.año')
        ->get();

        return view('pago.empleado.show', compact('pago', 'anticipo'));
    }

}
