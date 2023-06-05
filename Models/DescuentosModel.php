<?php 
class DescuentosModel extends Mysql
{

    private $intIdDescuentos;
    private $intProdId;
    private $strDescuentos;
    private $intNuevoTotal;
    private $strDescuentoPertenece;
    private $dateFechaVigencia;

    private $strTipoPuntos;
    private $strCodCupon;
    private $intPuntos;
    private $intEstado;


    public function __construct()
    {
        parent::__construct();
    }
    public function selectDescuentoPorProducto($porproducto){
        $this->strDescuentoPertenece = $porproducto;
        $sql = "SELECT de.id_cupon,
                de.id_cupon as cont,
                de.prod_id,
                de.descuento,
                de.nuevo_total,
                de.fvigencia,
                p.nombre,
                p.precio
                FROM descuentos as de
                INNER JOIN producto p
                ON de.prod_id=p.idproducto                    
                WHERE descuento_pertenece = '{$porproducto}' AND de.status !='0' ORDER BY de.id_cupon DESC";
                $request = $this->select_all($sql);
        return $request;
    }
    public function deleteProductoDescuento(int $idproductoDel){
        $this->intIdDescuentos = $idproductoDel;

        $sql_detalle = "SELECT de.prod_id
                        FROM descuentos as de
                        INNER JOIN producto p
                        ON de.prod_id=p.idproducto  
                        WHERE  de.id_cupon = $this->intIdDescuentos";
        $requestProductos = $this->select($sql_detalle);
        if(!empty($requestProductos)){
            $id = $requestProductos['prod_id'];
            $sql = "DELETE FROM descuentos WHERE id_cupon  = $this->intIdDescuentos ";
            $arrData = array(0);
            $request = $this->delete($sql,$arrData);
            $query_update  = "UPDATE producto SET estado_descuento = ?  WHERE idproducto = $id ";
            $arrDatas = array(Null);
            $this->update($query_update,$arrDatas);
        }

        return $request;
    }
    public function insertDescuentoProducto(int $intIdProducto, int $intDescuento, int $intTotalPagar, string $strDescuentoPertenece, string $vigenciaProducto){
        $this->intProdId = $intIdProducto;
        $this->strDescuentos = $intDescuento;
        $this->intNuevoTotal = $intTotalPagar;
        $this->dateFechaVigencia = $vigenciaProducto;
        $this->strDescuentoPertenece = $strDescuentoPertenece;
        $return = 0;
        $sql = "SELECT * FROM producto WHERE idproducto = $this->intProdId AND estado_descuento = 'condescuento'";
        $request = $this->select_all($sql);
        if(empty($request))
        {
            $query_insert  = "INSERT INTO descuentos(prod_id,
                                                    descuento,
                                                    nuevo_total,
                                                    fvigencia,
                                                    descuento_pertenece) 
                              VALUES(?,?,?,?,?)";
            $arrData = array($this->intProdId,
                            $this->strDescuentos,
                            $this->intNuevoTotal,
                            $this->dateFechaVigencia,
                            $this->strDescuentoPertenece);
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = "exist";
        }
        return $return;
    }
    public function updateDescuentoProducto(int $idDescuento, int $intIdProducto, int $intDescuento, int $intTotalPagar, $vigenciaProducto){
        $this->intIdDescuentos = $idDescuento;
        $this->intProdId = $intIdProducto;
        $this->strDescuentos = $intDescuento;
        $this->intNuevoTotal = $intTotalPagar;
        $return = 0;
        $sql = "UPDATE descuentos 
                SET prod_id=?,
                    descuento=?,
                    fvigencia=?,
                    nuevo_total=?
                WHERE id_cupon  = $this->intIdDescuentos ";
        $arrData = array($this->intProdId,
                        $this->strDescuentos,
                        $vigenciaProducto,
                        $this->intNuevoTotal);

        $request = $this->update($sql,$arrData);
        $return = $request;
    
        return $return;
    }
    public function updateProductoDescuento(int $intIdProducto,$estadoAlteradoDescuento){
        $this->con = new Mysql();
        $this->intProdId = $intIdProducto;
        $query_update  = "UPDATE producto SET estado_descuento = ?  WHERE idproducto = $this->intProdId ";
        $request_insert = $this->con->update($query_update,array($estadoAlteradoDescuento));
        return $request_insert;
    }
    public function selectDescuentoPorProductoRegistrados($porproducto){
        $this->strDescuentoPertenece = $porproducto;
        $sql = "SELECT de.id_cupon,
                de.id_cupon  as cont,
                de.prod_id,
                de.descuento,
                de.nuevo_total,
                de.fvigencia,
                de.descuento_pertenece,
                p.nombre,
                p.precio
                FROM descuentos as de
                INNER JOIN producto p
                ON de.prod_id=p.idproducto 
                WHERE id_cupon = $this->strDescuentoPertenece";
                $request = $this->select($sql);
        return $request;
    }
    //POR PUNTOS
    public function selectDescuentoPorPuntos($porpuntos){
        $this->strDescuentoPertenece = $porpuntos;
        $sql = "SELECT id_cupon,
                id_cupon as cont,
                descuento,
                fvigencia,
                ptipo,
                ppuntos,
                codigo,
                status
                FROM descuentos 
                WHERE descuento_pertenece = '{$porpuntos}'
                AND status !='0' ORDER BY id_cupon DESC";
                $request = $this->select_all($sql);
        return $request;
    }
    public function insertDescuentoPorPuntos(string $tipopuntos,int $puntos, string $descuento, string $cod_cupon, string $fvalido,int $estadop, string $descuentopertenece){
        $this->strTipoPuntos = $tipopuntos;
        $this->intPuntos = $puntos;
        $this->strDescuentos = $descuento;
        $this->strCodCupon = $cod_cupon;
        $this->dateFechaVigencia = $fvalido;
        $this->intEstado = $estadop;
        $this->strDescuentoPertenece = $descuentopertenece;
        $return = 0;
        if($this->strTipoPuntos == "Puntos" || $this->strTipoPuntos == "Envio gratis"){
            $sql = "SELECT * FROM descuentos WHERE ptipo = '{$this->strTipoPuntos}' AND descuento_pertenece = 'porpuntos'";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                $query_insert  = "INSERT INTO descuentos(descuento,
                                                        fvigencia,
                                                        ptipo,
                                                        ppuntos,
                                                        codigo,
                                                        status,
                                                        descuento_pertenece) 
                                  VALUES(?,?,?,?,?,?,?)";
                $arrData = array($this->strDescuentos,
                                $this->dateFechaVigencia,
                                $this->strTipoPuntos,
                                $this->intPuntos,
                                $this->strCodCupon,
                                $this->intEstado,
                                $this->strDescuentoPertenece);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "existtipopuntos";
            }

        }else{
            $query_insert  = "INSERT INTO descuentos(descuento,
                                                        fvigencia,
                                                        ptipo,
                                                        codigo,
                                                        status,
                                                        descuento_pertenece) 
                                  VALUES(?,?,?,?,?,?)";
                $arrData = array($this->strDescuentos,
                                $this->dateFechaVigencia,
                                $this->strTipoPuntos,
                                $this->strCodCupon,
                                $this->intEstado,
                                $this->strDescuentoPertenece);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
        }
        return $return;
    }

    public function UpdateDescuentoPorPuntos(int $idDescuentoAdd, string $tipopuntos,int $puntos, string $descuento, string $cod_cupon, string $fvalido,int $estadop){

        $this->intIdDescuentos = $idDescuentoAdd;
        $this->strTipoPuntos = $tipopuntos;
        $this->intPuntos = $puntos;
        $this->strDescuentos = $descuento;
        $this->strCodCupon = $cod_cupon;
        $this->dateFechaVigencia = $fvalido;
        $this->intEstado = $estadop;
        $return = 0;
        if($this->strTipoPuntos == "Puntos"){
            $sql = "UPDATE descuentos 
                    SET descuento=?,
                        fvigencia=?,
                        ppuntos=?,
                        status=?
                    WHERE id_cupon = $this->intIdDescuentos ";

            $arrData = array($this->strDescuentos,
                            $this->dateFechaVigencia,
                            $this->intPuntos,
                            $this->intEstado);

            $request = $this->update($sql,$arrData);
            $return = $request;

        }else if($this->strTipoPuntos == "Envio gratis"){

            $sql = "UPDATE descuentos 
                    SET descuento=?,
                        fvigencia=?,
                        ppuntos=?,
                        status=?
                    WHERE id_cupon = $this->intIdDescuentos ";

            $arrData = array($this->strDescuentos,
                            $this->dateFechaVigencia,
                            $this->intPuntos,
                            $this->intEstado);

            $request = $this->update($sql,$arrData);
            $return = $request;



        }
        
        
        else{
            $sql = "UPDATE descuentos 
                    SET descuento=?,
                        fvigencia=?,
                        status=?
                    WHERE id_cupon = $this->intIdDescuentos ";

            $arrData = array($this->strDescuentos,
                            $this->dateFechaVigencia,
                            $this->intEstado);

            $request = $this->update($sql,$arrData);
            $return = $request;

        }
    
        return $return;
    }
    public function selectDescuentoPorPuntosRegistrados($porpuntos){
        $this->intIdDescuentos = $porpuntos;
        $sql = "SELECT id_cupon,
                prod_id,
                descuento,
                nuevo_total,
                fvigencia,
                ptipo,
                ppuntos,
                codigo,
                descuento_pertenece,
                status FROM descuentos 
                WHERE id_cupon = $this->intIdDescuentos";
                $request = $this->select($sql);
        return $request;
    }
    public function deletePuntosDescuento(int $idPuntosDel){
        $this->intIdDescuentos = $idPuntosDel;

        $sql_detalle = "SELECT * FROM descuentos WHERE id_cupon = $this->intIdDescuentos";
        $requestProductos = $this->select($sql_detalle);
        if(!empty($requestProductos)){
            $sql = "DELETE FROM descuentos WHERE id_cupon  = $this->intIdDescuentos ";
            $arrData = array(0);
            $request = $this->delete($sql,$arrData);

            return $request;
        }
    }

    public function setCuponesDisponibles(){
        $sql = "SELECT * FROM descuentos 
                WHERE ptipo='Cupón libre'
                AND status !='0' ORDER BY id_cupon DESC";
                $request = $this->select_all($sql);
        return $request;
    }

    public function updatecodcuponadd($cod,$id){
        $this->con = new Mysql();
        $sql_detalle = "SELECT * FROM referidos WHERE id_referidos = $id";
        $requestIdRef = $this->select($sql_detalle);
        if(!empty($requestIdRef)){
            $sql_update = "UPDATE referidos SET cupon_cod = ?, estado = 'asignado'  WHERE id_referidos = $id";
            $request_insert = $this->con->update($sql_update,array($cod));
        }
        return $request_insert;
    }
    
}