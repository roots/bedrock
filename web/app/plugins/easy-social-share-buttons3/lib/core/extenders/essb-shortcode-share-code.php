<?php
if (! function_exists ( 'essb_shortcode_share_prepare' )) {
	function essb_shortcode_share_prepare($atts) {
		
		global $essb_networks, $essb_options;
		
		$shortcode_extended_options = array ();
		
		$shortcode_custom_display_texts = array ();
		$exist_personalization = false;
		foreach ( $essb_networks as $key => $data ) {
			$text_key = sprintf ( '%1$s_text', $key );
			$value = isset ( $atts [$text_key] ) ? $atts [$text_key] : '';
			
			if (! empty ( $value )) {
				$shortcode_custom_display_texts [$key] = $value;
				$exist_personalization = true;
			}
		}
		
		// add other names from default settings that are not modified
		if ($exist_personalization) {
			foreach ( $essb_networks as $key => $object ) {
				$search_for = "user_network_name_" . $key;
				$user_network_name = essb_object_value ( $essb_options, $search_for, $object ['name'] );
				if (! isset ( $shortcode_custom_display_texts [$key] )) {
					$shortcode_custom_display_texts [$key] = $user_network_name;
				}
			}
		}
		
		// parsing extended shortcode options
		if (is_array ( $atts )) {
			foreach ( $atts as $key => $value ) {
				if (strpos ( $key, "extended_" ) !== false) {
					$key = str_replace ( "extended_", "", $key );
					$shortcode_extended_options [$key] = $value;
				}
			}
		}
		
		$shortcode_automatic_parse_args = array ('counters' => 'number', 
				'current' => 'number', 
				'text' => 'text', 
				'title' => 'text', 
				'url' => 'text', 
				'native' => 'bool', 
				'sidebar' => 'bool', 
				'popup' => 'bool', 
				'flyin' => 'bool', 
				'popafter' => 'text', 
				'message' => 'bool', 
				'description' => 'text', 
				'image' => 'text', 
				'fblike' => 'text', 
				'plusone' => 'text', 
				'style' => 'text', 
				'hide_names' => 'text', 
				'hide_icons' => 'text', 
				'counters_pos' => 'text', 
				'counter_pos' => 'text', 
				'sidebar_pos' => 'text', 
				'nostats' => 'bool', 
				'hide_total' => 'bool', 
				'total_counter_pos' => 'text', 
				'fullwidth' => 'bool', 
				'fullwidth_fix' => 'text', 
				'fullwidth_first' => 'text', 
				'fullwidth_second' => 'text', 
				'fixedwidth' => 'bool', 
				'fixedwidth_px' => 'text', 
				'fixedwidth_align' => 'text', 
				'float' => 'bool', 
				'postfloat' => 'bool', 
				'morebutton' => 'text', 
				'morebutton_icon' => 'text', 
				'forceurl' => 'bool', 
				'videoshare' => 'bool', 
				'template' => 'text', 
				'query' => 'bool', 
				'column' => 'bool', 
				'columns' => 'text', 
				'topbar' => 'bool', 
				'bottombar' => 'bool', 
				'twitter_user' => 'text', 
				'twitter_hashtags' => 'text', 
				'twitter_tweet' => 'text', 
				'nospace' => 'bool', 
				'post_float' => 'text', 
				'fullwidth_align' => 'text', 
				'mobilebar' => 'bool', 
				'mobilebuttons' => 'bool',
				'mobilepoint' => 'bool', 
				'heroshare' => 'bool', 
				'animation' => 'string', 
				'postviews' => 'string', 
				'utm' => 'string', 
				'point' => 'bool', 
				'point_type' => 'string', 
				'demo_counter' => 'bool', 
				'flex' => 'bool', 
				'autowidth' => 'bool',
				'align' => 'string',
				'sharebtn_func' => 'string',
				'sharebtn_style' => 'string',
				'sharebtn_icon' => 'string',
				'sharebtn_counter' => 'string',
				'vcgridpost' => '',
				'email_subject' => 'string',
				'email_message' => 'string' );
		$shortcode_options = array (
				'buttons' => '', 
				'counters' => 0, 
				'current' => 1, 
				'text' => '', 
				'title' => '',
				'url' => '', 
				'native' => 'no', 
				'sidebar' => 'no', 
				'popup' => 'no', 
				'flyin' => 'no', 
				'hide_names' => '', 
				'popafter' => '', 
				'message' => 'no', 
				'description' => '', 
				'image' => '', 
				'fblike' => '', 
				'plusone' => '', 
				'style' => '', 
				'counters_pos' => '', 
				'counter_pos' => '', 
				'sidebar_pos' => '', 
				'nostats' => 'no', 
				'hide_total' => 'no', 
				'total_counter_pos' => '', 
				'fullwidth' => 'no', 
				'fullwidth_fix' => '', 
				'fullwidth_align' => '', 
				'fullwidth_first' => '', 
				'fullwidth_second' => '',
				'fixedwidth' => 'no', 
				'fixedwidth_px' => '', 
				'fixedwidth_align' => '', 
				'float' => 'no', 
				'postfloat' => 'no', 
				'morebutton' => '', 
				'forceurl' => 'no', 
				'videoshare' => 'no', 
				'template' => '', 
				'hide_mobile' => 'no', 
				'only_mobile' => 'no', 
				'query' => 'no',
				'column' => 'no', 
				'columns' => '5', 
				'morebutton_icon' => '', 
				'topbar' => 'no', 
				'bottombar' => 'no', 
				'twitter_user' => '', 
				'twitter_hashtags' => '',
				 'twitter_tweet' => '', 
				'nospace' => 'false', 
				'post_float' => '', 
				'hide_icons' => '', 
				'mobilebar' => 'no', 
				'mobilebuttons' => 'no', 
				'mobilepoint' => 'no', 
				'heroshare' => 'no', 
				'animation' => '', 
				'postviews' => '', 
				'utm' => 'no', 
				'point' => 'no', 
				'point_type' => 'simple', 
				'demo_counter' => 'no', 
				'flex' => 'no', 
				'autowidth' => 'no', 
				'align' => '',
				'sharebtn_func' => '',
				'sharebtn_style' => '',
				'sharebtn_icon' => '',
				'sharebtn_counter' => '',
				'vcgridpost' => '',
				'email_subject' => '',
				'email_message' => '' );
		
		$atts = shortcode_atts ( $shortcode_options, $atts );
		
		$hide_mobile = isset ( $atts ['hide_mobile'] ) ? $atts ['hide_mobile'] : '';
		$hide_mobile = ESSBOptionValuesHelper::unified_true ( $hide_mobile );
		
		$only_mobile = isset ( $atts ['only_mobile'] ) ? $atts ['only_mobile'] : '';
		$only_mobile = ESSBOptionValuesHelper::unified_true ( $only_mobile );
		
		if ($hide_mobile && essb_is_mobile ()) {
			return "";
		}
		
		if ($only_mobile && ! essb_is_mobile ()) {
			return "";
		}
		
		// initialize list of availalbe networks
		if ($atts ['buttons'] == '') {
			$networks = essb_option_value ( 'networks' );
			if (! is_array ( $networks )) {
				$networks = array ();
			}
		} else {
			$networks = preg_split ( '#[\s+,\s+]#', $atts ['buttons'] );
		}
		
		$shortcode_parameters = array ();
		$shortcode_parameters ['networks'] = $networks;
		$shortcode_parameters ['customize_texts'] = $exist_personalization;
		$shortcode_parameters ['network_texts'] = $shortcode_custom_display_texts;
		
		foreach ( $shortcode_automatic_parse_args as $key => $type ) {
			$value = isset ( $atts [$key] ) ? $atts [$key] : '';
			
			if ($type == "number") {
				$value = intval ( $value );
			}
			if ($type == "bool") {
				$value = ESSBOptionValuesHelper::unified_true ( $value );
			}
			
			// @since 3.0.3 - fixed the default button style when used with
			// shortcode
			if ($key == "style") {
				if (empty ( $value )) {
					$value = essb_option_value ( 'button_style' );
				}
			}
			
			$shortcode_parameters [$key] = $value;
		}
		
		
		
		if (! empty ( $shortcode_parameters ['post_float'] )) {
			$shortcode_parameters ['postfloat'] = ESSBOptionValuesHelper::unified_true ( $shortcode_parameters ['post_float'] );
		}
		
		if (! empty ( $shortcode_parameters ['animation'] )) {
			if ($shortcode_parameters ['animation'] != 'no') {
				if (! essb_resource_builder ()->is_activated ( 'animations' )) {
					$animate_url = ESSB3_PLUGIN_URL . '/assets/css/essb-animations.min.css';
					essb_resource_builder ()->add_static_resource_footer ( $animate_url, 'easy-social-share-buttons-animations', 'css' );
				}
			}
		}

		///print_r($shortcode_parameters);
		
		// @since 3.0 query handling parameters is set as default in shortcode
		
		if ($shortcode_parameters ['query']) {
			$query_url = isset ( $_REQUEST ['url'] ) ? $_REQUEST ['url'] : '';
			if (! empty ( $query_url )) {
				
				$shortcode_parameters ['url'] = $query_url;
				$url = $query_url;
			}
			
			$query_text = isset ( $_REQUEST ['post_title'] ) ? $_REQUEST ['post_title'] : '';
			
			if (! empty ( $query_text )) {
				$shortcode_parameters ['text'] = $query_text;
				$shortcode_parameters ['title'] = $query_text;
				$text = $query_text;
			}
		}
		
		if ($shortcode_parameters ['counters_pos'] == "" && $shortcode_parameters ['counter_pos'] != '') {
			$shortcode_parameters ['counters_pos'] = $shortcode_parameters ['counter_pos'];
		}
		if ($shortcode_parameters ['text'] != '' && $shortcode_parameters ['title'] == '') {
			$shortcode_parameters ['title'] = $shortcode_parameters ['text'];
		}
		
		if ($shortcode_options['twitter_tweet'] == '' && $shortcode_options['title'] != '') {
			$shortcode_options['twitter_tweet'] = $shortcode_options['title'];
		}
		
		if (! empty ( $shortcode_parameters ['hide_names'] )) {
			if ($shortcode_parameters ['hide_names'] == "yes") {
				$shortcode_parameters ['style'] = "icon_hover";
			}
			if ($shortcode_parameters ['hide_names'] == "no") {
				$shortcode_parameters ['style'] = "button";
			}
			if ($shortcode_parameters ['hide_names'] == "force") {
				$shortcode_parameters ['style'] = "icon";
			}
		}
		if (! empty ( $shortcode_parameters ['hide_icons'] )) {
			if ($shortcode_parameters ['hide_icons'] == "yes") {
				$shortcode_parameters ['style'] = "button_name";
			}
		}
		
		// shortcode extended options
		foreach ( $shortcode_extended_options as $key => $value ) {
			$shortcode_parameters [$key] = $value;
		}
		
		if ($shortcode_parameters ['sidebar']) {
			if ($shortcode_parameters ['sidebar_pos'] == "bottom") {
				$shortcode_parameters ['sidebar'] = false;
				$shortcode_parameters ['bottombar'] = true;
			}
			if ($shortcode_parameters ['sidebar_pos'] == "top") {
				$shortcode_parameters ['sidebar'] = false;
				$shortcode_parameters ['topbar'] = true;
			}
		}
		
		$use_minifed_css = (ESSBGlobalSettings::$use_minified_css) ? ".min" : "";
		$use_minifed_js = (ESSBGlobalSettings::$use_minified_js) ? ".min" : "";
		// load mail resource on access
		if (in_array ( 'mail', $networks )) {
			if (! essb_resource_builder ()->is_activated ( 'mail' )) {
				//$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-mailform' . $use_minifed_css . '.css';
				//essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-mailform', 'css' );
				
				//$script_url = ESSB3_PLUGIN_URL . '/assets/js/essb-mailform.js';
				//essb_resource_builder ()->add_static_resource_footer ( $script_url, 'essb-mailform', 'js', true );
				
				//essb_resource_builder ()->activate_resource ( 'mail' );
			}
		}
		
		/*if (in_array ( 'print', $networks )) {
			if (! essb_resource_builder ()->is_activated ( 'print' )) {
				if (! essb_option_bool_value ( 'print_use_printfriendly' )) {
					//essb_resource_builder ()->add_js ( ESSBResourceBuilderSnippets::js_build_window_print_code (), true, 'essb-printing-code' );
					essb_depend_load_function('essb_rs_js_build_window_print_code', 'lib/core/resource-snippets/essb_rs_js_build_window_print_code.php');
						
					essb_resource_builder ()->activate_resource ( 'print' );
				}
			}
		}*/
		
		if ($shortcode_parameters ['counters'] == 1) {
			if (! essb_resource_builder ()->is_activated ( 'counters' )) {
				if (! defined ( 'ESSB3_COUNTER_LOADED' ) && ! defined ( 'ESSB3_CACHED_COUNTERS' )) {
					$script_url = ESSB3_PLUGIN_URL . '/assets/js/easy-social-share-buttons' . $use_minifed_js . '.js';
					essb_resource_builder ()->add_static_resource_footer ( $script_url, 'easy-social-share-buttons', 'js' );
					essb_resource_builder ()->activate_resource ( 'counters' );
					define ( 'ESSB3_COUNTER_LOADED', true );
				}
			}
		}
		
		$display_as_key = "shortcode";
		if ($shortcode_parameters ['sidebar']) {
			$display_as_key = "sidebar";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
		}
		if ($shortcode_parameters ['popup']) {
			$display_as_key = "popup";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
			
			if (! essb_resource_builder ()->is_activated ( 'popup' )) {
				
				/*$script_url = ESSB3_PLUGIN_URL . '/assets/js/essb-popup' . $use_minifed_js . '.js';
				essb_resource_builder ()->add_static_resource_footer ( $script_url, 'essb-popup', 'js', true );
				essb_resource_builder ()->activate_resource ( 'popup' );*/
			}
		}
		
		if ($shortcode_parameters ['heroshare']) {
			$display_as_key = "heroshare";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
			
			if (! essb_resource_builder ()->is_activated ( 'heroshare' )) {
				
				$script_url = ESSB3_PLUGIN_URL . '/assets/js/essb-heroshare' . $use_minifed_js . '.js';
				essb_resource_builder ()->add_static_resource_footer ( $script_url, 'essb-heroshare', 'js', true );
				essb_resource_builder ()->activate_resource ( 'heroshare' );
			}
		}
		
		if ($shortcode_parameters ['flyin']) {
			$display_as_key = "flyin";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
			
			/*if (! essb_resource_builder ()->is_activated ( 'flyin' )) {
				
				$script_url = ESSB3_PLUGIN_URL . '/assets/js/essb-flyin' . $use_minifed_js . '.js';
				essb_resource_builder ()->add_static_resource_footer ( $script_url, 'essb-flyin', 'js' );
				essb_resource_builder ()->activate_resource ( 'flyin' );
			}*/
		}
		if ($shortcode_parameters ['postfloat']) {
			$display_as_key = "postfloat";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
			if (! essb_resource_builder ()->is_activated ( 'display_positions_script' )) {
				$script_url = ESSB3_PLUGIN_URL . '/assets/js/essb-display-methods' . $use_minifed_js . '.js';
				//essb_resource_builder ()->add_static_resource_footer ( $script_url, 'essb-display-methods', 'js' );
				essb_resource_builder ()->activate_resource ( 'display_positions_script' );
			
			}
		}
		if ($shortcode_parameters ['point']) {
			$display_as_key = "point";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
			if (! essb_resource_builder ()->is_activated ( 'display_positions_script' )) {
				$script_url = ESSB3_PLUGIN_URL . '/assets/js/essb-display-methods' . $use_minifed_js . '.js';
				//essb_resource_builder ()->add_static_resource_footer ( $script_url, 'essb-display-methods', 'js' );
				essb_resource_builder ()->activate_resource ( 'display_positions_script' );
			
			}
		}
		
		if ($shortcode_parameters ['float']) {
			$display_as_key = "float";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_script' )) {
				$script_url = ESSB3_PLUGIN_URL . '/assets/js/essb-display-methods' . $use_minifed_js . '.js';
				//essb_resource_builder ()->add_static_resource_footer ( $script_url, 'essb-display-methods', 'js' );
				essb_resource_builder ()->activate_resource ( 'display_positions_script' );
					
			}				
		}
		if ($shortcode_parameters ['topbar']) {
			$display_as_key = "topbar";
			
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
		}
		if ($shortcode_parameters ['bottombar']) {
			$display_as_key = "bottombar";
			if (! essb_resource_builder ()->is_activated ( 'display_positions_style' )) {
				$style_url = ESSB3_PLUGIN_URL . '/assets/css/essb-display-methods' . $use_minifed_css . '.css';
				essb_resource_builder ()->add_static_resource_footer ( $style_url, 'easy-social-share-buttons-display-methods', 'css' );
				essb_resource_builder ()->activate_resource ( 'display_positions_style' );
			}
		}
		
		if ($shortcode_parameters ['mobilebar'] || $shortcode_parameters ['mobilebuttons'] || $shortcode_parameters ['mobilepoint']) {
			if (! essb_is_mobile ()) {
				return "";
			}
		}
		
		// @since version 3.0.4
		if ($shortcode_parameters ['mobilebar']) {
			$display_as_key = "sharebar";
		}
		if ($shortcode_parameters ['mobilebuttons']) {
			$display_as_key = "sharebottom";
		}
		if ($shortcode_parameters ['mobilepoint']) {
			$display_as_key = "sharepoint";
		}
		
		$special_shortcode_options = array ();
		// print_r($shortcode_parameters);
		if (! $shortcode_parameters ['native']) {
			$special_shortcode_options ['only_share'] = true;
		}
		
		//print_r($shortcode_parameters);
		
		if ($display_as_key == "sidebar") {
			return essb_core ()->display_sidebar ( true, $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "popup") {
			return essb_core ()->display_popup ( true, $shortcode_parameters ['popafter'], $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "heroshare") {
			return essb_core ()->display_heroshare ( true, $shortcode_parameters ['heroafter'], $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "flyin") {
			return essb_core ()->display_flyin ( true, $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "postfloat") {
			return essb_core ()->shortcode_display_postfloat ( $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "topbar") {
			return essb_core ()->display_topbar ( true, $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "bottombar") {
			return essb_core ()->display_bottombar ( true, $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "sharebar") {
			return essb_core ()->display_sharebar ( true, $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "sharebottom") {
			return essb_core ()->display_sharebottom ( true, $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "sharepoint") {
			return essb_core ()->display_sharepoint ( true, $shortcode_parameters, $special_shortcode_options );
		} else if ($display_as_key == "point") {
			return essb_core ()->display_point ( true, $shortcode_parameters, $special_shortcode_options );
		} else {
			return essb_core ()->generate_share_buttons ( $display_as_key, 'share', $special_shortcode_options, true, $shortcode_parameters );
		}
	
	}
}