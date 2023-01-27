<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
?>


<section class="content">
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">RELACIONAR DOCUMENTOS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"></button>            
        </div>
    </div>
    <div class="box-body">
    <div class="row">
        <div class="col-md-12">
                <button type='button' class='btn btn-primary' id='' onclick="guardarRelacion()" ><span class='fa fa-save'>Guardar relación</span></button>                
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="tabla-relacion-documento-principal" class="table table-bordered">
                    <thead>
                        <tr>
                        <th scope="col" bgcolor='#dedcd5'><div class="size-botones-buzon">Selección</div></th>
                        <th scope="col" bgcolor='#dedcd5'>Cod. Relación</th>
                        <th scope="col" bgcolor='#dedcd5'>Cod. Solicitud</th>
                        <th scope="col" bgcolor='#dedcd5'>Cod. Documento</th>
                        <th scope="col" bgcolor='#0a6771'>Cerrado</th>
                        <th scope="col" bgcolor='#dedcd5'>Tipo Documento</th>
                        <th scope="col" bgcolor='#dedcd5'>Hallazgo</th>
                        </tr>
                    </thead>
                    <tbody id="resultado-busqueda">
                    </tbody>
                </table>
            </div>
        </div>
        <input type="hidden" id="documentos-seleccionados"class="form-control"> 
    </div>
 </div>


 <?php
$script = <<< JS
$(document).ready(function (){
    cargarDocumentos();
});

JS;
$this->REGISTERJS($script);
?>

<script>
function cargarDocumentos()
{
    var valores = {'opcion':17,'accion':'V'};
    $.ajax({
        url: '/nqr/web/index.php?r=relaciondocumento/gestiondocumento', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            success: function(data) {
                var dataSolicitudes = JSON.parse(data);
 
                $('#tabla-relacion-documento-principal').dataTable( {
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
                                "search": "Buscar solicitud específico:",
                                "zeroRecords": "Sin resultados encontrados",
                                "paginate": {
                                        "first": "Primero",
                                        "last": "Ultimo",
                                        "next": "Siguiente",
                                        "previous": "Anterior"
                                            }
                            },                                       
                    data : dataSolicitudes,
                    columns: [{"data": null,
                        render:function(data, type, row)                        
                                {
                                    if(data['codigoRelacion']==0){
                                        return "<input type='checkbox' onclick='accionChekDocumento(this)' id='checkDocumento' value='"+data['codigoSolicitudDocumento']+"'>";
                                    }else{
                                        return "<input type='checkbox' onclick='accionChekDocumento(this)' id='checkDocumento' value='"+data['codigoSolicitudDocumento']+"' disabled='true'>";
                                    }                                    
                                },
                            }                                                                                                                
                            ,{ data: "codigoRelacion" },{data:"codigoSolicitudDocumento"},{data:"codigoDocumento"},{ data: "fechaCerrado" }
                            ,{ data: "descripcionDocumento" },{data:"hallazgoDescripcion"}],
                });              

            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });
}

function accionChekDocumento(codigoSolicitudDocumento)
{
    e = codigoSolicitudDocumento.value
    var documentosSeleccionados = $("#documentos-seleccionados").val();

    if (documentosSeleccionados != "") {

          var textoseparado = documentosSeleccionados.split("|");
          //busco en el array si existe el valor
          var i = textoseparado.indexOf(e);
          
          if ( i !== -1 ) {
              textoseparado.splice( i, 1 );
                var arrayNuevo = ""
              $.each(textoseparado, function (ind, elem) {
                if (elem != "") {
                  arrayNuevo =arrayNuevo +elem+'|';
                }                                             
                }); 
              $("#documentos-seleccionados").val(arrayNuevo);   
          }else{
                $("#documentos-seleccionados").val(documentosSeleccionados+e+"|");
          }
    }else{
      $("#documentos-seleccionados").val(e+"|");    
    }              
}


function guardarRelacion()
{
    var documentosSeleccionados = $("#documentos-seleccionados").val();
    var valores = {'dato':documentosSeleccionados,'accion':'R','opcion':5};

    if(documentosSeleccionados.trim().length > 20){
        swal({
          title: "Guardar relación de documentos",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          confirmButtonText: "Guardar relación",
          cancelButtonText: "Cancelar",
          showLoaderOnConfirm: true
          }, function () {                
            $.ajax({
              url: '/nqr/web/index.php?r=relaciondocumento/gestiondocumento', 
              type : 'POST',      
              datatype : 'json',
              data : valores, 
                success: function(data) {            
                  var obj = jQuery.parseJSON(data);
                  $.each(obj, function(i, item) { 		
                    if(item.ESTADO == 1){
                        cargarDocumentos();
                        $("#documentos-seleccionados").val("");
                        swal("Exitoso!",item.MENSAJE, "success");
                    }else{
                        swal("Error!",item.MENSAJE, "error");
                    }					
                  });
                      
                },error:function(data){
                  swal("FATAL!", data, "error"); 
                }
              });
        });
    }else{
        swal("Error!","Debe tener seleccionado minimo 2 documentos", "error");
    }        
}

</script>