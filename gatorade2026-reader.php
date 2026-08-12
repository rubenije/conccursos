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
	$table 			= "gatorade2026";

	$date = date('Ymd');
	$file_csv 	= 'GATORADE2026.csv';
	
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

				$post['CUMPLIMIENTO_HORIZONTAL'] 			= $data['CUMPLIMIENTO_HORIZONTAL'] ?? "";
				$post['CUMPLIMIENTO_ACELERADOR_750_1LT'] 	= $data['CUMPLIMIENTO_ACELERADOR_750_1LT'] ?? "";
				$post['CUMPLIMIENTO_VOL_GATORADE'] 			= $data['CUMPLIMIENTO_VOL_GATORADE'] ?? "";
				$post['CUMPLIMIENTO_VOL_ACELERADOR'] 		= $data['CUMPLIMIENTO_VOL_ACELERADOR'] ?? "";
				$post['FALTANTE_HORIZONTAL'] 				= $data['FALTANTE_HORIZONTAL'] ?? "";
				$post['FALTANTE_ACELERADOR'] 				= $data['FALTANTE_ACELERADOR'] ?? "";
				
				
				
				
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