@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-lg-10 col-md-10 col-sm-12">
            <h2 class="">Editar Curso: {{$curso->descripcion}}</h2>
        </div>
    </div>

    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <form action="{{route('curso.update', $curso)}}" method="POST" enctype="multipart/form-data" onsubmit="disableButton()">
                        @method('PUT')
                        @csrf
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Familia</label>
                                <select name="tipo_curso_id" id="tipo_curso_id" class="form-control basic">
                                    @foreach ($tipo_curso as $item)
                                        <option {{ (old('tipo_curso_id', $curso->tipo_curso_id)== $item->id ? 'selected' : '') }} value="{{$item->id}}">{{$item->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Descripcion</label>
                                <input type="text" class="form-control" placeholder="Descripcion" name="descripcion" id="descripcion" value="{{old('descripcion', $curso->descripcion)}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Modulo</label>
                                <select name="curso_modulo_id" id="curso_modulo_id" class="form-control basic">
                                    @foreach ($modulo as $item)
                                        <option {{ (old('curso_modulo_id', $curso->curso_modulo_id)== $item->id ? 'selected' : '') }} value="{{$item->id}}">{{$item->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Estado</label>
                                <select name="estado_id" id="estado_id" class="form-control">
                                    <option {{ (old('tipo_curso_id', $curso->estado_id) == 1 ? 'selected' : '') }} value="1">ACTIVO</option>
                                    <option {{ (old('tipo_curso_id', $curso->estado_id) == 2 ? 'selected' : '') }} value="2">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                      <button type="submit" class="btn btn-success mt-3" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
    <script>
        function disableButton() {
            document.getElementById('submitBtn').disabled = true;
        }
        var ss = $(".basic").select2({
            tags: true,
        });
    </script>
@endsection
