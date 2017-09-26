<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
?>

<div class="form create-zakaz-block">
	<div class="form-container">
		<p class="note"><?=Yii::t('site','Fields with <span class="required">*</span> are required.')?></p>

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'filter-form',
			'enableAjaxValidation'=>false,
		)); ?>
			<?php echo $form->errorSummary($model); ?>

			<div class="form-item">
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>

			<div class="form-item">
				<label for="role" class="required">
					<?php echo Yii::t('site','For role');?>
					<span class="required">*</span>
				</label>
				<?php
				$fa = array(
					array('val' => 'Manager', 'name' => UserModule::t('Manager')),
					array('val' => 'Customer', 'name' => UserModule::t('Customer')),
					array('val' => 'Author', 'name' => UserModule::t('Author')),
				);
				echo CHtml::activeDropDownList($model, 'role', CHtml::listData($fa, 'val', 'name'),
					array(
						'empty' => Yii::t('site','Select an role...'),
						'class' => 'form-control',
						'onchange' => 'showSelectTable(this)'
					));
				?>
			</div>

			<div class="form-item">
				<?php echo $form->labelEx($model,'default'); ?>
				<?php echo $form->checkBox($model,'default'); ?>
				<?php echo $form->error($model,'default'); ?>
			</div>

			<div class="form-item" <?php if(!$model->role) echo 'style="display: none"'; ?> id="table">
				<label for="table" class="required">
					<?php echo Yii::t('site','For table');?>
					<span class="required">*</span>
				</label>
				<?php
				$fa = array(
					array('name' => UserModule::t('User'), 'val' => 'User'),
					array('name' => UserModule::t('Projects'), 'val' => 'Projects'),
					array('name' => UserModule::t('Payment'), 'val' => 'Payment'),
					array('name' => UserModule::t('CurrentProjects'), 'val' => 'CurrentProjects'),
					array('name' => UserModule::t('DoneProjects'), 'val' => 'DoneProjects'),
				);
				echo CHtml::activeDropDownList($model, 'table', CHtml::listData($fa, 'val', 'name'),
					array(
						'empty' => Yii::t('site','Select an role...'),
						'class' => 'form-control',
						'onchange' => 'showColumnTable(this)'
					));
				?>
			</div>

			<div id="column_table">
				<? if($model->table) {
					$columns = Filters::getColumnTable($model->table);
					$filter = unserialize($model->filter);
					$this->renderPartial('tableColumn', array('columns'=>$columns, 'filter' => $filter));
				} ?>
			</div>

			<div style="clear: both"></div>

			<div class="form-save" style="position: inherit">
				<?php $attr = array('class' => 'btn btn-primary'); ?>
				<?php if(Yii::app()->user->isGuest) $attr['disabled'] = 'disabled'; ?>
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'Create') : Yii::t('site', 'Save'), $attr); ?>
			</div>

			<div style="clear: both"></div>

		<?php $this->endWidget(); ?>
	</div>
</div><!-- form -->

<script>
	function setRole(role) {
		if(role=='Customer') {
			$('#table option').hide();
			$('#table option[value="CurrentProjects"]').show();
			$('#table option[value="DoneProjects"]').show();
		} else if(role=='Author') {
			$('#table option').hide();
			$('#table option[value="CurrentProjects"]').show();
			$('#table option[value="DoneProjects"]').show();
		} else if(role=='Manager') {
			$('#table option').hide();
			$('#table option[value="User"]').show();
			$('#table option[value="Projects"]').show();
			$('#table option[value="Payment"]').show();
		}
	}

	function showSelectTable(selected) {
		var role = $(selected).val();
		setRole(role);
		$('#table option[value=""]').show();
		$('#table select').val("");
		$('#column_table').hide();
		$('#table').show();
	}

	<?php if($model->role) echo 'setRole("'.$model->role.'");'; ?>

	function showColumnTable(selected) {
		var table = selected.value;
		$.ajax({
			type: "POST",
			url:'http://'+document.domain+'/filters/columnTable/?table='+table,
			success: function(html) {
				if (html != 'null') {
					$('#column_table').html(html);
					$('#column_table').show();
				}
			}
		});
	}
</script>