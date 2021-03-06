<?php
/**
 * Created by PhpStorm.
 * User: coolfire
 * Date: 20.08.15
 * Time: 2:19
 */
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/manager.js');
?>

<script type="text/javascript">
$(document).ready(function () {
	$('#extremum-in').click(function() {
		$('#in').show();
		$('#out').hide();
		$('#analysis').hide();
	});
	$('#extremum-out').click(function(){
		$('#in').hide();
		$('#out').show();
		$('#analysis').hide();
	});
	$('#extremum-analysis').click(function(){
		$('#out').hide();
		$('#in').hide();
		$('#analysis').show();
	});
});
</script>
<?php
$filters = Filters::getFilters('Payment', User::model()->getUserRole());
if(!empty($filters)) { ?>
	<p style="margin: 15px 0 10px;"><?=Yii::t('site','Filters')?>:
		<?php
		$default = Filters::getDefaultFilters('Payment', User::model()->getUserRole());
		$active = $default->id;
		if(isset($_GET['filter'])) $active = $_GET['filter'];
		foreach ($filters as $filter) { ?>
			<a href="/project/payment/view/?filter=<?php echo $filter->id; ?>" class="filters-team <?php if($filter->id==$active) echo "active"; ?>">
				<?php echo $filter->name; ?>
			</a>
		<?php } ?>
		<a href="/project/payment/view/" class="filters-team">
			<?php echo Yii::t('site','Reset filter'); ?>
		</a>
	</p>
<?php } ?>
<ul class="operations">
	<li><a href="#" id="extremum-in"><?=ProjectModule::t('Getting money')?></a></li>
	<li><a href="#" id="extremum-out"><?=ProjectModule::t('Pay for all')?></a></li>
	<li><a href="#" id="extremum-analysis"><?=ProjectModule::t('The financial analysis')?></a></li>
