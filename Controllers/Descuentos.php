<?php 
		session_start();

class Descuentos extends Controllers{
	public function __construct()
	{
		parent::__construct();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MDDESCUENTOS);
	}
	public function Descuentos()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Descuentos";
		$data['page_title'] = "DESCUENTOS <small>Tienda Virtual</small>";
		$data['page_name'] = "descuentos";
		$data['cupones'] = $this->model->setCuponesDisponibles();
		$data['page_functions_js'] = "functions_descuentos.js";
		$this->views->getView($this,"descuentos",$data);
	}
    public function getDescuentoPorProductos($porproducto)
    {
        if($_SESSION['permisosMod']['r']){
            $cont = 0;
            $arrData = $this->model->selectDescuentoPorProducto($porproducto);
            for ($i=0; $i < count($arrData); $i++) {
                $cont++;
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';
                $arrData[$i]['cont'] = $cont;
                $arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);
                $arrData[$i]['nuevo_total'] = SMONEY.' '.formatMoney($arrData[$i]['nuevo_total']);
                $arrData[$i]['descuento'] = '<span class="badge badge-danger">- '.$arrData[$i]['descuento'].'%</span>';
                if($_SESSION['permisosMod']['u']){
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['id_cupon'].')" title="Editar descuento por producto"><i class="fas fa-pencil-alt"></i></button>';
                }
                if($_SESSION['permisosMod']['d']){	
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['id_cupon'].')" title="Eliminar descuento por producto"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function delDescuentoPorProducto()
    {
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $intIdProdDes = intval($_POST['idProdDes']);
                $requestDelete = $this->model->deleteProductoDescuento($intIdProdDes);
                if($requestDelete)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el descuento');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el descuento.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    public function setDescuentoPorProducto()
    {
        // dep($_POST); exit();
        if($_POST){			
            if(empty($_POST['idproducto']) || empty($_POST['descuento']) || empty($_POST['total_pagar']) || empty($_POST['descuentopertenece']) || empty($_POST['vigenciaProducto']))
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{ 
                $idDescuento = intval($_POST['idDescuentoProducto']);
                $intIdProducto = intval($_POST['idproducto']);
                $intDescuento = intval($_POST['descuento']);
                $intTotalPagar = intval($_POST['total_pagar']);
                $strDescuentoPertenece = strClean($_POST['descuentopertenece']);
                $vigenciaProducto = $_POST['vigenciaProducto'];
                $request_user = "";

                if($idDescuento == "" || $idDescuento==0)
                {

                    $option = 1;
                    if($_SESSION['permisosMod']['w']){
                        $request_user = $this->model->insertDescuentoProducto($intIdProducto,
                                                                            $intDescuento, 
                                                                            $intTotalPagar,
                                                                            $strDescuentoPertenece,
                                                                            $vigenciaProducto);
                    }
                }else{

                    $option = 2;
                    if($_SESSION['permisosMod']['u']){
                        $request_user = $this->model->updateDescuentoProducto($idDescuento,
                                                                            $intIdProducto,
                                                                            $intDescuento, 
                                                                            $intTotalPagar,
                                                                            $vigenciaProducto);
                    }

                }

                if($request_user > 0 )
                {
                    if($option == 1){
                        $estadoAlteradoDescuento = "condescuento";
                        $this->model->updateProductoDescuento($intIdProducto,$estadoAlteradoDescuento);
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    }else{
                        $estadoAlteradoDescuento = "condescuento";
                        $this->model->updateProductoDescuento($intIdProducto,$estadoAlteradoDescuento);
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                }else if($request_user == 'exist'){
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya se aplicó un descuento a este producto.');		
                }
                else{
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getDescuentoPorProductoRegistrados($idDescuentoProd)
    {
        if($_SESSION['permisosMod']['r']){
            $intIdDescProd = intval($idDescuentoProd);
            if($intIdDescProd > 0)
            {
                $arrData = $this->model->selectDescuentoPorProductoRegistrados($intIdDescProd);
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
    //POR PUNTOS
    public function getDescuentoPorPuntos($porpuntos)
    {
        if($_SESSION['permisosMod']['r']){
            $cont = 0;
            $arrData = $this->model->selectDescuentoPorPuntos($porpuntos);
            for ($i=0; $i < count($arrData); $i++) {
                $cont++;
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';
                $arrData[$i]['cont'] = $cont;

                if($arrData[$i]['ptipo'] == "Puntos")
                {
                    $arrData[$i]['ptipo'] = '<span class="badge badge-info"> Puntos </span>';
                    $arrData[$i]['descuento'] = 'S/'.$arrData[$i]['ppuntos'].' <span class="badge badge-pill badge-primary"> -'.$arrData[$i]['descuento'].' %</span>';

                }if($arrData[$i]['ptipo'] == "Cupón libre")
                {
                    $arrData[$i]['ptipo'] = '<span class="badge badge-dark"> '.$arrData[$i]['ptipo'].' </span>';
                    $arrData[$i]['descuento'] = '<span class="badge badge-pill badge-primary"> -'.$arrData[$i]['descuento'].' %</span>';


                }if($arrData[$i]['ptipo'] == "Envio gratis")
                {
                    $arrData[$i]['ptipo'] = '<span class="badge badge-success"> '.$arrData[$i]['ptipo'].' </span>';
                    $arrData[$i]['descuento'] = '<b> A partir de: S/'.$arrData[$i]['ppuntos'].'</b>';
                    $arrData[$i]['fvigencia'] = '-';
                    $arrData[$i]['codigo'] = '-';


                }
                
                if($arrData[$i]['status'] == 1){
                    $arrData[$i]['status'] = '<span class="badge badge-success"> Activo </span>';
                }else if ($arrData[$i]['status'] == 2){
                    
                    $arrData[$i]['status'] = '<span class="badge badge-danger"> Inactivo </span>';
                }
                else{
                    $arrData[$i]['status'] = '<span class="badge badge-warning"> Usado </span>';
                }
                if($_SESSION['permisosMod']['u']){
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditPuntos(this,'.$arrData[$i]['id_cupon'].')" title="Editar descuento por producto"><i class="fas fa-pencil-alt"></i></button>';
                }
                if($_SESSION['permisosMod']['d']){	
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelPuntos('.$arrData[$i]['id_cupon'].')" title="Eliminar descuento por producto"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setDescuentoPorPuntos()
    {
        // dep($_POST); exit();
        if($_POST){			
            if(empty($_POST['tipopuntos'])||  empty($_POST['cod_cupon']) || empty($_POST['descuentopertenece']))
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');

            }else{ 


                $idDescuentoAdd = intval($_POST['idDescuentoAdd']);
                $puntos = intval($_POST['puntos']);
                $tipopuntos = strClean($_POST['tipopuntos']);
                $estadop = strClean($_POST['estadop']);
                $descuento = intval($_POST['descuento']);
                $cod_cupon = strClean($_POST['cod_cupon']);
                $fvalido = $_POST['fvalido'];
                $descuentopertenece = $_POST['descuentopertenece'];
                $request_user = "";
                
                if($fvalido== "0000-00-00" || $fvalido=="" || $fvalido == null){
                    $fvalido="1970-01-01";

                }


                if($idDescuentoAdd == "" || $idDescuentoAdd==0){
                    $option = 1;
                    if($_SESSION['permisosMod']['w']){
                        $request_user = $this->model->insertDescuentoPorPuntos($tipopuntos,
                                                                                $puntos,
                                                                                $descuento,
                                                                                $cod_cupon,
                                                                                $fvalido,
                                                                                $estadop,
                                                                                $descuentopertenece);
                    }
                }else{
                    $option = 2;
                    if($_SESSION['permisosMod']['u']){
                        $request_user = $this->model->UpdateDescuentoPorPuntos($idDescuentoAdd,
                                                                                $tipopuntos,
                                                                                $puntos,
                                                                                $descuento,
                                                                                $cod_cupon,
                                                                                $fvalido,
                                                                                $estadop);
                    }

                }

                if($request_user > 0 )
                {
                    if($option == 1){
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    }else{
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                }else if ($request_user == 'existtipopuntos'){
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya se aplicó descuento de ese tipo.');	
                }else 
                if($request_user == 'exist'){
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya se aplicó un descuento a este producto.');		
                }
                else{
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function delDescuentoPorPuntos()
    {
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $intIdPuntosDes = intval($_POST['idPuntosDes']);
                $requestDelete = $this->model->deletePuntosDescuento($intIdPuntosDes);
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
    public function getDescuentoPorPuntosRegistrados($idDescuentoPuntos)
    {
        if($_SESSION['permisosMod']['r']){
            $intIdDescPuntos = intval($idDescuentoPuntos);
            if($intIdDescPuntos > 0)
            {
                $arrData = $this->model->selectDescuentoPorPuntosRegistrados($intIdDescPuntos);
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
    public function setDescAgregar()
    {
        // dep($_POST); exit();
        if($_SESSION['permisosMod']['r']){
            $strCodCUpon = strClean($_POST['cod']);
            $intId = intval($_POST['id']);
            if($intId != "")
            {
                $arrData = $this->model->updatecodcuponadd($strCodCUpon,$intId);
                if(empty($arrData))
                {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else{
                    $arrResponse = array('status' => true, 'data' => 'Cupón asignado.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    }
?>