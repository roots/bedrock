<?php

/**
 * Global Plugin Setup
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.4.1
 *
 */

class ESSBGlobalSettings {
	
	public static $legacy_class = false;
	public static $counter_total_text = "";
	public static $button_counter_hidden_till = "";
	public static $mycred_group = "";
	public static $mycred_points = "";
	public static $more_button_icon = "";
	public static $comments_address = "";
	public static $use_rel_me = false;
	public static $essb_encode_text = false;
	public static $essb_encode_url = false;
	public static $essb_encode_text_plus = false;
	public static $print_use_printfriendly = false;
	public static $pinterest_sniff_disable = false;
	public static $facebookadvanced = false;
	public static $facebookadvancedappid = "";
	public static $fbmessengerapp = "";
	public static $activate_ga_campaign_tracking = "";
	public static $twitter_message_optimize = false;
	public static $sidebar_pos = "";
	
	public static $mobile_networks_active = false;
	public static $mobile_networks = array();
	public static $mobile_networks_order_active = false;
	public static $mobile_networks_order = array();
		
	public static $telegram_alternative = false;
	
	public static $cache_runtime = false;
	
	public static $subscribe_function = "";
	public static $subscribe_link = "";
	public static $subscribe_content = "";
	
	public static $use_minified_css = false;
	public static $use_minified_js = false;
	
	public static $cached_counters_cache_mode = false;
	public static $user_sort = "";
	
	public static $vkontakte_fullshare = false;
	
	public static $internal_cache = array();
	
	/**
	 * load
	 * 
	 * Load global plugin settings for single call use
	 * 
	 * @param array $options
	 * @since 3.4.1
	 */
	public static function load($options = array()) {
		self::$legacy_class = essb_options_bool_value( 'legacy_class' );
		self::$counter_total_text = essb_options_value( 'counter_total_text' );
		self::$button_counter_hidden_till = essb_options_value( 'button_counter_hidden_till' );
		self::$mycred_group = essb_options_value( 'mycred_group', 'mycred_default' );
		self::$mycred_points = essb_options_value( 'mycred_points', '1' );
		self::$more_button_icon = essb_options_value( 'more_button_icon' );
		self::$comments_address = essb_options_value( 'comments_address' );
		self::$use_rel_me = essb_options_bool_value( 'use_rel_me' );
		self::$essb_encode_text = essb_options_bool_value( 'essb_encode_text' );
		self::$essb_encode_url = essb_options_bool_value( 'essb_encode_url' );
		self::$essb_encode_text_plus = essb_options_bool_value( 'essb_encode_text_plus' );
		self::$print_use_printfriendly = essb_options_bool_value( 'print_use_printfriendly' );
		self::$pinterest_sniff_disable = essb_options_bool_value( 'pinterest_sniff_disable' );
		self::$facebookadvanced = essb_options_bool_value( 'facebookadvanced' );
		self::$facebookadvancedappid = essb_options_value( 'facebookadvancedappid' );
		self::$activate_ga_campaign_tracking = essb_options_value( 'activate_ga_campaign_tracking' );
		self::$twitter_message_optimize = essb_options_bool_value( 'twitter_message_optimize' );
		self::$sidebar_pos = essb_option_value('sidebar_pos');
		
		self::$fbmessengerapp = essb_option_value('fbmessengerapp');
		if (self::$fbmessengerapp == '') {
			self::$fbmessengerapp = self::$facebookadvancedappid;
		}
		
		self::$telegram_alternative = essb_options_bool_value('telegram_alternative');
		
		// @since 3.5 - runtime cache via WordPress functions
		self::$cache_runtime = essb_options_bool_value('essb_cache_runtime');
		
		$personalized_networks = essb_get_active_social_networks_by_position('mobile');
		$personalized_network_order = essb_get_order_of_social_networks_by_position('mobile');
		
		// added in @since 3.4.2
		if (is_array($personalized_networks) && count($personalized_networks) > 0) {
			self::$mobile_networks = $personalized_networks;
			self::$mobile_networks_active = true;
		}
		
		if (is_array($personalized_network_order) && count($personalized_network_order) > 0) {
			self::$mobile_networks_order = $personalized_network_order;
			self::$mobile_networks_order_active = true;
		}
		
		self::$subscribe_function = essb_options_value( 'subscribe_function' );
		self::$subscribe_link = essb_options_value( 'subscribe_link' );
		self::$subscribe_content = essb_options_value( 'subscribe_content' );
		
		self::$use_minified_css = essb_options_bool_value('use_minified_css');
		self::$use_minified_js = essb_options_bool_value('use_minified_js');
		
		// demo mode subscribe function
		if (isset($_REQUEST['essb_subscribe']) && ESSB3_DEMO_MODE) {
			self::$subscribe_function = $_REQUEST['essb_subscribe'];
		}
		
		self::$cached_counters_cache_mode = essb_options_bool_value('cache_counter_refresh_cache');
		self::$user_sort = essb_option_value('user_sort');
		
		self::$vkontakte_fullshare = essb_option_bool_value('vkontakte_fullshare');
	}
	
}