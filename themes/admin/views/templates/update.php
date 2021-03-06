<?php
/* @var $this TemplatesController */
/* @var $model Templates */

$this->breadcrumbs=array(
	Yii::t('site','Templates')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('site','Update'),
);

$this->menu=array(
	//array('label'=>Yii::t('site','List Templates'), 'url'=>array('index')),
	array('label'=>Yii::t('site','Create Templates'), 'url'=>array('create', 'type'=>$type)),
	array('label'=>Yii::t('site','View Templates'), 'url'=>array('view', 'id'=>$model->id, 'type'=>$type)),
	array('label'=>Yii::t('site','Delete Templates'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('site','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('site','Manage Templates'), 'url'=>array('admin', 'type'=>$type)),
);
?>

<h1><?= Yii::t('site','Update Templates').' '.$model->id; ?></h1>
<h1 style="font-size: 16px"><?=isset($type) ? Templates::model()->getCategoryesName($type) : ''?></h1>


<?php $this->renderPartial('_form'.$type, array('model'=>$model, 'type'=>$type)); ?>