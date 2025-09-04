<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/utils/class.DB.php');	

	class comuna extends DB {
	    
		
		public function getComunaId($comuna_id){
			if(!empty($comuna_id) && is_numeric($comuna_id)){
				$sql 	= "SELECT * FROM comuna WHERE comuna_id = $comuna_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function saveComuna($data){
        	extract($data);
        	$comuna_id 		= (int) $comuna_id;
        	$region_id 		= (int) $region_id;
        	$comu_orden 	= (int) $comu_orden;
        	
        	$sql = "SELECT COUNT(*) FROM comuna WHERE comuna_id=$comuna_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE comuna SET region_id=$region_id, comu_nombre='$comu_nombre', comu_estado = '$comu_estado', comu_orden = $comu_orden WHERE comuna_id=$comuna_id";
	        } else {
	        	$sql = "INSERT INTO comuna (region_id, comu_nombre, comu_estado, comu_orden) VALUES ($region_id, '$comu_nombre', '$comu_estado', $comu_orden)";
	        }
	        return DB::query($sql);
	    
	    }

		public function getComunaAll(){
			$sql	= "SELECT 
							R.regi_nombre,
							C.*
						FROM comuna C 
						LEFT JOIN region R ON (R.region_id = C.region_id)
						ORDER BY comu_orden ASC";
			return 	DB::getAll( $sql );
		}

		public function getComunaPublicAll(){
			$sql	= "SELECT 
							C.comuna_id,
							TRIM(C.comu_nombre) comu_nombre
						FROM comuna C 
						WHERE 
							comu_estado = 'A'
						ORDER BY comu_nombre ASC";
			return 	DB::getAll( $sql );
		}

		public function deleteComunaId($comuna_id){
			if(!empty($comuna_id) && is_numeric($comuna_id)){
				$delete = array('comuna_id' => $comuna_id);
	        	return DB::delete('comuna', $delete, 1 );
			}
			return false;
		}

	}
?>