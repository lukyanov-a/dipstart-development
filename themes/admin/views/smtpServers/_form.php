<?php
/* @var $model SmtpServer */
?>
<div class="form create-zakaz-block">
    <?php echo CHtml::errorSummary($model); ?>
    <div class="form-container">
        <?php echo CHtml::beginForm(); ?>

        <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

        <div class="form-item address">
            <?php echo CHtml::activeLabelEx($model, 'address'); ?>
            <?php echo CHtml::activeTextField($model, 'address', ['size' => 60, 'maxlength' => 255]); ?>
            <?php echo CHtml::error($model, 'address'); ?>
        </div>

        <div class="form-item port">
            <?php echo CHtml::activeLabelEx($model, 'port'); ?>
            <?php echo CHtml::activeTextField($model, 'port'); ?>
            <?php echo CHtml::error($model, 'port'); ?>
        </div>

        <div class="form-item secure">
            <?php echo CHtml::activeLabelEx($model, 'secure'); ?>
            <?php echo CHtml::activeDropDownList($model, 'secure', SmtpServer::itemAlias('secure')); ?>
            <?php echo CHtml::error($model, 'secure'); ?>
        </div>

        <div class="form-item login">
            <?php echo CHtml::activeLabelEx($model, 'login'); ?>
            <?php echo CHtml::activeTextField($model, 'login', ['size' => 50, 'maxlength' => 255]); ?>
            <?php echo CHtml::error($model, 'login'); ?>
        </div>

        <div class="form-item password">
            <?php echo CHtml::activeLabelEx($model, 'password'); ?>
            <?php echo CHtml::activeTextField($model, 'password', ['size' => 50, 'maxlength' => 255]); ?>
            <?php echo CHtml::error($model, 'password'); ?>
        </div>

        <div class="form-item limit">
            <?php echo CHtml::activeLabelEx($model, 'limit'); ?>
            <?php echo CHtml::activeTextField($model, 'limit'); ?>
            <?php echo CHtml::error($model, 'limit'); ?>
        </div>

        <div class="form-save">
            <?php $attr = ['class' => 'btn btn-primary']; ?>
            <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), $attr); ?>
        </div>

        <?php echo CHtml::endForm(); ?>

    </div>
</div><!-- form -->
