<div class="layout-px-spacing mt-4">

    <div class="row layout-spacing">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="">Anulación Anticipo - Empleado / Instructor</h2>
        </div>
    </div>

    <div class="row" style="margin-top: -40px">

        <div id="flFormsGrid" class="col-lg-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Cierre ID</label>
                    <input type="text" wire:model.defer="cierre_id" class="form-control" onkeyup="punto_decimal(this)">
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
                    @if (empty($data))
                    @else
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Total Ingreso</label>
                                <input type="text" class="form-control" value="{{number_format($data->total_ingreso, 0, ".", ".")}}" class="text-right" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Total Egreso</label>
                                <input type="text" class="form-control" value="{{number_format($data->total_egreso, 0, ".", ".")}}" class="text-right" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Total Neto</label>
                                <input type="text" class="form-control" value="{{number_format($data->total_ingreso - $data->total_egreso, 0, ".", ".")}}" class="text-right" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Cajero/a</label>
                                <input type="text" class="form-control" value="{{$data->cajero_nombre->name}}"  readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Fecha Cierre</label>
                                <input type="datetime" class="form-control" value="{{date('d/m/Y H:i', strtotime($data->created_at))}}"  readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Observación</label>
                                <input type="text" class="form-control" value="{{$data->observacion}}"  readonly>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="button" onclick="anular_cierre()"  class="btn btn-danger">Anular</button>
                            </div>



                        </div>
                    @endif


                </div>
            </div>
        </div>

    </div>



</div>
