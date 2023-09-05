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

                                @livewire('pago-empleado.empleado-inactivo')

                            </div>

                            <div class="tab-pane fade" id="underline-historico" role="tabpanel" aria-labelledby="underline-historico-tab">

                                <div class="table-responsive col-xl-12 col-lg-12 col-sm-12">

                                    <table id="" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20%">Tipo de Pago</th>
                                                <th width="30%">Fecha</th>
                                                <th width="15%">Total Salario</th>
                                                <th width="15%">Total Descuentos</th>
                                                <th width="15%">Total Neto</th>
                                                <th class="no-content">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_pago as $item)
                                                <tr>
                                                    <td style="font-size: 11px">
                                                        {{$item->tipo_pago->descripcion}}
                                                    </td>
                                                    <td style="font-size: 11px">
                                                        {{date('d/m/Y', strtotime($item->fecha_cierre))}}
                                                    </td>
                                                    <td class="text-right" style="font-size: 11px">
                                                        {{number_format($item->total_salario, 0, ".", ".")}}
                                                    </td>
                                                    <td class="text-right" style="font-size: 11px">
                                                        {{number_format($item->total_descuento, 0, ".", ".")}}
                                                    </td>
                                                    <td class="text-right" style="font-size: 11px">
                                                        {{number_format($item->total_neto, 0, ".", ".")}}
                                                    </td>
                                                    <td class="text-right; font-size: 11px">
                                                        <a href="{{route('pago_empleados.show', $item->id)}}">
                                                            <i class="fas fa-eye" style="font-size: 15px;
                                                            color: rgb(52, 253, 220);" ></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- <div class="row">
                                    {{$data_pago->links()}}
                                </div> --}}

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
