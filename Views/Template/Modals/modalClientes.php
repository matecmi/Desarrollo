<!-- Modal -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formCliente" name="formCliente" class="form-horizontal">
              <input id="idclienterg" type="hidden" name="idclienterg" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtDniC">Dni <span class="required">*</span></label>
                  <input type="text" class="form-control valid validNumber" id="txtDniC" name="txtDniC" required="" onkeypress="return controlTag(event);">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtNombreC">Nombres <span class="required">*</span></label>
                  <input type="text" class="form-control valid validText" id="txtNombreC" name="txtNombreC" required="" >
                </div>
              </div>


              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtCelularC">N° Celular <span class="required">*</span></label>
                  <input type="text" class="form-control valid validNumber" id="txtCelularC" name="txtCelularC" required="" onkeypress="return controlTag(event);">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtDireccionC">Dirección de envío <span class="required">*</span></label>
                  <input type="text" class="form-control valid validText" id="txtDireccionC" name="txtDireccionC" required="" >
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="txtEmailC">Correo Electrónico <span class="required">*</span></label>
                  <input type="email" class="form-control valid validEmail" id="txtEmailC" name="txtEmailC" required="">
                </div>
              </div>
              
             <div class="form-row">
                
             </div>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail">Larry</td>
            </tr>
            <tr>
              <td>Identificación Tributaria:</td>
              <td id="celIde">Larry</td>
            </tr>
            <tr>
              <td>Nombre Fiscal:</td>
              <td id="celNomFiscal">Larry</td>
            </tr>
            <tr>
              <td>Dirección Fiscal:</td>
              <td id="celDirFiscal">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
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

