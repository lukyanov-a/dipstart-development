<br>
<h4><p><?php echo Yii::t('partner','Links for customers'); ?>:</p></h4>
<ul>
<li><?php echo Yii::t('partner','to the front page'); ?>: <code>&lt;a href="http://<?=$_SERVER['HTTP_HOST']?>/partner/redirect?pid=<?=$pid?>"&gt;<?php echo Company::getName();?>&lt;/a&gt;</code></li>
<li><?php echo Yii::t('partner','to the registation page'); ?>: <code>&lt;a href="http://<?=$_SERVER['HTTP_HOST']?>/partner/redirect?pid=<?=$pid?>&url=/user/registration"&gt;<?php echo Company::getName();?>&lt;/a&gt;</code></li>
<li><?php echo Yii::t('partner','to the order page'); ?>: <code>&lt;a href="http://<?=$_SERVER['HTTP_HOST']?>/partner/redirect?pid=<?=$pid?>&url=/project/zakaz/create"&gt;<?php echo Company::getName();?>&lt;/a&gt;</code></li>
</ul><hr>
<h4><p><?php echo Yii::t('partner','Links for executors'); ?>:</p></h4>
<ul>
<li><?php echo Yii::t('partner','to the registation page'); ?>: <code>&lt;a href="http://<?=$_SERVER['HTTP_HOST']?>/partner/redirect?pid=<?=$pid?>&url=/user/registration?role=Author"&gt;<?php echo Company::getName();?>&lt;/a&gt;</code></li>
</ul>