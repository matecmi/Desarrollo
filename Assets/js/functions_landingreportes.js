function frmShowRegister(){

    var landingelegida = $('#landing').val();

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Landingreportes/getReportesDinamicos/'+landingelegida;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            console.log(objData)
            $('#porcionDinamica').html(objData); //agrego toda la tabla armada, al div personalizado.



                $('#bootstrap-data-table-export').dataTable( {
                    "aProcessing":true,
                    "aServerSide":true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    },
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




        }
    }
}