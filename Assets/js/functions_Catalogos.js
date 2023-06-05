let tableCatalogos; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableCatalogos = $('#tableCatalogos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Catalogos/getCatalogos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_catalogo"},
            {"data":"titulo"},
            {"data":"descripcion"},
            {"data":"fvigencia"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

	if(document.querySelector("#frmAddCatalogo")){
        let frmAddCatalogo = document.querySelector("#frmAddCatalogo");
        frmAddCatalogo.onsubmit = function(e) {
            e.preventDefault();
            let strTitulo = document.querySelector('#txtTituloCatalogo').value;
            let strDescripcion = document.querySelector('#txtDescripcionCatalogo').value;
            let dtFecha = document.querySelector('#datFecha').value;
            let intId = document.querySelector('#idCatalogoadd').value;

            if(strTitulo == '' || dtFecha == '')
            {
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
                    title: "Todos los campos son obligatorios"
                })
                return false;
            }

         
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Catalogos/setCatalogos'; 
            let formData = new FormData(frmAddCatalogo);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableCatalogos.api().ajax.reload();
                        }else{
                           rowTable.cells[1].textContent =  strTitulo;
                           rowTable.cells[2].textContent =  strDescripcion;
                           rowTable.cells[3].textContent =  dtFecha;
                           rowTable = "";
                        }
                        $('#modalFormCatalogos').modal("hide");
                        frmAddCatalogo.reset();
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
                divLoading.style.display = "none";
                return false;
            }
        }
    }


}, false);


function fntEditInfo(element,idCata){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#modalFormCatalogosTitle').innerHTML ="Actualizar Catálogo";
    $('.modal-header').css("background-color", "#007bff");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";      

    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Catalogos/getCatalogo/'+idCata;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let htmlImage = "";
                let objCatalogo = objData.data;
                document.querySelector("#idCatalogoadd").value = objCatalogo.id_catalogo;
                document.querySelector("#txtTituloCatalogo").value = objCatalogo.titulo;
                document.querySelector("#txtDescripcionCatalogo").value = objCatalogo.descripcion;
                document.querySelector("#datFecha").value = objCatalogo.fvigencia;
                
                $('#modalFormCatalogos').modal('show');
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









function fntAddProd(id){

    if(id != ""){
        $("#idCatalogoProductoRegistrar").val(id);
        traerproductosporCatalogo(id);
        $("#modalAddProductoCatalogos").modal("show");
    }
}
function traerproductosporCatalogo(idCatProd){

    $("#tblprodcatal").html("")
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Catalogos/getCatalogoProductos/' + idCatProd;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        let html = "";
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let cont = 0;
            objData.forEach(objProducto => {
                cont++
                html += `
                <tr>
                  <td>${cont}</td>
                  <td>${objProducto.nombre}</td>
                  <td>${objProducto.precio}</td>
                  <td>${objProducto.options}</td>
                </tr>`;
                $("#tblprodcatal").html(html)
            });

            
            return
            
        }
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
            let ajaxUrl = base_url + '/Catalogos/delCatProd';
            let strData = "idCatProd=" + idProdL;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);

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
                        traerproductosporCatalogo($("#idCatalogoProductoRegistrar").val())
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

if (document.querySelector("#formRegistroCatalogoProductos")) {
    let formRegistroCatalogoProductos = document.querySelector("#formRegistroCatalogoProductos");
    formRegistroCatalogoProductos.onsubmit = function (e) {
        e.preventDefault();
        let idCatalogo = document.querySelector('#idCatalogoProductoRegistrar').value;
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

        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Catalogos/setRegistrarcatalogoproductos';
        let formData = new FormData();
        formData.append('idCatalogo', idCatalogo);
        formData.append('idproducto', idproducto);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    formRegistroCatalogoProductos.reset();
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
                    traerproductosporCatalogo($("#idCatalogoProductoRegistrar").val())
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

function fntDelInfo(idCatalogoDel) {
    Swal.fire({
        title: "Eliminar descuento",
        text: "¿Realmente quiere eliminar catalogo?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Catalogos/delCatalogo__all';
            let strData = "idcat=" + idCatalogoDel;
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
                        tableCatalogos.api().ajax.reload();
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
    document.querySelector('#idCatalogoadd').value =0;
    $('.modal-header').css("background-color", "#fff");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#modalFormCatalogosTitle').innerHTML = "Nuevo Cliente";
    document.querySelector("#frmAddCatalogo").reset();
    $('#modalFormCatalogos').modal('show');
}