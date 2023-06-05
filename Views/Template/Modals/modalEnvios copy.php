<!-- Modal Registrar -->
<div class="modal fade" id="modalRegistrarEnvios" tabindex="-1" role="dialog"
    aria-labelledby="modalRegistrarEnviosTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Registro de envíos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEnvios" name="formEnvios" class="form-horizontal">
                    <input type="hidden" id="idEnvios" name="idEnvios" value="">
                    <p class="text-primary">Todos los campos son obligatorios.</p>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="listDep">Departamento</label>
                            <select class="form-control" id="listDep" name="listDep" required="">
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="listProv">Provincia</label>
                            <select class="form-control" id="listProv" name="listProv" required="">
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="txtDestino">Distrito</label>
                            <select class="form-control" id="txtDestino" name="txtDestino" required="">
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="txtPrecioEnvio">Precio</label>
                            <input type="text" class="form-control valid validNumber" id="txtPrecioEnvio" name="txtPrecioEnvio"
                                required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="listStatus">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <div class="tile-footer text-center">
                            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal View -->
<div class="modal fade" id="modalViewEnvios" tabindex="-1" role="dialog" aria-labelledby="modalViewEnviosTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>ID:</td>
              <td id="enCodigo"></td>
            </tr>
            <tr>
              <td>Destino:</td>
              <td id="enDestino"></td>
            </tr>
            <tr>
              <td>Precio:</td>
              <td id="enPrecio"></td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="enEstado"><span class="badge badge-success"></span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>