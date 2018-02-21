<?php
/**
 * Share counter recovery functions
 * 
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.2
 *
 */

function essb_recovery_is_matching_recovery_date($post_id, $recover_till_date) {
	$is_matching = true;
	
	$post_publish_date = get_the_date ( "Y-m-d", $post_id );
	
	if (! empty ( $post_publish_date )) {
		$recover_till_time = strtotime ( $recover_till_date );
		$post_publish_time = strtotime ( $post_publish_date );
		
		if ($post_publish_time < $recover_till_time) {
			$is_matching = true;
		} else {
			$is_matching = false;
		}
	}
	
	return $is_matching;
}

/**
 * Generate alternative post permalink upon recovery
 * 
 * @param string $past_url
 * @param id $post_id
 * @return string
 * 
 * @since 5.0
 */
function essb_recovery_get_alt_permalink($past_url, $post_id) {
	$rewritecode = array ('%year%', '%monthnum%', '%day%', '%hour%', '%minute%', '%second%', '%postname%', '%post_id%', '%category%', '%author%', '%pagename%' );
	
	$post = get_post ( $post_id );
	$leavename = false;
	
	$structure = essb_option_value ( 'counter_recover_mode' );
	$permalink = '';
	
	if ($structure == 'custom') {
		$permalink = essb_option_value ( 'counter_recover_custom' );
	} else if ($structure == 'unchanged') {
		$permalink = get_option ( 'permalink_structure' );
	} else if ($structure == 'default') {
		$permalink = '';
	} else if ($structure == 'day_and_name') {
		$permalink = '/%year%/%monthnum%/%day%/%postname%/';
	} else if ($structure == 'month_and_name') {
		$permalink = '/%year%/%monthnum%/%postname%/';
	} else if ($structure == 'numeric') {
		$permalink = '/archives/%post_id%';
	} else if ($structure == 'post_name') {
		$permalink = '/%postname%/';
	} else {
		$permalink = get_option ( 'permalink_structure' );
	}
	
	$permalink = apply_filters ( 'pre_post_link', $permalink, $post, $leavename );
	
	// Check if the user has defined a specific custom URL
	$custom_url = get_post_meta ( get_the_ID (), 'essb_activate_sharerecovery', true );
	if ($custom_url) {
		return $custom_url;
	} 
	else {
		
		if ('' != $permalink && ! in_array ( $post->post_status, array ('draft', 'pending', 'auto-draft', 'future' ) )) {
			$unixtime = strtotime ( $post->post_date );
			
			$category = '';
			if (strpos ( $permalink, '%category%' ) !== false) {
				$cats = get_the_category ( $post->ID );
				if ($cats) {
					usort ( $cats, '_usort_terms_by_ID' ); // order by ID
					
					$category_object = apply_filters ( 'post_link_category', $cats [0], $cats, $post );
					
					$category_object = get_term ( $category_object, 'category' );
					$category = $category_object->slug;
					if ($parent = $category_object->parent) {
						$category = get_category_parents ( $parent, false, '/', true ) . $category;
					}
				}
				
				if (empty ( $category )) {
					$default_category = get_term ( get_option ( 'default_category' ), 'category' );
					$category = is_wp_error ( $default_category ) ? '' : $default_category->slug;
				}
			}
			
			$author = '';
			if (strpos ( $permalink, '%author%' ) !== false) {
				$authordata = get_userdata ( $post->post_author );
				$author = $authordata->user_nicename;
			}
			
			$date = explode ( ' ', date ( 'Y m d H i s', $unixtime ) );
			$rewritereplace = array ($date [0], $date [1], $date [2], $date [3], $date [4], $date [5], $post->post_name, $post->ID, $category, $author, $post->post_name );
			
			$permalink = home_url ( str_replace ( $rewritecode, $rewritereplace, $permalink ) );
			
			if ($structure != 'custom') {
				$permalink = user_trailingslashit ( $permalink, 'single' );
			}
		
		} else {
			$permalink = home_url ( '?p=' . $post->ID );
		} 
		
		$url = apply_filters ( 'post_link', $permalink, $post, $leavename );
		

		if (is_front_page ()) {
			$url = get_site_url ();
		
		}
		
		if (essb_option_value('counter_recover_domain') != '' && essb_option_value('counter_recover_newdomain')) {
			$url = str_replace ( essb_option_value('counter_recover_newdomain'), essb_option_value('counter_recover_domain'), $url );		
		}
		
		// Filter the Protocol
		if (essb_option_value('counter_recover_protocol') == 'http2https' && strpos ( $url, 'https' ) !== false) {
			$url = str_replace ( 'https', 'http', $url );
		}
	    else if (essb_option_value('counter_recover_protocol') == 'https2http' && strpos ( $url, 'https' ) === false) {
			$url = str_replace ( 'http', 'https', $url );
		}
		
		if (essb_option_value('counter_recover_prefixdomain') == 'unchanged') {
		
		}
		else if (essb_option_value('counter_recover_prefixdomain') == 'www' && strpos ( $url, 'www' ) === false) {
			$url = str_replace ( 'http://', 'http://www.', $url );
			$url = str_replace ( 'https://', 'https://www.', $url );
		}
		else if (essb_option_value('counter_recover_prefixdomain') == 'nonwww' && strpos ( $url, 'www' ) !== false) {
			$url = str_replace ( 'http://www.', 'http://', $url );
			$url = str_replace ( 'https://www.', 'https://', $url );
		}
		
		// Filter out the subdomain
		if (essb_option_value('counter_recover_subdomain') != '') {
			$url = str_replace (essb_option_value('counter_recover_subdomain') . '.', '', $url );
		
		}
		
		if (has_filter('essb4_recovery_filter')) {		
			$url = apply_filters ( 'essb4_recovery_filter', $past_url);
		}
		
		$url = apply_filters('essb4_alt_permalink', $url);
		
		return $url;
	
	}

}

function essb_recovery_get_alternate_permalink($url, $id) {
	_deprecated_function( __FUNCTION__, 'ESSB 5.0', 'Please use <code>essb_recovery_get_alt_permalink</code>' );
	
	return essb_recovery_get_alt_permalink($url, $id);
	
}

function essb_recovery_consolidate_results($share_values, $additional_values, $networks) {
	$new_result = array ();
	$new_result ['total'] = 0;
	
	foreach ( $networks as $k ) {
		$one_share = isset ( $share_values [$k] ) ? $share_values [$k] : 0;
		$two_share = isset ( $additional_values [$k] ) ? $additional_values [$k] : 0;
		
		$new_result [$k] = intval ( $one_share ) + intval ( $two_share );
		
		$new_result ['total'] += intval ( $one_share ) + intval ( $two_share );
	}
	
	return $new_result;
}