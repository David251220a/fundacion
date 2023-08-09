@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class=" p-3">Instructores Salario</h2>
            </div>
        </div>

        <div class="row" style="margin-top: -40px">
            <div id="tabsLine" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area underline-content">

                        <ul class="nav nav-tabs  mb-3" id="lineTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="underline-home-tab" data-toggle="tab" href="#underline-home" role="tab" aria-controls="underline-home" aria-selected="true">
                                    <i class="fas fa-hand-holding-usd mr-2"></i> Pago Curso Concluido
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="underline-profile-tab" data-toggle="tab" href="#underline-profile" role="tab" aria-controls="underline-profile" aria-selected="false">
                                    <i class="fas fa-dollar-sign mr-2"></i> Instructores Salario
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="lineTabContent-3">
                            <div class="tab-pane fade show active" id="underline-home" role="tabpanel" aria-labelledby="underline-home-tab">

                                {{-- <div class="col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
                                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id#</th>
                                                <th>Tipo Curso</th>
                                                <th>Curso</th>
                                                <th>Concluido</th>
                                                <th>Fecha Inicio</th>
                                                <th>Horario</th>
                                                <th>Dias</th>
                                                <th>Estado</th>
                                                <th class="no-content">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr style="font-weight: bold">
                                                    <td class="text-right">{{$item->id}}</td>
                                                    <td>
                                                        {{str_pad($item->tipo_curso->id, 2, '0', STR_PAD_LEFT)}}00 -
                                                        {{$item->tipo_curso->descripcion}}
                                                    </td>
                                                    <td>
                                                        {{str_pad($item->curso->id, 3, '0', STR_PAD_LEFT)}}
                                                        - {{$item->curso->descripcion }} - {{$item->curso->modulo->descripcion }}
                                                    </td>
                                                    <td>
                                                        @if ($item->concluido)
                                                            @php
                                                                $desc = 'SI';
                                                                $estilo = 'color: green';
                                                            @endphp
                                                        @else
                                                            @php
                                                                $desc = 'NO';
                                                                $estilo = 'color: red';
                                                            @endphp
                                                        @endif
                                                        <label for="" style="{{$estilo}}">{{$desc}}</label>
                                                    </td>
                                                    <td>
                                                        {{date('d/m/Y', strtotime($item->periodo_desde))}}
                                                    </td>
                                                    <td>
                                                        {{date('H:i', strtotime($item->hora_entrada))}} a {{date('H:i', strtotime($item->hora_salida))}}
                                                    </td>
                                                    <td>
                                                        {{ ($item->lunes == 1 ? 'LUNES' : '') }}
                                                        {{ ($item->martes == 1 ? 'MARTES' : '')}}
                                                        {{ ($item->miercoles == 1 ? 'MIERCOLES' : '')}}
                                                        {{ ($item->jueves == 1 ? 'JUEVES' : '')}}
                                                        {{ ($item->viernes == 1 ? 'VIERNES' : '')}}
                                                        {{ ($item->sabado == 1 ? 'SABADO' : '')}}
                                                        {{ ($item->domingo == 1 ? 'DOMINGO' : '')}}
                                                    </td>
                                                    <td>
                                                        {{$item->estado->descripcion}}
                                                    </td>
                                                    <td>
                                                        @can('cursoAlumno.buscar')
                                                            <a href="{{route('cursoAlumno.buscar', $item)}}" class="ml-2"><i class="fas fa-user-plus"></i></a>
                                                        @endcan

                                                        @can('habilitado.show')
                                                            <a href="{{route('habilitado.show', $item)}}" class="ml-2"><i class="fas fa-eye"></i></a>
                                                        @endcan

                                                        @can('habilitado.edit')
                                                            <a href="{{route('habilitado.edit', $item)}}" class="ml-2"><i class="fas fa-pencil"></i></a>
                                                        @endcan

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> --}}

                            </div>

                            <div class="tab-pane fade" id="underline-profile" role="tabpanel" aria-labelledby="underline-profile-tab">

                                {{-- <div class="col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
                                    <table id="zero-config_d" class="table dt-table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id#</th>
                                                <th>Tipo Curso</th>
                                                <th>Curso</th>
                                                <th>Concluido</th>
                                                <th>Fecha Inicio</th>
                                                <th>Horario</th>
                                                <th>Dias</th>
                                                <th>Estado</th>
                                                <th class="no-content">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_d as $item)
                                                <tr style="font-weight: bold">
                                                    <td class="text-right">{{$item->id}}</td>
                                                    <td>
                                                        {{str_pad($item->tipo_curso->id, 2, '0', STR_PAD_LEFT)}}00 -
                                                        {{$item->tipo_curso->descripcion}}
                                                    </td>
                                                    <td>
                                                        {{str_pad($item->curso->id, 3, '0', STR_PAD_LEFT)}}
                                                        - {{$item->curso->descripcion }} - {{$item->curso->modulo->descripcion }}
                                                    </td>
                                                    <td>
                                                        @if ($item->concluido)
                                                            @php
                                                                $desc = 'SI';
                                                                $estilo = 'color: green';
                                                            @endphp
                                                        @else
                                                            @php
                                                                $desc = 'NO';
                                                                $estilo = 'color: red';
                                                            @endphp
                                                        @endif
                                                        <label for="" style="{{$estilo}}">{{$desc}}</label>
                                                    </td>
                                                    <td>
                                                        {{date('d/m/Y', strtotime($item->periodo_desde))}}
                                                    </td>
                                                    <td>
                                                        {{date('H:i', strtotime($item->hora_entrada))}} a {{date('H:i', strtotime($item->hora_salida))}}
                                                    </td>
                                                    <td>
                                                        {{ ($item->lunes == 1 ? 'LUNES' : '') }}
                                                        {{ ($item->martes == 1 ? 'MARTES' : '')}}
                                                        {{ ($item->miercoles == 1 ? 'MIERCOLES' : '')}}
                                                        {{ ($item->jueves == 1 ? 'JUEVES' : '')}}
                                                        {{ ($item->viernes == 1 ? 'VIERNES' : '')}}
                                                        {{ ($item->sabado == 1 ? 'SABADO' : '')}}
                                                        {{ ($item->domingo == 1 ? 'DOMINGO' : '')}}
                                                    </td>
                                                    <td>
                                                        {{$item->estado->descripcion}}
                                                    </td>
                                                    <td>
                                                        @can('cursoAlumno.buscar')
                                                            <a href="{{route('cursoAlumno.buscar', $item)}}" class="ml-2"><i class="fas fa-user-plus"></i></a>
                                                        @endcan

                                                        @can('habilitado.show')
                                                            <a href="{{route('habilitado.show', $item)}}" class="ml-2"><i class="fas fa-eye"></i></a>
                                                        @endcan

                                                        @can('habilitado.edit')
                                                            <a href="{{route('habilitado.edit', $item)}}" class="ml-2"><i class="fas fa-pencil"></i></a>
                                                        @endcan

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('js')

@endsection
