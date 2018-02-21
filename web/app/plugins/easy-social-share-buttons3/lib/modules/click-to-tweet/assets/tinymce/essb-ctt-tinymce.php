<?php

defined ( 'ABSPATH' ) or die ( "No soup for you. You leave now." );

if (! class_exists ( 'ESSB_CTT_TinyMCE' )) {
	
	// Start up the engine
	class ESSB_CTT_TinyMCE {
		
		/**
		 * This is our constructor
		 *
		 * @return BCTT_TinyMCE
		 */
		public function __construct() {
			add_action ( 'admin_init', array ($this, 'tinymce_loader' ) );
			add_action ( 'admin_enqueue_scripts', array ($this, 'tinymce_css' ), 10 );
		}
		
		/**
		 * load our CSS file
		 * 
		 * @return [type] [description]
		 */
		public function tinymce_css() {
			
			wp_enqueue_style ( 'essb-ctt-admin', plugins_url ( '/css/essb-ctt-admin.css', __FILE__ ), array (), null, 'all' );
		}
		
		/**
		 * load the TinyMCE button
		 *
		 * @return [type] [description]
		 */
		public function tinymce_loader() {
			add_filter ( 'mce_external_plugins', array (__class__, 'essb_ctt_tinymce_core' ) );
			add_filter ( 'mce_buttons', array (__class__, 'essb_ctt_tinymce_buttons' ) );
		}
		
		/**
		 * loader for the required JS
		 *
		 * @param $plugin_array [type]
		 *       	 [description]
		 * @return [type] [description]
		 */
		public static function essb_ctt_tinymce_core($plugin_array) {
			
			// add our JS file
			$plugin_array ['essb_ctt'] = plugins_url ( '/js/tinymce-essb-ctt.js', __FILE__ );
			
			// return the array
			return $plugin_array;
		}
		
		/**
		 * Add the button key for event link via JS
		 *
		 * @param $buttons [type]
		 *       	 [description]
		 * @return [type] [description]
		 */
		public static function essb_ctt_tinymce_buttons($buttons) {
			
			// push our buttons to the end
			array_push ( $buttons, 'essb_ctt' );
			
			// now add back the sink
			// send them back
			return $buttons;
		}
		
		// end class
	}
	
	// end exists check
}

// Instantiate our class
new ESSB_CTT_TinyMCE ();