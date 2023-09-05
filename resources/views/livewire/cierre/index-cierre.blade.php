<div class="layout-px-spacing mt-4">

    <div class="row layout-spacing">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="">Consulta</h2>
        </div>
    </div>

    <div class="row" style="margin-top: -40px">

        <div id="flFormsGrid" class="col-lg-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Desde Fecha</label>
                    <input type="date" wire:model.defer="desde_fecha" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Hasta Fecha</label>
                    <input type="date" wire:model.defer="hasta_fecha" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Accion</label> <br>
                    <button type="button" class="btn btn-info btn-sm" wire:click="buscar_insumo">Buscar</button>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div id="tabsLine" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area underline-content">

                    <ul class="nav nav-tabs  mb-3" id="lineTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="underline-home-tab" data-toggle="tab" href="#underline-home" role="tab" aria-controls="underline-home" aria-selected="true">
                                <i class="fas fa-hand-holding-usd mr-2"></i> Datos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="underline-profile-tab" data-toggle="tab" href="#underline-profile" role="tab" aria-controls="underline-profile" aria-selected="false">
                                <i class="fas fa-dollar-sign mr-2"></i> Grafico
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="lineTabContent-3">
                        <div class="tab-pane fade show active" id="underline-home" role="tabpanel" aria-labelledby="underline-home-tab">
                            <div class="row layout-top-spacing" style="margin-top: -25px">

                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                <div class="widget widget-table-one">

                                    <div class="widget-heading">
                                        <h5 class="">
                                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18">
                                            </polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                            Ingresos
                                        </h5>
                                    </div>

                                    <div class="widget-content">
                                        <div class="table-responsive">
                                            <table id="" class="table table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Movimiento
                                                        </th>
                                                        <th>
                                                            Forma de Cobro
                                                        </th>
                                                        <th>
                                                            Monto
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td style="color: rgb(0, 255, 234)">{{$item->ingreso_tipo->descripcion}}</td>
                                                            <td style="color: rgb(0, 255, 234)">
                                                                {{$item->forma_pago->descripcion}}
                                                            </td>
                                                            <td class="text-right" style="color: rgb(0, 255, 234)">
                                                                {{number_format($item->total, 0, ".", ".")}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">Total Ingreso</th>
                                                        <th class="text-right">{{number_format($data->sum('total'), 0, ".", ".")}}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                <div class="widget widget-table-two">

                                    <div class="widget-heading">
                                        <h5 class="">
                                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                                            </polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                                            Egreso
                                        </h5>
                                    </div>

                                    <div class="widget-content">
                                        <div class="table-responsive">
                                            <table id="" class="table table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Movimiento
                                                        </th>
                                                        <th>
                                                            Forma de Cobro
                                                        </th>
                                                        <th>
                                                            Monto
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data_e as $item)
                                                        <tr>
                                                            <td style="color: rgb(0, 255, 234)">{{$item->tipo_pago->descripcion}}</td>
                                                            <td style="color: rgb(0, 255, 234)">
                                                                {{$item->forma_pago->descripcion}}
                                                            </td>
                                                            <td class="text-right" style="color: rgb(0, 255, 234)">
                                                                {{number_format($item->total, 0, ".", ".")}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">Total Egreso</th>
                                                        <th class="text-right">{{number_format($data_e->sum('total'), 0, ".", ".")}}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>

                        <div class="tab-pane fade" id="underline-profile" role="tabpanel" aria-labelledby="underline-profile-tab">

                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                <div class="widget widget-table-one">

                                    <div class="widget-heading">
                                        <h5 class="">
                                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18">
                                            </polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                            Ingresos
                                        </h5>
                                    </div>
                                    <div class="widget-content widget-content-area">
                                        <div id="donut-chart" class=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
