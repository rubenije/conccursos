<?php

	date_default_timezone_set("Chile/Continental");
	$time = date('His');

	//error_reporting(0);

	if (!defined('INCLUDE_PATH')) {
	  define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
	}

	include_once(INCLUDE_PATH . 'class/class.inputfilter.php');
	include_once(INCLUDE_PATH . 'class/inc.globals.php');
	include_once(INCLUDE_PATH . 'class/class.csv.php');
	include_once(INCLUDE_PATH . 'class/class.detalle.php');
	include_once(INCLUDE_PATH . 'class/class.resumen.php');
	

	$resumen['resu_inicio'] = date('Y-m-d H:i:s');
	
	$objDetalle 	= new detalle();
	$objResumen 	= new resumen();
	$table 			= "cervezas";

	$date = date('Ymd');
	$file_csv 	= 'CERVEZAS_DETALLE.csv';

	
	if(file_exists($file_csv)){
		$csv 		= new CsvImporter($file_csv,';', true);
		$datas 		= $csv->get();

		$count = 0;

		if(is_array($datas) && !empty($datas)){
			$objDetalle->truncateDetalleByTable($table);
			//sleep(1000);
			foreach ($datas as $data) { 

				$post['vendedor_id'] 			= $data['ID_VENDEDOR'] ?? "";
				$post['id'] 					= $data['ID_CLIENTE'] ?? "";
				$post['sector'] 				= $data['SECTOR'] ?? "";
				$post['razon'] 					= $data['RAZON_SOCIAL'] ?? "";
				
				$post['GRUPO'] 								= $data['GRUPO'] ?? "";
				$post['VOLUMEN_AL_DIA_CRI_ESC'] 			= $data['VOLUMEN_AL_DIA_CRI_ESC'] ?? "";
				$post['VOLUMEN_AL_DIA_AGOSTO_2025'] 		= $data['VOLUMEN_AL_DIA_AGOSTO_2025'] ?? "";
				$post['VOLUMEN_MES_COMPLETO_AGOSTO_2025'] 	= $data['VOLUMEN_MES_COMPLETO_AGOSTO_2025'] ?? "";
				
				
				
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