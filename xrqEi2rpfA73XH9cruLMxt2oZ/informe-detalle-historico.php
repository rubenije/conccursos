<?php 
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}
require_once(INCLUDE_PATH.'class/class.inputfilter.php');
require_once(INCLUDE_PATH.'class/inc.globals.php');
require_once(INCLUDE_PATH.'class/class.informe.php');

session_start();
$titleFecha = '';
if(!empty($_SESSION['FECHA_DESDE']) && !empty($_SESSION['FECHA_HASTA'])){
    $titleFecha = "Desde:".sql2date($_SESSION['FECHA_DESDE'])." Hasta:".sql2date($_SESSION['FECHA_HASTA']);
}
$grupoActual = isset($get['grupo']) ? $get['grupo'] : ''; 

$objInforme = new informe();
$campanas = $objInforme->getCampanas();
$campanasInactivas = $objInforme->getCampanasInactivas();
$diarios = $objInforme->getIngresosDiarios($get['grupo']);
$zonas = $objInforme->getRankingPorZona($get['grupo']);
$distritos = $objInforme->getRankingPorDistrito($get['grupo']);
$actividades = $objInforme->getRankingActividadPorDia($get['grupo']);
$participaciones = $objInforme->getPorcentajeDeParticipacionPorZona($get['grupo']);
$ingresos = $objInforme->getVendedoresSinIngresos($get['grupo']);

$todasLasCampanas = array_merge($campanas, $campanasInactivas);

$campanaSeleccionada = null;

