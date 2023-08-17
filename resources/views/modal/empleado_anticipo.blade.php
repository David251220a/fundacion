<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modal_salario_empleado_anticipo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Solicitar Anticipo</h5>
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
                            <label for="inputPassword4">Forma Pago</label>
                            <select wire:model.defer="anticipo_forma_pago_id" class="form-control">
                                @foreach ($forma_pago as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Monto Anticipo</label>
                            <input type="text" wire:model.defer = "monto_anticipo" class="form-control text-right" onkeyup="punto_decimal_limite_precio(this)">
                            @php
                                $limite = 0;
                            @endphp
                            @if (!(empty($empleado)))
                                @php
                                    $limite = $empleado->ingreso->where('salario_concepto_id', 1)->sum('importe') - $empleado->egreso->sum('importe');
                                @endphp
                            @endif
                            <input type="hidden" id="curso_precio" value="{{str_replace('.', '', $limite)}}">

                        </div>
                    </div>
                </div>

                <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -15px">
                    <table id="" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="2">Ingreso</th>
                            </tr>
                            <tr>
                                <th width="70%">Concepto</th>
                                <th width="30%">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!(empty($empleado)))
                                @foreach ($empleado->ingreso as $item)
                                    <tr>
                                        <td>{{$item->concepto->descripcion}}</td>
                                        <td class="text-right">
                                            {{number_format($item->importe, 0, ".", ".")}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            <tr style="background: blueviolet">
                                <td colspan="2" style="font-weight: bold; color:white; font-size:15px">Egreso</td>
                            </tr>

                            @if (!(empty($empleado)))
                                @if ($empleado->egreso->sum('importe') <= 0)
                                    <tr>
                                        <td colspan="2">No hay egresos</td>
                                    </tr>
                                @endif

                                @foreach ($empleado->egreso as $item)
                                    <tr>
                                        <td>{{$item->concepto->descripcion}}</td>
                                        <td class="text-right">
                                            {{number_format($item->importe, 0, ".", ".")}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="color: white;font-size: 15px">Neto</th>
                                <th colspan="2" class="text-right" style="color: white;font-size: 15px">
                                    @if (!(empty($empleado)))
                                        @php
                                            $valor = $empleado->ingreso->sum('importe') - $empleado->egreso->sum('importe');
                                        @endphp
                                        <b> {{number_format($valor, 0, ".", ".")}}</b>
                                    @endif
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="resetUI" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="grabar_anticipo" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

</div>
