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

        </form>
    </div>

@endsection

@section('js')

@endsection
