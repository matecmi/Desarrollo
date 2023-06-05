<?php 
class CatalogosModel extends Mysql
{
    private $intId_catalogo ;
	private $strTitulo;
	private $strDescripcion;
	private $strFvigencia;
	private $intProd;


    public function selectCatalogos()
	{

		$sql = "SELECT id_catalogo, titulo, descripcion, fvigencia, status FROM catalogos WHERE status = 1"; 
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertCatalogo(string $strTitulo, string $strDescripcion, string $strFechaVigenciaz){

		$this->strTitulo = $strTitulo;
		$this->strDescripcion = $strDescripcion;
		$this->strFvigencia = $strFechaVigenciaz;
		$query_insert  = "INSERT INTO catalogos(titulo, descripcion, fvigencia) 
							VALUES(?,?,?)";
		$arrData = array($this->strTitulo,
						$this->strDescripcion,
						$this->strFvigencia);
		$request_insert = $this->insert($query_insert,$arrData);
		$return = $request_insert;
	
        return $return;
	}






	public function updateCatalogo(int $idCatalogo, string $strTitulo, string $strDescripcion, string $strFechaVigenciaz){

		$this->intId_catalogo = $idCatalogo;
		$this->strTitulo = $strTitulo;
		$this->strDescripcion = $strDescripcion;
		$this->strFvigencia = $strFechaVigenciaz;

		$sql = "SELECT id_catalogo, titulo, descripcion, fvigencia, status 
				FROM catalogos 
				WHERE id_catalogo = $this->intId_catalogo";
		$request = $this->select($sql);

		if(!empty($request))
		{
		
			$sql = "UPDATE catalogos SET titulo=?, descripcion=?, fvigencia=?
					WHERE id_catalogo = $this->intId_catalogo ";
			$arrData = array($this->strTitulo,
							$this->strDescripcion,
							$this->strFvigencia);
			$request = $this->update($sql,$arrData);
		}else{
			$request = "noexist";
		}
		return $request;
	}


	public function selectCatalogo(int $idcata){
		$this->intId_catalogo = $idcata;
		$sql = "SELECT id_catalogo, titulo, descripcion, fvigencia, status 
				FROM catalogos 
				WHERE id_catalogo = $this->intId_catalogo";
		$request = $this->select($sql);
		return $request;
	}









	public function selectCatalogoProd(int $idprod)
	{

		$this->intProd = $idprod;
		$sql = "SELECT c.id_catalogo,cp.id_catalogo_productos,  c.titulo, c.descripcion, c.fvigencia,cp.id_prod,p.*
				FROM catalogos as c
				INNER JOIN catalogo_productos cp
				ON cp.id_cat=c.id_catalogo
				INNER JOIN producto p
				ON cp.id_prod = p.idproducto
				WHERE cp.id_cat= $this->intProd"; 
		$request = $this->select_all($sql);
		return $request;
	}
	public function deleteCatalogoProducto(int $idCatProd){
        $sql_detalle = "SELECT * FROM catalogo_productos WHERE id_catalogo_productos  = $idCatProd";
        $requestProductos = $this->select($sql_detalle);
        if(!empty($requestProductos)){
            $sql = "DELETE FROM catalogo_productos WHERE id_catalogo_productos  = $idCatProd ";
            $arrData = array(0);
            $request = $this->delete($sql,$arrData);

            return $request;
        }
    }
	public function insertCatalogoProducto(int $idcatalogo, int $idproducto){
        $this->intId_catalogo = $idcatalogo;
        $this->intProd = $idproducto;
        $return = 0;
            $sql = "SELECT * FROM catalogo_productos WHERE id_cat=$this->intId_catalogo AND id_prod= $this->intProd";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                $query_insert  = "INSERT INTO catalogo_productos(id_cat, id_prod) 
                                  VALUES(?,?)";
                $arrData = array($this->intId_catalogo,
                                $this->intProd);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "existtipopuntos";
            }

        
        return $return;
    }
	public function deleteCat(int $idcat){
        $this->intId_catalogo = $idcat;

        $sql_detalle = "SELECT * FROM `catalogo_productos` WHERE id_cat   = $this->intId_catalogo";
        $requestLP = $this->select($sql_detalle);
        if(!empty($requestLP)){
			$return = "nodeleted";//Tiene productos registrados
        }else{
            $sql = "DELETE FROM catalogos WHERE id_catalogo   = $this->intId_catalogo ";
            $arrData = array(0);
            $this->delete($sql,$arrData);
			$return = "deleted";//Tiene productos registrados
            
        }

        return $return;
    }

}
