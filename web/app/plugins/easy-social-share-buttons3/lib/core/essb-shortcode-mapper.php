<?php
/**
 * Shortcode Mapper
 * 
 * @author appsreo
 * @package EasySocialShareButtons
 * @since 4.0
 * 
 */

add_shortcode('easy-profiles', 'essb_shortcode_profiles');
add_shortcode('easy-social-like', 'essb_shortcode_native');
add_shortcode ('easy-subscribe',  'essb_shortcode_subscribe');
add_shortcode ('easy-popular-posts', 'essb_shortcode_popular_posts');

add_shortcode ( 'easy-social-share-popup', 'essb_shortcode_share_popup');
add_shortcode ( 'easy-social-share-flyin', 'essb_shortcode_share_flyin');
add_shortcode ( 'easy-total-shares', 'essb_shortcode_total_shares');
// shortcodes
add_shortcode ( 'essb', 'essb_shortcode_share');
add_shortcode ( 'easy-share', 'essb_shortcode_share');
add_shortcode ( 'easy-social-share-buttons', 'essb_shortcode_share');

add_shortcode ( 'easy-social-share', 'essb_shortcode_share_vk');

/*** shortcode functions ***/
function essb_shortcode_profiles($atts) {
	global $essb_options;
	essb_depend_load_class('ESSBCoreExtenderShortcodeProfiles', 'lib/core/extenders/essb-core-extender-shortcode-profiles.php');
	
	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-profiles', $exist_ukey);
	}
	
	return ESSBCoreExtenderShortcodeProfiles::parse_shortcode($atts, $essb_options);
}


function essb_shortcode_native($atts) {
	global $essb_options;
	essb_depend_load_class('ESSBCoreExtenderShortcodeNative', 'lib/core/extenders/essb-core-extender-shortcode-native.php');
	
	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-social-like', $exist_ukey);
	}
	
	return ESSBCoreExtenderShortcodeNative::parse_shortcode($atts, $essb_options);
}

function essb_shortcode_subscribe($atts, $content = '') {
	
	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-subscribe', $exist_ukey);
	}
	
	$mode = 'mailchimp';
	$design = '';
	$twostep = 'false';
	$twostep_inline = 'false';
	$conversion_key = 'shortcode';

	if (is_array($atts)) {
		$mode = essb_object_value($atts, 'mode');
		$design = essb_object_value($atts, 'design');
		$twostep = essb_object_value($atts, 'twostep');
		$twostep_inline = essb_object_value($atts, 'twostep_inline');
		$twostep_text = essb_object_value($atts, 'twostep_text');
		$conversion = essb_object_value($atts, 'conversion');
		
		if ($conversion != '') {
			$conversion_key = $conversion;
		}
			
		if ($content == '' && $twostep_text != '') {
			$content = $twostep_text;
		}
		
		if ($mode == '') {
			$mode = 'mailchimp';
		}
	}

	if (!class_exists('ESSBNetworks_Subscribe')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe.php');
	}
		
	if ($twostep == 'true') {
		return ESSBNetworks_Subscribe::draw_inline_subscribe_form_twostep($mode, $design, $content, $twostep_inline);
	}
	else {
		return ESSBNetworks_Subscribe::draw_inline_subscribe_form($mode, $design, false, $conversion_key);
	}
}

function essb_shortcode_popular_posts($atts) {
	
	if (!function_exists('essb_popular_posts')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/widgets/essb-popular-posts-widget-shortcode.php');		
	}
	
	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-popular-posts', $exist_ukey);
	}
	
	return essb_popular_posts_code($atts, false);
}

function essb_shortcode_share_popup($atts) {
	essb_depend_load_function('essb_shortcode_share_popup_prepare', 'lib/core/extenders/essb-shortcode-share-popup.php');
	
	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-social-share-popup', $exist_ukey);
	}
	
	$shortcode_options = essb_shortcode_share_popup_prepare($atts);
	
	return essb_shortcode_share($shortcode_options);
}

function essb_shortcode_share_flyin($atts) {
	essb_depend_load_function('essb_shortcode_share_flyin_prepare', 'lib/core/extenders/essb-shortcode-share-flyin.php');

	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-social-share-flyin', $exist_ukey);
	}
	
	$shortcode_options = essb_shortcode_share_flyin_prepare($atts);

	return essb_shortcode_share($shortcode_options);
}

function essb_shortcode_total_shares($atts) {
	global $essb_options;
	
	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-total-shares', $exist_ukey);
	}
	
	
	$network_list = essb_option_value('networks');
	if (!is_array($network_list)) { $network_list = array(); }
	essb_depend_load_class('ESSBCoreExtenderShortcodeTotalShares', 'lib/core/extenders/essb-core-extender-shortcode-totalshares.php');

	return ESSBCoreExtenderShortcodeTotalShares::parse_shortcode($atts, $essb_options, $network_list);
}

function essb_shortcode_share_vk($atts) {
	//$atts['native'] = "no";

	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-social-share', $exist_ukey);
	}
	
	$total_counter_pos = essb_object_value($atts, 'total_counter_pos');
	if ($total_counter_pos == "none") {
		$atts['hide_total'] = "yes";
	}

	$counter_pos = essb_object_value($atts, 'counter_pos');
	if ($counter_pos == "none") {
		$atts['counter_pos'] = "hidden";
	}

	return essb_shortcode_share($atts);
}

function essb_shortcode_share($atts) {
	
	$exist_ukey = isset($atts['ukey']) ? $atts['ukey'] : '';
	if ($exist_ukey != '') {
		essb_depend_load_function('essb_shortcode_ukey_options', 'lib/core/extenders/essb-shortcode-ukey.php');
		$atts = essb_shortcode_ukey_options('easy-social-share', $exist_ukey);
	}
	
	essb_depend_load_function('essb_shortcode_share_prepare', 'lib/core/extenders/essb-shortcode-share-code.php');
	return essb_shortcode_share_prepare($atts);
}