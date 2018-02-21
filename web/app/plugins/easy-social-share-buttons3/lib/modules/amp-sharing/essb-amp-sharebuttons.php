<?php

if (! defined ( 'WPINC' ))
	die ();

define ( 'ESSB5_AMP_PLUGIN_ROOT', dirname ( __FILE__ ) . '/' );

class ESSBAmpSupport {
	private static $_instance;
	private $version = "2.0";
	private $options;
	private $position = "";
	
	function __construct() {
		add_action ( 'amp_init', array (&$this, 'activate_amp_support' ) );
	}
	
	public static function getInstance() {
		if (! (self::$_instance instanceof self)) {
			self::$_instance = new self ();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Cloning disabled
	 */
	private function __clone() {
	}
	
	/**
	 * Serialization disabled
	 */
	private function __sleep() {
	}
	
	/**
	 * De-serialization disabled
	 */
	private function __wakeup() {
	}
	
	public function activate_amp_support() {
		
		$is_mobile = true;
		
		
		if ($is_mobile) {
			$this->options = get_option ( 'easy-social-share-buttons3' );
			
			$content_position = essb_option_value('content_position_amp');
			
			if ($content_position != 'content_top' && $content_position != 'content_bottom' && $content_position != 'content_both') {
				$this->position = 'content_bottom';
			} else {
				$this->position = $content_position;
			}
			
			add_filter ( 'the_content', array (&$this, 'amp_display_share' ) );
			add_action ( 'amp_post_template_css', array (&$this, 'amp_load_css' ), 10 );
		}
	}
	
	public function amp_display_share($content) {
		$links_before = '';
		$links_after = '';
		
		if (essb_is_amp_page()) {
			$post_types = $this->option_value ( 'display_in_types' );
			if ($this->position == 'content_top' || $this->position == 'content_both') {
				if (essb_core ()->check_applicability ( $post_types, 'top' )) {
					$links_before = essb_core ()->generate_share_buttons ( 'amp', 'share', array ('only_share' => true, 'amp' => true ) );
				}
			}
			if ($this->position == 'content_bottom' || $this->position == 'content_both') {
				if (essb_core ()->check_applicability ( $post_types, 'bottom' )) {
					$links_after = essb_core ()->generate_share_buttons ( 'amp', 'share', array ('only_share' => true, 'amp' => true ) );
				}
			}
		}
		
		return $links_before . $content . $links_after;
	}
	
	public function is_active_mobile_support() {
		$key = 'mobile_positions';
		
		$value = isset ( $this->options [$key] ) ? $this->options [$key] : 'false';
		
		return ($value == 'true') ? true : false;
	}
	
	public function option_value($key) {
		return isset ( $this->options [$key] ) ? $this->options [$key] : '';
	}
	
	public function amp_load_css() {
		include_once (ESSB5_AMP_PLUGIN_ROOT . 'essb-amp-styles.php');
	}
}

/**
 * main code *
 */

global $essb_amp_mobile_support;
if (! isset ( $essb_amp_mobile_support )) {
	$essb_amp_mobile_support = ESSBAmpSupport::getInstance ();
}

