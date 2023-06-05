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


   

    <div class="tile">
        <div class="row mb-4">
            <div class="col-6">
                <!-- <?= var_dump($data['arrPedidoAll']["detallepedidos"][0]) ?> -->
                <h2 class="page-header"><i class="fa fa-male"></i> <?= $data['arrPedidoAll']["ordenGeneral"]["nombre"] ?></h2>
 
            </div>
            <div class="col-6">
            
                <?php
                
                if($data['arrPedidoAll']["ordenGeneral"]["puntos"] == 0){
                
                ?>
                <!-- <h5 class="text-right"><span class="badge badge-info"><i class="fa fa-hand-o-right" aria-hidden="true"></i> El cliente ha usado cupón de descuento</span></h5> -->
                
                <?php
                
                    }
                
                ?>
                <h5 class="text-right">Compras: <b style="font-size: 20px;">(<?= $data['arrPedidoAll']['totalcompras']["totalcompras"] ?>)</b></h5>
                <h5 class="text-right">Total: <b style="font-size: 20px;"><?= SMONEY.' '. formatMoney($data['arrPedidoAll']["ordenGeneral"]["montototales"]) ?></b></h5>
                <h5 class="text-right">Puntos: <b style="font-size: 20px;"><?= $data['arrPedidoAll']["ordenGeneral"]["puntos"] ?></b></h5>
            </div>
        </div>
        <div class="row invoice-info">

            <div class="col-4 mb-3">
                <i><b>Dni:</b> <?= $data['arrPedidoAll']["ordenGeneral"]["dni"] ?></i><br>
                <i><b>N° Celular:</b> <?= $data['arrPedidoAll']["ordenGeneral"]["celular"] ?></i><br>
               </address>
            </div>
           


          </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Productos comprados</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>


            
                <?php
                $cont = 0;
                 for ($n=0; $n < count($data['arrPedidoAll']["detallepedidos"]) ; $n++) {
                    $cont++;

                ?>
                    <tr>
                        <td><?= $cont ?></td>
                        <td><?= $data['arrPedidoAll']["detallepedidos"][$n]["fecha"] ?></td>


                        <td> <button class="btn btn-info btn-sm" onclick="fnt_viewdt(<?= $data['arrPedidoAll']['detallepedidos'][$n]['idpedido'] ?>)">Ver detalle de pedido</button>  </td>
                        
                        
                        <td><?= SMONEY.' '. formatMoney($data['arrPedidoAll']["detallepedidos"][$n]["montofinal"]) ?></td>
                    </tr>
              
                <?php } ?>
            </tbody>
        </table>
    </div>








<!-- Modal -->
<div class="modal fade" id="ModalDetallePedido" tabindex="-1" role="dialog" aria-labelledby="ModalDetallePedidoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>




        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>N° Orden</th>
                <th>Producto</th>
                <th>SubTotal</th>
                <th>Cantidad</th>
                <th>Precio envío</th>
                <th>Tipo Pago</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody id="tblallped">
            
            </tbody>
        </table>

















      </div>
     
    </div>
  </div>
</div>

</main>
<?php footerAdmin($data); ?>