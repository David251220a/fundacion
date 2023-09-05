@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="row layout-top-spacing">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="">Cierre de Caja - Faltante</h2>
        </div>

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-two">

                <div class="widget-heading">
                    <h5 class="">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18">
                        </polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        Cajeros
                    </h5>
                </div>

                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Cajero
                                    </th>
                                    <th>
                                        Ingreso
                                    </th>
                                    <th>
                                        Egreso
                                    </th>
                                    <th>
                                        Accion
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_ingreso = 0;
                                    $total_egreso = 0;
                                @endphp
                                @foreach ($matricula as $item)
                                    @php
                                        $ingreso = $item->total;
                                        $saber_insumo = $insumo->where('user_id', $item->user_id);
                                        $ingreso += $saber_insumo->sum('total');
                                        $egreso = $pago->where('user_id', $item->user_id);
                                        $total_ingreso += $ingreso;
                                        $total_egreso += $egreso->sum('total');
                                    @endphp
                                    <tr>
                                        <td style="color: rgb(0, 255, 234)">{{$item->usuario->name}}</td>
                                        <td class="text-right" style="color: rgb(0, 255, 234)">
                                            {{number_format($ingreso, 0, ".", ".")}}
                                        </td>
                                        <td class="text-right" style="color: rgb(0, 255, 234)">
                                            {{number_format($egreso->sum('total'), 0, ".", ".")}}
                                        </td>
                                        <td style="color: rgb(0, 255, 234)">
                                            <a href="{{route('cierre.cierre_gerente', $item->user_id)}}" class="btn btn-success btn-sm">Cerrar</a>
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($insumo as $item)
                                    @php
                                        $existe_matri = $matricula->where('user_id', $item->user_id);
                                        $aux = count($existe_matri);
                                        if ($aux == 0) {
                                            $nuevo = $pago->where('user_id', $item->user_id);
                                            $total_ingreso += $item->total;
                                            $total_egreso += $nuevo->sum('total');
                                        }

                                    @endphp
                                    @if ($aux == 0)
                                        <tr>
                                            <td style="color: rgb(0, 255, 234)">{{$item->usuario->name}}</td>
                                            <td class="text-right" style="color: rgb(0, 255, 234)">
                                                {{number_format($item->total, 0, ".", ".")}}
                                            </td>
                                            <td class="text-right" style="color: rgb(0, 255, 234)">
                                                {{number_format($nuevo->sum('total'), 0, ".", ".")}}
                                            </td>
                                            <td style="color: rgb(0, 255, 234)">
                                                <a href="{{route('cierre.cierre_gerente', $item->user_id)}}" class="btn btn-success btn-sm">Cerrar</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                @foreach ($pago as $item)
                                    @php
                                        $existe_matri = $matricula->where('user_id', $item->user_id);
                                        $exite_insumo = $insumo->where('user_id', $item->user_id);
                                        $aux = count($existe_matri);
                                        $aux_i = count($exite_insumo);
                                        if (($aux == 0) && ($aux_i == 0)){
                                            $total_egreso += $item->total;
                                        }
                                    @endphp
                                    @if (($aux == 0) && ($aux_i == 0))
                                        <tr>
                                            <td style="color: rgb(0, 255, 234)">{{$item->usuario->name}}</td>
                                            <td class="text-right" style="color: rgb(0, 255, 234)">
                                                0
                                            </td>
                                            <td class="text-right" style="color: rgb(0, 255, 234)">
                                                {{number_format($item->total, 0, ".", ".")}}
                                            </td>
                                            <td style="color: rgb(0, 255, 234)">
                                                <a href="{{route('cierre.cierre_gerente', $item->user_id)}}" class="btn btn-success btn-sm">Cerrar</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Totales</th>
                                    <th class="text-right">{{number_format($total_ingreso, 0, ".", ".")}}</th>
                                    <th class="text-right">{{number_format($total_egreso, 0, ".", ".")}}</th>
                                    @php
                                        $ganancia = $total_ingreso - $total_egreso;
                                        $color = '';
                                        if($ganancia <= 0){
                                            $color = 'color: #ff0808';
                                        }else{
                                            $color = 'color: #00ff1f';
                                        }
                                    @endphp
                                    <th class="text-right" style="{{$color}}">{{number_format($total_ingreso - $total_egreso, 0, ".", ".")}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-three">

                <div class="widget-heading">
                    <h5 class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-trello"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9">
                        </rect><rect x="14" y="7" width="3" height="5"></rect></svg>
                        Hoy: {{date('d/m/Y H:i', strtotime($fecha_actual))}}
                    </h5>
                </div>

                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>
                                            Cajero
                                        </th>
                                        <th>
                                            Hora Cierre
                                        </th>
                                        <th>
                                            Total Ingreso
                                        </th>
                                        <th>
                                            Total Egreso
                                        </th>
                                        <th>
                                            Neto
                                        </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->usuario->name}}</td>
                                            <td>{{date('H:i', strtotime($item->created_at))}}</td>
                                            <td class="text-right">
                                                {{number_format($item->total_ingreso, 0, ".", ".")}}
                                            </td>
                                            <td class="text-right">
                                                {{number_format($item->total_egreso, 0, ".", ".")}}
                                            </td>
                                            <td class="text-right">
                                                {{number_format($item->total_ingreso - $item->total_egreso, 0, ".", ".")}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tr>
                            </tbody>
                            <tfoot>
                                <th colspan="2">Total</th>
                                <th class="text-right">{{number_format($data->sum('total_ingreso'), 0, ".", ".")}}</th>
                                <th class="text-right">{{number_format($data->sum('total_egreso'), 0, ".", ".")}}</th>
                                <th class="text-right">{{number_format($data->sum('total_ingreso')-$data->sum('total_egreso'), 0, ".", ".")}}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="{{asset('js/consulta/pago.js')}}"></script>

@endsection
