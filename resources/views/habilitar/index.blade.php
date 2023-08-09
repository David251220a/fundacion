@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 p-3">Cursos Habilitados</h2>
            </div>
            @can('habilitado.create')
                <div class="col-lg-2 col-md-10 d-flex align-items-center">
                    <a href="{{route('habilitado.create')}}" class="btn btn-info">Agregar</a>
                </div>
            @endcan

        </div>

        <div class="row">
            <div id="tabsLine" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area underline-content">

                        <ul class="nav nav-tabs  mb-3" id="lineTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="underline-home-tab" data-toggle="tab" href="#underline-home" role="tab" aria-controls="underline-home" aria-selected="true">
                                    <i class="fas fa-school"></i> Cursando
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="underline-profile-tab" data-toggle="tab" href="#underline-profile" role="tab" aria-controls="underline-profile" aria-selected="false">
                                    <i class="fas fa-graduation-cap"></i> Concluido
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="lineTabContent-3">
                            <div class="tab-pane fade show active" id="underline-home" role="tabpanel" aria-labelledby="underline-home-tab">

                                <div class="col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
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
                                </div>

                            </div>

                            <div class="tab-pane fade" id="underline-profile" role="tabpanel" aria-labelledby="underline-profile-tab">
                                <div class="col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


    {{-- <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="widget-content widget-content-area br-6 table-responsive">
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
        </div>
    </div> --}}
@endsection

@section('js')
    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50, 100],
            "pageLength": 10,
            "ordering": false
        });

        $('#zero-config_d').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50, 100],
            "pageLength": 10,
            "ordering": false
        });
    </script>
@endsection
