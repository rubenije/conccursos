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
    header('Location: index.php');
    exit;
  }
  $table = "bep";
  $objIngreso = new ingreso();
  $objRegistro = new registro();
  if(isset($get['id']) && is_numeric($get['id'])){
    $registros  = $objRegistro->getJefeDeVentaByTableBySupervisorId($table, $get['id']);
    $total   = $objRegistro->getDistritoByTableById($table, $get['id']);
  }else{
    $registros  = $objRegistro->getJefeDeVentaByTableBySupervisorId($table, $_SESSION['LOGIN_SUPERVISOR_ID']);
    $total   = $objRegistro->getDistritoByTableById($table, $_SESSION['LOGIN_SUPERVISOR_ID']);
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
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-2 text-center is-desktop">
            <?php //include("include-izquierda.php"); ?>
          </div>
          <div class="col-12 col-lg-8 text-center">
            <!-- INI TABLA -->
            <div class="space-20"></div>
            <div class="is-desktop">
            
            <table class="table table-spacing mx-auto">
              <thead>
                <tr>
                    <th scope="col" class="transparent">
                      <div class="titulo bg-verde-oscuro borde">
                        <div class="space-10"></div>
                        ID
                      </div>
                    </th>
                    <th scope="col" class="transparent">
                      <div class="titulo bg-verde-oscuro borde">
                        <div class="space-10"></div>
                          JDV
                      </div>
                    </th>
                    <th scope="col" class="transparent">
                        <div class="titulo bg-amarillo borde"> 
                            <div class="space-10"></div>
                            <div class="text-small">INGRESOS</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-azul borde"> 
                            <div class="space-5"></div>
                            <div class="text-small">CUMPLIMIENTO<br>BEP</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-celeste borde"> 
                            <div class="space-5"></div>
                            <div class="text-small">VOLUMEN<br>VS AA</div>
                        </div>
                      </th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $totIngresos = 0;
                foreach($registros as $registro){ 
                  $ingresos = $objIngreso->getIngresosBySupervisorId($registro->id);

                  ?> 
                 <tr>
                    <td width="50" class="text-start txt-verde-oscuro"><?= $registro->id; ?></td>
                    <td width="250" class="text-start"><a href="<?= $table; ?>-vendedor.php?id=<?= $registro->id; ?>" class="txt-verde-oscuro"><?= $registro->nombre; ?></a></td>
                    <td width="100" class="txt-amarillo"><?= $ingresos; ?></td>
                    <td width="150" class="txt-azul"><?= $registro->CUMPLIMIENTO_BEP; ?></td>
                    <td width="150" class="txt-celeste"><?= $registro->CUMPLIMIENTO_BEP_VOL; ?></td>
                  </tr>
                  <?php 
                  $totIngresos += $ingresos;
                  } ?>
                  <?php if($total){ ?>
                  <tr class="transparent">
                    <td colspan="2" class="text-start bg-verde-oscuro">Total General</td>
                    <td class="bg-amarillo"><?= $totIngresos; ?></td>
                    <td class="bg-azul"><?= $total->CUMPLIMIENTO_BEP; ?></td>
                    <td class="bg-celeste"><?= $total->CUMPLIMIENTO_BEP_VOL; ?></td>
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
            </div>


            <!-- SM --> 
            <div class="table-responsive d-flex justify-content-center"> 
              <table class="table is-mobile w-auto" style="vertical-align: middle;">
            <thead>
              <tr>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-verde-oscuro borde" style="height: 60px;">
                      <div class="space-20"></div>
                      ID
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-verde-oscuro borde" style="height: 60px;">
                      <div class="space-20"></div>
                      JDV
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-amarillo borde" style="height: 60px;padding-top: 0px;"> 
                        <div class="space-20"></div>
                        <div class="text-small">INGRESOS</div>
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-azul borde" style="height: 60px;padding-top: 0px;"> 
                        <div class="text-small">CUMP<br>BEP</div>
                    </div>
                  </th>
                  <th scope="col" class="transparent">
                    <div class="titulo bg-celeste borde" style="height: 60px;padding-top: 0px;"> 
                        <div class="text-small">VOL<br>VS AA</div>
                    </div>
                  </th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $totIngresos = 0;
                foreach($registros as $registro){ 
                $ingresos = $objIngreso->getIngresosBySupervisorId($registro->id);    
                ?> 
                <tr>
                  <td class="text-start txt-verde-oscuro"><?= $registro->id; ?></td>
                  <td class="text-start"><a href="<?= $table; ?>-vendedor.php?id=<?= $registro->id; ?>" class="txt-verde-oscuro"><?= $registro->nombre; ?></a></td>
                  <td class="txt-amarillo"><?= $ingresos; ?></td>
                  <td class="txt-azul"><?= $registro->CUMPLIMIENTO_BEP; ?></td>
                  <td class="txt-celeste"><?= $registro->CUMPLIMIENTO_BEP_VOL; ?></td>
                </tr>
                <?php 
                $totIngresos += $ingresos;
                } ?>
                <?php if($total){ ?>
                <tr class="transparent">
                  <td colspan="2" class="text-start bg-verde-oscuro">Total General</td>
                  <td class="bg-amarillo"><?= $totIngresos; ?></td>
                  <td class="bg-azul"><?= $total->CUMPLIMIENTO_BEP; ?></td>
                  <td class="bg-celeste"><?= $total->CUMPLIMIENTO_BEP_VOL; ?></td>
                </tr>
                <?php } ?>
            </tbody>
          </table>
          </div>
            <!-- SM --> 
            
           

            

            
            <!-- END TABLA -->
            <p class="premios ubuntu-bold">REVISA LA INFORMACIÓN DE LOS PREMIOS HACIENDO <a href="assets/pdf/bep.pdf" target="_blank" class="irpdf">CLICK AQUÍ</a></p>
          </div>
          <div class="col-12 col-lg-2 text-center is-desktop">
            <?php //include("include-derecha.php"); ?>
          </div>
          
        </div>
      
      
      <div class="space-80"></div>
      
      
    </main>

    <?php include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
  </body>
</html>