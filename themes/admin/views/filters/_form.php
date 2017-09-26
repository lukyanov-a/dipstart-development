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
					array('name' => 'Manager'),
					array('name' => 'Customer'),
					array('name' => 'Author'),
				);
				echo CHtml::activeDropDownList($model, 'role', CHtml::listData($fa, 'name', 'name'),
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
					array('name' => 'User'),
					array('name' => 'Projects'),
					array('name' => 'Payment'),
				);
				echo CHtml::activeDropDownList($model, 'table', CHtml::listData($fa, 'name', 'name'),
					array(
						'empty' => Yii::t('site','Select an role...'),
						'class' => 'form-control',
						'onchange' => 'showColumnTable(this)'
					));
				?>
			</div>

			<? if($model->table) {
				$columns = Filters::getColumnTable($model->table);
				$filter = unserialize($model->filter);
				$this->renderPartial('tableColumn', array('columns'=>$columns, 'filter' => $filter));
			} ?>

			<div id="column_table"></div>

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
	function showSelectTable(selected) {
		var role = selected.value;
		if(role=='Customer') {
			$('#table option[value="Payment"]').hide();
			$('#table option[value="User"]').hide();
			$('#table option[value="Projects"]').show();
		} else if(role=='Author') {
			$('#table option[value="Payment"]').hide();
			$('#table option[value="User"]').hide();
			$('#table option[value="Projects"]').show();
		} else if(role=='Manager') {
			$('#table option[value="Payment"]').show();
			$('#table option[value="User"]').show();
			$('#table option[value="Projects"]').show();
		}
		$('#table').show();
	}

	function showColumnTable(selected) {
		var table = selected.value;
		$.ajax({
			type: "POST",
			url:'http://'+document.domain+'/filters/columnTable/?table='+table,
			success: function(html) {
				if (html != 'null') {
					$('#column_table').html(html);
				}
			}
		});
	}
</script>