<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
use yii\jui\DatePicker;
?>
<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title"><strong>ACTUALIZACIÓN DE DOCUMENTO</strong></h3>
    </div>
    <div class="box-body">
    <!--INFORMACION GENERAL-->
      <div class="row">
        <div class="col-md-3 col-sm-3">
            <label>Código solicitud</label>            
            <div class="input-group">            
                <span class="input-group-addon"><i class="fa fa-dedent"></i></span>
                <input type="text" class="form-control" placeholder="SO00000001" id="codigoSolicitudDocumento" >
            </div> 
        </div> 
        <div class="col-md-3 col-sm-3">
            <label>Estado documento</label>            
            <div class="input-group">            
                <span class="input-group-addon"><i class="fa fa-dedent"></i></span>
                <input type="text" class="form-control" id="estadoDocumento" readonly>
            </div> 
        </div> 
        <div class="col-md-3 col-sm-6">
          <div class="form-group">
            <label>Tipo de documento*</label>
            <input type="hidden" class="form-control" id="select-tipo-documento" name="select-tipo-documento" readonly>
            <input type="text" class="form-control" id="select-tipo-documento-desc" name="select-tipo-documento-desc" readonly>

          </div>
          <!-- /.form-group -->
        </div>            
        <div class="col-md-3 col-sm-6 ">
          <div class="form-group">
            <label>Subtipo de documento*</label>
            <input type="hidden" class="form-control" id="select-subtipo-documento" name="select-subtipo-documento" readonly>
            <input type="text" class="form-control" id="select-subtipo-documento-desc" name="select-subtipo-documento-desc" readonly>
            <!--<select class="form-control select2" id="select-subtipo-documento" style="width: 100%;">-->
            </select>
          </div>
          <!-- /.form-group -->
        </div>
      </div>     
    </div>
  </div>
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title"><strong>COMPLETAR SOLICITUD</strong></h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div>
        <div id="pantalla-principal" style="display:none">
            <div class="row">
                <div class="col-md-4 col-sm-6 OPCIONES ECE ECL INT PRO SGE" style="display:none">
                    <div class="form-group">
                    <label>Código auditoría</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                            <input type="text" class="form-control" onkeyup="mayus(this);" id="cod-auditoria">
                        </div>
                    </div>
                </div>                  
            </div>
            <h4 class="OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP"><strong>INFORMACIÓN DEL EMISOR Y RECEPTOR</strong></h4> 
            <div class="row">
                <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" style="display:none"><!--EMISORES-->
                    <div class="row">           
                        <div class="col-md-12 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-EMISOR-AREA OPCIONES-DOC">
                            <label>Área emisor*</label>            
                            <div class="input-group">            
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control EMISOR-RECEPTOR AREA-EMISOR" id="AREA-EMISOR" readonly>
                            </div>                 
                        </div>                  
                        <div class="col-md-12 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-EMISOR-USUARIO OPCIONES-DOC">
                            <label>Usuario emisor*</label>            
                            <div class="input-group">            
                                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                <input type="text" class="form-control EMISOR-RECEPTOR USUARIO-EMISOR" id="USUARIO-EMISOR" readonly>
                            </div> 
                        </div>                                                           
                    </div>                   
                </div>
                <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" style="display:none"><!--RECEPTORES-->
                    <div class="row">                    
                        <div class="col-md-12 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-RECEPTOR-AREA OPCIONES-DOC">
                            <label>Área receptor*</label>            
                            <div class="input-group">            
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control EMISOR-RECEPTOR AREA-RECEPTOR" id="AREA-RECEPTOR" readonly>
                            </div>                 
                        </div>
                        <div class="col-md-12 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-RECEPTOR-USUARIO OPCIONES-DOC">
                            <label>Usuario receptor*</label>            
                            <div class="input-group">            
                                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                <input type="text" class="form-control EMISOR-RECEPTOR USUARIO-RECEPTOR" id="USUARIO-RECEPTOR" readonly>
                            </div> 
                        </div>                                                                
                    </div>                
                </div>
                <div class="col-md-12 col-sm-12 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" style="display:none">
                            <label>Contactos receptor(correos)</label>
                            <textarea class="textarea" placeholder="" id="textarea-contactos-receptor"
                                        style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>                                                        
                </div>                        
            </div>
            <h4 class="OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP"><strong>INFORMACIÓN DEL HALLAZGO Y TRATAMIENTO A SEGUIR</strong></h4>
            <div class="row">
                <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" style="display:none">
                    <label>Hallazgo*</label>
                    <textarea class="textarea" placeholder="Escriba el hallazgo" id="textarea-hallazgo"
                                        style="width: 100%; height: 90px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        
                                
                </div> 
                <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" style="display:none">
                    <label>Tratamiento Inmediato*</label>
                    <textarea class="textarea" placeholder="Escriba el tratamiento inmediato" id="textarea-tratamiento-inmediato"
                                        style="width: 100%; height: 90px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        
                                
                </div> 
            </div>
            <!--EVIDENCIA OBJETIVA-->
            <h4 class="OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP"><strong>EVIDENCIA OBJETIVA</strong></h4>           
            <div class="row">
                <div class="col-md-2 col-sm-4 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" style="display:none">
                    <div class="form-group">
                        <label>Cuando ocurrió*</label>
                        <!-- /.input group -->
                        <?= DatePicker::widget(['name' => 'fechaOcurrio',
                                    'options' => ['class' => 'form-control ','id' => 'fechaOcurrio'],
                                    'attribute' => 'from_date',                                
                                    'language' => 'es',
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'value' => date('Y-m-d'),])?> 
                    </div>
                </div>                
                <div class="col-md-4 col-sm-6 OPCIONES REC REI REP" style="display:none">
                    <div class="form-group">
                    <label>Tipo de reclamo*</label>
                    <select class="form-control select2" id="select-tipoReclamo" style="width: 100%;">
                            <?php
                            foreach($tipoReclamo as $row)
                            {
                            ?>
                            <option value='<?php echo $row['tipoReclamo'];?>' name='<?php echo $row['tipoReclamo'];?>' ><?php echo $row['tipoReclamo'];?></option>	
                            <?php
                            }
                            ?>     
                    </select>
                    </div>
                </div>                                   
                <div class="col-md-3 col-sm-6 OPCIONES ECE ECL INT PRO SGE QUI REI" style="display:none">
                    <div class="form-group">
                        <label>Área*</label>
                        <select class="form-control select2" style="width: 100%;" id="select-dondeOcurrioAreas">
                        <?php
                            foreach($dondeOcurrioAreas as $row)
                                {
                            ?>
                            <option value="<?php echo $row['descripcionArea']; ?>"><?php echo $row['descripcionArea']; ?></opction>  
                            <?php
                                }
                            ?>                        
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-3 col-sm-6 OPCIONES ECE ECL INT PRO SGE QUI REI" style="display:none">
                    <div class="form-group">
                        <label>Sub-Área*</label>
                        <select class="form-control select2" style="width: 100%;" id="select-subAreas">
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>                
            </div>
            <!--DATOS DE LA NORMA-->
            <h4 class="OPCIONES ECE ECL INT PRO SGE"><strong>DATOS DE LA NORMA</strong></h4>    
            <div class="row">
                <div class = 'col-md-12 OPCIONES ECE ECL INT PRO SGE' style="display:none">
                    <button type='button'  class='btn btn-warning' id='btn-eliminar-clausula' onclick="modalNormas()" ><span class=''> + Nueva norma</span></button>
                </div>
                <div class = 'col-md-12 OPCIONES ECE ECL INT PRO SGE' style="display:none">
                    <div class="table-responsive">                    
                        <table class='table table-bordered' >
                            <thead bgcolor='#3482d3'>
                                <tr><th scope='col'>Eliminar</th><th scope='col'>Norma</th><th scope='col'>Requisito (clausula)</th></tr>
                            </thead>
                            <tbody id='normas-agregadas'>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class = 'col-md-12 OPCIONES ECE ECL INT PRO SGE' style="display:none">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="select-requisito-clausula" name="select-requisito-clausula" readonly><!--readonly-->
                    </div>
                </div>
            </div>
            <!--DATOS DEL PRODUCTO-->
            <h4 class="OPCIONES REC"><strong>DATOS DEL PRODUCTO</strong></h4>    
            <div class="row">
                <div class="col-md-12">
                    <p><a class="btn btn-warning OPCIONES REC" data-toggle="collapse" href="#modalAgregarProducto" role="button" aria-expanded="false" aria-controls="modalAgregarProducto">+ Nuevo producto</a></p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="collapse multi-collapse" id="modalAgregarProducto">
                                <div class="col-md-4 col-sm-6 OPCIONES REC" style="display:none">
                                    <div class="form-group">
                                    <label>Código producción*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-th-list"></i></span>
                                            <input type="text" class="form-control DATOS-PRODUCTO" id="DATO-LOTE" placeholder="Código producción">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 OPCIONES REC" style="display:none">
                                    <div class="form-group">
                                    <label>Referencia*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-th-list"></i></span>
                                            <input type="text" class="form-control DATOS-PRODUCTO" id="DATO-REFERENCIA" placeholder="Referencia">
                                        </div>
                                    </div>
                                </div>                                                                                   
                                <div class="col-md-4 col-sm-6 OPCIONES REC" style="display:none">
                                    <div class="form-group">
                                    <label>Marca*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-tty"></i></span>
                                            <input type="text" class="form-control DATOS-PRODUCTO" id="DATO-MARCA" placeholder="Marca">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-4 col-sm-6 OPCIONES REC" style="display:none">
                                    <div class="form-group">
                                    <label>Factura</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                                            <input type="text" class="form-control DATOS-PRODUCTO" id="DATO-FACTURA" placeholder="Factura">
                                        </div>
                                    </div>
                                </div>                                                           
                                <div class="col-md-4 col-sm-6 OPCIONES REC" style="display:none">
                                    <div class="form-group">
                                    <label>Contenedor</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-ship"></i></span>
                                            <input type="text" class="form-control DATOS-PRODUCTO" id="DATO-CONTENEDOR" placeholder="Contenedor">
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-4 col-sm-6 OPCIONES REC" style="display:none">
                                    <div class="form-group">
                                        <button type='button' class='btn btn-primary' id='btn-agregarProducto' onclick="agregarProducto()" ><span class='fa fa-save'></span></button>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive OPCIONES REC">                    
                                <table class='table table-bordered' >
                                    <thead bgcolor='#3482d3'>
                                        <tr><th scope='col'>Eliminar</th><th scope='col'>Código producción</th><th scope='col'>Referencia</th><th scope='col'>Marca</th><th scope='col'>Factura</th><th scope='col'>Contenedor</th></tr>
                                    </thead>
                                    <tbody id='productos-agregados'>
                                    </tbody>
                                </table>
                            </div>                        
                        </div>
                        <div class = 'col-md-12 OPCIONES REC' style="display:none">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="select-productos" name="select-productos" readonly><!--readonly-->
                            </div>
                        </div>                        
                    </div>                
                </div>
            </div>
            <!--DATOS ADICIONALES-->
            <h4 class="OPCIONES REP"><strong>DATOS ADICIONALES</strong></h4>
            <div class="row">
                <div class="col-md-6 col-sm-6 OPCIONES REP" style="display:none">
                    <div class="form-group">
                        <label>Orden de compra GP</label>
                        <select class="form-control select2" id="select-orden-compra" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 OPCIONES REP" style="display:none">
                    <div class="form-group">
                        <label>Item producto-GP</label>
                        <select class="form-control select2" id="select-item-producto" style="width: 100%;">
                        </select>
                    </div>
                </div>                
            </div> 
            <!--BOTONES DEL FORMULARIO-->
            <div class='row'>
                <div class="col-md-12 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" style="display:none">
                    <div class="form-group">
                        <button type='button' class='btn btn-primary' id='' onclick="generarSolicitud()" ><span class='fa fa-save'> Actualizar solicitud</span></button>                
                        <button type='button' class='btn btn-default' id='btn-eliminar-clausula' onclick="modalAdjuntar()" ><span class='fa fa-paperclip'> Adjuntar</span></button>                
                    </div>
                </div> 
            </div> 
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal ADJUNTAR ARCHIVOS-->
<div class="modal fade" id="ModalAdjuntarArchivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adjuntar documentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
            <form enctype="multipart/form-data" id="form1">
                <input type="hidden" id="idSecuenciaDocumentos" name="idSecuenciaDocumentos">
                <input type="hidden" id="codigoSolicitudDocumento2" name="codigoSolicitudDocumento2">
                <input type="hidden" value="Solicitud" id="proceso" name="proceso">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <input type="text" class="form-control" id="descDocumento" name="descDocumento">
                        </div>                         
                    </div>             
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Archivo</label>
                            <input type="file" class="form-control" id="documento" name="documento">
                        </div>
                    </div>
                </div>               
            </form>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="btn-subirArchivo" onclick="onSubmitForm()"><span class='fa fa-cloud-upload'> Subir archivo</span></button>
            </div>
            <div id="respuesta-subida-archivo">                
            </div>
            <div id="respuesta-archivo">                
            </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal buscar clausulas fin-->    

