<?php

class m220516_113512_add_payment_managerlogs extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('ManagerLogs', 'payment', 'INT(11) NULL DEFAULT "0"');
    }

    public function down()
    {
        $this->dropColumn('ManagerLogs', 'payment');
    }
}