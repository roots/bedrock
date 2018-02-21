<?php

/**
 * Automatic mobile setup configuration when plugin functions are set for this
 * 
 * @since 5.0
 * @author appscreo
 * @package EasySocialShareButtons
 * 
 */

add_filter('essb4_options_extender_after_load', 'essb_setup_automatic_mobile_display');

function essb_setup_automatic_mobile_display($options) {
	
	$mobile_networks = array();
	
	$all_networks = essb_option_value('networks');
	
	foreach($all_networks as $key) {
		if ($key != 'more' && $key != 'share') {
			$mobile_networks[] = $key;
		}
	}
	
	$button_count = count($mobile_networks) <= 6 ? count($mobile_networks) : 6;	
	
	$options['mobile_positions'] = 'true';
	$options['content_position_mobile'] = '';
	$options['button_position_mobile'] = array('sharebottom');
	$options['sharebottom_activate'] = 'true';
	$options['sharebottom_template'] = '5';
	$options['sharebottom_networks'] = $mobile_networks;
	$options['mobile_sharebuttonsbar_count'] = $button_count;
	$options['mobile_css_activate'] = 'true';
	$options['mobile_css_readblock'] = 'true';
	$options['mobile_css_all'] = 'true';
	$options['mobile_css_optimized'] = 'true';
	
	return $options;
}