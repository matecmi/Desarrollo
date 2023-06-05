<!-- Modal -->
<div class="modal fade" id="modalFormPedido" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formUpdatePedido" name="formUpdatePedido" class="form-horizontal">
              <input type="hidden" id="idpedido" name="idpedido" value="<?= $data['orden']['idpedido'] ?>" required="">
              <table class="table table-bordered">
                  <tbody>
                      <tr>
                          <td width="210">No. Pedido</td>
                          <td><?= $data['orden']['idpedido'] ?></td>
                      </tr>
                      <tr>
                          <td>Cliente:</td>

                          <!-- <td><?= $data['cliente']['nombres'].' '.$data['cliente']['apellidos'] ?></td> -->
                            <?php 
                                if($data['cliente'] != ""){
                            ?>

                                <td>  
                                    <select class="form-control" data-live-search="true" id="listaClientesAll" name="listaClientesAll" required >
                                        <option value="<?= $data['cliente']['id_cliente']?>"><?= $data['cliente']['nombre']?></option>
                                    </select>
                                </td>

                            <?php 
                                }else{ 
                            ?>

                                <td>  
                                    <b class="text-danger"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Aún no se ha registrado cliente </b>
                                    <select class="form-control" data-live-search="true" id="listaClientesAll" name="listaClientesAll" required >

                                        <?php foreach ($data['todosclientes'] as $allClientes) { ?>

                                            <option value="<?= $allClientes['id_cliente']?>"><?= $allClientes['nombre']?></option>

                                        <?php } ?>

                                    </select>
                                </td>


                            <?php 
                                } 
                            ?>
                      </tr>
                      <tr>
                          <td>Importe total:</td>
                          <td><?= SMONEY.' '.$data['orden']['monto'] ?></td>
                      </tr>
                     
                      <tr>
                          <td>Transacción:</td>
                          <td>
                            <input type="text" name="txtTransaccion" id="txtTransaccion" class="form-control" value="<?= $data['orden']['referenciacobro'] ?>" required="">
                          </td>
                      </tr>
                      <tr>
                          <td>Tipo pago:</td>
                          <td>
                              <select name="listTipopago" id="listTipopago" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count($data['tipospago']) ; $i++) {
                                        $selected = "";
                                        if( $data['tipospago'][$i]['idtipopago'] == $data['orden']['tipopagoid']){
                                            $selected = " selected ";
                                        }
                                   ?>
                                    <option value="<?= $data['tipospago'][$i]['idtipopago'] ?>" <?= $selected ?> ><?= $data['tipospago'][$i]['tipopago'] ?></option>
                                <?php } ?>
                              </select>
                          </td>
                      </tr>
                      <tr>
                          <td>Estado:</td>
                          <td>
                              <select name="listEstado" id="listEstado" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count(STATUS) ; $i++) {
                                        $selected = "";
                                        if( STATUS[$i] == $data['orden']['status']){
                                            $selected = " selected ";
                                        }
                                   ?>
                                   <option value="<?= STATUS[$i] ?>" <?= $selected ?> ><?= STATUS[$i] ?></option>
                               <?php } ?>
                              </select>
                          </td>
                      </tr>
                  </tbody>
              </table>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-info" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
            </div>
              
            </form>
      </div>
    </div>
  </div>
</div>