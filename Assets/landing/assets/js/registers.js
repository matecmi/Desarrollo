let rowTable = "";
document.addEventListener('DOMContentLoaded', function(){

	if(document.querySelector("#addRegisterForm")){
        let addRegisterForm = document.querySelector("#addRegisterForm");
        addRegisterForm.onsubmit = function(e) {
            e.preventDefault();
         
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Landing/setRegisterFormularioLanding'; 
            let formData = new FormData(addRegisterForm);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);

                    if(objData.status)
                    {
                        addRegisterForm.reset();
                        document.querySelector(".msj").innerHTML = `
                        <div class="input-group-icon" style="background-color: hsl(152, 51%, 52%);padding: 10px;text-align: center;">
                          <span  style="font-weight: bold;color: #fff;">
                          ${objData.msg} <i class="fas fas fa-check"> </i> </span>
                        </div> `

                        setTimeout(() => {
                            document.querySelector(".msj").innerHTML = "";
                        }, 1800);
                    }else{
                        document.querySelector(".msj").innerHTML = `
                        <div class="input-group-icon" style="background-color: #cd0008;padding: 10px;text-align: center;">
                          <span  style="font-weight: bold;color: #fff;">
                          ${objData.msg} <i class="fas fas fa-check"> </i> </span>
                        </div> `
                        setTimeout(() => {
                            document.querySelector(".msj").innerHTML = "";
                        }, 1800);
                    }
                }
                return false;
            }
        }
    }


}, false);