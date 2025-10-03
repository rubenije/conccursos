<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	
	

	class intento extends DB {
	    
	    public function getIntentoId($intento_id){
			if(!empty($intento_id) && is_numeric($intento_id)){
				$sql 	= "SELECT * FROM intento WHERE intento_id = $intento_id LIMIT 1";
	        	return DB::getRow($sql);
			}
			return false;		
	    }

	    public function getIntentoByClienteIdFacturaId($cliente_id, $factura_id){
			if(!empty($cliente_id) && is_numeric($cliente_id) && !empty($factura_id) && is_numeric($factura_id)){
				$inte_fecha = date('Y-m-d');
				$sql 		= "SELECT COUNT(*) FROM intento WHERE cliente_id = $cliente_id AND factura_id = $factura_id LIMIT 1";
	        	return (int) DB::getOne($sql);
			}
			return false;		
	    }



	    public function getIntentoByClienteIdNumero($cliente_id, $fact_numero){
			if(!empty($cliente_id) && is_numeric($cliente_id) && !empty($fact_numero)){
				$inte_fecha = date('Y-m-d');
				$sql 		= "SELECT COUNT(*) FROM intento WHERE cliente_id = $cliente_id AND fact_numero = '$fact_numero' LIMIT 1";
	        	return (int) DB::getOne($sql);
			}
			return false;		
	    }

	    public function getIntentoByClienteId($cliente_id){
			if(!empty($cliente_id) && is_numeric($cliente_id)){
				$inte_fecha = date('Y-m-d');
				$sql 		= "SELECT COUNT(*) FROM intento WHERE cliente_id = $cliente_id LIMIT 1";
	        	return DB::getOne($sql);
			}
			return false;		
	    }


	    public function getIntentoByFecha(){
			$inte_fecha = date('Y-m-d');
			$sql 		= "SELECT COUNT(*) FROM intento WHERE inte_fecha = '$inte_fecha' LIMIT 1";
        	return DB::getOne($sql);
		}


		public function getIntentoTotal(){
			$sql 		= "SELECT COUNT(*) 
							FROM intento I
							LIMIT 1";
        	return DB::getOne($sql);
		}


		public function saveIntento($data){
        	extract($data);
        	$intento_id 	= (int) $intento_id;
	        $cliente_id 	= (int) $cliente_id;
			$factura_id 	= (int) $factura_id;


	        
	        $sql = "SELECT COUNT(*) FROM intento WHERE intento_id = $intento_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE intento SET cliente_id = $cliente_id, factura_id = $factura_id, inte_fecha='$inte_fecha', inte_hora='$inte_hora' WHERE intento_id=$intento_id";
	        } else {
	        	$inte_fecha 	= date('Y-m-d');
	        	$inte_hora 		= date('H:i:s');
	        	$sql = "INSERT INTO intento (cliente_id, factura_id, inte_fecha, inte_hora, fact_numero) VALUES ($cliente_id, $factura_id, '$inte_fecha', '$inte_hora', '$fact_numero')";
	        }
	        return DB::query($sql);
	    
	    }

	    public function getIntentoAll(){
			$sql	= "SELECT * FROM intento ORDER BY intento_id ASC";
			return 	DB::getAll( $sql );
		}


		public function deleteIntentoId($intento_id){
			if(!empty($intento_id) && is_numeric($intento_id)){
				$delete = array('intento_id' => $intento_id);
	        	return DB::delete('intento', $delete, 1 );
			}
			return false;
		}


		/* INI INFORME CARLITA */
		public function getInformeGU(){
			$sql = "SELECT cliente_id FROM intento GROUP BY cliente_id";
			$elements = DB::getAll( $sql );
			return count($elements);
		}

		public function getInformeGT(){
			$sql = "SELECT COUNT(*) as contador 
					FROM intento I 
					INNER JOIN cliente C ON (C.cliente_id = I.cliente_id) 
					INNER JOIN factura F ON (F.factura_id = I.factura_id)
					LIMIT 1";
			return DB::getOne($sql);
		}

		public function getInformeGiros(){
			$sql = "SELECT 
						C.cliente_id,
						C.clie_rut,	
						C.clie_nombre,
						( SELECT SUM(F.fact_intento) FROM factura F WHERE F.cliente_id = C.cliente_id ) as giros_totales,
						COUNT(I.intento_id) as giros_realizados
					FROM cliente C
						INNER JOIN intento I ON (C.cliente_id = I.cliente_id) 
					GROUP BY 
						C.cliente_id
					ORDER BY 	
						C.clie_nombre";
			return DB::getAll( $sql );
		}

		public function getGirosByDia(){
			$sql = "SELECT 
						COUNT(*) as giros,
						I.inte_fecha
					FROM intento I
					INNER JOIN cliente C ON (C.cliente_id = I.cliente_id) 
					INNER JOIN factura F ON (F.factura_id = I.factura_id)
					GROUP BY
						I.inte_fecha 
					ORDER BY 
						I.inte_fecha DESC";
        	return DB::getAll($sql);
		}
		/* END INFORME CARLITA */
	}
?>