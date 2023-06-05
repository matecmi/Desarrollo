<?php 
		session_start();

class Catalogos extends Controllers{
	public function __construct()
	{
		parent::__construct();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MDCATALOGOS);
	}
    public function Catalogos()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Catálogos";
		$data['page_title'] = "CATÁLOGOS <small>Tienda Virtual</small>";
		$data['page_name'] = "catalogos";
		$data['page_functions_js'] = "functions_Catalogos.js";
		$this->views->getView($this,"catalogos",$data);
	}
    public function getCatalogos()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectCatalogos();
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnProd = '';
				$btnEdit = '';
				$btnDelete = '';















				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['id_catalogo'].')" title="Editar catálogo"><i class="fas fa-pencil-alt"></i></button>';
					
					
	// $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntGeneratePDF('.$arrData[$i]['id_catalogo'].')" title="Generar catálogo"><i class="fa fa-file-pdf-o"></i></button>';

$btnView = '<a class="btn btn-secondary btn-sm" href="'.base_url().'/catalogo/bijou/'.base64_encode($arrData[$i]['id_catalogo']).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';


					
					
					
					$btnProd = '<button class="btn btn-info btn-sm" onClick="fntAddProd('.$arrData[$i]['id_catalogo'].')" title="Agregar productos"><i class="fas fa-archive"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['id_catalogo'].')" title="Eliminar catálogo"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnProd.' '.$btnEdit.' '.$btnView.'  '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}


	public function setCatalogos(){
		// dep($_POST); exit();



		if($_POST){
			if(empty($_POST['txtTituloCatalogo']) || empty($_POST['datFecha']) )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idCatalogo = intval($_POST['idCatalogoadd']);
				$strTitulo = strClean($_POST['txtTituloCatalogo']);
				$strDescripcion = strClean($_POST['txtDescripcionCatalogo']);
				$strFechaVigencia = strClean($_POST['datFecha']);
				$request_user = "";
				if($idCatalogo == 0)
				{

					$option = 1;
					if($_SESSION['permisosMod']['w']){
						$request_user = $this->model->insertCatalogo($strTitulo,
																	$strDescripcion, 
																	$strFechaVigencia);
					}
				}else{

					$option = 2;
					if($_SESSION['permisosMod']['u']){
						$request_user = $this->model->updateCatalogo($idCatalogo,
																	$strTitulo, 
																	$strDescripcion,
																	$strFechaVigencia);
					}
				}

				if($request_user > 0 )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == "noexist"){
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getCatalogo($idCata){
		if($_SESSION['permisosMod']['r']){
			$idcata = intval($idCata);
			if($idcata > 0)
			{
				$arrData = $this->model->selectCatalogo($idcata);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}



	public function getCatalogoProductos($idcatprod)
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectCatalogoProd($idcatprod);
			for ($i=0; $i < count($arrData); $i++) {
				$btnDelete = '';

				$arrData[$i]['precio'] = $arrData[$i]['precio'];
				$arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelProdLanding('.$arrData[$i]['id_catalogo_productos'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}


	public function delCatProd()
    {
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $intIdCatProd = intval($_POST['idCatProd']);
                $requestDelete = $this->model->deleteCatalogoProducto($intIdCatProd);
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


	public function setRegistrarcatalogoproductos(){
		// dep($_POST); exit();


		if($_POST){
			if(empty($_POST['idproducto']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idCatalogo = intval($_POST['idCatalogo']);
				$idproducto = intval($_POST['idproducto']);
				$request_user = "";
				

				if($_SESSION['permisosMod']['w']){
					$request_user = $this->model->insertCatalogoProducto($idCatalogo,
																		$idproducto);
				

				if($request_user > 0 )
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else if($request_user == 'existtipopuntos'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! ya se segistró este producto.');		
				}
				else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();



	}

	public function delCatalogo__all()
    {
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $idcat = intval($_POST['idcat']);
                $requestDelete = $this->model->deleteCat($idcat);
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
}



?>