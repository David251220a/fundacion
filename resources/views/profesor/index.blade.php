@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/cards/card.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25">Vista de Instructores</h2>
                <h4 class="">Documento: {{number_format($profesor->persona->documento, 0, ".", ".")}}</h4>
                <h4 class="">
                    Nombre y apellido: {{$profesor->persona->nombre}} {{$profesor->persona->apellido}}

                </h4>
            </div>
        </div>

        <div class="row">
            @foreach ($curso_activos as $item)

                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="card component-card_7 mb-4">
                        <a href="{{route('profesor.show', $item)}}">
                            <div class="card-body" style="">
                                <img src="{{Storage::url('iconos/instructor.png')}}" alt="" style="width: 20%">
                                <h5 class="card-text">{{$item->curso->descripcion}}</h5>
                                <h6 class="">{{$item->curso->modulo->descripcion}}</h6>
                                <h6 class="">Familia: {{$item->tipo_curso->descripcion}}</h6>
                                <h6 class="">Cant Alumnos: {{ count($item->alumnos_cursando)}}</h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>



    </div>

@endsection
