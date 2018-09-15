<?php

add_action('init', 'ls_register_form_actions');
function ls_register_form_actions() {

	add_action('save_post', 'layerslider_delete_caches');
	if(current_user_can(get_option('layerslider_custom_capability', 'manage_options'))) {

		// Sliders list layout
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'layout') {
			$type = ($_GET['type'] === 'list') ? 'list' : 'grid';
			update_user_meta(get_current_user_id(), 'ls-sliders-layout', $type);
			wp_redirect('admin.php?page=layerslider');
		}

		// Remove slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'remove') {
			if(check_admin_referer('remove_'.$_GET['id'])) {
				add_action('admin_init', 'layerslider_removeslider');
			}
		}

		// Restore slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'restore') {
			if(check_admin_referer('restore_'.$_GET['id'])) {
				add_action('admin_init', 'layerslider_restoreslider');
			}
		}

		// Duplicate slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'duplicate') {
			if(check_admin_referer('duplicate_'.$_GET['id'])) {
				add_action('admin_init', 'layerslider_duplicateslider');
			}
		}

		// Export slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'export') {
			if(check_admin_referer('export-sliders')) {
				$_POST['sliders'] = array( (int) $_GET['id'] );
				$_POST['ls-export'] = true;
			}
		}

		// Empty caches
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'empty_caches') {
			if(check_admin_referer('empty_caches')) {
				add_action('admin_init', 'layerslider_empty_caches');
			}
		}

		// Update Library
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'update_store') {
			if(check_admin_referer('update_store')) {
				delete_option('ls-store-last-updated');
				wp_redirect('admin.php?page=layerslider&message=updateStore');
			}
		}


		// Slider list bulk actions
		if(isset($_POST['ls-bulk-action'])) {
			if(check_admin_referer('bulk-action')) {
				add_action('admin_init', 'ls_sliders_bulk_action');
			}
		}

		// Add new slider
		if(isset($_POST['ls-add-new-slider'])) {
			if(check_admin_referer('add-slider')) {
				add_action('admin_init', 'ls_add_new_slider');
			}
		}

		// Google Fonts
		if(isset($_POST['ls-save-google-fonts'])) {
			if(check_admin_referer('save-google-fonts')) {
				add_action('admin_init', 'ls_save_google_fonts');
			}
		}

		// Advanced settings
		if(isset($_POST['ls-save-advanced-settings'])) {
			if(check_admin_referer('save-advanced-settings')) {
				add_action('admin_init', 'ls_save_advanced_settings');
			}
		}

		// Access permission
		if(isset($_POST['ls-access-permission'])) {
			if(check_admin_referer('save-access-permissions')) {
				add_action('admin_init', 'ls_save_access_permissions');
			}
		}

		// Import sliders
		if(isset($_POST['ls-import'])) {
			if(check_admin_referer('import-sliders')) {
				add_action('admin_init', 'ls_import_sliders');
			}
		}

		// Export sliders
		if(isset($_POST['ls-export'])) {
			if(check_admin_referer('export-sliders')) {
				add_action('admin_init', 'ls_export_sliders');
			}
		}

		// Custom CSS editor
		if(isset($_POST['ls-user-css'])) {
			if(check_admin_referer('save-user-css')) {
				add_action('admin_init', 'ls_save_user_css');
			}
		}

		// Skin editor
		if(isset($_POST['ls-user-skins'])) {
			if(check_admin_referer('save-user-skin')) {
				add_action('admin_init', 'ls_save_user_skin');
			}
		}

		// Transition builder
		if(isset($_POST['ls-user-transitions'])) {
			if(check_admin_referer('save-user-transitions')) {
				add_action('admin_init', 'ls_save_user_transitions');
			}
		}

		// Compatibility: convert old sliders to new data storage since 3.6
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'convert') {
			if(check_admin_referer('convertoldsliders')) {
				add_action('admin_init', 'layerslider_convert');
			}
		}

		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'hide-support-notice') {
			if(check_admin_referer('hide-support-notice')) {
				update_option('ls-show-support-notice', 0);
				header('Location: admin.php?page=layerslider');
				die();
			}
		}

		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'hide-update-notice') {
			if(check_admin_referer('hide-update-notice')) {
				$latest = get_option('ls-latest-version', LS_PLUGIN_VERSION);
				update_option('ls-last-update-notification', $latest);
				header('Location: admin.php?page=layerslider');
				die();
			}
		}


		// Create Debug Account
		if(isset($_GET['page']) && $_GET['page'] == 'ls-system-status' && isset($_GET['action']) && $_GET['action'] == 'debug_account') {
			if(check_admin_referer('debug_account')) {
				add_action('admin_init', 'ls_create_debug_account');
			}
		}


		// Erase Plugin Data
		if( isset( $_POST['ls-erase-plugin-data'] ) ) {
			if(check_admin_referer('erase_data')) {
				add_action('admin_init', 'ls_erase_plugin_data');
			}
		}


		// AJAX functions
		add_action('wp_ajax_ls_save_slider', 'ls_save_slider');
		add_action('wp_ajax_ls_import_bundled', 'ls_import_bundled');
		add_action('wp_ajax_ls_import_online', 'ls_import_online');
		add_action('wp_ajax_ls_parse_date', 'ls_parse_date');
		add_action('wp_ajax_ls_save_screen_options', 'ls_save_screen_options');
		add_action('wp_ajax_ls_get_mce_sliders', 'ls_get_mce_sliders');
		add_action('wp_ajax_ls_get_post_details', 'ls_get_post_details');
		add_action('wp_ajax_ls_get_taxonomies', 'ls_get_taxonomies');
		add_action('wp_ajax_ls_upload_from_url', 'ls_upload_from_url');
		add_action('wp_ajax_ls_store_opened', 'ls_store_opened');

	}
}


