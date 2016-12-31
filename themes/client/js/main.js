jQuery(function($) {
	$('#main-menu-button').click(function(event) {
        $('body').addClass('pushed');
	});
	$('.menu-button.cross').click(function(event) {
        $('body').removeClass('pushed');
	});
});