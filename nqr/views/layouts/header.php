<?php
use yii\helpers\Html;
?>
<header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?=$title?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?=$title?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-expand-lg" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><span id="nombre-usuario-1"><i class='fa fa-user'></i> <?php echo @$_SESSION["usuarioSession"]; ?></span></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?= Html::img('@web/img/avatar2.png', ['class' => 'img-circle', 'alt'=>'User Image']) ?>
                    <p>
                      <?php echo @$_SESSION["usuarioSession"]; ?> - <?php echo @$_SESSION["usuarioRolSession"]; ?>
                      <small>SALICA DEL ECUADOR</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="#" class="btn btn-danger btn-flat" id="btn-cerrar-session" onclick="cerrarSession()"><i class='fa fa-power-off'></i> Cerrar sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

<script>
  function cerrarSession(){
    $.ajax({
        url: '/nqr/web/index.php?r=site/cerrarsession', 
        type : 'POST',      
        datatype : 'json',
        data : {'valores':'12'}, 
          success: function(data) {
            location.reload();           
          },error:function(data){

          }
    });
  }
</script>