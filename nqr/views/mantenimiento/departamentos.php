<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
?>


    <!-- Main content -->
    <section class="content">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">AREA, PUESTO Y USUARIO</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"></button>            
          </div>
        </div>
        <div class="box-body">
        <!--DONDE OCURRIO (areas)-->
          <div class="row">
            <div class="col-md-6 ">
              <div class="form-group">
                <label>Area</label>
                <input type="text" class="form-control" id="area">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Subarea</label>
                <input type="text" class="form-control" id="subarea">
              </div>
            </div>
            <input type="hidden" id="idSecuencia-area">
            <div class="col-md-4">
              <div class="form-group">
                <label>Puesto</label>
                <input type="text" class="form-control" id="puesto">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="nombre">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Correo</label>
                <input type="text" class="form-control" id="correo">
              </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">                
                  <button type='button' class='btn btn-primary ' id='btn-guardar-departamento' onclick='guardarDepartamento(1)' ><span class='glyphicon glyphicon-floppy-saved'> Guardar</span></button>
                  <button type='button' class='btn btn-primary' id='btn-nuevo-departamento' style='display:none' onclick='nuevoDepartamento()' ><span class='glyphicon'>+ Nuevo</span></button>                                         
                  <button type='button' class='btn btn-info' id='btn-actualizar-departamento' style='display:none' onclick='actualizarDepartamento()' ><span class='glyphicon glyphicon-edit'> Actualizar</span></button>                         
            </div>            
          </div>
        </div>
    </div>
  </div>
    <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">AREAS INGRESADAS</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"></button>            
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class='table'>
              <thead>
                <tr>
                  <th scope='col'>Acción</th>
                  <th scope='col'>Area</th>
                  <th scope='col'>Subarea</th>
                  <th scope='col'>Puesto</th>
                  <th scope='col'>Usuario</th>
                  <th scope='col'>Correo</th>
                </tr>
              </thead>
              <tbody id="resultado-areas">
              <?php
                foreach($areas as $row)
                {
                ?>
                <tr>                
                <?php
                  if ($row['estado']==1){
                ?>
                  <th scope='row'><button type='button' class='btn btn-warning' id='<?php echo $row['idSecuencia'];?>' value='<?php echo $row['descripcionArea'];?>' onclick='agregarSeleccion(this);'><i class='fa fa-hand-pointer-o'></i></button><button type='button' class='btn btn-primary' id='<?php echo $row['idSecuencia'];?>' value='0'  onclick='eliminarDepartamento(this)' ><span class='fa fa-check-square'></span></button></th>                  
                <?php
                  }else{
                ?>              
                  <th scope='row'><button type='button' class='btn btn-warning' id='<?php echo $row['idSecuencia'];?>' value='<?php echo $row['descripcionArea'];?>' onclick='agregarSeleccion(this);'><i class='fa fa-hand-pointer-o'></i></button><button type='button' class='btn btn-danger' id='<?php echo $row['idSecuencia'];?>' value='1'  onclick='eliminarDepartamento(this)' ><span class='fa fa-plus-square'></span></button></th>
                <?php
                      }
                  ?>                                
                  <td><strong> <?php echo $row['descripcionArea'];?></strong></td>
                  <td><?php echo $row['descripcionSubArea'];?></td>
                  <td><?php echo $row['descripcionPuesto'];?></td>
                  <td><?php echo $row['descripcionNombre'];?></td>
                  <td><?php echo $row['correo'];?></td>
                </tr>                    
                  <?php
                    }
                  ?>                 
              </tbody>
            </table>
          </div>
        </div>
    </div>

<?php
$script = <<< JS


JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">

