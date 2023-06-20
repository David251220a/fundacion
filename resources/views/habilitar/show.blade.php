@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="col-lg-12 layout-spacing mt-4">
    <div class="widget-content widget-content-area">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h3 class="">Curso:</h3>
                <h5>{{$cursoHabilitado->curso->descripcion}}</h5>
                <p>Periodo: {{$cursoHabilitado->periodo_desde}} al {{$cursoHabilitado->periodo_hasta}}</p>
            </div>
        </div>

        <hr class="bg-white" style="color: white; backgraund: white; font-size: 5px">
        <div class="widget-content widget-content-area rounded-pills-icon">

            <ul class="nav nav-pills mb-4 mt-3  justify-content-center" id="rounded-pills-icon-tab" role="tablist">
                <li class="nav-item ml-2 mr-2">
                    <a class="nav-link mb-2 active text-center" id="rounded-pills-icon-home-tab" data-toggle="pill"
                    href="#rounded-pills-icon-home" role="tab" aria-controls="rounded-pills-icon-home" aria-selected="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Alumnos
                    </a>
                </li>
                <li class="nav-item ml-2 mr-2">
                    <a class="nav-link mb-2 text-center" id="rounded-pills-icon-profile-tab" data-toggle="pill" href="#rounded-pills-icon-profile"
                    role="tab" aria-controls="rounded-pills-icon-profile" aria-selected="false">
                    <i class="fas fa-tasks" style="font-size: 2.5rem"></i>
                        Asistencia
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="rounded-pills-icon-tabContent">
                <div class="tab-pane fade show active" id="rounded-pills-icon-home" role="tabpanel" aria-labelledby="rounded-pills-icon-home-tab">
                    @livewire('habilitado.listado-curso', ['cursoHabilitado' => $cursoHabilitado], key($cursoHabilitado->id))
                </div>

                <div class="tab-pane fade show " id="rounded-pills-icon-profile" role="tabpanel" aria-labelledby="rounded-pills-icon-profile-tab">
                    tabla asistencia
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('js')

@endsection

