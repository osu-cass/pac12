$(document).ready(function() {
	$('.deleteForm').submit(function(e) {
		var message = $(this).data('confirm');
		if (!confirm(message)) e.preventDefault();
	});

	$('.noSubmitOnEnter').bind('keyup keypress', function(e) {
		var code = e.keyCode || e.which;
		if (code  == 13) {
			e.preventDefault();
			return false;
		}
	});

	$('.expandBelow').click(function() {
		var $icon = $(this).children('.glyphicon');
		if ($icon.hasClass('glyphicon-chevron-down')) {
			$icon.removeClass('glyphicon-chevron-down');
			$icon.addClass('glyphicon-chevron-up');
			$(this).next().stop().slideDown();
		} else {
			$icon.removeClass('glyphicon-chevron-up');
			$icon.addClass('glyphicon-chevron-down');
			$(this).next().stop().slideUp();
		}
	});
});