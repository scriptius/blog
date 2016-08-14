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

		], 'DEFAULT CHARSET=utf8');

		$this->createIndex('titlePosts_idx', 'Posts', 'title', TRUE);
		$this->createIndex('posts_idx', 'Posts', ['raiting', 'userId', 'status']);

		$adminId = Yii::app()->db->createCommand()
			->select ('id')
			->from('Users')
			->where('username = \'admin\'')
			->queryRow();

		$this->insert('Posts', [
			'title' => 'What is Lorem Ipsum?',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
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
		$this->dropForeignKey('userId_fk', 'Posts');
		$this->dropTable('Posts');
	}
}