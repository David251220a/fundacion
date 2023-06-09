@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
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

        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget-content widget-content-area br-6 table-responsive">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tipo Curso</th>
                            <th>Curso</th>
                            <th>Fecha Inicio</th>
                            <th>Dias</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th class="no-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr style="font-weight: bold">
                                <td>{{$item->tipo_curso->descripcion}}</td>
                                <td>{{$item->curso->descripcion }}</td>
                                <td>
                                    {{date('d/m/Y', strtotime($item->periodo_desde))}}
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
                                    {{number_format($item->precio, 0, ".", ".")}}
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
            "pageLength": 10
        });
    </script>
@endsection
