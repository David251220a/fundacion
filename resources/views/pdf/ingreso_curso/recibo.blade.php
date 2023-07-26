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
                Documento: <b> {{number_format($ingresoMatricula->alumno->persona->documento, 0, ".", ".")}} </b>
                <br>
                Nombre: <b>{{$ingresoMatricula->alumno->persona->nombre}}</b>
                <br>
                Apellido: <b>{{$ingresoMatricula->alumno->persona->apellido}} </b>
                <br>
                Recibo: <b>{{$ingresoMatricula->año}}-A-{{str_pad($ingresoMatricula->numero_recibo, 5, "0", STR_PAD_LEFT)}}</b>
            </label>
        </div>

        <div style="margin-top: 10px">
            <table>
                <thead>
                    <tr>
                        <th width="80%" style="text-align: left">
                            Curso
                        </th>
                        <th width="20%">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingresoMatricula->detalle as $item)
                        <tr style="">
                            <td style="">
                                {{$item->curso_habilitado->curso->descripcion}} -
                                {{$item->curso_habilitado->curso->modulo->descripcion}}
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
                        <th width="20%">{{number_format($ingresoMatricula->detalle->sum('monto_pagado'), 0, ".", ".")}}</th>
                    </tr>
                </tfoot>
            </table>

        </div>

        <div>
            <p class="detalle">Detalles</p>
            <p>
                Tipo de Cobro: <b>{{($ingresoMatricula->tipo_cobro == 1 ? 'MATRICULA' : 'CERTIFICADO')}}</b> <br>
                Forma de Pago: <b>{{$ingresoMatricula->forma_pago->descripcion}}</b> <br>
                Fecha: <b>{{date('d/m/Y H:i', strtotime($ingresoMatricula->created_at))}}</b> <br>
                Usuario: <b>{{$ingresoMatricula->usuario->name}}</b> <br>
            </p>
        </div>
    </body>

</html>
