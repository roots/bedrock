<?php
class ESSBAdminBarMenu3 {
	function __construct() {
		add_action ( 'admin_bar_menu', array ($this, "attach_admin_barmenu" ), 89 );
	}
	
	public function attach_admin_barmenu() {
		global $post;
		
		$url = '';
		if (isset ( $post )) {
			$url = get_permalink ( $post->ID );
		} else {
			$url = get_bloginfo ( 'url' );
		}
	
		
		// https://developers.facebook.com/tools/debug/og/object?q='.$url
		
		$not_activated_dot = "";
		if (ESSBActivationManager::existNewVersion()) {
			$not_activated_dot = '<span style="background-color:#e74c3c;width:10px;height:10px;border-radius:50%;margin-left:5px;display:inline-block;"></span>';
		}
		
		$this->add_root_menu ( "Easy Social Share Buttons".$not_activated_dot, "essb", get_admin_url () . 'admin.php?page=essb_options' );
		
		if (essb_show_welcome()) {
			$this->add_sub_menu ( __('Welcome', 'essb'), get_admin_url () . 'admin.php?page=essb_options', "essb", "essb_p0" );
			$this->add_sub_menu ( __('Settings', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_social', "essb", "essb_p1" );
			$this->add_sub_menu ( __('Social Sharing', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_social', "essb_p1", "essb_p11" );
				
		}
		else {
			$this->add_sub_menu ( __('Settings', 'essb'), get_admin_url () . 'admin.php?page=essb_options', "essb", "essb_p1" );
			$this->add_sub_menu ( __('Social Sharing', 'essb'), get_admin_url () . 'admin.php?page=essb_options', "essb_p1", "essb_p11" );
		}
		$this->add_sub_menu ( __('Where to Display', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_where', "essb_p1", "essb_p12" );
		
		
		if (!essb_option_bool_value('deactivate_module_natives') || !essb_option_bool_value('deactivate_module_profiles') || !essb_option_bool_value('deactivate_module_followers')) {		
			$this->add_sub_menu ( __('Social Follow', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_display', "essb_p1", "essb_p21" );
		}
		
		if (!essb_option_bool_value('deactivate_module_subscribe')) {
			$this->add_sub_menu ( __('Subscribe Forms', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_optin', "essb_p1", "essb_p211" );
		}
		
		$this->add_sub_menu ( __('Advanced Settings', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_advanced', "essb_p1", "essb_p51" );
		$this->add_sub_menu ( __('Style Settings', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_style', "essb_p1", "essb_p41" );
		$this->add_sub_menu ( __('Shortcode Generator', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_shortcode&tab=shortcode', "essb", "essb_p3" );
		$this->add_sub_menu ( __('Social Share Buttons [easy-social-share]', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_shortcode&tab=shortcode&code=easy-social-share', "essb_p3", "essb_p31" );
		$this->add_sub_menu ( __('Native Social Buttons [easy-social-lile]', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_shortcode&tab=shortcode&code=easy-social-like', "essb_p3", "essb_p32" );
		$this->add_sub_menu ( __('Total Shares [easy-total-shares]', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_shortcode&tab=shortcode&code=easy-total-shares', "essb_p3", "essb_p33" );
		$this->add_sub_menu ( __('Subscribe Form [easy-subscribe]', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_shortcode&tab=shortcode&code=easy-subscribe', "essb_p3", "essb_p34" );
		$this->add_sub_menu ( __('All available shortcodes', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_shortcode&tab=shortcode', "essb_p3", "essb_p35" );
		$this->add_sub_menu ( __('Validate and test shared data', 'essb'), '', "essb", "essb_v" );
		$this->add_sub_menu ( __('How will my information will look in Facebook', 'essb'), 'https://developers.facebook.com/tools/debug/og/object?q=' . $url, "essb_v", "essb_v1" );
		$this->add_sub_menu ( __('Test my Twitter Cards and validate site', 'essb'), 'https://dev.twitter.com/docs/cards/validation/validator/?link=' . $url, "essb_v", "essb_v2" );
		//$this->add_sub_menu ( "Google Rich Snippet Validator", 'http://www.google.com/webmasters/tools/richsnippets?q=' . $url, "essb_v", "essb_v3" );
		
		if (defined ( 'ESSB3_CACHE_ACTIVE' )) {
			$this->add_sub_menu ( '<b>'.__('Purge plugin cache', 'essb').'</b>', get_admin_url () . 'admin.php?page=essb_redirect_advanced&tab=advanced&purge-cache=true', "essb", "essb_p7" );
		}
		
		if (defined('ESSB3_CACHED_COUNTERS')) {
			$root_clear_url = '';
			if (is_single() || is_page()) {
				$root_clear_url = $url . '?essb_counter_update=true';
			}
			$this->add_sub_menu ( '<span style="color: #83D6DE;">'. __('Update Counters', 'essb').'</span>', $root_clear_url, "essb", "essb_p8" );
				
			$history_clear_url = '';
			if (is_single () || is_page ()) {
				$this->add_sub_menu ( '<b>'.__('Update counters for current page/post', 'essb').'</b>', $url . '?essb_counter_update=true', "essb_p8", "essb_p81" );				
				$current_url = essb_get_current_page_url();
				$history_clear_url = $current_url;
				$current_url = add_query_arg('essb_clear_cached_counters', 'true', $current_url);
				$history_clear_url = add_query_arg('essb_clear_counters_history', 'true', $history_clear_url);
			}
			else if (is_admin()) {
				$current_url = admin_url('admin.php?page=essb_options');
				$history_clear_url = $current_url;
				$current_url = add_query_arg('essb_clear_cached_counters', 'true', $current_url);
				$history_clear_url = add_query_arg('essb_clear_counters_history', 'true', $history_clear_url);
			}
			else {
				$current_url = essb_get_current_page_url();
				$history_clear_url = essb_get_current_page_url();
			}
			
			
			$this->add_sub_menu ( '<b>'.__('Setup update of counters on entire site', 'essb').'</b>', $current_url, "essb_p8", "essb_p102" );
			$this->add_sub_menu ( '<b>'.__('Clear counter history & update counters for current post/page', 'essb').'</b>', $history_clear_url, "essb_p8", "essb_p103" );
			
			if (is_single() || is_page()) {
				$this->add_sub_menu ( '<b>'.__('Debug Counters', 'essb').'</b>', get_admin_url().'admin.php?usertab=system-1&page=essb_redirect_status&url='.$url, "essb_p8", "essb_p104" );
				
			}
		}
		
		$this->add_sub_menu ( __('Need help?', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_support&tab=support', "essb", "essb_p6" );
		$this->add_sub_menu ( __('About', 'essb'), get_admin_url () . 'admin.php?page=essb_redirect_about&tab=about', "essb", "essb_p101" );
		
		if (!ESSBActivationManager::isActivated() && !ESSBActivationManager::isThemeIntegrated()) {
			$activate_url = admin_url('admin.php?page=essb_redirect_update&tab=update');
			$this->add_sub_menu ( '<span style="color:#EE543A;">'.__('Activate Plugin', 'essb').'</span>', $activate_url, "essb", "essb_p9" );
		}
		
		if (ESSB3_ADDONS_ACTIVE) {
			$this->add_sub_menu ( '<span style="color:#f39c12;">'.__('Extensions', 'essb').'</span>', get_admin_url () . 'admin.php?page=essb_redirect_extensions&tab=extensions', "essb", "essb_p7" );
				
		}
	}
	
	function add_root_menu($name, $id, $href = FALSE) {
		global $wp_admin_bar;
		if (! is_super_admin () || ! is_admin_bar_showing ())
			return;
		
		$wp_admin_bar->add_menu ( array ('id' => $id, 'meta' => array (), 'title' => $name, 'href' => $href ) );
	}
	
	function add_sub_menu($name, $link, $root_menu, $id, $meta = FALSE) {
		global $wp_admin_bar;
		if (! is_super_admin () || ! is_admin_bar_showing ())
			return;
		
		$wp_admin_bar->add_menu ( array ('parent' => $root_menu, 'id' => $id, 'title' => $name, 'href' => $link, 'meta' => $meta ) );
	}

}
