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

    @php
        $lunes = 'Lunes';
        $martes = 'Martes';
        $miercoles = 'Miercoles';
        $jueves = 'Jueves';
        $viernes = 'Viernes';
        $sabado = 'Sabado';
        $domingo = 'domingo';
        $clase = '';
        $ant = 0;
        if($cursoHabilitado->lunes){
            $clases = $lunes;
            $ant = 1;
        }

        if($cursoHabilitado->martes){
            if($ant == 1){
                $clases = $clases . ', ' . $martes;
            }else {
                $clases = $martes;
                $ant = 1;
            }
        }

        if($cursoHabilitado->miercoles){
            if($ant == 1){
                $clases = $clases . ', ' . $miercoles;
            }else {
                $clases = $miercoles;
                $ant = 1;
            }
        }

        if($cursoHabilitado->jueves){
            if($ant == 1){
                $clases = $clases . ', ' . $jueves;
            }else {
                $clases = $jueves;
                $ant = 1;
            }
        }

        if($cursoHabilitado->viernes){
            if($ant == 1){
                $clases = $clases . ', ' . $viernes;
            }else {
                $clases = $viernes;
                $ant = 1;
            }
        }

        if($cursoHabilitado->sabado){
            if($ant == 1){
                $clases = $clases . ', ' . $sabado;
            }else {
                $clases = $sabado;
                $ant = 1;
            }
        }

        if($cursoHabilitado->domingo){
            if($ant == 1){
                $clases = $clases . ', ' . $domingo;
            }else {
                $clases = $domingo;
                $ant = 1;
            }
        }

    @endphp
    <body>
        <div class="cont-cabezera">
            <img class="img-cabezera" src="{{ asset('storage/iconos/logo_horizontal_alta.png')}}" alt="">
            <p>
                {{date('d/m/Y', strtotime(Carbon\Carbon::now()))}}
                <br>
                {{date('H:i', strtotime(Carbon\Carbon::now()))}}
            </p>
        </div>

        <div>
            <h4>{{$cursoHabilitado->tipo_curso->descripcion}}</h4>
            <h4>{{$cursoHabilitado->curso_id}} - {{$cursoHabilitado->curso->descripcion}}</h4>
            <h5 style="text-align: center">{{$cursoHabilitado->curso->modulo->descripcion}}</h5>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Detalle del Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Periodo:</td>
                        <td>{{date('d/m/Y', strtotime($cursoHabilitado->periodo_desde))}} al {{date('d/m/Y', strtotime($cursoHabilitado->periodo_hasta))}}</td>
                    </tr>
                    <tr>
                        <td>Precio:  </td>
                        <td>{{number_format($cursoHabilitado->precio, 0, ".", ".")}}</td>
                    </tr>
                    <tr>
                        <td>Días de clase:</td>
                        <td>{{$clases}}</td>
                    </tr>
                    <tr>
                        <td>Horario</td>
                        <td>{{date('H:i', strtotime($cursoHabilitado->hora_entrada))}} a {{date('H:i', strtotime($cursoHabilitado->hora_salida))}}</td>
                    </tr>
                    <tr>
                        <td>Instructor</td>
                        <td>{{$cursoHabilitado->instructor->persona->nombre}} {{$cursoHabilitado->instructor->persona->apellido}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="datos" style="margin-top: 5px">
            <table class="table">
                <thead class="table thead-light table-bordered ">
                    <tr>
                        <th colspan="4" style="text-align: center">Alumnos Aprobados</th>
                    </tr>
                </thead>
                <tbody style="font-size: 10px">
                    @foreach ($alumnos as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                            <td>{{$item->alumno->persona->nombre}}</td>
                            <td>{{$item->alumno->persona->apellido}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="font-size: 15px">
                        <td colspan="4"> <b>Cantidad de Alumnos: {{$alumnos->count()}}</b> </td>
                    </tr>
                </tfoot>
            </table>

        </div>

    </body>

</html>
