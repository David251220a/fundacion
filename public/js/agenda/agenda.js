const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success btn-rounded',
    cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
    buttonsStyling: false,
})
window.addEventListener('load', function() {

    window.livewire.on('reloadClassCSs', msj => {
        let mensaje_nombre = document.getElementById("mensaje_nombre");
        let mensaje_apellido = document.getElementById("mensaje_apellido");
        let mensaje_documento = document.getElementById("mensaje_documento");
        if(mensaje_nombre != null){
            document.getElementById("mensaje_nombre").style.display = "none";
        }

        if(mensaje_apellido != null){
            document.getElementById("mensaje_apellido").style.display = "none";
        }

        if(mensaje_documento != null){
            document.getElementById("mensaje_documento").style.display = "none";
        }

    });

    window.livewire.on('mensaje_error', msj => {
        $('#modal_agregar').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('crear', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_agregar').modal('show');
    });

    window.livewire.on('confirmar_creacion', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_confirmar').modal('show');
    });

    window.livewire.on('guardado', msj => {
        $('#modal_buscar').modal('hide');
        $('#modal_agregar').modal('hide');
        $('#modal_confirmar').modal('hide');
        swal({
            title: 'Buen Trabajo!',
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
