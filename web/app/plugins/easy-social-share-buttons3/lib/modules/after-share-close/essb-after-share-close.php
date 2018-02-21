<?php

class ESSBAfterCloseShare3 {
	static $instance;
	
	private $options;
	
	public $version = "";
	
	public $resource_files = array();
	public $js_code = array();
	public $social_apis = array();
	
	protected $mobile_detect;
	
	protected $single_display_mode = false;
	protected $single_display_cookie_length = 7;
	
	function __construct() {
		global $essb_options;
		$this->options = $essb_options;
		
		$is_active = ESSBOptionValuesHelper::options_bool_value($this->options, 'afterclose_active');
		$is_deactive_mobile = ESSBOptionValuesHelper::options_bool_value($this->options, 'afterclose_deactive_mobile');
		
		$is_active_singledisplay = ESSBOptionValuesHelper::options_bool_value($this->options, 'afterclose_singledisplay');
		$single_display_cookie_length = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_singledisplay_days');
				
		$this->single_display_mode = $is_active_singledisplay;
		$this->single_display_cookie_length = intval($single_display_cookie_length);
		if ($this->single_display_cookie_length == 0) { $this->single_display_cookie_length = 7; }
		
		$afterclose_deactive_sharedisable = ESSBOptionValuesHelper::options_bool_value($this->options, 'afterclose_deactive_sharedisable');
		//if ($is_active) {
			//add_action ( 'wp_enqueue_scripts', array ($this, 'check_after_postload_settings' ), 1 );
		//}
		
		
 		
		$is_active_option = "";
		if (ESSB3_DEMO_MODE) {
			$is_active_option = isset($_REQUEST['aftershare']) ? $_REQUEST['aftershare'] : '';
			if ($is_active_option != '') {
				$is_active = true;
			}
		}
		
		// @since 2.0.3 - deactivate on mobile
		if ($is_active && $is_deactive_mobile && $this->isMobile()) {
			$is_active = false;
		}
		
		// @since 2.0.3
		
		if ($this->single_display_mode) {
			//print "deactivated!";
			$cookie_aftershare = isset($_COOKIE['essb_aftershare']) ? true : false;
			//print "cookie state = ".$cookie_aftershare;
			if ($cookie_aftershare) {
				$is_active = false;
			}
		}
		//print "is active after share = ".$is_active;
		if ($is_active) {
			//$this->load($is_active_option);
			add_action ( 'wp_enqueue_scripts', array ($this, 'check_after_postload_settings' ), 1 );
		}
	}
	
	public function check_after_postload_settings() {
		
		$is_active = true;
		
		$is_active_option = "";
		if (ESSB3_DEMO_MODE) {
			$is_active_option = isset($_REQUEST['aftershare']) ? $_REQUEST['aftershare'] : '';
			if ($is_active_option != '') {
				$is_active = true;
			}
		}
		
		if ($this->isUserDeactivated()) {
			$is_active = false;
		}
		
		// @since 4.0
		$afterclose_activate_all = essb_options_bool_value('afterclose_activate_all');
		if (!$afterclose_activate_all) {
			$post_types_run = essb_option_value('display_in_types');
				
			if (!is_array($post_types_run)) {
				$post_types_run = array();
			}
			
			if (!essb_core()->check_applicability($post_types_run, 'aftershare')) {
				$is_active = false;
			}
		}
		
		//print "after share state = ".$is_active;
		
		if (essb_option_bool_value('afterclose_activate_sharedisable')) {
			$is_active = true;
		}
		
		if (!$is_active) {
			remove_action ( 'wp_footer', array ($this, 'generateFollowWindow' ), 99 );
			remove_action ( 'wp_footer', array ($this, 'generateMessageText' ), 99 );
			remove_action ( 'wp_footer', array ($this, 'generate_option_code' ), 99 );
			remove_action ( 'wp_footer', array ($this, 'generate_popular_posts' ), 99 );
				
		}
		else {
			$this->load($is_active_option);
		}
	}
	
