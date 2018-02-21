<?php

/**
 * Manage and display metrics data inside WordPress admin dashboard
 * 
 * @author appscreo
 * @since 5.0
 * @package EasySocialShareButtons
 *
 */
class ESSBSocialMetrics {
	
	private $version = '3.0';
	
	public function __construct() {
		
		if (is_admin()) {
			add_action('admin_menu', array($this,'admin_menu_setup'));
		}
	}
	
	public function admin_menu_setup() {
		$visibility = essb_option_value('esml_access');
		
		if ($visibility == '') {
			$visibility = 'manage_options';
		}
		
		add_menu_page( __('Social Metrics by ESSB'), __('Social Metrics by ESSB'), $visibility, 'easy-social-metrics-lite', array($this, 'render_view'), 'dashicons-chart-bar' );
	}
	
	public function render_view() {
		require(ESSB3_PLUGIN_ROOT .'lib/modules/social-metrics/class-socialmetrics-data.php');
		require(ESSB3_PLUGIN_ROOT .'lib/modules/social-metrics/socialmetrics-draw.php');
		//esml_render_dashboard_view($this->options);
	} 
	
	
}

global $essb_sm;
if (defined('ESSB3_ESML_ACTIVE')) {
	$essb_sm = new ESSBSocialMetrics();
}