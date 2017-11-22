<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'modelGrid',
	'dataProvider' => $dataProvider,
	'afterAjaxUpdate'=>'function(id, data) { setInlineEdit(); }',
    'columns' => [
        [
            'name' => 'attribute',
            'value' => '(new $data->class_name)->getAttributeLabel($data->attribute)'
        ],
        [
            'name' => 'old_value',
            'type' => 'ntext'
        ],
        [
            'name' => 'new_value',
            //'type' => 'ntext'
			'type' => 'raw',
			'value'=>'Tools::inlineEdit($data, "new_value", "textarea")'
        ],
        'date_update',
        [
            'class' => 'CButtonColumn',
            'template' => '{approve}{delete}',
            'buttons' => [
                'approve' => [
                    'label' => '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>',
                    'url' => '["approve", "id"=>"$data->id"]',
                    'options' => [
                        'title'=>Yii::t('site','Approve'),
                        'class'=>'sendData'
                    ]
                ],
                'delete' => [
                    'label' => '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
                    'click' => 'function(){}',
                    'imageUrl' => null,
                    'options' => [
                        'title'=>Yii::t('site','Reject'),
                        'class'=>'sendData'
                    ]
                ],
            ]
        ]
    ]
]) ?>

<?php
if($next)
    echo CHtml::link(Yii::t('site', 'Continue'), $next, array('class' => 'btn btn-primary'));

Yii::app()->clientScript->registerScript('updateStatus',"
	$('.sendData').on('click', function() {
		$.post($(this).attr('href'));
        $(this).parent().html('".Yii::t('site','Changed')."');
		return false;
	});
");?>

<?php $cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jeditable.mini.js');
?>
<?php $cs->registerScript('inline', "
function setInlineEdit() {
  $('.inlineEdit').each(function(){
    var params = {field: $(this).attr('field')};
    var type = $(this).attr('type');
    var s = '', c = '';
    if(type=='textarea' ) {
       s = 'OK';
       c = 'Cancel';
    }
    $(this).editable('/moderate/field', {
        placeholder : '---',
        indicator : '".Yii::t('site','Saving...')."',
        tooltip   : '".Yii::t('site','Click to edit')."',
        type     : type,
        rows: 6,
        cols: 60,
        submit   : s,
        cancel   : c,
        width: '200px',
        submitdata : params,
        callback  : function(value, settings) {
             $.fn.yiiGridView.update('modelGrid',{data:{ }});
          }
     });
  });
}

$(function(){
   setInlineEdit();
});

");
?>