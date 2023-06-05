<?php 
headerTienda($data);
$nombre = $data['dataorden']["nombreSuscriptor"];
$orden = $data['dataorden']["orden"];

// $validar = array($data['compras_total_clientes']);


  $monto = $data['compras_total_clientes']["datamonto"]["puntos"];
  
  if(isset($data['validar_descuento']["ppuntos"])){

    $descuentopuntos = $data['validar_descuento']["ppuntos"];
  
    //Validar si ha completado los puntos para el descuento
    
    $validarsiaccede = intval($descuentopuntos) - $monto;

    // var_dump(intval($descuentopuntos));
    // echo '</br>';
    // var_dump(intval($monto));
    // echo '</br>';
    // var_dump(intval($validarsiaccede));

  
  }

  

?>
<br><br><br><!-- WHATSAPP -->



<a href="https://api.whatsapp.com/send?phone=949160993" class="btn-wsp" target="_blank">
	<i class="zmdi zmdi-whatsapp icono"></i>
</a>
<div class="jumbotron text-center">
  <h4 class="mtext-109 cl2">
    <?= $nombre  ?> ¡Te has registrado exitosamente!
  </h4>


<!-- Button trigger modal -->


  <hr class="my-4">
  <p class="stext-111 cl6 p-t-2">
    Pronto nos pondremos en contacto contigo para coordinar los datos de entrega.
  </p>
  <p class="stext-111 cl6 p-t-2">
    No olvides guardar tu N° de orden <b>(<?= $orden  ?>)</b> para poder validar tus compras.
  </p>
  <p class="stext-111 cl6 p-t-2">
    Gracias por elegir Bm.bijou.
  </p>
  <br>
  <!-- <a class="btn btn-success" href="https://api.whatsapp.com/send?text=<?= 'He realizado la compra con N° de orden '.$data['orden']. ' adjuntando mis siguientes datos:'?>" target="_blank" role="button">Enviar a <i class="fa fa-whatsapp" aria-hidden="true"></i></a> -->
  <a class="btn btn-success flat-btn" style="font-size: 16px;border-radius: 0;" href="<?= base_url(); ?>" role="button"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <b style="font-size:13px">Seguir comprando</b></a>
  
  <?php if($validarsiaccede == 0 || $validarsiaccede < 0 ){ ?>
    <button data-toggle="modal" data-target="#modalcupon" class="btn btn-info mdlcpn flat-btn" type="button" style="font-size: 16px;border-radius: 0;"><i class="fa fa-gift"></i> <b style="font-size:13px">Ver mi regalo</b></button>
  <?php } ?>

  <h5 class="mtext-109 cl2 p-b-30 mt-5" onclick="referidos('<?= openssl_encrypt($data['compras_total_clientes']['datamonto']['id_cliente'],METHODENCRIPT,KEY); ?>','<?= $data['compras_total_clientes']['datamonto']['nombre']; ?>')" style="font-size: 13px;cursor: pointer;color: hsl(152, 51%, 52%);font-weight: bold;"> Llevate un cupón de descuento por cada referido </h5>
</div>



<!-- Modal -->
<div class="modal fade" id="modalcupon" tabindex="-1" role="dialog" aria-labelledby="modalcuponLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="coupon-container">
        <img class="bg" src="http://localhost/bmbijou_catalogo/Assets/images/bg.svg" alt="">

        <img class="gift" src="http://localhost/bmbijou_catalogo/Assets/images/gift.svg" alt="">

        <h2>¡Felicidades!</h2>
        <p>En tu siguiente compra obtendrás</p>
        <div class="discount" style="font-weight: bold;"><b id="desc_cards"><?= (isset($data['validar_descuento']["ppuntos"])) ? $data['validar_descuento']["descuento"] : "-" ?></b>% </div>
        <p style="margin: 0;"><b><i>Ingresando el siguiente cupón</i></b></p>
        <a href="#" class="btn">

            <span class="code" style="font-size: 25px;" id="cuponcards"><?= (isset($data['validar_descuento']["ppuntos"])) ? $data['validar_descuento']["codigo"] : "-" ?></span> <br>
            <span style="font-size: 10px;">Válido hasta <b id="yearcupon"><?= (isset($data['validar_descuento']["ppuntos"])) ? date("d-m-Y", strtotime($data['validar_descuento']["fvigencia"])) : "dd-mm-yyy" ?></b></span>

        </a>
        
        
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalReferidos" tabindex="-1" role="dialog" aria-labelledby="modalReferidosTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="top: 20%;">
    <div class="modal-content" style="border-radius: 0;">
      <div class="modal-header" style="background-image: url(<?= media() ?>/images/imgref.png);background-size: cover;height: 130px;">
        <h5 class="modal-title" id="modalReferidosTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center><h4 class="mtext-109 cl2 p-b-10" style="font-size: 13px;"> Por cada referido te enviaremos un cupón de descuento </h4></center>
        
        <form id="formRegisterReferides" method="post">
          <div class="bor8 bg0 m-b-12">
            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="rf_nombre" id="rf_nombre" placeholder="Nombre">
          </div>
          <div class="bor8 bg0 m-b-12">
            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="rf_celular" id="rf_celular" placeholder="N° Celular">
          </div>
          <div class="bor8 bg0 m-b-12">
            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="rf_email" id="rf_email" placeholder="Correo Electrónico">
          </div>
          <input type="hidden" name="rf_clt" id="rf_clt" value="">
          <input type="hidden" name="rf_nomb" id="rf_nomb" value="">
          
          <center>
            <button type="button" class="btn btn-secondary stext-107 bor7 m-r-5 m-b-5" data-dismiss="modal" style="border-radius: 0;">Cerrar</button>
            <button type="submit" class="btn btn-info stext-107 bor7 m-r-5 m-b-5" style="border-radius: 0;">Enviar referido</button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>

<?php 
	footerTienda($data);
?>
<?php if($validarsiaccede == 0 || $validarsiaccede < 0 ){ ?>
  <script>
    $('#modalcupon').modal("show")
  </script>
<?php } ?>