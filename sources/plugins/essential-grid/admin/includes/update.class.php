<?php
/**
 * Update Class For Essential Grid
 * Enables automatic updates on the Plugin
 *
 * @package Essential_Grid_Admin
 * @author  ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Update {

	private $plugin_url			= 'http://codecanyon.net/item/essential-grid-wordpress-plugin/7563340';
	private $remote_url			= 'http://updates.themepunch.tools/check_for_updates.php';
	private $remote_url_info	= 'http://updates.themepunch.tools/essential-grid/essential-grid.php';
	private $plugin_slug		= 'essential-grid';
	private $plugin_path		= 'essential-grid/essential-grid.php';
	private $version;
	private $plugins;
	private $option;
	
	
	public function __construct($version) {
	
		$this->option = $this->plugin_slug . '_update_info';
		$this->_retrieve_version_info();
		$this->version = $version;
		
	}
	
	public function add_update_checks(){
		
		add_filter('pre_set_site_transient_update_plugins', array(&$this, 'set_update_transient'));
		add_filter('plugins_api', array(&$this, 'set_updates_api_results'), 10, 3);
		
	}
	
	public function set_update_transient($transient) {
	
		$this->_check_updates();

		if(!isset($transient->response)) {
			$transient->response = array();
		}

		if(!empty($this->data->basic) && is_object($this->data->basic)) {
			if(version_compare($this->version, $this->data->basic->version, '<')) {

				$this->data->basic->new_version = $this->data->basic->version;
				$transient->response[$this->plugin_path] = $this->data->basic;
			}
		}
		
		return $transient;
	}


	public function set_updates_api_results($result, $action, $args) {
	
		$this->_check_updates();

		if(isset($args->slug) && $args->slug == $this->plugin_slug && $action == 'plugin_information') {
			if(is_object($this->data->full) && !empty($this->data->full)) {
				$result = $this->data->full;
			}
		}
		
		return $result;
	}


	protected function _check_updates() {
		//reset saved options
		//update_option($this->option, false);
		
		$force = false;
		
		if(isset($_GET['checkforupdates']) && $_GET['checkforupdates'] == 'true') $force = true;
		
		// Get data
		if(empty($this->data)) {
			$data = get_option($this->option, false);
			$data = $data ? $data : new stdClass;
			
			$this->data = is_object($data) ? $data : maybe_unserialize($data);
			
		}
		
		$last_check = get_option('tp_eg_update-check');
		if($last_check == false){
			$last_check = time();
			update_option('tp_eg_update-check', $last_check);
		}
		
		// Check for updates
		if(time() - $last_check > 14400 || $force == true){
			$data = $this->_retrieve_update_info();
			
			if(isset($data->basic)) {
				update_option('tp_eg_update-check', time());
				
				$this->data->checked = time();
				$this->data->basic = $data->basic;
				$this->data->full = $data->full;
				
				update_option('tp_eg_latest-version', $data->full->version);
			}
			
		}
		
		// Save results
		update_option($this->option, $this->data);
	}


	public function _retrieve_update_info() {

		global $wp_version;
		$data = new stdClass;

		// Build request
		$code = get_option('tp_eg_code', '');
		
		$request = wp_remote_post($this->remote_url_info, array(
			'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
			'body' => array(
				'code' => urlencode($code),
				'product' => urlencode('essential-grid'),
				'version' => urlencode(Essential_Grid::VERSION)
			)
		));
		
		if(!is_wp_error($request)) {
			if($response = maybe_unserialize($request['body'])) {
				if(is_object($response)) {
					$data = $response;
					
					$data->basic->url = $this->plugin_url;
					$data->full->url = $this->plugin_url;
					$data->full->external = 1;
				}
			}
		}
		
		return $data;
	}
	
	
	public function _retrieve_version_info($force = false) {
		global $wp_version;
		
		$last_check = get_option('tp_eg_update-check-short');
		if($last_check == false){
			$last_check = time();
			update_option('tp_eg_update-check-short', $last_check);
		}
		
		// Check for updates
		if(time() - $last_check > 14400 || $force == true){
			update_option('tp_eg_update-check-short', time());
			
			$response = wp_remote_post($this->remote_url, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => array(
					'item' => urlencode('essential-grid'),
					'version' => urlencode(Essential_Grid::VERSION)
				)
			));
			
			$response_code = wp_remote_retrieve_response_code( $response );
			$version_info = wp_remote_retrieve_body( $response );
			
			$version_info = json_decode($version_info);
			
			if ( $response_code != 200 || is_wp_error( $version_info ) ) {
				update_option('essential-connection', false);
				return false;
			}else{
				update_option('essential-connection', true);
			}
			
			if(isset($version_info->stable)){
				update_option('essential-stable-version', $version_info->stable);
			}
			
			if(isset($version_info->notices)){
				update_option('essential-notices', $version_info->notices);
			}
			
			if(isset($version_info->dashboard)){
				update_option('essential-dashboard', $version_info->dashboard);
			}

			if(isset($version_info->addons)){
				update_option('essential-addons', $version_info->addons);
			}
			
			update_option('tp_eg_latest-version', $version_info->version);
			
		}
		
	}
	
}

?>