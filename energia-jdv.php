<?php   
  if (!defined('INCLUDE_PATH')) {
      define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
  }
  $time = date('His');
  require_once(INCLUDE_PATH.'class/class.inputfilter.php');
  require_once(INCLUDE_PATH.'class/class.registro.php');
  
  session_start();
  if(!$_SESSION['LOGIN']){
    header('Location: index-php');
    exit;
  }
  
  $objRegistro = new registro();
  if(isset($get['id']) && is_numeric($get['id'])){
    $registros  = $objRegistro->getJefeDeVentaBySupervisorId($get['id']);
    $total   = $objRegistro->getDistritoById($get['id']);
  }else{
    $registros  = $objRegistro->getJefeDeVentaBySupervisorId($_SESSION['LOGIN_SUPERVISOR_ID']);
    $total   = $objRegistro->getDistritoById($_SESSION['LOGIN_SUPERVISOR_ID']);
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
          <div class="col-12 col-lg-2 d-flex justify-content-center align-items-center">
            <img src="assets/img/logo-rockstar-v2.png" class="logo-rockstar img-fluid is-desktop" alt="">
          </div>
          <div class="col-12 col-lg-8 text-center">
            <!-- INI TABLA -->
            <div class="space-20"></div>
            
            <div class="is-desktop">
              <table class="table table-spacing mx-auto" style="width: 550px;">
                <thead>
                  <tr>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-negro borde" style="height: 60px;">
                          <div class="space-20"></div>
                          ID
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-negro borde" style="height: 60px;">
                          <div class="space-20"></div>
                          JDV
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-rojo-oscuro borde" style="height: 60px;">
                          <div class="titulo">
                            <div class="space-5"></div>
                            Cobertura<br>Conjunta
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-azul borde" style="height: 60px;"> 
                          <div class="titulo">
                            <div class="space-5"></div>
                            Cobertura<br>RedBull
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-gris borde" style="height: 60px;">
                          <div class="space-15"></div>
                          Cupones
                        </div>
                      </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($registros as $registro){ ?> 
                  <tr>
                      <td style="width: 50px;" class="txt-negro"><?= $registro->id; ?></td>
                      <td style="width: 220px;" class="text-start"><a href="energia-vendedor.php?id=<?= $registro->id; ?>" class="txt-negro"><?= $registro->nombre; ?></a></td>
                      <td style="width: 80px;" class="txt-rojo"><?= $registro->e_cob_conjunta; ?></td>
                      <td style="width: 80px;" class="txt-azul"><?= $registro->e_cob_redbull; ?></td>
                      <td style="width: 60px;" class="txt-gris fw-bold"><?= $registro->e_cupones; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($total){ ?>
                    <tr class="transparent">
                      <td class="transparent" style="border: none;"></td>
                      <td class="text-start bg-negro">Total General</td>
                      <td class="bg-rojo-oscuro"><?= $total->e_cob_conjunta; ?></td>
                      <td class="bg-azul"><?= $total->e_cob_redbull; ?></td>
                      <td class="bg-gris"><?= $total->e_cupones; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>



            <div class="table-responsive d-flex justify-content-center is-mobile"> 
              <table class="table table-spacing is-mobile w-auto">
                <thead>
                  <tr>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-negro borde" style="height: 70px;">
                          <div class="space-20"></div>
                          ID
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-negro borde" style="height: 70px;">
                          <div class="space-20"></div>
                          JDV
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-rojo-oscuro borde" style="height: 70px;">
                          <div class="titulo">
                            <div class="space-5"></div>
                            Cobertura<br>Conjunta
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-azul borde" style="height: 70px;"> 
                          <div class="titulo">
                            <div class="space-5"></div>
                            Cobertura<br>RedBull
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-gris borde" style="height: 70px;">
                          <div class="space-15"></div>
                          Cupones
                        </div>
                      </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($registros as $registro){ ?> 
                  <tr>
                      <td class="txt-negro"><?= $registro->id; ?></td>
                      <td class="text-start"><a href="energia-vendedor.php?id=<?= $registro->id; ?>" class="txt-negro"><?= $registro->nombre; ?></a></td>
                      <td class="txt-rojo"><?= $registro->e_cob_conjunta; ?></td>
                      <td class="txt-azul"><?= $registro->e_cob_redbull; ?></td>
                      <td class="txt-gris fw-bold"><?= $registro->e_cupones; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($total){ ?>
                    <tr class="transparent">
                      <td class="transparent" style="border: none;"></td>
                      <td class="text-start bg-negro">Total General</td>
                      <td class="bg-rojo-oscuro"><?= $total->e_cob_conjunta; ?></td>
                      <td class="bg-azul"><?= $total->e_cob_redbull; ?></td>
                      <td class="bg-gris"><?= $total->e_cupones; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>


           

            

            
            <!-- END TABLA -->
            <p class="premios ubuntu-bold">REVISA LA INFORMACIÓN DE LOS PREMIOS HACIENDO <a href="premios.pdf" target="_blank" class="irpdf">CLICK AQUÍ</a></p>
          </div>
          <div class="col-12 col-lg-2 d-flex justify-content-center align-items-center">
            <img src="assets/img/logo-redbull-v2.png" class="logo-redbull img-fluid is-desktop" alt="">
          </div>
          
        </div>
      
      
      <div class="space-80"></div>
      
      
    </main>

    <?php // include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
  </body>
</html>