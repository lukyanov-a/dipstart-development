<?php
/**
 * Created by PhpStorm.
 * User: Emericanec
 * Date: 17.02.15
 * Time: 20:46
 */
?>
<br>
<?php echo ProjectModule::t('User').' '.$user->full_name.' ('.$user->email.', '.$user->phone_number.') '. CHtml::link(ProjectModule::t('placed an order'), $this->createUrl('zakaz/update',array('id'=>$model->id))) ?><br>
<br>
<?php
if($model) {
	$columns = array([
			'name' => 'id',
			'type'=>'raw',
			'value'=>CHtml::link($model->id, $this->createUrl('zakaz/update',array('id'=>$model->id))),
		], 
		[
			'name' => 'author_informed',
			'value' => Yii::app()->dateFormatter->formatDateTime($model->author_informed),
		]);
	$work_type = false;
	if(isset($model->specials2)) $work_type = $model->specials2;
	$projectFields = $model->getFields();
	if ($projectFields) {
		foreach($projectFields as $field) {
			if ($work_type === false || $field->work_types == null || in_array($work_type, explode(',',$field->work_types))) {
				if ($field->field_type=="BOOL"){
					$tmp = $field->varname;
					$tmp = $model->$tmp;
					if($tmp) $tmp=ProjectModule::t('Yes'); else $tmp=ProjectModule::t('No');
					$columns[] = [
						'label' => $field->title,
						'value' => $tmp
					];
				} elseif ($field->field_type=="LIST"){
					$tmp = $field->varname;
					$columns[] = [
						'label' => $field->title,
						'type' => 'raw',
						'value' => Catalog::model()->findByPk($model->$tmp)->cat_name,
					];
				} else {
					$tmp = $field->varname;
					$columns[] = [
						'label' => $field->title,
						'value' => $model->$tmp
						//'value'=>Tools::inlineEdit($model, $tmp, "textarea")
					];
				}
			}
		}
	}
	$this->widget('zii.widgets.CDetailView', array(
		'data' => $model,
		'attributes' => $columns));
	?>
	<br>
	<form method="post"
		  action="<?php echo Yii::app()->createUrl('project/zakaz/moderationAnswer', array('id' => $model->id, 'event_next' => $event, 'answer' => 1));?>"
		  style="display: inline-block">
		<input type="submit" value="<?=ProjectModule::t('Approve') ?>">
	</form>
	<form method="post"
		  action="<?php echo Yii::app()->createUrl('project/zakaz/moderationAnswer', array('id' => $model->id, 'event_next' => $event, 'answer' => 0));?>"
		  style="display: inline-block">
		<input type="submit" value="<?=ProjectModule::t('Reject') ?>">
	</form>
	<?php
} else {
	echo 'Project not found.';
}