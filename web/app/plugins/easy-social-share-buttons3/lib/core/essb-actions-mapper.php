<?php
/**
 * Actions Mapper
 * 
 * @author appsreo
 * @package EasySocialShareButtons
 * @since 4.0
 * 
 */

add_action ( 'wp_ajax_nopriv_essb_self_postcount', 'essb_actions_update_post_count' );
add_action ( 'wp_ajax_essb_self_postcount', 'essb_actions_update_post_count' );

if (essb_option_bool_value('cache_counter_facebook_async')) {
	add_action ( 'wp_ajax_nopriv_essb_facebook_counter_update', 'essb_actions_update_facebook_count' );
	add_action ( 'wp_ajax_essb_facebook_counter_update', 'essb_actions_update_facebook_count' );
}

if (essb_option_bool_value('cache_counter_pinterest_async')) {
	add_action ( 'wp_ajax_nopriv_essb_pinterest_counter_update', 'essb_actions_update_pinterest_count' );
	add_action ( 'wp_ajax_essb_pinterest_counter_update', 'essb_actions_update_pinterest_count' );
}


// loading events only if real time counters are used - @since 5.0
if (essb_option_value('counter_mode') == '') {
	add_action ( 'wp_ajax_nopriv_essb_counts', 'essb_actions_get_share_counts' );
	add_action ( 'wp_ajax_essb_counts', 'essb_actions_get_share_counts' );
}

add_action ( 'template_redirect', 'essb_process_additional_ajax_requests', 1 );

add_action ( 'wp_ajax_nopriv_essb_love_action', 'essb_love_logclick');
add_action ( 'wp_ajax_essb_love_action', 'essb_love_logclick');

// send mail action will only work if the user setup mail form inside settings
// otherwise action will be removed
if (essb_option_value('mail_function') == 'form') {
	add_action ( 'wp_ajax_nopriv_essb_mail_action', 'essb_actions_sendmail' );
	add_action ( 'wp_ajax_essb_mail_action', 'essb_actions_sendmail' );
}


// --------------------------------------------------
// Actions
// --------------------------------------------------

if (!function_exists('essb_love_logclick')) {
	function essb_love_logclick() {
		global $blog_id;

		$post_id = isset ( $_POST ['post_id'] ) ? $_POST ['post_id'] : '';
		$service_id = isset ( $_POST ['service'] ) ? $_POST ['service'] : '';
		
		$post_id = sanitize_text_field($post_id);
		$service_id = sanitize_text_field($service_id);

		$love_count = get_post_meta($post_id, '_essb_love', true);
		if( isset($_COOKIE['essb_love_'. $post_id]) ) die( $love_count);
		if (!isset($love_count)) {
			$love_count = 0;
		}
		$love_count = intval($love_count);
		$love_count++;
		update_post_meta($post_id, '_essb_love', $love_count);
		//setcookie('essb_love_'. $post_id, $post_id . " - ". $love_count, time()*60*60*24, '/');
		$cookie_information = 'essb_love_'. $post_id.' = '.$love_count;
		setcookie('essb_love_'. $post_id, $cookie_information, time()+(3600 * 24), "/", "",  0);

		die ( json_encode ( array ("success" => 'Log handled - post_id = '.$post_id.' count = '.$love_count ) ) );
	}
}

function essb_process_additional_ajax_requests() {

	$subscribe_action = isset($_REQUEST['essb-malchimp-signup']) ? $_REQUEST['essb-malchimp-signup']: '';

	if ($subscribe_action == '1') {
		if (!class_exists('ESSBNetworks_SubscribeActions')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-actions.php');
		}
			
		ESSBNetworks_SubscribeActions::process_subscribe();
			
		die();
	}

	if (defined('ESSB3_CACHED_COUNTERS')) {
		if (ESSBGlobalSettings::$cached_counters_cache_mode) {
			if (isset($_REQUEST['essb_counter_cache']) && $_REQUEST['essb_counter_cache'] == 'rebuild') {
				$share_details = essb_get_post_share_details('');
				$share_details['full_url'] = $share_details['url'];
				$networks = essb_option_value('networks');
				$result = ESSBCachedCounters::get_counters(get_the_ID(), $share_details, $networks);
				echo json_encode($result);
				die();
			}
		}
		
		$full_counter_update = isset($_REQUEST['essb_clear_cached_counters']) ? $_REQUEST['essb_clear_cached_counters'] : '';
		if ($full_counter_update == 'true') {
			delete_post_meta_by_key('essb_cache_expire');
		}
		
		$full_history_clear = isset($_REQUEST['essb_clear_counters_history']) ? $_REQUEST['essb_clear_counters_history'] : '';
		if ($full_history_clear == 'true') {
			delete_post_meta(get_the_ID(), 'essb_cache_expire');
			$networks = essb_available_social_networks();
			
			foreach ($networks as $key => $data) {
				delete_post_meta(get_the_ID(), 'essb_c_'.$key);
			} 
		}
	}

	$current_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

	if ($current_action == "essb_counts") {
		define('DOING_AJAX', true);

		send_nosniff_header();
		header('content-type: application/json');
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');

		if(is_user_logged_in())
			do_action('wp_ajax_essb_counts');
		else
			do_action('wp_ajax_nopriv_essb_counts');

		exit;
	}
	
	$sharing_thankyou = isset($_REQUEST['sharing-thankyou']) ? $_REQUEST['sharing-thankyou'] : '';
	
	if ($sharing_thankyou == 'yes') {
		send_nosniff_header();
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		echo '
		<!DOCTYPE html><html><head>    <meta name="viewport" content="width=device-width, initial-scale=1" />    
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>    
		<title>Sharing Success!</title>    
		<style>        .thank-you-msg {            text-align: center;        }    </style></head>
		<body>    <h1 class="thank-you-msg">        Thank you for sharing!    </h1>    
		<script>        try {            self.close();            window.close();        }        catch(e) { }    </script>    
		<script></script></body></html>';
		
		die();
	}
}

