<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	
	include_once(INCLUDE_PATH.'class/class.ingreso.php');
	include_once(INCLUDE_PATH.'class/class.registro.php');
		
	
	class master extends DB {
	    
	    public function getMasterId($master_id){
			if(!empty($master_id) && is_numeric($master_id)){
				$sql 	= "SELECT * FROM master WHERE master_id = $master_id LIMIT 1";
				return DB::getRow( $sql );
			}
			return false;		
	    }

        public function getMasterById($id){
			if(!empty($id) && is_numeric($id)){
				$sql 	= "SELECT 
								R.*,
								M.supervisor_id,
								M.distrito 
							FROM master M 
							INNER JOIN registro R ON (R.id = M.id)
							WHERE M.id = $id LIMIT 1";
				return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function getMasterRut($clie_rut){
			if(!empty($clie_rut) && is_string($clie_rut)){
				$sql 	= "SELECT * FROM master WHERE clie_rut = '$clie_rut' LIMIT 1";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

		public function getMasterAll(){
			$sql	= "SELECT * FROM master ORDER BY master_id ASC";
			return 	DB::getAll( $sql );
		}

		public function deleteMasterId($master_id){
			if(!empty($master_id) && is_numeric($master_id)){
				$delete = array('master_id' => $master_id);
	        	return DB::delete('master', $delete, 1 );
			}
			return false;
		}


		public function autenticateByPass($id){
	    	if(!empty($id) && is_numeric($id)){
	    		$autenticate = $this->getMasterById($id);

				
				if(is_object($autenticate) && !empty($autenticate)){

	    			session_start();
	        		$_SESSION['LOGIN'] 				    = true;
			  		$_SESSION['LOGIN_REGISTRO_ID'] 		= $autenticate->registro_id;
			  		$_SESSION['LOGIN_TIPO'] 		    = $autenticate->tipo;
			  		$_SESSION['LOGIN_ID'] 	            = $autenticate->id;
			  		$_SESSION['LOGIN_NOMBRE'] 	        = $autenticate->nombre;
					$_SESSION['LOGIN_DISTRITO'] 		= $autenticate->distrito;
					$_SESSION['LOGIN_CANAL'] 		    = $autenticate->canal;
                    $_SESSION['LOGIN_SUPERVISOR_ID'] 	= $autenticate->supervisor_id;
					$_SESSION['LOGIN_DISTRITO'] 		= $autenticate->distrito;
					$_SESSION['LOGIN_FECHA'] 		    = date('Y-m-d');
					return true;
	        	}
		        
	    	}
	    	return false;
	    }


	    public function autenticate($master_id){
			$master_id 	= trim($master_id);
			
			if(!empty($master_id) && is_numeric($master_id) ){
	    		$sql = "SELECT 
							R.*,
							M.supervisor_id,
							M.distrito 
						FROM 
							master M 
							INNER JOIN registro R ON (R.id = M.id)
						WHERE 
							M.id = '$master_id' 
						LIMIT 1";

				$autenticate = DB::getRow($sql);

				$objIngreso = new ingreso();
				$distrito = $objIngreso->getDistritoByCodigo($autenticate->distrito);
				
				
				$tmp['cliente_id'] 	= $autenticate->id;
				$tmp['distrito_id'] = $distrito->distrito_id;
				$tmp['zona_id'] 	= $distrito->zona_id;
				
				
				if(is_object($autenticate) && !empty($autenticate)){
        			$objIngreso->saveIngreso($tmp);
	    			
	        		$_SESSION['LOGIN'] 				    = true;
			  		$_SESSION['LOGIN_REGISTRO_ID'] 		= $autenticate->registro_id;
			  		$_SESSION['LOGIN_TIPO'] 		    = $autenticate->tipo;
			  		$_SESSION['LOGIN_ID'] 	            = $autenticate->id;
			  		$_SESSION['LOGIN_NOMBRE'] 	        = $autenticate->nombre;
					$_SESSION['LOGIN_DISTRITO'] 		= $autenticate->distrito;
					$_SESSION['LOGIN_CANAL'] 		    = $autenticate->canal;
                    $_SESSION['LOGIN_SUPERVISOR_ID'] 	= $autenticate->supervisor_id;
                    $_SESSION['LOGIN_FECHA'] 		    = date('Y-m-d');
					
					return true;
	        	}
		        
	    	}
	    	return false;
	    }


	}
?>