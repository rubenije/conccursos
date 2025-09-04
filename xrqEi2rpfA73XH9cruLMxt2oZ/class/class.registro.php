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

		public function getTotales(){
			
				$sql 	= "SELECT 
								R.* 
							FROM registro R
							WHERE 
								R.id = 999999";
	        	return DB::getRow( $sql );
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


	    public function saveRegistro($data){
			extract($data);
        	$id 			= (int) $id;
			$m_cupones 		= (int) $m_cupones;
			$e_cupones 		= (int) $e_cupones;
			$nombre 		= DB::filter($nombre);
			$contable 		= $contable ?? date('Y-m-d');
			$fecha 			= $fecha ?? date('Y-m-d');
        	
        	$sql = "SELECT COUNT(*) FROM registro WHERE id = $id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE registro SET m_cob_conjunta = '$m_cob_conjunta', m_cob_concretar = '$m_cob_concretar', m_cob_nectar = '$m_cob_nectar', m_cob_nectar_concretar = '$m_cob_nectar_concretar', m_cupones = '$m_cupones', e_cob_conjunta = '$e_cob_conjunta', e_cob_concretar = '$e_cob_concretar', e_cob_redbull = '$e_cob_redbull', e_cob_rebull_concretar = '$e_cob_rebull_concretar', e_cupones = '$e_cupones', contable= '$contable', fecha = '$fecha' WHERE id = $id";
	        } else {
	        	$sql = "INSERT INTO registro (tipo, id, nombre, canal, m_cob_conjunta, m_cob_concretar, m_cob_nectar, m_cob_nectar_concretar, m_cupones, e_cob_conjunta, e_cob_concretar, e_cob_redbull, e_cob_rebull_concretar, e_cupones, contable, fecha) VALUES ";
				$sql.= "('$tipo', $id, '$nombre', '$canal', '$m_cob_conjunta', '$m_cob_concretar', '$m_cob_nectar', '$m_cob_nectar_concretar', '$m_cupones', '$e_cob_conjunta', '$e_cob_concretar', '$e_cob_redbull', '$e_cob_rebull_concretar', '$e_cupones', '$contable', '$fecha')";
	        }
			echo $sql."<br>";
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

		public function getSubgerentes(){
			$sql = "SELECT 
						R.* 
					FROM 
						distrito D
						INNER JOIN registro R ON (R.id = D.id) 
					ORDER BY 
						D.dist_orden";
			return DB::getAll($sql);
		}

	}
?>