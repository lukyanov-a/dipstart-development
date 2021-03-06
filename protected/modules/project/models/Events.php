<?php

class Events extends CActiveRecord {
    
	public function tableName() {
		return Company::getId().'_ProjectsEvents';
	}
    
    public function rules() {
        return array(
            array('event_id, description, type', 'required'),
            array('id, event_id, description, type, timestamp, status', 'safe'),
        );
    }
    
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
        
    public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Номер заказа',
			'description' => 'описание',
			'type' => 'Тип',
			'timestamp' => 'Дата',
			'status' => 'Статус',
		);
	}
	
	public static function getCacheKey($role = 'manager')
	{
		if ($role == 'manager') {
			return Company::getId().'-events-manager';
		} elseif ($role == 'sales-manager') {
			return Company::getId().'-events-sales-manager';
		} else {
			return Company::getId().'-events';
		}
	}
	
	protected function afterSave() {
		Yii::app()->cache->delete(self::getCacheKey());
		Yii::app()->cache->delete(self::getCacheKey('sales-manager'));
        return parent::afterSave();
    }
	
	public function afterDelete() {
        Yii::app()->cache->delete(self::getCacheKey());
		Yii::app()->cache->delete(self::getCacheKey('sales-manager'));
        return parent::afterDelete();
    } 
    
    public function scopes() {
        return array(
            'forManager'=>array(
                'condition'=>'type IN (1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17)',
            ),
			'forSalesManager'=>array(
                'condition'=>'type IN (14,18)',
            ),
        );
    }
	
    public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
