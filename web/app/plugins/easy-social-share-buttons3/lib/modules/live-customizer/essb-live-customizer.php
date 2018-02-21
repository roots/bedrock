<?php

/**
 * Provide front end options customization
 * 
 * @author appscreo
 * @package EasySocialShareButtons
 * @since 4.2
 *
 */

class ESSBLiveCustomizer {
	
	public function __construct() {
		
		add_action ( 'wp_enqueue_scripts', array (&$this, 'enqueue_scripts_and_styles' ) );
		add_action ( 'wp_footer', array (&$this, 'load_customizer' ) );
		
		add_action ( 'wp_ajax_essb_livecustomizer_options', array ($this, 'customizer_options' ) );
		add_action ( 'wp_ajax_essb_livecustomizer_save', array ($this, 'customizer_options_save' ) );
		add_action ( 'wp_ajax_essb_livecustomizer_get', array ($this, 'customizer_get' ) );
		add_action ( 'wp_ajax_essb_livecustomizer_set', array ($this, 'customizer_set' ) );
		add_action ( 'wp_ajax_essb_livecustomizer_get_meta', array ($this, 'customizer_get_meta' ) );
		add_action ( 'wp_ajax_essb_livecustomizer_set_meta', array ($this, 'customizer_set_meta' ) );
		add_action ( 'wp_ajax_essb_livecustomizer_preview', array($this, 'customizer_preview'));
		add_action ( 'wp_ajax_essb_livecustomizer_module', array($this, 'module_activation'));
		
	}
	
	public function enqueue_scripts_and_styles() {
		//	wp_enqueue_script ( 'essb-social-image-share', ESSB3_PLUGIN_URL . '/lib/modules/social-image-share/assets/js/easy-social-image-share.min.js', array ('jquery' ), false, true );
		//  wp_enqueue_style ( 'essb-fontawsome', ESSB3_PLUGIN_URL . '/assets/admin/font-awesome.min.css', array (), ESSB3_VERSION );
		
		if (essb_is_mobile()) {
			return;
		}
		
		// loading icons fonts used for customizer
		//if (!essb_option_bool_value('deactivate_fa')) {
			wp_enqueue_style ( 'essb-fontawsome', ESSB3_PLUGIN_URL . '/assets/admin/font-awesome.min.css', array (), ESSB3_VERSION );
		//}

		wp_enqueue_style ( 'essb-live-customizer-alerts', ESSB3_PLUGIN_URL.'/assets/admin/sweetalert.css', array (), ESSB3_VERSION );
		wp_enqueue_script ( 'essb-live-customizer-alerts', ESSB3_PLUGIN_URL . '/assets/admin/sweetalert.min.js', array ('jquery'), false, true);
		
		wp_enqueue_style ( 'essb-themifyicons', ESSB3_PLUGIN_URL . '/assets/admin/themify-icons.css', array (), ESSB3_VERSION );	
		wp_enqueue_style ( 'essb-live-customizer', ESSB3_PLUGIN_URL . '/lib/modules/live-customizer/assets/essb-live-customizer.css', array (), ESSB3_VERSION );	
		wp_enqueue_script ( 'essb-live-customizer', ESSB3_PLUGIN_URL . '/lib/modules/live-customizer/assets/essb-live-customizer.js', array ('jquery'), false, true);	
		wp_enqueue_style ( 'essb-live-customizer-animations', ESSB3_PLUGIN_URL.'/assets/css/essb-animations.min.css', array (), ESSB3_VERSION );
		wp_enqueue_style ( 'essb-live-customizer-display-methods', ESSB3_PLUGIN_URL.'/assets/css/essb-display-methods.min.css', array (), ESSB3_VERSION );
		
		
		wp_enqueue_media ();
		
	}
	
	public function can_run() {
		$post_types = essb_option_value('display_in_types');
		if (!is_array($post_types)) {
			$post_types = array();
		}
		unset($post_types['all_lists']);
		
		return is_singular($post_types);
	}
	
	public function load_customizer() {
		if ($this->can_run() && !essb_is_mobile()) {		
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/controls.php');				
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/essb-live-customizer-toggle.php');
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/panel.php');			
		}
	}	
		
	//-- Internal Options Read & Save
	
	public function customizer_get() {
		$params = isset($_REQUEST['params']) ? $_REQUEST['params'] : '';
		$response = array();
		
		$params_list = explode(',', $params);
		foreach ($params_list as $param) {
			$response[$param] = essb_option_value($param);
		}
		
		send_nosniff_header();
		header('content-type: application/json');
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		
		echo json_encode($response);
		die();
	}
	
	public function customizer_get_meta() {
		$params = isset($_REQUEST['params']) ? $_REQUEST['params'] : '';
		$postid = isset($_REQUEST['postid']) ? $_REQUEST['postid'] : '';
		$response = array();
	
		if ($postid != '') {
			$params_list = explode(',', $params);
			foreach ($params_list as $param) {
				$response[$param] = get_post_meta($postid, $param, true);
			}
		}
	
		send_nosniff_header();
		header('content-type: application/json');
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
	
		echo json_encode($response);
		die();
	}
	
	public function customizer_options() {
		global $post_id;
		$post_id = isset($_REQUEST['postid']) ? $_REQUEST['postid'] : '';
		$section = isset($_REQUEST['section']) ? $_REQUEST['section'] : '';
		
		
		send_nosniff_header();
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		
		if ($post_id != '' && $section != '') {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/section-'.$section.'.php');
		}
		
		die();
	}
	
