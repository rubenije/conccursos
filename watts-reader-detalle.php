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
	$table 			= "watts";

	$date = date('Ymd');
	$file_csv 	= 'WATTS_DETALLE.csv';
	
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

				$post['CONCRETADO_NARANJA'] 		= $data['CONCRETADO_NARANJA'] ?? "";
				$post['CONCRETADO_PINA'] 			= $data['CONCRETADO_PINA'] ?? "";
				$post['CONCRETADO_DURAZNO'] 		= $data['CONCRETADO_DURAZNO'] ?? "";
				$post['CONCRETADO_TUTIFRUTILLA'] 	= $data['CONCRETADO_TUTIFRUTILLA'] ?? "";
				$post['CONCRETADO_LIGHT'] 			= $data['CONCRETADO_LIGHT'] ?? "";

				$post['VOL_VS_AA_NARANJA'] 			= $data['VOL_VS_AA_NARANJA'] ?? "";
				$post['VOL_VS_AA_PINA'] 			= $data['VOL_VS_AA_PINA'] ?? "";
				$post['VOL_VS_AA_DURAZNO'] 			= $data['VOL_VS_AA_DURAZNO'] ?? "";
				$post['VOL_VS_AA_TUTIFRUTILLA'] 	= $data['VOL_VS_AA_TUTIFRUTILLA'] ?? "";
				$post['VOL_VS_AA_LIGHT'] 			= $data['VOL_VS_AA_LIGHT'] ?? "";
				
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