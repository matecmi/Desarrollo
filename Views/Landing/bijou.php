<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- ===============================================-->
  <!--    Document Title-->
  <!-- ===============================================-->
  <title><?= $data['page_title'] ?></title>


  <!-- ===============================================-->
  <!--    Favicons-->
  <!-- ===============================================-->
  <link rel="icon" type="image/png" sizes="32x32" href="<?= media(); ?>/tienda/images/logo2.png">
  <link rel="manifest" href="<?= media(); ?>/landing/assets/img/favicons/manifest.json">
  <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
  <meta name="theme-color" content="#ffffff">


  <!-- ===============================================-->
  <!--    Stylesheets-->
  <!-- ===============================================-->
  <link href="<?= media(); ?>/landing/assets/css/theme.css" rel="stylesheet" />

</head>

<?php




?>



<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main divLoading" id="top">
    <img style="position: absolute;top: 10px;" class="d-inline-block" src="<?= media();?>/tienda/images/logo2.png"
      width="135" alt="logo" />
    <section class="">
      <div class="bg-holder w-50 bg-right d-none d-lg-block"
        style="background-image:url(<?= media();?>/images/uploads/<?= $data['respuestas_landing']["portadaprincipal"]; ?>);background-size: contain;background-position: right;">
      </div>
      <!--/.bg-holder-->

      <div class="container">
        <div class="row">
          <div class="col-lg-6 py-xxl-7">
            <h1 class="display-3 text-1000 fw-normal"><?= $data['respuestas_landing']["tituloform"]; ?></h1>
            <h1 class="display-3 text-primary fw-bold"><?= $data['respuestas_landing']["subtituloform"]; ?></h1>
            <div>
              <nav>
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form class="row g-4 mt-5" id="addRegisterForm" method="post">
                      <input type="hidden" id="landing" name="landing" value="<?= $data['id'] ?>">

                        <?php if ($data['respuestas_landing']["formulario"] != NULL) { 
                          $arr = json_decode($data['respuestas_landing']["formulario"], true);
                        ?>
                    
                      <?php
                        $continput = 0;
                        foreach ($arr["array_data"]["rpta"] as $inpt) {

                          $continput++;
                      ?>
                    <div class="col-sm-6 col-md-12 col-xl-10">
                        <div class="input-group-icon">
                          <input class="form-control input-box form-voyage-control" id="input__<?= $continput ?>" name="input__<?= $continput ?>" type="text" placeholder="<?= $inpt ?>" /><span class="nav-link-icon text-800 fs--1 input-box-icon"><i class="fas fa-check"></i></span>
                        </div>
                      </div>
                      <?php } ?>


                      <?php
                      $contselect = 0;
                      foreach ($arr["array_select"]["rpta"] as $select) {
                        $contselect++;
                      ?>

                         <div class="col-sm-6 col-md-12 col-xl-10">
                            <div class="input-group-icon">
                              <select class="form-select form-voyage-select input-box" id="select__<?= $continput ?>" name="select__<?= $continput ?>">
                                <option selected="selected" disabled><?= $select["nombreinput"] ?></option>
                                <?php
                                foreach ($select["valorintput"] as $options) {
                                ?>
                                <option><?= $options ?></option>
                                <?php 
                                  }
                                ?>
                              </select><span class="nav-link-icon text-800 fs--1 input-box-icon"><i
                                  class="fas fas fa-check">
                                </i></span>
                            </div>
                          </div>


                      <?php 
                      }
                     ?>

                    
                     


                    <?php } ?>
                      
                    <div class="col-sm-6 col-md-12 col-xl-10 msj">
                    </div>



                      <div class="col-12 col-xl-10 col-lg-12 d-grid mt-3">
                        <button class="btn btn-secondary" type="submit">Registrarme</button>
                      </div>


                    </form>
                  </div>

                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>



    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-7" id="activities">

      <div class="container">
        <div class="row g-0">
          <div class="col-lg-4 order-1"><img class="w-100 mt-5 mt-lg-0"
              src="<?= media();?>/images/uploads/<?= $data['respuestas_landing']["imagin1desc"]; ?>" style="height: auto;"
              alt="..." />
          </div>
          <div class="col-lg-8">
            <div class="carousel slide" id="carouselActivity" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                  <div class="row h-100">
                    <div class="col-12"><img class="w-100"
                        src="<?= media();?>/images/uploads/<?= $data['respuestas_landing']["imagin2desc"]; ?>"
                        width="383" alt="..." />
                      <div class="py-4">
                        <h4 class="mb-2 text-1000"><?= $data['respuestas_landing']["titulodes"]; ?></h4>
                        <h2 class="mb-3 text-primary fs-3 fs-md-6"><?= $data['respuestas_landing']["subtitulodesc"]; ?>
                        </h2>
                        <p class="fw-normal mb-0 pe-lg-7" style="text-align: justify;"><?= $data['respuestas_landing']["descripcionlanding"]; ?></p>
                      </div>
                    </div>
                  </div>
                </div>



              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <section class="py-prueba" id="testimonial">
      <div class="container">
        <div class="row h-100">
          <div class="col-lg-7 mx-auto text-center mb-1">
            <?php
              $arrProductos=$data['productosLanding'];
              if(!empty($arrProductos)){
            ?>
            <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3">Productos</h5>
            <?php
              }
            ?>
          </div>
          <div class="col-12">

            <div class="row align-items-center g-2">


              <?php 
          $arrProductos=$data['productosLanding'];
					if(!empty($arrProductos)){
						for ($p=0; $p < count($arrProductos); $p++) { 
                            


				 ?>
              
                <div class="col-md-4 mb-3 mb-md-0 h-100">
                  <a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$arrProductos[$p]['ruta']; ?>" target="_blank">
                    <div class="card card-span h-100 text-white">
                      <img class="img-fluid h-100" src="<?= media();?>/images/uploads/<?= $arrProductos[$p]['images'] ?>" alt="..." />
                      <div class="card-body ps-0">
                        <h5 class="fw-bold text-1000 mb-2 text-truncate">
                        <?= $arrProductos[$p]['producto'] ?>
                        </h5>
                        <h1 class="mb-3 text-primary fw-bolder fs-4">
                          <span>S/<?= $arrProductos[$p]['precio'] ?></span>
                        </h1>
                      
                      </div>
                    </div>
                  </a>
                </div>

              <?php 
						}
					}	
				 ?>

            </div>



          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="bg-holder"
        style="background-image:url(<?= media();?>/landing/assets/img/gallery/cta-bg.png);background-position:center;background-size:cover;">
      </div>
      <!--/.bg-holder-->

      <div class="container">
        <div class="row flex-center">
          <div class="col-lg-6 text-center"><img class="mb-5 mb-lg-0"
              src="<?= media();?>/landing/assets/img/gallery/aaaaaaa.png" alt="..."></div>
          <div class="col-lg-6 text-center">
            <h4 class="fs-2 pe-xxl-10">Visitanos en:</h4>
            <a href="https://bmbijou.com/"><h1 class="fs-4 pe-xxl-10">www.bmbijou.com</h1></a>
          </div>
        </div>
      </div>
    </section>
    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0 overflow-hidden">

      <div class="container">
        <div class="row">
          <div class="col-6 col-sm-4 col-lg-6">
            <div class="py-7"><img class="d-inline-block" src="<?= media();?>/tienda/images/2.png" width="180"
                alt="logo" />
            </div>
          </div>
          <div class="col-6 col-8 col-lg-6 bg-primary-gradient bg-offcanvas-right">
            <div class="p-3 py-7 p-md-7">
              <p class="text-light"><i class="fas fa-phone-alt me-3"></i><span
                  class="text-light"><?= TELEMPRESA ?></span></p>
              <p class="text-light"><i class="fas fa-envelope me-3"></i><span
                  class="text-light"><?= EMAIL_EMPRESA ?></span></p>
              <p class="text-light"><i class="fas fa-map-marker-alt me-3"></i><span class="text-light lh-lg">Piura -
                  Perú
                  America</span></p>
              <div class="mt-6"><a href="<?= FACEBOOK ?>"> <img class="me-3"
                    src="<?= media();?>/landing/assets/img/icons/facebook.svg" alt="..." /></a><a href="<?= INSTAGRAM ?>">
                  <img class="me-3" src="<?= media();?>/landing/assets/img/icons/instagram.svg" alt="..." /></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->

  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->




  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
	<script>
	    const base_url = "<?= base_url(); ?>";
		const smony = "<?= SMONEY; ?>";
	</script>
  <script src="<?= media(); ?>/landing/vendors/@popperjs/popper.min.js"></script>
  <script src="<?= media(); ?>/landing/vendors/bootstrap/bootstrap.min.js"></script>
  <script src="<?= media(); ?>/landing/vendors/is/is.min.js"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="<?= media(); ?>/landing/vendors/fontawesome/all.min.js"></script>
  <script src="<?= media();?>/landing/assets/js/theme.js"></script>
  <script src="<?= media();?>/landing/assets/js/registers.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700&amp;display=swap"
    rel="stylesheet">
</body>

</html>