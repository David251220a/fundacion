@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 p-3">Cursos Habilitado</h2>
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

                </table>
            </div>
        </div>

    </div>

@endsection

@section('js')

@endsection

