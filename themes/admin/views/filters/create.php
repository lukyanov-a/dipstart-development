<?php
$this->menu=array(
    array('label'=>Yii::t('site','Filter templates'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('site','Create filter')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>