<!-- Modal DATOS DE LA NORMA-->
<div class="modal fade" id="ModalNormas" tabindex="-1" role="dialog" aria-labelledby="ModalNormas" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
          <div class="col-md-12">
            <div class="form-group">
                <label>Norma</label>
                <select class="form-control select2" id="select-normas" style="width: 100%;">
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
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Búsqueda requisito</label>
                <input type="text" class="form-control" id="input-busqueda-requisito">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
              <div id="resultado-busqueda-normas"></div>
            </div>
        </div>              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal DATOS DE LOS INPUTTEXT-->
<div class="modal fade" id="ModalInputText" tabindex="-1" role="dialog" aria-labelledby="ModalInputText" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
          <div class="col-md-12">
            <div class="form-group">
                <label id="inputText-titulo"></label>
                <input type="text" class="form-control" id="input-busqueda-inputText">
                <input type="hidden" class="form-control" id="id-inputText" >
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
              <div id="resultado-busqueda-inputText"></div>
            </div>
        </div>              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal DATOS DEL PRODUCTO-->
<div class="modal fade" id="ModalDatosProducto" tabindex="-1" role="dialog" aria-labelledby="ModalDatosProducto" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
          <div class="col-md-12">
            <div class="form-group">
                <label id="ModalProducto-titulo"></label>
                <input type="text" class="form-control" id="input-busqueda-ModalProducto">
                <input type="hidden" class="form-control" id="id-ModalProducto" >
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
              <div id="resultado-busqueda-ModalProducto"></div>
            </div>
        </div>              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?php
