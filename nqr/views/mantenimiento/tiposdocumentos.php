<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
?>


    <!-- Main content -->
    <section class="content">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">TIPOS DE DOCUMENTOS</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"></button>            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <!--INFORMACION GENERAL-->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Seleccione el tipo de documento</label>
                <select id="tiposDocumentos-select" class="form-control ">
                    <?php
                    foreach($tiposDocumentos as $row)
                    {
                    ?>
                    <option value='<?php echo $row['codigoDocumento'];?>' name='<?php echo $row['codigoDocumento'];?>' ><?php echo $row['codigoDocumento']." - ";  echo $row['descripcionDocumento'];?></option>	
                    <?php
                    }
                    ?>              
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-12">
              <div class="form-group">
                <button type='button' class='btn btn-primary ' id='btn-nuevo-documento' onclick="nuevaDocumento()"  ><span class='glyphicon glyphicon-plus'> Nuevo</span></button>
                <button type='button' class='btn btn-info' id='btn-actualizar-documento' onclick="actualizarDocumento()" style="display:none" ><span class='glyphicon glyphicon-edit'> Actualizar</span></button>       
                <button type='button' class='btn btn-danger' id='btn-eliminar-documento' onclick="eliminarDocumento()" style="display:none"><span class='glyphicon glyphicon-trash'> Eliminar</span></button>            
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      </div>

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">SUBTIPOS DE DOCUMENTOS</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <!--INFORMACION GENERAL-->
          <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                <label>Seleccione el subtipo del documento</label>
                <select id="subtipoDocumentos-select" class="form-control ">
                </select>
              </div>
              <!-- /.form-group -->
            </div>                            
            <div class="col-md-12">
            <div class='form-group'>
                <div id="subtipoSeleccionada">
                </div>            
            </div>
                <input type="hidden" id="secuencial-subtipo">
            </div>
         
            <!-- /.col -->
            <div class="col-md-12">
                <div class="form-group">
                    <button type='button' class='btn btn-primary ' id='btn-nuevo-subtipo' onclick='nuevaSubtipo()' ><span class='glyphicon'>+ Nuevo</span></button>                   
                    <button type='button' class='btn btn-info' id='btn-actualizar-subtipo' style="display:none" onclick="actualizarSubtipo()" ><span class='glyphicon glyphicon-edit'> Actualizar</span></button>             
                    <button type='button' class='btn btn-danger' id='btn-eliminar-subtipo' style="display:none" onclick="eliminarSubtipo()" ><span class='glyphicon glyphicon-trash'> Eliminar</span></button>                          
            </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>


<!-- Modal documento inicio-->
<div class="modal fade" id="ModalDocumentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gestión de documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body"> 
            <div class='form-group'>
                <label>Código. Documento</label>  
                <input type="hidden"  id="codigoDocumentoCod">       
                <input type="text" class="form-control" placeholder="Código documento" id="codigoDocumento" readonly>
            </div>
            <div class='form-group'>
                <label>Descripción</label>        
                <input type="text" class="form-control" placeholder="Descripcion documento" id="descripcionDocumento">
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarDocumento" onclick="guardarDocumento()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal documento fin-->


<!-- Modal gestion subtipo inicio-->
<div class="modal fade" id="ModalSubtipos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gestion subtipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
            <div class='form-group'>
                <label>Código. Subtipo</label>  
                <input type="hidden"  id="codigoSubtipoCod">       
                <input type="text" class="form-control" placeholder="Código subtipo" id="codigoSubtipo" readonly>
            </div>
            <div class='form-group'>
                <label>Descripción subtipo</label>        
                <input type="text" class="form-control" placeholder="Descripcion subtipo" id="descripcionSubtipo">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="" onclick="guardarSubtipo()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal buscar subtipo fin-->



<?php
$script = <<< JS

$("#tiposDocumentos-select").change(function(){
    if ($("#tiposDocumentos-select").val()=="SN")
    {
        $("#btn-actualizar-documento").hide()
        $("#btn-eliminar-documento").hide(); 
    }else{
        obtenerSubtipos();
        $("#btn-actualizar-documento").show()
        $("#btn-eliminar-documento").show();
    }
        $("#btn-actualizar-subtipo").hide()
        $("#btn-eliminar-subtipo").hide();
});


