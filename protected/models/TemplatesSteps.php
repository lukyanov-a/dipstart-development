<?php

/**
 * This is the model class for table "Templates".
 *
 * The followings are the available columns in table 'Templates':
 * @property string $id
 * @property string $name
 * @property string $steps
 */
class TemplatesSteps extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return Company::getId().'_TemplatesSteps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, steps', 'required'),
			//array('name', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, steps', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('site','ID'),
			'name' => Yii::t('site','Name template'),
			'steps' => Yii::t('site','Steps'),
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
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getCountSteps($id) {
		$model = static::model()->findByPk($id);
		return count(unserialize($model->steps));
	}
}
