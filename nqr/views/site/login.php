<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\bootstrap\ActiveForm;
$this->title = 'Logeo';
//$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    body { 
      width: 100%;
      height: 100%;
      /*background-color:  #3552f7;*/
    }
  </style>

<div class="site-login">
    <div class="row">
        <div class="login-box">
            <div class="col-md-12 box box-radius">
                <center><label for="" style="margin-top:15px;"><h3>SALICA DEL ECUADOR</h3></label></center>
                <div class="col-sm-12" style="margin-top:15px;">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control"  id="usuario">
                        </div>
                    </div>
                </div> 
                <div class="col-sm-12" style="margin-top:15px;">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control"  id="contrasena">
                        </div>
                    </div>
                </div> 
                <div class=" col-sm-12">
                    <div class="form-group">                    
                        <a class="btn btn-primary" name="login-button" id="login-button" onclick="logeo()">Iniciar sesión</a>
                    </div>
                </div>                              
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS

$("#contrasena").keypress(function(e) {
       if(e.which == 13) {
          logeo()
       }
    });

JS;
$this->REGISTERJS($script);
?>

<script type="text/javascript">

function logeo()
{
    var usuario = $("#usuario").val();
    var contrasena = $("#contrasena").val();
    var valores = {'usuario':usuario,'contrasena':contrasena}

    //VALIDACION CUANDO SE ENVIEN CAMPOS VACIOS
    if (usuario == "" || contrasena =="")
    {
        swal("INCOMPLETO!", "Debe digitar el usuario y la contraseña", "info"); 
    }
    else{
        $.ajax({
        url: '/nqr/web/index.php?r=site/autenticacion', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   
		console.log("cargando")
            },success: function(data) {
                var obj = jQuery.parseJSON(data);              
                if(obj.estado)
                {
                    location.reload();
                }else{
                    swal("LO SIENTO!", obj.mensaje, "error"); 
                }
                   
            },error:function(data){
                swal("FATAL!", "ERROR DE CREDENCIALES", "error"); 
            }
        }); 

    }

}
</script>