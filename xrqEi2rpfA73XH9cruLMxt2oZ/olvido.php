<?php
    error_reporting(E_ALL & ~E_NOTICE); 
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', '');
    }
    require_once(INCLUDE_PATH.'class/class.inputfilter.php');
    require_once(INCLUDE_PATH.'class/class.usuario.php');
    session_start();
    $error  = false;
    $send   = false;
    if($post['opc'] == 'sendPass' && !empty($post['usua_email']) && is_string($post['usua_email'])){
        $usuario        = new usuario();
        $autenticate    = $usuario->sendEmailBack($post['usua_email']);
        if($autenticate){
            $send = true;
        }else{
            $error = true;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("include_head.php"); ?>
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">TF+</h1>
            </div>
            <h3>¿Olvidaste tu Clave?</h3>
            <p>La herramienta perfecta que analiza, planifica y gestiona las rutas y flotas en tiempo real.
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>&nbsp;</p>
            <p>Ingresa tu email para recuperar la clave.</p>
            <form class="m-t" role="form" action="" method="post">
                <input type="hidden" name="opc" value="sendPass">
                <div class="form-group">
                    <input type="email" name="usua_email" class="form-control" placeholder="usuario@dominio.cl" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Recuperar</button>
                <a href="index.php"><small>Volver al inicio</small></a>
                <p class="text-muted text-center">&nbsp;</p>
                <br />
            </form>
            <p class="m-t"> <small>Powered by <a href="http://www.aconcreta.cl" target="_blank">Acción Concreta</a> &copy; 2014 - <?php echo date('Y'); ?></small> </p>
        </div>
    </div>
    <div class="modal inmodal fade" id="errorAutenticate" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Recuperar Clave</h4>
                </div>
                <div class="modal-body">
                    <p>El correo <strong><?php echo $post['usua_email']; ?></strong> no se encuentra en nuestros registros, intente nuevamente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="sendEmail" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Recuperar Clave</h4>
                </div>
                <div class="modal-body">
                    <p>Se ha enviado un email al correo <strong><?php echo $post['usua_email']; ?></strong> con los datos de acceso.</p>
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
    <script type="text/javascript">
    $(document).ready(function(){
        <?php if($error){ ?>
        $('#errorAutenticate').modal('show');
        <?php } ?>
        <?php if($send){ ?>
        $('#sendEmail').modal('show');
        <?php } ?>
    })
    </script>
</body>
</html>