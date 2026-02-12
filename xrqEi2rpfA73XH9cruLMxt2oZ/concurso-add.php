<?php
    error_reporting(E_ALL & ~E_NOTICE); 
    if (!defined('INCLUDE_PATH')) {
        define('INCLUDE_PATH', '');
    }
    include_once(INCLUDE_PATH.'class/class.home.php');
    include_once(INCLUDE_PATH.'class/class.concurso.php');



    //Variables
    /*
    $concurso_id    = (int) $get['concurso_id'];
    $opc            = (!empty($get['concurso_id'])) ? "editar" : "ingresar";

    if($post['opc'] == "ingresar" || $post['opc'] == "editar"){
        $concurso = new concurso();
        $concurso->saveConcurso($post);
        echo "<script>window.location='concurso.php';</script>";
        exit;
    }

    $concurso   = new concurso();
    $objeto     = $concurso->getConcursoId($get['concurso_id']);
    */
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

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Concursos</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="home.php">Home</a>
                        </li>
                        <li>
                            <a href="concurso.php">Concursos</a>
                        </li>
                        <li class="active">
                            <strong>Agregar Concursos</strong>
                        </li>
                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Agregar Concurso</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" class="form-horizontal" action="" enctype="multipart/form-data" onsubmit="return validaHorizontal(this);">
                            <input type="hidden" name="concurso_id" value="<?php echo $concurso_id; ?>">
                            <input type="hidden" name="opc" value="<?php echo $opc; ?>">

                            <div class="form-group"><label class="col-sm-2 control-label">Grupo</label>
                                <div class="col-md-6"><input type="text" name="conc_grupo" class="form-control" value="<?php echo $objeto->conc_grupo; ?>" required></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label">Nombre</label>
                                <div class="col-md-6"><input type="text" name="conc_nombre" class="form-control" value="<?php echo $objeto->conc_nombre; ?>" required></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label">Fecha Inicio</label>
                                <div class="col-md-6"><input type="text" name="conc_inicio" class="form-control date" value="<?php echo $objeto->conc_inicio; ?>" required></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label">Fecha Termino</label>
                                <div class="col-md-6"><input type="text" name="conc_termino" class="form-control date" value="<?php echo $objeto->conc_termino; ?>" required></div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group"><label class="col-sm-2 control-label">Estado</label>
                                <div class="col-sm-10">
                                    <div class="radio-inline"><label> <input type="radio" value="A" <?php if($objeto->conc_estado == 'A') { echo "checked"; } ?> name="conc_estado" required> Activo </label></div>
                                    <div class="radio-inline"><label> <input type="radio" value="I" <?php if($objeto->conc_estado == 'I') { echo "checked"; } ?> name="conc_estado"> Inactivo </label></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label">Orden</label>
                                <div class="col-md-2"><input type="text" name="conc_orden" class="form-control" value="<?php echo $objeto->conc_orden; ?>" required></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <!-- <button class="btn btn-white" type="submit">Cancel</button>-->
                                    <button class="btn btn-primary" type="submit">Guardar Cambios</button>
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
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  



    <script>

        $( function() {
            $( ".date" ).datepicker({
                dateFormat: 'dd/mm/yy',
            });
        } );
        
    $(document).ready(function(){

            function bs_input_file() {
                $(".input-file").before(
                    function() {
                        if ( ! $(this).prev().hasClass('input-ghost') ) {
                            var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                            element.attr("name",$(this).attr("name"));
                            element.change(function(){
                                element.next(element).find('input').val((element.val()).split('\\').pop());
                            });
                            $(this).find("button.btn-choose").click(function(){
                                element.click();
                            });
                            $(this).find("button.btn-reset").click(function(){
                                element.val(null);
                                $(this).parents(".input-file").find('input').val('');
                            });
                            $(this).find('input').css("cursor","pointer");
                            $(this).find('input').mousedown(function() {
                                $(this).parents('.input-file').prev().click();
                                return false;
                            });
                            return element;
                        }
                    }
                );
            }
            $(function() {
                bs_input_file();
            });


            $('.contact-box').each(function() {
                animationHover(this, 'pulse');
            });

            var postForm = function() {
                var content = $('textarea[name="conc_descripcion"]').html($('.summernote').code());
            }
        });
    </script>

</body>

</html>