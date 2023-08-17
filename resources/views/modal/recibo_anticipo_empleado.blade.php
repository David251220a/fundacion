<div wire:ignore.self class="modal fade bd-example-modal-lg" id="recibo_anticipo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">

                @if ($pago)
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                        <div class="caja">
                            <table>
                                <tr>
                                    <th width="60%">
                                        <img class="navbar-logo" src="{{Storage::url('public/iconos/logo_horizontal-1.png')}}" alt="logo" style="width: 50%">
                                    </th>
                                    <th width="40%">
                                        <p>N° Recibo:</p>
                                        <p>{{$pago->año}}-C-{{ str_pad($pago->numero_recibo, 6, '0', STR_PAD_LEFT) }}</p>
                                    </th>
                                </tr>

                            </table>

                            <div class="datos">
                                @foreach ($pago->pago_empleado as $item)
                                    Documento: {{number_format($item->empleado->persona->documento, 0, ".", ".")}}
                                    <br>
                                    Nombre y apellido: {{$item->empleado->persona->nombre}} {{$item->empleado->persona->apellido}}
                                    <br>
                                    Remuneración: {{number_format($item->empleado->ingreso->where('salario_concepto_id')->sum('importe'), 0, ".", ".")}}
                                @endforeach
                            </div>
                            <br>
                            <table class="" style="width:100%; margin: 2px 2px">
                                <thead >
                                    <tr>
                                        <th width="50%">
                                            Concepto
                                        </th>
                                        <th width="50%" style="text-align: right">
                                            Importe
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pago->pago_empleado as $item)
                                        <tr style="font-weight: bold">
                                            <td style="font-weight: bold">
                                                {{$item->concepto->descripcion}}
                                            </td>
                                            <td style="text-align: right; font-weight: bold">{{number_format($item->importe, 0, ".", ".")}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif


            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
                <a href="{{route('pdf.recibo_anticipo_empleado', $reporte_id)}}" target="__blank" class="btn btn-primary">Imprimir</a>
            </div>
        </div>
    </div>

</div>
