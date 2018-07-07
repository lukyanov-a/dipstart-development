<?php
/* @var $this SmtpServersController */
/* @var $model SmtpServer */

$this->menu = [
    ['label' => Yii::t('site','Add SMTP-server'), 'url' => ['create']],
];

?>

<h1><?=Yii::t('site','Manage SMTP-servers')?></h1>

<?php
$this->widget('zii.widgets.grid.CGridView',[
    'id' => 'smtp-servers-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'id',
        'address',
        'port',
        [
            'name' => 'secure',
            'value' => 'SmtpServer::itemAlias("secure",$data->secure)',
            'filter' => SmtpServer::itemAlias("secure"),
        ],
        'login',
        'limit',
        [
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
        ],
    ],
]); ?>
