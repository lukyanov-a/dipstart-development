<?php
/* @var $this ProjectStatusController */
/* @var $model ProjectStatus */

$this->breadcrumbs=array(
	Yii::t('site','Project Statuses')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('site','Create ProjectStatus'), 'url'=>array('create')),
	array('label'=>Yii::t('site','Update ProjectStatus'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('site','Delete ProjectStatus'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('site','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('site','Manage ProjectStatus'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('site','View ProjectStatus').' #'.$model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'status',
	),
)); ?>
