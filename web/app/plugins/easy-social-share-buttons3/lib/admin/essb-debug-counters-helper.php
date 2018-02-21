<?php

class ESSBDebugCountersHelper {
	
	public static function parse( $encUrl ) {
		global $essb_options;
		
		$counter_curl_fix = isset($essb_options['counter_curl_fix']) ? $essb_options['counter_curl_fix'] : 'false';
	
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
	
		$options[CURLOPT_URL] = $encUrl;
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
		return $content;
	}
	
	public static function get_shared_counter($network, $url) {
		$count = 0;
		$cached_counters = array();
		$k = "all";
		switch ($network) {
			case "facebook" :
					$cached_counters [$k] = self::get_facebook_count ( $url );
					break;
				case "twitter" :
					$cached_counters [$k] = self::get_tweets_newsc ( $url );
					break;
				case "linkedin" :
					$cached_counters [$k] = self::get_linkedin ( $url );
					break;
				case "pinterest" :
					$cached_counters [$k] = self::get_pinterest( $url );
					break;
				case "google" :
					$cached_counters [$k] = self::getGplusShares($url);
					break;
				case "stumbleupon" :
					$cached_counters [$k] = self::get_stumbleupon($url);
					break;
				case "vk" :
					$cached_counters [$k] = self::get_counter_number__vk($url);
					break;
				case "reddit" :
					$cached_counters [$k] = self::getRedditScore($url);
					break;
				case "buffer" :
					$cached_counters [$k] = self::get_buffer($url);
					break;
				case "ok":
					$cached_counters [$k] = self::get_counter_number_odnoklassniki ( $url );
					break;
				case "mwp" :
					$cached_counters [$k] = self::getManagedWPUpVote ( $url );
					break;
				case "xing" :
					$cached_counters [$k] = self::getXingCount($url);
					break;				
				case "yummly" :
					$cached_counters [$k] = self::get_yummly($url);
					break;
		}
		
		return $count;
	}
	
	
	public static function getXingCount($url) {
		//- Get Xing Shares counter from this https://www.xing-share.com/app/share?op=get_share_button;url=https://blog.xing.com/2012/01/the-shiny-new-xing-share-button-how-to-implement-it-in-your-blog-or-website/;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle
		$buttonURL = sprintf('https://www.xing-share.com/app/share?op=get_share_button;url=%s;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle', urlencode($url));
		$data  = self::parse($buttonURL);
		$shares = array();
	
		
		$count = 0;
		preg_match( '/<span class="xing-count top">(.*?)<\/span>/s', $data, $shares );
	
		if (count($shares) > 0) {
			$current_result = $shares[1];
	
			$count = $current_result;
		}
	
		print '<tr>';
		print '<td>Counter value: <b>'.$count.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$data.'</textarea></td>';
		print '</tr>';
	}
	
	public static function getPocketCount($url) {
		//- Get Xing Shares counter from this https://www.xing-share.com/app/share?op=get_share_button;url=https://blog.xing.com/2012/01/the-shiny-new-xing-share-button-how-to-implement-it-in-your-blog-or-website/;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle
		$buttonURL = sprintf('https://widgets.getpocket.com/v1/button?align=center&count=vertical&label=pocket&url=%s', urlencode($url));
		$data  = self::parse($buttonURL);
		$shares = array();
	
		$count = 0;
		preg_match( '/<em id="cnt">(.*?)<\/em>/s', $data, $shares );
	
		if (count($shares) > 0) {
			$current_result = $shares[1];
	
			$count = $current_result;
		}
	
		print '<tr>';
		print '<td>Counter value: <b>'.$count.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$data.'</textarea></td>';
		print '</tr>';
	}
	
	public static function getGplusShares($url) {
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
	
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$content.'</textarea></td>';
		print '</tr>';
	}

