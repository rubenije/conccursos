<?php   
  if (!defined('INCLUDE_PATH')) {
      define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
  }
  $time = date('His');
  require_once(INCLUDE_PATH.'class/class.inputfilter.php');
  require_once(INCLUDE_PATH.'class/class.master.php');
  

  session_start();

  if( !empty($post['opc']) && $post['opc'] == 'autenticate' && !empty($post['master_id']) ){
    $objMaster   = new master();
    $autenticate  = $objMaster->autenticate($post['master_id']);
    
    if($autenticate){
      header("Location: home.php");
      exit;
    }else{
      $error = true;
    }
  }
  
 if(isset($get['opc']) && $get['opc'] == 'logout'){
    header("Location: index.php");
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
  <body class="d-flex flex-column min-vh-100 page-index">
    <main class="flex-grow-1">
      <div class="container">
        <div class="row">
          <div class="col-12 text-end">
            <img src="assets/img/logo-ccu.png" class="img-fluid logo-ccu" alt="CCU Chile">
          </div>
        </div>
      </div>

      <div class="is-mobile">
        <div class="container vh-100 d-flex justify-content-center align-items-center" style="margin-top: -5rem;">
          <div class="row text-center">
            <div class="col-12">
              <img src="assets/img/txt-home-concursos-sm.png" class="img-fluid" alt="Gana con CCU Chile">
            </div>
            <div class="col-12">
              <div class="container mb-5 formulario-inline">
                <div class="row justify-content-center">
                  <div class="col-12 col-md-6 text-center p-2">
                    <form method="post" action="index.php" id="ingreso">
                      <input type="hidden" name="opc" value="autenticate">
                      <div class="row">
                        <div class="col-12">
                          <input type="text" class="form-control input-entrar" name="master_id" id="master_id" maxlength="20" oninput="this.value = this.value.replace(/\D/g, '')">
                          <div id="master_id_help" class="form-text">Ingresa tu ID de usuario</div>
                          
                        </div>
                        <div class="col-12 text-end">
                          <div class="space-10"></div>
                          <button type="submit" class="btn btn-primary btn-entrar w-100">ENTRAR</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
            </div>
            
          </div>
        </div>
      </div> 

      <div class="is-desktop">
        <div class="container">
          <div class="row">
            <div class="col-12 text-center">
              <img src="assets/img/txt-home-concursos.png" class="img-fluid home-gana" alt="Gana con CCU Chile">
            </div>
        </div>
        <div class="container mb-5 formulario-inline">
          <div class="row justify-content-center">
            <div class="col-12 col-md-6 text-center p-2">
              <form method="post" action="index.php">
                <input type="hidden" name="opc" value="autenticate">
                <div class="row">
                  <div class="col-8">
                    <input type="text" class="form-control input-entrar" name="master_id" id="master_id">
                    <div id="emailHelp" class="form-text">Ingresa tu ID para ver tu progreso</div>
                  </div>
                  <div class="col-4 text-start">
                    <button type="submit" class="btn btn-primary btn-entrar">ENTRAR</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <div class="space-80"></div>
      
      
    </main>

    <?php include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
  </body>
</html>