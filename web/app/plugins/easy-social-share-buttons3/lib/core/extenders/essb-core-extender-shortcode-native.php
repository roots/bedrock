<?php
/**
 * EasySocialShareButtons CoreExtender: Shortcode Native
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBCoreExtenderShortcodeNative {

	public static function parse_shortcode($atts, $options) {
		global $post;
		
		$atts = shortcode_atts ( array (
				'facebook' => 'false',
				'facebook_url' => '',
				'facebook_width' => '',
				'facebook_skinned_text' => '',
				'facebook_skinned_width' => '',
				'facebook_follow' => 'false',
				'facebook_follow_url' => '',
				'facebook_follow_width' => '',
				'facebook_follow_skinned_text' => '',
				'facebook_follow_skinned_width' => '',
				'facebook_size' => '',
				'twitter_follow' => 'false',
				'twitter_follow_user' => '',
				'twitter_follow_skinned_text' => '',
				'twitter_follow_skinned_width' => '',
				'twitter_tweet' => 'false',
				'twitter_tweet_message' => '',
				'twitter_tweet_skinned_text' => '',
				'twitter_tweet_skinned_width' => '',
				'google' => 'false',
				'google_url' => '',
				'google_skinned_text' => '',
				'google_skinned_width' => '',
				'google_follow' => 'false',
				'google_follow_url' => '',
				'google_follow_skinned_text' => '',
				'google_follow_skinned_width' => '',
				'google_size' => '',
				'vk' => 'false',
				'vk_skinned_text' => '',
				'vk_skinned_width' => '',
				'youtube' => 'false',
				'youtube_chanel' => '',
				'youtube_skinned_text' => '',
				'youtube_skinned_width' => '',
				'linkedin' => 'false',
				'linkedin_company' => '',
				'linkedin_skinned_text' => '',
				'linkedin_skinned_width' => '',
				'pinterest_pin' => 'false',
				'pinterest_pin_skinned_text' => '',
				'pinterest_pin_skinned_width' => '',
				'pinterest_follow' => 'false',
				'pinterest_follow_display' => '',
				'pinterest_follow_url' => '',
				'pinterest_follow_skinned_text' => '',
				'pinterest_follow_skinned_width' => '',
				'skinned' => 'false',
				'skin' => 'flat',
				'message' => '',
				'align' => '',
				'counters' => 'false',
				'hide_mobile' => 'false',
				'order' => ''
		), $atts );
		
		$hide_mobile = isset ( $atts ['hide_mobile'] ) ? $atts ['hide_mobile'] : '';
		$hide_mobile_state = ESSBOptionValuesHelper::unified_true($hide_mobile);
		
		if ($hide_mobile_state && essb_is_mobile()) {
			return "";
		}
		
		$order = isset ( $atts ['order'] ) ? $atts ['order'] : '';
		
		// @ since 2.0 order of buttons
		if ($order == '') {
			$order = 'facebook,facebook_follow,twitter_follow,twitter_tweet,google,google_follow,vk,youtube,linkedin,pinterest_pin,pinterest_follow';
		}
		
		$align = isset ( $atts ['align'] ) ? $atts ['align'] : '';
		$facebook = isset ( $atts ['facebook'] ) ? $atts ['facebook'] : '';
		$facebook_url = isset ( $atts ['facebook_url'] ) ? $atts ['facebook_url'] : '';
		$facebook_width = isset ( $atts ['facebook_width'] ) ? $atts ['facebook_width'] : '';
		$facebook_skinned_text = isset ( $atts ['facebook_skinned_text'] ) ? $atts ['facebook_skinned_text'] : '';
		$facebook_skinned_width = isset ( $atts ['facebook_skinned_width'] ) ? $atts ['facebook_skinned_width'] : '';
		
		$facebook_follow = isset ( $atts ['facebook_follow'] ) ? $atts ['facebook_follow'] : '';
		$facebook_follow_url = isset ( $atts ['facebook_follow_url'] ) ? $atts ['facebook_follow_url'] : '';
		$facebook_follow_width = isset ( $atts ['facebook_follow_width'] ) ? $atts ['facebook_follow_width'] : '';
		$facebook_follow_skinned_text = isset ( $atts ['facebook_follow_skinned_text'] ) ? $atts ['facebook_follow_skinned_text'] : '';
		$facebook_follow_skinned_width = isset ( $atts ['facebook_follow_skinned_width'] ) ? $atts ['facebook_follow_skinned_width'] : '';
		
		$facebook_size = isset($atts['facebook_size']) ? $atts['facebook_size'] : '';
		
		$twitter_follow = isset ( $atts ['twitter_follow'] ) ? $atts ['twitter_follow'] : '';
		$twitter_follow_user = isset ( $atts ['twitter_follow_user'] ) ? $atts ['twitter_follow_user'] : '';
		$twitter_follow_skinned_text = isset ( $atts ['twitter_follow_skinned_text'] ) ? $atts ['twitter_follow_skinned_text'] : '';
		$twitter_follow_skinned_width = isset ( $atts ['twitter_follow_skinned_width'] ) ? $atts ['twitter_follow_skinned_width'] : '';
		
		$twitter_tweet = isset ( $atts ['twitter_tweet'] ) ? $atts ['twitter_tweet'] : '';
		$twitter_tweet_message = isset ( $atts ['twitter_tweet_message'] ) ? $atts ['twitter_tweet_message'] : '';
		$twitter_tweet_skinned_text = isset ( $atts ['twitter_tweet_skinned_text'] ) ? $atts ['twitter_tweet_skinned_text'] : '';
		$twitter_tweet_skinned_width = isset ( $atts ['twitter_tweet_skinned_width'] ) ? $atts ['twitter_tweet_skinned_width'] : '';
		
		$google = isset ( $atts ['google'] ) ? $atts ['google'] : '';
		$google_url = isset ( $atts ['google_url'] ) ? $atts ['google_url'] : '';
		$google_skinned_text = isset ( $atts ['google_skinned_text'] ) ? $atts ['google_skinned_text'] : '';
		$google_skinned_width = isset ( $atts ['google_skinned_width'] ) ? $atts ['google_skinned_width'] : '';
		
		$google_follow = isset ( $atts ['google_follow'] ) ? $atts ['google_follow'] : '';
		$google_follow_url = isset ( $atts ['google_follow_url'] ) ? $atts ['google_follow_url'] : '';
		$google_follow_skinned_text = isset ( $atts ['google_follow_skinned_text'] ) ? $atts ['google_follow_skinned_text'] : '';
		$google_follow_skinned_width = isset ( $atts ['google_follow_skinned_width'] ) ? $atts ['google_follow_skinned_width'] : '';
		
		$google_size = isset($atts['google_size']) ? $atts['google_size'] : '';
		
		$vk = isset ( $atts ['vk'] ) ? $atts ['vk'] : '';
		$vk_skinned_text = isset ( $atts ['vk_skinned_text'] ) ? $atts ['vk_skinned_text'] : '';
		$vk_skinned_width = isset ( $atts ['vk_skinned_width'] ) ? $atts ['vk_skinned_width'] : '';
		
		$youtube = isset ( $atts ['youtube'] ) ? $atts ['youtube'] : '';
		$youtube_chanel = isset ( $atts ['youtube_chanel'] ) ? $atts ['youtube_chanel'] : '';
		$youtube_skinned_text = isset ( $atts ['youtube_skinned_text'] ) ? $atts ['youtube_skinned_text'] : '';
		$youtube_skinned_width = isset ( $atts ['youtube_skinned_width'] ) ? $atts ['youtube_skinned_width'] : '';
		
		$linkedin = isset ( $atts ['linkedin'] ) ? $atts ['linkedin'] : '';
		$linkedin_comapny = isset ( $atts ['linkedin_company'] ) ? $atts ['linkedin_company'] : '';
		$linkedin_skinned_text = isset ( $atts ['linkedin_skinned_text'] ) ? $atts ['linkedin_skinned_text'] : '';
		$linkedin_skinned_width = isset ( $atts ['linkedin_skinned_width'] ) ? $atts ['linkedin_skinned_width'] : '';
		
		$pinterest_pin = isset ( $atts ['pinterest_pin'] ) ? $atts ['pinterest_pin'] : '';
		$pinterest_pin_skinned_text = isset ( $atts ['pinterest_pin_skinned_text'] ) ? $atts ['pinterest_pin_skinned_text'] : '';
		$pinterest_pin_skinned_width = isset ( $atts ['pinterest_pin_skinned_width'] ) ? $atts ['pinterest_pin_skinned_width'] : '';
		
		$pinterest_follow = isset ( $atts ['pinterest_follow'] ) ? $atts ['pinterest_follow'] : '';
		$pinterest_follow_display = isset ( $atts ['pinterest_follow_display'] ) ? $atts ['pinterest_follow_display'] : '';
		$pinterest_follow_url = isset ( $atts ['pinterest_follow_url'] ) ? $atts ['pinterest_follow_url'] : '';
		$pinterest_follow_skinned_text = isset ( $atts ['pinterest_follow_skinned_text'] ) ? $atts ['pinterest_follow_skinned_text'] : '';
		$pinterest_follow_skinned_width = isset ( $atts ['pinterest_follow_skinned_width'] ) ? $atts ['pinterest_follow_skinned_width'] : '';
		
		$skinned = isset ( $atts ['skinned'] ) ? $atts ['skinned'] : 'false';
		$skin = isset ( $atts ['skin'] ) ? $atts ['skin'] : '';
		$message = isset ( $atts ['message'] ) ? $atts ['message'] : '';
		$counters = isset ( $atts ['counters'] ) ? $atts ['counters'] : 'false';
		
		if (defined('ESSB3_DEMO_MODE')) {
			$query_skinned = isset($_REQUEST['nativemode']) ? $_REQUEST['nativemode'] : '';
			if ($query_skinned == 'skinned') { 
				$skinned = true;
				$skin = 'metro';
			}
		}
		
		// init global options
		$native_lang = isset ( $options ['native_social_language'] ) ? $options ['native_social_language'] : "en";
		
		$css_class_align = "";
		$css_class_noskin = ($skinned != 'true') ? ' essb-noskin' : '';
		
		// register like buttons CSS
		essb_resource_builder()->add_static_resource_footer( ESSB3_PLUGIN_URL . '/assets/css/essb-social-like-buttons.css', 'essb-social-like-shortcode-css', 'css');
		
		if (!defined('ESSB3_NATIVE_ACTIVE')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-skinned-native-button.php');
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-social-privacy.php');
			include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-native-buttons-helper.php');
			define('ESSB3_NATIVE_ACTIVE', true);
		
			$essb_spb = ESSBSocialPrivacyNativeButtons::get_instance();
			ESSBNativeButtonsHelper::$essb_spb = $essb_spb;
			foreach ($essb_spb->resource_files as $key => $object) {
				essb_resource_builder()->add_static_resource_footer($object["file"], $object["key"], $object["type"]);
			}
			foreach (ESSBSkinnedNativeButtons::get_assets() as $key => $object) {
				essb_resource_builder()->add_static_resource_footer($object["file"], $object["key"], $object["type"]);
			}
			essb_resource_builder()->add_css(ESSBSkinnedNativeButtons::generate_skinned_custom_css(), 'essb-skinned-native-buttons', 'footer');
		
			// asign instance of native buttons privacy class to helper
		
			// register active social network apis
			foreach (ESSBNativeButtonsHelper::get_list_of_social_apis() as $key => $code) {
				essb_resource_builder()->add_social_api($key);
			}
		}
		
		
		$counters_bool = ESSBOptionValuesHelper::unified_true($counters);
		$skinned_buttons = ESSBOptionValuesHelper::unified_true($skinned);
		
		
		$text = esc_attr ( urlencode ( $post->post_title ) );
		$url = $post ? get_permalink () : essb_get_current_url ( 'raw' );
		
		if ($align == "right" || $align == "center") {
			$css_class_align = $align;
		}
		
		$output = "";
		$output .= '<div class="essb-like ' . $css_class_align . '">';
		
		if ($message != '') {
			$output .= '<div class="essb-message">' . $message . '</div>';
		}
		
		if (defined('ESSB3_SOCIAL_PRIVACY_ACTIVE')) {
			$css_class_noskin = ' essb-privacynative';
		}
		
		$networks = preg_split ( '#[\s+,\s+]#', $order );
		
		$required_apis = array();
		
		foreach ( $networks as $network ) {
				
			if ($network == "facebook") {
				if (ESSBOptionValuesHelper::unified_true ( $facebook )) {
					if ($facebook_url == "") {
						$facebook_url = $url;
					}
						
					$native_button_options = array();
					$native_button_options['facebook_type'] = 'like';
					$native_button_options['facebook_url'] = $facebook_url;
					$native_button_options['facebook_width'] = $facebook_skinned_width;
					$native_button_options['facebook_text'] = $facebook_skinned_text;
					$native_button_options['skin'] = $skin;
						
					$output .= '<div class="essb-like-facebook essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('facebook', $native_button_options, $counters_bool, $skinned_buttons, $facebook_size);
					$output .= '</div>';
						
					if (ESSBNativeButtonsHelper::is_active_network('facebook')) {
						$required_apis['facebook'] = 'facebook';
					}
				}
			}
				
			if ($network == "facebook_follow") {
				if (ESSBOptionValuesHelper::unified_true ( $facebook_follow )) {
						
					$native_button_options = array();
					$native_button_options['facebook_type'] = 'follow';
					$native_button_options['facebook_url'] = $facebook_follow_url;
					$native_button_options['facebook_width'] = $facebook_follow_skinned_width;
					$native_button_options['facebook_text'] = $facebook_follow_skinned_text;
					$native_button_options['skin'] = $skin;
					$output .= '<div class="essb-like-facebook essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('facebook', $native_button_options, $counters_bool, $skinned_buttons, $facebook_size);
					$output .= '</div>';
					if (ESSBNativeButtonsHelper::is_active_network('facebook')) {
						$required_apis['facebook'] = 'facebook';
					}
		
				}
			}
				
			if ($network == "twitter_tweet") {
				if (ESSBOptionValuesHelper::unified_true ( $twitter_tweet )) {
						
					$native_button_options = array();
					$native_button_options['twitter_type'] = 'tweet';
					$native_button_options['twitter_user'] = $twitter_follow_user;
					$native_button_options['twitter_tweet'] = $twitter_tweet_message;
					$native_button_options['url'] = $url;
					$native_button_options['twitter_width'] = $twitter_tweet_skinned_width;
					$native_button_options['twitter_text'] = $twitter_tweet_skinned_text;
					$native_button_options['skin'] = $skin;
						
					$output .= '<div class="essb-like-twitter essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('twitter', $native_button_options, $counters_bool, $skinned_buttons);
					$output .= '</div>';
					if (ESSBNativeButtonsHelper::is_active_network('twitter')) {
						$required_apis['twitter'] = 'twitter';
					}
		
				}
			}
				
			if ($network == "twitter_follow") {
				if (ESSBOptionValuesHelper::unified_true ( $twitter_follow )) {
					$native_button_options = array();
					$native_button_options['twitter_type'] = 'follow';
					$native_button_options['twitter_user'] = $twitter_follow_user;
					$native_button_options['twitter_tweet'] = $twitter_tweet_message;
					$native_button_options['url'] = $url;
					$native_button_options['twitter_width'] = $twitter_follow_skinned_width;
					$native_button_options['twitter_text'] = $twitter_follow_skinned_text;
					$native_button_options['skin'] = $skin;
						
					$output .= '<div class="essb-like-twitter-follow essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('twitter', $native_button_options, $counters_bool, $skinned_buttons);
					$output .= '</div>';
					if (ESSBNativeButtonsHelper::is_active_network('twitter')) {
						$required_apis['twitter'] = 'twitter';
					}
				}
			}
				
			if ($network == "google") {
				if (ESSBOptionValuesHelper::unified_true ( $google )) {
					if ($google_url == "") {
						$google_url = $url;
					}
						
					$native_button_options = array();
					$native_button_options['google_type'] = 'plus';
					$native_button_options['google_url'] = $google_url;
					$native_button_options['google_width'] = $google_skinned_width;
					$native_button_options['google_text'] = $google_skinned_text;
					$native_button_options['skin'] = $skin;
					$output .= '<div class="essb-like-google essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('google', $native_button_options, $counters_bool, $skinned_buttons, $google_size);
					$output .= '</div>';
					if (ESSBNativeButtonsHelper::is_active_network('google')) {
						$required_apis['google'] = 'google';
					}
				}
			}
				
			if ($network == "google_follow") {
				if (ESSBOptionValuesHelper::unified_true ( $google_follow )) {
					$native_button_options = array();
					$native_button_options['google_type'] = 'follow';
					$native_button_options['google_url'] = $google_follow_url;
					$native_button_options['google_width'] = $google_follow_skinned_width;
					$native_button_options['google_text'] = $google_follow_skinned_text;
					$native_button_options['skin'] = $skin;
					$output .= '<div class="essb-like-google essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('google', $native_button_options, $counters_bool, $skinned_buttons, $google_size);
					$output .= '</div>';
					if (ESSBNativeButtonsHelper::is_active_network('google')) {
						$required_apis['google'] = 'google';
					}
				}
			}
				
			if ($network == "vk") {
				if (ESSBOptionValuesHelper::unified_true ( $vk )) {
					$native_button_options = array();
					$native_button_options['vk_width'] = $google_follow_skinned_width;
					$native_button_options['vk_text'] = $google_follow_skinned_text;
					$native_button_options['skin'] = $skin;
						
					$output .= '<div class="essb-like-vk essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('vk', $native_button_options, $counters_bool, $skinned_buttons);
					$output .= '</div>';
						
					if (ESSBNativeButtonsHelper::is_active_network('vk')) {
						$required_apis['vk'] = 'vk';
					}
				}
			}
				
			if ($network == "youtube") {
				if (ESSBOptionValuesHelper::unified_true ( $youtube )) {
					$native_button_options = array();
					$native_button_options['youtube_channel'] = $youtube_chanel;
					$native_button_options['youtube_width'] = $youtube_skinned_width;
					$native_button_options['youtube_text'] = $youtube_skinned_text;
					$native_button_options['skin'] = $skin;
					$output .= '<div class="essb-like-youtube essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('youtube', $native_button_options, $counters_bool, $skinned_buttons);
					$output .= '</div>';
					if (ESSBNativeButtonsHelper::is_active_network('google')) {
						$required_apis['google'] = 'google';
					}
				}
			}
				
			if ($network == "pinterest_pin") {
				if (ESSBOptionValuesHelper::unified_true ( $pinterest_pin )) {
					$native_button_options = array();
					$native_button_options['pinterest_type'] = 'pin';
					$native_button_options['pinterest_url'] = $pinterest_follow_url;
					$native_button_options['pinterest_text'] = $pinterest_follow_display;
					$native_button_options['pinterest_width'] = $pinterest_pin_skinned_width;
					$native_button_options['pinterest_text'] = $pinterest_pin_skinned_text;
					$native_button_options['skin'] = $skin;
						
					$output .= '<div class="essb-like-pin essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('pinterest', $native_button_options, $counters_bool, $skinned_buttons);
					$output .= '</div>';
						
					if (ESSBNativeButtonsHelper::is_active_network('pinterest')) {
						$required_apis['pinterest'] = 'pinterest';
					}
				}
			}
				
			if ($network == "pinterest_follow") {
				if (ESSBOptionValuesHelper::unified_true ( $pinterest_follow )) {
					$native_button_options = array();
					$native_button_options['pinterest_type'] = 'follow';
					$native_button_options['pinterest_url'] = $pinterest_follow_url;
					$native_button_options['pinterest_display'] = $pinterest_follow_display;
					$native_button_options['pinterest_width'] = $pinterest_follow_skinned_width;
					$native_button_options['pinterest_text'] = $pinterest_follow_skinned_text;
					$native_button_options['skin'] = $skin;
					$output .= '<div class="essb-like-pin-follow essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('pinterest', $native_button_options, $counters_bool, $skinned_buttons);
					$output .= '</div>';
						
					if (ESSBNativeButtonsHelper::is_active_network('pinterest')) {
						$required_apis['pinterest'] = 'pinterest';
					}
				}
			}
				
			if ($network == "linkedin") {
				if (ESSBOptionValuesHelper::unified_true ( $linkedin )) {
					$native_button_options = array();
					$native_button_options['linkedin_company'] = $linkedin_comapny;
					$native_button_options['linkedin_width'] = $linkedin_skinned_width;
					$native_button_options['linkedin_text'] = $linkedin_skinned_text;
					$native_button_options['skin'] = $skin;
		
					$output .= '<div class="essb-like-linkedin essb-block' . $css_class_noskin . '">';
					$output .= ESSBNativeButtonsHelper::draw_single_native_button('linkedin', $native_button_options, $counters_bool, $skinned_buttons);
					$output .= '</div>';
						
					if (ESSBNativeButtonsHelper::is_active_network('linkedin')) {
						$required_apis['linkedin'] = 'linkedin';
					}
				}
			}
		}
		
		foreach ($required_apis as $key => $code) {
			essb_resource_builder()->add_social_api($key);
		}
		$output .= '</div>';
		
		return $output;
	}
}