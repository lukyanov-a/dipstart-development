<?php
/* @var $this TemplatesController */
/* @var $model Templates */

$this->menu=array(
	//array('label'=>Yii::t('site','List Templates'), 'url'=>array('index')),
	array('label'=>Templates::model()->getCategoryesName(1), 'url'=>array('templates/admin/', 'type'=>1)),
	array('label'=>Templates::model()->getCategoryesName(2), 'url'=>array('templates/admin/', 'type'=>2)),
	array('label'=>Templates::model()->getCategoryesName(3), 'url'=>array('templates/admin/', 'type'=>3)),
	array('label'=>Templates::model()->getCategoryesName(4), 'url'=>array('templates/admin/', 'type'=>4)),
	array('label'=>Templates::model()->getCategoryesName(0), 'url'=>array('templates/admin/', 'type'=>0)),
	array('label'=>Yii::t('site','Create Templates'), 'url'=>array('create', 'type'=>$type)),
);
$columns = array(
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
				'url'=>'Yii::app()->controller->createUrl("templates/update/".$data->id."/?type='.$type.'")',
			),
			'view'=>array(
				'url'=>'Yii::app()->controller->createUrl("templates/".$data->id."/?type='.$type.'")',
			),
		),
	),
);
switch ($type){
	case 1:
		$columns = array(
			'id',
			array(
				'header' => Yii::t("site","Category question"),
				'name' => 'title'
			),
			array(
				'header' => Yii::t('site','For answers via chat'),
				'name' => 'text'
			),
			array(
				'name' => 'type_id',
				'type' => 'raw',
				'value' => function($data) {
					return Templates::model()->performType($data->type_id);
				},
				'filter'=>$model->typesByCategory($type),
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view} {update} {delete}',
				'buttons'=>array(
					'update'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/update/".$data->id."/?type='.$type.'")',
					),
					'view'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/".$data->id."/?type='.$type.'")',
					),
				),
			),
		);
	break;
	case 2:
		$columns = array(
			'id',
			array(
				'header' => Yii::t("site","Letter subject"),
				'name' => 'title'
			),
			array(
				'header' => Yii::t("site","message"),
				'name' => 'text'
			),
			array(
				'name' => 'type_id',
				'type' => 'raw',
				'value' => function($data) {
					return Templates::model()->performType($data->type_id);
				},
				'filter'=>$model->typesByCategory($type),
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view} {update} {delete}',
				'buttons'=>array(
					'update'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/update/".$data->id."/?type='.$type.'")',
					),
					'view'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/".$data->id."/?type='.$type.'")',
					),
				),
			),
		);
	break;
	case 3:
		$columns = array(
			'id',
			array(
				'header' => Yii::t("site","Field name"),
				'name' => 'name',
				'filter'=>$model->nameHintFild(),
			),
			array(
				'name' => 'title',
				'filter'=>$model->nameHintName(),
			),
			'text',
			array(
				'name' => 'type_id',
				'type' => 'raw',
				'value' => function($data) {
					return Templates::model()->performType($data->type_id);
				},
				'filter'=>$model->typesByCategory($type),
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view} {update} {delete}',
				'buttons'=>array(
					'update'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/update/".$data->id."/?type='.$type.'")',
					),
					'view'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/".$data->id."/?type='.$type.'")',
					),
				),
			),
		);
	break;
	case 4:
		$columns = array(
			'id',
			array(
				'header' => Yii::t("site","Button label"),
				'name' => 'title',
			),
			array(
				'header' => Yii::t("site","Message text"),
				'name' => 'text',
			),
			array(
				'name' => 'type_id',
				'type' => 'raw',
				'value' => function($data) {
					return Templates::model()->performType($data->type_id);
				},
				'filter'=>$model->typesByCategory($type),
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view} {update} {delete}',
				'buttons'=>array(
					'update'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/update/".$data->id."/?type='.$type.'")',
					),
					'view'=>array(
						'url'=>'Yii::app()->controller->createUrl("templates/".$data->id."/?type='.$type.'")',
					),
				),
			),
		);
		break;
}
?>

<h1><?=Yii::t('site','Manage Templates')?></h1>
<h1 style="font-size: 16px"><?=isset($type) ? Templates::model()->getCategoryesName($type) : ''?></h1>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'templates-grid',
	'dataProvider'=>$model->searchByCategory($type),
	'filter'=>$model,
	'columns'=> $columns,
)); ?>
