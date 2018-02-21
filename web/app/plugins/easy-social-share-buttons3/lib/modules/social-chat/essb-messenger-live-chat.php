<?php
/**
 * Facebook Messenger Live Chat Module for Easy Social Share Buttons for WordPress
 *
 * @package EasySocialShareButtons
 * @author appscreo
 * @version 1.0
 * @since 5.3
 */

if (!function_exists('essb_register_messenger')) {
	function essb_register_messenger() {
		
		if (is_admin() || is_feed()) { return; }
		
		$is_deactivated = false;
		$exclude_from = essb_option_value('fbmessenger_exclude');
		if (! empty ( $exclude_from )) {
			$excule_from = explode ( ',', $exclude_from );
		
			$excule_from = array_map ( 'trim', $excule_from );
			if (in_array ( get_the_ID (), $excule_from, false )) {
				$is_deactivated = true;
			}
		}
		
		if (essb_option_bool_value('fbmessender_deactivate_homepage')) {
			if (is_home() || is_front_page()) {
				$is_deactivated = true;
			}
		}
		
		if (essb_option_bool_value('fbmessenger_posttypes')) {
			$posttypes = $this->option_value('posttypes');
			if (!is_array($posttypes)) {
				$posttypes = array();
			}
				
			if (!is_singular($posttypes)) {
				$is_deactivated = true;
			}
		}
		
		// deactivate display of the functions
		if ($is_deactivated) { return; }
		
		$minimized_state = essb_option_bool_value('fbmessenger_minimized');				
		echo '<div class="fb-customerchat" page_id="'.essb_option_value('fbmessenger_pageid').'" '.($minimized_state ? 'minimized="true"' : '').'></div>';

		if (essb_option_bool_value('fbmessenger_left')) {
			echo '<style type="text/css">.fb_dialog, .fb-customerchat:not(.fb_iframe_widget_fluid) iframe { left: 18pt !important; right: auto !important; }</style>';
		}
		
		// loading Facebook API required for the function to run
		essb_resource_builder()->add_social_api('facebook');
	}
	
	add_action('wp_footer', 'essb_register_messenger');
}