function essb_actions_update_facebook_count() {
	$post_id = $_POST['post_id'];
	$count = $_POST['count'];
	
	$past_shares = intval(get_post_meta($post_id, 'essb_c_facebook', true));
	
	if ( $count > $past_shares || essb_option_bool_value('cache_counter_force') ) {
		delete_post_meta( $post_id, 'essb_c_facebook' );
		update_post_meta( $post_id, 'essb_c_facebook', $count );
	}
	
	echo json_encode(array('network' => 'facebook', 'past_shares' => $past_shares, 'new_shares' => $count));
	
	wp_die();
}

function essb_actions_update_pinterest_count() {
	$post_id = $_POST['post_id'];
	$count = $_POST['count'];

	$past_shares = intval(get_post_meta($post_id, 'essb_c_pinterest', true));

	if ( $count > $past_shares || essb_option_bool_value('cache_counter_force') ) {
		delete_post_meta( $post_id, 'essb_c_pinterest' );
		update_post_meta( $post_id, 'essb_c_pinterest', $count );
	}

	echo json_encode(array('network' => 'pinterest', 'past_shares' => $past_shares, 'new_shares' => $count));

	wp_die();
}

function essb_actions_update_post_count() {
	global $wpdb, $blog_id;

	$post_id = isset($_POST["post_id"]) ? $_POST["post_id"] : '';
	$service_id = isset($_POST["service"]) ? $_POST["service"] : '';
	
	$post_id = sanitize_text_field($post_id);
	$service_id = sanitize_text_field($service_id);
	
	$post_id = intval($post_id);
	

	if ($service_id == "print_friendly") {
		$service_id = "print";
	}

	$current_value = get_post_meta($post_id, 'essb_pc_'.$service_id, true);
	$current_value = intval($current_value) + 1;
	update_post_meta ( $post_id, 'essb_pc_'.$service_id, $current_value );

	// @since 3.6
	// addint custom hook to execute when click on share buttons
	do_action('essb_after_sharebutton_click');

	die(json_encode(array("post_id" => $post_id, "service" => $service_id, "current_value" => $current_value)));
}

function essb_actions_get_share_counts() {
	$networks = isset($_REQUEST['nw']) ? $_REQUEST['nw'] : '';
	$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '';
	$instance = isset($_REQUEST['instance']) ? $_REQUEST['instance'] : '';
	$post = isset($_REQUEST['post']) ? $_REQUEST['post'] : '';

	$networks = sanitize_text_field($networks);

	header('content-type: application/json');

	// check if cache is present

	$is_active_cache =  essb_option_bool_value('admin_ajax_cache');
	$cache_ttl = intval(essb_option_value('admin_ajax_cache_time'));
	if ($cache_ttl == 0) {
		$cache_ttl = 600;
	}

	$list = explode(',', $networks);
	$output = array();
	$output['url'] = sanitize_text_field($url);
	$output['instance'] = sanitize_text_field($instance);
	$output['post'] = sanitize_text_field($post);
	$output['network'] = $networks;

	if (!class_exists('ESSBCounterHelper')) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/core/essb-counters-helper.php');
	}

	foreach ($list as $nw) {
		$transient_key = 'essb_'.$nw.'_'.$url;
		$exist_in_cache = false;
		if ($is_active_cache) {
			$cached_value = get_transient($transient_key);
			if ($cached_value) {
				$output[$nw] = $cached_value;
				$exist_in_cache = true;
			}
		}
			
		if (!$exist_in_cache) {
			$count = ESSBCountersHelper::get_shared_counter($nw, $url, $post);
			$output[$nw] = $count;
			if ($is_active_cache) {
				delete_transient($transient_key);
				set_transient( $transient_key, $count, $cache_ttl );
			}
		}
	}

	echo str_replace('\\/','/',json_encode($output));

	die();
}

