<?php 
	$cantCarrito = 0;
	if(isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0){ 
		foreach($_SESSION['arrCarrito'] as $product) {
			$cantCarrito += $product['cantidad'];
		}
	}
	$tituloPreguntas = !empty(getInfoPage(PPREGUNTAS)) ? getInfoPage(PPREGUNTAS)['titulo'] : "";
	$infoPreguntas = !empty(getInfoPage(PPREGUNTAS)) ? getInfoPage(PPREGUNTAS)['contenido'] : "";
 ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title><?= $data['page_tag']; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <?php 
		$nombreSitio = NOMBRE_EMPESA;
		$descripcion = DESCRIPCION;
		$nombreProducto = NOMBRE_EMPESA;
		$urlWeb = base_url();
		$urlImg = media()."/images/portada.jpg";
		if(!empty($data['producto'])){
			//$descripcion = $data['producto']['descripcion'];
			$descripcion = DESCRIPCION;
			$nombreProducto = $data['producto']['nombre'];
			$urlWeb = base_url()."/tienda/producto/".$data['producto']['idproducto']."/".$data['producto']['ruta'];
			$urlImg = $data['producto']['images'][0]['url_image'];
		}
	?>
  <meta property="og:locale" content='es_ES' />
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?= $nombreSitio; ?>" />
  <meta property="og:description" content="<?= $descripcion; ?>" />
  <meta property="og:title" content="<?= $nombreProducto; ?>" />
  <meta property="og:url" content="<?= $urlWeb; ?>" />
  <meta property="og:image" content="<?= $urlImg; ?>" />

  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="<?= media() ?>/tienda/images/favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css"
    href="<?= media() ?>/tienda/fonts/iconic/css/material-design-iconic-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/fonts/linearicons-v1.0.0/icon-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/animsition/css/animsition.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/slick/slick.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/MagnificPopup/magnific-popup.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/perfect-scrollbar/perfect-scrollbar.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/css/sweetalert2.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/css/util.css">
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/tienda/css/coupon.css">
  <!--===============================================================================================-->
</head>


<body class="animsition" translate="no">

  <div id="all">
    <?php $arrProductos = $data['productos'];?>
    <img src="<?= media(); ?>/tienda/images/2.png" alt="logo" style="width: 100px;position: absolute">
    <div class="" style="    text-align: center;">
      <div class="container">
        <div class="p-b-5 p-t-0">
          <h3 class="stext-101 cl2 hov-cl1 trans-04" style="font-weight: bold;font-size: 30px;" id="btnCrearPdf">
            <?= $data['productos'][0]["titulo"] ?>
          </h3>
          <p class="stext-117 cl6">
            <?= $data['productos'][0]["descripcion"] ?>
          </p>
        </div>
        <div class="row isotope-grid" style="position: relative; height: 1944.5px;">
          <?php
            if(count($arrProductos) > 0 ){ 
              for ($p=0; $p < count($arrProductos); $p++) { 
                $ruta = $arrProductos[$p]['ruta'];
                if(count($arrProductos[$p]['images']) > 0 ){
                  $portada = $arrProductos[$p]['images'][0]['url_image'];
                }else{
                  $portada = media().'/images/uploads/product.png';
                }
          ?>
          <div class="col-sm-6 col-md-4 col-lg-4 isotope-item women" style="position: absolute; left: 0%; top: 0px;">
            <div class="block2">
              <div class="block2-pic hov-img0">
                <img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">
              </div>
              <div class="block2-txt flex-w flex-t p-t-14">
                <div class="block2-txt-child1 flex-col-l">
                  <a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta; ?>"
                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                    <b><?= $arrProductos[$p]['nombre'] ?></b>
                  </a>
                  <span class="stext-110 cl3" style="font-size:17px;">
                    <b><?= SMONEY.formatMoney($arrProductos[$p]['precio']); ?></b>
                  </span>
                </div>
                <div class="block2-txt-child2 flex-r p-t-3">
                  <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                    <img class="icon-heart1 dis-block trans-04" src="<?= media();?>/tienda/images/icons/icon-heart-01.png"
                      alt="ICON">
                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                      src="<?= media();?>/tienda/images/icons/icon-heart-02.png" alt="ICON">
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php }
              }else{
          ?>
          <p>No hay productos para mostrar <a href="<?= base_url() ?>/tienda"> Ver productos</a></p>
          <?php } ?>
        </div>
        <div class="flex-c-m flex-w w-full p-b-10 p-t-0">
          <button type="button" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
            Válido hasta: <?= $data['productos'][0]["fvigencia"] ?>
          </button>
        </div>
      </div>
    </div>
  </div>






  <script>


    /*
  ____          _____               _ _           _       
 |  _ \        |  __ \             (_) |         | |      
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___ 
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |        
        |___/                               |___/         
    
____________________________________
/ Si necesitas ayuda, contáctame en \
\ https://parzibyte.me               /
 ------------------------------------
        \   ^__^
         \  (oo)\_______
            (__)\       )\/\
                ||----w |
                ||     ||
Creado por Parzibyte (https://parzibyte.me). Este encabezado debe mantenerse intacto,
excepto si este es un proyecto de un estudiante.
*/
    document.addEventListener("DOMContentLoaded", () => {
      // Escuchamos el click del botón
      const $boton = document.querySelector("#btnCrearPdf");
      $boton.addEventListener("click", () => {
        const $elementoParaConvertir = document.querySelector("#all"); // <-- Aquí puedes elegir cualquier elemento del DOM
        // console.log($elementoParaConvertir);
        html2pdf()
          .set({
            margin: 1,
            filename: 'documento.pdf',
            image: {
              type: 'jpeg',
              quality: 0.98
            },
            html2canvas: {
              scale: 2, // A mayor escala, mejores gráficos, pero más peso
              letterRendering: true,
            },
            jsPDF: {
              unit: "in",
              format: "a3",
              orientation: 'portrait' // landscape o portrait
            }
          })
          .from($elementoParaConvertir)
          .save()
          .catch(err => console.log(err));
      });
    });
  </script>








































