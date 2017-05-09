<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');

/* @var $this ZakazController */
/* @var $model Zakaz */
/* @var $form CActiveForm */
?>
<div class="row">
<h1><?=ProjectModule::t('Create Zakaz')?></h1>
<div class="col-md-12 create-zakaz-block">
    <?php
    ?>
    <div class="form-container">
		<p class="note"><?=ProjectModule::t('Fields with <span class="required">*</span> are required.')?></p>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'zakaz-form',
            //'type' => 'horizontal',
            //'htmlOptions' => array('class' => 'well'),
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
        )); ?>

		<?php
		$url = '/uploads/'.$model->id.'/'.$model->unixtime.'/';
		$uploaded_files = $model->generateMaterialsList($url, true);
		$upload_params = array('unixtime' => $model->unixtime);
		?>
		<div class="form-item" style="min-height: 162px;">
			<?php
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id' => 'justFileUpload',
					'config' => array(
						'action' => $this->createUrl('/project/zakaz/upload', $upload_params),
						'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>'. ProjectModule::t('Drag and drop files here') .'</span><div class="qq-upload-button">'. ProjectModule::t('Attach materials to the order') .'</div><ul class="qq-upload-list">'.$uploaded_files.'</ul></div></div>',
						'disAllowedExtensions' => array('exe','scr'),
						'sizeLimit' => Tools::maxFileSize(), // maximum file size in bytes
						'minSizeLimit' => 1,// minimum file size in bytes
						'onComplete' => "js:function(id, fileName, responseJSON){masonry();}",
					)
				)
			);
			?>
		</div>

		<?php $this->renderPartial('_form', array('model' => $model, 'form' => $form)); ?>

		<div class="form-item create-terms">
			<h3><?=ProjectModule::t('Deadlines')?></h3>
			<table class="table" style="font-size: 12px">
				<thead>
				<th><?=ProjectModule::t('Designation')?></th>
				<th><?=ProjectModule::t('Date/Time')?></th>
				</thead>
				
				<tr>
					<td>
						<?php echo $form->labelEx($model,'max_exec_date'); ?>
					</td>
					<td>
						<?php
						$this->widget('ext.juidatetimepicker.EJuiDateTimePicker', array(
							'model' => $model,
							'attribute' => 'dbmax_exec_date',
							'options'=>array(
								'onSelect'=> "js: function(dateText,inst){
									var date=new Date(dateText.replace(/(\d+).(\d+).(\d+)( \d+:\d+)/, '$3/$2/$1'));
									var dnow=new Date;
									dnow.setHours(date.getHours());
									dnow.getMinutes(date.getMinutes());
									dnow.getSeconds(date.getSeconds());
									date.setDate(dnow.getDate()+Math.ceil((date-dnow)/2000/3600/24));
									$('#Zakaz_dbauthor_informed').datetimepicker('setDate',date);
								}"
							),
						));?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->labelEx($model,'author_informed'); ?>
					</td>
					<td>
						<?php
						$this->widget('ext.juidatetimepicker.EJuiDateTimePicker', array(
							'model' => $model,
							'attribute' => 'dbauthor_informed',
						));?>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="form-item" style="padding-left: 0; padding-right: 0;">
			<?php echo $form->errorSummary($model); ?>
			<div class="col-md-12">
				<?php echo $form->labelEx($model,'status');
				$models = ProjectStatus::model()->findAll();
				$list = CHtml::listData($models, 'id', 'status');
				echo $form->dropDownList($model, 'status', $list/*, array('empty' => ProjectModule::t('Select a status'))*/);?>
				<?php echo $form->error($model,'status'); ?>
			</div>
			<div class="col-md-12">
				<?php echo $form->labelEx($model,'user_id');
				$list = CHtml::listData(User::model()->findAllCustomers(), 'id', 'email');
				echo $form->dropDownList($model, 'user_id', $list, array('empty' => ProjectModule::t('Select a customer')));
				?>
				<?php echo $form->error($model,'user_id'); ?>
			</div>
			<div class="col-md-12">
				<?php echo $form->labelEx($model,'executor');
				$list = CHtml::listData(User::model()->findAllAuthors(), 'id', 'email');
				echo $form->dropDownList($model, 'executor', $list, array('empty' => ProjectModule::t('Select a author')));
				?>
				<?php //echo $form->textField($model,'executor',array('size'=>53,'maxlength'=>100)); ?>
				<?php echo $form->error($model,'executor'); ?>
			</div>
		</div>
		
        <div class="form-save">
     		<?php $attr = array ('class' => 'btn btn-primary'); ?>
			<?php if(Yii::app()->user->isGuest) $attr['disabled'] = 'disabled'; ?>
			<?php echo CHtml::submitButton($model->isNewRecord ? ProjectModule::t('Create') : ProjectModule::t('Save'), $attr); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
</div>