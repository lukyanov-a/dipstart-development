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
            foreach ($t_filter as $key=>$item) {
                if($t_filter[$key]['value']) {
                    $filter[$key] = $t_filter[$key];
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
            foreach ($t_filter as $key=>$item) {
                if($t_filter[$key]['value']) {
                    $filter[$key] = $t_filter[$key];
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

        $this->render('tableColumn',array(
            'columns'=>$columns,
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