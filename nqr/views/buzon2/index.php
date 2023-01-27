<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
use yii\jui\DatePicker;
?>

<style type="text/css">
    .btn-circle.btn-xl {
        width: 70px;
        height: 70px;
        padding: 10px 16px;
        border-radius: 35px;
        font-size: 24px;
        line-height: 1.33;
    }
    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }
    .size-botones-buzon{
        width: 220px;
    }
    .size-botones-plan{
        width: 80px;
    }    
    .fullscreen-modal  {
        margin: 20;
        margin-right: auto;
        margin-left: auto;
        width: 90%;
    }

</style>

<!-- Main content -->
<section class="content">
<div class="box box-default">
    <div class="box-header with-border">        
      <h3 class="box-title">Filtro de búsqueda</h3> 
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <!--INFORMACION GENERAL-->
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="form-group">
                    <label>Tipo Documento</label>
                    <select class="form-control select2 control-buqueda" id="select-tipo-documento" style="width: 100%;">
                    <?php
                    foreach($tipoDocumentos as $row)
                    {
                    ?>
                      <option value='<?php echo $row['codigoDocumento'];?>' name='<?php echo $row['codigoDocumento'];?>' ><?php echo $row['codigoDocumento']." - ";  echo $row['descripcionDocumento'];?></option>	
                    <?php
                    }
                    ?>     
                    </select>
                </div>
            </div> 
            <div class="col-md-2 col-sm-6">
                <div class="form-group">
                    <label>Estado Documento</label>
                    <select class="form-control select2 control-buqueda" id="select-estado-documento" style="width: 100%;">
                        <option value='SN'>SN-TODAS</option>
                        <option value='G'>G-GENERADO</option>
                        <option value='C'>C-CONFIRMADO</option>	                    	
                        <option value='R'>R-RECHAZADO</option>
                        <option value='P'>P-PLANIFICADO</option>
                        <option value='A'>A-APROBADO</option> 
                        <option value='CE'>CE-CERRADO</option>                    	
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label>Fecha inicio</label>
                    <!-- /.input group -->
                    <?= DatePicker::widget(['name' => 'fechaInicio',
                                        'options' => ['class' => 'form-control control-buqueda','id' => 'fechaInicio'],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?> 

                </div>
            </div> 
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label>Fecha fin</label>
                    <!-- /.input group -->
                    <?= DatePicker::widget(['name' => 'fechaFin',
                                        'options' => ['class' => 'form-control control-buqueda','id' => 'fechaFin'],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?> 

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
            <th scope="col" bgcolor='#dedcd5'>Cod. Solicitud</th>
            <th scope="col" bgcolor='#dedcd5'>Cod. Documento</th>
            <th scope="col" bgcolor='#dedcd5'>Usuario genera</th>
            <th scope="col" bgcolor='#dedcd5'>Tipo documento</th>
            <th scope="col" bgcolor='#dedcd5'>Subtipo documento</th>
            <th scope="col" bgcolor='#dedcd5'>Area responsable</th>
            <th scope="col" bgcolor='#dedcd5'>Gestor</th>            
            <th scope="col" bgcolor='#dedcd5'>Tipo reclamo</th>                                
            <th scope="col" bgcolor='#dedcd5'>Clasificación</th>
            <th scope="col" bgcolor='#dedcd5'>Sub-Clasificación</th>
            <th scope="col" bgcolor='#afaf0a'>Generado</th>
            <th scope="col" bgcolor='#3482d3'>Confirmado</th>
            <th scope="col" bgcolor='#C70039'>Rechazado</th>
            <th scope="col" bgcolor='#99a5a6'>Planificado</th>
            <th scope="col" bgcolor='#99a5a6'>Aprobado</th>
            <th scope="col" bgcolor='#99a5a6'>%US</th>
            <th scope="col" bgcolor='#99a5a6'>%SG</th>
            <th scope="col" bgcolor='#dedcd5'>Valoración economica</th>
            <th scope="col" bgcolor='#0a6771'>Cerrado</th>
            </tr>
        </thead>
        <tbody id="resultado-busqueda">
        </tbody>
    </table>
</div>  

<!-- Modal VER SOLICITUD-->
<div class="modal fade" id="ModalVerSolicitud" tabindex="-1" role="dialog" aria-labelledby="ModalVerSolicitud" aria-hidden="true">
  <div class="fullscreen-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalVerSolicitud">SOLICITUD GENERADA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
        <div id="resultado-verSolicitud"></div>
        <div class="row">
            <div class="col-md-3 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-EMISOR-USUARIO OPCIONES-DOC">
                <label>código solicitud</label>            
                <div class="input-group">            
                    <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                    <input type="text" class="form-control EMISOR-RECEPTOR USUARIO-EMISOR" id="ver-codigoSolicitudDocumento" readonly>
                </div> 
            </div>
            <div class="col-md-3 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-EMISOR-USUARIO OPCIONES-DOC">
                <label>código documento</label>            
                <div class="input-group">            
                    <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                    <input type="text" class="form-control EMISOR-RECEPTOR USUARIO-EMISOR" id="ver-codigoDocumento" readonly>
                </div> 
            </div>            
            <div class="col-md-3 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-EMISOR-USUARIO OPCIONES-DOC">
                <label>Tipo de documento</label>            
                <div class="input-group">            
                    <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                    <input type="text" class="form-control EMISOR-RECEPTOR USUARIO-EMISOR" id="ver-tipoDocumento" readonly>
                </div> 
            </div> 
            <div class="col-md-3 col-sm-6 OPCIONES ECE ECL INT PRO SGE OPCIONES-EMISOR-USUARIO OPCIONES-DOC">
                <label>Subtipo de documento</label>            
                <div class="input-group">            
                    <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                    <input type="text" class="form-control EMISOR-RECEPTOR USUARIO-EMISOR" id="ver-tipoDocumentos" readonly>
                </div> 
            </div> 
        </div>
            <h4 class="OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP"><strong>INFORMACIÓN DEL EMISOR Y RECEPTOR</strong></h4> 
            <div class="row">
                <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP" ><!--EMISORES-->
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
                <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP"><!--RECEPTORES-->
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
            <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP">
                <label>Hallazgo</label>
                <textarea class="textarea" placeholder="Escriba el hallazgo" id="ver-textarea-hallazgo"
                                        style="width: 100%; height: 90px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly></textarea>
                        
                                
            </div> 
            <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP">
                <label>Tratamiento Inmediato</label>
                <textarea class="textarea" placeholder="Escriba el tratamiento inmediato" id="ver-textarea-tratamiento-inmediato"
                                        style="width: 100%; height: 90px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly></textarea>
                        
                                
            </div> 
            <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP">
                <label>Evaluación de consecuencias</label>
                <textarea class="textarea" placeholder="Escriba el tratamiento inmediato" id="ver-textarea-evaluacion-consecuencias"
                                        style="width: 100%; height: 90px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly></textarea>
                        
                                
            </div>
            <div class="col-md-6 OPCIONES ECE ECL INT PRO SGE QUE QUI REC REI REP">
                <label>Listado de documentos</label>
                <div class="table-responsive">
                        <table class='table table-bordered' >
                            <thead bgcolor='#3482d3'>
                                <tr><th scope='col'>Proceso</th><th scope='col'>Descripción</th><th scope='col'>Acción</th></tr>
                            </thead>
                            <tbody id='ver-solicitud-documentos'>
                            </tbody>
                        </table>                
                </div>                                  
            </div>                         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal PLAN DE ACCION-->
<div class="modal fade" id="ModalPlanAccion" tabindex="-1" role="dialog" aria-labelledby="ModalPlanAccion" aria-hidden="true">
  <div class="fullscreen-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalPlanAccion">PLAN DE ACCIÓN CORRECTIVAS Y/O PREVENTIVAS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <label>código documento</label>            
                    <div class="input-group">            
                        <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                        <input type="text" class="form-control" id="plan-codigoDocumento2" readonly>
                        <input type="hidden" class="form-control" id="plan-codigoDocumento" readonly>
                    </div> 
                </div>
                <div class="col-md-8 col-sm-12">
                    <label>Hallazgo</label>
                    <textarea class="textarea" placeholder="Escriba el tratamiento inmediato" id="plan-hallazgo"
                                        style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly>
                    </textarea>              
                </div>                   
            </div>
            <!--OPCIONES DE LA CAUSA-->
            <div class="row">
                <div class="col-md-12">
                    <h5 class=""><strong>DATOS DE LA CAUSA</strong></h5>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive ">                    
                        <table class='table table-bordered' >
                            <thead bgcolor='#dedcd5'>
                                <tr><th scope='col'>Causa</th><th scope='col'>Detalle</th><th scope='col'>Accion</th></tr>
                                <tr class="resultado-cabecera-plan">
                                    <th scope='col'>                    
                                        <select class="form-control select2" id="input-select-causa" style="width: 100%;">
                                            <option value='MÉTODO'>MÉTODO</option>
                                            <option value='MÁQUINA'>MÁQUINA</option>	                    	
                                            <option value='MATERIALES'>MATERIALES</option>
                                            <option value='MANO DE OBRA'>MANO DE OBRA</option>
                                            <option value='MEDIO AMBIENTE'>MEDIO AMBIENTE</option>                                             
                                        </select>
                                    </th>
                                    <th scope='col'><input type="text" class="form-control" id="input-causa-detalle"></th>
                                    <th scope='col'><button type='button'  class='btn btn-warning' id='btn-agregar-causa' onclick="agregarCausaPlan(this)"><span class=''> + Agregar</span></button></th>
                                </tr>
                            </thead>
                            <tbody id='resultado-causas'>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" class="form-control" id="causas-agregadas">    
                </div>               
            </div>
            <!--OPCIONES DEL PLAN DE ACCION-->
            <div class="row">
                <div class="col-md-12">
                    <h5 class=""><strong>PLAN DE ACCIÓN CORRECTIVAS Y/O PREVENTIVAS</strong></h5>  
                </div>
                <div class="col-sm-4 col-md-4 col-lg-2 opcion-plan opcion-fechas" style="display:none"> 
                                        <?= DatePicker::widget(['name' => 'fr-inicio2',
                                        'options' => ['class' => 'form-control ','id' => 'fr-inicio2','readonly'=>true],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-2 opcion-plan opcion-fechas" style="display:none"> 
                                        <?= DatePicker::widget(['name' => 'fr-fin2',
                                        'options' => ['class' => 'form-control ','id' => 'fr-fin2','readonly'=>true],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?>
                </div>                
                <div class="col-sm-4 col-md-4 col-lg-2 opcion-plan opcion-avance" style="display:none">                              
                    <select class="form-control select2 control-buqueda" id="plan-avance" style="width: 100%;">
                        <option value='0' selected="true">0 %</option>
                        <option value='25'>25 %</option>
                        <option value='50'>50 %</option>                        
                        <option value='75'>75 %</option>                        
                        <option value='100'>100 %</option>                      
                    </select>                       
                </div>
                <div class="col-sm-4 col-md-4 col-lg-2 opcion-plan opcion-estadoPlan" style="display:none">                    
                    <select class="form-control select2 control-buqueda" id="plan-select-estadoPlan" style="width: 100%;">
                        <option value='R'>R-RECHAZADO</option>
                        <option value='F'>F-FINALIZADO</option>                     
                    </select>                                    
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 opcion-plan opcion-estadoPlan rechazo-tarea-retroalimentacion" style="display:none">                    
                    <input type="text" class="form-control" id="rechazo-tarea-retroalimentacion" name="rechazo-tarea-retroalimentacion" placeholder="Retroalimentación">                               
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4  opcion-plan opcion-documento" style="display:none">
                    <form enctype="multipart/form-data" id="form1" >
                    <input type="hidden" class="form-control" id="idSecuencia-avances" name="idSecuencia-avances">
                    <input type="hidden" class="form-control" id="accion-avances" name="accion-avances">                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" class="form-control" id="documento" name="documento">
                                </div>
                            </div>
                        </div>              
                    </form>                     
                </div>                                                    
                <div class="col-sm-4 col-md-4 col-lg-6 opcion-plan opcion-btn-avances" style="display:none">
                    <div class="form-group">
                        <button type='button' class='btn btn-primary' id='btn-actualizar-plan-avances' onclick='actualizarPlanAvances(this)' ><span class='fa fa-save'> Actualizar</span></button>                                        
                        <button type='button' class='btn btn-default' id='btn-cancelar-plan-avances' onclick='actualizarPlanAvances(this)' ><span class='fa fa-compress'></span></button>                
                    </div>    
                </div>
                <div class="col-md-12">
                    <div class="table table-responsive">                    
                        <table class='table table-bordered' >
                            <thead bgcolor='#dedcd5'>
                                <tr><th scope='col'><div class="size-botones-plan"> Avances</div></th><th scope='col'>Tarea</th><th scope='col'>Área</th><th scope='col'>Puesto</th><th scope='col'>Nombre</th><th scope='col'>Inicio f. prevista</th><th scope='col'>Fin f. prevista</th><th scope='col'>Inicio f. real</th><th scope='col'>Fin f. real</th><th scope='col'>Accion</th></tr>
                                <tr class="resultado-cabecera-plan">
                                    <th scope='col'></th>
                                    <th scope='col'><input type="text" class="form-control" id="input-tarea"></th>
                                    <th scope='col'>                    
                                        <select class="form-control select2" id="input-select-area" style="width: 100%;">
                                        <?php
                                            foreach($areas as $row)
                                            {
                                            ?>
                                            <option value='<?php echo $row['descripcionArea'];?>' name='<?php echo $row['descripcionArea'];?>' ><?php echo $row['descripcionArea'];?></option>  
                                            <?php
                                            }
                                        ?>                                                              
                                        </select>
                                    </th>
                                    <th scope='col'>                    
                                        <select class="form-control select2" id="input-select-puesto" style="width: 100%;">                     
                                        </select>
                                    </th>
                                    <th scope='col'>                    
                                        <select class="form-control select2" id="input-select-nombre" style="width: 100%;">                     
                                        </select>
                                    </th>
                                    <th scope='col'>                        
                                        <?= DatePicker::widget(['name' => 'fp-inicio',
                                        'options' => ['class' => 'form-control ','id' => 'fp-inicio','readonly'=>true],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?>
                                    </th>
                                    <th scope='col'>                        
                                        <?= DatePicker::widget(['name' => 'fp-fin',
                                        'options' => ['class' => 'form-control ','id' => 'fp-fin','readonly'=>true],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?>
                                    </th>
                                    <th scope='col'>                        
                                        <?= DatePicker::widget(['name' => 'fr-inicio',
                                        'options' => ['class' => 'form-control ','id' => 'fr-inicio','readonly'=>true,'disabled'=>true],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?>
                                    </th>
                                    <th scope='col'>                        
                                        <?= DatePicker::widget(['name' => 'fr-fin',
                                        'options' => ['class' => 'form-control ','id' => 'fr-fin','readonly'=>true,'disabled'=>true],
                                        'attribute' => 'from_date',                                
                                        'language' => 'es',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'value' => date('Y-m-d'),])?>
                                    </th>
                                    <th scope='col'><button type='button'  class='btn btn-warning' id='btn-agregar-plan' onclick="agregarCausaPlan(this)"><span class=''> + Agregar</span></button></th></tr>
                            </thead>
                            <tbody id='resultado-plan-accion'>                            
                            </tbody>
                        </table>
                    </div>                    
                </div>
                <div class="col-md-12">                    
                    <div class="alert alert-success" role="alert" id="resultado-clases" style="display: none">                     
                        <div class="resultado-mensaje">       
                        </div>                      
                    </div>                   
                </div>                          
            </div>
            <!--BOTONES DEL FORMULARIO-->
            <div class='row'>
                <div class="col-md-12 OPCIONES BOTONES-PLAN" style="display: none" >
                    <div class="form-group">
                        <button type='button' class='btn btn-default' id='btn-notificar-plan' onclick="aprobarRechazarPlan(this)" ><span class='fa fa-send-o'> Notificar</span></button>                                          
                    </div>
                </div> 
            </div>                    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal CAMPOS ADICIONALES-->
<div class="modal fade" id="ModalcamposAdicionales" tabindex="-1" role="dialog" aria-labelledby="ModalcamposAdicionales" aria-hidden="true">
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
                <input type="hidden" id="codigoSolicitudDocumento">
                <input type="hidden" id="opcion">
                <label><div id ="titulo-busqueda"></div></label>
                <input type="text" class="form-control" id="input-busqueda-adicionales">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div id='resultado-busqueda-adicionales'></div>
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
$(".control-buqueda").change(function(){
    obtenerBusquedaNQR();
});
$(document).ready(function (){
    obtenerBusquedaNQR();
});
$("#input-busqueda-adicionales").keyup(function(){

    var codigoSolicitudDocumento = $("#codigoSolicitudDocumento").val();
    var dato = $("#input-busqueda-adicionales").val();
    var opcion ="";
    if ($("#opcion").val() == "areaResponsable"){
        opcion ="4";
    }
    if ($("#opcion").val() == "gestor"){
        opcion ="5";
    }
    if ($("#opcion").val() == "tipoReclamo"){
        opcion ="6";
    }
    if ($("#opcion").val() == "clasificacion"){
        opcion ="15";
    }
    if ($("#opcion").val() == "subclasificacion"){
        opcion ="16";
    }            
    var valores = {'opcion':opcion,'codigoSolicitudDocumento':codigoSolicitudDocumento,'dato':dato,'accion':'V','opcion':opcion};

    $.ajax({
        url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            success: function(data) {
                var html= "";
                if (data == '[]')
                {
                    html += "No hay datos";
                }else{
                    html += "<div class='table-responsive'><table class='table table-bordered'><thead><tr><th scope='col'>Seleccionar</th><th scope='col'>AREA RESPONSABLE</th></tr></thead><tbody>";
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, item) {            
                        html += "<tr><td><button type='button' class='btn btn-warning' value='"+item.valor+"' id='"+item.idSecuencia+"' onclick='actualizarAdicionales(this)' ><span class='fa fa-hand-pointer-o'></span></button></td><td>"+item.valor+"</td></tr>";
                    });
                    html += "</tbody></table></div>";
                } 
                $("#resultado-busqueda-adicionales").html(html);

            },error:function(data){
                $("#resultado-busqueda-adicionales").html("<p>Hubo un error en la base de datos.</p>")
            }
        });    
});
$("#input-select-area").change(function(){
    obtenerDatosPlan(1);
})
$("#input-select-puesto").change(function(){
    obtenerDatosPlan(2);
})
JS;
$this->REGISTERJS($script);
?>

<script>
function obtenerBusquedaNQR()
{
  var tipoDocumento = $("#select-tipo-documento").val();
  var estadoDocumento = $("#select-estado-documento").val();
  var fechaInicio = $("#fechaInicio").val();
  var fechaFin = $("#fechaFin").val();

  var valores = {'tipoDocumento':tipoDocumento,'estadoDocumento':estadoDocumento,'fechaInicio':fechaInicio,'fechaFin':fechaFin};

  $.ajax({
        url: '/nqr/web/index.php?r=buzon/obtenerbusquedanqr', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            success: function(data) {
                var dataSolicitudes = JSON.parse(data);
 
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
                                    var html = "";
                                    if (data["estadoSolicitud"] == "G"){
                                        html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud'><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias'disabled='true'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción' disabled='true'><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                    }else if(data["estadoSolicitud"] == "C"){
                                        html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud'><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias' disabled='true'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción'><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                    }else if(data["estadoSolicitud"] == "R"){
                                        html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud'><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias' disabled='true'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción' disabled='true'><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                    }else if(data["estadoSolicitud"] == "I"){
                                        html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud'><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias' ><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción' disabled='true'><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                    }else if(data["estadoSolicitud"] == "P"){
                                        html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud'><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias' disabled='true'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción'><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                    }else if(data["estadoSolicitud"] == "A"){
                                        if(data["us"]=="100%" && data["sg"]=="100%"){
                                            html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud'><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias' disabled='true'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción'><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                        }else{
                                            html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud'><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias' disabled='true'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción'><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                        }                                                                                 
                                    }else if(data["estadoSolicitud"] == "CE"){
                                        html = "<button type='button' value='"+data['codigoSolicitudDocumento']+"' name='1' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Visualizar solicitud' ><i class='fa fa-eye'></i></button><button type='button' class='btn btn-success btn-circle' value='"+data['codigoSolicitudDocumento']+"' name='2' onclick='gestionBuzon(this)' data-toggle='tooltip' data-placement='top' title='Confirmar solicitud' disabled='true'><i class='fa fa-check'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='3' onclick='gestionBuzon(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Rechazar solicitud' disabled='true'><i class='fa fa-close'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='4' onclick='gestionBuzon(this)' class='btn btn-default btn-circle'  data-toggle='tooltip' data-placement='top' title='Visualizar retroalimentación'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='5' onclick='gestionBuzon(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Agregar evaluación de consecuencias' disabled='true'><i class='fa fa-commenting'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='6' onclick='gestionBuzon(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Plan de acción' ><i class='fa fa-calendar-minus-o'></i></button><button type='button' value='"+data['codigoSolicitudDocumento']+"' name='7' onclick='' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Cerrar documento' disabled='true'><i class='fa fa-file-zip-o'></i></button>";
                                    }
                                    
                                    return html;
                                },
                            }
                            ,{"data": null,
                                render:function(data, type, row)                        
                                    {//janchundia
                                        if (data['codigoTipoDocumento'] == "NC"){
                                        var html = "<a href='//produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteIndividualNCNQR&tipoDocumento="+data['codigoTipoDocumento']+"&codigoSolicitudDocumento="+data['codigoSolicitudDocumento']+"' target='_blank' name='areaResponsable' id='"+data['codigoSolicitudDocumento']+"'>"+data['codigoSolicitudDocumento']+"</a>";
                                        }else if(data['codigoTipoDocumento'] == "QU"){
                                        var html = "<a href='//produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteIndividualQUNQR&tipoDocumento="+data['codigoTipoDocumento']+"&codigoSolicitudDocumento="+data['codigoSolicitudDocumento']+"' target='_blank' name='areaResponsable' id='"+data['codigoSolicitudDocumento']+"'>"+data['codigoSolicitudDocumento']+"</a>";
                                        }else if(data['codigoTipoDocumento'] == "RE"){
                                        var html = "<a href='//produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteIndividualRENQR&tipoDocumento="+data['codigoTipoDocumento']+"&codigoSolicitudDocumento="+data['codigoSolicitudDocumento']+"' target='_blank' name='areaResponsable' id='"+data['codigoSolicitudDocumento']+"'>"+data['codigoSolicitudDocumento']+"</a>";
                                        }                                                         
                                        return html;
                                    },
                            }
                            ,{ data: "codigoDocumento" },{data:"usuarioCrea"}
                            ,{data: "descripcionDocumento" }, { data: "descripcionSubtipo" }
                            ,{"data": null,
                                render:function(data, type, row)                        
                                    {
                                        var html = "<a href='#' name='areaResponsable' id='"+data['codigoSolicitudDocumento']+"' onclick=''>"+data['areaResponsable']+"</a>";                                                                
                                        return html;
                                    },
                            }
                            ,{"data": null,
                                render:function(data, type, row)                        
                                    {
                                        var html = "<a href='#' name='gestor' id='"+data['codigoSolicitudDocumento']+"' onclick=''>"+data['gestor']+"</a>";                                                                
                                        return html;
                                    },
                            }
                            ,{"data": null,
                                render:function(data, type, row)                        
                                    {
                                        var html = "<a href='#' name='tipoReclamo' id='"+data['codigoSolicitudDocumento']+"' onclick=''>"+data['tipoReclamo']+"</a>";                                                                
                                        return html;
                                    },
                            }  
                            ,{"data": null,
                                render:function(data, type, row)                        
                                    {
                                        var html = "<a href='#' name='clasificacion' id='"+data['codigoSolicitudDocumento']+"' onclick=''>"+data['clasificacion']+"</a>";                                                                
                                        return html;
                                    },
                            }  
                            ,{"data": null,
                                render:function(data, type, row)                        
                                    {
                                        var html = "<a href='#' name='subclasificacion' id='"+data['codigoSolicitudDocumento']+"' onclick=''>"+data['subclasificacion']+"</a>";                                                                
                                        return html;
                                    },
                            }                                                                                                                 
                            ,{ data: "fechaGenerado" },{data:"fechaConfirmado"}
                            ,{data: "fechaRechazado" }, { data: "fechaPlanificado" }, { data: "fechaAprobado" },{data:"us"}
                            ,{data: "sg" }
                            ,{"data": null,
                                render:function(data, type, row)                        
                                    {
                                        var html = "<a href='#' name='valoracionEconomica' id='"+data['codigoSolicitudDocumento']+"' onclick='gestionBuzonAdicionales(this)'>"+data['valoracionEconomica']+"</a>";                                                                
                                        return html;
                                    },
                            }
                            ,{ data: "fechaCerrado" }],
                });              

            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });
}

function gestionBuzonAdicionales (boton)
{
    var  codigoSolicitudDocumento = boton.id;

    if (boton.name == "valoracionEconomica")
    {
        swal({
            title: "Ingreso valoración economica!",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText:"Guardar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "Escriba..."
            }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue.trim() === "") { //inputValue.replace(/[^0-9]/g,'')
                swal.showInputError("Campo obligatorio!");
                return false
            }else{
                var valores = {'codigoSolicitudDocumento':codigoSolicitudDocumento,'accion':'I','opcion':18,'valoracionEconomica':inputValue};
                $.ajax({
                    url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
                    type : 'POST',      
                    datatype : 'json',
                    data : valores, 
                        success: function(data) { 
                            $("#ModalcamposAdicionales").modal('hide');
                            var obj = jQuery.parseJSON(data);
                            $.each(obj, function(i, item) {         
                                swal(item.MENSAJE+''+item.RESPUESTA);                   
                            });
                            obtenerBusquedaNQR();
                        },error:function(data){
                            swal("FATAL!", data, "error"); 
                        }
                }); 
            }
        });     


    }else{
        $("#titulo-busqueda").html("Busqueda "+boton.name);
        $("#codigoSolicitudDocumento").val(codigoSolicitudDocumento);
        $("#opcion").val(boton.name);//busqueda de tipos de documentos ;*/
        $("#resultado-busqueda-adicionales").html("");
        $("#ModalcamposAdicionales").modal('show');       
    }   
}
function actualizarAdicionales(valor)
{
    var codigoSolicitudDocumento = $("#codigoSolicitudDocumento").val();
    var opcion = $("#opcion").val();
    var opcion ="";
    var dato = valor.value;
    if ($("#opcion").val() == "areaResponsable"){
        opcion ="4";
    }
    if ($("#opcion").val() == "gestor"){
        opcion ="5";
    }
    if ($("#opcion").val() == "tipoReclamo"){
        opcion ="6";
    }
    if ($("#opcion").val() == "clasificacion"){
        opcion ="15";
    }
    if ($("#opcion").val() == "subclasificacion"){
        opcion ="16";
    } 
    var valores = {'codigoSolicitudDocumento':codigoSolicitudDocumento,'dato':dato,'accion':'I','opcion':opcion};
    $.ajax({
        url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
        type : 'POST',      
        datatype : 'json',
        data : valores, 
            success: function(data) { 
                $("#ModalcamposAdicionales").modal('hide');
                var obj = jQuery.parseJSON(data);
		      	$.each(obj, function(i, item) { 		
                    swal(item.MENSAJE+''+item.RESPUESTA);					
		      	});
                obtenerBusquedaNQR();
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
    });    
}

function gestionBuzon(valor)
{
    var codigoSolicitudDocumento = valor.value;
    var accion = valor.name;
    var tipoDocumento = $("#select-tipo-documento").val();

    /*
    CÓDIGOS PARA LAS ACCIONES DEL BUZON
        1.- VISUALIZAR SOLICITUD
        2.- APROBAR SOLICITUD
        3.- RECHAZAR SOLICITUD
        4.- VISUALIZAR RETROALIMENTACION
        5.- AGREGAR EVALUACION DE CONSECUENCIAS
        6.- AGREGAR PLAN DE ACCION
        7.- CERRAR DOCUMENTO
    */
   if (accion == "1")//VISUALIZAR SOLICITUD
    {
        $.ajax({
            url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'tipoDocumento':tipoDocumento,'accion':'V','opcion':2}, 
                success: function(data) { 
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, item) { 
                        $("#ver-codigoSolicitudDocumento").val(item.codigoSolicitudDocumento);
                        $("#ver-codigoDocumento").val(item.codigoDocumento);
                        $("#ver-tipoDocumento").val(item.descripcionDocumento);
                        $("#ver-tipoDocumentos").val(item.descripcionSubtipo);                        
                        $("#AREA-EMISOR").val(item.areaEmisor);
                        $("#USUARIO-EMISOR").val(item.usuarioEmisor);
                        $("#AREA-RECEPTOR").val(item.areaReceptor);
                        $("#USUARIO-RECEPTOR").val(item.usuarioReceptor);
                        $("#ver-textarea-hallazgo").val(item.hallazgoDescripcion);
                        $("#ver-textarea-tratamiento-inmediato").val(item.tratamientoInmediato);
                        $("#ver-textarea-evaluacion-consecuencias").val(item.descripcionEvaluacionCon.trim());
                    }); 
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
        });
        $.ajax({
            url: '/nqr/web/index.php?r=buzon/cargararchivos', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'accion':'V','opcion':8}, 
                success: function(data) { 
                    html ="";
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, item) {                         
                        html += "<tr><td>"+item.proceso+"</td><td>"+item.descDocumento+"</td><td><a type='button' target='_black' href='http://10.10.100.32/nqr/web/"+item.rutaDocumento+"' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Ver documento' ><i class='fa fa-eye'></i></a></td></tr>";
                    });
                    $("#ver-solicitud-documentos").html(html) 
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
        });
       $("#resultado-verSolicitud").html("");
       $("#ModalVerSolicitud").modal("show");
   }else if(accion == "2"){//APROBAR SOLICITUD
        swal({
            title: "Confirmación de solicitud!",
            text: "Desea confirmar la solicitud?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
            },
            function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
                    type : 'POST',      
                    datatype : 'json',
                    data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'tipoDocumento':tipoDocumento,'accion':'C','opcion':3}, 
                        success: function(data) { 
                            var obj = jQuery.parseJSON(data);
                            $.each(obj, function(i, item) { 
                                if (item.ESTADO == 1) {
                                    swal("Confirmada!", "COD: "+item.RESPUESTA, "success");
                                    obtenerBusquedaNQR();
                                }else{							   
                                    swal("FATAL!", item.MENSAJE, "error");
                                }
                            }); 
                        },error:function(data){
                            swal("FATAL!", data, "error"); 
                        }
                });
            }
        });
   }else if(accion == "3"){//RECHAZAR SOLICITUD
        swal({
            title: "Ingreso de retroalimentación!",
            text: "Indique el porque rechaza la solicitud.",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText:"Guardar, rechazar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "Escriba algo que pueda ayudar al usuario"
            }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("Campo obligatorio!");
                return false
            }else{
                $.ajax({                
                        url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
                        type : 'POST',      
                        datatype : 'json',
                        data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'retroalimentacion':inputValue,'tipoDocumento':tipoDocumento,'accion':'R','opcion':3}, 
                            success: function(data) {                
                                var obj = jQuery.parseJSON(data);
                                $.each(obj, function(i, item) { 
                                    if (item.ESTADO == 1) {
                                        swal("Rechazado!", "COD: "+item.RESPUESTA, "error");
                                        obtenerBusquedaNQR();
                                    }else{							   
                                        swal("FATAL!", item.MENSAJE, "error");
                                    }
                                }); 
                            },error:function(data){
                                swal("FATAL!", data, "error"); 
                            }
                    });
            }
        });
   }else if(accion == "4"){//VISUALIZAR RETROALIMENTACION    
        $.ajax({
        url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
        type : 'POST',      
        datatype : 'json',
        data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'tipoDocumento':tipoDocumento,'accion':'V','opcion':1}, 
            success: function(data) {                
                var obj = jQuery.parseJSON(data);
                var html = "<table class='table'><thead><tr><th scope='col'>#</th><th scope='col'><h5>Proceso</h5></th><th scope='col'><h5>Descripción de la retroalimentación</h5></th></tr></thead><tbody>";
                $.each(obj, function(i, item) {
                    var cantidad = i + 1
                    html += "<tr><th scope='row'><h4>"+cantidad+"</h4></th><th scope='row'><h5><strong>"+item.ventana+" </strong></h5></th><td><h5>"+item.detalleRetroalimentacion+" <strong> ("+item.fechaCreacion+")</strong></h5></td></tr>";                 
                });
                html += "</tbody></table>";
                if (obj.length>0)
                {                    
                    swal({
                        title: 'Listado de retroalimentación',
                        text: html,
                        html: html,
                        //timer: 3000,
                    });
                }else{
                    swal("Esta solicitud no tiene retroalimentación");
                }             
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        }); 
   }else if(accion == "5"){//AGREGAR EVALUACION DE CONSECUENCIAS
        swal({
            title: "Ingreso de evaluación de consecuencias!",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText:"Guardar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "Escriba..."
            }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue.trim() === "") {
                swal.showInputError("Campo obligatorio!");
                return false
            }else{
                $.ajax({                
                        url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
                        type : 'POST',      
                        datatype : 'json',
                        data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'retroalimentacion':inputValue,'tipoDocumento':tipoDocumento,'accion':'R','opcion':8}, 
                            success: function(data) {                
                                var obj = jQuery.parseJSON(data);
                                $.each(obj, function(i, item) { 
                                    if (item.ESTADO == 1) {
                                        swal("Exitoso!", item.MENSAJE, "info");
                                        obtenerBusquedaNQR();
                                    }else{							   
                                        swal("FATAL!", item.MENSAJE, "error");
                                    }
                                }); 
                            },error:function(data){
                                swal("FATAL!", data, "error"); 
                            }
                    });
            }
        });
   }else if(accion == "6"){//AGREGAR PLAN DE ACCION
        cargarDatosPantallaPlan(codigoSolicitudDocumento,tipoDocumento); 
        //cargar datos que se necesitan en la pantalla           
        $("#resultado-clases").hide();
        $("#ModalPlanAccion").modal("show");
   }else if(accion == "7"){//CERRAR DOCUMENTO
        swal({
            title: "Cierre de documento!",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText:"Guardar y cerrar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "Escriba..."
            }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue.trim() === "") {
                swal.showInputError("Campo obligatorio!");
                return false
            }else{
                $.ajax({                
                        url: '/nqr/web/index.php?r=buzon/gestionbuzon', 
                        type : 'POST',      
                        datatype : 'json',
                        data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'retroalimentacion':inputValue,'tipoDocumento':tipoDocumento,'accion':'R','opcion':17}, 
                            success: function(data) {                
                                var obj = jQuery.parseJSON(data);
                                $.each(obj, function(i, item) { 
                                    if (item.ESTADO == 1) {
                                        swal("Exitoso!", item.MENSAJE, "info");
                                        obtenerBusquedaNQR();
                                    }else{							   
                                        swal("FATAL!", item.MENSAJE, "error");
                                    }
                                }); 
                            },error:function(data){
                                swal("FATAL!", data, "error"); 
                            }
                    });
            }
        });
   }    
}

