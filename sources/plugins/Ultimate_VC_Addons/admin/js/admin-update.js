jQuery(window).load(function(e) {
	var update = jQuery(".update-plugins");
	
	var plugin_counter = update.find(".plugin-count").html();
	plugin_counter = parseInt(plugin_counter)+1;
	jQuery(".plugin-count").html(plugin_counter);
	
	update.removeClass("count-0").addClass("count-"+plugin_counter);
	update.find(".update-count").html(plugin_counter);
	jQuery("#wp-admin-bar-updates").find(".ab-label").html(plugin_counter);
	
	jQuery("#ultimate-addons-for-visual-composer").addClass("update");
	var html = '<tr class="plugin-update-tr">\
				<td colspan="3" class="plugin-update colspanchange">\
					<div class="update-message">There is a new version of Ultimate Addons for Visual Composer available. \
					<a href="update-core.php#brainstormforce-plugins">Check update details.</a>\
					</div>\
				</td>\
			</tr>';
	jQuery(html).insertAfter("#ultimate-addons-for-visual-composer");
	
});
