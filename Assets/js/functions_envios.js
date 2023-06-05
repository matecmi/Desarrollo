let tableEnvios; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableEnvios = $('#tableEnvios').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Envios/getEnvios",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_envios"},
            {"data":"destino"},
            {"data":"precio"},
            {"data":"status"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

	if(document.querySelector("#formEnvios")){
        let formEnvios = document.querySelector("#formEnvios");
        formEnvios.onsubmit = function(e) {
            e.preventDefault();
            let strDestino = document.querySelector('#txtDestino').value;
            let intPrecio = document.querySelector('#txtPrecioEnvio').value;
            let intStatus = document.querySelector('#listStatus').value;
        
            if(strDestino == '' || intPrecio == '')
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
                        text: 'Por favor verifique los campos en rojo.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Envios/setEnvio'; 
            let formData = new FormData(formEnvios);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableEnvios.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                           rowTable.cells[1].textContent =  strDestino;
                           rowTable.cells[2].textContent =  intPrecio;
                           rowTable.cells[3].innerHTML = htmlStatus;
                           rowTable = "";
                        }
                        $('#modalRegistrarEnvios').modal("hide");
                        formEnvios.reset();
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: 'Envío',
                            text: objData.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }else{
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Error',
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


function fntViewEnvios(idenvios){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Envios/getEnvio/'+idenvios;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let estado = objData.data.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#enCodigo").innerHTML = objData.data.id_envios;
                document.querySelector("#enDestino").innerHTML = objData.data.destino;
                document.querySelector("#enPrecio").innerHTML = "S/"+objData.data.precio;
                document.querySelector("#enEstado").innerHTML = estado;
                $('#modalViewEnvios').modal('show');
            }else{
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Error',
                    text: objData.msg,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    }
}

function fntEditEnvios(element, idpersona){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar - precio de envíos";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Envios/getEnvio/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData);
            if(objData.status)
            {
                document.querySelector("#idEnvios").value = objData.data.id_envios;
                document.querySelector("#listDep").value = objData.data.idDepa;
                document.querySelector("#listProv").value = objData.data.idProv;
                document.querySelector("#txtDestino").value = objData.data.idDist;
                document.querySelector("#txtPrecioEnvio").value = objData.data.precio;
                document.querySelector("#listStatus").value = objData.data.status;

                uprovincia(objData.data.idDepa)
                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            }
        }
        $('#modalRegistrarEnvios').modal('show');
    }
}

function fntDelEnvios(idenvio){
    Swal.fire({
      

        title: "Eliminar precio de envío",
        text: "¿Realmente quiere eliminar el precio de envío?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        
        if (result.isConfirmed) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Envios/delEnvio';
            let strData = "idEnvio="+idenvio;
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
                            title: 'Eliminar',
                            text: objData.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        tableEnvios.api().ajax.reload();
                    }else{
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Atención',
                            text: objData.msg,
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
    // rowTable = "";
    document.querySelector('#idEnvios').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Registro - precio de envíos";
    document.querySelector("#formEnvios").reset();
    $('#modalRegistrarEnvios').modal('show');
}
udepartamento()
function udepartamento(){
    let ajaxUrl = base_url+'/Envios/getUbiDepartamento';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let template = "";
            uprovincia(JSON.parse(request.responseText)["data"][0]["idDepa"])
            JSON.parse(request.responseText)["data"].forEach(dep => {
                template += `<option value="${dep.idDepa}">${dep.departamento}</option>`;
            });
            $("#listDep").html(template);
        }
    }
}
$("#listDep").on("change",function(){
    uprovincia(this.value)
})
function uprovincia(idDepa){
    let ajaxUrl = base_url+'/Envios/getUbiProvincia/'+idDepa;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var template_prov = "";
            udistrito(JSON.parse(request.responseText)["data"][0]["idProv"])
            JSON.parse(request.responseText)["data"].forEach(prov => {
                template_prov += `<option value="${prov.idProv}">${prov.provincia}</option>`;
            });
            $("#listProv").html(template_prov);
            // $('#listProv').selectpicker('render');
        }
    }
}
function udistrito(idProv){
    console.log(idProv)
    let ajaxUrl = base_url+'/Envios/getUbiDistrito/'+idProv;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var template_dist = "";
            JSON.parse(request.responseText)["data"].forEach(dist => {
                console.log(dist)
                template_dist += `<option value="${dist.idDist}">${dist.distrito}</option>`;
            });
            $("#txtDestino").html(template_dist);
            // $('#listProv').selectpicker('render');
        }
    }
}

$("#listProv").on("change",function(){
    udistrito(this.value)
})