$script = <<< JS
$("#codigoSolicitudDocumento").keyup(function(){
    obtenerDocumento();
});

$("#select-tipo-documento").change(function(){
    obtenerSubtipos();    
    $(".OPCIONES").hide();
});

$("#select-subtipo-documento").change(function(){
  var codigoDocumento = $("#select-tipo-documento").val();
  var codigoSubtipo = $("#select-subtipo-documento").val();  
  //$("#normas-agregadas, #productos-agregados").html("");
  //$("#textarea-hallazgo, #textarea-tratamiento-inmediato, #textarea-contactos-receptor, #select-productos, #select-requisito-clausula, #cod-auditoria").val("");
  //$("#select-orden-compra, #select-item-producto").empty();
  //OBTENER USUARIO Y AREA DEL EMISOR Y RECEPTOR DE ACUERDO CON EL SUBTIPO DE DOCUMENTO
  $.ajax({
    url: '/nqr/web/index.php?r=solicitud/obtenerusuarioarea', 
    type : 'POST',      
    datatype : 'json',
    data : {'usuarioLogin':'JANCHUNDIA','subTipoDocumento':codigoSubtipo}, 
        beforeSend: function() {   

        },success: function(data) {
            var obj = jQuery.parseJSON(data);                
            //$(".EMISOR-RECEPTOR").val("");
            $.each(obj, function(i, item) {                 
                //SE OCULTAN TODAS LAS OPCIONES
                $(".OPCIONES").hide();
                $(".EMISOR-RECEPTOR").prop('readonly', true);
                $(".OPCIONES-DOC").show();
                //VALIDACION DE LA PANTALLA QUE SE DEBE MOSTRAR
                //VALIDACION DE CAMPOS QUE SE DEBEN BLOQUEAR   || codigoSubtipo.trim() ==''
                if (codigoSubtipo != 'SN')
                {    
                    //DEPENDIENDO DE EL SUBDOCUMENTO SE HABILITAN LAS OPCIONES
                    if (codigoSubtipo =="ECE"){
                        $("#pantalla-principal").show();        
                        $(".ECE").show();
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);//EL USUARIO QUE INICIA SESSION
                        $(".AREA-EMISOR").prop('readonly', false); //INGRESO DE LA CERTIFICADORA
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);   //DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO
                    }else if(codigoSubtipo =="ECL"){
                        $("#pantalla-principal").show();       
                        $(".ECL").show();
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);// EL USUARIO QUE INICIA SESSION
                        $(".AREA-EMISOR").prop('readonly', false); //INGRESO DEL CLIENTE
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);   //DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO        
                    }else if(codigoSubtipo =="INT"){
                        $("#pantalla-principal").show();
                        $(".INT").show();  //USUARIO Y AREA EMISOR SON TOMADOS POR EL USUARIO QUE SE LOGEA
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        //$(".AREA-EMISOR").val(item.areaEmisor);
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);//DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO
                    }else if(codigoSubtipo =="PRO"){
                        $("#pantalla-principal").show();
                        $(".PRO").show(); //USUARIO Y AREA EMISOR SON TOMADOS POR EL USUARIO QUE SE LOGEA
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        //$(".AREA-EMISOR").val(item.areaEmisor);                        
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE SELECCIONAR UN PROVEEDOR DE GP
                        $(".AREA-RECEPTOR").prop('readonly', false);//DEBE OCULTARSE
                    }else if(codigoSubtipo =="SGE"){
                        $("#pantalla-principal").show();
                        $(".SGE").show();
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        //$(".AREA-EMISOR").val(item.areaEmisor);                        
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);//DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO        
                    }else if(codigoSubtipo =="QUE"){
                        $("#pantalla-principal").show();
                        $(".QUE").show(); 
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        $(".AREA-EMISOR").prop('readonly', false); //INGRESO DEL CLIENTE
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);   //DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO          
                    }else if(codigoSubtipo =="QUI"){
                        $("#pantalla-principal").show();
                        $(".QUI").show(); //USUARIO Y AREA EMISOR SON TOMADOS POR EL USUARIO QUE SE LOGEA
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        //$(".AREA-EMISOR").val(item.areaEmisor); 
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);//DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO        
                    }else if(codigoSubtipo =="REC"){
                        $("#pantalla-principal").show();
                        $(".REC").show();
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        $(".AREA-EMISOR").prop('readonly', false); //INGRESO DEL CLIENTE
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);   //DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO 
                    }else if(codigoSubtipo =="REI"){
                        $("#pantalla-principal").show();
                        $(".REI").show();//USUARIO Y AREA EMISOR SON TOMADOS POR EL USUARIO QUE SE LOGEA
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        //$(".AREA-EMISOR").val(item.areaEmisor); 
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE OBTENER EL USUARIO DE ACUERDO AL MANTEMIENTO DE AREAS
                        $(".AREA-RECEPTOR").prop('readonly', false);//DEBE SELECCIONAR UN AREA DEL MANTENIMIENTO        
                    }else if(codigoSubtipo =="REP"){
                        $("#pantalla-principal").show();
                        $(".REP").show();//USUARIO Y AREA EMISOR SON TOMADOS POR EL USUARIO QUE SE LOGEA
                        //$(".USUARIO-EMISOR").val(item.usuarioEmisor);
                        //$(".AREA-EMISOR").val(item.areaEmisor); 
                        $(".USUARIO-RECEPTOR").prop('readonly', false);//DEBE SELECCIONAR UN PROVEEDOR DE GP
                        $(".AREA-RECEPTOR").prop('readonly', false);//DEBE OCULTARSE        
                    }else{
                        
                    }
                }else{
                    
                }
            });                 
        },error:function(data){
                swal("ERROR!","Problemas al cargar el usuario y área", "error"); 
        }
    });

});

