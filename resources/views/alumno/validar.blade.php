@extends('layouts.admin')

@section('styles')
@endsection

@section('content')

    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="row" style="margin-left: 3px">
                    <h3 class="mb-4">Validar Alumno</h3>
                </div>
                <form class="needs-validation" action="{{route('alumno.validar_post')}}" method="POST" >
                    @csrf

                    <div class="form-row">

                        <div class="col-md-3 col-sm-6 mb-4">
                            <label for="">Documento</label>
                            <input type="text" name="documento" id="documento" class="form-control text-right" placeholder="Documento" required>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Siguiente</button>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('js')
@endsection
