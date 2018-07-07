<?php

class SmtpServersController extends Controller
{
    public $layout = '//layouts/second_menu';
    public $defaultAction = 'admin';

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SmtpServer;
        $model->unsetAttributes();
        if(isset($_GET['SmtpServer'])) $model->attributes = $_GET['SmtpServer'];

        $this->render('admin', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'admin' page.
     */
    public function actionCreate() {
        $model = new SmtpServer;
        if(isset($_POST['SmtpServer'])) {
            $model->attributes = $_POST['SmtpServer'];
            if($model->validate()) {
                $model->save();
                $this->redirect(['admin']);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'admin' page.
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if(isset($_POST['SmtpServer'])) {
            $model->attributes = $_POST['SmtpServer'];
            if($model->save())
                $this->redirect(['admin']);
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest) { // we only allow deletion via POST request
            $this->loadModel($id)->delete();
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
        } else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel($id)
    {
        $model = SmtpServer::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404,Yii::t('site','The requested page does not exist.'));
        return $model;
    }
}