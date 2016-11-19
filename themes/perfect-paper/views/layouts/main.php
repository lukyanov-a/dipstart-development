<?php
/**
 * Created by PhpStorm.
 * User: coolfire
 * Date: 09.04.15
 * Time: 17:53
 */
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/style.css');
Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->language='en';
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <title>Perfect-paper</title>
	<link rel="shortcut icon" href="<?= Yii::app()->theme->baseUrl ?>/img/favicon.ico" type="image/x-icon">
    <!-- Bootstrap -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700,700italic&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container paperhelper">
    <!-- Begin header -->
    <div id="header" class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 logo"></div>
        <!-- Begin 1st column -->
        <div class="col-xs-12 col-sm-12 col-md-3">
            <?php $this->renderPartial('//layouts/user_panel');?>
        </div>
        <!-- End 1st column -->
        <!-- Begin 2nd column -->
        <div class="col-xs-12 col-sm-12 col-md-5">

            <div class="col-xs-10 col-sm-10 col-md-9 contact">
                <address style="margin-left: 50px; margin-top: 5px;">
                    E-mail:	<a href="mailto:#">perfectpaper.com@gmail.com</a><br>
                    Skype: perfect-paper<br>
					+1 (323) 984 75 11<br>
					<!--<a href="http://perfect-paper.com/site/page?view=contacts">Contact information</a><br>-->
					<a href="http://perfect-paper.com/site/page?view=disclaimer">Disclaimer</a>
                </address>
            </div>
        </div>
        <!-- End 2nd column -->
    </div>
    <!-- End header -->

    <!-- Begin menu -->
    <nav id="menu" class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responxive-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo Yii::app()->createUrl('site/index');?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/home.png"></a>
            </div>

            <div class="collapse navbar-collapse" id="responxive-menu">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'faq'));?>">FAQ</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'price'));?>">Prices</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'term'));?>">How to make an order</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'comments'));?>">Testimonials</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'why'));?>">Why choose perfect-paper?</a></li>
                </ul>
                <a class="button4 notmobileOrder" href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'order'));?>">Order now</a>
            </div>
        </div>
    </nav>
    <!-- End menu -->
    <div class="row" style="margin: 0 auto;">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a class="button4 mobileOrder" href="<?php echo Yii::app()->createUrl('site/page',array('view'=>'order'));?>">Order now</a>
        </div>
    </div>
<?php echo $content;?>
    <!-- Блок Footer -->
    <div id="footer" class="row" style="margin-top:4em;">
        <div class="col-xs-12 col-md-12" style="background-color: #c3c9cc; height: 1px; margin-bottom: 1em;"></div>
        <div class="col-xs-12 col-sm-12 col-md-2 copyright" style="padding-bottom:10px; margin-right:10px;"><span>Perfect-paper</span><br>
            @ 2010-2016. All rights reserved</div
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-2" style="padding-bottom:10px;">
                <a href="http://perfect-paper.com/site/page?view=order"><button type="button" class="btn btn-default col-xs-12 col-md-12 btn-lg alternative">To place an order</button></a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2" style="padding-bottom:10px;">
                <a href="http://perfect-paper.com/site/page?view=order"><button type="button" class="btn btn-primary btn-lg col-xs-12 col-md-12 alternative">Callback</button></a>
            </div
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 center" style="margin-bottom:1em;">
            <p style="font-size: 1em; margin-top:5px;">E-mail: <a href="mailto:#">perfectpaper.com@gmail.com</a><br>
                Skype: perfect-paper</p>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 center" style="width:210px;">
            <a href="https://plus.google.com/u/2/108384397516634127351"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/g-plus.png"></a>
            <a href="https://www.facebook.com/groups/perfectpaper/"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/facebook.png"></a>
            <a href="https://twitter.com/perfectpapercom"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/fbico.png"></a>
            <!--<a href="#"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/linkedin.png"></a>-->
        </div>
    </div>

</div>


</body>
</html>
