<?php

namespace App\Http\Livewire\PagoVario;

use App\Models\FormaPago;
use App\Models\Insumo;
use App\Models\Pago;
use App\Models\PagoVarios;
use Carbon\Carbon;
use Livewire\Component;

class InsumoActivo extends Component
{
    public $descripcion, $precio=0, $pago, $reporte_id = 0;
    public $pago_descripcion, $pago_precio, $insumo, $forma_pago, $forma_pago_id, $mes, $año;

    protected $listeners = ['delete'];

    public function mount()
    {
        $this->forma_pago = FormaPago::all();
        $this->forma_pago_id = 1;
    }

    public function render()
    {
        $data = Insumo::where('estado_id', 1)->latest()->get();
        return view('livewire.pago-vario.insumo-activo', compact('data'));
    }


    public function save()
    {
        if(empty($this->descripcion)){
            $this->emit('mensaje_error', 'La descripción del nuevo insumo no puede ser vacio.');
            $this->resetUI();
            return false;
        }

        if(empty($this->precio)){
            $this->emit('mensaje_error', 'El precio del insumo no puede ser vacio.');
            $this->resetUI();
            return false;
        }
        $precio = str_replace('.', '', $this->precio);
        if($precio == 0){
            $this->emit('mensaje_error', 'El precio del insumo no puede ser cero.');
            $this->resetUI();
            return false;
        }

        $aux_existe = Insumo::where('descripcion', 'LIKE', '%' . $this->descripcion . '%')
        ->first();

        if($aux_existe){
            $this->emit('mensaje_error', 'Ya existe insumo con esta descripcion.');
            $this->resetUI();
            return false;
        }

        Insumo::create([
            'descripcion' => $this->descripcion,
            'precio' => $precio,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $this->emit('correcto', 'Se creo con existo al empleado.');
        $this->resetUI();
    }

    public function edit($id)
    {
        $this->insumo = Insumo::find($id);
        $this->pago_descripcion = $this->insumo->descripcion;
        $this->pago_precio = number_format($this->insumo->precio, 0, ".", ".");
        if($id <= 3){
            $pago = PagoVarios::join('pagos AS a', 'pago_varios.pago_id', '=', 'a.id')
            ->select('pago_varios.*', 'a.año', 'a.mes')
            ->where('pago_varios.insumo_id', $id)
            ->where('a.estado_id', 1)
            ->orderBy('año', 'DESC')
            ->orderBy('mes', 'DESC')
            ->first();

            if($pago){
                $mes = $pago->mes;
                if($mes == 12){
                    $this->mes = 1;
                    $this->año = $pago->año + 1;
                }else{
                    $this->mes = $pago->mes + 1;
                    $this->año = $pago->año;
                }

            }else{
                $fecha_actual = Carbon::now();
                $this->mes = intval(date('m', strtotime($fecha_actual)));
                $this->año = intval(date('Y', strtotime($fecha_actual)));
            }
        }
    }

    public function pago()
    {
        if(empty($this->pago_precio)){
            $this->emit('mensaje_error', 'El precio del insumo no puede ser vacio.');
            $this->resetUI();
            return false;
        }

        $precio = str_replace('.', '', $this->pago_precio);
        $insumo = $this->insumo;

        if($precio == 0){
            $this->emit('mensaje_error', 'El precio del insumo no puede ser cero.');
            $this->resetUI();
            return false;
        }

        if($insumo->id <= 3){
            $pago = PagoVarios::join('pagos AS a', 'pago_varios.pago_id', '=', 'a.id')
            ->select('pago_varios.*', 'a.año', 'a.mes')
            ->where('pago_varios.insumo_id', $insumo->id)
            ->where('a.estado_id', 1)
            ->where('año', $this->año)
            ->where('mes', $this->mes)
            ->first();

            if($pago){
                $this->emit('mensaje_error', 'Ya se realizo el pago por el mes:'. $this->mes .' y el año: ' . $this->año .' del insumo de: '. $insumo->descripcion .'.');
                $this->resetUI();
                return false;
            }
        }

        $fecha_actual = Carbon::now();
        $mes = intval(date('m', strtotime($fecha_actual)));
        $anio = intval(date('Y', strtotime($fecha_actual)));
        $numero_recibo = Pago::where('año', $anio)
        ->max('numero_recibo');

        $numero_recibo = $numero_recibo + 1;

        $pago = Pago::create([
            'pago_tipo_id' => 4,
            'fecha' => $fecha_actual,
            'mes' => $mes,
            'año' => $anio,
            'importe' => $precio,
            'forma_pago_id' => $this->forma_pago_id,
            'procesado' => 0,
            'sucursal' => '0000',
            'general' => '0000',
            'factura_numero' => 0,
            'numero_recibo' => $numero_recibo,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $pago->pago_varios()->create([
            'insumo_id' => $insumo->id,
            'importe' => $precio,
            'estado_id' => 1,
            'user_id' => auth()->user()->id,
            'modif_user_id' => auth()->user()->id,
        ]);

        $insumo->precio = $precio;
        $insumo->modif_user_id = auth()->user()->id;
        $insumo->update();

        $this->pago = $pago;
        $this->reporte_id = $pago->id;
        $this->emit('reporte', 'Se cargo con exito el pago.');

    }

    public function delete(Insumo $insumo)
    {
        $insumo->estado_id = 2;
        $insumo->modif_user_id = auth()->user()->id;
        $insumo->update();

        $this->emit('correcto', 'Insumo eliminado con exito.');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->reset('descripcion');
        $this->reset('precio');
        $this->reset('pago_descripcion');
        $this->reset('pago_precio');
        $this->reset('insumo');
        $this->reset('mes');
        $this->reset('año');
        $this->forma_pago_id = 1;
        $this->reporte_id = 0;
    }
}
