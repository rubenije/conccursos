<?php
    //header("Location: https://concursoalmaceneros.aguamas.cl/");
    //exit;
    error_reporting(E_ALL & ~E_NOTICE); 
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', '');
    }
    require_once(INCLUDE_PATH.'class/class.inputfilter.php');
    require_once(INCLUDE_PATH.'class/class.usuario.php');
    session_start();
    if($get['opc'] == 'logout'){
        unset($_SESSION['PANEL']);
        unset($_SESSION['PANEL_USUARIO_ID']);
        unset($_SESSION['PANEL_USUA_NOMBRE']);
        unset($_SESSION['PANEL_USUA_CARGO']);
        unset($_SESSION['PANEL_USUA_EMAIL']);
        unset($_SESSION['PANEL_USUA_PERFIL']);
        unset($_SESSION['PANEL_USUA_IMAGEN']);
        unset($_SESSION['PANEL_USUA_FECHA']);

        header("Location: index.php");
        exit;
    }

    $error = false;
    if($post['opc'] == 'autenticateBack' && !empty($post['usua_user']) && !empty($post['usua_pass'])){
        $usuario        = new usuario();
        $autenticate    = $usuario->autenticateBack($post['usua_user'], $post['usua_pass']);
        if($autenticate){
            header("Location: home.php");
            exit;
        }else{
            $error = true;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("include_head.php"); ?>
    <link rel="stylesheet" href="css/plugins/supersized/supersized.css">
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name" style="font-size:150px">CCU</h1>
            </div>
            <h3>Bienvenido a Sabores CCU</h3>
            <p>La herramienta perfecta que analiza, planifica, gestiona los proyectos en tiempo real.</p>
            <p>&nbsp;</p>
            <p>Ingresa. Para verlo en acción.</p>
            <form class="m-t" role="form" action="index.php" method="post">
                <input type="hidden" name="opc" value="autenticateBack">
                <div class="form-group">
                    <input type="text" name="usua_user" class="form-control" placeholder="Usuario" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="usua_pass" class="form-control" placeholder="Contraseña" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>

                <a href="olvido.php"><small>¿Olvidaste tu Clave?</small></a>
                <p class="text-muted text-center">&nbsp;</p>
                <br />
            </form>
            <p class="m-t"> <small>Powered by <a href="http://www.posicionamientopro.cl" target="_blank" style="color: #5AAB35;"><strong>PosicionamientoPro Ltda.</strong></a> &copy; 2014 - <?php echo date('Y'); ?></small> </p>
        </div>
    </div>
    <div class="modal inmodal fade" id="errorAutenticate" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Error de Acceso</h4>
                </div>
                <div class="modal-body">
                    <p>Intente nuevamente ingresando sus datos.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/supersized/supersized.3.2.7.min.js"></script>
    <script type="text/javascript">
    jQuery(function($){

        $.supersized({

            // Functionality
            slide_interval     : 4000,    // Length between transitions
            transition         : 1,    // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
            transition_speed   : 1000,    // Speed of transition
            performance        : 1,    // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)

            // Size & Position
            min_width          : 0,    // Min width allowed (in pixels)
            min_height         : 0,    // Min height allowed (in pixels)
            vertical_center    : 1,    // Vertically center background
            horizontal_center  : 1,    // Horizontally center background
            fit_always         : 0,    // Image will never exceed browser width or height (Ignores min. dimensions)
            fit_portrait       : 1,    // Portrait images will not exceed browser height
            fit_landscape      : 0,    // Landscape images will not exceed browser width

            // Components
            slide_links        : 'blank',    // Individual links for each slide (Options: false, 'num', 'name', 'blank')
            slides             : [    // Slideshow Images
                                     {image : 'img/bg/bg-1.jpg'},
                                     {image : 'img/bg/bg-2.jpg'},
                                     {image : 'img/bg/bg-3.jpg'},
                                 ]

        });

    });
    </script>

    <?php if($error){ ?>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#errorAutenticate').modal('show');
    })
    </script>
    <?php } ?>
</body>
</html>