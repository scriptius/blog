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