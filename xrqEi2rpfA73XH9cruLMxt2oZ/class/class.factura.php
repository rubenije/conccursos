<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');
	include_once(INCLUDE_PATH.'class/class.ingreso.php');
		
	

	class factura extends DB {
	    
	    public function getFacturaId($factura_id){
			if(!empty($factura_id) && is_numeric($factura_id)){
				$sql 	= "SELECT * FROM factura WHERE factura_id = $factura_id LIMIT 1";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }


	    public function getFacturaByNumero($fact_numero){
			if(!empty($fact_numero) && is_numeric($fact_numero)){
				$sql 	= "SELECT * FROM factura WHERE fact_numero = $fact_numero LIMIT 1";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function getFacturaIntentoByRut($clie_sin){
			if(!empty($clie_sin) && is_string($clie_sin)){
				$sql 	= "SELECT SUM(fact_intento) FROM factura WHERE clie_sin = '$clie_sin' LIMIT 1";
	        	return DB::getOne( $sql );
			}
			return false;		
	    }


	    public function getNumeroFacturaByClienteId($cliente_id){
	    	if(!empty($cliente_id) && is_numeric($cliente_id)){
	    		$sql = "SELECT F.fact_numero FROM factura F INNER JOIN intento I ON (F.fact_numero = I.fact_numero) WHERE I.cliente_id = $cliente_id GROUP BY F.fact_numero";
	    		return 	DB::getAll( $sql );
	    	}
	    	return false;

	    }

	    public function getFacturaByRut($clie_rut){
	    	$sql	= "SELECT * FROM factura WHERE clie_rut = '$clie_rut' ORDER BY factura_id ASC";
			
		}

		public function getFacturaByRuleta($clie_sin){
			if(!empty($clie_sin) && is_string($clie_sin)){
				$sql = "SELECT 
						C.cliente_id,
						F.factura_id,
						F.clie_rut,
					  	F.fact_numero,
						F.fact_intento,
						( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = C.cliente_id AND I.factura_id = F.factura_id ) as usado
						FROM factura F
						INNER JOIN cliente C ON (C.clie_sin = F.clie_rut) 
					WHERE 
						F.clie_rut = '$clie_sin' 
						AND ( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = C.cliente_id AND I.factura_id = F.factura_id ) <> F.fact_intento 
					ORDER BY F.fact_numero ASC";

				return 	DB::getAll( $sql );		
			}
			return false;
		}

		public function getFacturaByClienteIdByNumero($cliente_id, $fact_numero){
			if(!empty($cliente_id) && is_numeric($cliente_id) && !empty($fact_numero) && is_numeric($fact_numero)){
				$fact_numero = (int) $fact_numero;
				$sql = "SELECT 
						F.cliente_id,
						F.factura_id,
						F.fact_numero,
						F.fact_intento,
						( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = F.cliente_id AND I.fact_numero = F.fact_numero ) as usado
						FROM factura F
					WHERE 
						F.cliente_id = '$cliente_id' AND F.fact_numero = '$fact_numero'
						AND ( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = F.cliente_id AND I.fact_numero = F.fact_numero ) <> F.fact_intento 
					ORDER BY F.fact_numero ASC";
				
				$sql = "SELECT 
						F.cliente_id,
						F.factura_id,
						F.fact_numero,
						F.fact_intento,
						( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = F.cliente_id AND I.fact_numero = F.fact_numero ) as usado
						FROM factura F
					WHERE 
						F.cliente_id = '$cliente_id' AND F.fact_numero = '$fact_numero'
					ORDER BY F.fact_numero ASC";

				return 	DB::getRow( $sql );		
			}
			return false;
		}

		public function getFacturaByRuletaByNumero($clie_sin, $fact_numero){
			if(!empty($clie_sin) && is_string($clie_sin) && !empty($fact_numero) && is_numeric($fact_numero)){
				$fact_numero = (int) $fact_numero;
				$sql = "SELECT 
						F.cliente_id,
						F.factura_id,
						F.clie_rut,
					  	F.fact_numero,
						F.fact_intento,
						( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = F.cliente_id AND I.factura_id = F.factura_id ) as usado
						FROM factura F
					WHERE 
						F.clie_rut = '$clie_sin' AND F.fact_numero = '$fact_numero'
						AND ( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = F.cliente_id AND I.factura_id = F.factura_id ) <> F.fact_intento 
					ORDER BY F.fact_numero ASC";
				/*	
				$sql = "SELECT 
						C.cliente_id,
						F.factura_id,
						F.clie_rut,
					  	F.fact_numero,
						F.fact_intento,
						( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = C.cliente_id AND I.factura_id = F.factura_id ) as usado
						FROM factura F
						INNER JOIN cliente C ON (C.clie_sin = F.clie_rut) 
					WHERE 
						F.clie_rut = '$clie_sin' AND F.fact_numero = '$fact_numero'
						AND ( SELECT COUNT(*) FROM intento I WHERE I.cliente_id = C.cliente_id AND I.factura_id = F.factura_id ) <> F.fact_intento 
					ORDER BY F.fact_numero ASC";
				*/
				return 	DB::getRow( $sql );		
			}
			return false;
		}

		public function getListadoFacturas(){
			$sql = "SELECT 
				C.cliente_id,
				C.clie_rut,
				C.clie_sin,
				C.clie_fantasia,
				F.factura_id,
				F.fact_numero,
				F.fact_intento
			FROM factura F
			INNER JOIN cliente C ON (C.clie_sin = F.clie_rut)
			ORDER BY
				F.fact_intento DESC";

			return 	DB::getAll( $sql );		
		}

		public function saveClienteXX($data){
	    	extract($data);
        	$cliente_id 				= (int) $cliente_id;
        	$clie_rut 					= (int) $clie_rut;
        	$clie_tipo 					= (int) $clie_tipo;
        	$clie_carton_completo 		= (int) $clie_carton_completo;
        	$clie_carton_incompleto 	= (int) $clie_carton_incompleto;
        	$clie_caja_16 				= (int) $clie_caja_16;
        	$clie_caja_225_25 			= (int) $clie_caja_225_25;
        	$clie_fecha_venta			= date2sql($clie_fecha_venta);
        	$clie_fecha_actualizacion 	= date2sql($clie_fecha_actualizacion);
        	
        	$sql = "SELECT COUNT(*) FROM cliente WHERE cliente_id=$cliente_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE cliente SET clie_tipo=$clie_tipo, clie_carton_completo=$clie_carton_completo, clie_carton_incompleto=$clie_carton_incompleto, clie_caja_16 = $clie_caja_16, clie_caja_225_25 = $clie_caja_225_25, clie_fecha_venta = '$clie_fecha_venta', clie_fecha_actualizacion = '$clie_fecha_actualizacion' WHERE cliente_id=$cliente_id";
	        } else {
	        	$sql = "INSERT INTO cliente (cliente_id, clie_rut, clie_tipo, clie_carton_completo, clie_carton_incompleto, clie_caja_16, clie_caja_225_25, clie_fecha_venta, clie_fecha_actualizacion) VALUES ($cliente_id, '$clie_rut', $clie_tipo, $clie_carton_completo, $clie_carton_incompleto, $clie_caja_16, $clie_caja_225_25, '$clie_fecha_venta', '$clie_fecha_actualizacion')";
	        }
	        return DB::query($sql);
	    
	    }



	    public function saveFactura($data){

			extract($data);
        	$factura_id 		= (int) $factura_id;
	        $fact_numero 		= (int) $fact_numero;
	        $fact_intento 		= (int) $fact_intento;
			$fact_caja 			= (int) $fact_caja;
			$fact_contable 		= date2sql($fact_contable);
			$fact_actualizacion = date2sql($fact_actualizacion);
			
			$fact_carga = date('Y-m-d H:i:s');

			$sql = "INSERT INTO factura (cliente_id, fact_contable, fact_numero, fact_caja, fact_intento, fact_actualizacion) VALUES ('$cliente_id', '$fact_contable', $fact_numero, $fact_caja, $fact_intento, '$fact_actualizacion')";
			return DB::query($sql);
	    
	    }



	    public function saveFacturaNew($data){

			extract($data);
        	$factura_id 		= (int) $factura_id;
	        $fact_numero 		= (int) $fact_numero;
	        $fact_intento 		= (int) $fact_intento;
			$fact_caja 			= (int) $fact_caja;
			$fact_contable 		= date2sql($fact_contable);
			$fact_actualizacion = date2sql($fact_actualizacion);
			
			$fact_carga = date('Y-m-d H:i:s');

			$sql = "SELECT COUNT(*) FROM factura WHERE cliente_id=$cliente_id AND fact_numero = '$fact_numero'";
	        if (!DB::getOne($sql)) {
	        	$sql = "INSERT INTO factura (cliente_id, fact_contable, fact_numero, fact_caja, fact_intento, fact_actualizacion) VALUES ('$cliente_id', '$fact_contable', $fact_numero, $fact_caja, $fact_intento, '$fact_actualizacion')";
				DB::query($sql);
	    	}
	    	//else{
	    	//	$sql = "UPDATE factura SET fact_caja=$fact_caja, fact_intento=$fact_intento WHERE cliente_id=$cliente_id AND fact_numero = '$fact_numero'";
	        //}
	        //echo $sql."<br>";
	    	//return DB::query($sql);
	    }	

	    public function getFacturaAll(){
			$sql	= "SELECT * FROM factura ORDER BY factura_id ASC";
			return 	DB::getAll( $sql );
		}


		public function deleteFacturaId($factura_id){
			if(!empty($factura_id) && is_numeric($factura_id)){
				$delete = array('factura_id' => $factura_id);
	        	return DB::delete('factura', $delete, 1 );
			}
			return false;
		}



		public function autenticate($cliente_id, $clie_rut){
	    	$cliente_id 	= trim($cliente_id);
			$clie_rut 		= str_replace('-','',str_replace('.','',trim($clie_rut)));
	    	

	    	if(!empty($clie_rut) && is_string($clie_rut) && !empty($cliente_id)){
	    		$sql = "SELECT 
        				* 
        			FROM 
        				factura 
        			WHERE 
        				cliente_id = '$cliente_id' 
        				AND clie_rut = '$clie_rut' 
        			LIMIT 1";
				
				$autenticate = DB::getRow($sql);

				if(is_object($autenticate) && !empty($autenticate)){
        			$objIngreso = new ingreso();
	    			$objIngreso->saveIngreso($autenticate->cliente_id);
	    			
	        		session_start();
	        		$_SESSION['RULETA'] 				= true;
			  		$_SESSION['RULETA_CLIENTE_ID'] 		= $autenticate->cliente_id;
			  		$_SESSION['RULETA_CLIE_RUT'] 		= $autenticate->clie_rut;
			  		$_SESSION['RULETA_CLIE_DISTRITO'] 	= $autenticate->clie_distrito;
					$_SESSION['RULETA_CLIE_FANTASIA'] 	= $autenticate->clie_fantasia;
					$_SESSION['RULETA_CLIE_FECHA'] 		= date('Y-m-d');
					return true;
	        	}
		        
	    	}
	    	return false;
	    }

	}
?>