@extends('layouts.admin')

@section('styles')

    <style>
        .caja{
            width: 100%;
            padding: 5px;
            border: 1px solid;
            height: auto;
        }

        .caja img{
            width: 60%;
            height: auto;
            max-height: 100%;
        }

        .caja .datos{
            color: white;
            margin: 5px 5px;
            font-weight: bold;
            width: auto;
        }

        .caja .datos br{
            margin-bottom: 2px;
        }



    </style>

@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Ingreso Varios - Recibo</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="caja">
                    <table>
                        <tr>
                            <th width="60%">
                                <img class="navbar-logo" src="{{Storage::url('public/iconos/logo_horizontal-1.png')}}" alt="logo">
                            </th>
                            <th width="40%">
                                <p>N° Recibo:</p>
                                <p>{{$ingreso->año}}-V-{{ str_pad($ingreso->numero_recibo, 6, '0', STR_PAD_LEFT) }}</p>
                            </th>
                        </tr>

                    </table>

                    <div class="datos">
                        Documento: {{number_format($ingreso->persona->documento, 0, ".", ".")}}
                        <br>
                        Nombre y apellido: {{$ingreso->persona->nombre}} {{$ingreso->persona->apellido}}
                    </div>

                    <br>

                    <table class="" style="width:100%; margin: 2px 2px">
                        <thead >
                            <tr>
                                <th width="50%">
                                    Descripcion
                                </th>
                                <th width="25%" style="text-align: right">
                                    Cantidad * P. Unitario
                                </th>
                                <th width="25%" style="text-align: right">
                                    Total
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
                                    <td style="font-weight: bold">{{$item->concepto->descripcion}}</td>
                                    <td style="text-align: right; font-weight: bold">{{$item->cantidad}} * {{number_format($item->precio_unitario, 0, ".", ".")}}</td>
                                    <td style="text-align: right; font-weight: bold">{{number_format($item->total_pagar, 0, ".", ".")}}</td>
                                    @php
                                        $total_a_pagar += $item->total_pagar;
                                        $saldo += $item->saldo;
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="font-size: 1.2rem">
                            <tr>
                                <td colspan="2" style="padding-top: 10px">Total a Pagar</td>
                                <td style="text-align: right; font-weight: bold; padding-top: 10px">{{number_format($total_a_pagar, 0, ".", ".")}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Monto Pagado</td>
                                <td style="text-align: right; font-weight: bold">{{number_format($ingreso->total_pagado, 0, ".", ".")}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Saldo</td>
                                <td style="text-align: right; font-weight: bold">{{number_format($saldo, 0, ".", ".")}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="caja">
                    <table>
                        <tr>
                            <th width="60%">
                                <img class="navbar-logo" src="{{Storage::url('public/iconos/logo_horizontal-1.png')}}" alt="logo">
                            </th>
                            <th width="40%">
                                <p>N° Recibo:</p>
                                <p>{{$ingreso->año}}-V-{{ str_pad($ingreso->numero_recibo, 6, '0', STR_PAD_LEFT) }}</p>
                            </th>
                        </tr>

                    </table>

                    <div class="datos">
                        Documento: {{number_format($ingreso->persona->documento, 0, ".", ".")}}
                        <br>
                        Nombre y apellido: {{$ingreso->persona->nombre}} {{$ingreso->persona->apellido}}
                    </div>

                    <br>

                    <table class="" style="width:100%; margin: 2px 2px">
                        <thead >
                            <tr>
                                <th width="50%">
                                    Descripcion
                                </th>
                                <th width="25%" style="text-align: right">
                                    Cantidad * P. Unitario
                                </th>
                                <th width="25%" style="text-align: right">
                                    Total
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
                                    <td style="font-weight: bold">{{$item->concepto->descripcion}}</td>
                                    <td style="text-align: right; font-weight: bold">{{$item->cantidad}} * {{number_format($item->precio_unitario, 0, ".", ".")}}</td>
                                    <td style="text-align: right; font-weight: bold">{{number_format($item->total_pagar, 0, ".", ".")}}</td>
                                    @php
                                        $total_a_pagar += $item->total_pagar;
                                        $saldo += $item->saldo;
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="font-size: 1.2rem">
                            <tr>
                                <td colspan="2" style="padding-top: 10px">Total a Pagar</td>
                                <td style="text-align: right; font-weight: bold; padding-top: 10px">{{number_format($total_a_pagar, 0, ".", ".")}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Monto Pagado</td>
                                <td style="text-align: right; font-weight: bold">{{number_format($ingreso->total_pagado, 0, ".", ".")}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Saldo</td>
                                <td style="text-align: right; font-weight: bold">{{number_format($saldo, 0, ".", ".")}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <a href="{{route('ingreso_varios.index')}}" class="btn btn-warning">Volver al Inicio</a>
            <a href="#" class="btn btn-info">Imprimir</a>
        </div>

    </div>

@endsection

@section('js')

@endsection
