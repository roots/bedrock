<?php
/**
 * EasySocialShareButtons CoreExtender: Shortcode
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.0
 *
 */

if (!function_exists('essb_shortcode_map_shareoptions')) {
	function essb_shortcode_map_shareoptions($post_share_details, $shortcode_options) {
		
		
		if ($shortcode_options['forceurl']) {
			$post_share_details['url'] = essb_get_current_page_url();
		}
			
		if ($shortcode_options['url'] != '') {
			$post_share_details['url'] = $shortcode_options['url'];
		}
		if ($shortcode_options['title'] != '') {
			$post_share_details['title'] = $shortcode_options['title'];
			$post_share_details['title_plain'] = $shortcode_options['title'];
		}
		if ($shortcode_options['image'] != '') {
			$post_share_details['image'] = $shortcode_options['image'];
		}
		if ($shortcode_options['description'] != '') {
			$post_share_details['description'] = $shortcode_options['description'];
		}
		
		// customize tweet message
		if ($shortcode_options['twitter_user'] != '') {
			$post_share_details['twitter_user'] = $shortcode_options['twitter_user'];
		}
		if ($shortcode_options['twitter_hashtags'] != '') {
			$post_share_details['twitter_hashtags'] = $shortcode_options['twitter_hashtags'];
		}
		if ($shortcode_options['twitter_tweet'] != '') {
			$post_share_details['twitter_tweet'] = $shortcode_options['twitter_tweet'];
		}
		else {
			if ($shortcode_options['title'] != '') {
				$post_share_details['twitter_tweet'] = $shortcode_options['title'];
			}
		}
		
		if (isset($shortcode_options['email_subject'])) {
			if ($shortcode_options['email_subject'] != '') {
				$post_share_details['mail_subject'] = $shortcode_options['email_subject'];
				$post_share_details['customized_mail'] = true;
			}
		}
		
		if (isset($shortcode_options['email_message'])) {
			if ($shortcode_options['email_message'] != '') {
				$post_share_details['mail_body'] = $shortcode_options['email_message'];
				$post_share_details['customized_mail'] = true;
			}
		}
			
		$affwp_active_shortcode = essb_option_bool_value('affwp_active_shortcode');
		if ($affwp_active_shortcode) {
			essb_depend_load_function('essb_generate_affiliatewp_referral_link', 'lib/core/integrations/affiliatewp.php');
			$post_share_details['url'] = essb_generate_affiliatewp_referral_link($post_share_details['url']);
		}
		
		$affs_active_shortcode = essb_option_bool_value('affs_active_shortcode');
		if ($affs_active_shortcode) {
			$post_share_details['url'] = do_shortcode('[affiliates_url]'.$post_share_details['url'].'[/affiliates_url]');
		}
		
		$mycred_referral_activate_shortcode = essb_option_bool_value('mycred_referral_activate_shortcode');
		if ($mycred_referral_activate_shortcode) {
			if (function_exists('mycred_render_affiliate_link')) {
				$post_share_details['url'] = mycred_render_affiliate_link( array( 'url' => $post_share_details['url'] ) );
			}
		}
				
		if (isset($shortcode_options['query'])) {
			$post_share_details['query'] = $shortcode_options['query'];
		}
			
		if (isset($shortcode_options['utm'])) {
			if ($shortcode_options['utm'] == 'yes') {
				$ga_campaign_tracking = essb_option_value('activate_ga_campaign_tracking');
				$post_ga_campaign_tracking = get_post_meta(get_the_ID(), 'essb_activate_ga_campaign_tracking', true);
				if ($post_ga_campaign_tracking != '') {
					$ga_campaign_tracking = $post_ga_campaign_tracking;
				}
					
				if ($ga_campaign_tracking != '') {
					$post_share_details['url'] = essb_attach_tracking_code($post_share_details['url'], $ga_campaign_tracking);
				}
			}
		}		
		
		return $post_share_details;
	}
}

