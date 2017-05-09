<?php

class m170506_153501_add_contacts_companies extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('Companies', 'contacts', 'varchar(255)');
    }

    public function down()
    {
        $this->dropColumn('Companies', 'contacts');
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