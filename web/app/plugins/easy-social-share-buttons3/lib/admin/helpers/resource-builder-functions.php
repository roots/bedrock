<?php
/**
 * Build a compiled resources based on user selection
 * 
 * @param array $keys
 */
function essb_admin_build_resources($keys = array()) {
	
	$css_resources = essb_stylebuilder_css_files();
	
	$content = '';
	foreach ($keys as $key) {
		$data = isset($css_resources[$key]) ? $css_resources[$key] : array();
		$file = isset($data['file']) ? $data['file'] : '';
		
		if ($file != '') {
			$css_code = file_get_contents(ESSB3_PLUGIN_ROOT.$file);
			
			if ($key == "essb-imageshare") {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/lib/modules/social-image-share/assets/', $css_code);
			}
			if ($key == "easy-social-share-buttons-profiles" || $key == "essb-displaymethods" || $key == 'easy-social-share-buttons') {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/assets/', $css_code);
			}
			if ($key == "essb-followers") {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/', $css_code);
			}
				
			$content .= $css_code;
		}
	}
	
	$base_path = ABSPATH.'wp-content/easysocialsharebuttons-assets/';
	
	if (! is_dir ( $base_path )) {
		if (! mkdir ( $base_path, 0777 )) {
	
			return false;
		}
	
	}
	
	
	if (file_put_contents($base_path.'essb-userselection.min.css', $content)) {
		return true;
	}
	else{
		return false;
	}
}

function essb_admin_build_js_resources($keys = array()) {

	$css_resources = essb_stylebuilder_js_files();

	$content = '';
	foreach ($keys as $key) {
		$data = isset($css_resources[$key]) ? $css_resources[$key] : array();
		$file = isset($data['file']) ? $data['file'] : '';

		if ($file != '') {
			$css_code = file_get_contents(ESSB3_PLUGIN_ROOT.$file);

			$content .= $css_code;
		}
	}

	$base_path = ABSPATH.'wp-content/easysocialsharebuttons-assets/';

	if (! is_dir ( $base_path )) {
		if (! mkdir ( $base_path, 0777 )) {

			return false;
		}

	}


	if (file_put_contents($base_path.'essb-userselection.min.js', $content)) {
		return true;
	}
	else{
		return false;
	}
}