<?php
/* @var $this TemplatesstepsController */
/* @var $model Templatessteps */

$this->menu=array(
	array('label'=>Yii::t('site','Create Templates'), 'url'=>array('create')),
);

?>

<h1><?=Yii::t('site','Manage Templates steps')?></h1>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'templates-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'header' => Yii::t('site','Count steps'),
			'value' => 'TemplatesSteps::getCountSteps($data->id)',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>
