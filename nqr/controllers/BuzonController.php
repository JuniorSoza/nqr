<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

class BuzonController extends Controller
{


    //FUNCIONES PARA EL BUZÓN -- INICIO
    public function actionIndex()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {

            $tipoDocumentos = \Yii::$app->db->createCommand("SELECT 'SN' codigoDocumento,'SIN SELECCIÓN' descripcionDocumento UNION ALL
            SELECT codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR WHERE estado = 1") ->queryAll();

            $areas = \Yii::$app->db->createCommand("SELECT 'SIN SELECCIÓN' descripcionArea UNION ALL
            SELECT DISTINCT descripcionArea FROM nqr.areas WHERE estado = 1 ") ->queryAll();

            if($session['usuarioRolCodSession']==3){
                return $this->render('/buzon/index',['tipoDocumentos'=>$tipoDocumentos,'areas'=>$areas]);
            }else if($session['usuarioRolCodSession']==2){
                return $this->render('/buzon2/index',['tipoDocumentos'=>$tipoDocumentos,'areas'=>$areas]);
            }else{
                return $this->render('/buzon2/index',['tipoDocumentos'=>$tipoDocumentos,'areas'=>$areas]);
            } 

        }else{
            return $this->render('/site/login');
        }
    }

    public function actionObtenerbusquedanqr()
    {   
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $tipoDocumento = @$_POST['tipoDocumento'];
        $estadoDocumento = @$_POST['estadoDocumento'];
        $fechaInicio = @$_POST['fechaInicio'];
        $fechaFin = @$_POST['fechaFin'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion=2, @codigoTipoDocumento='".$tipoDocumento."', @estadoSolicitud='".$estadoDocumento."',@usuarioCrea='".$usuario."',@fechaInicio ='".$fechaInicio."',@fechaFin = '".$fechaFin."'")->queryAll();
        return json_encode($Respuesta);
    }
    //FUNCIONES PARA EL BUZÓN -- FIN

    public function actionGestionbuzon()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $retroalimentacion = @$_POST['retroalimentacion'];
        $tipoDocumento = @$_POST['tipoDocumento'];
        $valoracionEconomica = @$_POST['valoracionEconomica'];
        $accion = $_POST['accion'];
        $opcion = $_POST['opcion'];
        $dato = @$_POST['dato'];
        if ($accion == 'V'){
            $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@dato='".$dato."',@usuarioLogin='".$usuario."'")->queryAll();
        }else{
            $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."', @dato='".$dato."', @detalleRetroalimentacion='".$retroalimentacion."',@estadoSolicitud='".$accion."',@codigoTipoDocumento='".$tipoDocumento."',@usuarioModifica='".$usuario."',@valoracionEconomica='".$valoracionEconomica."',@usuarioCrea='".$usuario."'")->queryAll();
        }
        

        return json_encode($Respuesta); 
    }

    public function actionCargarpantallaplanaccion()
    {
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $tipoDocumento = $_POST['tipoDocumento'];
        $accion = $_POST['accion'];
        $opcion = $_POST['opcion'];
        
        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spPlanificacionNQR @opcion='".$opcion."',@accion='".$accion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."'")->queryAll();

        return json_encode($Respuesta);
    }

