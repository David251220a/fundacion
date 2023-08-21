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
        $('#modal_nuevo_insumo').modal('hide');
        $('#modal_pago_insumo').modal('hide');
        $('#recibo_pago_vario').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('reporte', msj => {
        $('#modal_nuevo_insumo').modal('hide');
        $('#modal_pago_insumo').modal('hide');
        $('#recibo_pago_vario').modal('show');
    });


    window.livewire.on('correcto', msj => {
        $('#modal_nuevo_insumo').modal('hide');
        $('#modal_pago_insumo').modal('hide');
        $('#recibo_pago_vario').modal('hide');
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
        title: 'Desea eliminar insumo?',
        text: "Esta acción se puede revertir en la sección de Insumo Inactivos!",
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
        title: 'Desea activar insumo?',
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