</ul>
<div id="in">
	<h3><?=ProjectModule::t('Getting money')?></h3>
	<?php
	function approve_buttons($data) {
		$html = '';
		if($data->approve == Payment::FREE) $html .= CHtml::button(Yii::t('site','Confirm'), array('class'=>'btn btn-primary btn-xs approve_payment', 'href' => $data->id, 'onclick' => 'setApprove($(this).attr("href"),$("#paymentType_"+$(this).attr("href")).val(),$("#payDetailNumber_"+$(this).attr("href")).val());return false;'));
		if($data->approve == Payment::FREE) $html .= CHtml::button(Yii::t('site','Reject'), array('class'=>'btn btn-primary btn-xs reject_payment', 'href' => $data->id, 'onclick' => 'setReject($(this).attr("href"));return false;'));
		if($data->approve == Payment::APPROVED) $html .= Yii::t('site','Confirmed');
		if($data->approve == Payment::REJECTED) $html .= Yii::t('site','Rejected');
		return $html;
	}
	$provider = $model->search(array(0));
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'buh_transaction_in',
		'dataProvider' => $provider,
		'filter'=>$model,
		'columns'=>array(
			array(
				'name' => 'order_id',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::link($data->order_id,array('zakaz/update','id'=>$data->order_id));
				},
				'footer'=>$provider->itemCount,
			),
			array(
				'name' => 'receive_date',
				'value' => function($data) {
					if($data->receive_date) return date('d.m.Y H:i:s', strtotime($data->receive_date));
				},
			),
			array(
				'name' => 'pay_date',
				'value' => function($data) {
					if($data->pay_date) return date('d.m.Y H:i:s', strtotime($data->pay_date));
				},
			),
			array(
				'name' => 'zakaz.title',
			),
			array(
				'header' => 'Спец',
				'name' => 'zakaz.catalog_specials.cat_name',
			),
			array(
				'header' => 'Спец2',
				'value' => function($data) {			
					//$columns = Yii::app()->db->createCommand("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . Company::getId() . "_projects'")->queryRow();
					$specials2 = false;
					$projectFields = Zakaz::model()->getFields();
					foreach($projectFields as $field) {
						if($field->varname == 'specials2') $specials2 = true;
					}
					if ($specials2) {
						if (isset($data->zakaz->catalog_specials2)) return $data->zakaz->catalog_specials2->cat_name;
					} else return false;
				}
			),
			array(
				'name' => 'manager',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::link($data->manager,array('/user/admin/view','id'=>$data->profileManager->id));
				}
			),
			array(
				'name' => 'user',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::link($data->user,array('/user/admin/view','id'=>$data->profileUser->id));
				}
			),
			/*array(
				'name' => 'profileUser.AuthAssignment.AuthItem.description',
			),*/
			array(
				'name' => 'summ',
				'footer'=>ProjectModule::t('The amount in accordance with the filter criteria').': <b>'.$model->pageTotal($provider).'</b>',
				'footerHtmlOptions'=>array('colspan'=>'4'),
			),
			array(
				'header' => Yii::t('site','Payment method'),
				'type' => 'raw',
				'value'=>function($data) {
					$payFields = ProfileField::model()->findAllByAttributes(array('paymentProps' => '1'));
					$payFieldsUser = $data->profileUser;

					foreach ($payFields as $field) {
						$fields[] = $field->varname;
						$final[$field->varname] = $field->title;
					}
					$fields = implode($fields, ',');
					
					$userPayFields = Profile::model()->find(array('select' => $fields, 'condition' => 'user_id = :user', 'params' => array(':user' => $data->profileUser->id)));
					
					$fields = array();
					if(!empty($userPayFields))
						foreach ($userPayFields as $key => $field)
							if ($field != null) $fields[$key] = $final[$key];
					
					$model = Company::model()->findByPk(Company::getId());
					if ($model !== null && $model->PaymentCash == '1') $fields['cash'] = 'Наличные';
				
					return CHtml::dropDownList('paymentType_' . $data->id, $data->details_type, $fields,
						array(
							'empty' => '',
							'disabled' => in_array($data->approve, array(Payment::APPROVED,Payment::REJECTED)) == 1 ? true : false,
							'ajax' => array(
								'url'=> PaymentController::createUrl('getPayNumber'),
								'data' => array(
									'payType' => 'js:this.value',
									'user' => $data->profileUser->id,
								),
								'success' => 'function(html) {
									if (html != "") $("#payDetailNumber_' . $data->id . '").val(html);
									else $("#payDetailNumber_' . $data->id . '").val("");
								}',
							),
						)
					);
				}
			),
			array(
				'name' => 'details_number',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::textField("payDetailNumber_{$data->id}", $data->details_number, array('disabled' => in_array($data->approve, array(Payment::APPROVED,Payment::REJECTED)) == 1 ? true : false));
				}
			),
			array(
				'name' => 'approve',
				'type' => 'raw',
				'value'=> function($data) {return approve_buttons($data);},
				'filter' => array('0' => Yii::t('site','New'), '1' => Yii::t('site','Confirmed'), '2' => Yii::t('site','Rejected')),
			),
			/*array(
				'class' => 'CButtonColumn',
				'template'=> '{approved} {reject} {for_approve} {for_reject} ',
				'buttons' => array(
					'for_approve' => array(
						'label' => Yii::t('site','Confirm'),
						'options' => array("class"=>"btn btn-primary btn-xs approve_payment"),
						'visible' => '$data->approve == '.Payment::FREE,
						'click' =>'function(){setApprove($(this).attr("href"),$("#paymentType_"+$(this).attr("href")).val(),$("#payDetailNumber_"+$(this).attr("href")).val());return false;}', // manager.js
						'url'=>'$data->id',
					),
					'for_reject' => array(
						'label' => Yii::t('site','Reject'),
						'options' => array("class"=>"btn btn-primary btn-xs reject_payment"),
						'visible' => '$data->approve == '.Payment::FREE,
						'click' => 'function(){setReject($(this).attr("href"));return false;}', 
						'url'=>'$data->id',
					),
					'approved' => array(
						'label' => Yii::t('site','Confirmed'),
						'visible' => '$data->approve == '.Payment::APPROVED,
					),
					'reject' => array(
						'label' => Yii::t('site','Rejected'),
						'visible' => '$data->approve == '.Payment::REJECTED,
					),
				),
			),*/
			array(
				'header' => 'Отменить платеж',
				'class' => 'CButtonColumn',
				'template'=> '{cancel}',
				'buttons' => array(
					'cancel' => array(
						'label' => Yii::t('site','Cancel'),
						'options' => array("class"=>"btn btn-primary btn-xs cancel_payment"),
						'visible' => 'in_array($data->approve, array('.Payment::APPROVED.', '.Payment::REJECTED.'))',
						'click' => 'function(){cancelPayment($(this).attr("href"));return false;}', // manager.js
						'url'=>'$data->id',
					),
				),
			),
		),
	));
	echo $test;?>
	Количество: <b><?= $data['in']['count'] ?></b>
	<br>
	Сумма: <b><?= $data['in']['sum'] ?>&nbsp;р.</b>
	
