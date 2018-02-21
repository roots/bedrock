<?php
/**
 * Short URL generation functions
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2017 AppsCreo
 * @since 1.0
 *
 */


/**
 * Rebradn.ly Short URL Integration
 * 
 * @param string $url
 * @param mixed $post_id
 * @param boolean $deactivate_cache
 * @param string $api_key
 * @return string
 * @since 4.3
 * 
 */

function essb_short_rebrandly($url, $post_id = '', $deactivate_cache = false, $api_key = '') {
	if (!empty($post_id) && !$deactivate_cache) {
		$exist_shorturl = get_post_meta($post_id, 'essb_shorturl_rebrand', true);
			
		if (!empty($exist_shorturl)) {
			return $exist_shorturl;
		}
	}
	
	$domain_id = essb_option_value('shorturl_rebrandpi_domain');

	//$encoded_url = urlencode($url);
	$encoded_url = $url;
	
	if ($domain_id != '') {
		$result = wp_remote_post ( 'https://api.rebrandly.com/v1/links', 
				array ('body' => json_encode ( array ('destination' => esc_url_raw ( $encoded_url ), 'domain' => array('id' => $domain_id) ) ), 
					   'headers' => array ('Content-Type' => 'application/json', 'apikey' => $api_key ) ) );
	}
	else {
		$result = wp_remote_post ( 'https://api.rebrandly.com/v1/links',
				array ('body' => json_encode ( array ('destination' => esc_url_raw ( $encoded_url ) ) ),
						'headers' => array ('Content-Type' => 'application/json', 'apikey' => $api_key ) ) );
		
	}

	// Return the URL if the request got an error.
	if (is_wp_error ( $result ))
		return $url;

	$result = json_decode ( $result ['body'] );
	$shortlink = isset($result->shortUrl) ? $result->shortUrl : '';

	if ($shortlink != '') {
		$shortlink = 'http://'.$shortlink;
		
		if ($post_id != '') {
			update_post_meta ( $post_id, 'essb_shorturl_rebrand', $shortlink );

		}

		return $shortlink;
	}

	return $url;
}

function essb_short_post($url, $post_id = '', $deactivate_cache = false, $api_key = '') {
	if (!empty($post_id) && !$deactivate_cache) {
		$exist_shorturl = get_post_meta($post_id, 'essb_shorturl_post', true);
			
		if (!empty($exist_shorturl)) {
			return $exist_shorturl;
		}
	}

	//$encoded_url = urlencode($url);
	$encoded_url = $url;
	
	$result = wp_remote_get('http://po.st/api/shorten?longUrl='.esc_url_raw ( $encoded_url ).'&apiKey='.$api_key);
	
	// Return the URL if the request got an error.
	if (is_wp_error ( $result ))
		return $url;

	$result = json_decode ( $result ['body'] );
	$shortlink = isset($result->short_url) ? $result->short_url : '';

	if ($shortlink != '') {
		if ($post_id != '') {
			update_post_meta ( $post_id, 'essb_shorturl_post', $shortlink );

		}

		return $shortlink;
	}

	return $url;
}


function essb_short_googl($url, $post_id = '', $deactivate_cache = false, $api_key = '') {
	if (!empty($post_id) && !$deactivate_cache) {
		$exist_shorturl = get_post_meta($post_id, 'essb_shorturl_googl', true);
			
		if (!empty($exist_shorturl)) {
			return $exist_shorturl;
		}
	}

	//$encoded_url = urlencode($url);
	$encoded_url = $url;
	if (!empty($api_key)) {
		$result = wp_remote_post ( 'https://www.googleapis.com/urlshortener/v1/url?key='.($api_key), array ('body' => json_encode ( array ('longUrl' => esc_url_raw ( $encoded_url ) ) ), 'headers' => array ('Content-Type' => 'application/json' ) ) );
	}
	else {
		$result = wp_remote_post ( 'https://www.googleapis.com/urlshortener/v1/url', array ('body' => json_encode ( array ('longUrl' => esc_url_raw ( $encoded_url ) ) ), 'headers' => array ('Content-Type' => 'application/json' ) ) );
	}
	
	// Return the URL if the request got an error.
	if (is_wp_error ( $result ))
		return $url;

	$result = json_decode ( $result ['body'] );
	$shortlink = $result->id;
	if ($shortlink) {
		if ($post_id != '') {
			update_post_meta ( $post_id, 'essb_shorturl_googl', $shortlink );

		}

		return $shortlink;
	}

	return $url;
}

function essb_short_bitly($url, $user = '', $api = '', $post_id = '', $deactivate_cache = false, $bitly_api_version = '') {

	if (!empty($post_id) && !$deactivate_cache) {
		$exist_shorturl = get_post_meta($post_id, 'essb_shorturl_bitly', true);

		if (!empty($exist_shorturl)) {
			return $exist_shorturl;
		}
	}

	//$encoded_url = urlencode($url);
	$encoded_url = ($url);

	if ($bitly_api_version == 'new') {
		$params = http_build_query(
				array(
						'access_token' => $api,
						'uri' => ($encoded_url),
						'format' => 'json',
				)
		);

	}
	else {
		$params = http_build_query(
				array(
						'login' => $user,
						'apiKey' => $api,
						'longUrl' => $encoded_url,
						'format' => 'json',
				)
		);
	}

	/*if ($jmp == 'true') {
	 $params['domain'] = "j.mp";
	}*/
		
	$result = $url;

	$rest_url = 'https://api-ssl.bitly.com/v3/shorten?' . $params;
		
	$response = wp_remote_get( $rest_url );
	// if we get a valid response, save the url as meta data for this post
	if( !is_wp_error( $response ) ) {

		$json = json_decode( wp_remote_retrieve_body( $response ) );
		//print_r($json);
		if( isset( $json->data->url ) ) {

			$result = $json->data->url;
			update_post_meta ( $post_id, 'essb_shorturl_bitly', $result );
		}
	}

	return $result;
}

