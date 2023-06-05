<?php 
class LandingreportesModel extends Mysql
{

    private $intIdLndingpage;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getLandingPagesAll()
    {
        $sql = "SELECT id_landing, id_landing as ruta, tituloform, subtituloform, portadaprincipal, titulodes, subtitulodesc, descripcionlanding, imagin1desc, imagin2desc,formulario FROM landing";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectReporte(int $idLanding){
		$this->intIdLndingpage = $idLanding;
		$sql = "SELECT `id`, `valor`, `landingid`, `registro` FROM `registrodinamic`
                WHERE landingid  = $this->intIdLndingpage";
		$request = $this->select_all($sql);
		return $request;
	}

    public function selectCampoLanding(int $idLanding){
		$this->intIdLndingpage = $idLanding;
		$sql = "SELECT formulario FROM `landing` WHERE id_landing = $this->intIdLndingpage";
		$request = $this->select_all($sql);
		return $request;
	}

}


    ?>