function agregarCausaPlan(boton)
{
    var codigoSolicitudDocumento = $("#plan-codigoDocumento").val();
    if (boton.id == "btn-agregar-causa")
    {
        var causa = $("#input-select-causa").val();
        var detalleCausa = $("#input-causa-detalle").val();
        //agregar a la bd la causa   
        if(detalleCausa.trim().length > 10){
            $.ajax({
                url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
                type : 'POST',      
                datatype : 'json',
                data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'causa':causa,'detalleCausa':detalleCausa,'accion':'I','opcion':1}, 
                    success: function(data) { 
		        		var obj = jQuery.parseJSON(data);
		        		$.each(obj, function(i, item) { 
							
							$(".resultado-mensaje").html(item.MENSAJE);
							if (item.ESTADO == 1) {
								$("#resultado-clases").removeClass("alert-danger");
								$("#resultado-clases").addClass("alert-success");
							}else{							   
							    //alert("Hubo un error en el proceso vuelve a intentarlo");
								$("#resultado-clases").addClass("alert-danger");
								$("#resultado-clases").removeClass("alert-success");
							}
		        		});
		        		
						$("#resultado-clases").fadeIn(1);
                        cargarDatosPantallaPlan(codigoSolicitudDocumento,'sd');
                        vaciarCausaPlan();
                    },error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
            });
        }else{
            swal("FATAL!", "El detalle de la causa debe tener minimo 10 caracteres", "info");
            $("#input-causa-detalle").focus();
        }  
    }
    if(boton.id == "btn-agregar-plan")
    {
        var tarea = $("#input-tarea").val();
        var area = $("#input-select-area").val();
        var puesto = $("#input-select-puesto").val();
        var nombre = $("#input-select-nombre").val();
        var fp_inicio = $("#fp-inicio").val();
        var fp_fin = $("#fp-fin").val();
        var fr_inicio = $("#fr-inicio").val();
        var fr_fin = $("#fr-fin").val();

        //agregar a la bd el plan de accion
        if ($("#causas-agregadas").val().trim() != "")
        {
            if(tarea.trim().length > 10)
            {
                if(area != "SIN SELECCIÓN")
                {
                    if(puesto != "SIN SELECCIÓN")
                    {
                        if(nombre != "SIN SELECCIÓN")
                        {
                            $.ajax({
                                url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
                                type : 'POST',      
                                datatype : 'json',
                                data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'tarea':tarea,'area':area,'puesto':puesto,'nombre':nombre,'fp_inicio':fp_inicio,'fp_fin':fp_fin,'fr_inicio':fr_inicio,'fr_fin':fr_fin,'accion':'I','opcion':2}, 
                                    success: function(data) {
                                        var obj = jQuery.parseJSON(data);
                                        $.each(obj, function(i, item) { 
                                            
                                            $(".resultado-mensaje").html(item.MENSAJE);
                                            if (item.ESTADO == 1) {
                                                $("#resultado-clases").removeClass("alert-danger");
                                                $("#resultado-clases").addClass("alert-success");
                                            }else{							   
                                                //alert("Hubo un error en el proceso vuelve a intentarlo");
                                                $("#resultado-clases").addClass("alert-danger");
                                                $("#resultado-clases").removeClass("alert-success");
                                            }
                                        });
                                        
                                        $("#resultado-clases").fadeIn(1);
                                        //$("#resultado-clases").fadeOut(8000);                   
                                        cargarDatosPantallaPlan(codigoSolicitudDocumento,'sd');
                                        vaciarCausaPlan();
                                        obtenerBusquedaNQR();
                                    },error:function(data){
                                        swal("FATAL!", data, "error"); 
                                    }
                            });
                        }else{
                            swal("FATAL!", "Debe seleccionar el nombre", "info");
                        }
                    }else{
                        swal("FATAL!", "Debe seleccionar el puesto", "info");
                    }
                }else{
                    swal("FATAL!", "Debe seleccionar un area", "info");
                }
            }else{
                swal("FATAL!", "La tarea debe tener minimo 10 caracteres", "info");
                $("#input-tarea").focus();
            }
        }else{
            swal("FATAL!", "Para ingresar un plan de acción, primero debe ingresar minimo una causa", "info");
        }

    }
}

