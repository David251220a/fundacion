enviando = false; //Obligaremos a entrar el if en el primer submit

function checkSubmit() {
    if (!enviando) {
        enviando= true;
        return true;
    } else {
        return false;
    }
}

function punto_decimal(input){
    var num = input.value.replace(/\./g,'');
    if(!isNaN(num)){
        if(num == ''){

        }else{
            num = parseInt(num);
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }

    }
    else{
        input.value = input.value.replace(/[^\d\.]*/g,'');
    }
}

function punto_decimal_limite(input){
    var num = input.value.replace(/\./g,'');
    if(!isNaN(num)){
        if(num == ''){

        }else{
            if (num > 9999999) {
                aux_num = num.toString().length;
                cantidad = ((parseInt(aux_num) - 7) * -1);
                num = num.slice(0, cantidad);
            }
            num = parseInt(num);
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }

    }
    else{
        input.value = input.value.replace(/[^\d\.]*/g,'');
    }
}

function punto_decimal_n(input){
    var num = input.value.replace(/\./g,'');
    if(!isNaN(num)){
        if(num == ''){

        }else{
            if (num > 99) {
                num = num.slice(0, -1);
            }
            num = parseInt(num);
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }

    }
    else{
        input.value = input.value.replace(/[^\d\.]*/g,'');
    }
}

function abrir_modal(agenda_id)
{
    let modal = document.getElementById('edit_estado').innerHTML;
    Swal.fire({
        title: '<h3>Editar Estado</h3>',
        html:
        modal,
        width: 600,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',

        }).then(resultado => {
            if (resultado.value) {
                let estado_consulta_id = Swal.getPopup().querySelector('#estado_consulta_id').value;
                axios.post('/doctor/consulta/edit/estado',  {
                    estado_consulta_id : estado_consulta_id,
                    agenda_id : agenda_id,
                })
                .then(respuesta => {
                    if(respuesta.data.ok == 1){
                        let select = document.getElementById(agenda_id);
                        select.innerHTML = respuesta.data.descripcion;
                        Swal.fire(
                            'Estado Consulta',
                            respuesta.data.mensaje,
                            'success'
                        )
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: respuesta.data.mensaje,
                        })
                    }

                })
                .catch(error => {
                    console.log(error);
                })
            }

    })

}


function punto_decimal_limite_precio(input){
    var num = input.value.replace(/\./g,'');
    var precio = parseInt(document.getElementById('curso_precio').value.replace(/\./g,''));
    if(!isNaN(num)){
        if(num == ''){

        }else{
            if (num > precio) {
                aux_num = num.toString().length;
                aux_precio = precio.toString().length;
                if(parseInt(aux_num) == parseInt(aux_precio)){
                    cantidad = -1;
                }else{
                    cantidad = ((parseInt(aux_num) - parseInt(aux_precio)) * -1);
                }
                num = num.slice(0, cantidad);
            }
            num = parseInt(num);
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }

    }
    else{
        input.value = input.value.replace(/[^\d\.]*/g,'');
    }
}

function disableButton() {
    document.getElementById('submitBtn').disabled = true;
}


function punto_decimal_limite_precio_certificado(input){
    var num = input.value.replace(/\./g,'');
    var precio = parseInt(document.getElementById('precio_certificado').value.replace(/\./g,''));
    if(!isNaN(num)){
        if(num == ''){

        }else{
            if (num > precio) {
                aux_num = num.toString().length;
                aux_precio = precio.toString().length;
                if(parseInt(aux_num) == parseInt(aux_precio)){
                    cantidad = -1;
                }else{
                    cantidad = ((parseInt(aux_num) - parseInt(aux_precio)) * -1);
                }
                num = num.slice(0, cantidad);
            }
            num = parseInt(num);
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }

    }
    else{
        input.value = input.value.replace(/[^\d\.]*/g,'');
    }
}
