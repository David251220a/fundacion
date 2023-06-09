@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">{{$cursoHabilitado->curso->descripcion}} </h2>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Cursos - Agregar Alumno </h2>
            </div>
        </div>

        <form action="{{route('cursoAlumno.buscar_post', $cursoHabilitado)}}" method="POST" onsubmit="disableButton()">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="">Documento</label>
                    <input type="text" class="form-control text-right" style="width: 100%" name="documento" onkeyup="punto_decimal(this)">
                </div>
            </div>

            <div class="form-row">
                <button class="btn btn-success mr-3" type="submit" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Siguiente</button>
                <a href="{{route('habilitado.show', $cursoHabilitado)}}" class="btn btn-info mr-3">Ir al Curso</a>
                <a href="{{route('habilitado.index')}}" class="btn btn-warning">Volver al Inicio</a>
            </div>
        </form>

    </div>

@endsection

@section('js')

@endsection