function cargarDatosPantallaPlan(codigoSolicitudDocumento,tipoDocumento)
{
        $("#resultado-causas").empty();
        $("#resultado-plan-accion").empty();
        //DATOS YA GUARDADOS DE LAS CAUSAS
        $.ajax({
            url: '/nqr/web/index.php?r=buzon/cargarpantallaplanaccion', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'tipoDocumento':tipoDocumento,'accion':'V','opcion':1}, 
                success: function(data) {                   
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, item) {
                        $("#plan-codigoDocumento2").val(item.codigoDocumento);
                        $("#plan-codigoDocumento").val(item.codigoSolicitudDocumento);
                        $("#plan-hallazgo").val(item.hallazgoDescripcion);
                        $("#causas-agregadas").val(item.idSecuencia);                        
                        if(item.causa.trim() != ""){
                            $("#resultado-causas").append("<tr id=''><td>"+item.causa+"</td><td>"+item.detalleCausa+"</td><td><button type='button' value='"+item.idSecuencia+"' name='1' onclick='eliminarRegistroPlan(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Eliminar causa' ><i class='glyphicon glyphicon-trash'></i></button></td></tr>"); 
                        }
                        if(item.estadoSolicitud=="P")
                        {
                            $(".BOTONES-PLAN").show();
                        }else{
                            $(".BOTONES-PLAN").hide();
                        }                       
                    }); 
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
        });
        //DATOS YA GUARDADOS DEL PLAN DE ACCION
        $.ajax({
            url: '/nqr/web/index.php?r=buzon/cargarpantallaplanaccion', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'tipoDocumento':tipoDocumento,'accion':'V','opcion':2}, 
                success: function(data) {                    
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, item) {
                        if(item.estadoSolicitud.trim() != 'P'){
                            $(".resultado-cabecera-plan").hide()
                        }else{
                            $(".resultado-cabecera-plan").show()
                        }                        
                        //cuando el documento ya este aprobado se deben ocultar los botones de APROBAR Y RECHAZAR                        
                        if(item.avance == 100){
                            if(item.estadoPlan.trim() == 'F'){
                                $("#resultado-plan-accion").append("<tr id=''><td><button type='button' value='"+item.idSecuencia+"' name='1' id='"+item.estadoPlan+"' onclick='mostrarPlanAvances(this)' class='btn btn-success btn-circle' data-toggle='tooltip' data-placement='top'disabled='true'>"+item.estadoPlan+"</button><button type='button' value='"+item.idSecuencia+"' name='2' onclick='mostrarPlanAvances(this)' class='btn btn-success btn-circle' data-toggle='tooltip' data-placement='top' id ='"+item.avance+"'>"+item.avance+"%</button><td>"+item.tarea+"</td><td>"+item.area+"</td><td>"+item.puesto+"</td><td>"+item.nombre+"</td><td>"+item.fechaInicioP+"</td><td>"+item.fechaFinP+"</td><td>"+item.fechaInicioR+"</td><td>"+item.fechaFinR+"</td><td><button type='button' value='"+item.idSecuencia+"' name='2' onclick='eliminarRegistroPlan(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Eliminar plan' ><i class='glyphicon glyphicon-trash'></i></button><button type='button' value='"+item.idSecuencia+"' name='11' onclick='adjuntarArchivoPlan(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Adjuntar' ><i class='fa fa-paperclip'></i></button><button type='button' value='"+item.idSecuencia+"' name='9' onclick='seleccionarTareaPlan(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Seleccionar' ><i class='fa fa-hand-pointer-o'></i></button></td></tr>");   
                            }else if(item.estadoPlan.trim() == 'P'){
                                $("#resultado-plan-accion").append("<tr id=''><td><button type='button' value='"+item.idSecuencia+"' name='1' id='"+item.estadoPlan+"' onclick='mostrarPlanAvances(this)' class='btn btn-default btn-circle' data-toggle='tooltip' data-placement='top' disabled='true'>"+item.estadoPlan+"</button><button type='button' value='"+item.idSecuencia+"' name='2' onclick='mostrarPlanAvances(this)' class='btn btn-success btn-circle' data-toggle='tooltip' data-placement='top' id ='"+item.avance+"'>"+item.avance+"%</button><td>"+item.tarea+"</td><td>"+item.area+"</td><td>"+item.puesto+"</td><td>"+item.nombre+"</td><td>"+item.fechaInicioP+"</td><td>"+item.fechaFinP+"</td><td>"+item.fechaInicioR+"</td><td>"+item.fechaFinR+"</td><td><button type='button' value='"+item.idSecuencia+"' name='2' onclick='eliminarRegistroPlan(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Eliminar plan' ><i class='glyphicon glyphicon-trash'></i></button><button type='button' value='"+item.idSecuencia+"' name='11' onclick='adjuntarArchivoPlan(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Adjuntar' ><i class='fa fa-paperclip'></i></button><button type='button' value='"+item.idSecuencia+"' name='9' onclick='seleccionarTareaPlan(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Seleccionar' ><i class='fa fa-hand-pointer-o'></i></button></td></tr>");   
                            }else{
                                $("#resultado-plan-accion").append("<tr id=''><td><button type='button' value='"+item.idSecuencia+"' name='1' id='"+item.estadoPlan+"' onclick='mostrarPlanAvances(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' disabled='true'>"+item.estadoPlan+"</button><button type='button' value='"+item.idSecuencia+"' name='2' onclick='mostrarPlanAvances(this)' class='btn btn-success btn-circle' data-toggle='tooltip' data-placement='top' id ='"+item.avance+"'>"+item.avance+"%</button><td>"+item.tarea+"</td><td>"+item.area+"</td><td>"+item.puesto+"</td><td>"+item.nombre+"</td><td>"+item.fechaInicioP+"</td><td>"+item.fechaFinP+"</td><td>"+item.fechaInicioR+"</td><td>"+item.fechaFinR+"</td><td><button type='button' value='"+item.idSecuencia+"' name='2' onclick='eliminarRegistroPlan(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Eliminar plan' ><i class='glyphicon glyphicon-trash'></i></button><button type='button' value='"+item.idSecuencia+"' name='11' onclick='adjuntarArchivoPlan(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Adjuntar' ><i class='fa fa-paperclip'></i></button><button type='button' value='"+item.idSecuencia+"' name='9' onclick='seleccionarTareaPlan(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Seleccionar' ><i class='fa fa-hand-pointer-o'></i></button></td></tr>");   
                            }                            
                        }else{
                            if(item.estadoPlan.trim()  == "P"){
                                $("#resultado-plan-accion").append("<tr id=''><td><button type='button' value='"+item.idSecuencia+"' name='1' id='"+item.estadoPlan+"' onclick='mostrarPlanAvances(this)' class='btn btn-default btn-circle' data-toggle='tooltip' data-placement='top' disabled='true'>"+item.estadoPlan+"</button><button type='button' value='"+item.idSecuencia+"' name='2' onclick='mostrarPlanAvances(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' id ='"+item.avance+"'>"+item.avance+"%</button><td>"+item.tarea+"</td><td>"+item.area+"</td><td>"+item.puesto+"</td><td>"+item.nombre+"</td><td>"+item.fechaInicioP+"</td><td>"+item.fechaFinP+"</td><td>"+item.fechaInicioR+"</td><td>"+item.fechaFinR+"</td><td><button type='button' value='"+item.idSecuencia+"' name='2' onclick='eliminarRegistroPlan(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Eliminar plan' ><i class='glyphicon glyphicon-trash'></i></button><button type='button' value='"+item.idSecuencia+"' name='11' onclick='adjuntarArchivoPlan(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Adjuntar' ><i class='fa fa-paperclip'></i></button><button type='button' value='"+item.idSecuencia+"' name='9' onclick='seleccionarTareaPlan(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Seleccionar' ><i class='fa fa-hand-pointer-o'></i></button></td></tr>");                               
                            }else{
                                $("#resultado-plan-accion").append("<tr id=''><td><button type='button' value='"+item.idSecuencia+"' name='1' id='"+item.estadoPlan+"' onclick='mostrarPlanAvances(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' disabled='true'>"+item.estadoPlan+"</button><button type='button' value='"+item.idSecuencia+"' name='2' onclick='mostrarPlanAvances(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' id ='"+item.avance+"'>"+item.avance+"%</button><td>"+item.tarea+"</td><td>"+item.area+"</td><td>"+item.puesto+"</td><td>"+item.nombre+"</td><td>"+item.fechaInicioP+"</td><td>"+item.fechaFinP+"</td><td>"+item.fechaInicioR+"</td><td>"+item.fechaFinR+"</td><td><button type='button' value='"+item.idSecuencia+"' name='2' onclick='eliminarRegistroPlan(this)' class='btn btn-danger btn-circle' data-toggle='tooltip' data-placement='top' title='Eliminar plan' ><i class='glyphicon glyphicon-trash'></i></button><button type='button' value='"+item.idSecuencia+"' name='11' onclick='adjuntarArchivoPlan(this)' class='btn btn-primary btn-circle' data-toggle='tooltip' data-placement='top' title='Adjuntar' ><i class='fa fa-paperclip'></i></button><button type='button' value='"+item.idSecuencia+"' name='9' onclick='seleccionarTareaPlan(this)' class='btn btn-warning btn-circle' data-toggle='tooltip' data-placement='top' title='Seleccionar' ><i class='fa fa-hand-pointer-o'></i></button></td></tr>");                               
                            }                            
                        }
                    });
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
        });  
}

