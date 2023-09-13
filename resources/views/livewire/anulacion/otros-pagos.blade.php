<div class="layout-px-spacing mt-4">

    <div class="row layout-spacing">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="">Anulación Otros Pagos</h2>
        </div>
    </div>

    <div class="row" style="margin-top: -40px">

        <div id="flFormsGrid" class="col-lg-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Año</label>
                    <input type="text" wire:model.defer="año" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail4">SIGLA</label>
                    <input type="text" readonly value="C" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">N° de Recibo</label>
                    <input type="text" wire:model.defer="numero_recibo" class="form-control" onkeyup="punto_decimal_anio(this)">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Accion</label> <br>
                    <button type="button" class="btn btn-info btn-sm" wire:click="buscar">Buscar</button>
                </div>
            </div>
        </div>

    </div>

    @php
        if($ver_detalle){
            $estilo = 'block';
        }else {
            $estilo = 'none';
        }
    @endphp

    <div class="row" style="display: {{$estilo}}">

        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <h2>Detalles</h2>
                    @if (empty($data))
                        <div class="col-md-12" >
                            <h2 class="text-center" style="text-align: center">No existe boleta de recibo con este numero.</h2>
                        </div>

                    @else
                        @if ($data->procesado == 1)
                            <div class="form-row">
                                <h2 class="text-center">
                                    No se puede anular esta boleta por que ya se realizo el cierre de caja.
                                </h2>
                            </div>
                        @else
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Concepto</label>
                                    <input type="text" class="form-control" value="{{$data->pago_varios[0]->concepto->descripcion}}" readonly>


                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Monto Pagado</label>
                                    <input type="text" class="form-control" value="{{number_format($data->importe, 0, ".", ".")}}" class="text-right" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">Usuario</label>
                                    <input type="text" class="form-control" value="{{$data->usuario->name}}"  readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">Fecha Pago</label>
                                    <input type="datetime" class="form-control" value="{{date('d/m/Y H:i', strtotime($data->created_at))}}"  readonly>
                                </div>

                                @if ($data->estado_id == 2)
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">Estado</label>
                                        <input type="text" class="form-control text-red" style="color:rgb(202, 81, 81)" value="Esta boleta de recibo esta anulada."  readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">Anulado Cajero</label>
                                        <input type="text" class="form-control text-red" value="{{$data->usuario_modif->name}}"  readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">Fecha Anulación</label>
                                        <input type="datetime" class="form-control" value="{{date('d/m/Y H:i', strtotime($data->updated_at))}}"  readonly>
                                    </div>

                                @else
                                    <div class="form-group col-md-12">
                                        <button type="button" onclick="anular_curso()"  class="btn btn-danger">Anular</button>
                                    </div>
                                @endif


                            </div>
                        @endif

                    @endif

                </div>
            </div>
        </div>

    </div>

</div>
