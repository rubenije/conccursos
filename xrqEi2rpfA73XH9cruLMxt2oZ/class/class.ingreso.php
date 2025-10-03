<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	
	include_once(INCLUDE_PATH.'class/class.registro.php');	
	
	

	class ingreso extends DB {
	    
	    public function getIngresoId($ingreso_id){
			if(!empty($ingreso_id) && is_numeric($ingreso_id)){
				$sql 	= "SELECT * FROM ingreso WHERE ingreso_id = $ingreso_id LIMIT 1";
	        	return DB::getRow($sql);
			}
			return false;		
	    }

		public function getDistritoByCodigo($dist_codigo){
			if(!empty($dist_codigo) && is_string($dist_codigo)){
				$sql 	= "SELECT * FROM distrito WHERE dist_codigo = '$dist_codigo' LIMIT 1";
	        	return DB::getRow($sql);
			}
			return false;		
	    }


	    public function getIngresoByClienteId($cliente_id){
			if(!empty($cliente_id) && is_numeric($cliente_id)){
				$ingr_fecha = date('Y-m-d');
				$sql 	= "SELECT COUNT(*) FROM ingreso WHERE cliente_id = $cliente_id AND ingr_fecha LIKE '$ingr_fecha' LIMIT 1";
	        	return DB::getOne($sql);
			}
			return false;		
	    }

	    public function saveIngreso($data){
			extract($data);
			$ingreso_id 	= 0;
            $cliente_id 	= (int) $cliente_id;
			$distrito_id 	= (int) $distrito_id;
			$supervisor_id 	= (int) $supervisor_id;
			$zona_id 		= (int) $zona_id;

	        if($tipo == 'JDV' || $tipo == 'VENDEDOR'){
				$ingr_fecha 	= date('Y-m-d');
				$ingr_hora 		= date('H:i:s');
				$sql = "INSERT INTO ingreso (grupo, tipo, cliente_id, distrito_id, zona_id, supervisor_id, ingr_fecha, ingr_hora) VALUES ('$grupo', '$tipo', $cliente_id, $distrito_id, $zona_id, $supervisor_id, '$ingr_fecha', '$ingr_hora')";

				return DB::query($sql);
			}
			return false;
		}

	    public function getIngresoAll(){
			$sql	= "SELECT * FROM ingreso ORDER BY ingreso_id ASC";
			return 	DB::getAll( $sql );
		}


		public function deleteIngresoId($ingreso_id){
			if(!empty($ingreso_id) && is_numeric($ingreso_id)){
				$delete = array('ingreso_id' => $ingreso_id);
	        	return DB::delete('ingreso', $delete, 1 );
			}
			return false;
		}



		public function getIngresosPorDistrito($zona_id, $distrito_id){
			$table = $_SESSION['LOGIN_GRUPO'];
			if(empty($table)) {
				return 0;
			}
			$sql = "SELECT 
						count(*) 
					FROM 
						ingreso I
						INNER JOIN registro_$table R ON ( R.id = I.cliente_id ) 
						INNER JOIN master M ON (M.id = R.id)
					WHERE 
						I.zona_id = $zona_id 
						AND I.distrito_id = $distrito_id 
						AND I.grupo = '$table'";
			return (int) DB::getOne( $sql );
		}

		public function getIngresosPorDistritoUnicos($zona_id, $distrito_id){
			$table = $_SESSION['LOGIN_GRUPO'];
			if(empty($table)) {
				return 0;
			}
			$sql = "SELECT 
						DISTINCT(I.cliente_id) 
					FROM
						ingreso I
						INNER JOIN registro_$table R ON ( R.id = I.cliente_id ) 
						INNER JOIN master M ON (M.id = R.id)
					WHERE 
						I.zona_id = $zona_id 
						AND I.distrito_id = $distrito_id 
						AND I.grupo = '$table'";
			$elements = DB::getAll( $sql );
			return count($elements);
		}

		public function getIngresosByClienteId($cliente_id){
			$table = $_SESSION['LOGIN_GRUPO'];
			if(empty($table)) {
				return 0;
			}
			$sql = "SELECT count(*) 
					FROM 
						ingreso I 
						INNER JOIN registro_$table R ON ( R.id = I.cliente_id ) 
						INNER JOIN master M ON (M.id = R.id)
					WHERE 
						I.cliente_id = $cliente_id
						AND I.grupo = '$table'";
			return (int) DB::getOne( $sql );
		}



		public function getIngresosBySupervisorId($supervisor_id){
			$table = $_SESSION['LOGIN_GRUPO'];
			if(empty($table)) {
				return 0;
			}
			$sql = "SELECT count(*) 
					FROM 
						ingreso I 
						INNER JOIN registro_$table R ON ( R.id = I.cliente_id ) 
						INNER JOIN master M ON (M.id = R.id)
					WHERE 
						I.supervisor_id = $supervisor_id
						AND I.grupo = '$table'";
			return (int) DB::getOne( $sql );
		}
	}
?>