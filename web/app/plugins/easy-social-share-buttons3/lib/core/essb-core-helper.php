<?php

function essb_post_details_to_content($content) {
	global $post;

	if (isset($post)) {
		$url = get_permalink();
		$title_plain = $post->post_title;
		$post_image = has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';
		$image = ($post_image != '') ? $post_image[0] : '';
		$description = $post->post_excerpt;
			
		$content = preg_replace(array('#%%title%%#', '#%%url%%#', '#%%image%%#', '#%%excerpt%%#'), array($title_plain, $url, $image, $description), $content);

	}

	return $content;
}

function essb_template_folder ($template_id) {
	$folder = 'default';

	if ($template_id == 1) {
		$folder = 'default';
	}
	if ($template_id == 2) {
		$folder = 'metro';
	}
	if ($template_id == 3) {
		$folder = 'modern';
	}
	if ($template_id == 4) {
		$folder = 'round';
	}
	if ($template_id == 5) {
		$folder = 'big';
	}
	if ($template_id == 6) {
		$folder = 'metro-retina';
	}
	if ($template_id == 7) {
		$folder = 'big-retina';
	}
	if ($template_id == 8) {
		$folder = 'light-retina';
	}
	if ($template_id == 9) {
		$folder = 'flat-retina';
	}
	if ($template_id == 10) {
		$folder = 'tiny-retina';
	}
	if ($template_id == 11) {
		$folder = 'round-retina';
	}
	if ($template_id == 12) {
		$folder = 'modern-retina';
	}
	if ($template_id == 13) {
		$folder = 'circles-retina';
	}
	if ($template_id == 14) {
		$folder = 'circles-retina essb_template_blocks-retina';
	}
	if ($template_id == 15) {
		$folder = 'dark-retina';
	}
	if ($template_id == 16) {
		$folder = 'grey-circles-retina';
	}
	if ($template_id == 17) {
		$folder = 'grey-blocks-retina';
	}
	if ($template_id == 18) {
		$folder = 'clear-retina';
	}
	if ($template_id == 19) {
		$folder = 'copy-retina';
	}
	if ($template_id == 20) {
		$folder = 'dimmed-retina';
	}
	if ($template_id == 21) {
		$folder = 'grey-retina';
	}
	if ($template_id == 22) {
		$folder = 'default-retina';
	}
	if ($template_id == 23) {
		$folder = 'jumbo-retina';
	}
	if ($template_id == 24) {
		$folder = 'jumbo-round-retina essb_template_jumbo-retina';
	}
	if ($template_id == 25) {
		$folder = 'fancy-retina';
	}
	if ($template_id == 26) {
		$folder = 'deluxe-retina';
	}
	if ($template_id == 27) {
		$folder = 'modern-retina essb_template_modern-slim-retina';
	}
	if ($template_id == 28) {
		$folder = 'bold-retina';
	}
	if ($template_id == 29) {
		$folder = 'fancy-bold-retina';
	}
	if ($template_id == 30) {
		$folder = 'retro-retina';
	}
	if ($template_id == 31) {
		$folder = 'metro-bold-retina';
	}

	if ($template_id == 32) {
		$folder = 'default4-retina';
	}
	if ($template_id == 33) {
		$folder = 'clear-retina essb_template_clear-rounded-retina';
	}
	if ($template_id == 34) {
		$folder = 'grey-fill-retina';
	}
	if ($template_id == 35) {
		$folder = 'white-fill-retina';
	}
	if ($template_id == 36) {
		$folder = 'white-retina';
	}
	if ($template_id == 37) {
		$folder = 'grey-round-retina';
	}
	if ($template_id == 38) {
		$folder = 'color-leafs';
	}
	if ($template_id == 39) {
		$folder = 'grey-leafs';
	}
	if ($template_id == 40) {
		$folder = 'circles-retina essb_tempate_color-circles-outline-retina';
	}
	if ($template_id == 41) {
		$folder = 'circles-retina essb_template_blocks-retina essb_tempate_color-blocks-outline-retina';
	}
	if ($template_id == 42) {
		$folder = 'grey-circles-outline-retina';
	}
	if ($template_id == 43) {
		$folder = 'grey-circles-outline-retina essb_template_grey-blocks-outline-retina';
	}
	if ($template_id == 44) {
		$folder = 'dark-outline-retina';
	}
	if ($template_id == 45) {
		$folder = 'dark-outline-retina essb_template_dark-round-outline-retina';
	}
	if ($template_id == 46) {
		$folder = 'light-retina essb_template_classic-retina';
	}
	if ($template_id == 47) {
		$folder = 'light-retina essb_template_classic-retina essb_template_classic-round-retina';
	}
	if ($template_id == 48) {
		$folder = 'modern-retina essb_template_classic-fancy-retina';
	}
	
	if ($template_id == 49) {
		$folder = 'default4-retina essb_template_color-circles-retina';
	}
	if ($template_id == 50) {
		$folder = 'default4-retina essb_template_massive-retina';
	}
	
	if ($template_id == 51) {
		$folder = 'round-retina essb_template_cutoff-retina';
	}

	if ($template_id == 52) {
		$folder = 'metro-bold-retina essb_template_cutoff-fill-retina';
	}
	
	
	if ($template_id == 53) {
		$folder = 'round-retina essb_template_modern-light-retina';
	}
	
	if ($template_id == 54) {
		$folder = 'default4-retina essb_template_tiny-color-circles-retina';
	}
	
	if ($template_id == 55) {
		$folder = 'clear-retina essb_template_lollipop-retina';
	}

	if ($template_id == 56) {
		$folder = 'rainbow-retina';
	}

	if ($template_id == 57) {
		$folder = 'round-retina essb_template_modern-light-retina essb_template_flow-retina';
	}

	if ($template_id == 58) {
		$folder = 'round-retina essb_template_modern-light-retina essb_template_flow-retina essb_template_flow-jump-retina';
	}
	
	if ($template_id == 59) {
		$folder = 'default4-retina essb_template_glow-retina';
	}
	
	if (has_filter('essb4_templates_class')) {
		$folder = apply_filters('essb4_templates_class', $folder, $template_id);
	}

	// fix when using template_slug instead of template_id
	if (intval($template_id) == 0 && $template_id != '') {
		$folder = $template_id;
	}


	return $folder;
}

