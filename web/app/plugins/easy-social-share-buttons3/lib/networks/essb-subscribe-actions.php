<?php
/**
 * Subsctibe Actions
 *
 * @since 3.6
 *
 * @package EasySocialShareButtons
 * @author  appscreo <http://codecanyon.net/user/appscreo/portfolio>
 */

class ESSBNetworks_SubscribeActions {
	
	private static $version = "2.0";
	
	public static function process_subscribe() {
		global $essb_options;
		// send no caching headers
		
		define ( 'DOING_AJAX', true );
		
		send_nosniff_header ();
		header ( 'content-type: application/json' );
		header ( 'Cache-Control: no-cache' );
		header ( 'Pragma: no-cache' );
		
		$output = array("code" => "", "message" => "");
		
		$user_email = isset ( $_REQUEST ['mailchimp_email'] ) ? $_REQUEST ['mailchimp_email'] : '';
		$user_name = isset ($_REQUEST['mailchimp_name']) ? $_REQUEST['mailchimp_name'] : '';
		$output['request_mail'] = $user_email;
		
		if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
			$output['code'] = "90";
			$output['message'] = __('Invalid email address', 'essb');
			
			$translate_subscribe_invalidemail = essb_option_value('translate_subscribe_invalidemail');
			if ($translate_subscribe_invalidemail != '') {
				$output['message'] = $translate_subscribe_invalidemail;
			}
		}
		else {
			$output = self::subscribe($user_email, $user_name);
		}
		
		
		print json_encode($output);
	}
	
	public static function subscribe($user_email, $user_name = '') {
		global $essb_options;
		
		$debug_mode = isset($_REQUEST['debug']) ? $_REQUEST['debug'] : '';
		
		$connector = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_connector', 'mailchimp' );
		if ($connector == '') {
			$connector = 'mailchimp';
		}
		
		$external_connectors = array();
		if (has_filter('essb_external_subscribe_connectors')) {
			$external_connectors_base = array();
			$external_connectors_base = apply_filters('essb_external_subscribe_connectors', $external_connectors_base);
			
			foreach($external_connectors_base as $excon => $exname) {
				$external_connectors[] = $excon;
			}
		}		
		
		
		$output = array();
		$output['name'] = $user_name;
		$output['email'] = $user_email;
				
		switch ($connector) {
			case "mailchimp":
				if (has_filter('essb_custom_mailing_list_mailchimp')) {
					$mc_list = apply_filters('essb_custom_mailing_list_mailchimp', $mc_list);
				}	

				$mc_api = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_mc_api' );
				$mc_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_mc_list' );
				$mc_welcome = ESSBOptionValuesHelper::options_bool_value($essb_options, 'subscribe_mc_welcome');
				$mc_double = ESSBOptionValuesHelper::options_bool_value($essb_options, 'subscribe_mc_double');			
				
				$result = self::subscribe_mailchimp($mc_api, $mc_list, $user_email, $mc_double, $mc_welcome, $user_name);
				
				if ($debug_mode == 'true') {
					print_r($result);
				}
								
				$output['name'] = $user_name;
				$output['email'] = $user_email;
					
				if ($result) {
					$result = json_decode($result);
				
					if ($result->euid) {
						$output['code'] = '1';
						$output['message'] = 'Thank you';
					}
					else {
						$output['code'] = "99";
						$output['message'] = __('Missing connection', 'essb');
				
					}
				}
				else {
					$output['code'] = "99";
					$output['message'] = __('Missing connection', 'essb');
				
				}
				break;
			case "getresponse":
				$gr_api = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_gr_api' );
				$gr_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_gr_list' );
				
				
				$output = self::subscribe_getresponse($gr_api, $gr_list, $user_email, $user_name);
				break;
			case "mymail":
				$mm_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_mm_list' );				
				$output = self::subscribe_mymail($mm_list, $user_email, $user_name);
				break;
			case "mailpoet":
				$mp_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_mp_list' );				
				$output = self::subscribe_mailpoet($mp_list, $user_email, $user_name);
				break;
			case "mailerlite":
				$ml_api = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_ml_api' );
				$ml_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_ml_list' );
				$output = self::subscribe_mailerlite($ml_api, $ml_list, $user_email, $user_name);
				break;
			case "activecampaign":				
				$ac_api_url = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_ac_api_url' );
				$ac_api = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_ac_api' );
				$ac_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_ac_list' );
								
				$output = self::subscribe_activecampaign($ac_api_url, $ac_api, $ac_list, $user_email, $user_name);
				break;
			case "campaignmonitor":
				$cm_api = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_cm_api' );
				$cm_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_cm_list' );
				
				$output = self::subscribe_campaignmonitor($cm_api, $cm_list, $user_email, $user_name);
				break;
			case "sendinblue":
				$sib_api = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_sib_api' );
				$sib_list = ESSBOptionValuesHelper::options_value ( $essb_options, 'subscribe_sib_list' );
				
				$output = self::subscribe_sendinblue($sib_api, $sib_list, $user_email, $user_name);
				break;
			default:								
				$output['code'] = '99';
				$output['message'] = __('Service is not supported', 'essb');
				
				if (in_array($connector, $external_connectors)) {
					$output['external_connector'] = $connector;
					
					$output = apply_filters("essb_subscribe_{$connector}", $user_email, $user_name, $output);
				}
				
				break;
		}
		
		// @since 5.3 add if exising thank you redirect
		$thankyou_redirect = essb_option_value('subscribe_success');
		if ($thankyou_redirect != '') {
			$output['redirect_new'] = essb_option_bool_value('subscribe_success_new');
			$output['redirect'] = $thankyou_redirect;
		}
		
		return $output;
	}
	
	public static function subscribe_mailchimp($api_key, $list_id, $email, $double_option = false, $send_welcome = false, $name = '') {
		
		$dc = "us1";
		if (strstr ( $api_key, "-" )) {
			list ( $key, $dc ) = explode ( "-", $api_key, 2 );
			if (! $dc)
				$dc = "us1";
		}
		$mailchimp_url = 'https://' . $dc . '.api.mailchimp.com/2.0/lists/subscribe.json';
		$data = array ('apikey' => $api_key, 
				'id' => $list_id, 
				'email' => array ('email' => $email ), 
				'merge_vars' => array (
						'optin_ip' => $_SERVER ['REMOTE_ADDR'] ), 
				'replace_interests' => false, 
				'double_optin' => ($double_option ? true : false), 
				'send_welcome' => ($send_welcome == 'on' ? true : false), 
				'update_existing' => true );
		
		if (!empty($name)) {
			$fname = $name;
			$lname = '';
			if ($space_pos = strpos($name, ' ')) {
				$fname = substr($name, 0, $space_pos);
				$lname = substr($name, $space_pos);
			}

			$data['merge_vars']['FNAME'] = $fname;
			$data['merge_vars']['LNAME'] = $lname;
		}
		
		$request = json_encode ( $data );
		$response = array();
		try {
			$curl = curl_init ( $mailchimp_url );
			curl_setopt ( $curl, CURLOPT_POST, 1 );
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $request );
			curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
			curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $curl, CURLOPT_FORBID_REUSE, 1 );
			curl_setopt ( $curl, CURLOPT_FRESH_CONNECT, 1 );
			// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
			curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
			
			$response = curl_exec ( $curl );
			curl_close ( $curl );
		} 
		catch ( Exception $e ) {
		}
		
		return $response;
	}
	
	public static function subscribe_getresponse($api_key, $list_id, $email, $name = '') {
	
		if (!class_exists('GetResponse')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/external/getresponse/getresponse3.php');
	
		}
	
		$response = array();
	
		$api = new GetResponse ( $api_key );
		$campaignName = $list_id;
		$subscriberName = $name;
		$subscriberEmail = $email;
		
		
		$campaignId = $api->getCampaignId($campaignName);
		if ($name == '') {
			$parts = explode('@', $email);
			$name = $parts[0];
		}
		
		if ($campaignId != '') {
			$data = array(
					'campaign' => array('campaignId' => $campaignId),
					'name' => $name,
					'email' => $email,
					'dayOfCycle' => 0,
			);
		
			$result = $api->subscribe($data);
	
			$response ['code'] = '1';
			$response ['message'] = 'Thank you';
			
			
		}
		else {
			$response ['code'] = "99";
			$response ['message'] = __ ( 'Missing connection', 'essb' );
			
		}
	
		return $response;
	}
	
	public static function subscribe_mailerlite($api_key, $list_id, $email, $name = '') {
	
		$response = array();
		
		$data = array(
				'apiKey' => $api_key,
				'id' => $list_id,
				'email' => $email,
				'name' => $name,
				'resubscribe' => '1'
		);
		$request = http_build_query($data);
		
		try {
			$curl = curl_init('https://app.mailerlite.com/api/v1/subscribers/'.$list_id.'/');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
			
			$server_response = curl_exec($curl);
			curl_close($curl);
			
			$response ['code'] = '1';
			$response ['message'] = 'Thank you';
		}
		catch (Exception $e) {
			$response ['code'] = "99";
			$response ['message'] = __ ( 'Missing connection', 'essb' );
		}
		
		return $response;
	}
	
	public static function subscribe_mymail($list_id, $email, $name = '') {
		$response = array();
		
		
		if (function_exists('mymail_subscribe') || function_exists('mymail')) {
			$response ['code'] = '1';
			$response ['message'] = 'Thank you';
			
			if (function_exists('mymail')) {
				$list = mymail('lists')->get($list_id);
			} else {
				$list = get_term_by('id', $list_id, 'newsletter_lists');
			}
			
			if (!empty($list)) {
				try {
					// set as pending state when double opt-in is set to Yes
					$double = essb_option_bool_value('subscribe_mm_double');
					if (function_exists('mymail')) {
						$entry = array(
								'firstname' => $name,
								'email' => $email,
								'status' => $double ? 0 : 1,
								'ip' => $_SERVER['REMOTE_ADDR'],
								'signup_ip' => $_SERVER['REMOTE_ADDR'],
								'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
								'signup' =>time()
						);
						
						$subscriber_id = mymail('subscribers')->add($entry, true);
						if (is_wp_error( $subscriber_id )) {
							$response['code'] = '99';
							return $response;
						}
						$result = mymail('subscribers')->assign_lists($subscriber_id, array($list->ID));
					} else {
						$result = mymail_subscribe($_subscriber['{subscription-email}'], array('firstname' => $_subscriber['{subscription-name}']), array($list->slug), $double);
					}
				} catch (Exception $e) {
					$response['code'] = '99';
				}
			}
		}
		else {
			$response ['code'] = "99";
			$response ['message'] = __ ( 'Missing connection', 'essb' );
		}
		
		return $response;
	}
	
	// add support of MailPoet3
	// http://beta.docs.mailpoet.com/article/195-add-subscribers-through-your-own-form-or-plugin
	
	public static function subscribe_mailpoet($list_id, $email, $name = '') {
		$response = array();
	
	
				
			if (class_exists('WYSIJA')) {
				try {
					$response ['code'] = '1';
					$response ['message'] = 'Thank you';
					$user_data = array(
							'email' => $email,
							'firstname' => $name,
							'lastname' => '');
					$data_subscriber = array(
							'user' => $user_data,
							'user_list' => array('list_ids' => array($list_id))
					);
					$helper_user = WYSIJA::get('user','helper');
					$helper_user->addSubscriber($data_subscriber);
				} catch (Exception $e) {
					$response['code'] = '99';
					$response ['message'] = __ ( 'Missing connection', 'essb' );
				}
			}
			
			if (class_exists('\MailPoet\API\API')) {
				try {
					$response ['code'] = '1';
					$response ['message'] = 'Thank you';
					$user_data = array(
							'email' => $email,
							'first_name' => $name,
							'last_name' => '');
					$data_subscriber = array(
							'user' => $user_data,
							'user_list' => array('list_ids' => array($list_id))
					);
					$subscriber = \MailPoet\API\API::MP('v1')->addSubscriber($user_data, array($list_id));
				} catch (Exception $e) {
					$response['code'] = '99';
					$response ['message'] = __ ( 'Missing connection', 'essb' );
				}
			}
	
		return $response;
	}

	public static function subscribe_activecampaign($api_url, $api_key, $list_id, $email, $name = '') {
	
		$response = array();
	
		$data = array(
				'api_action' => 'contact_add',
				'api_key' => $api_key,
				'api_output' => 'serialize',
				'p['.$list_id.']' => $list_id,
				'email' => $email
		);
		
		if ($name != '') {
			$data['first_name'] = $name;
			$data['last_name'] = '';
		}
		
		$request = http_build_query($data);
	
		try {
			$url = str_replace('https://', 'http://', $api_url);
			$curl = curl_init($url.'/admin/api.php?api_action=contact_add');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_TIMEOUT, 20);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			$server_response = curl_exec($curl);
			curl_close($curl);
				
			$response ['code'] = '1';
			$response ['message'] = 'Thank you';
		}
		catch (Exception $e) {
			$response ['code'] = "99";
			$response ['message'] = __ ( 'Missing connection', 'essb' );
		}
	
		return $response;
	}

	public static function subscribe_campaignmonitor($api_key, $list_id, $email, $name = '') {
	
		$response = array();
			
	
		try {
			$options['EmailAddress'] = $email;
			$options['Name'] = $name;
			$options['Resubscribe'] = 'true';
			$options['RestartSubscriptionBasedAutoresponders'] = 'true';
			$post = json_encode($options);

			$curl = curl_init('http://api.createsend.com/api/v3/subscribers/'.urlencode($list_id).'.json');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
				
			$header = array(
				'Content-Type: application/json',
				'Content-Length: '.strlen($post),
				'Authorization: Basic '.base64_encode($api_key)
				);

			//curl_setopt($curl, CURLOPT_PORT, 443);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
			//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); // verify certificate
			//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // check existence of CN and verify that it matches hostname
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
					
			$server_response = curl_exec($curl);
			curl_close($curl);
			
				
			$response ['code'] = '1';
			$response ['message'] = 'Thank you';
		}
		catch (Exception $e) {
			$response ['code'] = "99";
			$response ['message'] = __ ( 'Missing connection', 'essb' );
		}
	
		return $response;
	}
	

	public static function subscribe_sendinblue($api_key, $list_id, $email, $name = '') {
	
		$response = array();
			
	
		try {
			$headers = array(
				'api-key: '.$api_key,
				'Content-Type: application/json'
			);
			$data = array(
				'listid' => array($list_id),
				'email' => $email,
				'blacklisted' => 0
			);			
			

			try {
				$curl = curl_init('https://api.sendinblue.com/v2.0/user/createdituser');
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($curl, CURLOPT_TIMEOUT, 10);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
				curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
				$response_api = curl_exec($curl);
				curl_close($curl);
			} catch (Exception $e) {
			}
			
			
				
			$response ['code'] = '1';
			$response ['message'] = 'Thank you';
		}
		catch (Exception $e) {
			$response ['code'] = "99";
			$response ['message'] = __ ( 'Missing connection', 'essb' );
		}
	
		return $response;
	}
}