<?php 

	class EnviosModel extends Mysql
	{
		private $intIdEnvios;
		private $strDestino;
		private $intPrecio;
		private $intStatus;
		private $intIdDepartamento;
		private $intIdProvincia;

		public function __construct()
		{
			parent::__construct();
		}
		public function insertEnvio(string $destino, int $precio, int $status){

			$return = 0;
			$this->strDestino = $destino;
			$this->intPrecio = $precio;
			$this->intStatus = $status;

			$sql = "SELECT * FROM envios WHERE id_destino = $this->strDestino ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO envios(id_destino,precio,status) VALUES(?,?,?)";
	        	$arrData = array($this->strDestino, 
								 $this->intPrecio, 
								 $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}
		public function selectEnvios()
		{
			$sql = "SELECT id_envios, id_destino, precio, status,d.distrito as destino
					FROM envios as e
					INNER JOIN ubdistrito d
					ON e.id_destino = d.idDist
					WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectEnvio(int $idenvios){
			$this->intIdEnvios = $idenvios;
			$sql = "SELECT e.id_envios, e.id_destino, e.precio, e.status,dp.idDepa, d.idDist, p.idProv ,p.provincia as destino
					FROM envios as e 
					INNER JOIN ubdistrito d
					ON e.id_destino=d.idDist
					INNER JOIN ubprovincia p 
					ON d.idProv=p.idProv
					INNER JOIN ubdepartamento dp
					ON p.idDepa=dp.idDepa
					WHERE status != 0 AND id_envios = $this->intIdEnvios";
			$request = $this->select($sql);
			return $request;
		}
		public function updateEnvio(int $idenvios, string $destino, int $precio, int $status){
			$this->intIdEnvios = $idenvios;
			$this->strDestino = $destino;
			$this->intPrecio = $precio;
			$this->intStatus = $status;

			$sql = "SELECT * FROM envios WHERE id_destino = '{$this->strDestino}' AND id_envios  != $this->intIdEnvios";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE envios SET id_destino  = ?, precio = ?, status = ? WHERE id_envios = $this->intIdEnvios ";
				$arrData = array($this->strDestino, 
								 $this->intPrecio,
								 $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}
		public function deleteEnvio(int $intIdenvio)
		{
			$this->intIdEnvios = $intIdenvio;
			$sql = "DELETE FROM envios WHERE id_envios = $this->intIdEnvios ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			if($request)
			{
				$request = 'ok';	
			}else{
				$request = 'error';
			}
			return $request;
		}	

		
		public function selectUbiDepartamento()
		{

			$sql = "SELECT * FROM ubdepartamento";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectUbiProvincia(int $depaid)
		{
			$this->intIdDepartamento = $depaid;
			$sql = "SELECT * FROM ubprovincia WHERE idDepa = $this->intIdDepartamento";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectUbiDistrito(int $provaid)
		{
			$this->intIdProvincia = $provaid;
			$sql = "SELECT * FROM ubdistrito WHERE idProv = $this->intIdProvincia";
			$request = $this->select_all($sql);
			return $request;
		}
	}
 ?>