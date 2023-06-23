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

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card component-card_1 mb-4" style="background: aqua">
                        <a href="#">
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

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card component-card_1 mb-4" style="background: aqua">
                        <a href="#">
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

            </div>
        </div>

    </div>

@endsection

@section('js')

@endsection
