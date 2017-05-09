<?php
/* @var $this TemplatesController */
/* @var $model Templates */

$this->breadcrumbs=array(
	Yii::t('site','Templates')=>array('index'),
	Yii::t('site','Create'),
);

$this->menu=array(
	//array('label'=>Yii::t('site','List Templates'), 'url'=>array('index')),
	array('label'=>Yii::t('site','Manage Templates'), 'url'=>array('admin', 'type'=>$type)),
);
?>

<h1><?=Yii::t('site','Create Templates')?></h1>
<h1 style="font-size: 16px"><?=isset($type) ? Templates::model()->getCategoryesName($type) : ''?></h1>


<?php $this->renderPartial('_form'.$type, array('model'=>$model, 'type'=>$type)); ?>