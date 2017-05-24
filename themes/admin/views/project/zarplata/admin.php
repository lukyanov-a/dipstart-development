<?php

$this->menu=array(
    array('label'=>Yii::t('site','Create actions'), 'url'=>array('create')),
    array('label'=>Yii::t('site','Calculate the salary of an employee'), 'url'=>array('salaryup')),
);

?>

    <h1><?=Yii::t('site','Manage classifying actions')?></h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'templates-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'name',
        'factor',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
)); ?>