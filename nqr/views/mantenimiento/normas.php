<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
?>


    <!-- Main content -->
    <section class="content">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">INFORMACIÓN DE LAS NORMAS</h3>
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
                <label>Seleccione Cod. Norma</label>
                <select id="normas-select" class="form-control ">
          <?php
        	foreach($normas as $row)
        			{
        	?>
          <option value='<?php echo $row['codigoNorma'];?>' name='<?php echo $row['codigoNorma'];?>' ><?php echo $row['codigoNorma']." - ";  echo $row['descripcionNorma'];?></option>	
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
                <button type='button' class='btn btn-primary ' id='btn-nuevo-norma' onclick="nuevaNorma()"  ><span class='glyphicon glyphicon-plus'> Nuevo</span></button>
                <button type='button' class='btn btn-info' id='btn-actualizar-norma' onclick="actualizarNorma()" style="display:none" ><span class='glyphicon glyphicon-edit'> Actualizar</span></button>       
                <button type='button' class='btn btn-danger' id='btn-eliminar-norma' onclick="eliminarNorma()" style="display:none"><span class='glyphicon glyphicon-trash'> Eliminar</span></button>            
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
          <h3 class="box-title">INFORMACIÓN DE LA CLAUSULA (requisito)</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <!--INFORMACION GENERAL-->
          <div class="row">              
            <div class="col-md-12">
            <div class='form-group'>
                <div id="clasulaSeleccionada">
                </div>            
            </div>
            <div class='form-group'>
            <label>Clausula</label>
            <textarea class="textarea" placeholder="Escriba la clausula" id="txt-area-clausula"
                          style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>                
            <input type="hidden" id="secuencial-clausula">
            </div>
            </div>           
            <!-- /.col -->
            <div class="col-md-12">
                <div class="form-group">
                    <button type='button' class='btn btn-primary ' id='btn-nuevo-clausula' onclick='guardarClausula()' ><span class='glyphicon glyphicon-floppy-saved'> Guardar</span></button>
                    <button type='button' class='btn btn-default' id='buscar' onclick='buscarClausula()'><span class='glyphicon glyphicon-search'> Buscar</span></button>                     
                    <button type='button' class='btn btn-info' id='btn-actualizar-clausula' style="display:none" onclick="actualizarClausula()" ><span class='glyphicon glyphicon-edit'> Actualizar</span></button>             
                    <button type='button' class='btn btn-danger' id='btn-eliminar-clausula' style="display:none" onclick="eliminarClausula()" ><span class='glyphicon glyphicon-trash'> Eliminar</span></button>                          
            </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->


    </div>


<!-- Modal normas inicio-->
<div class="modal fade" id="ModalNormas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gestión de normas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div class='form-group'>
            <label>Cod. norma</label>  
            <input type="hidden"  id="codigoNormaCod">       
            <input type="text" class="form-control" placeholder="Codigo Norma" id="codigoNorma">
        </div>
        <div class='form-group'>
            <label>Descripción</label>        
        <input type="text" class="form-control" placeholder="descripcion Norma" id="descripcionNorma">
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarNorma" onclick="guardarNorma()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal normas fin-->


<!-- Modal buscar clausulas inicio-->
<div class="modal fade" id="ModalBuscarClausulas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar clausulas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
        <input type="text" class="form-control" placeholder="Clausula a buscar" id="ClausulaBuscar">
        <div id="resultado-clausulas"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal buscar clausulas fin-->



<?php
$script = <<< JS

$("#ClausulaBuscar").keyup(function(){
    obtenerClausulas();
});

$("#normas-select").change(function(){
    if ($("#normas-select").val()=="SN")
    {
        $("#btn-actualizar-norma").hide()
        $("#btn-eliminar-norma").hide(); 
    }else{
        $("#btn-actualizar-norma").show()
        $("#btn-eliminar-norma").show();
    }
});

$("#normas-select").val('1');
JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">
function nuevaNorma()
{                    
    $("#codigoNorma").val("");
    $("#descripcionNorma").val("");
    $("#codigoNormaCod").val("");
    $('#ModalNormas').modal('show');

}

function guardarNorma()
{
    var codigoNorma = $("#codigoNorma").val();
    var descripcionNorma = $("#descripcionNorma").val();
    var codigoNormaCod = $("#codigoNormaCod").val();
    var valores = {'codigoNormaCod':codigoNormaCod,'codigoNorma':codigoNorma,'descripcionNorma':descripcionNorma};
    
    if (codigoNorma.trim() != ''){
        //CONDICION PARA SABER SI ESTA ACTUALIZANDO O ES UN NUEVO REGISTRO
        if (codigoNormaCod.trim()== '')
        {
        $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/guardarnorma', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   

            },success: function(data) {
                swal("FINALIZADO!", data, "success");  
                $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/obtenernormas', 
                type : 'POST',      
                datatype : 'json',
                data : {'valores':'DF'}, 
                    success: function(data) {
                    //aqui se debe llenar el combo box
                    var obj = jQuery.parseJSON(data);
                    $("#normas-select").empty();
                    $.each(obj, function(i, item) {                 
                        $("#normas-select").append('<option value="'+item.codigoNorma+'">'+item.codigoNorma+" - "+item.descripcionNorma+'</option>');
                    });
                    }
                }); 
                $('#ModalNormas').modal('hide')                           
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
    }else{
        $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/actualizarnorma', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   

            },success: function(data) {
                swal("FINALIZADO!", data, "success");  
                $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/obtenernormas', 
                type : 'POST',      
                datatype : 'json',
                data : {'valores':'DF'}, 
                    success: function(data) {
                    //aqui se debe llenar el combo box
                    var obj = jQuery.parseJSON(data);
                    $("#normas-select").empty();
                    $.each(obj, function(i, item) {                 
                        $("#normas-select").append('<option value="'+item.codigoNorma+'">'+item.codigoNorma+" - "+item.descripcionNorma+'</option>');
                    });
                    }
                }); 
                $('#ModalNormas').modal('hide')                           
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
    }
    }else{
        swal("LO SENTIMOS!", "El código de la norma no puede quedar vacio", "info");
    }
}

