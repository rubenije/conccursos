<?php   
  if (!defined('INCLUDE_PATH')) {
      define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
  }
  $time = date('His');
  require_once(INCLUDE_PATH.'class/class.inputfilter.php');
  require_once(INCLUDE_PATH.'class/class.master.php');
  

  session_start();
  $page = strtolower($_SESSION['LOGIN_TIPO']);
  if(!$_SESSION['LOGIN']){
    header('Location: index-php');
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
                      <!--    
                      <div class="col-12 col-md-6 text-center">
                        <a href="retornables-<?= $page; ?>.php"><img src="assets/img/btn-retornables.png" class="img-fluid btn-minions" alt="Botón Retornables"></a>
                      </div>
                      -->
                      <div class="col-12 col-md-12 text-center">
                        <a href="redbull-<?= $page; ?>.php"><img src="assets/img/btn-redbull.png" class="img-fluid btn-minions" alt="Botón RedBull"></a>
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
            <!--
            <div class="col-12">
              <a href="retornables-<?= $page; ?>.php"><img src="assets/img/btn-retornables.png" class="img-fluid btn-minions" alt="Botón Minions"></a>
            </div>
            -->
            <div class="col-12">
              <a href="redbull-<?= $page; ?>.php"><img src="assets/img/btn-redbull.png" class="img-fluid btn-minions" alt="Botón Redbull"></a>
            </div>
            
            <!--
            <div class="col-12">
              <a href="minions-<?= $page; ?>.php"><img src="assets/img/btn-minions.png" class="img-fluid btn-minions" alt="Botón Minions"></a>
            </div>
            <div class="col-12">
                <a href="#" data-bs-toggle="modal" data-bs-target="#energiaModal">
                  <img src="assets/img/btn-energia.png" class="img-fluid btn-energia" alt="Bot��n Energia">
                </a>
            </div>
            -->
          </div>
        </div>
      </div> 
      <!-- SM -->
      
      
      <div class="space-80"></div>
      
      
    </main>

    <!-- Modal transparente con bot��n de cerrar -->
    <div class="modal fade" id="energiaModal" tabindex="-1" aria-labelledby="energiaModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0 position-relative">
          <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          <br/>
          <!-- Bot��n cerrar -->
          <div class="modal-body text-center">
            <!-- Contenido del modal -->
            <img src="assets/img/modal-energia.png" class="img-fluid" alt="Contenido del Modal">
          </div>
          
        </div>
      </div>
    </div>


    <?php include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <script src="assets/js/main.js?<?= $time; ?>"></script>-->
  </body>
</html>