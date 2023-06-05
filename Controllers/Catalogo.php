<?php 
			session_start();

	require_once("Models/TProducto.php");
	require_once("Models/LoginModel.php");

	class Catalogo extends Controllers{
		use TProducto;
		public $login;
		public function __construct()
		{
			parent::__construct();
			$this->login = new LoginModel();
		}
		public function catalogo()
		{
			// $data['page_tag'] = NOMBRE_EMPESA;
			// $data['page_title'] = NOMBRE_EMPESA;
			// $data['page_name'] = "catalogo";
			// $data['productos'] = $this->getProductosT();
			// // $data['productos'] = $this->getAddCatalogoProducto();
			// // $cantProductos = $this->cantProductos();
			// $this->views->getView($this,"catalogo",$data);

            header("Location:".base_url());
		}
        public function bijou($teporada){
			if(empty($teporada)){
				header("Location:".base_url());
			}else{


                $data['page_tag'] = NOMBRE_EMPESA;
                $data['page_title'] = NOMBRE_EMPESA;
                $data['page_name'] = "catalogo";
                // $data['productos'] = $this->getProductosT();
				$infoLanding = $this->getAddCatalogoProducto(intval(base64_decode($teporada)));
                if(empty($infoLanding)){
					header("Location:".base_url());
				}
                $data['productos'] = $infoLanding;
                // $cantProductos = $this->cantProductos();


                $this->views->getView($this,"bijou",$data);


                
            }

    	}
	

	}

 ?>
