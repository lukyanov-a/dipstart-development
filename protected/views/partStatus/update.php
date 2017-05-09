<?php
/* @var $this PartStatusController */
/* @var $model PartStatus */

$this->breadcrumbs=array(
	Yii::t('site','Part Statuses')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('site','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('site','Create PartStatus'), 'url'=>array('create')),
	array('label'=>Yii::t('site','View PartStatus'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('site','Manage PartStatus'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('site','Update PartStatus').' '.$model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>