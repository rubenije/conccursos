<?php   
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', 'xrqEi2rpfA73XH9cruLMxt2oZ/');
    }
    $time = date('His');
    require_once(INCLUDE_PATH.'class/class.inputfilter.php');
    require_once(INCLUDE_PATH.'class/class.master.php');
    require_once(INCLUDE_PATH.'class/class.registro.php');
  
    session_start();
    $objRegistro = new registro();
  
    if(isset($get['opc']) && $get['opc'] == 'bypass'){
        $objMaster   = new master();
        $autenticate  = $objMaster->autenticate($get['id']);
        
        if($autenticate){
            header("Location: home.php");
            exit;
        }else{
            $error = true;
        }
        
    }

    $objRegistro = new registro();
    $registros = $objRegistro->getRegistroDataAllNew();
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <?php //pre($registros[0]); ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Tipo</th>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">m_cob<br>conj</th>
                                <th scope="col">m_cob<br>conc</th>
                                <th scope="col">m_cob<br>nec</th>
                                <th scope="col">m_cob<br>nec_conc</th>
                                <th scope="col">m_cupones</th>
                                <th scope="col">e_cob<br>conj</th>
                                <th scope="col">e_cob<br>conc</th>
                                <th scope="col">e_cob<br>rb</th>
                                <th scope="col">e_cob<br>rb_conc</th>
                                <th scope="col">e_cupones</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">Distrito</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($registros as $registro){ ?>
                            <tr>
                                <th scope="row">
                                    <a href="?opc=bypass&id=<?= $registro->id; ?>&tipo=<?= $registro->tipo; ?>">
                                        <?= $registro->tipo; ?>
                                    </a>    
                                </th>
                                <td><?= $registro->id; ?></td>
                                <td><?= $registro->nombre; ?></td>
                                <td><?= $registro->m_cob_conjunta; ?></td>
                                <td><?= $registro->m_cob_concretar; ?></td>
                                <td><?= $registro->m_cob_nectar; ?></td>
                                <td><?= $registro->m_cob_nectar_concretar; ?></td>
                                <td><?= $registro->m_cupones; ?></td>
                                <td><?= $registro->e_cob_conjunta; ?></td>
                                <td><?= $registro->e_cob_concretar; ?></td>
                                <td><?= $registro->e_cob_redbull; ?></td>
                                <td><?= $registro->e_cob_rebull_concretar; ?></td>
                                <td><?= $registro->e_cupones; ?></td>
                                <td><?= $registro->supervisor_id; ?></td>
                                <td><?= $registro->distrito; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                
                </div>
            </div>
        </div>
        

      <div class="space-80"></div>
      <div class="space-80"></div>
      
      
    </main>

    <?php include("include-footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/main.js?<?= $time; ?>"></script>
  </body>
</html>