$(document).ready(function() {
	$('#copyChecked').click(function(e) {
		if (!$('.idCheckbox:checked').length) {
			alert('You must first select at least one page to copy!');
			return;
		}
		$('#all').val(0);
		$('#copyModal').modal('show');
	});
	$('#copyAll').click(function() {
		$('#all').val(1);
	});
});