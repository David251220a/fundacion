@extends('layouts.admin')

@section('styles')
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
@endsection

@section('content')

    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="row" style="margin-left: 3px">
                    <h3 class="mb-4">Crear Instructor: {{$data->nombre}} {{$data->apellido}}</h3>
                </div>
                <form class="needs-validation" action="{{route('instructor.add_nuevo_post', $data)}}" method="POST" >
                    @csrf

                    @include('ui.persona.edit')

                    <button class="btn btn-primary mt-3" type="submit">Grabar</button>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('js/pais/index.js')}}"></script>
@endsection
