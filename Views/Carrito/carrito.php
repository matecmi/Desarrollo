<?php 
headerTienda($data);
?>
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
	</div>
<?php 
$subtotal = 0;
$subtotaldesc = 0;
$total = 0;
if(isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0){ 
	

	
 ?>		
	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85" >
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">

						<div class="wrap-table-shopping-cart">
							<table id="tblCarrito" class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Producto</th>
									<th class="column-2"></th>
									<th class="column-3">Precio</th>
									<th class="column-4">Cantidad</th>
									<th class="column-5">Total</th>
								</tr>
							<?php 
								foreach ($_SESSION['arrCarrito'] as $producto) {
									$totalProducto = $producto['precio'] * $producto['cantidad'];
									$subtotal += $totalProducto;
									$subtotaldesc += $producto['preciocondescuento'];
									$idProducto = openssl_encrypt($producto['idproducto'],METHODENCRIPT,KEY);
								
							 ?>
								<tr class="table_row <?= $idProducto ?>">
									<td class="column-1">
										<div class="how-itemcart1" idpr="<?= $idProducto ?>" op="2" onclick="fntdelItem(this)" >
											<img src="<?= $producto['imagen'] ?>" alt="<?= $producto['producto'] ?>">
										</div>
									</td>
									<td class="column-2"><?= $producto['producto'] ?></td>
									<td class="column-3"><?= SMONEY.formatMoney($producto['precio']) ?></td>
									<td class="column-4">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" idpr="<?= $idProducto ?>">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="<?= $producto['cantidad'] ?>" idpr="<?= $idProducto ?>">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" idpr="<?= $idProducto ?>">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
									</td>
									<td class="column-5"><?= SMONEY.formatMoney($totalProducto) ?></td>
								</tr>
							<?php } ?>

							</table>
						</div>

						<?php 
							$aplicar_descuento = ($subtotal * $subtotaldesc) / 100;
							$precio_condescuento = $subtotal - $aplicar_descuento;

						?>
						<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
							<div class="flex-w flex-m m-r-20 m-tb-5">
								<input class="stext-104 cl2 plh4 size-117 bor10 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" id="coupon" placeholder="Código de descuento" value="">
								<div class="appcupon flex-c-m stext-101 cl2 size-118 bg8 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
									Aplicar código
								</div>
							</div>
						</div>


					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Totales 

							<?php if ($subtotaldesc != 0){ ?>
								<span style="background: hsl(152, 51%, 52%);font-size: 0.813rem;color: #ffffff;border-radius: 5px;padding: 0 8px;"><b class="descuentototal"><?= $subtotaldesc ?></b>%</span>
							<?php } ?>
						
						
						</h4>
						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209 alprecio">
								<?php if ($subtotaldesc != 0){ ?>
									<span id="subTotalCompra" style="text-decoration: line-through;color: rgb(205, 0, 8);" class="mtext-110 cl2"><?= SMONEY.formatMoney($subtotal) ?></span>
								<?php }else{  ?>
									<span id="subTotalCompra" class="mtext-110 cl2"><?= SMONEY.formatMoney($subtotal) ?></span>
								<?php } ?>

								<?php if ($subtotaldesc != 0){ ?>
									<span class="mtext-110 cl2" style="font-weight: bold;">- <b id="new_prec"><?= SMONEY.formatMoney($precio_condescuento) ?></b></span>
								<?php } ?>
								
							</div>

								
							
							<!-- <?= SMONEY.formatMoney(COSTOENVIO) ?> -->











							<?php 
								$validoenviofree = $_SESSION['arrCarrito'][0]["enviofree"];
								if($validoenviofree != NULL){
									if($subtotal >= $validoenviofree["ppuntos"]){
									?>
										<div class="size-208" style="margin: auto">
											<span class="stext-110 cl2">
												Envío:
											</span>
										</div>
										<div class="size-209 rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
											<select disabled="disabled" class="js-select2 precio_envios" name="time" idProd="<?= $idProducto ?>" idenv="<?= $_SESSION['arrCarrito'][0]["precioenvios"]["precio"] ?>">
												<option value="<?= $_SESSION['arrCarrito'][0]["precioenviosArmado"]; ?>" attrvalues="<?= $_SESSION['arrCarrito'][0]["precioenvios"]["precio"] ?>" ><?= $_SESSION['arrCarrito'][0]["precioenviosArmado"]; ?></option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									<?php

									}else{

										?>

										<div class="size-208" style="margin: auto">
											<span class="stext-110 cl2">
												Envío:
											</span>
										</div>
										<div class="size-209 rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
											<select class="js-select2 precio_envios" name="time" idProd="<?= $idProducto ?>" idenv="<?= $_SESSION['arrCarrito'][0]["precioenvios"]["precio"] ?>">
												<option value="<?= $_SESSION['arrCarrito'][0]["precioenviosArmado"]; ?>" attrvalues="<?= $_SESSION['arrCarrito'][0]["precioenvios"]["precio"] ?>" ><?= $_SESSION['arrCarrito'][0]["precioenviosArmado"]; ?></option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>

										<?php


									}

								}else{


									?>

										<div class="size-208" style="margin: auto">
											<span class="stext-110 cl2">
												Envío:
											</span>
										</div>
										<div class="size-209 rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
											<select class="js-select2 precio_envios" name="time" idProd="<?= $idProducto ?>" idenv="<?= $_SESSION['arrCarrito'][0]["precioenvios"]["precio"] ?>">
												<option value="<?= $_SESSION['arrCarrito'][0]["precioenviosArmado"]; ?>" attrvalues="<?= $_SESSION['arrCarrito'][0]["precioenvios"]["precio"] ?>" ><?= $_SESSION['arrCarrito'][0]["precioenviosArmado"]; ?></option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>


									<?php
								}
							?>

							

							



















						</div>
						<div class="flex-w flex-t p-t-10 p-b-10 bor12">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<?php 

								$validoenviogratis = $_SESSION['arrCarrito'][0]["enviofree"];

								$subtotalCalcular = ($subtotal != $precio_condescuento) ? $precio_condescuento : $subtotal;

								if($validoenviogratis != NULL){
									if($subtotal >= $validoenviogratis["ppuntos"]){
										$calculandoenvios = $subtotal;
										$enviogratisactivado = "enviogratis";

									}else{
										$calculandoenvios = $subtotal + $_SESSION['arrCarrito'][0]["precioenvios"]["precio"];
										$enviogratisactivado = "noenviogratis";
									}
								}else{
									$calculandoenvios = $subtotal + $_SESSION['arrCarrito'][0]["precioenvios"]["precio"];
									$enviogratisactivado = "noenviogratis";
								}


							?>
							<div class="size-209 p-t-1">

								<?php if (($subtotaldesc != 0)){ ?>


									<?php  if($precio_condescuento >= $validoenviogratis["ppuntos"]){ ?>
										
									<span id="totalCompra" class="mtext-110 cl2" style="color:hsl(152, 51%, 52%);font-weight:bold"><?= SMONEY.formatMoney($precio_condescuento + $_SESSION['arrCarrito'][0]["precioenvios"]["precio"]) ?></span>
									<span class="mtext-110 cl2 pricesfree" style="background: hsl(152, 51%, 52%);font-size: 1rem;color: hsl(0, 100%, 100%);padding: 0px 8px;border-radius: 5px;">Envío gratis</span>

									<?php  }else{ ?>

										<span id="totalCompra" class="mtext-110 cl2"><?= SMONEY.formatMoney($precio_condescuento + $_SESSION['arrCarrito'][0]["precioenvios"]["precio"]) ?></span>
										<span class="mtext-110 cl2 pricesfree" style="display:none;background: hsl(152, 51%, 52%);font-size: 1rem;color: hsl(0, 100%, 100%);padding: 0px 8px;border-radius: 5px;">Envío gratis</span>


									<?php  } ?>


									


								<?php }else{  ?>
									<?php  if($enviogratisactivado == "enviogratis"){ ?>
									<span id="totalCompra" class="mtext-110 cl2" style="color:hsl(152, 51%, 52%);font-weight:bold"><?= SMONEY.formatMoney($calculandoenvios) ?></span>
										<span class="mtext-110 cl2 pricesfree" style="background: hsl(152, 51%, 52%);font-size: 1rem;color: hsl(0, 100%, 100%);padding: 0px 8px;border-radius: 5px;">Envío gratis</span>
									<?php  }else{ ?>
									<span id="totalCompra" class="mtext-110 cl2"><?= SMONEY.formatMoney($calculandoenvios) ?></span>
										<span class="mtext-110 cl2 pricesfree" style="display:none;background: hsl(152, 51%, 52%);font-size: 1rem;color: hsl(0, 100%, 100%);padding: 0px 8px;border-radius: 5px;">Envío gratis</span>
									<?php  } ?>
								<?php } ?>
							
							
							</div>
						</div>




						<h6 class="ltext-103 cl5 m-t-15" style="font-size: 15px !important;text-align: center;">
								<i>Paga aquí con:</i>
							</h6>


						<div class="flex-w flex-sb-m p-b-1">
							<div class="flex-w flex-l-m filter-tope-group m-tb-10">
								<button type="button" class="stext-106 cl6 hov1 bor3 trans-04 m-r-10 m-tb-5 pagoconyape" data-filter=".men">
									<img src="<?= media();?>/images/yape.png" alt="pago yape" class="logoyape">
								</button>
								<button type="button" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 pagoconplin" data-filter=".shoes">
									<img src="<?= media();?>/images/plin.png" alt="pago plin" class="logoplin">
								</button>
							</div>
						</div>








						<div class="row isotope-grid">

							<div class="col-sm-6 col-md-4 col-lg-12 p-b-35 isotope-item men" style="text-align: center;">
								<div class="block2">
									<div class="block2-pic hov-img0">
										<img src="<?= media();?>/images/qryape.jpg" alt="Pago por yape" id="pagoyapeqr" style="width: 250px;">
									</div>
								</div>
							</div>

							
							<div class="col-sm-6 col-md-4 col-lg-12 p-b-35 isotope-item shoes" style="text-align: center;">
								<!-- Block2 -->
								<div class="block2">
									<div class="block2-pic hov-img0">
										<img src="<?= media();?>/images/qrplin.jpg" alt="Pago por plin" id="pagoplinqr" style="width: 250px;display:none;">
									</div>
									
								</div>
							</div>
						
						</div>



						<div id="showbtncomprar">
							<button type="button" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
								Confirmar pago
							</button>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php }else{ ?>
<br>
<div class="container">
	<p>No hay producto en el carrito <a href="<?= base_url() ?>/tienda"> Ver productos</a></p>
</div>
<br>
<?php 
	}
	footerTienda($data);
 ?>
	