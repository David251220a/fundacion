@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
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
                    <h5>{{$cursoHabilitado->curso->descripcion}}</h5>
                    <p>Periodo: {{$cursoHabilitado->periodo_desde}} al {{$cursoHabilitado->periodo_hasta}}</p>
                </div>
            </div>

        </div>
        <h2 class="">Lista de Asistencia</h2>
        <form action="{{route('cursoAlumno.asistencia_post', $cursoHabilitado)}}">
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <div class="table-responsive widget-content widget-content-area br-6">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%">Documento</th>
                                <th width="10%">Nombre</th>
                                <th width="10%">Apellido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos_cursando as $item)
                                <tr>
                                    <td class="text-right">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                                    <td class="">{{$item->alumno->persona->nombre}}</td>
                                    <td class="">{{$item->alumno->persona->apellido}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('js')

@endsection
