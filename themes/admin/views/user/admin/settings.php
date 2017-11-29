<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);
?>

<h1 style="margin-top: 20px"><?=Yii::t('site','Profile settings')?></h1>

<div class="form create-zakaz-block">
    <div class="form-container">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'templates-form',
            'enableAjaxValidation'=>false,
        )); ?>
            <?php echo $form->errorSummary($model); ?><br>
            <div class="form-item">
                <input type="checkbox" id="max_waiting_time_teh_email" <?php echo $model->max_waiting_time_teh_email ? 'checked="checked"' : ''; ?>>
                <?php echo $form->labelEx($model,'max_waiting_time_teh_email', array('for'=>'max_waiting_time_teh_email')); ?><br>
                <div <?php echo !$model->max_waiting_time_teh_email ? 'style="display: none"' : ''; ?>>
                    <?php echo Yii::t('site', 'at the expiration of'); ?>
                    <?php echo $form->textField($model,'max_waiting_time_teh_email'); ?>
                    <?php echo Yii::t('site', 'minutes'); ?>
                </div>
                <?php echo $form->error($model,'max_waiting_time_teh_email'); ?>
            </div>

            <div class="form-item">
                <input type="checkbox" id="max_waiting_time_teh_sms" <?php echo $model->max_waiting_time_teh_sms ? 'checked' : ''; ?>>
                <?php echo $form->labelEx($model,'max_waiting_time_teh_sms', array('for'=>'max_waiting_time_teh_sms')); ?><br>
                <div <?php echo !$model->max_waiting_time_teh_sms ? 'style="display: none"' : ''; ?>>
                    <?php echo Yii::t('site', 'at the expiration of'); ?>
                    <?php echo $form->textField($model,'max_waiting_time_teh_sms'); ?>
                    <?php echo Yii::t('site', 'minutes'); ?>
                </div>
                <?php echo $form->error($model,'max_waiting_time_teh_sms'); ?>
            </div>

            <div class="form-item">
                <input type="checkbox" id="max_waiting_time_admin_email" <?php echo $model->max_waiting_time_admin_email ? 'checked' : ''; ?>>
                <?php echo $form->labelEx($model,'max_waiting_time_admin_email', array('for'=>'max_waiting_time_admin_email')); ?><br>
                <div <?php echo !$model->max_waiting_time_admin_email ? 'style="display: none"' : ''; ?>>
                    <?php echo Yii::t('site', 'at the expiration of'); ?>
                    <?php echo $form->textField($model,'max_waiting_time_admin_email'); ?>
                    <?php echo Yii::t('site', 'minutes'); ?>
                </div>
                <?php echo $form->error($model,'max_waiting_time_admin_email'); ?>
            </div>

            <div class="form-item">
                <input type="checkbox" id="max_waiting_time_admin_sms" <?php echo $model->max_waiting_time_admin_sms ? 'checked' : ''; ?>>
                <?php echo $form->labelEx($model,'max_waiting_time_admin_sms', array('for'=>'max_waiting_time_admin_sms')); ?><br>
                <div <?php echo !$model->max_waiting_time_admin_sms ? 'style="display: none"' : ''; ?>>
                    <?php echo Yii::t('site', 'at the expiration of'); ?>
                    <?php echo $form->textField($model,'max_waiting_time_admin_sms'); ?>
                    <?php echo Yii::t('site', 'minutes'); ?>
                </div>
                <?php echo $form->error($model,'max_waiting_time_admin_sms'); ?>
            </div>

            <div class="form-item">
                <input type="checkbox" id="max_waiting_time_manager_email" <?php echo $model->max_waiting_time_manager_email ? 'checked' : ''; ?>>
                <?php echo $form->labelEx($model,'max_waiting_time_manager_email', array('for'=>'max_waiting_time_manager_email')); ?><br>
                <div <?php echo !$model->max_waiting_time_manager_email ? 'style="display: none"' : ''; ?>>
                    <?php echo Yii::t('site', 'at the expiration of'); ?>
                    <?php echo $form->textField($model,'max_waiting_time_manager_email'); ?>
                    <?php echo Yii::t('site', 'minutes'); ?>
                </div>
                <?php echo $form->error($model,'max_waiting_time_manager_email'); ?>
            </div>

            <div class="form-item">
                <input type="checkbox" id="max_waiting_time_manager_sms" <?php echo $model->max_waiting_time_manager_sms ? 'checked' : ''; ?>>
                <?php echo $form->labelEx($model,'max_waiting_time_manager_sms', array('for'=>'max_waiting_time_manager_sms')); ?><br>
                <div <?php echo !$model->max_waiting_time_manager_sms ? 'style="display: none"' : ''; ?>>
                    <?php echo Yii::t('site', 'at the expiration of'); ?>
                    <?php echo $form->textField($model,'max_waiting_time_manager_sms'); ?>
                    <?php echo Yii::t('site', 'minutes'); ?>
                </div>
                <?php echo $form->error($model,'max_waiting_time_manager_sms'); ?>
            </div>

            <div class="form-item">
                <?php echo Yii::t('site', 'Time Work'); ?><br>
                <?php echo Yii::t('site', 'From'); ?>:
                <?php
                $this->widget('ext.juidatetimepicker.EJuiDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'time_work_start',
                    'options' => array('timeOnly' => true),
                ));
                ?>
                <?php echo Yii::t('site', 'to'); ?>:
                <?php
                $this->widget('ext.juidatetimepicker.EJuiDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'time_work_end',
                    'options' => array('timeOnly' => true),
                ));
                ?>
                <?php echo $form->error($model,'time_work_start'); ?><br>
                <?php echo $form->error($model,'time_work_end'); ?>
            </div>

            <div class="form-item">
                <?php echo CHtml::submitButton(Yii::t('site', 'Save')); ?>
            </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".form-item input[type='checkbox']").click( function(){
            if ($(this).is(':checked')) {
                $(this).parent().find('div').fadeIn(300);
            } else {
                $(this).parent().find('div').fadeOut(300);
                $(this).parent().find("input[type='text']").val('');
            }
        });
    });
</script>