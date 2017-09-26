<?php

class ClassAction extends CActiveRecord
{
    public function tableName() {
        return self::staticTableName();
    }

    public static function staticTableName() {
        return Company::getId().'_ClassAction';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, factor', 'required'),
            array('factor', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max'=>50),
            array('id, name, factor, summ', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('site','ID'),
            'name' => Yii::t('site','Название'),
            'factor' => Yii::t('site','Коэффициент за действие'),
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('factor',$this->factor,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));
    }

    public static function getName($id) {
        $model = self::model()->findByPk($id);
        return $model->name;
    }

    public static function getFactor($id) {
        $model = self::model()->findByPk($id);
        return $model->factor;
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}