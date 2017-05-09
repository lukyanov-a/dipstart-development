<?php

class EmailsController extends Controller
{
	private	$subject = 'Notification';
    protected $_request;
    protected $_response;
	
    public function filters() {
		return array(
			'accessControl'
		);
	}
	public function accessRules()
	{
        return array(
            array('allow',
                'actions'=>array('index','send'),
                //'users'=>array('admin','manager'),
				'expression' => array('EmailsController', 'allowManagers'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
	}
	public static function allowManagers(){
		if(User::model()->isManager()) {
			return true;
		} else {
			return false;
		}
	}
	
    /*Вызов методов для работы с json*/
    protected function _prepairJson() {
        $this->_request = Yii::app()->jsonRequest;
        $this->_response = new JsonHttpResponse();
    }
	
	public function actionIndex() {
        $recipients = $_POST['recipients'];
        $title = $_POST['title'];
        $message = $_POST['message'];
        
        $profile_url = 'http://'.$_SERVER['SERVER_NAME'].'/user/profile/edit';
        $message_ps = '<br><br>'.ProjectModule::t('You can unsubscribe...').':';
        $message_ps .= '<br><a href="'.$profile_url.'">'.$profile_url.'</a>';
		$result = '';
		
        if($recipients && $message && $title && isset($_POST['submit'])) {
            if($recipients == 'executors') $role = 'Author';
            elseif($recipients == 'customers') $role = 'Customer'; //$users = User::model()->findAllCustomers(); 
            $users = User::model()->resetScope()->Role($role)->with(array('profile'=>array('select'=>array('profile.general_mailing'))))->findAll();
            
            foreach($users as $user) if(!($user->profile) || $user->profile->general_mailing == 1){
                $email = new Emails;
                $email->to		= $user->email;
                $email->subject	= $title;	
                $email->body	= $message.$message_ps;		
                $email->type	= 0;
                $email->dt		= time();
                $email->save();
                //print_r( $user );
                //echo $email->body;
                //echo '<br>';
            }
            //print_r($users);
            $title = '';
            $message = '';
            $recipients = null;
            $result = '<span class="result">'.ProjectModule::t('Your message is sending...').'</span>';
        } elseif(isset($_POST['submit'])) {
            $result = '<span class="result" style="color: red;">'.ProjectModule::t('Something wrong...').'</span>';
        }
        $this->render('index', array(
            'title'=>$title,
            'message'=>$message,
            'recipients'=>$recipients,
            'result' => $result,
        ));
	}
    
    public function actionSend()
    {
		$email = new Emails;
		
		$this->_prepairJson();

		$orderId = $this->_request->getParam('orderId');
		$typeId = $this->_request->getParam('typeId');
		$back = $this->_request->getParam('back');
		$cost = $this->_request->getParam('cost');

		$order	 = Zakaz::model()->findByPk($orderId);
		
		$arr_type = array(
				Emails::TYPE_18,
				Emails::TYPE_19,
				Emails::TYPE_20,
				Emails::TYPE_21,
				Emails::TYPE_22,
				Emails::TYPE_23,
				Emails::TYPE_24,
				//Emails::TYPE_25,
		);
		if (in_array($typeId,$arr_type)) {
			$user_id = $order->executor;
		} else {
			$user_id = $order->user_id;
		};
		if (!$user_id) Yii::app()->end();
			
		$user = User::model()->findByPk($user_id);

		$email->to_id = $user_id;
		$profile = Profile::model()->findAll("`user_id`='$user_id'");
		
		$rec   = Templates::model()->findAll("`type_id`='$typeId'");
		
		$title = $rec[0]->title;
		$email->name = $profile->full_name;
		if (strlen($email->name) < 2) $email->name = $user->username;
		$email->login= $user->username;
		
		$email->num_order = $orderId;
		$email->page_order = 'http://'.$_SERVER['SERVER_NAME'].'/project/chat?orderId='.$orderId;
		$email->message = $rec[0]->text;
		$email->price_order = $cost;
		$email->sum_order  = $cost;
		
		if (isset($order->specials)) {
            $specials = Catalog::model()->findByPk($order->specials);
        } elseif (isset($order->specials2)) {
            $specials = Catalog::model()->findByPk($order->specials2);
        }
		$email->specialization	= $specials->cat_name;
		$email->name_order		= $order->title;		
		$email->subject_order	= $order->title;		
		$email->sendTo( $user->email, $rec[0]->title, $rec[0]->text, $typeId);
    }
}