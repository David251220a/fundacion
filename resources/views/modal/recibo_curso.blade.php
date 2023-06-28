<div wire:ignore.self class="modal fade bd-example-modal-lg" id="recibo_comprobante" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                        <p>{{$ingreso->año}}-A-{{ str_pad($ingreso->numero_recibo, 6, '0', STR_PAD_LEFT) }}</p>
                                    </th>
                                </tr>

                            </table>

                            <div class="datos">
                                Documento: {{number_format($ingreso->alumno->persona->documento, 0, ".", ".")}}
                                <br>
                                Nombre y apellido: {{$ingreso->alumno->persona->nombre}} {{$ingreso->alumno->persona->apellido}}
                            </div>

                            <br>

                            <table class="" style="width:100%; margin: 2px 2px">
                                <thead >
                                    <tr>
                                        <th width="50%">
                                            Descripcion
                                        </th>
                                        <th width="16%" style="text-align: right">
                                            Monto a Pagar
                                        </th>
                                        <th width="16%" style="text-align: right">
                                            Total Pagado
                                        </th>
                                        <th width="16%" style="text-align: right">
                                            Saldo
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
                                            <td style="font-weight: bold">
                                                {{$item->curso_habilitado->curso->descripcion}} -
                                                {{$item->curso_habilitado->curso->modulo->descripcion}}
                                            </td>
                                            <td style="text-align: right; font-weight: bold">{{number_format($item->monto_total, 0, ".", ".")}}</td>
                                            <td style="text-align: right; font-weight: bold">{{number_format($item->monto_pagado, 0, ".", ".")}}</td>
                                            <td style="text-align: right; font-weight: bold">{{number_format($item->saldo, 0, ".", ".")}}</td>
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
                <a href="#" class="btn btn-primary">Imprimir</a>
            </div>
        </div>
    </div>

</div>
