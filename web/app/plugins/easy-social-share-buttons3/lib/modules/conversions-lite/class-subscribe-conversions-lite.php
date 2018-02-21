<?php

/**
 * Track and log subscribe forms conversion on site (Lite)
 * 
 * @package EasySocialShareButtons
 * @author appscreo
 * @version 1.0
 * @since 5.2
 *
 */
class ESSBSubscribeConversionsLite {
	
	private $version = '1.0';
	
	private $data_holder = 'essb-subscribe-conversions-lite';
	
	public function __construct() {
		
		if (!is_admin()) {
			$this->register_tracking();
			$this->register_log();	
			
			add_action ( 'template_redirect', array($this, 'conversion_tracking'), 1 );
				
		}
		
	}
	
	public function conversion_tracking() {
		$essb_subscribe_logging = isset($_REQUEST['essb_subscribe_logging']) ? $_REQUEST['essb_subscribe_logging'] : '';

		if ($essb_subscribe_logging == 'true') {
			
			define ( 'DOING_AJAX', true );
			
			send_nosniff_header ();
			header ( 'content-type: application/json' );
			header ( 'Cache-Control: no-cache' );
			header ( 'Pragma: no-cache' );
			
			$conversion = isset($_REQUEST['conversion']) ? $_REQUEST['conversion'] : '';
			$conversion = stripslashes($conversion);
			
			$data = json_decode($conversion);
			
			$log_date = date('Y-m-d');
			
			$ab_stats = get_option ( $this->data_holder );
			if (!$ab_stats || !is_array($ab_stats)) {
				$ab_stats = array( 'totals' => array(), 'dates' => array());
			}
			
			
			if (!isset($ab_stats['dates'][$log_date])) {
				$ab_stats['dates'][$log_date] = array('positions' => array(), 'networks' => array());
			}
			
			if (isset($data->positions)) {
				if (!isset($ab_stats['totals']['positions'])) {
					$ab_stats['totals']['positions'] = array();
				}
				
				foreach ($data->positions as $key => $value) {
					if (!isset($ab_stats['totals']['positions'][$key])) {
						$ab_stats['totals']['positions'][$key] = array('views' => intval($value), 'clicks' => 0);
					}
					else {
						$ab_stats['totals']['positions'][$key]['views'] += intval($value);
					}
					
					if (!isset($ab_stats['dates'][$log_date]['positions'][$key])) {
						$ab_stats['dates'][$log_date]['positions'][$key] = array('views' => intval($value), 'clicks' => 0);						
					}
					else {
						$ab_stats['dates'][$log_date]['positions'][$key]['views'] += intval($value);
					}
				}
			}
			
			if (isset($data->networks)) {
				if (!isset($ab_stats['totals']['networks'])) {
					$ab_stats['totals']['networks'] = array();
				}
				
				foreach ($data->networks as $key => $value) {
					if (!isset($ab_stats['totals']['networks'][$key])) {
						$ab_stats['totals']['networks'][$key] = array('views' => intval($value), 'clicks' => 0);
					}
					else {
						$ab_stats['totals']['networks'][$key]['views'] += intval($value);
					}
					
					if (!isset($ab_stats['dates'][$log_date]['networks'][$key])) {
						$ab_stats['dates'][$log_date]['networks'][$key] = array('views' => intval($value), 'clicks' => 0);
					}
					else {
						$ab_stats['dates'][$log_date]['networks'][$key]['views'] += intval($value);
					}
				}
			}
			
			
			if (count($ab_stats['dates']) > 7) {
				
				$first = '';
				
				foreach ($ab_stats['dates'] as $key => $data) {
					$key = str_replace('-', '', $key);
					if ($first == '') {
						$first = $key;
					}
					else {
						if (intval($key) < intval($first)) {
							$first = $key;
						}
					}
				}
				
				$first = substr($first, 0, 4) . '-' . substr($first, 4, 2) . '-' . substr($first, 6, 2);
				
				//$first = array_shift ($keys);
				unset($ab_stats['dates'][$first]);
			}
			
			/*
			 * stdClass Object
(
    [positions] => stdClass Object
        (
            [shortcode] => 1
            [bottom] => 1
        )

    [networks] => stdClass Object
        (
            [facebook] => 2
            [twitter] => 2
            [google] => 2
            [linkedin] => 2
            [pinterest] => 2
            [messenger] => 1
            [mail] => 1
        )

)
			 */
			
			
			
			update_option ( $this->data_holder, $ab_stats );
			die(json_encode($ab_stats));
		}
		
		$essb_subscribe_tracking = isset($_REQUEST['essb_subscribe_tracking']) ? $_REQUEST['essb_subscribe_tracking'] : '';
		
		if ($essb_subscribe_tracking == 'true') {
			
			$position = isset($_REQUEST['position']) ? $_REQUEST['position'] : '';
			$service = isset($_REQUEST['service']) ? $_REQUEST['service'] : '';
			
			define ( 'DOING_AJAX', true );
				
			send_nosniff_header ();
			header ( 'content-type: application/json' );
			header ( 'Cache-Control: no-cache' );
			header ( 'Pragma: no-cache' );
				
			$log_date = date('Y-m-d');
				
			$ab_stats = get_option ( $this->data_holder );
			if (!$ab_stats || !is_array($ab_stats)) {
				$ab_stats = array( 'totals' => array(), 'dates' => array());
			}

			
			
			if (!isset($ab_stats['dates'][$log_date])) {
				$ab_stats['dates'][$log_date] = array('positions' => array(), 'networks' => array());
			}
				
			if (isset($position) && $position != '') {
				if (!isset($ab_stats['totals']['positions'])) {
					$ab_stats['totals']['positions'] = array();
				}
			
				if (!isset($ab_stats['totals']['positions'][$position])) {
					$ab_stats['totals']['positions'][$position] = array('views' => 0, 'clicks' => 1);
				}
				else {
					$ab_stats['totals']['positions'][$position]['clicks'] += 1;
				}
						
				if (!isset($ab_stats['dates'][$log_date]['positions'][$position])) {
					$ab_stats['dates'][$log_date]['positions'][$position] = array('views' => 0, 'clicks' => 1);
				}
				else {
					$ab_stats['dates'][$log_date]['positions'][$position]['clicks'] += 1;
				}
			}
				
			if (isset($service) && $service != '') {
				if (!isset($ab_stats['totals']['networks'])) {
					$ab_stats['totals']['networks'] = array();
				}
			
					if (!isset($ab_stats['totals']['networks'][$service])) {
						$ab_stats['totals']['networks'][$service] = array('views' => 0, 'clicks' => 1);
					}
					else {
						$ab_stats['totals']['networks'][$service]['clicks'] += 1;
					}
						
					if (!isset($ab_stats['dates'][$log_date]['networks'][$service])) {
						$ab_stats['dates'][$log_date]['networks'][$service] = array('views' => 0, 'clicks' => 1);
					}
					else {
						$ab_stats['dates'][$log_date]['networks'][$service]['clicks'] += 1;
					}
			}
				
			
			update_option ( $this->data_holder, $ab_stats );
			die(json_encode($ab_stats));
		}
	}
	
