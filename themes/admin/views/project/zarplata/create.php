<?php
$this->menu=array(
	array('label'=>Yii::t('site','Manage classifying actions'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('site','Create classifying actions')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'error' => $error)); ?>