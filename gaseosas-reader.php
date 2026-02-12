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
	$table 			= "gaseosas";

	$date = date('Ymd');
	//$file_csv 	= 'RETORNABLE_'.$date.'.csv';
	$file_csv 	= 'GASEOSAS.csv';
	
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

				$post['CUMPLIMIENTO_PEPSI_MAS_2_SABORES'] 	= $data['CUMPLIMIENTO_PEPSI_MAS_2_SABORES'] ?? "";
				$post['CUMPLIMIENTO_PEPSI_MAS_3_SABORES'] 	= $data['CUMPLIMIENTO_PEPSI_MAS_3_SABORES'] ?? "";
				$post['CUMPLIMIENTO_TOTAL'] 				= $data['CUMPLIMIENTO_TOTAL'] ?? "";
				
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