//MOSTRAR MODAL DE USUARIOS Y AREAS DE LOS EMISORES Y RECEPTORES
$(".EMISOR-RECEPTOR").on("click focus",function(){
    var inputText = this.id
    $("#resultado-busqueda-inputText").html("");
    $("#input-busqueda-inputText").val("");
    $("#id-inputText").val(inputText);
    
    if (inputText=="USUARIO-EMISOR" && $("#AREA-EMISOR").val()==""){
        swal("LO SENTIMOS!","Debe ingresar primero el área emisor","info");
        $("body").removeClass("stop-scrolling");
    }else if(inputText=="USUARIO-RECEPTOR" && $("#AREA-RECEPTOR").val()==""){
        swal("LO SENTIMOS!","Debe ingresar primero el área receptor","info");
        $("body").removeClass("stop-scrolling");
    }else {
        modalUsuarioArea(inputText);        
    }    
});

$(".DATOS-PRODUCTO").on("click focus",function(){
    var inputText = this.id
    $("#resultado-busqueda-ModalProducto").html("");
    $("#input-busqueda-ModalProducto").val("");    
    $("#id-ModalProducto").val(inputText);

    if ($("#AREA-EMISOR").val()==""){
        swal("LO SENTIMOS!","Debe ingresar primero el área emisor","info");
        $("body").removeClass("stop-scrolling");
    }else {
        modalDatosProducto(inputText);      
    }     
    
});

$("#select-normas").change(function(){
  obtenerRequisitosClausulas();
  $("#resultado-busqueda-normas").html("");
});

$("#select-dondeOcurrioAreas").change(function(){
    var idArea = $("#select-dondeOcurrioAreas").val();
    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenersubareas', 
        type : 'POST',      
        datatype : 'json',
        data : {'idArea':idArea}, 
            beforeSend: function() {   
                $("#select-subAreas").append('<option value="">cargando...</option>');
            },success: function(data) {
                var obj = jQuery.parseJSON(data);
                $("#select-subAreas").empty();
                $.each(obj, function(i, item) {                 
                    $("#select-subAreas").append('<option value="'+item.descripcionSubArea+'">'+item.descripcionSubArea+'</option>');
                });

            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
});

$("#input-busqueda-requisito").keyup(function(){
  var valorBusquedaRequisito = $("#input-busqueda-requisito").val();
  var codigoNorma = $("#select-normas").val();

    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenerclausulas', 
        type : 'POST',      
        datatype : 'json',
        data : {'codigoNorma':codigoNorma,'valorBusquedaRequisito':valorBusquedaRequisito}, 
            beforeSend: function() {   

            },success: function(data) {
                html = "<div class='table-responsive'><table class='table table-bordered'><thead bgcolor='#3482d3'><tr><th scope='col'>Seleccionar</th><th scope='col'>Requisito</th></tr></thead><tbody >";
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {                 
                    html += "<tr><td><button type='button' class='btn btn-warning' value='"+item.idSecuencia+"' id='"+item.requisito+"' name='"+item.codigoNorma+"' onclick='agregarSeleccionRequisito(this)' ><span class='fa fa-hand-pointer-o'></span></button></td><td>"+item.requisito+"</td></tr>";
                });
                html += "</tbody></table></div>";
                if(obj.length>0){
                  $("#resultado-busqueda-normas").html(html);
                }else{
                  $("#resultado-busqueda-normas").html("No hay datos");
                }
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });

});

$("#input-busqueda-inputText").keyup(function(){ 
    
    var idInputText = $("#id-inputText").val();
    var codigoSubtipo = $("#select-subtipo-documento").val();
    var filtroBusqueda = '';
    var valor = this.value;

    
    if (idInputText=="USUARIO-EMISOR"){
        var opcion =8;
        filtroBusqueda = $("#AREA-EMISOR").val();
    }else if(idInputText=="USUARIO-RECEPTOR"){
        var opcion =9;
        filtroBusqueda = $("#AREA-RECEPTOR").val();
    }else if(idInputText=="AREA-EMISOR"){
        var opcion =10;
    }else if(idInputText=="AREA-RECEPTOR"){
        var opcion =11;
    }

    var valores = {'opcion':opcion,'codigoSubtipo':codigoSubtipo,'inputText':this.value,'filtroBusqueda':filtroBusqueda};

    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenerinputtext', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   
                $("#resultado-busqueda-inputText").html("Buscando...");
            },success: function(data) {
                html = "<div class='table-responsive'><table class='table table-bordered'><thead bgcolor='#3482d3'><tr><th scope='col'>Seleccionar</th><th scope='col'>resultado</th></tr></thead><tbody >";
                var obj = jQuery.parseJSON(data);
                if (idInputText=="USUARIO-RECEPTOR" && (codigoSubtipo=='PRO' || codigoSubtipo =='REP') && valor.trim() != ""){
                    html += "<tr><td><button type='button' class='btn btn-warning' value='"+valor+"' id='"+valor+"' onclick='agregarInputText(this)' ><span class='fa fa-hand-pointer-o'></span></button></td><td>"+valor+"</td></tr>";
                }
                $.each(obj, function(i, item) {                 
                    if (item.respuesta.trim() != ""){
                        html += "<tr><td><button type='button' class='btn btn-warning' value='"+item.respuesta+"' id='"+item.respuesta+"' onclick='agregarInputText(this)' ><span class='fa fa-hand-pointer-o'></span></button></td><td>"+item.respuesta+"</td></tr>";
                    }
                });
                html += "</tbody></table></div>";

                if (idInputText=="USUARIO-RECEPTOR" && (codigoSubtipo=='PRO' || codigoSubtipo =='REP') && valor.trim() != ""){
                    $("#resultado-busqueda-inputText").html(html);
                }else{
                    if(obj.length>0){
                        $("#resultado-busqueda-inputText").html(html);
                    }else{
                        $("#resultado-busqueda-inputText").html("No hay datos");
                    } 
                }               
            },error:function(data){
                $("#resultado-busqueda-inputText").html(data); 
            }
    });
});

