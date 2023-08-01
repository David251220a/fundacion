// const swalWithBootstrapButtons = swal.mixin({
//     confirmButtonClass: 'btn btn-success btn-rounded',
//     cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
//     buttonsStyling: false,
// })


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
        $('#modal_agregar').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            msj,
            'error'
        )
    });

    window.livewire.on('cobro_exito', msj => {
        $('#modal_agregar').modal('hide');
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
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

});

function filtro(id){
    Livewire.emit('filtro', id);
}

function datos(ingreso_id)
{
    Livewire.emit('ver_recibo', ingreso_id);
    $('#recibo_comprobante').modal('show');
}

function anular(ingreso_id)
{
    swal({
        title: 'Desea anular este ingreso?',
        text: "No podras revertir este cambio!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Anular',
        padding: '2em'
      }).then(function(result) {
        if (result.value) {
            Livewire.emit('anular', ingreso_id);
          swal(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      })
}


function actualizar_curso()
{
    Livewire.emit('actualizar_curso');
}
