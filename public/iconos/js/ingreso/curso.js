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

    window.livewire.on('abrir_modal', msj => {
        $('#modal_agregar').modal('show');
    });

    window.livewire.on('mensaje_error', msj => {
        $('#modal_agregar').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('ver_recibo', msj => {
        $('#modal_agregar').modal('hide');
        $('#modal_agregar_certificado').modal('hide');
        $('#recibo_comprobante').modal('show');
    });

});

function datos(cursoAlumno){
    Livewire.emit('datos', cursoAlumno);
}
