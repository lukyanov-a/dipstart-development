<?php
/* @var $this ProjectStatusController */
/* @var $model ProjectStatus */

$this->breadcrumbs=array(
		Yii::t('site','Project Statuses')=>array('index'),
	    Yii::t('site','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('site','Manage ProjectStatus'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('site','Create ProjectStatus')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>