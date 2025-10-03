<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class zona extends DB {
	    
		
		public function getZonaId($zona_id){
			if(!empty($zona_id) && is_numeric($zona_id)){
				$sql 	= "SELECT * FROM zona WHERE zona_id = $zona_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function saveZona($data){
        	extract($data);
        	$zona_id 		= (int) $zona_id;
        	$region_id 		= (int) $region_id;
        	$zona_orden 	= (int) $zona_orden;
        	
        	$sql = "SELECT COUNT(*) FROM zona WHERE zona_id=$zona_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE zona SET zona_codigo='$zona_codigo', zona_nombre='$zona_nombre', zona_estado = '$zona_estado', zona_orden = $zona_orden WHERE zona_id=$zona_id";
	        } else {
	        	$sql = "INSERT INTO zona (region_id, zona_codigo, zona_nombre, zona_estado, zona_orden) VALUES ($region_id, '$zona_codigo', '$zona_nombre', '$zona_estado', $zona_orden)";
	        }
	        return DB::query($sql);
	    
	    }

		public function getZonaAll(){
			$sql	= "SELECT * FROM zona
						ORDER BY zona_orden ASC";
			return 	DB::getAll( $sql );
		}


        public function getPublicZonaAll(){
			$sql	= "SELECT * 
                        FROM 
                            zona
                        WHERE 
                            zona_estado = 'A'
						ORDER BY zona_orden ASC";
			return 	DB::getAll( $sql );
		}


		public function getZonaByCodigo($zona_codigo){
			if(!empty($zona_codigo) && is_string($zona_codigo)){
				$sql	= "SELECT * FROM zona WHERE zona_codigo = '$zona_codigo' ORDER BY zona_orden";
				return 	DB::getRow( $sql );
			}
			return false;
		}


		public function getZonas(){
			$sql	= "SELECT * FROM zona ORDER BY zona_orden";
			return 	DB::getAll( $sql );
		}

		public function deleteZonaId($zona_id){
			if(!empty($zona_id) && is_numeric($zona_id)){
				$delete = array('zona_id' => $zona_id);
	        	return DB::delete('zona', $delete, 1 );
			}
			return false;
		}

	}
?>