function vaciarCausaPlan()
{
    //limpiar input de las causas
    $("#input-causa-detalle").val("");

    //limpiar input del plan de acción
    $("#input-tarea").val("");
}

function obtenerDatosPlan(opcion)
{
    console.log("usuario");
    var area = $("#input-select-area").val();
    var puesto = $("#input-select-puesto").val();
    var valorBuscar = "",filtroBusqueda="";

    if (opcion==1)
    {
        valorBuscar = area;
    }
    if (opcion==2)
    {
        valorBuscar = puesto;
        filtroBusqueda =area;
    }

    $.ajax({
        url: '/nqr/web/index.php?r=buzon/obtenerdatosplan', 
        type : 'POST',      
        datatype : 'json',
        data : {'valorBuscar':valorBuscar,'filtroBusqueda':filtroBusqueda,'opcion':opcion}, 
        beforeSend: function() { 
            if (opcion==1)
            {
                $("#input-select-puesto").append('<option value="">cargando...</option>');
            }
            if (opcion==2)
            {
                $("#input-select-nombre").append('<option value="">cargando...</option>');
            }  
        },success: function(data) {
                var obj = jQuery.parseJSON(data);
                if (opcion==1)
                {
                    $("#input-select-puesto").empty();
                    $.each(obj, function(i, item) {                 
                        $("#input-select-puesto").append('<option value="'+item.resultadoBusqueda+'">'+item.resultadoBusqueda+'</option>');
                    });
                }
                if (opcion==2)
                {
                    $("#input-select-nombre").empty();
                    $.each(obj, function(i, item) {                 
                        $("#input-select-nombre").append('<option value="'+item.resultadoBusqueda+'">'+item.resultadoBusqueda+'</option>');
                    });
                } 
             
        },error:function(data){
            swal("FATAL!", data, "error"); 
        }
    });
}