if (!function_exists('essb_shortcode_map_visualoptions')) {
	function essb_shortcode_map_visualoptions($button_style, $shortcode_options) {
		// apply shortcode counter options
		if ($shortcode_options['counters'] == 1) {
			$button_style['show_counter'] = true;
		}
		else {
			$button_style['show_counter'] = false;
		}
			
		if (!empty($shortcode_options['style'])) {
			$button_style['button_style'] = $shortcode_options['style'];
		}
		if (!empty($shortcode_options['counters_pos'])) {
			$button_style['counter_pos'] = $shortcode_options['counters_pos'];
		}
		if (!empty($shortcode_options['total_counter_pos'])) {
			$button_style['total_counter_pos'] = $shortcode_options['total_counter_pos'];
		}
		if ($shortcode_options['hide_total']) {
			$button_style['total_counter_pos'] = "hidden";
		}
			
		if ($shortcode_options['fullwidth']) {
			$button_style['button_width'] = "full";
		
			if (!empty($shortcode_options['fullwidth_fix'])) {
				$button_style['button_width_full_button'] = $shortcode_options['fullwidth_fix'];
			}
			if (!empty($shortcode_options['fullwidth_align'])) {
				$button_style['fullwidth_align'] = $shortcode_options['fullwidth_align'];
			}
			if (!empty($shortcode_options['fullwidth_first'])) {
				$button_style['button_width_full_first'] = $shortcode_options['fullwidth_first'];
			}
			if (!empty($shortcode_options['fullwidth_second'])) {
				$button_style['button_width_full_second'] = $shortcode_options['fullwidth_second'];
			}
		}
			
		if ($shortcode_options['fixedwidth']) {
			$button_style['button_width'] = "fixed";
		
			if (!empty($shortcode_options['fixedwidth_px'])) {
				$button_style['button_width_fixed_value'] = $shortcode_options['fixedwidth_px'];
			}
			if (!empty($shortcode_options['fixedwidth_align'])) {
				$button_style['button_width_fixed_align'] = $shortcode_options['fixedwidth_align'];
			}
		}
			
		if (!empty($shortcode_options['morebutton'])) {
			$button_style['more_button_func'] = $shortcode_options['morebutton'];
		}
			
		if (!empty($shortcode_options['morebutton_icon'])) {
			
			$button_style['more_button_icon'] = $shortcode_options['morebutton_icon'];
		}
			
		if ($shortcode_options['column']) {
			$button_style['button_width'] = "column";
			if (!empty($shortcode_options['columns'])) {
				$button_style['button_width_columns'] = $shortcode_options['columns'];
			}
		}
			
		if (!empty($shortcode_options['template'])) {
			$button_style['template'] = $shortcode_options['template'];
		}
			
		if (!empty($shortcode_options['sidebar_pos'])) {
			$button_style['sidebar_pos'] = $shortcode_options['sidebar_pos'];
		}
			
		$button_style['nospace'] = $shortcode_options['nospace'];
		$button_style['nostats'] = $shortcode_options['nostats'];
			
		if (!empty($shortcode_options['animation'])) {
			$button_style['button_animation'] = $shortcode_options['animation'];
		}
			
		if (!$shortcode_options['message']) {
			$button_style['message_share_buttons'] = "";
			$button_style['message_share_before_buttons'] = "";
		}
			
		// @since 3.5 Integration with post views add-on via shortcode option
		if (!empty($shortcode_options['postviews'])) {
			$button_style['postviews'] = $shortcode_options['postviews'];
		}
		
		if ($shortcode_options['demo_counter']) {
			$button_style['demo_counter'] = $shortcode_options['demo_counter'];
		}
		
		if (!empty($shortcode_options['align'])) {
			$button_style['button_align'] = $shortcode_options['align'];
		}
		
		if ($shortcode_options['flex']) {
			$button_style['button_width'] = "flex";
		}
		if ($shortcode_options['autowidth']) {
			$button_style['button_width'] = "auto";
		}
		
		// share button style
		if (!empty($shortcode_options['sharebtn_func'])) {
			$button_style['share_button_func'] = $shortcode_options['sharebtn_func'];
		}
		if (!empty($shortcode_options['sharebtn_style'])) {
			$button_style['share_button_style'] = $shortcode_options['sharebtn_style'];
		}
		if (!empty($shortcode_options['sharebtn_icon'])) {
			$button_style['share_button_icon'] = $shortcode_options['sharebtn_icon'];
		}
		if (!empty($shortcode_options['sharebtn_counter'])) {
			$button_style['share_button_counter'] = $shortcode_options['sharebtn_counter'];
		}
		
		return $button_style;
	}
}