	public function customizer_set() {
		
	}
	
	public function customizer_set_meta() {
	
	}
	
	public function customizer_options_save() {
		global $essb_options;
		
		$list = isset($_REQUEST['list']) ? $_REQUEST['list'] : '';
		$postid = isset($_REQUEST['postid']) ? $_REQUEST['postid'] : '';
		
		$exist_metabox = false;
		$meta_update = array();
		$exist_options = false;
		
		$debug_output = array();
		$debug_output['post_id'] = $postid;
		$debug_output['list_of_options'] = $list;
		
		if ($list != '') {
			$params = explode('|', $list);
			
			foreach ($params as $param) {
				$value = isset($_REQUEST[$param]) ? $_REQUEST[$param] : '';
				
				if (is_array($value)) {
					$debug_output[$param] = 'meta|' . $value['value'];
					$update_at = $value['update'];
					if ($update_at == 'meta') {
						$meta_update[$param] = $value['value'];
						$exist_metabox = true;
					}
					
					if ($update_at == 'options') {
						$debug_output[$param] = 'options|' . $value['value'];
						$essb_options[$param] = $value['value'];
						
						if ($param == 'mobile_css_activate') {
							if ($value == 'true') {
								$essb_options['mobile_css_readblock'] = 'true';
								$essb_options['mobile_css_all'] = 'true';
								$essb_options['mobile_css_optimized'] = 'true';
							}
							else {
								$essb_options['mobile_css_readblock'] = 'false';
								$essb_options['mobile_css_all'] = 'false';
								$essb_options['mobile_css_optimized'] = 'false';
							}
						}
						
						$exist_options = true;
					}
				}
				else {
					//$debug_output[$param] = $value;
				}
			}
		}
		
		if ($exist_metabox) {
			$this->update_post_meta($postid, $meta_update);
		}
		
		if ($exist_options) {
			update_option(ESSB3_OPTIONS_NAME, $essb_options);
		}
		
		echo json_encode($debug_output);
		die();
	}
	
	private function update_post_meta($post_id, $meta_details) {
		foreach ($meta_details as $param => $value) {
			$this->save_metabox_value($post_id, $param, $value);
		}
	}
	
	private function save_metabox_value($post_id, $option, $value) {
		if (!empty($value)) {
			update_post_meta ( $post_id, $option, $value );
		}
		else {
			delete_post_meta ( $post_id, $option );
		}
	}
	
	public function customizer_preview() {
		send_nosniff_header();
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/section-livepreview.php');
		die();
	}
	
	public function module_activation() {
		send_nosniff_header();
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		
		$module = isset($_REQUEST['feature']) ? $_REQUEST['feature'] : '';
		$command = isset($_REQUEST['command']) ? $_REQUEST['command'] : '';
		
		$debug_output = array('module' => $module, 'command' => $command);
		
		$debug_output['result'] = $this->module_boolean_activate($module, $command);
		
		echo json_encode($debug_output);
		
		die();
	}
	
	private function module_boolean_activate($module, $command) {
		global $essb_options;
		
		$value = ($command == 'activate') ? 'true': '';
		$result = '';
		
		if ($module == 'share_optmize') {
			$essb_options['opengraph_tags'] = $value;
		}
		if ($module == 'analytics') {
			$essb_options['stats_active'] = $value;
		}
		if ($module == 'aftershare') {
			$essb_options['afterclose_active'] = $value;
		}
		if ($module == 'shorturl') {
			$essb_options['shorturl_activate'] = $value;
		}
		if ($module == 'optin') {
			$essb_options['subscribe_widget'] = $value;
		}
		if ($module == 'followers') {
			$essb_options['fanscounter_active'] = $value;
		}
		if ($module == 'profiles') {
			$essb_options['profiles_widget'] = $value;
		}
		if ($module == 'native') {
			$essb_options['native_active'] = $value;
		}
		if ($module == 'recovery') {
			$essb_options['counter_recover_active'] = $value;
		}
		
		if ($module == 'cct') {
			$essb_options['deactivate_ctt'] = ($command == 'activate') ? '' : 'true';
		}
		
		if ($module == 'widget' || $module == 'onmedia') {
			$button_positions = essb_option_value ( 'button_position' );
			if (!is_array($button_positions)) {
				$button_positions = array();
			}
			
			$result .= json_encode($button_positions)."|||";
			
			if ($value == 'true') {
				$pos = array_search($module, $button_positions, true);
				if (!in_array($module, $button_positions)) {
					$button_positions[] = $module;
					$result .= "| adding";
				}
			}
			else {
				if (in_array($module, $button_positions)) {
					$button_positions = $this->remove_position($module, $button_positions);
					$result .= "| removing";
				}
			}
			
			$result .= json_encode($button_positions);
			
			$essb_options['button_position'] = $button_positions;
		}
		
		update_option(ESSB3_OPTIONS_NAME, $essb_options);
		
		return $result;
	}
	
	private function remove_position($position, $positions) {
		$new_positions = array();
		
		foreach ($positions as $key) {
			if ($key != $position) {
				$new_positions[] = $key;
			}
		}
		
		return $new_positions;
		
	}
}