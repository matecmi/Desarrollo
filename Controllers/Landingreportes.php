<?php 
		session_start();

class Landingreportes extends Controllers{
	public function __construct()
	{
		parent::__construct();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MDLANDINGPAGESREPORTES);
	}
    public function Landingreportes()
    {
        if(empty($_SESSION['permisosMod']['r'])){
            header("Location:".base_url().'/dashboard');
        }
        $data['page_tag'] = "Landingreportes";
        $data['page_title'] = "REPORTES LANDING PAGES - <small>Tienda Virtual</small>";
        $data['page_name'] = "landingreportes";
        $data['page_functions_js'] = "functions_landingreportes.js";
        $data['landing'] = $this->model->getLandingPagesAll();
        $this->views->getView($this,"landingreportes",$data);
    }

    public function getReportesDinamicos($idReporte){
		if($_SESSION['permisosMod']['r']){
			$reporteId = intval($idReporte);
			if($reporteId > 0)
			{
				$arrData = $this->model->selectReporte($reporteId);
				$arrDataCampos = $this->model->selectCampoLanding($reporteId);


                $contador = 0;
                $tabla = '
                <table id="bootstrap-data-table-export" class="table table-striped">
        
                <thead>
                <tr>';


                $columnas = json_decode($arrDataCampos[0]["formulario"])->array_data->rpta;
                $columnas2 = json_decode($arrDataCampos[0]["formulario"])->array_select->rpta;
                foreach ($columnas2 as $sel) {
                        array_push($columnas, $sel->nombreinput); //agrupo todo los campos dinamicos
                }

                
              
                foreach ($columnas as $colum) {


                    $contador = $contador + 1;
                    $tabla .= '
                        <th>' . $colum . '</th>
                    ';
                }


                $tabla .= '
                    </tr></thead>
                    <tbody>';




                $k = 0;
                foreach ($arrData as $value) {


        
                    if ($k == 0) {
                        $tabla .= '<tr>';
                        $tabla .= '<th>' . $value["valor"] . '</th>';
                        $k = $k + 1;
                    } else if ($k == $contador) {
                        $tabla .= '</tr>';
                        $tabla .= '<tr>';
                        $tabla .= '<th>' . $value["valor"] . '</th>';
                        $k = 1;
                    } else {
                        $tabla .= '<th>' . $value["valor"] . '</th>';
                        $k = $k + 1;
                        //$tabla.='</tr>';
                    }
                }
                $tabla .= '</tbody></table>';




                
				// if(empty($arrData))
				// {
				// 	$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				// }else{
				// 	$arrResponse = array('status' => true, 'data' => $arrData);
				// }

				echo json_encode($tabla,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}


}




?>