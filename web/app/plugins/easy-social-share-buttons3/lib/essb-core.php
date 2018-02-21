<?php

/**
 * ESSB Core Component
 * 
 * @author appscreo
 * @package EasySocialShareButtons
 * @since 4.0
 *
 */

class ESSBCore {
	// options container
	private $options;
	private $design_options = array();
	private $network_options = array();
	private $button_style = array();
	private $general_options = array();
	
	private $list_of_activated_locations = array();
	private $temporary_decativated_locations = array();
	
	private $advanced_visual_on_post_off = false;
	private $initialize_mail = false;
	
	private static $instance = null;
	
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	/**
	 * Cloning disabled
	 */
	private function __clone() {
	}
	
	/**
	 * Serialization disabled
	 */
	private function __sleep() {
	}
	
	/**
	 * De-serialization disabled
	 */
	private function __wakeup() {
	}
	
	
	function __construct() {
		global $essb_options;
		$this->options = $essb_options;
		
		// load settings and defaults
		$this->load();
						
		add_action ( 'wp_enqueue_scripts', array ($this, 'register_assets' ), 1 );
		
		// @since 3.3 myEventOn fix for display buttons in widgets
		if (class_exists( 'EventON' )) {
			add_action('eventon_cal_variable_action', array($this, 'eventon_deactiate_content_filters'));
		}
	}
	
	public function get_general_options() {
		return $this->general_options;
	}
		
	public function eventon_deactiate_content_filters($args) {
		$this->temporary_deactivate_content_filters();
		
		return $args;
	}
	
	public function register_assets() {
		global $post, $essb_options;				
		
		if ($this->general_options['reset_postdata']) {
			wp_reset_postdata();
		}

		if (essb_is_plugin_deactivated_on() || essb_is_module_deactivated_on('share')) {
			$this->deactivate_stored_filter_and_actions();
			return;
		}
		
		// new since @version 4.2 - option to deactivate plugin running of share function on mobile devices
		if (essb_is_mobile() && essb_option_bool_value('deactivate_mobile_share')) {
			$this->deactivate_stored_filter_and_actions();
			return;
		}
		
		// new since @version 5 deactivate mobile on specific posts only
		if (essb_is_mobile() && essb_is_module_deactivated_on('mobile')) {
			$this->deactivate_stored_filter_and_actions();
			return;
		}
		
		$this->register_locations();
		
		$essb_post_template = '';
		$essb_post_animations = '';
		$essb_post_content_position = '';
			
		$essb_post_button_position = array();
			
		$essb_post_native = '';
		$essb_post_native_skin = '';
		
		
		// @since 3.3 - this check will be done only if the option is not turned off
		if (isset($post) && !$this->advanced_visual_on_post_off) {
			
			// @since version 3.4 - code is moved to extender to allow running in light mode
			if (class_exists('ESSBCoreExtenderPostVisualOptions')) {
				$post_visual_options = ESSBCoreExtenderPostVisualOptions::get($post, $this->general_options['button_position']);				
				
				foreach ( $post_visual_options as $single_callback_option ) {
					$param_name = $single_callback_option ['param'];
					if ($single_callback_option ['type'] == 'general_options') {
						$this->general_options [$param_name] = $single_callback_option ['value'];
					} 
					else if ($single_callback_option ['type'] == 'design_options') {
						$this->design_options [$param_name] = $single_callback_option ['value'];
					} 
					else if ($single_callback_option ['type'] == 'button_style') {
						$this->button_style [$param_name] = $single_callback_option ['value'];
					} 
					else {
						if ($param_name == 'modified_locations') {
							if ($single_callback_option ['value']) {
								//$this->deactivate_stored_filters_and_actions_by_group('button_position');
								$this->deactivate_stored_filter_and_actions('button_position');
								$this->activate_button_position_filters($this->general_options['button_position'], $this->general_options['content_position']);
							}
						}
						else if ($param_name == 'post_template') {
							$essb_post_template = $single_callback_option['value'];
						}
						else if ($param_name == 'post_animations') {
							$essb_post_animations = $single_callback_option['value'];
						}
					}
				}
				
				if (in_array('onmedia', $this->general_options['button_position']) && !defined('ESSB3_IMAGESHARE_ACTIVE')) {
					include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-image-share/essb-social-image-share.php');
					define('ESSB3_IMAGESHARE_ACTIVE', true);
					essb_manager()->factoryActivate('essbis', 'ESSBSocialImageShare');
					essb_depend_load_function('essb_rs_css_build_imageshare_customizer', 'lib/core/resource-snippets/essb_rs_css_build_imageshare_customizer.php');
				}
			}
			// end of on post visual options
		}
		
		// loading aminations
		$css_animations = essb_option_value('css_animations');
		if (!empty($essb_post_animations)) {
			$css_animations = $essb_post_animations;
		}
		
		if ($css_animations != '' && $css_animations != 'no') {
			//@since 3.5 - animations come from external css
			$animate_url = ESSB3_PLUGIN_URL.'/assets/css/essb-animations.min.css';
			essb_resource_builder()->add_static_resource($animate_url, 'easy-social-share-buttons-animations', 'css');
			essb_resource_builder()->activate_resource('animations');
		}
	
		
		$use_minifed_css = (ESSBGlobalSettings::$use_minified_css) ? '.min' : '';
		$use_minifed_js = (ESSBGlobalSettings::$use_minified_js) ? '.min' : '';

		$template_url = ESSB3_PLUGIN_URL.'/assets/css/easy-social-share-buttons'.$use_minifed_css.'.css';
		essb_resource_builder()->add_static_resource($template_url, 'easy-social-share-buttons', 'css');
		
		$core_js = ESSB3_PLUGIN_URL.'/assets/js/essb-core'.$use_minifed_js.'.js';
		essb_resource_builder()->add_static_resource($core_js, 'easy-social-share-buttons-core', 'js');
		
		// main theme CSS
		$template_id = $this->design_options['template'];
		$template_slug = essb_template_folder($template_id);
		if (!empty($essb_post_template)) {
			$template_slug = $essb_post_template;
			$this->design_options['template'] = $template_slug;
		}
		$this->design_options['template_slug'] = $template_slug;
		
		// counter script
		if ($this->button_style['show_counter']) {
			if (!defined('ESSB3_COUNTER_LOADED') && !defined('ESSB3_CACHED_COUNTERS')) {
				$script_url = ESSB3_PLUGIN_URL .'/assets/js/easy-social-share-buttons'.$use_minifed_js.'.js';
				essb_resource_builder()->add_static_resource($script_url, 'easy-social-share-buttons', 'js');
				essb_resource_builder()->activate_resource('counters');
				define('ESSB3_COUNTER_LOADED', true);
			}
		}
		
		// since 4.2 adding support for animated share counters
		//if (essb_option_bool_value('animate_single_counter') || essb_option_bool_value('animate_total_counter')) {
		//	$script_url = ESSB3_PLUGIN_URL .'/assets/js/jquery.animateNumber'.$use_minifed_js.'.js';
		//	essb_resource_builder()->add_static_resource($script_url, 'essb-counter-animate', 'js');
		//	essb_resource_builder()->activate_resource('counters_animate');
		//}
		
		$display_locations_script = false;
		
		// float from content top
		$content_postion = $this->general_options['content_position'];
		if (!empty($essb_post_content_position)) {
			$content_postion = $essb_post_content_position;
			$this->general_options['content_position'] = $content_postion;
		}
		if ($content_postion == 'content_float' || $content_postion == 'content_floatboth') {
			essb_resource_builder()->activate_resource('float');			
			$display_locations_script = true;
		}
		
		// post vertical float or sidebar
		// @since 3.5 - load styles from single file
		$display_locations_style = false;
		if (in_array('sidebar', $this->general_options['button_position']) || in_array('postfloat', $this->general_options['button_position'])) {
			$display_locations_style = true;
			essb_resource_builder()->activate_resource('sidebar');
			
			if (essb_option_value('sidebar_entry_ani') != '') {
				$display_locations_script = true;
			}
			
			if (in_array('postfloat', $this->general_options['button_position'])) {
				
				essb_resource_builder()->activate_resource('postfloat');
				$display_locations_script = true;
			}
		}

		if (in_array('topbar', $this->general_options['button_position']) || in_array('bottombar', $this->general_options['button_position'])) {
			essb_resource_builder()->activate_resource('topbottombar');
			$display_locations_style = true;
		}
		
		if (in_array('popup', $this->general_options['button_position'])) {
			$display_locations_style = true;
		}
		
		if (in_array('booster', $this->general_options['button_position'])) {
			$display_locations_style = true;
		}
		
		if (in_array('heroshare', $this->general_options['button_position'])) {
			$script_url = ESSB3_PLUGIN_URL .'/assets/js/essb-heroshare'.$use_minifed_js.'.js';
			essb_resource_builder()->add_static_resource($script_url, 'essb-heroshare', 'js', true);
			essb_resource_builder()->activate_resource('heroshare');
			$display_locations_style = true;
		}

		// @since 3.5
		// changed in 3.6 to add share point
		if (in_array('postbar', $this->general_options['button_position']) || in_array('point', $this->general_options['button_position'])) {
			if (!essb_resource_builder()->is_activated('postbar') && in_array('postbar', $this->general_options['button_position'])) {
				essb_depend_load_function('essb_rs_css_build_postbar_customizations', 'lib/core/resource-snippets/essb_rs_css_build_postbar_customizations.php');
			}
				
			$display_locations_style = true;
			essb_resource_builder()->activate_resource('postbar');
			$display_locations_script = true;			
		}
		
		
		if (in_array('flyin', $this->general_options['button_position'])) {
			$display_locations_style = true;
		}
		
		// @since 3.5
		// loading of display settings style
		if ($display_locations_style) {
			$style_url = ESSB3_PLUGIN_URL .'/assets/css/essb-display-methods'.$use_minifed_css.'.css';
			essb_resource_builder()->add_static_resource($style_url, 'easy-social-share-buttons-display-methods', 'css');
			essb_resource_builder()->activate_resource('display_positions_style');
		}
		
		$this->general_options['included_mail'] = false;
		if (in_array('mail', $this->network_options['networks'])) {
			if ($this->network_options['mail_function'] == 'form') {
				$this->general_options['included_mail'] = true;
				
				essb_resource_builder()->activate_resource('mail');

			}
		}
	}
	
