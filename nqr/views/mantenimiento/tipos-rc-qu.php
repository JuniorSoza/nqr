<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
?>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">TIPOS DE RECLAMOS</h3>
            </div>        
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Subtipo de documento*</label>
                            <select id="select-codigoSubDocumento" class="form-control ">
                                <?php
                                    foreach($codigoSubDocumento as $row)
                                    {
                                    ?>
                                    <option value='<?php echo $row['codigoSubtipo'];?>' name='<?php echo $row['codigoSubtipo'];?>' ><?php echo $row['descripcionSubtipo'];?></option>   
                                    <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Área</label>
                            <select id="select-codigoDondeOcurrioArea" class="form-control ">
                                <?php
                                    foreach($codigoDondeOcurrioArea as $row)
                                    {
                                    ?>
                                    <option value='<?php echo $row['dondeOcurrioArea'];?>' name='<?php echo $row['dondeOcurrioArea'];?>' ><?php echo $row['dondeOcurrioArea'];?></option>   
                                    <?php
                                    }
                                    ?>                     
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"> 
                            <label>Tipo reclamo*</label>                           
                            <input type="text" class="form-control" id="descripcionTipoReclamo">
                            <input type="hidden" id="idSecuencia-tipoReclamo">
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Clasificación</label>                           
                            <input type="text" class="form-control" id="clasificacion">
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Subclasificación</label>                           
                            <input type="text" class="form-control" id="subclasificacion">
                        </div>                       
                    </div> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type='button' class='btn btn-primary ' id='btn-guardar-tiporeclamo' onclick='guardarTipoReclamo();'  ><span class='glyphicon glyphicon-floppy-saved'> Guardar</span></button>
                            <button type='button' class='btn btn-primary ' id='btn-nuevo-tiporeclamo' onclick="" style='display:none' ><span class='glyphicon glyphicon-floppy-saved'> Nuevo</span></button>
                            <button type='button' class='btn btn-info' id='btn-actualizar-tiporeclamo' onclick="actualizarTipoReclamo()" style='display:none' ><span class='glyphicon glyphicon-edit'> Actualizar</span></button>                  
                        </div>
                    </div>                                       
                    <div class="col-md-12">
                        <div id="resultado-reclamos">                            

                        </div>  
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
obtenerTipoReclamos();


$("#btn-nuevo-tiporeclamo").click(function(){
    nuevoTipoReclamo();    
});

JS;
$this->REGISTERJS($script);
?>

<script>
function obtenerTipoReclamos()
{
    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenertiporeclamos', 
        type : 'POST',      
        datatype : 'json', 
            beforeSend: function() {   
                $("#resultado-reclamos").html("<p>Buscando...</p>")
            },success: function(data) {

                var html = "<div class=' table-responsive'><table class='table' id='tabla-tipo-principal'><thead><tr><th scope='col'>Acción</th><th scope='col'>Subtipo documento</th><th scope='col'>Área</th><th scope='col'>Tipo reclamo</th><th scope='col'>Clasificación</th><th scope='col'>SubClasificación</th></tr></thead><tbody class='' id=''>";

                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {
                    if (item.estado ==1)
                    {
                        html += "<tr><th scope='row'><button type='button' class='btn btn-warning' id='"+item.idSecuencia+"' value='"+item.codigoDondeOcurrioArea+"' onclick='agregarSeleccionReclamo(this);'><i class='fa fa-hand-pointer-o'></i></button><button type='button' class='btn btn-danger' id='"+item.idSecuencia+"' value='0' onclick='eliminarTipoReclamo(this)' ><span class='fa fa-plus-square'></span></button></th><td>"+item.descripcionSubtipo+"</td><td>"+item.area+"</td><td>"+item.tipoReclamo+"</td><td>"+item.clasificacion+"</td><td>"+item.subclasificacion+"</td></tr>"; 
                    }else{
                        html += "<tr><th scope='row'><button type='button' class='btn btn-warning' id='"+item.idSecuencia+"' value='"+item.codigoDondeOcurrioArea+"' onclick='agregarSeleccionReclamo(this);'><i class='fa fa-hand-pointer-o'></i></button><button type='button' class='btn btn-primary' id='"+item.idSecuencia+"' value='1' onclick='eliminarTipoReclamo(this)' ><span class='fa fa-check-square'></span></button></th><td>"+item.descripcionSubtipo+"</td><td>"+item.area+"</td><td>"+item.tipoReclamo+"</td><td>"+item.clasificacion+"</td><td>"+item.subclasificacion+"</td></tr>"; 
                    }                           
                });
                html +="</tbody></table></div>";
                if (obj.length == 0)
                {
                html = "<h5>No hay datos.</h5>";
                }

                $("#resultado-reclamos").html(html);                
                $("#tabla-tipo-principal").dataTable();
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });    

}