    public function actionGestionpantallaplanaccion()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $accion = $_POST['accion'];
        $opcion = $_POST['opcion'];
        $causa = @$_POST['causa'];
        $detalleCausa = @$_POST['detalleCausa'];
        $tarea = @$_POST['tarea'];
        $area = @$_POST['area']; 
        $puesto = @$_POST['puesto'];
        $nombre = @$_POST['nombre'];
        $fp_inicio = @$_POST['fp_inicio'];
        $fp_fin = @$_POST['fp_fin'];
        $fr_inicio = @$_POST['fr_inicio'];
        $fr_fin = @$_POST['fr_fin'];
        $retroalimentacion = @$_POST['retroalimentacion'];
        $idSecuencia = @$_POST['idSecuencia'];
        $valor = @$_POST['valor'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spPlanificacionNQR @opcion='".$opcion."',@accion='".$accion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."'
        ,@causa='".$causa."',@detalleCausa='".$detalleCausa."',@tarea='".$tarea."',@area='".$area."',@puesto='".$puesto."',@fp_inicio='".$fp_inicio."',@fp_fin='".$fp_fin."'
        ,@fr_inicio='".$fr_inicio."',@fr_fin='".$fr_fin."',@nombre='".$nombre."',@idSecuencia='".$idSecuencia."',@valor='".$valor."',@retroalimentacion='".$retroalimentacion."',@usuario='".$usuario."'")->queryAll();

        return json_encode($Respuesta);
    }    