	public function load() {
		global $essb_networks;
		$this->general_options['mobile_exclude_tablet'] = essb_option_bool_value('mobile_exclude_tablet');
		$this->general_options['mobile_css_activate'] = essb_option_bool_value('mobile_css_activate');
		
		// loading static resources based on current options
		$this->design_options['template'] = essb_object_value($this->options, 'style', '0');
		$this->design_options['button_style'] = essb_object_value($this->options, 'button_style', 'button');
		$this->design_options['button_align'] = essb_option_value('button_pos');
		$this->design_options['button_width'] = essb_option_value('button_width');
		$this->design_options['button_width_fixed_value'] = essb_option_value('fixed_width_value');
		$this->design_options['button_width_fixed_align'] = essb_option_value('fixed_width_align');
		$this->design_options['button_width_full_container'] = essb_option_value('fullwidth_share_buttons_container');
		$this->design_options['button_width_full_button'] = essb_option_value('fullwidth_share_buttons_correction');
		$this->design_options['button_width_Full_button_mobile'] = essb_option_value('fullwidth_share_buttons_correction');
		$this->design_options['button_width_columns'] = essb_option_value('fullwidth_share_buttons_columns');
		$this->design_options['nospace'] = essb_option_bool_value('nospace');

		$this->design_options['fullwidth_align'] = essb_option_value('fullwidth_align');
		$this->design_options['fullwidth_share_buttons_columns_align'] = essb_option_value('fullwidth_share_buttons_columns_align');		
		
		$this->design_options['sidebar_leftright_close'] = essb_option_bool_value('sidebar_leftright_close');
		
		// social network options
		$this->network_options['networks'] = essb_option_value('networks');
		if (!is_array($this->network_options['networks'])) {
			$this->network_options['networks'] = array();
		}
		
		// update since version 5 to user the saved networks - order is not needed any more
		$this->network_options['networks_order'] = essb_option_value('networks');
		//$this->network_options['networks_order'] = essb_option_value('networks_order');
		$this->network_options['more_button_func'] = essb_option_value('more_button_func');

		$this->network_options['default_names'] = array();
		foreach ($essb_networks as $key => $object) {
			$search_for = 'user_network_name_'.$key;
			$user_network_name = essb_object_value($this->options, $search_for, $object['name']);
			$this->network_options['default_names'][$key] = $user_network_name;
		}
		
		$this->network_options['twitter_shareshort'] = essb_option_bool_value('twitter_shareshort');
		$this->network_options['twitter_shareshort_service'] = essb_option_value('twitter_shareshort_service');
		$this->network_options['twitter_always_count_full'] = essb_option_bool_value('twitter_always_count_full');
		$this->network_options['twitter_user'] = essb_option_value('twitteruser');
		$this->network_options['twitter_hashtags'] = essb_option_value('twitterhashtags');
		//$this->network_options['facebook_advanced'] = essb_option_bool_value('facebookadvanced');
		//$this->network_options['facebook_advancedappid'] = essb_option_value('facebookadvancedappid');
		//$this->network_options['pinterest_sniff_disable'] = essb_option_value('pinterest_sniff_disable');
		$this->network_options['mail_disable_editmessage'] = essb_option_bool_value('mail_disable_editmessage');
		$this->network_options['mail_function'] = essb_option_value('mail_function');
		// mobile mail setting
		if (essb_is_mobile()) {
			if (!essb_option_bool_value( 'mail_popup_mobile')) {
				$this->network_options['mail_function'] = 'link';
			}
		}
		 
		$this->network_options['mail_inline_code'] = essb_option_bool_value('mail_inline_code');
		$this->network_options['mail_function_mobile'] = essb_option_value('mail_function_mobile');
		$this->network_options['use_wpmandrill'] = essb_option_bool_value('use_wpmandrill');
		$this->network_options['mail_copyaddress'] = essb_option_value('mail_copyaddress');
		$this->network_options['mail_captcha'] = essb_option_value('mail_captcha');
		$this->network_options['mail_captcha_answer'] = essb_option_value('mail_captcha_answer');
		$this->network_options['mail_subject'] = essb_object_value($this->options, 'mail_subject', '');
		$this->network_options['mail_body'] = essb_object_value($this->options, 'mail_body', '');
		$this->network_options['print_use_printfriendly'] = essb_option_bool_value('print_use_printfriendly');
		$this->network_options['stumble_noshortlink'] = essb_option_bool_value('stumble_noshortlink');
		$this->network_options['buffer_twitter_user'] = essb_option_bool_value('buffer_twitter_user');
		
		// button style options
		$this->button_style['show_counter'] = essb_option_bool_value('show_counter');
		$this->button_style['counter_pos'] = essb_option_value('counter_pos');
		$this->button_style['active_internal_counters'] = essb_option_value('active_internal_counters');
		$this->button_style['total_counter_pos'] = essb_option_value('total_counter_pos');
		
		$this->button_style['message_share_buttons'] = essb_option_value('message_above_share_buttons');
		$this->button_style['message_share_before_buttons'] = essb_option_value('message_share_before_buttons');
		$this->button_style['message_like_buttons'] = essb_option_value('message_like_buttons');
		
		// message cleaner @since 4.1 missing in @4.0
		$message_share_before_buttons_on = essb_option_value('message_share_before_buttons_on');
		if (is_array($message_share_before_buttons_on)) {
			if (essb_is_mobile() && !in_array('mobile', $message_share_before_buttons_on)) {
				$this->button_style['message_share_before_buttons'] = '';
			}
			if (essb_is_tablet() && !in_array('tablet', $message_share_before_buttons_on)) {
				$this->button_style['message_share_before_buttons'] = '';
			}
			if (!essb_is_mobile() && !essb_is_tablet() && !in_array('desktop', $message_share_before_buttons_on)) {
				$this->button_style['message_share_before_buttons'] = '';
			}				
		}

		// message cleaner @since 4.1 missing in @4.0
		$message_above_share_buttons_on = essb_option_value('message_above_share_buttons_on');
		if (is_array($message_above_share_buttons_on)) {
			if (essb_is_mobile() && !in_array('mobile', $message_above_share_buttons_on)) {
				$this->button_style['message_share_buttons'] = '';
			}
			if (essb_is_tablet() && !in_array('tablet', $message_above_share_buttons_on)) {
				$this->button_style['message_share_buttons'] = '';
			}
			if (!essb_is_mobile() && !essb_is_tablet() && !in_array('desktop', $message_above_share_buttons_on)) {
				$this->button_style['message_share_buttons'] = '';
			}
		}
		
		
		$this->general_options['total_counter_afterbefore_text'] = essb_option_value('total_counter_afterbefore_text');
		
		$this->general_options['activate_ga_campaign_tracking'] = essb_option_value('activate_ga_campaign_tracking');
		
		$this->general_options['customshare'] = essb_option_bool_value('customshare');
		$this->general_options['customshare_text'] = essb_option_value('customshare_text');
		$this->general_options['customshare_url'] = essb_option_value('customshare_url');
		$this->general_options['customshare_image'] = essb_option_value('customshare_image');
		$this->general_options['customshare_description'] = essb_option_value('customshare_description');
		
		$this->general_options['shorturl_activate'] = essb_option_bool_value('shorturl_activate');
		$this->general_options['shorturl_type'] = essb_option_value('shorturl_type');
		$this->general_options['shorturl_bitlyuser'] = essb_option_value('shorturl_bitlyuser');
		$this->general_options['shorturl_bitlyapi'] = essb_option_value('shorturl_bitlyapi');
		
		// post types where buttons are active
		$this->general_options['display_in_types'] = essb_option_value('display_in_types');
		
		$this->general_options['display_excerpt'] = essb_option_bool_value('display_excerpt');
		$this->general_options['display_excerpt_pos'] = essb_option_value('display_excerpt_pos');
		$this->general_options['display_exclude_from'] = essb_option_value('display_exclude_from');
		$this->general_options['display_include_on'] = essb_option_value('display_include_on');
		$this->general_options['display_deactivate_on'] = essb_option_value('display_deactivate_on');
		$this->general_options['deactivate_homepage'] = essb_option_bool_value('deactivate_homepage');
		
		// content and button positions
		$this->general_options['content_position'] = essb_option_value('content_position');
		
		$this->general_options['button_position'] = essb_option_value('button_position');
		if (!is_array($this->general_options['button_position'])) {
			$this->general_options['button_position'] = array();
		}
		
		if (!is_array($this->general_options['display_in_types'])) {
			$this->general_options['display_in_types'] = array();
		}
				
		// administrative options
		
		$this->general_options['total_counter_hidden_till'] = essb_option_value('total_counter_hidden_till');
		$this->general_options['button_counter_hidden_till'] = essb_option_value('button_counter_hidden_till');
		
		// that settings need to be added to plugin settings
		$this->general_options['reset_postdata'] = essb_option_bool_value('reset_postdata');
		$this->general_options['reset_posttype'] = essb_option_bool_value('reset_posttype');
		$this->general_options['metabox_visual'] = essb_option_bool_value('metabox_visual');
		$this->general_options['using_yoast_ga'] = essb_option_bool_value('using_yoast_ga');
		$this->general_options['scripts_in_head'] = essb_option_bool_value('scripts_in_head');
		
		// cleaner
		$this->general_options['apply_clean_buttons'] = essb_option_bool_value('apply_clean_buttons');
		$this->general_options['apply_clean_buttons_method'] = essb_option_value('apply_clean_buttons_method');
		
		// custom buttons priority
		$this->general_options['priority_of_buttons'] = essb_object_value($this->options, 'priority_of_buttons', '10');
		$this->general_options['priority_of_buttons'] = intval($this->general_options['priority_of_buttons']);
		if ($this->general_options['priority_of_buttons'] == 0) {
			$this->general_options['priority_of_buttons'] = 10;
		}
 		
		
		// apply mobile options for content positions
		if ($this->general_options['mobile_css_activate']) {
			if ($this->is_mobile_safecss()) {
				$user_set_mobile = essb_option_value('button_position_mobile' );
				
				if (!is_array($user_set_mobile)) {
					$user_set_mobile = array();
				}				
				
				if (in_array('sharebottom', $user_set_mobile)) {
					$this->general_options ['button_position'][] = 'sharebottom';
				}
				if (in_array('sharebar', $user_set_mobile)) {
					$this->general_options ['button_position'][] = 'sharebar';
				}
				if (in_array('sharepoint', $user_set_mobile)) {
					$this->general_options ['button_position'][] = 'sharepoint';
				}
				
			}
		}
		else {
			if (essb_is_mobile ()) {
				if (essb_option_bool_value('mobile_positions' )) {
					$this->general_options ['content_position'] = essb_option_value('content_position_mobile' );
					$this->general_options ['button_position'] = essb_option_value('button_position_mobile' );
					if (! is_array ( $this->general_options ['button_position'] )) {
						$this->general_options ['button_position'] = array ();
					}
				}
				
				if (ESSB3_DEMO_MODE) {
					$demo_mode_mobile = isset ( $_REQUEST ['mobile'] ) ? $_REQUEST ['mobile'] : '';
					if (! empty ( $demo_mode_mobile )) {
						$this->general_options ['button_position'] = array ();
						$this->general_options ['button_position'] [] = $demo_mode_mobile;
					}
				}
			}
		}
		
		$this->advanced_visual_on_post_off = essb_option_bool_value('turnoff_essb_advanced_box');
		
		// @since 3.4 - in light mode advanced_visual_on_post_off is true by default
		if (defined('ESSB3_LIGHTMODE')) {
			$this->advanced_visual_on_post_off = true;
		}
		
		if (!$this->advanced_visual_on_post_off) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-postvisual.php');
		}
	}
	
	public function activate($type, $hook, $function, $priority = '', $position = '') {
		if ($type == 'filter') {
			add_filter($hook, array($this, $function), $priority);
		}
		else {
			add_action($hook, array($this, $function), $priority);
		}
		$this->list_of_activated_locations[] = array('type' => $type, 'hook' => $hook, 'function' => $function, 'priority' => $priority, 'position' => $position);
	}
	
	public function register_locations() {
		global $post;
		
		if (is_admin()) {
			return;
		}
		
		if ($this->general_options['reset_postdata']) {
			wp_reset_postdata();
		}
		
		// @since version 3.1 CSS hide of mobile buttons
		$mobile_css_activate = essb_option_bool_value('mobile_css_activate');
		if ($mobile_css_activate) {
			//essb_resource_builder()->add_css(ESSBResourceBuilderSnippets::css_build_mobile_compatibility(), 'essb-mobile-compatibility');
			essb_depend_load_function('essb_rs_css_build_mobile_compatibility', 'lib/core/resource-snippets/essb_rs_css_build_mobile_compatibility.php');
		}
		
		$this->list_of_activated_locations = array();
		
		$current_post_content_locations = $this->general_options['content_position'];
		$current_post_button_position = $this->general_options['button_position'];
		
		
		// different button placement by post type is only avaiable in full interface
		if (!defined('ESSB3_LIGHTMODE')) {
			$positions_by_pt = essb_option_bool_value('positions_by_pt');
			if ($positions_by_pt && isset($post)) {
				$current_post_type = $post->post_type;
				
				$content_position_by_pt = essb_option_value('content_position_'.$current_post_type);
				$button_position_by_pt = essb_option_value('button_position_'.$current_post_type);
							
				if (!empty($content_position_by_pt)) {
					$current_post_content_locations = $content_position_by_pt;
					$this->general_options['content_position'] = $content_position_by_pt;
				}
				
				if (is_array($button_position_by_pt)) {
					if (count($button_position_by_pt) > 0) {
						
						if (is_array($this->general_options['button_position'])) {
							if (in_array('sharebottom', $this->general_options['button_position'])) {
								$button_position_by_pt[] = 'sharebottom';
							}
							if (in_array('sharebar', $this->general_options['button_position'])) {
								$button_position_by_pt[] = 'sharebar';
							}
							if (in_array('sharepoint', $this->general_options['button_position'])) {
								$button_position_by_pt[] = 'sharepoint';
							}
						}
						
						$current_post_button_position = $button_position_by_pt;
						$this->general_options['button_position'] = $button_position_by_pt;
					}	
				}
			}
		}
		
		if ($current_post_content_locations != '' && $current_post_content_locations != 'content_manual') {
			$this->activate('filter', 'the_content', 'display_inline', $this->general_options['priority_of_buttons'], 'content_position');
			
			if (essb_option_bool_value('using_elementor')) {
				$this->activate('action', 'elementor/frontend/the_content', 'display_inline', $this->general_options['priority_of_buttons'], 'content_position');
			}
		}
		
		
		$this->activate_button_position_filters($current_post_button_position, $this->general_options['content_position']);
		
		// excerpt display
		if ($this->general_options['display_excerpt']) {
			
			// @since verion 3.0.4 - build in Avada theme bridge
			if (class_exists('FusionCore_Plugin')) {
				// detected Avada theme
				if ($this->general_options['display_excerpt_pos'] == 'top') {
					$this->activate('action', 'fusion_blog_shortcode_loop_content', 'display_excerpt_avada', $this->general_options['priority_of_buttons'], '');
						
					$this->activate('action', 'avada_blog_post_content', 'display_excerpt_avada', '1', '');
						
				}
				else {
					$this->activate('action', 'fusion_blog_shortcode_loop_footer', 'display_excerpt_avada', $this->general_options['priority_of_buttons'], '');
						
					$this->activate('action', 'avada_blog_post_content', 'display_excerpt_avada', '20', '');
						
				}
			}
			else {
				$this->activate('filter', 'the_excerpt', 'display_excerpt', $this->general_options['priority_of_buttons'], 'excerpt_position');
			}
		}
		
		// clean buttons 
		if ($this->general_options['apply_clean_buttons']) {

			if ($this->general_options['apply_clean_buttons_method'] == 'actionremove') {
				add_filter( 'get_the_excerpt', array( $this, 'remove_buttons_excerpts_method2'), -999);
			}
			else if ($this->general_options['apply_clean_buttons_method'] == 'remove2') {
				// do nothing
			}
			else {
				if ($this->general_options['apply_clean_buttons_method'] == 'clean2') {
					add_filter( 'get_the_excerpt', array( $this, 'remove_buttons_excerpts_method3'));
				}
				else {
					add_filter( 'get_the_excerpt', array( $this, 'remove_buttons_excerpts'));
				}
			}
		}
		
		if (!defined('ESSB3_LIGHTMODE')) {
			// additional module integraton hooks
			//-- WooCommerce
			
			// refactor in version 4.2 for on demand code load
			if (essb_option_bool_value('woocommece_share') || essb_option_bool_value('woocommerce_after_add_to_cart_form') ||
					essb_option_bool_value('woocommece_beforeprod') || essb_option_bool_value('woocommece_afterprod')) {
				
				essb_depend_load_function('essb_woocommerce_activate', 'lib/core/integrations/woocommerce.php');
				essb_woocommerce_activate();
			}
			
			//-- WP eCommerce
			if (essb_option_bool_value('wpec_before_desc') || essb_option_bool_value('wpec_after_desc') ||
					essb_option_bool_value('wpec_theme_footer')) {
			
				essb_depend_load_function('essb_wpecommerce_activate', 'lib/core/integrations/wpecommerce.php');
				essb_wpecommerce_activate();
			}
			
	
			// JigoShop
			if (essb_option_bool_value('jigoshop_top') || essb_option_bool_value('jigoshop_bottom')) {
					
				essb_depend_load_function('essb_jigoshop_activate', 'lib/core/integrations/jigoshop.php');
				essb_jigoshop_activate();
			}
			
	
			// BBPress
			if (essb_option_bool_value('bbpress_forum') || essb_option_bool_value('bbpress_topic')) {
					
				essb_depend_load_function('essb_bbpress_activate', 'lib/core/integrations/bbpress.php');
				essb_bbpress_activate();
			}			
			
			// iThemes Exchange
			if (essb_option_bool_value('ithemes_after_title') || essb_option_bool_value('ithemes_before_desc') || 
					essb_options_bool_value('ithemes_after_desc') || essb_options_bool_value('ithemes_after_desc') ||
					essb_options_bool_value('ithemes_after_product')) {
					
				essb_depend_load_function('essb_ithemes_activate', 'lib/core/integrations/ithemes.php');
				essb_ithemes_activate();
			}
			// BuddyPress
			if (essb_option_bool_value('buddypress_group') || essb_option_bool_value('buddypress_activity')) {
					
				essb_depend_load_function('essb_buddypress_activate', 'lib/core/integrations/buddypress.php');
				essb_buddypress_activate();
			}			
		}
	}
	
	function remove_buttons_excerpts_method2($text) {		
		remove_filter( 'the_content', array( $this, 'display_inline' ), $this->general_options['priority_of_buttons']);
		remove_filter( 'the_content', array( $this, 'display_postfloat' ));
		remove_filter( 'the_content', array( $this, 'trigger_bottom_mark' ), 9999 );
		remove_filter( 'the_content', array( $this, 'display_onmedia' ), 9999 );
		
		return $text;
	}
	
	function remove_buttons_excerpts($text) {
		if (!function_exists('essb_excerpt_clean_method1')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-excerpt-clean-method1.php');				
		}
		
		return essb_excerpt_clean_method1($text, $this->options, $this->network_options['networks'], $this->network_options['default_names']);
		
	}
	
	function remove_buttons_excerpts_method3($text) {
		
		if (!function_exists('essb_excerpt_clean_method3')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-excerpt-clean-method3.php');				
		}
		
		return essb_excerpt_clean_method3($text, $this->options, $this->network_options['networks'], $this->network_options['default_names']);
		
	}
	
	
	function reactivate_content_filters_after_temporary_deactivate() {
		if (is_admin()) {
			return;
		}
		
		foreach ($this->temporary_decativated_locations as $hook_data) {
			$type = isset($hook_data['type']) ? $hook_data['type'] : 'filter';
			$hook = isset($hook_data['hook']) ? $hook_data['hook'] : 'the_content';
			$action = isset($hook_data['function']) ? $hook_data['function'] : '';
			$priority = isset($hook_data['priority']) ? $hook_data['priority'] : '';
			$position = isset($hook_data['position']) ? $hook_data['position'] : '';
		
			if ($hook != 'the_content' && $hook != 'the_excerpt') {
				continue;
			}
		
			if ($hook != '' && $action != '') {
				$this->activate($type, $hook, $action, $priority, $position);
			}
		}
		
		$this->temporary_decativated_locations = array();
	}
	
	function temporary_deactivate_content_filters() {
		$this->temporary_decativated_locations = array();
		
		if (is_admin()) {
			return;
		}
		
		foreach ($this->list_of_activated_locations as $hook_data) {
			$type = isset($hook_data['type']) ? $hook_data['type'] : 'filter';
			$hook = isset($hook_data['hook']) ? $hook_data['hook'] : 'the_content';
			$action = isset($hook_data['function']) ? $hook_data['function'] : '';
			$priority = isset($hook_data['priority']) ? $hook_data['priority'] : '';
			$position = isset($hook_data['position']) ? $hook_data['position'] : '';
				
			if ($hook != 'the_content' && $hook != 'the_excerpt') {
				continue;
			}
		
			if ($hook != '' && $action != '') {
				if ($type == 'filter') {
					if (!empty($priority)) {
						remove_filter($hook, array($this, $action), $priority);
					}
					else {
						remove_filter($hook, array($this, $action));
					}
		
				}
				if ($type == 'action') {
					if (!empty($priority)) {
						remove_action($hook, array($this, $action), $priority);
					}
					else {
						remove_action($hook, array($this, $action));
					}
				}
			}
			
			$this->temporary_decativated_locations[] = $hook_data;
		}
	}
	
	function activate_button_position_filters($current_post_button_position, $current_post_content_position = '') {
		//$current_post_button_position = $this->general_options['button_position'];
		if (is_array($current_post_button_position)) {
			foreach ($current_post_button_position as $position) {
				if (method_exists($this, 'display_'.$position)) {
					if ($position == 'postfloat') {
						$this->activate('filter', 'the_content', 'display_postfloat', '', 'button_position');
						$this->activate('filter', 'the_content', 'trigger_bottom_mark', '9999', 'button_position');
						
						if (essb_option_bool_value('using_elementor')) {
							$this->activate('filter', 'elementor/frontend/the_content', 'display_postfloat', '', 'button_position');
							$this->activate('filter', 'elementor/frontend/the_content', 'trigger_bottom_mark', '9999', 'button_position');
						}
					}
					else if ($position == 'onmedia') {
						$this->activate('filter', 'the_content', 'display_onmedia', '9999', 'button_position');
					}
					else {
		
						if ($position == 'popup' && essb_option_bool_value( 'popup_display_comment')) {
							$this->activate('filter', 'comment_post_redirect', 'after_comment_trigger', '', 'button_position');
								
						}
		
						if ($position == 'flyin' && essb_option_bool_value('flyin_display_comment')) {
							$this->activate('filter', 'comment_post_redirect', 'after_comment_trigger', '', 'button_position');
								
						}
		
						if ($position == 'popup' && essb_option_bool_value('popup_display_purchase')) {
							//woocommerce_thankyou
							$this->activate('action', 'woocommerce_thankyou', 'display_popup', '', 'button_position');
								
						}
						
						if ($position == 'postbar') {
							$this->activate('filter', 'the_content', 'trigger_postbar_readbar', '', 'button_position');
							if (essb_option_bool_value('using_elementor')) {
								$this->activate('filter', 'elementor/frontend/the_content', 'trigger_postbar_readbar', '', 'button_position');
							}
						}						
						
						$this->activate('filter', 'the_content', 'trigger_bottom_mark', '9999', 'button_position');
						$this->activate('action', 'wp_footer', "display_{$position}", '', 'button_position');
						if (essb_option_bool_value('using_elementor')) {
							$this->activate('filter', 'elementor/frontend/the_content', 'trigger_bottom_mark', '9999', 'button_position');
						}
					}
				}
			}
		}
		
		if ($current_post_content_position == 'content_followme') {
			$this->activate('action', 'wp_footer', 'display_followme', '', 'button_position');
		}
	}
	
	
	function deactivate_stored_filter_and_actions($group_filter = '') {
		if (is_admin()) {
			return;
		}
		
		foreach ($this->list_of_activated_locations as $hook_data) {
			$type = isset($hook_data['type']) ? $hook_data['type'] : 'filter';
			$hook = isset($hook_data['hook']) ? $hook_data['hook'] : 'the_content';
			$action = isset($hook_data['function']) ? $hook_data['function'] : '';
			$priority = isset($hook_data['priority']) ? $hook_data['priority'] : '';			
			$position = isset($hook_data['position']) ? $hook_data['position'] : '';
			
			if ($group_filter != '') {
				if ($group_filter != $position || empty($position)) {
					continue;
				}
			}
			
			if ($hook != '' && $action != '') {
				if ($type == 'filter') {
					if (!empty($priority)) {
						remove_filter($hook, array($this, $action), $priority);
					}
					else {
						remove_filter($hook, array($this, $action));
					}
						
				}
				if ($type == 'action') {
					if (!empty($priority)) {
						remove_action($hook, array($this, $action), $priority);
					}
					else {
						remove_action($hook, array($this, $action));
					}
				}
			}
		}
	}
	
	function check_applicability($post_types = array(), $location = '') {
		global $post;
		
		// @since 3.4.2 - check to ensure buttons will not appear in feed or search
		if (is_search() || is_feed()) { return false; }

		$current_active_post_type = '';
		if ($this->general_options['reset_posttype'] && isset($post)) {
			$current_active_post_type = isset($post->post_type) ? $post->post_type : '';
 		}
		
		if ($this->general_options['reset_postdata']) {
			wp_reset_postdata();
		}	
		
		// @since 3.0
		// another check to avoid buttons appear on unwanted post types
		
		$is_exclusive_active = false;
		if (isset($post)) {
			$is_exclusive_active = essb_is_plugin_activated_on();
		}
		
		if ($this->general_options['reset_posttype'] && !empty($current_active_post_type)) {
			if (!in_array($current_active_post_type, $post_types)) {
				if (!$is_exclusive_active) {
					return false;
				}
			}
		}
		
		if ($this->general_options['apply_clean_buttons']) {
			if ($this->general_options['apply_clean_buttons_method'] == 'remove2') {
				if (!is_main_query() || !in_the_loop()) {
					return false;
				}
			}
		}
		
		if (essb_option_bool_value('essb_avoid_nonmain')) {
			if (!is_main_query() || !in_the_loop()) {
				return false;
			}
		}

		$is_all_lists = in_array('all_lists', $post_types);
		$is_set_list = count($post_types) > 0 ?  true: false;
		
		unset($post_types['all_lists']);
		$is_lists_authorized = (is_archive() || is_front_page() || is_search() || is_tag() || is_post_type_archive() || is_home()) && $is_all_lists ? true : false;
		$is_singular = is_singular($post_types);
		if ($is_singular && !$is_set_list) {
			$is_singular = false;
		}
		
		if ($this->general_options['deactivate_homepage']) {
			if (is_home() || is_front_page()) {
				$is_lists_authorized = false;
				$is_singular = false;
			}
		}
		

		if ($this->general_options['display_exclude_from'] != '') {
			$excule_from = explode(',', $this->general_options['display_exclude_from']);
			
			$excule_from = array_map('trim', $excule_from);
			
			if (in_array(get_the_ID(), $excule_from, false)) {
				$is_singular = false;
				$is_lists_authorized = false;
			}
		}
		
		if (essb_is_module_deactivated_on('share')) {
			$is_singular = false;
			$is_lists_authorized = false;
		}
		
		// additional plugin hacks
		$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		if ($request_uri != '') {
			$exist_ai1ec_export = strpos($request_uri, 'ai1ec_exporter_controller');
			if ($exist_ai1ec_export !== false) {
				$is_singular = false; $is_lists_authorized = false;
			}
				
			$exist_tribe_cal = strpos($request_uri, 'ical=');
			if ($exist_tribe_cal !== false) {
				$is_singular = false; $is_lists_authorized = false;
			}
		}
		
		// check post meta for turned off
		$essb_off = get_post_meta(get_the_ID(),'essb_off',true);
		
		if ($essb_off == 'true') {
			$is_lists_authorized = false;
			$is_singular = false;
		}
				
		// deactivate on mobile devices if selected
		if (essb_is_mobile()) {
			if (essb_option_bool_value($location.'_mobile_deactivate')) {
				$is_singular = false;
				$is_lists_authorized = false;
			}
		}
		
		if (essb_is_tablet()) {
			if (essb_option_bool_value($location.'_tablet_deactivate')) {
				$is_singular = false;
				$is_lists_authorized = false;
			}
		}
		
		if ($is_exclusive_active) {
			$is_singular = true;
		}
		
		// check current location settings
		if ($is_singular || $is_lists_authorized) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function check_applicability_excerpt($post_types = array(), $location = '') {
		
		if (!function_exists('essb_check_applicability_excerpt')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-check-applicability-excerpt.php');
		}
		
		return essb_check_applicability_excerpt($post_types, $location, $this->options, $this->general_options);
	}
	
	// -- additional plugin special integration hooks
	
	
	function after_comment_trigger( $location ){

		$newurl = $location;
	
		if (essb_option_bool_value('popup_display_comment') || essb_option_bool_value('flyin_display_comment')) {
			$newurl = substr( $location, 0, strpos( $location, '#comment' ) );
			$delimeter = false === strpos( $location, '?' ) ? '?' : '&';
			$params = 'essb_popup=true';
	
			$newurl .= $delimeter . $params;
		}
	
		return $newurl;
	}
	
	function trigger_postbar_readbar($content) {
		return '<div class="essb_postbar_start"></div>'.$content.'<div class="essb_postbar_end"></div>';
	}
	
	function trigger_bottom_mark($content) {
		$deactivate_trigger = false;
		$deactivate_trigger = apply_filters('essb5_remove_bottom_mark', $deactivate_trigger);
		
		if ($deactivate_trigger) {
			return $content;
		}
		else {
			return $content.'<div class="essb_break_scroll"></div>';
		}	
	}	
	
	function display_booster() {
		$post_types = $this->general_options['display_in_types'];
		$is_valid = $this->check_applicability($post_types, 'booster');
	
		$output = '';
	
		if ($is_valid) {
			essb_depend_load_function('essb5_generate_booster', 'lib/core/display-methods/essb-display-method-booster.php');
	
			$share_buttons = $this->generate_share_buttons('booster');
			$output .= essb5_generate_booster($share_buttons);
		}
	
		echo $output;
	}
	
	function display_cornerbar() {
		$post_types = $this->general_options['display_in_types'];
		$is_valid = $this->check_applicability($post_types, 'cornerbar');
	
		$output = '';
	
		if ($is_valid) {
			essb_depend_load_function('essb5_generate_corner_bar', 'lib/core/display-methods/essb-display-method-cornerbar.php');
				
			$share_buttons = $this->generate_share_buttons('cornerbar');
			$output .= essb5_generate_corner_bar($share_buttons);
		}
	
		echo $output;
	}
	
	function display_followme() {
		$post_types = $this->general_options['display_in_types'];
		$is_valid = $this->check_applicability($post_types, 'followme');
		
		$output = '';
		
		if ($is_valid) {
			$share_buttons = $this->generate_share_buttons('followme');
			
			essb_depend_load_function('essb5_generate_followme_bar', 'lib/core/display-methods/essb-display-method-followme.php');
			
			$output .= essb5_generate_followme_bar($share_buttons);
		}
		
		echo $output;
	}
	
	/**
	 * display_point
	 * 
	 * Generate share point code
	 * 
	 * @param unknown_type $is_shortcode
	 * @param unknown_type $shortcode_options
	 * @param unknown_type $share_options
	 */
	function display_point($is_shortcode = true, $shortcode_options = array(), $share_options = array()) {
		global $post;
		
		$post_types = $this->general_options['display_in_types'];
		
		$is_valid = false;
		if ($is_shortcode) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'point');
		
			// post share bar cannot work on list of posts
			if (!is_single () && !is_page ()) {
				$is_valid = false;
				
				if (essb_option_bool_value('point_allowall')) {
					$is_valid = true;
				}
			}
		}
		
		
		$output = '';
		
		if ($is_valid) {
		
			if (!class_exists('ESSBDisplayMethodPoint')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-point.php');
			}
				
			$post_details = essb_get_post_share_details('point');
			
			$share_buttons = '';
			$total_shares_code = essb_shortcode_total_shares(array('inline' => 'yes', 'url' => $post_details['url']));
				
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('point', 'share', array('only_share' => true));
			}
			else {
				$share_buttons = $this->generate_share_buttons('point', 'share', $share_options, true, $shortcode_options);
			}
				
			// Helper class to generate post share bar
			$output = ESSBDisplayMethodPoint::generate_point_code($this->options, $share_buttons, $total_shares_code, $is_shortcode, $shortcode_options);
				
			// when it is not a shortcode we output the generated markup
			if (!$is_shortcode) {
				print $output;
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	/**
	 * display_postbar
	 * 
	 * Generate social post bar display method
	 * 
	 * @param bool $is_shortcode
	 * @param array $shortcode_options
	 * @param array $share_options
	 * @since 3.5
	 */
	function display_postbar($is_shortcode = true, $shortcode_options = array(), $share_options = array()) {
		global $post;
		
		$post_types = $this->general_options['display_in_types'];
	
		$is_valid = false;
		if ($is_shortcode) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'postbar');
				
			// post share bar cannot work on list of posts
			if (!is_single () && !is_page ()) {
				$is_valid = false;
			}
		}
	
		
		$output = '';
		
		if ($is_valid) {


			if (!class_exists('ESSBDisplayMethodPostBar')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-postbar.php');				
			}
			
			$share_buttons = '';
			$total_shares_code = essb_shortcode_total_shares(array('inline' => 'yes'));
			
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('postbar');
			}
			else {
				$share_buttons = $this->generate_share_buttons('postbar', 'share', $share_options, true, $shortcode_options);
			}
			
			// Helper class to generate post share bar
			$output = ESSBDisplayMethodPostBar::generate_postbar_code($this->options, $share_buttons, $total_shares_code);
			
			// when it is not a shortcode we output the generated markup
			if (!$is_shortcode) {
				print $output;
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	
	function display_sharebottom($is_shortcode = false, $shortcode_options = array(), $share_options = array()) {
		if (!$this->is_mobile_safecss()) { return; }
		$post_types = $this->general_options['display_in_types'];
		
		$is_valid = false;
		
		$hide_on_end = essb_option_bool_value('mobile_sharebuttonsbar_hideend');
		$hide_on_end_percent = essb_option_value('mobile_sharebuttonsbar_hideend_percent');
		$mobile_sharebuttonsbar_showscroll = essb_option_value('mobile_sharebuttonsbar_showscroll');
		$hide_before_end = ' data-hideend="'.($hide_on_end ? "true":"false").'" data-hideend-percent="'.$hide_on_end_percent.'" data-show-percent="'.$mobile_sharebuttonsbar_showscroll.'"';
		$mobile_sharebuttonsbar_pos = essb_option_value('mobile_sharebuttonsbar_pos');
		if ($this->general_options['mobile_css_activate']) {
			$hide_before_end .= ' data-responsive="true"';
		}
		
		$output = '';
		
		$css_hidden_load = '';
		if (intval($mobile_sharebuttonsbar_showscroll) > 0) {
			$css_hidden_load = ' essb-mobile-break';
		}
		if ($mobile_sharebuttonsbar_pos == 'top') {
			$css_hidden_load .= ' essb-mobile-sharetop';
		}
		
		if ($is_shortcode == true) {
			$is_valid = true;
		} 
		else {
			$is_valid = $this->check_applicability($post_types, 'sharebottom');
		}
		
		if ($is_valid) {
			if (!$is_shortcode) {
				$sharebuttons_code = $this->generate_share_buttons('sharebottom');
				
				$bar_bg = essb_option_value('sharebottom_usercontent_bg');
				if ($bar_bg != '') {
					$bar_bg = ' style="background-color:'.$bar_bg.';"';
				}
				
				$bar_hidden = '';
				$bar_controled = '';
				if (essb_option_bool_value('sharebottom_usercontent_control')) {
					$bar_hidden = ' essb-mobile-break';
					$bar_controled = ' data-connected="true"';
				}
				
				if ($mobile_sharebuttonsbar_pos != 'top' && essb_option_bool_value('sharebottom_adarea') && essb_option_value('sharebottom_usercontent') != '') {
					$bottombar_usercontent = essb_option_value('sharebottom_usercontent');
					$bottombar_usercontent = stripslashes($bottombar_usercontent);
					$bottombar_usercontent = do_shortcode($bottombar_usercontent);
					
					$sharebuttons_code .= '<div class="adholder"'.$bar_bg.'>'.$bottombar_usercontent.'</div>';
				}
				
				printf('<div class="essb-mobile-sharebottom%3$s"%2$s>%1$s</div>', $sharebuttons_code, $hide_before_end, $css_hidden_load);
				
				if ($mobile_sharebuttonsbar_pos == 'top' && essb_option_bool_value('sharebottom_adarea') && essb_option_value('sharebottom_usercontent') != '') {
					$bottombar_usercontent = essb_option_value('sharebottom_usercontent');
					$bottombar_usercontent = stripslashes($bottombar_usercontent);
					$bottombar_usercontent = do_shortcode($bottombar_usercontent);
					echo '<div class="adholder essb-adholder-bottom'.$bar_hidden.'"'.$bar_bg.$bar_controled.'>'.$bottombar_usercontent.'</div>';
				}
			}
			else {
				$sharebuttons_code = $this->generate_share_buttons('sharebottom', 'share', $share_options, true, $shortcode_options);
				
				if ($mobile_sharebuttonsbar_pos != 'top' && essb_option_bool_value('sharebottom_adarea') && essb_option_value('sharebottom_usercontent') != '') {
					
					$bottombar_usercontent = essb_option_value('sharebottom_usercontent');
					$bottombar_usercontent = stripslashes($bottombar_usercontent);
					$bottombar_usercontent = do_shortcode($bottombar_usercontent);
					
					$sharebuttons_code .= '<div class="adholder"'.$bar_bg.'>'.$bottombar_usercontent.'</div>';
				}
				
				$output = sprintf('<div class="essb-mobile-sharebottom%3$s"%2$s>%1$s</div>', $sharebuttons_code, $hide_before_end, $css_hidden_load);

				if ($mobile_sharebuttonsbar_pos == 'top' && essb_option_bool_value('sharebottom_adarea') && essb_option_value('sharebottom_usercontent') != '') {
					
					$bottombar_usercontent = essb_option_value('sharebottom_usercontent');
					$bottombar_usercontent = stripslashes($bottombar_usercontent);
					$bottombar_usercontent = do_shortcode($bottombar_usercontent);
					
					$output .= '<div class="adholder essb-adholder-bottom'.$bar_hidden.'"'.$bar_bg.$bar_controled.'>'.$bottombar_usercontent.'</div>';
				}
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	function display_sharebar($is_shortcode = false, $shortcode_options = array(), $share_options = array()) {
		if (!$this->is_mobile_safecss()) {
			return;
		}
		$post_types = $this->general_options['display_in_types'];
		
		$is_valid = false;
		
		if ($is_shortcode == true) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'sharebar');
		}
		
		$output = '';
		if ($is_valid) {
			
			if (!class_exists('ESSBDisplayMethodMobile')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-mobile.php');
			}

			$share_buttons = '';
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('sharebar');
			}
			else {
				$share_buttons = $this->generate_share_buttons('sharebar', 'share', $share_options, true, $shortcode_options);
			}
			
			$output = ESSBDisplayMethodMobile::generate_sharebar_code($this->options, $share_buttons, $is_shortcode, $shortcode_options);
			
			if (!$is_shortcode) {
				echo $output;
			}			
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	
	function display_sharepoint($is_shortcode = false, $shortcode_options = array(), $share_options = array()) {
		if (!$this->is_mobile_safecss()) {
			return;
		}
		$post_types = $this->general_options['display_in_types'];
	
		$is_valid = false;
		
		if ($is_shortcode == true) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'sharepoint');
		}
		
		$output = '';
		
		if ($is_valid) {
				
			if (!class_exists('ESSBDisplayMethodMobile')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-mobile.php');
			}
			
			$share_buttons = '';
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('sharepoint');
			}
			else {
				$share_buttons = $this->generate_share_buttons('sharepoint', 'share', $share_options, true, $shortcode_options);
			}
			$output = ESSBDisplayMethodMobile::generate_sharepoint_code($this->options, $share_buttons, $is_shortcode, $shortcode_options);
			
			if (!$is_shortcode) {
				echo $output;
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	function display_topbar ($is_shortcode = false, $shortcode_options = array(), $share_options = array()) {
		$post_types = $this->general_options['display_in_types'];
		
		$is_valid = false;
		
		if ($is_shortcode == true) {
			$is_valid = true;
		} 
		else {
			$is_valid = $this->check_applicability($post_types, 'topbar');
		}
		
		$output = '';
		
		if ($is_valid) {
			
			if (!class_exists('ESSBDisplayMethodTopBar')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-topbar.php');
			}
			
			$share_buttons = '';
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('topbar');
			}
			else {
				$share_buttons = $this->generate_share_buttons('topbar', 'share', $share_options, true, $shortcode_options);
			}
			
			$output = ESSBDisplayMethodTopBar::generate_topbar_code($this->options, $share_buttons, $is_shortcode, $shortcode_options);
			
			if (!$is_shortcode) {
				echo $output;
			}
			
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	function display_bottombar ($is_shortcode = false, $shortcode_options = array(), $share_options = array()) {
		$post_types = $this->general_options['display_in_types'];
	
		$is_valid = false;
		if ($is_shortcode) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'bottombar');
		}
		
		$output = '';
		
		if ($is_valid) {
			
			if (!class_exists('ESSBDisplayMethodBottomBar')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-bottombar.php');
			}
			
			$share_buttons = '';
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('bottombar');
			}
			else {
				$share_buttons = $this->generate_share_buttons('bottombar', 'share', $share_options, true, $shortcode_options);
			}
				
			$output = ESSBDisplayMethodBottomBar::generate_bottombar_code($this->options, $share_buttons, $is_shortcode, $shortcode_options);
				
			if (!$is_shortcode) {
				echo $output;
			}
			
		}
	
		if ($is_shortcode) {
			return $output;
		}
	}
	
	function display_sidebar($is_shortcode = false, $shortcode_options = array(), $share_options = array()) {
		$post_types = $this->general_options['display_in_types'];
		
		
		$is_valid = false;
		if ($is_shortcode) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'sidebar');
		}
		
		$output = '';
				
		if ($is_valid) {
			if (!$is_shortcode) {
				$output .= $this->generate_share_buttons('sidebar');
			}
			else {
				$output .= $this->generate_share_buttons('sidebar', 'share', $share_options, true, $shortcode_options);
			}
		
			if (!$is_shortcode) {
				echo $output;
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}

	function display_heroshare($is_shortcode = true, $shortcode_popafter = '', $shortcode_options = array(), $share_options = array()) {
		$post_types = $this->general_options['display_in_types'];
		
		$is_valid = false;
		if ($is_shortcode) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'heroshare');
			
			// hero share cannot work on list of posts
			if (!is_single () && !is_page ()) {
				$is_valid = false;
			}
		}
		
		// @since 3.0.4 - avoid display popup for logged in users
		$popup_avoid_logged_users = essb_option_bool_value('heroshare_avoid_logged_users');
		if ($popup_avoid_logged_users) {
			if (is_user_logged_in()) {
				$is_valid = false;
			}
		}
		
		if ($is_valid) {
			
			if (!class_exists('ESSBDisplayMethodHeroShare')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-heroshare.php');
			}
						
			if (ESSB3_DEMO_MODE) {
				$is_active_option = isset($_REQUEST['heroshare']) ? $_REQUEST['heroshare'] : '';
				if (!empty($is_active_option)) {
					$popup_second_type = $is_active_option;
				}
				
				$is_active_option = isset($_REQUEST['heroshare_title']) ? $_REQUEST['heroshare_title'] : '';
				if (!empty($is_active_option)) {
					$popup_second_title = $is_active_option;
				}
			}
			
			
			$post_details = essb_get_post_share_details('heroshare');
			
			$share_buttons = '';				
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('heroshare');
			}
			else {
				$share_buttons = $this->generate_share_buttons('heroshare', 'share', $share_options, true, $shortcode_options);
			}
			
			$output = ESSBDisplayMethodHeroShare::generate_heroshare_code($this->options, $share_buttons, $is_shortcode, $shortcode_options, $post_details);
			
			if (!$is_shortcode) {
				echo $output;
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	function display_popup($is_shortcode = true, $shortcode_popafter = '', $shortcode_options = array(), $share_options = array()) {
		$post_types = $this->general_options['display_in_types'];
	
		$is_valid = false;
		if ($is_shortcode) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'popup');
		}
		
		// @since 3.0.4 - avoid display popup for logged in users
		$popup_avoid_logged_users = essb_option_bool_value('popup_avoid_logged_users');
		if ($popup_avoid_logged_users) {
			if (is_user_logged_in()) {
				$is_valid = false;
			}
		}
		
		$output = '';
		
		if ($is_valid) {
			
			if (!class_exists('ESSBDisplayMethodPopup')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-popup.php');
			}
			
			$share_buttons = '';
			
			if (!$is_shortcode) {
				$share_buttons = $this->generate_share_buttons('popup');
			}
			else {
				$share_buttons = $this->generate_share_buttons('popup', 'share', $share_options, true, $shortcode_options);
			}
			
			$output = ESSBDisplayMethodPopup::generate_popup_code($this->options, $share_buttons, $is_shortcode, $shortcode_options);
			
			if (!$is_shortcode) {
				echo $output;
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}
	
	function display_flyin($is_shortcode = false, $shortcode_options = array(), $share_options = array()) {
		$post_types = $this->general_options['display_in_types'];
		
		$is_valid = false;
		if ($is_shortcode) {
			$is_valid = true;
		}
		else {
			$is_valid = $this->check_applicability($post_types, 'flyin');
		}
		
		$output = '';
	
		if ($is_valid) {
			
			if (!class_exists('ESSBDisplayMethodFlyin')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/display-methods/essb-display-method-flyin.php');
			}

			$share_buttons = '';
			
			if (!$is_shortcode) {
				$flyin_noshare = essb_option_bool_value( 'flyin_noshare');
				if (!$flyin_noshare) {
					$share_buttons = $this->generate_share_buttons('flyin');
				}
			}
			else {
				$share_buttons = $this->generate_share_buttons('flyin', 'share', $share_options, true, $shortcode_options);
			}
				
			$output = ESSBDisplayMethodFlyin::generate_flyin_code($this->options, $share_buttons, $is_shortcode, $shortcode_options);
			
			if (!$is_shortcode) {
				echo $output;
			}
		}
		
		if ($is_shortcode) {
			return $output;
		}
	}	
	
	function shortcode_display_postfloat($shortcode_options = array(), $share_options = array()) {
		$display_key = 'postfloat';
		$float_onsingle_only = essb_option_bool_value('float_onsingle_only');
		if ($float_onsingle_only) {
			if (is_archive() || is_front_page() || is_search() || is_tag() || is_post_type_archive() || is_home()) {
				$display_key = 'top';
			}
		}
		
		return $this->generate_share_buttons($display_key, 'share', $share_options, true, $shortcode_options);
	}
	
	function display_postfloat($content) {
		//
		$links_before = '';
		$links_after = '';
		
		$display_key = 'postfloat';
		$float_onsingle_only = essb_option_bool_value('float_onsingle_only');
		if ($float_onsingle_only) {
			if (is_archive() || is_front_page() || is_search() || is_tag() || is_post_type_archive() || is_home()) {
				$display_key = 'top';
			}
		}
		
		$post_types = $this->general_options['display_in_types'];
		if ($this->check_applicability($post_types, $display_key)) {
			$links_before = $this->generate_share_buttons($display_key);
		}
		
		return $links_before.$content;
	}
	
	function display_excerpt($content) {
		$post_types = $this->general_options['display_in_types'];
		
		$links_before = '';
		$links_after = '';
		
		//print "is possible on excerpt: ".$this->check_applicability($post_types, 'excerpt');
		
		if ($this->check_applicability_excerpt($post_types, 'excerpt')) {
			
			if ($this->general_options['display_excerpt_pos'] == 'top') {
				$links_before = $this->generate_share_buttons('excerpt');
			}
			if ($this->general_options['display_excerpt_pos'] == 'bottom') {
				$links_after = $this->generate_share_buttons('excerpt');
			}
			
		}
		return $links_before.$content.$links_after;
	}
	
	function display_excerpt_avada() {
		echo $this->generate_share_buttons('excerpt');
	}
	
	function display_inline($content) {
		$links_before = '';
		$links_after = '';
				
		$post_types = $this->general_options['display_in_types'];
		$content_position = $this->general_options['content_position'];
		$check_location_options_top = '';
		$check_location_options_bottom = '';
		if ($content_position == 'content_top' || $content_position == 'content_both' || $content_position == 'content_sharenative') {			
			if ($this->check_applicability($post_types, 'top')) {

				$share_buttons_only = ($content_position == 'content_sharenative') ? true : false;
				
				$links_before = $this->generate_share_buttons('top', 'share', array('only_share' => $share_buttons_only));
			}
		}
		
		if ($content_position == 'content_float' || $content_position == 'content_floatboth') {
			
			$display_key = 'float';
			$float_onsingle_only = essb_option_bool_value('float_onsingle_only');
			if ($float_onsingle_only) {
				if (is_archive() || is_front_page() || is_search() || is_tag() || is_post_type_archive() || is_home()) {
					$display_key = 'top';
				}
			}
			
			if ($this->check_applicability($post_types, $display_key)) {
				$links_before = $this->generate_share_buttons($display_key);
			}
		}
		
		if ($content_position == 'content_bottom' || $content_position == 'content_both' || $content_position == 'content_nativeshare' || $content_position == 'content_floatboth') {
		
			if ($this->check_applicability($post_types, 'bottom')) {
				$share_buttons_only = ($content_position == 'content_nativeshare') ? true : false;
				$links_after = $this->generate_share_buttons('bottom', 'share', array('only_share' => $share_buttons_only));
			}
		}
		
		if ($content_position == 'content_nativeshare') {
			if ($this->check_applicability($post_types, 'top')) {
				$links_before = $this->generate_like_buttons('top');
			}
		}

		if ($content_position == 'content_sharenative') {
			if ($this->check_applicability($post_types, 'bottom')) {
				$links_after = $this->generate_like_buttons('bottom');
			}
		}
		
		
		if ($content_position == 'content_followme') {
			$appear_at = essb_option_value('followme_content');
			
			if ($appear_at == '' || $appear_at == 'above') {
				if ($this->check_applicability($post_types, 'followme')) {
					$links_before = $this->generate_share_buttons('followme');
				}
			}

			if ($appear_at == '' || $appear_at == 'below') {
				if ($this->check_applicability($post_types, 'followme')) {
					$links_after = $this->generate_share_buttons('followme');
				}
			}
		}
		
		return $links_before.$content.$links_after;
	}
 	
	// -- end: content display methods
	
	// start: buttons drawer
	
	function generate_like_buttons($position) {
		if (!function_exists('essb_generate_like_buttons')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-likebuttons.php');				
		}
		
		return essb_generate_like_buttons($position);
	}
	
	function generate_share_buttons($position, $likeshare = 'share', $share_options = array(), $is_shortcode = false, $shortcode_options = array(), $media_url = '') {
		global $post;
						
		//return "";
		//timer_start();
		
		// @since 3.5 - runtime cache
		$cache_key_runtime = '';
		if (ESSBGlobalSettings::$cache_runtime) {
			if (isset($post) && !$is_shortcode) {
				$cache_key_runtime = sprintf('essb_cache_share_%1$s_%2$s', $post->ID, $position);
				
				$cached_data = wp_cache_get( $cache_key_runtime );
				if ( false !== $cached_data ) {
					return $cached_data;
				}
			}
		}
		
		$only_share = essb_option_bool_value('only_share', $share_options);
		$post_type = essb_option_value('post_type', $share_options);
		$user_based_post_type = $post_type;
		
		// @since 3.6 AMP support 
		$amp_sharing = essb_option_bool_value('amp', $share_options);

		if ($this->general_options['reset_postdata']) {
			wp_reset_postdata();
		}
		
		$cache_key = '';
		
		if (isset($post) && defined('ESSB3_CACHE_ACTIVE') && !$is_shortcode) {
			$cache_key = sprintf('essb_cache_share_%1$s_%2$s', $post->ID, $position);
			
			$cached_data = ESSBDynamicCache::get($cache_key);
			if (!empty($cached_data)) {
				return $cached_data;
			}
		}		
		
		if (empty($post_type) && isset($post)) {
			$post_type = $post->post_type;
			
			if (!empty($user_based_post_type)) {
				$post_type = $user_based_post_type;
			}
		}		
		
		// -- getting main share details based on current post
		$post_share_details = essb_get_post_share_details($position);
		
		// generate native button main settings
		$post_native_details = essb_get_native_button_settings($position, $only_share);		
		$post_native_details['order'] = ($post_native_details['active']) ? ESSBNativeButtonsHelper::active_native_buttons() : array();
		
		// apply shortcode options
		if ($is_shortcode) {
			essb_depend_load_function('essb_shortcode_map_shareoptions', 'lib/core/extenders/essb-core-extender-shortcode.php');
						
			$post_share_details = essb_shortcode_map_shareoptions($post_share_details, $shortcode_options);
		}
		else {
			// activate short url and custom campaign tracking codes
			// apply custom share options
			if (!empty($share_options['url'])) {
				$post_share_details['url'] = $share_options['url'];
			}
			if (!empty($share_options['title'])) {
				$post_share_details['title'] = $share_options['title'];
				$post_share_details['title_plain'] = $share_options['title_plain'];
			}
			if (!empty($share_options['image'])) {
				$post_share_details['image'] = $share_options['image'];
			}
			if (!empty($share_options['description'])) {
				$post_share_details['description'] = $share_options['description'];
			}
			
			// customize tweet message
			if (!empty($share_options['twitter_user'])) {
				$post_share_details['twitter_user'] = $share_options['twitter_user'];
			}
			if (!empty($share_options['twitter_hashtags'])) {
				$post_share_details['twitter_hashtags'] = $share_options['twitter_hashtags'];
			}
			if (!empty($share_options['twitter_tweet'])) {
				$post_share_details['twitter_tweet'] = $share_options['twitter_tweet'];
			}
				
			if ($media_url != '') {
				$post_share_details['image'] = $media_url;
				$post_share_details['user_image_url'] = $media_url;
			}
			
			if (!defined('ESSB3_LIGHTMODE')) {
				// Google Campaign Tracking code
				$ga_campaign_tracking = $this->general_options['activate_ga_campaign_tracking'];
				$post_ga_campaign_tracking = get_post_meta(get_the_ID(), 'essb_activate_ga_campaign_tracking', true);
				if ($post_ga_campaign_tracking != '') {
					$ga_campaign_tracking = $post_ga_campaign_tracking;
				}
				
				if ($ga_campaign_tracking != '') {
					$post_share_details['url'] = essb_attach_tracking_code($post_share_details['url'], $ga_campaign_tracking);
				}						
			}
		}
			
		// @since 3.1.2 exist filter to control the share address
		if (has_filter('essb3_share_url')) {
			$post_share_details['url'] = apply_filters('essb3_share_url', $post_share_details['url']);
		}
		
	    // -- short url code block
	    // code refactor @since 3.4.2
		$post_share_details ['full_url'] = $post_share_details ['url'];
		
		if ($this->general_options['shorturl_activate'] && $post_share_details['full_url'] != 'http://socialsharingplugin.com') {
			$global_provider = $this->general_options ['shorturl_type'];			
			
			essb_depend_load_function('essb_short_url', 'lib/core/essb-shorturl-helper.php');
			$post_share_details = essb_apply_shorturl($post_share_details, $this->network_options ['twitter_shareshort'], $post_share_details ['url'], $global_provider, get_the_ID (), $this->general_options ['shorturl_bitlyuser'], $this->general_options ['shorturl_bitlyapi']);
		}
		else {
			$post_share_details ['short_url'] = $post_share_details ['url'];
			$post_share_details ['short_url_twitter'] = $post_share_details ['url'];
			$post_share_details ['short_url_whatsapp'] = $post_share_details ['url'];
		}
		
		//-- end: short url code block
		
		// -- main button design
		$button_style = $this->get_buttons_visual_options($position);
		// @since 3.6 AMP support
		$button_style['amp'] = $amp_sharing;
				
		$social_networks = $this->network_options['networks'];
		$social_networks_order = $this->network_options['networks_order'];
		$social_networks_names = $this->network_options['default_names'];
				
		// apply settings based on position when active
		$check_position_settings_key = $position;
		
		if (essb_is_mobile() && essb_active_position_settings('mobile')) {
			$check_position_settings_key = 'mobile';
		}
		
		if (essb_is_mobile()) {
			if (ESSBGlobalSettings::$mobile_networks_active) {
				$social_networks = ESSBGlobalSettings::$mobile_networks;				
			}
			if (ESSBGlobalSettings::$mobile_networks_order_active) {
				$social_networks_order = ESSBGlobalSettings::$mobile_networks_order;
			}
		}
		
		// read AMP share networks
		if ($amp_sharing) {
			$amp_networks = essb_options_value('amp_networks');
			if (!is_array($amp_networks)) {
				$amp_networks = array();
			}
			
			if (count($amp_networks) > 0) {
				$social_networks = $amp_networks;
				$social_networks_order = $amp_networks;
				$social_networks_names = essb_apply_position_network_names('amp', $social_networks_names);
			}
		}
		
		// double check to avoid missconfiguration based on mobile specific settings
		if ($check_position_settings_key != 'sharebar' && $check_position_settings_key != 'sharepoint' && $check_position_settings_key != 'sharebottom') {
			// first check for post type settins - if there are such that will be the settings key. If nothing is active switch to button position
			// settings
			if (!defined('ESSB3_LIGHTMODE')) {
				if (!empty($post_type)) {
					if (essb_active_position_settings(sprintf('post-type-%1$s', $post_type))) {
						$check_position_settings_key = sprintf('post-type-%1$s', $post_type);
					}
				}
			}
			
			// postbar settings that are over the setup
			if ($position == 'postbar') {
				$button_style = essb_apply_postbar_position_style_settings('postbar', $button_style);
				
			}
			
			if ($position == 'point') {
				$button_style = essb_apply_point_position_style_settings('point', $button_style);
			}
			
			
			if (essb_active_position_settings($check_position_settings_key)) {
				$button_style = essb_apply_position_style_settings($check_position_settings_key, $button_style);
				
				
				if ($check_position_settings_key != 'mobile') {
					$personalized_networks = essb_get_active_social_networks_by_position($check_position_settings_key);
					$personalized_network_order = essb_get_order_of_social_networks_by_position($check_position_settings_key);
					
					if (is_array($personalized_networks) && count($personalized_networks) > 0) {
						$social_networks = $personalized_networks;
					}
					
					if (is_array($personalized_network_order) && count($personalized_network_order) > 0) {
						$social_networks_order = $personalized_network_order;
					}
				}
				
				$social_networks_names = essb_apply_position_network_names($check_position_settings_key, $social_networks_names);
				
			}
			else {
				if (defined('ESSB3_LIGHTMODE')) {
					if (ESSBLightModeHelper::position_with_predefined_options($position)) {
						$button_style = ESSBLightModeHelper::apply_position_predefined_settings($position, $button_style);
					}
				}
			}
			
			if (has_filter("essb4_position_style_{$position}")) {
				$button_style = apply_filters("essb4_position_style_{$position}", $button_style);
			}
		}
				
		// apply safe default of mobile styles to avoid miss configured display
		$share_bottom_networks = array();
		if ($position == 'sharebar' || $position == 'sharepoint' || $position == 'sharebottom') {		
			$post_native_details['active'] = false;
			// apply mobile personalizations by display methods
			if (essb_active_position_settings($position)) {
				$button_style = essb_apply_mobile_position_style_settings($position, $button_style);
				
				$personalized_networks = essb_get_active_social_networks_by_position($position);
				$personalized_network_order = essb_get_order_of_social_networks_by_position($position);
				
				if (is_array($personalized_networks) && count($personalized_networks) > 0) {					
					$social_networks = $personalized_networks;
				}
				
				if (is_array($personalized_network_order) && count($personalized_network_order) > 0) {
					$social_networks_order = $personalized_network_order;
				}
				
				$social_networks_names = essb_apply_position_network_names($position, $social_networks_names);
			}
			
			// apply sharebar and sharepoint default styles
			if ($position == 'sharebar' || $position == 'sharepoint') {
				
				// for those display methods the more buttons is not needed
				if (in_array('more', $social_networks)) {
					if(($key = array_search('more', $social_networks)) !== false) {
						unset($social_networks[$key]);
					}
				}
				
				$button_style = essb_apply_required_mobile_style_settings($position, $button_style);
				
				
			}
			
			if ($position == 'sharebottom') {
				if (in_array('more', $social_networks)) {
					if(($key = array_search('more', $social_networks)) !== false) {
						unset($social_networks[$key]);
					}
				}

				$button_style['button_style'] = 'icon';
				$button_style['show_counter'] = false;
				$button_style['nospace'] = true;
				$button_style['button_width'] = 'column';
				
				// @since 3.6
				// allow total counter to appear
				$button_count_correction_when_total = 0;
				if (essb_option_bool_value('mobile_sharebuttonsbar_total')) {
					$button_style['show_counter'] = true;
					$button_style['total_counter_pos'] = 'leftbig';
					$button_style['counter_pos'] = 'hidden';
					$button_count_correction_when_total = 1;
				}
				
				$available_networks_count = essb_option_value('mobile_sharebuttonsbar_count');
				$mobile_sharebuttonsbar_names = essb_option_bool_value( 'mobile_sharebuttonsbar_names');
				if ($mobile_sharebuttonsbar_names) {
					$button_style['button_style'] = 'button';
				}
				
				if (intval($available_networks_count) == 0) {
					$available_networks_count = 4;
				}
				if (count($social_networks) > (intval($available_networks_count) - $button_count_correction_when_total)) {
					$share_bottom_networks = $social_networks;
					
					
					$share_bottom_networks = (array_slice($social_networks, intval($available_networks_count) - 1 - $button_count_correction_when_total));
					array_splice($social_networks, intval($available_networks_count) - 1 - $button_count_correction_when_total);
					$social_networks[] = 'more';
					$social_networks_order = $social_networks;
					//$button_style['more_button_icon'] = "dots";
					
				}
				
				$button_style['button_width_columns'] = intval($available_networks_count);
				
			}
						
		}
		
		if (!is_array($social_networks)) { $social_networks = array(); }
		if (!is_array($social_networks_order) || count($social_networks_order) == 0) {
			$social_networks_order = essb_core_helper_generate_network_list();
		}

		// apply shortcode customizations
		if ($is_shortcode) {
			
			
			essb_depend_load_function('essb_shortcode_map_visualoptions', 'lib/core/extenders/essb-core-extender-shortcode.php');
			
			$button_style = essb_shortcode_map_visualoptions($button_style, $shortcode_options);
			
			// apply personalization of social networks if set from shortcode
			if (count($shortcode_options['networks']) > 0) {
				$social_networks = $shortcode_options['networks'];
				$social_networks_order = $shortcode_options['networks'];				
			}
			
			if ($shortcode_options['customize_texts']) {
				$social_networks_names = $shortcode_options['network_texts'];
			}
			
			// apply shortcode counter options
			if (!empty($shortcode_options['fblike'])) {
				$post_native_details['facebook_url'] = $shortcode_options['fblike'];
			}
			if (!empty($shortcode_options['plusone'])) {
				$post_native_details['google_url'] = $shortcode_options['plusone'];
			}
			
			//apply again mobile settings for the mobile buttons bar
			if ($position == 'sharebottom') {
				if (in_array('more', $social_networks)) {
					if(($key = array_search('more', $social_networks)) !== false) {
						unset($social_networks[$key]);
					}
				}
			
				$button_style['button_style'] = 'icon';
				$button_style['show_counter'] = false;
				$button_style['nospace'] = true;
				$button_style['button_width'] = 'column';
			
			
				$available_networks_count = essb_option_value('mobile_sharebuttonsbar_count');
				$mobile_sharebuttonsbar_names = essb_option_bool_value( 'mobile_sharebuttonsbar_names');
				if ($mobile_sharebuttonsbar_names) {
					$button_style['button_style'] = 'button';
				}
			
				if (intval($available_networks_count) == 0) {
					$available_networks_count = 4;
				}
				if (count($social_networks) > intval($available_networks_count)) {
					$share_bottom_networks = $social_networks;
					array_splice($social_networks, intval($available_networks_count) - 1);
					$social_networks[] = 'more';
					$social_networks_order[] = 'more';
					//$button_style['more_button_icon'] = "dots";
				}
			
				$button_style['button_width_columns'] = intval($available_networks_count);

			}
			
		}
		
		
		// generate unique instance key
		$salt = mt_rand();
		// attache compliled mail message data
		if (in_array('mail', $social_networks)) {
			if (!function_exists('essb_sharing_prepare_mail')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-sharing.php');
			}
			
			$post_share_details = essb_sharing_prepare_mail($post_share_details);
			
			
			
			// activating mail generation of code from here;
			essb_resource_builder()->activate_resource('mail');
		}
		
		if (in_array('love', $social_networks)) {
			essb_depend_load_function('essb_love_generate_js_code', 'lib/networks/essb-loveyou.php');
		}
		
		$button_style['included_button_count'] = count($social_networks);
		if ($button_style['show_counter']) {
			if (isset($button_style['total_counter_pos'])) {
				if ($button_style['total_counter_pos'] != 'hidden') {
					$button_style['included_button_count']++;
				}
			}
		}
		
		
		$intance_morebutton_func = $this->network_options['more_button_func'];
		if ($position == 'sidebar' || $position == 'postfloat') {
			//$intance_morebutton_func = "2";
			if ($button_style['more_button_func'] == '1') {
				$button_style['more_button_func'] = '2';
			}
			
			if ($button_style['share_button_func'] == '1') {
				$button_style['share_button_func'] = '2';
			}
		}
		if ($position == 'sharebottom') {
			//$intance_morebutton_func = "3";
			$button_style['more_button_func'] = '3';
			$button_style['share_button_func'] = '3';
		}
		
		//$button_style['more_button_func'] = $intance_morebutton_func;
		
		// sidebar close button option if activated into settings
		if ($this->design_options['sidebar_leftright_close'] && $position == 'sidebar') {
			$social_networks[] = 'sidebar-close';
			$social_networks_order[] = 'sidebar-close';
		}
		
		// apply additional native button options
		if ($post_native_details['active']) {
			$post_native_details['url'] = $post_share_details['url'];
			$post_native_details['text'] = $post_share_details['title'];
		}
		
		// @since 3.0 beta 4 - check if on post settings we have set counters that are not active generally
		if ($button_style['show_counter']) {
			if (!essb_resource_builder()->is_activated('counters')) {
				if (!defined('ESSB3_COUNTER_LOADED') && !defined('ESSB3_CACHED_COUNTERS')) {
					$script_url = ESSB3_PLUGIN_URL .'/assets/js/easy-social-share-buttons'.ESSBGlobalSettings::$use_minified_js.'.js';
					essb_resource_builder()->add_static_resource_footer($script_url, 'easy-social-share-buttons', 'js');
					essb_resource_builder()->activate_resource('counters');
					define('ESSB3_COUNTER_LOADED', true);
				}
			}				
		}
		
		// @since 3.0.3 fix for the mail function
		$button_style['mail_function'] = $this->network_options['mail_function'];
		
		// @since 3.6
		if ($amp_sharing) $button_style['mail_function'] = 'link';
		
		// @since 3.2 - passing mobile state to button style to allow deactivate advaned share on mobile (does not work);
		$button_style['is_mobile'] = essb_is_mobile();
		
		if ($button_style['button_width_full_button'] == '') {
			$button_style['button_width_full_button'] = '95';
		}
		
		
		$ssbuttons = ESSBButtonHelper::draw_share_buttons($post_share_details, $button_style, 
				$social_networks, $social_networks_order, $social_networks_names, $position, $salt, $likeshare, $post_native_details);
		
		
		//print_r($post_native_details);
		if (!defined('ESSB3_LIGHTMODE')) {
			if ($post_native_details['active']) {
				if (!$post_native_details['sameline']) {
					$post_native_details['withshare'] = true;
					//@fixed display of native for float in 3.0beta5
					$native_buttons_code = ESSBNativeButtonsHelper::draw_native_buttons($post_native_details, $post_native_details['order'], $post_native_details['counters'], 
							$post_native_details['sameline'], $post_native_details['skinned']);
					
					$ssbuttons = str_replace('<!--native--></div>', $native_buttons_code.'</div>', $ssbuttons);
				}
			}
		}
		
		if (has_filter('essb4_draw_style_details')) {			
			$button_style = apply_filters('essb4_draw_style_details', $button_style);
		}
		
		if ($button_style['button_width'] == 'fixed') {
			$fixedwidth_key = $button_style['button_width_fixed_value'] . '-' . $button_style['button_width_fixed_align'];
			essb_depend_load_function('essb_rs_css_build_fixedwidth_button', 'lib/core/resource-snippets/essb_rs_css_build_fixedwidth_button.php');
			essb_resource_builder()->add_css(essb_rs_css_build_fixedwidth_button($salt, $button_style['button_width_fixed_value'], $button_style['button_width_fixed_align']), 'essb-fixed-width-'.$fixedwidth_key, 'footer');
					
		}
		if ($button_style['button_width'] == 'full') {
			//print_r($button_style);
			//print "fixed button code adding";
			$count_of_social_networks = count($social_networks);
			if ($button_style['show_counter']) {
				if (isset($button_style['total_counter_pos'])) {
					if ($button_style['total_counter_pos'] != 'hidden') {
						$count_of_social_networks++;
					}
				}
			}
			$container_width = $button_style['button_width_full_container'];

			$single_button_width = intval($container_width) / $count_of_social_networks;
			$single_button_width = floor($single_button_width);
			
			essb_depend_load_function('essb_rs_css_build_fullwidth_buttons', 'lib/core/resource-snippets/essb_rs_css_build_fullwidth_buttons.php');
			essb_resource_builder()->add_css(essb_rs_css_build_fullwidth_buttons($count_of_social_networks, $button_style['button_width_full_container'], $button_style['button_width_full_button'], $button_style['button_width_full_first'], $button_style['button_width_full_second']), 'essb-full-width-'.$single_button_width.'-'.$button_style['button_width_full_button'].'-'.$button_style['button_width_full_container'], 'footer');
				
		}
		
		// more buttons code append
		if (in_array('more', $social_networks) || in_array('share', $social_networks)) {
			
			$share_button_exist = in_array('share', $social_networks) ? true : false;
			
			//print_r($button_style);
			
			essb_depend_load_function('essb_generate_morebutton_code', 'lib/core/extenders/essb-core-extender-morebutton.php');
			//print_r($share_bottom_networks);
			if ($position == 'sharebottom') {
				$ssbuttons .= essb_generate_morebutton_code($button_style, $share_bottom_networks, $share_bottom_networks, $salt, $position, $post_share_details, $social_networks_names, $share_button_exist);
			}
			else {
				$ssbuttons .= essb_generate_morebutton_code($button_style, $social_networks, $social_networks_order, $salt, $position, $post_share_details, $social_networks_names, $share_button_exist);
			}
		}
		
		// @since 3.6 Invoke code for subscribe button if network is active in list
		if (in_array('subscribe', $social_networks) && ESSBGlobalSettings::$subscribe_function != 'link') {
			if (!class_exists('ESSBNetworks_Subscribe')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe.php');				
			}
			
			$ssbuttons .= ESSBNetworks_Subscribe::draw_subscribe_form($position, $salt, 'sharebuttons-'.$position);
		}
		
		// loading position based animations
		if (($button_style['button_animation'] != '' && $button_style['button_animation'] != 'no') && !essb_resource_builder()->is_activated('animations')) {
			$animate_url = ESSB3_PLUGIN_URL.'/assets/css/essb-animations.min.css';
			essb_resource_builder()->add_static_resource_footer($animate_url, 'easy-social-share-buttons-animations', 'css');
			essb_resource_builder()->activate_resource('animations');
				
		}
		
		// apply clean of new lines
		if (!empty($ssbuttons)) {
			$ssbuttons = trim(preg_replace('/\s+/', ' ', $ssbuttons));
		}
		
		if (!empty($cache_key)) {
			ESSBDynamicCache::put($cache_key, $ssbuttons);
		}
		
		if (!empty($cache_key_runtime) && ESSBGlobalSettings::$cache_runtime) {
			wp_cache_set( $cache_key_runtime, $ssbuttons );
		}
		
		//print "generated share in ".timer_stop(0, 5);
		
		return $ssbuttons;
	}
		

	
	function get_buttons_visual_options($position = '') {
		
		$style = array();
		$style['template'] = $this->design_options['template'];
		$style['button_style'] = $this->design_options['button_style'];
		$style['button_align'] = $this->design_options['button_align'];
		$style['button_width'] = $this->design_options['button_width'];
		$style['button_width_fixed_value'] = $this->design_options['button_width_fixed_value'];
		$style['button_width_fixed_align'] = $this->design_options['button_width_fixed_align'];
		$style['button_width_full_container'] = $this->design_options ['button_width_full_container'];
		$style['button_width_full_button'] = $this->design_options ['button_width_full_button'];
		$style['button_width_full_button_mobile'] = $this->design_options ['button_width_Full_button_mobile'];
		$style['button_width_columns'] = $this->design_options['button_width_columns']; 
		$style['show_counter'] = $this->button_style ['show_counter'];
		$style['counter_pos'] = $this->button_style ['counter_pos'];
		$style['active_internal_counters'] = $this->button_style ['active_internal_counters'];
		$style['total_counter_pos'] = $this->button_style ['total_counter_pos'];
		$style['message_share_buttons'] = $this->button_style ['message_share_buttons'];
		$style['message_share_before_buttons'] = $this->button_style['message_share_before_buttons'];
		$style['message_like_buttons'] = $this->button_style['message_like_buttons'];
		$style['total_counter_afterbefore_text'] = $this->general_options['total_counter_afterbefore_text'];
		$style['total_counter_hidden_till'] = $this->general_options['total_counter_hidden_till'];
		$style['button_counter_hidden_till'] = $this->general_options['button_counter_hidden_till'];
		$style['nospace'] = $this->design_options['nospace'];
		$style['more_button_func'] = $this->network_options['more_button_func'];
		$style['fullwidth_align'] = $this->design_options['fullwidth_align'];
		$style['fullwidth_share_buttons_columns_align'] = $this->design_options['fullwidth_share_buttons_columns_align'];
				
		if (intval($style['button_width_full_container']) == 0) {
			$style['button_width_full_container'] = '100';
		}

		
		if (essb_is_mobile()) {
			if ($style['button_width_full_button_mobile'] != '') {
				$style['button_width_full_button'] = $style['button_width_full_button_mobile'];
			}
		}
		
		if ($style['button_width_full_button'] == '') {
			$style['button_width_full_button'] = '100';
		}
		
		$style['button_width_full_first'] = essb_option_value('fullwidth_first_button');
		$style['button_width_full_second'] = essb_option_value('fullwidth_second_button');
		
		// @since 3.5
		// animations can be added on each button instance and we can have different at once
		$style['button_animation'] = essb_option_value('css_animations');
		
		// @since 4.0
		// Share button design code and functions
		$style['share_button_func'] = essb_option_value('share_button_func');
		$style['share_button_icon'] = essb_option_value('share_button_icon');		
		$style['share_button_style'] = essb_option_value('share_button_style');
		
		if (has_filter('essb4_button_visual_options')) {
			$style = apply_filters('essb4_button_visual_options', $style, $position);
		}
		
		return $style;
	}
	
	// end: button drawer
	
	function is_mobile() {
		// @since 3.4.1 - moved check in global function
		return essb_is_mobile();
	}
	
	function is_mobile_safecss() {
		if ($this->general_options['mobile_css_activate']) {
			return true;
		}
		else {
			return essb_is_mobile();
		}
	}
}

if (!function_exists ('str_replace_first')) {
	function str_replace_first($search, $replace, $subject) {
		$pos = strpos($subject, $search);
		if ($pos !== false) {
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}
}
?>