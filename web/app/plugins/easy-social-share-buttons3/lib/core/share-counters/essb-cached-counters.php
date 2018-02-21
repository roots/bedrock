<?php
/**
 * Cached Counters Update Functions
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2017 AppsCreo
 * @since 4.2
 *
 */

class ESSBCachedCounters {
	
	public static function prepare_list_of_networks_with_counter($networks, $active_networks_list) {		
		$basic_network_list = 'twitter,linkedin,facebook,pinterest,google,stumbleupon,vk,reddit,buffer,love,ok,mwp,xing,mail,print,comments,yummly';
		
		// updated in version 4.2 - now we have only avoid with counter networks
		$avoid_network_list = 'more,share,subscribe';
		
		$internal_counters = essb_option_bool_value('active_internal_counters');
		$no_mail_print_counter = essb_option_bool_value('deactive_internal_counters_mail');
		$twitter_counter = essb_option_value('twitter_counters');
		
		if ($twitter_counter == '')  {$twitter_counter = 'api'; }
		
		$basic_array = explode(',', $basic_network_list);
		$avoid_array = explode(',', $avoid_network_list);

		$count_networks = array();
		
		foreach ($networks as $k) {
			
			if (!in_array ( $k, $active_networks_list)) {
				continue;
			}
			
			if (in_array($k, $basic_array)) {
				if ($k == 'print' || $k == 'mail') {
					if (!$no_mail_print_counter) {
						$count_networks[] = $k;
					}
				}
				else {
					$count_networks[] = $k;
				}
 			}
 			
 			if (!in_array($k, $basic_array) && $internal_counters && !in_array($k, $avoid_array)) {
 				$custom_network_avoid = false;
 				$custom_network_avoid = apply_filters("essb4_no_counter_for_{$k}", $custom_network_avoid);
 				if (!$custom_network_avoid) {
 					$count_networks[] = $k;
 				}
 			}
		}		
				
		
		return $count_networks;
	}
	
	public static function is_fresh_cache($post_id) {		
		$is_fresh = true;
		
		// Bail early if it's a crawl bot. If so, ONLY SERVE CACHED RESULTS FOR MAXIMUM SPEED.
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/bot|crawl|slurp|spider/i',  wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) ) {
			$is_fresh = true;
		}
		else {
			$expire_time = get_post_meta ( $post_id, 'essb_cache_expire', true );
			$now = time ();
			
			$is_alive = ($expire_time > $now);
			
			if (true == $is_alive) {
				$is_fresh = true;
			}
			else {
				$is_fresh = false;
			}
		}
		
		// avoid update of share counters when we do not browse on single post
		if ( ! is_singular()) {
			$is_fresh = true;
		}

		$user_call_refresh = isset ( $_REQUEST ['essb_counter_update'] ) ? $_REQUEST ['essb_counter_update'] : '';
		if ($user_call_refresh == 'true') {
			$is_fresh = false;
		}
		
		if (essb_internal_cache_get('updatedcounter-'.$post_id) == 'true') {
			$is_fresh = true;
		}
		
