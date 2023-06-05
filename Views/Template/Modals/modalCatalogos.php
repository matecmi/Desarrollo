
<div class="modal fade" id="modalFormCatalogos" tabindex="-1" role="dialog" aria-labelledby="modalFormCatalogosTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormCatalogosTitle">Nuevo Catálogo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <form id="frmAddCatalogo" name="frmAddCatalogo" class="form-horizontal">
            <div class="form-group col-md-12">
             
                <input type="hidden" id="idCatalogoadd" name="idCatalogoadd" value="0">

                <div class="form-row mt-3 mb-3">
                    <label for="txtTituloCatalogo">Título <span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtTituloCatalogo" name="txtTituloCatalogo" required="">
                </div>
                <div class="form-row mt-3 mb-3">
                    <label for="txtDescripcionCatalogo">Descripción <span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtDescripcionCatalogo" name="txtDescripcionCatalogo" required="">
                </div>
                <div class="form-row mt-3 mb-3">
                    <label for="datFecha">Fecha vigencia <span class="required">*</span></label>
                    <input type="date" class="form-control" id="datFecha" name="datFecha" required="" min=<?php $hoy=date("Y-m-d"); echo $hoy;?>>
                </div>
            </div>
            <center>
                
            <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle" aria-hidden="true"></i>Cerrar</button>
              </div>
            </center>
        </form>




      </div>
     
    </div>
  </div>
</div>