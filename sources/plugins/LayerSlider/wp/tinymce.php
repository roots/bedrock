<?php

function ls_mce_hooks() {
	if(current_user_can('edit_posts') || current_user_can('edit_pages')) {
		if(get_user_option('rich_editing')) {
			add_filter('mce_external_plugins', 'ls_register_mce_js');
			add_filter('mce_buttons_2', 'ls_register_mce_buttons');
		}
	}
}

function ls_register_mce_buttons($buttons) {
	array_push($buttons, '|', 'layerslider_button');
	return $buttons;
}

function ls_register_mce_js($plugins) {

	$plugins['layerslider_button'] = LS_ROOT_URL.'/static/admin/js/ls-admin-tinymce.js';
	return $plugins;
}

add_action('init', 'ls_mce_hooks');
