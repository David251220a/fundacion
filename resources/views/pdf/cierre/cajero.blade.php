<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            .cabezera{
                padding: 0;
                margin: 0;
                /* border-style: solid; */
                position: absolute;
                width: 100%;
            }

            .cont-cabezera{
                width: 100%;
                overflow: auto;
                margin-bottom: 20px;
                /* border: 1px solid red; */
            }

            .cont-cabezera .img-cabezera {
                width: 30%;
                float: left; /* Alineación a la izquierda */
            }

            .cont-cabezera p {
                text-align: right;
                vertical-align: top;
            }

            .cabezera th{
                /* border-style: solid; */
            }

            .content {
                margin-top: 5px;
                width: 100%;
                position: relative;
                border: 1px solid black;
                border-collapse: collapse;
            }

            .content th{
                margin: 0;
                font-size: 13px;
                border: 1px solid black;
                border-collapse: collapse;
            }

            .content body{
                font-size: 12px;
                font-weight: lighter;
            }

            .content td{
                padding: 3px;
                font-size: 12px;
                line-height: 15px;
                border: 1px solid black;
                border-collapse: collapse;
            }

            .datos {
                width: 100%;
                font-size: 13px;
                /* border: 1px solid red; */
            }

            h4 {
                text-align: center;
                margin-bottom: 15px;
                /* border: 1px solid red; */
            }

        </style>
    </head>

    <body>
        <div class="cont-cabezera">
            <img class="img-cabezera" src="{{ asset('storage/iconos/logo_horizontal_alta.png')}}" alt="">
            <p>17/07/2023
                <br>
                12:49
            </p>
        </div>

        <div>
            <h4>CIERRE DE CAJA</h4>
            <h6>Cajero\a: {{$cierreCaja->cajero_nombre->name}}</h6>
            <h6>Cierre Id: {{number_format($cierreCaja->id, 0, ".", ".")}}</h6>
        </div>

        <div class="datos">
            <div class="table-responsive">
                <table id="" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">INGRESOS</th>
                        </tr>
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

                        @foreach ($cierreCaja->ingresos as $item)
                            <tr>
                                <td >{{$item->ingreso_tipo->descripcion}}</td>
                                <td >
                                    {{$item->forma_pago->descripcion}}
                                </td>
                                <td class="text-right" >
                                    {{number_format($item->importe, 0, ".", ".")}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">TOTAL INGRESOS</th>
                            <th class="text-right">
                                @if (count($cierreCaja->ingresos) > 0)
                                    {{number_format($cierreCaja->ingresos->sum('importe'), 0, ".", ".")}}
                                @else
                                    0
                                @endif
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

        <div class="datos">
            <div class="table-responsive">
                <table id="" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">EGRESOS</th>
                        </tr>
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

                    </tbody>
                    <tfoot>
                        <th colspan="2">
                            TOTAL EGRESOS
                        </th>
                        <th class="text-right">
                            @if (count($cierreCaja->egresos) > 0)
                                {{number_format($cierreCaja->egresos->sum('importe'), 0, ".", ".")}}
                            @else
                                0
                            @endif
                        </th>
                    </tfoot>
                </table>
            </div>

        </div>

        <div class="datos">
            <div class="table-responsive">
                <table id="" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">TOTAL GENERAL</th>
                        </tr>
                        @php
                            $ingresos = 0;
                            $egresos = 0;
                        @endphp
                        <tr>
                            <th>
                                Total Ingreso:
                                @if (count($cierreCaja->ingresos) > 0)
                                    {{number_format($cierreCaja->ingresos->sum('importe'), 0, ".", ".")}}
                                    @php
                                        $ingresos = $cierreCaja->ingresos->sum('importe');
                                    @endphp
                                @else
                                    0
                                @endif
                            </th>
                            <th>
                                Total Ingreso:
                                @if (count($cierreCaja->egresos) > 0)
                                    {{number_format($cierreCaja->egresos->sum('importe'), 0, ".", ".")}}
                                    @php
                                        $egresos = $cierreCaja->egresos->sum('importe');
                                    @endphp
                                @else
                                    0
                                @endif
                            </th>
                            <th>
                                SALDO: {{number_format($ingresos - $egresos, 0, ".", ".")}}
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

    </body>

</html>
