<?php 
		session_start();

	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TTipoPago.php");
	require_once("Models/TCliente.php");
	class Carrito extends Controllers{
		use TCategoria, TProducto, TTipoPago, TCliente;
		public function __construct()
		{
			parent::__construct();
		}

		public function carrito()
		{
			$data['page_tag'] = NOMBRE_EMPESA.' - Carrito';
			$data['page_title'] = 'Carrito de compras';
			$data['page_name'] = "carrito";
			$data['precio_envios_all'] = $this->getPrecioEnvios();
			$this->views->getView($this,"carrito",$data); 
		}
		public function procesarpago()
		{
			if(empty($_SESSION['dataorden'])){ 
				header("Location: ".base_url());
				die();
			}

			$data['page_tag'] = NOMBRE_EMPESA.' - Procesar Pago';
			$data['page_title'] = 'Procesar Pago';
			$data['page_name'] = "procesarpago";
			$data['tiposPago'] = $this->getTiposPagoT();
			$this->views->getView($this,"procesarpago",$data); 
		}

	}
 ?>
