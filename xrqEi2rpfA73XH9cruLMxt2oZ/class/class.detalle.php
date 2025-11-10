<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class detalle extends DB {
	    
		public function getDetalleAll(){
			$sql	= "SELECT * FROM detalle ORDER BY nombre ASC";
			return 	DB::getAll( $sql );
		}

		public function getDetalleByVendedorId($vendedor_id){
			if(!empty($vendedor_id) && is_numeric($vendedor_id)){
				$sql 	= "SELECT * FROM detalle WHERE vendedor_id = $vendedor_id ORDER BY sector ASC, razon ASC";
	        	return DB::getAll( $sql );
			}
			return false;		
	    }

		public function getDetalleByVendedoresByIds($vendedores_id){
			if(!empty($vendedores_id) && is_string($vendedores_id)){
				$sql 	= "SELECT * FROM detalle WHERE vendedor_id IN ($vendedores_id) ORDER BY sector ASC, razon ASC";
	        	return DB::getAll( $sql );
			}
			return false;		
	    }

		public function getDetalleId($detalle_id){
			if(!empty($detalle_id) && is_numeric($detalle_id)){
				$sql 	= "SELECT * FROM detalle WHERE detalle_id = $detalle_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

		public function saveDetalle($data){
            extract($data);
        	$vendedor_id 	= (int) $vendedor_id;
			$id 			= (int) $id;
            $sector 		= (int) $sector;
			$razon 		    = DB::filter($razon);
			
        	$sql = "INSERT INTO detalle (vendedor_id, id, sector, razon, mes_curso, mes_cerrado) VALUES ";
			$sql.= "($vendedor_id, $id, '$sector', '$razon', '$mes_curso', '$mes_cerrado')";
	        return DB::query($sql);
	    
	    }

		public function deleteDetalleId($detalle_id){
			if(!empty($detalle_id) && is_numeric($detalle_id)){
				$delete = array('detalle_id' => $detalle_id);
	        	return DB::delete('detalle', $delete, 1 );
			}
			return false;
		}

        public function truncateDetalle(){
			$sql 	= "TRUNCATE TABLE detalle";
			return DB::query($sql);
	    }

		/**	
		 * INI funciones por tabla
		 */
		public function truncateDetalleByTable($table){
			if(!empty($table) && is_string($table)){
				$sql 	= "TRUNCATE TABLE detalle_$table";
				echo $sql."<br>";
				return DB::query($sql);
			}
			return false;
		}


		public function saveDetalleByTable($table, $data){
			if(!empty($table) && is_string($table)){
				extract($data);
				$vendedor_id 	= (int) $vendedor_id;
				$id 			= (int) $id;
				$razon 		    = DB::filter($razon);
				$fecha 		    = date('Y-m-d');

				if($table == 'tirate'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, COB_CATUN_16, COB_CATUN_25, COB_MANANTIAL_30, COB_MANANTIAL_15, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$COB_CATUN_16', '$COB_CATUN_25', '$COB_MANANTIAL_30', '$COB_MANANTIAL_15', '$fecha')";
				}
				if($table == 'craft'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, COB_CALAFATE_500, COB_TOROBAYO_500, COB_TORRES_PAINE_500, COB_GUAYACAN_PAPAYA_500, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$COB_CALAFATE_500', '$COB_TOROBAYO_500', '$COB_TORRES_PAINE_500', '$COB_GUAYACAN_PAPAYA_500', '$fecha')";
				}
				if($table == 'sabores'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, COB_BILZ, COB_PAP, COB_KEM, COB_LIMON_SODA, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$COB_BILZ', '$COB_PAP', '$COB_KEM', '$COB_LIMON_SODA', '$fecha')";
				}
				if($table == 'bep'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, COB_VIVO, COB_SPRIM, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$COB_VIVO', '$COB_SPRIM', '$fecha')";
				}
				if($table == 'lipton'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, PET600, LATA310, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$PET600', '$LATA310', '$fecha')";
				}
				return DB::query($sql);
			}
			return false;
	    }
		public function getDetalleByTableByVendedorId($table, $vendedor_id){
			if(!empty($vendedor_id) && is_numeric($vendedor_id)){
				$sql 	= "SELECT * FROM detalle_$table WHERE vendedor_id = $vendedor_id ORDER BY sector ASC, razon ASC";
	        	return DB::getAll( $sql );
			}
			return false;		
	    }

		public function getDetalleByTableByVendedoresByIds($table, $vendedores_id){
			if(!empty($vendedores_id) && is_string($vendedores_id)){
				$sql 	= "SELECT * FROM detalle_$table WHERE vendedor_id IN ($vendedores_id) ORDER BY sector ASC, razon ASC";
	        	return DB::getAll( $sql );
			}
			return false;		
	    }
		/**	
		 * INI funciones por tabla
		 */
	}
?>