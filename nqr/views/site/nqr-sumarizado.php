<?php
use yii\helpers\Html;
?>
<meta charset="UTF-8"/>
<?php

    //verificacion para la importacion del excel
    $filename = "nqr-sumarizado.xls";

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
   	header("Content-Disposition: attachment; filename=".$filename);
    
?>   
<table border>
    <thead>
    <tr>        
        <td rowspan='2'><?= Html::img('@web/img/salica-rpt.png', ['alt'=>'logo salica']) ?></td>
        <td rowspan='2' COLSPAN='5'><center><h3><strong>SUMARIZACIÓN Y SEGUIMIENTO DE NO CONFORMIDADES Y RECLAMOS</strong></h3></center></td>
        <td style='border:1px solid black'>Código: FEC.03</td>
    </tr>    
    <tr>
        <td style='border:1px solid black'>Copia Controlada Nº: N/A</td>
    </tr>
    </thead>
    <tbody>
        <tr>
            <th COLSPAN='11'>Tipo de documento:_________________</th>
        </tr>
        <tr>
            <th>Proceso receptor</th><th>Código del documento</th><th>Subtipo del documento</th><th>Fecha confirmado</th><th>Descripción del hallazgo</th><th>Valoración económica</th><th>Plan de acción: Tarea</th><th>Responsable</th><th>Fecha final previsto</th><th>Fecha final ejecutado</th><th>Estado del documento</th>
        </tr>        
        <?php
        foreach($dataSolicitudes as $row)
        {
        ?>
        <tr>
		<td><?php echo $row['areaReceptor'];?></td><td><?php echo $row['codigoDocumento'];?></td><td><?php echo $row['descripcionSubtipo'];?></td><td><?php echo $row['fechaConfirmado'];?></td><td><?php echo $row['hallazgoDescripcion'];?></td><td><?php echo $row['valoracionEconomica'];?></td><td><?php echo $row['tareas'];?></td><td><?php echo $row['responsable'];?></td><td><?php echo $row['fechaTareasPre'];?></td><td><?php echo $row['fechaTareasRel'];?></td><td><?php echo $row['estadoSolicitudDescripcion'];?></td>
        </tr> 
        <?php
        }
        ?>                                                       
    </tbody>        
</table></br>
Revisión:02</br>
Fecha:2021-04-21                       