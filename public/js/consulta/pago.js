const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success btn-rounded',
    cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
    buttonsStyling: false,
})
window.addEventListener('load', function() {

    window.livewire.on('reloadClassCSs', msj => {
        let mensaje = document.getElementById("mensaje");
        let mensaje_2 = document.getElementById("mensaje_2");
        let comprobante = document.getElementById("comprobante");

        if(mensaje != null){
            document.getElementById("mensaje").style.display = "none";
        }

        if(mensaje_2 != null){
            document.getElementById("mensaje_2").style.display = "none";
        }

        if(comprobante != null){
            document.getElementById("comprobante").style.display = "none";
        }
    });


    window.livewire.on('mensaje_error', msj => {
        $('#modal_agregar').modal('hide');
        $('#modal_agregar_certificado').modal('hide');
        $('#recibo_comprobante_certificado').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('reporte', msj => {
        $('#modal_agregar').modal('hide');
        $('#modal_agregar_certificado').modal('hide');
        $('#recibo_comprobante').modal('show');
    });

    window.livewire.on('reporte_cert', msj => {
        $('#modal_agregar').modal('hide');
        $('#modal_agregar_certificado').modal('hide');
        $('#recibo_comprobante_certificado').modal('show');
    });

    window.livewire.on('reporte_insumo', msj => {
        $('#modal_cobrar_insumo').modal('hide');
        $('#recibo_comprobante_ingreso').modal('show');
    });


    window.livewire.on('correcto', msj => {
        // $('#modal_agregar').modal('hide');
        // $('#recibo_comprobante').modal('hide');
        // $('#modal_agregar_certificado').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

});

function anular_instructor(id)
{
    swal({
        title: 'Desea anular el pago?',
        text: "Esta acción no se puede revertir!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confimar',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            Livewire.emit('anular_instructor', id);
        }

    })

}

function exonerar_insumo(id)
{
    swal({
        title: 'Desea exonerar el insumo?',
        text: "Esta acción no se puede revertir!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Exonerar',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            Livewire.emit('exonerar_insumo', id);
        }

    })

}
