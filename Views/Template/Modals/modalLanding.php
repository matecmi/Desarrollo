<!-- Modal -->
<div class="modal fade" id="modalFormLanding" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Categoría</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formLandingpage" name="formLandingpage" class="form-horizontal">
              <input type="hidden" id="idlandingpage" name="idLandingpage" value="0">
              <input type="hidden" id="foto_actual" name="foto_actual" value="">
              <input type="hidden" id="foto_imagen01" name="foto_imagen01" value="">
              <input type="hidden" id="foto_imagen02" name="foto_imagen02" value="">
              <input type="hidden" id="foto_remove" name="foto_remove" value="0">

              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Titulo formulario <span class="required">*</span></label>
                      <input class="form-control" id="txtTituloFormulario" name="txtTituloFormulario" type="text" placeholder="Ingrese un título" required="">
                    </div>
                    <div class="form-group">
                      <label class="control-label">SubTítulo formulario <span class="required">*</span></label>
                      <input class="form-control" id="txtSubtituloForm" name="txtSubtituloForm" type="text" placeholder="Ingrese subtitulo" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="photo">
                        <label for="foto">Portada principal (570x380)</label>
                        <div class="prevPhoto">
                          <span class="delPhoto notBlock">X</span>
                          <label for="foto"></label>
                          <div>
                            <img id="img" src="<?= media(); ?>/images/uploads/portada_categoria.png">
                          </div>
                        </div>
                        <div class="upimg">
                          <input type="file" name="foto" id="foto">
                        </div>
                        <div id="form_alert"></div>
                    </div>
                </div>

                <hr>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                      <label class="control-label">Titulo Descripción <span class="required">*</span></label>
                      <input class="form-control" id="txtTituloDescripcion" name="txtTituloDescripcion" type="text" placeholder="Ingrese una descripción" required="">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                      <label class="control-label">SubTítulo Descripción <span class="required">*</span></label>
                      <input class="form-control" id="txtSubtituloDescripcion" name="txtSubtituloDescripcion" type="text" placeholder="Ingrese SubTítulo a la descripción" required="">

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Descripción <span class="required">*</span></label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción general" required=""></textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Imagen1<span class="required">*</span></label>
                      <input class="form-control" type="file" id="img1" name="img1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Imagen2 <span class="required">*</span></label>
                      <input class="form-control" type="file" id="img2" name="img2">
                    </div>
                </div>
                

              </div>
              
              <div class="tile-footer mt-3">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>