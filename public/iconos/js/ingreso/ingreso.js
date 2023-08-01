var ss = $(".basic").select2({
    tags: true,
});

const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success btn-rounded',
    cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
    buttonsStyling: false,
})

function grabar_ingreso()
{
    let descripcion_concepto = document.getElementById('descripcion_concepto').value;
    let precio_concepto = document.getElementById('precio_concepto').value.replace(/\./g, "");
    let select = document.getElementById('concepto');
    let select_precio = document.getElementById('concepto_precio');

    if(descripcion_concepto == '')
    {
        $('#modal_agregar').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            'La descripcion del concepto no puede ser vacio!',
            'error'
        )
        return false;
    }

    if((precio_concepto == 0) || (precio_concepto == ''))
    {
        $('#modal_agregar').modal('hide');
        swalWithBootstrapButtons(
            'Atención',
            'El precio no puede ser 0 o no contener un numero mayor a cero',
            'error'
        )
        return false;
    }

    axios.post('/ingreso/crear_ingreso_concepto',  {
        descripcion_concepto : descripcion_concepto,
        precio_concepto : precio_concepto,
    })
    .then(respuesta => {
        for (let i = select.options.length; i >= 0; i--) {
            select.remove(i);
        }
        for (let i = select_precio.options.length; i >= 0; i--) {
            select_precio.remove(i);
        }

        $(select).empty().trigger('change');
        // $(select_precio).empty().trigger('change');

        for(var i=0; i < respuesta.data.length; i++){
            var option = document.createElement('option');
            var option2 = document.createElement('option');
            var valor = respuesta.data[i].id;
            var valor2 = respuesta.data[i].descripcion;
            var valor3 = respuesta.data[i].precio;
            option.value = valor;
            option.text = valor2;
            select.appendChild(option);
            option2.value = valor3;
            option2.text = valor3;
            select_precio.appendChild(option2);

            // var option = new Option(respuesta.data[i].descripcion, respuesta.data[i].id);
            // var option2 = new Option(respuesta.data[i].precio, respuesta.data[i].id);

            select.appendChild(option);
            select_precio.appendChild(option2);
        }

        $(select).select2();
        num = parseInt(respuesta.data[0].precio);
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
        num = num.split('').reverse().join('').replace(/^[\.]/,'');
        document.getElementById('precio').value = num;

        swal({
            title: 'Ingreso Concepto!',
            text: "Agregado con exito!",
            type: 'success',
            padding: '2em'
        })
        $('#modal_agregar').modal('hide');
        limpiar_campos();
    })
    .catch(error => {
        console.log(error);
        console.log(error.response.data);
    })
}

function limpiar_campos()
{
    document.getElementById('descripcion_concepto').value = "";
    document.getElementById('precio_concepto').value = "";

}

let cont = 0;

function agregar_ingreso()
{

    let precio = document.getElementById('precio').value;
    let cantidad = document.getElementById('cantidad').value.replace(/\./g, "");
    let precio_total = parseInt(precio.replace(/\./g, "")) *  parseInt(cantidad);

    let descripcion = document.getElementById('concepto');
    let index = descripcion.selectedIndex;
    let descripcion_id = descripcion.options[index].value;
    let desc = descripcion.options[index].text;

    document.getElementById("ingresos").insertRow(-1).innerHTML = '<tr>\
                                                                        <td class"text-center"> \
                                                                            <input type="hidden" class="" name="env_descripcion_id[]" value="'+descripcion_id+'"> \
                                                                            '+desc+' \
                                                                        </td>\
                                                                        <td class"text-center"> \
                                                                            <input type="text" class="form-control" name="env_precio[]" value="'+precio+'" style="display: none" readonly> \
                                                                            '+precio+' \
                                                                        </td>\
                                                                        <td class"text-center"> \
                                                                            <input type="text" class="form-control" name="env_cantidad[]" value="'+cantidad+'" style="display: none" readonly> \
                                                                            '+cantidad+' \
                                                                        </td>\
                                                                        <td class"text-center"> \
                                                                            <input type="text" class="form-control" name="env_precio_total[]" value="'+precio_total+'" style="display: none" readonly> \
                                                                            '+precio_total+' \
                                                                        </td>\
                                                                        <td class"text-center"> \
                                                                            <button id="'+cont+'" type="button" onclick="eliminar_fila(this)"><i class="fas fa-backspace"></i></button> \
                                                                        </td>\
                                                                    </tr>';

    cont ++;

    sumar_total();
}

function cambiar_precio(input){
    var index = 0;
    var precio = 0;
    html_precio = document.getElementById('concepto_precio');
    if (html_precio.options.length > 0) {
        index = input.selectedIndex;
        precio = html_precio.options[index].value;
        precio = precio.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
        precio = precio.split('').reverse().join('').replace(/^[\.]/,'');
        document.getElementById('precio').value = precio;
    }
}

function eliminar_fila(input)
{
    $(input).closest('tr').remove();
    sumar_total();
}

function sumar_total()
{
    var tabla = document.querySelector("#ingresos");

    // Variable para almacenar la suma
    var suma = 0;

    // Recorre las filas de la tabla
    for (var i = 0; i < tabla.rows.length; i++) {
        // Accede a la celda específica en la posición deseada
        var celda = tabla.rows[i].cells[3]; // Cambia el índice (2) según la columna que desees sumar

        // Extrae el valor numérico de la celda
        var valor = parseInt(celda.innerText);

        // Verifica si el valor extraído es un número válido
        if (!isNaN(valor)) {
            // Suma el valor a la variable suma
            suma += valor;
        }
    }

    num = parseInt(suma);
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');

    document.getElementById('total_a_pagar').value = num;

}


