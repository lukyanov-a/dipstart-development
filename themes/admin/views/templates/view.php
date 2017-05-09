<?php
/* @var $this TemplatesController */
/* @var $model Templates */

$this->breadcrumbs=array(
	Yii::t('site','Templates')=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>Yii::t('site','List Templates'), 'url'=>array('index')),
	array('label'=>Yii::t('site','Create Templates'), 'url'=>array('create', 'type'=>$type)),
	array('label'=>Yii::t('site','Update Templates'), 'url'=>array('update', 'id'=>$model->id, 'type'=>$type)),
	array('label'=>Yii::t('site','Delete Templates'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id, 'type'=>$type),'confirm'=>Yii::t('site','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('site','Manage Templates') , 'url'=>array('admin', 'type'=>$type)),
);
?>
<h1>View Templates #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'title',
		'text',
		array(
            'name' => 'type_id',
            'type' => 'raw',
            'value' => function($data) {
				return Templates::model()->performType($data->type_id);
			},
        ),
	),
)); ?>
