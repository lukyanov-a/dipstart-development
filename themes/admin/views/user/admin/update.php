<?php
$this->breadcrumbs=array(
	(UserModule::t('Users'))=>array('admin'),
	$model->username=>array('view','id'=>$model->id),
	(UserModule::t('Update')),
);
$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    //array('label'=>UserModule::t('View User'), 'url'=>array('view','id'=>$model->id)),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);

$this->widget('zii.widgets.CMenu', array(
	'items'=>$this->menu,
	'htmlOptions'=>array('class'=>'operations'),
));
?>

<h1><?php echo  UserModule::t('Update User')." ".$model->id; ?></h1>

<div id="userAssignments">
	<h3><?php echo Rights::t('core', 'Assign item'); ?></h3>
	<div class="assignments span-12 first">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'template'=>'{items}',
			'hideHeader'=>true,
			'emptyText'=>Rights::t('core', 'This user has not been assigned any items.'),
			'htmlOptions'=>array('class'=>'grid-view user-assignment-table mini'),
			'columns'=>array(
				array(
					'name'=>'name',
					'header'=>Rights::t('core', 'Name'),
					'type'=>'raw',
					'htmlOptions'=>array('class'=>'name-column'),
					'value'=>'$data->getNameText()',
				),
				array(
					'name'=>'type',
					'header'=>Rights::t('core', 'Type'),
					'type'=>'raw',
					'htmlOptions'=>array('class'=>'type-column'),
					'value'=>'$data->getTypeText()',
				),
				array(
					'header'=>'&nbsp;',
					'type'=>'raw',
					'htmlOptions'=>array('class'=>'actions-column'),
					'value'=>'CHtml::linkButton(Rights::t("core", "Revoke"), array(
								"submit"=>array("//rights/assignment/revoke", "id"=>$data->userId, "name"=>urlencode($data->owner->name), "return"=>"user"),
								"class"=>"revoke-link",
								"csrf"=>Yii::app()->request->enableCsrfValidation))',
				),
			)
		)); ?>
	</div>
	<div class="add-assignment-update span-11 last">
		<div class="row">
			<div class="col-md-4">
			<?php if( $formModel!==null ): ?>

				<div class="form">

					<?php $form=$this->beginWidget('CActiveForm'); ?>
					<div class="col-md-6">
						<div class="row">
							<?php echo $form->dropDownList($formModel, 'itemname', $assignSelectOptions); ?>
							<?php echo $form->error($formModel, 'itemname'); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row buttons">
							<?php echo CHtml::submitButton(Rights::t('core', 'Assign')); ?>
						</div>
					</div>
					<?php $this->endWidget(); ?>
				</div>
			<?php else: ?>
				<p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?></p>
			<?php endif; ?>
			</div>
		</div>
		<?php //echo CHtml::link(UserModule::t('Edit assignments'), $this->createAbsoluteUrl('/rights/assignment/user',array('id'=>$model->id))).'<br /><br />'; ?>
	</div>
</div>
<?php
	echo $this->renderPartial('_form', array(
			'model'		=> $model,
			'profile'	=> $profile,
			'manager'	=> $manager,
			'admin'		=> $admin,
			'fields'	=> $fields,
			//'specials' => $specials,
		)
		);
?>
