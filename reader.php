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
	$file_csv 	= 'MINIONS_ENERGIA_'.$date.'.csv';
	//$file_csv 	= 'MINIONS_ENERGIA.csv';

	
	if(file_exists($file_csv)){
		$csv 		= new CsvImporter($file_csv,';', true);
		$datas 		= $csv->get();
		$count = 0;

		
		if(is_array($datas) && !empty($datas)){
			$objRegistro->deleteRegistro();
			
			foreach ($datas as $data) { 
				$post['tipo'] 					= $data['TIPO'] ?? "";
				$post['id'] 					= $data['ID'] ?? "";
				$post['nombre'] 				= $data['NOMBRE'] ?? "";
				$post['canal'] 					= $data['CANAL'] ?? "";

				$post['m_cob_conjunta'] 		= $data['M_COB_CONJUNTA'] ?? "";
				$post['m_cob_concretar'] 		= $data['M_COB_CONCRETAR'] ?? "";
				$post['m_cob_nectar'] 			= $data['M_COB_NECTAR'] ?? "";
				$post['m_cob_nectar_concretar'] = $data['M_COB_NECTAR_CONCRETAR'] ?? "";
				$post['m_cupones'] 				= $data['M_CUPONES'] ?? "";

				$post['e_cob_conjunta'] 		= $data['E_COB_CONJUNTA'] ?? "";
				$post['e_cob_concretar'] 		= $data['E_COB_CONCRETAR'] ?? "";
				$post['e_cob_redbull'] 			= $data['E_COB_REDBULL'] ?? "";
				$post['e_cob_rebull_concretar'] = $data['E_COB_REDBULL_CONCRETAR'] ?? "";
				$post['e_cupones'] 				= $data['E_CUPONES'] ?? "";
		
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