if (!function_exists('essb_actions_sendmail')) {
	function essb_actions_sendmail() {
		$exist_captcha = essb_option_value('mail_captcha_answer');
		$mail_function_security = essb_option_value('mail_function_security');
		
		$post_id = essb_object_value($_REQUEST, 'post_id');
		$from = essb_object_value($_REQUEST, 'from');
		$to = essb_object_value($_REQUEST, 'to');
		$c = essb_object_value($_REQUEST, 'c');
		$mail_salt = essb_object_value($_REQUEST, 'salt');
		$cu = essb_object_value($_REQUEST, 'cu');
		
		$post_id = sanitize_text_field($post_id);
		$from = sanitize_email($from);
		$to = sanitize_email($to);
		$c = sanitize_text_field($c);
		$mail_salt = sanitize_text_field($mail_salt);
		
		$translate_mail_message_sent = essb_option_value('translate_mail_message_sent');
		$translate_mail_message_invalid_captcha = essb_option_value('translate_mail_message_invalid_captcha');
		$translate_mail_message_error_send = essb_option_value('translate_mail_message_error_send');
		
		
		$output = array("code" => "", "message" => "");
		$valid = true;
		
		if ($exist_captcha != '' && $exist_captcha != $c) {
			$valid = false;
			$output["code"] = "101";
			$output["message"] = $translate_mail_message_invalid_captcha != '' ? $translate_mail_message_invalid_captcha : __("Invalid captcha code", "essb");
		}
		
		if (strlen($to) > 80) {
			$valid = false;
			$output["code"] = "102";
			$output["message"] = __('Invalid recepient email', 'essb');		
		}
		
		$mail_salt_check = get_option(ESSB3_MAIL_SALT);
		if ($mail_function_security == 'level2') {
			$mail_salt = "salt";
			$mail_salt_check = "salt";
		}
		
		if ($mail_salt != $mail_salt_check) {
			$valid = false;
			$output["code"] = "103";
			$output["message"] = __('Invalid security key provided', 'essb');		
		}
		
		if (filter_var($from, FILTER_VALIDATE_EMAIL) === false) {
			$valid = false;
			$output["code"] = "104";
			$output["message"] = __('Invalid sender email', 'essb');		
		}
		
		if (filter_var($to, FILTER_VALIDATE_EMAIL) === false) {
			$valid = false;
			$output["code"] = "102";
			$output["message"] = __('Invalid recepient email', 'essb');
		}
		
		if ($valid) {
			$message_subject = essb_option_value('mail_subject');
			$message_body = essb_option_value('mail_body');
			
			$post = get_post($post_id);
			$url = get_permalink($post_id);

			$base_post_url = $url;
			
			$site_url = get_site_url();
			
			$base_site_url = $site_url;
			
			$site_url = '<a href="'.$site_url.'">'.$site_url.'</a>';
			$url = '<a href="'.$url.'">'.$url.'</a>';
			
			$title = $post->post_title;
			$image = essb_core_get_post_featured_image($post->ID);
			$description = $post->post_excerpt;
			
			if ($image != '') {
				$image = '<img src="'.$image.'" />';
			}
				

			$parsed_address = parse_url($base_site_url);
			
			$message_subject = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#', '#%%image%%#'), array($title, $base_site_url, $base_post_url, $image), $message_subject);
			$message_body = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#', '#%%image%%#'), array($title, $site_url, $url, $image), $message_body);
			
			if ($cu != '') {
				$message_body .= $cu;
			}
			
			$copy_address = essb_option_value('mail_copyaddress');
			$message_body = str_replace("\r\n", "<br />", $message_body);
			
			$headers = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/html; charset=utf-8";
			$headers[] = "Reply-to: ".$from;
			//$headers[] = "From: ".$from." <no-reply@".$parsed_address['host'].'>';//admin_email
			$headers[] = "From: ".$from.' <'.get_bloginfo('admin_email').'>';//admin_email
			if ($copy_address != '') {
				$headers[] = 'Bcc: '. $copy_address;
			}
			
			wp_mail($to, $message_subject, $message_body, $headers);
			$output["code"] = "1";
			$output["message"] = $translate_mail_message_sent != '' ? $translate_mail_message_sent : __("Message sent!", "essb");
		}
		
		echo str_replace('\\/','/',json_encode($output));
		die();
	}
}