<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');
	include_once(INCLUDE_PATH.'class/class.parametro.php');
		
	

	class premio extends DB {
	    
	    public function getPremioId($premio_id){
			if(!empty($premio_id) && is_numeric($premio_id)){
				$sql 	= "SELECT * FROM premio WHERE premio_id = $premio_id LIMIT 1";
	        	return DB::getRow($sql);
			}
			return false;		
	    }

	    public function getPremioByUniqid($prem_uniqid){
			if(!empty($prem_uniqid) && is_string($prem_uniqid)){
				$sql 	= "SELECT DATE_FORMAT(prem_fecha,'%d%m') prem_fecha, premio_id FROM premio WHERE prem_uniqid = '$prem_uniqid' LIMIT 1";
	        	return DB::getRow($sql);
			}
			return false;		
	    }

		public function getPremioTotal(){
			$prem_fecha = date('Y-m-d');
			//$prem_fecha = '2022-07-07';
			
			$sql 	= "SELECT * FROM premio WHERE prem_estado = 'P' AND cliente_id IS NULL AND prem_fecha = '$prem_fecha' AND clie_fecha IS NULL LIMIT 1";
	        return DB::getRow($sql);
		}


	    public function getPremioByIntento($prem_intento){
			$prem_fecha = date('Y-m-d');
			$sql 	= "SELECT * FROM premio WHERE prem_intento = $prem_intento AND prem_fecha = '$prem_fecha' AND prem_estado = 'P' AND cliente_id IS NULL AND clie_fecha IS NULL LIMIT 1";
	        return DB::getRow($sql);
		}

	    public function savePremio($data){
        	extract($data);
        	$premio_id 		= (int) $premio_id;
	        $prem_intento 	= (int) $prem_intento;
	        $prem_orden 	= (int) $prem_orden;
	        $prem_fecha 	= date2sql($prem_fecha);
	        
	        $sql = "SELECT COUNT(*) FROM premio WHERE premio_id = $premio_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE premio SET prem_tipo = '$prem_tipo', prem_nombre = '$prem_nombre', prem_intento='$prem_intento', prem_fecha='$prem_fecha', prem_orden = $prem_orden, prem_estado = '$prem_estado' WHERE premio_id=$premio_id";
	        } else {
	        	$sql = "INSERT INTO premio (prem_tipo, prem_nombre, prem_intento, prem_fecha, prem_orden, prem_estado) VALUES ('$prem_tipo', '$prem_nombre', '$prem_intento', '$prem_fecha', $prem_orden, '$prem_estado')";
	        }
	        return DB::query($sql);
	    }


	    public function savePremioGanador($premio_id, $cliente_id, $factura_id, $fact_numero = 0){
	    	if(!empty($premio_id) && is_numeric($premio_id) && !empty($cliente_id) && is_numeric($cliente_id) && !empty($factura_id) && is_numeric($factura_id)){
	    		$sql = "SELECT COUNT(*) FROM premio WHERE premio_id = $premio_id";
		        if (DB::getOne($sql)) {
		        	$clie_fecha 	= date('Y-m-d H:i:s');
		        	$prem_uniqid 	= uniqid('premio_');
		            $sql = "UPDATE premio SET prem_estado = 'A', cliente_id = $cliente_id, clie_fecha='$clie_fecha', fact_numero='$fact_numero', factura_id = $factura_id, prem_uniqid = '$prem_uniqid' WHERE premio_id=$premio_id";
		        }
		        return DB::query($sql);
	    	}
	    	return false;
	    }


		public function getPremioAll(){
			$sql	= "SELECT * FROM premio ORDER BY prem_fecha ASC";
			return 	DB::getAll( $sql );
		}


		public function getPremioListado(){
			$sql = "SELECT 
					P.*,
					C.clie_rut,
					C.clie_nombre,
					C.clie_vendedor
				FROM premio P
				LEFT JOIN cliente C ON (C.cliente_id = P.cliente_id)
				WHERE 
					P.prem_estado = 'P' OR P.prem_estado = 'A'
				ORDER BY prem_fecha, prem_intento ASC";

			return DB::getAll($sql);

		}
		public function getPremioAllByTipo($prem_tipo){
			if(!empty($prem_tipo) && is_string($prem_tipo)){
				$sql	= "SELECT * FROM premio ORDER BY premio_id ASC";
				return 	DB::getAll( $sql );
			}
			return false;
		}


		public function getWinner($cliente_id, $factura_id){
			if(!empty($cliente_id) && !empty($factura_id)){
				$premio_id 	= (int) $premio_id;
				$factura_id = (int) $factura_id;

				$sql = "SELECT prem_uniqid FROM premio WHERE cliente_id = $cliente_id AND factura_id = $factura_id AND prem_estado = 'A' ORDER BY clie_fecha DESC LIMIT 1";
				return DB::getOne($sql);
			}
			return false;
		}

		public function getPremioAllByTipoByFecha($prem_tipo){
			if(!empty($prem_tipo) && is_string($prem_tipo)){
				$prem_fecha = date('Y-m-d');
				$sql	= "SELECT * FROM premio WHERE prem_fecha = '$prem_fecha' ORDER BY premio_id ASC";
				return 	DB::getRow( $sql );
			}
			return false;
		}

		public function getGanadoresJunio(){
			$parametro = new parametro();
			$dia = $parametro->getParametroByCodigo('JUNIO');
			$sql = "SELECT 
						P.prem_fecha,
						P.prem_nombre,
						P.cliente_id,
						IF( R.regi_nombre IS NULL, C.clie_nombre, CONCAT(R.regi_nombre, ' ', R.regi_apellido) ) as regi_nombre
					FROM premio P 
					INNER JOIN cliente C ON (C.cliente_id = P.cliente_id) 
					LEFT JOIN registro R ON (R.premio_id = P.premio_id)
					WHERE 
						P.prem_estado = 'A' 
						AND P.prem_fecha >= '2023-06-01' AND P.prem_fecha <= '2023-06-".$dia."' 
					GROUP BY 
						P.premio_id
					ORDER BY 
						P.prem_fecha DESC";
			return 	DB::getAll( $sql );
		}



		public function getGanadoresJulio(){
			$parametro = new parametro();
			$dia = $parametro->getParametroByCodigo('JULIO');
			$sql = "SELECT 
						P.prem_fecha,
						P.prem_nombre,
						P.cliente_id,
						IF( R.regi_nombre IS NULL, C.clie_nombre, CONCAT(R.regi_nombre, ' ', R.regi_apellido) ) as regi_nombre
					FROM premio P 
					INNER JOIN cliente C ON (C.cliente_id = P.cliente_id) 
					LEFT JOIN registro R ON (R.premio_id = P.premio_id)
					WHERE 
						P.prem_estado = 'A' 
						AND P.prem_fecha >= '2023-07-01' AND P.prem_fecha <= '2023-08-03'
					GROUP BY 
						P.premio_id
					ORDER BY 
						P.prem_fecha DESC";
			return 	DB::getAll( $sql );
		}

		public function getCountPremioByMes($cliente_id){
			if(!empty($cliente_id) && is_numeric($cliente_id)){
				$sql	= "SELECT COUNT(*) FROM premio WHERE cliente_id = '$cliente_id' AND MONTH(clie_fecha) = MONTH(now()) AND YEAR(clie_fecha) = YEAR(now()) AND prem_estado = 'A'";
				return 	(int) DB::getOne( $sql );
			}
			return false;
		}

		public function deletePremioId($premio_id){
			if(!empty($premio_id) && is_numeric($premio_id)){
				$delete = array('premio_id' => $premio_id);
	        	return DB::delete('premio', $delete, 1 );
			}
			return false;
		}

	}
?>