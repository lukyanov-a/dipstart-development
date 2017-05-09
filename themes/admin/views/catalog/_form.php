<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/worktypes.js');
?>

<div class="form create-zakaz-block">
	<div class="form-container">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'catalog-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		)); ?>

			<p class="note"><?=Yii::t('site','Fields with <span class="required">*</span> are required.')?></p>

			<?php echo $form->errorSummary($model); ?>


			<div class="form-item">
				<?php echo $form->labelEx($model,'cat_name'); ?>
				<?php echo $form->textField($model,'cat_name',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'cat_name'); ?>
			</div>

			<?php if($field_varname!=-1) {
				echo $form->hiddenField($model,'field_varname', array('value'=>$field_varname));
			} else { ?>
				<div class="form-item"><?php
					echo $form->labelEx($model,'field_varname');
					//echo $form->textField($model,'field_varname',array('size'=>60,'maxlength'=>50));
					echo $form->error($model,'field_varname');
					$criteria = new CDbCriteria();
					$criteria->compare('field_type','LIST');
					$list = CHtml::listData(ProjectField::model()->findAll($criteria),'varname','title');
					$list = array_merge($list,CHtml::listData(ProfileField::model()->findAll($criteria),'varname','title'));
					echo $form->dropDownList($model, 'field_varname', $list, array('empty' => Yii::t('site','Select')));
				?></div>
			<?php } ?>

		<?php if($parent==0) { ?>
			<div class="form-item">
			<?php
				 echo $form->label($model,'parent_id');
				 $criteria = new CDbCriteria();
				 $criteria->compare('parent_id',0);
				 $list = CHtml::listData(Catalog::model()->findAll($criteria),'id','cat_name');
				 echo $form->dropDownList($model, 'parent_id', $list, array('empty' => Yii::t('site','Select')));
				?>
			</div>
		<?php } else {
			echo $form->hiddenField($model,'parent_id');
		} ?>

			<div class="form-save">
				<?php $attr = array('class' => 'btn btn-primary'); ?>
				<?php if(Yii::app()->user->isGuest) $attr['disabled'] = 'disabled'; ?>
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site','Create') : Yii::t('site','Save'), $attr); ?>
			</div>

		<?php $this->endWidget(); ?>
	</div>

</div><!-- form -->