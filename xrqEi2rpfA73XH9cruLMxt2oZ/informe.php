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
$concursos = $objInforme->getConsolidadoPorConcurso();
$zonas = $objInforme->getConsolidadoPorZona();
$distritos = $objInforme->getConsolidadoPorDistrito();
$dias = $objInforme->getConsolidadoPorDia();

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
$grupoActual = isset($get['grupo']) ? $get['grupo'] : ''; 

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
                  <?php foreach($campanas as $campana){ 
                    $activo = ($campana['grupo'] === $grupoActual) ? 'active' : '';
                    ?>
                    <li class="nav-item">
                    <a class="nav-link <?= $activo ?>" href="informe-detalle.php?grupo=<?= $campana['grupo']; ?>"><?= strtoupper($campana['grupo']); ?></a>
                  </li>
                  <?php } ?>
                  <li class="nav-item">
                    <a class="nav-link" href="informe-historico.php">HISTORICO</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>

    <div class="container-fluid pt-5">

      <div class="row mt-4">
        <div class="col-12 col-md-10 m-auto">
          <div class="row g-3">
            <div class="col-md-12 text-end">
              <a href="xls-consolidado.php" class="btn btn-success mt-2">Exportar todos los ingresos</a>
            </div>
            
            <div class="col-md-3">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  <div class="text-muted">Total Ingresos</div>
                  <div class="fs-4 fw-bold"><?= numberFormat($totalIngresos) ?></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  <div class="text-muted">Clientes Únicos</div>
                  <div class="fs-4 fw-bold"><?= numberFormat($totalUnicos) ?></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  
                  <form class="row g-2 justify-content-end" method="post" action="informe.php" novalidate>
                    <input type="hidden" name="opc" value="setFechas">
                    <div class="col-12 col-sm-4">
                      <label for="desde" class="form-label mb-1">Desde</label>
                      <input type="date" class="form-control form-control-sm" id="desde" name="desde"
                                value="<?= htmlspecialchars($_SESSION['FECHA_DESDE'] ?? '', ENT_QUOTES,'UTF-8') ?>">
                        </div>
                        <div class="col-12 col-sm-4">
                      <label for="hasta" class="form-label mb-1">Hasta</label>
                      <input type="date" class="form-control form-control-sm" id="hasta" name="hasta"
                            value="<?= htmlspecialchars($_SESSION['FECHA_HASTA'] ?? '', ENT_QUOTES,'UTF-8') ?>">
                    </div>
                    <div class="col-12 col-sm-4 d-flex align-items-end gap-2">
                      <button type="submit" class="btn btn-primary btn-sm w-50">Filtrar</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm w-50"
                              onclick="this.form.desde.value=''; this.form.hasta.value=''; this.form.submit();">
                        Limpiar
                      </button>
                    </div>
                  </form>
                  
                  
                </div>
              </div>

              
            </div>

            
            
            
          </div>
        </div>
      </div>

      
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
                <th class="text-center" style="width:15%;">Totales</th>
                <th class="text-center" style="width:15%;">Únicos</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($concursos)): ?>
                <?php foreach($concursos as $element):
                  $grupo  = $element->grupo;
                  $nombre = $campanasByGrupo[$grupo] ?? strtoupper($grupo);
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
          <canvas id="ingresosPorConcurso" width="600" height="400"></canvas>

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