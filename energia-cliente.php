<?php   
  if (!defined('INCLUDE_PATH')) {
      define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
  }
  $time = date('His');
  require_once(INCLUDE_PATH.'class/class.inputfilter.php');
  require_once(INCLUDE_PATH.'class/class.detalle.php');
  require_once(INCLUDE_PATH.'class/class.master.php');
  require_once(INCLUDE_PATH.'class/class.registro.php');
  
  
  session_start();
  if(!$_SESSION['LOGIN']){
    header('Location: index.php');
    exit;
  }
    
  $isMayorista = ($_SESSION['LOGIN_CANAL'] == 'MAYORISTA') ? true : false;
  
  $table = "energia";
  $objMaster = new master();
  $objRegistro = new registro();  
  $objDetalle = new detalle();

  if($get['tipo'] == 'vendedor'){
    $detalles  = $objDetalle->getDetalleByTableByVendedorId($table, $get['id']);
  }else{
    $master         = $objMaster->getMasterId($get['id']);
    $vendedores_ids = $objRegistro->getIdsVendedorByTableBySupervisorId($table, $get['id']);
    $detalles       = $objDetalle->getDetalleByTableByVendedoresByIds($table, $vendedores_ids);
  }
  //pre($detalles);
  //exit;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>conCCUrsos</title>
    
    <link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="favicon.svg" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    <link rel="manifest" href="site.webmanifest" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/css/main.min.css?<?= $time; ?>" rel="stylesheet">
  </head>
  <body class="d-flex flex-column min-vh-100 page-minions">
    <main class="flex-grow-1">
      <div class="container">
        <div class="row">
          <div class="col-12 text-end">
            <img src="assets/img/logo-ccu.png" class="img-fluid logo-ccu" alt="CCU Chile">
          </div>
        </div>
      </div>
      <div class="container tablitas">
        <div class="row">
          <div class="col-12 text-center">
            <img src="assets/img/<?= $table; ?>-titulo.png" class="img-fluid minions" alt="Minions">
            <div class="space-20"></div>

          </div>
        </div>
        <div class="row justify-content-center text-center g-4">
          <!--
          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="filtroGrupo" class="form-label text-white">Filtrar por grupo:</label>
              <select id="filtroGrupo" class="form-select w-auto mx-auto">
                <option value="">Todos</option>
                <?php
                  $grupos = array_unique(array_map(fn($d) => $d->GRUPO_CLIENTE, $detalles));
                  sort($grupos);
                  foreach ($grupos as $grupo) {
                    echo "<option value=\"$grupo\">$grupo</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          -->
          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="filtroSector" class="form-label text-white">Filtrar por sector:</label>
              <select id="filtroSector" class="form-select w-auto mx-auto">
                <option value="">Todos</option>
                <?php
                  $sectores = array_unique(array_map(fn($d) => $d->sector, $detalles));
                  sort($sectores);
                  foreach ($sectores as $sector) {
                    echo "<option value=\"$sector\">Sector $sector</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          
        </div>

        <div class="row">
          <div class="col-12 text-center">
            <!-- <img src="assets/img/cliente-rojo.png" class="img-fluid cliente-rojo" alt="Cliente Rojo"> -->
            
            <!-- INI TABLA -->
            

            <div class="table-responsive">
              <table class="table table-spacing mx-auto tableDetalles pt-2 pb-3 w-100">
                <thead>
                  <tr style="vertical-align: middle !important;">
                      <th scope="col" class="bg-verde-oscuro borde" style="height: 30px;">ID</th>
                      <th scope="col" class="bg-verde-oscuro borde">Sector</th>
                      <th scope="col" class="bg-verde-oscuro borde">Razón Social</th>
                      <?php if($isMayorista){ ?>
                      <th scope="col" class="bg-redbull-azul borde text-center">REDBULL HL ABRIL<br>2026 AL DÍA</th>
                      <th scope="col" class="bg-redbull-rojo borde text-center">ROCKSTAR HL ABRIL<br>2026 AL DÍA</th>

                      <th scope="col" class="bg-redbull-azul borde text-center">REDBULL HL ABRIL<br>2025 TOTAL MES</th>
                      <th scope="col" class="bg-redbull-rojo borde text-center">ROCKSTAR HL ABRIL<br>2025 TOTAL MES</th>
                      <?php }else{ ?>
                      <th scope="col" class="bg-redbull-azul borde text-center">CONCRETADO<br>REDBULL</th>
                      <th scope="col" class="bg-redbull-rojo borde text-center">CONCRETADO<br>ROCKSTAR</th>
                      <?php } ?>
                  </tr>
                </thead>
                <tbody style="vertical-align: middle !important;">
                  <?php foreach($detalles as $detalle){ 
                      $class_01 = ($detalle->CONCRETADO_REDBULL == 'SI') ? 'txt-azul' : 'txt-rojo';
                      $class_02 = ($detalle->CONCRETADO_ROCKSTAR == 'SI') ? 'txt-azul' : 'txt-rojo';
                  ?>
                  <tr>
                      <td class="text-start txt-verde-oscuro"><?= $detalle->id; ?></td>
                      <td class="txt-verde-oscuro"><?= $detalle->sector; ?></td>
                      <td class="txt-verde-oscuro text-start"><?= $detalle->razon; ?></td>
                      <?php if($isMayorista){ ?>
                      <td class="<?= $class; ?>"><?= $detalle->REDBULL_HL_2026; ?></td>
                      <td class="<?= $class; ?>"><?= $detalle->ROCKSTAR_HL_2026; ?></td>
                      <td class="<?= $class; ?>"><?= $detalle->REDBULL_HL_2025; ?></td>
                      <td class="<?= $class; ?>"><?= $detalle->ROCKSTAR_HL_2025; ?></td>
                      <?php }else{ ?>
                      <td class="<?= $class_01; ?>"><?= $detalle->CONCRETADO_REDBULL; ?></td>
                      <td class="<?= $class_02; ?>"><?= $detalle->CONCRETADO_ROCKSTAR; ?></td>
                      <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>

            <!-- END TABLA -->
            <p class="premios ubuntu-bold">REVISA LA INFORMACIÓN DE LOS PREMIOS HACIENDO <a href="assets/pdf/energia.pdf" target="_blank" class="irpdf">CLICK AQUÍ</a></p>
            
          </div>
        </div>
      
      
      <div class="space-80"></div>
      
      
    </main>

    <?php // include("include-footer.php"); ?>
    <style>
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
      display: none !important;
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
    <script>
      $(document).ready(function () {

        const tabla = $('.tableDetalles').DataTable({
          paging: false,
          info: false,
          ordering: false,
          autoWidth: false,
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
          }
        });

        // Filtro por Sector
        $('#filtroSector').on('change', function () {
          tabla.column(1).search($(this).val());
          tabla.draw();
        });

        // Filtro por Grupo
        $('#filtroGrupo').on('change', function () {
          tabla.column(1).search($(this).val());
          tabla.draw();
        });

      });
    </script>


  </body>
</html>