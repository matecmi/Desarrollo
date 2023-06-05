function fnt_viewdt(id){

    $('#ModalDetallePedido').modal('show');
    let html = "";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getDetallePedidosAll/'+id;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            objData.forEach(dato => {
                console.log(dato)

                html += `
                <tr>
                    <td>${dato.idpedido}</td>
                    <td>${dato.producto}</td>
                    <td>S/${dato.subtotal}</td>
                    <td>${dato.cantidad}</td>
                    <td>S/${dato.precioenvio}</td>
                    <td>${dato.tipopago}</td>
                    <td>${dato.status}</td>
                </tr>
                
                `
                $("#tblallped").html(html)
                
            });
            
        }
    }






}