$("#subtipoDocumentos-select").change(function(){
    if ($("#subtipoDocumentos-select").val()=="SN")
    {
        $("#btn-actualizar-subtipo").hide();
        $("#btn-eliminar-subtipo").hide(); 
    }else{
        $("#btn-actualizar-subtipo").show()
        $("#btn-eliminar-subtipo").show();
    }
});

JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">
function nuevaDocumento()
{                    
    $("#codigoDocumento").val("");
    $("#descripcionDocumento").val("");
    $("#codigoDocumentoCod").val("");
    $('#ModalDocumentos').modal('show');

}

function guardarDocumento()
{
    var codigoDocumento = $("#codigoDocumento").val();
    var descripcionDocumento = $("#descripcionDocumento").val();
    var codigoDocumentoCod = $("#codigoDocumentoCod").val();
    var valores = {'codigoDocumentoCod':codigoDocumentoCod,'codigoDocumento':codigoDocumento,'descripcionDocumento':descripcionDocumento};
    
    if (codigoDocumento.trim() != ''){
        //CONDICION PARA SABER SI ESTA ACTUALIZANDO O ES UN NUEVO REGISTRO
        if (codigoDocumentoCod.trim()== '')
        {
        $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/guardardocumento', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   

            },success: function(data) {
                swal("FINALIZADO!", data, "success");  
                $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/obtenerdocumentos', 
                type : 'POST',      
                datatype : 'json',
                data : {'valores':'DF'}, 
                    success: function(data) {
                    //aqui se debe llenar el combo box
                    var obj = jQuery.parseJSON(data);
                    $("#tiposDocumentos-select").empty();
                    $.each(obj, function(i, item) {                 
                        $("#tiposDocumentos-select").append('<option value="'+item.codigoDocumento+'">'+item.codigoDocumento+" - "+item.descripcionDocumento+'</option>');
                    });
                    }                    
                }); 
                $('#ModalDocumentos').modal('hide')                           
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
    }else{
        $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/actualizardocumento', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   

            },success: function(data) {
                swal("FINALIZADO!", data, "success");  
                $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/obtenerdocumentos', 
                type : 'POST',      
                datatype : 'json',
                data : {'valores':'DF'}, 
                    success: function(data) {
                    //aqui se debe llenar el combo box
                    var obj = jQuery.parseJSON(data);
                    $("#tiposDocumentos-select").empty();
                    $.each(obj, function(i, item) {                 
                        $("#tiposDocumentos-select").append('<option value="'+item.codigoDocumento+'">'+item.codigoDocumento+" - "+item.descripcionDocumento+'</option>');
                    });
                    obtenerSubtipos();
                    }
                }); 
                $('#ModalDocumentos').modal('hide')                           
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
    }
    }else{
        swal("LO SENTIMOS!", "El código de la norma no puede quedar vacio", "info");
    }
}

function eliminarDocumento()
{
    swal({
    title: "Eliminar Documento?",
    text: "Si continua no volvera a ver esta documento!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, Continuar!",
    closeOnConfirm: false
    },
    function(){
        var codigoDocumento = $("#tiposDocumentos-select").val();
        var valores = {'codigoDocumento':codigoDocumento};

        $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/eliminardocumento', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                success: function(data) {
                    swal("Eliminado!", data, "success");
                    $.ajax({
                    url: '/nqr/web/index.php?r=mantenimiento/obtenerdocumentos', 
                    type : 'POST',      
                    datatype : 'json',
                    data : {'valores':'DF'}, 
                        success: function(data) {
                        //aqui se debe llenar el combo box
                        $("#tiposDocumentos-select").empty();
                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function(i, item) {                 
                            $("#tiposDocumentos-select").append('<option value="'+item.codigoDocumento+'">'+item.codigoDocumento+" - "+item.descripcionDocumento+'</option>');
                        });
                        }
                    });                     
                },error:function(data){
                    swal("FATAL!", data, "error");
                }
            });
    });
}

function actualizarDocumento()
{
    if($("#tiposDocumentos-select").val() != 'SN')
    {
        //aqui se debe cargar la informacion de la norma seleccionada
        var codigoDocumento = $("#tiposDocumentos-select").val();
        $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/obtenerdocumento', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoDocumento':codigoDocumento}, 
                success: function(data) {
                //aqui se debe llenar los input de la norma seleccionada
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {                 
                    $("#codigoDocumento").val(item.codigoDocumento);
                    $("#descripcionDocumento").val(item.descripcionDocumento);
                    $("#codigoDocumentoCod").val(item.codigoDocumento);
                });
                }
        });        
        $('#ModalDocumentos').modal('show')
    }else{
        swal("LO SENTIMOS!", "Para poder actualizar debe seleccionar un tipo de documento", "info"); 
    } 
}

