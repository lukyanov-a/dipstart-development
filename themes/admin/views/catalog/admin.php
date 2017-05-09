<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->menu=array(
	//array('label'=>Yii::t('site','List Catalog'), 'url'=>array('index')),
	array('label'=>Yii::t('site','Create Categories'), 'url'=>array('create', 'field_varname'=>$field_varname)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#catalog-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?=Yii::t('site','Manage Catalog')?></h1>

<p>
<?=Yii::t('site','You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.')?>
</p>

<?php echo CHtml::link(Yii::t('site','Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="childs" <?php echo $dataProviderChild->itemCount ? '' : 'style="display: none"'; ?>>
	<ul class="operations">
		<li>
			<?php echo CHtml::link(Yii::t('site','Parent management'),'#',array('id' => 'open_parents')); ?>
		</li>
	</ul>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'categories-grid-child',
		'dataProvider'=>$dataProviderChild,
		'filter'=>$model,
		'columns'=>array(
			'id',
			array(
				'name' => 'field_varname',
				'filter' => Catalog::getAllVarnames(),
			),
			'cat_name',
			array(
				'name' => 'parent_id',
				'type' => 'raw',
				'value' => 'Catalog::model()->performParent($data->parent_id)',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=> '{view} {update} {delete}',
				'buttons'=>array(
					'update'=>array(
						'url'=>'Yii::app()->controller->createUrl("catalog/update/".$data->id."/?field_varname='.$field_varname.'")',
					),
				),
			),
		),
	)); ?>
</div>

<div class="parents" <?php echo $dataProviderChild->itemCount ? 'style="display: none"' : ''; ?>>
	<ul class="operations">
		<li>
			<?php echo CHtml::link(Yii::t('site','Childs management'),'#',array('id' => 'open_childs')); ?>
		</li>
		<li>
			<?php echo CHtml::link(Yii::t('site','Create Parents Categories'),array('create', 'field_varname'=>$field_varname, 'parent'=>1)); ?>
		</li>
	</ul>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'categories-grid-parent',
		'dataProvider'=>$dataProviderParent,
		'filter'=>$model,
		'columns'=>array(
			'id',
			array(
				'name' => 'field_varname',
				'filter' => Catalog::getAllVarnames(),
			),
			'cat_name',
			array(
				'class'=>'CButtonColumn',
				'template'=> '{view} {update} {delete}',
				'buttons'=>array(
					'update'=>array(
						'url'=>'Yii::app()->controller->createUrl("catalog/update/".$data->id."/?field_varname='.$field_varname.'")',
					),
				),
			),
		),
	)); ?>
</div>

<script>
	$( document ).ready( function() {
		$('#open_parents').click(function (e) {
			e.preventDefault();
			$('.childs').hide();
			$('.parents').show();
		});
		$('#open_childs').click(function (e) {
			e.preventDefault();
			$('.parents').hide();
			$('.childs').show();
		});
	});
</script>
