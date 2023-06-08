codigoAleatorio()
let tableDescuentoProducto;
let tableDescuentoPuntos;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

const btnActionFormPuntos = document.getElementById("btnActionFormPuntos");

// Agregar un event listener al botón
btnActionFormPuntos.addEventListener("click", function() {
    setTimeout(function() {

        document.querySelector("#idDescuentoPorPuntos").value = "";
        console.log("entre al metodo del boton");
      }, 1000);    
});

document.addEventListener('DOMContentLoaded', function () {



    // DESCUENTOS POR PRODUCTOS
    tableDescuentoProducto = $('#tableDescuentoProducto').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Descuentos/getDescuentoPorProductos/porproducto",
            "dataSrc": ""
        },
        "columns": [
            {"data": "cont"},
            {"data": "nombre"},
            {"data": "precio"},
            {"data": "descuento"},
            {"data": "nuevo_total"},
            {"data": "fvigencia"},
            {"data": "options"}
        ],
        "columnDefs": [{
            'className': "textcenter",
            "targets": [3]
        }],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 5,
        "order": [
            [0, "desc"]
        ]
    });
    if (document.querySelector("#formRegistroPorProducto")) {
        let formRegistroPorProducto = document.querySelector("#formRegistroPorProducto");
        formRegistroPorProducto.onsubmit = function (e) {
            e.preventDefault();
            let idproducto = document.querySelector('#listProductos').value;
            let descuento = document.querySelector('#txtDescuento').value;
            let total_pagar = document.querySelector('#txtTotalDescuento').value;
            let idDescuentoProducto = document.querySelector('#idDescuentoProducto').value;
            let vigenciaProducto = document.querySelector('#fValidoProducto').value;
            let descuentopertenece = "porproducto";
            if (idproducto == '' || descuento == '' || total_pagar == '') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Todos los campos son obligatorios.'
                })
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: 'Por favor verifique los campos en rojo.'
                    })
                    return false;
                }
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Descuentos/setDescuentoPorProducto';
            let formData = new FormData();
            formData.append('idproducto', idproducto);
            formData.append('descuento', descuento);
            formData.append('total_pagar', total_pagar);
            formData.append('descuentopertenece', descuentopertenece);
            formData.append('idDescuentoProducto', idDescuentoProducto);
            formData.append('vigenciaProducto', vigenciaProducto);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        if (rowTable == "") {
                            tableDescuentoProducto.api().ajax.reload();
                            document.querySelector('#listProductos').value = "";
                            $('#listProductos').selectpicker('render');
                            document.querySelector('#txtPrecioProducto').innerText = "";
                        } else {
                            htmlDesc = '<span class="badge badge-danger">- ' + descuento + '%</span>'


                            rowTable.cells[3].innerHTML = htmlDesc;
                            rowTable.cells[4].textContent = "S/"+total_pagar;
                            rowTable.cells[5].textContent = vigenciaProducto;
                            // rowTable.cells[2].textContent = strApellido;
                            // rowTable.cells[3].textContent = strEmail;
                            // rowTable.cells[4].textContent = intTelefono;
                            rowTable = "";

                            document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-primary");
                            document.querySelector('#btnText').innerHTML = "Guardar";


                            document.querySelector('#idDescuentoProducto').value = "";
                            document.querySelector('#listProductos').value = "";
                            $('#listProductos').selectpicker('render');
                            $('#listProductos').attr('disabled',false);
                            $('#listProductos').selectpicker('refresh');
                            document.querySelector('#txtPrecioProducto').innerText = "";
                        }
                        formRegistroPorProducto.reset();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: objData.msg
                        })
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: objData.msg
                        })
                    }
                }
                divLoading.style.display = "none";
                return false;
            }

        }
    }
    // DESCUENTOS POR PUNTOS
    tableDescuentoPuntos = $('#tableDescuentoPuntos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Descuentos/getDescuentoPorPuntos/porpuntos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "cont"},
            {"data": "ptipo"},
            {"data": "descuento"},
            {"data": "fvigencia"},
            {"data": "codigo"},
            {"data": "status"},
            {"data": "options"}
        ],
        "columnDefs": [{
            'className': "textcenter",
            "targets": [3,2]
        }],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 5,
        "order": [
            [0, "desc"]
        ]
    });
    if (document.querySelector("#formRegistroPorPuntos")) {
        let formRegistroPorPuntos = document.querySelector("#formRegistroPorPuntos");
        formRegistroPorPuntos.onsubmit = function (e) {
            e.preventDefault();

            let idDescuentoAdd = document.querySelector('#idDescuentoPorPuntos').value;
            let tipopuntos = document.querySelector('#txtTitpoPuntos').value;
            let descuento = document.querySelector('#txtTotalDescuentoPuntos').value;
            let puntos = document.querySelector('#txtPuntos').value;
            let cod_cupon = document.querySelector('#txtCod_cupon').value;
            let fvalido = document.querySelector('#fValido').value;
            let estadoP = document.querySelector('#txtEstadoPuntos').value;
            let descuentopertenece = "porpuntos";

            console.log("tipopuntos: ",tipopuntos)
            console.log("descuento :",descuento)
            console.log("cod_cupon :",cod_cupon)
            console.log("fvalido :",fvalido)
            console.log("estadoP :",estadoP)



            if (tipopuntos == '' || descuento == '' || puntos == '') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Hay campos que son obligatorios.'
                })
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: 'Por favor verifique los campos en rojo.'
                    })
                    return false;
                }
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Descuentos/setDescuentoPorPuntos';
            let formData = new FormData();


            formData.append('idDescuentoAdd', idDescuentoAdd);
            formData.append('tipopuntos', tipopuntos);
            formData.append('descuento', descuento);
            formData.append('puntos', puntos);
            formData.append('cod_cupon', cod_cupon);
            formData.append('fvalido', fvalido);
            formData.append('estadop', estadoP);
            formData.append('descuentopertenece', descuentopertenece);


            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    console.log(objData);
                    if (objData.status) {
                        if (rowTable == "") {
                            tableDescuentoPuntos.api().ajax.reload();
                            $("#formRegistroPorPuntos").trigger("reset");
                            document.querySelector("#idDescuentoPorPuntos").value = "";
                            codigoAleatorio();
                        } else {
                           

                            if(tipopuntos == "Puntos"){
                                htmlDesc = 'S/'+puntos+' <span class="badge badge-danger">- ' + descuento + '%</span>'
                            }
                            if(tipopuntos == "Cupón libre"){
                                htmlDesc = '<span class="badge badge-danger">- ' + descuento + '%</span>'
                            }
                            if(tipopuntos == "Envio gratis"){
                                htmlDesc = '<b> A partir de: S/'+puntos+'</b>'
                            }

                            
                            document.querySelector('#btnActionFormPuntos').classList.replace("btn-warning", "btn-primary");
                            document.querySelector('#btnTextPuntos').innerHTML = "Guardar";
                            $("#txtTitpoPuntos").attr("disabled",false);
                            $("#formRegistroPorPuntos").trigger("reset");
                            document.querySelector("#idDescuentoPorPuntos").value = "";

                            
                            
                            htmlStatus = estadoP == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';

                            rowTable.cells[2].innerHTML = htmlDesc;
                            rowTable.cells[3].textContent = fvalido;
                            rowTable.cells[5].innerHTML = htmlStatus;
                            codigoAleatorio();

                        }
                        formRegistroPorProducto.reset();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: objData.msg
                        })
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: objData.msg
                        })
                    }
                }
                divLoading.style.display = "none";
                return false;
            }

            $("#formRegistroPorPuntos").trigger("reset");

            document.querySelector("#idDescuentoPorPuntos").value = "";
        }
        $("#formRegistroPorPuntos").trigger("reset");

    }
    // BUSCAR REFERIDOS POR CLIENTE
    if (document.querySelector("#frmBuscarReferidos")) {
        let frmBuscarReferidos = document.querySelector("#frmBuscarReferidos");
        frmBuscarReferidos.onsubmit = function (e) {
            e.preventDefault();
            divLoading.style.display = "flex";
            let idcliente = document.querySelector('#slcClientes').value;
            console.log("idcliente :",idcliente)
            tblref(idcliente)
        }
    }
    // ASIGNAR CUPÓN REFERIDOS POR CLIENTE
    if (document.querySelector("#frmAddCuponRef")) {
        let frmAddCuponRef = document.querySelector("#frmAddCuponRef");
        frmAddCuponRef.onsubmit = function (e) {
        e.preventDefault();
        let cod = document.querySelector('#slcCuponesDescuentos').value;
        let id = document.querySelector('#id_ref').value;
        if (cod == '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: 'Seleccione cupón.'
            })
            return false;
        }
       
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Descuentos/setDescAgregar';
        let formData = new FormData();
        formData.append('cod', cod);
        formData.append('id', id);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                   
                    frmAddCuponRef.reset();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: objData.data
                    })

                    $('#addCuponModal').modal("hide")
                    let idclt = document.querySelector('#slcClientes').value;
                    tblref(idclt)
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: objData.data
                    })
                }
            }
            divLoading.style.display = "none";
            return false;
        }
        }
    }

}, false);



