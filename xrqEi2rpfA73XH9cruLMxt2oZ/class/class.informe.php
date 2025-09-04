<?php 

	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	

	class informe extends DB {


        /* Informe Resumen */
        public function getIngresoClientesUnicos(){
			$sql = "SELECT DISTINCT(I.cliente_id) FROM ingreso I";
			$elements = DB::getAll( $sql );
			return count($elements);
		}
        

        public function getIngresoClientesTotales(){
			$sql = "SELECT count(*) as cantidad FROM ingreso I INNER JOIN cliente C ON (C.cliente_id = I.cliente_id)";
			return (int) DB::getOne($sql);
		}


        public function getCantidadGirosUnicos(){
			$sql = "SELECT cliente_id FROM intento GROUP BY cliente_id";
			$elements = DB::getAll( $sql );
			return count($elements);
		}


        public function getIngresoGirosTotales(){
			$sql = "SELECT COUNT(*) as contador 
					FROM intento I 
					INNER JOIN cliente C ON (C.cliente_id = I.cliente_id) 
					LIMIT 1";
			return DB::getOne($sql);
		}


        public function getGirosByDia(){
			$sql = "SELECT 
						COUNT(*) as cantidad,
						I.inte_fecha
					FROM intento I
					/* INNER JOIN factura F ON (F.factura_id = I.factura_id) */
					INNER JOIN cliente C ON (C.cliente_id = I.cliente_id)  
					GROUP BY
						I.inte_fecha 
					ORDER BY 
						I.inte_fecha DESC";
        	return DB::getAll($sql);
		}

        public function getCantidadGirosUnicosByFecha($inte_fecha){
			$sql = "SELECT cliente_id FROM intento WHERE inte_fecha = '$inte_fecha' GROUP BY cliente_id";
			$elements = DB::getAll( $sql );
			return count($elements);
		}

        public function getIngresosByDia(){
			$sql = "SELECT 
						COUNT(*) as cantidad,
						I.ingr_fecha
					FROM ingreso I
					INNER JOIN cliente C ON (C.cliente_id = I.cliente_id) 
					GROUP BY
						I.ingr_fecha 
					ORDER BY 
						I.ingr_fecha DESC";

            return DB::getAll($sql);
		}

        public function getCantidadIngresosUnicosByFecha($ingr_fecha){
			$sql = "SELECT cliente_id FROM ingreso WHERE ingr_fecha = '$ingr_fecha' GROUP BY cliente_id";
			$elements = DB::getAll( $sql );
			return count($elements);
		}
        





        /* Informe Ganadores */
        public function getListadoPremios(){
            $sql = "SELECT * FROM premio WHERE prem_estado = 'P' OR prem_estado = 'A' ORDER BY prem_fecha, prem_nombre";
            return DB::getAll($sql);
        }
        
        public function getListadoGanadores(){
			$sql = "SELECT 
					P.*,
					C.clie_rut,
					C.clie_nombre,
					C.clie_vendedor
				FROM premio P
				INNER JOIN cliente C ON (C.cliente_id = P.cliente_id)
				WHERE 
                    P.prem_estado = 'A'
                GROUP BY 
                	P.premio_id
				ORDER BY 
                    P.premio_id ASC";

			return DB::getAll($sql);
		}


		public function getListadoGanadoresFormulario(){
			$sql = "SELECT
						R.regi_nombre,
						R.regi_apellido,
						R.regi_rut,
						R.regi_telefono,
						R.regi_email,
						R.regi_direccion,
						CO.comu_nombre,
						P.premio_id,
						P.prem_nombre,
						P.prem_fecha,
						P.prem_estado,
						C.cliente_id,
						C.clie_nombre 
					FROM registro R 
					INNER JOIN cliente C ON (C.cliente_id = R.cliente_id) 
					INNER JOIN premio P ON (P.premio_id = R.premio_id)
					INNER JOIN comuna CO ON (CO.comuna_id = R.comuna_id) 
					WHERE 
						P.prem_estado = 'A' 
					GROUP BY 
						P.premio_id 
					ORDER BY 
						P.premio_id ASC";

			return DB::getAll($sql);
		}

        public function getPremioGruped(){
            $sql = "SELECT prem_nombre, count(*) as cantidad FROM premio GROUP BY prem_nombre";
            return DB::getAll($sql);
        }


        /* Informe Distritos */
        public function getDistritosIntento(){
			$sql = "SELECT distinct(C.clie_distrito) FROM intento I INNER JOIN cliente C ON (C.cliente_id = I.cliente_id)";
			return DB::getAll( $sql );
		}


		public function getDistritos(){
			$sql = "SELECT distinct(C.clie_distrito) FROM ingreso I INNER JOIN cliente C ON (C.cliente_id = I.cliente_id)";
			return DB::getAll( $sql );
		}


		public function getIngresosUnicosByDistrito($clie_distrito){
			$sql = "SELECT distinct(I.cliente_id) FROM intento I INNER JOIN cliente C ON (I.cliente_id = C.cliente_id) WHERE C.clie_distrito = '$clie_distrito'";
			$elements = DB::getAll( $sql );
			return count($elements);
		}

		
		public function getIngresosTotalesByDistrito($clie_distrito){
			$sql = "SELECT count(*) FROM intento I INNER JOIN cliente C ON (I.cliente_id = C.cliente_id) WHERE C.clie_distrito = '$clie_distrito'";
			//$elements = DB::getAll( $sql );
			//return count($elements);
			return DB::getOne($sql);
		}

        //Ingresos 
        public function getInformeGiros(){
        	/*
			$sql = "SELECT 
						C.cliente_id,
						C.clie_rut,	
						C.clie_nombre,
                        C.clie_distrito,
						( SELECT SUM(F.fact_intento) FROM factura F WHERE F.cliente_id = C.cliente_id ) as giros_totales,
						COUNT(I.intento_id) as giros_realizados
					FROM cliente C
						INNER JOIN intento I ON (C.cliente_id = I.cliente_id) 
					GROUP BY 
						C.cliente_id
					ORDER BY 	
						C.clie_nombre";
			*/
			/*
			$sql = "SELECT C.cliente_id,
						(SELECT 
						SUM(F.fact_intento) 
					FROM factura F 
					WHERE 
						F.cliente_id = C.cliente_id) as giros_totales,
						(SELECT 
						COUNT(I.intento_id)
					FROM intento I 
					WHERE 
						I.cliente_id = C.cliente_id) as giros_realizados
					FROM cliente C
						INNER JOIN intento I ON (I.cliente_id = C.cliente_id)
						INNER JOIN factura F ON (F.cliente_id = C.cliente_id) 
					GROUP BY 
						C.cliente_id";
			*/
			$sql = "SELECT 
						DISTINCT(I.cliente_id) as cliente_id,
						C.clie_nombre,
						C.clie_distrito
					FROM 
						intento I
						INNER JOIN cliente C ON (C.cliente_id = I.cliente_id) 
					GROUP BY 
						I.cliente_id";

			return DB::getAll( $sql );
		}


		public function getGirosTotales($cliente_id){
			$sql = "SELECT 
						SUM(F.fact_intento) 
					FROM factura F 
					WHERE 
						F.cliente_id = $cliente_id";
			return (int) DB::getOne($sql);

		}


		public function getGirosRealizados($cliente_id){
			$sql = "SELECT 
						COUNT(I.intento_id)
					FROM intento I 
					WHERE 
						I.cliente_id = $cliente_id";
			return (int) DB::getOne($sql);

		}

		public function getGirosRealizadosByNumero($cliente_id, $fact_numero){
			$sql = "SELECT 
						COUNT(I.intento_id)
					FROM intento I 
					WHERE 
						I.cliente_id = $cliente_id 
						AND I.fact_numero = $fact_numero";
			return (int) DB::getOne($sql);

		}


		public function getInformeGirosNew($mes = 7){

			$where = "WHERE MONTH(I.inte_fecha) = $mes";
			//$where = "WHERE MONTH(I.inte_fecha) = $mes AND C.cliente_id IN (1942319,872702)";
			
			$sql = "SELECT 
						I.cliente_id,
						C.clie_nombre,
						C.clie_distrito,
						I.fact_numero,
						I.inte_fecha,
						F.fact_intento,
						count(I.intento_id) as usados
					FROM factura F 
					INNER JOIN cliente C ON (C.cliente_id = F.cliente_id)
					INNER JOIN intento I ON (I.fact_numero = F.fact_numero)
					$where
					GROUP BY 
						C.cliente_id,
						I.fact_numero,
						I.inte_fecha
					ORDER BY
						I.fact_numero DESC,
						I.inte_fecha ASC";

			return DB::getAll($sql);

		}

		public function getClienteId($cliente_id){
			$sql = "SELECT * FROM cliente WHERE cliente_id = $cliente_id";
			return DB::getRow($sql);
		}


		public function getGanadoresParche(){
			$sql = "SELECT 
						C.cliente_id,
						C.clie_nombre,
						P.prem_fecha,
						P.prem_nombre,
						P.cliente_id,
						IF( R.regi_nombre IS NULL, C.clie_nombre, CONCAT(R.regi_nombre, ' ', R.regi_apellido) ) as regi_nombre,
						regi_apellido,
						regi_rut,
						regi_telefono,
						regi_email,
						regi_direccion
					FROM premio P 
					INNER JOIN cliente C ON (C.cliente_id = P.cliente_id) 
					LEFT JOIN registro R ON (R.premio_id = P.premio_id)
					WHERE 
						P.prem_estado = 'A' 
					GROUP BY 
						P.premio_id
					ORDER BY 
						P.prem_fecha DESC";
			return 	DB::getAll( $sql );
		}


        /*
		public function resumenTotales($tipo = 'T'){
			if($tipo == 'T'){
				$sql = "SELECT count(*) as total FROM registro";
			}
			if($tipo == 'C'){
				$sql = "SELECT count(*) as total FROM registro WHERE cadena_id = 0";
			}
			if($tipo == 'J'){
				$sql = "SELECT count(*) as total FROM registro R INNER JOIN cadena C ON (C.cadena_id = R.cadena_id) WHERE R.cadena_id = 1";
			}
			if($tipo == 'S'){
				$sql = "SELECT count(*) as total FROM registro R INNER JOIN cadena C ON (C.cadena_id = R.cadena_id) WHERE R.cadena_id = 2";
			}
			return (int) DB::getOne( $sql );
		}

		public function getIngresosUnicosByDistrito($clie_distrito){
			$sql = "SELECT distinct(I.cliente_id) FROM intento I INNER JOIN cliente C ON (I.cliente_id = C.cliente_id) WHERE C.clie_distrito = '$clie_distrito'";
			$elements = DB::getAll( $sql );
			return count($elements);
		}

		
		public function getIngresosTotalesByDistrito($clie_distrito){
			$sql = "SELECT count(*) FROM intento I INNER JOIN cliente C ON (I.cliente_id = C.cliente_id) WHERE C.clie_distrito = '$clie_distrito'";
			$elements = DB::getAll( $sql );
			return count($elements);
		}

		
		public function resumenUnicos($tipo = 'T'){
			if($tipo == 'T'){
				$sql = "SELECT distinct(regi_rut) FROM registro R";
			}
			if($tipo == 'C'){
				$sql = "SELECT distinct(regi_rut) FROM registro R WHERE R.cadena_id = 0";
			}
			if($tipo == 'J'){
				$sql = "SELECT distinct(regi_rut) FROM registro R INNER JOIN cadena C ON (C.cadena_id = R.cadena_id) WHERE R.cadena_id = 1";
			}
			if($tipo == 'S'){
				$sql = "SELECT distinct(regi_rut) FROM registro R INNER JOIN cadena C ON (C.cadena_id = R.cadena_id) WHERE R.cadena_id = 2";
			}
			$elements = DB::getAll( $sql );
			return count($elements);
		}

		
		public function getFechaByRegistros(){
			$sql = "SELECT distinct(R.regi_fecha) FROM registro R";
			return DB::getAll( $sql );
		}

		
		public function getResumenTotalPorDia($tipo = 'T', $regi_fecha){
			if(!empty($regi_fecha) && is_string($regi_fecha)){
				if($tipo == 'C'){
					$sql = "SELECT distinct(R.regi_rut) FROM registro R WHERE R.cadena_id = 0 AND R.regi_fecha = '$regi_fecha'";
				}
				if($tipo == 'J'){
					$sql = "SELECT distinct(R.regi_rut) FROM registro R INNER JOIN cadena C ON (C.cadena_id = R.cadena_id) WHERE R.cadena_id = 1 AND R.regi_fecha = '$regi_fecha'";
				}
				if($tipo == 'S'){
					$sql = "SELECT distinct(R.regi_rut) FROM registro R INNER JOIN cadena C ON (C.cadena_id = R.cadena_id) WHERE R.cadena_id = 2 AND R.regi_fecha = '$regi_fecha'";
				}
				$elements = DB::getAll( $sql );
				return count($elements);
			}
		}


		
		public function getDistritos(){
			$sql = "SELECT distinct(C.clie_distrito) FROM ingreso I INNER JOIN cliente C ON (C.cliente_id = I.cliente_id)";
			return DB::getAll( $sql );
		}

		public function getDistritosTotalesByDistrito($clie_distrito){
			if(!empty($clie_distrito) && is_string($clie_distrito)){

				$sql = "SELECT C.cliente, C.clie_distrito FROM intento I INNER JOIN cliente C ON (C.cliente_id = I.cliente_id) WHERE C.clie_distrito LIKE '$clie_distrito'";
				
				echo $sql;
				return (int) DB::getOne($sql);
			}
			return false;
		}


		public function getDistritosUnicosByDistrito($tipo = 'T', $comu_distrito){
			if(!empty($comu_distrito) && is_string($comu_distrito)){
				if($tipo == 'C'){
					$sql = "SELECT distinct(R.regi_rut) FROM registro R INNER JOIN comuna C ON (C.comuna_id = R.comuna_id) WHERE R.cadena_id = 0 AND C.comu_distrito LIKE '$comu_distrito'";
				}
				if($tipo == 'J'){
					$sql = "SELECT distinct(R.regi_rut) FROM registro R INNER JOIN comuna C ON (C.comuna_id = R.comuna_id) WHERE R.cadena_id = 1 AND C.comu_distrito LIKE '$comu_distrito'";
				}
				if($tipo == 'S'){
					$sql = "SELECT distinct(R.regi_rut) FROM registro R INNER JOIN comuna C ON (C.comuna_id = R.comuna_id) WHERE R.cadena_id = 2 AND C.comu_distrito LIKE '$comu_distrito'";
				}
				if($tipo == 'T'){
					$sql = "SELECT distinct(R.regi_rut) FROM registro R INNER JOIN comuna C ON (C.comuna_id = R.comuna_id) WHERE C.comu_distrito LIKE '$comu_distrito'";
				}
				$elements = DB::getAll( $sql );
				return count($elements);
			}
		}


		public function getEdades(){
			$sql = "SELECT distinct(R.regi_edad) FROM registro R ORDER BY R.regi_edad ASC";
			return DB::getAll( $sql );
		}

		public function getRegistroByEdad($tipo = 'T', $regi_edad){
			if(!empty($regi_edad) && is_string($regi_edad)){
				if($tipo == 'C'){
					$sql = "SELECT count(*) as total FROM registro R WHERE R.cadena_id = 0 AND R.regi_edad = '$regi_edad'";
				}
				if($tipo == 'J'){
					$sql = "SELECT count(*) as total FROM registro R WHERE R.cadena_id = 1 AND R.regi_edad = '$regi_edad'";
				}
				if($tipo == 'S'){
					$sql = "SELECT count(*) as total FROM registro R WHERE R.cadena_id = 2 AND R.regi_edad = '$regi_edad'";
				}
				return (int) DB::getOne($sql);
			}
			return false;
		}


		public function getListadoByCadenaId($cadena_id){
			$sql = "SELECT 
						R.registro_id,
						R.codi_nombre,
						R.regi_nombre,
						R.regi_apellido,
						R.regi_rut,
						R.regi_email,
						R.regi_telefono,
						R.regi_nacimiento,
						R.regi_edad,
						R.regi_fecha,
						R.regi_hora,
						R.regi_numero,
						R.regi_boleta,
						R.regi_mayor,
						R.regi_bases,
						C.comu_nombre,
						C.comu_distrito,
						C.comu_region,
						CA.cade_nombre
					FROM registro R 
					INNER JOIN comuna C ON (C.comuna_id = R.comuna_id) 
					LEFT JOIN cadena CA ON (CA.cadena_id = R.cadena_id)
					WHERE
						R.cadena_id = $cadena_id
					ORDER BY 
						R.regi_fecha DESC";
			return DB::getAll( $sql );
		}


	    
		
		public function getCarlitaRegistros(){
			$sql = "SELECT table_name, table_rows FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'lapromo1_web' AND table_name LIKE 'codigo%' ";
			return 	DB::getAll( $sql );
		}


		public function registrosXDistrito(){
			$sql = "SELECT 
				COUNT(C.comu_distrito) cantidad,
				C.comu_distrito 
				FROM registro R 
				INNER JOIN comuna C ON (C.comuna_id = R.comuna_id)
				GROUP BY 
					C.comu_distrito";
			return 	DB::getAll( $sql );
		}


		public function usuariosUnicos(){
			$sql = "SELECT COUNT(*) as cantidad, regi_fecha FROM registro R GROUP BY regi_fecha";
			return 	DB::getAll( $sql );
		}

		public function usuariosUnicosByFecha($regi_fecha){
			$sql = "SELECT DISTINCT(regi_rut) FROM `registro` WHERE regi_fecha = '$regi_fecha'";
			$elements = DB::getAll( $sql );
			return count($elements);
		}
		

		public function usuariosCarlita(){
			$sql = "SELECT DISTINCT(regi_rut) FROM registro";
			$elements = DB::getAll($sql);
			return count($elements);
		}


		public function registrosXDistritoRut($comu_distrito){
			$sql = "SELECT DISTINCT(R.regi_rut) 
					FROM registro R
					INNER JOIN comuna C ON (C.comuna_id = R.comuna_id)
					WHERE C.comu_distrito LIKE '$comu_distrito'";
			$elements = DB::getAll( $sql );
			return count($elements);
		}


		public function getComercialAll(){
			$sql = "SELECT come_nombre, come_codigo FROM comercial";
			return 	DB::getAll( $sql );
		}

		public function usuariosRangoEdad(){
			$sql = "SELECT '1 a 4' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '85 a 70' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 0 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 4999999)
					UNION
					SELECT '5 a 7' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '70 a 60' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 5000000 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 7999999)
					UNION
					SELECT '8 a 10' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '60 a 50' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 8000000 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 10999999)
					UNION
					SELECT '11 a 13' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '50 a 40' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 11000000 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 13999999)
					UNION
					SELECT '14 a 16' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '40 a 30' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 14000000 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 16999999)
					UNION
					SELECT '17 a 19' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '30 a 20' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 17000000 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 19999999)
					UNION
					SELECT '20 a 22' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '20 a 10' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 20000000 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 22999999)
					UNION
					SELECT '23 a 26' as 'rut', COUNT(substring(regi_rut, 1, length(regi_rut) - 2)) as 'total', COUNT(DISTINCT(substring(regi_rut, 1, length(regi_rut) - 2))) as 'unicos', '10 a 1' as 'rango' FROM  registro WHERE (substring(regi_rut, 1, length(regi_rut) - 2) > 23000000 AND substring(regi_rut, 1, length(regi_rut) - 2)  < 26999999)";
			return DB::getAll($sql);
		}

        */
	}
?>