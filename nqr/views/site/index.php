
<?php
use yii\helpers\Html;
use app\assets\AdminLteAsset;
use yii\helpers\Json;
use yii\jui\DatePicker;
?>

<!--LIBRERIA QUE SE USA PARA LOS GRAFICOS 
TODAVIA HAY QUE DESCARGAR LA LIBRERIA, PARA NO NECESITAR INTERNET-->
<script type="text/javascript" charset="utf8" src="/nqr/web/js/highcharts.js"></script>
<script type="text/javascript" charset="utf8" src="/nqr/web/js/drilldown.js"></script>
<script type="text/javascript" charset="utf8" src="/nqr/web/js/exporting.js"></script>


<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12"> 
        <div id="container"></div>
    </div>    
</div><br>

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12"> 
        <div id="container2"></div>
    </div>    
</div><br>

<!--FILTRO PARA OBTENER EL REPORTE SUMARIZADO-->

<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Filtro de reportes</h3> 
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <!--INFORMACION GENERAL-->
        <div class="row">
            <div class="col-md-2 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label>Tipo reporte</label>
                    <select class="form-control select2 control-buqueda" id="select-tipo-reporte" style="width: 100%;">
                        <option value='S'>SUMARIZADO</option>
                        <option value='I'>INDIVIDUAL</option>                     
                    </select>
                </div>
            </div>            
            <div class="col-md-2 col-sm-6 col-xs-6" id="opcion--tipo-documento">
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
            <div class="col-md-2 col-sm-6 col-xs-6" id="opcion-estado-documento">
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
            <div class="col-md-2 col-sm-6 col-xs-6" id="opcion-codigoSolicitudDocumento" style="display:none">
                <div class="form-group">
                    <label>Código solicitud</label>
                    <input type="text" class="form-control" name="codigoSolicitudDocumento" id="codigoSolicitudDocumento" value="SO00000001">
                </div>
            </div>            
            <div class="col-md-2 col-sm-6 col-xs-6">
                <a class="btn btn-primary" id="btnDescargarRPT" onclick="descargarReporte()" >Descargar RPT</a>
            </div>
        </div>    
    </div>
</div>
<!--FILTRO PARA OBTENER EL REPORTE SUMARIZADO-->
<?php
$script = <<< JS
$("#select-tipo-reporte").change(function(){
    if (this.value == 'S'){
        $("#opcion-codigoSolicitudDocumento").hide();
        $("#opcion-estado-documento").show(); 
        //$("#opcion--tipo-documento").show();
    }else{
        $("#opcion-codigoSolicitudDocumento").show();
        $("#opcion-estado-documento").hide();
        //$("#opcion--tipo-documento").hide();
    }
    
});
$("#container2").hide();
JS;
$this->REGISTERJS($script);
?>

<script type="text/javascript">


var data = [];
var drilldown = [];
var drilldownData = [];
var contador = 0;
<?php
foreach($documentos as $row)
{
?>
    var datas = parseFloat(<?php echo "'".$row['cantidadDocumento']."'";?>);
    var names = <?php echo "'".$row['descripcionDocumento']."'";?>; 
    var fte = {
            name: names,
            data: JSON.parse("[" +datas + "]"),
            y:datas,
            drilldown:names
        };
                            
    data.push(fte);
<?php
}
?> 

