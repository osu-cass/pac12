$(document).ready(function() {
	//-----------------
	// Item ordering
	//-----------------
	// Drag helper to set width for table cells
	function fixHelper(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	}
	$(".linksTable tbody").sortable({
		helper: fixHelper,
		handle: '.handle',
		cancel: '',
		stop: function(e, ui) {
			// Update the orders of the menu items
			var i = 0;
			var send = false;
			ui.item.parent().children('tr').each(function() {
				var $input = $(this).find('.orderInput');
				if ($input.val() != i) {
					$input.val(i);
					send = true;
				}
				i++;
			});

			// Don't send if nothing's changed.
			if (!send) return;

			// Build our menu item orders
			var orders = {};
			$('.orderInput').each(function() {
				var id = $(this).closest('tr').data('id');
				orders[id] = $(this).val();
			});

			// Send them off
			$.post(config.base_url + "admin/menus/item-order", {orders:orders}, function(data) {
				if (data != 1) {
					alert('There was an error connecting to our servers.');
					console.log(data);
					return;
				}
			}).fail(function() {
				alert('There was an error connecting to our servers.');
			});
		}
	});

	//-----------------
	// Add link wizard
	//-----------------
	var menu_id = '';
	$(".showWizard").click(function() {
		var $td = $(this).closest('td');
		menu_id = $td.data('id');
		var order = $td.find('.linksTable tr').length;
		$('input[name="menu_id"]').val(menu_id);
		$('input[name="order"]').val(order);
	});
	$("#wizard").on('show.bs.modal', function () {
		resetModal();
	});
	$(".wizNext").click(function() {
		var $wizSlide = $(this).closest('.wizSlide');
		$wizSlide.hide().next().show();
	});

	var model = '';
	$("#modelSelect").change(function() {
		model = $(this).val();
		$(".model").html(model);
		$.post(config.base_url+"admin/menus/model-drop-down", {model:model}, function(data) {
			$("#existingModelWrap").html(data);
		}).fail(function() {
			alert('There was an error connecting to our servers.');
		});
	});
	$("#modelSelect").trigger('change');

	$('.modelType').change(function() {
		var type = $(".modelType:checked").val();
		$('#'+type+'Next').show();
		$('#'+type+'Next').siblings().hide();
		if (type == 'new') {
			$('#newNext').attr('href', linkable_models[model].add+'?menu_id='+menu_id);
		}
	});

	function resetModal() {
		$(".wizSlide").hide();
		$(".wizSlide").first().show();
		$('.modelType').first().prop('checked', true).trigger('change');
	}
	resetModal();

	//-----------------
	// Delete link
	//-----------------
	$(".deleteLink").click(function() {
		if (!confirm("Delete this link?")) return;
		var $tr = $(this).closest('tr');
		$.post(config.base_url+"admin/menus/item-delete", {id:$tr.data('id')}, function(data) {
			if (data != 1) {
				alert('There was an error connecting to our servers.');
				console.log(data);
				return;
			}
			$tr.remove();
		}).fail(function() {
			alert('There was an error connecting to our servers.');
		});
	});
});