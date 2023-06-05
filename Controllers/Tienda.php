<?php 
			session_start();

	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TCliente.php");
	require_once("Models/LoginModel.php");

	class Tienda extends Controllers{
		use TCategoria, TProducto, TCliente;
		public $login;
		public function __construct()
		{
			parent::__construct();
			$this->login = new LoginModel();
		}

		public function tienda()
		{
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda";
			//$data['productos'] = $this->getProductosT();
			$pagina = 1;
			$cantProductos = $this->cantProductos();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROPORPAGINA;
			$total_paginas = ceil($total_registro / PROPORPAGINA);
			$data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
			//dep($data['productos']);exit;
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"tienda",$data);
		}

		public function categoria($params){
			if(empty($params)){
				header("Location:".base_url());
			}else{

				$arrParams = explode(",",$params);
				$idcategoria = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$pagina = 1;
				if(count($arrParams) > 2 AND is_numeric($arrParams[2])){
					$pagina = $arrParams[2];
				}

				$cantProductos = $this->cantProductos($idcategoria);
				$total_registro = $cantProductos['total_registro'];
				$desde = ($pagina-1) * PROCATEGORIA;
				$total_paginas = ceil($total_registro / PROCATEGORIA);
				$infoCategoria = $this->getProductosCategoriaT($idcategoria,$ruta,$desde,PROCATEGORIA);
				$categoria = strClean($params);
				$data['page_tag'] = NOMBRE_EMPESA." - ".$infoCategoria['categoria'];
				$data['page_title'] = $infoCategoria['categoria'];
				$data['page_name'] = "categoria";
				$data['productos'] = $infoCategoria['productos'];
				$data['infoCategoria'] = $infoCategoria;
				$data['pagina'] = $pagina;
				$data['total_paginas'] = $total_paginas;
				$data['categorias'] = $this->getCategorias();
				$this->views->getView($this,"categoria",$data);
			}
		}

		public function producto($params){
			if(empty($params)){
				header("Location:".base_url());
			}else{
				$arrParams = explode(",",$params);
				$idproducto = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoProducto = $this->getProductoT($idproducto,$ruta);
				$descInfoProducto = $this->getProductoIDTDesc($idproducto);
				if(empty($infoProducto)){
					header("Location:".base_url());
				}
				$data['page_tag'] = NOMBRE_EMPESA." - ".$infoProducto['nombre'];
				$data['page_title'] = $infoProducto['nombre'];
				$data['page_name'] = "producto";
				$data['producto'] = $infoProducto;
				$data['productocondesc'] = $descInfoProducto;
				$data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'],8,"r");
				$this->views->getView($this,"producto",$data);
			}
		}

		public function addCarrito(){
			if($_POST){
				//unset($_SESSION['arrCarrito']);exit;
				$arrCarrito = array();
				$cantCarrito = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$cantidad = $_POST['cant'];
				$penvio = $this->getPrecioEnvios();
				if(!empty($this->validarenviogratis())){
					$validoenviogratis = $this->validarenviogratis();
				}else{
					$validoenviogratis = NULL;
				}
				if(is_numeric($idproducto) and is_numeric($cantidad)){
					$arrInfoProducto = $this->getProductoIDT($idproducto);

					if(!empty($arrInfoProducto)){

						if(!empty($this->getProductoIDTDesc($idproducto))){
							$ProdoDes =$this->getProductoIDTDesc($idproducto);
							$arrInfoProductoDesc =$ProdoDes["nuevo_total"];
						}else{
							$arrInfoProductoDesc =$arrInfoProducto['precio'];
						}
						$arrProducto = array('idproducto' => $idproducto,
											'producto' => $arrInfoProducto['nombre'],
											'cantidad' => $cantidad,
											'validar_prod_des' => $arrInfoProductoDesc,
											'enviofree' => $validoenviogratis,
											// 'precio' => $arrInfoProducto['precio'],
											'precio' => $arrInfoProductoDesc,
											'precioenvios' => $penvio[0], //el primer registro total
											'precioenviosArmado' => $penvio[0]["distrito"] .' - '. SMONEY.formatMoney($penvio[0]["precio"]), //el primer registro total
											'imagen' => $arrInfoProducto['images'][0]['url_image'],
											'preciocondescuento' => 0
										);
						if(isset($_SESSION['arrCarrito'])){
							$on = true;
							$arrCarrito = $_SESSION['arrCarrito'];
							for ($pr=0; $pr < count($arrCarrito); $pr++) {
								if($arrCarrito[$pr]['idproducto'] == $idproducto){
									$arrCarrito[$pr]['cantidad'] += $cantidad;
									$on = false;
								}
							}
							if($on){
								array_push($arrCarrito,$arrProducto);
							}
							$_SESSION['arrCarrito'] = $arrCarrito;
						}else{
							array_push($arrCarrito, $arrProducto);
							$_SESSION['arrCarrito'] = $arrCarrito;
						}

						foreach ($_SESSION['arrCarrito'] as $pro) {
							$cantCarrito += $pro['cantidad'];
						}
						$htmlCarrito ="";
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
						$arrResponse = array("status" => true, 
											"msg" => '¡Se agrego al corrito!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito
										);

					}else{
						$arrResponse = array("status" => false, "msg" => 'Producto no existente.');
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delCarrito(){
			if($_POST){
				$arrCarrito = array();
				$cantCarrito = 0;
				$subtotal = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$option = $_POST['option'];
				if(is_numeric($idproducto) and ($option == 1 or $option == 2)){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($pr=0; $pr < count($arrCarrito); $pr++) {
						if($arrCarrito[$pr]['idproducto'] == $idproducto){
							unset($arrCarrito[$pr]);
						}
					}
					sort($arrCarrito);
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$cantCarrito += $pro['cantidad'];
						$subtotal += $pro['cantidad'] * $pro['precio'];
					}
					$htmlCarrito = "";
					if($option == 1){
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
					}
					$arrResponse = array("status" => true, 
											"msg" => '¡Producto eliminado!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito,
											"subTotal" => SMONEY.formatMoney($subtotal),
											"total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
										);
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function updCarrito(){
			// dep($_POST); exit();
			if($_POST){
				$arrCarrito = array();
				$totalProducto = 0;
				$subtotal = 0;
				$total = 0; 
				$precio_condescuento = 0; 
				if(!empty($this->validarenviogratis())){
					$validoenviogratis = $this->validarenviogratis();
				}else{
					$validoenviogratis = NULL;
				}
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$cantidad = intval($_POST['cantidad']);
				$envio = intval($_POST['envio']);
				$condescuento = intval($_POST['preciodesc']);
				$nomenvio = strClean($_POST['nomenvio']);
				if(is_numeric($idproducto) and $cantidad > 0){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($p=0; $p < count($arrCarrito); $p++) { 
						if($arrCarrito[$p]['idproducto'] == $idproducto){
							$arrCarrito[$p]['cantidad'] = $cantidad;
							$arrCarrito[0]['precioenviosArmado'] = $nomenvio; //precio armamdo
							$arrCarrito[0]['precioenvios']["precio"] = $envio; //precio del envio
							if($condescuento !=0){
								$arrCarrito[$p]['preciocondescuento'] = $condescuento; //descuento por cupón
							}
							$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
							break;
						}
					}
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio'];
						
						if($pro['preciocondescuento'] != 0){
							$aplicar_descuento = ($subtotal * $pro['preciocondescuento']) / 100;
							$precio_condescuento += $subtotal - $aplicar_descuento;

						}else{
							$precio_condescuento += 0;
						}
					}
					
					
					// $subtotalCalcular = ($subtotal != $precio_condescuento) ? $precio_condescuento : $subtotal;
					$subtotalCalcular = ($precio_condescuento != 0) ? $precio_condescuento : $subtotal;

					
					if($validoenviogratis != NULL){
						if($subtotalCalcular >= $validoenviogratis["ppuntos"]){
							$calculandoenvios = $subtotalCalcular;
							$enviogratisactivado = "enviogratis";
						}else{
							$calculandoenvios = $subtotalCalcular + $envio;
							$enviogratisactivado = "noenviogratis";
						}
					}else{
						$calculandoenvios = $subtotalCalcular + $envio;
						$enviogratisactivado = "noenviogratis";
					}
					$calcularenviodesc = ($precio_condescuento != 0) ? $precio_condescuento + $envio : 0;
					$arrResponse = array("status" => true, 
										"msg" => '¡Producto actualizado!',
										"Enviofree" => $enviogratisactivado,
										"totalProducto" => SMONEY.formatMoney($totalProducto),
										"subTotal" => SMONEY.formatMoney($subtotal),
										"subTotal_conDesc" => SMONEY.formatMoney($precio_condescuento),
										"subTotal_conDescSinFormart" => $precio_condescuento,
										"subTotalconDesc" => SMONEY.formatMoney($calcularenviodesc),
										"precioenvio" => intval($validoenviogratis["ppuntos"]),
										"total" => SMONEY.formatMoney($calculandoenvios)
									);

				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function registro(){
			error_reporting(0);
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
					$intTipoId = RCLIENTES; 
					$request_user = "";
					
					$strPassword =  passGenerator();
					$strPasswordEncript = hash("SHA256",$strPassword);
					$request_user = $this->insertCliente($strNombre, 
														$strApellido, 
														$intTelefono, 
														$strEmail,
														$strPasswordEncript,
														$intTipoId );
					if($request_user > 0 )
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						$nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'asunto' => 'Bienvenido a tu tienda en línea');
						$_SESSION['idUser'] = $request_user;
						$_SESSION['login'] = true;
						$this->login->sessionLogin($request_user);
						sendEmail($dataUsuario,'email_bienvenida');

					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function procesarVenta_old(){
			if($_POST){
				$idtransaccionpaypal = NULL;
				$datospaypal = NULL;
				$personaid = $_SESSION['idUser'];
				$monto = 0;
				$tipopagoid = intval($_POST['inttipopago']);
				$direccionenvio = strClean($_POST['direccion']).', '.strClean($_POST['ciudad']);
				$status = "Pendiente";
				$subtotal = 0;
				$costo_envio = COSTOENVIO;

				if(!empty($_SESSION['arrCarrito'])){
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
					}
					$monto = $subtotal + COSTOENVIO;
					//Pago contra entrega
					if(empty($_POST['datapay'])){
						//Crear pedido
						$request_pedido = $this->insertPedido($idtransaccionpaypal, 
															$datospaypal, 
															$personaid,
															$costo_envio,
															$monto, 
															$tipopagoid,
															$direccionenvio, 
															$status);
						if($request_pedido > 0 ){
							//Insertamos detalle
							foreach ($_SESSION['arrCarrito'] as $producto) {
								$productoid = $producto['idproducto'];
								$precio = $producto['precio'];
								$cantidad = $producto['cantidad'];
								$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
							}

							$infoOrden = $this->getPedido($request_pedido);
							$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );
							sendEmail($dataEmailOrden,"email_notificacion_orden");

							$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
							$transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
							$arrResponse = array("status" => true, 
											"orden" => $orden, 
											"transaccion" =>$transaccion,
											"msg" => 'Pedido realizado'
										);
							$_SESSION['dataorden'] = $arrResponse;
							unset($_SESSION['arrCarrito']);
							session_regenerate_id(true);
						}
					}else{ //Pago con PayPal
						$jsonPaypal = $_POST['datapay'];
						$objPaypal = json_decode($jsonPaypal);
						$status = "Aprobado";
						if(is_object($objPaypal)){
							$datospaypal = $jsonPaypal;
							$idtransaccionpaypal = $objPaypal->purchase_units[0]->payments->captures[0]->id;
							if($objPaypal->status == "COMPLETED"){
								$totalPaypal = formatMoney($objPaypal->purchase_units[0]->amount->value);
								if($monto == $totalPaypal){
									$status = "Completo";
								}
								//Crear pedido
								$request_pedido = $this->insertPedido($idtransaccionpaypal, 
																	$datospaypal, 
																	$personaid,
																	$costo_envio,
																	$monto, 
																	$tipopagoid,
																	$direccionenvio, 
																	$status);
								if($request_pedido > 0 ){
									//Insertamos detalle
									foreach ($_SESSION['arrCarrito'] as $producto) {
										$productoid = $producto['idproducto'];
										$precio = $producto['precio'];
										$cantidad = $producto['cantidad'];
										$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
									}
									$infoOrden = $this->getPedido($request_pedido);
									$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );

									sendEmail($dataEmailOrden,"email_notificacion_orden");

									$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
									$transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
									$arrResponse = array("status" => true, 
													"orden" => $orden, 
													"transaccion" =>$transaccion,
													"msg" => 'Pedido realizado'
												);
									$_SESSION['dataorden'] = $arrResponse;
									unset($_SESSION['arrCarrito']);
									session_regenerate_id(true);
								}else{
									$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
								}
							}else{
								$arrResponse = array("status" => false, "msg" => 'No es posible completar el pago con PayPal.');
							}
						}else{
							$arrResponse = array("status" => false, "msg" => 'Hubo un error en la transacción.');
						}
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function procesarVenta(){
			// dep($_POST); exit();
			if($_POST){
				$idtransaccionpaypal = NULL;
				$datospaypal = NULL;
				$tipopagoid = 4; //Por confirmar
				$personaid = 1;
				$monto = 0;
				$status = "Pendiente";
				$subtotal = 0;
				$subtotal_pagar = 0;
				$prec_descu = 0;
				// $precio_condescuento = 0; 

				if(!empty($_SESSION['arrCarrito'])){
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
						$prec_descu +=$pro['preciocondescuento'];
						
					}
					if($prec_descu != 0){
						$aplicar_descuento = ($subtotal * $prec_descu) / 100;
						$subtotal_pagar += $subtotal - $aplicar_descuento; // SUBTOTAL CON DESCUENTO
						$cupon = strClean($_POST['codcupon']);

					}else{
						$cupon = strClean("-");
						$subtotal_pagar += $subtotal; //SUBTOTAL SIN DESCUENTO  
					}
					/*
					tabla pedidos
					costo_envio = $costo_envio
					monto = $monto
					
					*/
					$costo_envio = intval($_SESSION['arrCarrito'][0]["precioenvios"]["precio"]);
					$monto = $subtotal_pagar; //subtotal
					$montofinal = $subtotal_pagar + $costo_envio;
					$direccionenvio = $_SESSION['arrCarrito'][0]["precioenviosArmado"];
					//Crear pedido
					$request_pedido = $this->insertPedido($idtransaccionpaypal, 
														$datospaypal, 
														$personaid,
														$costo_envio,
														$monto, //subtotal
														$montofinal, //monto total con evio
														$tipopagoid,
														$direccionenvio,
														$cupon,
														$prec_descu,
														$status);
					if($request_pedido > 0 ){
						//Insertamos detalle
						foreach ($_SESSION['arrCarrito'] as $producto) {
							$productoid = $producto['idproducto'];
							$precio = $producto['precio'];
							$cantidad = $producto['cantidad'];
							$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
						}

						$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
						// $transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
						$arrResponse = array("status" => true, 
										"orden" => $orden, 
										"pedido_id" => $request_pedido,
										// "transaccion" =>$transaccion,
										"msg" => 'Pedido realizado'
									);
						$_SESSION['dataorden'] = $arrResponse;
						unset($_SESSION['arrCarrito']);
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function confirmar_oldpedido(){
			if(empty($_SESSION['dataorden'])){
				header("Location: ".base_url());
			}else{
				$dataorden = $_SESSION['dataorden'];
				$idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
				$transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmarpedido";
				$data['orden'] = $idpedido;
				$data['transaccion'] = $transaccion;
				$this->views->getView($this,"confirmarpedido",$data);
			}
			unset($_SESSION['dataorden']);
		}

		public function confirmarpedido(){
			if(empty($_SESSION['dataordenconfirm'])){
				header("Location: ".base_url());
			}else{
				$dataorden = $_SESSION['dataordenconfirm'];
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmarpedido";
				$data['dataorden'] = $dataorden;
			
				$idCliente = array($dataorden)[0]["idClnt"];
				// $montopuntos = $data['compras_total_clientes']["datamonto"]["montototales"];

				//Traer el total de la compra para sumarlo en el puntaje de cliente
				$idPedido = array($dataorden)[0]["orden"];
				$obtengoTotalDeCompra = $this->totalCompra($idPedido);
				$totalobtenido = $obtengoTotalDeCompra["total"];
				$this->puntossumadocliente($idCliente,$totalobtenido);
				$data['compras_total_clientes'] = $this->selectPedidoAllTienda($idCliente);

				
				//Quitando los puntos
				$data["validar_descuento"] = $this->selectValidarDescuentoPuntos();
				if(isset($data['validar_descuento']["ppuntos"])){
					$monto = $data['compras_total_clientes']["datamonto"]["puntos"];
					$puntoDescuentoTotal = $data['validar_descuento']["ppuntos"];
					$validarsiaccede = $puntoDescuentoTotal - $monto;
					if ($validarsiaccede == 0 || $validarsiaccede < 0){
						$this->puntonceroupdate($idCliente);
						
					}
				}
				// $data['productos'] = $this->selectPedidoAll($id_cliente,$idpersona);
				$this->views->getView($this,"confirmarpedido",$data);
			}
			unset($_SESSION['dataordenconfirm']);
			
		}

		public function page($pagina = null){

			$pagina = is_numeric($pagina) ? $pagina : 1;
			$cantProductos = $this->cantProductos();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROPORPAGINA;
			$total_paginas = ceil($total_registro / PROPORPAGINA);
			$data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
			//dep($data['productos']);exit;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"tienda",$data);
		}

		public function search(){
			if(empty($_REQUEST['s'])){
				header("Location: ".base_url());
			}else{
				$busqueda = strClean($_REQUEST['s']);
			}

			$pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
			$cantProductos = $this->cantProdSearch($busqueda);
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROBUSCAR;
			$total_paginas = ceil($total_registro / PROBUSCAR);
			$data['productos'] = $this->getProdSearch($busqueda,$desde,PROBUSCAR);
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = "Resultado de: ".$busqueda;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['busqueda'] = $busqueda;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"search",$data);

		}

		public function suscripcion(){
			if($_POST){
				$nombre = ucwords(strtolower(strClean($_POST['nombreSuscripcion'])));
				$email  = strtolower(strClean($_POST['emailSuscripcion']));

				$suscripcion = $this->setSuscripcion($nombre,$email);
				if($suscripcion > 0){
					$arrResponse = array('status' => true, 'msg' => "Gracias por tu suscripción.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva suscripción",
										'email' => EMAIL_SUSCRIPCION,
										'nombreSuscriptor' => $nombre,
										'emailSuscriptor' => $email );
					sendEmail($dataUsuario,"email_suscripcion");
				}else{
					$arrResponse = array('status' => false, 'msg' => "El email ya fue registrado.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

		public function contacto(){
			if($_POST){
				//dep($_POST);
				$nombre = ucwords(strtolower(strClean($_POST['nombreContacto'])));
				$email  = strtolower(strClean($_POST['emailContacto']));
				$mensaje  = strClean($_POST['mensaje']);
				$useragent = $_SERVER['HTTP_USER_AGENT'];
				$ip        = $_SERVER['REMOTE_ADDR'];
				$dispositivo= "PC";

				if(preg_match("/mobile/i",$useragent)){
					$dispositivo = "Movil";
				}else if(preg_match("/tablet/i",$useragent)){
					$dispositivo = "Tablet";
				}else if(preg_match("/iPhone/i",$useragent)){
					$dispositivo = "iPhone";
				}else if(preg_match("/iPad/i",$useragent)){
					$dispositivo = "iPad";
				}

				$userContact = $this->setContacto($nombre,$email,$mensaje,$ip,$dispositivo,$useragent);
				if($userContact > 0){
					$arrResponse = array('status' => true, 'msg' => "Su mensaje fue enviado correctamente.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva Usuario en contacto",
										'email' => EMAIL_CONTACTO,
										'nombreContacto' => $nombre,
										'emailContacto' => $email,
										'mensaje' => $mensaje );
					sendEmail($dataUsuario,"email_contacto");
				}else{
					$arrResponse = array('status' => false, 'msg' => "No es posible enviar el mensaje.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

		//CUPÓN DE DESCUENTOS.
		public function validarcupon(){
			// dep($_POST); exit();
			if($_POST){
				$cupon = strClean($_POST['cod']);
				$request_cupon = $this->validarcupondesc($cupon);
				if(empty($request_cupon))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $request_cupon);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}

		}

		//OBTENER CLIENTE POR DNI
		public function getClienteNombre(){
			// dep($_POST); exit();
	
			if($_POST){
					$dni = $_POST['dni'];
					$campo = "dni";
					$request_cliente = $this->buscarCliente($dni,$campo);
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
					$correo = $_POST['correo']; 
	
					if($tiporegistro == "exist"){ //Actualizar
						$idClienteRegistrado = $_POST['idclienteregistrado'];
						$nombre = $_POST['nombreobtenido'];
						if(!empty($idClienteRegistrado)){
							$adi = ($adicional == "") ? "-" : $adicional; //Si el adicional está vacío
							$det = $this->updateClientePedido($idClienteRegistrado,$numpedido,$tipoPago,$adi);
							if($det > 0){
								$this->updateClienteCorreo($correo,$dni); //Por si actualizó el correo
								$infoOrden = $this->getPedido($numpedido);
								$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$numpedido,
														'email' => $correo, 
														'emailCopia' => EMAIL_PEDIDOS,
														'pedido' => $infoOrden );
								sendEmail($dataEmailOrden,"email_notificacion_orden"); //Enviar correo al cliente registrado
								$arrResponse = array("status" => true, 
													'orden' => $numpedido,
													'nombreSuscriptor' => $nombre,
													'idClnt' => $idClienteRegistrado,
													"msg" => 'Cliente registrado.');
								$_SESSION['dataordenconfirm'] = $arrResponse;
								unset($_SESSION['dataorden']);
							}else{
								$arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
							}
						}else{
							$arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
						}
	
					}
					else if($tiporegistro == "new"){
								$nombre = $_POST['nombre'];
								$celular = $_POST['celular'];
								$direccion = $_POST['direccion'];
	
								$request_clientes = $this->insertCliente($dni, 
																		$nombre,
																		$celular,
																		$direccion,
																		$rolid,
																		$correo);
	
								//ENVIAR CORREO ====
								if($request_clientes > 0 ){
									$adi = ($adicional == "") ? "-" : $adicional; //Si el adicional está vacío
									$det = $this->updateClientePedido($request_clientes,$numpedido,$tipoPago,$adi);
									if($det > 0){
										$arrResponse = array("status" => true, 
													'orden' => $numpedido,
													'nombreSuscriptor' => $nombre,
													'idClnt' => $request_clientes,
													"msg" => 'Cliente registrado.'
											);
										$_SESSION['dataordenconfirm'] = $arrResponse;
										
										$nombreUsuario = $nombre;
										$dataUsuario = array('nombreUsuario' => $nombreUsuario,
															'email' => $correo,
															// 'password' => $strPassword,
															'asunto' => 'Gracias por formar parte de bmbijou =D');
										sendEmail($dataUsuario,'email_bienvenida');
										unset($_SESSION['dataorden']);
									}else{
										$arrResponse = array("status" => false, "msg" => 'No es posible registrar cliente.');
									}
								}else if($request_clientes == "existdni"){
									$arrResponse = array("status" => false, "msg" => 'El DNI ya se encuentra registrado.');
								}else if($request_clientes == "existemail"){
									$arrResponse = array("status" => false, "msg" => 'El Correo ya se encuentra registrado.');
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
		//REGISTRO DE REFERIDOS
		public function referidos(){
			// dep($_POST); exit();
			if($_POST){
				//dep($_POST);
				$nombre = strClean($_POST['rf_nombre']);
				$celular  = strClean($_POST['rf_celular']);
				$email  = strClean($_POST['rf_email']);
				$idCliente = openssl_decrypt($_POST['rf_clt'], METHODENCRIPT, KEY);
				$nombreCliente  = strClean($_POST['rf_nomb']);


				$createReferidos = $this->setReferidosAdd($nombre,$celular,$email,$idCliente);
			
				if($createReferidos > 0){
					$arrResponse = array('status' => true, 'msg' => $nombreCliente.", tu referido ha sido registrado.");
				}else if($createReferidos == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existen referidos con esos datos.');		
				}
				else{
					$arrResponse = array('status' => false, 'msg' => "No es posible enviar el mensaje.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

	}

 ?>
