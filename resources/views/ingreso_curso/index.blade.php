@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="col-lg-12 layout-spacing mt-4">
        <div class="widget-content widget-content-area">

            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25">Ingreso Curso</h2>
            </div>

            @livewire('ingreso-matricula.ingreso-index')

        </div>

    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('js/ingreso/index.js')}}"></script>
@endsection