	public static function getGplusShares1($url)
	{
		$buttonUrl = sprintf('https://plusone.google.com/u/0/_/+1/fastbutton?url=%s', urlencode($url));
		//$htmlData  = file_get_contents($buttonUrl);
		$htmlData  = self::parse($buttonUrl);
	
		@preg_match_all('#{c: (.*?),#si', $htmlData, $matches);
		$ret = isset($matches[1][0]) && strlen($matches[1][0]) > 0 ? trim($matches[1][0]) : 0;
		if(0 != $ret) {
			$ret = str_replace('.0', '', $ret);
		}
	
		print '<tr>';
		print '<td>Counter value: <b>'.$ret.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$htmlData.'</textarea></td>';
		print '</tr>';
		
	}
	
	public static function get_counter_number_odnoklassniki( $url ) {
		//$CHECK_URL_PREFIX = 'http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref=';
		$CHECK_URL_PREFIX = 'https://connect.ok.ru/dk?st.cmd=extLike&uid=odklcnt0&ref=';
		
		$check_url = $CHECK_URL_PREFIX . $url;
			
		$data   = self::parse( $check_url );
		$shares = array();
		$count = 0;
		try {
			preg_match( '/^ODKL\.updateCount\(\'odklcnt0\',\'(\d+)\'\);$/i', $data, $shares );
	
			$count = (int)$shares[ 1 ];
		}
		catch (Exception $e) {
			//return 0;
		}
		
		print '<tr>';
		print '<td>Counter value: <b>'.$count.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$data.'</textarea></td>';
		print '</tr>';
 	}
	
	public static function get_counter_number__vk( $url ) {
		$CHECK_URL_PREFIX = 'https://vk.com/share.php?act=count&url=';
	
		$check_url = $CHECK_URL_PREFIX . $url;
	
		$data   = self::parse( $check_url );
		$shares = array();
			
		preg_match( '/^VK\.Share\.count\(\d, (\d+)\);$/i', $data, $shares );
	
		$count = $shares[1];
		
		print '<tr>';
		print '<td>Counter value: <b>'.$count.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$data.'</textarea></td>';
		print '</tr>';
		
		///return $shares[ 1 ];
	}
	
	public static function getManagedWPUpVote($url) {
		$buttonURL = sprintf('https://managewp.org/share/frame/small?url=%s', urlencode($url));
		$data  = self::parse($buttonURL);
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
	
		//return $count;
		print '<tr>';
		print '<td>Counter value: <b>'.$count.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$data.'</textarea></td>';
		print '</tr>';
	}
	
	public static function getRedditScore($url) {
		$reddit_url = 'https://www.reddit.com/api/info.json?url='.$url;
		$format = "json";
		$score = $ups = $downs = 0; //initialize
	
		//print $reddit_url;
		//http://stackoverflow.com/questions/8963485/error-429-when-invoking-reddit-api-from-google-app-engine
		/* action */
		$content = self::parse( $reddit_url );
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
	
		//return $score;
		print '<tr>';
		print '<td>Counter value: <b>'.$score.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$content.'</textarea></td>';
		print '</tr>';
	}
	
