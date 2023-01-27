<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
use yii\jui\DatePicker;
?>

<link rel="stylesheet" type="text/css" href="/nqr/web/select2/css/select2.css">

<!-- Main content -->
<section class="content">
<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Usuario</h3> 
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <!--INFORMACION GENERAL-->
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Código usuario</label>
                    <input type="text" class="form-control" id="usuario">
                </div>              
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" id="apellidos">
                </div>              
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="nombre">
                </div>              
            </div>
            <div class="col-md-4">
                <label>Centro de costo</label>
                <select class="form-control" id="codigoCentroCosto" style="width: 100%;">
                    <?php
                        foreach($centroCostos as $row)
                        {
                    ?>
                        <option value='<?php echo $row['cciCentroCosto'];?>' name='<?php echo $row['cnoCentroCosto'];?>' ><?php echo $row['cnoCentroCosto'];?></option>  
                    <?php
                        }
                    ?>                                                
                </select>
            </div>            
            <div class="col-md-4">
                <div class="form-group">
                    <label>Correo</label>
                    <input type="text" class="form-control" id="correo">
                </div>              
            </div> 
            <div class="col-md-2">
                <label>Rol usuario</label>
                <select class="form-control select2" id="codigoRolUsuario" style="width: 100%;">
                    <option value='1' name='USUARIO'>USUARIO</option>
                    <option value='2' name='GESTOR'>GESTOR</option> 
                    <option value='3' name='SISTEMA DE GESTIÓN'>SISTEMA DE GESTIÓN</option>                                               
                </select>             
            </div> 
            <div class="col-md-2">
                <label>Estado</label>
                <select class="form-control select2" id="estadoActivo" style="width: 100%;">
                    <option value='1'>ACTIVO</option>
                    <option value='0'>INACTIVO</option>                                               
                </select>              
            </div>
            <div class="col-md-12">
                <label>Responsable documental</label>
                <select class="form-control select2" id="responsable-documental" style="width: 100%;"  multiple="multiple">
                    <?php
                        foreach($usuariosNQR as $row)
                        {
                    ?>
                        <option value='<?php echo $row['usuario'];?>' name='<?php echo $row['usuario'];?>' ><?php echo $row['usuario'];?></option>  
                    <?php
                        }
                    ?>    
                </select>              
            </div> 
        </div>
        <br>
        <!--BOTONES DEL FORMULARIO-->
        <div class='row'>
             <div class="col-md-12 ">
                <div class="form-group">
                    <button type='button' class='btn btn-primary' id='btn-guardar-usuario' onclick="guardarUsuarioNQR(1)" ><span class='fa fa-save'> Guardar</span></button>
                    <button type='button' class='btn btn-primary' id='btn-nuevo-usuario' style='display:none' onclick='nuevoUsuario()' ><span class='glyphicon'>+ Nuevo</span></button>                                   
                    <button type='button' class='btn btn-default' id='btn-actualizar-usuario' style='display:none' onclick="guardarUsuarioNQR(2)"><span class='fa fa-paperclip'> Actualizar</span></button>                
                </div>
            </div> 
        </div>            
    </div>
</div>
<div class="table-responsive">
    <table id="tabla-buzon-principal" class="table table-bordered">
        <thead>
            <tr>
            <th scope="col" bgcolor='#dedcd5'><div class="size-botones-buzon">Acción</div></th>
            <th scope="col" bgcolor='#dedcd5'>Usuario</th>
            <th scope="col" bgcolor='#dedcd5'>Apellidos</th>
            <th scope="col" bgcolor='#dedcd5'>Nombres</th>
            <th scope="col" bgcolor='#dedcd5'>Centro de costo</th>
            <th scope="col" bgcolor='#dedcd5'>Correo</th>
            <th scope="col" bgcolor='#dedcd5'>Rol</th>
            <th scope="col" bgcolor='#dedcd5'>Estado</th>
            <th scope="col" bgcolor='#dedcd5'>responsableDocumental</th>
            </tr>
        </thead>
        <tbody id="resultado-busqueda">         
        </tbody>
    </table>
</div>  
<?php
$script = <<< JS
obtenerUsuariosNQR();

$(document).ready(function(){
    $("#responsable-documental").select2({
      maximumSelectionLength: 5
    });
})

JS;
$this->REGISTERJS($script);
?>



<script type="text/javascript">

