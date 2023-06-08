@extends('layouts.admin')

@section('styles')
@endsection

@section('content')

    <div class="layout-px-spacing">

        <h2 class="mt-3">Crear Rol</h2>
        <div class="widget-content widget-content-area">
            <form action="{{ route('role.store') }}" method="POST" onsubmit="return checkSubmit();">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                        <label for="">Rol</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </div>

@endsection

@section('js')
@endsection