window.addEventListener('load', function () {
    fntListaProductos();
    fntListaClientesReferidos();
}, false);


function tblref(idcliente){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Clientes/getReferidosClientes/' + idcliente;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);

            console.log(objData)
            
            if (objData.status) {
                let objProducto = objData.data;
                let html = "";
                let cont = 0;
                objProducto.forEach(ref => {
                    cont++
                    html += `
                        <tr>
                            <td>${cont}</td>
                            <td>${ref.nombre}</td>
                            <td>${ref.celular}</td>
                            <td>${ref.email}</td>
                            <td>${ref.registrado}</td>`

                            if(ref.estado == "pendiente"){

                                html += `<td><span class="badge badge-warning"> ${ref.estado} </span></td>`

                            }
                            if(ref.estado == "asignado"){

                                html += `<td><span class="badge badge-primary"> ${ref.estado} </span></td>`

                            }
                            

                    html += `
                            <td>
                            
                                <div class="text-center"> 
                                    <button class="btn btn-primary  btn-sm" onclick="fntAddCuponRef(this,${ref.id_referidos},'${ref.cupon_cod}')" title="Editar descuento por producto"><i class="fa fa-ticket" aria-hidden="true"></i></button>
                                    <button class="btn btn-danger btn-sm" onclick="fntDelReferidos(${ref.id_referidos})" title="Eliminar descuento por producto"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                                </div>
                            </td>
                        </tr>`

                    $("#tblReferidos").html(html);
                    
                    divLoading.style.display = "none";
                    
                });

            } else {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    text: 'Error',
                    title: objData.msg,
                    showConfirmButton: false,
                    timer: 1500
                })
                divLoading.style.display = "none";
            }
        }
    }
}