function essb_short_ssu($url, $post_id, $deactivate_cache = false) {
	$result = $url;

	if (!empty($post_id) && !$deactivate_cache) {
		$exist_shorturl = get_post_meta($post_id, 'essb_shorturl_ssu', true);

		if (!empty($exist_shorturl)) {
			return $exist_shorturl;
		}
	}

	if (defined('ESSB3_SSU_VERSION')) {
		if (class_exists('ESSBSelfShortUrlHelper')) {
			$short_url = ESSBSelfShortUrlHelper::get_external_short_url ( $url );

			if (!empty($short_url)) {
				$result = ESSBSelfShortUrlHelper::get_base_path () . $short_url;
				update_post_meta ( $post_id, 'essb_shorturl_ssu', $result );
			}
		}
	}

	return $result;
}

function essb_short_url($url, $provider, $post_id = '', $bitly_user = '', $bitly_api = '') {

	$deactivate_cache = essb_options_bool_value('deactivate_shorturl_cache');
	$shorturl_googlapi = essb_options_value('shorturl_googlapi');

	$bitly_api_version = essb_options_value('shorturl_bitlyapi_version');
	
	$rebrandly_api_key = essb_option_value('shorturl_rebrandpi');
	$post_api_key = essb_option_value('shorturl_postapi');

	$short_url = '';
	
	// TODO: test this change
	//if (is_preview()) {
	//	return $url;
	//}

	if ($provider == 'ssu') {
		if (!defined('ESSB3_SSU_VERSION')) {
			$provider = 'wp';
		}
	}
	
	switch ($provider) {
		case 'wp' :
			$short_url = wp_get_shortlink($post_id);

			$url_parts = parse_url($url);
			if (isset($url_parts['query'])) {
				$short_url = essb_attach_tracking_code($short_url, $url_parts['query']);
			}

			break;
		case 'goo.gl' :
			$short_url = essb_short_googl($url, $post_id, $deactivate_cache, $shorturl_googlapi);
			break;
		case 'bit.ly' :
			$short_url = essb_short_bitly($url, $bitly_user, $bitly_api, $post_id, $deactivate_cache, $bitly_api_version);
			break;
		case 'rebrand.ly':
			$short_url = essb_short_rebrandly($url, $post_id, $deactivate_cache, $rebrandly_api_key);
			break;
		case 'po.st':
			$short_url = essb_short_post($url, $post_id, $deactivate_cache, $post_api_key);
			break;
		case 'ssu':
			$short_url = essb_short_ssu($url, $post_id, $deactivate_cache);
			break;
	}

	// @since 3.4 affiliate intergration with wp shorturl
	$affwp_active = essb_options_bool_value('affwp_active');
	if ($affwp_active) {
		essb_depend_load_function('essb_generate_affiliatewp_referral_link', 'lib/core/integrations/affiliatewp.php');
		$short_url = essb_generate_affiliatewp_referral_link($short_url);
	}

	$affs_active = essb_options_bool_value('affs_active');
	if ($affs_active) {
		$short_url = do_shortcode('[affiliates_url]'.$short_url.'[/affiliates_url]');
	}

	return $short_url;
}

function essb_apply_shorturl($post_share_details, $only_recommended, $url, $provider, $post_id = '', $bitly_user = '', $bitly_api = '') {
	// generating short urls only for selected networks
	if ($only_recommended) {
		$generated_shorturl = essb_short_url ( $post_share_details ['url'], $provider, get_the_ID (), essb_option_value('shorturl_bitlyuser'), essb_option_value('shorturl_bitlyapi') );
		$post_share_details ['short_url_twitter'] = $generated_shorturl;
		$post_share_details ['short_url_whatsapp'] = $generated_shorturl;
	}
	else {
		// generate short url for all networks
		$post_share_details ['short_url'] = essb_short_url( $post_share_details ['url'], $provider, get_the_ID (), essb_option_value('shorturl_bitlyuser'), essb_option_value('shorturl_bitlyapi') );
	
		$post_share_details ['short_url_twitter'] = $post_share_details ['short_url'];
		$post_share_details ['short_url_whatsapp'] = $post_share_details ['short_url'];
	}
		
	if (empty($post_share_details['short_url'])) {
		$post_share_details['short_url'] = $post_share_details ['url'];
	}
	if (empty($post_share_details['short_url_twitter'])) {
		$post_share_details['short_url_twitter'] = $post_share_details ['url'];
	}
	if (empty($post_share_details['short_url_whatsapp'])) {
		$post_share_details['short_url_whatsapp'] = $post_share_details ['url'];
	}
	
	return $post_share_details;
}