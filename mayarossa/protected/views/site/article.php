<?php
/* @var $this PageController */

$this->pageTitle=Yii::app()->name;
?>


<h1> <?php echo $post->title; ?> </h1>

<div class="portlet-content">
    <?php echo $post->content; ?>
</div>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'comments-comments-form',
        // Please note: When you enable ajax validation, make sure the corresponding 
        // controller action is handling ajax validation correctly. 
        // See class documentation of CActiveForm for details on this, 
        // you need to use the performAjaxValidation()-method described there. 
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($comment); ?>

    <div class="row">
        <?php echo $form->hiddenField($comment,'userId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($comment,'content'); ?>
        <?php echo $form->textArea($comment,'content', ['cols' => 75, 'rows' => 5]); ?>
        <?php echo $form->error($comment,'content'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'updated_at'); ?>

    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'created_at'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'raiting'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'parentPost'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'parentComment'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить коммантарий'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

