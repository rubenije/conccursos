<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');
	include_once(INCLUDE_PATH.'class/class.concurso.php');

	class informe extends DB {

		public function getCampanas(){
			$concurso = new concurso();
			$concursos = $concurso->getConcursosVigentesHoy(); // <- ahora viene array de objetos

			$campanas = [];

			if (!empty($concursos)) {
				foreach ($concursos as $c) {
					$campanas[] = [
						'grupo'        => $c->conc_grupo,
						'nombre'       => $c->conc_nombre,
						'fecha_inicio' => $c->conc_inicio,
						'fecha_fin'    => $c->conc_termino,
					];
				}
			}

			return $campanas;
		}



		public function getCampanasInactivas(){
			$concurso = new concurso();
			$concursos = $concurso->getConcursoInactivo(); // <- ahora viene array de objetos

			$campanas = [];

			if (!empty($concursos)) {
				foreach ($concursos as $c) {
					$campanas[] = [
						'grupo'        => $c->conc_grupo,
						'nombre'       => $c->conc_nombre,
						'fecha_inicio' => $c->conc_inicio,
						'fecha_fin'    => $c->conc_termino,
					];
				}
			}

			return $campanas;
		}


		public function getConsolidadoPorConcurso($desde = '', $hasta = ''){

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}
			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$grupos = array_column($this->getCampanas(), 'grupo');
			$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";
			$whereGrupos = "AND I.grupo IN ($inGrupos)";
			
			$sql = "SELECT 
						I.grupo,
						COUNT(*) AS ingresos,
						COUNT(DISTINCT I.cliente_id) AS unicos,
						COUNT(DISTINCT I.ingr_fecha) AS actividad
					FROM 
						ingreso I
					WHERE 
						1 = 1
						$whereDesde
						$whereHasta
						$whereGrupos
					GROUP BY 
						I.grupo
					ORDER BY 
						unicos DESC";
			return DB::getAll($sql);
		}


		public function getConsolidadoPorZona($desde = '', $hasta = ''){
			
			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$grupos = array_column($this->getCampanas(), 'grupo');
			$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";
			$whereGrupos = "AND I.grupo IN ($inGrupos)";

			$sql = "SELECT 
						Z.zona_codigo,
						COUNT(*) AS ingresos,
						COUNT(DISTINCT I.cliente_id) AS unicos
					FROM ingreso I
						LEFT JOIN zona Z ON Z.zona_id = I.zona_id
					WHERE 
						1 = 1 
						$whereDesde 
						$whereHasta 
						$whereGrupos
					GROUP BY 
						Z.zona_codigo
					ORDER BY 
						unicos DESC";
			return DB::getAll($sql);
		}	


		public function getConsolidadoPorDistrito($desde = '', $hasta = ''){

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$grupos = array_column($this->getCampanas(), 'grupo');
			$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";
			$whereGrupos = "AND I.grupo IN ($inGrupos)";

			$sql = "SELECT 
						D.dist_codigo,
						COUNT(*) AS ingresos,
						COUNT(DISTINCT I.cliente_id) AS unicos
					FROM ingreso I
						LEFT JOIN distrito D ON D.distrito_id = I.distrito_id
					WHERE 
						1 = 1 
						$whereDesde 
						$whereHasta 
						$whereGrupos
					GROUP BY 
						D.dist_codigo
					ORDER BY 
						unicos DESC";
			return DB::getAll($sql);
		}	


		public function getConsolidadoPorDia($desde = '', $hasta = ''){

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}
			$grupos = array_column($this->getCampanas(), 'grupo');
			$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";
			$whereGrupos = "AND I.grupo IN ($inGrupos)";

			$sql = "SELECT 
						I.ingr_fecha,
						COUNT(*) AS ingresos,
						COUNT(DISTINCT I.cliente_id) AS unicos
					FROM 
						ingreso I
					WHERE 
						1 = 1 
						$whereDesde 
						$whereHasta
						$whereGrupos
					GROUP BY 
						I.ingr_fecha
					ORDER BY 
						I.ingr_fecha DESC";
			return DB::getAll($sql);
		}

		public function getIngresosConsolidado(){
			$desde = $_SESSION['FECHA_DESDE'] ?? null;
			$hasta = $_SESSION['FECHA_HASTA'] ?? null;

			// WHERE fechas para tabla I
			$whereDesde = !empty($desde) ? "AND I.ingr_fecha >= '$desde' " : '';
			$whereHasta = !empty($hasta) ? "AND I.ingr_fecha <= '$hasta' " : '';

			// WHERE fechas para subquery I2 (IMPORTANTE)
			$whereDesdeI2 = !empty($desde) ? "AND I2.ingr_fecha >= '$desde' " : '';
			$whereHastaI2 = !empty($hasta) ? "AND I2.ingr_fecha <= '$hasta' " : '';

			// Limitar a grupos válidos (opcional, si quieres acotar a los definidos en getCampanas)
			$grupos = array_column($this->getCampanas(), 'grupo');
			$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";
			$whereGrupos   = "AND I.grupo IN ($inGrupos)";
			$whereGruposI2 = "AND I2.grupo IN ($inGrupos)";
			

			$sql = "SELECT 
						I.cliente_id AS id,
						M.nombre,
						Z.zona_codigo AS zona_nombre,
						D.dist_codigo AS dist_nombre,
						I.grupo,
						I.ingr_fecha,
						I.ingr_hora,
						I.supervisor_id,
						(
							SELECT COUNT(*) 
							FROM ingreso I2 
							WHERE I2.grupo = I.grupo
								$whereDesdeI2
								$whereHastaI2
								$whereGruposI2
						) AS ingresos
					FROM ingreso I 
						INNER JOIN master M ON (I.cliente_id = M.id)
						LEFT JOIN zona Z ON (Z.zona_id = I.zona_id)
						LEFT JOIN distrito D ON (D.distrito_id = I.distrito_id)
					WHERE 
						1 = 1
						$whereDesde
                  		$whereHasta
                  		$whereGrupos
					ORDER BY
						I.ingr_fecha DESC, 
						I.ingr_hora DESC";
			return DB::getAll($sql);
		}


		public function getIngresosByGrupo($grupo){
			$whereGrupo = "";
			if(!empty($grupo)){
				$whereGrupo = "AND I.grupo = '$grupo' ";
			}

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}
			$grupos = array_column($this->getCampanas(), 'grupo');
			$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";
			$whereGrupos = "AND I.grupo IN ($inGrupos)";

			$sql = "SELECT 
						I.cliente_id AS id,
						M.nombre,
						Z.zona_codigo AS zona_nombre,
						D.dist_codigo AS dist_nombre,
						I.ingr_fecha,
						I.ingr_hora,
						I.supervisor_id,
						(
							SELECT COUNT(*) 
							FROM ingreso I2 
							WHERE I2.grupo = I.grupo
						) AS ingresos 
					FROM ingreso I 
						INNER JOIN master M ON (I.cliente_id = M.id)
						LEFT JOIN zona Z ON (Z.zona_id = I.zona_id)
						LEFT JOIN distrito D ON (D.distrito_id = I.distrito_id)
					WHERE 
						1 = 1
						$whereGrupo 
						$whereDesde
						$whereHasta
						$whereGrupos
					ORDER BY
						I.ingr_fecha DESC, 
						I.ingr_hora DESC";
			return DB::getAll($sql);
		}

		public function getIngresosDiarios($grupo){
			
			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "SELECT 
						I.ingr_fecha,
						COUNT(*)                AS ingresos,
						COUNT(DISTINCT R.id)    AS unicos
					FROM ingreso I
						JOIN registro_$grupo R ON R.id = I.cliente_id
					WHERE 
						I.grupo = '$grupo'
						$whereDesde
						$whereHasta
					GROUP BY 
						I.ingr_fecha
					ORDER BY 
						I.ingr_fecha DESC";
			return DB::getAll($sql);
		}

		public function getRankingPorZona($grupo){
			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "SELECT
						Z.zona_id,
						Z.zona_nombre,
						COUNT(*) AS ingresos,
						COUNT(DISTINCT R.id) AS unicos
					FROM ingreso I
						JOIN registro_$grupo R ON R.id = I.cliente_id
						LEFT JOIN zona Z ON Z.zona_id = I.zona_id
					WHERE 
						I.grupo = '$grupo'
						$whereDesde
						$whereHasta
					GROUP BY 
						Z.zona_id, 
						Z.zona_nombre, 
						Z.zona_orden
					ORDER BY 
						ingresos DESC, 
						Z.zona_orden";
			return DB::getAll($sql);
		}


		public function getRankingPorDistrito($grupo){

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "SELECT
						D.distrito_id,
						D.dist_nombre,
						COUNT(*) AS ingresos,
						COUNT(DISTINCT R.id) AS unicos
					FROM ingreso I
						JOIN registro_$grupo R ON R.id = I.cliente_id
						LEFT JOIN distrito D ON D.distrito_id = I.distrito_id
					WHERE 
						I.grupo = '$grupo'
						$whereDesde
						$whereHasta
					GROUP BY 
						D.distrito_id, 
						D.dist_nombre, 
						D.dist_orden
					ORDER BY 
						ingresos DESC, 
						D.dist_orden";
			return DB::getAll($sql);
		}

		public function getRankingActividadPorDia($grupo){

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "SELECT
						R.id AS cliente_id,
						R.nombre,
						COUNT(*) AS ingresos,
						COUNT(DISTINCT I.ingr_fecha) AS activos
					FROM ingreso I
						JOIN registro_$grupo R ON R.id = I.cliente_id
					WHERE 
						I.grupo = '$grupo'
						$whereDesde
						$whereHasta
					GROUP BY 
						R.id, R.nombre
					ORDER BY 
						ingresos DESC, 
						activos DESC
					LIMIT 20";
			return DB::getAll($sql);
		}


		public function getPorcentajeDeParticipacionPorZona($grupo){

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "SELECT
						Z.zona_nombre,
						COUNT(*) AS ingresos,
						ROUND(100 * COUNT(*) / SUM(COUNT(*)) OVER (), 2) AS porcentaje
					FROM ingreso I
						LEFT JOIN zona Z ON Z.zona_id = I.zona_id
					WHERE 
						I.grupo = '$grupo'
						$whereDesde
						$whereHasta
					GROUP BY 
						Z.zona_nombre
					ORDER BY 
						ingresos DESC";
			return DB::getAll($sql);
		}


		public function getVendedoresSinIngresos($grupo){

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = $_SESSION['FECHA_DESDE'];
			}
			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = $_SESSION['FECHA_HASTA'];
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($desde)){
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}
			if(!empty($hasta)){
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "SELECT 
						R.id AS cliente_id,
						R.nombre,
						R.tipo
					FROM registro_$grupo R
					WHERE R.id NOT IN (
						SELECT I.cliente_id
						FROM ingreso I
						WHERE I.grupo = '$grupo'
						$whereDesde
						$whereHasta
					)
					AND R.tipo = 'VENDEDOR'
					ORDER BY R.nombre";
			return DB::getAll($sql);
		}

	}
?>