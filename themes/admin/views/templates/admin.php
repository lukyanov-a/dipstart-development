<?php
/* @var $this TemplatesController */
/* @var $model Templates */

$this->menu=array(
	//array('label'=>Yii::t('site','List Templates'), 'url'=>array('index')),
	array('label'=>Yii::t('site','For answers via chat'), 'url'=>array('templates/admin/', 'type'=>1)),
	array('label'=>Yii::t('site','Service messages sent automatically to email'), 'url'=>array('templates/admin/', 'type'=>2)),
	array('label'=>Yii::t('site','Tips for managers'), 'url'=>array('templates/admin/', 'type'=>3)),
	array('label'=>Yii::t('site','Button templates'), 'url'=>array('templates/admin/', 'type'=>4)),
	array('label'=>Yii::t('site','Different service messages'), 'url'=>array('templates/admin/', 'type'=>0)),
	array('label'=>Yii::t('site','Create Templates'), 'url'=>array('create', 'type'=>$type)),
);
?>

<h1><?=Yii::t('site','Manage Templates')?></h1>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'templates-grid',
	'dataProvider'=>$model->searchByCategory($type),
	'filter'=>$model,
	'columns'=>array(
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
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete}',
			'buttons'=>array(
				'update'=>array(
					'url'=>'Yii::app()->controller->createUrl("templates/update/".$data->id."/?type=".$data->type_id)',
				),
				'view'=>array(
					'url'=>'Yii::app()->controller->createUrl("templates/".$data->id."/?type='.$type.'")',
				),
			),
		),
	),
)); ?>
