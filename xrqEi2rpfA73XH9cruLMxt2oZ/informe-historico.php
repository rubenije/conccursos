<?php 
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}
require_once(INCLUDE_PATH.'class/class.inputfilter.php');
require_once(INCLUDE_PATH.'class/inc.globals.php');
require_once(INCLUDE_PATH.'class/class.informe.php');
require_once(INCLUDE_PATH.'class/class.concurso.php');

session_start();

$opc  = $post['opc']  ?? null;
if($opc == 'setFechas'){
  $desde = trim($post['desde'] ?? '');
  $hasta = trim($post['hasta'] ?? '');
  if(!empty($post['desde']) && !empty($post['hasta'])){
    $_SESSION['FECHA_DESDE'] = trim($post['desde'] ?? '');
    $_SESSION['FECHA_HASTA'] = trim($post['hasta'] ?? '');
  } else {
    unset($_SESSION['FECHA_DESDE']);
    unset($_SESSION['FECHA_HASTA']);
  }
}
$titleFecha = '';
if(!empty($_SESSION['FECHA_DESDE']) && !empty($_SESSION['FECHA_HASTA'])){
    $titleFecha = "Desde:".sql2date($_SESSION['FECHA_DESDE'])." Hasta:".sql2date($_SESSION['FECHA_HASTA']);
}

$objInforme = new informe();
$campanas = $objInforme->getCampanas();
$inactivas = $objInforme->getCampanasInactivas();
$concursos = $objInforme->getConsolidadoPorConcurso();


// 1) mapa para búsqueda O(1)
$campanasByGrupo = [];
foreach ($campanas as $c) {
  $campanasByGrupo[$c['grupo']] = $c['nombre'];
}

// 2) inicializar arrays para charts
$lConcursos = $iConcursos = $uConcursos = [];
$lDiarios   = $iDiarios   = $uDiarios   = [];

// 3) Totales útiles (KPI)
$totalIngresos = 0;
$totalUnicos   = 0;
foreach ($concursos as $row) {
  $totalIngresos += (int)$row->ingresos;
  $totalUnicos   += (int)$row->unicos;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Informe ONLINE</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-md-10 m-auto">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="informe.php">ConCCUrsos</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-md-center" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link active" href="informe.php">INICIO</a>
                  </li>
                  <?php foreach($campanas as $campana){ ?>
                    <li class="nav-item">
                    <a class="nav-link active" href="informe-detalle.php?grupo=<?= $campana['grupo']; ?>"><?= strtoupper($campana['grupo']); ?></a>
                  </li>
                  <?php } ?>
                  <li class="nav-item">
                    <a class="nav-link active" href="informe-historico.php">HISTORICO</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>

    <div class="container-fluid pt-5">

      

      
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
          <h4 class="mb-0">Ingresos x Concurso</h4>
          <?php if($titleFecha){ ?>
          <span class="badge bg-secondary"><?= $titleFecha; ?></span>
          <?php } ?>
          <table class="table table-striped table-sm" style="font-size:12px;">
            <thead>
              <tr>
                <th>Nombre</th>
                <th class="text-center" style="width:15%;">Inicio</th>
                <th class="text-center" style="width:15%;">Término</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($inactivas)): ?>
                <?php foreach($inactivas as $element):
                  $grupo  = $element['grupo'];
                  $nombre = $campanasByGrupo[$grupo] ?? strtoupper($grupo);
                ?>
                <tr>
                  <td><a href="informe-detalle.php?grupo=<?= $element['grupo']; ?>"><?= $element['nombre']; ?></a></td>
                  <td class="text-center"><?= $element['fecha_inicio']; ?></td>
                  <td class="text-center"><?= $element['fecha_fin']; ?></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="3" class="text-center text-muted">Sin datos</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
         
        </div>
      </div>

      

      
  
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    

  </body>
</html>