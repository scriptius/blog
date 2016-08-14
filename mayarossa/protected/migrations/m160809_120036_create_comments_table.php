<?php

class m160809_120036_create_comments_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('Comments', [
			'id' => 'pk',
			'userId' => 'int(11) NOT NULL',
			'content' => 'text NOT NULL',
			'raiting' => 'int(11) NOT NULL DEFAULT 0',
			'parentPost' => 'int(11) DEFAULT NULL',
			'parentComment' => 'int(11) DEFAULT NULL',
			'updated_at' => 'int(11) NOT NULL',
			'created_at' => 'int(11) NOT NULL',
		], 'DEFAULT CHARSET=utf8');

		$adminId = Yii::app()->db->createCommand()
			->select ('id')
			->from('Users')
			->where('username = \'admin\'')
			->queryRow();

		$this->insert('Comments', [
			'userId' => $adminId['id'],
			'content' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
			'raiting' => 0,
			'parentPost' => 1,
			'parentComment' => 'int(11) DEFAULT NULL',
			'updated_at' => 'int(11) NOT NULL',
			'created_at' => 'int(11) NOT NULL',
		]);
		
		
		$this->createIndex('comments_idx', 'Comments', ['raiting', 'userId']);

		$this->addForeignKey('parentPost_fk', 'Comments', 'parentPost', 'Posts', 'id', NULL , 'cascade');
		$this->addForeignKey('parentComment_fk', 'Comments', 'parentComment', 'Comments', 'id', NULL , 'cascade');
		$this->addForeignKey('userId_fk', 'Comments', 'userId', 'Users', 'id', NULL , 'cascade');
	}

	public function safeDown()
	{
		$this->dropTable('Comments');
	}
}