function fntListaProductos() {
    if (document.querySelector('#listProductos')) {
        let ajaxUrl = base_url + '/Productos/getSelectProducto';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('#listProductos').innerHTML = request.responseText;
                $('#listProductos').selectpicker('render');
            }
        }
    }
}

$("#listProductos").on("change", function () {
    let idProducto = this.value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Productos/getProducto/' + idProducto;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            console.log(objData)
            if (objData.status) {
                let objProducto = objData.data;
                document.getElementById('txtPrecioProducto').innerText = objProducto.precio;
                precioDeProducto(objProducto.precio)

            } else {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    text: 'Error',
                    title: objData.msg,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    }

})

function fntEditInfo(element, idDescuentoProd) {

    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-warning");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Descuentos/getDescuentoPorProductoRegistrados/' + idDescuentoProd;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            console.log(objData)
            if (objData.status) {
                $("#listProductos").prop("disabled", true)
                document.querySelector("#listProductos").value = objData.data.prod_id;
                $('#listProductos').selectpicker('refresh');
                document.querySelector("#txtDescuento").value = objData.data.descuento;
                document.querySelector("#txtTotalDescuento").value = objData.data.nuevo_total;
                let aumento = (objData.data.descuento / 100) * objData.data.precio;
                let pagar = objData.data.precio + aumento
                // console.log(parseInt(aumento))
                // console.log(parseInt(pagar))
                document.querySelector("#txtPrecioProducto").innerText = parseInt(pagar)
                document.querySelector("#txtTotalDescuentoProncentual").value = parseInt(aumento)
                document.querySelector("#idDescuentoProducto").value = objData.data.id_cupon;
                document.querySelector("#fValidoProducto").value = objData.data.fvigencia;
                precioDeProducto(parseInt(pagar))

            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: objData.msg
                })
            }
        }
    }
}
function fntDelInfo(idDescuentoProd) {
    Swal.fire({
        title: "Eliminar descuento",
        text: "¿Realmente quiere eliminar descuento?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Descuentos/delDescuentoPorProducto';
            let strData = "idProdDes=" + idDescuentoProd;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    console.log(objData)

                    if (objData.status) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: objData.msg
                        })
                        tableDescuentoProducto.api().ajax.reload();
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: objData.msg
                        })
                    }
                }
            }
        }
    })




}
function precioDeProducto(precioproducto) {
    precioDeProductoIngresado(precioproducto)

    $("#txtDescuento").on("keyup", function () {

        let porcentaje = this.value;
        let precio = precioproducto;
        //35 - 10
        let descuento = (precio * porcentaje) / 100
        let pagar = precio - descuento

        $("#txtTotalDescuentoProncentual").val(descuento)
        $("#txtTotalDescuento").val(pagar)

    })
}
function precioDeProductoIngresado(precioproducto) {
    let porcentaje = $("#txtDescuento").val();
    let precio = precioproducto;
    //35 - 10
    let descuento = (precio * porcentaje) / 100
    let pagar = precio - descuento
    $("#txtTotalDescuentoProncentual").val(descuento)
    $("#txtTotalDescuento").val(pagar)
}
function fntDelPuntos(idDescuentoPuntos) {
    Swal.fire({
        title: "Eliminar",
        text: "¿Realmente quiere eliminar registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Descuentos/delDescuentoPorPuntos';
            let strData = "idPuntosDes=" + idDescuentoPuntos;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    console.log(objData)

                    if (objData.status) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: objData.msg
                        })
                        tableDescuentoPuntos.api().ajax.reload();
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: objData.msg
                        })
                    }
                }
            }
        }
    })

}
function fntEditPuntos(element, idDescuentoPuntos) {

    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#btnActionFormPuntos').classList.replace("btn-primary", "btn-warning");
    document.querySelector('#btnTextPuntos').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Descuentos/getDescuentoPorPuntosRegistrados/' + idDescuentoPuntos;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            
            if (objData.status) {
          
                // console.log(objData.data);
                if(objData.data.ptipo == "Puntos"){
                    $(".evnipunt").text("Puntos:")
                    document.querySelector(".tiposel").classList.remove("col-md-6");
                    document.querySelector(".tiposel").classList.add("col-md-4");
                    $(".tipopuntos").show()
                    document.querySelector("#txtPuntos").value = objData.data.ppuntos;
                    document.querySelector("#txtCod_cupon").value = objData.data.codigo;
                    document.querySelector("#cuponcards").innerText = objData.data.codigo;
                }
                if(objData.data.ptipo == "Cupón libre"){

                    if(document.querySelector(".tiposel").classList[1] == "col-md-6"){
                        document.querySelector(".tiposel").classList.add("col-md-6");
                        document.querySelector(".tiposel").classList.remove("col-md-4");
                    }

                    if(document.querySelector(".tiposel").classList[1] == "tiposel"){
                        document.querySelector(".tiposel").classList.remove("col-md-4");
                        document.querySelector(".tiposel").classList.add("col-md-6");
                        $(".tipopuntos").hide()
                        $(".tipopuntos").val(0)
                    }
                    document.querySelector("#txtCod_cupon").value = objData.data.codigo;
                    document.querySelector("#cuponcards").innerText = objData.data.codigo;
                    
                   
                }
                if(objData.data.ptipo == "Envio gratis"){
                    $(".evnipunt").text("A partir de:")
                    document.querySelector(".tiposel").classList.remove("col-md-6");
                    document.querySelector(".tiposel").classList.add("col-md-4");
                    $(".tipopuntos").show()
                    document.querySelector("#txtPuntos").value = objData.data.ppuntos;
                    $("#txtTotalDescuentoPuntos").prop("disabled",true)
                    $("#fValido").prop("disabled",true)
                    $("#txtCod_cupon").prop("disabled",true)
                    document.querySelector("#txtCod_cupon").value = "-";
                    document.querySelector("#cuponcards").innerText = "-";
                 
                }


                document.querySelector("#txtTitpoPuntos").value = objData.data.ptipo;
                document.querySelector("#txtTotalDescuentoPuntos").value = objData.data.descuento;
                document.querySelector("#idDescuentoPorPuntos").value = objData.data.id_cupon;
                document.querySelector("#desc_cards").innerText = objData.data.descuento;
                document.querySelector("#fValido").value = objData.data.fvigencia;
                document.querySelector("#yearcupon").innerText = objData.data.fvigencia;
                document.querySelector("#txtEstadoPuntos").value = objData.data.status;

                
                $("#txtTitpoPuntos").attr("disabled",true)

            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: objData.msg
                })
            }
        }
    }
}
$("#txtTotalDescuentoPuntos").on("keyup", function (){
    $("#desc_cards").text(this.value)
})
$("#fValido").on("change", function (){
    console.log(this.value)
    $("#yearcupon").text(this.value)
})
$("#txtCod_cupon").on("keyup", function (){
    console.log(this.value)
    $("#cuponcards").text(this.value)
})
function codigoAleatorio() {
    let abecedario = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    let Char;
    let cd = '';
    for (i = 1; i <= 10; i++) {
        Char = abecedario[(Math.random() * (abecedario.length - 1)).toFixed(0)];
        if (parseInt(Math.random() * 2) == 1)
            cd += Char.toUpperCase(Char);
        else
            cd += Char;
    }
    $("#txtCod_cupon").val("BM-"+cd.toUpperCase())
    $("#cuponcards").text("BM-"+cd.toUpperCase())
    return cd;
}

