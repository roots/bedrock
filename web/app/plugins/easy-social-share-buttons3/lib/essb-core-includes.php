<?php

// inialize plugin options
global $essb_options, $essb_networks, $essb_translate_options;
$essb_options = get_option(ESSB3_OPTIONS_NAME);
$essb_translate_options = get_option(ESSB3_WPML_OPTIONS_NAME);
$essb_networks = essb_available_social_networks();

if (has_filter('essb4_options_extender')) {
	$essb_options = apply_filters('essb4_options_extender', $essb_options);
}

// @since 4.0 
// support for A/B split test of social setup
if (has_filter('essb4_options_ab')) {
	$essb_options = apply_filters('essb4_options_ab', $essb_options);
}


//@since 4.1 including activation manager
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-activation-manager.php');

// include options helper functions
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/options/essb-options-helper.php');
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-global-settings.php');
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-url-helper.php');

// @since 4.0 - activation of widget and shortcodes require to activate widget display method
if (ESSBOptionValuesHelper::is_active_module('sharingwidget')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/widgets/essb-share-widget.php');
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/widgets/essb-popular-posts-widget-shortcode.php');
}

if (essb_option_bool_value('subscribe_widget')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/widgets/essb-share-subscribe-widget.php');
}

// initialize global plugin settings from version 3.4.1
ESSBGlobalSettings::load($essb_options);

// init admin bar menu
// admin bar menu
$disable_admin_menu = ESSBOptionValuesHelper::options_bool_value($essb_options, 'disable_adminbar_menu');
// update relted to WordPress 4.4 changes
if (!$disable_admin_menu) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-adminbar-menu.php');
	add_action ( 'init', 'ESSBAdminMenuInit3' );
	
	function ESSBAdminMenuInit3() {
		global $essb_adminmenu;
		
		if (is_admin_bar_showing()) {
			$essb_adminmenu = new ESSBAdminBarMenu3();
		}
	}
}

if (essb_option_bool_value('essb_cache')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/cache/essb-dynamic-cache.php');
	$cache_mode = ESSBOptionValuesHelper::options_value($essb_options, 'essb_cache_mode');
	ESSBDynamicCache::activate($cache_mode);
}

if (essb_options_bool_value('precompiled_resources')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/cache/essb-precompiled.php');
	ESSBPrecompiledResources::activate();
}


if (essb_options_bool_value('essb_cache_static') || essb_options_bool_value('essb_cache_static_js')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/cache/essb-static-cache.php');
}


// dynamic resource builder
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-resource-builder.php');
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-resource-builder-core.php');
//include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-resource-builder-snippets.php');

include_once (ESSB3_PLUGIN_ROOT . 'lib/external/mobile-detect/mobile-detect.php');

if (!defined('ESSB3_LIGHTMODE')) {
	if (essb_options_bool_value('native_active')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-skinned-native-button.php');
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-social-privacy.php');
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-native-buttons-helper.php');
		define('ESSB3_NATIVE_ACTIVE', true);
	}
}
// including additional plugin modules
if (essb_options_bool_value('opengraph_tags') || essb_options_bool_value('twitter_card')) {
	//include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-optimization/essb-social-share-optimization-frontend.php');
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-optimization/class-metadetails.php');
	if (essb_options_bool_value('opengraph_tags')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-optimization/class-opengraph.php');
		
		if (class_exists('WooCommerce', false)) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-optimization/class-woocommerce.php');
		}
	}
	if (essb_options_bool_value('twitter_card')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-optimization/class-twittercards.php');
	}
	define('ESSB3_SSO_ACTIVE', true);
}

if (essb_options_bool_value('stats_active')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-analytics/essb-social-share-analytics.php');
	define('ESSB3_SSA_ACTIVE', true);
}

if (essb_options_bool_value('mycred_activate')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/mycred/essb-mycred-integration.php');
	define('ESSB3_MYCRED_ACTIVE', true);
	ESSBMyCredIntegration::get_instance();
}

if (essb_options_bool_value('mycred_activate_custom')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/mycred/essb-mycred-custom-hook.php');
	define('ESSB3_MYCRED_CUSTOM_ACTIVE', true);
}

if (essb_options_bool_value('afterclose_active')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/after-share-close/essb-after-share-close.php');
	define('ESSB3_AFTERSHARE_ACTIVE', true);
}
else{
	if (ESSB3_DEMO_MODE) {
		$is_active_option = isset($_REQUEST['aftershare']) ? $_REQUEST['aftershare'] : '';
		if ($is_active_option != '') {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/after-share-close/essb-after-share-close.php');
			define('ESSB3_AFTERSHARE_ACTIVE', true);
			
		}
	}
}

if (ESSBOptionValuesHelper::is_active_module('imageshare')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-image-share/essb-social-image-share.php');
	define('ESSB3_IMAGESHARE_ACTIVE', true);
}

if (!defined('ESSB3_LIGHTMODE')) {
	if (essb_options_bool_value('profiles_display')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles.php');
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles-helper.php');
		define('ESSB3_SOCIALPROFILES_ACTIVE', 'true');
	}
	// Social Profiles Widget is always available
	if (essb_option_bool_value('profiles_widget')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles-widget.php');
	}
}

