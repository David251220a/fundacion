@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="layout-px-spacing">

        <h2 class="mt-3">Editar Usuario: {{$user->name}}</h2>
        <div class="widget-content widget-content-area">
            <form action="{{route('user.update', $user)}}" method="post" onsubmit="return checkSubmit();">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                        <label for="">Documento</label>
                        <input type="text" class="form-control" name="documento" value="{{old('documento', number_format($user->documento, 0, ".", "."))}}"
                        onkeyup="punto_decimal(this)" onchange="punto_decimal(this)" required>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                        <label for="">Nombre y Apellido</label>
                        <input type="text" class="form-control" name="name" value="{{old('name', $user->name)}}" required>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" value="{{old('email', $user->email)}}" >
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                        <label for="">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}" >
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                        <label for="">Repetir Contraseña</label>
                        <input type="password" class="form-control" name="password_rep" id="password_rep" value="{{old('password')}}"
                        onkeyup="verificar_pass()" >
                        <span id="msj" style="display: none"><p style="color: red">Las contraseñas no coinciden!!</p></span>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                        <label for="">Grupo</label>
                        <select name="rol" id="rol" class="form-control">
                            <option value=""></option>
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}" {{ $user->hasRole($item->id) ? 'selected' : null }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" id="enviar" class="btn btn-success ml-3">Editar</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
<script>

    function verificar_pass()
    {
        let valorInput1 = document.getElementById('password').value;
        let valorInput2 = document.getElementById('password_rep').value;
        let enviar = document.getElementById('enviar');
        let msj = document.getElementById('msj');

        if (valorInput1 === valorInput2) {
            enviar.disabled = false;
            msj.style.display = 'none';
        } else {
            enviar.disabled = true;
            msj.style.display = 'block';
        }
    }

</script>
@endsection
