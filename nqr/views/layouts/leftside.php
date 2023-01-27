<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!--OPCIONES DEL MENU-->

        <?php 
        $session = Yii::$app->session;
        if(isset($session['usuarioRolCodSession'])){
            if ($session['usuarioRolCodSession']==3){//ROL DE SISTEMA DE GESTION
                echo Menu::widget(
                        [
                            'options' => ['class' => 'sidebar-menu'],
                            'items' => [
                                ['label' => 'Menu', 'options' => ['class' => 'header']],
                                ['label' => 'ESCRITORIO', 'icon' => 'fa fa-dashboard', 
                                    'url' => ['/'], 'active' => $this->context->route == 'site/index'
                                ],
                                [
                                    'label' => 'SOLICITUDES',
                                    'icon' => 'fa fa-tags ',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'GENERAR',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/solicitud/index'],
                            'active' => $this->context->route == 'solicitud/index'
                                        ],
                                        [
                                            'label' => 'ACTUALIZAR',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/solicitud/actualizardoc'],
                            'active' => $this->context->route == 'solicitud/actualizardoc'
                                        ]
                                    ]
                                ],
                                [
                                    'label' => 'BUZÓN',
                                    'icon' => 'fa fa-pencil-square-o',
                                    'url' => ['/buzon/index'],
                                    'active' => $this->context->route == 'buzon/index',
                                ],                                                                                              
                                ['label' => 'RELACIONAR DOCUMENTOS', 'icon' => 'fa fa-clipboard', 'url' => ['/relaciondocumento/index'],]
                                ,
                                [
                                    'label' => 'MANTENIMIENTOS',
                                    'icon' => 'fa fa-check-square-o ',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'NORMAS',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/mantenimiento/normas'],
                            'active' => $this->context->route == 'mantenimiento/normas'
                                        ],
                                        [
                                            'label' => 'TIPOS DOCUMENTOS',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/mantenimiento/tiposdocumentos'],
                            'active' => $this->context->route == 'mantenimiento/tiposdocumentos'
                                        ],
                                        [
                                            'label' => 'DEPARTAMENTOS',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/mantenimiento/departamentos'],
                            'active' => $this->context->route == 'mantenimiento/departamentos'
                                        ],
                                        [
                                            'label' => 'TIPOS RECLAMOS',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/mantenimiento/tiposrcqu'],
                            'active' => $this->context->route == 'mantenimiento/tiposrcqu'
                                        ]
                                        /*[
                                            'label' => 'GESTORES',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/mantenimiento/gestores'],
                            'active' => $this->context->route == 'mantenimiento/gestores'
                                        ]*/
,
                                        [
                                            'label' => 'USUARIOS',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/mantenimiento/usuarios'],
                            'active' => $this->context->route == 'mantenimiento/usuarios'
                                        ]                                                                         
                                    ]                            
                                ], 
                            ],
                        ]
                    );
            }else if($session['usuarioRolCodSession']==2){//ROL DEL GESTOR
                    echo Menu::widget(
                        [
                            'options' => ['class' => 'sidebar-menu'],
                            'items' => [
                                ['label' => 'Menu', 'options' => ['class' => 'header']],
                                ['label' => 'ESCRITORIO', 'icon' => 'fa fa-dashboard', 
                                    'url' => ['/'], 'active' => $this->context->route == 'site/index2'
                                ],                                
                                [
                                    'label' => 'SOLICITUDES',
                                    'icon' => 'fa fa-tags ',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'GENERAR',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/solicitud/index'],
                            'active' => $this->context->route == 'solicitud/index'
                                        ],
                                        [
                                            'label' => 'ACTUALIZAR',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/solicitud/actualizardoc'],
                            'active' => $this->context->route == 'solicitud/actualizardoc'
                                        ]
                                    ]
                                ],                        
                                [
                                    'label' => 'BUZÓN',
                                    'icon' => 'fa fa-pencil-square-o',
                                    'url' => ['/buzon2/index'],
                                    'active' => $this->context->route == 'buzon2/index',
                                ],                                                                        
                            ],
                        ]
                    );
            }else{//ROL DE USUARIO NORMAL
                    echo Menu::widget(
                        [
                            'options' => ['class' => 'sidebar-menu'],
                            'items' => [
                                ['label' => 'Menu', 'options' => ['class' => 'header']],
                                ['label' => 'ESCRITORIO', 'icon' => 'fa fa-dashboard', 
                                    'url' => ['/'], 'active' => $this->context->route == 'site/index2'
                                ],                                
                                [
                                    'label' => 'SOLICITUDES',
                                    'icon' => 'fa fa-tags ',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'GENERAR',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/solicitud/index'],
                            'active' => $this->context->route == 'solicitud/index'
                                        ],
                                        [
                                            'label' => 'ACTUALIZAR',
                                            'icon' => 'fa fa-circle',
                                            'url' => ['/solicitud/actualizardoc'],
                            'active' => $this->context->route == 'solicitud/actualizardoc'
                                        ]
                                    ]
                                ],                        
                                [
                                    'label' => 'BUZÓN',
                                    'icon' => 'fa fa-pencil-square-o',
                                    'url' => ['/buzon2/index'],
                                    'active' => $this->context->route == 'buzon2/index',
                                ],                                                                       
                            ],
                        ]
                    );
            }
        } 
        
        ?>

        
    </section>
    <!-- /.sidebar -->
</aside>
