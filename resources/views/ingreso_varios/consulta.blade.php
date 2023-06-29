@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
@endsection

@section('content')

    <div class="col-lg-12 layout-spacing mt-4">
        <div class="widget-content widget-content-area">

            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25">Ingreso Varios</h2>
            </div>

            <div class="form-row mx-4">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <h4 class="mb-2">Filtros</h4>
                </div>

                <div class="col-md-2  mb-4">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked onclick="filtro(1)">
                        <label class="custom-control-label" for="customRadioInline1">Por Fecha</label>
                    </div>
                </div>

                <div class="col-md-2 mb-4">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" onclick="filtro(2)">
                        <label class="custom-control-label" for="customRadioInline2">Por numero de recibo</label>
                    </div>
                </div>

                <div class="col-md-2 mb-4">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input" onclick="filtro(3)">
                        <label class="custom-control-label" for="customRadioInline3">Por Documento</label>
                    </div>
                </div>

            </div>

            <form action="{{route('ingreso_varios.index')}}" method="GET" class="">
                <input type="hidden" id="buscar" name="buscar" value="{{$buscar}}">
                <div class="form-row mx-4">
                    <div class="col-md-3 mb-4" style="display: block">
                        <label for="">Fecha</label>
                        <input name="fecha" id="fecha" type="date" class="form-control text-right" value="{{$fecha_actual}}" required>
                    </div>

                    <div class="col-md-3  mb-4" id="ver_recibo" style="display: none">
                        <label for="">Nº Recibo</label>
                        <input name="recibo" id="recibo" type="text" class="form-control text-right">
                    </div>

                    <div class="col-md-3  mb-4" id="ver_documento" style="display: none">
                        <label for="">Documento</label>
                        <input name="documento" id="documento" type="text" class="form-control text-right" placeholder="">
                    </div>

                    <div class="col-md-3  mb-4">
                        <label for="" class="w-full">Accion</label>
                        <br>
                        <button type="submit" class="btn btn-info">Filtrar</button>
                        <button type="submit" class="btn btn-warning ">Atras</button>
                    </div>
                </div>
            </form>

            <div class="col-xl-12 col-lg-12 col-sm-12">
                <div class="widget-content widget-content-area br-6 table-responsive">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>N° Recibo</th>
                                <th>Persona</th>
                                <th>Detalle</th>
                                <th>Fecha Pago</th>
                                <th>Monto</th>
                                <th>Forma Pago</th>
                                <th class="no-content">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <td>{{$item->numero_recibo}}</td>
                            <td>
                                {{number_format($item->persona->documento, 0, ".", ".")}} -
                                {{$item->persona->nombre}}
                                {{$item->persona->apellido}}
                            </td>
                            <td>
                                @foreach ($item->detalle as $det)
                                    <p>* {{$det->concepto->descripcion}}</p>
                                @endforeach
                            </td>
                            <td>
                                {{date('d/m/Y', strtotime($item->fecha_ingreso))}}
                            </td>
                            <td>
                                {{number_format($item->total_pagado, 0, ".", ".")}}
                            </td>
                            <td>
                                {{$item->forma_pago->descripcion}}
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm">Anular</button>
                                <button type="button" class="btn btn-info btn-sm">Ver recibo</button>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
