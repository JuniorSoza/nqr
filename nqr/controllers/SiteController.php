<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {        
        $session = Yii::$app->session;
        if (isset($session['usuarioSession']))
        {
            $documentos = \Yii::$app->db->createCommand("
            SELECT dn.codigoDocumento,dn.descripcionDocumento, isnull(COUNT(d.codigoSolicitudDocumento),0)cantidadDocumento
            FROM nqr.tipoDocumentoNQR dn
            LEFT JOIN nqr.solicitudDocumento d ON dn.codigoDocumento = D.codigoTipoDocumento
            GROUP BY dn.codigoDocumento,dn.descripcionDocumento") ->queryAll();
            
            $dataSubtipoDocumento = \Yii::$app->db->createCommand("
            SELECT D.codigoTipoDocumento,dn.descripcionDocumento
            ,D.codigoSubtipoDocumento,dn1.descripcionSubtipo
            ,isnull(COUNT(d.codigoSolicitudDocumento),0)cantidadDocumento
            FROM nqr.solicitudDocumento d 
                LEFT JOIN nqr.tipoDocumentoNQR dn ON d.codigoTipoDocumento = dn.codigoDocumento
                LEFT JOIN nqr.subtipoDocumentoNQR dn1 ON dn1.codigoSubtipo = d.codigoSubtipoDocumento
            GROUP BY D.codigoTipoDocumento,dn.descripcionDocumento,D.codigoSubtipoDocumento,dn1.descripcionSubtipo")->queryAll(); 

            $dataDocumentos = \Yii::$app->db->createCommand("
            SELECT dn.codigoDocumento,dn.descripcionDocumento, d.estadoSolicitud
            ,CASE WHEN d.estadoSolicitud = 'G' THEN 'G-GENERADO'
                  WHEN d.estadoSolicitud = 'C' THEN 'C-CONFIRMADO'
                  WHEN d.estadoSolicitud = 'R' THEN 'R-RECHAZADO'
                  WHEN d.estadoSolicitud = 'P' THEN 'P-PLANIFICADO'
                  WHEN d.estadoSolicitud = 'A' THEN 'A-APROBADO'
                  WHEN d.estadoSolicitud = 'CE' THEN 'CE-CERRADO'
            END estadoSolicitudDesc
            ,isnull(COUNT(d.codigoSolicitudDocumento),0)cantidadDocumento
            FROM nqr.tipoDocumentoNQR dn
                LEFT JOIN nqr.solicitudDocumento d ON dn.codigoDocumento = D.codigoTipoDocumento
            GROUP BY dn.codigoDocumento,dn.descripcionDocumento,d.estadoSolicitud") ->queryAll();

            $documentos2 = \Yii::$app->db->createCommand("
            SELECT dn.codigoDocumento,dn.descripcionDocumento, isnull(COUNT(d.codigoSolicitudDocumento),0)cantidadDocumento
            FROM nqr.tipoDocumentoNQR dn
            LEFT JOIN nqr.solicitudDocumento d ON dn.codigoDocumento = D.codigoTipoDocumento
            WHERE d.usuarioCrea = '".$session['usuarioSession']."'
            GROUP BY dn.codigoDocumento,dn.descripcionDocumento") ->queryAll();
            
            $dataDocumentos2 = \Yii::$app->db->createCommand("
            SELECT dn.codigoDocumento,dn.descripcionDocumento, d.estadoSolicitud
            ,CASE WHEN d.estadoSolicitud = 'G' THEN 'G-GENERADO'
                  WHEN d.estadoSolicitud = 'C' THEN 'C-CONFIRMADO'
                  WHEN d.estadoSolicitud = 'R' THEN 'R-RECHAZADO'
                  WHEN d.estadoSolicitud = 'P' THEN 'P-PLANIFICADO'
                  WHEN d.estadoSolicitud = 'A' THEN 'A-APROBADO'
                  WHEN d.estadoSolicitud = 'CE' THEN 'CE-CERRADO'
            END estadoSolicitudDesc
            ,isnull(COUNT(d.codigoSolicitudDocumento),0)cantidadDocumento
            FROM nqr.tipoDocumentoNQR dn
                LEFT JOIN nqr.solicitudDocumento d ON dn.codigoDocumento = D.codigoTipoDocumento
                WHERE d.usuarioCrea = '".$session['usuarioSession']."'
            GROUP BY dn.codigoDocumento,dn.descripcionDocumento,d.estadoSolicitud") ->queryAll();

            $tipoDocumentos = \Yii::$app->db->createCommand("SELECT 'SN' codigoDocumento, 'TODOS' descripcionDocumento
                UNION ALL
            SELECT codigoDocumento,descripcionDocumento FROM nqr.tipoDocumentoNQR WHERE estado = 1") ->queryAll();            

            $dataSolicitudes = \Yii::$app->db->createCommand("EXEC NQR.spObtenerInformacionNQR @opcion = 19") ->queryAll(); 

            if($session['usuarioRolCodSession']==3){
                return $this->render('index',['documentos'=>$documentos,'dataDocumentos'=>$dataDocumentos,'dataSubtipoDocumento'=>$dataSubtipoDocumento,'dataSolicitudes'=>$dataSolicitudes,'tipoDocumentos'=>$tipoDocumentos]);
            }else if($session['usuarioRolCodSession']==2){
                return $this->render('/solicitud/index2',['documentos'=>$documentos2,'dataDocumentos'=>$dataDocumentos2,'dataSolicitudes'=>$dataSolicitudes,'tipoDocumentos'=>$tipoDocumentos]);
            }else{
                return $this->render('/solicitud/index2',['documentos'=>$documentos2,'dataDocumentos'=>$dataDocumentos2,'dataSolicitudes'=>$dataSolicitudes,'tipoDocumentos'=>$tipoDocumentos]);
            }        

        }else{
            return $this->render('login');
        }

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /** 
    *METODOS PARA EL LOGEO Y EL CIERRE DE SESSION
    */
    //AUTENTICACION DE ACTIVE DIRECTORY
    public function actionAutenticacion()
    {    
        $session = Yii::$app->session;
        $session->open();
  
        $usuario = $_POST["usuario"];        
        $contrasena = $_POST["contrasena"]; 

        // conexión al servidor LDAP
        $ldapconn = ldap_connect("salica.ec") or die("Error de conexion con el servidor.");

        try {
            if ($ldapconn) {
                // realizando la autenticación
                $ldapbind = ldap_bind($ldapconn, "salica\\".$usuario, $contrasena);
                // verificación del enlace
                if ($ldapbind) {
                    //cuando la conexion por active directory es exitosa se envian las opciones de los usuarios
                    //y los permisos permitidos                    
                    //validacion de los permisos y verificacion si el usuario esta habilitado para el uso del sistema
                    $Respuesta = \Yii::$app->db->createCommand("exec nqr.spRegistroyLogeo @opcion=1, @usuarioLogin='".$usuario."'")->queryAll();

                    foreach ($Respuesta as $value) {                        
                        //agregar el usuario a una variable de session                        
                        if ($value['ESTADO']==1){
                            $_SESSION["usuarioSession"]=$usuario;
                            $_SESSION["usuarioLargoSession"]=$value['nombreLargo'];
                            $_SESSION["usuarioRolSession"]=$value['descripcionRolUsuario'];
                            $_SESSION["usuarioRolCodSession"]=$value['codigoRolUsuario'];                            
                            return json_encode(array("estado"=>true,"mensaje"=>"CONEXIÓN CON ÉXITO","usuario"=>$value['usuario']));
                        }else{
                            return json_encode(array("estado"=>false,"mensaje"=>$value['MENSAJE'],"usuario"=>"SD"));
                        }                                                
                     }                                        
                } else {
                    return json_encode(array("estado"=>false,"mensaje"=>"Error de credenciales"));
                }
            }
        } catch (\Throwable $th) {
            return json_encode(array("estado"=>false,"mensaje"=>"Error de credenciales"));
        }

    }

    //DESTRUCCION DE INICIO DE SESSION
    public function actionCerrarsession()
    {
        $session = Yii::$app->session;
        $session->remove('usuarioSession');
        $session->remove('usuarioLargoSession');
        $session->remove('usuarioRolSession');
        $session->remove('usuarioRolCodSession');
        return 1; 
    }

    public function actionDescargarsumarizado()
    {

        $tipoReporte = $_GET['tipR'];
        $tipoDocumento = @$_GET['tipD'];
        $fechaConfirmado = @$_GET['dfeD'];
        $estadoDocumento = @$_GET['estD'];
        $codigoSolicitudDocumento = @$_GET['codSol'];

        if ($tipoReporte=="S"){
        $dataSolicitudes = \Yii::$app->db->createCommand("EXEC NQR.spObtenerInformacionNQR @opcion = 19,@tipoDocumento='".$tipoDocumento."',@fechaConfirmado='".$fechaConfirmado."',@estadoDocumento='".$estadoDocumento."'") ->queryAll();        
        return $this->renderAjax('nqr-sumarizado',['dataSolicitudes'=>$dataSolicitudes]);
        }
        if ($tipoReporte=="I"){
        $dataSolicitudes = \Yii::$app->db->createCommand("EXEC NQR.spObtenerInformacionNQR @opcion = 18,@codigoSolicitudDocumento='".$codigoSolicitudDocumento."'") ->queryAll();        
        return $this->renderAjax('nqr-individual',['dataSolicitudes'=>$dataSolicitudes]);            
        }

    }  

    public function actionObtenerestadosdocumento(){
            
            $session = Yii::$app->session;
            $valor = $_POST["valor"];  


            $dataDocumentos = \Yii::$app->db->createCommand("
            SELECT dn.codigoDocumento,dn.descripcionDocumento, d.estadoSolicitud
            ,dn1.codigoSubtipo,dn1.descripcionSubtipo
            ,CASE WHEN d.estadoSolicitud = 'G' THEN '1-GENERADO'
                  WHEN d.estadoSolicitud = 'C' THEN '2-CONFIRMADO'
                  WHEN d.estadoSolicitud = 'R' THEN '3-RECHAZADO'
                  WHEN d.estadoSolicitud = 'P' THEN '4-PLANIFICADO'
                  WHEN d.estadoSolicitud = 'A' THEN '5-APROBADO'
                  WHEN d.estadoSolicitud = 'CE' THEN '6-CERRADO'
            END estadoSolicitudDesc
            ,isnull(COUNT(d.codigoSolicitudDocumento),0)cantidadDocumento
            FROM nqr.tipoDocumentoNQR dn
                LEFT JOIN nqr.solicitudDocumento d ON dn.codigoDocumento = D.codigoTipoDocumento
                LEFT JOIN nqr.subtipoDocumentoNQR dn1 ON dn1.codigoSubtipo = d.codigoSubtipoDocumento
                WHERE dn1.descripcionSubtipo='".$valor."'
            GROUP BY dn.codigoDocumento,dn.descripcionDocumento,d.estadoSolicitud,dn1.codigoSubtipo,dn1.descripcionSubtipo
            ORDER BY estadoSolicitudDesc") ->queryAll();       


             return json_encode($dataDocumentos);
    }    
}
