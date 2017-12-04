<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    //array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    //array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    //array('label'=>UserModule::t('User rights'), 'url'=>array('/rights')),
);

$this->widget('zii.widgets.CMenu', array(
	'items'=>$this->menu,
	'htmlOptions'=>array('class'=>'operations'),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<p><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>

<?php echo CHtml::link(UserModule::t('Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$filters = Filters::getFilters('User', User::model()->getUserRole());
if(!empty($filters)) {
	?>
	<p><?=Yii::t('site','Filters')?>:
		<?php
		$default = Filters::getDefaultFilters('User', User::model()->getUserRole());
		$active = $default->id;
		if(isset($_GET['filter'])) $active = $_GET['filter'];
		foreach ($filters as $filter) { ?>
			<a href="/user/admin/?filter=<?php echo $filter->id; ?>" class="filters-team <?php if($filter->id==$active) echo "active"; ?>">
				<?php echo $filter->name; ?>
			</a>
		<?php } ?>
		<a href="/user/admin/" class="filters-team">
			<?php echo Yii::t('site','Reset filter'); ?>
		</a>
	</p>
<?php } ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->with('roles')->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/update","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"email"),array("admin/update","id"=>$data->id))',
			//'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		array(
			'name'=>'phone_number',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"phone_number"),array("admin/update","id"=>$data->id))',
		),
		'create_at',
		'lastvisit_at',
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
		array(
			'name'=>'roles',
			'value'=>'$data->printRoles()',
			'filter' => User::itemAlias('roles'),
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
		),
	),
)); ?>
