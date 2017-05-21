<?php

class EventController extends Controller {

    /*public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index','delete'),
                'users'=>array('admin','manager'),
            ),
            array('allow',
                'actions'=>array('index','delete','back'),
                'users'=>array('customer'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }*/
    /*public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }*/
    public function actionIndex() {
        if (Yii::app()->request->isAjaxRequest){ // Используется?
            header('Content-Type: application/json');
            echo CJSON::encode(array('success'=>true,'msg'=>ProjectMessages::model()->findByPk(Events::model()->findByPk(Yii::app()->request->getParam('id'))->event_id)->message));
            Yii::app()->end();
        }
        $events = Events::model()->forManager()->findAll(array(
            'condition' => '',
            'order' => 'timestamp DESC'
        ));
        $this->render('index', array(
            'events' => $events
        ));
    }
	
	public function actionRefresh() {
	    if (Yii::app()->request->isAjaxRequest) {
			$key = Events::getCacheKey();
			$html = Yii::app()->cache->get($key);
			if ($html === false) {
				$events = Events::model()->forManager()->findAll(array(
					'condition' => '',
					'order' => 'timestamp DESC'
				));
				$html = $this->renderPartial('list',array('events'=>$events), true);
				Yii::app()->cache->set($key, $html, 5*60); //5 min
			}
			echo $html;
		}
	}
	
	public function actionSalesManagerIndex() {
        $events = Events::model()->forSalesManager()->findAll(array(
            'condition' => '',
            'order' => 'timestamp DESC'
        ));
        $this->render('index', array(
            'events' => $events
        ));
    }
	
	public function actionRefreshForSalesManager() {
	    if (Yii::app()->request->isAjaxRequest) {
			$key = Events::getCacheKey('sales-manager');
			$html = Yii::app()->cache->get($key);
			if ($html === false) {
				$events = Events::model()->forSalesManager()->findAll(array(
					'condition' => '',
					'order' => 'timestamp DESC'
				));
				$html = $this->renderPartial('list',array('events'=>$events), true);
				Yii::app()->cache->set($key, $html, 5*60); //5 min
			}
			echo $html;
		}
	}
	
    public function actionDelete() {
		$id  = Yii::app()->request->getParam('id');
        if (Yii::app()->request->isAjaxRequest){
			Yii::app()->cache->delete(Events::getCacheKey());
			Yii::app()->cache->delete(Events::getCacheKey('sales-manager'));
            header('Content-Type: application/json');
			if (Events::model()->deleteByPk($id))
				echo CJSON::encode(array('success'=>true));
			else
				echo CJSON::encode(array('error'=>true));
			
            Yii::app()->end();
			
        }
        /*$events = Events::model()->findAll(array(
            'condition' => '',
            'order' => 'timestamp DESC',
        ));
        $this->render('index', array(
            'events' => $events,
        ));*/
    }
    /*public function actionBack() {
		die('back back back back back back back ');
    }*/   
}
