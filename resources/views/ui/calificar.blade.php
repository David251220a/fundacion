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
    <h2 class="mt-2">Calificación de Alumnos</h2>

    <div class="alert alert-light-danger border-0 mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
        <strong>Atención!</strong> Si califica los alumnos para este curso ya se dará por concluido y ya no podra mas llamar listado u otras funciones.</button>
    </div>

        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mt-4">
            <div class="table-responsive widget-content widget-content-area br-6">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="5">
                                Aprobación completa <input type="checkbox" name="completa" id="completa" value="0"
                                onclick="asistencia_completo()">
                            </th>
                        </tr>
                        <tr>
                            <th width="5%">N#</th>
                            <th width="5%" class="text-center">Aprobo?</th>
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
                <a href="{{route('profesor.show', $cursoHabilitado)}}" class="btn btn-warning">Atras</a>
            </div>

        </div>
</div>