// Template store last viewed
function ls_store_opened() {
	update_user_meta(get_current_user_id(), 'ls-store-last-viewed', date('Y-m-d'));
	die();
}

function layerslider_delete_caches() {

	global $wpdb;
	$sql = "SELECT * FROM $wpdb->options
			WHERE option_name LIKE '_transient_ls-slider-data-%'
			ORDER BY option_id DESC LIMIT 100";

	if($transients = $wpdb->get_results($sql)) {
		foreach ($transients as $key => $value) {
			$key = str_replace('_transient_', '', $value->option_name);
			delete_transient($key);
		}
	}
}

function layerslider_empty_caches() {
	layerslider_delete_caches();
	wp_redirect('admin.php?page=layerslider&message=cacheEmpty');
}


function ls_add_new_slider() {
	$id = LS_Sliders::add($_POST['title']);
	header('Location: admin.php?page=layerslider&action=edit&id='.$id.'&showsettings=1');
	die();
}

function ls_sliders_bulk_action() {

	// Export
	if($_POST['action'] === 'export') {
		ls_export_sliders();


	// Remove
	} elseif($_POST['action'] === 'remove') {
		if(!empty($_POST['sliders']) && is_array($_POST['sliders'])) {
			foreach($_POST['sliders'] as $item) {
				LS_Sliders::remove( intval($item) );
				delete_transient('ls-slider-data-'.intval($item));
			}
			header('Location: admin.php?page=layerslider&message=removeSuccess'); die();
		} else {
			header('Location: admin.php?page=layerslider&message=removeSelectError&error=1'); die();
		}


	// Delete
	} elseif($_POST['action'] === 'delete') {
		if(!empty($_POST['sliders']) && is_array($_POST['sliders'])) {
			foreach($_POST['sliders'] as $item) {
				LS_Sliders::delete( intval($item));
				delete_transient('ls-slider-data-'.intval($item));
			}
			header('Location: admin.php?page=layerslider&message=deleteSuccess'); die();
		} else {
			header('Location: admin.php?page=layerslider&message=deleteSelectError&error=1'); die();
		}


	// Restore
	} elseif($_POST['action'] === 'restore') {
		if(!empty($_POST['sliders']) && is_array($_POST['sliders'])) {
			foreach($_POST['sliders'] as $item) { LS_Sliders::restore( intval($item)); }
			header('Location: admin.php?page=layerslider&message=restoreSuccess'); die();
		} else {
			header('Location: admin.php?page=layerslider&message=restoreSelectError&error=1'); die();
		}



	// Merge
	} elseif($_POST['action'] === 'merge') {

		// Error check
		if(!isset($_POST['sliders'][1]) || !is_array($_POST['sliders'])) {
			header('Location: admin.php?page=layerslider&error=1&message=mergeSelectError');
			die();
		}

		if($sliders = LS_Sliders::find($_POST['sliders'])) {
			foreach($sliders as $key => $item) {

				// Get IDs
				$ids[] = '#' . $item['id'];

				// Merge slides
				if($key === 0) { $data = $item['data']; }
				else { $data['layers'] = array_merge($data['layers'], $item['data']['layers']); }
			}

			// Save as new
			$name = 'Merged sliders of ' . implode(', ', $ids);
			$data['properties']['title'] = $name;
			LS_Sliders::add($name, $data);
		}

		header('Location: admin.php?page=layerslider&message=mergeSuccess');
		die();
	}
}

