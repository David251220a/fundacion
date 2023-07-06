@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/cards/card.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25">Agenda Alumnos</h2>
                <h3 class="">Familia</h3>
            </div>
        </div>

        <div class="row">
            @foreach ($familia as $item)

                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="card component-card_7 mb-4">
                        <a href="{{route('agenda.show', $item)}}">
                            <div class="card-body">
                                <img src="{{Storage::url('iconos/mundo.png')}}" class="mb-2" alt="" style="width: 20%">
                                <h5 class="card-text">{{$item->descripcion}}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>



    </div>

@endsection