</div>

<div id="out" style="display: none;">
	<h3><?=ProjectModule::t('Pay for all')?></h3>
	<?php
	$provider = $model->search(array(1,2,3,4,5,6));
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'buh_transaction_out',
		'dataProvider' => $provider,
		'filter'=>$model,
		'columns'=>array(
			array(
				'name' => 'order_id',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::link($data->order_id,array('zakaz/update','id'=>$data->order_id));
				},
				'footer'=>$provider->itemCount,
			),
			array(
				'name' => 'receive_date',
				'value' => function($data) {
					if($data->receive_date) return date('d.m.Y H:i:s', strtotime($data->receive_date));
				},
			),
			array(
				'name' => 'pay_date',
				'value' => function($data) {
					if($data->pay_date) return date('d.m.Y H:i:s', strtotime($data->pay_date));
				},
			),
			array(
				'name' => 'zakaz.title',
			),
			array(
				'header' => 'Спец',
				'name' => 'zakaz.catalog_spec1.cat_name',
			),
			array(
				'header' => 'Спец2',
				'value' => function($data) {			
					//$columns = Yii::app()->db->createCommand("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . Company::getId() . "_projects'")->queryRow();
					$specials2 = false;
					$projectFields = Zakaz::model()->getFields();
					foreach($projectFields as $field) {
						if($field->varname == 'specials2') $specials2 = true;
					}
					if ($specials2) {
						if (isset($data->zakaz->catalog_specials2)) return $data->zakaz->catalog_specials2->cat_name;
					} else return false;
				}
			),
			array(
				'name' => 'manager',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::link($data->manager,array('/user/admin/view','id'=>$data->profileManager->id));
				}
			),
			array(
				'name' => 'user',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::link($data->user,array('/user/admin/view','id'=>$data->profileUser->id));
				}
			),
			array(
				'name' => 'payment_type',
				'value' => '$data->performType()',
			),
			array(
				'name' => 'summ',
				'footer'=>ProjectModule::t('The amount in accordance with the filter criteria').': <b>'.$model->pageTotal($provider).'</b>',
				'footerHtmlOptions'=>array('colspan'=>'4'),
			),
			array(
				'header' => Yii::t('site','Payment method'),
				'type' => 'raw',
				'value'=>function($data) {
					$payFields = ProfileField::model()->findAllByAttributes(array('paymentProps' => '1'));
					$payFieldsUser = $data->profileUser;

					foreach ($payFields as $field) {
						$fields[] = $field->varname;
						$final[$field->varname] = $field->title;
					}

					$fields = implode($fields, ',');

					$userPayFields = Profile::model()->find(array('select' => $fields, 'condition' => 'user_id = :user', 'params' => array(':user' => $data->profileUser->id)));

					$fields = array();
					if(!empty($userPayFields))					
						foreach ($userPayFields as $key => $field)
							if ($field != null) $fields[$key] = $final[$key];
					
					$model = Company::model()->findByPk(Company::getId());
					if ($model !== null && $model->PaymentCash == '1') $fields['cash'] = 'Наличные';
						
					return CHtml::dropDownList('paymentType_' . $data->id, $data->details_type, $fields,
						array(
							'empty' => '',
							'disabled' => in_array($data->approve, array(Payment::APPROVED,Payment::REJECTED)) ? true : false,
							'ajax' => array(
								'url'=> PaymentController::createUrl('getPayNumber'),
								'data' => array(
									'payType' => 'js:this.value',
									'user' => $data->profileUser->id,
								),
								'success' => 'function(html) {
									if (html != "") $("#payDetailNumber_' . $data->id . '").val(html);
									else $("#payDetailNumber_' . $data->id . '").val("");
								}',
							),
						)
					);
				}
			),
			array(
				'name' => 'details_number',
				'type' => 'raw',
				'value'=>function($data) {
					return CHtml::textField("payDetailNumber_{$data->id}", $data->details_number, array('disabled' => in_array($data->approve, array(Payment::APPROVED,Payment::REJECTED)) ? true : false));
				}
			),
			array(
				'name' => 'approve',
				'type' => 'raw',
				'value'=> function($data) {return approve_buttons($data);},
				'filter' => array('0' => Yii::t('site','New'), '1' => Yii::t('site','Confirmed'), '2' => Yii::t('site','Rejected')),
			),
			/*array(
				'class' => 'CButtonColumn',
				'template'=> '{approved} {reject} {for_approve} {for_reject} ',
				'buttons' => array(
					'for_approve' => array(
						'label' => Yii::t('site','Confirm'),
						'options' => array("class"=>"btn btn-primary btn-xs approve_payment"),
						'visible' => '$data->approve == '.Payment::FREE,
						'click' =>'function(){setApprove($(this).attr("href"),$("#paymentType_"+$(this).attr("href")).val(),$("#payDetailNumber_"+$(this).attr("href")).val());return false;}', // manager.js
						'url'=>'$data->id',
					),
					'for_reject' => array(
						'label' => Yii::t('site','Reject'),
						'options' => array("class"=>"btn btn-primary btn-xs reject_payment"),
						'visible' => '$data->approve == '.Payment::FREE,
						'click' => 'function(){setReject($(this).attr("href"));return false;}', 
						'url'=>'$data->id',
					),
					'approved' => array(
						'label' => Yii::t('site','Confirmed'),
						'visible' => '$data->approve == '.Payment::APPROVED,
					),
					'reject' => array(
						'label' => Yii::t('site','Rejected'),
						'visible' => '$data->approve == '.Payment::REJECTED,
					),
				),
			),*/
			array(
				'header' => 'Отменить платеж',
				'class' => 'CButtonColumn',
				'template'=> '{cancel}',
				'buttons' => array(
					'cancel' => array(
						'label' => Yii::t('site','Cancel'),
						'options' => array("class"=>"btn btn-primary btn-xs cancel_payment"),
						'visible' => 'in_array($data->approve, array('.Payment::APPROVED.', '.Payment::REJECTED.'))',
						'click' => 'function(){cancelPayment($(this).attr("href"));return false;}', // manager.js
						'url'=>'$data->id',
					),
				),
			),
		),
	));
	?>
	Количество: <b><?= $data['out']['count'] ?></b>
	<br>
	Сумма: <b><?= $data['out']['sum'] ?>&nbsp;р.</b>
</div>

<div id="analysis" style="display: none;">
	<h3><?=ProjectModule::t('The financial analysis')?></h3>
	<table class="table table-striped" style="text-align: justify; width: 100%;">
		<thead>
			<th><?=ProjectModule::t('Date')?></th>
			<th><?=ProjectModule::t('Income')?></th>
			<th><?=ProjectModule::t('Expenditure')?></th>
			<th><?=ProjectModule::t('Profit')?></th>
		</thead>
		<?php
		$totalProfit = 0;
		$totalIncome = 0;
		$totalExpenditure = 0;
		foreach ($profit as $item) {
			$totalProfit += $item['total'];
			$totalIncome += $item['s1'];
			$totalExpenditure += $item['s2'];
			?>
			<tr>
				<td><?php echo date("Y-m", strtotime($item['date'])); ?></td>
				<td><?php echo $item['s1']; ?></td>
				<td><?php echo $item['s2']; ?></td>
				<td><?php echo $item['total']; ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td><b><?=ProjectModule::t('Total')?></b></td>
			<td><b><?php echo $totalIncome; ?></b></td>
			<td><b><?php echo $totalExpenditure; ?></b></td>
			<td><b><?php echo $totalProfit; ?></b></td>
		</tr>
	</table>
</div>