    public function actionObtenerdatosplan()
    {
        $valorBuscar = $_POST["valorBuscar"];
        $opcion = $_POST["opcion"];
        $filtroBusqueda = @$_POST['filtroBusqueda'];
        if ($opcion == 1) //busqueda de los puestos
        {
            $Respuesta = \Yii::$app->db->createCommand("SELECT 'SIN SELECCIÓN' resultadoBusqueda UNION ALL
                                                        SELECT DISTINCT descripcionPuesto resultadoBusqueda 
                                                        FROM nqr.areas WHERE descripcionArea LIKE '%".$valorBuscar."%' AND descripcionPuesto <>'' and estado=1")->queryAll();
        }
        if($opcion == 2)//busqueda de los nombres
        {
            $Respuesta = \Yii::$app->db->createCommand("SELECT 'SIN SELECCIÓN' resultadoBusqueda UNION ALL
                                                        SELECT DISTINCT descripcionNombre resultadoBusqueda 
                                                        FROM nqr.areas WHERE descripcionPuesto LIKE '%".$valorBuscar."%' AND descripcionNombre <>'' AND descripcionArea LIKE '%".$filtroBusqueda."%'  and estado=1")->queryAll();
        }

        return json_encode($Respuesta);
    }

    public function actionCargararchivos()
    {

        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $accion = $_POST['accion'];
        $opcion = $_POST['opcion']; 

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spPlanificacionNQR @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@usuario='".$usuario."'")->queryAll();

        return json_encode($Respuesta);
    }

    public function actionGuardararchivos()
    {        
            $session = Yii::$app->session;
            $usuario = $session['usuarioSession'];
            $file_name = $_FILES['documento']['name'];
            $idSecuencia = $_POST['idSecuencia-avances'];
            $new_name_file = null;
            $respuesta = [];
            
            if ($file_name != '' || $file_name != null) {
                $file_type = $_FILES['documento']['type'];
                list($type, $extension) = explode('/', $file_type);
                if ($extension == 'pdf' || $extension == 'jpeg' || $extension == 'png' || $extension == 'jpg') {
                    $dir = 'files/';
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                        $respuesta[] = array("ESTADO"=>false,"MENSAJE"=>"No existe la carpeta, comunicar al departamento de sistemas");
                        return json_encode($respuesta);
                    }

                    $file_tmp_name = $_FILES['documento']['tmp_name'];
                    $nombreDocumento = date('Ymdhis') . '.' . $extension;
                    $new_name_file = 'files/' . date('Ymdhis') . '.' . $extension;
                    if (copy($file_tmp_name, $new_name_file)) {                    
                    }

                    $Documento = \Yii::$app->db->createCommand("EXEC nqr.spPlanificacionNQR @opcion=11, @usuario='".$usuario."',@nombreDocumento='".$nombreDocumento."',@rutaDocumento='".$new_name_file."',@idSecuencia='".$idSecuencia."'")->queryAll();            
                    return json_encode($Documento); 
                }else{
                    $respuesta[] = array("ESTADO"=>false,"MENSAJE"=>"La extension del archivo no esta permitida");
                  return json_encode($respuesta);  
                }
            }else {
                $respuesta[] = array("ESTADO"=>false,"MENSAJE"=>"No hay archivos seleccionados");
               return json_encode($respuesta);  
            }          
    }

    public function actionPrint()
    {

    $codigoSolicitudDocumento = $_GET['cod'];
    $codigoTipoDocumento = $_GET['tip'];


    header('Content-Type:http://produccion/ReportServer/Pages/ReportViewer.aspx?%2fProduccion%2freporteSumarizadoNQR&tipoDocumento=SN&estadoDocumento=SN'); 
    /*$content = '';
    $footer = '<table><tr ><td style="width:99%;font-size:9px;">Revisión: 01</td><td></td><td  style="width:1%;font-size:9px;">{PAGENO}</td></tr><tr style="width:100%" ><td style="width:95%;font-size:9px;">Fecha: 2021-04-26</td><td></td><td></td></tr></table>';

    if ($codigoTipoDocumento == 'RE')
    {
        $content = " <table style='width:100%;border:1px solid black'>
                      <tr>
                        <td rowspan='2'><img src='../../nqr/web/img/salica-rpt.png'></td>
                        <td rowspan='2'><center><h4><strong>INFORME DE RECLAMACIONES</strong></h4></center></td>
                        <td style='border:1px solid black'>Código: FEC.96</td>
                      </tr>
                      <tr>                                            
                        <td style='border:1px solid black'>Copia Controlada Nº: N/A</td>
                      </tr>
                    </table> ";
    }
    if ($codigoTipoDocumento == 'NC')
    {
        $content = " <table style='width:100%;border:1px solid black'>
                      <tr>
                        <td rowspan='2'><img src='../../nqr/web/img/salica-rpt.png'></td>
                        <td rowspan='2'><center><h4><strong>INFORME DE NO CONFORMIDADES</strong></h4></center></td>
                        <td style='border:1px solid black'>Código: FEC.04</td>
                      </tr>
                      <tr>                                            
                        <td style='border:1px solid black'>Copia Controlada Nº: N/A</td>
                      </tr>
                    </table> ";
    $footer = '<table><tr ><td style="width:99%;font-size:9px;">Revisión: 03</td><td></td><td  style="width:1%;font-size:9px;">{PAGENO}</td></tr><tr style="width:100%" ><td style="width:95%;font-size:9px;">Fecha: 2021-04-26</td><td></td><td></td></tr></table>';                    
    }
    if ($codigoTipoDocumento == 'QU')
    {
        $content = " <table style='width:100%;border:1px solid black'>
                      <tr>
                        <td rowspan='2'><img src='../../nqr/web/img/salica-rpt.png'></td>
                        <td rowspan='2'><center><h4><strong>INFORME DE RECLAMACIONES</strong></h4></center></td>
                        <td style='border:1px solid black'>Código: FEC.96</td>
                      </tr>
                      <tr>                                            
                        <td style='border:1px solid black'>Copia Controlada Nº: N/A</td>
                      </tr>
                    </table> ";
    }    

    //OBTENER EL DETALLE DEL REPORTES
    $Resultado = \Yii::$app->db->createCommand("EXEC nqr.spObtenerInformacionNQR @opcion=18,@codigoSolicitudDocumento='".$codigoSolicitudDocumento."'")->queryAll();
    $JsonObject = json_encode($Resultado);                
    
    $content .= implode(" ",$Resultado[0]);

    
    // setup kartik\mpdf\Pdf component
    
    $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Salica del Ecuador (Sistema NQR)'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'SetHeader'=>['Salica del Ecuador (Sistema NQR)'], 
            'SetFooter'=>$footer,
        ]
    ]);
    //Revisión: 02      Página 3 de 3
    //Fecha: 2021-04-07

    // return the pdf output as per the destination setting
    return $pdf->render(); */

    }    
}
?>