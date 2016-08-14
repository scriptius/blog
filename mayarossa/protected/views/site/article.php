<?php
/* @var $this PageController */

$this->pageTitle=Yii::app()->name;
?>
// This part of the message output for flash

<?php if(Yii::app()->user->hasFlash('addComment')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('addComment'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('addRaitingSuccess')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('addRaitingSuccess'); ?>
    </div>
<?php endif; ?>

<h1> <?php echo $post->title; ?> </h1>


<div class="portlet-content">
    <?php echo $post->content; ?>
</div>

<p>
Общий рейтинг поста: <?php echo $raitingPost; ?>
</p>

<p>
    <form action="/site/addraiting" method="post">
        <select size="1" name="raiting">
            <option value="-3" >-3</option>
            <option value="-2">-2</option>
            <option value="-1">-1</option>
            <option value="0" selected>0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <input type="hidden" name="postId" value="<?php echo $post->id ?>">
        <input type="submit" value="Оценить пост">
    </form>
</p>

<hr>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'comments-comments-form',
        'action' => '/site/AddComment',
        // Please note: When you enable ajax validation, make sure the corresponding 
        // controller action is handling ajax validation correctly. 
        // See class documentation of CActiveForm for details on this, 
        // you need to use the performAjaxValidation()-method described there. 
        'enableAjaxValidation'=>false,
    ));
    ?>

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
        <?php echo $form->hiddenField($comment,'raiting', ['value' => 0]); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'parentPost', ['value' => $parentPost]); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($comment,'parentComment'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить комментарий'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

// This part for comments

<?php if (true == is_array($allComments) && !empty($allComments)): ?>
    <?php foreach ($allComments as $oneComment): ?>
           <?php echo $oneComment->author->username.' / '.date('d-m-o H:m:s',$oneComment->created_at);?>
        <div class="portlet-content-comment">
            <?php echo $oneComment->content; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="flash-notice">
        На текущий момент комментариев нет. Вы можете быть первым.
    </div>
<?php endif; ?>

