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
        if (Yii::app()->request->isAjaxRequest){ // ������������?
            header('Content-Type: application/json');
            echo CJSON::encode(array('success'=>true,'msg'=>ProjectMessages::model()->findByPk(Events::model()->findByPk(Yii::app()->request->getParam('id'))->event_id)->message));
            Yii::app()->end();
        }
        $events = Events::model()->forManager()->findAll(array(
            'condition' => '',
            'order' => 'timestamp DESC'
        ));
        $this->render('index', array(
            'events' => $this->groupeEventID($events),
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
				$html = $this->renderPartial('list',array('events'=>$this->groupeEventID($events)), true);
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
            'events' => $this->groupeEventID($events, true)
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
				$html = $this->renderPartial('list',array('events'=>$this->groupeEventID($events, true)), true);
				Yii::app()->cache->set($key, $html, 5*60); //5 min
			}
			echo $html;
		}
	}
	
    public function actionDelete() {
		$id  = Yii::app()->request->getParam('id');
		$is_managerSale  = Yii::app()->request->getParam('is_managerSale');
        if (Yii::app()->request->isAjaxRequest){
			Yii::app()->cache->delete(Events::getCacheKey());
			Yii::app()->cache->delete(Events::getCacheKey('sales-manager'));
            header('Content-Type: application/json');
			if($is_managerSale)
				$del = Events::model()->forSalesManager()->deleteAll("`event_id` = :event_id",['event_id'=>$id]);
			else
				$del = Events::model()->forManager()->deleteAll("`event_id` = :event_id",['event_id'=>$id]);
			if ($del)
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
	
	public function groupeEventID($events, $is_managerSale=false) {
		$result = array();
		if(!empty($events)) {
			foreach ($events as $event) {
				$showLink = true;
				$result[$event->event_id]['is_managerSale'] = $is_managerSale;
				if ($event->type == EventHelper::TYPE_CUSTOMER_REGISTRED) $showLink = false;
				$result[$event->event_id]['events'][] = $event;
				$result[$event->event_id]['showLink'] = $showLink;
				if(!isset($result[$event->event_id]['timestamp'])) $result[$event->event_id]['timestamp'] = $event->timestamp;
				switch ($event->type) {
					case EventHelper::TYPE_EDIT_ORDER:
					case EventHelper::TYPE_UPDATE_PROFILE:
						$arg = ['id' => $event->event_id];
						if(isset($result[$event->event_id]['action']['type']) &&
							$result[$event->event_id]['action']['type']==EventHelper::TYPE_MESSAGE) {
							$arg = array_merge($arg, [
								'next'=>Yii::app()->createUrl('/project/zakaz/preview', ['id' => $event->event_id, 'is_managerSale'=>$is_managerSale])
							]);
						}
						$result[$event->event_id]['action']['button'] = CHtml::link(
							Yii::t('site', 'Show'),
							Yii::app()->createUrl('moderate/index', $arg)
						);
						$result[$event->event_id]['action']['type'] = EventHelper::TYPE_EDIT_ORDER;
						break;
					case EventHelper::TYPE_NOTIFICATION:
						$result[$event->event_id]['action'] = '<td>' . Yii::t('site', 'Link is absent') . '</td>';
						break;
					case EventHelper::TYPE_MESSAGE:
					case EventHelper::TYPE_CUSTOMER_REGISTRED:
					case EventHelper::TYPE_ORDER_MANAGER_INFORMED:
					case EventHelper::TYPE_ORDER_STAGE_EXPIRED:
					default:
						$arg = ['id' => $event->event_id];
						if(isset($result[$event->event_id]['action']['type']) &&
							$result[$event->event_id]['action']['type']==EventHelper::TYPE_EDIT_ORDER) {
							$arg = array_merge($arg, [
								'next'=>Yii::app()->createUrl('/project/zakaz/preview', ['id' => $event->event_id, 'is_managerSale'=>$is_managerSale])
							]);
							$result[$event->event_id]['action']['button'] = CHtml::link(
								Yii::t('site', 'Show'),
								Yii::app()->createUrl('moderate/index', $arg)
							);
							$result[$event->event_id]['action']['type'] = EventHelper::TYPE_EDIT_ORDER;
						} else {
							$result[$event->event_id]['action']['type'] = EventHelper::TYPE_MESSAGE;
							$result[$event->event_id]['action']['button'] = CHtml::link(Yii::t('site', 'Show'), ['/project/zakaz/preview', 'id' => $event->event_id, 'is_managerSale'=>$is_managerSale]);
						}
						break;
				}
			}
		}
		return $result;
	}
    /*public function actionBack() {
		die('back back back back back back back ');
    }*/   
}
