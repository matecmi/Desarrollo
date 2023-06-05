<?php 
		session_start();

require_once("Models/TTipoPago.php");
class Clientes extends Controllers{
	use TTipoPago;
	public function __construct()
	{
		parent::__construct();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MCLIENTES);
	}

	public function Clientes()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Clientes";
		$data['page_title'] = "CLIENTES <small>Tienda Virtual</small>";
		$data['page_name'] = "clientes";
		$data['page_functions_js'] = "functions_clientes.js";
		$this->views->getView($this,"clientes",$data);
	}
	public function setCliente_old(){
		dep($_POST); exit();
		error_reporting(0);
		if($_POST){
			if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idUsuario = intval($_POST['idUsuario']);
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strApellido = ucwords(strClean($_POST['txtApellido']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmail']));
				$strNit = strClean($_POST['txtNit']);
				$strNomFiscal = strClean($_POST['txtNombreFiscal']);
				$strDirFiscal = strClean($_POST['txtDirFiscal']);
				$intTipoId = 7;
				$request_user = "";
				if($idUsuario == 0)
				{
					$option = 1;
					$strPassword =  empty($_POST['txtPassword']) ? passGenerator() : $_POST['txtPassword'];
					$strPasswordEncript = hash("SHA256",$strPassword);
					if($_SESSION['permisosMod']['w']){
						$request_user = $this->model->insertCliente($strIdentificacion,
																			$strNombre, 
																			$strApellido, 
																			$intTelefono, 
																			$strEmail,
																			$strPasswordEncript,
																			$intTipoId, 
																			$strNit,
																			$strNomFiscal,
																			$strDirFiscal );
					}
				}else{
					$option = 2;
					$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
					if($_SESSION['permisosMod']['u']){
						$request_user = $this->model->updateCliente($idUsuario,
																	$strIdentificacion, 
																	$strNombre,
																	$strApellido, 
																	$intTelefono, 
																	$strEmail,
																	$strPassword, 
																	$strNit,
																	$strNomFiscal, 
																	$strDirFiscal);
					}
				}

				if($request_user > 0 )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						$nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'asunto' => 'Bienvenido a tu tienda en línea');
						sendEmail($dataUsuario,'email_bienvenida');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function setCliente(){
		// dep($_POST); exit();
		if($_POST){
			if(empty($_POST['txtDniC']) || empty($_POST['txtNombreC']) || empty($_POST['txtCelularC']) || empty($_POST['txtDireccionC']) || empty($_POST['txtEmailC']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idUsuario = intval($_POST['idclienterg']);
				$intDni = strClean($_POST['txtDniC']);
				$strNombre = strClean($_POST['txtNombreC']);
				$strCelular = strClean($_POST['txtCelularC']);
				$strDireccion = strClean($_POST['txtDireccionC']);
				$strEmail = strClean($_POST['txtEmailC']);

				$request_user = "";
				if($idUsuario == 0)
				{
					$option = 1;
					if($_SESSION['permisosMod']['w']){
						$request_user = $this->model->insertCliente($intDni,
																	$strNombre, 
																	$strCelular, 
																	$strDireccion, 
																	$strEmail);
					}
				}else{
					$option = 2;
					if($_SESSION['permisosMod']['u']){
						$request_user = $this->model->updateCliente($idUsuario,
																	$intDni,
																	$strNombre, 
																	$strCelular, 
																	$strDireccion, 
																	$strEmail);
					}
				}

				if($request_user > 0 )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						// $dataUsuario = array('nombreUsuario' => $strNombre,
						// 					'email' => $strEmail,
						// 					// 'password' => $strPassword,
						// 					'asunto' => 'Gracias por formar parte de bmbijou =D');
						// sendEmail($dataUsuario,'email_bienvenida');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == 'existdni'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el dni ya existe, ingrese otro.');		
				}else if($request_user == 'existemail'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el correo ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function getClientes()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectClientes();
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idpersona'].')" title="Ver cliente"><i class="far fa-eye"></i></button>';
				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idpersona'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idpersona'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function getClientesUsuarios()
	{

		$contador = 0;
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectClientesUsuarios();
			for ($i=0; $i < count($arrData); $i++) {
				$contador++;
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				
				$arrData[$i]['cont'] = $contador;
				if($_SESSION['permisosMod']['r']){
					$btnView = '<a href="'.base_url().'/Clientes/detalles/'.$arrData[$i]['id_cliente'].'" class="btn btn-info btn-sm" title="Ver Detalle"><i class="far fa-eye"></i></a>';
				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['id_cliente'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['id_cliente'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function detalles($id_cliente){
		if(!is_numeric($id_cliente)){
			header("Location:".base_url().'/pedidos');
		}
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$idpersona = "";
		if( $_SESSION['userData']['idrol'] == RCLIENTES ){
			$idpersona = $_SESSION['userData']['idpersona'];
		}
		
		$data['page_tag'] = "Historial de peridos - Tienda Virtual";
		$data['page_title'] = "Historial de pedidos - <small>Tienda Virtual</small>";
		$data['page_name'] = "detalles";
		$data['arrPedidoAll'] = $this->model->selectPedidoAll($id_cliente,$idpersona);
		$data['page_functions_js'] = "functions_clientes_detalle.js";
		$this->views->getView($this,"detalles",$data);
	}


	public function getCliente($idpersona){
		if($_SESSION['permisosMod']['r']){
			$idusuario = intval($idpersona);
			if($idusuario > 0)
			{
				$arrData = $this->model->selectCliente($idusuario);
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
	public function delCliente()
	{
		if($_POST){
			if($_SESSION['permisosMod']['d']){
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteCliente($intIdpersona);
				if($requestDelete > 0)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente');
				}else if($requestDelete == "exist"){
					
					$arrResponse = array('status' => false, 'msg' => 'Hay otros registros asociados a este cliente');

				} else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al cliente.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
	
    public function getClienteNombre(){
        // dep($_POST); exit();

        if($_POST){
				$dni = $_POST['dni'];
                $campo = "dni";
				$request_cliente = $this->model->buscarCliente($dni,$campo);
                if(empty($request_cliente))
                {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else{
                    $arrResponse = array('status' => true, 'data' => $request_cliente);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);


        }
       
    }

    public function procesarDatosCliente(){
        // dep($_POST); exit();

        if(!empty($_SESSION['dataorden'])){

            if($_POST){
                
                $tiporegistro = $_POST['tipo_registro_usuario'];
                $dni = $_POST['dni'];
                $adicional = $_POST['adicional'];
                $numpedido = $_POST['numorden'];
                $tipoPago = $_POST['inttipopago'];
                $rolid = 1;
                $estado_registro = $_POST['estado_registro'];


                if($tiporegistro == "exist"){ //Actualizar
                    $idClienteRegistrado = $_POST['idclienteregistrado'];
                    $nombre = $_POST['nombreobtenido'];
                    if(!empty($idClienteRegistrado)){

                        $det = $this->model->updateClientePedido($idClienteRegistrado,$numpedido,$tipoPago);
                            if($det > 0){
                                $arrResponse = array("status" => true, 
                                                    'orden' => $numpedido,
                                                    'nombreSuscriptor' => $nombre,
                                                    'idClnt' => $idClienteRegistrado,
                                                    "msg" => 'Cliente registrado.'
                                            );
                                $_SESSION['dataordenconfirm'] = $arrResponse;
                                unset($_SESSION['dataorden']);
                                // session_regenerate_id(true);
                            }else{
                                $arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
                            }
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
                    }

                }else if($tiporegistro == "new"){
                            $nombre = $_POST['nombre'];
                            $celular = $_POST['celular'];
                            $direccion = $_POST['direccion'];
                            $ciudad = $_POST['ciudad'];
                            $correo = $_POST['correo'];

                            $request_clientes = $this->model->insertCliente($dni, 
                                                                            $nombre,
                                                                            $celular,
                                                                            $direccion,
                                                                            $ciudad,
                                                                            $rolid,
                                                                            $adicional,
                                                                            $correo);

                            //ENVIAR CORREO ====


                            if($request_clientes > 0 ){

                                $det = $this->model->updateClientePedido($request_clientes,$numpedido,$tipoPago);
                                if($det > 0){
                                    $arrResponse = array("status" => true, 
                                                'orden' => $numpedido,
                                                'nombreSuscriptor' => $nombre,
                                                "msg" => 'Cliente registrado.'
                                        );
                                    $_SESSION['dataordenconfirm'] = $arrResponse;
                                    unset($_SESSION['dataorden']);
                                    // session_regenerate_id(true);
                                }else{
                                    $arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
                                }
                            }else if($request_clientes == "exist"){
                                $arrResponse = array("status" => false, "msg" => 'El usuario ya está registrado.');
                            }
                            
                            else{

                                $arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');

                            }	
                            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            die();
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
                    }


                    

            }

        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
        

    }

	//REFERIDOS

	public function getSelectClientesReferidos()
	{
		$htmlOptions = "";
		$arrData = $this->model->selectReferidosCliente();
		if(count($arrData) > 0 ){
			$htmlOptions .= '<option disabled="" selected="" value="">Seleccionar</option>';
			for ($i=0; $i < count($arrData); $i++) { 
				if($arrData[$i]['status'] == 1 ){
				$htmlOptions .= '<option value="'.$arrData[$i]['id_cliente'].'">'.$arrData[$i]['nombre'].'</option>';
				}
			}
		}else{
			$htmlOptions .= '<option disabled="" selected="" value="">No hay registros</option>';
		}
		echo $htmlOptions;
		die();		
	}

	public function getReferidosClientes($idclt)
	{
			$arrData = $this->model->selectRefClient($idclt);
			if($arrData > 0){
				for ($i=0; $i < count($arrData); $i++) {

					$btnDelete = '';

					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelProdLanding('.$arrData[$i]['id_referidos'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnDelete.'</div>';

					
					$arrResponse = array("status" => true, "msg" => 'Hay registros.',"data" => $arrData);
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'No hay registros.');
				
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		die();
	}






	public function getDetallePedidosAll($id)
	{
		$arrData = $this->model->selectDetallePedidosAll($id);
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

}

?>