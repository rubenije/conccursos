<?php

	date_default_timezone_set("Chile/Continental");
	$time = date('His');

	error_reporting(0);

	if (!defined('INCLUDE_PATH')) {
	  define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
	}

	include_once(INCLUDE_PATH . 'class/class.inputfilter.php');
	include_once(INCLUDE_PATH . 'class/inc.globals.php');
	include_once(INCLUDE_PATH . 'class/class.csv.php');
	include_once(INCLUDE_PATH . 'class/class.registro.php');
	include_once(INCLUDE_PATH . 'class/class.detalle.php');
	include_once(INCLUDE_PATH . 'class/class.resumen.php');
	

	/**	Carga del archivo registro */
	
	$resumen['resu_inicio'] = date('Y-m-d H:i:s');
	
	$objRegistro 	= new registro();
	$objResumen 	= new resumen();
	$table 			= "tirate";

	$date = date('Ymd');
	$file_csv 	= 'TIRATE_AL_AGUA.csv';

	
	if(file_exists($file_csv)){
		$csv 		= new CsvImporter($file_csv,';', true);
		$datas 		= $csv->get();
		$count = 0;

		if(is_array($datas) && !empty($datas)){
			
			$objRegistro->deleteRegistroByTable($table);


			foreach ($datas as $data) { 
				$post['tipo'] 						= $data['TIPO'] ?? "";
				$post['id'] 						= $data['ID'] ?? "";
				$post['nombre'] 					= $data['NOMBRE'] ?? "";
				$post['canal'] 						= $data['CANAL'] ?? "";

				$post['CUMPLIMIENTO_DUO'] 			= $data['CUMPLIMIENTO_DUO'] ?? "";
				$post['CUANTOS_FALTAN_DUO'] 		= $data['CUANTOS_FALTAN_DUO'] ?? "";
				$post['CUMPLIMIENTO_MANANTIAL'] 	= $data['CUMPLIMIENTO_MANANTIAL'] ?? "";
				$post['CUANTOS_FALTAN_MANANTIAL'] 	= $data['CUANTOS_FALTAN_MANANTIAL'] ?? "";
				$post['CUMPLIMIENTO_TOTAL'] 		= $data['CUMPLIMIENTO_TOTAL'] ?? "";


				if( !empty($post['id']) ){
					$objRegistro->saveRegistroByTable($table, $post);
					$count++;
				}
			}	
		}
		$resumen['resu_registros'] 	= $count;
		$resumen['resu_termino'] 	= date('Y-m-d H:i:s');
		$resumen['resu_archivo'] 	= $file_csv;
		$objResumen->saveResumen($resumen);
		
	}else{
		echo "No existe archivo: ".$file_csv;
	}


	/**	Carga del archivo detalle */

	$resumen['resu_inicio'] = date('Y-m-d H:i:s');
	
	$objDetalle 	= new detalle();
	$objResumen 	= new resumen();
	$table 			= "tirate";

	$date = date('Ymd');
	$file_csv 	= 'TIRATE_AL_AGUA_DETALLE.csv';

	
	if(file_exists($file_csv)){
		$csv 		= new CsvImporter($file_csv,';', true);
		$datas 		= $csv->get();

		$count = 0;

		if(is_array($datas) && !empty($datas)){
			$objDetalle->truncateDetalleByTable($table);
			foreach ($datas as $data) { 

				$post['vendedor_id'] 			= $data['ID_VENDEDOR'] ?? "";
				$post['id'] 					= $data['ID_CLIENTE'] ?? "";
				$post['sector'] 				= $data['SECTOR'] ?? "";
				$post['razon'] 					= $data['RAZON_SOCIAL'] ?? "";

				$post['COB_CATUN_16'] 			= $data['COB_CATUN_16'] ?? "";
				$post['COB_CATUN_25'] 		    = $data['COB_CATUN_25'] ?? "";
				$post['COB_MANANTIAL_30'] 		= $data['COB_MANANTIAL_30'] ?? "";
				$post['COB_MANANTIAL_15'] 		= $data['COB_MANANTIAL_15'] ?? "";
				
				
				if( !empty($post['id']) ){
					$objDetalle->saveDetalleByTable($table, $post);
					$count++;
				}
            }	
		}
		$resumen['resu_registros'] 	= $count;
		$resumen['resu_termino'] 	= date('Y-m-d H:i:s');
		$resumen['resu_archivo'] 	= $file_csv;
		$objResumen->saveResumen($resumen);
		
	}else{
		echo "No existe archivo: ".$file_csv;
	}
	
?>