<?php
/* @var $this PageController */

$this->pageTitle=Yii::app()->name;
?>
<?php if(Yii::app()->user->hasFlash('addComment')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('addComment'); ?>
    </div>
<?php endif; ?>

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
        <?php echo $form->hiddenField($comment,'userId', ['value' => $userId]) ; ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($comment,'content'); ?>
        <?php echo $form->textArea($comment,'content', ['cols' => 75, 'rows' => 5]); ?>
        <?php echo $form->error($comment,'content'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'updated_at', ['value' => time()]); ?>

    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'created_at', ['value' => time()]); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'raiting'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'parentPost', ['value' => 1]); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'parentcomment', ['value' => 1]); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить комментарий'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php
//var_dump($allComments);
//if (true == is_array($allComments) && !empty($allComments)){
//    foreach ($allComments as $comment){
//        var_dump($comment->content);
//    }
//}else {
//    echo 'На текущий момент комментариев нет';
//}
//?>

<?php if (true == is_array($allComments) && !empty($allComments)): ?>
    <?php foreach ($allComments as $oneComment): ?>
           <?php echo 'Комментарий от: '. $oneComment->author->username.' Отправлено'.date('d-m-o H:m:s',$oneComment->created_at);?>
        <div class="portlet-content-comment">
            <?php echo $oneComment->content;?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="flash-notice">
        На текущий момент комментариев нет. Вы можете быть первым.
    </div>
<?php endif; ?>

