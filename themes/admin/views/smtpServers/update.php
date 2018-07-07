<?php
/* @var $this SmtpServersController */
/* @var $model SmtpServer */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);

$this->menu = [
    ['label' => Yii::t('site','Manage SMTP-servers'), 'url' => ['admin']],
];
?>

    <h1><?=Yii::t('site','Update SMTP-server')?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>