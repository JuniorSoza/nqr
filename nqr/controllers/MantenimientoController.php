<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;

class MantenimientoController extends Controller
{


    public function actionNormas()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {        
            $normas = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoNorma,'SIN SELECCIÓN' descripcionNorma
            UNION all
            SELECT idSecuencia,codigoNorma,descripcionNorma FROM nqr.normas where estado = 1") ->queryAll();
            
            return $this->render('normas',['normas'=>$normas]);
        }else{
            return $this->render('/site/login');
        }
    }

    public function actionTiposdocumentos()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {         
            $tiposDocumentos = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoDocumento,'SIN SELECCIÓN' descripcionDocumento
            UNION all
            SELECT idSecuencia,codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR where estado = 1") ->queryAll();
            
            return $this->render('tiposdocumentos',['tiposDocumentos'=>$tiposDocumentos]);
        }else{
            return $this->render('/site/login');
        }            
    }
    
    public function actionDepartamentos()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {        
            $areas = \Yii::$app->db->createCommand("SELECT * FROM nqr.areas") ->queryAll();
            
            return $this->render('departamentos',['areas'=>$areas]); 
        }else{
            return $this->render('/site/login');
        }        
    }

    public function actionTiposrcqu()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {         
            /*$codigoDondeOcurrioArea = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SIN SELECCIÓN' dondeOcurrioArea, 0 estado
            UNION all
            SELECT idSecuencia,descripcionArea,estado FROM nqr.areas where estado = 1") ->queryAll();*/
            $codigoDondeOcurrioArea = \Yii::$app->db->createCommand("SELECT 'S/D' dondeOcurrioArea,'SIN SELECCIÓN' dondeOcurrioArea, 0 estado
            UNION all
            SELECT distinct descripcionArea,descripcionArea,estado FROM nqr.areas where estado = 1") ->queryAll();

            $codigoSubDocumento = \Yii::$app->db->createCommand("SELECT 'S/D' codigoSubtipo,'SIN SELECCIÓN' descripcionSubtipo
                UNION all
            SELECT distinct codigoSubtipo,descripcionSubtipo FROM nqr.subtipoDocumentoNQR  where estado = 1 AND codigoDocumento = 'RE'") ->queryAll();
                
            return $this->render('tipos-rc-qu',['codigoDondeOcurrioArea'=>$codigoDondeOcurrioArea,'codigoSubDocumento'=>$codigoSubDocumento]); 
        }else{
            return $this->render('/site/login');
        }   
    }

    public function actionGestores()
    {
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {
            return $this->render('gestores');
        }else{
            return $this->render('/site/login');
        }    
    } 

    public function actionUsuarios()
    {

        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {
            $centroCostos = \Yii::$app->db->createCommand("SELECT DISTINCT LTRIM(RTRIM(tcc.cciCentroCosto))cciCentroCosto,tcc.cnoCentroCosto 
                                                                FROM SPRDATUN.dbo.TblPersonalEventual M
                                                                INNER JOIN SPRDATUN.dbo.TblCentroCosto tcc ON tcc.cciCentroCosto = M.cciCentroCosto
                                                                ORDER BY tcc.cnoCentroCosto") ->queryAll();

        $usuariosNQR = \Yii::$app->db->createCommand("SELECT usuario,CentroCosto,ltrim(rtrim(codigoCentroCosto))codigoCentroCosto,apellidos,nombre,correo,descripcionRolUsuario,codigoRolUsuario,CASE WHEN estadoActivo = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END estadoActivoDesc,estadoActivo,responsableDocumental FROM PNC.nqr.UsuarioNQR") ->queryAll();

            //return json_encode($usuariosNQR);             

            return $this->render('usuarios',['centroCostos'=>$centroCostos,'usuariosNQR'=>$usuariosNQR]);
        }else{
            return $this->render('/site/login');
        }    
    }     

    /****************************************************/
    /****************************************************/
    /*********   MANTENIMIENTO DE LAS NORMAS   **********/
    /******************  Y POLITICAS  *******************/
    /****************************************************/
    /****************************************************/
    
    
    //FUNCIONES DE LAS NORMAS
    public function actionGuardarnorma()
    {
        $codigoNorma = $_POST['codigoNorma'];
        $descripcionNorma = $_POST['descripcionNorma'];

        $normas = \Yii::$app->db->createCommand("INSERT INTO  
        nqr.normas VALUES ('".$codigoNorma."', '".$descripcionNorma."', 1)") ->execute();

        return json_encode("Ingreso exitoso");
    }

    public function actionObtenernormas()
    {
        $normas = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoNorma,'SIN SELECCIÓN' descripcionNorma
        UNION all
        SELECT idSecuencia,codigoNorma,descripcionNorma FROM nqr.normas where estado = 1") ->queryAll();

        return json_encode($normas);
    }

    public function actionEliminarnorma()
    {
        $codigoNorma = $_POST['codigoNorma'];

        $normas = \Yii::$app->db->createCommand("UPDATE nqr.normas SET estado=0 where codigoNorma = '".$codigoNorma."'") ->execute();

        return json_encode("Norma eliminada sin novedad");
    }

    public function actionActualizarnorma()
    {
        $codigoNormaCod = $_POST['codigoNormaCod'];
        $codigoNorma = $_POST['codigoNorma'];
        $descripcionNorma = $_POST['descripcionNorma'];

        $normas = \Yii::$app->db->createCommand("UPDATE nqr.normas SET codigoNorma='".$codigoNorma."',descripcionNorma='".$descripcionNorma."' 
                                                where codigoNorma = '".$codigoNormaCod."'") ->execute();        
        return json_encode("Actualizado con exito");
    }

    public function actionObtenernorma()
    {
        $codigoNorma = $_POST['codigoNorma'];
        $norma = \Yii::$app->db->createCommand("
        SELECT idSecuencia,codigoNorma,descripcionNorma FROM nqr.normas where codigoNorma = '".$codigoNorma."'") ->queryAll();

        return json_encode($norma);
    }

    //FUNCIONES DE LAS CLAUSULAS (REQUISITOS)
    public function actionObtenerclausulas()
    {
        $codigoNorma = $_POST['codigoNorma'];
        $clausula = $_POST['clausula'];

        $clausulas = \Yii::$app->db->createCommand("
        SELECT * FROM nqr.requisitos where codigoNorma = '".$codigoNorma."' and requisito like '%".$clausula."%' and estado=1") ->queryAll();
        
        return json_encode($clausulas);
    }

    public function actionActualizarclausula()
    {
        $secuencialClausula = $_POST['secuencialClausula'];
        $decripcionClausula = $_POST['decripcionClausula'];

        $clausula = \Yii::$app->db->createCommand("UPDATE nqr.requisitos SET requisito = '".$decripcionClausula."' where idSecuencia='".$secuencialClausula."'") ->execute();

        return json_encode('Actualizado con exito');          

    }    

    public function actionGuardarclausula()
    {
        $codigoNorma = $_POST['codigoNorma'];
        $requisito = $_POST['requisito'];

        $normas = \Yii::$app->db->createCommand("INSERT INTO nqr.requisitos VALUES ('".$codigoNorma."', '".$requisito."', 1)") ->execute();        
        return json_encode("Ingreso exitoso");        
    }

    public function actionEliminarclausula()
    {
        $secuencialClausula = $_POST['secuencialClausula'];
        $decripcionClausula = $_POST['decripcionClausula'];

        $normas = \Yii::$app->db->createCommand("UPDATE nqr.requisitos SET estado = 0 where idSecuencia='".$secuencialClausula."'") ->execute();

        return json_encode('Clausula eliminada sin novedad');  
    }


    /****************************************************/
    /****************************************************/
    /********* MANTENIMIENTO DE LOS DOCUMENTOS **********/
    /*************  Y TIPOS DE DOCUMENTOS   *************/
    /****************************************************/
    /****************************************************/

    public function actionGuardardocumento()
    {
        $codigoDocumento = $_POST['codigoDocumento'];
        $descripcionDocumento = $_POST['descripcionDocumento'];

        $tipoDocumentoNQR = \Yii::$app->db->createCommand("INSERT INTO  
        nqr.tipoDocumentoNQR VALUES ('".$codigoDocumento."', '".$descripcionDocumento."', 1)") ->execute();

        return json_encode("Ingreso exitoso");        
    }

    public function actionObtenerdocumentos()
    {
        $normas = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoDocumento,'SIN SELECCIÓN' descripcionDocumento
        UNION all
        SELECT idSecuencia,codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR where estado = 1") ->queryAll();

        return json_encode($normas);
    }

    public function actionObtenerdocumento()
    {
        $codigoDocumento = $_POST['codigoDocumento'];
        $tipoDocumento = \Yii::$app->db->createCommand("
        SELECT idSecuencia,codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR where codigoDocumento = '".$codigoDocumento."'") ->queryAll();

        return json_encode($tipoDocumento);
    } 
    
    public function actionActualizardocumento()
    {
        $codigoDocumentoCod = $_POST['codigoDocumentoCod'];
        $codigoDocumento = $_POST['codigoDocumento'];
        $descripcionDocumento = $_POST['descripcionDocumento'];

        $normas = \Yii::$app->db->createCommand("UPDATE nqr.tipoDocumentoNQR SET codigoDocumento='".$codigoDocumento."',descripcionDocumento='".$descripcionDocumento."' 
                                                where codigoDocumento = '".$codigoDocumentoCod."'") ->execute();        
        return json_encode("Actualizado con exito");
    }

    public function actionEliminardocumento()
    {
        $codigoDocumento = $_POST['codigoDocumento'];

        $tipoDocumento = \Yii::$app->db->createCommand("UPDATE nqr.tipoDocumentoNQR SET estado=0 where codigoDocumento = '".$codigoDocumento."'") ->execute();

        return json_encode("Tipo de documento eliminada sin novedad");
    }    

        
    /****************************************************/
    /****************************************************/
    /********* MANTENIMIENTO DE LOS SUBTIPO *************/
    /**************** DE DOCUMENTOS   *******************/
    /****************************************************/
    /****************************************************/
    public function actionObtenersubtipos()
    {
        $codigoDocumento = $_POST['codigoDocumento'];

        $subtipos = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN' codigoDocumento,'SN' codigoSubtipo,'SIN SELECCIÓN' descripcionSubtipo 
        UNION ALL SELECT idSecuencia,codigoDocumento,codigoSubtipo,descripcionSubtipo 
                                                FROM nqr.subtipoDocumentoNQR
                                                where codigoDocumento = '".$codigoDocumento."'") ->queryAll();

        return json_encode($subtipos);
    }

    public function actionGuardarsubtipo()
    {
        $codigoDocumento = $_POST['codigoDocumento'];
        $codigoSubtipo = $_POST['codigoSubtipo'];
        $descripcionSubtipo = $_POST['descripcionSubtipo'];
        $codigoSubtipoCod = $_POST['codigoSubtipoCod'];

        $normas = \Yii::$app->db->createCommand("INSERT INTO  
        nqr.subtipoDocumentoNQR VALUES ('".$codigoDocumento."', '".$codigoSubtipo."', '".$descripcionSubtipo."', 1)") ->execute();

        return json_encode("Ingreso exitoso");
    }

    public function actionActualizarsubtipo()
    {
        $codigoSubtipo = $_POST['codigoSubtipo'];
        $descripcionSubtipo = $_POST['descripcionSubtipo'];
        $codigoSubtipoCod = $_POST['codigoSubtipoCod'];

        $subtipo = \Yii::$app->db->createCommand("UPDATE nqr.subtipoDocumentoNQR SET codigoSubtipo='".$codigoSubtipo."',descripcionSubtipo='".$descripcionSubtipo."' 
                                                where codigoSubtipo = '".$codigoSubtipoCod."'") ->execute();        
        return json_encode("Actualizado con exito");

    }  
    
    public function actionObtenersubtipo()
    {
        $codigoSubtipo = $_POST['codigoSubtipo'];
        $subtipo = \Yii::$app->db->createCommand("
        SELECT idSecuencia,codigoDocumento,codigoSubtipo,descripcionSubtipo,estado FROM nqr.subtipoDocumentoNQR where codigoSubtipo = '".$codigoSubtipo."'") ->queryAll();

        return json_encode($subtipo);
    }   
    
    public function actionEliminarsubtipo()
    {
        $codigoSubtipo = $_POST['codigoSubtipo'];

        $subtipo = \Yii::$app->db->createCommand("UPDATE nqr.subtipoDocumentoNQR SET estado=0 where codigoSubtipo = '".$codigoSubtipo."'") ->execute();

        return json_encode("Subtipo eliminado sin novedad");
    }      

    /****************************************************/
    /****************************************************/
    /***** MANTENIMIENTO DE AREAS (DONDE OCURRIO) *******/
    /****************************************************/
    /****************************************************/

    public function actionGuardararea()
    {
        $opcion = $_POST['opcion'];
        $area = $_POST['area'];
        $subarea = $_POST['subarea'];
        $puesto = $_POST['puesto'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $idSecuencia = @$_POST['idSecuencia'];

        if ($opcion == 1 ){
            $areas = \Yii::$app->db->createCommand("INSERT INTO  
            nqr.areas VALUES ('".$area."', '".$subarea."', '".$puesto."', '".$nombre."', '".$correo."', 1)") ->execute();
        }
        if ($opcion == 2 ){
            $areas = \Yii::$app->db->createCommand("UPDATE   
            nqr.areas SET descripcionArea = '".$area."',descripcionSubArea = '".$subarea."' ,descripcionPuesto = '".$puesto."'
            ,descripcionNombre = '".$nombre."',correo = '".$correo."' 
             WHERE idSecuencia = '".$idSecuencia."'") ->execute();            
        }
        return json_encode("Ingreso exitoso");
    }

    public function actionObtenerareas()
    {
        $areas = \Yii::$app->db->createCommand("SELECT * FROM nqr.areas") ->queryAll();
        return json_encode($areas);        
    }

    public function actionObtenerarea()
    {
        $idSecuencia = $_POST['idSecuencia'];
        $areas = \Yii::$app->db->createCommand("SELECT * FROM nqr.areas WHERE idSecuencia = '".$idSecuencia."'") ->queryAll();
        return json_encode($areas);        
    }

    public function actionEliminararea()
    {
        $idSecuencia = $_POST['idSecuencia'];
        $accion = $_POST['accion'];

        $areas = \Yii::$app->db->createCommand("UPDATE   
        nqr.areas SET estado = '".$accion."' WHERE idSecuencia = '".$idSecuencia."'") ->execute();

        return json_encode($areas);          
    }

    /****************************************************/
    /****************************************************/
    /*MANTENIMIENTO TIPO DE RECLAMOS 
                      (clasificacion y subclasificacion)*/
    /****************************************************/
    /****************************************************/
    public function actionObtenertiporeclamos()
    {
        //$codigoDondeOcurrioArea = $_POST['codigoDondeOcurrioArea'];

        $tiposReclamos = \Yii::$app->db->createCommand("SELECT a.idSecuencia,ISNULL(dn.descripcionSubtipo,a.codigoSubtipoDoc)descripcionSubtipo,
                                                                a.codigoDondeOcurrioArea,a.area,a.codigoSubtipoDoc,a.tipoReclamo
                                                                ,a.clasificacion,a.subclasificacion,a.estado 
                                                        FROM nqr.tipoClasificacionSubReclamos a
                                                            LEFT JOIN nqr.subtipoDocumentoNQR dn ON dn.codigoSubtipo = a.codigoSubtipoDoc") ->queryAll();

        return json_encode($tiposReclamos);          
    }  

    public function actionGuardartiporeclamos()
    {
        $codigoDondeOcurrioArea = $_POST['codigoDondeOcurrioArea'];
        $descripcionTipoReclamo = $_POST['descripcionTipoReclamo'];
        $clasificacion = @$_POST['clasificacion'];
        $subclasificacion = @$_POST['subclasificacion'];
        $codigoSubDocumento = @$_POST['codigoSubDocumento'];

        $tiposReclamos = \Yii::$app->db->createCommand("INSERT into nqr.tipoClasificacionSubReclamos 
                                                        values (0,'".$descripcionTipoReclamo."','".$clasificacion ."','".$subclasificacion."',DEFAULT,'".$codigoDondeOcurrioArea."','".$codigoSubDocumento."')") ->execute();

        return json_encode("Ingreso exitoso");          
    }  

    public function actionObtenertiporeclamo()
    {
        $idSecuencia = $_POST['idSecuencia'];
        $tiposReclamo = \Yii::$app->db->createCommand("SELECT * FROM nqr.tipoClasificacionSubReclamos 
        where idSecuencia ='".$idSecuencia."'") ->queryAll();

        return json_encode($tiposReclamo); 

    }

    public function actionActualizartiporeclamo()
    {
        $idSecuencia = $_POST['idSecuencia'];
        $codigoDondeOcurrioArea = $_POST['codigoDondeOcurrioArea'];
        $descripcionTipoReclamo = $_POST['descripcionTipoReclamo'];
        $clasificacion = @$_POST['clasificacion'];
        $subclasificacion = @$_POST['subclasificacion'];
        $codigoSubDocumento = @$_POST['codigoSubDocumento'];

        $tiposReclamos = \Yii::$app->db->createCommand("UPDATE nqr.tipoClasificacionSubReclamos
                                                        SET tipoReclamo = '".$descripcionTipoReclamo."',Clasificacion='".$clasificacion."',subclasificacion='".$subclasificacion ."',codigoSubtipoDoc='".$codigoSubDocumento."',area='".$codigoDondeOcurrioArea."' 
                                                        WHERE idSecuencia = '".$idSecuencia."'") ->execute();

        return json_encode("Actualizacion exitoso");          

    }
    
    public function actionEliminartiporeclamo()
    {
        $idSecuencia = $_POST['idSecuencia'];
        $accion = $_POST['accion'];

        $tipoReclamos = \Yii::$app->db->createCommand("UPDATE nqr.tipoClasificacionSubReclamos 
                                                SET estado = '".$accion."' 
                                                WHERE idSecuencia = '".$idSecuencia."'") ->execute();

        return json_encode($tipoReclamos);          
    }

    /****************************************************/
    /****************************************************/
    /***** MANTENIMIENTO DE GESTORES ********************/
    /****************************************************/
    /****************************************************/
    public function actionObtenergestores()
    {
        $tipoGestor = $_POST['tipoGestor'];
        $gestores = \Yii::$app->db->createCommand("SELECT 0 idSecuencia,'SN-SIN SELECCIÓN' gestor
        UNION ALL
        SELECT idSecuencia,gestor FROM  nqr.gestores WHERE tipo='".$tipoGestor."'") ->queryAll();

        return json_encode($gestores);     
    }

    public function actionObtenergestor()
    {
        $idGestor = $_POST['idGestor'];

        $gestor = \Yii::$app->db->createCommand("SELECT * FROM  nqr.gestores WHERE idSecuencia = '".$idGestor."'") ->queryAll();

        return json_encode($gestor);          
    }

    public function actionGuardargestor()
    {
        $opcion = @$_POST['opcion'];
        $idGestor = @$_POST['idGestor'];
        $nombreGestor = $_POST['nombreGestor'];
        $correoGestor = $_POST['correoGestor'];
        $tipoGestor = $_POST['tipoGestor'];
        $estadoGestor = $_POST['estadoGestor'];
        $respuesta = "Ingreso exitoso";

        if ($opcion == 1 ){
            $areas = \Yii::$app->db->createCommand("INSERT INTO  
            nqr.gestores VALUES ('".$nombreGestor."', '".$correoGestor."', '".$tipoGestor."', '".$estadoGestor."','janchundia')") ->execute();

        }
        if ($opcion == 2 ){
            $areas = \Yii::$app->db->createCommand("UPDATE   
            nqr.gestores SET gestor = '".$nombreGestor."',correo = '".$correoGestor."',tipo = '".$tipoGestor."',estado = '".$estadoGestor."' WHERE idSecuencia = '".$idGestor."'") ->execute();            
            $respuesta="Actualizacion exitoso";
        }

        return json_encode($respuesta);
    }

    /****************************************************/
    /****************************************************/
    /***** MANTENIMIENTO DE LOS USUARIOS DEL SIST********/
    /****************************************************/
    /****************************************************/

    /****************************************************/
    /****************************************************/
    /***** MANTENIMIENTO DE LOS USUARIOS DEL SIST********/
    /****************************************************/
    /****************************************************/

    public function actionObtenerusuariosnqr()
    {

        $usuariosNQR = \Yii::$app->db->createCommand("SELECT usuario,CentroCosto,ltrim(rtrim(codigoCentroCosto))codigoCentroCosto,apellidos,nombre,correo,descripcionRolUsuario,codigoRolUsuario,CASE WHEN estadoActivo = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END estadoActivoDesc,estadoActivo,responsableDocumental FROM PNC.nqr.UsuarioNQR") ->queryAll();

        return json_encode($usuariosNQR);     
    }

    public function actionObtenerusuarionqr()
    {

        $idUsuario = $_POST['idUsuario'];

        $usuariosNQR = \Yii::$app->db->createCommand("SELECT usuario,CentroCosto,ltrim(rtrim(codigoCentroCosto))codigoCentroCosto,apellidos,nombre,correo,descripcionRolUsuario,codigoRolUsuario,CASE WHEN estadoActivo = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END estadoActivoDesc,estadoActivo,responsableDocumental FROM PNC.nqr.UsuarioNQR where usuario='".$idUsuario."'") ->queryAll();

        return json_encode($usuariosNQR);     
    }  

    public function actionGuardarusuarionqr()
    {
        $opcion = $_POST['opcion'];
        $usuario =  $_POST['usuario'];
        $nombre =  @$_POST['nombre'];
        $apellidos =  @$_POST['apellidos'];
        $estadoActivo = @$_POST['estadoActivo'];
        $codigoRolUsuario = @$_POST['codigoRolUsuario'];
        $descripcionRolUsuario = @$_POST['descripcionRolUsuario'];
        $correo = @$_POST['correo']; 
        $codigoCentroCosto = @$_POST['codigoCentroCosto'];
        $CentroCosto = @$_POST['CentroCosto'];
        $responsableDocumental = @$_POST['responsableDocumental'];
        $respuesta = "Ingreso exitoso";

        try{
            if ($opcion == 1 ){
                $areas = \Yii::$app->db->createCommand("INSERT INTO nqr.UsuarioNQR (usuario, CentroCosto, codigoCentroCosto, apellidos, nombre, descripcionRolUsuario, codigoRolUsuario, estadoActivo, correo,responsableDocumental)
                    VALUES ('".$usuario."', '".$CentroCosto."', '".$codigoRolUsuario."', '".$apellidos."', '".$nombre."', '".$descripcionRolUsuario."', '".$codigoRolUsuario."', DEFAULT, '".$correo."','".$responsableDocumental."')") ->execute();

            }
            if ($opcion == 2 ){
                $areas = \Yii::$app->db->createCommand("UPDATE nqr.UsuarioNQR SET CentroCosto = '".$CentroCosto."',codigoCentroCosto = '".$codigoCentroCosto."',apellidos = '".$apellidos."',nombre = '".$nombre."',descripcionRolUsuario = '".$descripcionRolUsuario."',codigoRolUsuario = '".$codigoRolUsuario."',estadoActivo = '".$estadoActivo."',correo = '".$correo."',responsableDocumental='".$responsableDocumental."' WHERE usuario = '".$usuario."'") ->execute();            
                $respuesta="Actualizacion exitoso";
            }
        } catch (\Throwable $th) {
            $respuesta="Error de ingreso de usuario";
            return json_encode($respuesta);
        }
        return json_encode($respuesta);
    }
}
?>