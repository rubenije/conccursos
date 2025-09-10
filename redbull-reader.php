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

	include_once(INCLUDE_PATH . 'class/class.resumen.php');
	

	$resumen['resu_inicio'] = date('Y-m-d H:i:s');
	
	$objRegistro 	= new registro();
	$objResumen 	= new resumen();
	$table 			= "redbull";

	$date = date('Ymd');
	//$file_csv 	= 'RETORNABLE_'.$date.'.csv';
	$file_csv 	= 'RED_BULL.csv';

	
	if(file_exists($file_csv)){
		$csv 		= new CsvImporter($file_csv,';', true);
		$datas 		= $csv->get();
		$count = 0;

		if(is_array($datas) && !empty($datas)){
			
			$objRegistro->deleteRegistroByTable($table);


			foreach ($datas as $data) { 
				$post['tipo'] 					= $data['TIPO'] ?? "";
				$post['id'] 					= $data['ID'] ?? "";
				$post['nombre'] 				= $data['NOMBRE'] ?? "";
				$post['canal'] 					= $data['CANAL'] ?? "";

				$post['cumplimiento_250'] 		= $data['CUMPLIMIENTO_250'] ?? "";
				$post['cuantos_faltan_250'] 	= $data['CUANTOS_FALTAN_250'] ?? "";
				$post['cumplimiento_3_skus'] 	= $data['CUMPLIMIENTO_3_SKUS'] ?? "";
				$post['cuantos_faltan_3_skus'] 	= $data['CUANTOS_FALTAN_3_SKUS'] ?? "";
				$post['cumplimiento_total'] 	= $data['CUMPLIMIENTO_TOTAL'] ?? "";
				
				
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
	
?>