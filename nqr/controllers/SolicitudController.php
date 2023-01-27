<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;

class SolicitudController extends Controller
{


    public function actionIndex()
    {

        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {
            $tipoDocumentos = \Yii::$app->db->createCommand("SELECT 'SN' codigoDocumento,'SIN SELECCIÓN' descripcionDocumento UNION ALL
            SELECT codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR WHERE estado = 1") ->queryAll();
                  
            $normas = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoNorma,'SIN SELECCIÓN' descripcionNorma
            UNION all
            SELECT idSecuencia,codigoNorma,descripcionNorma FROM nqr.normas where estado = 1") ->queryAll();

            $dondeOcurrioAreas = \Yii::$app->db->createCommand("SELECT 'SIN SELECCIÓN' descripcionArea UNION ALL SELECT DISTINCT descripcionArea FROM nqr.areas where estado = 1") ->queryAll();
  
            $tipoReclamo = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SIN SELECCIÓN' tipoReclamo,'SIN SELECCIÓN' Clasificacion,'SIN SELECCIÓN' subclasificacion
            UNION all
            SELECT idSecuencia,tipoReclamo,Clasificacion,subclasificacion FROM nqr.tipoClasificacionSubReclamos WHERE estado=1") ->queryAll();                    

            return $this->render('index',['tipoDocumentos'=>$tipoDocumentos,'normas'=>$normas,'dondeOcurrioAreas' => $dondeOcurrioAreas,'tipoReclamo' =>$tipoReclamo]);
        }else{
            return $this->render('/site/login');
        }            
    }

    public function actionActualizardoc()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {   
            $tipoDocumentos = \Yii::$app->db->createCommand("SELECT 'SN' codigoDocumento,'SIN SELECCIÓN' descripcionDocumento UNION ALL
            SELECT codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR WHERE estado = 1") ->queryAll();
                  
            $normas = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoNorma,'SIN SELECCIÓN' descripcionNorma
            UNION all
            SELECT idSecuencia,codigoNorma,descripcionNorma FROM nqr.normas where estado = 1") ->queryAll();

            $dondeOcurrioAreas = \Yii::$app->db->createCommand("SELECT 'SIN SELECCIÓN' descripcionArea UNION ALL SELECT DISTINCT descripcionArea FROM nqr.areas where estado = 1") ->queryAll();

            $tipoReclamo = \Yii::$app->db->createCommand("SELECT 'SIN SELECCIÓN' tipoReclamo
            UNION all
            SELECT DISTINCT Ltrim(Rtrim(tipoReclamo))tipoReclamo FROM nqr.tipoClasificacionSubReclamos WHERE estado=1") ->queryAll();        

            return $this->render('actualizardoc',['tipoDocumentos'=>$tipoDocumentos,'normas'=>$normas,'dondeOcurrioAreas' => $dondeOcurrioAreas,'tipoReclamo' =>$tipoReclamo]);

            //return $this->render('actualizardoc2');
        }else{
            return $this->render('/site/login');
        }        
    }    

    //FUNCIONES PRINCIPALES -- FIN
    public function actionObtenerusuarioarea()
    {
        $session = Yii::$app->session;
        $usuarioLogin = $session['usuarioSession'];
        $subTipoDocumento = $_POST['subTipoDocumento'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion=7, @usuarioLogin='".$usuarioLogin."', @subTipoDocumento='".$subTipoDocumento."'")->queryAll();
        return json_encode($Respuesta);
    }

    public function actionObtenersubtipos()
    {
        $codigoDocumento = $_POST['codigoDocumento'];
        $subtipos = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoDocumento,'SN' codigoSubtipo,'SIN SELECCIÓN' descripcionSubtipo 
        UNION ALL SELECT idSecuencia,codigoDocumento,codigoSubtipo,descripcionSubtipo 
                                                FROM nqr.subtipoDocumentoNQR
                                                where codigoDocumento = '".$codigoDocumento."' AND estado = 1") ->queryAll();

        return json_encode($subtipos);
    }

    public function actionObtenerareas()
    {
        $codigoDocumento = $_POST['codigoDocumento'];
        $dondeOcurrioAreas = \Yii::$app->db->createCommand("SELECT idSecuencia,codigoDocumento,dondeOcurrioArea,estado FROM dondeOcurrioArea where codigoDocumento='".$codigoDocumento."' AND  estado = 1") ->queryAll();
              
        return json_encode($dondeOcurrioAreas);
    }

    public function actionObtenersubareas()
    {
        $idArea = $_POST['idArea'];
        $subAreas = \Yii::$app->db->createCommand("SELECT  'SIN SELECCIÓN' descripcionSubArea
            UNION ALL 
            SELECT DISTINCT descripcionSubArea
            FROM nqr.areas where descripcionArea = '".$idArea."' AND estado = 1")->queryAll();
              
        return json_encode($subAreas);
    }
    
    public function actionObtenerinputtext()//FUNCION PARA OBTENER LOS USUARIOS Y AREAS DE LOS EMISORES Y RECEPTORES
    {
        $inputText = @$_POST['inputText'];
        $codigoSubtipo = $_POST['codigoSubtipo'];
        $opcion = $_POST['opcion'];
        $filtroBusqueda = $_POST['filtroBusqueda'];
        
        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion='".$opcion."', @subTipoDocumento='".$codigoSubtipo."',@inputText='".$inputText."',@filtroBusqueda='".$filtroBusqueda."'")->queryAll();
        return json_encode($Respuesta);
    }

    public function actionObtenerinfoproducto()//FUNCION PARA OBTENER LA INFORMACIÓN DEL PRODUCTO
    {
        $inputText = @$_POST['inputText'];
        $opcion = $_POST['opcion'];
        $filtroBusqueda = $_POST['filtroBusqueda'];
        $accion = @$_POST['accion'];
        
        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion='".$opcion."',@inputText='".$inputText."',@filtroBusqueda='".$filtroBusqueda."',@accion='".$accion."'")->queryAll();
        return json_encode($Respuesta);
    }
    
    public function actionGuardarproductotemp()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $datoLote = @$_POST['datoLote'];
        $datoReferencia = @$_POST['datoReferencia'];
        $datoMarca = @$_POST['datoMarca'];
        $datoFactura = @$_POST['datoFactura'];
        $datoContenedor = @$_POST['datoContenedor'];

        $productoTemp = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion=7
        , @codigoProduccion='".$datoLote."', @Referencia='".$datoReferencia."', @Marca='".$datoMarca."', @Factura='".$datoFactura."', @Contenedor='".$datoContenedor."'") ->queryAll();            
        return json_encode($productoTemp);     
    }

    public function actionObtenerdatosadicionales()
    {
        $filtroBusqueda = $_POST['filtroBusqueda'];
        $opcion = $_POST['opcion'];
        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion='".$opcion."',@filtroBusqueda='".$filtroBusqueda."'")->queryAll();
        return json_encode($Respuesta);        
    }
   

    //FUNCIONES DE LAS CLAUSULAS (REQUISITOS)
    public function actionObtenerclausulas()
    {
        $codigoNorma = $_POST['codigoNorma'];
        $valorBusquedaRequisito = @$_POST['valorBusquedaRequisito'];

        $clausulas = \Yii::$app->db->createCommand("
        SELECT idSecuencia,codigoNorma,requisito FROM nqr.requisitos where codigoNorma = '".$codigoNorma."' AND requisito like '%".$valorBusquedaRequisito."%' AND estado=1") ->queryAll();
        
        return json_encode($clausulas);
    }

    public function actionRevision()
    {
        $tipoDocumentos = \Yii::$app->db->createCommand("SELECT 'SN' codigoDocumento,'SIN SELECCIÓN' descripcionDocumento UNION ALL
        SELECT codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR WHERE estado = 1") ->queryAll();

        return $this->render('revision',['tipoDocumentos'=>$tipoDocumentos]);        
    }

    //FUNCIONES PARA LA GENERACION DE SOLICITUDES -- INICIO
    public function actionGenerarsolicitud()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoDocumento = @$_POST['codigoDocumento'];
        $codigoSubtipo = @$_POST['codigoSubtipo'];
        $codigoAuditoria = @$_POST['codauditoria'];
        $usuarioEmisor = @$_POST['usuarioEmisor'];
        $usuarioReceptor = @$_POST['usuarioReceptor'];
        $areaEmisor = @$_POST['areaEmisor'];
        $areaReceptor = @$_POST['areaReceptor'];
        $contactosReceptor = @$_POST['contactosReceptor'];
        $hallazgoDescripcion = @$_POST['hallazgo'];
        $tratamientoInmediatoDescripcion = @$_POST['tratamientoInmediato'];
        $fechaCuandoOcurrio = @$_POST['fechaCuandOcurrio'];
        $dondeOcurrioArea = @$_POST['dondeOcurrioArea'];
        $dondeOcurrioSubArea = @$_POST['dondeOcurrioSubArea'];

        $codigosNormas = @$_POST['codigosNormas'];
        $codigosProductos = @$_POST['codigosProductos'];
        $codigoReclamo = @$_POST['tipoReclamo'];
        $ordenCompra = @$_POST['ordenCompra'];
        $itemProducto = @$_POST['itemProducto'];
        $idSecuenciaDocumentos = @$_POST['idSecuenciaDocumentos'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion=1, @codigoTipoDocumento='".$codigoDocumento."',@codigoSubtipoDocumento='".$codigoSubtipo."',@codigoAuditoria='".$codigoAuditoria."'
        ,@areaEmisor='".$areaEmisor."',@areaReceptor='".$areaReceptor."',@usuarioEmisor='".$usuarioEmisor."',@usuarioReceptor='".$usuarioReceptor."',@contactosReceptor='".$contactosReceptor."'
        ,@hallazgoDescripcion='".$hallazgoDescripcion."',@tratamientoInmediatoDescripcion='".$tratamientoInmediatoDescripcion."',@fechaCuandoOcurrio='".$fechaCuandoOcurrio."',@dondeOcurrioArea='".$dondeOcurrioArea."',@dondeOcurrioSubArea='".$dondeOcurrioSubArea."',@codigosArchivos='".$idSecuenciaDocumentos."'
        ,@codigosNormas='".$codigosNormas."',@codigosProductos='".$codigosProductos."',@codigoReclamo='".$codigoReclamo."',@ordenCompra='".$ordenCompra."',@itemProducto='".$itemProducto."',@usuarioCrea='".$usuario."'")->queryAll();

        return json_encode($Respuesta);
    }

    public function actionObetenertipos_qu_re()
    {   
        $codigoSubtipo = @$_POST['codigoSubtipo'];
        $Respuesta = \Yii::$app->db->createCommand("SELECT DISTINCT tipoReclamo FROM nqr.tipoClasificacionSubReclamos WHERE codigoSubtipoDoc = '".$codigoSubtipo."' AND estado = 1")->queryAll();

        return json_encode($Respuesta);
    }
    //FUNCIONES PARA LA GENERACION DE SOLICITUDES -- FIN

    //FUNCIONES PARA LA GESTION DE SOLICITUDES -- INICIO
    public function actionObtenerbusquedanqr()
    {   
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $tipoDocumento = @$_POST['tipoDocumento'];
        $estadoDocumento = @$_POST['estadoDocumento'];
        $fechaInicio = @$_POST['fechaInicio'];
        $fechaFin = @$_POST['fechaFin'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion=2, @codigoTipoDocumento='".$tipoDocumento."', @estadoSolicitud='".$estadoDocumento."',@usuarioModifica='".$usuario."'")->queryAll();
        return json_encode($Respuesta);
    }

    public function actionAprobarnegarsolicitud()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $retroalimentacion = @$_POST['retroalimentacion'];
        $aprobar = $_POST['aprobar'];
        $tipoDocumento = $_POST['tipoDocumento'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion=3, @codigoSolicitudDocumento='".$codigoSolicitudDocumento."', @detalleRetroalimentacion='".$retroalimentacion."',@estadoSolicitud='".$aprobar."',@codigoTipoDocumento='".$tipoDocumento."',@usuarioModifica='".$usuario."'")->queryAll();
        return json_encode($Respuesta);

    }

    public function actionObtenerbusqueda()
    {   
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion=1, @codigoSolicitudDocumento='".$codigoSolicitudDocumento."'")->queryAll();
        return json_encode($Respuesta);
    }  
    
    public function actionObteneradicionales()
    {   
        $codigoSolicitudDocumento = @$_POST['codigoSolicitudDocumento'];
        $dato = @$_POST['dato'];
        $opcion = $_POST['opcion']; //idAdicional = adicionales.id;

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@dato='".$dato."'")->queryAll();
        return json_encode($Respuesta);
    }   
    
    public function actionActualizaradicionales()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = @$_POST['codigoSolicitudDocumento'];
        $opcion = $_POST['opcion'];
        $codigoAreaResponsable = $_POST['idAdicional'];
        $codigoGestor = $_POST['idAdicional'];
        $codigoTipoDocumento = $_POST['idAdicional'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion='".$opcion."', @codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@codigoGestor='".$codigoGestor."',@codigoAreaResponsable='".$codigoAreaResponsable."',@codigoTipoDocumento='".$codigoTipoDocumento."'")->queryAll();

        return json_encode($Respuesta);        
    }
    
    public function actionObtenerpantallaplanaccion()
    {
        $view = 'planAccion';
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];

        $infoSolicitud = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion=2, @codigoSolicitudDocumento='".$codigoSolicitudDocumento."'")->queryAll();
        $causas = \Yii::$app->db->createCommand("exec nqr.spObtenerInformacionNQR @opcion=3")->queryAll();

        return $this->renderAjax($view,['infoSolicitud' => $infoSolicitud,'codigoSolicitudDocumento'=>$codigoSolicitudDocumento,'causas'=>$causas]); 
    }
    
    public function actionGuardarcausas()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $idCausa = $_POST['idCausa'];
        $detalleCausas = $_POST['detalleCausas'];
   
        $areas = \Yii::$app->db->createCommand("INSERT INTO nqr.causaSolicitud
        VALUES ('".$codigoSolicitudDocumento."', '".$idCausa."', '".$detalleCausas."', DEFAULT, '".$usuario."')") ->execute();            
        return json_encode("Ingreso exitoso");        
    }
    //FUNCIONES PARA LA GESTION DE SOLICITUDES -- FIN    


    //FUNCIONES PARA LA ACTULIZACION DEL DOCUMENTO
    public function actionActualizardocumento()
    {

        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoDocumento = @$_POST['codigoDocumento'];
        $codigoSolicitudDocumento = @$_POST['codigoSolicitudDocumento'];
        $codigoSubtipo = @$_POST['codigoSubtipo'];
        $codigoAuditoria = @$_POST['codauditoria'];
        $usuarioEmisor = @$_POST['usuarioEmisor'];
        $usuarioReceptor = @$_POST['usuarioReceptor'];
        $areaEmisor = @$_POST['areaEmisor'];
        $areaReceptor = @$_POST['areaReceptor'];
        $contactosReceptor = @$_POST['contactosReceptor'];
        $hallazgoDescripcion = @$_POST['hallazgo'];
        $tratamientoInmediatoDescripcion = @$_POST['tratamientoInmediato'];
        $fechaCuandoOcurrio = @$_POST['fechaCuandOcurrio'];
        $dondeOcurrioArea = @$_POST['dondeOcurrioArea'];
        $dondeOcurrioSubArea = @$_POST['dondeOcurrioSubArea'];

        $codigosNormas = @$_POST['codigosNormas'];
        $codigosProductos = @$_POST['codigosProductos'];
        $codigoReclamo = @$_POST['tipoReclamo'];
        $ordenCompra = @$_POST['ordenCompra'];
        $itemProducto = @$_POST['itemProducto'];
        $idSecuenciaDocumentos = @$_POST['idSecuenciaDocumentos'];

        $Respuesta = \Yii::$app->db->createCommand("exec nqr.spGestionSolicitud @opcion=9, @codigoTipoDocumento='".$codigoDocumento."',@codigoSubtipoDocumento='".$codigoSubtipo."',@codigoAuditoria='".$codigoAuditoria."'
        ,@areaEmisor='".$areaEmisor."',@areaReceptor='".$areaReceptor."',@usuarioEmisor='".$usuarioEmisor."',@usuarioReceptor='".$usuarioReceptor."',@contactosReceptor='".$contactosReceptor."'
        ,@hallazgoDescripcion='".$hallazgoDescripcion."',@tratamientoInmediatoDescripcion='".$tratamientoInmediatoDescripcion."',@fechaCuandoOcurrio='".$fechaCuandoOcurrio."',@dondeOcurrioArea='".$dondeOcurrioArea."',@dondeOcurrioSubArea='".$dondeOcurrioSubArea."',@codigosArchivos='".$idSecuenciaDocumentos."'
        ,@codigosNormas='".$codigosNormas."',@codigosProductos='".$codigosProductos."',@codigoReclamo='".$codigoReclamo."',@ordenCompra='".$ordenCompra."',@itemProducto='".$itemProducto."',@usuarioModifica='".$usuario."',@codigoSolicitudDocumento='".$codigoSolicitudDocumento."'")->queryAll();

        return json_encode($Respuesta);
    }

    public function actionGuardararchivos()
    {        
            $session = Yii::$app->session;
            $usuario = $session['usuarioSession'];
            $codigoSolicitudDocumento = @$_POST['codigoSolicitudDocumento2'];
            $proceso = $_POST['proceso'];
            $description = $_POST['descDocumento'];
            $file_name = $_FILES['documento']['name'];
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

                    $Documento = \Yii::$app->db->createCommand("EXEC nqr.spPlanificacionNQR @opcion=7,@codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@usuario='".$usuario."',@descDocumento='".$description."',@proceso='".$proceso."',@nombreDocumento='".$nombreDocumento."',@rutaDocumento='".$new_name_file."'")->queryAll();            
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

    public function actionObtenerarchivos()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $opcion = $_POST['opcion'];

        $Documento = \Yii::$app->db->createCommand("EXEC nqr.spPlanificacionNQR @opcion='".$opcion."',@codigoSolicitudDocumento='".$codigoSolicitudDocumento."',@usuario='".$usuario."'")->queryAll();            

        return json_encode($Documento);         
    }

    public function actionEliminararchivos()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $idSecuencia = $_POST['idSecuencia'];
        $nombreDocumento = $_POST['nombreDocumento'];
        $respuesta = "";
        $Documento = \Yii::$app->db->createCommand("delete NQR.documentos where idSecuencia='".$idSecuencia."'")->execute();            
        if (unlink('files/'.$nombreDocumento)) {
          $respuesta = "Documento eliminado con exito";
        } else {
          $respuesta = "El documento no pudo ser eliminado";
        }
        return json_encode($respuesta); 
    }

    public function actionCargardatos()
    {
        $session = Yii::$app->session;
        $usuario = $session['usuarioSession'];
        $codigoSolicitudDocumento = $_POST['codigoSolicitudDocumento'];
        $codigoTipoDocumento = $_POST['codigoTipoDocumento'];

        if ($codigoTipoDocumento == 'NC') {
            $respuesta = \Yii::$app->db->createCommand("SELECT * FROM nqr.requisitos 
                                                        WHERE idSecuencia IN (SELECT StrVal FROM SPRDATUN.dbo.Fn_CreArray((SELECT codigosNormas FROM nqr.solicitudDocumento WHERE codigoSolicitudDocumento = '".$codigoSolicitudDocumento."'),'|'))")->queryAll();
        }
        if ($codigoTipoDocumento == 'QU'){
            $respuesta = \Yii::$app->db->createCommand("SELECT areaDondeOcurrio,subAreaDondeOcurrio,ordenCompraGp,itemProductoGp FROM nqr.solicitudDocumento WHERE codigoSolicitudDocumento = '".$codigoSolicitudDocumento."'")->queryAll();
        }
        if ($codigoTipoDocumento == 'RE'){
            $respuesta = \Yii::$app->db->createCommand("SELECT * FROM nqr.productoNqr 
                                                        WHERE idSecuencia IN (SELECT StrVal FROM SPRDATUN.dbo.Fn_CreArray((SELECT codigosProductos FROM nqr.solicitudDocumento WHERE codigoSolicitudDocumento = '".$codigoSolicitudDocumento."'),'|'))")->queryAll();
        }        
  

        return json_encode($respuesta);
    }
}
?>