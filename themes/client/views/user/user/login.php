<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login"); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/skin2.css');?>
<!--<div class="col-xs-offset-3 col-xs-6 login-form-bg"> -->
<div class="login-form-bg">
<?php  $this->widget('application.components.UloginWidget', array(
    'params'=>array(
        'redirect'=>'http://'.$_SERVER['HTTP_HOST'].'/ulogin/login?role='.$_GET['role'] //Адрес, на который ulogin будет редиректить браузер клиента. Он должен соответствовать контроллеру ulogin и действию login
    )
)); ?>

<h1><?=UserModule::t("Login") ?></h1>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<!--<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>-->

<!-- form begin-->
<form method="post" role="form">
<?php echo CHtml::beginForm(); ?>

	<!--<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>-->
	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="form-group">
        <!--<?php //echo CHtml::activeLabelEx($model,'username'); ?> <br />-->
		<?php echo CHtml::activeTextField($model,'username',array('placeholder' => $model->getAttributeLabel( 'username' ))); ?>
	</div>
	
	<div class="form-group">
		<!--<?php echo CHtml::activeLabelEx($model,'password'); ?> <br />-->
		<?php echo CHtml::activePasswordField($model,'password',array('placeholder'=>'Пароль', 'class'=>'placeholder')) ?>
	</div>
	
	<div>
		<p class="hint">
			<a href="/user/registration<?php if($_GET['role']) echo '?role='.$_GET['role']; ?>"><?=UserModule::t('Register') ?></a>
			<?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
        <p>
			<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?> <label for="UserLogin_rememberMe"><?=UserModule::t("Remember me next time") ?></label>
        </p>
	</div>
	
	<div class="nova-btn user_submit">
		<?php echo CHtml::submitButton(UserModule::t("Login")); ?>
	</div>
	
<?php echo CHtml::endForm(); ?>
</div>
</form>
<!-- form end-->
</div>