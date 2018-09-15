<?php
/*
Plugin Name: Ultimate Addons for Visual Composer
Plugin URI: https://brainstormforce.com/demos/ultimate/
Author: Brainstorm Force
Author URI: https://www.brainstormforce.com
Version: 3.16.7
Description: Includes Visual Composer premium addon elements like Icon, Info Box, Interactive Banner, Flip Box, Info List & Counter. Best of all - provides A Font Icon Manager allowing users to upload / delete custom icon fonts.
Text Domain: ultimate_vc
*/
if(!defined('__ULTIMATE_ROOT__')){
	define('__ULTIMATE_ROOT__', dirname(__FILE__));
}
if(!defined('ULTIMATE_VERSION')){
	define('ULTIMATE_VERSION', '3.16.7');
}

register_activation_hook( __FILE__, 'uvc_plugin_activate');
function uvc_plugin_activate()
{
	update_option('ultimate_vc_addons_redirect',true);
	$memory = ini_get('memory_limit');
	$allowed_memory = preg_replace("/[^0-9]/","",$memory)*1024*1024;
	$peak_memory = memory_get_peak_usage(true);
	if($allowed_memory - $peak_memory <= 14436352){
		$pre = __('Unfortunately, plugin could not be activated. Not enough memory available.','ultimate_vc');
		$sub = __('Please contact', 'ultimate_vc');
		trigger_error( $pre.' '.$sub.' <a href="https://support.brainstormforce.com/">'.__('plugin support','ultimate_vc').'</a>.',E_USER_ERROR );
	}

	// theme depend custom row class
	$themes = array(
		'X' 			=> 'x-content-band',
		'HighendWP' 	=> 'vc_row',
		'Vellum' 		=> 'vc_section_wrapper',
		'Curves'		=> 'default-section',
	);
	$site_theme = wp_get_theme();
	$current_theme = $site_theme->get( 'Name' );
	if(array_key_exists($current_theme, $themes))
	{
		if(!get_option('ultimate_custom_vc_row') || get_option('ultimate_custom_vc_row') == '')
			update_option('ultimate_custom_vc_row',$themes[$current_theme]);
	}
	if(!get_option('ultimate_js') || get_option('ultimate_js') == '')
		update_option('ultimate_js', 'enable');
	if(!get_option('ultimate_css') || get_option('ultimate_css') == '')
		update_option('ultimate_css', 'enable');
}

add_action('vc_after_init', 'load_ulitmate_presets');
function load_ulitmate_presets()  {
	$ultimate_preset_path = realpath(dirname(__FILE__).'/presets');
	foreach (glob($ultimate_preset_path."/*.php") as $filename) {
		include_once($filename);
		$base = (isset($array['base'])) ? $array['base'] : '';
		if($base === '')
			continue;
		$presets = (isset($array['presets'])) ? $array['presets'] : array();
		if(empty($presets))
			continue;
		foreach ($presets as $key => $preset) {
			$title = (isset($preset['title'])) ? $preset['title'] : '';
			$default = (isset($preset['default'])) ? $preset['default'] : '';
			$settings = (isset($preset['settings'])) ? $preset['settings'] : array();
			do_action( 'vc_register_settings_preset', $title, $base, $settings, $default );
		}
	}
}

