@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/cards/card.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="col-lg-12 layout-spacing mt-4">
        <div class="widget-content widget-content-area">

            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class="w-25">Ingreso Varios</h2>
            </div>
            <div class="form-row">

                @can('ingreso_varios.consulta')
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card component-card_1 mb-4" style="background: chocolate">
                            <a href="{{route('ingreso_varios.consulta')}}">
                                <div class="card-body">
                                    <div class="user-info">
                                        <img src="{{Storage::url('iconos/consulta_ingreso.png')}}" class="card-img-top" alt="...">
                                        <div class="media-body">
                                            <h5 class="card-user_name font-bold text-center mt-1" style="color: black">Consulta Ingreso</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('ingreso_varios.ingreso_persona')
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card component-card_1 mb-4" style="background: aqua">
                            <a href="{{route('ingreso_varios.buscar', 1)}}">
                                <div class="card-body">
                                    <div class="user-info">
                                        <img src="{{Storage::url('iconos/cobro_varios.png')}}" class="card-img-top" alt="...">
                                        <div class="media-body">
                                            <h5 class="card-user_name font-bold text-center mt-1" style="color: black">Realizar Cobro</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('ingreso_varios.ingreso_pendiente')
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card component-card_1 mb-4" style="background: rgb(240, 50, 50)">
                            <a href="{{route('ingreso_varios.buscar', 2)}}">
                                <div class="card-body">
                                    <div class="user-info">
                                        <img src="{{Storage::url('iconos/pendiente.png')}}" class="card-img-top" alt="...">
                                        <div class="media-body">
                                            <h5 class="card-user_name font-bold text-center mt-1" style="color: black">Cobros Pendiente</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('ingreso_matricula.cobro_alumno')
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card component-card_1 mb-4" style="background: white">
                            <a href="{{route('ingreso_varios.buscar', 3)}}">
                                <div class="card-body">
                                    <div class="user-info">
                                        <img src="{{Storage::url('iconos/curso.png')}}" class="card-img-top" alt="...">
                                        <div class="media-body">
                                            <h5 class="card-user_name font-bold text-center mt-1" style="color: black; font-weight: bold">Cobro Curso</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endcan


            </div>
        </div>

    </div>
    <a href="https://www.flaticon.es/iconos-gratis/curso" target="__blank" title="curso iconos">Curso iconos creados por xnimrodx - Flaticon</a>
@endsection

@section('js')

@endsection
