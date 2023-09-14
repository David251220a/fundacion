window.addEventListener('load', function() {

    window.livewire.on('reloadClassCSs', msj => {

    });

    window.livewire.on('correcto', msj => {
        swal({
            title: 'Buen Trabajo',
            text: msj,
            type: 'success',
            padding: '2em'
        })
    });

});

function anular_curso()
{
    swal({
        title: 'Desea anular esta boleta de recibo?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Anular',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            Livewire.emit('anular');
        }

    })
}

function anular_cierre()
{
    swal({
        title: 'Desea cierre de caja?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Anular',
        padding: '2em'
    }).then(function(result) {
        if (result.value) {
            Livewire.emit('anular');
        }

    })
}
