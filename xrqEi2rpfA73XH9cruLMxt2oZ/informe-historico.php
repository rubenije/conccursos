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
    <style>

        body{
            background:#f4f6f9;
        }

        .card-dashboard{
            border:none;
            border-radius:14px;
            box-shadow:0 2px 10px rgba(0,0,0,0.06);
        }

        .title-small{
            font-size:13px;
            color:#6c757d;
            margin-bottom:6px;
        }

        .kpi-number{
            font-size:34px;
            font-weight:700;
        }

        .navbar-custom{
            background:#fff;
            box-shadow:0 2px 10px rgba(0,0,0,0.04);
        }

        .table-dashboard thead{
            background:#f1f3f5;
        }

        .badge-status{
            font-size:11px;
            padding:6px 10px;
        }

    </style>
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
                    <a class="nav-link" href="informe-detalle.php?grupo=<?= $campana['grupo']; ?>"><?= strtoupper($campana['grupo']); ?></a>
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
          <div class="row g-4">

          <?php if (!empty($inactivas)): ?>

              <?php foreach($inactivas as $element):

                  $grupo = $element['grupo'];

                  $nombre = $campanasByGrupo[$grupo] ?? strtoupper($grupo);

                  $inicio = !empty($element['fecha_inicio'])
                      ? sql2date($element['fecha_inicio'])
                      : '-';

                  $termino = !empty($element['fecha_fin'])
                      ? sql2date($element['fecha_fin'])
                      : '-';

                  $dias = 0;

                  if(!empty($element['fecha_inicio']) && !empty($element['fecha_fin'])){

                      $dias = floor(
                          (
                              strtotime($element['fecha_fin']) -
                              strtotime($element['fecha_inicio'])
                          ) / 86400
                      );
                  }

              ?>

              <div class="col-12 col-md-6 col-lg-4">

                  <div class="card shadow-sm border-0 h-100">

                      <div class="card-body">

                          <div class="d-flex justify-content-between align-items-start mb-3">

                              <div>

                                  <div class="text-muted small">
                                      Concurso histórico
                                  </div>

                                  <h5 class="mb-0">
                                      <?= htmlspecialchars($nombre, ENT_QUOTES,'UTF-8') ?>
                                  </h5>

                              </div>

                              <span class="badge bg-secondary">
                                  FINALIZADO
                              </span>

                          </div>

                          <hr>

                          <div class="row text-center mb-3">

                              <div class="col-6">

                                  <div class="small text-muted">
                                      Inicio
                                  </div>

                                  <div class="fw-bold">
                                      <?= $inicio ?>
                                  </div>

                              </div>

                              <div class="col-6">

                                  <div class="small text-muted">
                                      Término
                                  </div>

                                  <div class="fw-bold">
                                      <?= $termino ?>
                                  </div>

                              </div>

                          </div>

                          <div class="text-center mb-4">

                              <div class="small text-muted">
                                  Duración campaña
                              </div>

                              <div class="fs-3 fw-bold text-primary">

                                  <?= $dias ?>

                              </div>

                              <div class="small text-muted">
                                  días
                              </div>

                          </div>

                          <a
                              href="informe-detalle-historico.php?grupo=<?= urlencode($grupo) ?>"
                              class="btn btn-outline-primary w-100"
                          >
                              Ver detalle
                          </a>

                      </div>

                  </div>

              </div>

              <?php endforeach; ?>

          <?php else: ?>

          <div class="col-12">

              <div class="alert alert-secondary text-center">

                  Sin campañas históricas

              </div>

          </div>

          <?php endif; ?>

          </div>
         
        </div>
      </div>

      

      
  
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    

  </body>
</html>