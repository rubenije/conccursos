<?php
    error_reporting(E_ALL & ~E_NOTICE); 
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', '');
    }
    include_once(INCLUDE_PATH.'class/class.home.php');
    include_once(INCLUDE_PATH.'class/class.registro.php');
    include_once(INCLUDE_PATH.'class/class.codigo.php');
    
    
    $registro  = new registro();

    /*
    if($get['opc'] == 'delete'){
        $registro->changeEstadoRegistro($get['registro_id']);

        $codigo = new codigo();
        $codigo->changeEstadoActivo($get['codi_nombre']);
    }
    */
    //pre($post);
    //exit;
    if($post['opc'] == 'sendFilter'){
         $elements   = $registro->getRegistroSearch($post);
    }else{
        //$elements   = $registro->getRegistroAll();
    }

    //pre($elements[0]);
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("include_head.php"); ?>

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">
    <?php include("include_menu.php"); ?>
    <div id="page-wrapper" class="gray-bg">
    <?php include("include_top.php"); ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Registro</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="home.php">Home</a>
                        </li>
                        <li class="active">
                            <strong>Registro</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-3">
                    <p>&nbsp;</p>
                    <!-- <a href="registro-add.php" class="btn btn-primary btn-lg">Agregar Registro</a> -->
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Registro</h5>
                    </div>
                    <div class="ibox-content">
                    <?php if($elements) { ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cupón</th>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Telefono</th>    
                        <th>Comuna</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($elements as $element) { ?>
                    <tr>
                        <td><?php echo $element->registro_id; ?></td>
                        <td><?php echo $element->codi_nombre; ?></td>
                        <td><?php echo $element->regi_rut; ?></td>
                        <td><?php echo $element->regi_nombre; ?> <?php echo $element->regi_apellido; ?></td>
                        <td><?php echo $element->regi_email; ?></td>
                        <td><?php echo $element->regi_telefono; ?></td>
                        <td><?php echo $element->comu_nombre; ?></td>
                        <td><small><?php echo $element->regi_fecha; ?><br><?php echo $element->regi_hora; ?></small></td>
                        <td><?php echo $element->regi_estado; ?></td>
                        <td><a href="?opc=delete&registro_id=<?php echo $element->registro_id; ?>&codi_nombre=<?php echo $element->codi_nombre; ?>"><button type="button" class="btn btn-danger btn-sm">Eliminar</button></a></td>
                    
                    </tr>
                    <?php } ?>
                    </tfoot>
                    </table>
                    <?php } ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <?php include("include_footer.php"); ?>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                "pageLength": 50,
                "language": {
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });
        });
    </script>
<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
</body>

</html>