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
	
	$resumen['resu_inicio'] = date('Y-m-d H:i:s');
	
	$objRegistro 	= new registro();
	$objResumen 	= new resumen();
	$table 			= "cpch";

	$date = date('Ymd');
	$file_csv 	= 'CPCH.csv';

	
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

				$post['CUMPLIMIENTO_MISTRAL_ICE_3R'] 	= $data['CUMPLIMIENTO_MISTRAL_ICE_3R'] ?? "";
				$post['CUMPLIMIENTO_MISTRAL_ICE_LOW'] 	= $data['CUMPLIMIENTO_MISTRAL_ICE_NOW'] ?? "";
				$post['FALTANTES_MISTRAL_ICE_3R'] 		= $data['FALTANTES_MISTRAL_ICE_3R'] ?? "";
				$post['FALTANTES_MISTRAL_ICE_LOW'] 		= $data['FALTANTES_MISTRAL_ICE_NOW'] ?? "";
				
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