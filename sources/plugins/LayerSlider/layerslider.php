<?php

/*
Plugin Name: LayerSlider WP
Plugin URI: https://codecanyon.net/item/layerslider-responsive-wordpress-slider-plugin-/1362246
Description: LayerSlider is the most advanced responsive WordPress slider plugin with the famous Parallax Effect and over 200 2D & 3D transitions.
Version: 6.0.5
Author: Kreatura Media
Author URI: https://layerslider.kreaturamedia.com
Text Domain: LayerSlider
*/

if(defined('LS_PLUGIN_VERSION') || isset($GLOBALS['lsPluginPath'])) {
	die('ERROR: It looks like you already have one instance of LayerSlider installed. WordPress cannot activate and handle two instanced at the same time, you need to remove the old version first.');
}

if(!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

/********************************************************/
/*                        Actions                       */
/********************************************************/

	// Legacy, will be dropped
	$GLOBALS['lsAutoUpdateBox'] = true;

	// Basic configuration
	define('LS_DB_TABLE', 'layerslider');
	define('LS_DB_VERSION', '6.0.1');
	define('LS_PLUGIN_VERSION', '6.0.5');

	// Path info
	define('LS_ROOT_FILE', __FILE__);
	define('LS_ROOT_PATH', dirname(__FILE__));
	define('LS_ROOT_URL', plugins_url('', __FILE__));

	// Other constants
	define('LS_PLUGIN_SLUG', basename(dirname(__FILE__)));
	define('LS_PLUGIN_BASE', plugin_basename(__FILE__));
	define('LS_MARKETPLACE_ID', '1362246');
	define('LS_TEXTDOMAIN', 'LayerSlider');
	define('LS_REPO_BASE_URL', 'https://repository.kreaturamedia.com/v4/');

	if(!defined('NL')) { define("NL", "\r\n"); }
	if(!defined('TAB')) { define("TAB", "\t"); }

	// Shared
	include LS_ROOT_PATH.'/wp/scripts.php';
	include LS_ROOT_PATH.'/wp/menus.php';
	include LS_ROOT_PATH.'/wp/hooks.php';
	include LS_ROOT_PATH.'/wp/widgets.php';
	include LS_ROOT_PATH.'/wp/compatibility.php';

	include LS_ROOT_PATH.'/classes/class.ls.posts.php';
	include LS_ROOT_PATH.'/classes/class.ls.sliders.php';
	include LS_ROOT_PATH.'/classes/class.ls.sources.php';


	// Register WP shortcode
	include LS_ROOT_PATH.'/wp/shortcodes.php';
	LS_Shortcode::registerShortcode();

	// Add demo sliders and skins
	//LS_Sources::addDemoSlider(LS_ROOT_PATH.'/demos/');
	LS_Sources::addSkins(LS_ROOT_PATH.'/static/layerslider/skins/');


	// Back-end only
	if(is_admin()) {
		include LS_ROOT_PATH.'/wp/activation.php';
		include LS_ROOT_PATH.'/wp/tinymce.php';
		include LS_ROOT_PATH.'/wp/notices.php';
		include LS_ROOT_PATH.'/wp/actions.php';

	// Front-end only
	} else {

	}


	// Auto update
	if(!class_exists('KM_PluginUpdatesV3')) {
		require_once LS_ROOT_PATH.'/classes/class.km.autoupdate.plugins.v3.php';
	}

	$GLOBALS['LS_AutoUpdate'] = new KM_PluginUpdatesV3(array(
			'name' => 'LayerSlider WP',
			'repoUrl' => LS_REPO_BASE_URL,
			'root' => LS_ROOT_FILE,
			'version' => LS_PLUGIN_VERSION,
			'itemID' => LS_MARKETPLACE_ID,
			'codeKey' => 'layerslider-purchase-code',
			'authKey' => 'layerslider-authorized-site',
			'channelKey' => 'layerslider-release-channel'
		));


	// Hook to trigger plugin override functions
	add_action('after_setup_theme', 'layerslider_loaded');
	add_action('plugins_loaded', 'layerslider_load_lang');




function layerslider_load_lang() {
	load_plugin_textdomain('LayerSlider', false, LS_PLUGIN_SLUG . '/locales/' );
}


/********************************************************/
/*          WPML Layer's String Translation             */
/********************************************************/
function layerslider_register_wpml_strings($sliderID, $data) {

	if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as $slideIndex => $slide) {

			if(!empty($slide['sublayers']) && is_array($slide['sublayers'])) {
				foreach($slide['sublayers'] as $layerIndex => $layer) {
					if($layer['type'] != 'img') {
						icl_register_string('LayerSlider WP', '<'.$layer['type'].':'.substr(sha1($layer['html']), 0, 10).'> layer on slide #'.($slideIndex+1).' in slider #'.$sliderID.'', $layer['html']);
					}
				}
			}
		}
	}
}



/********************************************************/
/*                        MISC                          */
/********************************************************/

function layerslider_builder_convert_numbers(&$item, $key) {
	if(is_numeric($item)) {
		$item = (float) $item;
	}
}

function ls_ordinal_number($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    $mod100 = $number % 100;
    return $number . ($mod100 >= 11 && $mod100 <= 13 ? 'th' :  $ends[$number % 10]);
}



function layerslider_check_unit($str, $key = '') {

	if(strstr($str, 'px') == false && strstr($str, '%') == false) {
		if( $key !== 'font-weight' && $key !== 'opacity') {
			return $str.'px';
		}
	}

	return $str;
}

function layerslider_convert_urls($arr) {

	// Global BG
	if(!empty($arr['properties']['backgroundimage']) && strpos($arr['properties']['backgroundimage'], 'http://') !== false) {
		$arr['properties']['backgroundimage'] = parse_url($arr['properties']['backgroundimage'], PHP_URL_PATH);
	}

	// YourLogo img
	if(!empty($arr['properties']['yourlogo']) && strpos($arr['properties']['yourlogo'], 'http://') !== false) {
		$arr['properties']['yourlogo'] = parse_url($arr['properties']['yourlogo'], PHP_URL_PATH);
	}

	if(!empty($arr['layers'])) {
		foreach($arr['layers'] as $key => $slide) {

			// Layer BG
			if(strpos($slide['properties']['background'], 'http://') !== false) {
				$arr['layers'][$key]['properties']['background'] = parse_url($slide['properties']['background'], PHP_URL_PATH);
			}

			// Layer Thumb
			if(strpos($slide['properties']['thumbnail'], 'http://') !== false) {
				$arr['layers'][$key]['properties']['thumbnail'] = parse_url($slide['properties']['thumbnail'], PHP_URL_PATH);
			}

			// Image sublayers
			if(!empty($slide['sublayers'])) {
				foreach($slide['sublayers'] as $subkey => $layer) {
					if($layer['media'] == 'img' && strpos($layer['image'], 'http://') !== false) {
						$arr['layers'][$key]['sublayers'][$subkey]['image'] = parse_url($layer['image'], PHP_URL_PATH);
					}
				}
			}
		}
	}

	return $arr;
}