function eliminarNorma()
{
    swal({
    title: "Eliminar Norma?",
    text: "Si continua no volvera a ver esta norma!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, Continuar!",
    closeOnConfirm: false
    },
    function(){
        var codigoNorma = $("#normas-select").val();
        var valores = {'codigoNorma':codigoNorma};

        $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/eliminarnorma', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                success: function(data) {
                    swal("Eliminado!", data, "success");
                    $.ajax({
                    url: '/nqr/web/index.php?r=mantenimiento/obtenernormas', 
                    type : 'POST',      
                    datatype : 'json',
                    data : {'valores':'DF'}, 
                        success: function(data) {
                        //aqui se debe llenar el combo box
                        $("#normas-select").empty();
                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function(i, item) {                 
                            $("#normas-select").append('<option value="'+item.codigoNorma+'">'+item.codigoNorma+" - "+item.descripcionNorma+'</option>');
                        });
                        }
                    });                     
                },error:function(data){
                    swal("FATAL!", data, "error");
                }
            });
    });
}

function actualizarNorma()
{
    if($("#normas-select").val() != 'SN')
    {
        //aqui se debe cargar la informacion de la norma seleccionada
        var codigoNorma = $("#normas-select").val();
        $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/obtenernorma', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoNorma':codigoNorma}, 
                success: function(data) {
                //aqui se debe llenar los input de la norma seleccionada
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {                 
                    $("#codigoNorma").val(item.codigoNorma);
                    $("#descripcionNorma").val(item.descripcionNorma);
                    $("#codigoNormaCod").val(item.codigoNorma);
                });
                }
        });        
        $('#ModalNormas').modal('show')
    }else{
        swal("LO SENTIMOS!", "Para poder actualizar debe seleccionar una norma", "info"); 
    } 
}
//funciones para las clausulas(requisito)
function buscarClausula()
{
    if ($("#normas-select").val() != 'SN')
    {
        $("#resultado-clausulas").html("");
        $('#ModalBuscarClausulas').modal('show')
    }else{
        swal("LO SENTIMOS!", "Debe seleccionar un Cod. Norma", "info"); 
    }
}

