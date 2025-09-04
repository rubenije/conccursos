<?php   
  if (!defined('INCLUDE_PATH')) {
      define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
  }
  $time = date('His');
  require_once(INCLUDE_PATH.'class/class.inputfilter.php');
  require_once(INCLUDE_PATH.'class/class.registro.php');
  require_once(INCLUDE_PATH.'class/class.ingreso.php');
  
  session_start();
  if(!$_SESSION['LOGIN']){
    header('Location: index-php');
    exit;
  }

  $objRegistro = new registro();
  $z_norte      = $objRegistro->getZonaByCodigo('NORTE');
  $z_costa      = $objRegistro->getZonaByCodigo('COSTA');
  $z_santiago   = $objRegistro->getZonaByCodigo('SANTIAGO');
  $z_centro_sur = $objRegistro->getZonaByCodigo('CENTRO_SUR');
  $z_sur        = $objRegistro->getZonaByCodigo('SUR');
  $totales      = $objRegistro->getTotales();

  $totFinalIngresos = 0;
  $totFinalUnicos = 0;
  
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
            <img src="assets/img/minions.png" class="img-fluid minions" alt="Minions">
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-2 text-center is-desktop">
            <?php include("include-izquierda.php"); ?>
          </div>
          <div class="col-12 col-lg-8 text-center">
            <!-- INI TABLA -->
            <div class="space-20"></div>

            <div class="is-desktop">
            <table class="table table-spacing mx-auto" style="width: 690px;">
              <thead>
                <tr>
                  <th scope="col" class="text-start transparent">
                    <div class="titulo bg-verde-oscuro">
                      <div class="space-10"></div>
                      &nbsp;Distrito_venta
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-amarillo">
                      <div class="space-5"></div>
                      <div class="text-small">Tasa Uso Sitio Web<br>(Ingresos Totales)</div>
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-amarillo">
                      <div class="space-10"></div>
                      ID Únicos
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="bg-rojo-oscuro borde">
                      <img src="assets/img/botella-cc.png" class="botella-cc" alt="Botella Cobertura Conjunta">
                      <div class="titulo">
                        <div class="space-20"></div>
                        <div class="text-small">Cobertura Conjunta</div>
                      </div>
                    </div>
                      
                  </th>
                  <th scope="col" class="transparent">
                    <div class="bg-verde borde"> 
                      <img src="assets/img/botella-cn.png" class="botella-cn" alt="Botella Cobertura Nectar">
                      <div class="titulo">
                        <div class="space-20"></div>
                        <div class="text-small">Cobertura Néctar</div>
                      </div>
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-verde-oscuro">
                      <div class="space-10"></div>
                      Total Cupones
                    </div>
                  </th>
                </tr>
              </thead>
              <?php if($z_norte){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_norte->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_norte->zona_codigo);
              ?>  
              <tbody>
                <?php 
                $totIngresos = 0;
                $totUnicos = 0;
                foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos;
                  
                ?>
                 <tr>
                    <td style="width: 180px;" class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td style="width: 110px;" class="txt-amarillo"><?= $ingresos; ?></td>
                    <td style="width: 70px;" class="txt-amarillo"><?= $unicos; ?></td>
                    <td style="width: 120px;" class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td style="width: 120px;" class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td style="width: 90px;" class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Zona Norte</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
              </tbody>
              <?php } 
                $totFinalIngresos+= $totIngresos;
                $totFinalUnicos+= $totUnicos;

              ?>
            </table>

            <?php if($z_costa){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_costa->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_costa->zona_codigo);
              
            ?> 
            <table class="table table-spacing mx-auto" style="width: 690px;">
              <tbody>
                 <?php 
                 $totIngresos = 0;
                 $totUnicos = 0;
                 
                 foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos;  
                ?>
                 <tr>
                    <td style="width: 180px;" class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td style="width: 110px;" class="txt-amarillo"><?= $ingresos; ?></td>
                    <td style="width: 70px;" class="txt-amarillo"><?= $unicos; ?></td>
                    <td style="width: 120px;" class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td style="width: 120px;" class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td style="width: 90px;" class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Centro Costa</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
              </tbody>
            </table>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;
            ?>

            <?php if($z_santiago){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_santiago->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_santiago->zona_codigo);

            ?> 
            <table class="table table-spacing mx-auto" style="width: 690px;">
              <tbody>
                 <?php 
                 $totIngresos = 0;
                 $totUnicos = 0;
                 foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos;  
                 ?>
                 <tr>
                    <td style="width: 180px;" class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td style="width: 110px;" class="txt-amarillo"><?= $ingresos; ?></td>
                    <td style="width: 70px;" class="txt-amarillo"><?= $unicos; ?></td>
                    <td style="width: 120px;" class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td style="width: 120px;" class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td style="width: 90px;" class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Stgo/Rcgua</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
              </tbody>
            </table>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;
            ?>

            <?php if($z_centro_sur){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_centro_sur->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_centro_sur->zona_codigo);
            ?> 
            <table class="table table-spacing mx-auto" style="width: 690px;">
              <tbody>
                 <?php 
                 $totIngresos = 0;
                 $totUnicos = 0;
                 foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos; 
                 ?>
                 <tr>
                    <td style="width: 180px;" class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td style="width: 110px;" class="txt-amarillo"><?= $ingresos; ?></td>
                    <td style="width: 70px;" class="txt-amarillo"><?= $unicos; ?></td>
                    <td style="width: 120px;" class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td style="width: 120px;" class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td style="width: 90px;" class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Centro Sur</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
              </tbody>
            </table>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;
            ?>

            <?php if($z_sur){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_sur->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_sur->zona_codigo);

            ?> 
            <table class="table table-spacing mx-auto" style="width: 690px;">
              <tbody>
                 <?php 
                 $totIngresos = 0;
                 $totUnicos = 0;
                 foreach($distritos as $distrito){ 
                    $objIngreso = new ingreso();
                    $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                    $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                    $totIngresos+= $ingresos;
                    $totUnicos+= $unicos;
                    
                  ?>
                 <tr>
                    <td style="width: 180px;" class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>&zona_codigo=<?= $z_sur->zona_codigo; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td style="width: 110px;" class="txt-amarillo"><?= $ingresos; ?></td>
                    <td style="width: 70px;" class="txt-amarillo"><?= $unicos; ?></td>
                    <td style="width: 120px;" class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td style="width: 120px;" class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td style="width: 90px;" class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Sur</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
              </tbody>
            </table>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;
           
            ?>

            <table class="table table-spacing totales mx-auto" style="width: 690px;">
              <tbody>
                  <tr class="bg-verde-oscuro">
                    <td style="width: 180px;" class="text-start bg-verde-oscuro">Total General</td>
                    <td style="width: 110px;" class="bg-amarillo"><?= $totFinalIngresos; ?></td>
                    <td style="width: 70px;" class="bg-amarillo"><?= $totFinalUnicos; ?></td>
                    <td style="width: 120px;" class="bg-rojo"><?= $totales->m_cob_conjunta; ?></td>
                    <td style="width: 120px;" class="bg-verde"><?= $totales->m_cob_nectar; ?></td>
                    <td style="width: 90px;" class="bg-verde-oscuro"><?= $totales->m_cupones; ?></td>
                  </tr>
              </tbody>
            </table>
            </div>


            <!-- SM -->
            <div class="table-responsive d-flex justify-content-center"> 
              <table class="table is-mobile w-auto">
              <thead>
                <tr>
                  <th scope="col" class="text-start transparent">
                    <div class="titulo bg-verde-oscuro borde">
                      <div class="space-10"></div>
                      &nbsp;Distrito_venta
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-amarillo borde">
                      <div class="text-small">Ingresos<br>Totales</div>
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-amarillo borde">
                      <div class="text-small">ID<br>Únicos</div>
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    
                      <div class="titulo bg-rojo-oscuro borde">
                        <div class="text-small">Cob.<br>Conjunta</div>
                      </div>
                      
                  </th>
                  <th scope="col" class="transparent">
                      <div class="titulo bg-verde borde">
                        <div class="text-small">Cob.<br>Néctar</div>
                      </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-verde-oscuro borde">
                      <div class="text-small">Total<br>Cupones</div>
                    </div>
                  </th>
                </tr>
              </thead>
              <?php if($z_norte){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_norte->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_norte->zona_codigo);
              ?>  
              <tbody>
                <?php 
                $totIngresos = 0;
                $totUnicos = 0;
                foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos;
                  
                ?>
                  <tr>
                    <td class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td class="txt-amarillo"><?= $ingresos; ?></td>
                    <td class="txt-amarillo"><?= $unicos; ?></td>
                    <td class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Zona Norte</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
              <?php } 
                $totFinalIngresos+= $totIngresos;
                $totFinalUnicos+= $totUnicos;

              ?>
            <?php if($z_costa){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_costa->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_costa->zona_codigo);
              
            ?> 
                  <?php 
                  $totIngresos = 0;
                  $totUnicos = 0;
                  
                  foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos;  
                ?>
                  <tr>
                    <td class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td class="txt-amarillo"><?= $ingresos; ?></td>
                    <td class="txt-amarillo"><?= $unicos; ?></td>
                    <td class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Centro Costa</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;
            ?>

            <?php if($z_santiago){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_santiago->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_santiago->zona_codigo);

            ?> 
                  <?php 
                  $totIngresos = 0;
                  $totUnicos = 0;
                  foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos;  
                  ?>
                  <tr>
                    <td class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td class="txt-amarillo"><?= $ingresos; ?></td>
                    <td class="txt-amarillo"><?= $unicos; ?></td>
                    <td class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Stgo/Rcgua</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;
            ?>

            <?php if($z_centro_sur){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_centro_sur->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_centro_sur->zona_codigo);
            ?> 
                  <?php 
                  $totIngresos = 0;
                  $totUnicos = 0;
                  foreach($distritos as $distrito){ 
                  $objIngreso = new ingreso();
                  $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                  $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                  $totIngresos+= $ingresos;
                  $totUnicos+= $unicos; 
                  ?>
                  <tr>
                    <td class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td class="txt-amarillo"><?= $ingresos; ?></td>
                    <td class="txt-amarillo"><?= $unicos; ?></td>
                    <td class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Centro Sur</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;
            ?>

            <?php if($z_sur){ 
                    $distritos = $objRegistro->getDistritoByZonaId($z_sur->zona_id);
                    $subtotal = $objRegistro->getSubTotalByTipo($z_sur->zona_codigo);

            ?> 
                  <?php 
                  $totIngresos = 0;
                  $totUnicos = 0;
                  foreach($distritos as $distrito){ 
                    $objIngreso = new ingreso();
                    $ingresos  = $objIngreso->getIngresosPorDistrito($distrito->zona_id, $distrito->distrito_id);
                    $unicos  = $objIngreso->getIngresosPorDistritoUnicos($distrito->zona_id, $distrito->distrito_id);
                    $totIngresos+= $ingresos;
                    $totUnicos+= $unicos;
                    
                  ?>
                  <tr>
                    <td class="text-start">
                      <a href="minions-jdv.php?id=<?= $distrito->id; ?>&zona_codigo=<?= $z_sur->zona_codigo; ?>" class="txt-verde-oscuro">
                        <?= $distrito->dist_nombre; ?>
                      </a>
                    </td>
                    <td class="txt-amarillo"><?= $ingresos; ?></td>
                    <td class="txt-amarillo"><?= $unicos; ?></td>
                    <td class="txt-rojo"><?= $distrito->m_cob_conjunta; ?></td>
                    <td class="txt-verde"><?= $distrito->m_cob_nectar; ?></td>
                    <td class="txt-verde-oscuro fw-bold"><?= $distrito->m_cupones; ?></td>
                  </tr>
                  <?php } ?>
                  <tr class="bg-verde-oscuro fw-bold">
                    <td class="text-start bg-verde-oscuro">Total Sur</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totUnicos; ?></td>
                    <td class="bg-rojo"><?= $subtotal->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $subtotal->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $subtotal->m_cupones; ?></td>
                  </tr>
            <?php } 
              $totFinalIngresos+= $totIngresos;
              $totFinalUnicos+= $totUnicos;

            ?>

                  <tr class="bg-verde-oscuro">
                    <td class="text-start bg-verde-oscuro">Total General</td>
                    <td class="bg-amarillo"><?= $totFinalIngresos; ?></td>
                    <td class="bg-amarillo"><?= $totFinalUnicos; ?></td>
                    <td class="bg-rojo"><?= $totales->m_cob_conjunta; ?></td>
                    <td class="bg-verde"><?= $totales->m_cob_nectar; ?></td>
                    <td class="bg-verde-oscuro"><?= $totales->m_cupones; ?></td>
                  </tr>
              </tbody>
            </table>
            </div>
            <!-- SM -->

            <!-- END TABLA -->
            <p class="premios ubuntu-bold">REVISA LA INFORMACIÓN DE LOS PREMIOS HACIENDO <a href="premios.pdf" target="_blank" class="irpdf">CLICK AQUÍ</a></p>

          </div>
          <div class="col-12 col-lg-2 text-center is-desktop">
            <?php include("include-derecha.php"); ?>
          </div>
          
        </div>
      
      
      <div class="space-80"></div>
      
      
    </main>

    <?php // include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
  </body>
</html>