$("#input-busqueda-ModalProducto").keyup(function(){
    var idModalProducto = $("#id-ModalProducto").val();
    var filtroBusqueda = $("#AREA-EMISOR").val();
    var valor = this.value;

    var valores = {'opcion':14,'inputText':valor,'filtroBusqueda':filtroBusqueda,'accion':idModalProducto};

    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenerinfoproducto', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   
                $("#resultado-busqueda-ModalProducto").html("Buscando...");
            },success: function(data) {
                html = "<div class='table-responsive'><table class='table table-bordered'><thead bgcolor='#3482d3'><tr><th scope='col'>Seleccionar</th><th scope='col'>resultado</th></tr></thead><tbody >";
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {                 
                    html += "<tr><td><button type='button' class='btn btn-warning' value='"+item.respuesta+"' id='"+item.respuesta+"' onclick='agregarInfoProducto(this)' ><span class='fa fa-hand-pointer-o'></span></button></td><td>"+item.respuesta+"</td></tr>";
                });
                html += "</tbody></table></div>";
                $("#resultado-busqueda-ModalProducto").html(html);
            
            },error:function(data){
                $("#resultado-busqueda-inputText").html(data); 
            }
    });

})
$("#select-orden-compra").change(function(){

    obtenerDatoAdicional($("#select-orden-compra").val(),'select-orden-compra');
});

//VALIDACION DE CORREOS
$("#textarea-contactos-receptor").blur(function () {    
    validarCorreos($(this).val());  
});

$("#textarea-contactos-receptor").on("keypress",function(e){
    if(e.which == 13) {
        validarCorreos($(this).val());
    }  
});
//FIN DE VALIDACION DE CORREOS

JS;
$this->REGISTERJS($script);
?>

<script>

function obtenerDocumento()
{
    var codigoSolicitudDocumento = $("#codigoSolicitudDocumento").val();
    $("#btn-actulizar-documento").show();
    $.ajax({
        url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
        type : 'POST',
        datatype : 'json',
        data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'tipoDocumento':'ACTUALIZARDOC','accion':'V','opcion':2}, 
            success: function(data) {                
                //console.log(data);
                var obj = jQuery.parseJSON(data);
                if (obj.length > 0) 
                {
                    $.each(obj, function(i, item) {    
                        $("#estadoDocumento").val(item.estadoSolicitudDescripcion);             
                        $("#select-tipo-documento").val(item.codigoTipoDocumento).change();
                        $("#select-subtipo-documento").val(item.codigoSubtipoDocumento).change();
                        $("#select-tipo-documento-desc").val(item.descripcionDocumento);
                        $("#select-subtipo-documento-desc").val(item.descripcionSubtipo);//SO00000004

                        //INFORMACION DE LOS EMISORES Y LOS RECEPTORES                    
                        $("#cod-auditoria").val(item.codigoAuditoria);
                        $("#AREA-EMISOR").val(item.areaEmisor);
                        $("#USUARIO-EMISOR").val(item.usuarioEmisor);
                        $("#AREA-RECEPTOR").val(item.areaReceptor);
                        $("#USUARIO-RECEPTOR").val(item.usuarioReceptor);
                        $("#textarea-contactos-receptor").val(item.contactosReceptor);

                        //INFORMACION DEL HALLAZGO Y TRATAMIENTO A SEGUIR
                        $("#textarea-hallazgo").val(item.hallazgoDescripcion);
                        $("#textarea-tratamiento-inmediato").val(item.tratamientoInmediato);

                        //EVIDENCIA OBJETIVA
                        $("#fechaOcurrio").val(item.fechaCuandoOcurrio);
                        $("#select-dondeOcurrioAreas").val(item.areaDondeOcurrio).change();
                        $("#select-subAreas").val(item.subAreaDondeOcurrio);

                        //CARGAR DOCUMENTOS
                        $("#idSecuenciaDocumentos").val(item.codigosArchivos);
                        //VERIFICACION DE QUE TIPO DE DOCUMENTO ES LA SOLICITUD
                        //d.codigosNormas,d.codigosProductos,d.codigosArchivos
                        if(item.codigoTipoDocumento.trim() == "NC"){
                            $("#select-requisito-clausula").val(item.codigosNormas);
                            cargarDatosNC(codigoSolicitudDocumento,item.codigoTipoDocumento.trim());
                        }
                        if(item.codigoTipoDocumento.trim() == "QU"){
                            cargarDatosQU(codigoSolicitudDocumento,item.codigoTipoDocumento.trim());
                        }
                        if(item.codigoTipoDocumento.trim() == "RE"){                        	
        					$("#select-tipoReclamo").val(item.tipoReclamo);
                            $("#select-productos").val(item.codigosProductos);
                            cargarDatosRE(codigoSolicitudDocumento,item.codigoTipoDocumento.trim());
                            //console.log("se debe cargar el producto,el area y subarea y tiporeclamo se debe cargar la orden de compra")
                        }
                    }); 
                }else{
                        $("#estadoDocumento").val("");  
                        $("#select-tipo-documento").val("").change();
                        $("#select-subtipo-documento").val("").change();
                        $("#select-tipo-documento-desc").val("");
                        $("#select-subtipo-documento-desc").val("");
                }
                                               
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });
}


