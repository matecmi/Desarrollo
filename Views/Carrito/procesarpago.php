<?php 
headerTienda($data);

$tituloTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['titulo'] : "";
$infoTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['contenido'] : "";

// $orden = array($_SESSION['dataorden'])[0]["orden"];
// $orden2 = openssl_decrypt($or,den, METHODENCRIPT, KEY);
// var_dump($_SESSION['dataorden']);
$pedido_id = openssl_decrypt($_SESSION['dataorden']["orden"], METHODENCRIPT, KEY);
// $lugar_envio = array($_SESSION['dataorden'])[0]["lugar_envio"];
// var_dump($orden2);
?>
<style>
	.buttonconfirm{
		background-color: #cd0008;
		-webkit-box-shadow: 0 10px 6px -6px #777;
	}

	.buttonconfirm:hover{
		background-color: #cd000808;
		color: #cd0008;
		padding: 30px;
	}
</style>
<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= $tituloTerminos ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<div class="page-content">
        		<?= $infoTerminos  ?>
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

 <br><br><br>
<hr>
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
				Inicio
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<span class="stext-109 cl4">
				<?= $data['page_title'] ?>
			</span>
		</div>
        <h4 class="mtext-109 cl2 text-center" style="font-size: 35px;"> <i>¡Gracias por tu compra!</i> </h4>
        <p class="stext-115 cl6 p-t-2 text-center" style="margin-bottom: 0;">
            Tu pedido fue procesado con éxito.
        </p>
        <center>
        <span class="stext-112 cl8 text-center">
            N° Orden: <strong style="font-size: 20px;"> <?= $pedido_id; ?> </strong>
        </span>
        </center>
        <hr>
	</div>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            <p class="stext-111 m-l-63 m-l-25 m-r--38 m-lr-0-xl" style="margin-bottom: 10px;margin-bottom: 10px;font-weight: bold"><i class="zmdi zmdi-case-check" style="font-size: 20px;"></i> Último paso para validar tu pedido</p>

			

				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl">

					<div class="row">
						<div class="col-6">
							<button onclick="fntipe('new')" id="new" class="mb-4 buttonconfirm flex-c-m stext-101 cl0 size-116 hov-btn3 p-lr-15 trans-04 pointer">
								<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
								Nuevo Cliente
								</font></font>
							</button>
						</div>
						<div class="col-6">
							<button onclick="fntipe('exist')" id="exist" class="mb-4 buttonconfirm flex-c-m stext-101 cl0 size-116 hov-btn3 p-lr-15 trans-04 pointer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
								Soy cliente
								</font></font>
							</button>
						</div>
					</div>



						<div id="showrpta" style="display: none">

							<div id="reg_add">



							</div>

							<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9 a6">
								<select id="listtipopago" class="js-select2" name="listtipopago">
									<option disabled="" selected="" value="">Tipo de pago</option>
								<?php 
									if(count($data['tiposPago']) != 0){ 
										foreach ($data['tiposPago'] as $tipopago) {
											if($tipopago['status'] !=2){ 
									?>
									<option value="<?= $tipopago['idtipopago']?>"><?= $tipopago['tipopago']?></option>
								<?php
											}
										}
									} ?>
								</select>
								<div class="dropDownSelect2"></div>
							</div>

                            <hr>

							<div>
							<div class="bor8 bg0 m-b-12">
								<input id="txtAdicional" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="txtAdicional" placeholder="¿Algo adicional? (Opcional)">
							</div>

								<div class="bor8 bg0 m-b-25" id="divCondiciones">
									<input type="checkbox" id="condiciones" class="m-l-10">
									<label for="condiciones"> Aceptar </label>
									<a href="#" data-toggle="modal" data-target="#modalTerminos"> Términos y Condiciones </a>
								</div>
							</div>

							<input id="txtnewoexist" type="hidden" name="txtnewoexist">
							<button type="button" id="btnCompraTotal" numorden="<?= $pedido_id; ?>" estatusRegistro="0" regClienteId="" class="flex-c-m stext-101 cl0 size-116 bg3 notblock hov-btn3 p-lr-15 trans-04 pointer">
									Enviar
							</button>

						</div>
				</div>
			</div>
			
		</div>
	</div>

<?php 
	footerTienda($data);
 ?>
	