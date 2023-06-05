$(".addinput").on("click", function () { 
    let htmlinput = `
                <div class="row inputrow">
                    <div class="col-lg-10">
                        <div class="form-group">
                            <input class="form-control inputsave" type="text" placeholder="Ejem: Ingresa tu nombre">
                        </div>
                    </div>
                    <div class="col-lg-2" style="margin: auto;">
                        <div class="form-group">
                            <button class="btn btn-danger btn-sm" type="button" onclick="delinput(this)"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>`
    $("#input_add").append(htmlinput)
 })

 //Eliminar input
 function delinput(e){
    e.closest(".inputrow").remove()
 }

 //Eliminar todo el select
 
 function delselectall(e){
    e.closest(".selct__All").remove()
 }

 $(".addselect").on("click", function () { 
    let htmlselect = `
                    <div class="card mb-3 border-primary selct__All">
                        <div class="card-body contpadresel">
                            <div class="form-group">
                            
                                <div class="row">
                                    <div class="col-9">
                                        <input class="form-control select_input" type="text" placeholder="Ejm: Estado Civil">
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group" style="margin: auto;">
                                            <button class="btn btn-danger btn-sm" type="button" onclick="delselectall(this)"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 mb-2">
                                <div class="col-12">
                                    <input class="form-control select_optiones" type="text" placeholder="option1,option2,option3">
                                </div>
                            </div>
                        </div>
                    </div>`
    $("#select_add").append(htmlselect)

 })
 



 
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector("#frmRegistrarFormularioDinamico")) {
        let frmRegistrarFormularioDinamico = document.querySelector("#frmRegistrarFormularioDinamico");
        frmRegistrarFormularioDinamico.onsubmit = function (e) {
            e.preventDefault();


            Swal.fire({
                title: '<strong>Registrar <u>formulario</u></strong>',
                icon: 'info',
                html:
                  'Una vez <b>confirmado</b>, ' +
                  'no podrá ser modificado.',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                  '<i class="fa fa-thumbs-up"></i> Registrar!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText:
                  '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
              }).then((result) => {
                if (result.isConfirmed) {
                    
                    let registro = {
                        array_data : {
                            "tipo": "input",
                            "rpta":[]
                        },
                        array_select : 
                        {
                            "tipo": "select",
                            "rpta":[]
                        }
                    }
    
                    let inputsall = document.querySelectorAll(".inputsave");
                    inputsall.forEach(ival => {
                        registro.array_data.rpta.push(ival.value)
                    });
                
                    $('.select_input').each(function() {
                        var nombreselect = $(this).val();
                        var arrSelectValue = $(this).closest('.contpadresel').find('.select_optiones').eq(0).val().split(',')
                        registro.array_select.rpta.push({
                            'nombreinput': nombreselect,
                            'valorintput': arrSelectValue
                        })
                    })


                    if (registro.array_data.rpta.length == 0) {
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
                            title: 'Tiene que tener al menos un registro.'
                        })
                        return false;
                    }
    
    
    
    
    
                  
                    divLoading.style.display = "flex";
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url + '/Landingpages/setAddFormularioDinamico';
                    let formData = new FormData();
                    formData.append('registro', JSON.stringify(registro));
                    formData.append('id_landingpage', $("#land_id").val());
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
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
              })


























                









        }




    }



})