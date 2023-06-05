<?php headerAdmin($data); ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-file-text-o"></i> <?= $data['page_title'] ?></h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/pedidos"> Pedidos</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <?php
          if(empty($data['arrPedido'])){
        ?>
        <p>Datos no encontrados</p>
        <?php }else{
            $cliente = $data['arrPedido']['cliente']; 
            $orden = $data['arrPedido']['orden'];
            $detalle = $data['arrPedido']['detalle'];

            // var_dump($orden);
            // echo '</br>';
            // echo '</br>';
            // var_dump($orden["monto"]);
            
         ?>
        <section id="sPedido" class="invoice">
          <div class="row mb-0">
            <div class="col-6">
              <h2 class="page-header"><img src="<?= media(); ?>/tienda/images/logo2.png" style="width: 15%"></h2>
            </div>
            <div class="col-6">
              <h5 class="text-right">Fecha: <?= $orden['fecha'] ?></h5>
            </div>
          </div>



    



          <div class="row invoice-info">
            <div class="col-4">
              <address><strong><i><?= NOMBRE_EMPESA; ?></i></strong><br>
                <i><?= DIRECCION ?></i><br>
                <i><?= TELEMPRESA ?></i><br>
                <i><?= EMAIL_EMPRESA ?></i><br>
                <i><?= WEB_EMPRESA ?></i>
              </address>
            </div>
            <div class="col-4">
              <address><strong><i><?= ($cliente == "") ? '<span class="badge badge-secondary">Pendiente</span>' : $cliente['nombre']; ?></i></strong><br>
              <i><b>Dni:</b> <?= ($cliente == "") ? '<span class="badge badge-secondary">Pendiente</span>' : $cliente['dni']; ?></i><br>
              <i><b>Envío:</b> <?= ($cliente == "") ? '<span class="badge badge-secondary">Pendiente</span>' : $cliente['direccion_envio']; ?></i><br>
              <i><b>Tel:</b> <?= ($cliente == "") ? '<span class="badge badge-secondary">Pendiente</span>' : $cliente['celular']; ?></i><br>
              <i><b>Adicional:</b> <?= ($orden == "") ? '<span class="badge badge-secondary">Pendiente</span>' : $orden["adicional"]; ?></i>
               </address>
            </div>
            <div class="col-4"><b><i>Orden <b style="font-size: 20px;"># <?= $orden['idpedido'] ?></b></i></b><br> 
                <i><b>Pago: </b><?= $orden['tipopago'] ?></i><br>
                <i><b>Estado:</b> <span class="badge badge-pill badge-info"><?= $orden['status'] ?></span></i> <br>
                <i><b>Monto:</b> <?= SMONEY.' '. formatMoney($orden["montofinal"]) ?></i>
            </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Descripción</th>
                    <th class="text-right">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Importe</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $subtotal = 0;
                        if(count($detalle) > 0){
                          
                          foreach ($detalle as $producto) {
                            // $subtotal += $producto['cantidad'] * $producto['precio'];
                     ?>
                  <tr>
            
                   

                    <td><?= $producto['producto'] ?></td>
                    <td class="text-right"><?= SMONEY.' '. formatMoney($producto['precio']) ?></td>
                    <td class="text-center"><?= $producto['cantidad'] ?></td>
                    <td class="text-right"><?= SMONEY.' '. formatMoney($producto['cantidad'] * $producto['precio']) ?></td>
                  </tr>
                  <?php 
                        }
                      }
                   ?>
                </tbody>
                <tfoot>
                    <?php  if($orden['cod_descuento'] != "-") { ?>
                    <tr>
                        <th colspan="3" class="text-right">Descuento:</th>
                        <td class="text-right"><span class="badge badge-light"><?= $orden['cod_descuento'] ?></span> - <span class="badge badge-success"><?= $orden['descuento'] ?>%</span></td>
                    </tr>
                    <?php  }  ?>
                    <tr>
                        <th colspan="3" class="text-right">Sub-Total:</th>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($orden["monto"]) ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Envío:</th>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($orden['costo_envio']) ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($orden['montofinal']) ?></td>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="row d-print-none mt-2">
            <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('#sPedido');" ><i class="fa fa-print"></i> Imprimir</a></div>
          </div>
        </section>
        <?php } ?>
      </div>
    </div>
  </div>
</main>
<?php footerAdmin($data); ?>