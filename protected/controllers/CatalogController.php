<?php

class CatalogController extends Controller {

	public $layout='//layouts/second_menu';
	//public $layout='//layouts/main';

	/*public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $field_varname = -1)
	{
        $this->render('view',array(
			'model'=>$this->loadModel($id),
			'field_varname'=>$field_varname
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($field_varname = -1, $parent = 0) {
		$model=new Catalog;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Catalog']))
		{
			$model->attributes=$_POST['Catalog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id, 'field_varname'=>$field_varname));
		}

		$this->render('create',array(
			'model'=>$model,
			'field_varname'=>$field_varname,
			'parent' => $parent
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $field_varname = -1)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Catalog']))
		{
			$model->attributes=$_POST['Catalog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id, 'field_varname'=>$field_varname));
		}

		$this->render('update',array(
			'model'=>$model,
			'field_varname'=>$field_varname
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $field_varname = -1)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin','field_varname'=>$field_varname));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($field_varname = -1) {
		if ($field_varname != -1) {
			$dataProvider = new CActiveDataProvider('Catalog', array('criteria' => array('condition'=>'field_varname="'.$field_varname.'"')));
		} else {
			$dataProvider = new CActiveDataProvider('Catalog');
		}
		//print_r(Yii::app()->user->checkAccess('Index'));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin($field_varname = -1)
	{
		if ($field_varname != -1) {
			$dataProviderChild = new CActiveDataProvider('Catalog',
				array('criteria' => array(
						'condition'=>'field_varname="'.$field_varname.'" AND parent_id!=0'
					)));
			$dataProviderParent = new CActiveDataProvider('Catalog',
				array('criteria' => array(
					'condition'=>'field_varname="'.$field_varname.'" AND parent_id=0'
				)));
		} else {
			$dataProviderChild = new CActiveDataProvider('Catalog',
				array('criteria' => array(
					'condition'=>'parent_id!=0'
				)));
			$dataProviderParent = new CActiveDataProvider('Catalog',
				array('criteria' => array(
					'condition'=>'parent_id=0'
				)));
		}
		$model=new Catalog('search');
		$model->unsetAttributes();
		
		if(isset($_GET['Catalog']))
			$model->attributes=$_GET['Catalog'];
        $this->render('admin',array(
			'model'=>$model,
			'dataProviderChild'=>$dataProviderChild,
			'dataProviderParent'=>$dataProviderParent,
			'field_varname'=>$field_varname
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Categories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Catalog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('site','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Categories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
}
