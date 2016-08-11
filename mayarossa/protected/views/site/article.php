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
        'id'=>'allCommentss-allCommentss-form',
        // Please note: When you enable ajax validation, make sure the corresponding 
        // controller action is handling ajax validation correctly. 
        // See class documentation of CActiveForm for details on this, 
        // you need to use the performAjaxValidation()-method described there. 
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($allComments); ?>

    <div class="row">
        <?php echo $form->hiddenField($allComments,'userId', ['value' => $userId]) ; ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($allComments,'content'); ?>
        <?php echo $form->textArea($allComments,'content', ['cols' => 75, 'rows' => 5]); ?>
        <?php echo $form->error($allComments,'content'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($allComments,'updated_at', ['value' => time()]); ?>

    </div>

    <div class="row">
        <?php echo $form->hiddenField($allComments,'created_at', ['value' => time()]); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($allComments,'raiting'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($allComments,'parentPost', ['value' => 1]); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($allComments,'parentallComments', ['value' => 1]); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить коммантарий'); ?>
    </div>

    <?php $this->endWidget(); ?>



</div><!-- form -->

