<?php 
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}
require_once(INCLUDE_PATH.'class/class.inputfilter.php');
require_once(INCLUDE_PATH.'class/inc.globals.php');
require_once(INCLUDE_PATH.'class/class.informe.php');

$objInforme = new informe();
$icu        =  $objInforme->getIngresoClientesUnicos();
$ict        = $objInforme->getIngresoClientesTotales();
$cgu        = $objInforme->getCantidadGirosUnicos();
$igt        = (int) $objInforme->getIngresoGirosTotales();
$giros      = $objInforme->getGirosByDia();
$distritos  = $objInforme->getDistritosIntento();
$ingresos   = $objInforme->getIngresosByDia();
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
                    <a class="nav-link active" href="informe.php">INICIO</a>
                  </li>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link" href="informe-ingreso.php">Ingresos</a>
                  </li>
                  -->
                  <li class="nav-item">
                    <a class="nav-link" href="informe-giro.php">TODOS LOS GIROS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="informe-canje.php">FORMULARIO DE CANJE</a>
                  </li>
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
        <div class="col-12 col-md-8 m-auto pt-4">
          <h4>Resumen Totales</h4>
          <?php 
            
          ?>
          <table class="table table-striped" style="font-size: 12px;">
            <tbody>
              <tr>
                <td>Ingreso clientes únicos</td>
                <td class="text-center"><?= $icu; ?></td>
                <!-- <td class="text-center"><a href="informe-cliente.php" class="btn btn-dark btn-sm">Ver</a></td> -->
              </tr>
              <tr>
                <td>Ingreso clientes totales</td>
                <td class="text-center"><?= $ict; ?></td>
                <!-- <td class="text-center"><a href="informe-cliente.php" class="btn btn-dark btn-sm">Ver</a></td> -->
              </tr>
              <tr>
                <td>Cantidad giros únicos</td>
                <td class="text-center"><?= $cgu; ?></td>
                <!-- <td class="text-center"><a href="informe-giro.php" class="btn btn-dark btn-sm">Ver</a></td> -->
              </tr>
              <tr>
                <td>Cantidad giros totales</td>
                <td class="text-center"><?= $igt; ?></td>
                <!-- <td class="text-center"><a href="informe-giro.php" class="btn btn-dark btn-sm">Ver</a></td> -->
              </tr>
              
              
            </tbody>
          </table>
          <br>
          <br>
          <h4>Informe Vendedores</h4>
          <table class="table table-striped" style="font-size: 12px;">
            <tbody>
              <tr>
                <td>Mes Junio</td>
                <td class="text-center"><a href="informe-giro-fecha-junio.php" class="btn btn-primary">Ver</a></td>
              </tr>
              <tr>
                <td>Mes Julio</td>
                <td class="text-center"><a href="informe-giro-fecha-julio.php" class="btn btn-primary">Ver</a></td>
              </tr>
              <tr>
                <td>Ganadores</td>
                <td class="text-center"><a href="informe-ganadores.php" class="btn btn-primary">Ver</a></td>
              </tr>
              
              
              
            </tbody>
          </table>
          <br>
          <br>

          <h4>Distritos Totales <a href="#;" class="btn btn-primary float-end dt-vermas">Ver Más +</a></h4>
          <br>
          <div class="distritos-totales" style="display:none;">
            <table class="table table-striped" style="font-size: 12px;">
              <thead>
                <tr>
                  <th scope="col" style="width:60%;">Distrito</th>
                  <th scope="col" style="width:20%;" class="text-center">Únicos</th>
                  <th scope="col" style="width:20%;" class="text-center">Totales</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($distritos){ 
                  foreach($distritos as $distrito){ 
                    $du = $objInforme->getIngresosUnicosByDistrito($distrito->clie_distrito);
                    $dt = $objInforme->getIngresosTotalesByDistrito($distrito->clie_distrito);
                    $dlabel[]   = substr($distrito->clie_distrito,0,10);
                    $dunicos[] = $du;
                    $dtotales[] = $dt;
                      
                ?>
                <tr>
                  <td><?php echo $distrito->clie_distrito; ?></td>
                  <td class="text-center"><?= $du; ?></td>
                  <td class="text-center"><?= $dt; ?></td>
                  
                </tr>
                <?php 
                  }
                } ?>
              </tbody>
            </table>
          </div>
          <canvas id="myChartDistritos" width="600" height="400"></canvas>
          <br>
          <br>
          <h4>Giros totales por día <a href="#;" class="btn btn-primary float-end gt-vermas">Ver Más +</a></h4>
          <br>
          <div class="giros-totales" style="display:none;">
            <table class="table table-striped" style="font-size: 12px;">
              <thead>
                <tr>
                  <th scope="col" style="width:60%;">Fecha</th>
                  <th scope="col" style="width:20%;" class="text-center">Únicos</th>
                  <th scope="col" style="width:20%;" class="text-center">Totales</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($giros as $giro) { 
                  $unico = $objInforme->getCantidadGirosUnicosByFecha($giro->inte_fecha);
                  $totalU+= $unico;
                  $totalT+= $giro->cantidad;

                  $gnombre[]  = $giro->inte_fecha;
                  $gunicos[]  = $unico;
                  $gtotales[] = $giro->cantidad;
                ?>
                <tr>
                  <td><?php echo sql2date($giro->inte_fecha); ?></td>
                  <td class="text-center"><?= $unico; ?></td>
                  <td class="text-center"><?= $giro->cantidad; ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td></td>
                  <td class="text-center"><strong><?= $totalU; ?></strong></td>
                  <td class="text-center"><strong><?= $totalT; ?></strong></td>
                </tr>
              </tbody>
            </table>
          </div>
           <canvas id="GirosTotalesDiarios" width="600" height="400"></canvas>
          <br>
          

          <br>
          <br>
          <!-- 
          <h4>Cantidad de giros únicos por día</h4>
          <table class="table table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                <th scope="col" style="width:60%;">Fecha</th>
                <th scope="col" style="width:20%;" class="text-center">Únicos</th>
                <th scope="col" style="width:20%;" class="text-center">Totales</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ingresos as $ingreso) { 
                $unico = $objInforme->getCantidadIngresosUnicosByFecha($ingreso->ingr_fecha);
                $totalU+= $unico;
                $totalT+= $ingreso->cantidad;

                $inombre[]  = $ingreso->ingr_fecha;
                $iunicos[]  = $unico;
                $itotales[] = $ingreso->cantidad;
              ?>
              <tr>
                <td><?php echo sql2date($ingreso->ingr_fecha); ?></td>
                <td class="text-center"><?= $unico; ?></td>
                <td class="text-center"><?= $ingreso->cantidad; ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td></td>
                <td class="text-center"><strong><?= $totalU; ?></strong></td>
                <td class="text-center"><strong><?= $totalT; ?></strong></td>
              </tr>
            </tbody>
          </table>
          <canvas id="IngresosTotalesDiarios" width="600" height="400"></canvas>
          <br>
          -->

          

        </div>
      </div>
      
  
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
  	var chartColors = {
      red: 'rgb(255, 99, 132)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: 'rgb(75, 192, 192)',
      blue: 'rgb(54, 162, 235)',
      purple: 'rgb(153, 102, 255)',
      grey: 'rgb(231,233,237)'
    };

    var ctx = document.getElementById("myChartDistritos").getContext("2d");

    var data = {
        labels: <?php echo json_encode($dlabel); ?>,
        datasets: [
            {
                label: "Únicos",
                backgroundColor: chartColors.green,
                data: <?php echo json_encode($dunicos); ?>
            },
            {
                label: "Totales",
                backgroundColor: chartColors.red,
                data: <?php echo json_encode($dtotales); ?>
            },
               
        ]
    };

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            barValueSpacing: 20,
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                    }
                }]
            }
        }
    });
    


    /* GIROS X DIA  */
    var config = {
      type: 'line',
      data: {
        labels: <?php echo json_encode($gnombre); ?>,
        datasets: [{
          label: "Únicos",
          backgroundColor: chartColors.orange,
          borderColor: chartColors.orange,
          data: <?php echo json_encode($gunicos); ?>,
          fill: false,
        }, {
          label: "Totales",
          fill: false,
          backgroundColor: chartColors.green,
          borderColor: chartColors.green,
          data: <?php echo json_encode($gtotales); ?>,
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Resumen Giros Diarios'
        },
        tooltips: {
          mode: 'label',
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Fecha'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Giros'
            }
          }]
        }
      }
    };


    var ctx = document.getElementById("GirosTotalesDiarios").getContext("2d");
    window.myLine = new Chart(ctx, config);



    /* Ingresos X DIA  */
    /*

    var config = {
      type: 'line',
      data: {
        labels: <?php echo json_encode($inombre); ?>,
        datasets: [{
          label: "Únicos",
          backgroundColor: chartColors.orange,
          borderColor: chartColors.orange,
          data: <?php echo json_encode($iunicos); ?>,
          fill: false,
        }, {
          label: "Totales",
          fill: false,
          backgroundColor: chartColors.green,
          borderColor: chartColors.green,
          data: <?php echo json_encode($itotales); ?>,
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Resumen Ingresos Diarios'
        },
        tooltips: {
          mode: 'label',
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Fecha'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Ingresos'
            }
          }]
        }
      }
    };


    var cti = document.getElementById("IngresosTotalesDiarios").getContext("2d");
    window.myLine = new Chart(cti, config);
    */

    $(".dt-vermas").on('click', function(){
      if($('.distritos-totales').is(':hidden')) {
        $('.distritos-totales').css('display', 'block');
        $(".dt-vermas").html('Ver Menos -');

      }else{
        $('.distritos-totales').css('display', 'none'); 
        $(".dt-vermas").html('Ver Más +');
        
      }

    })


    $(".gt-vermas").on('click', function(){
      if($('.giros-totales').is(':hidden')) {
        $('.giros-totales').css('display', 'block');
        $(".gt-vermas").html('Ver Menos -');

      }else{
        $('.giros-totales').css('display', 'none'); 
        $(".gt-vermas").html('Ver Más +');
        
      }

    })
    </script>

  </body>
</html>