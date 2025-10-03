<?php 
error_reporting(0);

if (!defined('INCLUDE_PATH')) {
    define('INCLUDE_PATH', '');
}
require_once(INCLUDE_PATH.'class/class.inputfilter.php');
require_once(INCLUDE_PATH.'class/inc.globals.php');
require_once(INCLUDE_PATH.'class/class.informe.php');

$objInforme = new informe();
$ganadores  = $objInforme->getListadoGanadoresFormulario();
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
                    <a class="nav-link" href="informe-giro.php">TODOS LOS GIROS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="informe-canje.php">FORMULARIO DE CANJE</a>
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
          <div class="col-12 col-md-10 m-auto pt-4">
            <h4>Formulario de Canje <a href="#;" class="btn btn-primary float-end lg-vermas">Ver Más +</a></h4>
            
            <div class="listado-ganadores" style="display:none;">
              <table class="table table-striped" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th scope="col">ID Premio</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">ID Cliente</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Premio</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">RUT</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Email</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Comuna</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($ganadores as $ganador) { ?>
                  <tr>
                    <td><?= $ganador->premio_id; ?></td>
                    <td><?= sql2date($ganador->prem_fecha); ?></td>
                    <td><?= $ganador->cliente_id; ?></td>
                    <td><?= $ganador->clie_nombre; ?></td>
                    <td><?= $ganador->prem_nombre; ?></td>
                    <td><?= $ganador->regi_nombre; ?></td>
                    <td><?= $ganador->regi_apellido; ?></td>
                    <td><?= $ganador->regi_rut; ?></td>
                    <td><?= $ganador->regi_telefono; ?></td>
                    <td><?= $ganador->regi_email; ?></td>
                    <td><?= $ganador->regi_direccion; ?></td>
                    <td><?= $ganador->comu_nombre; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <br>

          </div>
        </div>
      </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.js"></script>
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
    /*
    var chartColors = {
      red: 'rgb(255, 99, 132)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: 'rgb(75, 192, 192)',
      blue: 'rgb(54, 162, 235)',
      purple: 'rgb(153, 102, 255)',
      grey: 'rgb(231,233,237)'
    };

    var config = {
      type: 'line',
      data: {
        labels: <?php echo json_encode($gfechas); ?>,
        datasets: [{
          label: "Compras",
          backgroundColor: chartColors.orange,
          borderColor: chartColors.orange,
          data: <?php echo json_encode($gtdc); ?>,
          fill: false,
        }, {
          label: "Jumbo",
          fill: false,
          backgroundColor: chartColors.green,
          borderColor: chartColors.green,
          data: <?php echo json_encode($gtdj); ?>,
        }, {
          label: "Santa Isabel",
          fill: false,
          backgroundColor: chartColors.red,
          borderColor: chartColors.red,
          data: <?php echo json_encode($gtds); ?>,
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Resumen Totales x Día'
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


    var ctx = document.getElementById("totalxdia").getContext("2d");
    window.myLine = new Chart(ctx, config);


    var ctx = document.getElementById("myChart").getContext("2d");

    var data = {
        labels: <?php echo json_encode($glabel); ?>,
        datasets: [
            {
                label: "Totales",
                backgroundColor: chartColors.green,
                data: <?php echo json_encode($gtotales); ?>
            },
            {
                label: "Unicos",
                backgroundColor: chartColors.red,
                data: <?php echo json_encode($gunicos); ?>
            }
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
    */
    </script>

  </body>
</html>