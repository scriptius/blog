<?php
/* @var $this PostsController */
/* @var $model Posts */
/* @var $form CActiveForm */
?>
	<?php if(Yii::app()->user->hasFlash('addPost')): ?>
		<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('addPost'); ?>
		</div>
	<?php endif; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'posts-index-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> ОБЯЗАТЕЛЬНЫ.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title', ['size' => 74]); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model,'image', ['size' => 74]); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content', ['cols' => 75, 'rows' => 15]); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'userId', ['value' => 1]); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'updated_at', ['value' => time()]); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'created_at', ['value' => time()]); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->

<script>
	$('div.rating').rating();
</script>