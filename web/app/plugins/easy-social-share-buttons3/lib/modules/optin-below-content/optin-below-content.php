<?php
/**
 * Opt-in forms display below content
 * 
 * @package EasySocialShareButtons
 * @since 5.0
 * @version 2.0
 */

if (!function_exists('essb_optin_below_content')) {

	global $essb3of_options;
	$essb3of_options = get_option ( 'essb3-of' );
	
	if (!function_exists('essb_optin_below_content_deactivated_on')) {
		function essb_optin_below_content_deactivated_on() {
			global $essb3of_options;
			
			if (is_admin()) {
				return;
			}
	
			$is_deactivated = false;
			$exclude_from = isset($essb3of_options['of_exclude']) ? $essb3of_options['of_exclude'] : '';
			if (!empty($exclude_from)) {
				$excule_from = explode(',', $exclude_from);
	
				$excule_from = array_map('trim', $excule_from);
				if (in_array(get_the_ID(), $excule_from, false)) {
					$is_deactivated = true;
				}
			}
			return $is_deactivated;
		}
	}
	
	add_filter ( 'the_content', 'essb_optin_below_content', 100);
	
	function essb_optin_below_content($content) {
		global $essb3of_options;
		
		if (essb_is_plugin_deactivated_on() || essb_optin_below_content_deactivated_on()) {
			return $content;
		}
		
		if (!is_main_query() || !in_the_loop()) {
			return $content;
		}
		
		$of_design = isset($essb3of_options['of_design']) ? $essb3of_options['of_design'] : '';
		$of_creditlink = isset($essb3of_options['of_creditlink']) ? $essb3of_options['of_creditlink'] : 'false';
		$of_posts = isset($essb3of_options['of_posts']) ? $essb3of_options['of_posts'] : 'false';
		$of_pages = isset($essb3of_options['of_pages']) ? $essb3of_options['of_pages'] : 'false';
		$of_creditlink_user = isset($essb3of_options['of_creditlink_user']) ? $essb3of_options['of_creditlink_user'] : 'appscreo';
		
		$output = '';
		$output .= "<!-- Best social sharing plugin for WordPress has optin module : http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo -->";
		
		
		if ( (is_single() && $of_posts == 'true') || (is_page() && $of_pages == 'true') ) {
			$output .= do_shortcode('[easy-subscribe design="'.$of_design.'" mode="mailchimp" conversion="belowcontent"]');
			if ($of_creditlink == 'true') {
				$output .= '<p style="font-size: 12px; text-align: center;">Powered by <a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref='.$of_creditlink_user.'" target="_blank">Best Social Sharing Plugin for WordPress</a> Easy Social Shre Buttons</p>';
			}
			
			$content .= $output ;
		}
		
		return $content;
	}
}