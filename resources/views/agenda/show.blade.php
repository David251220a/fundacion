@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/cards/card.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25 ">Agenda Alumnos</h2>
                <h3 class="">Familia : {{$tipoCurso->descripcion}}</h3>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div class="card component-card_7 mb-4">
                    <a href="{{route('agenda.index')}}">
                        <div class="card-body" style="background: #f3a413;border-radius:10px">
                            <i class="fas fa-undo" style="font-size: 3.5rem"></i>
                            <h5 class="card-text">Retroceder</h5>
                            <h6 class="rating-count"></h6>
                        </div>
                    </a>
                </div>
            </div>
            @foreach ($cursos as $item)
                @php
                    $habilitado = count($item->habilitado);
                    if($habilitado > 0){
                        $estilo = 'background: #3abd19; border-radius:10px';
                        $desc = 'SI';
                    }else {
                        $estilo = '';
                        $desc = 'NO';
                    }

                    $estilo = '';
                    if(count($item->agendado) >= 10){
                        $estilo = 'background: #ff0d90;border-radius: 8px;';
                    }
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="card component-card_7 mb-4">
                        <a href="{{route('agenda.agenda', $item)}}">
                            <div class="card-body" style="{{$estilo}}">
                                <img src="{{Storage::url('iconos/grupo_estudio.png')}}" alt="" style="width: 20%">
                                <h5 class="card-text">{{$item->descripcion}}</h5>
                                <h6 class="">Modulo: {{$item->modulo->descripcion}}</h6>
                                <h6 class="">Habilitado: {{$desc}}</h6>
                                <h6 class="">Agendado: {{count($item->agendado)}}</h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>



    </div>

@endsection