foreach($todasLasCampanas as $campana){
    if($campana['grupo'] === $grupoActual){
        $campanaSeleccionada = $campana;
        break;
    }
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
                    <a class="nav-link" href="informe.php">INICIO</a>
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
    
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-10 m-auto pt-4 text-end">
                <a href="xls.php?grupo=<?= $get['grupo']; ?>" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i>Exportar Ingresos Totales</a>
            </div>
        </div>
      <?php 
      $diasOnline = 0;
      $diasRestantes = 0;

        if($campanaSeleccionada){ 
            $hoy = new DateTime('today');

            $fechaInicio = new DateTime($campanaSeleccionada['fecha_inicio']);
            $fechaFin = new DateTime($campanaSeleccionada['fecha_fin']);

            if($hoy >= $fechaFin){

                $diasOnline = $fechaInicio->diff($fechaFin)->days;
            }

            if($hoy <= $fechaFin){

                $diasRestantes = $hoy->diff($fechaFin)->days - 1;
            }
          ?>
<div class="row">
    <div class="col-12 col-md-10 m-auto pt-4">
        <div class="card card-dashboard">
            <div class="card-body">

                <div class="row align-items-center">

    <div class="col-12 col-md-8">

        <div class="title-small">
            Concurso 
            <?php if($campanaSeleccionada['estado'] === 'Online'){ ?>
            <span class="badge bg-success badge-status">Online</span>
            <?php }else{ ?>
            <span class="badge bg-secondary badge-status">Offline</span>
            <?php } ?>
            
        </div>

        <h2 class="mb-2 fw-bold">
            <?= htmlspecialchars($campanaSeleccionada['nombre']); ?>
        </h2>

        <div class="d-flex flex-wrap gap-2 align-items-center">

            <span class="badge bg-primary">
                <?= strtoupper($campanaSeleccionada['grupo']); ?>
            </span>

            <span class="text-muted small">
                Inicio:
                <strong><?= sql2date($campanaSeleccionada['fecha_inicio']); ?></strong>
            </span>

            <span class="text-muted small">
                Término:
                <strong><?= sql2date($campanaSeleccionada['fecha_fin']); ?></strong>
            </span>

        </div>

    </div>

    <div class="col-12 col-md-4 mt-4 mt-md-0">

        <div class="row g-3">

            <div class="col-12">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body text-center">

                        <div class="title-small">
                            Días Online
                        </div>

                        <div class="kpi-number">
                            <?= $diasOnline; ?>
                        </div>

                    </div>
                </div>
            </div>

            

        </div>

    </div>

</div>

            </div>
        </div>
    </div>
</div>
<?php } ?>
      <?php if($diarios){ ?>
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
            <h4 class="mb-0">Ingresos Diarios</h4>
            <?php if($titleFecha){ ?>
            <span class="badge bg-secondary"><?= $titleFecha; ?></span>
            <?php } ?>
            <div class="listado-ganadores">
                <table class="table table-striped" style="font-size: 12px;">
                <thead>
                    <tr>
                    <th scope="col">Fecha</th>
                    <th style="width: 10%;" scope="col">Ingresos</th>
                    <th style="width: 10%;" scope="col">Únicos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($diarios as $element){ ?>
                    <tr>
                    <td><?= $element->ingr_fecha; ?></td>
                    <td><?= $element->ingresos; ?></td>
                    <td><?= $element->unicos; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            <br>
        </div>
      </div>
      <?php } ?>


      <?php if($diarios){ ?>
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
            <h4 class="mb-0">Ranking x Zona</h4>
            <?php if($titleFecha){ ?>
            <span class="badge bg-secondary"><?= $titleFecha; ?></span>
            <?php } ?>
            <div class="listado-ganadores">
                <table class="table table-striped" style="font-size: 12px;">
                <thead>
                    <tr>
                    <th scope="col">Zona</th>
                    <th style="width: 10%;" scope="col">Ingresos</th>
                    <th style="width: 10%;" scope="col">Únicos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($zonas as $element){ ?>
                    <tr>
                    <td><?= $element->zona_nombre; ?></td>
                    <td><?= $element->ingresos; ?></td>
                    <td><?= $element->unicos; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            <br>
        </div>
      </div>
      <?php } ?>

      <?php if($distritos){ ?>
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
            <h4 class="mb-0">Ranking x Distrito</h4>
            <?php if($titleFecha){ ?>
            <span class="badge bg-secondary"><?= $titleFecha; ?></span>
            <?php } ?>
            <div class="listado-ganadores">
                <table class="table table-striped" style="font-size: 12px;">
                <thead>
                    <tr>
                    <th scope="col">Distrito</th>
                    <th style="width: 10%;" scope="col">Ingresos</th>
                    <th style="width: 10%;" scope="col">Únicos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($distritos as $element){ ?>
                    <tr>
                    <td><?= $element->dist_nombre; ?></td>
                    <td><?= $element->ingresos; ?></td>
                    <td><?= $element->unicos; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            <br>
        </div>
      </div>
        <?php } ?>


      <?php if($actividades){ ?>
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
            <h4 class="mb-0">Top 20 Actividad x Día</h4>
            <?php if($titleFecha){ ?>
            <span class="badge bg-secondary"><?= $titleFecha; ?></span>
            <?php } ?>
            <div class="listado-ganadores">
                <table class="table table-striped" style="font-size: 12px;">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th style="width: 10%;" scope="col">Ingresos</th>
                    <th style="width: 10%;" scope="col">Dias Activos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($actividades as $element){ ?>
                    <tr>
                    <td><?= $element->cliente_id; ?></td>
                    <td><?= $element->nombre; ?></td>
                    <td><?= $element->ingresos; ?></td>
                    <td><?= $element->activos; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            <br>
        </div>
      </div>
        <?php } ?>


      <?php if($participaciones){ ?>
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
            <h4 class="mb-0">Participación x Zona</h4>
            <?php if($titleFecha){ ?>
            <span class="badge bg-secondary"><?= $titleFecha; ?></span>
            <?php } ?>
            <div class="listado-ganadores">
                <table class="table table-striped" style="font-size: 12px;">
                <thead>
                    <tr>
                    <th scope="col">Zona</th>
                    <th style="width: 10%;" scope="col">Ingresos</th>
                    <th style="width: 10%;" scope="col">Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($participaciones as $element){ ?>
                    <tr>
                    <td><?= $element->zona_nombre; ?></td>
                    <td><?= $element->ingresos; ?></td>
                    <td><?= $element->porcentaje; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            <br>
        </div>
      </div>
        <?php } ?>


        <?php if($ingresos){ ?>
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
            <h4 class="mb-0">Vendedores Sin Ingresos</h4>
            <?php if($titleFecha){ ?>
            <span class="badge bg-secondary"><?= $titleFecha; ?></span>
            <?php } ?>
            <div class="listado-ganadores">
                <table class="table table-striped" style="font-size: 12px;">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ingresos as $element){ ?>
                    <tr>
                    <td><?= $element->cliente_id; ?></td>
                    <td><?= $element->nombre; ?></td>
                    <td><?= $element->tipo; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            <br>
        </div>
      </div>
        <?php } ?>

      
  
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(".lg-vermas").on('click', function(){
          if($('.listado-ganadores').is(':hidden')) {
            $('.listado-ganadores').css('display', 'block');
            $(".lg-vermas").html('Ver Menos -');

          }else{
            $('.listado-ganadores').css('display', 'none'); 
            $(".lg-vermas").html('Ver Más +');
            
          }
        })
    </script>
  </body>
</html>