<?php
/* @var $this PartStatusController */
/* @var $model PartStatus */

$this->breadcrumbs=array(
	Yii::t('site','Part Statuses')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('site','Create PartStatus'), 'url'=>array('create')),
	array('label'=>Yii::t('site','Update PartStatus'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('site','Delete PartStatus'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('site','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('site','Manage PartStatus'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('site','View PartStatus').' #'.$model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'status',
	),
)); ?>
