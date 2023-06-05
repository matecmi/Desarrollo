<?php 
    headerAdmin($data); 
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>


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

          <div class="row">

            <div class="col-lg-9">
              <div class="form-group">
                <select class="form-control" id="landing">
                  <option disabled selected>Selecciona landing</option>
                  <?php if(!empty($data['landing'])){  

                      foreach ($data['landing'] as $valor) {
                        var_dump($valor);
                      ?>
                  <option value="<?= $valor["id_landing"]; ?>"><?= $valor["tituloform"]; ?></option>
                  <?php }} ?>

                </select>
              </div>
            </div>

            <div class="col-lg-3">
              <button class="btn btn-primary" type="button" onclick="frmShowRegister()">Ver reporte</button>
            </div>


          </div>


         
          <div id="porcionDinamica">

          </div>
















        </div>
      </div>
    </div>
  </div>
</main>
<?php footerAdmin($data); ?>