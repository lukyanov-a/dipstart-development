<?php

class Filters extends CActiveRecord {
    public function tableName() {
        return Company::getId().'_Filters';
    }

    public function rules()
    {
        return array(
            array('name, table, filter, role, default', 'required'),
            array('id, table, filter, default, role', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('site','ID'),
            'name' => Yii::t('site','Name filter'),
            'table' => Yii::t('site','For table'),
            'filter' => Yii::t('site','Filter'),
            'default' => Yii::t('site','By default'),
            'role' => Yii::t('site','For role'),
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('table',$this->name,true);
        $criteria->compare('default',$this->name,true);
        $criteria->compare('role',$this->name,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    public static function getFilters($table, $role) {
        return self::model()->findAllByAttributes(
            array(
                'table' => $table,
                'role'=> $role));
    }

    public static function getDefaultFilters($table, $role) {
        return self::model()->findByAttributes(
            array(
                'table' => $table,
                'role'=> $role,
                'default' => '1'));
    }
    
    public static function getColumnTable($table) {
        switch ($table) {
            case 'Projects':
                $model = new Project();
                break;
            case 'User':
                $model = new User();
                break;
            case 'Payment':
                $model = new Payment();
                break;
        }

        return $model->getMetaData()->tableSchema->columns;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}