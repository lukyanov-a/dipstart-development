jQuery(function($) {
	$('#main-menu-button').click(function(event) {
        $('body').addClass('pushed');
	});
	$('.menu-button.cross').click(function(event) {
        $('body').removeClass('pushed');
	});
	
	if ($(window).width() <= '979'){
		$('header .logo').click(function(event) {
			$('.header-text').toggle('fast');
			return false;
		});
		$('header .header-text').click(function(event) {
			$('.header-text').toggle('fast');
		});
	}
});