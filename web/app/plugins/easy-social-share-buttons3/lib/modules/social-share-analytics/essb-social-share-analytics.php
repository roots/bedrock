<?php

class ESSBSocialShareAnalytics {
	
	private static $instance = null;
	
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	function __construct() {
		add_action ( 'wp_ajax_nopriv_essb_stat_log', array ($this, 'log_click' ) );
		add_action ( 'wp_ajax_essb_stat_log', array ($this, 'log_click' ) );		
	}
	
	public function log_click() {
		global $wpdb, $blog_id;
		
		$post_id = isset($_POST["post_id"]) ? $_POST["post_id"] : '';
		$service_id = isset($_POST["service"]) ? $_POST["service"] : '';
		$template = isset($_POST['template']) ? $_POST['template'] : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$position = isset($_POST['position']) ? $_POST['position'] : '';
		$button_style = isset($_POST['button']) ? $_POST['button'] : '';
		$counters = isset($_POST['counter']) ? $_POST['counter'] : '';
		
		$rows_affected = $wpdb->insert ( $wpdb->prefix.ESSB3_TRACKER_TABLE, 
				array ('essb_blog_id' => $blog_id, 
						'essb_post_id' => $post_id, 
						'essb_service' => $service_id,
						'essb_mobile' => $mobile,
						'essb_position' => $position,
						'essb_template' => $template,
						'essb_button' => $button_style ) );
		sleep ( 1 );
		die ( json_encode ( array ("success" => 'Log handled' ) ) );
		
	}
	
	public function generate_tracker_code() {
		$script = '
var essb_handle_stats = function(oService, oPostID, oInstance) {
	var element = jQuery(\'.essb_\'+oInstance);
	var instance_postion = jQuery(element).attr("data-essb-position") || "";
	var instance_template = jQuery(element).attr("data-essb-template") || "";
	var instance_button = jQuery(element).attr("data-essb-button-style") || "";
	
	var instance_counters = jQuery(element).hasClass("essb_counters") ? true : false;
	var instance_nostats = jQuery(element).hasClass("essb_nostats") ? true : false;
	
	if (instance_nostats) { return; }
	
	var instance_mobile = false;

	if( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent) ) {
		instance_mobile = true;
	}
		if (typeof(essb_settings) != "undefined") {
			jQuery.post(essb_settings.ajax_url, {
				\'action\': \'essb_stat_log\',
				\'post_id\': oPostID,
				\'service\': oService,
				\'template\': instance_template,
				\'mobile\': instance_mobile,
				\'position\': instance_postion,
				\'button\': instance_button,
				\'counter\': instance_counters,
				\'nonce\': essb_settings.essb3_nonce
			}, function (data) { if (data) {
				
			}},\'json\');
		}
	

};	
		';
		
		return $script;
	}
	
}

?>