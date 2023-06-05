let tableLandingpage;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
    tableLandingpage = $('#tableLandingpage').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Landingpages/getLandingpages",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_landing"},
            {"data":"tituloform"},
            {"data":"ruta"},
            {"data":"formulario"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });
// FOTO PORTADA
if(document.querySelector("#foto")){
    let foto = document.querySelector("#foto");
    foto.onchange = function(e) {
        let uploadFoto = document.querySelector("#foto").value;
        let fileimg = document.querySelector("#foto").files;
        let nav = window.URL || window.webkitURL;
        let contactAlert = document.querySelector('#form_alert');
        if(uploadFoto !=''){
            let type = fileimg[0].type;
            let name = fileimg[0].name;
            if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                if(document.querySelector('#img')){
                    document.querySelector('#img').remove();
                }
                document.querySelector('.delPhoto').classList.add("notBlock");
                foto.value="";
                return false;
            }else{  
                    contactAlert.innerHTML='';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
                }
        }else{
            alert("No selecciono foto");
            if(document.querySelector('#img')){
                document.querySelector('#img').remove();
            }
        }
    }
}
//QUITAR FOTO
if(document.querySelector(".delPhoto")){
    let delPhoto = document.querySelector(".delPhoto");
    delPhoto.onclick = function(e) {
        document.querySelector("#foto_remove").value= 1;
        removePhoto();
    }
}
//NUEVO LANDING
let formLandingpage = document.querySelector("#formLandingpage");
formLandingpage.onsubmit = function(e) {
    e.preventDefault();
    let tituloformulario = document.querySelector('#txtTituloFormulario').value;
    let subtituloform = document.querySelector('#txtSubtituloForm').value;
    let titulodescripcion = document.querySelector('#txtTituloDescripcion').value;           
    let subtitulodescripcion = document.querySelector('#txtSubtituloDescripcion').value;        
    let descripcion = document.querySelector('#txtDescripcion').value;        

    console.log("tituloformulario :",tituloformulario)
    console.log("subtituloform :",subtituloform)
    console.log("titulodescripcion :",titulodescripcion)
    console.log("subtitulodescripcion :",subtitulodescripcion)
    console.log("descripcion :",descripcion)

    if(tituloformulario == '' || subtituloform == '' || titulodescripcion == '' ||  subtitulodescripcion == '' ||  descripcion == '')
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

    divLoading.style.display = "flex";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Landingpages/setLandingpage'; 
    let formData = new FormData(formLandingpage);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                if(rowTable == ""){
                    tableLandingpage.api().ajax.reload();
                }else{
                    rowTable.cells[1].textContent = tituloformulario;
                    rowTable = "";
                }

                $('#modalFormLanding').modal("hide");
                formLandingpage.reset();
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Landing Page',
                    text: objData.msg,
                    showConfirmButton: false,
                    timer: 1500
                })
                removePhoto();
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
}, false);
function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img')){
        document.querySelector('#img').remove();
    }
}
function fnVerRegistrarProductos(id){

    if(id != ""){
        $("#idLandingRegistrar").val(id);
        traerproductosporlanding(id);
        $("#modalAddProductoLanding").modal("show");
    }
}
fntListaProductos()
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
function fntEditLandingPages(element,idLanding){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Landingpages/getLanding/'+idLanding;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let objProducto = objData.data;
                console.log(objProducto)


                document.querySelector("#idlandingpage").value = objProducto.id_landing;
                document.querySelector("#txtTituloFormulario").value = objProducto.tituloform;
                document.querySelector("#txtSubtituloForm").value = objProducto.subtituloform;
                document.querySelector("#txtTituloDescripcion").value = objProducto.titulodes;
                document.querySelector("#txtSubtituloDescripcion").value = objProducto.subtitulodesc;
                document.querySelector("#txtDescripcion").value = objProducto.descripcionlanding;
                // document.querySelector("#listCategoria").value = objProducto.categoriaid;
                // document.querySelector("#listStatus").value = objProducto.status;
            
                if(document.querySelector('#img')){
                    document.querySelector('#img').src = objProducto.rutaimagenprincipal;
                }else{
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objProducto.rutaimagenprincipal+">";
                }
                document.querySelector('#foto_actual').value = objProducto.portadaprincipal;
                document.querySelector('#foto_imagen01').value = objProducto.imagin2desc;
                document.querySelector('#foto_imagen02').value = objProducto.imagin1desc;
             
                if(objData.data.portada == 'portada_categoria.png'){
                    document.querySelector('.delPhoto').classList.add("notBlock");
                }else{
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                }
                // document.querySelector("#containerGallery").classList.remove("notblock");           
                $('#modalFormLanding').modal('show');


            }else{
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
if (document.querySelector("#formRegistroPorProductoLanding")) {
    let formRegistroPorProductoLanding = document.querySelector("#formRegistroPorProductoLanding");
    formRegistroPorProductoLanding.onsubmit = function (e) {
        e.preventDefault();
        let idlanding = document.querySelector('#idLandingRegistrar').value;
        let idLandingEditar = document.querySelector('#idLandingEditar').value;
        let idproducto = document.querySelector('#listProductos').value;
      
        if (idproducto == '') {
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
                title: 'Seleccione un producto.'
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
        let ajaxUrl = base_url + '/Landingpages/setRegistrarproductolanding';
        let formData = new FormData();
        formData.append('idlanding', idlanding);
        formData.append('idproducto', idproducto);
        formData.append('idlandingeditar', idLandingEditar);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    formRegistroPorProductoLanding.reset();
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
                    traerproductosporlanding($("#idLandingRegistrar").val())
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
function traerproductosporlanding(idprod){

    $("#tblprodland").html("")
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Landingpages/getLandingpagesProductos/' + idprod;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        let html = "";
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let cont = 0;
            objData.forEach(objProducto => {
                cont++
                console.log(objProducto);
                html += `
                <tr>
                  <td>${cont}</td>
                  <td>${objProducto.nombre}</td>
                  <td>${objProducto.precio}</td>
                  <td>${objProducto.options}</td>
                </tr>`;
                $("#tblprodland").html(html)
            });

            
            return
            
        }
    }
}
function fntDelProdLanding(idProdL) {
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
            let ajaxUrl = base_url + '/Landingpages/delProdLand';
            let strData = "idLandProd=" + idProdL;
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
                        traerproductosporlanding($("#idLandingRegistrar").val())
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
function openModal()
{
    rowTable = "";
    // document.querySelector('#idUsuario').value ="";
    // document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    // document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    // document.querySelector('#btnText').innerHTML ="Guardar";
    // document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    // document.querySelector("#formCliente").reset();
    $('#modalFormLanding').modal('show');
}
function fntEliminarLandingPages(idLandingDel) {
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
            let ajaxUrl = base_url + '/Landingpages/delLandingPage__all';
            let strData = "idLand=" + idLandingDel;
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
                        tableLandingpage.api().ajax.reload();
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