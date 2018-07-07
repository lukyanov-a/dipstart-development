<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionRecovery () {

		$form = new UserRecoveryForm;
		Yii::app()->theme='client';
		if (Yii::app()->user->id) {
	    	$this->redirect(Yii::app()->controller->module->returnUrl);
	    } else {
			$email = ((isset($_GET['email']))?$_GET['email']:'');
			$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');
			if ($email&&$activkey) {
				$form2 = new UserChangePassword;
	    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
	    		if(isset($find)&&$find->activkey==$activkey) {
		    		if(isset($_POST['UserChangePassword'])) {
						$form2->attributes=$_POST['UserChangePassword'];
						if($form2->validate()) {
							$find->password = Yii::app()->controller->module->encrypting($form2->password);
							$find->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
							if ($find->status==0) {
								$find->status = 1;
							}
							$find->save();
							
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
							$this->redirect(Yii::app()->controller->module->recoveryUrl);
						}
					} 
					$this->render('changepassword',array('form'=>$form2));
	    		} else {
	    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
					$this->redirect(Yii::app()->controller->module->recoveryUrl);
	    		}
	    	} else {
		    	if(isset($_POST['UserRecoveryForm'])) {
		    		$form->attributes=$_POST['UserRecoveryForm'];
		    		if($form->validate()) {
		    			$user = User::model()->notsafe()->findbyPk($form->user_id);
						$user->activkey = UserModule::encrypting(microtime().$user->password);
						$user->save();
						$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email));
/*
						$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl));
						$subject = UserModule::t("You have requested the password recovery site {site_name}",
		    					array(
		    						'{site_name}'=>Yii::app()->name,
		    					));
		    			$message = UserModule::t("You have requested the password recovery site {site_name}. To receive a new password, go to <a href=\"{activation_url}\">{activation_url}</a>.",
		    					array(
		    						'{site_name}'=>Yii::app()->name,
		    						'{activation_url}'=>$activation_url,
		    					));
							
		    			UserModule::sendMail($user->email,$subject,$message);
*/						
						// новая служба системных сообщений
						$type_id = Emails::TYPE_10;
						$email = new Emails;
						
						/*$criteria = new CDbCriteria();
						$criteria->order = 'id DESC';
						$criteria->limit = 1;
						$user = User::model()->findAll($criteria);
						$user = $user[0];*/

						$email->from_id = 1;
						$email->to_id = $form->user_id; //  = $user->id;
						
						$rec   = Templates::model()->findAll("`type_id`='$type_id'");
						//$id = Company::getId();
						$email->campaign = Company::getName();
						$email->name = $user->full_name;
						$email->login= $user->username;
						//$email->password= $soucePassword;
						
						$email->page_psw = $activation_url;
					
						$email->page_cabinet = 'http://'.$_SERVER['SERVER_NAME'].'/user/profile/edit';
						$email->sendTo( $user->email, $rec[0]->title, $rec[0]->text, $type_id);
		    			
						Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email. An instructions was sent to your email address."));
		    			$this->refresh();
		    		}
		    	}
	    		$this->render('recovery',array('form'=>$form));
	    	}
	    }
	}

}