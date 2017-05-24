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
    <div class="form-container">
        <p class="note"><?=Yii::t('site','Fields with <span class="required">*</span> are required.')?></p>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'action-form',
            'enableAjaxValidation'=>false,
        )); ?>
        <div class="form-item">
            <label for="employee" class="required">
                <?php echo Yii::t('site','Create actions');?>
                <span class="required">*</span>
            </label>
            <select class="form-control" name="employee" id="employee">
                <option value><?php echo Yii::t('site','Select an employee...');?></option>
                <option value="Manager"><?php echo UserModule::t('Manager');?></option>
                <option value="Corrector"><?php echo UserModule::t('Corrector');?></option>
            </select>
        </div>

        <div class="form-item" id="calculation_sec" style="display: none">
            <div class="row">
                <label for="calculation" class="required" style="width: 100%"><?=Yii::t('site','calculation')?></label>
                <input name="calculation" id="calculation" type="text" value="">
            </div>

            <div class="row">
                <label for="award" class="required" style="width: 100%"><?=Yii::t('site','Award')?></label>
                <input name="award" id="award" type="text" value="">
            </div>
            <div class="form-save">
                <?php echo CHtml::submitButton(Yii::t('site','Accrue'), array (
                    'class' => 'btn btn-primary',
                )); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    $( document ).ready( function() {
        $('#employee').change(function(){
            var val = $(this).val();
            $.post('/project/zarplata/salaryup', {val: val}, function (status){
                $('#calculation').val(status);
                $('#calculation_sec').show();
            });
        });
    });
</script>