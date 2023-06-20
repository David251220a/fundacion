@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="col-lg-12 layout-spacing mt-4">
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2 class="">Cursos - Agregar Alumno </h2>
                </div>
            </div>

            <form action="{{route('cursoAlumno.agregar_alumno_post', [$cursoHabilitado, $alumno] )}}" method="POST" onsubmit="disableButton()">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="">Documento</label>
                        <input type="text" class="form-control w-full text-right" value="{{number_format($alumno->persona->documento, 0, ".", ".")}}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control w-full text-right" value="{{$alumno->persona->nombre}}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Apellido</label>
                        <input type="text" class="form-control w-full text-right" value="{{$alumno->persona->apellido}}" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Cursos a Inscribirse</label>
                        <input type="text" class="form-control w-full text-right" value="{{$cursoHabilitado->curso->descripcion}}" readonly>
                    </div>
                </div>

                <h3>Detalle de Pago</h3>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="">Curso Precio</label>
                        <input type="text" class="form-control w-full text-right" value="{{number_format($cursoHabilitado->precio, 0, ".", ".")}}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Total a pagar</label>
                        <input type="text" class="form-control w-full text-right" name="total_pagar" id="total_pagar" value="0" onkeyup="punto_decimal_limite(this)">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Forma de Pago</label>
                        <select name="forma_pago_id" id="forma_pago_id" class="form-control">
                            @foreach ($forma_pago as $item)
                                <option value="{{$item->id}}">{{$item->descripcion}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="form-row">
                    <button class="btn btn-success" type="submit" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Inscribir</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')

@endsection
