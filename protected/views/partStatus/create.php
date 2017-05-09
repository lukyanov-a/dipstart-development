<?php
/* @var $this PartStatusController */
/* @var $model PartStatus */

$this->breadcrumbs=array(
		Yii::t('site','Part Statuses')=>array('index'),
	    Yii::t('site','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('site','Manage PartStatus'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('site','Create PartStatus')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>