	public function isUserDeactivated() {
		$is_user_deactivated = false;
		$display_exclude_from = ESSBOptionValuesHelper::options_value($this->options, 'display_exclude_from');
		
		if ($display_exclude_from != "") {
			$excule_from = explode(',', $display_exclude_from);
		
			$excule_from = array_map('trim', $excule_from);
		
			if (in_array(get_the_ID(), $excule_from, false)) {
				$is_user_deactivated = true;
			}
		}
		
		if ( essb_is_module_deactivated_on('aftershare')) {
			$is_user_deactivated = true;
		}
		
		// check post meta for turned off
		$essb_off = get_post_meta(get_the_ID(),'essb_off',true);
		
		if ($essb_off == "true") {
			$is_user_deactivated = true;
		}
		
		if (essb_option_bool_value('afterclose_activate_sharedisable')) {
			$is_user_deactivated = false;
		}
		
		return $is_user_deactivated;
	}
	
	public static function get_instance() {
	
		if ( ! self::$instance )
			self::$instance = new ESSBAfterCloseShare3();
	
		return self::$instance;	
	}
	
	public function isMobile() {
	
		$exclude_tablet = isset($this->options['mobile_exclude_tablet']) ? $this->options['mobile_exclude_tablet'] : 'false';
	
		if (!isset($this->mobile_detect)) {
			$this->mobile_detect = new ESSB_Mobile_Detect();
		}
	
		//print "mobile = ".$this->mobile_detect->isMobile();;
		$isMobile = $this->mobile_detect->isMobile();
	
		if ($exclude_tablet == 'true' && $this->mobile_detect->isTablet()) {
			$isMobile = false;
		}
		return $isMobile;
	}
	
	private function load($demo_mode = '') {
		$acs_type = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_type');
		
		$always_use_code = ESSBOptionValuesHelper::options_bool_value($this->options, 'afterclose_code_always_use');
		
		if ($demo_mode != '') {
			$acs_type = $demo_mode;
		}
		
		//print "loading code = ". $acs_type;
		
		switch ($acs_type) {
			case "follow":
				$this->prepare_required_social_apis();
				$this->register_asc_assets();
				add_action ( 'wp_footer', array ($this, 'generateFollowWindow' ), 99 );
				if ($always_use_code) {
					$this->generateMessageCode();
				}
				break;				
			case "message":
				$this->register_asc_assets();
				add_action ( 'wp_footer', array ($this, 'generateMessageText' ), 99 );
				if ($always_use_code) {
					$this->generateMessageCode();
				}
				break;
			case "code":
				$this->generateMessageCode();
				break;		
			case "optin":
				add_action ( 'wp_footer', array ($this, 'generate_option_code' ), 99 );
				if ($always_use_code) {
					$this->generateMessageCode();
				}
				break;
			case "popular":
				$this->register_asc_assets();				
				add_action ( 'wp_footer', array ($this, 'generate_popular_posts' ), 99 );
				if ($always_use_code) {
					$this->generateMessageCode();
				}
				break;					
		}
		
		foreach ($this->js_code as $key => $code) {
			essb_resource_builder()->add_js($code, false, 'essbasc_custom'.$key);
		}
		
		foreach ($this->social_apis as $key => $code) {
			essb_resource_builder()->add_social_api($key);
		}
	}
	
	public function register_asc_assets() {
		
		$this->resource_files[] = array("key" => "easy-social-share-buttons-popupasc", "file" => ESSB3_PLUGIN_URL . '/assets/css/essb-after-share-close.min.css', "type" => "css");
		$this->resource_files[] = array("key" => "essb-aftershare-close-script", "file" => ESSB3_PLUGIN_URL . '/assets/js/essb-after-share-close.min.js', "type" => "js");
		
		//print "register footer assets ";
		
		foreach ($this->resource_files as $key => $object) {
			
			if (isset($object['noasync'])) {
				essb_resource_builder()->add_static_resource_footer($object["file"], $object["key"], $object["type"], true);
			}
			else {
				essb_resource_builder()->add_static_resource_footer($object["file"], $object["key"], $object["type"]);
			}
		}
	}
	
	public function generateMessageCode() {
		$user_js_code = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_code_text');
		
		if ($user_js_code != '') {
			$user_js_code = stripslashes($user_js_code);
			
			$this->js_code[] = 'function essb_acs_code(oService, oPostID) { '.$user_js_code.' }';
		}
	} 
	
