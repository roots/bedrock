<?php
/**
 * AffiliateWP integration functions
 * 
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.2
 *
 */

if (! function_exists ( 'essb_generate_affiliatewp_referral_link' )) {
	function essb_generate_affiliatewp_referral_link($permalink) {
		global $essb_options;
		
		if (! (is_user_logged_in () && affwp_is_affiliate ())) {
			return $permalink;
		}
		
		$affwp_active_mode = essb_options_value ( 'affwp_active_mode' );
		$affwp_active_pretty = essb_options_bool_value ( 'affwp_active_pretty' );
		
		// append referral variable and affiliate ID to sharing links in ESSB
		if ($affwp_active_mode == 'name') {
			if ($affwp_active_pretty) {
				$permalink .= affiliate_wp ()->tracking->get_referral_var () . '/' . affwp_get_affiliate_username ();
			} else {
				$permalink = add_query_arg ( affiliate_wp ()->tracking->get_referral_var (), affwp_get_affiliate_username (), $permalink );
			}
		} else {
			if ($affwp_active_pretty) {
				$permalink .= affiliate_wp ()->tracking->get_referral_var () . '/' . affwp_get_affiliate_id ();
			} else {
				$permalink = add_query_arg ( affiliate_wp ()->tracking->get_referral_var (), affwp_get_affiliate_id (), $permalink );
			}
		}
		return $permalink;
	}
}