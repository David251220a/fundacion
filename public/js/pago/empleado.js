const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success btn-rounded',
    cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
    buttonsStyling: false,
})
window.addEventListener('load', function() {

    window.livewire.on('reloadClassCSs', msj => {
        let mensaje = document.getElementById("mensaje");
        let mensaje_2 = document.getElementById("mensaje_2");
        if(mensaje != null){
            document.getElementById("mensaje").style.display = "none";
        }

        if(mensaje_2 != null){
            document.getElementById("mensaje_2").style.display = "none";
        }
    });


    window.livewire.on('mensaje_error', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_empleado_agregar').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('reporte', msj => {
        $('#modal_heredado_tab').modal('hide');
        $('#modal_anticipo_heredado_tab').modal('hide');
        $('#modal_salario_instructor').modal('hide');
        $('#recibo_salario_reporte').modal('hide');
        $('#recibo_anticipo').modal('show');
    });

    window.livewire.on('añadir_empleado', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_empleado_agregar').modal('show');
    });

    window.livewire.on('correcto', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_empleado_agregar').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

});

