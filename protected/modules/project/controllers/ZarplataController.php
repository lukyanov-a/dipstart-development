<?php
class ZarplataController extends Controller
{
    public $layout = '//layouts/second_menu';

    public function actionAdmin()
    {
        $model=new ClassAction();

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionCreate()
    {
        $model= new ClassAction();

        if(isset($_POST['ClassAction'])) {
            $model->attributes = $_POST['ClassAction'];
            if($model->save())  $this->redirect(array('admin'));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id, $type = 0)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['ClassAction']))
        {
            $model->attributes=$_POST['ClassAction'];
            if($model->save()) $this->redirect(array('admin'));
        }

        $this->render('update',array(
            'model'=>$model,
            'type' => $type
        ));
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionSalaryup()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $summ = 0;
            $data = Yii::app()->request->getRestParams();
            if(isset($data['val'])) {
                $user_auth = AuthAssignment::model()->findByAttributes(array('itemname' => $data['val']));
                $user_id = $user_auth->userid;
                if($data['val']=='Corrector') {
                    $summ = $this->calculate($user_id);
                } else $summ = $this->calculateManeger($user_id);
            }

            echo $summ;

            Yii::app()->end();
        }

        if(isset($_POST['calculation'])) {
            $val = $_POST['employee'];
            $user_auth = AuthAssignment::model()->findByAttributes(array('itemname' => $val));
            $user_id = $user_auth->userid;

            if($val=='Corrector') {
                $summ = $this->calculate($user_id, true);
            } else $summ = $this->calculateManeger($user_id, true);
            $award = 0;
            if(isset($_POST['award']) && !empty($_POST['award'])) {
                $award = (int)$_POST['award'];
            }
            $summ += $award;

            $user = User::model()->with('profile')->findByPk($user_id);
            $manag = User::model()->findByPk(Yii::app()->user->id);

            $buh = new Payment;
            $buh->approve = 0;
            $buh->receive_date = date('Y-m-d H:i:s');
            $buh->theme = Yii::t('site','Payment for actions');
            $buh->user = $user->email;
            $buh->summ = $summ;
            $buh->payment_type = Payment::OUTCOMING_EXECUTOR;
            $buh->manager = $manag->email;
            $buh->save();

            $this->redirect(Yii::app()->createUrl('project/zarplata/index'));
        }

        $this->render('salaryup');
    }

    public function calculateManeger($user_id, $update = false) {
        $summ = 0;
        $log = ManagerLog::model()->findAllByAttributes(
            array('uid' => $user_id, 'payment'=>'0'), array('order'=>'datetime ASC'));
        if(!empty($log)) {
            $old_time = 0;
            foreach ($log as $item) {
                $time_action = strtotime($item->datetime);
                if($time_action>($old_time+60)) {
                    $summ += ClassAction::getFactor($item->action);
                }
                if ($update) {
                    $managerlog = ManagerLog::model()->findByPk($item->id);
                    $managerlog->payment = 1;
                    $managerlog->save();
                }
                $old_time = $time_action;
            }
        }

        return $summ;
    }

    public function calculate($user_id, $update = false) {
        $summ = 0;
        $log = ManagerLog::model()->findAllByAttributes(
            array('uid' => $user_id, 'payment'=>'0'),
            'action>=:action',
            array(':action'=>ManagerLog::MIN_CUSTOM_EVENT));
        if(!empty($log)) {
            foreach ($log as $item) {
                $summ += ClassAction::getFactor($item->action);
                if($update) {
                    $managerlog = ManagerLog::model()->findByPk($item->id);
                    $managerlog->payment = 1;
                    $managerlog->save();
                }
            }
        }

        return $summ;
    }

    public function loadModel($id)
    {
        $model=ClassAction::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,Yii::t('site','The requested page does not exist.'));
        return $model;
    }
}