<?php

class m190516_101558_create_class_action extends CDbMigration
{
	public function safeUp()
	{
            $this->createTable("ClassAction", array(
                'id' => 'int NOT NULL AUTO_INCREMENT',
                'name' => 'varchar(255)',
                'factor' => 'int NOT NULL',
                'PRIMARY KEY (`id`)'
            ), 'AUTO_INCREMENT=100');
	}

	public function down()
	{
		echo "m190516_101558_create_class_action does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}