function essb_core_helper_get_excerpt_by_id($post_id) {
	$the_post = get_post ( $post_id ); // Gets post ID
	$the_excerpt = $the_post->post_content; // Gets post_content to be used as
	// a basis for the excerpt
	$excerpt_length = 35; // Sets excerpt length by word count
	$the_excerpt = strip_tags ( strip_shortcodes ( $the_excerpt ) ); // Strips tags
	// and images
	$words = explode ( ' ', $the_excerpt, $excerpt_length + 1 );
	if (count ( $words ) > $excerpt_length) :
	array_pop ( $words );
	array_push ( $words, '…' );
	$the_excerpt = implode ( ' ', $words );

	endif;
	$the_excerpt = '<p>' . $the_excerpt . '</p>';
	return $the_excerpt;
}

function essb_core_get_post_featured_image($post_id) {
	$post_cached_image = get_post_meta($post_id, 'essb_cached_image', true);

	if (empty($post_cached_image)) {
		$post_image = has_post_thumbnail( $post_id ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' ) : '';
		$post_cached_image = ($post_image != '') ? $post_image[0] : '';

		if (!empty($post_cached_image)) {
			update_post_meta ( $post_id, 'essb_cached_image', $post_cached_image );
		}
	}

	return $post_cached_image;
}

/***
 * Create post excerpt using content or build in exceprt
 */
function essb_core_get_post_excerpt($post_id) {
	// Check if the post has an excerpt
	if ( has_excerpt($post_id) ) {
		$the_post = get_post( $post_id ); // Gets post ID
		$the_excerpt = $the_post->post_excerpt;
	}
	else {
		$the_post = get_post( $post_id ); // Gets post ID
		$the_excerpt = $the_post->post_content; // Gets post_content to be used as a basis for the excerpt
	}
	
	$excerpt_length = 100; 
	$the_excerpt = strip_tags( strip_shortcodes( $the_excerpt ) ); 

	$the_excerpt = str_replace( ']]>', ']]&gt;', $the_excerpt );
	$the_excerpt = strip_tags( $the_excerpt );
	$excerpt_length = apply_filters( 'excerpt_length', 100 );
	$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
	$words = preg_split( "/[\n\r\t ]+/", $the_excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
	
	if ( count( $words ) > $excerpt_length ) {
		array_pop( $words );
		$the_excerpt = implode( ' ', $words );
	}
	
	$the_excerpt = preg_replace( "/\r|\n/", '', $the_excerpt );
	
	return $the_excerpt;
	
}

function essb_core_convert_smart_quotes( $content ) {
	$content = str_replace( '"', '\'', $content );
	$content = str_replace( '&#8220;', '\'', $content );
	$content = str_replace( '&#8221;', '\'', $content );
	$content = str_replace( '&#8216;', '\'', $content );
	$content = str_replace( '&#8217;', '\'', $content );
	
	return $content;
}

function essb_core_helper_generate_list_networks($all_networks = false) {
	global $essb_networks, $essb_options;
	$networks = array();

	$listOfNetworks = ($all_networks) ? essb_core_helper_generate_network_list() : essb_options_value( 'networks');
	if (!is_array($listOfNetworks)) {
		$listOfNetworks = essb_core_helper_generate_network_list();
	}

	foreach ($listOfNetworks as $single) {
		if ($single != 'more' && $single != 'share') {
			$networks[] = $single;
		}
	}

	return $networks;
}

function essb_core_helper_generate_list_networks_with_more($all_networks = false) {
	global $essb_networks, $essb_options;
	$networks = array();

	$listOfNetworks = ($all_networks) ? essb_core_helper_generate_network_list() : essb_options_value( 'networks');

	foreach ($listOfNetworks as $single) {
		
		$networks[] = $single;
		
	}

	return $networks;
}

function essb_core_helper_networks_without_more($networks) {
	$more_appear = false;
	$new_list = array();

	foreach ($networks as $network) {

		if ($network != 'more' && $network != 'share') {
			$new_list[] = $network;
		}
	}

	return $new_list;
}

function essb_core_helper_networks_after_more($networks) {
	$more_appear = false;
	$new_list = array();
	
	foreach ($networks as $network) {
		
		if ($more_appear) {
			$new_list[] = $network;
		}
		
		if ($network == 'more' || $network == 'share') {
			$more_appear = true;
		}
	}
	
	return $new_list;
}

function essb_core_helper_generate_network_list() {
	global $essb_networks;
		
	$network_order = array();
		
	foreach ($essb_networks as $key => $data) {
		$network_order[] = $key;
	}
		
	return $network_order;
}

function essb_core_helper_urlencode($str) {
	$str = str_replace(' ', '%20', $str);
	$str = str_replace("'", '%27', $str);
	$str = str_replace("\"", '%22', $str);
	$str = str_replace('#', '%23', $str);
	$str = str_replace('+', '%2B', $str);
	$str = str_replace('$', '%24', $str);
	$str = str_replace('&', '%26', $str);
	$str = str_replace(',', '%2C', $str);
	$str = str_replace('/', '%2F', $str);
	$str = str_replace(':', '%3A', $str);
	$str = str_replace(';', '%3B', $str);
	$str = str_replace('=', '%3D', $str);
	$str = str_replace('?', '%3F', $str);
	$str = str_replace('@', '%40', $str);
	$str = str_replace('\%27', '%27', $str);

	return $str;
}

/**
 * get_post_share_details
 *
 * Generate post sharing details
 *
 * @param string $position
 * @return array
 */
function essb_get_post_share_details($position) {
	global $post;

	//timer_start();
	
	if (essb_option_bool_value('reset_postdata')) {
		wp_reset_postdata();
	}

	if (essb_option_bool_value( 'force_wp_query_postid')) {
		$current_query_id = get_queried_object_id();
		$post = get_post($current_query_id);
			
	}

	$url = '';
	$title = '';
	$image = '';
	$description = '';
	$title_plain = '';

	$twitter_user = essb_option_value('twitteruser');
	$twitter_hashtags = essb_option_value('twitterhashtags');
	$twitter_customtweet = '';


	$url = $post ? get_permalink() : essb_get_current_url( 'raw' );

	if (essb_option_bool_value( 'avoid_nextpage')) {
		$url = $post ? get_permalink(get_the_ID()) : essb_get_current_url( 'raw' );
	}

	if (essb_option_bool_value('force_wp_fullurl')) {
		$url = essb_get_current_page_url();		
	}

	if (essb_option_bool_value('always_use_http')) {
		$url = str_replace('https://', 'http://', $url);
	}

	if (!defined('ESSB3_LIGHTMODE')) {
		$mycred_referral_activate = essb_option_bool_value('mycred_referral_activate');
		if ($mycred_referral_activate && function_exists('mycred_render_affiliate_link')) {
			$url = mycred_render_affiliate_link( array( 'url' => $url ) );
		}
	}


	if (isset($post)) {
		$title = esc_attr(urlencode($post->post_title));
		$title_plain = $post->post_title;
		$image = essb_core_get_post_featured_image($post->ID);
		$description = $post->post_excerpt;
			
		if ($position == 'heroshare') {
			if ($description == '') {
				$description = essb_core_get_post_excerpt($post->ID);			}
		}
	}

	$list_of_articles_mode = false;
	if (essb_option_bool_value( 'force_archive_pages')) {
		if (is_archive() || is_front_page() || is_search() || is_tag() || is_post_type_archive()) {
			if ($position == 'sidebar' || $position == 'flyin' || $position == 'popup' || 
					$position == 'topbar' || $position == 'bottombar' || $position == 'sharebottom') {
				$list_of_articles_mode = true;
				$url = essb_get_current_page_url();
					
				if (is_front_page()) {
					$title = get_bloginfo('name');
					$title_plain = $title;
					$description = get_bloginfo('description');
				}
				else {
					$title = get_the_archive_title();
					$title_plain = $title;
					$description = get_the_archive_description();
				}
			}
		}
	}

	// apply custom share options
	if (essb_option_bool_value('customshare')) {
		if (essb_option_value('customshare_text') != '') {
			$title = essb_option_value('customshare_text');
			$title_plain = $title;
		}
		if (essb_option_value('customshare_url') != '') {
			$url = essb_option_value('customshare_url');
		}
		if (essb_option_value('customshare_image') != '') {
			$image = essb_option_value('customshare_image');
		}
		if (essb_option_value('customshare_description') != '') {
			$description = essb_option_value('customshare_description');
		}
	}

	$twitter_customtweet = $title;
	$post_pin_image = '';
	// apply post custom share options
	if (isset($post) && !$list_of_articles_mode) {
			
		if (essb_option_bool_value('twitter_message_tags_to_hashtags')) {
			$twitter_hashtags = essb_get_post_tags_as_list($post);			
		}
			
		$post_essb_post_share_message = get_post_meta($post->ID, 'essb_post_share_message', true);
		$post_essb_post_share_url = get_post_meta($post->ID, 'essb_post_share_url', true);
		$post_essb_post_share_image = get_post_meta($post->ID, 'essb_post_share_image', true);
		$post_essb_post_share_text = get_post_meta($post->ID, 'essb_post_share_text', true);

		$post_pin_image = get_post_meta($post->ID, 'essb_post_pin_image', true);
			
		$post_essb_twitter_username = get_post_meta($post->ID, 'essb_post_twitter_username', true);
		$post_essb_twitter_hastags = get_post_meta($post->ID, 'essb_post_twitter_hashtags', true);
		$post_essb_twitter_tweet = get_post_meta($post->ID, 'essb_post_twitter_tweet', true);
			
		if (defined('WPSEO_VERSION')) {	
			
			$yoast_title = get_post_meta( $post->ID, '_yoast_wpseo_title', true);
			$yoast_description = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true);
			
			if ($yoast_title != '') {
				// include WPSEO replace vars
				if (strpos($yoast_title, '%%') !== false && function_exists('wpseo_replace_vars')) {
					$yoast_title = wpseo_replace_vars($yoast_title, $post);
				}
				
				$title = $yoast_title;
				$title_plain = $yoast_title;
				$twitter_customtweet = $yoast_title;
			}
			if ($yoast_description != '') {
				$description = $yoast_description;
			}
		}
		
		if ($post_essb_post_share_image != '') {
			$image = $post_essb_post_share_image;
		}
		if ($post_essb_post_share_message != '') {
			$description = $post_essb_post_share_message;
		}
		if ($post_essb_post_share_text != '') {
			$title = $post_essb_post_share_text;
			$title_plain = $post_essb_post_share_text;
		}
		if ($post_essb_post_share_url != '') {
			$url = $post_essb_post_share_url;
		}
			
		if ($post_essb_twitter_hastags != '') {
			$twitter_hashtags = $post_essb_twitter_hastags;
		}
		if ($post_essb_twitter_tweet != '') {
			$twitter_customtweet = $post_essb_twitter_tweet;
		}
		if ($post_essb_twitter_username != '') {
			$twitter_user = $post_essb_twitter_username;
		}
	}

	// inetegration with affiliate plugins is not availalbe as option in easy mode
	if (!defined('ESSB3_LIGHTMODE')) {
		$affwp_active = essb_option_bool_value('affwp_active');
		if ($affwp_active) {
			essb_depend_load_function('essb_generate_affiliatewp_referral_link', 'lib/core/integrations/affiliatewp.php');
			$url = essb_generate_affiliatewp_referral_link($url);
		}
			
		$affs_active = essb_option_bool_value('affs_active');
		if ($affs_active) {
			$url = do_shortcode('[affiliates_url]'.$url.'[/affiliates_url]');
		}
	}


	$title= str_replace("'", "\'", $title);
	$description= str_replace("'", "\'", $description);
	$twitter_customtweet= str_replace("'", "\'", $twitter_customtweet);
	$title_plain= str_replace("'", "\'", $title_plain);

	
	//print "get share details".timer_stop(0, 5);
	
	return array('url' => $url, 'title' => $title, 'image' => $image, 'description' => $description, 'twitter_user' => $twitter_user,
			'twitter_hashtags' => $twitter_hashtags, 'twitter_tweet' => $twitter_customtweet, 'post_id' => isset($post) ? $post->ID : 0, 'user_image_url' => '', 'title_plain' => $title_plain,
			'short_url_whatsapp' => '', 'short_url_twitter' => '', 'short_url' => '', 'pinterest_image' => $post_pin_image);
}

function essb_get_post_tags_as_list($post) {
	$twitter_hashtags = '';
	
	$post_tags = wp_get_post_tags($post->ID);
	if ($post_tags) {
		$generated_tags = array();
		foreach($post_tags as $tag) {
			$current_tag = $tag->name;
			$current_tag = str_replace(' ', '', $current_tag);
			$generated_tags[] = $current_tag;
		}
			
		if (count($generated_tags) > 0) {
			$twitter_hashtags = implode(',', $generated_tags);
		}
	}
	
	return $twitter_hashtags;
}

function essb_get_native_button_settings($position = '', $only_share = false) {
	$are_active = true;

	if ($only_share) {
		$are_active = false;
		return array('active' => false);
	}

	if (!defined('ESSB3_NATIVE_ACTIVE')) {
		$are_active = false;
	}
	else {
		if (!ESSB3_NATIVE_ACTIVE) {
			$are_active = false;
		}
	}
		
	if (defined('ESSB3_NATIVE_DEACTIVE')) {
		$are_active = false;
	}

	if (essb_is_mobile()) {
		if (!essb_option_bool_value('allow_native_mobile')) {
			$are_active = false;
		}
	}

	if (!empty($position)) {
		if (essb_option_bool_value( $position.'_native_deactivate')) {
			$are_active = false;
		}
	}

	if (essb_is_module_deactivated_on('native')) {
		$are_active = false;
	}

	if (!$are_active) {
		return array('active' => false);
	}

	$native_options = ESSBNativeButtonsHelper::native_button_defaults();
	$native_options['active'] = $are_active;
	$native_options['message_like_buttons'] = '';

	$deactivate_message_for_location = essb_option_bool_value( $position.'_text_deactivate');
	if (!$deactivate_message_for_location) {
		$native_options['message_like_buttons'] = essb_option_value('message_like_buttons');
	}

	return $native_options;
}