function ls_save_google_fonts() {


	// Build object to save
	$fonts = array();
	if(!empty($_POST['fontsData']) && is_array($_POST['fontsData'])) {
		foreach($_POST['fontsData'] as $key => $val) {
			if(!empty($val['urlParams'])) {
				$fonts[] = array(
					'param' => $val['urlParams'],
					'admin' => isset($val['onlyOnAdmin']) ? true : false
				);
			}
		}
	}

	// Google Fonts character sets
	array_shift($_POST['scripts']);
	update_option('ls-google-font-scripts', $_POST['scripts']);

	// Save & redirect back
	update_option('ls-google-fonts', $fonts);
	header('Location: admin.php?page=layerslider&message=googleFontsUpdated');
	die();
}


function ls_save_advanced_settings() {

	$options = array('use_cache', 'include_at_footer', 'conditional_script_loading', 'concatenate_output', 'use_custom_jquery',  'put_js_to_body');
	foreach($options as $item) {
		update_option('ls_'.$item, (int) array_key_exists($item, $_POST));
	}

	update_option('ls_scripts_priority', (int)$_POST['scripts_priority']);

	header('Location: admin.php?page=layerslider&message=generalUpdated');
	die();
}


function ls_save_screen_options() {
	$_POST['options'] = !empty($_POST['options']) ? $_POST['options'] : array();
	update_option('ls-screen-options', $_POST['options']);
	die();
}

function ls_get_mce_sliders() {

	$sliders = LS_Sliders::find(array('limit' => 50));
	foreach($sliders as $key => $item) {
		$sliders[$key]['preview'] = apply_filters('ls_preview_for_slider', $item );
		$sliders[$key]['name'] = ! empty($item['name']) ? htmlspecialchars($item['name']) : 'Unnamed';
	}

	die(json_encode($sliders));
}

