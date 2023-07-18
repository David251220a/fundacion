@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/cards/card.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25">Vista de Instructores</h2>
                <h4 class="">Documento: {{number_format($profesor->persona->documento, 0, ".", ".")}}</h4>
                <h4 class="">
                    Nombre y apellido: {{$profesor->persona->nombre}} {{$profesor->persona->apellido}}

                </h4>
            </div>
        </div>

        <div class="row">
            @foreach ($curso_activos as $item)

                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="card component-card_7 mb-4">
                        <a href="{{route('profesor.show', $item)}}">
                            <div class="card-body" style="">
                                <img src="{{Storage::url('iconos/instructor.png')}}" alt="" style="width: 20%">
                                <h5 class="card-text">{{$item->curso->descripcion}}</h5>
                                <h6 class="">{{$item->curso->modulo->descripcion}}</h6>
                                <h6 class="">Familia: {{$item->tipo_curso->descripcion}}</h6>
                                <h6 class="">Cant Alumnos: {{ count($item->alumnos_cursando)}}</h6>
                                <h6>Horario: {{date('H:i', strtotime($item->hora_entrada))}} a {{date('H:i', strtotime($item->hora_salida))}}</h6>
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
                                    if($item->lunes){
                                        $clases = $lunes;
                                        $ant = 1;
                                    }

                                    if($item->martes){
                                        if($ant == 1){
                                            $clases = $clases . ', ' . $martes;
                                        }else {
                                            $clases = $martes;
                                            $ant = 1;
                                        }
                                    }

                                    if($item->miercoles){
                                        if($ant == 1){
                                            $clases = $clases . ', ' . $miercoles;
                                        }else {
                                            $clases = $miercoles;
                                            $ant = 1;
                                        }
                                    }

                                    if($item->jueves){
                                        if($ant == 1){
                                            $clases = $clases . ', ' . $jueves;
                                        }else {
                                            $clases = $jueves;
                                            $ant = 1;
                                        }
                                    }

                                    if($item->viernes){
                                        if($ant == 1){
                                            $clases = $clases . ', ' . $viernes;
                                        }else {
                                            $clases = $viernes;
                                            $ant = 1;
                                        }
                                    }

                                    if($item->sabado){
                                        if($ant == 1){
                                            $clases = $clases . ', ' . $sabado;
                                        }else {
                                            $clases = $sabado;
                                            $ant = 1;
                                        }
                                    }

                                    if($item->domingo){
                                        if($ant == 1){
                                            $clases = $clases . ', ' . $domingo;
                                        }else {
                                            $clases = $domingo;
                                            $ant = 1;
                                        }
                                    }

                                @endphp
                                <h6>Días de Clase: {{$clases}} </h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>



    </div>

@endsection
