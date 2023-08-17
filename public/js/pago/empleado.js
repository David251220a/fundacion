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
        $('#modal_salario_empleado_edit').modal('hide');
        $('#modal_salario_empleado_anticipo').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('reporte', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_empleado_agregar').modal('hide');
        $('#modal_salario_empleado_edit').modal('hide');
        $('#modal_salario_empleado_anticipo').modal('hide');
        $('#recibo_anticipo').modal('show');
    });

    window.livewire.on('añadir_empleado', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_empleado_agregar').modal('show');
    });

    window.livewire.on('correcto', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_empleado_agregar').modal('hide');
        $('#modal_salario_empleado_edit').modal('hide');
        $('#modal_salario_empleado_anticipo').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

});

function eliminar(id)
{
    swal({
        title: 'Desea eliminar empleado?',
        text: "Esta acción se puede revertir en la sección de Empleado Inactivos!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            Livewire.emit('delete', id);
        }

    })

}

function activar(id)
{
    swal({
        title: 'Desea activar empleado?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Activar',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            Livewire.emit('activar', id);
        }

    })
}

