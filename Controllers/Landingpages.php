<?php 
		session_start();

class Landingpages extends Controllers{
	public function __construct()
	{
		parent::__construct();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MDLANDINGPAGES);
	}
    public function Landingpages()
    {
        if(empty($_SESSION['permisosMod']['r'])){
            header("Location:".base_url().'/dashboard');
        }
        $data['page_tag'] = "Landingpages";
        $data['page_title'] = "LANDING PAGES - <small>Tienda Virtual</small>";
        $data['page_name'] = "landingpages";
        $data['page_functions_js'] = "functions_landingpages.js";
        $this->views->getView($this,"landingpages",$data);
    }
    public function formulario($idlanding){
		if(!is_numeric($idlanding)){
			header("Location:".base_url().'/landingpages');
		}
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Forlmulario - Tienda Virtual";
		$data['page_title'] = "FORMULARIO DINÁMICO <small>Tienda Virtual</small>";
		$data['page_name'] = "formulario";
		$data['id_landing_add'] = openssl_encrypt($idlanding,METHODENCRIPT,KEY);
        $data['page_functions_js'] = "functions_formulariodinamico.js";
		// $data['arrPedido'] = $this->model->selectPedido($idlanding,$idpersona);
		$this->views->getView($this,"formulario",$data);
	}
	public function getLandingpages()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectLandingPage();
			for ($i=0; $i < count($arrData); $i++) {
				$btnProd = '';
				$btnForm = '';
				$btnEdit = '';
				$btnDelete = '';
				$enlace = '';

                if($arrData[$i]['formulario'] == NULL){
                    $arrData[$i]['formulario'] = '<span class="badge badge-pill badge-warning">Formulario pendiente</span>';
                    $btnForm .= '<a title="Formulario dinámicos" href="'.base_url().'/landingpages/formulario/'.$arrData[$i]['id_landing'].'" target="_blanck" class="btn btn-info btn-sm"> <i class="fas fa-plus"></i> </a>';

                }else{
                    $arrData[$i]['formulario'] = '<span class="badge badge-pill badge-success">Formulario registrado</span>';
                    $btnForm .= '<a title="Formulario dinámicos" href="#" disabled class="btn btn-info btn-sm"> <i class="fas fa-plus"></i> </a>';

                }
				
				// $arrData[$i]['ruta'] = base_url()+"/landing/bijou/"+openssl_encrypt($arrData[$i]['id_landing'],METHODENCRIPT,KEY);

				$btnProd .= '<button class="btn btn-primary  btn-sm" onClick="fnVerRegistrarProductos('.$arrData[$i]['id_landing'].')" title="Agregar productos"><i class="fas fa-archive"></i></button>';
		
                

				
                
                
                $btnEdit .= '<button class="btn btn-warning  btn-sm" onClick="fntEditLandingPages(this,'.$arrData[$i]['id_landing'].')" title="Editar landing"><i class="fas fa-pencil-alt"></i></button>';
				$btnDelete .= '<button class="btn btn-danger btn-sm" onClick="fntEliminarLandingPages('.$arrData[$i]['id_landing'].')" title="Eliminar descuento por producto"><i class="far fa-trash-alt"></i></button>';
				
				$arrData[$i]['options'] = '<div class="text-center">'.$btnProd.' '.$btnForm.' '.$btnEdit.' '.$btnDelete.'</div>';

				// $enlace = base_url().'/landing/bijou/'.openssl_encrypt($arrData[$i]['id_landing'],METHODENCRIPT,KEY);
				// $enlace .= '<a href="'.base_url().'/landing/bijou/'.openssl_encrypt($arrData[$i]['id_landing'],METHODENCRIPT,KEY).'" target="_blank">'.base_url().'/landing/bijou/'.openssl_encrypt($arrData[$i]['id_landing'],METHODENCRIPT,KEY).'</a>';
				$enlace .= '<a href="'.base_url().'/landing/bijou/'.base64_encode($arrData[$i]['id_landing']).'" target="_blank">'.base_url().'/landing/bijou/'.base64_encode($arrData[$i]['id_landing']).'</a>';

				

				$arrData[$i]['ruta'] = $enlace;

             
                
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function setLandingpage(){
        // dep($_POST); exit();
        if($_POST){
            if(empty($_POST['txtTituloFormulario']) || empty($_POST['txtSubtituloForm']) || empty($_POST['txtTituloDescripcion']) || empty($_POST['txtSubtituloDescripcion']) || empty($_POST['txtDescripcion']) )
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{
                $idlandingpage = intval($_POST['idLandingpage']);
                $tituloformulario = strClean($_POST['txtTituloFormulario']);
                $subtituloformulario = strClean($_POST['txtSubtituloForm']);
                $titulodescripcion =  strClean($_POST['txtTituloDescripcion']);
                $subtitulodescripcion = strClean($_POST['txtSubtituloDescripcion']);
                $descripcion = strClean($_POST['txtDescripcion']);

                //foto portada principal
                $foto   	 	= $_FILES['foto'];
                $nombre_foto 	= $foto['name'];
                $type 		 	= $foto['type'];
                $url_temp    	= $foto['tmp_name'];
                $imgPortada 	= 'portada_categoria.png';
                $request_cateria = "";
                if($nombre_foto != ''){
                    $imgPortada = 'ld_port'.md5(date('d-m-Y H:i:s')).'.jpg';
                }

                // Foto01 y 02
                $foto1   	 	= $_FILES['img1'];
                $nombre_foto1 	= $foto1['name'];
                $type1 		 	= $foto1['type'];
                $url_temp1   	= $foto1['tmp_name'];
                $imgPortada1 	= 'portada_categoria.png';
                $request_cateria = "";
                if($nombre_foto1 != ''){
                    $imgPortada1 = 'ld_des'.md5(date('d-m-Y i:H:s')).'.jpg';
                }
                $foto2   	 	= $_FILES['img2'];
                $nombre_foto2 	= $foto2['name'];
                $type2 		 	= $foto2['type'];
                $url_temp2   	= $foto2['tmp_name'];
                $imgPortada2 	= 'portada_categoria.png';
                $request_cateria = "";
                if($nombre_foto2 != ''){
                    $imgPortada2 = 'ld_desdes'.md5(date('d-m-Y s:i:H')).'.jpg';
                }

                if($idlandingpage == 0)
                {
                    //Crear
                    if($_SESSION['permisosMod']['w']){
                        $request_cateria = $this->model->inserLanding($tituloformulario,$subtituloformulario,$imgPortada, $subtitulodescripcion,$titulodescripcion,$descripcion,$imgPortada2,$imgPortada1);
                        $option = 1;
                    }
                }else{
                    //Actualizar
                    if($_SESSION['permisosMod']['u']){
                        if($nombre_foto == ''){
                            if($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0 ){
                                $imgPortada = $_POST['foto_actual'];
                            }
                        }

                        if($nombre_foto1 == ''){
                                $imgPortada1 = $_POST['foto_imagen01'];
                        }

                        if($nombre_foto2 == ''){
                                $imgPortada2 = $_POST['foto_imagen02'];
                        }

                        $request_cateria = $this->model->updateLanding($idlandingpage,$tituloformulario,$subtituloformulario,$imgPortada, $subtitulodescripcion,$titulodescripcion,$descripcion,$imgPortada2,$imgPortada1);
                        $option = 2;
                    }
                }
                if($request_cateria > 0 )
                {
                    if($option == 1)
                    {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
                        if($nombre_foto1 != ''){ uploadImage($foto1,$imgPortada1); }
                        if($nombre_foto2 != ''){ uploadImage($foto2,$imgPortada2); }
                    }else{
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                        if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
                        if($nombre_foto1 != ''){ uploadImage($foto1,$imgPortada1); }
                        if($nombre_foto2 != ''){ uploadImage($foto2,$imgPortada2); }

                        if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png')
                            || ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')){
                            deleteFile($_POST['foto_actual']);
                        }
                    }
                }
                
                else{
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
	public function getLandingpagesProductos($idprod)
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectLandingPageProd($idprod);
			for ($i=0; $i < count($arrData); $i++) {
				$btnDelete = '';

				$arrData[$i]['precio'] = $arrData[$i]['precio'];
				$arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelProdLanding('.$arrData[$i]['prod_lan_id'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function setRegistrarproductolanding(){
		if($_POST){			
			if(empty($_POST['idproducto']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idlanding = intval($_POST['idlanding']);
				$idproducto = intval($_POST['idproducto']);
				$idlandingeditar = intval($_POST['idlandingeditar']);
				$request_user = "";

				if($idlandingeditar == 0)
				{
					$option = 1;
					if($_SESSION['permisosMod']['w']){
						$request_user = $this->model->insertProductoLanding($idproducto,
																			$idlanding);
					}
				}else{
					$option = 2;
					if($_SESSION['permisosMod']['u']){
						$request_user = $this->model->insertProductoLanding($idproducto,
																			$idlanding,
																			$idlandingeditar);
					}

				}

				if($request_user > 0 )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == 'existtipopuntos'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! ya se segistró este producto.');		
				}
				else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
    public function delProdLand()
    {
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $intIdProdLand = intval($_POST['idLandProd']);
                $requestDelete = $this->model->deleteProductoLanding($intIdProdLand);
                if($requestDelete)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    public function setAddFormularioDinamico(){
        // dep($_POST); exit();
        
        
		if($_POST){
            if(empty($_POST['registro']))
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{
                $idlanding = openssl_decrypt($_POST['id_landingpage'], METHODENCRIPT, KEY);
                // $registro = $_POST['registro'];
                $registro = json_decode($_POST['registro']);
                $saveregistro = json_encode($registro);
                // var_dump($saveregistro);
                // exit();
                
                if($idlanding != "")
                {
                    $requestAddForm = $this->model->insertAddFormularioLanding($idlanding,$saveregistro);
                    if($requestAddForm > 0 )
                    {
                        $arrResponse = array('status' => true, 'msg' => 'Formulario registrado.');
                    }else if($requestAddForm == 'noexist'){
                        $arrResponse = array('status' => false, 'msg' => 'No es posible registrar.');		
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible registrar.');
                    }
                }
            }
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
		die();
	}
    public function delLandingPage__all()
    {
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $idLand = intval($_POST['idLand']);
                $requestDelete = $this->model->deleteLP($idLand);
                if($requestDelete == "deleted")
                {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el descuento');
                }else if($requestDelete == "nodeleted"){
                    $arrResponse = array('status' => false, 'msg' => 'Hay productos asociados a este landing. Eliminalos primero.');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el descuento.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getLanding($idLanding){
		if($_SESSION['permisosMod']['r']){
			$landingId = intval($idLanding);
			if($landingId > 0)
			{
				$arrData = $this->model->selectLanding($landingId);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
                    $arrData['rutaimagenprincipal'] = media().'/images/uploads/'.$arrData['rutaimagenprincipal'];
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}


}




?>