<?php 
		$catFotter = getCatFooter();
	 ?>
	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categorías
					</h4>
					<?php if(count($catFotter) > 0){ ?>
					<ul>
						<?php foreach ($catFotter as $cat) { ?>
						<li class="p-b-10">
							<a href="<?= base_url() ?>/tienda/categoria/<?= $cat['idcategoria'].'/'.$cat['ruta'] ?>" class="stext-107 cl7 hov-cl1 trans-04">
								<?= $cat['nombre'] ?>
							</a>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Cotacto
					</h4>

					<p class="stext-107 cl7 size-201">
						<?= DIRECCION ?> <br>
						Tel: <a class="linkFooter" href="tel:<?= TELEMPRESA ?>"><?= TELEMPRESA ?></a><br>
						Email: <a class="linkFooter" href="mailto:<?= EMAIL_EMPRESA ?>"><?= EMAIL_EMPRESA ?></a>
					</p>

					<div class="p-t-27">
						<a href="<?= FACEBOOK ?>" target="_blanck" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="<?= INSTAGRAM ?>" target="_blanck"  class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="https://wa.me/<?= WHATSAPP ?>" target="_blanck"  class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fab fa-whatsapp"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Suscríbete
					</h4>

					<form id="frmSuscripcion" name="frmSuscripcion">
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" id="nombreSuscripcion" name="nombreSuscripcion" placeholder="Nombre completo" required>
							<div class="focus-input1 trans-04"></div>
						</div>
						<br>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="email" id="emailSuscripcion" name="emailSuscripcion" placeholder="email@example.com" required >
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Suscribirme
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</footer>
	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>
	<script>
	    const base_url = "<?= base_url(); ?>";
		const smony = "<?= SMONEY; ?>";
	</script>
<!--===============================================================================================-->	
	<script src="<?= media() ?>/tienda/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/slick/slick.min.js"></script>
	<script src="<?= media() ?>/tienda/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/parallax100/parallax100.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/js/sweetalert2.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media();?>/js/fontawesome.js"></script>
	<script src="<?= media() ?>/tienda/js/main.js"></script>
	<script src="<?= media();?>/js/functions_admin.js"></script>
	<script src="<?= media() ?>/js/functions_login.js"></script>
	<script src="<?= media() ?>/tienda/js/functions.js"></script>
	<script src="<?= media() ?>/tienda/js/html2pdf.bundle.min.js"></script>

</body>
</html>