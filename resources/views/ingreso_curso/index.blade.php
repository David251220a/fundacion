@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 p-3">Ingreso Curso</h2>
            </div>

            @livewire('ingreso-matricula.ingreso-index')

        </div>

    </div>

@endsection

@section('js')

@endsection
