<?php
    error_reporting(0); 
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', '');
    }
    include_once(INCLUDE_PATH.'class/inc.globals.php');
    include_once(INCLUDE_PATH.'class/class.inputfilter.php');
    include_once(INCLUDE_PATH.'class/class.registro.php');
    include_once(INCLUDE_PATH.'class/PHPExcel.php');
  
  

    //ini_set('memory_limit','128M');

    
    $registro       = new registro();
    $elements       = $registro->getRegistroFilterQuincena($get['fecha_desde'], $get['fecha_hasta']);
    

    $objPHPExcel = new PHPExcel();


    $objPHPExcel->
    getProperties()
        ->setCreator("TEDnologia.com")
        ->setLastModifiedBy("TEDnologia.com")
        ->setTitle("Exportar Excel con PHP")
        ->setSubject("Documento de prueba")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("usuarios phpexcel")
        ->setCategory("reportes");


$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Código');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Nombre');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Apellido');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'RUT');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Email');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Teléfono');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Comuna');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Región');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Distrito');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Mayor');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Bases');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Fecha');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Hora');



$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);




$i = 2;
if($elements){
    foreach($elements as $registro){
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $registro->registro_id);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $registro->codi_nombre);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, (string) html_entity_decode(trim($registro->regi_nombre)));
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, (string) html_entity_decode(trim($registro->regi_apellido)));
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, (string) $registro->regi_rut);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, (string) $registro->regi_email);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, (string) $registro->regi_telefono);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, (string) $registro->comu_nombre);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, (string) $registro->comu_region);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, (string) $registro->comu_distrito);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, (string) $registro->regi_mayor);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, (string) $registro->regi_bases);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, (string) $registro->regi_fecha);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, (string) $registro->regi_hora);



        $i++;
    }

}




$objPHPExcel->getActiveSheet()->setTitle('Participantes');
$objPHPExcel->setActiveSheetIndex(0);


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.date('Ymd-His').'-participantes-septiembre.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>