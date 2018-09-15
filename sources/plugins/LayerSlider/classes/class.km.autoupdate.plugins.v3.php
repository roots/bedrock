<?php

/**
 * Subclass of KM_Updates for plugins
 *
 * @package KM_Updates
 * @since 4.6.3
 * @author John Gera
 * @copyright Copyright (c) 2013  John Gera, George Krupa, and Kreatura Media Kft.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 */

require_once dirname(__FILE__) . '/class.km.autoupdate.v3.php';

class KM_PluginUpdatesV3 extends KM_UpdatesV3 {

	public function __construct($config) {

		// Set up auto updater
		parent::__construct($config);

		// Hook into Plugins API
		add_filter('pre_set_site_transient_update_plugins', array(&$this, 'set_update_transient'));
		add_filter('plugins_api', array(&$this, 'set_updates_api_results'), 10, 3);
		add_filter('upgrader_pre_download', array(&$this, 'pre_download_filter' ), 10, 4);

		// AJAX actions for site authorization
		add_action('wp_ajax_layerslider_authorize_site', array(&$this, 'handleActivation'));
		add_action('wp_ajax_layerslider_deauthorize_site', array(&$this, 'handleDeactivation'));
	}
}
