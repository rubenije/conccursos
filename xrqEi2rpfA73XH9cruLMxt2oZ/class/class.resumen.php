<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class resumen extends DB {
	    
		
		public function getResumenId($resumen_id){
			if(!empty($resumen_id) && is_numeric($resumen_id)){
				$sql 	= "SELECT * FROM resumen WHERE resumen_id = $resumen_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }


		public function getResumenFile(){
			$sql 	= "SELECT resu_archivo FROM resumen ORDER BY resumen_id DESC LIMIT 1";
	        return DB::getOne( $sql );
		}



		public function saveResumen($data){
	    	extract($data);
        	$resumen_id 	= 0;
        	$resu_fecha 	= date('Y-m-d');
        	$resu_registros = (int) $resu_registros;	
        	
        	$sql = "SELECT COUNT(*) FROM resumen WHERE resumen_id=$resumen_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE resumen SET clie_carton_completo=$clie_carton_completo, clie_carton_incompleto=$clie_carton_incompleto, clie_caja_16 = $clie_caja_16, clie_caja_225_25 = clie_caja_225_25, clie_fecha_venta = '$clie_fecha_venta', clie_fecha_actualizacion = '$clie_fecha_actualizacion' WHERE resumen_id=$resumen_id";
	        } else {
	        	$sql = "INSERT INTO resumen (resumen_id, resu_fecha, resu_inicio, resu_termino, resu_archivo, resu_registros) VALUES ($resumen_id, '$resu_fecha', '$resu_inicio', '$resu_termino', '$resu_archivo', $resu_registros)";
	        }
	        return DB::query($sql);
	    
	    }

		public function deleteClienteId($resumen_id){
			if(!empty($resumen_id) && is_numeric($resumen_id)){
				$delete = array('resumen_id' => $resumen_id);
	        	return DB::delete('resumen', $delete, 1 );
			}
			return false;
		}

	}
?>