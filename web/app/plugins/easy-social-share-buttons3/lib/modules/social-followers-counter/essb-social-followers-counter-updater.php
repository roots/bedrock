<?php

class ESSBSocialFollowersCounterUpdater {
	
	public function __construct() {
		if (! class_exists ( 'OAuthServer' )) {
			require_once ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/OAuth/OAuth.php';
		}
	}
	
	/**
	 * remote_update_curl
	 *
	 * Remote update counter using cURL library
	 *
	 * @param $url string       	
	 * @return mixed
	 */
	public function remote_update_curl($url) {
		if (! extension_loaded ( 'curl' ))
			return;
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 2 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_VERBOSE, true );
		$data = curl_exec ( $ch );
		curl_close ( $ch );
		return $data;
	}
	
	/**
	 * remote_update
	 *
	 * Remote update using WordPress functions
	 *
	 * @param $url string       	
	 * @param $json boolean       	
	 * @return mixed
	 */
	public function remote_update($url, $json = true) {
		$get_request = wp_remote_get ( $url, array ('timeout' => 5, 'sslverify' => false ) );
		$request = wp_remote_retrieve_body ( $get_request );
		if ($json)
			$request = @json_decode ( $request, true );
		return $request;
	}
	
	public function remote_get($url, $json = true, $args = array( 'timeout' => 18 , 'sslverify' => false )) {
		$get_request = wp_remote_get ( $url, $args );
		$request = wp_remote_retrieve_body ( $get_request );
		if ($json)
			$request = @json_decode ( $request, true );
		return $request;
		
	}
	
	public function update_love() {
		$result = 0;
		
		try {
			$args = array ('posts_per_page' => - 1, 'post_type' => 'any' );
			$posts = get_posts ( $args );
			if ($posts) {
				foreach ( $posts as $post ) {
					$love_count = get_post_meta ( $post->ID, '_essb_love', true );
					
					$love_count = intval ( $love_count );
					$result = $result + $love_count;
				}
			}
		
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	}
	
	public function update_twitter() {
		
		
		$consumer_key = ESSBSocialFollowersCounterHelper::get_option ( 'twitter_consumer_key' );
		$consumer_secret = ESSBSocialFollowersCounterHelper::get_option ( 'twitter_consumer_secret' );
		$access_token = ESSBSocialFollowersCounterHelper::get_option ( 'twitter_access_token' );
		$access_token_secret = ESSBSocialFollowersCounterHelper::get_option ( 'twitter_access_token_secret' );
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'twitter_id' );
		
		if (empty ( $consumer_key ) || empty ( $consumer_secret ) || empty ( $access_token ) || empty ( $access_token_secret ) || empty ( $id )) {
			return 0;
		}
		
		if (! class_exists ( 'TwitterOAuth' )) {
			include_once ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/twitter/twitteroauth.php';
		}
		
		$api = new TwitterOAuth ( $consumer_key, $consumer_secret, $access_token, $access_token_secret );
		$response = $api->get ( 'users/lookup', array ('screen_name' => trim ( $id ) ) );
		
		if (isset ( $response->errors )) {
			return null;
		}
		
		if (isset ( $response [0] ) && is_array ( $response [0] )) {
			return $response [0] ['followers_count'];
		}
		
		if (isset ( $response [0]->followers_count )) {
			return $response [0]->followers_count;
		}
	}
	
	public function update_facebook() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'facebook_id' );
		$access_token = ESSBSocialFollowersCounterHelper::get_option ( 'facebook_access_token' );
		$account_type = ESSBSocialFollowersCounterHelper::get_option ( 'facebook_account_type', 'page' );
		
		if (! empty ( $id ) && empty ( $access_token )) {
			return $this->update_facebook_no_token ( $id );
		} else {
			if (($account_type == 'page' && empty ( $id )) || ($account_type == 'followers' && (empty ( $id ) || empty ( $access_token )))) {
				return 0;
			}
			
			if ($account_type == 'followers') {
				return $this->update_facebook_followers ();
			} else {
				return $this->update_facebook_page ();
			}
		}
	}
	
	private function update_facebook_no_token($id) {
		
		$data = $this->remote_update_curl ( 'http://graph.facebook.com/' . $id );
		$result = 0;
		if (! empty ( $data )) {
			$response = json_decode ( $data, true );
			if (isset ( $response ['likes'] )) {
				return $response ['likes'];
			}
		}
		
		return $result;
	
	}
	
	private function update_facebook_page() {
		try {
			$response = $this->remote_update ( 'https://graph.facebook.com/v2.8/' . ESSBSocialFollowersCounterHelper::get_option ( 'facebook_id' ) . '?fields=fan_count&access_token=' . ESSBSocialFollowersCounterHelper::get_option ( 'facebook_access_token' ) );

			if (isset ( $response ['fan_count'] )) {
				return $response ['fan_count'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	private function update_facebook_followers() {
		
		try {
			$response = $this->remote_update ( 'https://graph.facebook.com/v2.0/me/subscribers?access_token=' . ESSBSocialFollowersCounterHelper::get_option ( 'facebook_access_token' ) );
			if (isset ( $response ['summary'] )) {
				return $response ['summary'] ['total_count'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_googleplus() {
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'google_api_key' );
		if (trim ( $api_key ) == '') {
			// no followers value can be taken without access token
			return 0;
		} else {
			return $this->update_googleplus_api ();
		}
	}
	
	public function update_googleplus_api() {
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'google_id' );
		if (empty ( $id )) {
			return 0;
		}
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'google_api_key' );
		$value_type = ESSBSocialFollowersCounterHelper::get_option ( 'google_value_type' );
		
		$url = "https://www.googleapis.com/plus/v1/people/" . $id . "?key=" . $api_key;
		
		$data = $this->remote_update_curl ( $url );
		$circleCount = 0;
		$plusOneCount = 0;
		if (! empty ( $data )) {
			$jsonData = json_decode ( $data, true );
			if (! empty ( $jsonData ['plusOneCount'] )) {
				$count ['plusOneCount'] = $jsonData ['plusOneCount'];
				$plusOneCount = intval ( $jsonData ['plusOneCount'] );
			}
			if (! empty ( $jsonData ['circledByCount'] )) {
				$count ['circledByCount'] = $jsonData ['circledByCount'];
				$circleCount = intval ( $jsonData ['circledByCount'] );
			}
		
		}
		
		if ($value_type == "plusOneCount") {
			return $plusOneCount;
		} else if ($value_type == "circledByCount") {
			return $circleCount;
		} else {
			return ($circleCount + $plusOneCount);
		}
	}
	
	public function update_pinterest() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'pinterest_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		try {
			$request = @$this->remote_update ( 'https://www.pinterest.com/' . $id, false );
			if (false == $request) {
				return null;
			}
			
			@preg_match ( ' <meta property="pinterestapp:followers" name="pinterestapp:followers" content="(\d+)" data-app>', $request, $matches );
			
			if (count ( $matches > 0 ) && isset ( $matches [1] )) {
				return $matches [1];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	/**
	 * update_linkedin_token
	 * 
	 * Update of LinkedIn followers counter will work from now on with token only
	 * 
	 * @since 4.1
	 */
	public function update_linkedin_token() {
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'linkedin_id' );
		$token = ESSBSocialFollowersCounterHelper::get_option ( 'linkedin_token' );
		$type = ESSBSocialFollowersCounterHelper::get_option ( 'linkedin_type' );
		
		$result = 0;
		
		if( ! empty( $type ) && !empty( $token )){
		
			$args  = array(
					'headers' => array('Authorization' => sprintf('Bearer %s', $token))
			);
		
			if( $type == 'profile' && ! empty( $id )){
		
				try {
					$data   = $this->remote_get('https://api.linkedin.com/v1/people/~:(num-connections)?format=json', true, $args);
					$result = (int) $data['numConnections'];
				}
				catch (Exception $e) {
					$result = 0;
				}
		
			}
			elseif( $type == 'company' && ! empty( $id )){
		
				$page_id = sprintf('https://api.linkedin.com/v1/companies/%s/num-followers?format=json', $id );
		
				try {
					$data = $this->remote_get( $page_id, true, $args);
					if( !is_array( $data )){
						$result = $data;
					}
				}
				catch (Exception $e) {
					$result = 0;
				}
			}		
		}
		
		return $result;
		
	}
	
	public function update_linkedin() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'linkedin_id' );

		
		if (empty ( $id )) {
			return 0;
		}
		
		$result = 0;
		try {
			$html = $this->remote_update ( $id, false );
			$doc = new DOMDocument ();
			@$doc->loadHTML ( $html );
			$xpath = new DOMXPath ( $doc );
			$data = $xpath->evaluate ( 'string(//p[@class="followers-count"])' );
			$result = ( int ) preg_replace ( '/[^0-9.]+/', '', $data );
		
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	
	}
	
	public function update_github() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'github_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		try {
			$response = $this->remote_update ( 'https://api.github.com/users/' . $id );
			
			if (isset ( $response["followers"] )) {
				return $response["followers"];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_vimeo() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'vimeo_id' );
		$account_type = ESSBSocialFollowersCounterHelper::get_option ( 'vimeo_account_type', 'channel' );
		$access_token = ESSBSocialFollowersCounterHelper::get_option ( 'vimeo_access_token' );
		
		if (($account_type == 'channel' && empty ( $id )) || ($account_type == 'user' && (empty ( $id ) || empty ( $access_token )))) {
			return 0;
		}
		
		if ($account_type == 'user') {
			return $this->update_vimeo_user ();
		} else {
			return $this->update_vimeo_channel ();
		}
	}
	
	private function update_vimeo_channel() {
		
		try {
			$response = $this->remote_update ( 'http://vimeo.com/api/v2/channel/' . ESSBSocialFollowersCounterHelper::get_option ( 'vimeo_id' ) . '/info.json' );
			if (isset ( $response ['total_subscribers'] )) {
				return $response ['total_subscribers'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	private function update_vimeo_user() {
		
		try {
			$response = $this->remote_update ( 'https://api.vimeo.com/users/' . ESSBSocialFollowersCounterHelper::get_option ( 'vimeo_id' ) . '/followers?access_token=' . ESSBSocialFollowersCounterHelper::get_option ( 'vimeo_access_token' ) );
			if (isset ( $response ['total'] )) {
				return $response ['total'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_dribbble() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'dribbble_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'http://api.dribbble.com/' . $id );
			if (isset ( $response["followers_count"] )) {
				return $response["followers_count"];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_envato() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'envato_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'http://marketplace.envato.com/api/edge/user:' . $id . '.json' );
			if (isset ( $response['user'] ) && isset ( $response['user']['followers'] )) {
				return $response['user']['followers'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_soundcloud() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'soundcloud_id' );
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'soundcloud_api_key' );
		if (empty ( $id ) || empty ( $api_key )) {
			return 0;
		}
		
		try {
			
			$response = $this->remote_update ( 'http://api.soundcloud.com/users/' . $id . '.json?client_id=' . $api_key );
			if (isset ( $response["followers_count"] )) {
				return $response["followers_count"];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_behance() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'behance_id' );
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'behance_api_key' );
		
		if (empty ( $id ) || empty ( $api_key )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'http://www.behance.net/v2/users/' . $id . '/?api_key=' . $api_key );
			if (isset ( $response["user"] ) && isset ( $response["user"]["stats"] ) && isset ( $response["user"]["stats"]["followers"] )) {
				return $response["user"]["stats"]["followers"];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_delicious() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'delicious_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		try {
			$response = $this->remote_update ( 'http://feeds.delicious.com/v2/json/userinfo/' . $id );
			if (isset ( $response ['2'] ) && isset ( $response ['2']->n )) {
				return $response ['2']->n;
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_instagram() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'instgram_id' );
		$username = ESSBSocialFollowersCounterHelper::get_option ( 'instgram_username' );
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'instgram_api_key' );
		
		if (empty ( $id ) || empty ( $username ) || empty ( $api_key )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'https://api.instagram.com/v1/users/' . $id . '?access_token=' . $api_key );
			if (isset ( $response["data"] ) && isset ( $response["data"]["counts"] ) && isset ( $response["data"]["counts"]["followed_by"] )) {
				return $response["data"]["counts"]["followed_by"];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_youtube() {
		
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'youtube_api_key' );
		
		if (ESSBSocialFollowersCounterHelper::get_option ( 'youtube_account_type' ) == 'channel')
			return $this->update_youtube_api3_channel ( $api_key );
		
		if (ESSBSocialFollowersCounterHelper::get_option ( 'youtube_account_type' ) == 'user')
			return $this->update_youtube_api3_user ( $api_key );
	
	}
	
	public function update_youtube_api3_user($api_key = '') {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'youtube_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		$request = $this->remote_update_curl ( 'https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=' . $id . '&key=' . $api_key );
		
		if (false == $request) {
			return null;
		}
		
		$response = @json_decode ( $request );
		if (isset ( $response->items ) && isset ( $response->items [0]->statistics )) {
			return intval ( $response->items [0]->statistics->subscriberCount );
		}
	}
	
	public function update_youtube_api3_channel($api_key = '') {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'youtube_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		$request = $this->remote_update_curl ( 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id=' . $id . '&key=' . $api_key );
		
		if (false == $request) {
			return null;
		}
		
		$response = @json_decode ( $request );	
		
		if (isset ( $response->items ) && isset ( $response->items [0]->statistics )) {
			return intval ( $response->items [0]->statistics->subscriberCount );
		}
	}
	
	public function update_foursquare() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'foursquare_id' );
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'foursquare_api_key' );
		
		if (empty ( $id ) || empty ( $api_key )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'https://api.foursquare.com/v2/users/self?oauth_token=' . $api_key . '&v=' . date ( 'Ymd' ) );
			if (isset ( $response["response"] ) && isset ( $response["response"]["user"]) && isset ( $response["response"]["user"]["friends"]["count"] )) {
				return $response["response"]["user"]["friends"]["count"];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_forrst() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'forrst_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'http://forrst.com/api/v2/users/info?username=' . $id );
			if (isset ( $response["resp"] ) && isset ( $response["resp"]["followers"] )) {
				return $response["resp"]["followers"];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_mailchimp() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'mailchimp_list_id' );
		$api_key = ESSBSocialFollowersCounterHelper::get_option ( 'mailchimp_api_key' );
		
		if (empty ( $id ) || empty ( $api_key )) {
			return 0;
		}
		
		if (! class_exists ( 'MCAPI' )) {
			require_once ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/mailchimp/MCAPI.class.php';
		}
		
		$result = 0;
		try {
			$api = new MCAPI ( $api_key );
			$retval = $api->lists ();
			$result = 0;
			
			foreach ( $retval ['data'] as $list ) {
				if ($list ['id'] == $id) {
					$result = $list ['stats'] ['member_count'];
					break;
				}
			}
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	}
	
	public function update_vk() {
		$type = ESSBSocialFollowersCounterHelper::get_option ( 'vk_account_type' );
		
		if ($type == "community") {
			return $this->update_vk_community ();
		} else {
			return $this->update_vk_profile ();
		}
	}
	
	public function update_vk_community() {
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'vk_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		$result = 0;
		try {
			
			$data = $this->remote_update ( "http://api.vk.com/method/groups.getById?gid=$id&fields=members_count" );
			
			$result = ( int ) $data ['response'] [0] ['members_count'];
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	}
	
	public function update_vk_profile() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'vk_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		$request = @wp_remote_post ( 'https://api.vk.com/method/users.getFollowers', array ('body' => array ('count' => '0', 'user_id' => $id ) ) );
		
		if (false == $request)
			return 0;
		
		$response = json_decode ( @wp_remote_retrieve_body ( $request ), true );
		
		if (isset ( $response ['response'] ) && isset ( $response ['response'] ['count'] )) {
			return $response ['response'] ['count'];
		}
	}
	
	public function update_rss() {
		
		$account_type = ESSBSocialFollowersCounterHelper::get_option ( 'rss_account_type', 'manual' );
		$json_file = ESSBSocialFollowersCounterHelper::get_option ( 'rss_json_file' );
		$url = ESSBSocialFollowersCounterHelper::get_option ( 'rss_link' );
		$feedblitz = ESSBSocialFollowersCounterHelper::get_option ( 'rss_feedblitz' );
		
		if (($account_type == 'feedpress' && (empty ( $json_file ) || empty ( $url )))) {
			return 0;
		}
		
		if ($account_type == 'feedpress') {
			return $this->update_rss_feedpress ();
		}
		
		if ($account_type == 'manual') {
			if (! empty ( $feedblitz )) {
				return $this->update_rss_feedblitz ();
			} else {
				return $this->update_rss_manual ();
			}
		}
	}
	
	private function update_rss_feedpress() {
		
		$json_file = ESSBSocialFollowersCounterHelper::get_option ( 'rss_json_file' );
		
		try {
			$response = $this->remote_update ( $json_file );
			if (is_array ( $response ) && isset ( $response ['subscribers'] )) {
				return $response ['subscribers'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	private function update_rss_feedblitz() {
		$feedblitz = ESSBSocialFollowersCounterHelper::get_option ( 'rss_feedblitz' );
		
		$result = 0;
		try {
			$feedpress_url = esc_url ( $feedblitz );
			
			$request = wp_remote_retrieve_body ( wp_remote_get ( $feedpress_url, array ('timeout' => 18, 'sslverify' => false ) ) );
			
			$result = ( int ) $request;
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	}
	
	private function update_rss_manual() {
		return ESSBSocialFollowersCounterHelper::get_option ( 'rss_count' );
	}
	
	public function update_vine() {
		
		$email = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'vine_email' ) );
		$password = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'vine_password' ) );
		
		if (empty ( $email ) || empty ( $password )) {
			return 0;
		}
		
		if (! class_exists ( 'VineApp' )) {
			require_once ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/vine/Vine.php';
		}
		
		$v = new VineApp ( $email, $password );
		$user = $v->userinfo ();
		
		if (! $user) {
			return 0;
		}
		
		return $user ['data'] ['followerCount'];
	}
	
	public function update_tumblr() {
		
		$api_key = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'tumblr_api_key' ) );
		$api_secret = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'tumblr_api_secret' ) );
		$access_token = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'tumblr_access_token' ) );
		$access_token_secret = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'tumblr_access_token_secret' ) );
		
		$basename = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'tumblr_basename' ) );
		
		if (empty ( $api_key ) || empty ( $api_secret ) || empty ( $access_token ) || empty ( $access_token_secret ) || empty ( $basename )) {
			return 0;
		}
		
		if (! class_exists ( 'Tumblr' )) {
			require_once ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/Tumblr/Tumblr.php';
		}
		
		$tumblr = new Tumblr ( $api_key, $api_secret, $access_token, $access_token_secret );
		$response = $tumblr->followers ( $basename );
		
		if (! $response || ! is_object ( $response )) {
			return 0;
		}
		
		if (isset ( $response->response ) && isset ( $response->response->total_users )) {
			return $response->response->total_users;
		}
	}
	
	public function update_slideshare() {
		
		$username = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'slideshare_username' ) );
		
		if (empty ( $username )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'http://www.slideshare.net/' . $username . '/followers', false );
			
			if (! $response) {
				return 0;
			}
			
			@preg_match ( '/([0-9]+)( Followers| Follower)/s', $response, $matches );
			
			if (is_array ( $matches ) && isset ( $matches [1] )) {
				return $matches [1];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_c500Px() {
		
		$api_key = trim ( ESSBSocialFollowersCounterHelper::get_option ( '500px_api_key' ) );
		$api_secret = trim ( ESSBSocialFollowersCounterHelper::get_option ( '500px_api_secret' ) );
		$username = trim ( ESSBSocialFollowersCounterHelper::get_option ( '500px_username' ) );
		
		if (empty ( $api_key ) || empty ( $api_secret ) || empty ( $username )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'https://api.500px.com/v1/users/search?term=' . $username . '&consumer_key=' . $api_key );
			if (! is_array ( $response ) || ! isset ( $response ['total_items'] ) || $response ['total_items'] == 0) {
				return 0;
			}
			
			foreach ( $response ['users'] as $user ) {

				if ($user ['username'] == $username) {
					return $user ['followers_count'];
				}
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_flickr() {
		
		$api_key = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'flickr_api_key' ) );
		$username = trim ( ESSBSocialFollowersCounterHelper::get_option ( 'flickr_id' ) );
		
		if (empty ( $api_key ) || empty ( $username )) {
			return 0;
		}
		
		$result = 0;
		try {
			$data = $this->remote_update ( "https://api.flickr.com/services/rest/?method=flickr.groups.getInfo&api_key=$api_key&group_id=$username&format=json&nojsoncallback=1" );
			$result = ( int ) $data ['group'] ['members'] ['_content'];
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	}
	
	public function update_wpposts() {
		
		return wp_count_posts ()->publish;
	}
	
	public function update_wpcomments() {
		
		return wp_count_comments ()->approved;
	}
	
	public function update_wpusers() {
		$result = count_users ();
		return $result ['total_users'];
	}
	
	public function update_audioboo() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'audioboo_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'http://api.audioboo.fm/users/' . $id . '/followers' );
			if (isset ( $response ['body'] ) && isset ( $response ['body'] ['totals'] )) {
				return $response ['body'] ['totals'] ['count'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_steamcommunity() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'steamcommunity_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		try {
			
			$request = $this->remote_update ( 'http://steamcommunity.com/groups/' . $id, false );
			
			preg_match ( '/<span class="count ">([0-9]+)<\/span>/s', $request, $matches );
			
			if (is_array ( $matches ) && count ( $matches ) > 0) {
				return $matches [1];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_weheartit() {
		
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'weheartit_id' );
		
		if (empty ( $id )) {
			return 0;
		}
		
		try {
			$request = $this->remote_update ( 'http://weheartit.com/' . $id . '/fans', false );
			
			preg_match ( '/<h3>([0-9]+) (Follower|Followers)<\/h3>/s', $request, $matches );
			
			if (is_array ( $matches ) && count ( $matches ) > 0) {
				return $matches [1];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_feedly() {
		
		$url = ESSBSocialFollowersCounterHelper::get_option ( 'feedly_url' );
		
		if (empty ( $url )) {
			return 0;
		}
		
		try {
			$response = $this->remote_update ( 'http://cloud.feedly.com/v3/feeds/feed' . urlencode ( '/' . $url ) );
			if (is_array ( $response ) && isset ( $response ['subscribers'] )) {
				return $response ['subscribers'];
			}
		} catch ( Exception $e ) {
			return 0;
		}
	}
	
	public function update_twitch() {
		$id = ESSBSocialFollowersCounterHelper::get_option ( 'twitch_id' );
		$api = ESSBSocialFollowersCounterHelper::get_option ( 'twitch_api' );
		$result = 0;
		try {
			$data = $this->remote_update ( "https://api.twitch.tv/kraken/channels/$id?oauth_token=$api" );
			$result = isset ( $data ['followers'] ) ? ( int ) $data ['followers'] : 0;
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	}
	
	public function update_spotify() {
		$id = $url = ESSBSocialFollowersCounterHelper::get_option ( 'spotify_id' );
		$id = rtrim ( $id, "/" );
		$id = urlencode ( str_replace ( array ('https://play.spotify.com/', 'https://player.spotify.com/', 'artist/', 'user/' ), '', $id ) );
		
		$result = 0;
		try {
			if (! empty ( $url ) && strpos ( $url, 'artist' ) !== false) {
				$data = $this->remote_update ( "https://api.spotify.com/v1/artists/$id" );
			} else {
				$data = $this->remote_update ( "https://api.spotify.com/v1/users/$id" );
			}
			$result = ( int ) $data ['followers'] ['total'];
		
		} catch ( Exception $e ) {
			$result = 0;
		}
		
		return $result;
	}
	
	public function update_mymail() {
		$result = 0;
		
		$list = ESSBSocialFollowersCounterHelper::get_option ( 'mymail_id' );
		if (function_exists ( 'mailster' )) {
			if (! empty ( $list )) {
				if ($list == 'all') {
					$counts = mailster ( 'subscribers' )->get_count_by_status ();
					$result = $counts [1];
				} else {
					$result = mailster ( 'lists' )->get_member_count ( $list, 1 );
				}
			}
		}
		return $result;
	}
	
	public function update_mailpoet() {
		
		$result = 0;
		
		$list = ESSBSocialFollowersCounterHelper::get_option ( 'mailpoet_id' );
		
		if (! empty ( $list )) {
			if ($list == 'all') {
				$result = ESSBSocialFollowersCounterHelper::mailpoet_total_subscribers ();
			} else {
				$result = ESSBSocialFollowersCounterHelper::mailpoet_get_list_users ( $list );
			}
		}
		
		return $result;
	}
}
