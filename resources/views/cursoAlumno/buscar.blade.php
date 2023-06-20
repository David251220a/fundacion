@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Cursos - Agregar Alumno </h2>
            </div>
        </div>

        <form action="{{route('cursoAlumno.buscar_post', $cursoHabilitado)}}" method="POST" onsubmit="disableButton()">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="">Documento</label>
                    <input type="text" class="form-control w-full" style="width: 100%" name="documento">
                </div>
            </div>

            <div class="form-row">
                <button class="btn btn-success" type="submit" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Siguiente</button>
            </div>
        </form>

    </div>

@endsection

@section('js')

@endsection
