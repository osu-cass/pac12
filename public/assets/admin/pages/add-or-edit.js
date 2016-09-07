$(document).ready(function() {
	// Show/hide the JavaScript / CSS fields
	$('.showID').change(function() {
		var $target = $('#' + $(this).data('id'));
		if (this.checked) {
			$target.show();
		} else {
			$target.hide();
		}
	}).each(function() {
		// Make sure to show/hide depending on state of checkboxes after page refresh
		$(this).trigger('change');
	});

	// Allow tabs on JavaScript / CSS fields
	$('.allowTab').keydown(function(e) {
		if(e.keyCode === 9) { // tab was pressed
			// get caret position/selection
			var start = this.selectionStart;
			var end = this.selectionEnd;

			var $this = $(this);
			var value = $this.val();

			// set textarea value to: text before caret + tab + text after caret
			$this.val(value.substring(0, start)
				+ "\t"
				+ value.substring(end));

			// put caret at right position again (add one for the tab)
			this.selectionStart = this.selectionEnd = start + 1;

			// prevent the focus lose
			e.preventDefault();
		}
	});

	// KCFinder browsing
	$('.imageBrowse').click(function() {
		var $input = $(this).parent().prev();
		window.KCFinder = {};
		window.KCFinder.callBack = function(url) {
			var base_url = config.base_url;
			base_url = base_url.substring(0, base_url.length - 1); // Remove trailing slash
			$input.val(base_url + url);
			window.KCFinder = null;
		};
		window.open('/assets/js/kcfinder/browse.php?type=images', 'image_finder', 'width=1000,height=600');
	});

	// Date / time picker
	$('.date-time').datetimepicker({
		format: 'Y-m-d H:i:00'
	});

	$('.add-module').click(function() {
		var newNumber = parseInt($('.module').last().data('num')) + 1;
		var html = '<div class="module" data-num="'+newNumber+'">'
			+ '<p><b>Module '+newNumber+'</b></p>'
			+ '<textarea class="ckeditor" name="modules['+newNumber+']" id="ckMe'+newNumber+'"></textarea>';
			+ '</div>';
		$('.modules').append(html);
		CKEDITOR.replace('ckMe'+newNumber);
	});
});