function ls_save_slider() {

	// Vars
	$id 	= (int) $_POST['id'];
	$data 	= $_POST['sliderData'];

	// Security check
	if(!check_admin_referer('ls-save-slider-' . $id)) {
		return false;
	}

	// Parse slider settings
	$data['properties'] = json_decode(stripslashes(html_entity_decode($data['properties'])), true);

	// Parse slide data
	if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as $slideKey => $slideData) {

			$slideData = json_decode(stripslashes($slideData), true);

			if( ! empty( $slideData['sublayers'] ) ) {
				foreach( $slideData['sublayers'] as $layerKey => $layerData ) {

					if( ! empty( $layerData['transition'] ) ) {
						$slideData['sublayers'][$layerKey]['transition'] = addslashes($layerData['transition']);
					}

					if( ! empty( $layerData['styles'] ) ) {
						$slideData['sublayers'][$layerKey]['styles'] = addslashes($layerData['styles']);
					}
				}
			}

			$data['layers'][$slideKey] = $slideData;
		}
	}

	$title = esc_sql($data['properties']['title']);
	$slug = !empty($data['properties']['slug']) ? esc_sql($data['properties']['slug']) : '';


	// Relative URL
	if(isset($data['properties']['relativeurls'])) {
		$data = layerslider_convert_urls($data);
	}

	// WPML
	if(function_exists('icl_register_string')) {
		layerslider_register_wpml_strings($id, $data);
	}

	// Delete transient (if any) to
	// invalidate outdated data
	delete_transient('ls-slider-data-'.$id);

	// Update the slider
	if(empty($id)) {
		LS_Sliders::add($title, $data, $slug);
	} else {
		LS_Sliders::update($id, $title, $data, $slug);
	}

	die(json_encode(array('status' => 'ok')));
}


function ls_parse_date() {

	date_default_timezone_set( get_option('timezone_string') );

	if( ! preg_match("/(\d{4}-\d{2}-\d{2})/", $_GET['date'] ) ) {
		if( $date = strtotime($_GET['date']) ) {
			die(json_encode(array(
				'errorCount' => 0,
				'dateStr' => date_i18n(
						get_option('date_format').' @ '.
						get_option('time_format'),
						$date
					)
				)
			));
		}
	}

	die(json_encode(array('errorCount' => 1, 'dateStr' => '')));
}

/********************************************************/
/*               Action to duplicate slider             */
/********************************************************/
function layerslider_duplicateslider() {

	// Check and get the ID
	$id = (int) $_GET['id'];
	if(!isset($_GET['id'])) {
		return;
	}

	// Get the original slider
	$slider = LS_Sliders::find( (int)$_GET['id'] );
	$data = $slider['data'];

	// Name check
	if(empty($data['properties']['title'])) {
		$data['properties']['title'] = 'Unnamed';
	}

	// Insert the duplicate
	$data['properties']['title'] .= ' copy';
	LS_Sliders::add($data['properties']['title'], $data);

	// Success
	header('Location: admin.php?page=layerslider&message=duplicateSuccess');
	die();
}


/********************************************************/
/*                Action to remove slider               */
/********************************************************/
function layerslider_removeslider() {

	// Check received data
	if(empty($_GET['id'])) { return false; }

	// Remove the slider
	LS_Sliders::remove( intval($_GET['id']) );

	// Delete transient cache
	delete_transient('ls-slider-data-'.intval($_GET['id']));

	// Reload page
	header('Location: admin.php?page=layerslider&message=removeSuccess');
	die();
}


/********************************************************/
/*                Action to restore slider              */
/********************************************************/
function layerslider_restoreslider() {

	// Check received data
	if(empty($_GET['id'])) { return false; }

	// Remove the slider
	LS_Sliders::restore( (int) $_GET['id'] );

	// Delete transient cache
	delete_transient('ls-slider-data-'.intval($_GET['id']));

	// Reload page
	if( ! empty($_GET['ref']) ) {
		wp_safe_redirect( urldecode($_GET['ref']) );
	} else {
		wp_redirect('admin.php?page=layerslider&message=restoreSuccess');
	}

	exit;
}

/********************************************************/
/*            Actions to import sample slider            */
/********************************************************/
function ls_import_bundled() {

	// Check nonce
	if( ! check_ajax_referer('ls-import-demos', 'security') ) {
		return false;
	}

	// Get samples and importUtil
	$sliders = LS_Sources::getDemoSliders();
	include LS_ROOT_PATH.'/classes/class.ls.importutil.php';

	if( ! empty($_GET['slider']) && is_string($_GET['slider'] )) {
		if( $item = LS_Sources::getDemoSlider($_GET['slider']) ) {
			if( file_exists( $item['file'] ) ) {
				$import = new LS_ImportUtil($item['file']);
				$id = $import->lastImportId;
			}
		}
	}

	die(json_encode(array(
		'success' => !! $id,
		'slider_id' => $id,
		'url' => admin_url('admin.php?page=layerslider&action=edit&id='.$id)
	)));
}


