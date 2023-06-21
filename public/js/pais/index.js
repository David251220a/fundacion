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
        // console.log(msj);
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

function actualizar_ciudad(){
    Livewire.emit('updatedCiudad');
}

function actualizar_pais(){
    Livewire.emit('updatedPais');
}

let x = 0;

function agregar_datos()
{
    let pasa = validar();
    if (pasa == true){
        let nombre = document.getElementById('f_nombre').value;
        let apellido = document.getElementById('f_apellido').value;
        let tipo_familia = document.getElementById('tipo_familia').value;
        let partido = document.getElementById('partido').value;
        let descripcion_familia = '';
        let descripcion_partido = '';
        x = x +1;

        var selectElement = document.getElementById('tipo_familia');
        var selectpartido = document.getElementById('partido');

        for (var i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].value === tipo_familia) {
                descripcion_familia = selectElement.options[i].text;
                break;
            }
        }

        for (var i = 0; i < selectpartido.options.length; i++) {
            if (selectpartido.options[i].value === partido) {
                descripcion_partido = selectpartido.options[i].text;
                break;
            }
        }

        document.getElementById("datos_familia").insertRow(-1).innerHTML = '<tr>\
                                                                                <td class"text-center"> \
                                                                                    <input type="hidden" name="familia_id[]" id="familia_id[]" value="0"> \
                                                                                    <input type="hidden" class="" name="nombre_familiar[]" value="'+nombre+'"> \
                                                                                    '+nombre+' \
                                                                                </td>\
                                                                                <td class"text-center"> \
                                                                                    <input type="hidden" class="form-control" name="apellido_familiar[]" value="'+apellido+'"> \
                                                                                    '+apellido+' \
                                                                                </td>\
                                                                                <td class"text-center"> \
                                                                                    <input type="hidden" class="form-control" name="tipo_familia[]" value="'+tipo_familia+'"> \
                                                                                    '+descripcion_familia+' \
                                                                                </td>\
                                                                                <td class"text-center"> \
                                                                                    <input type="hidden" class="form-control" name="partido[]" value="'+partido+'"> \
                                                                                    '+descripcion_partido+' \
                                                                                </td>\
                                                                                <td class"text-center"> \
                                                                                    <button id="'+x+'" type="button" onclick="eliminar_fila(this)"><i class="fas fa-backspace"></i></button> \
                                                                                </td>\
                                                                            </tr>';

        limpiar();
    }



}

function validar()
{
    let nombre = document.getElementById('f_nombre').value;
    let apellido = document.getElementById('f_apellido').value;

    if (nombre === '')
    {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El nombre de familiar no puede estar vacio!'
        })

        return false
    }

    if (apellido === '')
    {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El apellido de familiar no puede estar vacio!'
        })

        return false
    }

    return true
}


function eliminar_fila(input)
{
    $(input).closest('tr').remove();
}

function limpiar()
{
    document.getElementById('f_nombre').value = '';
    document.getElementById('f_apellido').value = '';
}


