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
        array(
            'name' => 'role',
            'value' => 'UserModule::t($data->role)'
        ),
        array(
            'name' => 'table',
            'value' => 'UserModule::t($data->table)'
        ),
        array(
            'name' => 'default',
            'value' => function($data) {
                return $data->default ? Yii::t('site','yes') : Yii::t('site','no');
            }
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
)); ?>