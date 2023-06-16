window.addEventListener('load', function() {

    window.livewire.on('reloadClassCSs', msj => {
        $(".mensaje").css("display", "none");
        document.getElementById("mensaje_departamento").style.display = "none";
        // $('#limpiar').css("display", "none");
    });

    window.livewire.on('pais-add', msj => {
        $('#paismodal').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

    window.livewire.on('departamento-add', msj => {
        $('#deparmodal').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

    window.livewire.on('barrio-add', msj => {
        $('#ciudadbarrio').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

    window.livewire.on('departamento-error', msj => {
        // $(".mensaje_departamento").css("display", "block");
        console.log(msj);
        document.getElementById("mensaje_departamento").style.display = "block";
        document.getElementById("contenido_departamento").innerHTML = msj;
    });

    window.livewire.on('ciudad-add', msj => {
        $('#ciudadmodal').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

    window.livewire.on('ciudad-error', msj => {
        // $(".mensaje_departamento").css("display", "block");
        console.log(msj);
        document.getElementById("mensaje_ciudad").style.display = "block";
        document.getElementById("contenido_ciudad").innerHTML = msj;
    });

    window.livewire.on('barrio-error', msj => {
        // $(".mensaje_departamento").css("display", "block");
        console.log(msj);
        document.getElementById("mensaje_barrio").style.display = "block";
        document.getElementById("contenido_barrio").innerHTML = msj;
    });

    window.livewire.on('pais-upd', msj => {
        $('#modal').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

    window.livewire.on('editar', function() {
        var intro = document.getElementById('limpiar');
        $(".mensaje").css("display", "none");
        // $('#limpiar').css("display", "none");
        $('#modal').modal('show');
    });

    Livewire.on('eliminar', identificador => {

        Swal.fire({
            title: 'Eliminar Pais',
            text: 'Desea eliminar el Pais?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then(function(result) {
            if (result.value) {
                Livewire.emit('destroy', identificador);
            }
        })
    });

    window.livewire.on('pais-del', msj => {
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });


});


function actualizar_departamento(){
    Livewire.emit('updatedDepartamento');
}

function actualizar_pais(){
    Livewire.emit('updatedPais');
}



