@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor-styles.css') }}">
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 p-3">Noticias</h2>
            </div>
            @can('noticias.create')
                <div class="col-lg-2 col-md-10 d-flex align-items-center">
                    <a href="{{route('noticias.create')}}" class="btn btn-info">Agregar</a>
                </div>
            @endcan

        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget-content widget-content-area br-6">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Titulo</th>
                            <th>Descripcion</th>
                            <th>Portada</th>
                            <th>Publicado</th>
                            <th>Fecha Publicación</th>
                            <th>Usuario</th>
                            <th class="no-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($noticias as $item)
                            <tr style="font-weight: bold">
                                <td>{{$item->titulo}}</td>
                                <td>{!! Str::limit($item->contenido, 20, '...') !!}</td>
                                <td>
                                    @if ($item->portada == 1)
                                       <a class="btn-si">SI</a>
                                    @else
                                        <a class="btn-no">NO</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->publicado == 1)
                                       <a class="btn-si">SI</a>
                                    @else
                                    <a class="btn-no">NO</a>
                                    @endif
                                </td>
                                <td>
                                    {{date('d/m/Y', strtotime($item->created_at))}}
                                </td>
                                <td>
                                    {{$item->usuario->name}}
                                </td>
                                <td>
                                    @can('noticias.show')
                                        <a href="{{route('noticias.show', $item->slug)}}" class="ml-2"><i class="fas fa-eye"></i></a>
                                    @endcan

                                    @can('noticias.edit')
                                        <a href="{{route('noticias.edit', $item)}}" class="ml-2"><i class="fas fa-pencil"></i></a>
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
