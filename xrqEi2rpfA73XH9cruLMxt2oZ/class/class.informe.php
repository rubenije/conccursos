<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class informe extends DB {

		public function getCampanas(){
			$campanas[] = ['grupo' => 'cervezas', 'nombre' => 'Cervezas Masivas', 'fecha_inicio' => '2026-08-05', 'fecha_fin' => '2026-09-30', 'estado' => 'Online', 'columnas' => [
            'CUMPLIMIENTO_VOLUMEN_CRIS_ESC',
			'HL_FALTANTE'
        ]];
			$campanas[] = ['grupo' => 'gaseosas_sabores', 'nombre' => 'Gaseosas Sabores', 'fecha_inicio' => '2026-08-05', 'fecha_fin' => '2026-09-30', 'estado' => 'Online', 'columnas' => [
            'CUMPLIMIENTO_SABORES_COBERTURA',
			'CLIENTES_FALTANTE'
        ]];
			$campanas[] = ['grupo' => 'redbull2026', 'nombre' => 'Red Bull', 'fecha_inicio' => '2026-08-05', 'fecha_fin' => '2026-09-30', 'estado' => 'Online', 'columnas' => [
            'CUMPLIMIENTO_250_ROMBO',
			'CUMPLIMIENTO_EDITIONS',
			'CUMPLIMIENTO_PONDERADO'
        ]];
			return $campanas;
		}

		public function getCampanasInactivas(){
					$campanas[] = ['grupo' => 'kunstmann', 'nombre' => 'Kunstmann', 'fecha_inicio' => '2026-06-05', 'fecha_fin' => '2026-06-31', 'estado' => 'Offline', 'columnas' => [
						'CUMPLIMIENTO_VOL_KUNSTMANN',
						'HL_FALTANTES'
					]];
					$campanas[] = ['grupo' => 'bep2026', 'nombre' => 'Beep', 'fecha_inicio' => '2026-06-05', 'fecha_fin' => '2026-07-31', 'estado' => 'Offline', 'columnas' => [
						'CUMPLIMIENTO_CONC_BEP',
						'CUMPLIMIENTO_VOL_BEP'
					]];
						$campanas[] = ['grupo' => 'gatorade2026', 'nombre' => 'Gatorade', 'fecha_inicio' => '2026-06-08', 'fecha_fin' => '2026-08-31', 'estado' => 'Offline', 'columnas' => [
						'CUMPLIMIENTO_HORIZONTAL',
						'CUMPLIMIENTO_ACELERADOR_750_1LT',
						'CUMPLIMIENTO_VOL_GATORADE',
						'CUMPLIMIENTO_VOL_ACELERADOR'
					]];
						$campanas[] = ['grupo' => 'watts', 'nombre' => 'Watts', 'fecha_inicio' => '2026-06-08', 'fecha_fin' => '2026-08-31', 'estado' => 'Offline', 'columnas' => [
						'CUMPLIMIENTO_3_SABORES',
						'CUMPLIMIENTO_LIGHT',
						'CUMPLIMIENTO_VOL_R',
						'CUMPLIMIENTO_VOL_LIGHT'
					]];
					
				$campanas[] = ['grupo' => 'royalweekend', 'nombre' => 'Royal Weekend', 'fecha_inicio' => '2026-04-13', 'fecha_fin' => '2026-06-05', 'estado' => 'Offline', 'columnas' => [
					'CUMPLIMIENTO_VOLUMEN'
				]];
					$campanas[] = ['grupo' => 'energia', 'nombre' => 'Energia', 'fecha_inicio' => '2026-04-15', 'fecha_fin' => '2026-06-05', 'estado' => 'Offline', 'columnas' => [
					'CUMPLIMIENTO_REDBULL',
					'CUMPLIMIENTO_ROCKSTAR',
					'CUMPL_VOL_REDBULL',
					'CUMPL_VOL_ROCKSTAR'
				]];
					$campanas[] = ['grupo' => 'cpch', 'nombre' => 'CPCH - Zona Comercial', 'fecha_inicio' => '2026-04-15', 'fecha_fin' => '2026-06-05', 'estado' => 'Offline', 'columnas' => [
					'CUMPLIMIENTO_MISTRAL_ICE_3R',
					'CUMPLIMIENTO_MISTRAL_ICE_LOW'
				]];
			$campanas[] = ['grupo' => 'gaseosas', 'nombre' => 'Gaseosas', 'fecha_inicio' => '2026-02-12', 'fecha_fin' => '2026-04-13', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_PEPSI_MAS_2_SABORES',
				'CUMPLIMIENTO_PEPSI_MAS_3_SABORES'
			]];
			$campanas[] = ['grupo' => 'aguas', 'nombre' => 'Aguas', 'fecha_inicio' => '2026-02-03', 'fecha_fin' => '2026-04-13', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_DUO',
				'CUMPLIMIENTO_MANANTIAL'
			]];
			$campanas[] = ['grupo' => 'heineken', 'nombre' => 'Heineken', 'fecha_inicio' => '2026-02-05', 'fecha_fin' => '2026-04-20', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_VOLUMEN']];
			$campanas[] = ['grupo' => 'gatorade', 'nombre' => 'Gatorade', 'fecha_inicio' => '2026-01-12', 'fecha_fin' => '2026-03-02', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_3_SKU',
				'CUMPLIMIENTO_COB_GATORADE'
			]];
			$campanas[] = ['grupo' => 'mas', 'nombre' => 'Mas', 'fecha_inicio' => '2026-01-06', 'fecha_fin' => '2026-02-02', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_G1',
				'CUMPLIMIENTO_G2',
				'CUMP_TOTAL'
			]];
			$campanas[] = ['grupo' => 'redbull', 'nombre' => 'Red Bull', 'fecha_inicio' => '2025-12-10', 'fecha_fin' => '2026-02-02', 'estado' => 'Offline', 'columnas' => [
				'COB_250',
				'COB_EDITIONS',
				'CUMPLIMIENTO_TOTAL'
			]];
			$campanas[] = ['grupo' => 'sabores', 'nombre' => 'Sabores', 'fecha_inicio' => '2025-10-10', 'fecha_fin' => '2026-01-05', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_COB_2_SABORES_3L',
				'CUMPLIMIENTO_COB_3_SABORES_3L'
			]];
			$campanas[] = ['grupo' => 'lipton', 'nombre' => 'Lipton', 'fecha_inicio' => '2025-11-06', 'fecha_fin' => '2025-12-02', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_LIPTON'
			]];
			$campanas[] = ['grupo' => 'craft', 'nombre' => 'Craft', 'fecha_inicio' => '2025-10-06', 'fecha_fin' => '2025-12-02', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_DUO_LN',
				'CUMPLIMIENTO_TORRES',
				'CUMPLIMIENTO_GUAYACAN'
			]];
			$campanas[] = ['grupo' => 'tirate', 'nombre' => 'Tírate', 'fecha_inicio' => '2025-10-01', 'fecha_fin' => '2025-12-02', 'estado' => 'Offline', 'columnas' => [
				'CUMPLIMIENTO_DUO',
				'CUMPLIMIENTO_MANANTIAL',
				'CUMPLIMIENTO_TOTAL'
			]];
			
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

		public function getIngresosConsolidado($grupo = ''){

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = addslashes($_SESSION['FECHA_DESDE']);
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}

			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = addslashes($_SESSION['FECHA_HASTA']);
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			// Grupos válidos
			$campanas = $this->getCampanas();
			
			$columnas = [];
			foreach ($campanas as $campana) {
				if ($campana['grupo'] !== $grupo) {
					continue;
				}
				 $columnas[] = "RG." . implode(", RG.", $campana['columnas']);
				
				//$grupo = $campana['grupo'];

				$sql = "
					SELECT
						RG.id,
						RG.nombre,
						RG.tipo,
						RG.canal,
						RVC.grupo,
						RVC.primera_visita,
						RVC.ultima_visita,
						RVC.total_visitas,
						" . implode(", ", $columnas) . "
					FROM registro_{$grupo} RG
						LEFT JOIN vw_resumen_visitas_cliente RVC ON RVC.cliente_id = RG.id
						AND RVC.grupo = '{$grupo}' 
					WHERE 
						RG.tipo = 'JDV' OR RG.tipo = 'VENDEDOR'
					ORDER BY 
						COALESCE(RVC.total_visitas, 0) DESC";

				return DB::getAll($sql);
			}
		}


		public function getIngresosConsolidadoInactivas($grupo = ''){

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = addslashes($_SESSION['FECHA_DESDE']);
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}

			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = addslashes($_SESSION['FECHA_HASTA']);
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			// Grupos válidos
			$campanas = $this->getCampanasInactivas();
			
			$columnas = [];
			foreach ($campanas as $campana) {
				if ($campana['grupo'] !== $grupo) {
					continue;
				}
				 $columnas[] = "RG." . implode(", RG.", $campana['columnas']);
				
				//$grupo = $campana['grupo'];

				$sql = "
					SELECT
						RG.id,
						RG.nombre,
						RG.tipo,
						RG.canal,
						RVC.grupo,
						RVC.primera_visita,
						RVC.ultima_visita,
						RVC.total_visitas,
						" . implode(", ", $columnas) . "
					FROM registro_{$grupo} RG
						LEFT JOIN vw_resumen_visitas_cliente RVC ON RVC.cliente_id = RG.id
						AND RVC.grupo = '{$grupo}' 
					WHERE 
						RG.tipo = 'JDV' OR RG.tipo = 'VENDEDOR'
					ORDER BY 
						COALESCE(RVC.total_visitas, 0) DESC";
						
				return DB::getAll($sql);
			}
		}


		public function getIngresosUnicosByGrupo($grupo){

			$whereGrupo = "";
			$whereGrupos = "";

			if(!empty($grupo)){
				$grupo = addslashes($grupo);
				$whereGrupo = "AND I.grupo = '$grupo' ";
			} else {
				$grupos = array_column($this->getCampanas(), 'grupo');
				$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";
				$whereGrupos = "AND I.grupo IN ($inGrupos)";
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($_SESSION['FECHA_DESDE'])){
				$desde = addslashes($_SESSION['FECHA_DESDE']);
				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}

			if(!empty($_SESSION['FECHA_HASTA'])){
				$hasta = addslashes($_SESSION['FECHA_HASTA']);
				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "SELECT 
						I.cliente_id AS id,
						M.nombre,
						M.tipo,
						Z.zona_codigo AS zona_nombre,
						D.dist_codigo AS dist_nombre,
						MAX(I.ingr_fecha) AS ingr_fecha,
						MAX(I.ingr_hora) AS ingr_hora,
						I.supervisor_id,
						COUNT(*) AS ingresos
					FROM ingreso I 
						INNER JOIN master M ON (I.cliente_id = M.id)
						LEFT JOIN zona Z ON (Z.zona_id = I.zona_id)
						LEFT JOIN distrito D ON (D.distrito_id = I.distrito_id)
					WHERE 
						1 = 1
						$whereGrupo 
						$whereGrupos
						$whereDesde
						$whereHasta
					GROUP BY 
						I.cliente_id,
						M.nombre,
						Z.zona_codigo,
						D.dist_codigo,
						I.supervisor_id
					ORDER BY
						ingresos DESC,
						ingr_fecha DESC, 
						ingr_hora DESC";
			return DB::getAll($sql);
		}


		public function getIngresosTotalesByGrupo($grupo)
		{
			$whereGrupo = "";
			$whereGrupos = "";

			if(!empty($grupo)){

				$grupo = addslashes($grupo);

				$whereGrupo = "AND I.grupo = '$grupo' ";

			} else {

				$grupos = array_column($this->getCampanas(), 'grupo');

				$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";

				$whereGrupos = "AND I.grupo IN ($inGrupos)";
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($_SESSION['FECHA_DESDE'])){

				$desde = addslashes($_SESSION['FECHA_DESDE']);

				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}

			if(!empty($_SESSION['FECHA_HASTA'])){

				$hasta = addslashes($_SESSION['FECHA_HASTA']);

				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "
				SELECT
					I.cliente_id as 'id',
					M.nombre,
					M.tipo,
					Z.zona_codigo AS zona_nombre,
					D.dist_codigo AS dist_nombre,
					I.ingr_fecha,
					I.ingr_hora,
					I.supervisor_id,
					I.grupo

				FROM ingreso I

				INNER JOIN master M
					ON (I.cliente_id = M.id)

				LEFT JOIN zona Z
					ON (Z.zona_id = I.zona_id)

				LEFT JOIN distrito D
					ON (D.distrito_id = I.distrito_id)

				WHERE
					1 = 1
					$whereGrupo
					$whereGrupos
					$whereDesde
					$whereHasta

				ORDER BY
					I.ingr_fecha DESC,
					I.ingr_hora DESC
			";

			return DB::getAll($sql);
		}

		public function getUsabilidadPlataforma($grupo = null)
		{
			$whereGrupo = "";
			$whereGrupos = "";

			if(!empty($grupo)){

				$grupo = addslashes($grupo);

				$whereGrupo = "AND I.grupo = '$grupo' ";

			} else {

				$grupos = array_column($this->getCampanas(), 'grupo');

				$inGrupos = "'" . implode("','", array_map('addslashes', $grupos)) . "'";

				$whereGrupos = "AND I.grupo IN ($inGrupos)";
			}

			$whereDesde = '';
			$whereHasta = '';

			if(!empty($_SESSION['FECHA_DESDE'])){

				$desde = addslashes($_SESSION['FECHA_DESDE']);

				$whereDesde = "AND I.ingr_fecha >= '$desde' ";
			}

			if(!empty($_SESSION['FECHA_HASTA'])){

				$hasta = addslashes($_SESSION['FECHA_HASTA']);

				$whereHasta = "AND I.ingr_fecha <= '$hasta' ";
			}

			$sql = "
				SELECT
					COUNT(*) AS total,

					SUM(
						CASE
							WHEN T.ingresos > 40 THEN 1
							ELSE 0
						END
					) AS sobre_40,

					SUM(
						CASE
							WHEN T.ingresos BETWEEN 20 AND 39 THEN 1
							ELSE 0
						END
					) AS entre_20_39,

					SUM(
						CASE
							WHEN T.ingresos < 20 THEN 1
							ELSE 0
						END
					) AS menos_20

				FROM (

					SELECT
						I.cliente_id,
						COUNT(*) AS ingresos

					FROM ingreso I

					WHERE
						1 = 1
						$whereGrupo
						$whereGrupos
						$whereDesde
						$whereHasta

					GROUP BY I.cliente_id

				) T
			";

			return DB::getRow($sql);
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