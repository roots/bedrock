<?php
/**
 * Skype Live Chat Module for Easy Social Share Buttons for WordPress
 *
 * @package EasySocialShareButtons
 * @author appscreo
 * @version 1.0
 * @since 5.3
 */

if (!function_exists('essb_skype_register')) {
	function essb_skype_register() {
		if (is_admin() || is_feed()) {
			return;
		}
		
		$is_deactivated = false;
		$exclude_from = essb_option_value('skype_exclude');
		if (! empty ( $exclude_from )) {
			$excule_from = explode ( ',', $exclude_from );
		
			$excule_from = array_map ( 'trim', $excule_from );
			if (in_array ( get_the_ID (), $excule_from, false )) {
				$is_deactivated = true;
			}
		}
		
		if (essb_option_bool_value('skype_deactivate_homepage')) {
			if (is_home() || is_front_page()) {
				$is_deactivated = true;
			}
		}
		
		if (essb_option_bool_value('skype_posttypes')) {
			$posttypes = $this->option_value('posttypes');
			if (!is_array($posttypes)) {
				$posttypes = array();
			}
		
			if (!is_singular($posttypes)) {
				$is_deactivated = true;
			}
		}
		
		// deactivate display of the functions
		if ($is_deactivated) {
			return;
		}
		
		$skype_user = essb_option_value('skype_user');
		$skype_type = essb_option_value('skype_type');
		
		if ($skype_type == '') { $skype_type = 'bubble'; }
		$skype_text = essb_option_value('skype_text');
		
		echo '<span class="skype-button '.$skype_type.'" data-contact-id="'.$skype_user.'" data-text="'.$skype_text.'"></span>
<script src="https://swc.cdn.skype.com/sdk/v1/sdk.min.js"></script>';
		
	}
	
	add_action('wp_footer', 'essb_skype_register');
}