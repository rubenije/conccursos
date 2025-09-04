<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	
	include_once(INCLUDE_PATH.'class/class.ingreso.php');	
	
	class cliente extends DB {
	    
	    public function getClienteId($cliente_id){
			if(!empty($cliente_id) && is_numeric($cliente_id)){
				$sql 	= "SELECT * FROM cliente WHERE cliente_id = $cliente_id LIMIT 1";
				return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function getClienteRut($clie_rut){
			if(!empty($clie_rut) && is_string($clie_rut)){
				$sql 	= "SELECT * FROM cliente WHERE clie_rut = '$clie_rut' LIMIT 1";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

		public function getClienteAll(){
			$sql	= "SELECT * FROM cliente ORDER BY cliente_id ASC";
			return 	DB::getAll( $sql );
		}

		public function deleteClienteId($cliente_id){
			if(!empty($cliente_id) && is_numeric($cliente_id)){
				$delete = array('cliente_id' => $cliente_id);
	        	return DB::delete('cliente', $delete, 1 );
			}
			return false;
		}


		public function autenticateByPass($cliente_id){
	    	if(!empty($cliente_id) && is_numeric($cliente_id)){
	    		$autenticate = cliente::getClienteId($cliente_id);

	    		if(is_object($autenticate) && !empty($autenticate)){

	    			//$objIngreso = new ingreso();
	    			//$objIngreso->saveIngreso($autenticate->cliente_id);
	        		session_start();
	        		$_SESSION['RULETA'] 				= true;
			  		$_SESSION['RULETA_ID'] 				= $autenticate->id;
			  		$_SESSION['RULETA_CLIENTE_ID'] 		= $autenticate->cliente_id;
			  		$_SESSION['RULETA_CLIE_NOMBRE'] 	= $autenticate->clie_nombre;
			  		$_SESSION['RULETA_CLIE_DISTRITO'] 	= $autenticate->clie_distrito;
					$_SESSION['RULETA_CLIE_VENDEDOR'] 	= $autenticate->clie_vendedor;
					$_SESSION['RULETA_CLIE_JEFE'] 		= $autenticate->clie_jefe;
					$_SESSION['RULETA_CLIE_FECHA'] 		= date('Y-m-d');
					return true;
	        	}
		        
	    	}
	    	return false;
	    }


	    public function autenticate($cliente_id){
			$cliente_id 	= trim($cliente_id);
			
			if(!empty($cliente_id) && is_numeric($cliente_id) ){
	    		$sql = "SELECT 
							C.* 
						FROM 
							cliente C
						WHERE 
							C.cliente_id = '$cliente_id' 
						LIMIT 1";

				$autenticate = DB::getRow($sql);

				if(is_object($autenticate) && !empty($autenticate)){
        			$objIngreso = new ingreso();
	    			$objIngreso->saveIngreso($autenticate->cliente_id);
	    			
	        		session_start();
	        		$_SESSION['RULETA'] 				= true;
			  		$_SESSION['RULETA_ID'] 				= $autenticate->id;
					$_SESSION['RULETA_CLIE_RUT'] 		= $autenticate->clie_rut;
			  		$_SESSION['RULETA_CLIE_DV'] 		= $autenticate->clie_dv;
			  		$_SESSION['RULETA_CLIENTE_ID'] 		= $autenticate->cliente_id;
					$_SESSION['RULETA_VENDEDOR_ID'] 	= $autenticate->vendedor_id;
					$_SESSION['RULETA_CLIE_NOMBRE'] 	= $autenticate->clie_nombre;
			  		$_SESSION['RULETA_CLIE_DISTRITO'] 	= $autenticate->clie_distrito;
					$_SESSION['RULETA_CLIE_VENDEDOR'] 	= $autenticate->clie_vendedor;
					$_SESSION['RULETA_CLIE_JEFE'] 		= $autenticate->clie_jefe;
					$_SESSION['RULETA_CLIE_FECHA'] 		= date('Y-m-d');
					return true;
	        	}
		        
	    	}
	    	return false;
	    }


		public function autenticateXXX($cliente_id, $clie_rut){
			$cliente_id 	= trim($cliente_id);
			$clie_rut 		= str_replace('.','',trim($clie_rut));
	    	
	    	if(!empty($clie_rut) && is_string($clie_rut) && !empty($cliente_id)){
	    		$sql = "SELECT 
        				* 
        			FROM 
        				cliente 
        			WHERE 
        				clie_rut = '$clie_rut' 
        				AND cliente_id = '$cliente_id' 
        			LIMIT 1";
        		$autenticate = DB::getRow($sql);

				if(is_object($autenticate) && !empty($autenticate)){
        			$objIngreso = new ingreso();
	    			$objIngreso->saveIngreso($autenticate->cliente_id);
	    			
	        		session_start();
	        		$_SESSION['RULETA'] 				= true;
			  		$_SESSION['RULETA_ID'] 				= $autenticate->id;
			  		$_SESSION['RULETA_CLIENTE_ID'] 		= $autenticate->cliente_id;
			  		$_SESSION['RULETA_CLIE_NOMBRE'] 	= $autenticate->clie_nombre;
			  		$_SESSION['RULETA_CLIE_DISTRITO'] 	= $autenticate->clie_distrito;
					$_SESSION['RULETA_CLIE_VENDEDOR'] 	= $autenticate->clie_vendedor;
					$_SESSION['RULETA_CLIE_JEFE'] 		= $autenticate->clie_jefe;
					$_SESSION['RULETA_CLIE_FECHA'] 		= date('Y-m-d');
					return true;
	        	}
		        
	    	}
	    	return false;
	    }


	}
?>