function guardarDepartamento(opcion)
{
    var area = $("#area").val();
    var subarea = $("#subarea").val();
    var puesto = $("#puesto").val();
    var nombre = $("#nombre").val();
    var correo = $("#correo").val();
    var idSecuencia = $("#idSecuencia-area").val();
    var valores = {'opcion':opcion,'area':area,'subarea':subarea,'puesto':puesto,'nombre':nombre,'correo':correo,'idSecuencia':idSecuencia};

        if (area.trim()!= '')
        {if(subarea.trim()!='')
          {
            $.ajax({
            url: '/nqr/web/index.php?r=mantenimiento/guardararea', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                beforeSend: function() {   

                },success: function(data) {                
                    nuevoDepartamento();               
                    obtenerDepartamentos();
                    swal("FINALIZADO!", data, "success");      
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
            });
          }else{
            swal("LO SENTIMOS!", "El subarea no puede quedar vacia", "info");  
          }
        }else{
            swal("LO SENTIMOS!", "El area no puede quedar vacia", "info");  
        }
}

function actualizarDepartamento()
{
  guardarDepartamento(2);
}

function eliminarDepartamento(valor)
{
  var accion = valor.value;
  var idSecuencia = valor.id;
  var mensaje = '';
  var mensaje2 = '';

  if (accion == 0)
  {
    mensaje = 'Desactivar area (departamento)';
    mensaje2 = 'Desactivado';
  }else{
    mensaje = 'Activar area (departamento)';  
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
            url: '/nqr/web/index.php?r=mantenimiento/eliminararea', 
            type : 'POST',      
            datatype : 'json',
            data : valores, 
                success: function(data) {
                    swal(mensaje2, "", "success");
                    obtenerDepartamentos();               
                },error:function(data){
                    swal("FATAL!", data, "error");
                }
            });
  });
}

function nuevoDepartamento()
{
  $("#btn-guardar-departamento").show();
  $("#btn-actualizar-departamento").hide();
  $("#btn-eliminar-departamento").hide();
  $("#btn-nuevo-departamento").hide();
  $("#idSecuencia-area").val("");
  $("#area").val("");  
  $("#subarea").val("");  
  $("#puesto").val("");  
  $("#nombre").val("");  
  $("#correo").val("");  
}

function obtenerDepartamentos()
{
  $.ajax({
    url: '/nqr/web/index.php?r=mantenimiento/obtenerareas', 
    type : 'POST',      
    datatype : 'json',
      success: function(data) {
        var obj = jQuery.parseJSON(data);
        html = "";
        $.each(obj, function(i, item) {
          if(item.estado ==1){
            html += "<tr><th scope='row'><button type='button' class='btn btn-warning' id='"+item.idSecuencia+"' value='"+item.descripcionArea+"' onclick='agregarSeleccion(this);'><i class='fa fa-hand-pointer-o'></i></button><button type='button' class='btn btn-primary' id='"+item.idSecuencia+"' value='0'  onclick='eliminarDepartamento(this)' ><span class='fa fa-check-square'></span></button></th><td><strong>"+item.descripcionArea+"</strong></td><td>"+item.descripcionSubArea+"</td><td>"+item.descripcionPuesto+"</td><td>"+item.descripcionNombre+"</td><td>"+item.correo+"</td></tr>";
          }else{
            html += "<tr><th scope='row'><button type='button' class='btn btn-warning' id='"+item.idSecuencia+"' value='"+item.descripcionArea+"' onclick='agregarSeleccion(this);'><i class='fa fa-hand-pointer-o'></i></button><button type='button' class='btn btn-danger' id='"+item.idSecuencia+"' value='1'  onclick='eliminarDepartamento(this)' ><span class='fa fa-plus-square'></span></button></th><td><strong>"+item.descripcionArea+"</strong></td><td>"+item.descripcionSubArea+"</td><td>"+item.descripcionPuesto+"</td><td>"+item.descripcionNombre+"</td><td>"+item.correo+"</td></tr>";
          }          
        });
        $("#resultado-areas").html(html);
      },error:function(data){
        swal("FATAL!", "Error en obtener los datos", "error");
      }
  });  
}

function agregarSeleccion(valor)
{
  $("#btn-actualizar-departamento").show();
  $("#btn-eliminar-departamento").show();
  $("#btn-nuevo-departamento").show();
  $("#btn-guardar-departamento").hide();   
  $("#idSecuencia-area").val(valor.id);
  $("#area").val(valor.value);
  idSecuencia = valor.id;

  $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenerarea', 
        type : 'POST',      
        datatype : 'json',
        data : {'idSecuencia':idSecuencia}, 
            success: function(data) {
              console.log(data);      
                var obj = jQuery.parseJSON(data);
                if (obj.length > 0){
                    $.each(obj, function(i, item) {                    
                    $("#area").val(item.descripcionArea);
                    $("#subarea").val(item.descripcionSubArea);
                    $("#puesto").val(item.descripcionPuesto);
                    $("#nombre").val(item.descripcionNombre);
                    $("#correo").val(item.correo);                   
                });  
                }else{
                    //vaciarCampos();
                }        
            }
        });  
}

</script>