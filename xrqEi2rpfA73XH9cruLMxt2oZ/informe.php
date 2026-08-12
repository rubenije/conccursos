<?php 
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}
require_once(INCLUDE_PATH.'class/class.inputfilter.php');
require_once(INCLUDE_PATH.'class/inc.globals.php');
require_once(INCLUDE_PATH.'class/class.informe.php');

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
$concursos = $objInforme->getConsolidadoPorConcurso();
$zonas = $objInforme->getConsolidadoPorZona();
$distritos = $objInforme->getConsolidadoPorDistrito();
$dias = $objInforme->getConsolidadoPorDia();


// 1) mapa para búsqueda O(1)
$campanasByGrupo = [];
foreach ($campanas as $c) {
  $campanasByGrupo[$c['grupo']] = $c;
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

        <div class="col-12 col-md-10 m-auto">

            <!-- HEADER KPI -->

            <div class="row g-3 mb-4">

                <div class="col-md-3">

                    <div class="card card-dashboard h-100">

                        <div class="card-body">

                            <div class="title-small">
                                Total ingresos
                            </div>

                            <div class="kpi-number">

                                <?= numberFormat($totalIngresos) ?>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card card-dashboard h-100">

                        <div class="card-body">

                            <div class="title-small">
                                Ingresos únicos
                            </div>

                            <div class="kpi-number">

                                <?= numberFormat($totalUnicos) ?>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="card card-dashboard">

                        <div class="card-body">

                            <form class="row g-2" method="post" action="informe.php">

                                <input type="hidden" name="opc" value="setFechas">

                                <div class="col-md-4">

                                    <label class="form-label">
                                        Desde
                                    </label>

                                    <input 
                                        type="date"
                                        class="form-control"
                                        name="desde"
                                        value="<?= htmlspecialchars($_SESSION['FECHA_DESDE'] ?? '', ENT_QUOTES,'UTF-8') ?>"
                                    >

                                </div>

                                <div class="col-md-4">

                                    <label class="form-label">
                                        Hasta
                                    </label>

                                    <input 
                                        type="date"
                                        class="form-control"
                                        name="hasta"
                                        value="<?= htmlspecialchars($_SESSION['FECHA_HASTA'] ?? '', ENT_QUOTES,'UTF-8') ?>"
                                    >

                                </div>

                                <div class="col-md-4 d-flex align-items-end gap-2">

                                    <button class="btn btn-primary w-50">
                                        Filtrar
                                    </button>

                                    <button 
                                        type="button"
                                        class="btn btn-outline-secondary w-50"
                                        onclick="this.form.desde.value=''; this.form.hasta.value=''; this.form.submit();"
                                    >
                                        Limpiar
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <!-- CONCURSOS -->

            <div class="row g-3 mb-4">

                <?php foreach($concursos as $element):
                    $campana = $campanasByGrupo[$element->grupo];
                    $grupo = strtolower($element->grupo);

                    $usabilidad = $objInforme->getUsabilidadPlataforma($element->grupo);

                    $totalUsabilidad = (int)$usabilidad->total;

                    $porcentajeSobre40 = $totalUsabilidad > 0
                        ? round(($usabilidad->sobre_40 / $totalUsabilidad) * 100)
                        : 0;

                    $porcentajeEntre20y39 = $totalUsabilidad > 0
                        ? round(($usabilidad->entre_20_39 / $totalUsabilidad) * 100)
                        : 0;

                    $porcentajeMenos20 = $totalUsabilidad > 0
                        ? round(($usabilidad->menos_20 / $totalUsabilidad) * 100)
                        : 0;
                        

                    $nombre = $campana['nombre'] ?? strtoupper($element->grupo);

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

                    if($termino){

                        $diasRestantes = floor(
                            (strtotime($termino) - time()) / 86400
                        );
                    }
                ?>

                <div class="col-md-4">

                    <div class="card card-dashboard h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start mb-3">

                                <div>

                                    <div class="title-small">
                                        Concurso
                                    </div>

                                    <h4 class="mb-0">
                                        <?= htmlspecialchars($nombre, ENT_QUOTES,'UTF-8') ?>
                                    </h4>

                                </div>

                                <span class="badge bg-success badge-status">

                                    <?= $estado ?>

                                </span>

                            </div>

                            <div class="row">

                                <div class="col-6">

                                    <div class="title-small">
                                        Inicio
                                    </div>

                                    <strong>
                                        <?= sql2date($inicio) ?>
                                    </strong>

                                </div>

                                <div class="col-6">

                                    <div class="title-small">
                                        Término
                                    </div>

                                    <strong>
                                        <?= sql2date($termino) ?>
                                    </strong>

                                </div>

                            </div>

                            <hr>

                            <div class="row text-center">

                                <div class="col-6">

                                    <div class="title-small">
                                        Días online
                                    </div>

                                    <div class="fs-4 fw-bold text-success">

                                        <?= $diasOnline ?>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="title-small">
                                        Restantes
                                    </div>

                                    <div class="fs-4 fw-bold text-warning">

                                        <?= $diasRestantes ?>

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="row text-center">

                                <div class="col-6">

                                    <div class="title-small">
                                        Totales
                                    </div>

                                    <div class="fs-5 fw-bold">

                                        <?= numberFormat($element->ingresos) ?>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="title-small">
                                        Únicos
                                    </div>

                                    <div class="fs-5 fw-bold">

                                        <?= numberFormat($element->unicos) ?>

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="text-center mb-2">

                                <div class="title-small">
                                    % Usabilidad Plataforma
                                </div>

                            </div>

                            <div class="row text-center">

                                <div class="col-4">

                                    <div class="small text-muted">
                                        +40
                                    </div>

                                    <div class="fw-bold text-success">
                                        <?= $porcentajeSobre40 ?>%
                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="small text-muted">
                                        39-20
                                    </div>

                                    <div class="fw-bold text-warning">
                                        <?= $porcentajeEntre20y39 ?>%
                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="small text-muted">
                                        -20
                                    </div>

                                    <div class="fw-bold text-danger">
                                        <?= $porcentajeMenos20 ?>%
                                    </div>

                                </div>
                                <div class="col-12 mt-3">

                                    <a href="xls-consolidado.php?grupo=<?= $grupo; ?>" class="btn btn-success w-100">
                                        Exportar ingresos
                                    </a>
                                  </div>

                            </div>

                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

            </div>
            <!-- GRAFICO -->

            <div class="row">

                <div class="col-12">

                    <div class="card card-dashboard">

                        <div class="card-body">

                            <h4 class="mb-4">
                                Ingresos por concurso
                            </h4>

                            <canvas id="ingresosPorConcurso" height="100"></canvas>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


      

      
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
          <h4 class="mb-0">Ingresos x conccurso</h4>
          <?php if($titleFecha){ ?>
          <span class="badge bg-secondary"><?= $titleFecha; ?></span>
          <?php } ?>
          <table class="table table-striped table-sm" style="font-size:12px;">
            <thead>
              <tr>
                <th>Nombre</th>
                <th class="text-center" style="width:15%;">Totales</th>
                <th class="text-center" style="width:15%;">Únicos</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($concursos)): ?>
                <?php foreach($concursos as $element):
                  $campana = $campanasByGrupo[$element->grupo];
                  $grupo  = $element->grupo;
                  $nombre = $campana['nombre'] ?? strtoupper($grupo);
                  $lConcursos[] = $nombre;
                  $iConcursos[] = (int)$element->ingresos;
                  $uConcursos[] = (int)$element->unicos;
                ?>
                <tr>
                  <td><?= htmlspecialchars($nombre, ENT_QUOTES,'UTF-8') ?></td>
                  <td class="text-center"><?= numberFormat($element->ingresos) ?></td>
                  <td class="text-center"><?= numberFormat($element->unicos) ?></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="3" class="text-center text-muted">Sin datos</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
          <h4 class="mb-0">Ingresos x Zona</h4>
          <?php if($titleFecha){ ?>
          <span class="badge bg-secondary"><?= $titleFecha; ?></span>
          <?php } ?>
          <table class="table table-striped" style="font-size: 12px;">
            <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col" style="width:15%;" class="text-center">Totales</th>
                  <th scope="col" style="width:15%;" class="text-center">Únicos</th>
                </tr>
              </thead>
            <tbody>
              <?php foreach($zonas as $element){ ?> 
              <tr>
                <td><?= $element->zona_codigo; ?></td>
                <td class="text-center"><?= numberFormat($element->ingresos); ?></td>
                <td class="text-center"><?= numberFormat($element->unicos); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>



      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
          <h4 class="mb-0">Ingresos x Distrito</h4>
          <?php if($titleFecha){ ?>
          <span class="badge bg-secondary"><?= $titleFecha; ?></span>
          <?php } ?>
          <table class="table table-striped" style="font-size: 12px;">
            <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col" style="width:15%;" class="text-center">Totales</th>
                  <th scope="col" style="width:15%;" class="text-center">Únicos</th>
                </tr>
              </thead>
            <tbody>
              <?php foreach($distritos as $element){ ?> 
              <tr>
                <td><?= $element->dist_codigo; ?></td>
                <td class="text-center"><?= numberFormat($element->ingresos); ?></td>
                <td class="text-center"><?= numberFormat($element->unicos); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>


      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
          <h4 class="mb-0">Ingresos Diarios</h4>
          <?php if($titleFecha){ ?>
          <span class="badge bg-secondary"><?= $titleFecha; ?></span>
          <?php } ?>
          <table class="table table-striped table-sm" style="font-size:12px;">
            <thead>
              <tr>
                <th>Fecha</th>
                <th class="text-center" style="width:15%;">Totales</th>
                <th class="text-center" style="width:15%;">Únicos</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($dias)): ?>
                <?php foreach($dias as $element):
                  $fechaFmt = sql2date($element->ingr_fecha);
                  $lDiarios[] = $fechaFmt;
                  $iDiarios[] = (int)$element->ingresos;
                  $uDiarios[] = (int)$element->unicos;
                ?>
                <tr>
                  <td><?= htmlspecialchars($fechaFmt, ENT_QUOTES,'UTF-8') ?></td>
                  <td class="text-center"><?= numberFormat($element->ingresos) ?></td>
                  <td class="text-center"><?= numberFormat($element->unicos) ?></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="3" class="text-center text-muted">Sin datos</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
          <canvas id="ingresosDiarios" width="600" height="400"></canvas>

        </div>
      </div>



      
  
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.js"></script>
    <script>
      var chartColors = {
        red:'rgb(255,99,132)', orange:'rgb(255,159,64)', yellow:'rgb(255,205,86)',
        green:'rgb(75,192,192)', blue:'rgb(54,162,235)', purple:'rgb(153,102,255)', grey:'rgb(231,233,237)'
      };

      // Datos PHP -> JS (con flags para unicode y números)
      var lConcursos = <?= json_encode($lConcursos, JSON_UNESCAPED_UNICODE) ?>;
      var iConcursos = <?= json_encode($iConcursos, JSON_NUMERIC_CHECK) ?>;
      var uConcursos = <?= json_encode($uConcursos, JSON_NUMERIC_CHECK) ?>;

      var lDiarios = <?= json_encode($lDiarios, JSON_UNESCAPED_UNICODE) ?>;
      var iDiarios = <?= json_encode($iDiarios, JSON_NUMERIC_CHECK) ?>;
      var uDiarios = <?= json_encode($uDiarios, JSON_NUMERIC_CHECK) ?>;

      // Bar: Ingresos x Concurso
      var ctx1 = document.getElementById("ingresosPorConcurso").getContext("2d");
      new Chart(ctx1, {
        type: 'bar',
        data: {
          labels: lConcursos,
          datasets: [
            { label: "Únicos",   backgroundColor: chartColors.green, data: uConcursos },
            { label: "Totales", backgroundColor: chartColors.red,   data: iConcursos }
          ]
        },
        options: {
          responsive: true,
          scales: {
            xAxes: [{ stacked: false }],
            yAxes: [{
              stacked: false,
              ticks: { beginAtZero: true, precision: 0 }
            }]
          },
          tooltips: { mode: 'index', intersect: false }
        }
      });

      // Line: Ingresos Diarios
      var ctx2 = document.getElementById("ingresosDiarios").getContext("2d");
      new Chart(ctx2, {
        type: 'line',
        data: {
          labels: lDiarios,
          datasets: [
            { label: "Totales", backgroundColor: chartColors.orange, borderColor: chartColors.orange, data: iDiarios, fill: false },
            { label: "Únicos",   backgroundColor: chartColors.green,  borderColor: chartColors.green,  data: uDiarios, fill: false }
          ]
        },
        options: {
          responsive: true,
          scales: {
            xAxes: [{ display: true }],
            yAxes: [{ display: true, ticks: { beginAtZero: true, precision: 0 } }]
          },
          tooltips: { mode: 'index', intersect: false }
        }
      });
    </script>

    

  </body>
</html>