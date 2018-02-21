<?php
/**
 * Async Counter Update Functions
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2017 AppsCreo
 * @since 4.2
 *
 */

class ESSBAsyncShareCounters {
	
	public $counters = array ();
	
	private $post_id = "";
	private $url = "";
	private $full_url = "";
	private $timeout = "";
	private $networks = array ();
	private $recovery_mode = false;
	private $twitter_counter = 'self';
	
	public function __construct($post_id, $url, $full_url, $networks = array(), $recover_mode = false, $twitter_counter = 'self', $timeout = 10) {
		
		$this->post_id = $post_id;
		$this->url = $url;
		$this->full_url = $full_url;
		$this->networks = $networks;
		$this->recovery_mode = $recover_mode;
		$this->twitter_counter = $twitter_counter;
		$this->timeout = $timeout;
	
	}
	
	public function get_counters() {
		
		// loading async class if not present till now
		essb_depend_load_class ( 'RollingCurlX', 'lib/external/rollingcurlx/RolingCurlX.php' );
		
		$this->counters = array ();
		$this->counters ['total'] = 0;
		
		$post_data = null;
		$headers = null;
		
		$options = array (CURLOPT_SSL_VERIFYPEER => FALSE, CURLOPT_SSL_VERIFYHOST => FALSE );
		
		$RollingCurlX = new RollingCurlX ( 10 ); // max 10 simultaneous downloads
		$RollingCurlX->setOptions ( $options );
		
		$url = $this->url;
		$full_url = $this->full_url;
		$recover_mode = $this->recovery_mode;
		$twitter_counter = $this->twitter_counter;
		
		foreach ( $this->networks as $k ) {
			switch ($k) {
				case 'facebook' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'twitter' :
					if ($twitter_counter == 'api') {
						$this->counters [$k] = 0;
					} else if ($twitter_counter == 'newsc') {
						$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $full_url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					} 
					else if ($twitter_counter == 'opensc') {
						$RollingCurlX->addRequest ( $this->prepare_request_url ( 'twitter_opensc', $full_url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					}
					else {
						if ($twitter_counter == 'self') {
							if (! $recover_mode) {
								$this->counters [$k] = $this->get_internal_count ( $this->post_id, $k );
							} else {
								$this->counters [$k] = 0;
							}
							
							$this->counters ['total'] += intval ( isset ( $this->counters [$k] ) ? $this->counters [$k] : 0 );
						}
					}
					break;
				case 'linkedin' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'pinterest' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'google' :
					//$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					if (essb_option_value('google_counter_type') == 'self') {
						if (! $recover_mode) {
							$this->counters [$k] = $this->get_internal_count ( $this->post_id, $k );
						} else {
							$this->counters [$k] = 0;
						}
					}
					else {
						$this->counters[$k] = $this->get_google_count_api($url);
					}
					break;
				case 'stumbleupon' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'vk' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'reddit' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'buffer' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'love' :
					if (! $recover_mode) {
						$this->counters [$k] = $this->get_loves_count ( $this->post_id );
					} else {
						$this->counters [$k] = 0;
					}
					$this->counters ['total'] += intval ( isset ( $this->counters [$k] ) ? $this->counters [$k] : 0 );
					break;
				case 'ok' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'mwp' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'xing' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				case 'comments' :
					if (! $recover_mode) {
						$this->counters [$k] = $this->get_comments_count ( $this->post_id );
					} else {
						$this->counters [$k] = 0;
					}
					$this->counters ['total'] += intval ( isset ( $this->counters [$k] ) ? $this->counters [$k] : 0 );
					break;
				case 'yummly' :
					$RollingCurlX->addRequest ( $this->prepare_request_url ( $k, $url ), $post_data, array ($this, 'get_counts' ), array ($k ), $headers );
					break;
				default :
					if (! $recover_mode) {
						$this->counters [$k] = $this->get_internal_count ( $this->post_id, $k );
					} else {
						$this->counters [$k] = 0;
					}
					$this->counters ['total'] += intval ( isset ( $this->counters [$k] ) ? $this->counters [$k] : 0 );
					break;
			
			}
		}
		
		$RollingCurlX->execute();
		
		return $this->counters;
	}
	
	private function prepare_request_url($service, $url) {
		$callback_url = '';
		
		switch ($service) {
			case 'facebook' :
				$callback_url = 'https://graph.facebook.com/?id=' . $url;
				
				$facebook_token = essb_option_value ( 'facebook_counter_token' );
				if ($facebook_token != '') {
					$callback_url = 'https://graph.facebook.com/?id=' . $url . '&access_token=' . sanitize_text_field ( $facebook_token );
				}
				if (essb_option_value('facebook_counter_api') == 'api2') {
					$callback_url = 'https://graph.facebook.com/?fields=og_object%7Blikes.summary(true).limit(0)%7D,share&id='.$url;
				}
				
				if (essb_option_value('facebook_counter_api') == 'api3') {
					$callback_url = 'https://graph.facebook.com/?id='.$url.'&fields=og_object{engagement}';
				
					if ($facebook_token != '') {
						$callback_url .= '&access_token=' . sanitize_text_field($facebook_token);
					}
				}
				
				break;
			case 'twitter' :
				$callback_url = 'https://public.newsharecounts.com/count.json?url=' . $url;
				break;
			case 'twitter_opensc' :
				$callback_url = 'https://opensharecount.com/count.json?url=' . $url;
				break;
				
			case 'linkedin' :
				$callback_url = 'https://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json';
				break;
			case 'pinterest' :
				$callback_url = 'https://api.pinterest.com/v1/urls/count.json?url=' . $url;
				break;
			case 'google' :
				$callback_url = 'https://plusone.google.com/_/+1/fastbutton?url=' . $url;
				break;
			case 'stumbleupon' :
				$callback_url = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $url;
				break;
			case 'vk' :
				$callback_url = 'https://vk.com/share.php?act=count&url=' . $url;
				break;
			case 'reddit' :
				$callback_url = 'https://www.reddit.com/api/info.json?url=' . $url;
				break;
			case 'buffer' :
				$callback_url = 'https://api.bufferapp.com/1/links/shares.json?url=' . $url;
				break;
			case 'ok' :
				$callback_url = 'https://connect.ok.ru/dk?st.cmd=extLike&uid=odklcnt0&ref=' . $url;
				break;
			case 'mwp' :
				$callback_url = 'https://managewp.org/share/frame/small?url=' . $url;
				break;
			case 'xing' :
				$callback_url = sprintf ( 'https://www.xing-share.com/app/share?op=get_share_button;url=%s;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle', urlencode ( $url ) );
				break;
			case 'yummly' :
				$callback_url = 'https://www.yummly.com/services/yum-count?url=' . $url;
				break;
		}
		
		return $callback_url;
	}
	
	private function get_internal_count($postID, $service) {
		if (! is_numeric ( $postID )) {
			return - 1;
		}
		
		$current_count = get_post_meta ( $postID, 'essb_pc_' . $service, true );
		
		return intval ( $current_count );
		;
	}
	
	private function get_loves_count($postID) {
		if (! is_numeric ( $postID )) {
			return 0;
		}
		
		$love_count = get_post_meta ( $postID, '_essb_love', true );
		
		if (! $love_count) {
			$love_count = 0;
			add_post_meta ( $postID, '_essb_love', $love_count, true );
		}
		
		return $love_count;
	}
	
	private function get_google_count_api($url) {
	$counter_curl_fix = essb_option_value('counter_curl_fix');
	
	$options = array(
			CURLOPT_RETURNTRANSFER	=> true, 	// return web page
			CURLOPT_HEADER 			=> false, 	// don't return headers
			//CURLOPT_FOLLOWLOCATION	=> true, 	// follow redirects
			CURLOPT_ENCODING	 	=> "", 		// handle all encodings
			CURLOPT_USERAGENT	 	=> isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'essb', 	// who am i
			CURLOPT_AUTOREFERER 	=> true, 	// set referer on redirect
			CURLOPT_CONNECTTIMEOUT 	=> 5, 		// timeout on connect
			CURLOPT_TIMEOUT 		=> 10, 		// timeout on response
			CURLOPT_MAXREDIRS 		=> 3, 		// stop after 3 redirects
			CURLOPT_SSL_VERIFYHOST 	=> 0,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_FAILONERROR => false,
			CURLOPT_NOSIGNAL => 1,
	);
	$ch = curl_init();
	
	if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
		$options[CURLOPT_FOLLOWLOCATION] = true;
	}
	
	$options[CURLOPT_URL] = 'https://clients6.google.com/rpc';
	
	$api_key = essb_option_value('google_counter_token');
	if ($api_key != '') {
		$options[CURLOPT_URL] = 'https://clients6.google.com/rpc?key='.$api_key;
	}
	
	$options[CURLOPT_POST] = true;
	$options[CURLOPT_POSTFIELDS] = '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . rawurldecode( $url ) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]';
	$options[CURLOPT_HTTPHEADER] = array( 'Content-type: application/json' );
	
	
	curl_setopt_array($ch, $options);
	// force ip v4 - uncomment this
	try {
		//print 'curl state = '.$counter_curl_fix;
		if ($counter_curl_fix != 'true') {
			curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		}
	}
	catch (Exception $e) {
	
	}
	
	
	$content	= curl_exec( $ch );
	$err 		= curl_errno( $ch );
	$errmsg 	= curl_error( $ch );
	
	curl_close( $ch );
	
	if ($errmsg != '' || $err != '') {
		print_r($errmsg);
	}
	
	$result = 0;
	
	try {
		$response = json_decode( $content, true );
		$result = isset( $response[0]['result']['metadata']['globalCounts']['count'] )?intval( $response[0]['result']['metadata']['globalCounts']['count'] ):0;
		
	}
	catch (Exception $e) {
		$result = 0;
	}
	
	return $result;
}
	