function ls_import_online() {

	// Check nonce
	if( ! check_ajax_referer('ls-import-demos', 'security') ) {
		return false;
	}

	$slider 		= urlencode($_GET['slider']);
	$remoteURL 		= LS_REPO_BASE_URL.'sliders/download.php?slider='.$slider;

	$uploads 		= wp_upload_dir();
	$downloadPath 	= $uploads['basedir'].'/lsimport.zip';

	// Download package
	$zip = $GLOBALS['LS_AutoUpdate']->sendApiRequest( $remoteURL );

	if( ! $zip ) {
		die(json_encode(array(
			'success' => false,
			'message' => __("LayerSlider couldn't download your selected slider. Please check LayerSlider -> System Status for potential issues. The WP Remote functions may be unavailable or your web hosting provider has to allow external connections to our domain.", 'LayerSlider')
		)));
	}

	// Save package
	if( ! file_put_contents($downloadPath, $zip) ) {
		die(json_encode(array(
			'success' => false,
			'message' => __("LayerSlider couldn't save the downloaded slider on your server. Please check LayerSlider -> System Status for potential issues. The most common reason for this issue is the lack of write permission on the /wp-content/uploads/ directory.", 'LayerSlider')
		)));
	}

	// Load importUtil & import the slider
	include LS_ROOT_PATH.'/classes/class.ls.importutil.php';
	$import = new LS_ImportUtil( $downloadPath);
	$id = $import->lastImportId;

	// Remove package
	unlink( $downloadPath );

	// Success
	die(json_encode(array(
		'success' => !! $id,
		'slider_id' => $id,
		'url' => admin_url('admin.php?page=layerslider&action=edit&id='.$id)
	)));
}


// PLUGIN USER PERMISSIONS
//-------------------------------------------------------
function ls_save_access_permissions() {

	// Get capability
	$capability = ($_POST['custom_role'] == 'custom') ? $_POST['custom_capability'] : $_POST['custom_role'];

	// Test value
	if(empty($capability) || !current_user_can($capability)) {
		header('Location: admin.php?page=layerslider&error=1&message=permissionError');
		die();
	} else {
		update_option('layerslider_custom_capability', $capability);
		header('Location: admin.php?page=layerslider&message=permissionSuccess');
		die();
	}
}




// IMPORT SLIDERS
//-------------------------------------------------------
function ls_import_sliders() {

	// Check export file if any
	if(!is_uploaded_file($_FILES['import_file']['tmp_name'])) {
		header('Location: '.admin_url('admin.php?page=layerslider&error=1&message=importSelectError'));
		die('No data received.');
	}

	include LS_ROOT_PATH.'/classes/class.ls.importutil.php';
	$import = new LS_ImportUtil($_FILES['import_file']['tmp_name'], $_FILES['import_file']['name']);

	header('Location: '.menu_page_url('layerslider', 0));
	die();
}




