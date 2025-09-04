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
    header('Location: index-php');
    exit;
  }
  
  $objMaster = new master();
  $objRegistro = new registro();  
  $objDetalle = new detalle();

  if($get['tipo'] == 'vendedor'){
    $detalles  = $objDetalle->getDetalleByVendedorId($get['id']);
  }else{
    $master         = $objMaster->getMasterId($get['id']);
    $vendedores_ids = $objRegistro->getIdsVendedorBySupervisorId($get['id']);
    $detalles       = $objDetalle->getDetalleByVendedoresByIds($vendedores_ids);
  }
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
  <body class="d-flex flex-column min-vh-100 page-energia">
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
            <img src="assets/img/energia.png" class="img-fluid minions" alt="Minions">
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-2 is-desktop">
            <div class="space-100"></div>
            <img src="assets/img/logo-rockstar-v2.png" class="logo-rockstar img-fluid " alt="">
          </div>
          <div class="col-12 col-lg-8 text-center">
            <img src="assets/img/cliente-rojo.png" class="img-fluid cliente-rojo" alt="Cliente Rojo">
            
            <!-- INI TABLA -->
            <div class="space-20"></div>
            <div class="is-desktop">
              <table class="table table-spacing mx-auto" style="width: 550px;">
                <thead>
                  <tr>
                      <th scope="col" class="bg-negro borde">ID</th>
                      <th scope="col" class="bg-negro borde">Sector</th>
                      <th scope="col" class="bg-amarillo-claro borde" >Razón Social</th>
                      <th scope="col" class="bg-rojo-oscuro borde">Compra Rockstar</th>
                      <th scope="col" class="bg-azul borde">Compra RedBull</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($detalles as $detalle){ 
                      $classg = ($detalle->compra_rockstar == 'SI') ? 'txt-verde' : 'txt-rojo';
                      $classd = ($detalle->compra_redbull == 'SI') ? 'txt-verde' : 'txt-rojo';   
                  ?>
                  <tr>
                      <td class="text-start txt-negro"><?= $detalle->id; ?></td>
                      <td class="txt-negro"><?= $detalle->sector; ?></td>
                      <td class="txt-amarillo-claro"><?= $detalle->razon; ?></td>
                      <td class="<?= $classg; ?>"><?= $detalle->compra_rockstar; ?></td>
                      <td class="<?= $classd; ?>"><?= $detalle->compra_redbull; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>

            <div class="table-responsive d-flex justify-content-center"> 
              <table class="table table-spacing is-mobile w-auto">
                <thead>
                  <tr>
                      <th scope="col" class="bg-negro borde">ID</th>
                      <th scope="col" class="bg-negro borde">Sector</th>
                      <th scope="col" class="bg-amarillo-claro borde" >Razón Social</th>
                      <th scope="col" class="bg-rojo-oscuro borde">Compra Rockstar</th>
                      <th scope="col" class="bg-azul borde">Compra RedBull</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($detalles as $detalle){ 
                      $classg = ($detalle->compra_rockstar == 'SI') ? 'txt-verde' : 'txt-rojo';
                      $classd = ($detalle->compra_redbull == 'SI') ? 'txt-verde' : 'txt-rojo';  
                  ?>
                  <tr>
                      <td class="text-start txt-negro"><?= $detalle->id; ?></td>
                      <td class="txt-negro"><?= $detalle->sector; ?></td>
                      <td class="txt-amarillo-claro"><?= $detalle->razon; ?></td>
                      <td class="<?= $classg; ?>"><?= $detalle->compra_rockstar; ?></td>
                      <td class="<?= $classd; ?>"><?= $detalle->compra_redbull; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>


           

            

            
            <!-- END TABLA -->
            <p class="premios ubuntu-bold">REVISA LA INFORMACIÓN DE LOS PREMIOS HACIENDO <a href="premios.pdf" target="_blank" class="irpdf">CLICK AQUÍ</a></p>
          </div>
          <div class="col-12 col-lg-2 is-desktop">
            <div class="space-100"></div>
            <img src="assets/img/logo-redbull-v2.png" class="logo-redbull img-fluid" alt="">
          </div>
          
        </div>
      
      
      <div class="space-80"></div>
      
      
    </main>

    <?php // include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
  </body>
</html>