@extends('layouts.admin')

@section('styles')
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
@endsection

@section('content')

    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="row" style="margin-left: 3px">
                    <h3 class="mb-4">Editar Instructor: {{$data->nombre}} {{$data->apellido}}</h3>
                </div>
                <form class="needs-validation" action="{{route('instructor.update', $instructor)}}" method="POST" >
                    @method('PUT')
                    @csrf

                    <div class="form-row">

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Documento</label>
                            <input type="text" name="documento" id="documento" class="form-control text-right" placeholder="Documento" value="{{old('documento', $data->documento)}}" required>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre..." value="{{old('nombre', $data->nombre)}}" required>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido..." value="{{old('apellido', $data->apellido)}}" required>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Fecha Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{old('fecha_nacimiento', $data->fecha_nacimiento)}}">
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Sexo</label>
                            <select name="sexo" id="sexo" class="form-control">
                                <option {{ ($data->sexo == 0 ? 'selected' : '') }} value="0">SIN ESPECIFICAR</option>
                                <option {{ ($data->sexo == 1 ? 'selected' : '') }} value="1">MASCULINO</option>
                                <option {{ ($data->sexo == 2 ? 'selected' : '') }} value="2">FEMENINO</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Celular</label>
                            <input type="text" name="celular" id="celular" class="form-control" value="{{old('celular', $data->celular)}}">
                        </div>

                        <div class="col-md-6 col-sm-6 mb-4">
                            <label for="">Direccion</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion', $data->direccion)}}">
                        </div>

                    </div>

                    @livewire('persona.editar-persona', ['persona' => $data])

                    <div class="form-row">
                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Estado Civil</label>
                            <select name="estado_civil_id" id="estado_civil_id" class="form-control">
                                @foreach ($estado_civil as $item)
                                    <option {{( old('', $data->estado_civil_id) == $item->id ? 'selected' : '' )}} value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">P</label>
                            <select name="partido_id" id="partido_id" class="form-control">
                                @foreach ($partido as $item)
                                    <option {{( old('', $data->partido_id) == $item->id ? 'selected' : '' )}} value="{{$item->id}}">{{$item->alias}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Estado</label>
                            <select name="estado_id" id="estado_id" class="form-control">
                                <option {{ ($data->estado_id == 1 ? 'selected' : '') }} value="1">ACTIVO</option>
                                <option {{ ($data->estado_id == 2 ? 'selected' : '') }} value="2">INACTIVO</option>
                            </select>
                        </div>
                    </div>

                    <h2>Familiares</h2>

                    <div class="form-row">

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Nombre</label>
                            <input type="text" id="f_nombre" class="form-control" placeholder="Nombre...">
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Apellido</label>
                            <input type="text" id="f_apellido" class="form-control" placeholder="apellido...">
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Tipo Familiar</label>
                            <select id="tipo_familia" class="form-control">
                                @foreach ($tipo_familia as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-2 mb-4">
                            <label for="">P</label>
                            <select id="partido" class="form-control">
                                @foreach ($partido as $item)
                                    <option value="{{$item->id}}">{{$item->alias}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-2 mb-4">
                            <label for="">Accion</label>
                            <button type="button" class="btn btn-primary btn-lg" onclick="agregar_datos()">Agregar</button>
                        </div>

                    </div>

                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="table-responsive widget-content widget-content-area br-6">
                            <table class="table dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Tipo Familia</th>
                                        <th>P</th>
                                        <th class="no-content">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="datos_familia">
                                    @foreach ($data->familiares as $item)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="familia_id[]" id="familia_id[]" value="{{$item->id}}">
                                                <input type="hidden" class="" name="nombre_familiar[]" value="{{$item->nombre}}">
                                                {{$item->nombre}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control" name="apellido_familiar[]" value="{{$item->apellido}}">
                                                {{$item->apellido}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control" name="tipo_familia[]" value="{{$item->tipo_familia}}">
                                                {{$item->tipo_familiar->descripcion}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control" name="partido[]" value="{{$item->partido}}">
                                                {{$item->partido->alias}}
                                            </td>
                                            <td><button id="{{$loop->iteration}}" type="button" onclick="eliminar_fila(this)"><i class="fas fa-backspace"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Grabar</button>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('js/pais/index.js')}}"></script>
@endsection
