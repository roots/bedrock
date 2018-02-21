<?php

/*
* Plugin Name: Easy Social Share Buttons for WordPress
* Description: Easy Social Share Buttons automatically adds beautiful share buttons to all your content with support of Facebook, Twitter, Google+, LinkedIn, Pinterest, Digg, StumbleUpon, VKontakte, Tumblr, Reddit, Print, E-mail and more than 40 other social networks and mobile messengers. Easy show on 27+ automatic display locations or use powerful shortcodes. Compatible with most popular e-commerce plugins, social plugins and affiliate plugins
* Plugin URI: http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo
* Version: 5.3
* Author: CreoApps
* Author URI: http://codecanyon.net/user/appscreo/portfolio?ref=appscreo
*/


if (! defined ( 'WPINC' ))
	die ();

//error_reporting( E_ALL | E_STRICT );

define ( 'ESSB3_SELF_ENABLED', false );

define ( 'ESSB3_VERSION', '5.3' );
define ( 'ESSB3_PLUGIN_ROOT', dirname ( __FILE__ ) . '/' );
define ( 'ESSB3_PLUGIN_URL', plugins_url () . '/' . basename ( dirname ( __FILE__ ) ) );
define ( 'ESSB3_PLUGIN_BASE_NAME', plugin_basename ( __FILE__ ) );
define ( 'ESSB3_OPTIONS_NAME', 'easy-social-share-buttons3');
define ( 'ESSB3_WPML_OPTIONS_NAME', 'easy-social-share-buttons3-wpml');
define ( 'ESSB3_NETWORK_LIST', 'easy-social-share-buttons3-networks');
define ( 'ESSB3_OPTIONS_NAME_FANSCOUNTER', 'easy-social-share-buttons3-fanscounter');
define ( 'ESSB3_EASYMODE_NAME', 'essb3-easymode');
define ( 'ESSB3_FIRST_TIME_NAME', 'essb3-firsttime');
define ( 'ESSB3_TEXT_DOMAIN', 'essb');
define ( 'ESSB3_TRACKER_TABLE', 'essb3_click_stats');
define ( 'ESSB3_MAIL_SALT', 'easy-social-share-buttons-mailsecurity');

define ( 'ESSB3_DEMO_MODE', true);
define ( 'ESSB3_ADDONS_ACTIVE', true);
define ( 'ESSB3_EASYMODE_ASKED', 'easy3-easymode-asked');
define ( 'ESSB3_ACTIVATION', true);
define ( 'ESSB3_WELCOME_TAB', false);
define ( 'ESSB3_CUSTOMIZER_CAN_RUN', true);
define ( 'ESSB3_SETTING5', true);


/**
 * Easy Social Share Buttons manager class to access all plugin features
 * 
 * @package EasySocialShareButtons
 * @author  appscreo
 * @since   3.4
 *
 */
class ESSB_Manager {
	
	/**
	 * Initialized as theme
	 * @since 3.4
	 */
	private $is_in_theme = false;
	
	/**
	 * Disable automatic plugin updates
	 * @since 3.4
	 */
	private $disable_updater = false;
	
	/**
	 * Component factory
	 * @since 3.4
	 */
	private $factory = array();
	
	/**
	 * Plugin settings for faster access
	 * @since 3.4
	 */
	public $settings;
	
	/**
	 * Is mobile device
	 * @var bool
	 * @since 3.4.2
	 */
	private $is_mobile = false;
	
	/**
	 * Is tablet device
	 * @var bool
	 * @since 3.4.2
	 */
	private $is_tablet = false;		
	
	/**
	 * Handle state of checked for mobile device 
	 * @var bool
	 * @since 3.4.2
	 */
	private $mobile_checked = false;
	
	private static $_instance;
	
