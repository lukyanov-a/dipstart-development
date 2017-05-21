<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);
?>

<div class="form create-zakaz-block">
	<div class="form-container">
		<p class="note"><?=Yii::t('site','Fields with <span class="required">*</span> are required.')?></p>

		<?php if(isset($error['success'])) echo '<p class="success">'.$error['success'].'</p>'; ?>
		<?php if(isset($error['message'])) echo '<div class="errorMessage">'.$error['message'].'</div>'; ?>

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'templates-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		)); ?>
			<?php echo $form->errorSummary($model); ?>

			<div class="form-item">
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>

			<div class="form-item">
				<a href="#" class="add-steps btn btn-primary"><?=Yii::t('site','Add steps')?></a>
			</div>

			<div class="step-all">
				<?php
				$steps = unserialize($model->steps);
				if(!empty($steps)) {
					foreach ($steps as $key=>$step) { ?>
						<div class="step form-item">
							<span class="num"><?= $key+1; ?></span>
							<div>
								<label style="width: 100%;"><?=Yii::t('site','Stage name')?></label>
								<input size="60" maxlength="255" name="TemplatesSteps[steps][name][]" value="<?= $step['name']; ?>" type="text">
								<div class="errorMessage"><?php if(isset($error['steps'][$key]['name'])) echo $error['steps'][$key]['name']; ?></div>
							</div>
							<div>
								<label style="width: 100%;"><?=Yii::t('site','Term of the stage (%)')?></label>
								<input size="60" maxlength="255" name="TemplatesSteps[steps][time][]" value="<?= $step['time']; ?>" type="text">
								<div class="errorMessage"><?php if(isset($error['steps'][$key]['time'])) echo $error['steps'][$key]['time']; ?></div>
							</div>
							<a href="#" class="dell-step"><?=Yii::t('site','Delete step')?></a>
						</div>
					<? }
				} else { ?>
					<div class="step form-item">
						<div>
							<label style="width: 100%;"><?=Yii::t('site','Stage name')?></label>
							<input size="60" maxlength="255" name="TemplatesSteps[steps][name][]" type="text">
						</div>
						<div>
							<label style="width: 100%;"><?=Yii::t('site','Term of the stage (%)')?></label>
							<input size="60" maxlength="255" name="TemplatesSteps[steps][time][]" type="text">
						</div>
						<a href="#" class="dell-step"><?=Yii::t('site','Delete step')?></a>
					</div>
				<?php } ?>
			</div>

			<div class="form-save">
				<?php $attr = array('class' => 'btn btn-primary'); ?>
				<?php if(Yii::app()->user->isGuest) $attr['disabled'] = 'disabled'; ?>
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'Create') : Yii::t('site', 'Save'), $attr); ?>
			</div>

		<?php $this->endWidget(); ?>
	</div>
</div><!-- form -->

<script>
	function del_step() {
		$('.dell-step').click(function (e) {
			e.preventDefault();
			if($('.step').length>1) {
				var del_step = $(this).parent();
				$('.form-container form').masonry('remove', del_step).masonry('layout');
				var step = 1;
				del_step.remove();
				$('.step').each(function () {
					$(this).find('.num').text(step);
					step++;
				});
			}
		});
	}

	$('.add-steps').click(function (e) {
		e.preventDefault();

		var new_step = $('.step:first').clone();
		new_step.find('input').val('');
		new_step.find('.num').text($('.step').length+1);
		$('.step-all').append(new_step);
		$('.form-container form').masonry('appended', new_step);
		del_step();
	});
	del_step();
</script>