// EXPORT SLIDERS
//-------------------------------------------------------
function ls_export_sliders( $sliderId = 0 ) {

	// Get sliders
	if( ! empty( $sliderId ) ) {
		$sliders = LS_Sliders::find( $sliderId );

	} elseif(isset($_POST['sliders'][0]) && $_POST['sliders'][0] == -1) {
		$sliders = LS_Sliders::find(array('limit' => 500));

	} elseif(!empty($_POST['sliders'])) {
		$sliders = LS_Sliders::find($_POST['sliders']);

	} else {
		header('Location: admin.php?page=layerslider&error=1&message=exportSelectError');
		die('Invalid data received.');
	}

	// Check results
	if(empty($sliders)) {
		header('Location: admin.php?page=layerslider&error=1&message=exportNotFound');
		die('Invalid data received.');
	}

	if(class_exists('ZipArchive')) {
		include LS_ROOT_PATH.'/classes/class.ls.exportutil.php';
		$zip = new LS_ExportUtil;
	}

	// Gather slider data
	foreach($sliders as $item) {

		// Gather Google Fonts used in slider
		$item['data']['googlefonts'] = $zip->fontsForSlider( $item['data'] );

		// Slider settings array for fallback mode
		$data[] = $item['data'];

		// If ZipArchive is available
		if(class_exists('ZipArchive')) {

			// Add slider folder and settings.json
			$name = empty($item['name']) ? 'slider_' . $item['id'] : $item['name'];
			$name = sanitize_file_name($name);
			$zip->addSettings(json_encode($item['data']), $name);

			// Add images?
			if(!isset($_POST['skip_images'])) {
				$images = $zip->getImagesForSlider($item['data']);
				$images = $zip->getFSPaths($images);
				$zip->addImage($images, $name);
			}
		}
	}

	if(class_exists('ZipArchive')) {
		$zip->download();
	} else {
		$name = 'LayerSlider Export '.date('Y-m-d').' at '.date('H.i.s').'.json';
		header('Content-type: application/force-download');
		header('Content-Disposition: attachment; filename="'.str_replace(' ', '_', $name).'"');
		die(base64_encode(json_encode($data)));
	}
}




// TRANSITION BUILDER
//-------------------------------------------------------
function ls_save_user_css() {

	// Get target file and content
	$upload_dir = wp_upload_dir();
	$file = $upload_dir['basedir'].'/layerslider.custom.css';

	// Attempt to save changes
	if(is_writable($upload_dir['basedir'])) {
		file_put_contents($file, stripslashes($_POST['contents']));
		header('Location: admin.php?page=ls-style-editor&edited=1');
		die();

	// File isn't writable
	} else {
		wp_die(__("It looks like your files isn't writable, so PHP couldn't make any changes (CHMOD).", "LayerSlider"), __('Cannot write to file', 'LayerSlider'), array('back_link' => true) );
	}
}





// SKIN EDITOR
//-------------------------------------------------------
function ls_save_user_skin() {

	// Error checking
	if(empty($_POST['skin']) || strpos($_POST['skin'], '..') !== false) {
		wp_die(__("It looks like you haven't selected any skin to edit.", "LayerSlider"), __('No skin selected.', 'LayerSlider'), array('back_link' => true) );
	}

	// Get skin file and contents
	$skin = LS_Sources::getSkin($_POST['skin']);
	$file = $skin['file'];

	// Attempt to write the file
	if(is_writable($file)) {
		file_put_contents($file, stripslashes($_POST['contents']));
		header('Location: admin.php?page=ls-skin-editor&skin='.$skin['handle'].'&edited=1');
	} else {
		wp_die(__("It looks like your files isn't writable, so PHP couldn't make any changes (CHMOD).", "LayerSlider"), __('Cannot write to file', 'LayerSlider'), array('back_link' => true) );
	}
}




// TRANSITION BUILDER
//-------------------------------------------------------
function ls_save_user_transitions() {

	$upload_dir = wp_upload_dir();
	$custom_trs = $upload_dir['basedir'] . '/layerslider.custom.transitions.js';
	$data = 'var layerSliderCustomTransitions = '.stripslashes($_POST['ls-transitions']).';';
	file_put_contents($custom_trs, $data);
	die('SUCCESS');
}


// --
function ls_get_post_details() {

	$params = $_POST['params'];

	$queryArgs = array(
		'post_status' => 'publish',
		'limit' => 100,
		'posts_per_page' => 100,
		'post_type' => $params['post_type']
	);

	if(!empty($params['post_orderby'])) {
		$queryArgs['orderby'] = $params['post_orderby']; }

	if(!empty($params['post_order'])) {
		$queryArgs['order'] = $params['post_order']; }

	if(!empty($params['post_categories'][0])) {
		$queryArgs['category__in'] = $params['post_categories']; }

	if(!empty($params['post_tags'][0])) {
		$queryArgs['tag__in'] = $params['post_tags']; }

	if(!empty($params['post_taxonomy']) && !empty($params['post_tax_terms'])) {
		$queryArgs['tax_query'][] = array(
			'taxonomy' => $params['post_taxonomy'],
			'field' => 'id',
			'terms' => $params['post_tax_terms']
		);
	}

	$posts = LS_Posts::find($queryArgs)->getParsedObject();

	die(json_encode($posts));
}


