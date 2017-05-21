<?php
/* @var $this TemplatesController */
/* @var $model Templates */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerScriptFile('/js/tinymce/tinymce.min.js');

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'templates-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?=Yii::t('site','Fields with <span class="required">*</span> are required.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'name'); ?>
	</div>

	<div class="row">
		<label for="Templates_title" class="required"><?=Yii::t('site','Button label')?> <span class="required">*</span></label>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<label for="Templates_text" class="required"><?=Yii::t('site','Message text')?> <span class="required">*</span></label>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<label for="Templates_type" class="required"><?=Yii::t('site','User type')?> <span class="required">*</span></label>
		<?php $list = $model->typesByCategory($type);
        echo $form->dropDownList($model, 'type_id', $list, array('empty' => Yii::t('site','Select')));
	    ?>
	</div>

	<div class="row buttons">
		<?php $attr = array(); ?>
		<?php if(Yii::app()->user->isGuest) $attr['disabled'] = 'disabled'; ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'Create') : Yii::t('site', 'Save'), $attr); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	tinymce.init({
		selector:'textarea',
		menubar: false,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
		],
		toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | mybutton',
		setup: function(editor) {
			editor.addButton('mybutton', {
				type: 'menubutton',
				text: '<?php echo Yii::t("site", "Variables"); ?>',
				icon: false,
				menu: [
					<?php foreach ($model->getVariables() as $variable) {
					echo "{	text: '".$variable."', onclick: function() { editor.insertContent('&nbsp;".$variable."&nbsp;'); } },";
				} ?>
				]
			});
		},
	});
</script>