//funciones para lOS SUBTIPOS DE DOCUMENTOS
function obtenerSubtipos()
{
    var codigoDocumento = $("#tiposDocumentos-select").val();
    var valores = {'codigoDocumento':codigoDocumento};

    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenersubtipos', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   

            },success: function(data) {
                //aqui se debe llenar el combo box
                var obj = jQuery.parseJSON(data);
                $("#subtipoDocumentos-select").empty();
                $.each(obj, function(i, item) {                 
                    $("#subtipoDocumentos-select").append('<option value="'+item.codigoSubtipo+'">'+item.codigoSubtipo+" - "+item.descripcionSubtipo+'</option>');
                });

            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });    

}

function nuevaSubtipo() {
    if ($("#tiposDocumentos-select").val()!='SN'){

        $("#codigoSubtipo").val("");
        $("#codigoSubtipoCod").val("");
        $("#descripcionSubtipo").val("");
        $('#ModalSubtipos').modal('show');

    }else{
        swal("LO SENTIMOS!", "Debe seleccionar un tipo de documento", "info");
    }
}

function guardarSubtipo()
{
    var codigoDocumento = $("#tiposDocumentos-select").val();
    var codigoSubtipo = $("#codigoSubtipo").val();
    var descripcionSubtipo = $("#descripcionSubtipo").val();
    var codigoSubtipoCod = $("#codigoSubtipoCod").val();
    var valores = {'codigoDocumento':codigoDocumento,'codigoSubtipo':codigoSubtipo,'descripcionSubtipo':descripcionSubtipo,'codigoSubtipoCod':codigoSubtipoCod};
    
    if (codigoDocumento.trim() != ''){
        //CONDICION PARA SABER SI ESTA ACTUALIZANDO O ES UN NUEVO REGISTRO
        if (codigoSubtipoCod.trim()== '')
        {
        $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/guardarsubtipo', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   

            },success: function(data) {
                swal("FINALIZADO!", data, "success");  
                obtenerSubtipos();
                $('#ModalSubtipos').modal('hide')                           
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
    }else{
        $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/actualizarsubtipo', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   

            },success: function(data) {
                swal("FINALIZADO!", data, "success");  
                obtenerSubtipos(); 
                $('#ModalSubtipos').modal('hide');
                $("#btn-actualizar-subtipo").hide();
                $("#btn-eliminar-subtipo").hide();                           
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
    }
    }else{
        swal("LO SENTIMOS!", "El código de la norma no puede quedar vacio", "info");
    }
}

function actualizarSubtipo()
{
    if($("#subtipoDocumentos-select").val() != 'SN')
    {
        //aqui se debe cargar la informacion deL tipo de documento seleccionado
        var codigoSubtipo = $("#subtipoDocumentos-select").val();
        $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/obtenersubtipo', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoSubtipo':codigoSubtipo}, 
                success: function(data) {
                //aqui se debe llenar los input de la norma seleccionada
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {                 
                    $("#codigoSubtipo").val(item.codigoSubtipo);
                    $("#descripcionSubtipo").val(item.descripcionSubtipo);
                    $("#codigoSubtipoCod").val(item.codigoSubtipo);
                });
                }
        });        
        $('#ModalSubtipos').modal('show')
    }else{
        swal("LO SENTIMOS!", "Para poder actualizar debe seleccionar un subtipo", "info"); 
    } 
}

function eliminarSubtipo()
{
    swal({
    title: "Eliminar Subtipo?",
    text: "Si continua no volvera a ver esta subtipo!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, Continuar!",
    closeOnConfirm: false
    },
    function(){
        var codigoSubtipo = $("#subtipoDocumentos-select").val();
        var valores = {'codigoSubtipo':codigoSubtipo};

        $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/eliminarsubtipo', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                success: function(data) {
                    swal("Eliminado!", data, "success");
                    obtenerSubtipos();
                    $("#btn-actualizar-subtipo").hide();
                    $("#btn-eliminar-subtipo").hide();                                         
                },error:function(data){
                    swal("FATAL!", data, "error");
                }
            });
    });
}
</script>