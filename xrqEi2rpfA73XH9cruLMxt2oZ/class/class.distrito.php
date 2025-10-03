<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class distrito extends DB {
	    
		
		public function getDistritoId($distrito_id){
			if(!empty($distrito_id) && is_numeric($distrito_id)){
				$sql 	= "SELECT * FROM distrito WHERE distrito_id = $distrito_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function saveDistrito($data){
        	extract($data);
        	$distrito_id 		= (int) $distrito_id;
        	$region_id 		= (int) $region_id;
        	$distrito_orden 	= (int) $distrito_orden;
        	
        	$sql = "SELECT COUNT(*) FROM distrito WHERE distrito_id=$distrito_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE distrito SET zona_id=$zona_id, id=$id, dist_codigo='$dist_codigo', dist_nombre='$dist_nombre', dist_estado = '$dist_estado', dist_orden = $dist_orden WHERE distrito_id=$distrito_id";
	        } else {
	        	$sql = "INSERT INTO distrito (zona_id, id, dist_codigo, dist_nombre, dist_estado, dist_orden) VALUES ($region_id, '$distrito_codigo', '$distrito_nombre', '$distrito_estado', $distrito_orden)";
	        }
	        return DB::query($sql);
	    
	    }

		public function getDistritoAll(){
			$sql	= "SELECT * FROM distrito
						ORDER BY dist_orden ASC";
			return 	DB::getAll( $sql );
		}


        public function getPublicDistritoAll(){
			$sql	= "SELECT * 
                        FROM 
                            distrito
                        WHERE 
                            dist_estado = 'A'
						ORDER BY dist_orden ASC";
			return 	DB::getAll( $sql );
		}

        public function getDistritoByZonaId($zona_id){
			if(!empty($zona_id) && is_numeric($zona_id)){
				$sql	= "SELECT 
								D.zona_id,
								D.distrito_id,
								D.dist_nombre,
								R.*
							FROM distrito D 
							INNER JOIN registro R ON (R.id = D.id)
							WHERE 
								D.zona_id = $zona_id  
								AND D.dist_estado = 'A'
							ORDER BY D.dist_orden";
				
				return 	DB::getAll( $sql );
			}
			return false;
		}


        public function getDistritoById($id){
			if(!empty($id) && is_numeric($id)){
				$sql	= "SELECT 
								D.zona_id,
								D.dist_nombre,
								R.*
							FROM distrito D 
							INNER JOIN zona Z ON (Z.zona_id = D.zona_id)
							INNER JOIN registro R ON (R.id = D.id)
							WHERE R.id = $id 
							ORDER BY D.dist_orden";
				
				return 	DB::getRow( $sql );
			}
			return false;
		}


        public function getDistritoByTableByZonaId($table, $zona_id){
			if(!empty($zona_id) && is_numeric($zona_id)){
				$sql	= "SELECT 
								D.zona_id,
								D.distrito_id,
								D.dist_nombre,
								R.*
							FROM distrito D 
							INNER JOIN registro_$table R ON (R.id = D.id)
							WHERE 
								D.zona_id = $zona_id  
								AND D.dist_estado = 'A'
							ORDER BY D.dist_orden";
				
				return 	DB::getAll( $sql );
			}
			return false;
		}

        public function deleteDistritoId($distrito_id){
			if(!empty($distrito_id) && is_numeric($distrito_id)){
				$delete = array('distrito_id' => $distrito_id);
	        	return DB::delete('distrito', $delete, 1 );
			}
			return false;
		}

	}
?>