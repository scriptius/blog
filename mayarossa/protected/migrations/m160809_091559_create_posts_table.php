<?php

class m160809_091559_create_posts_table extends CDbMigration
{
	public function safeUp()
	{
			$this->createTable('Posts', [
			'id' => 'pk',
			'title' => 'string NOT NULL',
			'content' => 'text NOT NULL',
			'image' => 'string DEFAULT NULL',
			'raiting' => 'int(11) NOT NULL DEFAULT 0',
			'userId' => 'int(11) NOT NULL',
			'status' => 'boolean NOT NULL DEFAULT 1',
			'updated_at' => 'int(11) NOT NULL',
			'created_at' => 'int(11) NOT NULL',

		]);

		$this->createIndex('titlePosts_idx', 'Posts', 'title', TRUE);
		$this->createIndex('posts_idx', 'Posts', ['raiting', 'userId', 'status']);

		$adminId = Yii::app()->db->createCommand()
			->select ('id')
			->from('Users')
			->where('username = \'admin\'')
			->queryRow();

		$this->insert('Posts', [
			'title' => 'Тестовый заголовок',
			'content' => 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).',
			'raiting' => '100',
			'userId' => $adminId['id'],
			'status' => 1,
			'updated_at' => time(),
			'created_at' => time(),
		]);

		$this->addForeignKey('userId_fk', 'Posts', 'userId', 'Users', 'id', NULL , 'cascade');
	}

	public function safeDown()
	{
		$this->dropTable('Posts');
	}
}