function guardarTipoReclamo()
{
    var codigoDondeOcurrioArea =$("#select-codigoDondeOcurrioArea").val();
    var descripcionTipoReclamo = $("#descripcionTipoReclamo").val();
    var clasificacion = $("#clasificacion").val();
    var subclasificacion = $("#subclasificacion").val();
    var codigoSubDocumento = $("#select-codigoSubDocumento").val();
    var valores = {'codigoDondeOcurrioArea':codigoDondeOcurrioArea,'descripcionTipoReclamo':descripcionTipoReclamo,'clasificacion':clasificacion,'subclasificacion':subclasificacion,'codigoSubDocumento':codigoSubDocumento};

    if( codigoSubDocumento.trim() != 'S/D')
    {
        if(descripcionTipoReclamo.trim().length >5){
            
            $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/guardartiporeclamos', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                success: function(data) {
                    obtenerTipoReclamos();
                    nuevoTipoReclamo();
                    swal("FINALIZADO!", data, "success"); 
                }
                ,error:function(data){
                    swal("FATAL!", data, "error"); 
                }
            }); 

        }else{
            swal("LO SENTIMOS!", "El tipo de reclamo debe tener minimo 5 caracteres", "info"); 
        }
    }else{
        swal("LO SENTIMOS!", "Debe seleccionar un subtipo de documento", "info"); 
    }    
}

function actualizarTipoReclamo()
{
    var idSecuencia = $("#idSecuencia-tipoReclamo").val();
    var codigoDondeOcurrioArea =$("#select-codigoDondeOcurrioArea").val();
    var descripcionTipoReclamo = $("#descripcionTipoReclamo").val();
    var clasificacion = $("#clasificacion").val();
    var subclasificacion = $("#subclasificacion").val();
    var codigoSubDocumento = $("#select-codigoSubDocumento").val();
    var valores = {'idSecuencia':idSecuencia,'codigoDondeOcurrioArea':codigoDondeOcurrioArea,'descripcionTipoReclamo':descripcionTipoReclamo,'clasificacion':clasificacion,'subclasificacion':subclasificacion,'codigoSubDocumento':codigoSubDocumento};


    if( codigoSubDocumento.trim() != 'S/D')
    {
        if(descripcionTipoReclamo.trim().length >5){
            $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/actualizartiporeclamo', 
                type : 'POST',      
                datatype : 'json',
                data : valores, 
                    success: function(data) {
                        nuevoTipoReclamo();
                        obtenerTipoReclamos();
                        swal("FINALIZADO!", data, "success"); 
                    }
                    ,error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                });
        }else{
             swal("LO SENTIMOS!", "El tipo de reclamo debe tener minimo 5 caracteres", "info");
        } 
    }else{
        swal("LO SENTIMOS!", "Debe seleccionar un subtipo de documento", "info");  
    } 
}

function agregarSeleccionReclamo(valor )
{
    $("#btn-actualizar-tiporeclamo").show()
    $("#btn-guardar-tiporeclamo").hide()
    $("#btn-nuevo-tiporeclamo").show()

    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenertiporeclamo', 
        type : 'POST',      
        datatype : 'json',
        data : {'idSecuencia':valor.id}, 
            success: function(data) {
                //aqui se debe llenar el combo box
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) { 
                    $("#idSecuencia-tipoReclamo").val(item.idSecuencia);              
                    $("#descripcionTipoReclamo").val(item.tipoReclamo);
                    $("#clasificacion").val(item.Clasificacion);
                    $("#subclasificacion").val(item.subclasificacion);
                    $("#select-codigoSubDocumento").val(item.codigoSubtipoDoc);
                    $("#select-codigoDondeOcurrioArea").val(item.area);                   
                });
            }
    });    
}

function eliminarTipoReclamo(valor)
{
  var accion = valor.value;
  var idSecuencia = valor.id;
  var mensaje = '';
  var mensaje2 = '';

  if (accion == 0)
  {
    mensaje = 'Desactivar tipo reclamo (clasificación, subclasificación)';
    mensaje2 = 'Desactivado';
  }else{
    mensaje = 'Activar tipo reclamo (clasificación, subclasificación)';  
    mensaje2 = 'Activado';
  }

  swal({
    title: mensaje,
    text: "Desea cambiar el estado?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, Continuar!",
    closeOnConfirm: false
    },
    function(){
        //var idSecuencia = $("#idSecuencia-departamento").val();
        var valores = {'idSecuencia':idSecuencia,'accion':accion};
        $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/eliminartiporeclamo', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                success: function(data) {
                    swal(mensaje2, "", "success");
                    obtenerTipoReclamos();               
                },error:function(data){
                    swal("FATAL!", data, "error");
                }
            });
  });
}

function nuevoTipoReclamo()
{
    $("#btn-guardar-tiporeclamo").show();
    $("#btn-actualizar-tiporeclamo").hide();
    $("#btn-nuevo-tiporeclamo").hide();
    $("#descripcionTipoReclamo").val("");
    $("#idSecuencia-tipoReclamo").val("");
    $("#clasificacion").val("")
    $("#subclasificacion").val("")

}
</script>