function mostrarPlanAvances(valor)
{
    
    if(valor.name == "1")//actualizacion del estado del avance
    {   if($("#plan-select-estadoPlan").val()=="R"){
            $(".rechazo-tarea-retroalimentacion").show();
        }else{
            $(".rechazo-tarea-retroalimentacion").hide();
        }


        $(".opcion-estadoPlan").show();
        $(".opcion-avance").hide();
    }
    if(valor.name == "2")//actualizacion de avance 
    {
        $(".opcion-avance").show();
        $(".opcion-estadoPlan").hide();
        $("#plan-avance").val(valor.id);
    }
    $("#accion-avances").val(valor.name);
    $("#idSecuencia-avances").val(valor.value);
    $(".opcion-btn-avances").show();
    $(".opcion-fechas").hide();
    $(".opcion-documento").hide();

}

function actualizarPlanAvances(opcion)
{   
    var codigoSolicitudDocumento =  $("#plan-codigoDocumento").val();
    var fr_inicio = $("#fr-inicio2").val();
    var fr_fin = $("#fr-fin2").val();
    var accion = $("#accion-avances").val();
    var idSecuencia =  $("#idSecuencia-avances").val();
    var retroalimentacion = $("#rechazo-tarea-retroalimentacion").val();
    var valor = '';

    if (opcion.id == "btn-cancelar-plan-avances")
    {
        $(".opcion-plan").hide();
        $("#idSecuencia-avances").val("");
    }
    if (opcion.id == "btn-actualizar-plan-avances")
    {
        if (accion==11)//ACTUALIZACION DE DOCUMENTOS
        {
            var frm = document.getElementById('form1');
            var valores = new FormData(frm);

            $.ajax({
                url: '/nqr/web/index.php?r=buzon/guardararchivos', 
                type : 'POST',      
                datatype : 'json',
                cache: false,
                contentType: false,
                processData: false,        
                data : valores, 
                    beforeSend: function() {
                        $(".resultado-mensaje").html("Subiendo archivo..."); 
                        $("#resultado-clases").removeClass("alert-danger");
                        $("#resultado-clases").addClass("alert-success");
                        $("#resultado-clases").fadeIn(1); 
                    },success: function(data) {
                        console.log(data);
                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function(i, item) {
                            $(".resultado-mensaje").html(item.MENSAJE);
                                if (item.ESTADO == 1) {
                                    $(".opcion-plan").hide();
                                    $("#resultado-clases").removeClass("alert-danger");
                                    $("#resultado-clases").addClass("alert-success");
                                }else{                             
                                    $("#resultado-clases").addClass("alert-danger");
                                    $("#resultado-clases").removeClass("alert-success");
                                }
                        });
                            
                        $("#resultado-clases").fadeIn(1);
                        cargarDatosPantallaPlan(codigoSolicitudDocumento,'sd');
                        obtenerBusquedaNQR();
                    },error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                });          

        }else{
            if (accion==1)
            {
                valor = $("#plan-select-estadoPlan").val();
            }
            else
            {
                valor = $("#plan-avance").val();
            }
            $.ajax({
                url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
                type : 'POST',      
                datatype : 'json',
                data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'idSecuencia':idSecuencia,'valor':valor,'fr_inicio':fr_inicio,'fr_fin':fr_fin,'retroalimentacion':retroalimentacion,'accion':accion,'opcion':4}, 
                    beforeSend: function() {
                        $(".resultado-mensaje").html("Actualizando..."); 
                        $("#resultado-clases").removeClass("alert-danger");
                        $("#resultado-clases").addClass("alert-success");
                        $("#resultado-clases").fadeIn(1); 
                    },success: function(data) {                     
                        var obj = jQuery.parseJSON(data);
                            $.each(obj, function(i, item) { 
                                
                                $(".resultado-mensaje").html(item.MENSAJE);
                                if (item.ESTADO == 1) {
                                    $(".opcion-plan").hide();
                                    $("#resultado-clases").removeClass("alert-danger");
                                    $("#resultado-clases").addClass("alert-success");
                                }else{                             
                                    $("#resultado-clases").addClass("alert-danger");
                                    $("#resultado-clases").removeClass("alert-success");
                                }
                            });
                            
                            $("#resultado-clases").fadeIn(1);
                        cargarDatosPantallaPlan(codigoSolicitudDocumento,'sd');
                        obtenerBusquedaNQR();
                    },error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
            });
        }         
    }    
}


