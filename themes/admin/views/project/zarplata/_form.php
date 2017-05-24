<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);
?>

<div class="form create-zakaz-block">
	<div class="form-container">
		<p class="note"><?=Yii::t('site','Fields with <span class="required">*</span> are required.')?></p>

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'action-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		)); ?>
			<?php echo $form->errorSummary($model); ?>

			<div class="form-item">
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>50)); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>

			<div class="form-item">
				<?php echo $form->labelEx($model,'factor'); ?>
				<?php echo $form->textField($model,'factor'); ?>
				<?php echo $form->error($model,'factor'); ?>
			</div>

			<div class="form-save">
				<?php $attr = array('class' => 'btn btn-primary'); ?>
				<?php if(Yii::app()->user->isGuest) $attr['disabled'] = 'disabled'; ?>
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'Create') : Yii::t('site', 'Save'), $attr); ?>
			</div>

		<?php $this->endWidget(); ?>
	</div>
</div><!-- form -->