function onSubmitForm() 
{
    
    var frm = document.getElementById('form1');
    var valores = new FormData(frm);

    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/guardararchivos', 
        type : 'POST',      
        datatype : 'json',
        cache: false,
        contentType: false,
        processData: false,        
        data : valores, 
            beforeSend: function() {  
                $("#respuesta-subida-archivo").html("Subiendo archivo..."); 
            },success: function(data) {
                var obj = jQuery.parseJSON(data);
                $.each(obj, function(i, item) {                 
                    $("#respuesta-subida-archivo").html(item.MENSAJE);
                });
                obtenerArchivos();
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
}

function obtenerArchivos(){
    var codigoSolicitudDocumento = $("#codigoSolicitudDocumento").val();
    $("#codigoSolicitudDocumento2").val(codigoSolicitudDocumento);
    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenerarchivos', 
        type : 'POST',      
        datatype : 'json',      
        data : {'opcion':8,'codigoSolicitudDocumento':codigoSolicitudDocumento}, 
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                var html = "<table class='table mt-2'><thead bgcolor='#3482d3'><tr><th scope='col'>Proceso</th><th scope='col'>Descripción</th><th scope='col'>Acciones</th></tr></thead><tbody>";
                var idSecuenciaDocumentos="";
                $.each(obj, function(i, item) {
                    idSecuenciaDocumentos += item.idSecuencia+"|";                 
                    $("#respuesta-subida-archivo").html(item.MENSAJE);
                    html += "<tr><td>"+item.proceso+"</td><td>"+item.descDocumento+"</td><td><a class='btn btn-warning' target='_black' href='http://10.10.100.32/nqr/web/"+item.rutaDocumento+"'><i class='fa fa-eye'></i></a><a name='"+item.nombreDocumento+"' id='"+item.idSecuencia+"' onclick='EliminarDoc(this)' class=' btn btn-danger'><i class='glyphicon glyphicon-remove'></i></a></td></tr>";
                });
                html += "</tbody></table>";
                $("#respuesta-archivo").html(html);
                $("#idSecuenciaDocumentos").val(idSecuenciaDocumentos);
                $("#descDocumento").val("");
                $("#documento").val("");               
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    }); 
}

function EliminarDoc(valor)
{
    var idSecuencia = valor.id;
    var nombreDocumento = valor.name;
    var valores = {'idSecuencia':idSecuencia,'nombreDocumento':nombreDocumento};

    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/eliminararchivos', 
        type : 'POST',      
        datatype : 'json',      
        data : valores, 
            success: function(data) {
                $("#respuesta-subida-archivo").html(data);
               obtenerArchivos();    
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });    
}

function validarCorreos(valor)
{
    if(valor.trim() != ""){
        let e_stringCorreos = valor.replace(/\s+/g, '');
        const m_correos = e_stringCorreos.split(";");    
        correos_validos = m_correos.filter(function(value){
        if( /(.+)@(.+){2,}\.(.+){2,}/.test(value) == false){            
            swal("INFORMACIÓN!","Los contactos incorretos de (contactos receptor), fueron eliminados","info");
            $("#textarea-contactos-receptor").focus();
        }
            return /(.+)@(.+){2,}\.(.+){2,}/.test(value);
        })    
        $("#textarea-contactos-receptor").val(correos_validos.join(";"));
    }
}

function obtenerSubtipos()
{
    var codigoDocumento = $("#select-tipo-documento").val();
    var valores = {'codigoDocumento':codigoDocumento};    
    
    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenersubtipos', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            beforeSend: function() {   
                $("#select-subtipo-documento").append('<option value="">cargando...</option>');
            },success: function(data) {
                var obj = jQuery.parseJSON(data);
                $("#select-subtipo-documento").empty();
                $.each(obj, function(i, item) {                 
                    $("#select-subtipo-documento").append('<option value="'+item.codigoSubtipo+'">'+item.codigoSubtipo+" - "+item.descripcionSubtipo+'</option>');
                });

            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });    
}

function modalUsuarioArea(inputText){
    var codigoDocumento = $("#select-tipo-documento").val();
    var codigoSubtipo = $("#select-subtipo-documento").val(); 
    
    $("#inputText-titulo").html("BUSQUEDA DE "+inputText+"");
    $("#ModalInputText").modal('show');

}

function modalDatosProducto(inputText){
    
    $("#ModalProducto-titulo").html("BUSQUEDA DE "+inputText+"");
    $("#ModalDatosProducto").modal('show');

}

function agregarInputText(valor){
    var idInputText = $("#id-inputText").val();
    $("#"+idInputText+"").val(valor.value);
    if(idInputText=="AREA-RECEPTOR"){
        $("#USUARIO-RECEPTOR").val("");
        $("#select-item-producto").empty();
        var filtroBusqueda = $("#AREA-RECEPTOR").val();
        //obtener ordendes de compras
        obtenerDatoAdicional(filtroBusqueda,'AREA-RECEPTOR')
    }
    $("#ModalInputText").modal('hide');
}

function agregarInfoProducto(valor){
    var idModalProducto = $("#id-ModalProducto").val();
    $("#"+idModalProducto+"").val(valor.value);
    $("#ModalDatosProducto").modal('hide');
}

function obtenerDatoAdicional(filtroBusqueda,campo){
    var opcion = 0;
    if (campo=="AREA-RECEPTOR"){
        opcion = 12;
        $("#select-orden-compra").empty();
    }else if(campo=="select-orden-compra"){
        opcion = 13;
    }        
    
    $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenerdatosadicionales', 
        type : 'POST',      
        datatype : 'json',
        data : {'filtroBusqueda':filtroBusqueda,'opcion':opcion}, 
            beforeSend: function() {
                if (campo=="AREA-RECEPTOR"){
                    $("#select-orden-compra").append('<option value="">cargando...</option>');
                }else if(campo=="select-orden-compra"){
                    $("#select-item-producto").append('<option value="">cargando...</option>');
                }                  
            },success: function(data) {
                var obj = jQuery.parseJSON(data);
                    if (campo=="AREA-RECEPTOR"){
                        $("#select-orden-compra").empty(); 
                    }else if(campo=="select-orden-compra"){
                        $("#select-item-producto").empty(); 
                    }                                                               
                $.each(obj, function(i, item) {                    
                    //debo dejar seleccionado por defecto el sin-seleccion
                    if (campo=="AREA-RECEPTOR"){
                        $("#select-orden-compra").append('<option value="'+item.respuesta+'">'+item.respuesta+'</option>');
                    }else if(campo=="select-orden-compra"){
                        $("#select-item-producto").append('<option value="'+item.respuesta+'">'+item.respuesta+'</option>');
                    } 
                });
                    if (campo=="AREA-RECEPTOR"){
                        $("#select-orden-compra > option[value='SIN SELECCIÓN']").attr("selected",true);
                    }                 
            },error:function(data){
                if (campo=="AREA-RECEPTOR"){
                    $("#select-orden-compra").append('<option value="">Error de respuesta</option>');
                }else if(campo=="select-orden-compra"){
                    $("#select-item-producto").append('<option value="">Error de respuesta</option>');
                }                                  
            }
        });    
}

function modalAdjuntar()
{
    obtenerArchivos();
   $("#ModalAdjuntarArchivo").modal('show');
}

function modalNormas()
{
  $("#resultado-busqueda-normas").html("");
  $("#ModalNormas").modal('show');
}

