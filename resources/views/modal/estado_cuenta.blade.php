<div wire:ignore.self class="modal fade bd-example-modal-lg" id="moda_estado_cuenta" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Estado de Cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">

                <div id="" class="col-lg-12">
                    <div class="form-row mb-2">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Nombre y Apellido</label>
                            @php
                                $nombre = $documento_e_modal . ' - '. $nombre_e_modal;
                            @endphp
                            <input value = "{{$nombre}}" type="text" class="form-control" readonly>
                            {{-- <input wire:model.defer="documento_e_modal" type="text" class="form-control" readonly> --}}
                        </div>

                        {{-- <div class="form-group col-md-9">
                            <label for="inputPassword4">Nombre y Apellido</label>
                            <input wire:model.defer="nombre_e_modal" type="text" class="form-control" readonly>
                        </div> --}}

                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <div class="table-responsive widget-content widget-content-area br-6">
                                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nº Recibo</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Forma Pago</th>
                                            <th>Total a Pagar</th>
                                            <th>Total Pagado</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cuenta as $item)
                                            <tr>
                                                <td>
                                                    {{$item->ingreso_matricula->año}} - {{$item->ingreso_matricula->numero_recibo}}
                                                </td>
                                                <td>
                                                    {{date('d/m/Y', strtotime($item->ingreso_matricula->fecha_ingreso))}}
                                                </td>

                                                <td>
                                                    {{$item->ingreso_matricula->forma_pago->descripcion}}
                                                </td>
                                                <td>
                                                    {{number_format($item->monto_total, 0, ".", ".")}}
                                                </td>
                                                <td>
                                                    {{number_format($item->monto_pagado, 0, ".", ".")}}
                                                </td>
                                                <td>
                                                    {{number_format($item->saldo, 0, ".", ".")}}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Atras</button>
            </div>
        </div>
    </div>

</div>
