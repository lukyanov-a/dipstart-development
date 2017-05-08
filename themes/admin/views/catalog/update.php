<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->menu=array(
	//array('label'=>Yii::t('site','List Categories'), 'url'=>array('index')),
	array('label'=>Yii::t('site','Manage Categories'), 'url'=>array('admin', 'field_varname'=>$field_varname)),
	array('label'=>Yii::t('site','Create Categories'), 'url'=>array('create', 'field_varname'=>$field_varname)),
	array('label'=>Yii::t('site','View Categories'), 'url'=>array('view', 'id'=>$model->id, 'field_varname'=>$field_varname)),
	array('label'=>Yii::t('site','Delete Categories'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id,'field_varname'=>$field_varname), 'confirm'=>Yii::t('site','Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('site','Update Categories').' '.$model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'field_varname'=>$field_varname)); ?>