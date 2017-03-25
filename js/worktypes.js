function work_types() {
	var work_type = $("#Zakaz_specials2 option:selected").val();
	$('[data-worktypes]').hide();
	if(work_type) $('[data-worktypes~='+work_type+']').show();
	masonry();
	return false;
}
$(document).ready(function() {
	$('#Zakaz_specials2').change(function(){
		work_types();
	});
	work_types();
});