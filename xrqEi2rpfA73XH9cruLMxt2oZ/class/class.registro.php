<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class registro extends DB {
	    
		public function getRegistroAll(){
			$sql	= "SELECT * FROM registro ORDER BY nombre ASC";
			return 	DB::getAll( $sql );
		}


		public function getRegistroDataAll(){
			$sql	= "SELECT * FROM registro ORDER BY tipo, canal";
			return 	DB::getAll( $sql );
		}


		public function getRegistroDataAllNew(){
			$sql	= "SELECT 
							R.*,
							M.supervisor_id,
							M.distrito
							 
						FROM registro R 
						INNER JOIN master M ON (M.id = R.id)
						ORDER BY 
							R.tipo, R.canal";
			return 	DB::getAll( $sql );
		}


		public function getVendedorBySupervisorId($supervisor_id){
			if(!empty($supervisor_id) && is_numeric($supervisor_id)){
				$sql	= "SELECT 
								R.* 
							FROM registro R 
							INNER JOIN master M ON (M.id = R.id)
							WHERE 
								R.tipo = 'VENDEDOR' 
								AND M.supervisor_id = $supervisor_id
							ORDER BY 
								R.nombre";
				return 	DB::getAll( $sql );
			}
			return false;
		}


		public function getIdsVendedorBySupervisorId($supervisor_id){
			if(!empty($supervisor_id) && is_numeric($supervisor_id)){
				$sql	= "SELECT 
								R.id 
							FROM registro R 
							INNER JOIN master M ON (M.id = R.id)
							WHERE 
								R.tipo = 'VENDEDOR' 
								AND M.supervisor_id = $supervisor_id
							ORDER BY 
								R.nombre";
				$elements = DB::getAll( $sql );
				if(is_array($elements)){
					$ids = array();
					foreach($elements as $element){
						$ids[] = $element->id;
					}
					return implode(',',$ids);
			 	}
			}
			return false;
		}


		public function getJefeDeVentaBySupervisorId($supervisor_id){
			if(!empty($supervisor_id) && is_numeric($supervisor_id)){
				$sql	= "SELECT 
								R.* 
							FROM registro R 
							INNER JOIN master M ON (M.id = R.id)
							WHERE 
								R.tipo = 'JDV' 
								AND M.supervisor_id = $supervisor_id
							ORDER BY 
								R.nombre";
				return 	DB::getAll( $sql );
			}
			return false;
		}

		public function getJefeDeMarca(){
			$sql	= "SELECT * 
						FROM registro R 
						INNER JOIN master M ON (M.id = R.id)
						WHERE 
							R.tipo <> 'JEFEDEMARCA' 
						ORDER BY 
							R.tipo, R.canal, R.patente";
			return 	DB::getAll( $sql );
		}

		public function getRegistroId($registro_id){
			if(!empty($registro_id) && is_numeric($registro_id)){
				$sql 	= "SELECT * FROM registro WHERE registro_id = $registro_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

		public function getRegistroById($id){
			if(!empty($id) && is_numeric($id)){
				$sql 	= "SELECT 
								R.*,
								M.supervisor_id 
							FROM registro R
							INNER JOIN master M ON (M.id = R.id) 
							WHERE 
								R.id = $id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

		public function getSubTotalByTipo($tipo){
			if(!empty($tipo) && is_string($tipo)){
				$sql 	= "SELECT 
								R.* 
							FROM registro R
							WHERE 
								R.tipo = '$tipo'";
	        	return DB::getRow( $sql );
			}
			return false;		
		}

		public function deleteRegistro(){
			$sql 	= "DELETE FROM registro WHERE tipo NOT LIKE '%JDM%'";
			return DB::query($sql);
	    }

	    public function truncateRegistro(){
			$sql 	= "TRUNCATE TABLE registro";
			return DB::query($sql);
	    }


	    public function deleteClienteId($registro_id){
			if(!empty($registro_id) && is_numeric($registro_id)){
				$delete = array('registro_id' => $registro_id);
	        	return DB::delete('registro', $delete, 1 );
			}
			return false;
		}

		public function getZonas(){
			$sql	= "SELECT * FROM zona ORDER BY zona_orden";
			return 	DB::getAll( $sql );
		}

		public function getZonaByCodigo($zona_codigo){
			if(!empty($zona_codigo) && is_string($zona_codigo)){
				$sql	= "SELECT * FROM zona WHERE zona_codigo = '$zona_codigo' ORDER BY zona_orden";
				return 	DB::getRow( $sql );
			}
			return false;
		}

		

		

		/**	
		 * INI funciones por tabla
		 */
		public function deleteRegistroByTable($table){
			if(!empty($table) && is_string($table)){
				$sql 	= "DELETE FROM registro_$table WHERE tipo NOT LIKE '%JDM%'";
				return DB::query($sql);
			}
			return false;
			
	    }

		public function saveRegistroByTable($table, $data){
			extract($data);
        	$id 			= (int) $id;
			$nombre 		= DB::filter($nombre);
			$fecha 			= $fecha ?? date('Y-m-d');
        	
			if($table == 'tirate' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_DUO = '$CUMPLIMIENTO_DUO', CUANTOS_FALTAN_DUO = '$CUANTOS_FALTAN_DUO', CUMPLIMIENTO_MANANTIAL = '$CUMPLIMIENTO_MANANTIAL', CUANTOS_FALTAN_MANANTIAL = '$CUANTOS_FALTAN_MANANTIAL', CUMPLIMIENTO_TOTAL = '$CUMPLIMIENTO_TOTAL', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_DUO, CUANTOS_FALTAN_DUO, CUMPLIMIENTO_MANANTIAL, CUANTOS_FALTAN_MANANTIAL, CUMPLIMIENTO_TOTAL, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_DUO', '$CUANTOS_FALTAN_DUO', '$CUMPLIMIENTO_MANANTIAL', '$CUANTOS_FALTAN_MANANTIAL', '$CUMPLIMIENTO_TOTAL', '$fecha')";
				}
			}

			if($table == 'craft' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_DUO_LN = '$CUMPLIMIENTO_DUO_LN', CUMPLIMIENTO_TORRES = '$CUMPLIMIENTO_TORRES', CUMPLIMIENTO_GUAYACAN = '$CUMPLIMIENTO_GUAYACAN', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_DUO_LN, CUMPLIMIENTO_TORRES, CUMPLIMIENTO_GUAYACAN, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_DUO_LN', '$CUMPLIMIENTO_TORRES', '$CUMPLIMIENTO_GUAYACAN', '$fecha')";
				}
			}

			if($table == 'sabores' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_COB_2_SABORES_3L = '$CUMPLIMIENTO_COB_2_SABORES_3L', CUMPLIMIENTO_COB_3_SABORES_3L = '$CUMPLIMIENTO_COB_3_SABORES_3L', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_COB_2_SABORES_3L, CUMPLIMIENTO_COB_3_SABORES_3L, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_COB_2_SABORES_3L', '$CUMPLIMIENTO_COB_3_SABORES_3L', '$fecha')";
				}
			}
			
			if($table == 'bep' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_BEP = '$CUMPLIMIENTO_BEP', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_BEP, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_BEP', '$fecha')";
				}
			}
			if($table == 'lipton' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_LIPTON = '$CUMPLIMIENTO_LIPTON', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_LIPTON, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_LIPTON', '$fecha')";
				}
			}

			if($table == 'redbull' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET COB_250 = '$COB_250', COB_EDITIONS = '$COB_EDITIONS', CUMPLIMIENTO_TOTAL = '$CUMPLIMIENTO_TOTAL', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, COB_250, COB_EDITIONS, CUMPLIMIENTO_TOTAL, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$COB_250', '$COB_EDITIONS', '$CUMPLIMIENTO_TOTAL', '$fecha')";
				}
			}

			if($table == 'mas' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_G1 = '$CUMPLIMIENTO_G1', CUANTOS_FALTAN_G1 = '$CUANTOS_FALTAN_G1', CUMPLIMIENTO_G2 = '$CUMPLIMIENTO_G2', CUANTOS_FALTAN_G2 = '$CUANTOS_FALTAN_G2', CUMP_TOTAL = '$CUMP_TOTAL', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_G1, CUANTOS_FALTAN_G1, CUMPLIMIENTO_G2, CUANTOS_FALTAN_G2, CUMP_TOTAL, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_G1', '$CUANTOS_FALTAN_G1', '$CUMPLIMIENTO_G2', '$CUANTOS_FALTAN_G2', '$CUMP_TOTAL', '$fecha')";
				}
			}

			if($table == 'gatorade' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_3_SKU = '$CUMPLIMIENTO_3_SKU', CUMPLIMIENTO_COB_GATORADE = '$CUMPLIMIENTO_COB_GATORADE', CUMP_VOL = '$CUMP_VOL', CUMP_VOL_750 = '$CUMP_VOL_750', CUPONES = '$CUPONES', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_3_SKU, CUMPLIMIENTO_COB_GATORADE, CUMP_VOL, CUMP_VOL_750, CUPONES, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_3_SKU', '$CUMPLIMIENTO_COB_GATORADE', '$CUMP_VOL', '$CUMP_VOL_750', '$CUPONES', '$fecha')";
				}
			}

			if($table == 'aguas' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_DUO = '$CUMPLIMIENTO_DUO', FALTANTES_DUO = '$FALTANTES_DUO', CUMPLIMIENTO_MANANTIAL = '$CUMPLIMIENTO_MANANTIAL', FALTANTES_MANANTIAL = '$FALTANTES_MANANTIAL', CUMP_TOTAL = '$CUMP_TOTAL', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_DUO, FALTANTES_DUO, CUMPLIMIENTO_MANANTIAL, FALTANTES_MANANTIAL, CUMP_TOTAL, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_DUO', '$FALTANTES_DUO', '$CUMPLIMIENTO_MANANTIAL', '$FALTANTES_MANANTIAL', '$CUMP_TOTAL', '$fecha')";
				}
			}

			if($table == 'heineken' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_VOLUMEN = '$CUMPLIMIENTO_VOLUMEN', CUMP_TOTAL = '$CUMP_TOTAL', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_VOLUMEN, CUMP_TOTAL, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_VOLUMEN', '$CUMP_TOTAL', '$fecha')";
				}
			}
			
			if($table == 'gaseosas' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_PEPSI_MAS_2_SABORES = '$CUMPLIMIENTO_PEPSI_MAS_2_SABORES', CUMPLIMIENTO_PEPSI_MAS_3_SABORES = '$CUMPLIMIENTO_PEPSI_MAS_3_SABORES', CUMPLIMIENTO_TOTAL = '$CUMPLIMIENTO_TOTAL', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_PEPSI_MAS_2_SABORES, CUMPLIMIENTO_PEPSI_MAS_3_SABORES, CUMPLIMIENTO_TOTAL, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_PEPSI_MAS_2_SABORES', '$CUMPLIMIENTO_PEPSI_MAS_3_SABORES', '$CUMPLIMIENTO_TOTAL', '$fecha')";
				}
			}

			if($table == 'energia' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_REDBULL = '$CUMPLIMIENTO_REDBULL', CUMPLIMIENTO_ROCKSTAR = '$CUMPLIMIENTO_ROCKSTAR', FALTANTES_REDBULL = '$FALTANTES_REDBULL', FALTANTES_ROCKSTAR = '$FALTANTES_ROCKSTAR', CUMPL_VOL_REDBULL = '$CUMPL_VOL_REDBULL', CUMPL_VOL_ROCKSTAR = '$CUMPL_VOL_ROCKSTAR', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_REDBULL, CUMPLIMIENTO_ROCKSTAR, FALTANTES_REDBULL, FALTANTES_ROCKSTAR, CUMPL_VOL_REDBULL, CUMPL_VOL_ROCKSTAR, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_REDBULL', '$CUMPLIMIENTO_ROCKSTAR', '$FALTANTES_REDBULL', '$FALTANTES_ROCKSTAR', '$CUMPL_VOL_REDBULL', '$CUMPL_VOL_ROCKSTAR', '$fecha')";
				}
			}

			if($table == 'cpch' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_MISTRAL_ICE_3R = '$CUMPLIMIENTO_MISTRAL_ICE_3R', CUMPLIMIENTO_MISTRAL_ICE_LOW = '$CUMPLIMIENTO_MISTRAL_ICE_LOW', FALTANTES_MISTRAL_ICE_3R = '$FALTANTES_MISTRAL_ICE_3R', FALTANTES_MISTRAL_ICE_LOW = '$FALTANTES_MISTRAL_ICE_LOW', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_MISTRAL_ICE_3R, CUMPLIMIENTO_MISTRAL_ICE_LOW, FALTANTES_MISTRAL_ICE_3R, FALTANTES_MISTRAL_ICE_LOW, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_MISTRAL_ICE_3R', '$CUMPLIMIENTO_MISTRAL_ICE_LOW', '$FALTANTES_MISTRAL_ICE_3R', '$FALTANTES_MISTRAL_ICE_LOW', '$fecha')";
				}
			}

			if($table == 'royalweekend' ){
				$sql = "SELECT COUNT(*) FROM registro_$table WHERE id = $id";
				if (DB::getOne($sql)) {
					$sql = "UPDATE registro_$table SET CUMPLIMIENTO_VOLUMEN = '$CUMPLIMIENTO_VOLUMEN', FALTANTES_VOLUMEN = '$FALTANTES_VOLUMEN', fecha = '$fecha' WHERE id = $id";
				} else {
					$sql = "INSERT INTO registro_$table (tipo, id, nombre, canal, CUMPLIMIENTO_VOLUMEN, FALTANTES_VOLUMEN, fecha) VALUES ";
					$sql.= "('$tipo', $id, '$nombre', '$canal', '$CUMPLIMIENTO_VOLUMEN', '$FALTANTES_VOLUMEN', '$fecha')";
				}
			}
			
			return DB::query($sql);
	    }

		public function getRegistroDataAllNewByTable($table){
			$sql	= "SELECT 
							R.*,
							M.supervisor_id,
							M.distrito
						FROM registro_$table R 
						INNER JOIN master M ON (M.id = R.id)
						ORDER BY 
							R.tipo, R.canal";
			return 	DB::getAll( $sql );
		}


		public function getJefeDeVentaByTableBySupervisorId($table , $supervisor_id){
			if(!empty($supervisor_id) && is_numeric($supervisor_id)){
				$sql	= "SELECT 
								R.* 
							FROM registro_$table R 
							INNER JOIN master M ON (M.id = R.id)
							WHERE 
								R.tipo = 'JDV' 
								AND M.supervisor_id = $supervisor_id
							ORDER BY 
								R.nombre";
				return 	DB::getAll( $sql );
			}
			return false;
		}


		public function getDistritoByTableById($table, $id){
			if(!empty($id) && is_numeric($id)){
				$sql	= "SELECT 
								D.zona_id,
								D.dist_nombre,
								R.*
							FROM distrito D 
							INNER JOIN zona Z ON (Z.zona_id = D.zona_id)
							INNER JOIN registro_$table R ON (R.id = D.id)
							WHERE R.id = $id 
							ORDER BY D.dist_orden";
				return 	DB::getRow( $sql );
			}
			return false;
		}


		public function getVendedorByTableBySupervisorId($table, $supervisor_id){
			if(!empty($supervisor_id) && is_numeric($supervisor_id)){
				$sql	= "SELECT 
								R.* 
							FROM registro_$table R 
							INNER JOIN master M ON (M.id = R.id)
							WHERE 
								R.tipo = 'VENDEDOR' 
								AND M.supervisor_id = $supervisor_id
							ORDER BY 
								R.nombre";
				return 	DB::getAll( $sql );
			}
			return false;
		}

		public function getRegistroByTableById($table, $id){
			if(!empty($id) && is_numeric($id)){
				$sql 	= "SELECT 
								R.*,
								M.supervisor_id 
							FROM registro_$table R
							INNER JOIN master M ON (M.id = R.id) 
							WHERE 
								R.id = $id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

		public function getIdsVendedorByTableBySupervisorId($table, $supervisor_id){
			if(!empty($supervisor_id) && is_numeric($supervisor_id)){
				$sql	= "SELECT 
								R.id 
							FROM registro_$table R 
							INNER JOIN master M ON (M.id = R.id)
							WHERE 
								R.tipo = 'VENDEDOR' 
								AND M.supervisor_id = $supervisor_id
							ORDER BY 
								R.nombre";
				$elements = DB::getAll( $sql );
				if(is_array($elements)){
					$ids = array();
					foreach($elements as $element){
						$ids[] = $element->id;
					}
					return implode(',',$ids);
			 	}
			}
			return false;
		}

		public function getTotalesByTable($table){
			if(!empty($table) && is_string($table)){
				$sql 	= "SELECT 
								R.* 
							FROM registro_$table R
							WHERE 
								R.id = 999999";
	        	return DB::getRow( $sql );
			}
			return false;
		}


		public function getDistritoByTableByZonaId($table, $zona_id, $dist_mayorista = false){
			$sqlWhere = '';
			if($dist_mayorista){
				$sqlWhere	= "AND D.dist_mayorista = 'S'";
			}

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
								$sqlWhere
							ORDER BY D.dist_orden";
				
				return 	DB::getAll( $sql );
			}
			return false;
		}


		public function getSubTotalByTableByTipo($table, $tipo){
			if(!empty($tipo) && is_string($tipo)){
				$sql 	= "SELECT 
								R.* 
							FROM registro_$table R
							WHERE 
								R.tipo = '$tipo'";

				return DB::getRow( $sql );
			}
			return false;		
		}
		/**	
		 * END funciones por tabla
		 */

	}
?>