function eliminarRegistroPlan(valor)
{
    var idSecuencia = valor.value;
    var codigoSolicitudDocumento = $("#plan-codigoDocumento").val();

    if(valor.name == 1){
        $.ajax({
            url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'idSecuencia':idSecuencia,'accion':'D','opcion':1}, 
                success: function(data) {                     
                    var obj = jQuery.parseJSON(data);
		        		$.each(obj, function(i, item) { 
							
							$(".resultado-mensaje").html(item.MENSAJE);
							if (item.ESTADO == 1) {
								$("#resultado-clases").removeClass("alert-danger");
								$("#resultado-clases").addClass("alert-success");
							}else{							   
							    //alert("Hubo un error en el proceso vuelve a intentarlo");
								$("#resultado-clases").addClass("alert-danger");
								$("#resultado-clases").removeClass("alert-success");
							}
		        		});
		        		
						$("#resultado-clases").fadeIn(1);
						//$("#resultado-clases").fadeOut(8000);
                    cargarDatosPantallaPlan(codigoSolicitudDocumento,'sd'); 
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
        }); 

    }
    if(valor.name == 2)
    {
        $.ajax({
            url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
            type : 'POST',      
            datatype : 'json',
            data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'idSecuencia':idSecuencia,'accion':'D','opcion':2}, 
                success: function(data) {                     
                    var obj = jQuery.parseJSON(data);
		        		$.each(obj, function(i, item) { 
							
							$(".resultado-mensaje").html(item.MENSAJE);
							if (item.ESTADO == 1) {
								$("#resultado-clases").removeClass("alert-danger");
								$("#resultado-clases").addClass("alert-success");
							}else{							   
								$("#resultado-clases").addClass("alert-danger");
								$("#resultado-clases").removeClass("alert-success");
							}
		        		});
		        		
						$("#resultado-clases").fadeIn(1);
						//$("#resultado-clases").fadeOut(8000);
                    cargarDatosPantallaPlan(codigoSolicitudDocumento,'sd'); 
                },error:function(data){
                    swal("FATAL!", data, "error"); 
                }
        });
    }

}

