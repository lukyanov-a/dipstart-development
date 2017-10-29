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
        $getFilter = array(
            'table' => $table,
            'role'=> $role);
        if($role=="Admin") $getFilter = array('table' => $table);
        return self::model()->findAllByAttributes($getFilter);
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
            case 'CurrentProjects':
            case 'DoneProjects':
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

    public static function getConditionAndParans($table, $role, $pref = 't.') {
        $filter = null;
        if(isset($_GET['filter'])) $filter = Filters::model()->findByPk($_GET['filter']);
        if(!$filter || $filter->table!=$table || ($filter->role!=$role && $role!="Admin")) $filter = Filters::getDefaultFilters($table, $role);
        if($filter) {
            $condition = '';
            $params = array();
            $first = true;
            foreach (unserialize($filter->filter) as $key=>$item) {
                if($first) $first = false;
                else $condition .= ' '.$item['operand'].' ';
                if($item['operator']=="LIKE") {
                    $match = addcslashes($item['value'], '%_');
                    $condition .= $pref.$item['column']." ".$item['operator']." :".$item['column'].'_filter_'.$key;
                    $params[':'.$item['column'].'_filter_'.$key] = "%$match%";
                } else {
                    $condition .= $pref.$item['column']." ".$item['operator']." :".$item['column'].'_filter_'.$key;
                    $params[':'.$item['column'].'_filter_'.$key] = $item['value'];
                }
            }
            if(!empty($params) && !empty($condition)) {
                return array('condition' => $condition, 'params' => $params);
            }
        }
        
        return false;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}