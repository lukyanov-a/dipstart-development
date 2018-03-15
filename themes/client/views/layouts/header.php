<?php $company = Company::getCompany(); ?>
<div id="sidebar" style="height: 100%;">
	<a class="menu-button cross" href="#">
		<i><svg height="16" version="1.1" width="16" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphael 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#000000" d="M0,0L16,16M16,0L0,16" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path></svg></i>
	</a>
	<nav class="mobile">
		<?php $this->widget('application.extensions.booster.widgets.TbMenu',array(
			'items'=> $this->menu,
			'type'=>'nav',
			'htmlOptions'=>array('class'=>'userMenu'),
		));
		?>
	</nav>
</div>

<header class="header clearfix">
    <div class="row">
		<?php if($company->logo) { ?>
        <div class="logo col-xs-12 col-sm-12 col-md-3">
            <a href="/">
                <?php echo Tools::printLogo($company);?>
            </a>
        </div>
		<?php } ?>
		<div class="col-xs-12 col-sm-12 col-md-3 main-menu-button-container">
			<button id="main-menu-button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar">&nbsp;</span>
				<span class="icon-bar">&nbsp;</span>
				<span class="icon-bar">&nbsp;</span>
			</button>
		</div>
		<?php if($company->header) { ?>
        <div class="col-xs-12 col-sm-12 col-md-9 header-text">
			<?php echo $company->header;?>
        </div>
		<?php } ?>
		<div class="clear"></div>
		<div id="control-menu">
			<?php $this->widget('application.extensions.booster.widgets.TbMenu',array(
				'items'=> $this->menu,
				'type'=>'tabs',
				'htmlOptions'=>array('class'=>'userMenu'),
			));
			?>
		</div>
    </div>
</header>