	private function get_comments_count($post_id) {
		$comments_count = wp_count_comments ( $post_id );
		
		return $comments_count->approved;
	}
	
	function get_counts( $data, $url, $request_info, $service, $time ) {
		$k = $service[0];
		$result = 0;
		
		if ($data) {
			switch ($k) {
				case 'facebook':
					$content = json_decode ( $data, true );
					
					$data_parsers = $content;
					if (essb_option_value('facebook_counter_api') == 'api3') {
						$result = isset( $data_parsers['og_object']['engagement']['count']) ? intval ( $data_parsers['og_object']['engagement']['count'] ) : 0;						
					}
					else if (essb_option_value('facebook_counter_api') == 'api2') {
						if( !empty( $data_parsers['og_object'] ) ) {
							$likes = $data_parsers['og_object']['likes']['summary']['total_count'];
						} else {
							$likes = 0;
						}
							
						if( !empty( $data_parsers['share'] ) ){
							$comments = $data_parsers['share']['comment_count'];
							$shares = $data_parsers['share']['share_count'];
						} else {
							$comments = 0;
							$shares = 0;
						}
							
						$result = $likes + $comments + $shares;
					}
					else {
						$result = isset ( $data_parsers ['share'] ['share_count'] ) ? intval ( $data_parsers ['share'] ['share_count'] ) : 0;
					}
					break;
				case 'twitter':
					$json = json_decode ( $data, true );
					$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
					break;
				case 'twitter_opensc':
					$json = json_decode ( $data, true );
					$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
					break;
				case 'linkedin':
					$json = json_decode ( $data, true );
					$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
					break;
				case 'pinterest':
					$json_string = preg_replace ( '/^receiveCount\((.*)\)$/', "\\1", $data );
					$json = json_decode ( $json_string, true );
					$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
					break;
					
				case 'google':
					preg_match( "#window\.__SSR = {c: ([\d]+)#", $data, $matches );
                    if( isset( $matches[0] ) ) {
                        $result = str_replace( 'window.__SSR = {c: ', '', $matches[0] );
                    }
					break;
				case 'stumbleupon':
					$data = json_decode ( $data );
					if (isset ( $data->result->views )) {
						$result = $data->result->views;
					}
					break;
				case 'vk':
					$shares = array();
					
					preg_match( '/^VK\.Share\.count\(\d, (\d+)\);$/i', $data, $shares );
					
					$result = $shares[ 1 ];
					break;
				case 'reddit':
					$score = $ups = $downs = 0; //initialize
					$format = 'json';
					
					$content = $data;
					if($content) {
						if($format == 'json') {
							//print "result ".$content;
							$json = json_decode($content,true);
					
							if (isset($json['data']) && isset($json['data']['children'])) {
								foreach($json['data']['children'] as $child) { // we want all children for this example
									$ups+= (int) $child['data']['ups'];
									$downs+= (int) $child['data']['downs'];
									//$score+= (int) $child['data']['score']; //if you just want to grab the score directly
								}
								$score = $ups - $downs;
							}
						}
					}
					
					$result = $score;
					break;
				case 'buffer':
					$result = 0;
					if (!empty($data)) {
						$json = json_decode($data, true);
						$result = isset($json['shares']) ? intval($json['shares']) : 0;
					}
					break;
				case 'ok':
					$shares = array();
					try {
						preg_match( '/^ODKL\.updateCount\(\'odklcnt0\',\'(\d+)\'\);$/i', $data, $shares );
					
						$result = (int)$shares[ 1 ];
					}
					catch (Exception $e) {
						$result = 0;
					}
					break;
				case 'mwp':
					$shares = array();
					
					$count = 0;
					preg_match( '/<form(.*?)<\/form>/s', $data, $shares );
					
					if (count($shares) > 0) {
						$current_result = $shares[1];
					
						$second_parse = array();
						preg_match( '/<div>(.*?)<\/div>/s', $current_result, $second_parse );
					
						$value = $second_parse[1];
						$value = str_replace("<span>", "", $value);
						$value = str_replace("</span>", "", $value);
					
						$count = $value;
					}
					
					$result = $count;
					break;
				case 'xing':
					$shares = array();
					
					$count = 0;
					preg_match( '/<span class="xing-count top">(.*?)<\/span>/s', $data, $shares );
					
					if (count($shares) > 0) {
						$current_result = $shares[1];
					
						$count = $current_result;
					}
					
					$result = $count;
					break;
				case 'yummly':
					$result = 0;
					if (!empty($data)) {
						$json = json_decode($data, true);
						$result = isset($json['count']) ? intval($json['count']) : 0;
					}
					break;
			}
		}
		
		$this->counters[$k] = $result;
		$this->counters ['total'] += intval ( isset ( $this->counters [$k] ) ? $this->counters [$k] : 0 );
	}
}