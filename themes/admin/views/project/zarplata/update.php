<?php
$menu = array();
$menu[] = array('label'=>Yii::t('site','Create actions'), 'url'=>array('create'));
if($model->id!=1 && $model->id!=2) {
	$menu[] = array('label'=>Yii::t('site','Delete actions'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('site','Are you sure you want to delete this item?')));
}
$menu[] = array('label'=>Yii::t('site','Manage actions'), 'url'=>array('admin'));
$this->menu= $menu;
?>

<h1><?= Yii::t('site','Update classifying actions').' '.$model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>