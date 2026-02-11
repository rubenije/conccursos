<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class concurso extends DB {
	    
		
		public function getConcursoId($concurso_id){
			if(!empty($concurso_id) && is_numeric($concurso_id)){
				$sql 	= "SELECT * FROM concurso WHERE concurso_id = $concurso_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

		public function getConcursoAll(){
			$sql	= "SELECT * FROM concurso ORDER BY conc_orden ASC";
			return 	DB::getAll( $sql );
		}

		public function getConcursoInactivo(){
			$sql	= "SELECT * FROM concurso WHERE conc_estado = 'I' ORDER BY conc_orden ASC";
			return 	DB::getAll( $sql );
		}


		public function getConcursosVigentesHoy(){
			$sql = "SELECT 
						*
					FROM concurso
					WHERE 
						conc_inicio <= CURDATE()
						AND conc_termino >= CURDATE() 
						AND conc_estado = 'A'
					ORDER BY 
						conc_orden ASC";
			return DB::getAll($sql);
		}



		public function saveConcurso($data){
	    	extract($data);
        	$concurso_id 	= 0;
        	$conc_orden 	= (int) $conc_orden;
        	$sql = "SELECT COUNT(*) FROM concurso WHERE concurso_id=$concurso_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE concurso SET conc_grupo='$conc_grupo', conc_nombre='$conc_nombre', conc_inicio='$conc_inicio', conc_termino='$conc_termino', conc_estado = '$conc_estado', conc_orden = $conc_orden WHERE concurso_id=$concurso_id";
	        } else {
	        	$sql = "INSERT INTO concurso (concurso_id, conc_grupo, conc_nombre, conc_inicio, conc_termino, conc_estado, conc_orden) VALUES ($concurso_id, '$conc_grupo', '$conc_nombre', '$conc_inicio', '$conc_termino', '$conc_estado', $conc_orden)";
	        }
	        return DB::query($sql);
		}

		public function deleteClienteId($concurso_id){
			if(!empty($concurso_id) && is_numeric($concurso_id)){
				$delete = array('concurso_id' => $concurso_id);
	        	return DB::delete('concurso', $delete, 1 );
			}
			return false;
		}

	}
?>