if(!class_exists('Ultimate_VC_Addons'))
{
	add_action('admin_init','init_addons');

	$plugin = plugin_basename(__FILE__);
	add_filter('plugin_action_links_'.$plugin, 'ultimate_plugins_page_link' );

	function ultimate_plugins_page_link($links) {
		$tutorial_link = '<a href="http://bsf.io/y7ajc" target="_blank">'.__('Video Tutorials','ultimate_vc').'</a>';
		if(is_multisite())
			$settins_link = '<a href="'.network_admin_url('admin.php?page=ultimate-dashboard').'" target="_blank">'.__('Settings','ultimate_vc').'</a>';
		else
			$settins_link = '<a href="'.admin_url('admin.php?page=ultimate-dashboard').'" target="_blank">'.__('Settings','ultimate_vc').'</a>';

		array_unshift($links, $tutorial_link);
		//array_push($links, $tutorial_link);
		array_push($links, $settins_link);
		return $links;
	}


	function init_addons()
	{
		$required_vc = '3.7';
		if(defined('WPB_VC_VERSION')){
			if( version_compare( $required_vc, WPB_VC_VERSION, '>' )){
				add_action( 'admin_notices', 'admin_notice_for_version');
				add_action('network_admin_notices','admin_notice_for_version');
			}
		} else {
			add_action( 'admin_notices', 'admin_notice_for_vc_activation');
			add_action('network_admin_notices','admin_notice_for_vc_activation');
		}
	}// end init_addons
	function admin_notice_for_version()
	{
		$is_multisite = is_multisite();
		$is_network_admin = is_network_admin();
		if(($is_multisite && $is_network_admin) || !$is_multisite)
			echo '<div class="updated"><p>'.__('The','ultimate_vc').' <strong>Ultimate addons for Visual Composer</strong> '.__('plugin requires','ultimate_vc').' <strong>Visual Composer</strong> '.__('version 3.7.2 or greater.','ultimate_vc').'</p></div>';
	}
	function admin_notice_for_vc_activation()
	{
		$is_multisite = is_multisite();
		$is_network_admin = is_network_admin();
		if(($is_multisite && $is_network_admin) || !$is_multisite)
			echo '<div class="updated"><p>'.__('The','ultimate_vc').' <strong>Ultimate addons for Visual Composer</strong> '.__('plugin requires','ultimate_vc').' <strong>Visual Composer</strong> '.__('Plugin installed and activated.','ultimate_vc').'</p></div>';
	}
	// plugin class
	class Ultimate_VC_Addons
	{
		var $paths = array();
		var $module_dir;
		var $params_dir;
		var $assets_js;
		var $assets_css;
		var $admin_js;
		var $admin_css;
		var $vc_template_dir;
		var $vc_dest_dir;
		function __construct()
		{
			//add_action( 'init', array($this,'init_addons'));

			add_action('init', array($this, 'load_vc_translation'));

			$this->vc_template_dir = plugin_dir_path( __FILE__ ).'vc_templates/';
			$this->vc_dest_dir = get_template_directory().'/vc_templates/';
			$this->module_dir = plugin_dir_path( __FILE__ ).'modules/';
			$this->params_dir = plugin_dir_path( __FILE__ ).'params/';
			$this->assets_js = plugins_url('assets/js/',__FILE__);
			$this->assets_css = plugins_url('assets/css/',__FILE__);
			$this->admin_js = plugins_url('admin/js/',__FILE__);
			$this->admin_css = plugins_url('admin/css/',__FILE__);
			$this->paths = wp_upload_dir();
			$this->paths['fonts'] 	= 'smile_fonts';
			if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || is_ssl()) {
			    $scheme = 'https';
			}
			else {
				$scheme = 'http';
			}
			$this->paths['fonturl'] = set_url_scheme($this->paths['baseurl'].'/'.$this->paths['fonts'], $scheme);
			add_action('after_setup_theme',array($this,'aio_init'));
			add_action('admin_enqueue_scripts',array($this,'aio_admin_scripts'));
			add_action('wp_enqueue_scripts',array($this,'aio_front_scripts'),99);
			add_action('admin_init',array($this,'toggle_updater'), 1);
			if(!get_option('ultimate_row')){
				update_option('ultimate_row','enable');
			}
			if(!get_option('ultimate_animation')){
				update_option('ultimate_animation','disable');
			}
			add_action('wp_head',array($this, 'ultimate_init_vars'));
			//add_action('admin_init', array($this, 'aio_move_templates'));
		}// end constructor

		function ultimate_init_vars() {
			$ultimate_smooth_scroll_compatible = get_option('ultimate_smooth_scroll_compatible');
			if($ultimate_smooth_scroll_compatible === 'enable')
				return false;

			$ultimate_smooth_scroll = get_option('ultimate_smooth_scroll');
			if($ultimate_smooth_scroll !== 'enable')
				return false;

			$ultimate_smooth_scroll_options = get_option('ultimate_smooth_scroll_options');
			$step = (isset($ultimate_smooth_scroll_options['step']) && $ultimate_smooth_scroll_options['step'] != '') ? $ultimate_smooth_scroll_options['step'] : 80;
			$speed = (isset($ultimate_smooth_scroll_options['speed']) && $ultimate_smooth_scroll_options['speed'] != '') ? $ultimate_smooth_scroll_options['speed'] : 480;
			echo "<script type='text/javascript'>
				jQuery(document).ready(function($) {
				var ult_smooth_speed = ".$speed.";
				var ult_smooth_step = ".$step.";
				$('html').attr('data-ult_smooth_speed',ult_smooth_speed).attr('data-ult_smooth_step',ult_smooth_step);
				});
			</script>";
		}

		function load_vc_translation()
		{
			load_plugin_textdomain('ultimate_vc', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
		}

		function aio_init()
		{
			//	activate - params
			foreach(glob($this->params_dir."/*.php") as $param)
			{
				require_once($param);
			}

			// activate addons one by one from modules directory
			$ultimate_modules = get_option('ultimate_modules');
			$ultimate_modules[] = 'ultimate_just_icon';
			$ultimate_modules[] = 'ultimate_functions';
			$ultimate_modules[] = 'ultimate_icon_manager';
			$ultimate_modules[] = 'ultimate_font_manager';

			if(get_option('ultimate_row') == "enable")
				$ultimate_modules[] = 'ultimate_parallax';
			foreach(glob($this->module_dir."/*.php") as $module)
			{
				$ultimate_file = basename($module);
				$ultimate_fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ultimate_file);

				if(is_array($ultimate_modules) && !empty($ultimate_modules)){
					if(in_array(strtolower($ultimate_fileName),$ultimate_modules) ){
						require_once($module);
					}
				}
			}

			if(in_array("woocomposer",$ultimate_modules) ){
				if(defined('WOOCOMMERCE_VERSION'))
				{
					if(version_compare( '2.1.0', WOOCOMMERCE_VERSION, '<' )) {
						foreach(glob(plugin_dir_path( __FILE__ ).'woocomposer/modules/*.php') as $module)
						{
							require_once($module);
						}
					} else {
						//add_action( 'admin_notices', array($this, 'woocomposer_admin_notice_for_woocommerce'));
					}
				} else {
					//add_action( 'admin_notices', array($this, 'woocomposer_admin_notice_for_woocommerce'));
				}
			}
		}// end aio_init
		function woocomposer_admin_notice_for_woocommerce(){
			echo '<div class="error"><p>'._('The','ultimate_vc').' <strong>WooComposer</strong> '.__('plugin requires','ultimate_vc').' <strong>WooCommerce</strong> '.__('plugin installed and activated with version greater than 2.1.0.', 'ultimate_vc').'</p></div>';
		}
		function aio_admin_scripts($hook)
		{
			// enqueue css files on backend'
			if($hook == "post.php" || $hook == "post-new.php" || $hook == 'visual-composer_page_vc-roles'){
				$bsf_dev_mode = bsf_get_option('dev_mode');

				if($bsf_dev_mode === 'enable') {
					wp_enqueue_style('ult-animate',$this->assets_css.'animate.css');
					wp_enqueue_style('aio-icon-manager',$this->admin_css.'icon-manager.css');
				}
				if(wp_script_is( 'vc_inline_custom_view_js', 'enqueued' ))
					wp_enqueue_script('vc-inline-editor',$this->assets_js.'vc-inline-editor.js',array('vc_inline_custom_view_js'),'1.5',true);
				$fonts = get_option('smile_fonts');
				if(is_array($fonts))
				{
					foreach($fonts as $font => $info)
					{
						if(strpos($info['style'], 'http://' ) !== false) {
							wp_enqueue_style('bsf-'.$font,$info['style']);
						} else {
							wp_enqueue_style('bsf-'.$font,trailingslashit($this->paths['fonturl']).$info['style']);
						}
					}
				}
			}
		}// end aio_admin_scripts

		function check_our_element_on_page($post_content) {
			// check for background
			$found_ultimate_backgrounds = false;
			if(stripos( $post_content, 'bg_type=')) {
				preg_match('/bg_type="(.*?)"/', $post_content, $output);
				if(
					$output[1] === 'bg_color'
					|| $output[1] === 'grad'
					|| $output[1] === 'image'
					|| $output[1] === 'u_iframe'
					|| $output[1] === 'video'
				) {
					$found_ultimate_backgrounds = true;
				}
			}
			if(
					stripos( $post_content, '[ultimate_spacer')
					|| stripos( $post_content, '[ult_buttons')
					|| stripos( $post_content, '[ultimate_icon_list')
					|| stripos( $post_content, '[just_icon')
					|| stripos( $post_content, '[ult_animation_block')
					|| stripos( $post_content, '[icon_counter')
					|| stripos( $post_content, '[ultimate_google_map')
					|| stripos( $post_content, '[icon_timeline')
					|| stripos( $post_content, '[bsf-info-box')
					|| stripos( $post_content, '[info_list')
					|| stripos( $post_content, '[ultimate_info_table')
					|| stripos( $post_content, '[interactive_banner_2')
					|| stripos( $post_content, '[interactive_banner')
					|| stripos( $post_content, '[ultimate_pricing')
					|| stripos( $post_content, '[ultimate_icons')
					|| stripos( $post_content, '[ultimate_heading')
					|| stripos( $post_content, '[ultimate_carousel')
					|| stripos( $post_content, '[ult_countdown')
					|| stripos( $post_content, '[ultimate_info_banner')
					|| stripos( $post_content, '[swatch_container')
					|| stripos( $post_content, '[ult_ihover')
					|| stripos( $post_content, '[ult_hotspot')
					|| stripos( $post_content, '[ult_content_box')
					|| stripos( $post_content, '[ultimate_ctation')
					|| stripos( $post_content, '[stat_counter')
					|| stripos( $post_content, '[ultimate_video_banner')
					|| stripos( $post_content, '[ult_dualbutton')
					|| stripos( $post_content, '[ult_createlink')
					|| stripos( $post_content, '[ultimate_img_separator')
					|| stripos( $post_content, '[ult_tab_element')
					|| stripos( $post_content, '[ultimate_exp_section')
					|| stripos( $post_content, '[info_circle')
					|| stripos( $post_content, '[ultimate_modal')

					|| stripos( $post_content, '[ult_sticky_section')

					|| stripos( $post_content, '[ult_team')
					|| stripos( $post_content, '[ultimate_fancytext')
					|| stripos( $post_content, '[ult_range_slider')
					|| $found_ultimate_backgrounds
				) {
				return true;
			}
			else {
				return false;
			}
		}

		function aio_front_scripts()
		{
			$isAjax = false;
			$ultimate_ajax_theme = get_option('ultimate_ajax_theme');
			if($ultimate_ajax_theme == 'enable')
				$isAjax = true;
			$dependancy = array('jquery');

			$bsf_dev_mode = bsf_get_option('dev_mode');
			if($bsf_dev_mode === 'enable') {
				$js_path = 'assets/js/';
				$css_path = 'assets/css/';
				$ext = '';
			}
			else {
				$js_path = 'assets/min-js/';
				$css_path = 'assets/min-css/';
				$ext = '.min';
			}

			$ultimate_smooth_scroll_compatible = get_option('ultimate_smooth_scroll_compatible');

			// register js
			wp_register_script('ultimate-script',plugins_url('assets/min-js/ultimate.min.js',__FILE__),array('jquery', 'jquery-ui-core' ), ULTIMATE_VERSION, false);
			wp_register_script('ultimate-appear',plugins_url($js_path.'jquery-appear'.$ext.'.js',__FILE__),array('jquery'), ULTIMATE_VERSION);
			wp_register_script('ultimate-custom',plugins_url($js_path.'custom'.$ext.'.js',__FILE__),array('jquery'), ULTIMATE_VERSION);
			wp_register_script('ultimate-vc-params',plugins_url($js_path.'ultimate-params'.$ext.'.js',__FILE__),array('jquery'), ULTIMATE_VERSION);
			if($ultimate_smooth_scroll_compatible === 'enable') {
				$smoothScroll = 'SmoothScroll-compatible.min.js';
			}
			else {
				$smoothScroll = 'SmoothScroll.min.js';
			}
			wp_register_script('ultimate-smooth-scroll',plugins_url('assets/min-js/'.$smoothScroll,__FILE__),array('jquery'),ULTIMATE_VERSION,true);
			wp_register_script("ultimate-modernizr",plugins_url($js_path.'modernizr-custom'.$ext.'.js',__FILE__),array('jquery'),ULTIMATE_VERSION);
			wp_register_script("ultimate-tooltip",plugins_url($js_path.'tooltip'.$ext.'.js',__FILE__),array('jquery'),ULTIMATE_VERSION);

			// register css
			wp_register_style('ultimate-animate',plugins_url($css_path.'animate'.$ext.'.css',__FILE__),array(),ULTIMATE_VERSION);
			wp_register_style('ultimate-style',plugins_url($css_path.'style'.$ext.'.css',__FILE__),array(),ULTIMATE_VERSION);
			wp_register_style('ultimate-style-min',plugins_url('assets/min-css/ultimate.min.css',__FILE__),array(),ULTIMATE_VERSION);
			wp_register_style('ultimate-tooltip',plugins_url($css_path.'tooltip'.$ext.'.css',__FILE__),array(),ULTIMATE_VERSION);

			$ultimate_smooth_scroll = get_option('ultimate_smooth_scroll');
			if($ultimate_smooth_scroll == "enable" || $ultimate_smooth_scroll_compatible === 'enable') {
				wp_enqueue_script('ultimate-smooth-scroll');
			}

			if(function_exists('vc_is_editor')){
				if(vc_is_editor()){
					wp_enqueue_style('vc-fronteditor',plugins_url('assets/min-css/vc-fronteditor.min.css',__FILE__));
				}
			}
			$fonts = get_option('smile_fonts');
			if(is_array($fonts))
			{
				foreach($fonts as $font => $info)
				{
					$style_url = $info['style'];
					if(strpos($style_url, 'http://' ) !== false) {
						wp_enqueue_style('bsf-'.$font,$info['style']);
					} else {
						wp_enqueue_style('bsf-'.$font,trailingslashit($this->paths['fonturl']).$info['style']);
					}
				}
			}

			$ultimate_global_scripts = bsf_get_option('ultimate_global_scripts');
			if($ultimate_global_scripts === 'enable') {
				wp_enqueue_script('ultimate-modernizr');
				wp_enqueue_script('jquery_ui');
				wp_enqueue_script('masonry');
				if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))
					$load_map_api = false;
				else
					$load_map_api = true;
				if($load_map_api)
					wp_enqueue_script('googleapis');
				/* Range Slider Dependecy */
				wp_enqueue_script('jquery-ui-mouse');
				wp_enqueue_script('jquery-ui-widget');
				wp_enqueue_script('jquery-ui-slider');
				wp_enqueue_script('ult_range_tick');
				/* Range Slider Dependecy */
				wp_enqueue_script('ultimate-script');
				wp_enqueue_script('ultimate-modal-all');
				wp_enqueue_script('jquery.shake',plugins_url($js_path.'jparallax'.$ext.'.js',__FILE__));
				wp_enqueue_script('jquery.vhparallax',plugins_url($js_path.'vhparallax'.$ext.'.js',__FILE__));

				wp_enqueue_style('ultimate-style-min');
				wp_enqueue_style("ult-icons");
				wp_enqueue_style('ultimate-vidcons',plugins_url('assets/fonts/vidcons.css',__FILE__));
				wp_enqueue_script('jquery.ytplayer',plugins_url($js_path.'mb-YTPlayer'.$ext.'.js',__FILE__));

				$Ultimate_Google_Font_Manager = new Ultimate_Google_Font_Manager;
				$Ultimate_Google_Font_Manager->enqueue_selected_ultimate_google_fonts();

				return false;
			}

			if(!is_404() && !is_search()){

				global $post;

				if(!$post) return false;

				$post_content = $post->post_content;

				$is_element_on_page = $this->check_our_element_on_page($post_content);

				if(stripos($post_content, 'font_call:'))
				{
					preg_match_all('/font_call:(.*?)"/',$post_content, $display);
					enquque_ultimate_google_fonts_optimzed($display[1]);
				}

				if(!$is_element_on_page)
					return false;

				$ultimate_js = get_option('ultimate_js');

				if(($ultimate_js == 'enable' || $isAjax == true) && ($bsf_dev_mode != 'enable') )
				{
					if(
							stripos( $post_content, '[swatch_container')
							|| stripos( $post_content, '[ultimate_modal')
					)
					{
						wp_enqueue_script('ultimate-modernizr');
					}

					if( stripos( $post_content, '[ultimate_exp_section') ||
						stripos( $post_content, '[info_circle') ) {
						wp_enqueue_script('jquery_ui');
					}

					if( stripos( $post_content, '[icon_timeline') ) {
						wp_enqueue_script('masonry');
					}

					if($isAjax == true) { // if ajax site load all js
						wp_enqueue_script('masonry');
					}

					if( stripos( $post_content, '[ultimate_google_map') ) {
						if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))
							$load_map_api = false;
						else
							$load_map_api = true;
						if($load_map_api)
							wp_enqueue_script('googleapis');
					}

					if( stripos( $post_content, '[ult_range_slider') ) {
						wp_enqueue_script('jquery-ui-mouse');
						wp_enqueue_script('jquery-ui-widget');
						wp_enqueue_script('jquery-ui-slider');
						wp_enqueue_script('ult_range_tick');
						wp_enqueue_script('ult_ui_touch_punch');
					}

					wp_enqueue_script('ultimate-script');

					if( stripos( $post_content, '[ultimate_modal') ) {
						//$modal_fixer = get_option('ultimate_modal_fixer');
						//if($modal_fixer === 'enable')
							//wp_enqueue_script('ultimate-modal-all-switched');
						//else
							wp_enqueue_script('ultimate-modal-all');
					}
				}
				else if($ultimate_js == 'disable')
				{
					wp_enqueue_script('ultimate-vc-params');

					if(
						stripos( $post_content, '[ultimate_spacer')
						|| stripos( $post_content, '[ult_buttons')
						|| stripos( $post_content, '[ult_team')
						|| stripos( $post_content, '[ultimate_icon_list')

					) {
						wp_enqueue_script('ultimate-custom');
					}
					if(
						stripos( $post_content, '[just_icon')
						|| stripos( $post_content, '[ult_animation_block')
						|| stripos( $post_content, '[icon_counter')
						|| stripos( $post_content, '[ultimate_google_map')
						|| stripos( $post_content, '[icon_timeline')
						|| stripos( $post_content, '[bsf-info-box')
						|| stripos( $post_content, '[info_list')
						|| stripos( $post_content, '[ultimate_info_table')
						|| stripos( $post_content, '[interactive_banner_2')
						|| stripos( $post_content, '[interactive_banner')
						|| stripos( $post_content, '[ultimate_pricing')
						|| stripos( $post_content, '[ultimate_icons')
					) {
						wp_enqueue_script('ultimate-appear');
						wp_enqueue_script('ultimate-custom');
					}
					if( stripos( $post_content, '[ultimate_heading') ) {
						wp_enqueue_script("ultimate-headings-script");
					}
					if( stripos( $post_content, '[ultimate_carousel') ) {
						wp_enqueue_script('ult-slick');
						wp_enqueue_script('ultimate-appear');
						wp_enqueue_script('ult-slick-custom');
					}
					if( stripos( $post_content, '[ult_countdown') ) {
						wp_enqueue_script('jquery.timecircle');
						wp_enqueue_script('jquery.countdown');
					}
					if( stripos( $post_content, '[icon_timeline') ) {
						wp_enqueue_script('masonry');
					}
					if( stripos( $post_content, '[ultimate_info_banner') ) {
						wp_enqueue_script('ultimate-appear');
						wp_enqueue_script('utl-info-banner-script');
					}
					if( stripos( $post_content, '[ultimate_google_map') ) {
						if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))
							$load_map_api = false;
						else
							$load_map_api = true;
						if($load_map_api)
							wp_enqueue_script('googleapis');
					}
					if( stripos( $post_content, '[swatch_container') ) {
						wp_enqueue_script('ultimate-modernizr');
						wp_enqueue_script('swatchbook-js');
					}
					if( stripos( $post_content, '[ult_ihover') ) {
						wp_enqueue_script('ult_ihover_js');
					}
					if( stripos( $post_content, '[ult_hotspot') ) {
						wp_enqueue_script('ult_hotspot_tooltipster_js');
						wp_enqueue_script('ult_hotspot_js');
					}
					if( stripos( $post_content, '[ult_content_box') ) {
						wp_enqueue_script('ult_content_box_js');
					}
					if( stripos( $post_content, '[bsf-info-box') ) {
						wp_enqueue_script('info_box_js');
					}
					if( stripos( $post_content, '[icon_counter') ) {
						wp_enqueue_script('flip_box_js');
					}
					if( stripos( $post_content, '[ultimate_ctation') ) {
						wp_enqueue_script('utl-ctaction-script');
					}
					if( stripos( $post_content, '[stat_counter') ) {
						wp_enqueue_script('ultimate-appear');
						wp_enqueue_script('ult-stats-counter-js');
						//wp_enqueue_script('ult-slick-custom');
						wp_enqueue_script('ultimate-custom');
						array_push($dependancy,'stats-counter-js');
					}
					if( stripos( $post_content, '[ultimate_video_banner') ) {
						wp_enqueue_script('ultimate-video-banner-script');
					}
					if( stripos( $post_content, '[ult_dualbutton') ) {
						wp_enqueue_script('jquery.dualbtn');

					}
					if( stripos( $post_content, '[ult_createlink') ) {
						wp_enqueue_script('jquery.ult_cllink');
					}
					if( stripos( $post_content, '[ultimate_img_separator') ) {
						wp_enqueue_script('ultimate-appear');
						wp_enqueue_script('ult-easy-separator-script');
						wp_enqueue_script('ultimate-custom');
					}

					if( stripos( $post_content, '[ult_tab_element') ) {
						wp_enqueue_script('ultimate-appear');
						wp_enqueue_script('ult_tabs_rotate');
						wp_enqueue_script('ult_tabs_acordian_js');
					}
					if( stripos( $post_content, '[ultimate_exp_section') ) {
						wp_enqueue_script('jquery_ui');
						wp_enqueue_script('jquery_ultimate_expsection');
					}

					if( stripos( $post_content, '[info_circle') ) {
						wp_enqueue_script('jquery_ui');
						wp_enqueue_script('ultimate-appear');
						wp_enqueue_script('info-circle');
						//wp_enqueue_script('info-circle-ui-effect');
					}

					if( stripos( $post_content, '[ultimate_modal') ) {
						wp_enqueue_script('ultimate-modernizr');
						//$modal_fixer = get_option('ultimate_modal_fixer');
						//if($modal_fixer === 'enable')
							//wp_enqueue_script('ultimate-modal-all-switched');
						//else
						if($bsf_dev_mode == true || $bsf_dev_mode == 'true') {
							wp_enqueue_script('ultimate-modal-customizer');
							wp_enqueue_script('ultimate-modal-classie');
							wp_enqueue_script('ultimate-modal-froogaloop2');
							wp_enqueue_script('ultimate-modal-snap-svg');
							wp_enqueue_script('ultimate-modal');
						} else {
							wp_enqueue_script('ultimate-modal-all');
						}
					}

					if( stripos( $post_content, '[ult_sticky_section') ) {
						wp_enqueue_script('ult_sticky_js');
						wp_enqueue_script('ult_sticky_section_js');
					}

					if( stripos( $post_content, '[ult_team') ) {
						wp_enqueue_script('ultimate-team');
					}

					if( stripos( $post_content, '[ult_range_slider') ) {
						wp_enqueue_script('jquery-ui-mouse');
						wp_enqueue_script('jquery-ui-widget');
						wp_enqueue_script('jquery-ui-slider');
						wp_enqueue_script('ult_range_tick');
						wp_enqueue_script('ult_range_slider_js');
						wp_enqueue_script('ult_ui_touch_punch');
					}
				}

				$ultimate_css = get_option('ultimate_css');

				if($ultimate_css == "enable"){
					wp_enqueue_style('ultimate-style-min');
					if( stripos( $post_content, '[ultimate_carousel') ) {
						wp_enqueue_style("ult-icons");
					}
				} else {

					$ib_2_found = $ib_found = false;

					wp_enqueue_style('ultimate-style');

					if( stripos( $post_content, '[ult_animation_block') ) {
						wp_enqueue_style('ultimate-animate');
					}
					if( stripos( $post_content, '[icon_counter') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ult-flip-style');
					}
					if( stripos( $post_content, '[ult_countdown') ) {
						wp_enqueue_style('ult-countdown');
					}
					if( stripos( $post_content, '[ultimate_icon_list') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ultimate-tooltip');
					}
					if( stripos( $post_content, '[ultimate_carousel') ) {
						wp_enqueue_style("ult-slick");
						wp_enqueue_style("ult-icons");
						wp_enqueue_style("ultimate-animate");
					}
					if( stripos( $post_content, '[ultimate_fancytext') ) {
						wp_enqueue_style('ultimate-fancytext-style');
					}
					if( stripos( $post_content, '[ultimate_ctation') ) {
						wp_enqueue_style('utl-ctaction-style');
					}
					if( stripos( $post_content, '[ult_buttons') ) {
						wp_enqueue_style( 'ult-btn' );
					}
					if( stripos( $post_content, '[ultimate_heading') ) {
						wp_enqueue_style("ultimate-headings-style");
					}
					if( stripos( $post_content, '[ultimate_icons') || stripos( $post_content, '[single_icon')) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ultimate-tooltip');
					}
					if( stripos( $post_content, '[ult_ihover') ) {
						 wp_enqueue_style( 'ult_ihover_css' );
					}
					if( stripos( $post_content, '[ult_hotspot') ) {
						wp_enqueue_style( 'ult_hotspot_css' );
						wp_enqueue_style( 'ult_hotspot_tooltipster_css' );
					}
					if( stripos( $post_content, '[ult_content_box') ) {
						wp_enqueue_style('ult_content_box_css');
					}
					if( stripos( $post_content, '[bsf-info-box') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('info-box-style');
					}
					if( stripos( $post_content, '[info_circle') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('info-circle');
					}
					if( stripos( $post_content, '[ultimate_info_banner') ) {
						wp_enqueue_style('utl-info-banner-style');
						wp_enqueue_style('ultimate-animate');
					}
					if( stripos( $post_content, '[icon_timeline') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ultimate-timeline-style');
					}
					if( stripos( $post_content, '[just_icon') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ultimate-tooltip');
					}

					if( stripos( $post_content, '[interactive_banner_2') ) {
						$ib_2_found = true;
					}
					if(stripos( $post_content, '[interactive_banner') && !stripos( $post_content, '[interactive_banner_2')) {
						$ib_found = true;
					}
					if(stripos( $post_content, '[interactive_banner ') && stripos( $post_content, '[interactive_banner_2')) {
						$ib_found = true;
						$ib_2_found = true;
					}

					if( $ib_found && !$ib_2_found ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ult-interactive-banner');
					}
					else if( !$ib_found && $ib_2_found ) {
						wp_enqueue_style('ult-ib2-style');
					}
					else if($ib_found && $ib_2_found) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ult-interactive-banner');
						wp_enqueue_style('ult-ib2-style');
					}

					if( stripos( $post_content, '[info_list') ) {
						wp_enqueue_style('ultimate-animate');
					}
					if( stripos( $post_content, '[ultimate_modal') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ultimate-modal');
					}
					if( stripos( $post_content, '[ultimate_info_table') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style("ultimate-pricing");
					}
					if( stripos( $post_content, '[ultimate_pricing') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style("ultimate-pricing");
					}
					if( stripos( $post_content, '[swatch_container') ) {
						wp_enqueue_style('swatchbook-css');
					}
					if( stripos( $post_content, '[stat_counter') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ult-stats-counter-style');
					}
					if( stripos( $post_content, '[ultimate_video_banner') ) {
						wp_enqueue_style('ultimate-video-banner-style');
					}
					if( stripos( $post_content, '[ult_dualbutton') ) {
						wp_enqueue_style('ult-dualbutton');
					}
					if( stripos( $post_content, '[ult_createlink') ) {
						wp_enqueue_style('ult_cllink');
					}
					if( stripos( $post_content, '[ultimate_img_separator') ) {
						wp_enqueue_style('ultimate-animate');
						wp_enqueue_style('ult-easy-separator-style');
					}
					if( stripos( $post_content, '[ult_tab_element') ) {
						wp_enqueue_style('ult_tabs');
						wp_enqueue_style('ult_tabs_acordian');
					}
					if( stripos( $post_content, '[ultimate_exp_section') ) {
						wp_enqueue_style('style_ultimate_expsection');
					}
					if( stripos( $post_content, '[ult_sticky_section') ) {
						wp_enqueue_style('ult_sticky_section_css');
					}
					if( stripos( $post_content, '[ult_team') ) {
						wp_enqueue_style('ultimate-team');
					}
					if( stripos( $post_content, '[ult_range_slider') ) {
						wp_enqueue_style('ult_range_slider_css');
					}
				}
			}
		}// end aio_front_scripts
		function aio_move_templates()
		{
			// Make destination directory
			if (!is_dir($this->vc_dest_dir)) {
				wp_mkdir_p($this->vc_dest_dir);
			}
			@chmod($this->vc_dest_dir,0777);
			foreach(glob($this->vc_template_dir.'*') as $file)
			{
				$new_file = basename($file);
				@copy($file,$this->vc_dest_dir.$new_file);
			}
		}// end aio_move_templates
		function toggle_updater(){
			if(defined('ULTIMATE_USE_BUILTIN')){
				update_option('ultimate_updater','disabled');
			} else {
				update_option('ultimate_updater','enabled');
			}

			$ultimate_constants = array(
				'ULTIMATE_NO_UPDATE_CHECK' => false,
				'ULTIMATE_NO_EDIT_PAGE_NOTICE' => false,
				'ULTIMATE_NO_PLUGIN_PAGE_NOTICE' => false
			);

			if(defined('ULTIMATE_NO_UPDATE_CHECK'))
				$ultimate_constants['ULTIMATE_NO_UPDATE_CHECK'] = ULTIMATE_NO_UPDATE_CHECK;
			if(defined('ULTIMATE_NO_EDIT_PAGE_NOTICE'))
				$ultimate_constants['ULTIMATE_NO_EDIT_PAGE_NOTICE'] = ULTIMATE_NO_EDIT_PAGE_NOTICE;
			if(defined('ULTIMATE_NO_PLUGIN_PAGE_NOTICE'))
				$ultimate_constants['ULTIMATE_NO_PLUGIN_PAGE_NOTICE'] = ULTIMATE_NO_PLUGIN_PAGE_NOTICE;

			update_option('ultimate_constants',$ultimate_constants);

			$modules = array(
				'ultimate_animation',
				'ultimate_buttons',
				'ultimate_countdown',
				'ultimate_flip_box',
				'ultimate_google_maps',
				'ultimate_google_trends',
				'ultimate_headings',
				'ultimate_icon_timeline',
				'ultimate_info_box',
				'ultimate_info_circle',
				'ultimate_info_list',
				'ultimate_info_tables',
				'ultimate_interactive_banners',
				'ultimate_interactive_banner_2',
				'ultimate_modals',
				'ultimate_parallax',
				'ultimate_pricing_tables',
				'ultimate_spacer',
				'ultimate_stats_counter',
				'ultimate_swatch_book',
				'ultimate_icons',
				'ultimate_list_icon',
				'ultimate_carousel',
				'ultimate_fancytext',
				'ultimate_highlight_box',
				'ultimate_info_banner',
				'ultimate_ihover',
				'ultimate_hotspot',
				'ultimate_video_banner',
				'woocomposer',
				'ultimate_dual_button',
				'ultimate_link',
				'ultimate_fancy_text',
				'ultimate_hightlight_box',
				'ultimate_content_box',
				'ultimate_image_separator',
				'ultimate_expandable_section',
				'ultimate_tab',
				'ultimate_sticky_section',
				'ultimate_team',
				'ultimate_range_slider',
			);
			$ultimate_modules = get_option('ultimate_modules');
			if(!$ultimate_modules && !is_array($ultimate_modules)){
				update_option('ultimate_modules',$modules);
			}

			if(get_option('ultimate_vc_addons_redirect') == true)
			{
				update_option('ultimate_vc_addons_redirect',false);
				if(!is_multisite()) :
					wp_redirect(admin_url('admin.php?page=about-ultimate'));
				endif;
			}

		}
	}//end class
	new Ultimate_VC_Addons;
	// load admin area
	require_once(__ULTIMATE_ROOT__.'/admin/admin.php');
	$ultimate_modules = get_option('ultimate_modules');
	if($ultimate_modules &&  in_array("woocomposer",$ultimate_modules) ){
		require_once(__ULTIMATE_ROOT__.'/woocomposer/woocomposer.php');
	}
}// end class check
/*
* Generate RGB colors from given HEX color
*
* @function: ultimate_hex2rgb()
* @Package: Ultimate Addons for Visual Compoer
* @Since: 2.1.0
* @param: $hex - HEX color value
* 		  $opecaty - Opacity in float value
* @returns: value with rgba(r,g,b,opacity);
*/
if(!function_exists('ultimate_hex2rgb')){
	function ultimate_hex2rgb($hex,$opacity=1) {
	   $hex = str_replace("#", "", $hex);
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgba = 'rgba('.$r.','.$g.','.$b.','.$opacity.')';
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgba; // returns an array with the rgb values
	}
}
// bsf core
$bsf_core_version_file = realpath(dirname(__FILE__).'/admin/bsf-core/version.yml');
if(is_file($bsf_core_version_file)) {
	global $bsf_core_version, $bsf_core_path;
	$bsf_core_dir = realpath(dirname(__FILE__).'/admin/bsf-core/');
	$version = file_get_contents($bsf_core_version_file);
	if(version_compare($version, $bsf_core_version, '>')) {
		$bsf_core_version = $version;
		$bsf_core_path = $bsf_core_dir;
	}
}
add_action('init', 'bsf_core_load', 999);
if(!function_exists('bsf_core_load')) {
	function bsf_core_load() {
		global $bsf_core_version, $bsf_core_path;
		if(is_file(realpath($bsf_core_path.'/index.php'))) {
			include_once realpath($bsf_core_path.'/index.php');
		}
	}
}
