<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/manager.css');
Yii::app()->clientScript->registerScriptFile('/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/common-masonry.js', CClientScript::POS_END);

$this->menu=array(
    array('label'=>Yii::t('site','Manage classifying actions'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('site','Accrue salary')?></h1>
<div class="form create-zakaz-block">
    <div class="">
        <p class="note"><?=Yii::t('site','Fields with <span class="required">*</span> are required.')?></p>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'action-form',
            'enableAjaxValidation'=>false,
        )); ?>
        <div class="row">
            <div class="form-item">
                <select class="form-control" name="employee" id="employee">
                    <option value><?php echo Yii::t('site','Select class an employee...');?></option>
                    <option value="Manager"><?php echo UserModule::t('Manager');?></option>
                    <option value="Corrector"><?php echo UserModule::t('Corrector');?></option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-item users" style="display: none">
                <select class="form-control" name="users_id" id="users_select">
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-item" id="calculation_sec" style="display: none">
                <label for="calculation" class="required" style="width: 100%"><?=Yii::t('site','calculation')?></label>
                <input name="calculation" id="calculation" type="text" value="">

                <label for="award" class="required" style="width: 100%"><?=Yii::t('site','Award')?></label>
                <input name="award" id="award" type="text" value="">

                <div class="form-save" style="margin-top: 25px">
                    <?php echo CHtml::submitButton(Yii::t('site','Accrue'), array (
                        'class' => 'btn btn-primary',
                    )); ?>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    $( document ).ready( function() {
        $('#employee').change(function(){
            $('.form-item.users').hide();
            var val = $(this).val();
            if(val) {
                $.post('/project/zarplata/salaryup', {val: val, action: 'get_users'}, function (status) {
                    $('#users_select').html(status);
                    $('.form-item.users').show();
                    $('#calculation_sec').hide();
                });
            } else {
                $('#calculation_sec').hide();
                $('.form-item.users').hide();
            }
        });

        $('#users_select').change(function(){
            var val = $('#employee').val();
            var user_id = $(this).val();
            if(user_id) {
                $.post('/project/zarplata/salaryup', {val: val, user_id: user_id, action: 'get_employee'}, function (status) {
                    $('#calculation').val(status);
                    $('#calculation_sec').show();
                });
            } else {
                $('#calculation_sec').hide();
            }
        });
    });
</script>