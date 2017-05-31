<?php

class m170530_115423_add_Filters extends CDbMigration
{
	public function up()
	{
        $this->createTable('Filters', array(
          'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
          'name' => 'VARCHAR(50) NOT NULL',
          'table' => 'VARCHAR(50) NOT NULL',
          'filter' => 'TEXT NOT NULL',
          'default' => 'TINYINT(1) NOT NULL DEFAULT "0"',
          'role' => 'VARCHAR(50) NOT NULL',
          'PRIMARY KEY (`id`)',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8;');
	}

	public function down()
	{
        $this->dropTable('Filters');
	}
}