		return $is_fresh;
	}
		
	public static function all_socaial_networks() {
		$result = array();
		
		$networks = essb_available_social_networks();
		foreach ($networks as $key => $data) {
			$result[] = $key;
		}
		
		return $result;
	}
	
	public static function get_counters($post_id, $share = array(), $networks) {
		
		$cached_counters = array();
		$cached_counters['total'] = 0;
		
		// since 4.2 we give option to display each time total counter based on all
		// social networks
		if (essb_option_bool_value('total_counter_all')) {
			$networks = self::all_socaial_networks();
		}
		
		if (!ESSBCachedCounters::is_fresh_cache($post_id)) {
			$cached_counters = ESSBCachedCounters::update_counters($post_id, $share['url'], $share['full_url'], $networks);
			
			if (defined('ESSB3_SHARED_COUNTER_RECOVERY')) {
				
				$recovery_till_date = essb_option_value('counter_recover_date');
				$is_applying_for_recovery = true;
				
				// @since 3.4 - apply recovery till provided date only
				if (!empty($recovery_till_date)) {
					$is_applying_for_recovery = essb_recovery_is_matching_recovery_date($post_id, $recovery_till_date);
				}
				
				if ($is_applying_for_recovery) {
					$current_url = $share['full_url'];
					// get post meta recovery value
					// essb_activate_sharerecovery - post meta recovery address
					$post_essb_activate_sharerecovery = get_post_meta($post_id, 'essb_activate_sharerecovery', true);
					if (!empty($post_essb_activate_sharerecovery)) {
						$current_url = $post_essb_activate_sharerecovery;
					}
					else {
						//$current_url = essb_recovery_get_alternate_permalink($current_url, $post_id);
						// function changed inside version 5
						$current_url = essb_recovery_get_alt_permalink($current_url, $post_id);
					}					
					

					// to avoid duplicating same data we will execute update call only if those 2 URLs are different in some form
					if ($share['full_url'] != $current_url) {
						
						
						$recovery_counters = ESSBCachedCounters::update_counters($post_id, $current_url, $current_url, $networks, true);
						$cached_counters = essb_recovery_consolidate_results($cached_counters, $recovery_counters, $networks);
					}
				}
			}
			
			// mutli-step share counter recovery option - since 5.2
			if (function_exists('essb_advnaced_recovery_url_list')) {
				
				// include the required for share recovery functions if does not exists
				if (!function_exists('essb_recovery_consolidate_results')) {
					include_once(ESSB3_PLUGIN_ROOT . 'lib/core/share-counters/essb-sharecounter-recovery.php');
				}
				
				$alternative_url_list = essb_advnaced_recovery_url_list($share['full_url'], $post_id);				
				
				foreach ($alternative_url_list as $current_url) {
					if ($share['full_url'] != $current_url) {
						$recovery_counters = ESSBCachedCounters::update_counters($post_id, $current_url, $current_url, $networks, true);
						$cached_counters = essb_recovery_consolidate_results($cached_counters, $recovery_counters, $networks);
					}
				}
			}
			
			$total_saved = false;
			$require_rebuild_total = false;
			foreach ($networks as $k) {
				
				if ($k == 'total') $total_saved = true;
				
				$single = isset($cached_counters[$k]) ? $cached_counters[$k] : '0';
				if (intval($single) > -1) {
					//cache_counter_force
					$past_shares = intval(get_post_meta($post_id, 'essb_c_'.$k, true));
					
					// since version 5 we prevent save of lower than past saved shares
					if (!essb_option_bool_value('cache_counter_force')) {
						if (intval($past_shares) < intval($single)) {
							update_post_meta($post_id, 'essb_c_'.$k, $single);
						}
						else {
							$cached_counters[$k] = $past_shares;
							$require_rebuild_total = true;
						}
					}
					else {
						update_post_meta($post_id, 'essb_c_'.$k, $single);						
					}
				}
				else {
					$cached_counters[$k] =  intval(get_post_meta($post_id, 'essb_c_'.$k, true));
				}
			}
			
			// if we have a prevented saved record of counters we will rebuild total to show the correct value
			if ($require_rebuild_total) {
				$cached_counters['total'] = 0;
				
				foreach ($networks as $k) {
					$cached_counters['total'] += isset($cached_counters[$k]) ? intval($cached_counters[$k]) : 0;
				}
			}
			
			if (defined('ESSB3_ESML_ACTIVE') && function_exists('essb_sm_store_data')) {
				essb_sm_store_data($post_id, $cached_counters);
			}
			
			if (!$total_saved) {
				$k = 'total';
				$single = isset($cached_counters[$k]) ? $cached_counters[$k] : '0';
				if (intval($single) > 0) {
					update_post_meta($post_id, 'essb_c_'.$k, $single);
				}
				else {
					$cached_counters[$k] =  intval(get_post_meta($post_id, 'essb_c_'.$k, true));
				}
			}
		}		
		else {
			foreach ($networks as $k) {
				$cached_counters[$k] = get_post_meta($post_id, 'essb_c_'.$k, true);
				$cached_counters['total'] += intval($cached_counters[$k]);
			}
		}		
		
		
		if (has_filter('essb4_get_cached_counters')) {
			$cached_counters = apply_filters('essb4_get_cached_counters', $cached_counters);
		}
		
		return $cached_counters;
	}
	
	public static function update_counters($post_id, $url, $full_url, $networks = array(), $recover_mode = false) {
		
		$twitter_counter = essb_options_value('twitter_counters');
		
		// changed in 4.2 to use internal counter when nothing is selected
		if ($twitter_counter == '')  {
			$twitter_counter = 'self';
		}
		
		$async_update_mode = essb_option_bool_value('cache_counter_refresh_async');
		
		if (!$async_update_mode) {
			essb_depend_load_function('essb_counter_request', 'lib/core/share-counters/essb-counter-update.php');
			$cached_counters = essb_counter_update_simple($post_id, $url, $full_url, $networks, $recover_mode, $twitter_counter);
		}
		else {
			essb_depend_load_class('ESSBAsyncShareCounters', 'lib/core/share-counters/essb-counter-update-async.php');
			$counter_parser = new ESSBAsyncShareCounters($post_id, $url, $full_url, $networks, $recover_mode, $twitter_counter);
			$cached_counters = $counter_parser->get_counters();
		}
		
		if (!$recover_mode) {
			$expire_time = essb_option_value('counter_mode');
			if ($expire_time == '') { $expire_time = 60; }
			
			// @since version 5.0 - support for progressive counter update mode
			if (essb_option_bool_value('cache_counter_increase')) {
				$post_age = floor( date( 'U' ) - get_post_time( 'U' , false , $post_id ) );
				$post_age = $post_age / 86400;
				
				if (intval($post_age) >= 14 && intval($post_age) < 21) {
					$expire_time = intval($expire_time) * 2;
				}
				if (intval($post_age) >= 21 && intval($post_age) < 30) {
					$expire_time = intval($expire_time) * 3;
				}
				if (intval($post_age) >= 30) {
					$expire_time = intval($expire_time) * 4;
				}
			}
			
			update_post_meta ( $post_id, 'essb_cache_expire', (time () + ($expire_time * 60)) );
			
			essb_internal_cache_set('updatedcounter-'.$post_id, 'true');
		}		
		
		return $cached_counters;
	}

	
}

?>