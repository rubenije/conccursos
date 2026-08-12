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

	$date = date('Ymd');
	$file_csv 	= 'RETORNABLE_'.$date.'.csv';
	//$file_csv 	= 'RETORNABLE.csv';

	
	if(file_exists($file_csv)){
		$csv 		= new CsvImporter($file_csv,';', true);
		$datas 		= $csv->get();
		$count = 0;

		if(is_array($datas) && !empty($datas)){
			$objRegistro->deleteRegistro();
			
			foreach ($datas as $data) { 

				//pre($data);
				//exit;
				$post['tipo'] 					= $data['TIPO'] ?? "";
				$post['id'] 					= $data['ID'] ?? "";
				$post['nombre'] 				= $data['NOMBRE'] ?? "";
				$post['canal'] 					= $data['CANAL'] ?? "";

				$post['cumplimiento'] 			= $data['CUMPLMIENTO_META_RET'] ?? "";
				$post['meta_ret'] 				= $data['META_RET'] ?? "";
				$post['vs_aa_ret'] 				= $data['VS_AA_RET'] ?? "";
				$post['proyectado'] 			= $data['PROYECTADO_CIERRE_RET'] ?? "";
				
				if( !empty($post['id']) ){
					$objRegistro->saveRegistro($post);
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