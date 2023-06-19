@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 p-3">Alumnos</h2>
            </div>
            {{-- @can('alumno.create') --}}
                <div class="col-lg-2 col-md-10 d-flex align-items-center">
                    <a href="{{route('alumno.validar')}}" class="btn btn-info">Agregar</a>
                </div>
            {{-- @endcan --}}

        </div>

        <div class="col-lg-6 col-md-6 d-flex align-items-center">
            @include('ui.busqueda_conletras')
        </div>


        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget-content widget-content-area br-6 table-responsive">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Celular</th>
                            <th>Direccion</th>
                            <th>Fecha Nacimiento</th>
                            <th>Estado</th>
                            <th class="no-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr style="font-weight: bold">
                                <td style="text-align: right">{{number_format($item->persona->documento, 0, ".", ".")}}</td>
                                <td>{{$item->persona->nombre}}</td>
                                <td>{{$item->persona->apellido}}</td>
                                <td>{{$item->persona->celular}}</td>
                                <td>{{$item->persona->direccion}}</td>
                                <td>
                                    {{date('d/m/Y', strtotime($item->persona->fecha_nacimiento))}}
                                </td>
                                <td>
                                    {{$item->estado->descripcion}}
                                </td>
                                <td>
                                    {{-- @can('alumno.show') --}}
                                        <a href="{{route('alumno.show', $item)}}" class="ml-2"><i class="fas fa-eye"></i></a>
                                    {{-- @endcan --}}
                                    {{-- @can('alumno.edit') --}}
                                        <a href="{{route('alumno.edit', $item)}}" class="ml-2"><i class="fas fa-pencil"></i></a>
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            {{$data->links()}}
        </div>
    </div>

@endsection

@section('js')
@endsection
