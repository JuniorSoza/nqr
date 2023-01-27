<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\AlertLte;

?>
<?php 
$session = Yii::$app->session;
//CUANDO SE ESTA LOGEADO
if (isset($session['usuarioSession']))
{
?>
	  <!-- Content Wrapper. Contains page content -->
	  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
			<?php if (isset($this->blocks['content-header'])) { ?>
				<h1><?= $this->blocks['content-header'] ?></h1>
			<?php } else { ?>
				<h1>
					<?php
					if ($this->title !== null) {
						
						//echo \yii\helpers\Html::encode($this->title);
					} else {
						echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
					} ?>
				</h1>
			<?php } ?>

			<?=
			Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
        </section>

        <!-- Main content -->
        <section class="content">
			<?= $content ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php

//CUANDO NO ESTA LOGEADO
}else
{
?>
	  <!-- Content Wrapper. Contains page content -->
	  <div class="">
        <!-- Main content -->
        <section class="content-login">
			<?= $content ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php
}
?>

