<?php 

if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class usuario extends DB {
	    
		
		public function getUsuarioId($usuario_id){
			if(!empty($usuario_id) && is_numeric($usuario_id)){
				$sql 	= "SELECT * FROM usuario WHERE usuario_id = $usuario_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function saveUsuario($data){
        	extract($data);
        	$usua_imagen	= DB::uploadFileImage('usua_imagen', $usua_imagen_old);	
        	$id 			= (int) $id;
	        $usua_orden 	= (int) $usua_orden;
	        
	        $sql = "SELECT COUNT(*) FROM usuario WHERE usuario_id=$id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE usuario SET usua_nombre='$usua_nombre', usua_cargo='$usua_cargo', usua_telefono='$usua_telefono', usua_email='$usua_email', usua_user='$usua_user', usua_pass='$usua_pass', usua_imagen='$usua_imagen', usua_estado='$usua_estado', usua_orden=$usua_orden WHERE usuario_id=$id";
	        } else {
	        	$sql = "INSERT INTO usuario (usua_nombre, usua_cargo, usua_telefono, usua_email, usua_user, usua_pass, usua_imagen, usua_estado, usua_orden) VALUES ('$usua_nombre', '$usua_cargo', '$usua_telefono', '$usua_email', '$usua_user', '$usua_pass', '$usua_imagen', '$usua_estado',$usua_orden)";
	        }
	        return DB::query($sql);
	    
	    }

		public function getUsuarioAll(){
			$sql	= "SELECT * FROM usuario ORDER BY usuario_id ASC";
			return 	DB::getAll( $sql );
		}


		public function deleteUsuarioId($usuario_id){
			if(!empty($usuario_id) && is_numeric($usuario_id)){
				$delete = array('usuario_id' => $usuario_id);
	        	return DB::delete('usuario', $delete, 1 );
			}
			return false;
		}


		public function autenticateBack($usua_user, $usua_pass){
	    	$usua_user = trim($usua_user);
	    	$usua_pass = trim($usua_pass);

	    	if(!empty($usua_user) && is_string($usua_user) && !empty($usua_pass)){
	    		$sql = "SELECT 
        				* 
        			FROM 
        				usuario 
        			WHERE 
        				usua_user = '$usua_user' 
        				AND usua_pass = '$usua_pass' 
        				AND usua_estado = 'A' 
        			LIMIT 1";
        		$autenticate = DB::getRow($sql);

        		if(is_object($autenticate) && !empty($autenticate)){
	        		session_start();
	        		$_SESSION['PANEL'] 				= true;
			  		$_SESSION['PANEL_USUARIO_ID'] 	= $autenticate->usuario_id;
			  		$_SESSION['PANEL_USUA_NOMBRE'] 	= $autenticate->usua_nombre;
					$_SESSION['PANEL_USUA_CARGO'] 	= $autenticate->usua_cargo;
					$_SESSION['PANEL_USUA_EMAIL'] 	= $autenticate->usua_email;
					$_SESSION['PANEL_USUA_PERFIL'] 	= $autenticate->usua_perfil;
					$_SESSION['PANEL_USUA_IMAGEN'] 	= $autenticate->usua_imagen;
					$_SESSION['PANEL_USUA_FECHA'] 	= date('Y-m-d');
					return true;
	        	}
		        
	    	}
	    	return false;
	    }

	}
?>