<?php
/**
 * Minimal Share Counters parser
 * 
 * Set minimal share numbers for all or selected networks when real share values are lower
 * 
 * @since 5.1
 * @package EasySocialShareButtons
 * @author appscreo
 * 
 */

if (!function_exists('essb_apply_minimal_counter_values')) {
	function essb_apply_minimal_counter_values($cached_counters = array()) {
		global $post;
		
		if (!isset($post)) return $cached_counters;

		$minimal_fake = get_option('essb-fake');
		if (!is_array($minimal_fake)) {
			$minimal_fake = array();
		}
		
		// @since 5.1 support for selected fake social counters
		$fake_networks = essb_option_value('minimal_networks');
		if (!is_array($fake_networks)) {
			$fake_networks = array();
		}
		
		$post_id = $post->ID;
		
		$cumulative_total = 0;
		foreach ($cached_counters as $network => $shares) {
			
			if ($network == 'total') {
				continue;
			}
			
			if (count($fake_networks) > 0 && !in_array($network, $fake_networks)) {
				$shares = $cached_counters[$network];
				$cumulative_total += intval($shares);
				
				continue;
			}
			
			$shares = $cached_counters[$network];
			$minimal_fake_shares = isset($minimal_fake['minimal_'.$network]) ? $minimal_fake['minimal_'.$network] : '0';
			
			if (intval($shares) < intval($minimal_fake_shares)) {
				$shares = $minimal_fake_shares;
			}
			
			$cached_counters[$network] = $shares;
			$cumulative_total += intval($shares);
		}
		
		$cached_counters['total'] = $cumulative_total;
	
		return $cached_counters;
	}
	
	add_filter('essb4_get_cached_counters', 'essb_apply_minimal_counter_values');
}