<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/worktypes.js');
Yii::app()->getClientScript()->registerScriptFile('/js/tinymce/tinymce.min.js');

?>

<div class="form create-zakaz-block">
	<div class="form-container">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'company-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
	)); ?>
			<?php if(Yii::app()->user->hasFlash('companySuccessMessage'))
				echo '<p class="success">'.Yii::app()->user->getFlash('companySuccessMessage').'</p>';
			if(Yii::app()->user->hasFlash('companyErrorMessage'))
				echo $form->errorSummary($model);
			?>
			<?php if($root) { ?>
			<div class="form-item">
				<?php echo $form->labelEx($model,'frozen'); ?>
				<?php echo $form->checkBox($model,'frozen'); ?>
				<?php echo $form->error($model,'frozen'); ?>
			</div>
			<?php } ?>
			<div class="form-item">
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'domains'); ?>
				<?php echo $form->textField($model,'domains',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'domains'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'language'); ?>
				<?php //echo $form->textField($model,'language',array('size'=>10,'maxlength'=>2)); ?>
				<?php echo $form->dropDownList($model, 'language', array('en'=>'en','ru'=>'ru'), array('selected'=>$model->language /*,'empty' => ProjectModule::t('Select a language')*/,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'language'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'supportEmail'); ?>
				<?php echo $form->textField($model,'supportEmail',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($model,'supportEmail'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'PaymentCash'); ?>
				<?php echo $form->checkBox($model,'PaymentCash'); ?>
				<?php echo $form->error($model,'PaymentCash'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'Payment2Chekout'); ?>
				<?php echo $form->textField($model,'Payment2Chekout',array('size'=>60,'maxlength'=>11)); ?>
				<?php echo $form->error($model,'Payment2Chekout'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'Payment2ChekoutHash'); ?>
				<?php echo $form->textField($model,'Payment2ChekoutHash',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($model,'Payment2ChekoutHash'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'FrontPage'); ?>
				<?php echo $form->textField($model,'FrontPage',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'FrontPage'); ?>
			</div>
			<div class="form-item">
				<?php echo CHtml::image(Yii::app()->getBaseUrl(/*true*/) . '/' . $model->getFilesPath() . '/' . $model->icon, 'icon'); ?><br />
				<?php echo CHtml::label(Yii::t('site', 'icon'), 'iconupload'); ?>
				<?php echo CHtml::fileField('Company[iconupload]', '', array('class' => 'col-xs-12 btn btn-user')); ?>
				<?php echo $form->error($model,'iconupload'); ?>
			</div>
			<div class="form-item">
				<?php echo Tools::printLogo($model); ?>
				<br />
				<?php echo CHtml::label(ProjectModule::t('Attach file'), 'fileupload'); ?>
				<?php echo CHtml::fileField('Company[fileupload]', '', array('class' => 'col-xs-12 btn btn-user')); ?>
				<?php echo $form->error($model,'fileupload'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'header'); ?>
				<?php echo $form->textArea($model,'header',array('rows'=>12, 'cols'=>50, 'class'=>'form-control html-editor')); ?>
				<?php echo $form->error($model,'header'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'text4guests'); ?>
				<?php echo $form->textArea($model,'text4guests',array('rows'=>12, 'cols'=>50, 'class'=>'form-control html-editor')); ?>
				<?php echo $form->error($model,'text4guests'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'text4customers'); ?>
				<?php echo $form->textArea($model,'text4customers',array('rows'=>12, 'cols'=>50, 'class'=>'form-control html-editor')); ?>
				<?php echo $form->error($model,'text4customers'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'agreement4customers'); ?>
				<?php echo $form->textArea($model,'agreement4customers',array('rows'=>12, 'cols'=>50, 'class'=>'form-control html-editor')); ?>
				<?php echo $form->error($model,'agreement4customers'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'agreement4executors'); ?>
				<?php echo $form->textArea($model,'agreement4executors',array('rows'=>12, 'cols'=>50, 'class'=>'form-control html-editor')); ?>
				<?php echo $form->error($model,'agreement4executors'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'WebmasterFirstOrderRate'); ?>
				<?php echo $form->textField($model,'WebmasterFirstOrderRate',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'WebmasterFirstOrderRate'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'WebmasterSecondOrderRate'); ?>
				<?php echo $form->textField($model,'WebmasterSecondOrderRate',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'WebmasterSecondOrderRate'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'WebmasterFirstExecutorOrderRate'); ?>
				<?php echo $form->textField($model,'WebmasterFirstExecutorOrderRate',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'WebmasterFirstExecutorOrderRate'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'WebmasterSecondExecutorOrderRate'); ?>
				<?php echo $form->textField($model,'WebmasterSecondExecutorOrderRate',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'WebmasterSecondExecutorOrderRate'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'telfin_id'); ?>
				<?php echo $form->textField($model,'telfin_id',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'telfin_id'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'telfin_secret'); ?>
				<?php echo $form->textField($model,'telfin_secret',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'telfin_secret'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'smsc_login'); ?>
				<?php echo $form->textField($model,'smsc_login',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'smsc_login'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'smsc_passwd'); ?>
				<?php echo $form->textField($model,'smsc_passwd',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'smsc_passwd'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'module_tree'); ?>
				<?php echo $form->checkBox($model,'module_tree'); ?>
				<?php echo $form->error($model,'module_tree'); ?>
			</div>
			<div class="form-item">
				<?php echo $form->labelEx($model,'contacts'); ?>
				<?php echo $form->textField($model,'contacts',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'contacts'); ?>
			</div>
			<div class="form-save">
				<?php echo CHtml::submitButton(UserModule::t('Save'), array ('class' => 'btn btn-primary')); ?>
			</div>
		<?php $this->endWidget(); ?>
	</div>
</div><!-- form -->

<div class="form create-zakaz-block">
	<div class="form-container">
		<h3> <?=Yii::t('site', 'Paste these links on your site')?> </h3>
		<div class="form-item">
			<table class="table table-striped" style="font-size: 12px;">
				<tr>
					<td>
						<?=Yii::t('site', 'Creation of the application by the customer with the completion of the brief')?>:
					</td>
					<td>
						<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/project/zakaz/create">http://<?php echo $_SERVER['SERVER_NAME']; ?>/project/zakaz/create</a>
					</td>
				</tr>
				<tr>
					<td>
						<?=Yii::t('site', 'Personal cabinet (authorization; for any type of user)')?>:
					</td>
					<td>
						<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/user/login">http://<?php echo $_SERVER['SERVER_NAME']; ?>/user/login</a>
					</td>
				</tr>
				<tr>
					<td>
						<?=Yii::t('site', 'Quick registration (or, also, registration of the customer)')?>:
					</td>
					<td>
						<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/user/registration">http://<?php echo $_SERVER['SERVER_NAME']; ?>/user/registration</a>
					</td>
				</tr>
				<tr>
					<td>
						<?=Yii::t('site', 'Registering the company as WEB MASTER (Partner, leading clients)')?>:
					</td>
					<td>
						<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/user/registration?role=Webmaster">http://<?php echo $_SERVER['SERVER_NAME']; ?>/user/registration?role=Webmaster</a>
					</td>
				</tr>
				<tr>
					<td>
						<?=Yii::t('site', 'List of orders for freelancers (not yet registered potential performers)')?>:
					</td>
					<td>
						<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/project/zakaz/list">http://<?php echo $_SERVER['SERVER_NAME']; ?>/project/zakaz/list</a>
					</td>
				</tr>
				<tr>
					<td>
						<?=Yii::t('site', 'Quick order')?>:
					</td>
					<td>
						http://<?php echo $_SERVER['SERVER_NAME']; ?>/user/registration?RegistrationForm[email]=<%= email %>&RegistrationForm[phone_number]=<%= phone %>
					</td>
				</tr>
			</table>
		</div>
		<div style="clear: both"></div>
	</div>
</div>

<script>
	tinymce.init({
		selector:'.html-editor',
		menubar: false,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
		],
		toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	});
</script>