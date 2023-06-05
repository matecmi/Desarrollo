<?php 
class LandingpagesModel extends Mysql
{

    private $intIdLndingpage;
    private $intIdProducto;
    private $strtituloformulario;
    private $strsubtituloformulario;
    private $strtitulodescripcion;
    private $strsubtitulodescripcion;
    private $strdescripcionstatus;
    private $strPortada;
    private $strPortada1;
    private $strPortada2;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectLandingPage()
    {
        $sql = "SELECT id_landing, id_landing as ruta, tituloform, subtituloform, portadaprincipal, titulodes, subtitulodesc, descripcionlanding, imagin1desc, imagin2desc,formulario FROM landing";
        $request = $this->select_all($sql);
        return $request;
    }
    public function inserLanding(string $tituloformulario, string $subtituloformulario, string $titulodescripcion, string $subtitulodescripcion, string $descripcionstatus, string $imgPortada,string $imgPortada1,string $imgPortada2){

        $return = 0;
        $this->strtituloformulario = $tituloformulario;
        $this->strsubtituloformulario = $subtituloformulario;
        $this->strtitulodescripcion = $titulodescripcion;
        $this->strsubtitulodescripcion = $subtitulodescripcion;
        $this->strdescripcionstatus = $descripcionstatus;
        $this->strPortada = $imgPortada;
        $this->strPortada1 = $imgPortada1;
        $this->strPortada2 = $imgPortada2;

            $query_insert  = "INSERT INTO landing(tituloform, subtituloform, portadaprincipal, titulodes, subtitulodesc, descripcionlanding,imagin1desc,imagin2desc) VALUES(?,?,?,?,?,?,?,?)";
            
            
            $arrData = array($tituloformulario, 
                             $subtituloformulario, 
                             $titulodescripcion,
                             $subtitulodescripcion,
                             $descripcionstatus, 
                             $imgPortada,
                             $imgPortada1,
                             $imgPortada2);
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
       
        return $return;
    }
    public function selectLandingPageProd(int $idprod)
	{
		$sql = "SELECT pl.id as prod_lan_id,p.idproducto,p.nombre,p.precio
                FROM producto_landing as pl
                INNER JOIN producto p
                ON pl.id_producto = p.idproducto
                INNER JOIN landing l
                ON pl.id_landing = l.id_landing
                WHERE l.id_landing =$idprod"; 
		$request = $this->select_all($sql);
		return $request;
	}
    public function insertProductoLanding(int $idproducto,int $idlanding){
        $this->intIdProducto = $idproducto;
        $this->intIdLndingpage = $idlanding;
        $return = 0;
            $sql = "SELECT * FROM producto_landing WHERE id_landing= $this->intIdLndingpage AND id_producto= $this->intIdProducto";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                $query_insert  = "INSERT INTO producto_landing(id_producto,
                                                        id_landing) 
                                  VALUES(?,?)";
                $arrData = array($this->intIdProducto,
                                $this->intIdLndingpage);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "existtipopuntos";
            }

        
        return $return;
    }
    public function deleteProductoLanding(int $idProdLan){
        $sql_detalle = "SELECT * FROM producto_landing WHERE id = $idProdLan";
        $requestProductos = $this->select($sql_detalle);
        if(!empty($requestProductos)){
            $sql = "DELETE FROM producto_landing WHERE id  = $idProdLan ";
            $arrData = array(0);
            $request = $this->delete($sql,$arrData);

            return $request;
        }
    }
	public function insertAddFormularioLanding(int $idlanding, string $registro){

        
		$sql = "SELECT * FROM landing WHERE id_landing =  $idlanding";
        $request = $this->select_all($sql);

        if(!empty($request))
		{
            $sql_update = "UPDATE landing SET formulario = ? WHERE id_landing = $idlanding";
            $arrData = array($registro);
            $request_insert = $this->update($sql_update,$arrData);
        	$return = $request_insert;


		}else{
			$return = "noexist";
		}
        return $return;

    }
    public function deleteLP(int $idLanding){
        $this->intIdLndingpage = $idLanding;

        $sql_detalle = "SELECT * FROM producto_landing WHERE id_landing = $this->intIdLndingpage";
        $requestLP = $this->select_all($sql_detalle);
        if(!empty($requestLP)){
			$return = "nodeleted";//Tiene productos registrados
        }else{
            $sql = "DELETE FROM landing WHERE id_landing  = $this->intIdLndingpage ";
            $arrData = array(0);
            $this->delete($sql,$arrData);
			$return = "deleted";//Tiene productos registrados
            
        }

        return $return;
    }
    public function selectLanding(int $idLanding){
		$this->intIdLndingpage = $idLanding;
		$sql = "SELECT id_landing, tituloform, subtituloform, portadaprincipal,portadaprincipal as rutaimagenprincipal, titulodes, subtitulodesc, descripcionlanding, imagin1desc, imagin2desc, formulario 
                FROM landing
				WHERE id_landing = $this->intIdLndingpage";
		$request = $this->select($sql);
		return $request;
	}
    public function updateLanding(int $idlandingpage, string $tituloformulario, string $subtituloformulario, string $titulodescripcion, string $subtitulodescripcion, string $descripcionstatus, string $imgPortada,string $imgPortada1,string $imgPortada2){
        $this->intIdLndingpage = $idlandingpage;
        $this->strtituloformulario = $tituloformulario;
        $this->strsubtituloformulario = $subtituloformulario;
        $this->strtitulodescripcion = $titulodescripcion;
        $this->strsubtitulodescripcion = $subtitulodescripcion;
        $this->strdescripcionstatus = $descripcionstatus;
        $this->strPortada = $imgPortada;
        $this->strPortada1 = $imgPortada1;
        $this->strPortada2 = $imgPortada2;

        // $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}' AND idcategoria != $this->intIdcategoria";
        // $request = $this->select_all($sql);

        // if(empty($request))
        // {
            $sql = "UPDATE landing SET tituloform = ?, subtituloform = ?, portadaprincipal = ?, titulodes = ?, subtitulodesc = ?,descripcionlanding = ?,imagin1desc = ?,imagin2desc = ? WHERE id_landing  = $this->intIdLndingpage ";
            $arrData = array($this->strtituloformulario, 
                             $this->strsubtituloformulario, 
                             $this->strtitulodescripcion, 
                             $this->strsubtitulodescripcion, 
                             $this->strdescripcionstatus, 
                             $this->strPortada, 
                             $this->strPortada1, 
                             $this->strPortada2);
            $request = $this->update($sql,$arrData);
        // }else{
        //     $request = "exist";
        // }
        return $request;			
    }
}


?>