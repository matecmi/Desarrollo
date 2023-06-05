<?php 
class ClientesModel extends Mysql
{
	private $intIdUsuario;
	private $strIdentificacion;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intStatus;
	private $intDni;
	private $strNit;
	private $strNomFiscal;
	private $strDirFiscal;

	public function __construct()
	{
		parent::__construct();
	}	

	// public function insertCliente(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, string $nit, string $nomFiscal, string $dirFiscal){

	// 	$this->strIdentificacion = $identificacion;
	// 	$this->strNombre = $nombre;
	// 	$this->strApellido = $apellido;
	// 	$this->intTelefono = $telefono;
	// 	$this->strEmail = $email;
	// 	$this->strPassword = $password;
	// 	$this->intTipoId = $tipoid;
	// 	$this->strNit = $nit;
	// 	$this->strNomFiscal = $nomFiscal;
	// 	$this->strDirFiscal = $dirFiscal;

	// 	$return = 0;
	// 	$sql = "SELECT * FROM persona WHERE 
	// 			email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}' ";
	// 	$request = $this->select_all($sql);

	// 	if(empty($request))
	// 	{
	// 		$query_insert  = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,nit,nombrefiscal,direccionfiscal) 
	// 						  VALUES(?,?,?,?,?,?,?,?,?,?)";
    //     	$arrData = array($this->strIdentificacion,
    // 						$this->strNombre,
    // 						$this->strApellido,
    // 						$this->intTelefono,
    // 						$this->strEmail,
    // 						$this->strPassword,
    // 						$this->intTipoId,
    // 						$this->strNit,
    // 						$this->strNomFiscal,
    // 						$this->strDirFiscal);
    //     	$request_insert = $this->insert($query_insert,$arrData);
    //     	$return = $request_insert;
	// 	}else{
	// 		$return = "exist";
	// 	}
    //     return $return;
	// }

	public function selectClientes()
	{
		$sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,status 
				FROM persona 
				WHERE rolid = ".RCLIENTES." and status != 0 "; 
		$request = $this->select_all($sql);
		return $request;
	}




