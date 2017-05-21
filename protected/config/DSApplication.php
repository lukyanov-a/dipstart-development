<?php
class DSApplication extends CWebApplication
{
	public function runController($route)
	{
		Yii::app()->language = Company::getLanguage();

		if(($ca=$this->createController($route))!==null)
		{
			list($controller,$actionID)=$ca;
			$oldController=$this->getController();
			$this->setController($controller);
			$controller->init();
			$controller->run($actionID);
			$this->setController($oldController);
		}
		else
// 			throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
// 					array('{route}'=>$route===''?$this->defaultController:$route)));
			throw new CHttpException(404,Yii::t('site','The requested page does not exist.'));
	}
}