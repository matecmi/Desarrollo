<?php 
    headerAdmin($data); 
    getModal('modalCatalogos',$data);
?>
  <main class="app-content">    
      <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
                <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
              <?php } ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/clientes"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableCatalogos">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Título</th>
                          <th>Descripción</th>
                          <th>Vigencia</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>





<div class="modal fade" id="modalAddProductoCatalogos" tabindex="-1" role="dialog" aria-labelledby="modalAddProductoCatalogosLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddProductoCatalogosLabel">Agregando productos al catálogo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formRegistroCatalogoProductos" name="formRegistroCatalogoProductos" class="form-horizontal">

          <input type="hidden" id="idCatalogoProductoRegistrar" name="idCatalogoProductoRegistrar" value="">

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="listProductos">Producto</label>
              <select class="form-control" data-live-search="true" id="listProductos" name="listProductos" required>

              </select>
            </div>

          </div>



          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i
                class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
            <!-- <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button> -->
          </div>
        </form>
        <hr>
        <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody id="tblprodcatal">
              
              </tbody>
            </table>
      </div>
    </div>
  </div>
</div>
<?php footerAdmin($data); ?>
    