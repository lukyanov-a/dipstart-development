<?php

class m170516_122255_create_templates_steps extends CDbMigration
{
	public function safeUp()
	{
            $this->createTable("Templatessteps", array(
                'id' => 'int NOT NULL AUTO_INCREMENT',
                'name' => 'varchar(255)',
                'steps' => 'text',
                'PRIMARY KEY (`id`)'
            ));
	}

	public function down()
	{
		echo "m170516_122255_create_templates_steps does not support migration down.\n";
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