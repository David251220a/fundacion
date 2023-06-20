@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 p-3">Cursos Habilitados</h2>
            </div>
            <div class="col-lg-2 col-md-10 d-flex align-items-center">
                <a href="{{route('habilitado.create')}}" class="btn btn-info">Agregar</a>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="table-responsive widget-content widget-content-area br-6">
                <table class="table dt-table-hover" style="width:100%">
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
                                    <a href="{{route('cursoAlumno.buscar', $item)}}" class="ml-2"><i class="fas fa-user-plus"></i></a>
                                    <a href="{{route('habilitado.show', $item)}}" class="ml-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('habilitado.edit', $item)}}" class="ml-2"><i class="fas fa-pencil"></i></a>
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

@endsection
