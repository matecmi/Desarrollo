<?php
			session_start();

	class Envios extends Controllers{
		public function __construct()
		{
			parent::__construct();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MDPRECIOENVIOS);
		}
        public function Envios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Envios";
			$data['page_title'] = "Envios <small>Tienda Virtual</small>";
			$data['page_name'] = "envios";
			$data['page_functions_js'] = "functions_envios.js";
			$this->views->getView($this,"envios",$data);
		}
		public function getEnvios()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectEnvios();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
                    $arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewEnvios('.$arrData[$i]['id_envios'].')" title="Ver Envios"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditEnvios(this,'.$arrData[$i]['id_envios'].')" title="Editar Envios"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelEnvios('.$arrData[$i]['id_envios'].')" title="Eliminar Envios"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function delEnvio()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdenvio = intval($_POST['idEnvio']);
					$requestDelete = $this->model->deleteEnvio($intIdenvio);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el precio de envío');
					}
					// else if($requestDelete == 'exist'){
					// 	$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar el precio de envío con productos asociados.');
					// }
					else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el precio de envío.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function setEnvio(){
			// dep($_POST); exit();
			if($_POST){			
				if(empty($_POST['txtDestino']) || empty($_POST['txtPrecioEnvio']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Hay campos obligatorios.');
				}else{ 
					$idEnvios = intval($_POST['idEnvios']);
					$strDestino = strClean($_POST['txtDestino']);
					$intPrecio = ucwords(strClean($_POST['txtPrecioEnvio']));
					$intStatus = intval(strClean($_POST['listStatus']));
					$request_envio = "";
					if($idEnvios == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_envio = $this->model->insertEnvio($strDestino,
																		$intPrecio, 
																		$intStatus );
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_envio = $this->model->updateEnvio($idEnvios,
																		$strDestino, 
																		$intPrecio,
																		$intStatus, 
																		$intStatus);
						}

					}

					if($request_envio > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_envio == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el destino ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getEnvio($idenvio){
			if($_SESSION['permisosMod']['r']){
				$idenvios = intval($idenvio);
				if($idenvios > 0)
				{
					$arrData = $this->model->selectEnvio($idenvios);
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
		public function getUbiDepartamento()
		{
			
			$arrData = $this->model->selectUbiDepartamento();
			if(empty($arrData))
			{
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);	
		}
		public function getUbiProvincia($iddepa)
		{
			$depaid = intval($iddepa);
			$arrData = $this->model->selectUbiProvincia($depaid);
			if(empty($arrData))
			{
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);	
		}
		public function getUbiDistrito($idprov)
		{
			$provid = intval($idprov);
			$arrData = $this->model->selectUbiDistrito($provid);
			if(empty($arrData))
			{
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);	
		}
    }


?>