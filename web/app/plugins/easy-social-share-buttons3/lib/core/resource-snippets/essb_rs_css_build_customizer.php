<?php
if (! function_exists ( 'essb_rs_css_build_customizer' )) {
	function essb_rs_css_build_customizer() {
		global $post, $essb_options, $essb_networks;
		
		$options = $essb_options;
		
		$snippet = '';
		
		$global_bgcolor = isset ( $options ['customizer_bgcolor'] ) ? $options ['customizer_bgcolor'] : '';
		$global_textcolor = isset ( $options ['customizer_textcolor'] ) ? $options ['customizer_textcolor'] : '';
		$global_hovercolor = isset ( $options ['customizer_hovercolor'] ) ? $options ['customizer_hovercolor'] : '';
		$global_hovertextcolor = isset ( $options ['customizer_hovertextcolor'] ) ? $options ['customizer_hovertextcolor'] : '';
		
		$global_remove_bg_effects = ESSBOptionValuesHelper::options_bool_value ( $options, 'customizer_remove_bg_hover_effects' );
		$css = '';
		
		// @since 2.0
		$customizer_totalbgcolor = ESSBOptionValuesHelper::options_value ( $options, 'customizer_totalbgcolor' );
		$customizer_totalcolor = ESSBOptionValuesHelper::options_value ( $options, 'customizer_totalcolor' );
		$customizer_totalnobgcolor = ESSBOptionValuesHelper::options_value ( $options, 'customizer_totalnobgcolor' );
		$customizer_totalfontsize = ESSBOptionValuesHelper::options_value ( $options, 'customizer_totalfontsize' );
		$customizer_totalfontsize_after = ESSBOptionValuesHelper::options_value ( $options, 'customizer_totalfontsize_after' );
		
		$customizer_totalfontsize_beforeafter = ESSBOptionValuesHelper::options_value ( $options, 'customizer_totalfontsize_beforeafter' );
		
		if ($customizer_totalbgcolor != '') {
			$snippet .= ('.essb_totalcount { background: ' . $customizer_totalbgcolor . ' !important;} ');
		}
		if ($customizer_totalnobgcolor == 'true') {
			$snippet .= ('.essb_totalcount { background: none !important;} ');
		}
		if ($customizer_totalcolor != '') {
			$snippet .= ('.essb_totalcount, .essb_totalcount .essb_t_nb_after { color: ' . $customizer_totalcolor . ' !important;} ');
		}
		if ($customizer_totalfontsize != '') {
			$snippet .= ('.essb_totalcount .essb_t_nb { font-size: ' . $customizer_totalfontsize . '!important; line-height:' . $customizer_totalfontsize . '!important;}');
		}
		if ($customizer_totalfontsize_after != '') {
			$snippet .= ('.essb_totalcount .essb_t_nb_after { font-size: ' . $customizer_totalfontsize_after . '!important; }');
		}
		
		if ($customizer_totalfontsize_beforeafter != '') {
			$snippet .= ('.essb_totalcount_item_before .essb_t_before, .essb_totalcount_item_after .essb_t_before { font-size: ' . $customizer_totalfontsize_beforeafter . '!important; }');
		}
		
		if ($global_remove_bg_effects) {
			$snippet .= ('.essb_links a:hover, .essb_links a:focus { background: none !important; }');
		}
		
		$checkbox_list_networks = array ();
		$parse_network_list = essb_available_social_networks();
		foreach ( $parse_network_list as $key => $object ) {
			$checkbox_list_networks [$key] = $object ['name'];
		}		
		
		if ($global_bgcolor != '' || $global_textcolor != '' || $global_hovercolor != '' || $global_hovertextcolor != '') {
			foreach ( $checkbox_list_networks as $k => $v ) {
				if ($k != '') {
					$singleCss = "";
					if ($global_bgcolor != '' || $global_textcolor != '') {
						$singleCss .= '.essb_links.essb_share .essb_link_' . $k . ' a { ';
						if ($global_bgcolor != '') {
							$singleCss .= 'background-color:' . $global_bgcolor . '!important;';
						}
						if ($global_textcolor != '') {
							$singleCss .= 'color:' . $global_textcolor . '!important;';
						}
						$singleCss .= '}';
					}
					if ($global_hovercolor != '' || $global_hovertextcolor != '') {
						$singleCss .= '.essb_links.essb_share .essb_link_' . $k . ' a:hover, .essb_links .essb_link_' . $k . ' a:focus { ';
						if ($global_hovercolor != '') {
							$singleCss .= 'background-color:' . $global_hovercolor . '!important;';
						}
						if ($global_hovertextcolor != '') {
							$singleCss .= 'color:' . $global_hovertextcolor . '!important;';
						}
						$singleCss .= '}';
					}
					
					$snippet .= ($singleCss);
				}
			
			}
		}
		
		$global_customizer_iconsize = essb_option_value('customizer_iconsize');
		if ($global_customizer_iconsize != '') {
			$icon_wh = intval($global_customizer_iconsize) * 2;
			$icon_lt = intval($global_customizer_iconsize) / 2;
			$icon_lt = round($icon_lt);
			
			$snippet .= '.essb_links.essb_share .essb_icon { width: '.$icon_wh.'px!important;height:'.$icon_wh.'px!important;}';
			$snippet .= '.essb_links.essb_share .essb_icon:before { font-size:'.$global_customizer_iconsize.'px!important;left:'.$icon_lt.'px!important;top:'.$icon_lt.'px!important;}';
		}
		
		$global_customizer_namesize = essb_option_value('customizer_namesize');
		$global_customizer_namebold = essb_option_bool_value('customizer_namebold');
		$global_customizer_nameupper = essb_option_bool_value('customizer_nameupper');
		if ($global_customizer_namesize != '' || $global_customizer_namebold || $global_customizer_nameupper) {
			$snippet .= '.essb_links.essb_share .essb_network_name {';
			if ($global_customizer_namesize != '') {
				if (intval($global_customizer_namesize) > 0) { $global_customizer_namesize .= 'px'; }
				$snippet .= 'font-size:'.$global_customizer_namesize.'!important;';
			}
			if ($global_customizer_namebold) {
				$snippet .= 'font-weight: bold !important;';
			}
			
			if ($global_customizer_nameupper) {
				$snippet .= 'text-transform: uppercase !important;';
			}
			$snippet .= '}';
		}
		
		// single network color customization
		foreach ( $parse_network_list as $k => $v ) {
			if ($k != '') {
				$network_bgcolor = isset ( $options ['customizer_' . $k . '_bgcolor'] ) ? $options ['customizer_' . $k . '_bgcolor'] : '';
				$network_textcolor = isset ( $options ['customizer_' . $k . '_textcolor'] ) ? $options ['customizer_' . $k . '_textcolor'] : '';
				$network_hovercolor = isset ( $options ['customizer_' . $k . '_hovercolor'] ) ? $options ['customizer_' . $k . '_hovercolor'] : '';
				$network_hovertextcolor = isset ( $options ['customizer_' . $k . '_hovertextcolor'] ) ? $options ['customizer_' . $k . '_hovertextcolor'] : '';
				
				$network_icon = isset ( $options ['customizer_' . $k . '_icon'] ) ? $options ['customizer_' . $k . '_icon'] : '';
				$network_hovericon = isset ( $options ['customizer_' . $k . '_hovericon'] ) ? $options ['customizer_' . $k . '_hovericon'] : '';
				$network_iconbgsize = isset ( $options ['customizer_' . $k . '_iconbgsize'] ) ? $options ['customizer_' . $k . '_iconbgsize'] : '';
				$network_hovericonbgsize = isset ( $options ['customizer_' . $k . '_hovericonbgsize'] ) ? $options ['customizer_' . $k . '_hovericonbgsize'] : '';
				
				$sigleCss = "";
				
				if ($network_bgcolor != '' || $network_textcolor != '') {
					$sigleCss .= '.essb_links.essb_share .essb_link_' . $k . ' a { ';
					if ($network_bgcolor != '') {
						$sigleCss .= 'background-color:' . $network_bgcolor . '!important;';
					}
					if ($network_textcolor != '') {
						$sigleCss .= 'color:' . $network_textcolor . '!important;';
					}
					$sigleCss .= '}';
					
					if ($k == "more") {
						$sigleCss .= '.essb_links.essb_share .essb_link_less a { ';
						if ($network_bgcolor != '') {
							$sigleCss .= 'background-color:' . $network_bgcolor . '!important;';
						}
						if ($network_textcolor != '') {
							$sigleCss .= 'color:' . $network_textcolor . '!important;';
						}
						$sigleCss .= '}';
					}
				}
				if ($network_hovercolor != '' || $network_hovertextcolor != '') {
					$sigleCss .= '.essb_links.essb_share .essb_link_' . $k . ' a:hover, .essb_links.essb_share .essb_link_' . $k . ' a:focus { ';
					if ($network_hovercolor != '') {
						$sigleCss .= 'background-color:' . $network_hovercolor . '!important;';
					}
					if ($network_hovertextcolor != '') {
						$sigleCss .= 'color:' . $network_hovertextcolor . '!important;';
					}
					$sigleCss .= '}';
					
					if ($k == "more") {
						$sigleCss .= '.essb_links.essb_share .essb_link_less a:hover, .essb_links.essb_share .essb_link_less a:focus { ';
						if ($network_hovercolor != '') {
							$sigleCss .= 'background-color:' . $network_hovercolor . '!important;';
						}
						if ($network_hovertextcolor != '') {
							$sigleCss .= 'color:' . $network_hovertextcolor . '!important;';
						}
						$sigleCss .= '}';
					}
				}
				
				if ($network_icon != '') {
					$sigleCss .= '.essb_links .essb_link_' . $k . ' .essb_icon { background: url("' . $network_icon . '") !important; }';
					
					if ($network_iconbgsize != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' .essb_icon { background-size: ' . $network_iconbgsize . '!important; }';
					}
				}
				if ($network_hovericon != '') {
					$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover .essb_icon { background: url("' . $network_hovericon . '") !important; }';
					
					if ($network_hovericonbgsize != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover .essb_icon { background-size: ' . $network_hovericonbgsize . '!important; }';
					}
				}
				
				$snippet .= ($sigleCss);
			}
		
		}
		
		return $snippet;
	}
}