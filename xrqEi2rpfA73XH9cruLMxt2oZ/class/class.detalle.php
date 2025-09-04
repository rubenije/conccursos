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
			
        	$sql = "SELECT COUNT(*) FROM detalle WHERE vendedor_id = $vendedor_id AND id = $id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE detalle SET compra_gaseosas = '$compra_gaseosas', compra_catun = '$compra_catun', compra_rockstar = '$compra_rockstar', compra_redbull = '$compra_redbull' WHERE vendedor_id = $vendedor_id AND id = $id";
	        } else {
	        	$sql = "INSERT INTO detalle (vendedor_id, id, sector, razon, compra_gaseosas, compra_catun, compra_rockstar, compra_redbull) VALUES ";
				$sql.= "($vendedor_id, $id, '$sector', '$razon', '$compra_gaseosas', '$compra_catun', '$compra_rockstar', '$compra_redbull')";
	        }
			echo $sql."<br>";
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

	}
?>