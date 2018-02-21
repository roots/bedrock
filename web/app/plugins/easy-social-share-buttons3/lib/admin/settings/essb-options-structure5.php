<?php
if (!class_exists('ESSBSocialFollowersCounterHelper')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/essb-social-followers-counter-helper.php');
}

if (!class_exists('ESSBSocialProfilesHelper')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles-helper.php');
}

include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-admin-options-helper5.php');


$essb_navigation_tabs = array();
$essb_sidebar_sections = array();
$essb_sidebar_sections = array();

$essb_options = essb_options();

ESSBOptionsStructureHelper::init();
//if (essb_show_welcome()) {
//	ESSBOptionsStructureHelper::tab('welcome', __('Welcome', 'essb'), __('Welcome to Easy Social Share Buttons for WordPress', 'essb'), 'ti-lock', 'right', true, true, false, true);
//}
ESSBOptionsStructureHelper::tab('social', __('Social Sharing', 'essb'), __('Social Sharing', 'essb'), 'ti-sharethis');
ESSBOptionsStructureHelper::tab('where', __('Where to Display', 'essb'), __('Where to Display', 'essb'), 'ti-layout');

if (!essb_option_bool_value('deactivate_module_natives') || 
		!essb_option_bool_value('deactivate_module_profiles') || 
		!essb_option_bool_value('deactivate_module_followers') ||
		!essb_option_bool_value('deactivate_module_facebookchat') ||
		!essb_option_bool_value('deactivate_module_skypechat')) {
	ESSBOptionsStructureHelper::tab('display', __('Social Follow & Chat', 'essb'), __('Social Follow & Chat', 'essb'), 'ti-heart');
}

if (!essb_option_bool_value('deactivate_module_subscribe')) {
	ESSBOptionsStructureHelper::tab('optin', __('Subscribe Forms', 'essb'), __('Subscribe Forms', 'essb'), 'ti-email');
}
ESSBOptionsStructureHelper::tab('advanced', __('Advanced Settings', 'essb'), __('Advanced Settings', 'essb'), 'ti-settings');
ESSBOptionsStructureHelper::tab('style', __('Style Settings', 'essb'), __('Style Settings', 'essb'), 'ti-palette');
ESSBOptionsStructureHelper::tab('shortcode', __('Shortcode Generator', 'essb'), __('Shortcode Generator', 'essb'), 'ti-shortcode', '', true);
if (essb_option_bool_value('stats_active')) {
	ESSBOptionsStructureHelper::tab('analytics', __('Analytics', 'essb'), __('Analytics', 'essb'), 'ti-stats-up', '', true);
}

if (!essb_option_bool_value('deactivate_module_conversions')) {
	ESSBOptionsStructureHelper::tab('conversions', __('Conversions Lite', 'essb'), __('Conversions Lite', 'essb'), 'ti-dashboard', '');
	
}

if (essb_option_bool_value('activate_hooks') || essb_option_bool_value('activate_fake') || essb_option_bool_value('activate_minimal')) {
	ESSBOptionsStructureHelper::tab('developer', __('Developer Tools', 'essb'), __('Developer Tools', 'essb'), 'ti-server');

}


ESSBOptionsStructureHelper::tab('import', __('Import / Export', 'essb'), __('Import / Export Plugin Configuration', 'essb'), 'ti-reload', 'right', true);


if (defined('ESSB3_ACTIVATION')) {
	ESSBOptionsStructureHelper::tab('update', __('Activate', 'essb'), __('Activate Easy Social Share Buttons for WordPress', 'essb'), 'ti-lock', 'right', true, false, false, true);
}
else {
	ESSBOptionsStructureHelper::tab('update', __('Activate', 'essb'), __('Activate Easy Social Share Buttons for WordPress', 'essb'), 'ti-lock', 'right', false, false, false, true);
}

ESSBOptionsStructureHelper::tab('quick', __('Quick Setup', 'essb'), __('Quick Setup Wizard', 'essb'), 'fa fa-cog', '', false, true, false, true);

if (essb_option_value('functions_mode') != 'light') {
	ESSBOptionsStructureHelper::tab('readymade', __('Ready Made Styles', 'essb'), __('Apply Ready Made Styles', 'essb'), 'ti-brush', '', true, false, true);
}

ESSBOptionsStructureHelper::tab('status', __('System Status', 'essb'), __('System Status', 'essb'), 'ti-receipt', '', true, false, true);

if (essb_option_value('functions_mode') != 'light') {
	ESSBOptionsStructureHelper::tab('extensions', __('Extensions', 'essb'), __('Extensions', 'essb'), 'ti-package', '', true, false, true);
}

if (essb_installed_wpml() || essb_installed_polylang()) {
	ESSBOptionsStructureHelper::tab('translate', __('Multilingual Translate', 'essb'), __('Multilingual Translate', 'essb'), 'fa fa-globe', '', !ESSBActivationManager::isActivated(), false, false, false);
}

ESSBOptionsStructureHelper::tab('about', __('About', 'essb'), __('About', 'essb'), 'ti-info-alt', '', true, false, true);

ESSBOptionsStructureHelper::tab('modes', __('Switch Plugin Modes', 'essb'), __('Switch Plugin Modes', 'essb'), 'ti-info-alt', '', false, true, false, true);
ESSBOptionsStructureHelper::tab('functions', __('Manage Plugin Functions', 'essb'), __('Manage Plugin Functions', 'essb'), 'ti-info-alt', '', false, true, false, true);

ESSBOptionsStructureHelper::tab('support', __('Need Help?', 'essb'), __('Need Help?', 'essb'), 'ti-info-alt', '', true, true, false, true);

//-- menu
$user_active_tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : '';

$active_settings_page = isset ( $_REQUEST ['page'] ) ? $_REQUEST ['page'] : '';
if (strpos ( $active_settings_page, 'essb_redirect_' ) !== false) {
	$options_page = str_replace ( 'essb_redirect_', '', $active_settings_page );
	// print $options_page;
	// print admin_url ( 'admin.php?page=essb_options&tab=' . $options_page );
	if ($options_page != '') {
		$user_active_tab = $options_page;
	}
}

if ($user_active_tab == "quick") {
	include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-wizard.php');
}
if ($user_active_tab == "readymade") {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-options-structure-readymade.php');
}

//include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-admin-options-social.php');
//include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-admin-options-follow.php');
//include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-admin-options-legacy.php');


// version 5 options structure
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-functions.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-sharing.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-where.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-follow.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-subscribe.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-advanced.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-style.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-import.php');
include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-activation.php');
if (essb_option_bool_value('activate_hooks') || essb_option_bool_value('activate_fake') || essb_option_bool_value('activate_minimal')) {
	include_once(ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-developer.php');
}

if ($user_active_tab == "translate") {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-admin-options-wpml.php');
}
