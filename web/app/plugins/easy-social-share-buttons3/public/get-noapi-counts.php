<?php
	header('content-type: application/json');

	// parse() function

	function getManagedWPUpVote($url) {
		$buttonURL = sprintf('https://managewp.org/share/frame/small?url=%s', urlencode($url));
		$data  = parse($buttonURL);
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
		
		return $count;
	}
	
	function getXingCount($url) {
		//- Get Xing Shares counter from this https://www.xing-share.com/app/share?op=get_share_button;url=https://blog.xing.com/2012/01/the-shiny-new-xing-share-button-how-to-implement-it-in-your-blog-or-website/;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle
		$buttonURL = sprintf('https://www.xing-share.com/app/share?op=get_share_button;url=%s;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle', urlencode($url));
		$data  = parse($buttonURL);
		$shares = array();
		
		$count = 0;
		preg_match( '/<span class="xing-count top">(.*?)<\/span>/s', $data, $shares );
		
		if (count($shares) > 0) {
			$current_result = $shares[1];
				
			$count = $current_result;
		}
		
		return $count;
	}
	
	function getPocketCount($url) {
		//- Get Xing Shares counter from this https://www.xing-share.com/app/share?op=get_share_button;url=https://blog.xing.com/2012/01/the-shiny-new-xing-share-button-how-to-implement-it-in-your-blog-or-website/;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle
		$buttonURL = sprintf('https://widgets.getpocket.com/v1/button?align=center&count=vertical&label=pocket&url=%s', urlencode($url));
		$data  = parse($buttonURL);
		$shares = array();
	
		$count = 0;
		preg_match( '/<em id="cnt">(.*?)<\/em>/s', $data, $shares );
	
		if (count($shares) > 0) {
			$current_result = $shares[1];
	
			$count = $current_result;
		}
	
		return $count;
	}
	
	function getGplusShares($url) {
	
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
		$options[CURLOPT_POST] = true;
		$options[CURLOPT_POSTFIELDS] = '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . rawurldecode( $url ) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]';
		$options[CURLOPT_HTTPHEADER] = array( 'Content-type: application/json' );
	
	
		curl_setopt_array($ch, $options);
		// force ip v4 - uncomment this
		try {
			curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
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
	
	function getGplusShares1($url)
	{
		$buttonUrl = sprintf('https://plusone.google.com/u/0/_/+1/fastbutton?url=%s', urlencode($url));
		//$htmlData  = file_get_contents($buttonUrl);
		$htmlData  = parse($buttonUrl);
			
		@preg_match_all('#{c: (.*?),#si', $htmlData, $matches);
		$ret = isset($matches[1][0]) && strlen($matches[1][0]) > 0 ? trim($matches[1][0]) : 0;
		if(0 != $ret) {
			$ret = str_replace('.0', '', $ret);
		}
	
		return ($ret);
	}
	
	function get_counter_number_odnoklassniki( $url ) {
		$CHECK_URL_PREFIX = 'http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref=';
	
		$check_url = $CHECK_URL_PREFIX . $url;
	
		$data   = parse( $check_url );
		$shares = array();
	
		//print $check_url . ' = ' .$data;
		preg_match( '/^ODKL\.updateCount\(\'odklcnt0\',\'(\d+)\'\);$/i', $data, $shares );
	
		return (int)$shares[ 1 ];
	}
	
	function getRedditScore($url) {
		$reddit_url = 'http://www.reddit.com/api/info.json?url='.$url;
		$format = "json";
		$score = $ups = $downs = 0; //initialize
		
		/* action */
		$content = parse( $reddit_url );
		if($content) {
			if($format == 'json') {
				$json = json_decode($content,true);
				foreach($json['data']['children'] as $child) { // we want all children for this example
					$ups+= (int) $child['data']['ups'];
					$downs+= (int) $child['data']['downs'];
					//$score+= (int) $child['data']['score']; //if you just want to grab the score directly
				}
				$score = $ups - $downs;
			}
		}
		
		return $score;
	}
	
	function get_counter_number__vk( $url ) {
		$CHECK_URL_PREFIX = 'https://vk.com/share.php?act=count&url=';
	
		$check_url = $CHECK_URL_PREFIX . $url;
	
		$data   = parse( $check_url );
		$shares = array();
	
		preg_match( '/^VK\.Share\.count\(\d, (\d+)\);$/i', $data, $shares );
	
		return $shares[ 1 ];
	}
	
	function get_linkedin($url) {
		$json_string = parse ( "https://www.linkedin.com/countserv/count/share?url=$url&format=json" );
		$json = json_decode ( $json_string, true );
		$result = isset ( $json ['count'] ) ? intval ( $json ['count'] ) : 0;
		return $result;
	}
	
	
	
	function parse( $encUrl ) {

		$options = array(
			CURLOPT_RETURNTRANSFER	=> true, 	// return web page
			CURLOPT_HEADER 			=> false, 	// don't return headers
			//CURLOPT_FOLLOWLOCATION	=> true, 	// follow redirects
			CURLOPT_ENCODING	 	=> "", 		// handle all encodings
			CURLOPT_USERAGENT	 	=> 'essb', 	// who am i
			CURLOPT_AUTOREFERER 	=> true, 	// set referer on redirect
			CURLOPT_CONNECTTIMEOUT 	=> 5, 		// timeout on connect
			CURLOPT_TIMEOUT 		=> 10, 		// timeout on response
			CURLOPT_MAXREDIRS 		=> 3, 		// stop after 3 redirects
			CURLOPT_SSL_VERIFYHOST 	=> 0,
			CURLOPT_SSL_VERIFYPEER 	=> false,
		);
		$ch = curl_init();

		if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
			$options[CURLOPT_FOLLOWLOCATION] = true;
		}
		
		$options[CURLOPT_URL] = $encUrl;  
		curl_setopt_array($ch, $options);
		// force usage of v4
		try {
			curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
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


	// get counters

	$json = array('url'=>'','count'=>0, 'network'=>'', 'instance' => '');
	$url = isset($_GET['url']) ? $_GET['url'] : '';
	$json['url'] = $url;
	$network = isset($_GET['nw']) ? $_GET['nw'] : '';;
	$instance = isset($_GET['instance']) ? $_GET['instance'] : '';
	
	if ($url == '' && $network == '') { echo str_replace('\\/','/',json_encode($json)); die();}
	$json['network'] = $network;
	$json['instance'] = $instance;
	
	if ( filter_var($url, FILTER_VALIDATE_URL) ) {

		if ( $network == 'google2' ) {
			
			// http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
			$content = parse("https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true");
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false;
			@$dom->loadHTML($content);
			$domxpath = new DOMXPath($dom);
			$newDom = new DOMDocument;
			$newDom->formatOutput = true;

			$filtered = $domxpath->query("//div[@id='aggregateCount']");

			if ( isset( $filtered->item(0)->nodeValue ) ) {
				$cars = array("u00c2", "u00a", 'Ã‚Â ', 'Ã‚Â', 'Ã', ',', 'Â', 'Â ');
				$count = str_replace($cars, '', $filtered->item(0)->nodeValue );
				$json['count'] = preg_replace( '#([0-9])#', '$1', $count );
			}

		}
		elseif ( $network == 'stumble' || $network == 'stumbleupon' ) {
			
			$content = parse("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");

			$result = json_decode($content);
			if ( isset($result->result->views )) {
				$json['count'] = $result->result->views;
			}

		}
		elseif ($network == "ok") {
			$json['count'] = get_counter_number_odnoklassniki($url);
		}
		elseif ($network == "google") {
			$json['count'] = getGplusShares($url);
		
		}
		elseif ($network == "reddit") {
			$json['count'] = getRedditScore($url);		
		}				
		elseif ($network == 'vk') {
			$json['count'] = get_counter_number__vk($url);
		
		}		
		elseif ($network == "mwp") {
			$json['count'] = getManagedWPUpVote($url);
		}
		elseif ($network == "xing") {
			$json['count'] = getXingCount($url);
		}
		elseif ($network == "pocket") {
			$json['count'] = getPocketCount($url);
		}
		elseif ($network == "linkedin") {
			$json['count'] = get_linkedin($url);
		}
	}
	echo str_replace('\\/','/',json_encode($json));
?>