<?php

class ESSBActivationManager {
	private static $option = 'essb4-activation';
	private static $api = 'https://api.socialsharingplugin.com/'; //"http://localhost:8081/work/activation/";
	private static $manager_url = 'http://activation.socialsharingplugin.com/manage/'; //"http://localhost:8081/work/activation_front/manage/";
	private static $activate_url = 'https://activation.socialsharingplugin.com/';
	private static $option_data;
	private static $option_latest_version = 'essb4-latest-version';
	private static $latest_version;
	private static $benefit_url = "https://socialsharingplugin.com/direct-customer-benefits/";
	
	private static function load() {
		//if (!self::$option_data) {
		$activation_data = get_option(self::$option);
			
		if (!$activation_data) {
			$activation_data = array();
		}
			
		self::$option_data = $activation_data;
		//}
		
		self::$latest_version = get_option(self::$option_latest_version);
		if (!self::$latest_version) {
			self::$latest_version = ESSB3_VERSION;
		}
	}
	
	public static function init() {
		self::load();
	}
	
	public static function saveVersion($version = '') {
		if ($version != '') {
			update_option(self::$option_latest_version, $version);
			self::$latest_version = $version;
		}
	}
	
	public static function existNewVersion() {
		if (version_compare ( ESSB3_VERSION, self::$latest_version, '<' )) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function getLatestVersion() {
		return self::$latest_version;
	}
	
	public static function getApiUrl($callback = '') {
		if ($callback == 'manager') {
			return self::$manager_url;
		}
		else if ($callback == 'activate') {
			return self::$activate_url;
		}
		else if ($callback == 'api') {
			return self::$api;
		}
		else {
			return self::$api;
		}
	}
	
	public static function activateManual($purchase_code = '', $activation_code = '', $domain = '') {
		$encrypted = hash ( 'sha1', $purchase_code . $domain );
		
		if ($encrypted == $activation_code) {
			self::activate($purchase_code, $activation_code);
			return '100';
		}
		else {
			return '200';
		}
	}
	
	public static function activate($purchase_code = '', $activation_code = '') {
		if (!self::$option_data) {
			self::$option_data = array();
		}
		
		if (!is_array(self::$option_data)) {
			self::$option_data = array();
		}
		
		self::$option_data['activated'] = 'true';
		self::$option_data['purchase_code'] = $purchase_code;
		self::$option_data['activation_code'] = $activation_code;
		
		update_option(self::$option, self::$option_data);
	}
	
	public static function deactivate() {
		if (!self::$option_data) {
			self::$option_data = array();
		}
	
		if (!is_array(self::$option_data)) {
			self::$option_data = array();
		}
	
		self::$option_data['activated'] = 'false';
		self::$option_data['activation_code'] = '';
		update_option(self::$option, self::$option_data);
	}
	
	public static function isActivated() {
		$isActivated = false;
		
		if (self::$option_data) {
			if (is_array(self::$option_data)) {
				$state = isset(self::$option_data['activated']) ? self::$option_data['activated'] : '';
				if ($state == 'true') {
					$isActivated = true;
				}
			}
		}
		
		
		return $isActivated;
	}
	
	/***
	 * Control plugin theme integration to stop notice that plugin is not activated
	 * 
	 * @return boolean Integration state
	 */
	public static function isThemeIntegrated() {
		$is_integrated = false;
		
		return apply_filters('essb_is_theme_integrated', $is_integrated);
	}
	
	public static function getPurchaseCode() {
		$purchase_code = '';
		if (self::$option_data) {
			if (is_array(self::$option_data)) {
				$purchase_code = isset(self::$option_data['purchase_code']) ? self::$option_data['purchase_code'] : '';
			}
		}
		
		if ($purchase_code == '') {
			$purchase_code = essb_option_value('purchase_code');
		}
		
		return $purchase_code;
	}
	
	public static function getActivationCode() {
		$activation_code = '';
		if (self::$option_data) {
			if (is_array(self::$option_data)) {
				$activation_code = isset(self::$option_data['activation_code']) ? self::$option_data['activation_code'] : '';
			}
		}
	
		return $activation_code;
	}
	
	public static function isStagingSite($domain) {
	
		$result = false;
	
		if (strpos($domain, '.local') !== false) {
			$result = true;
		}
		if (strpos($domain, '.localhost') !== false) {
			$result = true;
		}
		if (strpos($domain, '.dev') !== false) {
			$result = true;
		}
		if (strpos($domain, '.wpstagecoach') !== false) {
			$result = true;
		}
		if (strpos($domain, '.wpengine.com') !== false) {
			$result = true;
		}
		if (strpos($domain, '.pantheon.io') !== false) {
			$result = true;
		}
		if (strpos($domain, 'localhost') !== false) {
			$result = true;
		}
	
		return $result;
	}
	
	public static function domain() {
		$url = self::getSiteURL();
		$parse = parse_url($url);
		$domain_only = isset($parse['host']) ? $parse['host'] : ''; 
		
		return self::getDomain($domain_only);
	}
	
	public static function getDomain($domain) {
		if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)) {
			return $matches['domain'];
		} 
		else {
			return $domain;
		}
	}
	
	public static function getSiteURL() {
		return site_url();
	}
	
	public static function isDevelopment() {
		return self::isStagingSite(self::getSiteURL());
	}
	
	public static function getBenefitURL() {
		return self::$benefit_url;
	}
}


add_action ( 'wp_ajax_essb_process_activation', 'essb_action_process_activation' );

function essb_action_process_activation() {
	$purchase_code = isset($_REQUEST['purchase_code']) ? $_REQUEST['purchase_code'] : '';
	$activation_code = isset($_REQUEST['activation_code']) ? $_REQUEST['activation_code'] : '';
	$state = isset($_REQUEST['activation_state']) ? $_REQUEST['activation_state'] : '';
	$domain = isset($_REQUEST['domain']) ? $_REQUEST['domain'] : '';
	$version = isset($_REQUEST['version']) ? $_REQUEST['version'] : '';
	
	$execute_code = -1;
	
	if ($state == 'activate' && $purchase_code != '' && $activation_code != '') {
		ESSBActivationManager::activate($purchase_code, $activation_code);
		$execute_code = 1;
	}
	
	if ($state == 'deactivate') {
		ESSBActivationManager::deactivate();
		$execute_code = 2;
	}
	
	if ($state == 'manual' && $purchase_code != '' && $activation_code != '') {
		$execute_code = ESSBActivationManager::activateManual($purchase_code, $activation_code, $domain);
	}
	
	if ($state == 'version_check' && $version != '') {
		ESSBActivationManager::saveVersion($version);
		$execute_code = ESSBActivationManager::existNewVersion() ? ESSBActivationManager::getLatestVersion() : '';
	}
	
	die(json_encode(array('code' => $execute_code)));
	exit;
}
