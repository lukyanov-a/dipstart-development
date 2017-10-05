<?php

class AdminController extends Controller {
	public $defaultAction = 'admin';
	//public $layout='//layouts/second_menu';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters() {
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update'),
				'users'=>UserModule::getAdmins(),
			),*/
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','admin','delete','create','update'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		//$model = User::model()->search();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User'])) {
			$model->attributes=$_GET['User'];
		}
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model	= $this->loadModel();
		$profile	= $model->profile;
	
		$this->render('view',array(
			'model'		=> $model,
			'profile'	=> $profile,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model		= new User;
		$profile	= new Profile;
		
		$this->performAjaxValidation(array($model,$profile));
		
		$manager = !User::model()->isAuthor();
		$admin	 = User::model()->isAdmin();
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			
			$_temp = array('','icq','sms','email');
			$_POST['Profile']['mailing_list'] = array_search($_POST['Profile']['mailing_list'],$_temp);
			$profile->attributes = $_POST['Profile'];
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}
		$fields = ProfileField::model()->findAll();
		$this->render('create',array(
			'model'		=> $model,
			'profile'	=> $profile,
			'fields'	=> $fields,
			'manager'	=> $manager,
			'admin'		=> $admin,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model = $this->loadModel();
		if($model->profile == null) {
			$model->profile = new Profile;
			$model->profile->user_id = $model->id;
		}
		$profile = $model->profile;
		$this->performAjaxValidation(array($model,$profile));
        if (Yii::app()->request->isAjaxRequest) {
            $data = Yii::app()->request->getRestParams();
			$field = str_replace('Profile_','',$data['elid']);
            if (is_array($data)) {
                echo json_encode($profile->$field=$data['data']);
				echo json_encode($profile->save());
				echo json_encode($profile->errors);
                Yii::app()->end();
            }
        }
		$manager = !User::model()->isAuthor();
		$admin	 = User::model()->isAdmin();

		$formModel = new AssignmentForm();
		$authorizer = Rights::module()->getAuthorizer();

		if(isset($_POST['User'])) {
			$model->attributes=$_POST['User'];
			$profile->setAttributes($_POST['Profile'], false);
            if(!$model->username) $model->username = null;
			if($model->validate()&&$profile->validate()) {
				/*$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}*/
				$model->save();
				$profile->save();
				$this->redirect(array('update','id'=>$model->id));
			} else $profile->validate();
		} elseif( $admin && isset($_POST['AssignmentForm'])===true ) {
			$formModel->attributes = $_POST['AssignmentForm'];
			if( $formModel->validate()===true )
			{
				// Update and redirect
				$authorizer->authManager->assign($formModel->itemname, $model->id);
				$item = $authorizer->authManager->getAuthItem($formModel->itemname);
				$item = $authorizer->attachAuthItemBehavior($item);

				Yii::app()->user->setFlash('success',
					Rights::t('core', 'Permission :name assigned.', array(':name'=>$item->getNameText()))
				);

				$this->redirect(array('update','id'=>$model->id));
			}
		};
		if (User::model()->isAdmin()) {
			$fields = ProfileField::model()->findAll();
		} elseif (User::model()->isSalesManager()) {
			$fields = ProfileField::model()->forSalesManager()->findAll();
		} elseif (User::model()->isManager()) {
			$fields = ProfileField::model()->forManager()->findAll();
		}

		$assignedItems = $authorizer->getAuthItems(null, $model->id);
		$assignments = array_keys($assignedItems);
		$assignSelectOptions = Rights::getAuthItemSelectOptions(2, $assignments);
		$dataProvider = new RAuthItemDataProvider('assignments', array(
			'userId'=>$model->id,
		));

		$this->render('update',array(
			'model'		=> $model,
			'profile'	=> $profile,
			'manager'	=> $manager,
			'admin'		=> $admin,
			'fields'	=> $fields,
			'dataProvider' => $dataProvider,
			'formModel'=>$formModel,
			'assignSelectOptions'=>$assignSelectOptions,
		));	
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			$AuthAssignment = AuthAssignment::model()->findByAttributes(array('userid'=>$model->id));
			$logs = ManagerLog::model()->findByAttributes(array('uid'=>$model->id));
			ManagerLog::model()->deleteAll("`uid` = :uid", array(':uid' => $model->id));
			if($logs) $logs->delete();
			if($AuthAssignment) $AuthAssignment->delete();
			if($profile) $profile->delete();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($validate)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($validate);
			Yii::app()->end();
		}
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->with('zakaz')->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,Yii::t('site','The requested page does not exist.'));
		}
		return $this->_model;
	}

}
