<?php

class TemplatesStepsController extends Controller
{
    public $layout='//layouts/second_menu';

    public function actionAdmin()
    {
        $model=new TemplatesSteps();
        
        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionCreate()
    {
        $model= new TemplatesSteps();

        if(isset($_POST['TemplatesSteps'])) {
            $steps = $_POST['TemplatesSteps']['steps'];
            $steps_value = array();
            $sum = 0;
            foreach ($steps['name'] as $key=>$step) {
                $steps_value[] = array('name'=>$step, 'time'=>$steps['time'][$key]);
                if(!$step) $error['steps'][$key]['name'] = Yii::t('site','You must fill in the name of the step');
                if(!(int)$steps['time'][$key]) $error['steps'][$key]['time'] = Yii::t('site','It is necessary to fill in the stage term correctly');
                else $sum += (int)$steps['time'][$key];
            }
            $attributes = array('name' => $_POST['TemplatesSteps']['name'], 'steps'=>serialize($steps_value));
            if($sum!=100) $error['message'] = Yii::t('site','The term of all stages should be equal to 100%');
            $model->attributes = $attributes;
            if($model->save()) {
                $error['success'] = Yii::t('site','Template saved successfully');
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'error' => $error,
        ));
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $error = array();

        if(isset($_POST['TemplatesSteps'])) {
            $steps = $_POST['TemplatesSteps']['steps'];
            $steps_value = array();
            $sum = 0;
            foreach ($steps['name'] as $key=>$step) {
                $steps_value[] = array('name'=>$step, 'time'=>$steps['time'][$key]);
                if(!$step) $error['steps'][$key]['name'] = Yii::t('site','You must fill in the name of the step');
                if(!(int)$steps['time'][$key]) $error['steps'][$key]['time'] = Yii::t('site','It is necessary to fill in the stage term correctly');
                else $sum += (int)$steps['time'][$key];
            }
            $attributes = array('name' => $_POST['TemplatesSteps']['name'], 'steps'=>serialize($steps_value));
            if($sum!=100) $error['message'] = Yii::t('site','The term of all stages should be equal to 100%');
            $model->attributes = $attributes;
            if(empty($error)) {
                if($model->save()) {
                    $error['success'] = Yii::t('site','Template saved successfully');
                }
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'error' => $error,
        ));
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function loadModel($id)
    {
        $model=TemplatesSteps::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,Yii::t('site','The requested page does not exist.'));
        return $model;
    }
}