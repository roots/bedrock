<?php
function essb_buttonhelper_encode_url_sharing($share) {
	$share['short_url_twitter'] = urlencode($share['short_url_twitter']);
	$share['full_url'] = urlencode($share['full_url']);
	$share ['url'] = urlencode($share['url']);
	$share['full_url'] = str_replace('&', '&amp;', $share['full_url'] );
	$share['url'] = str_replace('&', '&amp;', $share['url'] );
	
	return $share;
}

function essb_buttonhelper_encode_text($share) {
	$share['twitter_tweet'] = str_replace("+", " ", $share['twitter_tweet']);
	$share ['title'] = urlencode($share['title']);
	$share ['twitter_tweet'] = urlencode($share['twitter_tweet']);
	$share ['description'] = urlencode($share['description']);
	$share['twitter_tweet'] = str_replace(" ", "%20", $share['twitter_tweet']);
	$share['twitter_tweet'] = str_replace("+", "%20", $share['twitter_tweet']);
	
	$share['twitter_tweet'] = str_replace('&', '&amp;', $share['twitter_tweet'] );
	$share['title'] = str_replace('&', '&amp;', $share['title'] );
	$share['description'] = str_replace('&', '&amp;', $share['description'] );
	
	return $share;
}

function essb_correct_url_on_tracking_code($share, $network) {
	
	if ($share['full_url'] != 'http://socialsharingplugin.com' && $share['full_url'] != '') {
		
		$utm_title = $share['title'];
		$utm_title = str_replace(' ', '_', $utm_title);
		$utm_title = str_replace('+', '_', $utm_title);
	
		$share['url'] = str_replace('{network}', $network, $share['url']);
		$share['full_url'] = str_replace('{network}', $network, $share['full_url']);
	
		$share['url'] = str_replace('{title}', $utm_title, $share['url']);
		$share['full_url'] = str_replace('{title}', $utm_title, $share['full_url']);
		$share['clear_twitter_url'] = false;
	
		
		// rebuild shorturls if GA tracking is active
		// code refactor @since 3.4.2
	
		if (essb_option_bool_value('shorturl_activate' )) {
			$global_provider = essb_options_value( 'shorturl_type' );
			if (essb_option_bool_value('twitter_shareshort' )) {
				essb_depend_load_function('essb_short_url', 'lib/core/essb-shorturl-helper.php');
				$global_shorturl = essb_short_url ( $share ['full_url'], $global_provider, get_the_ID (), essb_options_value( 'shorturl_bitlyuser' ), essb_options_value( 'shorturl_bitlyapi' ) );
	
				$share ['short_url_twitter'] = $global_shorturl;
				$share ['short_url_whatsapp'] = $global_shorturl;
			}
			else {
				essb_depend_load_function('essb_short_url', 'lib/core/essb-shorturl-helper.php');
				$share ['short_url'] = essb_short_url ( $share ['full_url'], $global_provider, get_the_ID (), essb_options_value( 'shorturl_bitlyuser' ), essb_options_value('shorturl_bitlyapi' ) );
	
				$share ['short_url_twitter'] = $share ['short_url'];
				$share ['short_url_whatsapp'] = $share ['short_url'];
			}
	
			if ($share ['short_url_twitter'] == '') {
				$share ['short_url_twitter'] = $share ['url'];
			}
			if ($share ['short_url_whatsapp'] == '') {
				$share ['short_url_whatsapp'] = $share ['url'];
			}
			if ($share ['short_url'] == '') {
				$share ['short_url'] = $share ['url'];
			}
		}
		else {

			$share ['twitter_tweet'] .= '%20' . $share ['url'];
			$share ['short_url_twitter'] = esc_attr ( $share ['url'] );
			$share ['short_url_whatsapp'] = esc_attr ( $share ['url'] );
			$share['clear_twitter_url'] = true;
		}
	
	}
	return $share;
}