<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	
	include_once(INCLUDE_PATH.'class/class.ingreso.php');
	include_once(INCLUDE_PATH.'class/class.registro.php');
		
	
	class master extends DB {
	    
		public function getMasterNewId($id){
			if(!empty($id) && is_numeric($id)){
				$sql 	= "SELECT * FROM master WHERE id = $id LIMIT 1";
				return DB::getRow( $sql );
			}
			return false;		
	    }


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
	    		$master = $this->getMasterNewId($master_id);
				
				$objIngreso = new ingreso();
				$distrito = $objIngreso->getDistritoByCodigo($master->distrito);

				$tmp['cliente_id'] 		= $master->id;
				$tmp['distrito_id'] 	= $distrito->distrito_id;
				$tmp['zona_id'] 		= $distrito->zona_id;
				$tmp['supervisor_id'] 	= $master->supervisor_id;

				if(is_object($master) && !empty($master)){
        			$objIngreso->saveIngreso($tmp);
					
	        		$_SESSION['LOGIN'] 				    = true;
			  		$_SESSION['LOGIN_REGISTRO_ID'] 		= $master->master_id;
			  		$_SESSION['LOGIN_TIPO'] 		    = $master->tipo;
			  		$_SESSION['LOGIN_ID'] 	            = $master->id;
			  		$_SESSION['LOGIN_NOMBRE'] 	        = $master->nombre;
					$_SESSION['LOGIN_DISTRITO'] 		= $master->distrito; //M
					$_SESSION['LOGIN_CANAL'] 		    = $master->canal;
                    $_SESSION['LOGIN_SUPERVISOR_ID'] 	= $master->supervisor_id; //M
                    $_SESSION['LOGIN_FECHA'] 		    = date('Y-m-d');
					
					return true;
	        	}
		        
	    	}
	    	return false;
	    }






		public function autenticateSinIngreso($master_id){
			$master_id 	= trim($master_id);
			
			if(!empty($master_id) && is_numeric($master_id) ){
	    		$master = $this->getMasterNewId($master_id);
				
				if(is_object($master) && !empty($master)){
        			
	        		$_SESSION['LOGIN'] 				    = true;
			  		$_SESSION['LOGIN_REGISTRO_ID'] 		= $master->master_id;
			  		$_SESSION['LOGIN_TIPO'] 		    = $master->tipo;
			  		$_SESSION['LOGIN_ID'] 	            = $master->id;
			  		$_SESSION['LOGIN_NOMBRE'] 	        = $master->nombre;
					$_SESSION['LOGIN_DISTRITO'] 		= $master->distrito;
					$_SESSION['LOGIN_CANAL'] 		    = $master->canal;
                    $_SESSION['LOGIN_SUPERVISOR_ID'] 	= $master->supervisor_id;
                    $_SESSION['LOGIN_FECHA'] 		    = date('Y-m-d');
					
					return true;
	        	}
		        
	    	}
	    	return false;
	    }


	}
?>