	private function __construct() {
		// include the helper factory to get access to main plugin component
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-helpers-factory.php');
		
		// default plugin options
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/options/essb-options-defaults.php');
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/options/essb-admin-options-defaults.php');
		
		// activation/deactivation hooks
		register_activation_hook ( __FILE__, array ('ESSB_Manager', 'activate' ) );
		register_deactivation_hook ( __FILE__, array ('ESSB_Manager', 'deactivate' ) );

		// initialize plugin
		add_action( 'init', array( &$this, 'init' ), 9);
		add_action( 'plugins_loaded', array( &$this, 'load_widgets' ), 9);
		
		if (is_admin()) {
			if (!defined('ESSB3_AVOID_WELCOME') && !$this->isInTheme()) {
				function essb_page_welcome_redirect() {
					$redirect = get_transient( '_essb_page_welcome_redirect' );
					delete_transient( '_essb_page_welcome_redirect' );
					$redirect && wp_redirect( admin_url( 'admin.php?page=essb_redirect_about' ) );
				}
				add_action( 'init', 'essb_page_welcome_redirect' );
			}
		}
	}
	
	/**
	 * Get static instance of class
	 * 
	 * @return ESSB_Manager
	 */
	public static function getInstance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}
	
		return self::$_instance;
	}
	
	
	/**
	 * Cloning disabled
	 */
	public function __clone() {
	}
	
	/**
	 * Serialization disabled
	 */
	public function __sleep() {
	}
	
	/**
	 * De-serialization disabled
	 */
	public function __wakeup() {
	}
	
	/**
	 * Initialize plugin load
	 */
	public function init() {		
		
		// @since 4.2 option to disable translations
		if (!essb_option_bool_value('disable_translation')) {
			load_plugin_textdomain('essb', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
		}
		
		$this->resourceBuilder();		
		$this->essb();
		
		// Social share optimization
		if (defined('ESSB3_SSO_ACTIVE')) {
			if (class_exists('ESSB_OpenGraph')) {
				$this->factoryOnlyActivate('sso_og', 'ESSB_OpenGraph');
			}
			if (class_exists('ESSB_WooCommerceOpenGraph')) {
				$this->factoryOnlyActivate('sso_og_woo', 'ESSB_WooCommerceOpenGraph');
			}
			if (class_exists('ESSB_TwitterCards')) {
				$this->factoryOnlyActivate('sso_tc', 'ESSB_TwitterCards');
			}
		}
		
		// Social Share Analytics		
		if (defined('ESSB3_SSA_ACTIVE')) {
			$tracker = ESSBSocialShareAnalytics::get_instance();
			$this->resourceBuilder()->add_js($this->socialShareAnalytics()->generate_tracker_code(), true, 'essb-stats-tracker');
		}
		
		// After Share Actions
		if (defined('ESSB3_AFTERSHARE_ACTIVE')) {		
			$this->factoryOnlyActivate('asc', 'ESSBAfterCloseShare3');		
		}
				
		// On Media Sharing
		if (defined('ESSB3_IMAGESHARE_ACTIVE')) {
			$this->factoryOnlyActivate('essbis', 'ESSBSocialImageShare');
			essb_depend_load_function('essb_rs_css_build_imageshare_customizer', 'lib/core/resource-snippets/essb_rs_css_build_imageshare_customizer.php');
				
		}
				
		// Social Profiles
		if (!defined('ESSB3_LIGHTMODE')) {
			if (defined('ESSB3_SOCIALPROFILES_ACTIVE')) {
				$this->factoryOnlyActivate('essbsp', 'ESSBSocialProfiles');
			}
		}
		
		// Followers Counter
		if (defined('ESSB3_SOCIALFANS_ACTIVE')) {
			$this->factoryActivate('essbfc', 'ESSBSocialFollowersCounter');
			essb_depend_load_function('essb_rs_css_build_followerscounter_customizer', 'lib/core/resource-snippets/essb_rs_css_build_followerscounter_customizer.php');
		}
		
		if (!defined('ESSB3_LIGHTMODE')) {
			if (defined('ESSB3_NATIVE_ACTIVE')) {
				// Social Privacy Buttons when active include resources
				$essb_spb = ESSBSocialPrivacyNativeButtons::get_instance();
				ESSBNativeButtonsHelper::$essb_spb = $essb_spb;
				foreach ($this->privacyNativeButtons()->resource_files as $key => $object) {
					$this->resourceBuilder()->add_static_resource($object['file'], $object['key'], $object['type']);
				}
				foreach (ESSBSkinnedNativeButtons::get_assets() as $key => $object) {
					$this->resourceBuilder()->add_static_resource($object['file'], $object['key'], $object['type']);
				}
				$this->resourceBuilder()->add_css(ESSBSkinnedNativeButtons::generate_skinned_custom_css(), 'essb-skinned-native-buttons');
					
				// asign instance of native buttons privacy class to helper
					
				// register active social network apis
				foreach (ESSBNativeButtonsHelper::get_list_of_social_apis() as $key => $code) {
					$this->resourceBuilder()->add_social_api($key);
				}
			}
		}
		
		// @since 4.2 Live Customizer Initialization
		if (ESSB3_CUSTOMIZER_CAN_RUN) {
			if (essb_live_customizer_can_run()) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/essb-live-customizer.php');
				$this->factoryOnlyActivate('essb_live_customizer', 'ESSBLiveCustomizer');
			}
		}
		
		if (is_admin()) {
			$this->asAdmin();
		}
		
	}
	
	
	
	/**
	 * Load plugin active widgets based on user settings
	 */
	public function load_widgets() {
		// include the main plugin required files
		include_once (ESSB3_PLUGIN_ROOT . 'lib/essb-core-includes.php');

		ESSBActivationManager::init();
		
		if (is_admin()) {
				
			global $essb_options;
			$exist_user_purchase_code = isset($essb_options['purchase_code']) ? $essb_options['purchase_code'] : '';
		
			//if (!empty($exist_user_purchase_code) && !$this->isInTheme()) {
			if (ESSBActivationManager::isActivated() && !$this->isInTheme()) {
		
				include (ESSB3_PLUGIN_ROOT . 'lib/external/autoupdate/plugin-update-checker.php');
				// @since 1.3.3
				// autoupdate
				// activating autoupdate option
				$essb_autoupdate = PucFactory::buildUpdateChecker ( 'http://update.creoworx.com/essb3/', __FILE__, 'easy-social-share-buttons3' );
				// @since 1.3.7.2 - update to avoid issues with other plugins that uses same
				// method
				function addSecretKeyESSB3($query) {
					global $exist_user_purchase_code;
					$query ['license'] = ESSBActivationManager::getActivationCode();
					$query ['purchase_code'] = ESSBActivationManager::getPurchaseCode();
					return $query;
				}
				$essb_autoupdate->addQueryArgFilter ( 'addSecretKeyESSB3' );
			}
		
		}
	}
	
	/**
	 * setIsInTheme
	 * 
	 * Tell plugin that is loaded in theme - disable automatic updates and disable redirect after install
	 * @param bool $value
	 */
	public function setIsInTheme ( $value = true) {
		$this->is_in_theme = (boolean) $value;
	}
	
	public function isInTheme () {
		return (boolean) $this->is_in_theme;
	}
	
	public function disableUpdates() {
		$this->disable_updater = true;
	}
	
	public function resourceBuilder() {
		if (!isset($this->factory['resource_builder'])) {
			$this->factory['resource_builder'] = new ESSBResourceBuilder();
		}
		
		return $this->factory['resource_builder'];
	}
	
	public function essb() {
		if (!isset($this->factory['essb'])) {
			$this->factory['essb'] = new ESSBCore();
		}
		
		return $this->factory['essb'];
	}
	
	public function socialShareAnalytics() {
		if (!isset($this->factory['ssa'])) {
			$this->factory['ssa'] = new ESSBSocialShareAnalytics;
		}
		
		return $this->factory['ssa'];
	}
	
	public function afterShareActions() {
		if (!isset($this->factory['asc'])) {
			$this->factory['asc'] = new ESSBAfterCloseShare3;
		}
		
		return $this->factory['asc'];
	}
		
	public function privacyNativeButtons() {
		if (!isset($this->factory['nativeprivacy'])) {
			$this->factory['nativeprivacy'] = new ESSBSocialPrivacyNativeButtons;
		}
		
		return $this->factory['nativeprivacy'];
	}
	
	public function socialFollowersCounter() {
		if (!isset($this->factory['essbfc'])) {
			$this->factory['essbfc'] = new ESSBSocialFollowersCounter;
		}
		
		return $this->factory['essbfc'];
	}
	
	public function deactiveExecution() {
		$this->essb()->temporary_deactivate_content_filters();
	}
	
	public function reactivateExecution() {
		$this->essb()->reactivate_content_filters_after_temporary_deactivate();
	}
	
	public function essbOptions() {
		if (!isset($this->settings)) {
			$this->settings = get_option(ESSB3_OPTIONS_NAME);
		}
		
		return $this->settings;
	}
		
	public function optionsBoolValue($param) {
		$value = isset ( $this->settings [$param] ) ? $this->settings [$param]  : 'false';
	
		if ($value == 'true') {
			return true;
		}
		else {
			return false;
		}	
	}
	
	/**
	 * isMobile
	 * 
	 * Checks and return state of mobile device detected
	 * 
	 * @return boolean
	 * @since 3.4.2
	 */
	public function isMobile() {
		if (!$this->mobile_checked) {
			$this->mobile_checked = true;
			$mobile_detect = new ESSB_Mobile_Detect();
			
			$this->is_mobile = $mobile_detect->isMobile();
			$this->is_tablet = $mobile_detect->isTablet();
			
			if (essb_option_bool_value('mobile_exclude_tablet') && $this->is_tablet) {
				$this->is_mobile = false;
			}
			unset($mobile_detect);
			
			return $this->is_mobile;
		}
		else {
			return $this->is_mobile;
		}
	}
	
	public function isTablet() {
		if (!$this->mobile_checked) {
			$this->mobile_checked = true;
			$mobile_detect = new ESSB_Mobile_Detect();
				
			$this->is_mobile = $mobile_detect->isMobile();
			$this->is_tablet = $mobile_detect->isTablet();
				
			unset($mobile_detect);
			
			return $this->is_tablet;
		}
		else {
			return $this->is_tablet;
		}
	}
	
	
	/**
	 * Run admin part of code, when user with admin capabilites is detected
	 * 
	 * @since 3.4
	 */
	protected function asAdmin() {
		
		include_once (ESSB3_PLUGIN_ROOT . 'lib/admin/essb-admin-includes.php');
		$this->factoryOnlyActivate('essb_admin', 'ESSBAdminControler');
		
	}
	
	/**
	 * factoryActivate
	 * 
	 * Load plugin component into main class
	 * 
	 * @param string $module
	 * @param object $class_name
	 * @since 3.4
	 */
	public function factoryActivate($module = '', $class_name) {
		if (!empty($module) && !isset($this->factory[$module])) {
			$this->factory[$module] = new $class_name;
		}
	}
	
	/**
	 * Activate secondary class inside factory loader but without store in memory
	 * 
	 * @param string $module
	 * @param string $class_name
	 * @since 4.2
	 */
	public function factoryOnlyActivate($module = '', $class_name) {
		if (!empty($module) && !isset($this->factory[$module])) {
			$this->factory[$module] = true;
			new $class_name;
		}
	}
	
	/*
	 * Static activation/deactivation hooks
	 */
	
	public static function activate() {
		
		include_once(ESSB3_PLUGIN_ROOT . 'activate.php');
		essb_active_oninstall();
	
		// activate redirection hook
		if ( ! is_network_admin() ) {
			set_transient( '_essb_page_welcome_redirect', 1, 30 );
		}
	}
	
	public static function convert_ready_made_option($options) {
		$options = base64_decode ( $options );
	
		$options = htmlspecialchars_decode ( $options );
		$options = stripslashes ( $options );
	
		if ($options != '') {
			$imported_options = json_decode ( $options, true );
	
			return $imported_options;
		}
		else {
			return null;
		}
	}
	
	public static function deactivate() {
		delete_option(ESSB3_MAIL_SALT);
	}
}

/**
 * Initialize plugin with main global instace of ESSB_Manager
 * 
 * @since 3.4
 */

global $essb_manager;
if (!$essb_manager) {
	$essb_manager = ESSB_Manager::getInstance();
}