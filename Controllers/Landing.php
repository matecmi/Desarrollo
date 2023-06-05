<?php 
			session_start();

	require_once("Models/TProducto.php");
	require_once("Models/LoginModel.php");
	require_once("Models/TLanding.php");

	class Landing extends Controllers{
		use TProducto, TLanding;
		public $login;
		public function __construct()
		{
			parent::__construct();
			$this->login = new LoginModel();
		}
		public function Landing(){

			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "landing";
			$data['infoLandingAll'] = $this->selectLandingPageAll();
			$this->views->getView($this,"landing",$data);
			// header("Location:".base_url());

		}
        public function bijou($teporada){
			if(empty($teporada)){
				header("Location:".base_url());
			}else{

                $infoLanding = $this->getLandingT(intval(base64_decode($teporada)));
                if(empty($infoLanding)){
					header("Location:".base_url());
				}
                $productosPertenece = $this->getProductosLandingT(intval(base64_decode($teporada)));
                $data['page_title'] = NOMBRE_EMPESA;
                $data['productosLanding'] = $productosPertenece;
                $data['id'] = $teporada;
                
                $data['page_name'] = "bijou";
                $data['respuestas_landing'] = $infoLanding;
                // $data['arrPedidoAll'] = $this->model->selectPedidoAll($id_cliente,$idpersona);
                $this->views->getView($this,"bijou",$data);
            }

    	}

		public function setRegisterFormularioLanding(){
			// dep($_POST); exit();
			if($_POST){

				if(empty($_POST['landing']))
				{
					$arrResponse = array("status" => false, "msg" => 'Error al realizar el registro.');
				}else{
					$id = intval(base64_decode($_POST['landing']));
					foreach ($_POST as $key => $value) {


						if($value != $_POST['landing'] ){

                        	$request_form = $this->addformdinamic($value,$id);


						}
						
					}
					$arrResponse = array("status" => true, "msg" => 'Registrado con éxito.');

				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}





		}




    }