	//essb_subscribe_logging
	
	public function register_tracking() {
		$update_url = essb_get_current_page_url();
		
		if (defined('ESSB_FORCE_SSL')) {
			$update_url = str_replace('http://', 'https://', $update_url);
		}
		else {
			// second level of protection against non https connection calls when http is detected instead of https
			$current_page_url = get_permalink();
			if (strpos($current_page_url, 'https://') !== false && strpos($update_url, 'https://') === false) {
				$update_url = str_replace('http://', 'https://', $update_url);
			}
		}
		
		$output = '
		
		function essbConversionsLiteLog() {
			var trackings = { "positions": {}, "networks": {}},
			    isMobile = false;
			    
			if( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent) ) {
				isMobile = true;
			}
			
			jQuery(".essb-subscribe-form-content").each(function(){
				var instancePosition = jQuery(this).attr("data-position") || "";
				
				if (!trackings.positions[instancePosition])
					trackings.positions[instancePosition] = 1;
				else 
				   trackings.positions[instancePosition]++;
				
				trackings.networks["subscribe"] = 1;
				   
			});
			
			var essbab_url = "'.$update_url.'";
			jQuery.post(essbab_url, {
				"essb_subscribe_logging": "true",
				"conversion": JSON.stringify(trackings)
				}, function (data) { 
					if (data) {
					console.log(data);
					
				}},\'json\');
			
		
		}
		
		jQuery(document).ready(function() {
			essbConversionsLiteLog();
	    });
		
		';
		

		
		essb_resource_builder()->add_js($output, false, 'conversions-lite-tracking');
	}
	
	public function register_log() {
		$update_url = essb_get_current_page_url();
		
		if (defined('ESSB_FORCE_SSL')) {
			$update_url = str_replace('http://', 'https://', $update_url);
		}
		else {
			// second level of protection against non https connection calls when http is detected instead of https
			$current_page_url = get_permalink();
			if (strpos($current_page_url, 'https://') !== false && strpos($update_url, 'https://') === false) {
				$update_url = str_replace('http://', 'https://', $update_url);
			}
		}
		
		$output = '
		function essb_subscribe_tracking(instance_postion) {
		
		var instance_mobile = false;
		var essbab_url = "'.$update_url.'";
		
		if( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent) ) {
			instance_mobile = true;
		}
		if (typeof(essb_settings) != "undefined") {
		jQuery.post(essbab_url, {
		\'essb_subscribe_tracking\': \'true\',
		\'post_id\': "",
		\'service\': "subscribe",
		\'template\': "",
		\'mobile\': instance_mobile ? "true":"false",
		\'position\': instance_postion,
		\'button\': "subscribe"
		}, function (data) { if (data) {
		
		}},\'json\');
		}
		};
		';
		essb_resource_builder()->add_js($output, false, 'conversions-subscribe-lite-logging');
	}
	
}

global $essb_subscribe_conversions_lite;
if (!$essb_subscribe_conversions_lite) {
	$essb_subscribe_conversions_lite = new ESSBSubscribeConversionsLite();
}