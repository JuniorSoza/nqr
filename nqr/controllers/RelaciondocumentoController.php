<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;

class RelaciondocumentoController extends Controller
{


    public function actionIndex()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {
            return $this->render('index');
        }else{
            return $this->render('/site/login');
        }
    }
    
    public function actionGestiondocumento()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = @$_POST['codigoSolicitudDocumento'];
        $retroalimentacion = @$_POST['retroalimentacion'];
        $tipoDocumento = @$_POST['tipoDocumento'];
        $accion = $_POST['accion'];
        $opcion = $_POST['opcion'];
        $dato = @$_POST['dato'];
        if ($accion == 'V'){
            $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@dato='".$dato."'")->queryAll();
        }else{
            $Respuesta = \Yii::$app->db->createCommand("exec nqr.spPlanificacionNQR @opcion='".$opcion."',@accion='".$accion."',@valor='".$dato."'")->queryAll();
        }
        return json_encode($Respuesta); 
    }    
}
?>