function ls_get_taxonomies() {
	die(json_encode(array_values(get_terms($_POST['taxonomy']))));
}


function ls_create_debug_account() {

	// Only administrators can use this function
	// with activated auto-update feature.
	if(
		! current_user_can('manage_options') ||
		! get_option('layerslider-authorized-site', false)
	 ) {
		die();
	}

	$userName = 'KreaturaSupport';

	// Check if debug account already exits
	if( $userID = username_exists( $userName ) ) {
		wp_redirect(admin_url('admin.php?page=ls-system-status&error=1&message=debugAccountError&user='.$userID));
		exit;
	}

	// Create account
	$password = wp_generate_password( 12, true );
	$userID = wp_create_user( $userName, $password );

	// Set the role
	$user = new WP_User( $userID );
	$user->set_role('administrator');

	// Message & headers
	$message = 'New debug account for site: '. get_site_url().'/wp-admin/';
	$message.= '<br><br>Username: '.$userName.'<br><br>Password: '.$password;
	$headers = array(
		'From: '.get_bloginfo('name').'<'.get_bloginfo('admin_email').'>',
		'Content-Type: text/html; charset=UTF-8'
	);

	// Email the user
	wp_mail( 'support@kreaturamedia.com', 'Debug Account', $message, $headers );
	wp_redirect(admin_url('admin.php?page=ls-system-status&message=debugAccountSuccess'));
	exit;
}


function ls_erase_plugin_data() {

	// Only administrators can use this function.
	if( ! current_user_can('manage_options') ) {
		die('You are not an administrator.');
	}

	// Check for network-wide
	if( isset( $_POST['networkwide'] ) && ! current_user_can('manage_network') ) {
		die('You are not a network admin.');
	}

	if( is_multisite() && isset( $_POST['networkwide'] ) ) {

		// Get current & other sites
		global $wpdb;
		$current = $wpdb->blogid;
		$sites 	 = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

		// Iterate over the sites
		foreach($sites as $site) {
			switch_to_blog($site);
			ls_do_erase_plugin_data();
		}

		// Switch back the old site
		switch_to_blog($current);

		// Deactivate LayerSlider network-wide
		deactivate_plugins( LS_PLUGIN_BASE, false, true );

	} else {
		ls_do_erase_plugin_data();
	}

	// Finished
	wp_redirect( admin_url('plugins.php') );
	exit;
}



