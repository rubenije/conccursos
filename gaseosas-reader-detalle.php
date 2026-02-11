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
	$table 			= "gaseosas";

	$date = date('Ymd');
	//$file_csv 	= 'MINIONS_ENERGIA_DETALLE_'.$date.'.csv';
	$file_csv 	= 'GASEOSAS_DETALLE.csv';
	
	if(file_exists($file_csv)){
		$csv 		= new CsvImporter($file_csv,';', true);
		$datas 		= $csv->get();

		$count = 0;

		if(is_array($datas) && !empty($datas)){
			$objDetalle->truncateDetalleByTable($table);
			//sleep(1000);
			foreach ($datas as $data) { 

				pre($data);
				exit;
				

				$post['vendedor_id'] 			= $data['ID_VENDEDOR'] ?? "";
				$post['id'] 					= $data['ID_CLIENTE'] ?? "";
				$post['sector'] 				= $data['SECTOR'] ?? "";
				$post['razon'] 					= $data['RAZON_SOCIAL'] ?? "";

				$post['GRUPO_CLIENTE'] 			= $data['GRUPO_CLIENTE'] ?? "";
				$post['CONCRETADO_PEPSI'] 		= $data['CONCRETADO_PEPSI'] ?? "";
				$post['CONCRETADO_BILZ'] 		= $data['CONCRETADO_BILZ'] ?? "";
				$post['CONCRETADO_PAP'] 		= $data['CONCRETADO_PAP'] ?? "";
				$post['CONCRETADO_LIMON'] 		= $data['CONCRETADO_LIMON'] ?? "";
				$post['CONCRETADO_KEM'] 		= $data['CONCRETADO_KEM'] ?? "";
				$post['CONCRETADO_CRUSH'] 		= $data['CONCRETADO_CRUSH'] ?? "";
				$post['CONCRETADO_7UP'] 		= $data['CONCRETADO_7UP'] ?? "";
				$post['CONCRETADO_CDGA'] 		= $data['CONCRETADO_CDGA'] ?? "";
				
				
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