@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-lg-10 col-md-10 col-sm-12">
            <h2 class="">Habilitar Curso</h2>
        </div>
    </div>

    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <form action="{{route('habilitado.store')}}" method="POST" enctype="multipart/form-data" onsubmit="disableButton()">
                        @csrf
                        @livewire('habilitado.habilitado-create')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Descripcion</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{old('descripcion')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Observacion</label>
                                <input type="text" name="observacion" id="observacion" class="form-control" value="{{old('observacion')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Fecha Inicio</label>
                                <input type="date" name="periodo_desde" id="periodo_desde" class="form-control" value="{{old('periodo_desde')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Fecha Fin</label>
                                <input type="date" name="periodo_hasta" id="periodo_hasta" class="form-control" value="{{old('periodo_hasta')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Duración</label>
                                <input type="text" name="duracion" id="duracion" class="form-control text-right" onkeyup="punto_decimal_n(this)" value="{{old('duracion')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Periodo</label>
                                <select name="periodo_id" id="periodo_id" class="form-control">
                                    @foreach ($periodo as $item)
                                        <option {{ (old('periodo_id') == $item->id ? 'selected' : '' ) }} value="{{$item->id}}">{{$item->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Horario de Entrada</label>
                                <input type="time" name="hora_entrada" id="hora_entrada" class="form-control" value="{{old('hora_entrada')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Horario de Salida</label>
                                <input type="time" name="hora_salida" id="hora_salida" class="form-control" value="{{old('hora_salida')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Foto Portada</label>
                                <input type="file" name="portada" id="portada" class="form-control" value="{{old('portada')}}" accept="image/*">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Publicar en Seccion de Noticias</label>
                                <select name="publicar" id="publicar" class="form-control">
                                    <option {{ (old('publicar') == 1 ? 'selected' : '') }} value="1">NO</option>
                                    <option {{ (old('publicar') == 2 ? 'selected' : '') }} value="2">SI</option>
                                </select>
                            </div>
                            <div class="form-group cold-md-12">
                                <label for="w-full" style="width: 100%">Dias de clase</label>
                                <input type="checkbox" name="lunes" id="lunes" class="" {{ (old('lunes') ? 'checked' : '' ) }}>
                                <label for="checkbox" class="mr-3">Lunes</label>
                                <input type="checkbox" name="martes" id="martes" class="" {{ (old('martes') ? 'checked' : '' ) }}>
                                <label for="checkbox" class="mr-3">Martes</label>
                                <input type="checkbox" name="miercoles" id="miercoles" class="" {{ (old('miercoles') ? 'checked' : '' ) }}>
                                <label for="checkbox" class="mr-3">Miercoles</label>
                                <input type="checkbox" name="jueves" id="jueves" class="" {{ (old('jueves') ? 'checked' : '' ) }}>
                                <label for="checkbox" class="mr-3">Jueves</label>
                                <input type="checkbox" name="viernes" id="viernes" class="" {{ (old('viernes') ? 'checked' : '' ) }}>
                                <label for="checkbox" class="mr-3">Viernes</label>
                                <input type="checkbox" name="sabado" id="sabado" class="" {{ (old('sabado') ? 'checked' : '' ) }}>
                                <label for="checkbox" class="mr-3">Sabado</label>
                                <input type="checkbox" name="domingo" id="domingo" class="" {{ (old('domingo') ? 'checked' : '' ) }}>
                                <label for="checkbox" class="mr-3">Domingo</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-3" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script>
        var ss = $(".basic").select2({
            tags: true,
        });

        var dd = $(".basic-2").select2({
            tags: true,
        });

        function actualizar(){
            Livewire.emit('render');
        }

    </script>
@endsection
