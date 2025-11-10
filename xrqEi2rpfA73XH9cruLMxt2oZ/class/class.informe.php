<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class informe extends DB {

		public function getCampanas(){
			$campanas[] = ['grupo' => 'craft', 'nombre' => 'Craft', 'fecha_inicio' => '2024-06-01', 'fecha_fin' => '2024-07-31'];
			$campanas[] = ['grupo' => 'lipton', 'nombre' => 'Lipton', 'fecha_inicio' => '2024-06-01', 'fecha_fin' => '2024-07-31'];
			$campanas[] = ['grupo' => 'sabores', 'nombre' => 'Sabores', 'fecha_inicio' => '2024-06-01', 'fecha_fin' => '2024-07-31'];
			$campanas[] = ['grupo' => 'tirate', 'nombre' => 'Tírate al agua', 'fecha_inicio' => '2024-06-01', 'fecha_fin' => '2024-07-31'];
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
					GROUP BY 
						I.ingr_fecha
					ORDER BY 
						I.ingr_fecha DESC";
			return DB::getAll($sql);
		}

		public function getIngresosConsolidado(){
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
						) AS ingresos
					FROM ingreso I 
						INNER JOIN master M ON (I.cliente_id = M.id)
						LEFT JOIN zona Z ON (Z.zona_id = I.zona_id)
						LEFT JOIN distrito D ON (D.distrito_id = I.distrito_id)
					WHERE 
						1 = 1
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