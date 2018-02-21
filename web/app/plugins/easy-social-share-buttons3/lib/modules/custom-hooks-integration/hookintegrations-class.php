<?php
/**
 * Automated generation of share buttons based on the registered custom hooks inside plugin
 * 
 * @since 5.0
 * @package EasySocialShareButtons
 * @author appscreo
 *
 */
class ESSBHookIntegrations {
	
	public $hooks = array();
	
	private $hook_actions_map = array();
	
	/**
	 * Create and load required actions and hooks
	 * 
	 */
	public function __construct() {
		
		$existing_hooks = get_option('essb-hook');
		
		if (!is_array($existing_hooks)) {
			$existing_hooks = array();
		}
		
		$this->hooks = $existing_hooks;
		
		// Create map of action/hooks that will be included inside content
		$this->init_map();
		
		// interface registration of menu options
		$this->essb_interface_register();
	}
	
	public function init_map() {
		foreach ($this->hooks as $key => $data) {
			$type = isset($data['type']) ? $data['type'] : '';
			$action = isset($data['action']) ? $data['action'] : '';
			
			if (($type == 'action' || $type == 'filter') && $action != '') {
				$this->hook_actions_map[$action] = $key;
				
				if ($type == 'action') {
					add_action($action, array($this, 'action_parser'));
				}
				if ($type == 'filter') {
					add_filter($action, array($this, 'filter_parser'));
				}
			}
		}
	}
	
	/**
	 * Handle registration of custom display methods and hooks created by user inside plugin menu
	 */
	public function essb_interface_register() {
		add_filter('essb4_custom_method_list', array($this, 'essb_interface_custom_positions'));
		add_filter('essb4_custom_positions', array($this, 'essb_display_register_mycustom_position'));
		add_filter('essb4_button_positions', array($this, 'essb_display_mycustom_position'));
		add_action('init', array($this, 'essb_custom_methods_register'), 99);
	}
	
	public function essb_interface_custom_positions($methods) {
		$count = 40;
		
		foreach ($this->hooks as $key => $data) {
			$name = isset($data['name']) ? $data['name'] : '';
			
			if ($name != '') {
				$count++;
				$methods['display-'.$count] = $name;
			}
		}
		
		
		return $methods;
	}
	
	public function essb_display_register_mycustom_position($positions) {
		foreach ($this->hooks as $key => $data) {
			$name = isset($data['name']) ? $data['name'] : '';
				
			if ($name != '') {
				$positions[$key] = $name;
			}
		}
		
		return $positions;
	}
	
	public function essb_display_mycustom_position($positions) {
		
		foreach ($this->hooks as $key => $data) {
			$name = isset($data['name']) ? $data['name'] : '';
				
			if ($name != '') {
				$positions[$key] = array ("image" => "assets/images/display-positions-09.png", "label" => $name );
			}
		}
		
		
		return $positions;
	}
	
	public function essb_custom_methods_register() {
	
		if (is_admin()) {
			if (class_exists('ESSBOptionsStructureHelper')) {
				
				$count = 40;
				
				foreach ($this->hooks as $key => $data) {
					$name = isset($data['name']) ? $data['name'] : '';
						
					if ($name != '') {
						$count++;
						essb_prepare_location_advanced_customization('where', 'display-'.$count, $key);
					}
				}
			}
	
		}
	}
	
	public function action_parser() {
		$running_action = current_action();

		if (isset($this->hook_actions_map[$running_action])) {
			$key = $this->hook_actions_map[$running_action];
			
			essb_hook_integration_draw($key);
		}
	}
	
	public function filter_parser($buffer) {
		$running_action = current_filter();
		
		if (isset($this->hook_actions_map[$running_action])) {
			$key = $this->hook_actions_map[$running_action];
				
			$buffer .= essb_hook_integration_generate($key);
		}
		
		return $buffer;
	}	
}

global $essb_hook_manager;
if (!$essb_hook_manager) {
	$essb_hook_manager = new ESSBHookIntegrations();
}