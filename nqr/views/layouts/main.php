<?php

use yii\helpers\Html;
//use app\assets\AppAsset;
//se cambio, para que obtenga los datos del app
use app\assets\AdminLteAsset;

//AppAsset::register($this);
$asset      = AdminLteAsset::register($this);
$baseUrl    = $asset->baseUrl;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name.'-'.$this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php 
$session = Yii::$app->session;
//CUANDO SE ESTA LOGEADO
if (isset($session['usuarioSession']))
{
?>

    <body class="hold-transition skin-blue sidebar-mini">

    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render('header.php', ['baserUrl' => $baseUrl, 'title'=>Yii::$app->name]) ?>
        <?= $this->render('leftside.php', ['baserUrl' => $baseUrl]) ?>
        <?= $this->render('content.php', ['content' => $content]) ?>
        <?= $this->render('footer.php', ['baserUrl' => $baseUrl]) ?>
        <?= $this->render('rightside.php', ['baserUrl' => $baseUrl]) ?>
        <?=  $this->registerCssFile(\Yii::getAlias('@web').'/css/sweetalert.css') ?>
        <?=  $this->registerJsFile(\Yii::getAlias('@web').'/js/sweetalert.js') ?>
        <?=  $this->registerJsFile(\Yii::getAlias('@web').'/js/sweetalert.min.js') ?>
        <link rel="stylesheet" type="text/css" href="/nqr/web/css/jquery.dataTables.css">
        
        <link rel="stylesheet" type="text/css" href="/nqr/web/css/buttons.dataTables.min.css">
    </div>
<?php $this->endBody() ?>

<?php
//CUANDO NO ESTA LOGEADO
}else
{
?>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
        <?= $this->render('content.php', ['content' => $content]) ?>
        <?=  $this->registerCssFile(\Yii::getAlias('@web').'/css/sweetalert.css') ?>
        <?=  $this->registerJsFile(\Yii::getAlias('@web').'/js/sweetalert.js') ?>
        <?=  $this->registerJsFile(\Yii::getAlias('@web').'/js/sweetalert.min.js') ?>
        
    <?php $this->endBody() ?>
<?php
}
?>
<script type="text/javascript" charset="utf8" src="/nqr/web/js/jquery.dataTables.js"></script>

<script type="text/javascript" charset="utf8" src="/nqr/web/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="/nqr/web/js/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="/nqr/web/js/buttons.html5.min.js"></script>


<script type="text/javascript" charset="utf8" src="/nqr/web/select2/js/select2.js"></script>
</body>
</html>
<?php $this->endPage() ?>
