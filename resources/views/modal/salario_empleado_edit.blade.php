<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modal_salario_empleado_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Editar Salario</h5>
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
                                $nombre = $documento . ' - ' . $nombre . ' ' . $apellido;
                            @endphp
                            <input type="text" class="form-control" value="{{$nombre}}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Tipo de Cobro</label>
                            <select wire:model.defer="salario_pago_id" class="form-control">
                                @foreach ($salario_pago as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Forma Pago</label>
                            <select wire:model.defer="forma_pago_id" class="form-control">
                                @foreach ($forma_pago as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ingreso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Anticipo</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -20px">
                            <table id="" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="70%">Concepto</th>
                                        <th width="30%">Importe</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @for ($i = 0; $i < count($concepto_ingreso); $i++)
                                        <tr>
                                            <td>{{$descripcion_ingreso[$i]}}</td>
                                            <td>
                                                <input type="text" class="form-control text-right" wire:model.defer="monto_ingreso.{{$i}}" onkeyup="punto_decimal_limite(this)">
                                            </td>
                                        </tr>
                                    @endfor
                                    <tr style="background: blueviolet">
                                        <td colspan="2" style="font-weight: bold; color:white; font-size:15px">Egreso</td>
                                    </tr>

                                    @if (count($concepto_egreso) <= 0)
                                        <tr>
                                            <td colspan="2">No hay egresos</td>
                                        </tr>
                                    @endif
                                    @for ($i = 0; $i < count($concepto_egreso); $i++)
                                        <tr>
                                            <td>{{$descripcion_egreso[$i]}}</td>
                                            <td class="text-right">
                                                {{$monto_egreso[$i]}}
                                            </td>
                                        </tr>
                                    @endfor

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="color: white;font-size: 15px">Neto</th>
                                        <th colspan="2" class="text-right" style="color: white;font-size: 15px">
                                            <b> {{number_format($neto_empleado, 0, ".", ".")}}</b>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
                            <table id="" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="60%">Concepto</th>
                                        <th width="20%">Fecha</th>
                                        <th width="20%">Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($anticipo_detalle) > 0)
                                        @foreach ($anticipo_detalle as $item)
                                            <tr>
                                                <td style="font-size: 11px">
                                                    {{$item->concepto->descripcion}}
                                                </td>
                                                <td style="font-size: 11px">
                                                    {{date('d/m/Y H:i', strtotime($item->created_at))}}
                                                </td>
                                                <td class="text-right" style="font-size: 11px">
                                                    {{number_format($item->importe, 0, ".", ".")}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="color: white;font-size: 15px">Total Egreso</th>
                                        <th colspan="2" class="text-right" style="color: white;font-size: 15px">
                                            @if (count($anticipo_detalle) > 0)
                                                <b> {{number_format($anticipo_detalle->sum('importe'), 0, ".", ".")}}</b>
                                            @else
                                                <b>0</b>
                                            @endif
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="update_empleado" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

</div>
