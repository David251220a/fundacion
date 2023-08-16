@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <h2 class=" p-3">Empleados Salarios</h2>
            </div>
        </div>

        <div class="row" style="margin-top: -40px">
            <div id="tabsLine" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area underline-content">

                        <ul class="nav nav-tabs  mb-3" id="lineTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="underline-home-tab" data-toggle="tab" href="#underline-home" role="tab" aria-controls="underline-home" aria-selected="true">
                                    <i class="fas fa-hand-holding-usd mr-2"></i> Empleados Activos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="underline-profile-tab" data-toggle="tab" href="#underline-profile" role="tab" aria-controls="underline-profile" aria-selected="false">
                                    <i class="fas fa-dollar-sign mr-2"></i> Empleados Inactivos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="underline-historico-tab" data-toggle="tab" href="#underline-historico" role="tab" aria-controls="underline-historico" aria-selected="false">
                                    <i class="fas fa-dollar-sign mr-2"></i> Historico Pago
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="lineTabContent-3">
                            <div class="tab-pane fade show active" id="underline-home" role="tabpanel" aria-labelledby="underline-home-tab">

                                @livewire('pago-empleado.empleado-activo')

                            </div>

                            <div class="tab-pane fade" id="underline-profile" role="tabpanel" aria-labelledby="underline-profile-tab">

                                @livewire('pago-empleado.empleado-activo')

                            </div>

                            <div class="tab-pane fade" id="underline-historico" role="tabpanel" aria-labelledby="underline-historico-tab">

                                <h2>AJHHH</h2>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="{{asset('js/pago/empleado.js')}}"></script>

@endsection