$("#txtTitpoPuntos").on("change", function () {
    let sel = this.value;
    if (sel == "Puntos") {
        codigoAleatorio();
        $("#txtPuntos").val("");
        document.querySelector(".tiposel").classList.remove("col-md-6");
        document.querySelector(".tiposel").classList.add("col-md-4");
        $(".tipopuntos").show();
        $("#txtTotalDescuentoPuntos").val("");
        $(".evnipunt").text("Puntos:");
        $("#txtTotalDescuentoPuntos").prop("disabled",false);
        $("#fValido").prop("disabled",false);
        $("#txtTotalDescuentoPuntos").css("cursor","auto");
        $("#fValido").css("cursor","auto");
        $("#txtCod_cupon").css("cursor","auto");
        $("#txtCod_cupon").prop("disabled",false);

    } else
    if (sel == "Cupón libre") {
        codigoAleatorio()
        $("#txtPuntos").val(0)

        document.querySelector(".tiposel").classList.remove("col-md-4");
        document.querySelector(".tiposel").classList.add("col-md-6");
        $(".tipopuntos").hide()
        $("#txtTotalDescuentoPuntos").val("")
        $("#txtTotalDescuentoPuntos").prop("disabled",false)
        $(".evnipunt").text("Puntos:")
        $("#fValido").prop("disabled",false)
        $("#txtCod_cupon").prop("disabled",false)
        $("#txtTotalDescuentoPuntos").css("cursor","auto")
        $("#fValido").css("cursor","auto")
        $("#txtCod_cupon").css("cursor","auto")

    } else
    if (sel == "Envio gratis") {
        $("#txtPuntos").val("")
        document.querySelector(".tiposel").classList.remove("col-md-6");
        document.querySelector(".tiposel").classList.add("col-md-4");
        $("#txtTotalDescuentoPuntos").val(0)
        $(".evnipunt").text("A partir de:")
        $("#txtTotalDescuentoPuntos").prop("disabled",true)
        $("#fValido").prop("disabled",true)
        $("#txtCod_cupon").prop("disabled",true)
        $(".tipopuntos").show()

        $("#txtTotalDescuentoPuntos").css("cursor","no-drop")
        $("#txtCod_cupon").css("cursor","no-drop")
        $("#fValido").css("cursor","no-drop")
    }
})

//REFERIDOS
function fntListaClientesReferidos() {
    if (document.querySelector('#slcClientes')) {
        let ajaxUrl = base_url + '/Clientes/getSelectClientesReferidos';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                
                document.querySelector('#slcClientes').innerHTML = request.responseText;
                $('#slcClientes').selectpicker('render');
            }
        }
    }
}

// $("#slcClientes").on('change',function(){
//     $(".btn-ref").click();
// })

function fntDelReferidos(idReferido) {
    Swal.fire({
        title: "Eliminar",
        text: "¿Realmente quiere eliminar referido?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Clientes/delReferidos';
            let strData = "idRef=" + idReferido;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    console.log(objData)

                    if (objData.status) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: objData.msg
                        })
                        $(".btn-ref").click();
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: objData.msg
                        })
                    }
                }
            }
        }
    })

}

function fntAddCuponRef(element,id,cod){
    $("#cpasignado").text(cod)
    $("#id_ref").val(id)
    $('#addCuponModal').modal("show")
}