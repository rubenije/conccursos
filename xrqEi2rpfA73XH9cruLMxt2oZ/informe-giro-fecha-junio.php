<?php 
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}
require_once(INCLUDE_PATH.'class/class.inputfilter.php');
require_once(INCLUDE_PATH.'class/inc.globals.php');
require_once(INCLUDE_PATH.'class/class.informe.php');
require_once(INCLUDE_PATH.'class/class.factura.php');

$objInforme = new informe();
$elements      =  $objInforme->getInformeGirosNew(6);

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Informe ONLINE</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-md-8 m-auto pt-4">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="informe.php">Almaceneros</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-md-center" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="informe.php">INICIO</a>
                  </li>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link" href="informe-ingreso.php">Ingresos</a>
                  </li>
                  -->
                  <li class="nav-item">
                    <a class="nav-link active" href="informe-giro.php">TODOS LOS GIROS</a>
                  </li>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link" href="informe-distrito.php">Distritos</a>
                  </li>
                  -->
                  <li class="nav-item">
                    <a class="nav-link" href="informe-premio.php">PREMIOS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="informe-configuracion.php">CONFIGURACIÓN</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>

    <div class="container-fluid pt-5">
      <div class="row">
        <div class="col-12 col-md-10 m-auto pt-4">
        <h4>Todos los giros de Junio <!-- <a href="#;" class="btn btn-primary float-end lg-vermas">Ver Más +</a></h4> -->
          <br><br>

          <div class="listado-ganadores">
            <table class="table table-striped" style="font-size: 12px;">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nombre Fantasía</th>
                  <th scope="col">Distrito</th>
                  <th scope="col">Factura</th>
                  <th scope="col">Fecha</th>
                  <th scope="col" class="text-center">Totales</th>
                  <th scope="col" class="text-center">Realizados</th>
                  <th scope="col" class="text-center">Saldo</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($elements as $key => $element) {

                  $usados = $objInforme->getGirosRealizadosByNumero($element->cliente_id, $element->fact_numero);
                 

                  $prev = $elements[$key - 1];
                  if( !is_null($prev)){
                    if($prev->fact_numero == $element->fact_numero && $prev->cliente_id == $element->cliente_id){
                      $element->fact_intento = ((int)$prev->fact_intento - (int)$usados);
                    }
                  }
                  $saldo = ((int)$element->fact_intento - (int)$usados);
                  
                  

                  if($usados > $element->fact_intento){
                    $usados = $element->fact_intento;
                    $saldo = 0;
                  }

                ?>
                <tr>
                  <td><?= $element->cliente_id; ?></td>
                  <td><?= $element->clie_nombre; ?></td>
                  <td><?= $element->clie_distrito; ?></td>
                  <td><?= $element->fact_numero; ?></td>
                  <td><?= $element->inte_fecha; ?></td>
                  

                  <td class="text-center"><?= $element->fact_intento; ?></td>
                  <td class="text-center"><?= $usados; ?></td>
                  <td class="text-center"><?= $saldo; ?></td>
                </tr>
                <?php 
                  } 
                ?>
              </tbody>
            </table>
          </div>
          <br>

        </div>
      </div>
      
  
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(".lg-vermas").on('click', function(){
          if($('.listado-ganadores').is(':hidden')) {
            $('.listado-ganadores').css('display', 'block');
            $(".lg-vermas").html('Ver Menos -');

          }else{
            $('.listado-ganadores').css('display', 'none'); 
            $(".lg-vermas").html('Ver Más +');
            
          }
        })
    </script>
  </body>
</html>