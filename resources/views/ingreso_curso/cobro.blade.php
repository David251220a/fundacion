@extends('layouts.admin')

@section('styles')
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Cobro Cursos</h2>
            </div>
        </div>

        <form action="#" method="POST" onsubmit="disableButton()">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="">Documento</label>
                    <input type="text" class="form-control text-right" value="{{$persona->documento}}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Nombre y Apellido</label>
                    <input type="text" class="form-control text-left" value="{{$persona->nombre .' ' .$persona->apellido }}" readonly>
                </div>
            </div>

            @livewire('ingreso-matricula.ingreso-curso', ['alumno' => $alumno], key($alumno->id))

            <div class="form-row">
                <a href="{{route('ingreso_varios.index')}}" class="btn btn-warning">Volver al Inicio</a>
            </div>
        </form>

    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="{{asset('js/ingreso/curso.js')}}"></script>

@endsection
