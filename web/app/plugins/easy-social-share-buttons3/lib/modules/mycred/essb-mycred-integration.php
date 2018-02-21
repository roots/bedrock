<?php

class ESSBMyCredIntegration {
	private static $instance = null;
	
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	
	function __construct() {
		add_action ( 'wp_enqueue_scripts', array ($this, 'register_front_assets' ), 1 );		
	}
	
	public function register_front_assets() {
		wp_register_script(
				'essb-mycred-link-points',
				ESSB3_PLUGIN_URL . '/assets/js/essb-mycred.js',
				array( 'jquery' ),
				ESSB3_VERSION,
				true
		);
		wp_localize_script(
				'essb-mycred-link-points',
				'ESSBmyCREDlink',
				array(
						'ajaxurl' => admin_url( 'admin-ajax.php' ),
						'token'   => wp_create_nonce( 'mycred-link-points' )
				)
		);
		wp_enqueue_script( 'essb-mycred-link-points' );
	}
	
	public static function generate_mycred_datatoken() {
		
		$group = ESSBGlobalSettings::$mycred_group;
		$points = ESSBGlobalSettings::$mycred_points;
		
		$salt = mt_rand ();
		$result = "";
	
		if (function_exists('mycred_create_token')) {
	
			if ($points == "") {
				$points = "1";
			}
			if ($group == "") {
				$group = "mycred_default";
			}
				
			$result = mycred_create_token( array( $points, $group, $salt ) );
				
			if ($result != '') {
				$result = ' data-token="' . $result . '" data-type="'.$group.'"';
			}
		}
	
		return $result;
	}
}

?>