<div class="col-md-12">
<?php
$columns = array('datetime',
					array(	'name'=>'uid',
							'type'=>'raw',
							'value'=>'"<a href=\"/user/admin/view/id/".$data->uid."\">".$data->uid.": ".$data->user->email."</a>"',
					),
					array(	'name'=>'action',
							'type'=>'raw',
							'value'=>'$data->action.": ".ManagerLog::getLabel("action_".$data->action)'
					),
					array(	'name'=>'order_id',
							'type'=>'raw',
							'value'=>'"<a href=\"/project/zakaz/update/id/".$data->order_id."\">".$data->order_id."</a>"'
					),
				);
?>
<div id="grid">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'manager_logs_list',
	'dataProvider'=>$model->with('user')->search(),
    'filter'=>$model,
	'ajaxUpdate' => true,
    'columns'=>$columns,
    'ajaxType'=>'POST',
    'rowHtmlOptionsExpression'=>'array("style" => "cursor:pointer")',
	'summaryText' => Yii::t('site','Number of user actions: {start} - {end} from {count}')
    /*'selectionChanged'=>"js:function(id){
        document.location.href=$('.selected').find('td').find('a.update').attr('href');
    }",*/
));
?>
</div>
</div>