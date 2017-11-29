<?php

class m171128_201551_create_profiles_settings extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable("ProfilesSettings", array(
			'id' => 'int NOT NULL AUTO_INCREMENT',
			'user_id' => 'int NOT NULL',
			'max_waiting_time_teh_email' => 'int',
			'max_waiting_time_teh_sms' => 'int',
			'max_waiting_time_admin_email' => 'int',
			'max_waiting_time_admin_sms' => 'int',
			'max_waiting_time_manager_email' => 'int',
			'max_waiting_time_manager_sms' => 'int',
			'time_work_start' => 'time',
			'time_work_end' => 'time',
			'PRIMARY KEY (`id`)'
		));

		$this->addColumn('Projects', 'technicalspec_date', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
	}

	public function down()
	{
		$this->dropTable('ProfilesSettings');
		$this->dropColumn('Projects', 'technicalspec_date');
	}
}