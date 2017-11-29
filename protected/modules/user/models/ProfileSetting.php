<?php

class ProfileSetting extends CActiveRecord
{
	public function tableName() {
		return Company::getId().'_'.'ProfilesSettings'; //Yii::app()->getModule('user')->tableProfiles;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		return array(
			array('user_id', 'required'),
			array('max_waiting_time_teh_email,max_waiting_time_teh_sms,max_waiting_time_admin_email,
				max_waiting_time_admin_sms,max_waiting_time_manager_email,max_waiting_time_manager_sms',
				'numerical', 'integerOnly'=>true),
			array('time_work_start,time_work_end', 'safe')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'user_id' => UserModule::t('User ID'),
			'max_waiting_time_teh_email' => Yii::t('site', 'Notify about exceeding the expectation from corrector by email'),
            'max_waiting_time_teh_sms' => Yii::t('site', 'Notify about exceeding the expectation from corrector by sms'),
			'max_waiting_time_admin_email' => Yii::t('site', 'Notify about exceeding the expectation from admin by email'),
			'max_waiting_time_admin_sms' => Yii::t('site', 'Notify about exceeding the expectation from admin by sms'),
			'max_waiting_time_manager_email' => Yii::t('site', 'Notify about exceeding the expectation from manager by email'),
			'max_waiting_time_manager_sms' => Yii::t('site', 'Notify about exceeding the expectation from manager by sms'),
		);

		return $labels;
	}
}
