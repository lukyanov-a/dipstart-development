<?php
$this->menu=array(
    array('label'=>Yii::t('site','Create filter'), 'url'=>array('create')),
);
?>

<h1><?=Yii::t('site','Filter templates')?></h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'templates-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'name',
        'role',
        'table',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
)); ?>