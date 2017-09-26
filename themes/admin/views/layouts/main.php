<?php
/**
 * Created by PhpStorm.
 * User: coolfire
 * Date: 16.04.15
 * Time: 11:56
 */
$items = array();
$role = User::model()->getUserRole();
$menuprofile = array('label'=>Yii::t('site','Logout'). ' ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'));
if(count($user_roles = User::model()->getUserRoleArr())>1) {
	$itemprofile = array();
	foreach ($user_roles as $user_role) {
		if(in_array($user_role, User::model()->PRIORITY_ROLES)) {
			$itemprofile[] = array('label' => Yii::t('site', $user_role), 'url' => array('/site/setrole/', 'role' => $user_role));
		}
	}
	$itemprofile[] = array('label'=>Yii::t('site','Logout'). ' ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'));
	$menuprofile = array('label'=>Yii::t('site','My profile'), 'url'=>array('#'), 'items' => $itemprofile);
}
switch ($role){
	case 'root':
		$items[] = array('label'=>Yii::t('site','SQL'), 'url'=>array('/company/sql'));
		$items[] = array('label'=>Yii::t('site','List companies'), 'url'=>array('/company/list'));
		$items[] = array('label'=>Yii::t('site','Create company'), 'url'=>array('/company/create'));
		$items[] = array('label'=>Yii::t('site','Edit company'), 'url'=>array('/company/edit'));
		$items[] = array('label'=>Yii::t('site','Rights'), 'url'=>array('/rights'));
		$items[] = array('label'=>Yii::t('site','Logout'). ' ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'));
		break;
    case 'Admin':
		//$items[] = array('label'=>Yii::t('site','Home'), 'url'=>Yii::app()->getBaseUrl(true));
		$items[] = array('label'=>Yii::t('site','Events'), 'url'=>array('/project/event'), 'items' => array(
			array('label'=>Yii::t('site','Events for manager'), 'url'=>array('/project/event')),
			array('label'=>Yii::t('site','Events for sales-manager'), 'url'=>array('/project/event/salesManagerIndex')),
		));
		$items[] = array('label'=>Yii::t('site','Orders'), 'url'=>array('/project/zakaz'), 'items' => array(
			array('label'=>Yii::t('site','All orders'), 'url'=>array('/project/zakaz')),
			array('label'=>Yii::t('site','Create order'), 'url'=>array('/project/zakaz/create')),
		), 'itemOptions' =>   array('class' => 'dropdown-submenu'));
		$user = User::model()->findByPk(Yii::app()->user->id); // is it need??
		$items[] = array('label'=>Yii::t('site','Accounts department'), 'url'=>array('/project/payment/view'), 'visible'=>$user->superuser);
		$items[] = array('label'=>Yii::t('site','Users'), 'url'=>array('/user/admin'));
		  $logs[] = array('label'=>Yii::t('site','Managers logs'), 'url'=>array('/logs'));
		  if(Yii::app()->cdr->app_id) $logs[] = array('label'=>Yii::t('site','Calls'), 'url'=>array('/call/index'));
		$items[] = array('label'=>Yii::t('site','Logs'), 'url'=>array('/logs'), 'items' => $logs);
		$items[] = array('label'=>Yii::t('site','Company settings'), 'url'=>array('#'), 'items' => array(
			array('label'=>Yii::t('site','Base settings'), 'url'=>array('/company/edit')),
			array('label'=>Yii::t('site','Templates'), 'url'=>array('/templates/admin')),
            array('label'=>Yii::t('site','Templates steps'), 'url'=>array('/templatesSteps/admin')),
			array('label'=>Yii::t('site','Filter templates'), 'url'=>array('/filters/admin')),
			array('label'=>Yii::t('site','Statuses'), 'url'=>array('/projectStatus/admin')),
			array('label'=>Yii::t('site','Salaries'), 'url'=>array('/project/zarplata/index')),
			array('label'=>Yii::t('site','Parts statuses'), 'url'=>array('/partStatus/admin')),
			array('label'=>Yii::t('site','Project fields settings'), 'url'=>array('/project/projectField/admin')),
			array('label'=>Yii::t('site','Profile fields settings'), 'url'=>array('/user/profileField/admin')),
			array('label'=>Yii::t('site','Rights'), 'url'=>array('/rights')),
			array('label'=>Yii::t('site','Fields lists'), 'url'=>array('/catalog/admin')),
			array('label'=>Yii::t('site','Delivery'), 'url'=>array('/project/emails')),
		));
		$items[] = $menuprofile;
		break;
    case 'Manager':
        $items[] = array('label'=>Yii::t('site','Users'), 'url'=>array('/user/admin'));
		$items[] = array('label'=>Yii::t('site','All orders'), 'url'=>array('/project/zakaz'));
		$items[] = array('label'=>Yii::t('site','Create order'), 'url'=>array('/project/zakaz/create'));
		if (User::model()->isSalesManager()) {
			$items[] = array('label'=>Yii::t('site','Events'), 'url'=>array('/project/event'), 'items' => array(
				array('label'=>Yii::t('site','Events for manager'), 'url'=>array('/project/event')),
				array('label'=>Yii::t('site','Events for sales-manager'), 'url'=>array('/project/event/salesManagerIndex')),
			));
		} else {
			$items[] = array('label'=>Yii::t('site','Events'), 'url'=>array('/project/event'));
		}
		$items[] = array('label'=>Yii::t('site','Delivery'), 'url'=>array('/project/emails'));
        //$items[] = array('label'=>Yii::app()->user->fullName(), 'url'=>array('#'));
		//$items[] = array('label'=>Yii::t('site','Logout'), 'url'=>array('/user/logout'));
		$items[] = $menuprofile;

        break;
}
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/skin.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/skin2.css');
Yii::app()->clientScript->registerCssFile('/css/font-awesome/css/font-awesome.css');

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $company = Company::getCompany();
	if($company->icon) echo '<link rel="shortcut icon" href="'.Yii::app()->getBaseUrl(/*true*/).'/'.$company->getFilesPath().'/'.$company->icon.'" type="image/x-icon">'."\n";?>
	<title><?php echo Yii::app()->controller->pageTitle;?></title>
</head>
<body>
<div class="main-menu">
			<?php
			$this->widget('application.extensions.booster.widgets.TbMenu',array(
				'justified'=>true,
				'items'=> $items,
				'type'=>'pills',
				'htmlOptions'=>array('class'=>'topMenu'),
			));
			?>
</div>
<div class="container">
	<div class="row main-header">
		<div class="header-logo"></div>
	</div>
<?php echo $content;?>

</div>
</body>
</html>
