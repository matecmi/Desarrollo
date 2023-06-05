<?php 
require_once("Libraries/Core/Mysql.php");
trait TLanding{
	private $con;
	private $intIdLanding;
	private $strValor;

	public function getLandingT(int $idLanding){
		$this->con = new Mysql();
		$this->intIdLanding = $idLanding;
		$sql = "SELECT id_landing, tituloform, subtituloform, portadaprincipal, titulodes, subtitulodesc, descripcionlanding, imagin1desc, imagin2desc, formulario  FROM landing WHERE id_landing = $idLanding";
		$request = $this->con->select($sql);
		return $request;
	}

	public function getProductosLandingT(int $idLanding){
		$this->con = new Mysql();
		$this->intIdLanding = $idLanding;
		$sql = "SELECT p.idproducto, p.nombre as producto,p.precio, i.img as images,p.ruta FROM landing as l
				INNER JOIN producto_landing pl
				ON pl.id_landing = l.id_landing
				INNER JOIN producto p
				on pl.id_producto = p.idproducto
				INNER JOIN imagen i
				ON i.productoid = p.idproducto
				WHERE l.id_landing= $idLanding";
		$request = $this->con->select_All($sql);
		return $request;
	}
	public function selectLandingPageAll()
    {
		$this->con = new Mysql();
        $sql = "SELECT id_landing, id_landing as ruta, tituloform, subtituloform, portadaprincipal, titulodes, subtitulodesc, descripcionlanding, imagin1desc, imagin2desc,formulario FROM landing";
        $request = $this->con->select_all($sql);
        return $request;
    }

    public function addformdinamic(string $value, int $id){
		$this->con = new Mysql();
        $return = 0;
        $this->strValor = $value;
        $this->intIdLanding = $id;

            $query_insert  = "INSERT INTO registrodinamic(valor, landingid) VALUES(?,?)";
            $arrData = array($this->strValor, 
                             $this->intIdLanding);
            $request_insert = $this->con->insert($query_insert,$arrData);
            $return = $request_insert;
       
        return $return;
    }
}

 ?>