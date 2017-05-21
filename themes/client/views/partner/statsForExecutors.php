<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/custom.css');?>
<div id="partner-stats-grid" class="white-block">
<?php echo Yii::t('partner','Executors have bun registred'); ?>: <?=$executors?>
<br>
<?php echo Yii::t('partner','Payed'); ?>: <?=$money?>
</div>