function obtenerRequisitosClausulas()
{
  var codigoNorma = $("#select-normas").val();
  $.ajax({
        url: '/nqr/web/index.php?r=solicitud/obtenerclausulas', 
        type : 'POST',      
        datatype : 'json',
        data : {'codigoNorma':codigoNorma}, 
            beforeSend: function() {   

            },success: function(data) {
                //aqui se debe llenar el combo box
                var obj = jQuery.parseJSON(data);                
                $("#select-requisito-clausula").empty();
                $.each(obj, function(i, item) {                 
                    $("#select-requisito-clausula").append('<option value="'+item.idSecuencia+'">'+item.codigoNorma+" - "+item.requisito+'</option>');
                });
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
}

function agregarSeleccionRequisito(dato)
{
  var idRequisito = dato.value
  var requisito = dato.id
  var norma = dato.name  

  $("#normas-agregadas").append("<tr id='fila"+idRequisito+"'><td><button type='button' class='btn btn-danger' name='"+idRequisito+"' onclick='eliminarFila(this,1);'><i class='glyphicon glyphicon-trash'></i></button></td><td>"+norma+"</td><td>"+requisito+"</td></tr>");
  var valorAnterior = $("#select-requisito-clausula").val();
  $("#select-requisito-clausula").val(idRequisito+'|'+valorAnterior);
}

function agregarProducto()
{
    if($("#DATO-LOTE").val().trim() != ""){
        if($("#DATO-REFERENCIA").val().trim() != ""){
            if($("#DATO-MARCA").val().trim() != ""){

                var datoFactura =$("#DATO-FACTURA").val();
                var datoLote =$("#DATO-LOTE").val();
                var datoReferencia =$("#DATO-REFERENCIA").val();
                var datoMarca = $("#DATO-MARCA").val();
                var datoContenedor =$("#DATO-CONTENEDOR").val();
                var valores = {'datoFactura':datoFactura,'datoLote':datoLote,'datoReferencia':datoReferencia,'datoMarca':datoMarca,'datoContenedor':datoContenedor}

                //PRIMERO SE LO INGRESA A UNA TABLA TEMPORAL Y LUEGO SE OBTIENE ESE INGRESO REALIZADO CON EL ID
                $.ajax({
                url: '/nqr/web/index.php?r=solicitud/guardarproductotemp', 
                type : 'POST',      
                datatype : 'json',
                data : valores, 
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function(i, item) {				
                            $("#productos-agregados").append("<tr id='fila2"+item.RESPUESTA+"'><td><button type='button' class='btn btn-danger' name='"+item.RESPUESTA+"' onclick='eliminarFila(this,2);'><i class='glyphicon glyphicon-trash'></i></button></td><td>"+datoLote+"</td><td>"+datoReferencia+"</td><td>"+datoMarca+"</td><td>"+datoFactura+"</td><td>"+datoContenedor+"</td></tr>");                            
                            var valorAnterior = $("#select-productos").val();
                            $("#select-productos").val(item.RESPUESTA+'|'+valorAnterior);
                        });                                                 
                        $(".DATOS-PRODUCTO").val("");
                    }
                    ,error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                }); 

            }else{
                swal("Lo SENTIMOS!","No puede agregar un producto, si el campo (marca), esta vacío ","info");
                $("body").removeClass("stop-scrolling");   
            }
        }else{
            swal("Lo SENTIMOS!","No puede agregar un producto, si el campo (referencia), esta vacío ","info");
            $("body").removeClass("stop-scrolling");
        }
    }else{
        swal("Lo SENTIMOS!","No puede agregar un producto, si el campo (Lote producción), esta vacío ","info");
        $("body").removeClass("stop-scrolling");
    }
}

function eliminarFila(e,opcion) 
{

    if(opcion==1){
        $("#fila" + e.name).remove();  
        var requisitos = $("#select-requisito-clausula").val();

        var textoseparado = requisitos.split("|");//.map(Number);
        //busco en el array si existe el valor
        var i = textoseparado.indexOf(e.name);
        if ( i !== -1 ) {
        textoseparado.splice( i, 1 );
        var arrayNuevo = ""
        $.each(textoseparado, function (ind, elem) {
            if (elem != "") {
            arrayNuevo =arrayNuevo +elem+'|';
            }                                             
        }); 
        $("#select-requisito-clausula").val(arrayNuevo);      
    }
    }else if(opcion==2){
        $("#fila2" + e.name).remove();  
        var requisitos2 = $("#select-productos").val();

        var textoseparado2 = requisitos2.split("|")//.map(Number);
        //busco en el array si existe el valor
        var i = textoseparado2.indexOf(e.name);
        if ( i !== -1 ) {
        textoseparado2.splice( i, 1 );
        var arrayNuevo2 = ""
        $.each(textoseparado2, function (ind, elem) {
            if (elem != "") {
            arrayNuevo2 =arrayNuevo2 +elem+'|';
            }                                             
        }); 
        $("#select-productos").val(arrayNuevo2); 
    }
}
}

function mayus(e) {
  var tecla=e.value;
  var tecla2=tecla.toUpperCase();
  $("#cod-auditoria").val(tecla2);
}

////FUNCIONES PARA LA GENERACION DE SOLICITUDES
function generarSolicitud()
{

    var codigoSolicitudDocumento = $("#codigoSolicitudDocumento").val();
    var codigoDocumento = $("#select-tipo-documento").val();
    var codigoSubtipo = $("#select-subtipo-documento").val();
    var codauditoria = $("#cod-auditoria").val();
    var usuarioEmisor = $("#USUARIO-EMISOR").val();
    var usuarioReceptor = $("#USUARIO-RECEPTOR").val();
    var areaEmisor = $("#AREA-EMISOR").val();
    var areaReceptor = $("#AREA-RECEPTOR").val(); 
    var contactosReceptor = $("#textarea-contactos-receptor").val();    
    var hallazgo = $("#textarea-hallazgo").val();
    var tratamientoInmediato = $("#textarea-tratamiento-inmediato").val();
    var fechaCuandOcurrio = $("#fechaOcurrio").val();
    var dondeOcurrioArea = $("#select-dondeOcurrioAreas").val();
    var dondeOcurrioSubArea = $("#select-subAreas").val();
    var codigosNormas = $("#select-requisito-clausula").val(); 
    var codigosProductos = $("#select-productos").val();
    var tipoReclamo = $("#select-tipoReclamo").val();
    var ordenCompra = $("#select-orden-compra").val();
    var itemProducto = $("#select-item-producto").val();
    var idSecuenciaDocumentos = $("#idSecuenciaDocumentos").val();
    var valores = {'codigoDocumento':codigoDocumento,'codigoSolicitudDocumento':codigoSolicitudDocumento,'codigoSubtipo':codigoSubtipo,'codauditoria':codauditoria
                    ,'usuarioEmisor':usuarioEmisor,'usuarioReceptor':usuarioReceptor,'areaEmisor':areaEmisor,'areaReceptor':areaReceptor
                    ,'contactosReceptor':contactosReceptor,'hallazgo':hallazgo,'tratamientoInmediato':tratamientoInmediato
                    ,'fechaCuandOcurrio':fechaCuandOcurrio,'dondeOcurrioArea':dondeOcurrioArea,'dondeOcurrioSubArea':dondeOcurrioSubArea
                    ,'codigosNormas':codigosNormas,'codigosProductos':codigosProductos,'tipoReclamo':tipoReclamo,'ordenCompra':ordenCompra,'itemProducto':itemProducto,'idSecuenciaDocumentos':idSecuenciaDocumentos};
    //VALIDACION DE EL AREA Y USUARIO EMISOR Y RECEPTOR
    if(usuarioEmisor.trim().length > 3){
        if(areaEmisor.trim().length > 3){
            if(usuarioReceptor.trim().length > 3){
                if(areaReceptor.trim().length > 3){
                    //VALIDACION DE QUE EL HALLAZGO SEA INGRESADO
                    if (hallazgo.trim().length  > 50){
                      //VALIDACION PARA EL TRATAMIENTO INMEDIATO
                      if(tratamientoInmediato.trim().length >20){

                        swal({
                          title: "Actualizar solicitud",
                          text: "Desea continuar con la actualización?",
                          type: "info",
                          showCancelButton: true,
                          closeOnConfirm: false,
                          confirmButtonText: "Actualizar",
                          cancelButtonText: "Cancelar",
                          showLoaderOnConfirm: true
                          }, function () {      
                            $.ajax({
                              url: '/nqr/web/index.php?r=solicitud/actualizardocumento', 
                              type : 'POST',      
                              datatype : 'json',
                              data : valores, 
                                success: function(data) {   
                                    console.log(data);         
                                  var obj = jQuery.parseJSON(data);
                                  $.each(obj, function(i, item) {

                                    swal(item.MENSAJE+''+item.RESPUESTA);
                                    if(item.ESTADO == 1){
                                        obtenerDocumento();
                                    }                   
                                  });
                                      
                                },error:function(data){
                                  swal("FATAL!", data, "error"); 
                                }
                              });
                        });
                      }else{
                        $("#textarea-tratamiento-inmediato").focus();
                        swal("Incompleto!", "El tratamiento Inmediato debe tener minimo de 20 caracteres", "info");
                      } 
                    }else{
                      $("#textarea-hallazgo").focus();
                      swal("Incompleto!", "El hallazgo debe tener minimo de 50 caracteres", "info");
                    } 
                }else{
                    swal("Incompleto!", "El area del receptor no debe quedar vacío", "info");
                }
            }else{
                swal("Incompleto!", "El usuario del receptor no debe quedar vacío", "info");
            }
        }else{
            swal("Incompleto!", "El area del emisor no debe quedar vacío", "info");
        }
    }else{
        swal("Incompleto!", "El usuario del emisor no debe quedar vacío", "info");
    }    
}


///FUNCIONES PARA CARGAR LOS ADICIONALES DEPENDIENDO DEL SUBTIPO DE DOCUMENTO
function cargarDatosNC(codigoSolicitudDocumento,codigoTipoDocumento){

    $.ajax({
    url: '/nqr/web/index.php?r=solicitud/cargardatos', 
    type : 'POST',      
    datatype : 'json',
    data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'codigoTipoDocumento':codigoTipoDocumento}, 
        success: function(data) {
            $("#normas-agregadas").empty();
            var obj = jQuery.parseJSON(data);
            $.each(obj, function(i, item) {             
              $("#normas-agregadas").append("<tr id='fila"+item.idSecuencia+"'><td><button type='button' class='btn btn-danger' name='"+item.idSecuencia+"' onclick='eliminarFila(this,1);'><i class='glyphicon glyphicon-trash'></i></button></td><td>"+item.codigoNorma+"</td><td>"+item.requisito+"</td></tr>");
             });
             cargarDatosQU(codigoSolicitudDocumento,'QU');                                         
        }
        ,error:function(data){
            swal("FATAL!","Error al cargar los datos de las normas", "error"); 
        }
    });
}

