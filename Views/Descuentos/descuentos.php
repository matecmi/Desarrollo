<?php 
    headerAdmin($data); 
    getModal('modalClientes',$data);
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-box-tissue"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/descuentos"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>











    <div class="tile mb-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h4 class="mb-3 line-head" id="typography"><i class="fa fa-cubes" aria-hidden="true"></i> Por productos</h4>
                </div>
            </div>
        </div>
        <!-- Headings-->
        <div class="row">
            <div class="col-lg-4">

                <form id="formRegistroPorProducto" name="formRegistroPorProducto" class="form-horizontal">

                    <input type="hidden" id="idDescuentoProducto" name="idDescuentoProducto" value="">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="listProductos">Producto</label>
                            <select class="form-control" data-live-search="true" id="listProductos" name="listProductos" required>

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtPrecioProducto">Precio</label>
                            <span class="form-control" id="txtPrecioProducto" name="txtPrecioProducto"></span>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtDescuento">(-%)</label>
                            <input type="text" class="form-control valid validNumber" id="txtDescuento" name="txtDescuento" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtTotalDescuentoProncentual">Descuento</label>
                            <input type="text" disabled class="form-control valid validNumber" id="txtTotalDescuentoProncentual" name="txtTotalDescuentoProncentual" required="" onkeypress="return controlTag(event);">

                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtTotalDescuento">Pagar</label>
                            <input type="text" disabled class="form-control valid validNumber" id="txtTotalDescuento" name="txtTotalDescuento" required="" onkeypress="return controlTag(event);">

                        </div>
                        
                        <div class="form-group col-md-12">
                            <label for="fValidoProducto">Válido hasta</label>
                            <input type="date" class="form-control" id="fValidoProducto" name="fValidoProducto" required="" min=<?php $hoy=date("Y-m-d"); echo $hoy;?>>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp; <!-- <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button> -->
                    </div>
                </form>

            </div>



            <div class="col-md-8">
                <div class="tile">
                    <table class="table table-striped" id="tableDescuentoProducto">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Total</th>
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



    <hr>















    <div class="tile mb-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h4 class="mb-3 line-head" id="typography"><i class="fa fa-sitemap" aria-hidden="true"></i> Por puntos - cupón - envíos</h4>
                </div>
            </div>
        </div>
        <!-- Headings-->
        <div class="row">
            <div class="col-lg-8">
                <form id="formRegistroPorPuntos" name="formRegistroPorPuntos" class="form-horizontal">
                    <input type="hidden" id="idDescuentoPorPuntos" name="idDescuentoPorPuntos" value="">
                    <div class="form-row">
                        <div class="form-group col-md-6 tiposel">
                            <label for="txtTitpoPuntos">Tipo</label>
                            <select class="form-control" id="txtTitpoPuntos" name="txtTitpoPuntos" required>
                                <option disabled="" selected="" value="">Seleccionar</option>
                                <option value="Puntos">Puntos</option>
                                <option value="Cupón libre">Cupón libre</option>
                                <option value="Envio gratis">Envio gratis</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 tipopuntos" style="display: none;">
                            <label for="txtPuntos" class="evnipunt">Puntos</label>
                            <input type="text" class="form-control valid validNumber" value="0" id="txtPuntos" name="txtPuntos" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtTotalDescuentoPuntos" id="descuentotext">Descuento</label>
                            <input type="text" class="form-control valid validNumber" id="txtTotalDescuentoPuntos" name="txtTotalDescuentoPuntos" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtCod_cupon">Código</label>
                            <input type="text" class="form-control" id="txtCod_cupon" maxlength="13" placeholder="-">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fValido">Válido hasta</label>
                            <input type="date" class="form-control" id="fValido" name="fValido" required="" min=<?php $hoy=date("Y-m-d"); echo $hoy;?>>
                        </div>
                        <div class="form-group col-md-3 ">
                            <label for="txtEstadoPuntos">Estado</label>
                            <select class="form-control" id="txtEstadoPuntos" name="txtEstadoPuntos" required>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button id="btnActionFormPuntos" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i><span id="btnTextPuntos">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <!-- <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button> -->
                    </div>
                </form>
                <hr>
                <div class="tile">
            <table class="table table-striped" id="tableDescuentoPuntos">
            <thead>
                <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Descuentos</th>
                <th>Vigencia</th>
                <th>Código</th>
                <th>Estado</th>
                <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
            </table>
        </div>
            </div>
            <div class="col-lg-4">

                <div class="coupon-container">
                    <img class="bg" src="<?= media(); ?>/images/bg.svg" alt="" />

                    <img class="gift" src="<?= media(); ?>/images/gift.svg" alt="" />

                    <h2>¡Felicidades!</h2>
                    <p>En tu siguiente compra obtendrás</p>
                    <div class="discount" style="font-weight: bold;"> - <b id="desc_cards"></b>% </div>
                    <p style="margin: 0;"><b><i>Ingresando el siguiente cupón</i></b></p>
                    <a href="#" class="btn">

                        <span class="code" style="font-size: 25px;" id="cuponcards"></span> <br>
                        <span style="font-size: 10px;">Válido hasta <b id="yearcupon">mm/dd/yyy</b></span>

                    </a>


                </div>

            </div>

        </div>

    </div>




    <hr>


     <div class="tile mb-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h4 class="mb-3 line-head" id="typography"><i class="fa fa-users" aria-hidden="true"></i> Por referidos</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <form id="frmBuscarReferidos" name="frmBuscarReferidos" class="form-horizontal">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="slcClientes">Cliente</label>
                            <select class="form-control" id="slcClientes" name="slcClientes" required="">
                                
                            </select>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-info btn-ref"><i class="fa fa-fw fa-lg fa-eye" aria-hidden="true"></i> Ver sus referidos</button>
                    </div>

                </form>
            </div>
            <div class="col-lg-8">

                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>N° Celular</th>
                        <th>Correo</th>
                        <th>Registrado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tblReferidos">
                  
                 
                </tbody>
                </table>

            </div>
           
        </div>
     

    </div>












</main>

<div class="modal fade" id="addCuponModal" tabindex="-1" role="dialog" aria-labelledby="addCuponModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCuponModalTitle">Agregar Cupón</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form id="frmAddCuponRef" name="frmAddCuponRef" class="form-horizontal">
                    <div class="form-group col-md-12">
                        <label for="slcCuponesDescuentos">Cupones disponibles</label>
                        <select class="form-control" id="slcCuponesDescuentos" name="slcCuponesDescuentos" required="">
                            <?php
                            foreach ($data['cupones'] as $cupon) {
                            ?>
                            <option value="<?= $cupon["codigo"] ?>"><?= $cupon["codigo"] ?> - <?= $cupon["descuento"] ?>%</option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" id="id_ref" value="">

                        <hr>

                        <span>Asignado</span>
                        <span class="form-control" id="cpasignado" name="cpasignado"></span>

                        <hr>
                    </div>
                    <center>
                        
                    <div class="tile-footer mt-4">
                        <button class="btn btn-info btn-ref"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i> Asignar cupón</button>
                    </div>
                    </center>
                </form>
      </div>
     
    </div>
  </div>
</div>

<?php footerAdmin($data); ?>