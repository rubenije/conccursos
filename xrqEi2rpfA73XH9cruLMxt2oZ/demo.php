<?php 
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}

require_once(INCLUDE_PATH.'class/class.inputfilter.php');
require_once(INCLUDE_PATH.'class/inc.globals.php');
require_once(INCLUDE_PATH.'class/class.informe.php');

session_start();

$opc  = $post['opc'] ?? null;

if($opc == 'setFechas'){

    $desde = trim($post['desde'] ?? '');
    $hasta = trim($post['hasta'] ?? '');

    if(!empty($desde) && !empty($hasta)){

        $_SESSION['FECHA_DESDE'] = $desde;
        $_SESSION['FECHA_HASTA'] = $hasta;

    } else {

        unset($_SESSION['FECHA_DESDE']);
        unset($_SESSION['FECHA_HASTA']);
    }
}

$titleFecha = '';

if(
    !empty($_SESSION['FECHA_DESDE']) &&
    !empty($_SESSION['FECHA_HASTA'])
){
    $titleFecha = "Desde: ".sql2date($_SESSION['FECHA_DESDE'])." Hasta: ".sql2date($_SESSION['FECHA_HASTA']);
}

$objInforme = new informe();

$campanas  = $objInforme->getCampanas();
$concursos = $objInforme->getConsolidadoPorConcurso();
$zonas     = $objInforme->getConsolidadoPorZona();
$distritos = $objInforme->getConsolidadoPorDistrito();
$dias      = $objInforme->getConsolidadoPorDia();

/*
|--------------------------------------------------------------------------
| CONFIGURACION CONCURSOS
|--------------------------------------------------------------------------
*/

$infoConcursos = [

    'energia' => [
        'inicio' => '2025-05-01',
        'termino' => '2025-05-31',
        'estado' => 'En curso'
    ],

    'royalweekend' => [
        'inicio' => '2025-05-05',
        'termino' => '2025-06-05',
        'estado' => 'En curso'
    ],

    'cpch' => [
        'inicio' => '2025-04-15',
        'termino' => '2025-05-20',
        'estado' => 'Próximo cierre'
    ]

];

/*
|--------------------------------------------------------------------------
| MAPA CAMPAÑAS
|--------------------------------------------------------------------------
*/

$campanasByGrupo = [];

foreach ($campanas as $c) {

    $campanasByGrupo[$c['grupo']] = $c['nombre'];
}

/*
|--------------------------------------------------------------------------
| CHARTS
|--------------------------------------------------------------------------
*/

$lConcursos = [];
$iConcursos = [];
$uConcursos = [];

$lDiarios = [];
$iDiarios = [];
$uDiarios = [];

/*
|--------------------------------------------------------------------------
| KPIS
|--------------------------------------------------------------------------
*/

$totalIngresos = 0;
$totalUnicos   = 0;

foreach ($concursos as $row) {

    $totalIngresos += (int)$row->ingresos;
    $totalUnicos   += (int)$row->unicos;
}

?>
<!doctype html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Concursos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <div class="col-12 col-md-10 m-auto">

            <nav class="navbar navbar-expand-lg navbar-light navbar-custom mt-2">

                <div class="container-fluid">

                    <a class="navbar-brand fw-bold" href="informe.php">
                        ConCCUrsos
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">

                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link active" href="informe.php">
                                    INICIO
                                </a>
                            </li>

                            <?php foreach($campanas as $campana){ ?>

                                <li class="nav-item">

                                    <a class="nav-link" href="informe-detalle.php?grupo=<?= $campana['grupo']; ?>">

                                        <?= strtoupper($campana['grupo']); ?>

                                    </a>

                                </li>

                            <?php } ?>

                            <li class="nav-item">
                                <a class="nav-link" href="informe-historico.php">
                                    HISTORICO
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            </nav>

        </div>

    </div>

</div>

<div class="container-fluid py-4">

    <div class="row">

        <div class="col-12 col-md-10 m-auto">

            <!-- HEADER KPI -->

            <div class="row g-3 mb-4">

                <div class="col-md-12 text-end">

                    <a href="xls-consolidado.php" class="btn btn-success">
                        Exportar todos los ingresos
                    </a>

                </div>

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

                    $grupo = strtolower($element->grupo);

                    $nombre = $campanasByGrupo[$element->grupo] ?? strtoupper($element->grupo);

                    $inicio = $infoConcursos[$grupo]['inicio'] ?? null;
                    $termino = $infoConcursos[$grupo]['termino'] ?? null;
                    $estado = $infoConcursos[$grupo]['estado'] ?? 'Sin definir';

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

                    $lConcursos[] = $nombre;
                    $iConcursos[] = (int)$element->ingresos;
                    $uConcursos[] = (int)$element->unicos;

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

</div>

<script>

    var lConcursos = <?= json_encode($lConcursos, JSON_UNESCAPED_UNICODE) ?>;

    var iConcursos = <?= json_encode($iConcursos, JSON_NUMERIC_CHECK) ?>;

    var uConcursos = <?= json_encode($uConcursos, JSON_NUMERIC_CHECK) ?>;

    var ctx1 = document
        .getElementById("ingresosPorConcurso")
        .getContext("2d");

    new Chart(ctx1, {

        type: 'bar',

        data: {

            labels: lConcursos,

            datasets: [

                {
                    label: 'Totales',
                    backgroundColor: '#198754',
                    data: iConcursos
                },

                {
                    label: 'Únicos',
                    backgroundColor: '#0d6efd',
                    data: uConcursos
                }

            ]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: true
                }

            }

        }

    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>