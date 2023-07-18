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
            <h4>Reporte de Ingreso Curso - Detallado</h4>
            <h6>{{$titulo}}</h6>
        </div>

        <div class="datos">
            <table class="table">
                <thead class="table thead-light table-bordered ">
                    <tr>
                        <th width="5%">N° Recibo</th>
                        <th width="20%">Alumno</th>
                        <th width="20%">Curso</th>
                        <th width="2%">Tipo</th>
                        <th width="8%">Forma Pago</th>
                        <th width="2%">Fecha</th>
                        <th width="8%">Monto</th>

                    </tr>
                </thead>
                <tbody style="font-size: 10px">
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->año}}-{{$item->numero_recibo}}</td>
                            <td>
                                {{number_format($item->alumno->persona->documento, 0, ".", ".")}} -
                                {{$item->alumno->persona->nombre}}
                                {{$item->alumno->persona->apellido}}
                            </td>
                            <td>
                                {{$item->detalle[0]->curso_habilitado->curso->descripcion}}
                                - {{$item->detalle[0]->curso_habilitado->curso->modulo->descripcion}}
                            </td>
                            <td>
                                {{($item->tipo_cobro == 1 ? 'M' : 'C')}}
                            </td>
                            <td>
                                {{$item->forma_pago->descripcion}}
                            </td>
                            <td>
                                {{date('d/m/Y', strtotime($item->fecha_ingreso))}}
                            </td>
                            <td style="text-align: right">
                                {{number_format($item->total_pagado, 0, ".", ".")}}
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

    </body>

</html>
