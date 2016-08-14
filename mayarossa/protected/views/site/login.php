<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Авторизация';
$this->breadcrumbs=array(
	'Login',
);
?>

<?php if(Yii::app()->user->hasFlash('needLogin')): ?>
	<div class="flash-error">
		<?php echo Yii::app()->user->getFlash('needLogin'); ?>
	</div>
<?php endif; ?>

<h1>Страница авторизации</h1>

<p>Пожалуйста, заполните следующую форму с вашими учетными данными для входа:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> ОБЯЗАТЕЛЬНЫ.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			К сведению: вы можете авторизоваться, с помощью <kbd>admin</kbd>/<kbd>admin</kbd> или <kbd>test</kbd>/<kbd>test</kbd>.
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
