@extends('layouts.admin')

@section('styles')
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <form action="{{route('habilitado.calificar_post', $cursoHabilitado)}}" method="POST">
        @csrf
        @include('ui.calificar')
    </form>
@endsection

@section('js')
    <script>
        function asistencia_completo()
        {
            let completo = document.getElementById('completa').value;
            let valor = false;
            let valor_1 = 0;

            if(completo == 0){
                valor = true;
                valor_1 = 1;
                document.getElementById('completa').value = 1;
            }else{
                valor = false;
                document.getElementById('completa').value = 0;
            }
            var checkboxes = document.querySelectorAll(".presente");
            // Establecer el estado "checked" para cada elemento checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = valor;
                checkbox.value = valor_1;
            });

            var inputs = document.querySelectorAll(".asis_v");

            // Establecer el valor en cada elemento <input>
            inputs.forEach(function(input) {
            input.value = valor_1;
            });
        }

        function cambiar_v(input)
        {
            let completo = input.value;
            let valor = false;
            let v_id = input.id;
            let id = v_id.replace(/[^\d\.]*/g,'');
            let nombre = 'asistencia_valor_' + id.toString();
            let nuevo = document.getElementById(nombre);
            if(input.checked == true){
                valor = true;
                input.value = 1;
                input.checked = valor;
                nuevo.value = 1;
            }else{
                valor = false;
                input.value = 0;
                input.checked = valor;
                nuevo.value = 0;
            }
        }
    </script>
@endsection
