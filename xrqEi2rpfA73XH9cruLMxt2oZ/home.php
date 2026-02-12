<?php
    error_reporting(0); 
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', '');
    }
    include_once(INCLUDE_PATH.'class/class.home.php');
    include_once(INCLUDE_PATH.'class/class.registro.php');
    
    /*
    $registro   = new registro();
    $total      = $registro->getTotal();
    $total7     = $registro->getTotal(7);
    $total15    = $registro->getTotal(15);
    $total1M    = $registro->getTotal(1);

    $producto   = new producto();
    $productos  = $producto->getProductoPublicAll();
    */

    $total   = 0;
    $total7  = 0;
    $total15 = 0;
    $total1M = 0;

?>
<!DOCTYPE html>
<html>
<head>
    <?php include("include_head.php"); ?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>

    <div id="wrapper">
    <?php include("include_menu.php"); ?>
    <div id="page-wrapper" class="gray-bg">
    <?php include("include_top.php"); ?>
            
        <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5 class="text-success">Total</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo numberFormat($total); ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5 class="text-info">Ultimo día</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo numberFormat($total7); ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5 class="text-navy">Ultimos 7 días</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo numberFormat($total15); ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5 class="text-danger">Ultimo Mes</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo numberFormat($total1M); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Listar Participantes</h5>
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal" method="POST" action="registro.php" autocomplete="on">
                                    <input name="opc" type="hidden" value="sendFilter">
                                    <div class="form-group"><label class="col-lg-3 control-label">Código</label>
                                        <div class="col-lg-9"><input type="text" placeholder="G4NHAAA" autocomplete="off" name="codi_nombre" class="form-control"></div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-3 control-label">RUT</label>
                                        <div class="col-lg-9"><input type="text" placeholder="21071926-1" autocomplete="off" name="regi_rut" class="form-control"></div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-3 control-label">Nombre</label>
                                        <div class="col-lg-9"><input type="text" placeholder="Nombre" autocomplete="off" name="regi_nombre" class="form-control"></div>
                                    </div>
                                     <div class="form-group"><label class="col-lg-3 control-label">Apellido</label>
                                        <div class="col-lg-9"><input type="text" placeholder="Apellido" autocomplete="off" name="regi_apellido" class="form-control"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Filtrar Participantes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Exportar Participantes</h5>
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal" method="POST" action="xls.php" autocomplete="on">
                                    <input name="opc" type="hidden" value="sendExport">
                                    <div class="form-group"><label class="col-lg-3 control-label">Desde</label>
                                        <div class="col-lg-9"><input type="text" placeholder="Fecha Desde" autocomplete="off" name="fecha_desde" class="form-control date" required></div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-3 control-label">Hasta</label>
                                        <div class="col-lg-9"><input type="text" placeholder="Fecha Hasta" autocomplete="off" name="fecha_hasta" class="form-control date" required></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Exportar Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Buscar Código</h5>
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal" method="POST" action="codigo.php" autocomplete="on">
                                    <input name="opc" type="hidden" value="sendFilter">
                                    <div class="form-group"><label class="col-lg-3 control-label">Código</label>
                                        <div class="col-lg-9"><input type="text" placeholder="" autocomplete="off" name="codi_nombre" class="form-control" required></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Buscar Código</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

               
            </div>
            </div>
        </div>
        

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">
    $( function() {
        $( ".date" ).datepicker({
            dateFormat: 'dd/mm/yy',
        });
    } );
    </script>

    <!-- Page-Level Scripts -->
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