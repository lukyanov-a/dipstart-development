<?php

class FiltersController extends Controller {

    public $layout='//layouts/second_menu';
    
    public function actionAdmin()
    {
        $model = new Filters();
        
        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionCreate()
    {
        $model = new Filters();

        if(isset($_POST['Filters'])) {
            $filter = array();
            $t_filter = $_POST['Filters']['filter'];
            $_POST['Filters']['default'] = (int)$_POST['Filters']['default'];
            foreach ($t_filter['value'] as $key=>$item) {
                if ($item) {
                    $filter[] = array(
                        'value' => $t_filter['value'][$key],
                        'operator' => $t_filter['operator'][$key],
                        'column' => $t_filter['column'][$key],
                        'operand' => $t_filter['operand'][$key],
                    );
                }
            }
            $_POST['Filters']['filter'] = serialize($filter);
            $model->attributes = $_POST['Filters'];
            if($model->save()) {
                if($model->default) {
                    $defaults = Filters::model()->findByAttributes(
                        array(
                            'table' => $model->table,
                            'role' => $model->role,
                            'default' => '1'), 'id<>:id', array(':id' => $model->id,));
                    if ($defaults) {
                        $defaults->attributes = array('default' => 0);
                        $defaults->save();
                    }
                }
                $this->redirect(array('admin'));
            }
        }
        
        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['Filters'])) {
            $filter = array();
            $t_filter = $_POST['Filters']['filter'];
            $_POST['Filters']['default'] = (int)$_POST['Filters']['default'];
            foreach ($t_filter['value'] as $key=>$item) {
                if ($item) {
                    $filter[] = array(
                        'value' => $t_filter['value'][$key],
                        'operator' => $t_filter['operator'][$key],
                        'column' => $t_filter['column'][$key],
                        'operand' => $t_filter['operand'][$key],
                    );
                }
            }
            $_POST['Filters']['filter'] = serialize($filter);
            $model->attributes = $_POST['Filters'];
            if($model->save()) {
                if($model->default) {
                    $defaults = Filters::model()->findByAttributes(
                        array(
                            'table' => $model->table,
                            'role' => $model->role,
                            'default' => '1'), 'id<>:id', array(':id' => $model->id,));
                    if ($defaults) {
                        $defaults->attributes = array('default' => 0);
                        $defaults->save();
                    }
                }
                $this->redirect(array('admin'));
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionColumnTable($table) {
        $columns = Filters::getColumnTable($table);

        $this->renderPartial('tableColumn',array(
            'columns'=>$columns,
            'table' => $table
        ));
    }

    public function actionColumnValue($column, $table) {
        $this->renderPartial('columnValue',array(
            'column'=> $column,
            'table' => $table,
            'value' => false
        ));
    }

    public function loadModel($id)
    {
        $model=Filters::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,Yii::t('site','The requested page does not exist.'));
        return $model;
    }
}