function obtenerUsuariosNQR()
{


    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenerusuariosnqr', 
        type : 'POST',      
        datatype : 'json',
            success: function(data) {
                var dataUsuariosNQR = JSON.parse(data);
                $('#tabla-buzon-principal').dataTable( {
                    destroy: true,                    
                    language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar usuario específico:",
                                "zeroRecords": "Sin resultados encontrados",
                                "paginate": {
                                        "first": "Primero",
                                        "last": "Ultimo",
                                        "next": "Siguiente",
                                        "previous": "Anterior"
                                            }
                            },                                       
                    data : dataUsuariosNQR,
                    columns: [{"data": null,
                        render:function(data, type, row)                        
                                {                                    
                                    return "<button type='button' value='"+data['usuario']+"' name='1' onclick='agregarSeleccion(this)' class='btn btn-warning ' data-toggle='tooltip' data-placement='top' title='Seleccionar usuario' ><i class='fa fa-hand-pointer-o'></i></button>";
                                },
                            }
                                ,{ data: "usuario" }
                                ,{data:"apellidos"},
                                { data: "nombre" },{data:"CentroCosto"},{ data: "correo" },{data:"descripcionRolUsuario"},
                                { data:"estadoActivoDesc"},{ data:"responsableDocumental"}]
                });              

            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });
}

function agregarSeleccion(valor)
{

    $.ajax({
        url: '/nqr/web/index.php?r=mantenimiento/obtenerusuarionqr', 
        type : 'POST',      
        datatype : 'json',
        data: {'idUsuario':valor.value},
            success: function(data) {
                var obj = JSON.parse(data);
                $.each(obj, function(i, item) {             
                    $("#usuario").val(item.usuario);
                    $("#nombre").val(item.nombre);
                    $("#apellidos").val(item.apellidos);
                    $("#estadoActivo").val(item.estadoActivo);
                    $("#codigoRolUsuario").val(item.codigoRolUsuario);
                    $("#correo").val(item.correo); 
                    $("#codigoCentroCosto").val(item.codigoCentroCosto);                                 
                    //$("#responsable-documental").select2("val",arrayOfValues).trigger('change');;                             
                    $("#btn-actualizar-usuario").show();
                    $("#btn-guardar-usuario").hide();
                    $("#btn-nuevo-usuario").show();
                });
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });
}

function guardarUsuarioNQR(opcion)
{
    var usuario =  $("#usuario").val();
    var nombre =  $("#nombre").val();
    var apellidos =  $("#apellidos").val();
    var estadoActivo = $("#estadoActivo").val();
    var codigoRolUsuario = $("#codigoRolUsuario").val();
    var descripcionRolUsuario = $("#codigoRolUsuario").find('option:selected').attr("name");
    var correo = $("#correo").val(); 
    var codigoCentroCosto = $("#codigoCentroCosto").val();
    var responsableDocumental = $("#responsable-documental").val();
    var responsableDocumentalFinal = '';
        $.each(responsableDocumental, function (ind, elem) {           
          responsableDocumentalFinal += elem+'|'; 
        });        
    var CentroCosto = $("#codigoCentroCosto").find('option:selected').attr("name");
    var opcion = opcion; 
    var valores = {'opcion':opcion,'usuario':usuario,'nombre':nombre,'apellidos':apellidos,'estadoActivo':estadoActivo,'codigoRolUsuario':codigoRolUsuario,'descripcionRolUsuario':descripcionRolUsuario,'correo':correo,'codigoCentroCosto':codigoCentroCosto,'CentroCosto':CentroCosto,'responsableDocumental':responsableDocumentalFinal};


    if (codigoCentroCosto != null)
    {
        if (usuario.length >4 ){
            $.ajax({
                url: '/nqr/web/index.php?r=mantenimiento/guardarusuarionqr', 
                type : 'POST',      
                datatype : 'json',
                data : valores, 
                    success: function(data) {      
                        swal("FINALIZADO!", data, "success");  
                        obtenerUsuariosNQR(); 
                        vaciarCampos();
                    },error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                });
        }else{
           swal("FATAL!", "Debe ingresar el código del usuario y debe tener minimo 4 caracteres", "error");  
        }        
    }else{
        swal("FATAL!", "Debe asignar el usuario a un centro de costo", "error"); 
    }
}   

function vaciarCampos()
{
    $("#usuario").val("");
    $("#nombre").val("");
    $("#apellidos").val("");
    $("#correo").val(""); 

}
function nuevoUsuario()
{
    $("#btn-actualizar-usuario").hide();
    $("#btn-nuevo-usuario").hide();
    $("#btn-guardar-usuario").show();
    vaciarCampos();
}

</script>