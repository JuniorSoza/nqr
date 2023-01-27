<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;

class Buzon2Controller extends Controller
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

            return $this->render('index',['tipoDocumentos'=>$tipoDocumentos,'areas'=>$areas]);
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

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion=2, @codigoTipoDocumento='".$tipoDocumento."', @estadoSolicitud='".$estadoDocumento."',@usuarioModifica='".$usuario."',@fechaInicio ='".$fechaInicio."',@fechaFin = '".$fechaFin."'")->queryAll();
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
        $accion = $_POST['accion'];
        $opcion = $_POST['opcion'];
        $dato = @$_POST['dato'];
        if ($accion == 'V'){
            $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@dato='".$dato."'")->queryAll();
        }else{
            $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."', @dato='".$dato."', @detalleRetroalimentacion='".$retroalimentacion."',@estadoSolicitud='".$accion."',@codigoTipoDocumento='".$tipoDocumento."',@usuarioModifica='".$usuario."',@usuarioCrea='".$usuario."'")->queryAll();
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
        $idSecuencia = @$_POST['idSecuencia'];
        $valor = @$_POST['valor'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spPlanificacionNQR @opcion='".$opcion."',@accion='".$accion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."'
        ,@causa='".$causa."',@detalleCausa='".$detalleCausa."',@tarea='".$tarea."',@area='".$area."',@puesto='".$puesto."',@fp_inicio='".$fp_inicio."',@fp_fin='".$fp_fin."'
        ,@fr_inicio='".$fr_inicio."',@fr_fin='".$fr_fin."',@nombre='".$nombre."',@idSecuencia='".$idSecuencia."',@valor='".$valor."',@usuario='".$usuario."'")->queryAll();

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
        
}
?>