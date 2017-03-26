<?php
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/worktypes.js');

if ($model->unixtime) echo  $form->hiddenField($model,'unixtime');
$projectFields = $model->getFields();
if ($projectFields) {
	foreach($projectFields as $field) {
		$work_types = '';
		if ($field->work_types) $work_types = ' data-worktypes="'.str_replace(',',' ',$field->work_types).'"';
		echo '<div class="form-item"'.$work_types.'>';
		echo $form->labelEx($model,$field->varname).'<br/>';
		if ($field->field_type=="BOOL"){
			echo $form->checkBox($model,$field->varname);
		} elseif ($field->field_type=="LIST"){
			$models = Catalog::model()->findAllByAttributes(array('field_varname'=>$field->varname));
			$list = CHtml::listData($models, 'id', 'cat_name');
			echo $form->dropDownList($model, $field->varname, $list, array('empty' => ProjectModule::t('Select a category'),'class'=>'form-control'));
			echo $form->error($model,$field->varname);
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($model,$field->varname,array('rows'=>6, 'cols'=>50, 'class'=>'form-control'));
		} elseif ($field->field_type!="TIMESTAMP") {
			echo $form->textField($model,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class'=>'form-control'));
		}
		echo '</div>';
	}
}
?>