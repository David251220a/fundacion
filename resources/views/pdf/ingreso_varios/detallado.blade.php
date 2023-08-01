<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>

            body{
                margin-bottom: -10px;
            }
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
                padding: 1px;
                font-size: 12px;
                line-height: 12px;
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
            <h4>Reporte de Ingreso Varios - Detallado</h4>
            <h6>{{$titulo}} - {{Auth::user()->name}}</h6>
        </div>

        <div class="datos">
            <table class="table">
                <thead class="table thead-light table-bordered ">
                    <tr>
                        <th width="10%">N° Recibo</th>
                        <th width="20%">Persona</th>
                        <th width="30%">Detalle</th>
                        <th width="8%">Forma Pago</th>
                        <th width="10%">Usuario</th>
                        <th width="10%">Fecha</th>
                        <th class="text-right" width="15%">Monto</th>

                    </tr>
                </thead>
                <tbody style="font-size: 10px">
                    @foreach ($data as $item)
                        <tr>
                            <td>B-{{$item->numero_recibo}}</td>
                            <td>
                                {{number_format($item->persona->documento, 0, ".", ".")}} -
                                {{$item->persona->nombre}}
                                {{$item->persona->apellido}}
                            </td>
                            <td>
                                @if ($item->curso_ingreso_id > 0)
                                    Familia: {{ $item->familia->descripcion }}
                                    <br>
                                    Curso: {{$item->cursos->descripcion}} - {{$item->cursos->modulo->descripcion}} <br>
                                @endif

                                @foreach ($item->detalle as $det)
                                    * {{$det->concepto->descripcion}} * {{$det->cantidad}} Cant <br>
                                @endforeach
                            </td>
                            <td>
                                {{$item->forma_pago->descripcion}}
                            </td>
                            <td>
                                {{$item->usuario->name}}
                            </td>
                            <td>
                                {{date('d/m/Y H:i', strtotime($item->created_at))}}
                            </td>
                            <td style="text-align: right">
                                @if ($item->detalle->sum('saldo') > 0)
                                    <i> {{number_format($item->total_pagado, 0, ".", ".")}}</i>
                                @else
                                    <b>{{number_format($item->total_pagado, 0, ".", ".")}}</b>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="font-size: 15px">
                        <td colspan="2"> <b>Cantidad de Cobro: {{count($data)}}</b> </td>
                        <td colspan="3"> <b>Totales</b> </td>
                        <td colspan="2" class="text-right">
                            <b> {{number_format($data->sum('total_pagado'), 0, ".", ".")}} </b>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>

        <div style="margin-top: 10px">
            <p style="font-size: 10px">
                Observación: Los cobros con descripcion de familia y cursos son insumos que son identificados por las mismas. Los montos con estilo cursiva
                son cobros que no fueron realizados en su totalidad y queda con un saldo.
            </p>
        </div>

    </body>

</html>
