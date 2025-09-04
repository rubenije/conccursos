<?php
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', '');
    }
    include_once(INCLUDE_PATH.'class/class.home.php');
    include_once(INCLUDE_PATH.'class/class.parametro.php');
    //Variables
    $id     = (int) $get['id'];
    $opc    = (!empty($get['id'])) ? "editar" : "ingresar";

    if(!empty($post) && is_array($post)){
        $parametro = new parametro();
        $parametro->saveParametroNewAll($post);
        echo "<script>window.location='parametro.php';</script>";
        exit;
    }
    $objParametro   = new parametro();
    $gruped         = $objParametro->getParametroAllGruped();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("include_head.php"); ?>
</head>
<body>
    <div id="wrapper">
    <?php include("include_menu.php"); ?> 
    <div id="page-wrapper" class="gray-bg">
    <?php include("include_top.php"); ?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Parametros</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="home.php">Home</a>
                        </li>
                        <li>
                            <a href="parametros.php">Parametros</a>
                        </li>
                        <li class="active">
                            <strong>Modificar Parametros</strong>
                        </li>
                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Modificar Parametros</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" class="form-horizontal" action="" enctype="multipart/form-data">
                            <?php foreach($gruped as $grupo){ 
                                    $datos          = $objParametro->getParametroAllByGrupo($grupo->para_grupo);
                            ?>
                            <h3><?php echo $grupo->para_grupo; ?></h3>
                                <?php foreach($datos as $para){ ?>
                                <div class="form-group"><label class="col-sm-4 control-label"><?php echo $para->para_nombre; ?></label>
                                    <div class="col-md-6">
                                        <?php echo $objParametro->getInputHTML($para); ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <?php } ?>
                            <br/><br/><br/>
                            <?php } ?>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <!-- <button class="btn btn-white" type="submit">Cancel</button>-->
                                    <button class="btn btn-primary btn-kt" type="submit">Guardar Cambios</button>
                                </div>
                            </div>
                        </form>
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

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js?<?php echo date('His'); ?>"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
</body>
</html>