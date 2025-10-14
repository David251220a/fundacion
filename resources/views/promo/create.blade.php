@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ckeditor-styles.css') }}">
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-lg-10 col-md-10 col-sm-12">
            <h2 class="">Crear Promo</h2>
        </div>
    </div>

    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <form action="{{route('promo.store')}}" method="POST" enctype="multipart/form-data" onsubmit="disableButton()">
                        @csrf
                        <div class="form-row mb-2">
                            <div class="form-group col-md-6">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" class="form-control" placeholder="descripcion" name="descripcion" id="descripcion" value="{{old('descripcion')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fecha_inicio">Fecha Inicio</label>
                                <input type="date" class="form-control" placeholder="fecha_inicio" name="fecha_inicio" id="fecha_inicio" value="{{old('fecha_inicio')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fecha_fin">Fecha Fin</label>
                                <input type="date" class="form-control" placeholder="fecha_fin" name="fecha_fin" id="fecha_fin" value="{{old('fecha_fin')}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="procentaje">Porcentaje</label>
                                <input type="text" class="form-control" placeholder="procentaje" name="procentaje" id="procentaje" value="{{old('procentaje')}}">
                            </div>
                            
                        </div>

                        <div class="form-row mb-2">
                            <div class="form-group col-md-1">
                                <label for="lunes" style="width: 100%">Lunes</label>
                                <input type="checkbox" name="lunes" id="lunes">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="martes" style="width: 100%">Martes</label>
                                <input type="checkbox" name="martes" id="martes">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="miercoles" style="width: 100%">Miercoles</label>
                                <input type="checkbox" name="miercoles" id="miercoles">
                            </div>
                             <div class="form-group col-md-1">
                                <label for="jueves" style="width: 100%">Jueves</label>
                                <input type="checkbox" name="jueves" id="jueves">
                            </div>
                             <div class="form-group col-md-1">
                                <label for="viernes" style="width: 100%">Viernes</label>
                                <input type="checkbox" name="viernes" id="viernes">
                            </div>
                             <div class="form-group col-md-1">
                                <label for="sabado" style="width: 100%">Sabado</label>
                                <input type="checkbox" name="sabado" id="sabado">
                            </div>
                             <div class="form-group col-md-1">
                                <label for="domingo" style="width: 100%">Domingo</label>
                                <input type="checkbox" name="domingo" id="domingo">
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
    <script>
        function disableButton() {
            document.getElementById('submitBtn').disabled = true;
        }

    </script>
@endsection
