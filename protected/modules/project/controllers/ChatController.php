<?php

class ChatController extends Controller {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @return array action filters
	 */
    protected $_request;
    protected $_response;
    protected function _prepairJson() {
        $this->_request = Yii::app()->jsonRequest;
        $this->_response = new JsonHttpResponse();
    }

	public function filters()
	{
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete, ApiRenameFile', // we only allow deletion via POST request
        );
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow', 
                'actions' => array('index', 'ApiRenameFile'),
                'expression' => array('ChatController', 'allowOnlyOwner'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('upload','status'),
                'users' => array('@'),
            ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'approve', 'remove', 'edit', 'setexecutor', 'delexecutor', 'readdress','status'),
				'users'=>array('admin', 'manager'),
			),
			array('allow',  // allow all users
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    public static function allowOnlyOwner(){
        if(User::model()->isAdmin()){
            return true;
        }
        else{
            $zakaz = Zakaz::model()->resetScope()->findByPk($_GET["orderId"]);
            if(User::model()->isCustomer())
                return ($zakaz->user->id === Yii::app()->user->id);
            if(User::model()->isAuthor())
                return (($zakaz->executor == 0) || ($zakaz->executor === Yii::app()->user->id));
        }
    }

	/**
	 *  Вывод и добавление сообщений
	 */
    public function actionIndex($orderId)
    {

		$isGuest = Yii::app()->user->isGuest;

		Yii::app()->session['project_id'] = $orderId;
		
        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->getPost('ProjectMessages')) {

				$id = (int)$_POST['ProjectMessages']['id'];
				if ($id>0)	{ // редактирование сообщения
					$model = ProjectMessages::model()->findByPk($id);
				} else {	  // новое сообщение
					$model = new ProjectMessages;
					$model->sender = Yii::app()->user->id;
					$model->moderated = 0;
					$model->order = $orderId;
				};
				$post	= $_POST['ProjectMessages']['message'];
				$post	= str_replace("\x0D\x0A",'<br>',$post);
				$post	= str_replace("\x0A",'<br>',$post);
				$_POST['ProjectMessages']['message'] = $post;
			
                $model->attributes = Yii::app()->request->getPost('ProjectMessages');
                $model->date = date('Y-m-d H:i:s');
                switch ($model->recipient) {
                    case 'manager':
                        $model->recipient = 1;
                        break;
                    case 'customer':
						if (User::model()->isCustomer()) {
                            $model->recipient = Zakaz::model()->resetScope()->findByPk($orderId)->attributes['executor'];
							$type_id = Emails::TYPE_20;
                        } else if (User::model()->isAuthor()) {
                            $model->recipient = Zakaz::model()->findByPk($orderId)->attributes['user_id'];
							$type_id = Emails::TYPE_16;
						};
						$user = User::model()->findByPk($model->recipient);
						$profile = Profile::model()->findAll("`user_id`='$model->recipient'");
						
						$email = new Emails;
						$rec   = Templates::model()->findAll("`type_id`='$type_id'");
						$title = $rec[0]->title;
						$body  = $rec[0]->text;
						$email->name = $user->full_name;
						if (strlen($email->name) < 2) $email->name = $user->username;
						$email->num_order = $orderId;
						$email->message = $post;
						$email->page_order = 'http://'.$_SERVER['SERVER_NAME'].'/project/chat?orderId='.$orderId;
						$email->sendTo( $user->email, $body, $type_id);
                        break;
                }
				$model->save();
                EventHelper::addMessage($orderId, $model->message);
            }
            $this->renderPartial('chat', array(
                'orderId' => $orderId,
				'isGuest'	=> $isGuest,
            ));
            Yii::app()->end();
        }
		
		$order = Zakaz::model()->resetScope()->findByPk($orderId);
		
		$parts = ZakazParts::model()->findAll(array(
					'condition' => "`proj_id`='$orderId'",
				));
		if ($isGuest) {
			Yii::app()->theme='client';
			
			// если гость прошёл по ссылке на неcуществующий
			// проект, отправляем его на регистрацию
			$url = 'http://'.$_SERVER['SERVER_NAME'].'/';
			if (!$order) $this->redirect($url);

			$moderate_types = EventHelper::get_moderate_types_string();
			$events = Events::model()->findAll(array(
				'condition' => "`event_id`='$orderId' AND `type` in ($moderate_types)",
				'order' => 'timestamp DESC'
				),
				array(':event_id'=> $orderId) 			
			);
			$moderated = count($events) == 0;
			// если гость прошёл по ссылке на непромодерированный
			// проект, отправляем его на регистрацию
			if (!$moderated) $this->redirect( Yii::app()->createUrl('user/login'));

//			Catalog::model()->tableName();
			//$EmptyChat = UserModule::t('EmptyChat');
			$this->render('index', array(
				'orderId'	=> $orderId,
				'order'		=> $order,
				'executor'	=> Zakaz::getExecutor($orderId),
				'moderated'	=> $moderated,
				'isGuest'	=> $isGuest,
				'parts'		=> $parts,
			));
            Yii::app()->end();
		}
		
		$moderate_types = EventHelper::get_moderate_types_string();
        $events = Events::model()->findAll(array(
            'condition' => "`event_id`='$orderId' AND `type` in ($moderate_types)",
            'order' => 'timestamp DESC'
			),
			array(':event_id'=> $orderId) 			
		);
		$moderated = count($events) == 0;
        $this->render('index', array(
            'orderId'	=> $orderId,
			'order'		=> $order,
            'executor'	=> Zakaz::getExecutor($orderId),
			'moderated'	=> $moderated,
			'isGuest'	=> $isGuest,
			'parts'		=> $parts,
        ));
    }
	
	public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
		// --- кампании
		$c_id = Campaign::getId();
		if ($c_id) {
			$folder='uploads/c'.$c_id.'/'.$_GET['id'].'/';
		} else {
			$folder='uploads/'.$_GET['id'].'/';
		}
		// ---
		if (!file_exists($folder)) {
			mkdir($folder, 0777);
		}
        $config['allowedExtensions'] = array('png', 'jpg', 'jpeg', 'gif', 'txt', 'doc', 'docx');
        $config['disAllowedExtensions'] = array("exe");
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($config, $sizeLimit);
        if(!(User::model()->isAdmin())) $_GET['qqfile']='#pre#'.$_GET['qqfile'];
        $result = $uploader->handleUpload($folder,true);
        if ($result['success'] && User::model()->isCustomer()) {
            EventHelper::materialsAdded($_GET['id']);
        }
        $result['fileSize']=filesize($folder.$result['filename']);//GETTING FILE SIZE
        $result['fileName']=$result['filename'];//GETTING FILE NAME
		chmod($folder.$result['fileName'],0666);
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
    
    /*
     * Rename attachment file
     */
    public function actionApiRenameFile() {
        $this->_prepairJson();
        $data = $this->_request->getParam('data');
		$path=Yii::getPathOfAlias('webroot').$data['dir'];
        if (!file_exists($path)) mkdir($path);
        if (rename($path.$data['name'], $path.'#trash#'.$data['name'])) {
            EventHelper::materialsDeleted($_GET['orderId']);
            $this->_response->setData(true);
        } else $this->_response->setData(false);
        $this->_response->send();
    }
	
    public function actionStatus() {

		$orderId	= Yii::app()->request->getPost('orderId');
		$status_id	= Yii::app()->request->getPost('status_id');
		$id			= Yii::app()->request->getPost('id');

		$row	= array(
			'status_id'	=> $status_id,
		);
		$id		= Yii::app()->request->getPost('id');
		$condition 	= array();
		$params		= array();
		ZakazParts::model()->updateByPk( $id, $row, $condition, $params);
		
		$status_id = (int)$_POST['status_id'];
		if ($status_id != 6) Yii::app()->end();
		
		$parts = ZakazParts::model()->findAll("`proj_id` = '$orderId' AND `status_id` IN (1,2,3,4,5)");
echo '$parts)='; print_r($parts);
		
		// завершение части проекта
		$orderId = Yii::app()->request->getPost('orderId');

		$order = Zakaz::model()->resetScope()->findByPk($orderId);
		$subject_order = $order->title;
		$user_id = $order->user_id;
		$user = User::model()->findByPk($user_id);
echo '<br>count($parts)='.count($parts);
		$email = new Emails;
		if (count($parts) > 0)  $type_id = Emails::TYPE_14; else
								$type_id = Emails::TYPE_15;
								
		$rec   = Templates::model()->findAll("`type_id`='$type_id'");
		$title = $rec[0]->title;
		$body  = $rec[0]->text;
		$email->name = $user->full_name;
		$email->num_order = $orderId;
//		$model->date = date('Y-m-d H:i:s');
		$email->subject_order = $subject_order;
		if (strlen($email->name) < 2) $email->name = $user->username;
		$email->num_order = $orderId;
		$email->page_order = 'http://'.$_SERVER['SERVER_NAME'].'/project/chat?orderId='.$orderId;
		$email->sendTo( $user->email, $body, $type_id);
    }
}
