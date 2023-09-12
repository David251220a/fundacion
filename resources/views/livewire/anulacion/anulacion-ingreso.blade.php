<div class="layout-px-spacing mt-4">

    <div class="row layout-spacing">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="">Anulación Ingresos Varios</h2>
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
                    <input type="text" readonly value="B" class="form-control">
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
                        @if ($data->cierre_caja_id > 0)
                            <div class="form-row">
                                <h2 class="text-center">
                                    No se puede anular esta boleta por que ya se realizo el cierre de caja.
                                </h2>
                            </div>
                        @else
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Nombre y Apellido</label>
                                    @php
                                        $documento = number_format($data->persona->documento, 0, ".", ".");
                                        $nombre = $data->persona->nombre . ' '. $data->persona->apellido;
                                        $completo = $documento .' - ' . $nombre;
                                    @endphp
                                    <input type="text" class="form-control" value="{{$completo}}" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Concepto</label>
                                    @php
                                        if($data->curso_habilitado_id == 0){
                                            $concepto = 'INGRESO VARIOS';
                                        }

                                        if($data->curso_habilitado_id > 0){
                                            $concepto = 'INGRESO INSUMO';
                                        }
                                    @endphp
                                    <input type="text" class="form-control" value="{{$concepto}}" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Monto Pagado</label>
                                    <input type="text" class="form-control" value="{{number_format($data->total_pagado, 0, ".", ".")}}" class="text-right" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">Cajera</label>
                                    <input type="text" class="form-control" value="{{$data->usuario->name}}"  readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">Fecha Cobro</label>
                                    <input type="datetime" class="form-control" value="{{date('d/m/Y H:i', strtotime($data->created_at))}}"  readonly>
                                </div>
                                @if ($data->curso_habilitado_id > 0)
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">Familia</label>
                                        <input type="text" class="form-control" value="{{ $data->curso->tipo_curso->descripcion}}"  readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">Modulo</label>
                                        <input type="text" class="form-control" value="{{ $data->curso->curso->modulo->descripcion}}"  readonly>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4">Curso</label>
                                        @php
                                            $curso = $data->curso->curso->descripcion;
                                            $datos_curso = $data->curso_habilitado_id .' - '. $curso .' | '. date('d/m/Y', strtotime($data->curso->curso->periodo_desde))
                                            . ' a ' . date('d/m/Y', strtotime($data->curso->curso->periodo_hasta)) .' | ' . date('H:i', strtotime($data->curso->curso->hora_entrada))
                                            . ' a ' . date('H:i', strtotime($data->curso->curso->hora_salida)) . ' | Precio: ' .number_format($data->curso->curso->precio, 0, ".", ".");
                                        @endphp
                                        <input type="text" class="form-control" value="{{ $datos_curso}}"  readonly>
                                    </div>
                                @endif


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
