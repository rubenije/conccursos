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
  $table = "craft";
  $objIngreso = new ingreso();
  $objRegistro = new registro();
  if(isset($get['id']) && is_numeric($get['id'])){
    $registros  = $objRegistro->getVendedorByTableBySupervisorId($table, $get['id']);
    $total      = $objRegistro->getRegistroByTableById($table, $get['id']);
  }else{
    if($_SESSION['LOGIN_TIPO'] == 'VENDEDOR'){
        $registros  = $objRegistro->getVendedorByTableBySupervisorId($table, $_SESSION['LOGIN_SUPERVISOR_ID']);
        $total      = $objRegistro->getRegistroByTableById($table, $_SESSION['LOGIN_SUPERVISOR_ID']);
    }else{
        $registros  = $objRegistro->getVendedorByTableBySupervisorId($table, $_SESSION['LOGIN_ID']);
        $total      = $objRegistro->getRegistroByTableById($table, $_SESSION['LOGIN_ID']);
    }
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
            <?php if($registros){ ?>
            <div class="is-desktop">
              <table class="table table-spacing mx-auto">
                <thead>
                  <tr>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro borde" style="height: 60px;">
                          <div class="space-15"></div>
                          ID
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro borde" style="height: 60px;">
                          <div class="space-15"></div>
                          VENDEDOR
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-amarillo borde" style="height: 60px;"> 
                            <div class="space-15"></div>
                            <div class="text-small">INGRESOS</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-azul borde" style="height: 60px;"> 
                            <div class="space-10"></div>
                            <div class="text-small">CUMPLIMIENTO<br>DUO LN</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-rojo borde" style="height: 60px;"> 
                            <div class="space-10"></div>
                            <div class="text-small">CUMPLIMIENTO<br>TDP 500</div>
                        </div>
                      </th>
                      
                      <th scope="col" class="transparent">
                        <div class="titulo bg-amarillo borde" style="height: 60px;"> 
                            <div class="space-10"></div>
                            <div class="text-small">CUMPLIMIENTO<br>GUAYACAN 500</div>
                        </div>
                      </th>
                      
                      <th scope="col" class="transparent">
                        <div class="titulo bg-rojo borde" style="height: 60px;padding-top: 10px;">

                          <div class="text-small">
                            FALTANTES<br>
                            <p class="fw-light mt-1">Revisa el estado<br>de tus clientes</p></div>
                        </div>
                      </th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      $totIngresos = 0;
                      foreach ($registros as $registro) { 
                      $ingresos = $objIngreso->getIngresosByClienteId($registro->id);
                    ?>
                    <tr>
                      <td width="50" class="text-start txt-verde-oscuro"><?= $registro->id; ?></td>
                      <td width="200" class="text-start txt-verde-oscuro"><?= $registro->nombre; ?></td>
                      <td width="80" class="txt-amarillo"><?= $ingresos; ?></td>
                      <td width="100" class="txt-azul"><?= $registro->CUMPLIMIENTO_DUO_LN; ?></td>
                      <td width="120" class="txt-rojo"><?= $registro->CUMPLIMIENTO_TORRES; ?></td>
                      <td width="100" class="txt-amarillo"><?= $registro->CUMPLIMIENTO_GUAYACAN; ?></td>
                      <td width="120"><a href="<?= $table; ?>-cliente.php?id=<?= $registro->id; ?>&tipo=vendedor" class="txt-rojo"><span class="badge bg-danger">Click Aquí</span></a></td>
                    </tr>
                    <?php 
                      $totIngresos += $ingresos;
                    } ?>
                    
                    <?php if($total){ ?>
                    <tr class="transparent">
                      <td colspan="2" class="text-start bg-verde-oscuro">Total General Distrito</td>
                      <td class="bg-amarillo"><?= $totIngresos; ?></td>
                      <td class="bg-azul"><?= $total->CUMPLIMIENTO_DUO_LN; ?></td>
                      <td class="bg-rojo"><?= $total->CUMPLIMIENTO_TORRES; ?></td>
                      <td class="bg-amarillo"><?= $total->CUMPLIMIENTO_GUAYACAN; ?></td>
                      <td class="bg-rojo">&nbsp;</td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
            
            


            <!-- SM -->
            <div class="is-mobile">
            
                <div class="table-responsive d-flex justify-content-center align-items-center"> 
                <table class="table table-spacing w-auto">
                <thead>
                  <tr>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro borde">
                          <div class="space-5"></div>
                          <div class="text-small">ID</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro borde">
                          <div class="space-5"></div>
                          <div class="text-small">VENDEDOR</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-amarillo borde"> 
                          <div class="space-5"></div>
                          <div class="text-small">Ingresos</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-azul borde">
                            <div class="text-small">Cump<br>Duo</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-rojo borde">
                          <div class="text-small">Cump<br>TDP</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-amarillo borde">
                          <div class="text-small">Cump<br>Guayacan</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent" >
                        <div class="titulo bg-rojo borde"> 
                          <div class="space-5"></div>
                          <div class="text-small">Faltantes</div>
                        </div>
                      </th>
                      
                  </tr>
                </thead>
                <tbody style="vertical-align: middle !important;">
                    <?php 
                      $totIngresos = 0;
                      foreach ($registros as $registro) { 
                      $ingresos = $objIngreso->getIngresosByClienteId($registro->id);    
                    ?>
                    <tr>
                      <td class="text-start txt-verde-oscuro"><?= $registro->id; ?></td>
                      <td class="text-start txt-verde-oscuro"><?= $registro->nombre; ?></td>
                      <td class="txt-amarillo"><?= $ingresos; ?></td>
                      <td class="txt-azul"><?= $registro->CUMPLIMIENTO_DUO_LN; ?></td>
                      <td class="txt-rojo"><?= $registro->CUMPLIMIENTO_TORRES; ?></td>
                      <td class="txt-amarillo"><?= $registro->CUMPLIMIENTO_GUAYACAN; ?></td>
                      <td ><a href="<?= $table; ?>-cliente.php?id=<?= $registro->id; ?>&tipo=vendedor" class="txt-rojo"><span class="badge bg-danger">Click Aquí</span></a></td>
                    </tr>
                    <?php 
                      $totIngresos += $ingresos;
                      } ?>
                    
                    <?php if($total){ ?>
                    <tr class="transparent">
                      <td colspan="2" class="text-start bg-verde-oscuro">Total General</td>
                      <td class="bg-amarillo"><?= $totIngresos; ?></td>
                      <td class="bg-azul"><?= $total->CUMPLIMIENTO_DUO_LN; ?></td>
                      <td class="bg-rojo"><?= $total->CUMPLIMIENTO_TORRES; ?></td>
                      <td class="bg-amarillo"><?= $total->CUMPLIMIENTO_GUAYACAN; ?></td>
                      <td class="bg-rojo"><!-- <?= $total->CUANTOS_FALTAN; ?>--></td>
                    </tr>
                    <?php } ?>
                    <tr class="transparent">
                      <td colspan="6" class="transparent" style="border: none;"></td>
                      <td class="bg-rojo">
                        <div class="text-small">
                          Haz click y revisa el estado de tus clientes
                        </div>
                      </td>
                      
                    </tr>
                </tbody>
              </table>
              </div>
            </div>
            <!-- SM -->
             


            <!-- END TABLA -->
            <p class="premios ubuntu-bold">REVISA LA INFORMACIÓN DE LOS PREMIOS HACIENDO <a href="premios.pdf" target="_blank" class="irpdf">CLICK AQUÍ</a></p>
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