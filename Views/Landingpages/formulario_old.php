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
          <form id="frmRegistrarFormularioDinamico">
            
          

            <div class="row">

                <div class="col-lg-6">

                    <div class="bs-component">
                        <div class="card mb-3 border-primary">
                            <div class="card-body">
                                <center><h3><small class="text-muted"> Tipo de campo: </small> Texto</h3></center>
                                <div class="form-group">
                                    <small class="form-text text-muted" id="emailHelp">Ejemplo del campo:</small>
                                    <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Ejm. Escribe algo aquí...">
                                </div>
                                <center><button class="btn btn-primary addinput" type="button" style="border-radius: 50%;"><i class="fas fa-plus" aria-hidden="true"></i></button></center>
                                <hr>

                                <div id="input_add">

                                    
                                    

                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="bs-component">
                        <div class="card mb-3 border-primary">
                            <div class="card-body">
                                <center><h3><small class="text-muted"> Tipo de campo: </small> Select</h3></center>
                                <div class="form-group">
                                    <small class="form-text text-muted" id="emailHelp">Ejemplo del campo:</small>
                                    <select class="form-control" id="exampleSelect1">
                                        <option>Selecciona algo aquí</option>
                                        <option>Opcion 01</option>
                                        <option>Opcion 02</option>
                                        <option>Opcion 03</option>
                                        <option>.</option>
                                        <option>.</option>
                                        <option>.</option>
                                    </select>
                                </div>
                                <center><button class="btn btn-info addselect" type="button" style="border-radius: 50%;"><i class="fas fa-plus" aria-hidden="true"></i></button></center>
                                <hr>

                                <div id="select_add">

                                        
                                




                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <center>
              <button class="btn btn-secondary" type="submit">Registrar</button>
            </center>


          </form>
        </div>
      </div>
    </div>
  </div>


</main>



<?php footerAdmin($data); ?>