@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="row layout-top-spacing">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="">Cierre de Caja</h2>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-8">
            <p style="font-size: 15px"> <b>Cajero/a: {{$user->name}}</b></p>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4">
            <p style="font-size: 15px"> Fecha y Hora: <b>{{date('d/m/Y H:i', strtotime(Carbon\Carbon::now()))}}</b></p>
        </div>

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-two">

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
                                @if (count($cierreCaja->ingresos) > 0)
                                    @foreach ($cierreCaja->ingresos as $item)
                                        <tr>
                                            <td style="color: rgb(0, 255, 234)">{{$item->ingreso_tipo->descripcion}}</td>
                                            <td style="color: rgb(0, 255, 234)">
                                                {{$item->forma_pago->descripcion}}
                                            </td>
                                            <td class="text-right" style="color: rgb(0, 255, 234)">
                                                {{number_format($item->importe, 0, ".", ".")}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                @php
                                    $ingresos = 0;
                                @endphp
                                @if (count($cierreCaja->ingresos) > 0)
                                    <tr>
                                        <th colspan="2">Total Ingreso</th>
                                        <th class="text-right">{{number_format($cierreCaja->ingresos->sum('importe'), 0, ".", ".")}}</th>
                                        @php
                                            $ingresos = $cierreCaja->ingresos->sum('importe');
                                        @endphp
                                    </tr>
                                @else
                                    <tr>
                                        <th colspan="2">Total Ingreso</th>
                                        <th class="text-right">0</th>
                                    </tr>
                                @endif
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
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6">
                        </polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                        Egresos
                    </h5>
                </div>

                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
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
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_egreso = 0;
                                @endphp
                                <tr>
                                    @if (count($cierreCaja->egresos) > 0)
                                        @foreach ($cierreCaja->egresos as $item)
                                            <tr>
                                                <td>{{$item->tipo_pago->descripcion}}</td>
                                                <td class="mr-2">
                                                    {{$item->forma_pago->descripcion}}
                                                </td>
                                                <td class="text-right">
                                                    {{number_format($item->importe, 0, ".", ".")}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tr>
                            </tbody>
                            <tfoot>
                                @php
                                    if (count($cierreCaja->egresos) > 0) {
                                        $egreso = $cierreCaja->egresos->sum('importe');
                                    } else {
                                        $egreso = 0;
                                    }

                                @endphp
                                <th colspan="2">Total Egreso</th>
                                <th class="text-right">{{number_format($egreso, 0, ".", ".")}}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-three">
                <div class="widget-content">

                    <h5 class="">
                        Cierre Caja - Detalle
                    </h5>

                    <div class="table-responsive">
                        <table id="" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <tr>
                                        <th style="font-size: 20px">
                                            Saldo Caja
                                        </th>
                                        <th class="text-right" style="font-size: 20px; padding-right: 10px">
                                            {{number_format($ingresos - $egreso, 0, ".", ".")}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 20px">
                                            Fecha y Hora
                                        </th>
                                        <th class="text-right" style="font-size: 20px; padding-right: 10px">
                                            {{date('d/m/Y H:i', strtotime($cierreCaja->created_at))}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 20px">
                                            Usuario
                                        </th>
                                        <th class="text-right" style="font-size: 20px; padding-right: 10px">
                                            {{$user->name}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th><a href="{{route('pdf.cierre_cajero', $cierreCaja)}}" target="__blank" class="btn btn-info">Imprimir</a></th>
                                        <th><a href="{{route('cierre.cajero')}}" class="btn btn-warning">Volver al cierre</a></th>
                                    </tr>
                                </tr>
                            </thead>
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
