let tableClientes; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableClientes = $('#tableClientes').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Clientes/getClientesUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"cont"},
            {"data":"dni"},
            {"data":"nombre"},
            {"data":"celular"},
            {"data":"direccion_envio"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

	if(document.querySelector("#formCliente")){
        let formCliente = document.querySelector("#formCliente");
        formCliente.onsubmit = function(e) {
            e.preventDefault();
            let rg_idcliente = document.querySelector("#idclienterg").value;
            let rg_dni = document.querySelector("#txtDniC").value;
            let rg_nombre = document.querySelector("#txtNombreC").value;
            let rg_celular = document.querySelector("#txtCelularC").value;
            let rg_direccion = document.querySelector("#txtDireccionC").value;
            let rg_correo = document.querySelector("#txtEmailC").value;

       
            if(rg_dni == '' || rg_nombre == '' || rg_celular == '' || rg_direccion == '' || rg_correo == '')
            {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Atención',
                    text: 'Todos los campos son obligatorios.',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Atención',
                        text: 'favor verifique los campos en rojo.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Clientes/setCliente'; 
            let formData = new FormData(formCliente);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    console.log(objData)
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableClientes.api().ajax.reload();
                        }else{
                           rowTable.cells[1].textContent =  rg_dni;
                           rowTable.cells[2].textContent =  rg_nombre;
                           rowTable.cells[3].textContent =  rg_celular;
                           rowTable.cells[4].textContent =  rg_direccion;
                           rowTable = "";
                        }
                        $('#modalFormCliente').modal("hide");
                        formCliente.reset();
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: 'Usuarios',
                            text: objData.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }else{
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Usuarios',
                            text: objData.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }


}, false);


function fntViewInfo(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celIde").innerHTML = objData.data.nit;
                document.querySelector("#celNomFiscal").innerHTML = objData.data.nombrefiscal;
                document.querySelector("#celDirFiscal").innerHTML = objData.data.direccionfiscal;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro; 
                $('#modalViewCliente').modal('show');
            }else{
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Usuarios',
                    text: objData.msg,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    }
}

function fntEditInfo(element, idpersona){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Cliente";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData)
            if(objData.status)
            {
                document.querySelector("#idclienterg").value = objData.data.id_cliente;
                document.querySelector("#txtDniC").value = objData.data.dni;
                document.querySelector("#txtNombreC").value = objData.data.nombre;
                document.querySelector("#txtCelularC").value = objData.data.celular;
                document.querySelector("#txtDireccionC").value = objData.data.direccion_envio;
                document.querySelector("#txtEmailC").value = objData.data.correo;


            }
        }
        $('#modalFormCliente').modal('show');
    }
}

function fntDelInfo(idpersona){
    Swal.fire({

        title: "Eliminar Cliente",
        text: "¿Realmente quiere eliminar al cliente?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Clientes/delCliente';
            let strData = "idUsuario="+idpersona;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            text: 'Eliminar!',
                            title: objData.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        tableClientes.api().ajax.reload();
                    }else{
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            text: 'Atención!',
                            title: objData.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            }
        }

    });

}

function openModal()
{
    rowTable = "";
    document.querySelector('#formCliente').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector("#formCliente").reset();
    $('#modalFormCliente').modal('show');
}