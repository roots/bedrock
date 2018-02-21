jQuery(function($) {

	function runAjaxAction(button, action) {
		button = $(button);
		var panel = button.closest('.puc-debug-bar-panel');
		var responseBox = button.closest('td').find('.puc-ajax-response');

		responseBox.text('Processing...').show();
		$.post(
			ajaxurl,
			{
				action  : action,
				slug    : panel.data('slug'),
				_wpnonce: panel.data('nonce')
			},
			function(data) {
				responseBox.html(data);
			},
			'html'
		);
	}

	$('.puc-debug-bar-panel input[name="puc-check-now-button"]').click(function() {
		runAjaxAction(this, 'puc_debug_check_now');
		return false;
	});

	$('.puc-debug-bar-panel input[name="puc-request-info-button"]').click(function() {
		runAjaxAction(this, 'puc_debug_request_info');
		return false;
	});


	// Debug Bar uses the panel class name as part of its link and container IDs. This means we can
	// end up with multiple identical IDs if more than one plugin uses the update checker library.
	// Fix it by replacing the class name with the plugin slug.
	var panels = $('#debug-menu-targets').find('.puc-debug-bar-panel');
	panels.each(function(index) {
		var panel = $(this);
		var slug = panel.data('slug');
		var target = panel.closest('.debug-menu-target');

		//Change the panel wrapper ID.
		target.attr('id', 'debug-menu-target-puc-' + slug);

		//Change the menu link ID as well and point it at the new target ID.
		$('#puc-debug-menu-link-' + panel.data('slug'))
			.closest('.debug-menu-link')
			.attr('id', 'debug-menu-link-puc-' + slug)
			.attr('href', '#' + target.attr('id'));
	});
});