<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1 xmlns="http://www.w3.org/1999/html">Добро пожаловать на  <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php if (!empty($posts)): ?>

	<?php foreach ($posts as $post):?>
		<div class="portlet-title">
			<a href="article/<?= $post->id ?>"> <?= $post->title; ?> </a>
		</div>
		<div class="portlet-content">
			<?= $post->content; ?>
		</div>
	<?php endforeach; ?>

	<?php else: echo 'На текущий момент записей нет';	?>
<?php endif; ?>
