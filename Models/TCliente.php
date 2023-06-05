<?php 
require_once("Libraries/Core/Mysql.php");
trait TCliente{
	private $con;
	private $intIdUsuario;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intIdTransaccion;
	private $strDni;
	private $strDireccion;
	private $intRol;

	public function insert_oldCliente(string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid){
		$this->con = new Mysql();
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;

		$return = 0;
		$sql = "SELECT * FROM persona WHERE 
				email_user = '{$this->strEmail}' ";
		$request = $this->con->select_all($sql);

		if(empty($request))
		{
			$query_insert  = "INSERT INTO persona(nombres,apellidos,telefono,email_user,password,rolid) 
							  VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->strNombre,
    						$this->strApellido,
    						$this->intTelefono,
    						$this->strEmail,
    						$this->strPassword,
    						$this->intTipoId);
        	$request_insert = $this->con->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = "exist";
		}
        return $return;
	}

	public function insertCliente(string $dni, string $nombre, string $celular, string $direccion, int $rolid,string $correo){
		$this->con = new Mysql();
		$this->strDni = $dni;
		$this->strNombre = $nombre;
		$this->intTelefono = $celular;
		$this->strDireccion = $direccion;
		$this->intRol = $rolid;
		$this->strEmail = $correo;
		$return = 0;
		$sql = "SELECT * FROM clientes WHERE dni = '{$this->strDni}' OR correo  = '{$this->strEmail}' OR celular = '{$this->intTelefono}'";
		$request = $this->con->select($sql);



		$sqldni = "SELECT * FROM clientes WHERE 
				dni = '{$this->strDni}'";
		$requestdni = $this->con->select($sqldni);

		$sqlemail = "SELECT * FROM clientes WHERE 
					correo = '{$this->strEmail}'";
		$requestemail = $this->con->select($sqlemail);

		if(!empty($requestdni)){
			$return = "existdni";
		}else if(!empty($requestemail)){
			$return = "existemail";
		}else{

			$query_insert  = "INSERT INTO clientes(dni, nombre, celular, direccion_envio, rolid, correo) 
							  VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->strDni,
    						$this->strNombre,
    						$this->intTelefono,
    						$this->strDireccion,
    						$this->intRol,
    						$this->strEmail);
        	$request_insert = $this->con->insert($query_insert,$arrData);
        	$return = $request_insert;

		}


		
        return $return;
	}

	public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $personaid, float $costo_envio, string $monto, string $montofinal, int $tipopagoid = NULL, string $direccionenvio, string $cod_descuento, int $descuento, string $status){
		$this->con = new Mysql();
		$query_insert  = "INSERT INTO pedido(idtransaccionpaypal,datospaypal,personaid,costo_envio,monto,montofinal,tipopagoid,direccion_envio,cod_descuento,descuento,status) 
							  VALUES(?,?,?,?,?,?,?,?,?,?,?)";
		$arrData = array($idtransaccionpaypal,
    						$datospaypal,
    						$personaid,
    						$costo_envio,
    						$monto,
    						$montofinal,
    						$tipopagoid,
    						$direccionenvio,
    						$cod_descuento,
    						$descuento,
    						$status
    					);
		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;
	    return $return;
	}

	public function insertDetalle(int $idpedido, int $productoid, float $precio, int $cantidad){
		$this->con = new Mysql();
		$query_insert  = "INSERT INTO detalle_pedido(pedidoid,productoid,precio,cantidad) 
							  VALUES(?,?,?,?)";
		$arrData = array($idpedido,
    					$productoid,
						$precio,
						$cantidad
					);
		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;
	    return $return;
	}

	public function insertDetalleTemp(array $pedido){
		$this->intIdUsuario = $pedido['idcliente'];
		$this->intIdTransaccion = $pedido['idtransaccion'];
		$productos = $pedido['productos'];

		$this->con = new Mysql();
		$sql = "SELECT * FROM detalle_temp WHERE 
					transaccionid = '{$this->intIdTransaccion}' AND 
					personaid = $this->intIdUsuario";
		$request = $this->con->select_all($sql);

		if(empty($request)){
			foreach ($productos as $producto) {
				$query_insert  = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
	        	$arrData = array($this->intIdUsuario,
	        					$producto['idproducto'],
	    						$producto['precio'],
	    						$producto['cantidad'],
	    						$this->intIdTransaccion
	    					);
	        	$request_insert = $this->con->insert($query_insert,$arrData);
			}
		}else{
			$sqlDel = "DELETE FROM detalle_temp WHERE 
				transaccionid = '{$this->intIdTransaccion}' AND 
				personaid = $this->intIdUsuario";
			$request = $this->con->delete($sqlDel);
			foreach ($productos as $producto) {
				$query_insert  = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
	        	$arrData = array($this->intIdUsuario,
	        					$producto['idproducto'],
	    						$producto['precio'],
	    						$producto['cantidad'],
	    						$this->intIdTransaccion
	    					);
	        	$request_insert = $this->con->insert($query_insert,$arrData);
			}
		}
	}

	public function getPedido(int $idpedido){
		$this->con = new Mysql();
		$request = array();
		$sql = "SELECT p.idpedido,
							p.referenciacobro,
							p.idtransaccionpaypal,
							p.personaid,
							p.fecha,
							p.costo_envio,
							p.monto,
							p.tipopagoid,
							t.tipopago,
							p.direccion_envio,
							p.status
					FROM pedido as p
					INNER JOIN tipopago t
					ON p.tipopagoid = t.idtipopago
					WHERE p.idpedido =  $idpedido";
		$requestPedido = $this->con->select($sql);
		if(count($requestPedido) > 0){
			$sql_detalle = "SELECT p.idproducto,
											p.nombre as producto,
											d.precio,
											d.cantidad
									FROM detalle_pedido d
									INNER JOIN producto p
									ON d.productoid = p.idproducto
									WHERE d.pedidoid = $idpedido
									";
			$requestProductos = $this->con->select_all($sql_detalle);
			$request = array('orden' => $requestPedido,
							'detalle' => $requestProductos
							);
		}
		return $request;
	}

	public function setSuscripcion(string $nombre, string $email){
		$this->con = new Mysql();
		$sql = 	"SELECT * FROM suscripciones WHERE email = '{$email}'";
		$request = $this->con->select_all($sql);
		if(empty($request)){
			$query_insert  = "INSERT INTO suscripciones(nombre,email) 
							  VALUES(?,?)";
			$arrData = array($nombre,$email);
			$request_insert = $this->con->insert($query_insert,$arrData);
			$return = $request_insert;
		}else{
			$return = false;
		}
		return $return;
	}

	public function setContacto(string $nombre, string $email, string $mensaje, string $ip, string $dispositivo, string $useragent){
		$this->con = new Mysql();
		$nombre  	 = $nombre != "" ? $nombre : ""; 
		$email 		 = $email != "" ? $email : ""; 
		$mensaje	 = $mensaje != "" ? $mensaje : ""; 
		$ip 		 = $ip != "" ? $ip : ""; 
		$dispositivo = $dispositivo != "" ? $dispositivo : ""; 
		$useragent 	 = $useragent != "" ? $useragent : ""; 
		$query_insert  = "INSERT INTO contacto(nombre,email,mensaje,ip,dispositivo,useragent) 
						  VALUES(?,?,?,?,?,?)";
		$arrData = array($nombre,$email,$mensaje,$ip,$dispositivo,$useragent);
		$request_insert = $this->con->insert($query_insert,$arrData);
		return $request_insert;
	}

	//Campo tabla clientes usuario
	public function buscarCliente(string $dni,string $campo){
		$this->con = new Mysql();
		$sql = "SELECT * FROM clientes WHERE $campo = '$dni'";
		$request = $this->con->select($sql);
		return $request;
	}

	public function updateClientePedido(int $intIdCliente,int $idpedido,int $tipopago, string $adi){
		$this->con = new Mysql();
		$query_update  = "UPDATE pedido SET cliente_id  = ?, tipopagoid = ?, adicional = ? WHERE idpedido  = $idpedido ";
		$request_insert = $this->con->update($query_update,array($intIdCliente,$tipopago,$adi));
		return $request_insert;
	}

	public function updateClienteCorreo(string $correo, string $dni){
		$this->con = new Mysql();
		$query_update  = "UPDATE clientes SET correo  = ? WHERE dni  = '$dni' ";
		$request_insert = $this->con->update($query_update,array($correo));
		return $request_insert;
	}
	
	public function puntossumadocliente(int $idCliente, int $totalobtenido)
	{
		$sql = "SELECT puntos
					FROM clientes
					WHERE id_cliente =  $idCliente";
		$requestmontocliente = $this->con->select($sql);
		if(!empty($requestmontocliente)){
			$obtengoMonto = $requestmontocliente['puntos'];
			$sql_detalle = "UPDATE clientes SET puntos = ? + ? WHERE id_cliente = $idCliente ";
			$arrData = array($obtengoMonto,$totalobtenido);
			$requesttotal = $this->con->update($sql_detalle,$arrData);
		
		}
		return $requesttotal;
	}

	public function puntonceroupdate($idcliente)
	{
		$sql = "UPDATE clientes SET puntos = ? WHERE id_cliente  = $idcliente ";
		$arrData = array(0);
		$request = $this->con->update($sql,$arrData);
		return $request;
	}

	public function setReferidosAdd(string $nombre, string $celular, string $email, int $idCliente){
		$this->con = new Mysql();

		$sql = "SELECT celular, correo FROM clientes
				WHERE celular='$celular' 
				OR correo ='$email'";
		$requestClientesExist = $this->con->select($sql); //Verifica en la tabla clientes si existe el numero o correo
		if(empty($requestClientesExist))
		{
			$sql_buscar_referidos = "SELECT * FROM referidos WHERE celular = '$celular' OR email  = '$email'";
			$request_referidos = $this->con->select($sql_buscar_referidos);
			if(empty($request_referidos))
			{	
				$query_insert  = "INSERT INTO referidos (nombre, celular, email, cliente_id) 
									VALUES(?,?,?,?)";
				$arrData = array($nombre,
								$celular,
								$email,
								$idCliente
								);
				$request_insert = $this->con->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}
		}else{
			$return = "exist";
		}
		return $return;
	}
}

 ?>