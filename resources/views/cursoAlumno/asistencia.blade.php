@extends('layouts.admin')

@section('styles')
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="col-lg-12 layout-spacing mt-4">
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3 class="">Curso:</h3>
                    <h5>{{$cursoHabilitado->curso->descripcion}} - {{$cursoHabilitado->curso->modulo->descripcion}}</h5>
                    <p>Periodo: {{date('d/m/Y', strtotime($cursoHabilitado->periodo_desde))}}
                        al {{date('d/m/Y', strtotime($cursoHabilitado->periodo_hasta))}}
                    </p>
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
                    <p style="font-size: 18px; line-height: 15px">Días de Clase: {{$clases}}
                </div>
            </div>

        </div>
        <h2 class="mt-2">Lista de Asistencia</h2>
        <form action="{{route('cursoAlumno.asistencia_post', $cursoHabilitado)}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    @php
                        $fecha = date('Y-m-d', strtotime($fecha_actual));
                    @endphp
                    <label for="">Fecha Asistencia</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{old('fecha', $fecha)}}" >
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12">
                    <label for="">Suspender Clase</label>
                    <select name="suspender" id="suspender" class="form-control">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12">
                    <label for="">Tipo Clase</label>
                    <select name="tipo_clase" id="tipo_clase" class="form-control">
                        <option value="0">NORMAL</option>
                        <option value="1">PENULTIMA CLASE</option>
                        <option value="2">ULTIMA</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12">
                    <label for="">Motivo</label>
                    <select name="motivo" id="motivo" class="form-control">
                        @foreach ($motivo as $item)
                            <option value="{{$item->id}}">{{$item->descripcion}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-6 col-md-6    col-sm-12">
                    <Label>Observación</Label>
                    <input type="text" name="observacion" id="observacion" class="form-control">
                </div>
            </div>

            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mt-4">
                <div class="table-responsive widget-content widget-content-area br-6">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    Asistencia completa <input type="checkbox" name="completa" id="completa" value="0"
                                    onclick="asistencia_completo()">
                                </th>
                            </tr>
                            <tr>
                                <th width="5%">N#</th>
                                <th width="5%" class="text-center">Presencia</th>
                                <th width="10%">Documento</th>
                                <th ">Nombre</th>
                                <th ">Apellido</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cursoHabilitado->alumnos_cursando as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="asistencia[]" id="asistencia_{{$loop->iteration}}" class="presente"
                                        value="0" onclick = "cambiar_v(this)">
                                        <input type="hidden" name="alumno_id[]" value="{{$item->alumno_id}}">
                                        <input type="hidden" name="asistencia_valor[]" id="asistencia_valor_{{$loop->iteration}}" class="asis_v" value="0">
                                    </td>
                                    <td class="text-right">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                                    <td class="">{{$item->alumno->persona->nombre}}</td>
                                    <td class="">{{$item->alumno->persona->apellido}}</td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5">
                                    Cantidad de Alumnos: {{count($cursoHabilitado->alumnos_cursando)}}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Grabar</button>
                    <a href="{{route('habilitado.show', $cursoHabilitado)}}" class="btn btn-warning">Atras</a>
                </div>

            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        function asistencia_completo()
        {
            let completo = document.getElementById('completa').value;
            let valor = false;
            let valor_1 = 0;

            if(completo == 0){
                valor = true;
                valor_1 = 1;
                document.getElementById('completa').value = 1;
            }else{
                valor = false;
                document.getElementById('completa').value = 0;
            }
            var checkboxes = document.querySelectorAll(".presente");
            // Establecer el estado "checked" para cada elemento checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = valor;
                checkbox.value = valor_1;
            });

            var inputs = document.querySelectorAll(".asis_v");

            // Establecer el valor en cada elemento <input>
            inputs.forEach(function(input) {
            input.value = valor_1;
            });
        }

        function cambiar_v(input)
        {
            let completo = input.value;
            let valor = false;
            let v_id = input.id;
            let id = v_id.replace(/[^\d\.]*/g,'');
            let nombre = 'asistencia_valor_' + id.toString();
            let nuevo = document.getElementById(nombre);
            if(input.checked == true){
                valor = true;
                input.value = 1;
                input.checked = valor;
                nuevo.value = 1;
            }else{
                valor = false;
                input.value = 0;
                input.checked = valor;
                nuevo.value = 0;
            }
        }
    </script>
@endsection
