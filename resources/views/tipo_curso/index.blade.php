@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <link href="{{asset('assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @livewire('tipo-curso.tipo-curso-index')
@endsection

@section('js')
    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script>

        window.addEventListener('load', function() {

            window.livewire.on('reloadClassCSs', msj => {
                if(document.getElementById("mensaje") != null){
                    document.getElementById("mensaje").style.display = "none";
                }
            });

            window.livewire.on('tipo-add', msj => {
                $('#modal_agregar').modal('hide');
                swal({
                    title: 'Buen Trabajo',
                    text: msj,
                    type: 'success',
                    padding: '2em'
                })
            });

            window.livewire.on('mostrar-actualizado', msj => {
                $('#modal_editar').modal('hide');
                swal({
                    title: 'Buen Trabajo',
                    text: msj,
                    type: 'success',
                    padding: '2em'
                })
            });

            window.livewire.on('mostrar-edit', msj => {
                $('#modal_editar').modal('show');
            });



        });

        function edicion(tipoCurso){
            Livewire.emit('editar', tipoCurso);
        }
    </script>
@endsection
