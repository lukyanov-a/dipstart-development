<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/worktypes.js');

$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Create'),
);
$this->menu=array(
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
);

$this->widget('zii.widgets.CMenu', array(
	'items'=>$this->menu,
	'htmlOptions'=>array('class'=>'operations'),
));
?>
<h1><?php echo UserModule::t('Create Profile Field'); ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>