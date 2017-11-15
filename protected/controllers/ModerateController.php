<?php

class ModerateController extends Controller
{
    
    /*public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete + approve, ApiRenameFile', // we only allow deletion via POST request
        );
	}
		
	public function accessRules()
	{
			return array(
                array('allow', // 
                    'actions'=>array('view','index'),
                    'users'=>array('@'),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array('approve', 'delete','field'),
                    'users'=>array('admin','manager'),
                ),
				array('deny',  // deny all users
					'users'=>array('*'),
				),
			);
	}*/
	

    public function actionIndex($id, $next = false)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('id_record', $id);
        
        $dataProvider = new CActiveDataProvider('Moderate', [
            'criteria' => $criteria
        ]);
        
        $this->render('index', [
            'dataProvider' => $dataProvider,
            'next' => $next
        ]);
    }
    
    public function actionApprove($id) {
        $model = $this->loadModel($id);
        $model->approve();
    }
    
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->delete();
    }
    
    public function actionField() {
        if (isset($_POST['field'])) {
            $field = $_POST['field'];
            if (isset($_POST['id'])) {
                $model = $this->loadModel($_POST['id']);
                if ($model != null) {
                    $model->$field = $_POST['value'];
                    $model->save();
                    Yii::app()->end();
                }
            }
        }
    }
	
    public function loadModel($id)
	{
		$model=Moderate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404);
		return $model;
	}
}