if (essb_options_bool_value('fanscounter_active')) {
	define('ESSB3_SOCIALFANS_ACTIVE', 'true');
	
	global $essb_socialfans_options;
	$essb_socialfans_options = get_option(ESSB3_OPTIONS_NAME_FANSCOUNTER);
	
	if (has_filter('essb4_followeroptions_extender')) {
		$essb_socialfans_options = apply_filters('essb4_followeroptions_extender', $essb_socialfans_options);
	}
	
	
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/essb-social-followers-counter-helper.php');
	
	// if options does not exist we intialize the default settings
	if (!is_array($essb_socialfans_options)) { 
		$essb_socialfans_options = array();
		$essb_socialfans_options['expire'] = 1400;
		$essb_socialfans_options['format'] = 'short';
		
		// apply default values from structure helper
		$essb_socialfans_options = ESSBSocialFollowersCounterHelper::create_default_options_from_structure($essb_socialfans_options);
	}
	
		// include widget class
		
	if (!essb_option_bool_value('fanscounter_widget_deactivate')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/essb-social-followers-counter-widget.php');
	}
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/essb-social-followers-counter.php');
}

if (!defined('ESSB3_LIGHTMODE')) {
	if (essb_options_bool_value('esml_active')) {
		if (!defined('ESSB3_ESML_ACTIVE')) {
			define('ESSB3_ESML_ACTIVE', 'true');
		}
		
		if (is_admin()) {
			include_once(ESSB3_PLUGIN_ROOT . 'lib/modules/social-metrics/class-socialmetrics.php');
		}
		include_once(ESSB3_PLUGIN_ROOT . 'lib/modules/social-metrics/socialmetrics-functions.php');
	}
	
	if (essb_options_bool_value('esml_top_posts_widget')) {
		define('ESSB3_ESML_TOPPOSTS_ACTIVE', 'true');
		include_once(ESSB3_PLUGIN_ROOT . 'lib/modules/top-posts-widget/essb-top-posts-widget.php');	
	}
}

if (ESSBOptionValuesHelper::is_active_module('cachedcounters')) {
	define('ESSB3_CACHED_COUNTERS', true);
	include_once(ESSB3_PLUGIN_ROOT . 'lib/core/share-counters/essb-cached-counters.php');	
	
	if (essb_options_bool_value('counter_recover_active')) {
		define('ESSB3_SHARED_COUNTER_RECOVERY', true);
		include_once(ESSB3_PLUGIN_ROOT . 'lib/core/share-counters/essb-sharecounter-recovery.php');	
	}
}

// click to tweet module
if (!essb_options_bool_value('deactivate_ctt')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/click-to-tweet/essb-click-to-tweet.php');
}

if (essb_option_bool_value('optin_content_activate')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/optin-below-content/optin-below-content.php');
}


if (essb_option_bool_value('optin_flyout_activate')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/optin-flyout/class-optin-flyout.php');
}

if (essb_option_bool_value('optin_booster_activate')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/optin-booster/class-optin-booster.php');
}

if (essb_option_bool_value('fbmessenger_active')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-chat/essb-messenger-live-chat.php');
}

if (essb_option_bool_value('skype_active')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-chat/essb-skype-live-chat.php');
}


// visual composer element bridge
if (function_exists('vc_map')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/visual-composer/essb-visual-composer-map.php');
}

// WPML Bridge
if (essb_installed_wpml() || essb_installed_polylang()) {
	include_once(ESSB3_PLUGIN_ROOT . 'lib/core/essb-wpml-bridge.php');
	if (!is_admin()) {
		if (has_filter('essb4_options_multilanguage')) {
			$essb_options = apply_filters('essb4_options_multilanguage', $essb_options);
		}
		
		if (defined('ESSB3_SOCIALFANS_ACTIVE')) {
			if (has_filter('essb4_followeroptions_multilanguage')) {
				$essb_socialfans_options = apply_filters('essb4_followeroptions_multilanguage', $essb_socialfans_options);
			}
		}
	}
}

if (essb_option_bool_value('amp_positions')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/amp-sharing/essb-amp-sharebuttons.php');	
}

if (essb_option_value('functions_mode_mobile') == 'auto') {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-automatic-mobile.php');	
}

if (essb_option_bool_value('activate_fake')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/fake-share-counters/fakesharecounters-front.php');
}

if (essb_option_bool_value('activate_minimal')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/fake-share-counters/minimalsharecounters-front.php');
}

if (essb_option_bool_value('activate_hooks')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/custom-hooks-integration/hookintegrations-helper.php');
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/custom-hooks-integration/hookintegrations-class.php');
}

if (essb_option_bool_value('conversions_lite_run')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/conversions-lite/class-conversions-lite.php');	
}

if (essb_option_bool_value('conversions_subscribe_lite_run')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/conversions-lite/class-subscribe-conversions-lite.php');
}

if (class_exists('REALLY_SIMPLE_SSL')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/core/integrations/reallysimplessl.php');
}

if (has_filter('essb4_options_extender_after_load')) {
	$essb_options = apply_filters('essb4_options_extender_after_load', $essb_options);
}

include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-core-helper.php');
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-button-helper.php');
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-shortcode-mapper.php');
include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-actions-mapper.php');
include_once (ESSB3_PLUGIN_ROOT . 'lib/essb-core.php');

?>