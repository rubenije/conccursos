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
				if($table == 'redbull'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, COB_250, COB_EDITIONS, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$COB_250', '$COB_EDITIONS', '$fecha')";
				}
				if($table == 'mas'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, CON_GAS, SIN_GAS, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$CON_GAS', '$SIN_GAS', '$fecha')";
				}
				if($table == 'gatorade'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, CANTIDAD_SKU, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$CANTIDAD_SKU', '$fecha')";
				}
				if($table == 'aguas'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, CATUN_1_6, CATUN_2_5, MANAN_3, MANAN_1_5, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$CATUN_1_6', '$CATUN_2_5', '$MANAN_3', '$MANAN_1_5', '$fecha')";
				}
				if($table == 'heineken'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, HL_AL_DIA_MES_EN_CURSO, HL_VS_AA_AL_DIA, HL_AA_AL_DIA_MES_EN_CURSO, HL_FALTANTE_PARA_100_AA_MES_EN_CURSO, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$HL_AL_DIA_MES_EN_CURSO', '$HL_VS_AA_AL_DIA', '$HL_AA_AL_DIA_MES_EN_CURSO', '$HL_FALTANTE_PARA_100_AA_MES_EN_CURSO', '$fecha')";
				}
				if($table == 'gaseosas'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, GRUPO_CLIENTE, CONCRETADO_PEPSI, CONCRETADO_BILZ, CONCRETADO_PAP, CONCRETADO_LIMON, CONCRETADO_KEM, CONCRETADO_CRUSH, CONCRETADO_7UP, CONCRETADO_CDGA, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$GRUPO_CLIENTE', '$CONCRETADO_PEPSI', '$CONCRETADO_BILZ', '$CONCRETADO_PAP', '$CONCRETADO_LIMON', '$CONCRETADO_KEM', '$CONCRETADO_CRUSH', '$CONCRETADO_7UP', '$CONCRETADO_CDGA', '$fecha')";
				}
				if($table == 'energia'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, GRUPO_CLIENTE, CONCRETADO_REDBULL, CONCRETADO_ROCKSTAR, REDBULL_HL_2026, REDBULL_HL_2025, ROCKSTAR_HL_2026, ROCKSTAR_HL_2025, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$GRUPO_CLIENTE', '$CONCRETADO_REDBULL', '$CONCRETADO_ROCKSTAR', '$REDBULL_HL_2026', '$REDBULL_HL_2025', '$ROCKSTAR_HL_2026', '$ROCKSTAR_HL_2025', '$fecha')";
				}
				if($table == 'cpch'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, GRUPO_CLIENTE, CANTIDAD_MISTRAL_ICE, CONCRETADO_3R_ICE, CONCRETADO_MISTRAL_ICE_LOW, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$GRUPO_CLIENTE', '$CANTIDAD_MISTRAL_ICE', '$CONCRETADO_3R_ICE', '$CONCRETADO_MISTRAL_ICE_LOW', '$fecha')";
				}
				if($table == 'royalweekend'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, GRUPO_CLIENTE, HL_VSD_TOTAL_AA, HL_ABRIL_2026, HL_ABRIL_2025_AL_DIA, HL_ABRIL_2025_TOTAL, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$GRUPO_CLIENTE', '$HL_VSD_TOTAL_AA', '$HL_ABRIL_2026', '$HL_ABRIL_2025_AL_DIA', '$HL_ABRIL_2025_TOTAL', '$fecha')";
				}
				if($table == 'bep2026'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, CONC_BEP, VOL_VS_AA_BEP, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$CONC_BEP', '$VOL_VS_AA_BEP', '$fecha')";
				}
				if($table == 'gatorade2026'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, COMPRA_GATORADE, CONCRETADO_750, CANTIDAD_CONC_1LT, VOL_VS_AA_GATORADE, VOL_VS_AA_750, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$COMPRA_GATORADE', '$CONCRETADO_750', '$CANTIDAD_CONC_1LT', '$VOL_VS_AA_GATORADE', '$VOL_VS_AA_750', '$fecha')";
				}
				if($table == 'watts'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, CONCRETADO_NARANJA, CONCRETADO_PINA, CONCRETADO_DURAZNO, CONCRETADO_TUTIFRUTILLA, CONCRETADO_LIGHT, VOL_VS_AA_NARANJA, VOL_VS_AA_PINA, VOL_VS_AA_DURAZNO, VOL_VS_AA_TUTIFRUTILLA, VOL_VS_AA_LIGHT, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$CONCRETADO_NARANJA', '$CONCRETADO_PINA', '$CONCRETADO_DURAZNO', '$CONCRETADO_TUTIFRUTILLA', '$CONCRETADO_LIGHT', '$VOL_VS_AA_NARANJA', '$VOL_VS_AA_PINA', '$VOL_VS_AA_DURAZNO', '$VOL_VS_AA_TUTIFRUTILLA', '$VOL_VS_AA_LIGHT', '$fecha')";
				}
				if($table == 'kunstmann'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, VOL, VOL_AA, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$VOL', '$VOL_AA', '$fecha')";
				}
				if($table == 'cervezas'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, GRUPO, VOLUMEN_AL_DIA_CRI_ESC, VOLUMEN_AL_DIA_AGOSTO_2025, VOLUMEN_MES_COMPLETO_AGOSTO_2025, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$GRUPO', '$VOLUMEN_AL_DIA_CRI_ESC', '$VOLUMEN_AL_DIA_AGOSTO_2025', '$VOLUMEN_MES_COMPLETO_AGOSTO_2025', '$fecha')";
				}
				if($table == 'gaseosas_sabores'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, GRUPO, BILZ, PAP, KEM, LIMON_SODA, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$GRUPO', '$BILZ', '$PAP', '$KEM', '$LIMON_SODA', '$fecha')";
				}
				if($table == 'redbull2026'){
					$sql = "INSERT INTO detalle_".$table." (vendedor_id, id, sector, razon, ROMBO_250, CANTIDAD_SABORES, fecha) VALUES ";
					$sql.= "($vendedor_id, $id, '$sector', '$razon', '$ROMBO_250', '$CANTIDAD_SABORES', '$fecha')";
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