function aprobarRechazarPlan(boton)
{
    var codigoSolicitudDocumento = $("#plan-codigoDocumento").val();
    var accion = "";

    if(boton.id == "btn-notificar-plan")
    {
        accion = "P";

        $.ajax({
        url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
        type : 'POST',      
        datatype : 'json',
        data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'accion':accion,'opcion':6}, 
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, item) {                             
                        $(".resultado-mensaje").html(item.MENSAJE);
                        if (item.ESTADO == 1) {
                            $("#resultado-clases").removeClass("alert-danger");
                            $("#resultado-clases").addClass("alert-success");
                        }else{                             
                            $("#resultado-clases").addClass("alert-danger");
                            $("#resultado-clases").removeClass("alert-success");
                        }
                    });
                    
                    $("#resultado-clases").fadeIn(1);
                    //$("#resultado-clases").fadeOut(8000);                
                obtenerBusquedaNQR();                
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });
    }
    if (boton.id == "btn-aprobar-plan")
    {
        accion = "A";

        $.ajax({
        url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
        type : 'POST',      
        datatype : 'json',
        data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'accion':accion,'opcion':3}, 
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, item) {                             
                        $(".resultado-mensaje").html(item.MENSAJE);
                        if (item.ESTADO == 1) {
                            $("#resultado-clases").removeClass("alert-danger");
                            $("#resultado-clases").addClass("alert-success");
                        }else{                             
                            $("#resultado-clases").addClass("alert-danger");
                            $("#resultado-clases").removeClass("alert-success");
                        }
                    });
                    
                    $("#resultado-clases").fadeIn(1);
                    //$("#resultado-clases").fadeOut(8000);                
                obtenerBusquedaNQR();                
            },error:function(data){
                swal("FATAL!", data, "error"); 
            }
        });         
    }
    if (boton.id == "btn-rechazar-plan")
    {
        accion = "R";
        $("#ModalPlanAccion").modal('hide');

        swal({
            title: "Reclazo del plan de acción!",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText:"Guardar y rechazar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "Escriba..."
            }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue.trim() === "") {
                swal.showInputError("Campo obligatorio!");
                return false
            }else{
                $.ajax({
                url: '/nqr/web/index.php?r=buzon/gestionpantallaplanaccion', 
                type : 'POST',      
                datatype : 'json',
                data : {'codigoSolicitudDocumento':codigoSolicitudDocumento,'valor':inputValue,'accion':accion,'opcion':3}, 
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                            $.each(obj, function(i, item) {                             
                                $(".resultado-mensaje").html(item.MENSAJE);
                                if (item.ESTADO == 1) {
                                    swal("Exitoso!", item.MENSAJE, "success"); 
                                }else{                             
                                    swal("Error!", item.MENSAJE, "error");
                                }
                            });
                                           
                        obtenerBusquedaNQR();                
                    },error:function(data){
                        swal("FATAL!", data, "error"); 
                    }
                });
            }
        });             
    }       
}

function seleccionarTareaPlan(valor){
    $(".opcion-fechas").show();
    $("#accion-avances").val(valor.name);
    $("#idSecuencia-avances").val(valor.value);
    $(".opcion-btn-avances").show();

    $(".opcion-avance").hide(); 
    $(".opcion-estadoPlan").hide();
    $(".opcion-documento").hide();   
}

function adjuntarArchivoPlan(valor){
    $(".opcion-documento").show();
    $("#accion-avances").val(valor.name);
    $("#idSecuencia-avances").val(valor.value);
    $(".opcion-btn-avances").show();    

    $(".opcion-fechas").hide();
    $(".opcion-avance").hide(); 
    $(".opcion-estadoPlan").hide();     
}
</script>