	public function prepare_required_social_apis() {
		$afterclose_like_text = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_text');
		$afterclose_like_fb_like_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_fb_like_url');
		$afterclose_like_fb_follow_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_fb_follow_url');
		$afterclose_like_google_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_google_url');
		$afterclose_like_google_follow_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_google_follow_url');
		$afterclose_like_twitter_profile = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_twitter_profile');
		$afterclose_like_pin_follow_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_pin_follow_url');
		$afterclose_like_youtube_channel = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_youtube_channel');
		$afterclose_like_youtube_user = essb_option_value('afterclose_like_youtube_user');
		$afterclose_like_linkedin_company = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_linkedin_company');
		$afterclose_like_vk = essb_option_value('afterclose_like_vk');
		
		if ($afterclose_like_fb_like_url != '') {
			$this->social_apis['facebook'] = 'load';
		}
		if ($afterclose_like_fb_follow_url != '') {
			$this->social_apis['facebook'] = 'load';
		}
		if ($afterclose_like_google_url != '') {
			$this->social_apis['google'] = 'load';
		}
		if ($afterclose_like_google_follow_url != '') {
			$this->social_apis['google'] = 'load';
		}
		if ($afterclose_like_pin_follow_url != '') {
			$this->resource_files[] = array("key" => "pinterest-api", "file" => '//assets.pinterest.com/js/pinit.js', "type" => "js", 'noasync' => true);
		}
		if ($afterclose_like_youtube_channel != '' || $afterclose_like_youtube_user != '') {
			$this->social_apis['google'] = 'load';
		}
		if ($afterclose_like_vk != '') {
			//$this->resource_files[] = array("key" => "vk-follow-api", "file" => '//vk.com/js/api/openapi.js?139', "type" => "js", 'noasync' => true);
			//essb_resource_builder()->add_static_resource('//vk.com/js/api/openapi.js?139', 'vk-follow-api', 'js');
		}
	}
	
	public function generateFollowButton($social_code, $network_key, $icon_key) {
		$output = '';
		
		$output .= '<div class="essbasc-fans-single essbasc-fans-'.$network_key.'">
				<div class="essbasc-fans-icon">
					<i class="essb_icon_'.$icon_key.'"></i>
				</div>
				<div class="essbasc-fans-text">
		'.$social_code.'
		</div>
		</div>';
		
		return $output;
	}
	
	public function generateFollowWindow() {
		
		$afterclose_like_text = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_text');
		$afterclose_like_fb_like_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_fb_like_url');
		$afterclose_like_fb_follow_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_fb_follow_url');
		$afterclose_like_google_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_google_url');
		$afterclose_like_google_follow_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_google_follow_url');
		$afterclose_like_twitter_profile = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_twitter_profile');
		$afterclose_like_pin_follow_url = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_pin_follow_url');
		$afterclose_like_youtube_channel = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_youtube_channel');
		$afterclose_like_youtube_user = essb_option_value('afterclose_like_youtube_user');
		$afterclose_like_linkedin_company = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_linkedin_company');
		$afterclose_like_vk = essb_option_value('afterclose_like_vk');
		
		$afterclose_like_cols = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_like_cols', 'onecol');
				
		// Facebook Follow Button
		
		$afterclose_like_text = stripslashes($afterclose_like_text);
		
		$widget = "";
		
		if ($afterclose_like_text != '') {
			$widget .= '<div class="essbasc-text-before">'.$afterclose_like_text.'</div>';
		}
		
		$widget .= '<div class="essbasc-fans '.$afterclose_like_cols.'">';
		
		if ($afterclose_like_fb_like_url != '') {
			$social_code = '<div class="fb-like" data-href="'.$afterclose_like_fb_like_url.'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>';
			$widget .= $this->generateFollowButton($social_code, 'facebook', 'facebook');
		}
		if ($afterclose_like_fb_follow_url != '') {
			$social_code = '<div class="fb-follow" data-href="'.$afterclose_like_fb_follow_url.'" data-colorscheme="light" data-layout="button_count" data-show-faces="true"></div>';
			$widget .= $this->generateFollowButton($social_code, 'facebook', 'facebook');
		}
		if ($afterclose_like_google_url != '') {
			$social_code = '<div class="g-plusone" data-size="medium" data-href="'.$afterclose_like_google_url.'"></div>';
			$widget .= $this->generateFollowButton($social_code, 'google', 'google');
		}
		if ($afterclose_like_google_follow_url != '') {
			$social_code = '<div class="g-follow" data-annotation="bubble" data-height="20" data-href="'.$afterclose_like_google_follow_url.'" data-rel="author"></div>';
			$widget .= $this->generateFollowButton($social_code, 'google', 'google');
		}
		if ($afterclose_like_twitter_profile != '') {
			$social_code = '<a href="https://twitter.com/'.$afterclose_like_twitter_profile.'" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow @'.$afterclose_like_twitter_profile.'</a>';
			$social_code .= "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
			$widget .= $this->generateFollowButton($social_code, 'twitter', 'twitter');
		}	
		if ($afterclose_like_pin_follow_url != '') {
			$social_code = '<a data-pin-do="buttonFollow" href="'.$afterclose_like_pin_follow_url.'">'.'Follow'.'</a>';
			$widget .= $this->generateFollowButton($social_code, 'pinterest', 'pinterest');
		}	
		if ($afterclose_like_youtube_channel != '') {
			$social_code = '<div class="g-ytsubscribe" data-channelid="'.$afterclose_like_youtube_channel.'" data-layout="default" data-count="default"></div>';
			$widget .= $this->generateFollowButton($social_code, 'youtube', 'youtube-play');				
		}
		if ($afterclose_like_youtube_user != '') {
			$social_code = '<div class="g-ytsubscribe" data-channel="'.$afterclose_like_youtube_user.'" data-layout="default" data-count="default"></div>';
			$widget .= $this->generateFollowButton($social_code, 'youtube', 'youtube-play');				
		}
		if ($afterclose_like_linkedin_company != '') {
			$social_code = '<script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/FollowCompany" data-id="'.$afterclose_like_linkedin_company.'" data-counter="right"></script>';
			$widget .= $this->generateFollowButton($social_code, 'linkedin', 'linkedin');				
		}
		if ($afterclose_like_vk != '') {
			$social_code = '<!-- VK Widget -->
			<script type="text/javascript" src="//vk.com/js/api/openapi.js?139"></script>
<div id="vk_subscribe"></div>
<script type="text/javascript">
VK.Widgets.Subscribe("vk_subscribe", {soft: 1}, '.$afterclose_like_vk.');
</script>';
			$widget .= $this->generateFollowButton($social_code, 'vk', 'vk');
		}
		
		$widget .= '</div>';
		
		//$widget .= '<div class="essbasc-text-after">&nbsp;</div>';
		
		$this->popupWindowGenerate($widget, 'follow', '');
		
	}
	
