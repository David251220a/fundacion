<div wire:ignore.self class="modal fade bd-example-modal-lg" id="recibo_comprobante_ingreso" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @if ($ingreso)
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                        <div class="caja">
                            <table>
                                <tr>
                                    <th width="60%">
                                        <img class="navbar-logo" src="{{Storage::url('public/iconos/logo_horizontal-1.png')}}" alt="logo" style="width: 50%">
                                    </th>
                                    <th width="40%">
                                        <p>N° Recibo:</p>
                                        <p>{{$ingreso->año}}-B-{{ str_pad($ingreso->numero_recibo, 6, '0', STR_PAD_LEFT) }}</p>
                                    </th>
                                </tr>

                            </table>

                            <div class="datos">
                                Documento: {{number_format($ingreso->persona->documento, 0, ".", ".")}}
                                <br>
                                Nombre y apellido: {{$ingreso->persona->nombre}} {{$ingreso->persona->apellido}}
                            </div>

                            <br>

                            <table class="" style="width:100%; margin: 2px 2px">
                                <thead >
                                    <tr>
                                        <th width="50%">
                                            Descripcion
                                        </th>
                                        <th width="25%" style="text-align: right">
                                            Cantidad * P. Unitario
                                        </th>
                                        <th width="25%" style="text-align: right">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_a_pagar = 0;
                                        $saldo = 0;
                                    @endphp
                                    @foreach ($ingreso->detalle as $item)
                                        <tr style="font-weight: bold">
                                            <td style="font-weight: bold">{{$item->concepto->descripcion}}</td>
                                            <td style="text-align: right; font-weight: bold">{{$item->cantidad}} * {{number_format($item->precio_unitario, 0, ".", ".")}}</td>
                                            <td style="text-align: right; font-weight: bold">{{number_format($item->total_pagar, 0, ".", ".")}}</td>
                                            @php
                                                $total_a_pagar += $item->total_pagar;
                                                $saldo += $item->saldo;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="font-size: 1.2rem">
                                    <tr>
                                        <td colspan="2" style="padding-top: 10px">Total a Pagar</td>
                                        <td style="text-align: right; font-weight: bold; padding-top: 10px">{{number_format($total_a_pagar, 0, ".", ".")}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Monto Pagado</td>
                                        <td style="text-align: right; font-weight: bold">{{number_format($ingreso->total_pagado, 0, ".", ".")}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Saldo</td>
                                        <td style="text-align: right; font-weight: bold">{{number_format($saldo, 0, ".", ".")}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endif


            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
                <a href="{{route('ingreso_vario.recibo_vario_insumo', $valor_id)}}" class="btn btn-primary" target="__blank">Imprimir</a>
            </div>
        </div>
    </div>

</div>

