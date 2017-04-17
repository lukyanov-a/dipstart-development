<?php
/* @var $this ZakazController */
/* @var $model Zakaz */

$attr = array('id');
if(User::model()->isCustomer()) {
	if(isset($model->max_exec_date)) $attr[] = [
		'name' => 'deadline',
		'value' => Yii::app()->dateFormatter->formatDateTime($model->max_exec_date),
	];
} else {
	$attr[] = [
		'name' => 'deadline',
		'value' => Yii::app()->dateFormatter->formatDateTime($model->author_informed),
	];
}
$work_type = false;
if(isset($model->specials2)) $work_type = $model->specials2;
$projectFields = $model->getFields($role);
if ($projectFields) {
	foreach($projectFields as $field) {
		if ($work_type === false || $field->work_types == null || in_array($work_type, explode(',',$field->work_types))) {
			if ($field->field_type=="BOOL"){
				$tmp = $field->varname;
				$tmp = $model->$tmp;
				if($tmp) $tmp=ProjectModule::t('Yes'); else $tmp=ProjectModule::t('No');
				$attr[] = [
                    'name' => $field->varname,
                    'label' => $field->title,
					'value' => $tmp
				];
			} elseif ($field->field_type=="LIST"){
				$tmp = $field->varname;
				$attr[] = [
                    'name' => $field->varname,
                    'label' => $field->title,
					'type' => 'raw',
					'value' => Catalog::model()->findByPk($model->$tmp)->cat_name,
				];
			} else {
			    //var_dump($field->title);
				$tmp = $field->varname;
				$attr[] = [
					'name' => $field->varname,
					'label' => $field->title,
					'value' => $model->$tmp
				];
			}
		}
	}
}

// --- company      генерируем список загруженных материалов
if(isset(Zakaz::$files_folder)){
	$url = Zakaz::$files_folder.$model->id.'/';
} else {
	$url = '/uploads/'.$model->id.'/';
}
$html_string = $model->generateMaterialsList($url, false, $cant_remove_files);
// ---
$attr[] = [
	'name' => 'attached_materials',
    'label' => ProjectModule::t('Attached materials'),
	'type'=>'raw',
	'value' => '<ul class="materials-files">'.$html_string.'</ul>'
];

if(!User::model()->isCustomer() && $model->getAttribute('author_notes')) {
	$attr[] = [
		'name' => 'comments_to_the_work',
        'label' => ProjectModule::t('Comments to the work'),
		'value' => $model->getAttribute('author_notes')
	];
}

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$attr,
));