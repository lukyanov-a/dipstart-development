<?php
/**
 * Created by PhpStorm.
 * User: coolfire
 * Date: 05.04.15
 * Time: 23:56
 */
	if (Yii::app()->user->isGuest) {
		$items = array();
		if (strpos($_SERVER['HTTP_X_FORWARDED_URI'],'project/chat?orderId=')){
			$items[] = array('label'=>Yii::t('site','Home'), 'url'=>array('/site/index'));
			$items[] = array('label'=>Yii::t('site','About'), 'url'=>array('/site/page', 'view'=>'about'), 'visible'=>Yii::app()->user->isGuest);
			$items[] = array('label'=>Yii::t('site','Contact'), 'url'=>array('/site/contact'), 'visible'=>Yii::app()->user->isGuest);
			$items[] = array('label'=>Yii::t('site','Login'), 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest);
			$items[] = array('label'=>Yii::t('site','Logout'). ' ('.Yii::app()->user->name.')', 'url'=>array('user/logout'), 'visible'=>!Yii::app()->user->isGuest);
			$this->menu = $items;
		};	
	};
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php $company = Company::getCompany();
	if($company->icon) echo '<link rel="shortcut icon" href="'.Yii::app()->getBaseUrl(/*true*/).'/'.$company->getFilesPath().'/'.$company->icon.'" type="image/x-icon">'."\n";?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--<meta name="description" content="{$description}" />
    <meta name="keywords" content="{$keywords}"/>-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--[if lte IE 8]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/main.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.placeholder.js"></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/main.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/skin.css" />
    <link href='http://fonts.googleapis.com/css?family=Lobster&subset=cyrillic' rel='stylesheet' type='text/css' />
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie/8.css" />
    <![endif]-->
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie/7.css" />
    <![endif]-->
    <!--<link href='/css/font-awesome/css/font-awesome.css' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700,700italic&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Quicksand&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
    <!--<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico"/>
    <link rel="icon" type="image/ico" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico"/>
    <link rel="icon" type="image/x-icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico"/>-->
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/gamma-teal-0.css" />
</head>
<?php
$bg = ''; //Фон для регистрации и авторизации
// bg0 - кабина пилота
// bg1 - мужик с ноутбуком
if ($_SERVER['SERVER_NAME']=='adco.obshya.com') {
	$bg = ' class="bg0"';
}
?>
<body<?=$bg?>>
<!--[if lt IE 7]>
<p class="browsehappy">Вы используете <strong>устаревший</strong> браузер. Пожалуйста, <a href="http://browsehappy.com/">обновите ваш браузер</a>.</p>
<![endif]-->

<!--<div class="container">-->
<?php $this->renderPartial('//layouts/header');?>

<div id="layout" class="content-clearfix" >
   <?php echo $content; ?>
</div>
<!--</div>-->
   
   <!-- FOOTER -->
<div class="modal hide" id="restorePass" style="z-index:99999999">
    <form id="FormRestorePass" method="post">
        <div class="modal-header">
            <button type="button" class="pull-right modal-close close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 style=" margin:20px 0 10px 0; "><?=UserModule::t('Restore a password') ?></h4>
            <span><?=UserModule::t('Please enter your e-mail, specified during registration and click “Send new password”') ?></span>
        </div>
        <div class="modal-body">
            <label class="grey" for="email">E-mail:</label>
            <input class="span4" type="text" name="email" id="restore_pass_email" value="" />
            <input type="hidden" name="restore_password" value="1" />
        </div>
        <div class="modal-footer">
            <label id="error_add_rega"></label>
            <input class="pull-right" type="submit" name="submit" id="do_restore_password" value="<?=UserModule::t('Send new password') ?>" class="btn" />
        </div>
    </form>
</div>


<!--JS-->
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.tinycarousel.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.slicknav.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/menu.js"></script>

<!--Мобильное меню-->
<script type="text/javascript">
    $(document).ready(function(){
        $('.main-menu').slicknav();
    });
</script><!--Запуск мобильного меню-->
<script type="text/javascript">
    $(document).ready(function()
    {
        var e = document.getElementById('slider1');
		if ((e!=null) && ((e!=undefined)))
        $('#slider1').tinycarousel();
    });
</script>
<!-- Yandex.Metrika counter -->
<?php /*<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter17979787 = new Ya.Metrika({id:17979787,
                    webvisor:true,
                    clickmap:true,
                    accurateTrackBounce:true});
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/17979787" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->*/?>
</body>
</html>
