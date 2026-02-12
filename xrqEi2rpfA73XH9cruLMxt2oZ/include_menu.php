<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> 
                    <span>
                        <?php if($_SESSION['PANEL_USUA_IMAGEN']){ ?>
                            <img alt="image" class="img-circle" style="width: 40px;" src="../uploads/<?php echo $_SESSION['PANEL_USUA_IMAGEN']; ?>" />
                        <?php } else{ ?>
                            <img alt="image" class="img-circle" src="img/a7.jpg" style="width: 40px;" />
                        <?php } ?>
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION['PANEL_USUA_NOMBRE']; ?></strong>
                     </span> <span class="text-muted text-xs block"><?php echo $_SESSION['PANEL_USUA_CARGO']; ?> <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="perfil.php">Perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="index.php?opc=logout">Salir</a></li>
                    </ul>
                </div>
                <div class="logo-element" style="color: #FF7F00;">
                    TF+
                </div>
            </li>
            <li <?php if($base == 'home'){?>class="active"<?php } ?>>
                <a href="home.php"><i class="fa fa-th-large"></i> <span class="nav-label">Escritorio</span></a>
            </li>

            <li <?php if($base == 'concurso' || $base == 'concurso-add'){?>class="active"<?php } ?>>
                <a href="concurso.php"><i class="fa fa-th-large"></i> <span class="nav-label">Concurso</span></a>
            </li>
            <li <?php if($base == 'pregunta' || $base == 'pregunta-add'){?>class="active"<?php } ?>><!--  class="active" -->
                <a href="pregunta.php"><i class="fa fa-th-large"></i> <span class="nav-label">Pregunta</span></a>
            </li>
            <li <?php if($base == 'region' || $base == 'region-add' || $base == 'comuna' || $base == 'tombola-add' || $base == 'premio' || $base == 'premio-add' || $base == 'categoria' || $base == 'categoria-add'){?>class="active"<?php } ?>>
                <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Zonas Geográficas</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="region.php"><i class="fa fa-user"></i>Regiónes</a></li>
                    <li><a href="comuna.php"><i class="fa fa-cog"></i>Comunas</a></li>
                </ul>
            </li>
            <li <?php if($base == 'parametro' || $base == 'parametro-add'){?>class="active"<?php } ?>><!--  class="active" -->
                <a href="parametro.php"><i class="fa fa-th-large"></i> <span class="nav-label">Parametro</span></a>
            </li>
        </ul>
    </div>
</nav>