function obtenerClausulas()
{
    var codigoNorma = $("#normas-select").val();
    var clausula = $("#ClausulaBuscar").val();
    var valores = {'codigoNorma':codigoNorma,'clausula':clausula};

    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenerclausulas', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   
                $("#resultado-clausulas").html("<p>Buscando...</p>")
            },success: function(data) {

                var html = "<div class=' table-responsive'><table class='table'><thead><tr><th scope='col'>Agregar</th><th scope='col'>Cláusula</th></tr></thead><tbody class='' id=''>";

                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {                 
                html += "<tr><td><button type='button' class='btn btn-primary' value='"+item.idSecuencia+"°"+item.requisito+"' onclick='agregarClausula(this)' ><span class='glyphicon glyphicon-index'>+</span></button></td><td>"+item.requisito+"</td></tr>"; 
                });
                html +="</tbody></table></div>";
                if (obj.length == 0)
                {
                html = "<h5>No hay datos.</h5>";
                }

                $("#resultado-clausulas").html(html);

            },error:function(){
                swal("FATAL!", data, "error"); 
            }
        });    

}

function guardarClausula()
{  
    var clausula = $("#txt-area-clausula").val();

    if( clausula.trim() != '')
    {
        if ($("#normas-select").val() != 'SN')
        {
            var codigoNorma = $("#normas-select").val();
            var requisito = clausula;
            var valores = {'codigoNorma':codigoNorma,'requisito':requisito};

            $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/guardarclausula', 
                type : 'POST',      
                datatype : 'json',
                data : valores, 
                    success: function(data) {
                        swal("FINALIZADO!", data, "success"); 
                        $("#txt-area-clausula").val("");
                    }
                    ,error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                }); 

        }else{
            swal("LO SENTIMOS!", "Debe seleccionar una norma", "info"); 
        }        
    }else{
        swal("LO SENTIMOS!", "La clausula no debe estar vacia", "info"); 
    }
}

function eliminarClausula()
{
    swal({
    title: "Eliminar Clausula?",
    text: "Si continua no volvera a ver esta clausula!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, Continuar!",
    closeOnConfirm: false
    },
    function(){
        var secuencialClausula = $("#secuencial-clausula").val();
        var decripcionClausula = $("#txt-area-clausula").val();
        var valores = {'secuencialClausula':secuencialClausula,'decripcionClausula':decripcionClausula};

        $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/eliminarclausula', 
                type : 'POST',      
                datatype : 'json',
                data : valores, 
                    success: function(data) {
                        swal("FINALIZADO!", data, "success");
                        eliminarSeleccion();
                    }
                    ,error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                });
    });
}

function actualizarClausula()
{
    swal({
    title: "Actualizar Clausula?",
    text: "Desea actualizar el detalle de la clausula!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, Continuar!",
    closeOnConfirm: false
    },
    function(){
        var secuencialClausula = $("#secuencial-clausula").val();
        var decripcionClausula = $("#txt-area-clausula").val();
        var valores = {'secuencialClausula':secuencialClausula,'decripcionClausula':decripcionClausula};

        $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/actualizarclausula', 
                type : 'POST',      
                datatype : 'json',
                data : valores, 
                    success: function(data) {
                        swal("FINALIZADO!", data, "success");
                        eliminarSeleccion();
                    }
                    ,error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                });
    });
}

function agregarClausula(e)
{
    $('#ModalBuscarClausulas').modal('hide');
    $("#ClausulaBuscar").val("");
    var valorSeleccion = e.value;
    var secuencial = valorSeleccion.split("°")[0];
    var clausula = valorSeleccion.split("°")[1];

    $("#secuencial-clausula").val(secuencial);
    $("#txt-area-clausula").val(clausula);
    $("#clasulaSeleccionada").html("<p>"+clausula+"</p> <a href='#' onclick='eliminarSeleccion()'>Eliminar selección</a>");
    $("#btn-actualizar-clausula").show()
    $("#btn-eliminar-clausula").show();
    $("#btn-nuevo-clausula").hide();
    
}

function eliminarSeleccion()
{
    $("#secuencial-clausula").val("");
    $("#clasulaSeleccionada").html("");
    $("#txt-area-clausula").val("");
    $("#btn-actualizar-clausula").hide()
    $("#btn-eliminar-clausula").hide();
    $("#btn-nuevo-clausula").show();
}

</script>