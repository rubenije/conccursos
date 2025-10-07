<?php   
  if (!defined('INCLUDE_PATH')) {
      define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
  }
  $time = date('His');
  require_once(INCLUDE_PATH.'class/class.inputfilter.php');
  require_once(INCLUDE_PATH.'class/class.master.php');
  require_once(INCLUDE_PATH.'class/class.ingreso.php');
  
  session_start();
  if(!$_SESSION['LOGIN']){
    header('Location: index.php');
    exit;
  }

  if(isset($get['opc']) && isset($get['grupo']) && $get['opc'] == 'ingreso'){

    $objIngreso = new ingreso();
    $distrito   = $objIngreso->getDistritoByCodigo($_SESSION['LOGIN_DISTRITO']);

    $distrito_id = $distrito && isset($distrito->distrito_id) ? (int)$distrito->distrito_id : null;
    $zona_id     = $distrito && isset($distrito->zona_id)     ? (int)$distrito->zona_id     : null;


    $page = strtolower($_SESSION['LOGIN_TIPO']);
    
    $tmp['grupo']             = (isset($get['grupo']) && !empty($get['grupo'])) ? $get['grupo'] : '';
    $tmp['tipo'] 		          = $_SESSION['LOGIN_TIPO'];
    $tmp['cliente_id'] 		    = $_SESSION['LOGIN_ID'];
    $tmp['distrito_id'] 	    = $distrito_id;
    $tmp['zona_id'] 		      = $zona_id;
    $tmp['supervisor_id'] 	  = $_SESSION['LOGIN_SUPERVISOR_ID'];

    $_SESSION['LOGIN_GRUPO']  = $get['grupo'];
    $objIngreso->saveIngreso($tmp);
    header("Location: ".$get['grupo']."-".$page.".php");
    exit;
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
  <body class="d-flex flex-column min-vh-100 page-home">
    <main class="flex-grow-1">
      <div class="is-desktop">
      
      </div>
      <div class="container">
        <div class="row">
          <div class="col-12 text-end">
            <img src="assets/img/logo-ccu.png" class="img-fluid logo-ccu" alt="CCU Chile">
          </div>
        </div>
      </div>
      <div class="container is-desktop">
        
        <div class="row">
          <div class="col-12 text-center">
            <img src="assets/img/txt-conccursos-blanco.png" class="img-fluid conccursos-blanco" alt="Conccursos">
          </div>
          <div class="col-12 text-center">
            <img src="assets/img/txt-selecciona-el-concurso.png" class="img-fluid txt-selecciona-el-concurso" alt="Selecciona el concurso">
          </div>
        </div>
        <div class="row">
          <div class="container">
            <div class="row">
              <div class="col-8 m-auto col-auto">
                  <div class="container">
                    <div class="row">
                      <div class="col-12 col-md-6 text-center">
                        <a href="?opc=ingreso&grupo=tirate"><img src="assets/img/btn-tirate.png" class="img-fluid btn-minions" alt="Botón Retornables"></a>
                      </div>
                      <div class="col-12 col-md-6 text-center">
                        <a href="?opc=ingreso&grupo=craft"><img src="assets/img/btn-craft.png" class="img-fluid btn-minions" alt="Botón Craft"></a>
                      </div>
                      <div class="col-12 col-md-6 text-center">
                        <a href="?opc=ingreso&grupo=bep"><img src="assets/img/btn-bep.png" class="img-fluid btn-minions" alt="Botón BEP"></a>
                      </div>
                      <div class="col-12 col-md-6 text-center">
                        <a href="?opc=ingreso&grupo=sabores"><img src="assets/img/btn-sabores.png" class="img-fluid btn-minions" alt="Botón Sabores"></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- SM -->
      <div class="is-mobile">
        <div class="container vh-100 d-flex justify-content-center align-items-center" style="margin-top: -5rem;">
          <div class="row text-center">
            <div class="col-12">
              <img src="assets/img/txt-conccursos-blanco.png" class="img-fluid conccursos-blanco" alt="Conccursos">
            </div>
            <div class="col-12">
              <img src="assets/img/txt-selecciona-el-concurso.png" class="img-fluid txt-selecciona-el-concurso" alt="Selecciona el concurso">
            </div>
            <div class="col-12">
              <a href="?opc=ingreso&grupo=tirate"><img src="assets/img/btn-tirate.png" class="img-fluid btn-minions" alt="Botón Minions"></a>
            </div>
            <div class="col-12">
              <a href="?opc=ingreso&grupo=craft"><img src="assets/img/btn-craft.png" class="img-fluid btn-minions" alt="Botón Redbull"></a>
            </div>
            <div class="col-12">
              <a href="?opc=ingreso&grupo=bep"><img src="assets/img/btn-bep.png" class="img-fluid btn-minions" alt="Botón BEP"></a>
            </div>
            <div class="col-12">
              <a href="?opc=ingreso&grupo=sabores"><img src="assets/img/btn-sabores.png" class="img-fluid btn-minions" alt="Botón Saboress"></a>
            </div>
            
          </div>
        </div>
      </div> 
      <!-- SM -->
      
      
      <div class="space-80"></div>
      
      
    </main>

    <?php include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>