	public function generateMessageText() {
		$user_html_code = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_message_text');
		$user_html_code = stripslashes($user_html_code);
		
		$user_html_code = do_shortcode($user_html_code);
		
		$this->popupWindowGenerate($user_html_code, 'html');
	}
	
	public function popupWindowGenerate($html, $type = '', $force_width = '') {
		
		$popup_width = ESSBOptionValuesHelper::options_value($this->options, 'afterclose_popup_width', '500');
		
		if (trim($popup_width) == '') { $popup_width = '400'; }
		
		if ($force_width != '') { $popup_width = $force_width; }
		
		if ($type != '') {
			$type = ' essbasc-popup-'.$type;
		}
		
		echo '<div class="essbasc-popup'.$type.'" data-popup-width="'.$popup_width.'">';
		echo '<a href="#" class="essbasc-popup-close" onclick="essbasc_popup_close(); return false;"></a>';
		echo '<div class="essbasc-popup-content">';
		echo $html;
		echo '</div>';
		
		echo '</div>';
		echo '<div class="essbasc-popup-shadow" onclick="essbasc_popup_close();"></div>';
		echo '<script type="text/javascript">';
		echo 'var essbasc_cookie_live = '.$this->single_display_cookie_length.';';
		echo '</script>';
	}
	
	public function generate_option_code() {
		$design = essb_option_value('aftershare_optin_design');
		if ($design == '') { $design = 'design1'; }
		
		if (!class_exists('ESSBNetworks_Subscribe')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe.php');
		}
		echo ESSBNetworks_Subscribe::draw_aftershare_popup_subscribe_form($design);
	}
	
	public function generate_popular_posts() {
		
		$user_title = essb_option_value('translate_as_popular_title');
		if ($user_title == '') {
			$user_title = __('Popular posts', 'essb');
		}
		
		$user_shares = essb_option_value('translate_as_popular_shares');
		if ($user_shares == '') {
			$user_shares = __('Shares', 'essb');
		}
		
		$code = do_shortcode('[easy-popular-posts title="'.$user_title.'" show_num="yes" num_text="'.$user_shares.'" number="4" same_cat="true" show_thumb="true" thumb_size="thumb"]');
		$this->popupWindowGenerate($code, 'follow', '500');
	}
}

?>