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
    $registros  = $objRegistro->getVendedorBySupervisorId($get['id']);
    $total      = $objRegistro->getRegistroById($get['id']);
  }else{
    if($_SESSION['LOGIN_TIPO'] == 'VENDEDOR'){
        $registros  = $objRegistro->getVendedorBySupervisorId($_SESSION['LOGIN_SUPERVISOR_ID']);
        $total      = $objRegistro->getRegistroById($_SESSION['LOGIN_SUPERVISOR_ID']);
    }else{
        $registros  = $objRegistro->getVendedorBySupervisorId($_SESSION['LOGIN_ID']);
        $total      = $objRegistro->getRegistroById($_SESSION['LOGIN_ID']);
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
            <?php if($registros){ ?>
            <div class="is-desktop">
              <table class="table table-spacing mx-auto">
                <thead>
                  <tr>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro">
                          <div class="space-10"></div>
                          ID
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro">
                          <div class="space-10"></div>
                          VENDEDOR
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-rojo-oscuro borde" style="height: 85px;padding-top: 0px;">
                          <img src="assets/img/botella-cc.png" class="botella-cc" alt="Botella Cobertura Conjunta">
                          <div class="titulo">
                            <div class="space-15"></div>
                            <div class="text-small">Cobertura Conjunta</div>
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-rojo-oscuro borde" style="height: 85px;padding-top: 10px;">
                          <div class="text-small">HAZ <strong>CLIC</strong> Y<br>REVISA TUS<br>CLIENTES POR<br>CONCRETAR<br>COB.CONJUNTA</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-verde borde" style="height: 85px;padding-top: 0px;"> 
                          <img src="assets/img/botella-cn.png" class="botella-cn" alt="Botella Cobertura Nectar">
                          <div class="titulo">
                            <div class="space-15"></div>
                            <div class="text-small">Cobertura Néctar</div>
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent" >
                        <div class="bg-verde borde" style="height: 85px;padding-top: 10px;"> 
                          <div class="text-small">HAZ <strong>CLIC</strong> Y<br>REVISA TUS<br>CLIENTES POR<br>CONCRETAR<br>COB. NECTAR</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro">
                          <div class="space-10"></div>
                          Cupones
                        </div>
                      </th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registro) { ?>
                    <tr>
                      <td class="text-start txt-verde-oscuro"><?= $registro->id; ?></td>
                      <td class="text-start txt-verde-oscuro"><?= $registro->nombre; ?></td>
                      <td class="txt-rojo"><?= $registro->m_cob_conjunta; ?></td>
                      <td ><a href="minions-cliente.php?id=<?= $registro->id; ?>&tipo=vendedor" class="txt-rojo"><?= $registro->m_cob_concretar; ?></a></td>
                      <td class="txt-verde"><?= $registro->m_cob_nectar; ?></td>
                      <td ><a href="minions-cliente-nectar.php?id=<?= $registro->id; ?>&tipo=vendedor" class="txt-verde"><?= $registro->m_cob_nectar_concretar; ?></a></td>
                      <td class="txt-verde-oscuro fw-bold"><?= $registro->m_cupones; ?></td>
                    </tr>
                    <?php } ?>
                    
                    <?php if($total){ ?>
                    <tr class="transparent">
                      <td class="transparent" style="border: none;"></td>
                      <td class="text-start bg-verde-oscuro">Total General</td>
                      <td class="bg-rojo-oscuro"><?= $total->m_cob_conjunta; ?></td>
                      <td class="bg-rojo-oscuro"><?= $total->m_cob_concretar; ?></td>
                      <td class="bg-verde"><?= $total->m_cob_nectar; ?></td>
                      <td class="bg-verde"><?= $total->m_cob_nectar_concretar; ?></td>
                      <td class="bg-verde-oscuro"><?= $total->m_cupones; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
            
            


            <!-- SM -->
            <div class="is-mobile">
            
                <div class="table-responsive d-flex justify-content-center"> 
                <table class="table table-spacing w-auto">
                <thead>
                  <tr>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro" style="height: 60px;">
                          <div class="space-15"></div>
                          ID
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro" style="height: 60px;">
                          <div class="space-15"></div>
                          VENDEDOR
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-rojo-oscuro borde" style="height: 60px;">
                          <div class="titulo">
                            <div class="space-10"></div>
                            <div class="text-small">Cobertura<br>Conjunta</div>
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-rojo-oscuro borde" style="height: 60px;">
                          <div class="space-5"></div>
                          <div class="text-xsmall">Clientes por concretar cob. conjunta</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="bg-verde borde" style="height: 60px;"> 
                          <div class="titulo">
                            <div class="space-10"></div>
                            <div class="text-small">Cobertura<br>Nectar</div>
                          </div>
                        </div>
                      </th>
                      <th scope="col" class="transparent" >
                        <div class="bg-verde borde" style="height: 60px;"> 
                          <div class="space-5"></div>
                          <div class="text-xsmall">Clientes por concretar cob. Nectar</div>
                        </div>
                      </th>
                      <th scope="col" class="transparent">
                        <div class="titulo bg-verde-oscuro" style="height: 60px;">
                          <div class="space-15"></div>
                          Cupones
                        </div>
                      </th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registro) { ?>
                    <tr>
                      <td class="text-start txt-verde-oscuro"><?= $registro->id; ?></td>
                      <td class="text-start txt-verde-oscuro"><?= $registro->nombre; ?></td>
                      <td class="txt-rojo"><?= $registro->m_cob_conjunta; ?></td>
                      <td ><a href="minions-cliente.php?id=<?= $registro->id; ?>&tipo=vendedor" class="txt-rojo"><?= $registro->m_cob_concretar; ?></a></td>
                      <td class="txt-verde"><?= $registro->m_cob_nectar; ?></td>
                      <td ><a href="minions-cliente-nectar.php?id=<?= $registro->id; ?>&tipo=vendedor" class="txt-verde"><?= $registro->m_cob_nectar_concretar; ?></a></td>
                      <td class="txt-verde-oscuro fw-bold"><?= $registro->m_cupones; ?></td>
                    </tr>
                    <?php } ?>
                    
                    <?php if($total){ ?>
                    <tr class="transparent">
                      <td class="transparent" style="border: none;"></td>
                      <td class="text-start bg-verde-oscuro">Total General</td>
                      <td class="bg-rojo-oscuro"><?= $total->m_cob_conjunta; ?></td>
                      <td class="bg-rojo-oscuro"><?= $total->m_cob_concretar; ?></td>
                      <td class="bg-verde"><?= $total->m_cob_nectar; ?></td>
                      <td class="bg-verde"><?= $total->m_cob_nectar_concretar; ?></td>
                      <td class="bg-verde-oscuro"><?= $total->m_cupones; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
              </div>
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