function cargarDatosQU(codigoSolicitudDocumento,codigoTipoDocumento){
    $.ajax({
    url: '/nqr/web/index.php?r=solicitud/cargardatos', 
    type : 'POST',      
    datatype : 'json',
    data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'codigoTipoDocumento':codigoTipoDocumento}, 
        success: function(data) {
            var obj = jQuery.parseJSON(data);
            $.each(obj, function(i, item) {  
            //ordenCompraGp,itemProductoGp           
                $("#select-dondeOcurrioAreas").val(item.areaDondeOcurrio);
                $("#select-subAreas").val(item.subAreaDondeOcurrio);
                $("#select-orden-compra").empty();
                $("#select-item-producto").empty();
                $("#select-orden-compra").append('<option value="'+item.ordenCompraGp+'">'+item.ordenCompraGp+'</option>');
                $("#select-item-producto").append('<option value="'+item.itemProductoGp+'">'+item.itemProductoGp+'</option>');

             });                                 
        }
        ,error:function(data){
            swal("FATAL!","Error al cargar los datos del area y subarea", "error"); 
        }
    });
}

function cargarDatosRE(codigoSolicitudDocumento,codigoTipoDocumento){
    $.ajax({
    url: '/nqr/web/index.php?r=solicitud/cargardatos', 
    type : 'POST',      
    datatype : 'json',
    data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'codigoTipoDocumento':codigoTipoDocumento}, 
        success: function(data) {           

            $("#productos-agregados").empty();
            var obj = jQuery.parseJSON(data);
            $.each(obj, function(i, item) {             
                $("#productos-agregados").append("<tr id='fila2"+item.idSecuencia+"'><td><button type='button' class='btn btn-danger' name='"+item.idSecuencia+"' onclick='eliminarFila(this,2);'><i class='glyphicon glyphicon-trash'></i></button></td><td>"+item.codigoProduccion+"</td><td>"+item.referencia+"</td><td>"+item.marca+"</td><td>"+item.factura+"</td><td>"+item.contenedor+"</td></tr>");                            
             });
             cargarDatosQU(codigoSolicitudDocumento,'QU');                                               
        }
        ,error:function(data){
            swal("FATAL!","Error al cargar los datos del producto", "error"); 
        }
    });

}

</script>