<?php

if (!function_exists('essb_generate_like_buttons')) {
	function essb_generate_like_buttons($position) {
		global $post;
		
		$cache_key = "";
		
		if (isset($post) && defined('ESSB3_CACHE_ACTIVE')) {
			$cache_key = sprintf('essb_cache_like_%1$s_%2$s', $post->ID, $position);
		
			$cached_data = ESSBDynamicCache::get($cache_key);
				
			if (!empty($cached_data)) {
				return $cached_data;
			}
		}
		
		$post_share_details = essb_get_post_share_details($position);
		
		$post_native_details['withshare'] = false;
		
		// generate native button main settings
		$post_native_details = essb_get_native_button_settings($position);
		$post_native_details['order'] = ($post_native_details['active']) ? ESSBNativeButtonsHelper::active_native_buttons() : array();
		$ssbuttons = "";
		
		if ($post_native_details['active']) {
			if (!$post_native_details['sameline']) {
				$post_native_details['withshare'] = false;
				$ssbuttons .= ESSBNativeButtonsHelper::draw_native_buttons($post_native_details, $post_native_details['order'], $post_native_details['counters'],
						$post_native_details['sameline'], $post_native_details['skinned']);
			}
		}
		
		// apply clean of new lines
		if (!empty($ssbuttons)) {
			$ssbuttons = trim(preg_replace('/\s+/', ' ', $ssbuttons));
		}
		
		if (!empty($cache_key)) {
			ESSBDynamicCache::put($cache_key, $ssbuttons);
		}
		
		return $ssbuttons;
	}
}