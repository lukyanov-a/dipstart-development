<?php

$this->menu=array(
	array('label'=>Yii::t('site','Create filter'), 'url'=>array('create')),
	array('label'=>Yii::t('site','Delete filter'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('site','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('site','Manage filter'), 'url'=>array('admin')),
);
?>

<h1><?= Yii::t('site','Update Templates steps').' '.$model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>