	public function selectClientesUsuarios()
	{
		$sql = "SELECT id_cliente, id_cliente as cont, dni, nombre, celular, direccion_envio, rolid
				FROM clientes 
				WHERE rolid = 1 and status != 0 "; 
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectPedidoAll(int $id_cliente, $idpersona = NULL){
		$busqueda = "";
		if($idpersona != NULL){
			$busqueda = " AND p.personaid =".$idpersona;
		}
		$request = array();
		//RECORRIENDO PEDIDOS

		// $sql = "SELECT SUM(dp.precio) AS montototales, 
		// 		COUNT(*) as totalcompras,
		// 		c.id_cliente,
		// 		c.dni,
		// 		c.nombre,
		// 		c.celular,
		// 		c.direccion_envio,
		// 		c.puntos
		// 		FROM pedido as p
		// 		INNER JOIN detalle_pedido dp
		// 		ON dp.pedidoid = p.idpedido
		// 		INNER JOIN clientes c
		// 		ON p.cliente_id=c.id_cliente
		// 		WHERE c.rolid = 1 and c.status != 0 and cliente_id =  $id_cliente ".$busqueda;
		$sql = "SELECT SUM(montofinal) as montototales,
				c.id_cliente,
				c.dni,
				c.nombre,
				c.celular,
				c.direccion_envio,
				c.puntos
				FROM pedido as p
				INNER JOIN clientes c
				ON p.cliente_id=c.id_cliente
				WHERE c.rolid = 1 and c.status != 0 and cliente_id =  $id_cliente ".$busqueda;
		$requestPedidoGeneral = $this->select($sql);
		//Total compras
		$sql_totalcompras = "SELECT COUNT(*) as totalcompras
							FROM pedido
							WHERE cliente_id=  $id_cliente ";	
		$requesttotal_compras = $this->select($sql_totalcompras);
		if(!empty($requestPedidoGeneral)){
			$cliente_id = $requestPedidoGeneral['id_cliente'];
			//Total de pedidos
			// $sqlPedido = "SELECT p.idpedido,
			// 				p.personaid,
			// 				p.fecha,
			// 				p.costo_envio,
			// 				p.monto as subtotal,
			// 				p.tipopagoid,
			// 				p.direccion_envio,
			// 				dp.precio as montotoal,
			// 				dp.cantidad,
			// 				pd.nombre as nombreproducto,
			// 				tp.tipopago,
			// 				p.status
			// 				FROM pedido as p
			// 				INNER JOIN detalle_pedido dp
			// 				on dp.pedidoid = p.idpedido
			// 				INNER JOIN producto pd
			// 				ON dp.productoid = pd.idproducto
			// 				INNER JOIN tipopago tp
			// 				ON p.tipopagoid = tp.idtipopago
			// 				WHERE p.cliente_id = $cliente_id  ORDER BY p.idpedido DESC";
			$sqlPedido = "SELECT idpedido,
							fecha,
							montofinal
							FROM pedido 
							WHERE cliente_id = $cliente_id  ORDER BY idpedido DESC";
			$requestcliente = $this->select_all($sqlPedido);
			if(!empty($requestcliente)){
				foreach ($requestcliente as $val) {
					$pedidos__id = $val["idpedido"];

					$sqlporpedido = "SELECT p.idpedido, pr.nombre as producto, p.monto as subtotal,dp.cantidad as cantidad, p.costo_envio as precioenvio,tp.tipopago,p.status
									FROM detalle_pedido as dp
									INNER JOIN pedido p
									ON dp.pedidoid=p.idpedido
									INNER JOIN producto pr
									ON dp.productoid=pr.idproducto
									INNER JOIN tipopago as tp
									ON p.tipopagoid = tp.idtipopago
									WHERE p.idpedido = $cliente_id ORDER BY p.idpedido DESC";
					$requestporpedidos = $this->select_all($sqlporpedido);
				}

			}
			
			$request = array('detallepedidos' => $requestcliente,
							'ordenGeneral' => $requestPedidoGeneral,
							'totalcompras' => $requesttotal_compras
							 );
		}
		return $request;
	}


	public function selectDetallePedidosAll($id){

		$sql = "SELECT p.idpedido, pr.nombre as producto, p.monto as subtotal,dp.cantidad as cantidad, p.costo_envio as precioenvio,tp.tipopago,p.status
				FROM detalle_pedido as dp
				INNER JOIN pedido p
				ON dp.pedidoid=p.idpedido
				INNER JOIN producto pr
				ON dp.productoid=pr.idproducto
				INNER JOIN tipopago as tp
				ON p.tipopagoid = tp.idtipopago
				WHERE p.idpedido=$id ORDER BY p.idpedido DESC";
		$request = $this->select_all($sql);
		return $request;

	}



	

	public function selectCliente(int $idpersona){
		$this->intIdUsuario = $idpersona;
		$sql = "SELECT id_cliente, dni, nombre, celular, direccion_envio, rolid, correo, status, puntos, datecreated FROM clientes 
				WHERE id_cliente = $this->intIdUsuario";
		$request = $this->select($sql);
		return $request;
	}

	public function updateCliente(int $idUsuario,string $dni, string $nombre, string $strCelular, string $strDireccion, string $correo){


		$this->intIdUsuario = $idUsuario;
		$this->intDni = $dni;
		$this->strNombre = $nombre;
		$this->intTelefono = $strCelular;
		$this->strDirFiscal = $strDireccion;
		$this->strEmail = $correo;


		$sql = "UPDATE clientes SET dni=?, nombre=?, celular=?, direccion_envio=?, correo=?
				WHERE id_cliente = $this->intIdUsuario ";
			$arrData = array($this->intDni,
								$this->strNombre,
								$this->intTelefono,
								$this->strDirFiscal,
								$this->strEmail,
						);
		$request = $this->update($sql,$arrData);

		return $request;
	}

	public function deleteCliente(int $intIdpersona)
	{

		$this->intIdUsuario = $intIdpersona;
		
		$sql_ver = "SELECT c.id_cliente FROM clientes as c
					INNER JOIN pedido p
					ON p.cliente_id = c.id_cliente
					WHERE c.id_cliente = '{$this->intIdUsuario}'";
		$requesver = $this->select_all($sql_ver);


		if(!empty($requesver)){
			$request = "exist";
		}else{
			$sql = "DELETE FROM `clientes` WHERE id_cliente  = $this->intIdUsuario ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
		}



		return $request;
	}
	public function buscarCliente(string $dni,string $campo){
		$this->strDni = $dni;
		$sql = "SELECT * FROM clientes WHERE $campo = '$this->strDni'";
		$request = $this->select_all($sql);
		return $request;
	}




	public function insertCliente(string $dni, string $nombre, string $strCelular, string $strDireccion, int $rolid, string $correo){
		$this->con = new Mysql();
		$this->strDni = $dni;
		$this->strEmail = $correo;
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
			$arrData = array($dni,
							$nombre,
							$strCelular,
							$strDireccion,
							$rolid,
							$correo);
			$request_insert = $this->con->insert($query_insert,$arrData);
			$return = $request_insert;

		}



		
	    return $return;
	}










	
    public function updateClientePedido(int $intIdCliente,$idpedido,int $tipopago){
		$this->con = new Mysql();
		$this->intIdPedido = $idpedido;
		$query_update  = "UPDATE pedido SET cliente_id  = ?, tipopagoid = ? WHERE idpedido  = $this->intIdPedido ";
		$request_insert = $this->con->update($query_update,array($intIdCliente,$tipopago));
		return $request_insert;
	}

	//REFERIDOS
	public function selectReferidosCliente()
	{
		$sql = "SELECT c.id_cliente, c.dni, c.nombre, c.celular, c.direccion_envio, c.rolid, c.correo, c.status, c.puntos FROM referidos as r
				INNER JOIN clientes c
				ON r.cliente_id = c.id_cliente "; 
		$request = $this->select_all($sql);
		return $request;
	}
	public function selectRefClient(int $idclt)
	{
		$sql = "SELECT id_referidos, nombre, celular, email, cliente_id, estado, cupon_cod, registrado 
				FROM referidos
                WHERE cliente_id =$idclt"; 
		$request = $this->select_all($sql);
		return $request;
	}
}

 ?>