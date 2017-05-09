<?php
/* @var $this ProjectStatusController */
/* @var $model ProjectStatus */

$this->breadcrumbs=array(
	Yii::t('site','Project Statuses')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('site','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('site','Create ProjectStatus'), 'url'=>array('create')),
	array('label'=>Yii::t('site','View ProjectStatus'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('site','Manage ProjectStatus'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('site','Update ProjectStatus').' '.$model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>