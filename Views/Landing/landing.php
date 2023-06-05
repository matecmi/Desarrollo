<?php 
headerTienda($data);
?>
<br><br><br>
<hr>
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('<?= media();?>/images/iglanding.jpg');background-size: contain;">
    <h2 class="ltext-105 cl0 txt-left">
        Landing pages
    </h2>
</section>


<?php

// var_dump($data['infoLandingAll']);

?>


<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">

            <?php
                foreach ($data['infoLandingAll'] as $landing) {

            ?>

            <div class="col-md-6 col-lg-4 p-b-80">
                <div class="">
                    <div class="p-b-63">
                        <a href="<?= base_url();?>/landing/bijou/<?= base64_encode($landing['id_landing']);?>" target="_blank" class="hov-img0 how-pos5-parent">
                            <img src="<?= media();?>/images/uploads/<?= $landing["portadaprincipal"];?>" alt="IMG-BLOG">
<!-- 
                            <div class="flex-col-c-m size-123 bg9 how-pos5">
                                <span class="ltext-107 cl2 txt-center">
                                    22
                                </span>
                                <span class="stext-109 cl3 txt-center">
                                    Jan 2018
                                </span>
                            </div> -->
                        </a>


                        <p class="stext-117 cl6 mt-4">
                            <?= $landing["titulodes"];?>
                        </p>
                        <div class="flex-w flex-sb-m">
                            <a href="<?= base_url();?>/landing/bijou/<?= base64_encode($landing['id_landing']);?>" target="_blank" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                Me interesa

                                <i class="fa fa-long-arrow-right m-l-9"></i>
                            </a>
                        </div>
                    </div>


                </div>
            </div>
          


           

            <?php
                }
            ?>








































            </div>


        </div>
</section>




<?php 
	footerTienda($data);
?> 