	public static function get_facebook_count($url) {
		
		//$parse_url = 'https://graph.facebook.com/fql?q=SELECT%20like_count,%20total_count,%20share_count,%20click_count,%20comment_count%20FROM%20link_stat%20WHERE%20url%20=%20%22' . $url . '%22';
		//$parse_url = 'https://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$url;
		$parse_url = 'https://graph.facebook.com/?id='.$url;
		$api2 = false;
		
		$facebook_token = essb_option_value('facebook_counter_token');
		if ($facebook_token != '') {
			$parse_url = 'https://graph.facebook.com/?id='.$url.'&access_token=' . sanitize_text_field($facebook_token);
		}
		
		if (essb_option_value('facebook_counter_api') == 'api2') {
			$parse_url = 'https://graph.facebook.com/?fields=og_object%7Blikes.summary(true).limit(0)%7D,share&id='.$url;
			$api2 = true;
		}
		
		$api3 = false;
		if (essb_option_value('facebook_counter_api') == 'api3') {
			$parse_url = 'https://graph.facebook.com/?id='.$url.'&fields=og_object{engagement}';
			$api3 = true;
		
			if ($facebook_token != '') {
				$parse_url .= '&access_token=' . sanitize_text_field($facebook_token);
			}
		}
		
		$content = self::parse ( $parse_url );
		
		//print " facebook output = ".$content;
		$result = 0;
		$result_comments = 0;
		
		if ($content != '') {
			$content1 = json_decode ( $content, true );
		
			$data_parsers = $content1;
			//$result = isset ( $data_parsers ['share'] ['share_count'] ) ? intval ( $data_parsers ['share'] ['share_count'] ) : 0;
			if ($api3) {
				$result = isset( $data_parsers['og_object']['engagement']['count']) ? intval ( $data_parsers['og_object']['engagement']['count'] ) : 0;
			}
			else if ($api2) {
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
			//$result_comments = isset ( $data_parsers [0] ['comment_count'] ) ? intval ( $data_parsers [0] ['comment_count'] ) : 0;
		}
		
		//return $result;
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$content.'</textarea></td>';
		print '</tr>';
		
	}
	
	public static function get_tweets($url) {
		$json_string = self::parse  ( 'https://urls.api.twitter.com/1/urls/count.json?url=' . $url );
		$json = json_decode ( $json_string, true );
		$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
	
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$json_string.'</textarea></td>';
		print '</tr>';
		
		//return $result;
	}
	
	public static function get_tweets_newsc($url) {
		$json_string = self::parse  ( 'https://public.newsharecounts.com/count.json?url=' . $url );
		$json = json_decode ( $json_string, true );
		$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
		
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$json_string.'</textarea></td>';
		print '</tr>';
		//return $result;
	}
	
	public static function get_linkedin($url) {
		$json_string = self::parse ( "https://www.linkedin.com/countserv/count/share?url=$url&format=json" );
		$json = json_decode ( $json_string, true );
		$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
		//return $result;
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$json_string.'</textarea></td>';
		print '</tr>';
	}
	
	public static function get_pinterest($url) {
		$return_data = self::parse ( 'https://api.pinterest.com/v1/urls/count.json?url=' . $url );
		$json_string = preg_replace ( '/^receiveCount\((.*)\)$/', "\\1", $return_data );
		$json = json_decode ( $json_string, true );
		$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
	
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$json_string.'</textarea></td>';
		print '</tr>';
		//return $result;
	}
	
	public static function get_buffer($url) {
		$return_data = self::parse('https://api.bufferapp.com/1/links/shares.json?url='.$url);
		
		$result = 0;
		if (!empty($return_data)) {
			$json = json_decode($return_data, true);
			$result = isset($json['shares']) ? intval($json['shares']) : 0;
		}
		
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$return_data.'</textarea></td>';
		print '</tr>';
		
		//return $result;
	}
	
	public static function get_stumbleupon($url) {
		$count = 0;
		$content = self::parse ( "http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url" );
		
		$result = json_decode ( $content );
		if (isset ( $result->result->views )) {
			$count = $result->result->views;
		}
		
		//return $count;
		print '<tr>';
		print '<td>Counter value: <b>'.$count.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$content.'</textarea></td>';
		print '</tr>';
	}
	
	public static function get_yummly($url) {
		$return_data = self::parse('https://www.yummly.com/services/yum-count?url='.$url);
	
		$result = 0;
		if (!empty($return_data)) {
			$json = json_decode($return_data, true);
			$result = isset($json['count']) ? intval($json['count']) : 0;
		}
	
		print '<tr>';
		print '<td>Counter value: <b>'.$result.'</b></td>';
		print '<td><textarea class="input-element debug-out" style="width: 100%; height: 200px;">'.$return_data.'</textarea></td>';
		print '</tr>';
		
		//return $result;
	}
}


?>