function ls_do_erase_plugin_data() {

	global $wpdb;
	global $wp_filesystem;

	WP_Filesystem();

	// 1. Remove wp_layerslider DB table
	$table = $wpdb->prefix.'layerslider';
	$wpdb->query("DROP TABLE $table");

	// 2. Remove wp_option entries
	$options = array(

		// Installation
		'ls-installed',
		'ls-date-installed',
		'ls-plugin-version',
		'ls-db-version',
		'layerslider_do_activation_redirect',

		// Plugin settings
		'ls-screen-options',
		'layerslider_custom_capability',
		'ls-google-fonts',
		'ls-google-font-scripts',
		'ls_use_cache',
		'ls_include_at_footer',
		'ls_conditional_script_loading',
		'ls_concatenate_output',
		'ls_use_custom_jquery',
		'ls_put_js_to_body',

		// Updates & Services
		'ls-share-displayed',
		'ls-last-update-notification',
		'ls-show-support-notice',
		'layerslider-release-channel',
		'layerslider-authorized-site',
		'layerslider-purchase-code',
		'ls-latest-version',
		'ls-store-data',
		'ls-store-last-updated',


		// Legacy
		'ls-collapsed-boxes',
		'layerslider-validated',
		'ls-show-revalidation-notice'
	);

	foreach( $options as $key ) {
		delete_option( $key );
	}


	// 3. Remove wp_usermeta entries
	$options = array(
		'layerslider_help_wp_pointer',
		'layerslider_builder_help_wp_pointer',
		'layerslider_beta_program',
		'ls-sliders-layout',
		'ls-store-last-viewed'
	);

	foreach( $options as $key ) {
		delete_metadata('user', 0, $key, '', true);
	}



	// 4. Remove /wp-content/uploads files and folders
	$uploads 	= wp_upload_dir();
	$uploadsDir = trailingslashit($uploads['basedir']);

	foreach( glob($uploadsDir.'layerslider/*/*') as $key => $img ) {

		$imgPath  = explode( parse_url( $uploadsDir, PHP_URL_PATH ), $img );
		$attachs = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $imgPath[1] ) );

		if( ! empty( $attachs ) ) {
			foreach( $attachs as $attachID ) {
				if( ! empty($attachID) ) {
					wp_delete_attachment( $attachID, true );
				}
			}
		}
	}


	$wp_filesystem->rmdir( $uploadsDir.'layerslider', true );
	$wp_filesystem->delete( $uploadsDir.'layerslider.custom.css' );
	$wp_filesystem->delete( $uploadsDir.'layerslider.custom.transitions.js' );


	// 5. Remove debug account
	if( $userID = username_exists('KreaturaSupport') ) {
		wp_delete_user( $userID );
	}

	// 6. Deactivate LayerSlider
	deactivate_plugins( LS_PLUGIN_BASE, false, false );
}


// function ls_upload_from_url() {

// 	// Check user permission
// 	if(!current_user_can(get_option('layerslider_custom_capability', 'manage_options'))) {
// 		die(json_encode(array('success' => false)));
// 	}

// 	// Get URL & uploads folder
// 	$url = $_GET['url'];
// 	$uploads = wp_upload_dir();

// 	// Check if /uploads dir is writable
// 	if(is_writable($uploads['basedir'])) {

// 		// Set upload target
// 		$targetDir	= $uploads['basedir'].'/layerslider/cc_sdk/';
// 		$targetURL	= $uploads['baseurl'].'/layerslider/cc_sdk/';
// 		$targetExt	= pathinfo($url, PATHINFO_EXTENSION);
// 		$uploadFile	= $targetDir.time().'.'.$targetExt;

// 		// Create folder if not exists
// 		if(!file_exists(dirname($targetDir))) { mkdir(dirname($targetDir), 0755); }
// 		if(!file_exists($targetDir)) { mkdir($targetDir, 0755); }

// 		// Save image from URL
// 		$fp = fopen($uploadFile, 'w');
// 		fwrite($fp, file_get_contents($url));
// 		fclose($fp);

// 		// Include image.php for media library upload
// 		require_once(ABSPATH.'wp-admin/includes/image.php');

// 		// Get file type
// 		$fileName = sanitize_file_name(basename($uploadFile));
// 		$fileType = wp_check_filetype($fileName, null);

// 		// Validate media
// 		if(!empty($fileType['ext']) && $fileType['ext'] != 'php') {

// 			// Attachment meta
// 			$attachment = array(
// 				'guid' => $uploadFile,
// 				'post_mime_type' => $fileType['type'],
// 				'post_title' => preg_replace( '/\.[^.]+$/', '', $fileName),
// 				'post_content' => '',
// 				'post_status' => 'inherit'
// 			);

// 			// Insert and update attachment
// 			$attach_id = wp_insert_attachment($attachment, $uploadFile, 37);
// 			if($attach_data = wp_generate_attachment_metadata($attach_id, $uploadFile)) {
// 				wp_update_attachment_metadata($attach_id, $attach_data);
// 			}

// 			// Success
// 			die(json_encode(array(
// 				'success' => true,
// 				'id' => $attach_id,
// 				'url' => $targetURL.$fileName
// 			)));
// 		}
// 	}
// }