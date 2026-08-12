<?php
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}
include_once(INCLUDE_PATH.'class/inc.globals.php');
include_once(INCLUDE_PATH.'class/class.inputfilter.php');
include_once(INCLUDE_PATH.'class/class.informe.php');

// Obtén tus datos
session_start();
$objInforme = new informe();
$grupo = $get['grupo'] ?? '';

$campanas = $objInforme->getCampanasInactivas();

$campanaActual = null;

foreach ($campanas as $c) {
    if ($c['grupo'] == $grupo) {
        $campanaActual = $c;
        break;
    }
}
$campanasByGrupo = [];

foreach ($campanas as $c) {
    $campanasByGrupo[$c['grupo']] = $c;
}

$elements   = $objInforme->getIngresosConsolidadoInactivas($grupo); // ajusta si usas $get
$filename = date('Ymd') . '-consolidado-ingresos.xls';

// Headers para que el navegador lo abra como Excel
/*
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Pragma: no-cache');
header('Expires: 0');
*/
// BOM UTF-8 para que Excel no rompa los acentos
echo "\xEF\xBB\xBF";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Vendedores</title>
<style>
  table { border-collapse: collapse; }
  th, td { border: 1px solid #000; padding: 4px 6px; font-family: Arial, sans-serif; font-size: 12px; }
  th { background: #f0f0f0; }
  /* Estilos que Excel entiende (mso-*) para formato de celdas */
  .text  { mso-number-format:"\@"; }              /* Forzar texto (RUT, teléfono, códigos) */
  .date  { mso-number-format:"yyyy-mm-dd"; }      /* Fecha ISO */
  .time  { mso-number-format:"hh:mm:ss"; }        /* Hora */
  .wrap  { white-space: normal; }
</style>
</head>
<body>
<table>
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Tipo</th>
    <th>Canal</th>
    <th>Grupo</th>
    <th>Primera Visita</th>
    <th>Ultima Visita</th>
    <th>Total Visitas</th>
    <?php if (!empty($campanaActual['columnas'])): ?>
      <?php foreach ($campanaActual['columnas'] as $columna): ?>
          <th><?= htmlspecialchars($columna, ENT_QUOTES, 'UTF-8') ?></th>
      <?php endforeach; ?>
    <?php endif; ?>
    
  </tr>
  <?php if (!empty($elements)): ?>
    <?php foreach ($elements as $r): 
      $inicio = $campana['fecha_inicio'] ?? null;
      $termino = $campana['fecha_fin'] ?? null;
      $estado = $campana['estado'] ?? 'Sin definir';

      $diasOnline = 0;
      $diasRestantes = 0;

      if($inicio){

          $diasOnline = floor(
              (time() - strtotime($inicio)) / 86400
          );
      }
      
      // Asegurar strings limpios y seguros para HTML
      $id          = htmlspecialchars((string)($r->id ?? ''), ENT_QUOTES, 'UTF-8');
      $nombre      = htmlspecialchars((string)html_entity_decode(trim($r->nombre ?? ''), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
      $tipo        = htmlspecialchars((string)($r->tipo ?? ''), ENT_QUOTES, 'UTF-8');
      $canal       = htmlspecialchars((string)($r->canal ?? ''), ENT_QUOTES, 'UTF-8');
      $grupo       = htmlspecialchars((string)($r->grupo ?? $grupo), ENT_QUOTES, 'UTF-8');
      $primera     = htmlspecialchars((string)($r->primera_visita ?? ''), ENT_QUOTES, 'UTF-8');
      $ultima      = htmlspecialchars((string)($r->ultima_visita ?? ''), ENT_QUOTES, 'UTF-8');
      $ingresos    = htmlspecialchars((string)($r->ingresos ?? ''), ENT_QUOTES, 'UTF-8');
      $total       = htmlspecialchars((string)($r->total_visitas ?? '0'), ENT_QUOTES, 'UTF-8');
      // Normalizar fecha/hora
      $fechaRaw    = (string)($r->ingr_fecha ?? '');
      $horaRaw     = (string)($r->ingr_hora ?? '');
      // Dejar fecha como yyyy-mm-dd si viene con tiempo
      $fecha       = htmlspecialchars(substr($fechaRaw, 0, 10), ENT_QUOTES, 'UTF-8');
      // Dejar hora hh:mm:ss (rellena si viene corta)
      $hora        = htmlspecialchars(substr(str_pad($horaRaw, 8, '0', STR_PAD_RIGHT), 0, 8), ENT_QUOTES, 'UTF-8');
    ?>
    <tr>
        <td class="text"><?= $id ?></td>
        <td class="wrap"><?= $nombre ?></td>
        <td class="text"><?= $tipo ?></td>
        <td class="wrap"><?= $canal ?></td>
        <td class="wrap"><?= $grupo ?></td>
        <td class="date"><?= sql2date($primera) ?></td>
        <td class="time"><?= sql2date($ultima) ?></td>
        <td class="wrap"><?= $total ?></td>
        <?php if (!empty($campanaActual['columnas'])): ?>
          <?php foreach ($campanaActual['columnas'] as $columna): ?>
              <td class="wrap">
                  <?= htmlspecialchars((string)($r->$columna ?? ''), ENT_QUOTES, 'UTF-8') ?>
              </td>
          <?php endforeach; ?>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</table>
</body>
</html>