const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success btn-rounded',
    cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
    buttonsStyling: false,
})


window.addEventListener('load', function() {

    window.livewire.on('reloadClassCSs', msj => {
        let mensaje = document.getElementById("mensaje");
        let mensaje_2 = document.getElementById("mensaje_2");
        let mensaje_3 = document.getElementById("mensaje_insumo");
        let mensaje_4 = document.getElementById("mensaje_insumo_1");
        if(mensaje != null){
            document.getElementById("mensaje").style.display = "none";
        }

        if(mensaje_2 != null){
            document.getElementById("mensaje_2").style.display = "none";
        }

        if(mensaje_3 != null){
            document.getElementById("mensaje_insumo").style.display = "none";
        }

        if(mensaje_4 != null){
            document.getElementById("mensaje_insumo_1").style.display = "none";
        }

    });

    window.livewire.on('mensaje_error', msj => {
        $('#modal_agregar').modal('hide');
        $('#modal_agregar_certificado').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('cobro_exito', msj => {
        $('#modal_agregar').modal('hide');
        $('#modal_agregar_certificado').modal('hide');
        $('#recibo_comprobante').modal('show');
        // swal({
        //     title: 'Buen Trabajo',
        //     text: msj,
        //     type: 'success',
        //     padding: '2em'
        // })
    });

    window.livewire.on('estado_exito', msj => {
        $('#modal_estado').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

    window.livewire.on('validacion', msj => {
        $('#modal_insumo').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('confirma_ingreso', msj => {
        $('#modal_insumo').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });
});

function actualizar(){
    Livewire.emit('render');
}

function datos(cursoAlumno){
    Livewire.emit('datos', cursoAlumno);
}

function estado_cuenta(cursoAlumno, alumno){
    Livewire.emit('estado_cuenta', cursoAlumno, alumno);
}

function datos_insumo(id){
    Livewire.emit('datos', id);
}
