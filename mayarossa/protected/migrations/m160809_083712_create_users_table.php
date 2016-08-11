<?php

class m160809_083712_create_users_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('Users', [
			'id' => 'pk',
			'username' => 'string NOT NULL',
			'password' => 'string NOT NULL',
			'email' => 'string NOT NULL',
			'status' => 'boolean NOT NULL DEFAULT 1',
			'updated_at' => 'int(11) NOT NULL',
			'created_at' => 'int(11) NOT NULL',

		]);
		$this->createIndex('username_idx', 'Users', ['username', 'email'], TRUE);

		$this->insert('Users', [
			'username' => 'admin',
			'password' => '$2y$13$fOmTvADrkqaxcWgT2eqMuev655Svax6AAJx4tTVFFi4Pj6EGQ8Yte',
			'email' => 'admin@test.ru',
			'status' => 1,
			'updated_at' => time(),
			'created_at' => time(),
		]);
	}

	public function safeDown()
	{
		$this->dropTable('Users');
	}
}