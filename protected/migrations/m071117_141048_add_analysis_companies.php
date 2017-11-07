<?php

class m071117_141048_add_analysis_companies extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('Companies', 'analysis', 'TINYINT(1) NULL DEFAULT "1"');
    }

    public function down()
    {
        $this->dropColumn('Companies', 'analysis');
    }
}