<?php
foreach($dataSubtipoDocumento as $row)
{
?>
    var names2 = <?php echo "'".$row['descripcionDocumento']."'";?>; 
    //AQUI DEBO VERIFICAR SI EL ESTADO DEL DOCUMENTO YA ESTA INGRESADO
    //SE ENCUENTRA INGRESADO EN EL ARRAY, SI EXISTE YA NO LO DEBE INGRESAR
    drilldownData = [];
    <?php
    foreach($dataSubtipoDocumento as $row2)
    {
        if ($row['descripcionDocumento'] == $row2['descripcionDocumento'])
        {        
        ?>
        var estadoSolicitudDesc = <?php echo "'".$row2['descripcionSubtipo']."'";?>;
        var datas2 = parseFloat(<?php echo "'".$row2['cantidadDocumento']."'";?>);
        var valor = [estadoSolicitudDesc,JSON.parse(datas2)]; 
        //CON ESTA OPCION AGREGO LAS VARIAS OPCIONES DEL ESTATUS
        drilldownData.push(valor);       
    <?php
        }
    ?>
    
    <?php
    }
    ?>
    var fte2 = {point:{
                events:{
                    click: function(){
                        cargarTorta(this.name);
                    }
                }
            },            
            name: names2,
            id:names2,
            data:drilldownData
        };

    if (drilldown.length == 0){
        drilldown.push(fte2);
    }else{
        if (drilldown.length > 0){
            if (drilldown[contador].name != names2){
                drilldown.push(fte2);
                contador = contador+1;
            }
        }else{
            if ( drilldown[0].name != names2 ) {
                drilldown.push(fte2);
                contador = contador+1;
            }  
        }  
    }   

    //AQUI DEBO VERIFICAR SI EL TIPO DE DOCUMENTO 
    //SE ENCUENTRA INGRESADO EN EL ARRAY, SI EXISTE YA NO LO DEBE INGRESAR
<?php
}
?>

//creacion de grafico dinamico
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Cantidad de DOCUMENTOS, del sistema NQR'
    },
    subtitle: {
        text: 'Documentos creados hasta la actualidad<a href="#" target="_blank">#</a>'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Cantidad de documentos'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y} doc.'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} doc.</b> en total<br/>'
    },

    series: [
        {
            name: "Tipo de documento",
            colorByPoint: true,
            data: data
        }
    ],
    drilldown: {
        series: drilldown
    }
});


function descargarReporte(){
    tipoDocumento = $("#select-tipo-documento").val();
    estadoDocumento = $("#select-estado-documento").val();
    tipoReporte = $("#select-tipo-reporte").val();
    fechaConfirmacion = '01-06-2021';
    codigoSolicitudDocumento = $("#codigoSolicitudDocumento").val();


    if (tipoReporte == "S") {
        window.open('http://produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteSumarizadoNQR&tipoDocumento='+tipoDocumento+'&estadoDocumento='+estadoDocumento);

    }else{
        if(tipoDocumento=="SN"){
            alert("No hay formato para este tipo de opcion, seleccione un tipo de documento");
        }else if(tipoDocumento=="NC"){
        window.open('http://produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteIndividualNCNQR&codigoSolicitudDocumento='+codigoSolicitudDocumento+'&tipoDocumento='+tipoDocumento);
        }else if(tipoDocumento=="RE"){
        window.open('http://produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteIndividualRENQR&codigoSolicitudDocumento='+codigoSolicitudDocumento+'&tipoDocumento='+tipoDocumento);
        }else if(tipoDocumento=="QU"){
        window.open('http://produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteIndividualQUNQR&codigoSolicitudDocumento='+codigoSolicitudDocumento+'&tipoDocumento='+tipoDocumento);

        }

    }
}

function cargarTorta(valor){
    
    valor = valor;
    var dataGrafica = [];

    $.ajax({
        url: '/nqr/web/index.php?r=site/obtenerestadosdocumento', 
        type : 'POST',      
        datatype : 'json',       
        data : {'valor':valor}, 
            beforeSend: function() {  
                console.log("obteniendo data..."); 
            },success: function(data) {
                var obj = jQuery.parseJSON(data);

                $.each(obj, function(i, item) {                 
                        var fte = {            
                        name: item.estadoSolicitudDesc,
                        data: [JSON.parse(item.cantidadDocumento)]
                        
                    };                                        
                    dataGrafica.push(fte);
                });

                Highcharts.chart('container2', {
                  chart: {
                    type: 'column'
                  },
                  title: {
                    text: valor
                  },
                  yAxis: {
                    min: 0,
                    title: {
                      text: 'Cantidad de documentos'
                    }
                  },
                  plotOptions: {
                    column: {
                      pointPadding: 0.2,
                      borderWidth: 0
                    }
                  },
                  series: dataGrafica
                });

            },error:function(data){
                console.log(data);
            }
        });


    $("#container2").show();

}
</script>