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
            <h3>Comprobante de Pago</h3>
        </div>

        {{-- <div >
            <label for=""> --}}
                <h4>Pago de Insumos</h4>
            {{-- </label>
        </div> --}}

        <div style="margin-top: 5px">
            <table>
                <thead>
                    <tr>
                        <th width="70%" style="text-align: left">
                            Concepto
                        </th>
                        <th width="30%">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->pago_varios as $item)
                        <tr style="">
                            <td style="">
                                {{$item->concepto->descripcion}}
                            </td>
                            <td style="text-align: right; ">{{number_format($item->importe, 0, ".", ".")}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th width="70%" style="text-align: left">
                            Total Pagado
                        </th>
                        <th width="30%">{{number_format($data->importe, 0, ".", ".")}}</th>
                    </tr>
                </tfoot>
            </table>

        </div>

        <div>
            <p class="detalle">Detalles</p>
            <p>
                @if ($data->insumo_id <= 3)
                    Mes: <b>{{$data->mes}}</b> <br>
                    Año: <b>{{$data->año}}</b> <br>
                @endif
                Recibo: <b>{{$data->año}}-C-{{ str_pad($data->numero_recibo, 6, '0', STR_PAD_LEFT) }}</b> <br>
                Forma de Pago: <b>{{$data->forma_pago->descripcion}}</b> <br>
                Fecha: <b>{{date('d/m/Y H:i', strtotime($data->created_at))}}</b> <br>
                Usuario: <b>{{$data->usuario->name}}</b> <br>
            </p>
        </div>
    </body>

</html>
