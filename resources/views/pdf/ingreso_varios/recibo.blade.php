<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
        <style>
            body{
                /* border: 1px solid black; */
                font-size: 14px;
                margin-left: -25px;
                margin-right: -25px;
            }

            .cont-cabezera{
                width: 100%;
                /* margin-bottom: 20px; */
                /* border: 1px solid red; */
            }

            .cont-cabezera .img-cabezera {
                width: 100%;
            }

            .cont-cabezera p {
                text-align: right;
                vertical-align: top;
            }

            .datos {
                width: 100%;
                font-size: 13px;
                /* border: 1px solid red; */
            }

            table {
                width: 100%;
            }

            table tfoot{
                background: rgb(185, 181, 181);
            }

            h3 {
                text-align: center;
                margin-bottom: 15px;
                /* border: 1px solid red; */
            }

            .detalle {
                font-weight: bold;
                font-size: 14px;
                margin-bottom: -10px;
            }
        </style>
    </head>

    <body>
        <div class="cont-cabezera">
            <img class="img-cabezera" src="{{ asset('storage/iconos/logo_horizontal_alta.png')}}" alt="">
        </div>

        <div>
            <h3>Recibo de Dinero</h3>
        </div>

        <div>
            <label for="">
                Documento: <b> {{number_format($ingresoVarios->persona->documento, 0, ".", ".")}} </b>
                <br>
                Nombre: <b>{{$ingresoVarios->persona->nombre}}</b>
                <br>
                Apellido: <b>{{$ingresoVarios->persona->apellido}} </b>
                <br>
                Recibo: <b>{{$ingresoVarios->año}}-B-{{str_pad($ingresoVarios->numero_recibo, 5, "0", STR_PAD_LEFT)}}</b>
                <br>
                Total a Pagar: <b> {{number_format($ingresoVarios->detalle->sum('total_pagar'), 0, ".", ".")}} </b>
            </label>
        </div>

        <div style="margin-top: 10px">
            <table>
                <thead>
                    <tr>
                        <th width="80%" style="text-align: left">
                            Concepto
                        </th>
                        <th width="20%">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingresoVarios->detalle as $item)
                        <tr style="">
                            <td style="">
                                {{$item->concepto->descripcion}} * {{$item->cantidad}}
                            </td>
                            <td style="text-align: right; ">{{number_format($item->monto_pagado, 0, ".", ".")}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th width="80%" style="text-align: left">
                            Total Pagado
                        </th>
                        <th width="20%">{{number_format($ingresoVarios->detalle->sum('monto_pagado'), 0, ".", ".")}}</th>
                    </tr>
                </tfoot>
            </table>

        </div>

        <div>
            <p class="detalle">Detalles</p>
            <p>
                @if ($ingresoVarios->detalle->sum('saldo') > 0)
                    Saldo : <b>{{number_format($ingresoVarios->detalle->sum('saldo'), 0, ".", ".")}}</b> <br>
                @endif
                Forma de Pago: <b>{{$ingresoVarios->forma_pago->descripcion}}</b> <br>
                Fecha: <b>{{date('d/m/Y H:i', strtotime($ingresoVarios->created_at))}}</b> <br>
                Usuario: <b>{{$ingresoVarios->usuario->name}}</b> <br>
            </p>
        </div>
    </body>

</html>
