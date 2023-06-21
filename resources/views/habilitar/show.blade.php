@extends('layouts.admin')

@section('styles')
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
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

        <div class="widget-content widget-content-area rounded-pills-icon">

            <ul class="nav nav-pills justify-content-center" id="rounded-pills-icon-tab" role="tablist">
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
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <a href="#" class="btn btn-info">Llamar Lista</a>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="table-responsive widget-content widget-content-area br-6">
                            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">Documento</th>
                                        <th width="10%">Nombre</th>
                                        <th width="10%">Apellido</th>
                                        @if (count($asistencia_fecha) > 0)
                                            <th>Apellido</th>
                                        @else
                                            <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alumnos_cursando as $item)
                                        <tr>
                                            <td class="text-right">{{number_format($item->alumno->persona->documento, 0, ".", ".")}}</td>
                                            <td class="">{{$item->alumno->persona->nombre}}</td>
                                            <td class="">{{$item->alumno->persona->apellido}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>

                                </tbody>
                            </table>
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
    <script>

        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success btn-rounded',
            cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
            buttonsStyling: false,
        })
        window.addEventListener('load', function() {

            window.livewire.on('reloadClassCSs', msj => {
                let mensaje = document.getElementById("mensaje");
                if(mensaje != null){
                    document.getElementById("mensaje").style.display = "none";
                }

            });

            window.livewire.on('mensaje_error', msj => {
                $('#modal_agregar').modal('hide');
                swalWithBootstrapButtons(
                    'Atención',
                    msj,
                    'error'
                )
            });

            window.livewire.on('cobro_exito', msj => {
                $('#modal_agregar').modal('hide');
                swal({
                    title: 'Buen Trabajo',
                    text: msj,
                    type: 'success',
                    padding: '2em'
                })
            });

            window.livewire.on('estado_exito', msj => {
                $('#modal_estado').modal('hide');
                swal({
                    title: 'Buen Trabajo',
                    text: msj,
                    type: 'success',
                    padding: '2em'
                })
            });
        });

        function actualizar(){
            Livewire.emit('render');
        }

        function datos(cursoAlumno){
            Livewire.emit('datos', cursoAlumno);
        }
    </script>
@endsection

