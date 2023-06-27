@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Ingreso Varios {{ ($id == 2 ? ' - Cobros Pendiente' : '') }} </h2>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Buscar Persona</h2>
            </div>
        </div>

        <form action="{{route('ingreso_varios.buscar_post', $id)}}" method="POST" onsubmit="disableButton()">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="">Documento</label>
                    <input type="text" class="form-control w-full text-right" style="width: 100%" name="documento" onkeyup="punto_decimal(this)">
                </div>
            </div>

            <div class="form-row">
                <button class="btn btn-success mr-3" type="submit" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Siguiente</button>
                <a href="{{route('ingreso_varios.index')}}" class="btn btn-warning">Volver al Inicio</a>
            </div>
        </form>

    </div>

@endsection

@section('js')

@endsection
