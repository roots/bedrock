<?php

// Register "New" admin menu bar menu
add_action('admin_bar_menu', 'ls_admin_bar', 999 );
function ls_admin_bar($wp_admin_bar) {
	$wp_admin_bar->add_node(array(
		'parent' => 'new-content',
		'id'    => 'ab-ls-add-new',
		'title' => 'LayerSlider',
		'href'  => admin_url('admin.php?page=layerslider')
	));
}

// Register sidebar menu
add_action('admin_menu', 'layerslider_settings_menu');
function layerslider_settings_menu() {

	// Menu hook
	global $layerslider_hook;

	$capability = get_option('layerslider_custom_capability', 'manage_options');
	$icon = version_compare(get_bloginfo('version'), '3.8', '>=') ? 'dashicons-images-alt2' : LS_ROOT_URL.'/static/admin/img/icon_16x16.png';

	// Add main page
	$layerslider_hook = add_menu_page(
		'LayerSlider WP', 'LayerSlider WP',
		$capability, 'layerslider', 'layerslider_router',
		$icon
	);

	// Add "All Sliders" submenu
	add_submenu_page(
		'layerslider', 'LayerSlider WP', __('All Sliders', 'LayerSlider'),
		$capability, 'layerslider', 'layerslider_router'
	);

	// Add "Skin Editor" submenu
	add_submenu_page(
		'layerslider', 'LayerSlider WP Skin Editor', __('Skin Editor', 'LayerSlider'),
		$capability, 'ls-skin-editor', 'layerslider_router'
	);

	// Add "CSS Editor submenu"
	add_submenu_page(
		'layerslider', 'LayerSlider WP CSS Editor', __('CSS Editor', 'LayerSlider'),
		$capability, 'ls-style-editor', 'layerslider_router');

	// Add "Transition Builder" submenu
	add_submenu_page(
		'layerslider', 'LayerSlider WP Transition Builder', __('Transition Builder', 'LayerSlider'),
		$capability, 'ls-transition-builder', 'layerslider_router');

	// Add "System Status" submenu
	add_submenu_page(
		'layerslider', 'LayerSlider WP System Status', __('System Status', 'LayerSlider'),
		$capability, 'ls-system-status', 'layerslider_router');

	// Add "About" submenu
	add_submenu_page(
		'layerslider', 'About LayerSlider WP', __('About', 'LayerSlider'),
		$capability, 'ls-about', 'layerslider_router');
}

// Help menu
add_filter('contextual_help', 'layerslider_help', 10, 3);
function layerslider_help($contextual_help, $screen_id, $screen) {

	if(strpos($screen->base, 'layerslider') !== false && (!empty($_GET['page']) && $_GET['page'] !== 'ls-about')) {
		$screen->add_help_tab(array(
			'id' => 'help',
			'title' => 'Getting Help',
			'content' => '<p>Please read our  <a href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html" target="_blank">Online Documentation</a> carefully, it will likely answer all of your questions.</p><p>You can also check the <a href="https://support.kreaturamedia.com/faq/4/layerslider-for-wordpress/" target="_blank">FAQs</a> for additional information, including our support policies and licensing rules.</p>'
		));
	}
}

function layerslider_router() {

	// Get current screen details
	$screen = get_current_screen();


	if(strpos($screen->base, 'ls-skin-editor') !== false) {
		include(LS_ROOT_PATH.'/views/skin_editor.php');

	} elseif(strpos($screen->base, 'ls-transition-builder') !== false) {
		include(LS_ROOT_PATH.'/views/transition_builder.php');

	} elseif(strpos($screen->base, 'ls-system-status') !== false) {
		include(LS_ROOT_PATH.'/views/system_status.php');

	} elseif(strpos($screen->base, 'ls-about') !== false) {
		if(!empty($_GET['section']) && $_GET['section'] == 'getting-started') {
			include(LS_ROOT_PATH.'/views/getting-started.php');

		} elseif(!empty($_GET['section']) && $_GET['section'] == 'faqs') {
			include(LS_ROOT_PATH.'/views/faqs.php');

		} else {
			include(LS_ROOT_PATH.'/views/about.php');
		}

	} elseif(strpos($screen->base, 'ls-style-editor') !== false) {
		include(LS_ROOT_PATH.'/views/style_editor.php');

	} elseif(isset($_GET['action']) && $_GET['action'] == 'edit') {
		include(LS_ROOT_PATH.'/views/slider_edit.php');

	} else {
		include(LS_ROOT_PATH.'/views/slider_list.php');
	}
}



?>
