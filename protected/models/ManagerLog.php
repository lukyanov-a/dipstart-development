<?php
class ManagerLog extends CActiveRecord
{

	// types of actions
	const ORDER_PAGE_VIEW = 1; // загрузка страницы заказа 
	
	/*
	 * @return string the associated database table name
	 */
	public function tableName() {
		return self::staticTableName();
	}

	public static function staticTableName() {
		return Company::getId().'_ManagerLogs';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, action, datetime', 'required'),
			array('uid, order_id, action', 'numerical', 'integerOnly' => true),
			array('action', 'length', 'max'=>3),
			array('datetime', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
			array('id, uid, action, datetime, order_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => [self::BELONGS_TO, 'User', 'uid'],
			'order' => [self::BELONGS_TO, 'Zakaz', 'order_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('site','ID'),
			'uid' => Yii::t('site','Manager'),
			'datetime' => Yii::t('site','Date and time'),
			'order_id' => Yii::t('site','Order number'),
			'action' => Yii::t('site','Action'),
			'action_1' => Yii::t('site','Order page view'),
		);
	}
	
	public static function getLabel($varname) {
		$arr = self::model()->attributeLabels();
		return $arr[$varname];
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('user.email',$this->uid,true,'OR');
		$criteria->compare('datetime',$this->datetime,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
		));
	}
	
	/*public static function getLogsSumm($pid, $start_date, $finish_date){
		$sql_dates = "select * from 
			(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) `date` from
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
			where `date` between '$start_date' and '$finish_date'";
		$sql_unigue = 'SELECT date as date0, COUNT(*) AS `unique` FROM '.self::staticTableName().' WHERE pid = :pid AND action = '.self::PARTNER_UNIQUE.' AND date >= :start_date AND date <= :finish_date GROUP BY date';
		$sql_sales_first = 'SELECT date as date1, COUNT(*) AS `sales_first` FROM '.self::staticTableName().' WHERE pid = :pid AND action = '.self::FULL_PAYMENT_4_FIRST_ORDER.' AND date >= :start_date AND date <= :finish_date GROUP BY date';
		$sql_sales_repeat = 'SELECT date as date2, COUNT(*) AS `sales_repeat` FROM '.self::staticTableName().' WHERE pid = :pid AND action = '.self::FULL_PAYMENT_4_NON_FIRST_ORDER.' AND date >= :start_date AND date <= :finish_date GROUP BY date';
		$sql_completed_first = 'SELECT date as date3, COUNT(*) AS `completed_first` FROM '.self::staticTableName().' WHERE pid = :pid AND action = '.self::FINISH_FIRST_ORDER_SUCCESS.' AND date >= :start_date AND date <= :finish_date GROUP BY date';
		$sql_completed_repeat = 'SELECT date as date4, COUNT(*) AS `completed_repeat` FROM '.self::staticTableName().' WHERE pid = :pid AND action = '.self::FINISH_NON_FIRST_ORDER_SUCCESS.' AND date >= :start_date AND date <= :finish_date GROUP BY date';
		$sql_profit = 'SELECT date as date5, SUM(summ) as `profit` FROM '.self::staticTableName().' t51 LEFT OUTER JOIN '.Payment::model()->tableName().' t52 ON t51.order_id = t52.order_id WHERE pid = :pid AND action = '.self::FINISH_NON_FIRST_ORDER_SUCCESS.' AND date >= :start_date AND date <= :finish_date AND payment_type = '.Payment::OUTCOMING_WEBMASTER.' GROUP BY date';
		$sql = 'SELECT `date`, `unique`, `sales_first`, `sales_repeat`, `completed_first`, `completed_repeat`, `profit` FROM ('.$sql_dates.') t LEFT OUTER JOIN ('.$sql_unigue.') t0 ON date=date0 LEFT OUTER JOIN ('.$sql_sales_first.') t1 ON date=date1 LEFT OUTER JOIN ('.$sql_sales_repeat.') t2 ON date=date2 LEFT OUTER JOIN ('.$sql_completed_first.') t3 ON date=date3 LEFT OUTER JOIN ('.$sql_completed_repeat.') t4 ON date=date4 LEFT OUTER JOIN ('.$sql_profit.') t5 ON date=date5';
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':pid', $pid, PDO::PARAM_INT);
		$command->bindParam(":start_date",$start_date,PDO::PARAM_STR);
		$command->bindParam(":finish_date",$finish_date,PDO::PARAM_STR);
		return $command->queryAll();
	}*/
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectStatus the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
}