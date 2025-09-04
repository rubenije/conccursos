<?php   
  if (!defined('INCLUDE_PATH')) {
      define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
  }
  $time = date('His');
  require_once(INCLUDE_PATH.'class/class.inputfilter.php');
  require_once(INCLUDE_PATH.'class/class.master.php');
  

  session_start();
  if(!$_SESSION['LOGIN']){
    header('Location: index-php');
    exit;
  }

  
  if( !empty($post['opc']) && $post['opc'] == 'autenticate' && !empty($post['master_id']) ){
    $objMaster   = new master();
    $autenticate  = $objMaster->autenticate($post['master_id']);
    
    if($autenticate){
      if($_SESSION['LOGIN_TIPO'] == 'JEFEDEMARCA'){
        header("Location: detalle-jdm.php");
        exit;
      }else{
          header("Location: home.php");
          exit;
      }
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
  <body class="d-flex flex-column min-vh-100 page-energia">
    <main class="flex-grow-1">
      <div class="container">
        <div class="row">
          <div class="col-12 text-end">
            <img src="assets/img/logo-ccu.png" class="img-fluid logo-ccu" alt="CCU Chile">
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <img src="assets/img/txt-conccursos-blanco.png" class="img-fluid conccursos-blanco" alt="Conccursos">
          </div>
          <div class="col-12 text-center">
            <img src="assets/img/txt-selecciona-el-concurso.png" class="img-fluid selecciona-el-concurso" alt="Selecciona el concurso">
          </div>
          <div class="col-6 text-center">
            <a href="minions.php"><img src="assets/img/btn-minions.png" class="img-fluid btn-minions" alt="Botón Minions"></a>
          </div>
          <div class="col-6 text-center">
            <a href="energia.php"><img src="assets/img/btn-energia.png" class="img-fluid btn-energia" alt="Botón Energia"></a>
          </div>
          
        </div>
      
      
      <div class="space-80"></div>
      
      
    </main>

    <?php include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
  </body>
</html>