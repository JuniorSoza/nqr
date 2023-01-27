<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
?>

<section class="content">
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">USUARIOS (gestores, clientes, proveedores)</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"></button>            
        </div>
    </div>
    <div class="box-body">
    <div class="row">
            <div class="col-md-2">
                <label>Tipo</label>
                <select class="form-control select2" id="tipoGestor" style="width: 100%;">
                    <option value='SN'>SN-SIN SELECCIÓN</option>
                    <option value='GE'>GE-GESTOR</option>	                    	                   	
                </select>             
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Gestores</label>
                <select id="select-gestor" class="form-control ">                  
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre del usuario</label>
                    <input type="text" class="form-control" id="nombreGestor">
                </div>              
            </div> 
            <div class="col-md-8">
                <div class="form-group">
                    <label>Correo</label>
                    <input type="text" class="form-control" id="correoGestor">
                </div>              
            </div>    
            <div class="col-md-2">
                <div class="form-group">
                    <label>Estado</label>
                    <select class="form-control select2" id="estadoGestor" style="width: 100%;">
                        <option value='1'>ACTIVO</option>    
                        <option value='0'>INACTIVO</option>	                    	                   	
                    </select>
                </div>              
            </div>                                             
            <input type="hidden" id="idSecuencia-gestor">
            <div class="col-md-12">
                <div class="form-group">                
                  <button type='button' class='btn btn-primary ' id='btn-guardar-gestor' onclick='guardarGestor(1)' ><span class='glyphicon glyphicon-floppy-saved'> Guardar</span></button>
                  <button type='button' class='btn btn-primary' id='btn-nuevo-gestor' style='display:none' onclick='nuevoGestor()' ><span class='glyphicon'>+ Nuevo</span></button>                                         
                  <button type='button' class='btn btn-info' id='btn-actualizar-gestor' style='display:none' onclick='actualizarGestor()' ><span class='glyphicon glyphicon-edit'> Actualizar</span></button>                         
            </div>            
          </div>
    </div>
 </div>


 <?php
$script = <<< JS

$("#tipoGestor").change(function(){
    obtenerGestores();
    vaciarCampos();
});


$("#select-gestor").change(function(){
    $("#btn-nuevo-gestor").show();
    $("#btn-guardar-gestor").hide(); 
    $("#btn-actualizar-gestor").show();
    obtenerGestor();
});

JS;
$this->REGISTERJS($script);
?>

<script type="text/javascript">
function obtenerGestores()
{
    var tipoGestor = $("#tipoGestor").val();
    var valores = {'tipoGestor':tipoGestor};

    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenergestores', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            success: function(data) {  
                var obj = jQuery.parseJSON(data);
                $("#select-gestor").empty();
                $.each(obj, function(i, item) {
                    $("#select-gestor").append('<option value="'+item.idSecuencia+'">'+item.gestor+'</option>');
                });          
            }
        });
}

function obtenerGestor()
{
    var idGestor = $("#select-gestor").val();
    var valores = {'idGestor':idGestor};

    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenergestor', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            success: function(data) {      
                var obj = jQuery.parseJSON(data);
                if (obj.length > 0){
                    $.each(obj, function(i, item) {                    
                    $("#nombreGestor").val(item.gestor);
                    $("#correoGestor").val(item.correo);
                    $("#tipoGestor").val(item.tipo);
                    $("#estadoGestor").val(item.estado);                   
                });  
                }else{
                    vaciarCampos();
                }        
            }
        });
}

function guardarGestor()
{
    var idGestor = $("#select-gestor").val();
    var nombreGestor = $("#nombreGestor").val();
    var correoGestor = $("#correoGestor").val();
    var tipoGestor = $("#tipoGestor").val();
    var estadoGestor = $("#estadoGestor").val();
    var valores = {'opcion':1,'idGestor':idGestor,'nombreGestor':nombreGestor,'correoGestor':correoGestor,'tipoGestor':tipoGestor,'estadoGestor':estadoGestor};

    if (tipoGestor != "SN"){
        if(nombreGestor.trim() != ""){
            $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/guardargestor', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                success: function(data) {      
                    swal("FINALIZADO!", data, "success");  
                    obtenerGestores(); 
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
            });
        }else{
            $("#nombreGestor").val("");
            swal("LO SENTIMOS!", "El nombre del usuario no puede quedar vacio", "info"); 
        }
    }else{
        swal("LO SENTIMOS!", "Debe seleccionar un tipo", "info"); 
    }
}


function nuevoGestor()
{
    $("#btn-nuevo-gestor").hide();
    $("#btn-guardar-gestor").show(); 
    $("#btn-actualizar-gestor").hide();
    $("#nombreGestor").val(""); 
    $("#correoGestor").val(""); 
    $("#select-gestor").val(0); 
}

function actualizarGestor()
{
    var idGestor = $("#select-gestor").val();
    var nombreGestor = $("#nombreGestor").val();
    var correoGestor = $("#correoGestor").val();
    var tipoGestor = $("#tipoGestor").val();
    var estadoGestor = $("#estadoGestor").val();
    var valores = {'opcion':2,'idGestor':idGestor,'nombreGestor':nombreGestor,'correoGestor':correoGestor,'tipoGestor':tipoGestor,'estadoGestor':estadoGestor};
    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/guardargestor', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            success: function(data) {      
                swal("FINALIZADO!", data, "success");  
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });    
}

function vaciarCampos()
{
    $("#nombreGestor").val("");
    $("#correoGestor").val("");    
    $("#estadoGestor").val(1);  
    $("#btn-nuevo-gestor").hide();
    $("#btn-guardar-gestor").show(); 
    $("#btn-actualizar-gestor").hide();  
}

</script>