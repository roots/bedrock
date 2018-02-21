<?php
if (! function_exists ( 'essb_rs_css_build_customizer_mailchimp' )) {
	function essb_rs_css_build_customizer_mailchimp($active_customizers) {
		global $essb_options;
		
		$snippet = '';
		
		if ($active_customizers['design1']) {
			$global_bgcolor = isset ( $essb_options ['customizer_subscribe_bgcolor1'] ) ? $essb_options ['customizer_subscribe_bgcolor1'] : '';
			$global_textcolor = isset ( $essb_options ['customizer_subscribe_textcolor1'] ) ? $essb_options ['customizer_subscribe_textcolor1'] : '';
			$global_hovercolor = isset ( $essb_options ['customizer_subscribe_hovercolor1'] ) ? $essb_options ['customizer_subscribe_hovercolor1'] : '';
			$global_hovertextcolor = isset ( $essb_options ['customizer_subscribe_hovertextcolor1'] ) ? $essb_options ['customizer_subscribe_hovertextcolor1'] : '';
			$customizer_subscribe_emailcolor = isset($essb_options['customizer_subscribe_emailcolor1']) ? $essb_options['customizer_subscribe_emailcolor1'] : '';
			$customizer_subscribe_noborder = isset($essb_options['customizer_subscribe_noborder1']) ? $essb_options['customizer_subscribe_noborder1'] : '';
			
			
			if ($global_bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 { background-color: ' . $global_bgcolor . '!important;}';
			}
			if ($global_textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 { color: ' . $global_textcolor . '!important;}';
			}
			
			if ($global_hovercolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 { border-top: 3px solid ' . $global_hovercolor . '!important; }';
				$snippet .= '.essb-subscribe-from-design1 .essb-subscribe-form-content-title:after { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 input.submit { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 input.submit:hover { background: ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor)) . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 input.submit { border-bottom: 3px solid ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor, 50, -50)) . '!important;}';
				$snippet .= '.essb-subscribe-from-design1 .essb-subscribe-loader svg path, .essb-subscribe-from-design1 .essb-subscribe-loader svg rect { fill: ' . $global_hovercolor . '!important; }';
			}
			
			if ($global_hovertextcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 input.submit, .essb-subscribe-form-content.essb-subscribe-from-design1 input.submit:hover { color: ' . $global_hovertextcolor . '!important;}';
			}
			
			if ($customizer_subscribe_emailcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 input.essb-subscribe-form-content-email-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 .essb-subscribe-form-content-email-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 input.essb-subscribe-form-content-name-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 .essb-subscribe-form-content-name-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
			}
			
			if ($customizer_subscribe_noborder == 'true') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design1 { border: 0px solid ' . $global_hovercolor . '!important; }';
					
			}
		}
		
		if ($active_customizers['design2']) {
			$global_bgcolor = isset ( $essb_options ['customizer_subscribe_bgcolor2'] ) ? $essb_options ['customizer_subscribe_bgcolor2'] : '';
			$global_textcolor = isset ( $essb_options ['customizer_subscribe_textcolor2'] ) ? $essb_options ['customizer_subscribe_textcolor2'] : '';
			$global_hovercolor = isset ( $essb_options ['customizer_subscribe_hovercolor2'] ) ? $essb_options ['customizer_subscribe_hovercolor2'] : '';
			$global_hovertextcolor = isset ( $essb_options ['customizer_subscribe_hovertextcolor2'] ) ? $essb_options ['customizer_subscribe_hovertextcolor2'] : '';
			$customizer_subscribe_emailcolor = isset($essb_options['customizer_subscribe_emailcolor2']) ? $essb_options['customizer_subscribe_emailcolor2'] : '';
			$customizer_subscribe_noborder = isset($essb_options['customizer_subscribe_noborder2']) ? $essb_options['customizer_subscribe_noborder2'] : '';
								
			if ($global_bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 { background-color: ' . $global_bgcolor . '!important;}';
			}
			if ($global_textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 { color: ' . $global_textcolor . '!important;}';
			}
				
			if ($global_hovercolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 { border: 1px solid ' . $global_hovercolor . '!important; }';
				$snippet .= '.essb-subscribe-from-design2 .essb-subscribe-form-content-title:after { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 input.submit { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 input.submit:hover { background: ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor)) . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 input.submit { border-bottom: 3px solid ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor, 50, -50)) . '!important;}';
				$snippet .= '.essb-subscribe-from-design2 .essb-subscribe-loader svg path, .essb-subscribe-from-design2 .essb-subscribe-loader svg rect { fill: ' . $global_hovercolor . '!important; }';
			}
				
			if ($global_hovertextcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 input.submit, .essb-subscribe-form-content.essb-subscribe-from-design2 input.submit:hover { color: ' . $global_hovertextcolor . '!important;}';
			}
				
			if ($customizer_subscribe_emailcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 input.essb-subscribe-form-content-email-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 .essb-subscribe-form-content-email-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 input.essb-subscribe-form-content-name-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 .essb-subscribe-form-content-name-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
			}
				
			if ($customizer_subscribe_noborder == 'true') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design2 { border: 0px solid ' . $global_hovercolor . '!important; }';
					
			}
		}

		if ($active_customizers['design3']) {
			$global_bgcolor = isset ( $essb_options ['customizer_subscribe_bgcolor3'] ) ? $essb_options ['customizer_subscribe_bgcolor3'] : '';
			$global_textcolor = isset ( $essb_options ['customizer_subscribe_textcolor3'] ) ? $essb_options ['customizer_subscribe_textcolor3'] : '';
			$global_bgcolor_bottom = isset ( $essb_options ['customizer_subscribe_bgcolor3_bottom'] ) ? $essb_options ['customizer_subscribe_bgcolor3_bottom'] : '';
			$global_textcolor_bottom = isset ( $essb_options ['customizer_subscribe_textcolor3_bottom'] ) ? $essb_options ['customizer_subscribe_textcolor3_bottom'] : '';
			$global_hovercolor = isset ( $essb_options ['customizer_subscribe_hovercolor3'] ) ? $essb_options ['customizer_subscribe_hovercolor3'] : '';
			$global_hovertextcolor = isset ( $essb_options ['customizer_subscribe_hovertextcolor3'] ) ? $essb_options ['customizer_subscribe_hovertextcolor3'] : '';
			$customizer_subscribe_emailcolor = isset($essb_options['customizer_subscribe_emailcolor3']) ? $essb_options['customizer_subscribe_emailcolor3'] : '';
			$customizer_subscribe_noborder = isset($essb_options['customizer_subscribe_noborder3']) ? $essb_options['customizer_subscribe_noborder3'] : '';
		
			if ($global_bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 .essb-subscribe-form-content-top { background-color: ' . $global_bgcolor . '!important;}';
			}
			if ($global_textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 .essb-subscribe-form-content-top { color: ' . $global_textcolor . '!important;}';
			}

			if ($global_bgcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 .essb-subscribe-form-content-bottom { background-color: ' . $global_bgcolor_bottom . '!important;}';
			}
			if ($global_textcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 .essb-subscribe-form-content-bottom { color: ' . $global_textcolor_bottom . '!important;}';
			}
				
			if ($global_hovercolor != '') {
				$snippet .= '.essb-subscribe-from-design3 .essb-subscribe-form-content-title:after { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 input.submit { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 input.submit:hover { background: ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor)) . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 input.submit { border-bottom: 3px solid ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor, 50, -50)) . '!important;}';
				$snippet .= '.essb-subscribe-from-design3 .essb-subscribe-loader svg path, .essb-subscribe-from-design3 .essb-subscribe-loader svg rect { fill: ' . $global_hovercolor . '!important; }';
			}
		
			if ($global_hovertextcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 input.submit, .essb-subscribe-form-content.essb-subscribe-from-design3 input.submit:hover { color: ' . $global_hovertextcolor . '!important;}';
			}
		
			if ($customizer_subscribe_emailcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 input.essb-subscribe-form-content-email-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 .essb-subscribe-form-content-email-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 input.essb-subscribe-form-content-name-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 .essb-subscribe-form-content-name-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
			}
		
			if ($customizer_subscribe_noborder == 'true') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design3 { border: 0px solid ' . $global_hovercolor . '!important; }';
					
			}
		}

		if ($active_customizers['design4']) {
			$global_bgcolor = isset ( $essb_options ['customizer_subscribe_bgcolor4'] ) ? $essb_options ['customizer_subscribe_bgcolor4'] : '';
			$global_textcolor = isset ( $essb_options ['customizer_subscribe_textcolor4'] ) ? $essb_options ['customizer_subscribe_textcolor4'] : '';
			$global_bgcolor_bottom = isset ( $essb_options ['customizer_subscribe_bgcolor4_bottom'] ) ? $essb_options ['customizer_subscribe_bgcolor4_bottom'] : '';
			$global_textcolor_bottom = isset ( $essb_options ['customizer_subscribe_textcolor4_bottom'] ) ? $essb_options ['customizer_subscribe_textcolor4_bottom'] : '';
			$global_hovercolor = isset ( $essb_options ['customizer_subscribe_hovercolor4'] ) ? $essb_options ['customizer_subscribe_hovercolor4'] : '';
			$global_hovertextcolor = isset ( $essb_options ['customizer_subscribe_hovertextcolor4'] ) ? $essb_options ['customizer_subscribe_hovertextcolor4'] : '';
			$customizer_subscribe_emailcolor = isset($essb_options['customizer_subscribe_emailcolor4']) ? $essb_options['customizer_subscribe_emailcolor4'] : '';
			$customizer_subscribe_noborder = isset($essb_options['customizer_subscribe_noborder4']) ? $essb_options['customizer_subscribe_noborder4'] : '';
		
			if ($global_bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 .essb-subscribe-form-content-contentholder { background-color: ' . $global_bgcolor . '!important;}';
			}
			if ($global_textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 .essb-subscribe-form-content-contentholder { color: ' . $global_textcolor . '!important;}';
			}
		
			if ($global_bgcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 .essb-subscribe-form-content-subscribeholder { background-color: ' . $global_bgcolor_bottom . '!important;}';
			}
			if ($global_textcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 .essb-subscribe-form-content-subscribeholder { color: ' . $global_textcolor_bottom . '!important;}';
			}
		
			if ($global_hovercolor != '') {
				$snippet .= '.essb-subscribe-from-design4 .essb-subscribe-form-content-title:after { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 input.submit { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 input.submit:hover { background: ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor)) . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 input.submit { border-bottom: 3px solid ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor, 50, -50)) . '!important;}';
				$snippet .= '.essb-subscribe-from-design4 .essb-subscribe-loader svg path, .essb-subscribe-from-design4 .essb-subscribe-loader svg rect { fill: ' . $global_hovercolor . '!important; }';
			}
		
			if ($global_hovertextcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 input.submit, .essb-subscribe-form-content.essb-subscribe-from-design4 input.submit:hover { color: ' . $global_hovertextcolor . '!important;}';
			}
		
			if ($customizer_subscribe_emailcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 input.essb-subscribe-form-content-email-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 .essb-subscribe-form-content-email-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 input.essb-subscribe-form-content-name-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 .essb-subscribe-form-content-name-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
			}
		
			if ($customizer_subscribe_noborder == 'true') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design4 { border: 0px solid ' . $global_hovercolor . '!important; }';
					
			}
		}

		if ($active_customizers['design5']) {
			$global_bgcolor = isset ( $essb_options ['customizer_subscribe_bgcolor5'] ) ? $essb_options ['customizer_subscribe_bgcolor5'] : '';
			$global_textcolor = isset ( $essb_options ['customizer_subscribe_textcolor5'] ) ? $essb_options ['customizer_subscribe_textcolor5'] : '';
			$global_bgcolor_bottom = isset ( $essb_options ['customizer_subscribe_bgcolor5_bottom'] ) ? $essb_options ['customizer_subscribe_bgcolor5_bottom'] : '';
			$global_textcolor_bottom = isset ( $essb_options ['customizer_subscribe_textcolor5_bottom'] ) ? $essb_options ['customizer_subscribe_textcolor5_bottom'] : '';
			$global_hovercolor = isset ( $essb_options ['customizer_subscribe_hovercolor5'] ) ? $essb_options ['customizer_subscribe_hovercolor5'] : '';
			$global_hovertextcolor = isset ( $essb_options ['customizer_subscribe_hovertextcolor5'] ) ? $essb_options ['customizer_subscribe_hovertextcolor5'] : '';
			$customizer_subscribe_emailcolor = isset($essb_options['customizer_subscribe_emailcolor5']) ? $essb_options['customizer_subscribe_emailcolor5'] : '';
			$customizer_subscribe_noborder = isset($essb_options['customizer_subscribe_noborder5']) ? $essb_options['customizer_subscribe_noborder5'] : '';
		
			if ($global_bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 .essb-subscribe-form-content-contentholder { background-color: ' . $global_bgcolor . '!important;}';
			}
			if ($global_textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 .essb-subscribe-form-content-contentholder { color: ' . $global_textcolor . '!important;}';
			}
		
			if ($global_bgcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 .essb-subscribe-form-content-subscribeholder { background-color: ' . $global_bgcolor_bottom . '!important;}';
			}
			if ($global_textcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 .essb-subscribe-form-content-subscribeholder { color: ' . $global_textcolor_bottom . '!important;}';
			}
		
			if ($global_hovercolor != '') {
				$snippet .= '.essb-subscribe-from-design5 .essb-subscribe-form-content-title:after { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 input.submit { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 input.submit:hover { background: ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor)) . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 input.submit { border-bottom: 3px solid ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor, 50, -50)) . '!important;}';
				$snippet .= '.essb-subscribe-from-design5 .essb-subscribe-loader svg path, .essb-subscribe-from-design5 .essb-subscribe-loader svg rect { fill: ' . $global_hovercolor . '!important; }';
			}
		
			if ($global_hovertextcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 input.submit, .essb-subscribe-form-content.essb-subscribe-from-design5 input.submit:hover { color: ' . $global_hovertextcolor . '!important;}';
			}
		
			if ($customizer_subscribe_emailcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 input.essb-subscribe-form-content-email-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 .essb-subscribe-form-content-email-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 input.essb-subscribe-form-content-name-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 150, -150)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 .essb-subscribe-form-content-name-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 50, -50)).'!important;}';
			}
		
			if ($customizer_subscribe_noborder == 'true') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design5 { border: 0px solid ' . $global_hovercolor . '!important; }';
					
			}
		}

		if ($active_customizers['design6']) {
			$global_bgcolor = isset ( $essb_options ['customizer_subscribe_bgcolor6'] ) ? $essb_options ['customizer_subscribe_bgcolor6'] : '';
			$global_textcolor = isset ( $essb_options ['customizer_subscribe_textcolor6'] ) ? $essb_options ['customizer_subscribe_textcolor6'] : '';
			$global_bgcolor_bottom = isset ( $essb_options ['customizer_subscribe_bgcolor6_bottom'] ) ? $essb_options ['customizer_subscribe_bgcolor6_bottom'] : '';
			$global_textcolor_bottom = isset ( $essb_options ['customizer_subscribe_textcolor6_bottom'] ) ? $essb_options ['customizer_subscribe_textcolor6_bottom'] : '';
			$global_hovercolor = isset ( $essb_options ['customizer_subscribe_hovercolor6'] ) ? $essb_options ['customizer_subscribe_hovercolor6'] : '';
			$global_hovertextcolor = isset ( $essb_options ['customizer_subscribe_hovertextcolor6'] ) ? $essb_options ['customizer_subscribe_hovertextcolor6'] : '';
			$customizer_subscribe_emailcolor = isset($essb_options['customizer_subscribe_emailcolor6']) ? $essb_options['customizer_subscribe_emailcolor6'] : '';
			$customizer_subscribe_noborder = isset($essb_options['customizer_subscribe_noborder6']) ? $essb_options['customizer_subscribe_noborder6'] : '';
		
			if ($global_bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 .essb-subscribe-form-content-contentholder { background-color: ' . $global_bgcolor . '!important;}';
			}
			if ($global_textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 .essb-subscribe-form-content-contentholder { color: ' . $global_textcolor . '!important;}';
			}
		
			if ($global_bgcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 .essb-subscribe-form-content-subscribeholder { background-color: ' . $global_bgcolor_bottom . '!important;}';
			}
			if ($global_textcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 .essb-subscribe-form-content-subscribeholder { color: ' . $global_textcolor_bottom . '!important;}';
			}
		
			if ($global_hovercolor != '') {
				$snippet .= '.essb-subscribe-from-design6 .essb-subscribe-form-content-title:after { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 input.submit { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 input.submit:hover { background: ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor)) . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 input.submit { border-bottom: 3px solid ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor, 60, -60)) . '!important;}';
				$snippet .= '.essb-subscribe-from-design6 .essb-subscribe-loader svg path, .essb-subscribe-from-design6 .essb-subscribe-loader svg rect { fill: ' . $global_hovercolor . '!important; }';
			}
		
			if ($global_hovertextcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 input.submit, .essb-subscribe-form-content.essb-subscribe-from-design6 input.submit:hover { color: ' . $global_hovertextcolor . '!important;}';
			}
		
			if ($customizer_subscribe_emailcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 input.essb-subscribe-form-content-email-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 160, -160)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 .essb-subscribe-form-content-email-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 60, -60)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 input.essb-subscribe-form-content-name-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 160, -160)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 .essb-subscribe-form-content-name-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 60, -60)).'!important;}';
			}
		
			if ($customizer_subscribe_noborder == 'true') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design6 { border: 0px solid ' . $global_hovercolor . '!important; }';
					
			}
		}

		if ($active_customizers['design7']) {
			$global_bgcolor = isset ( $essb_options ['customizer_subscribe_bgcolor7'] ) ? $essb_options ['customizer_subscribe_bgcolor7'] : '';
			$global_textcolor = isset ( $essb_options ['customizer_subscribe_textcolor7'] ) ? $essb_options ['customizer_subscribe_textcolor7'] : '';
			$global_bgcolor_bottom = isset ( $essb_options ['customizer_subscribe_bgcolor7_bottom'] ) ? $essb_options ['customizer_subscribe_bgcolor7_bottom'] : '';
			$global_textcolor_bottom = isset ( $essb_options ['customizer_subscribe_textcolor7_bottom'] ) ? $essb_options ['customizer_subscribe_textcolor7_bottom'] : '';
			$global_hovercolor = isset ( $essb_options ['customizer_subscribe_hovercolor7'] ) ? $essb_options ['customizer_subscribe_hovercolor7'] : '';
			$global_hovertextcolor = isset ( $essb_options ['customizer_subscribe_hovertextcolor7'] ) ? $essb_options ['customizer_subscribe_hovertextcolor7'] : '';
			$customizer_subscribe_emailcolor = isset($essb_options['customizer_subscribe_emailcolor7']) ? $essb_options['customizer_subscribe_emailcolor7'] : '';
			$customizer_subscribe_noborder = isset($essb_options['customizer_subscribe_noborder7']) ? $essb_options['customizer_subscribe_noborder7'] : '';
		
			if ($global_bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 .essb-subscribe-form-content-contentholder { background-color: ' . $global_bgcolor . '!important;}';
			}
			if ($global_textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 .essb-subscribe-form-content-contentholder { color: ' . $global_textcolor . '!important;}';
			}
		
			if ($global_bgcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 .essb-subscribe-form-content-subscribeholder { background-color: ' . $global_bgcolor_bottom . '!important;}';
			}
			if ($global_textcolor_bottom != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 .essb-subscribe-form-content-subscribeholder { color: ' . $global_textcolor_bottom . '!important;}';
			}
		
			if ($global_hovercolor != '') {
				$snippet .= '.essb-subscribe-from-design7 .essb-subscribe-form-content-title:after { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 input.submit { background: ' . $global_hovercolor . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 input.submit:hover { background: ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor)) . '!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 input.submit { border-bottom: 3px solid ' . essb_rs_adjust_brightness($global_hovercolor, essb_rs_light_or_dark($global_hovercolor, 70, -70)) . '!important;}';
				$snippet .= '.essb-subscribe-from-design7 .essb-subscribe-loader svg path, .essb-subscribe-from-design7 .essb-subscribe-loader svg rect { fill: ' . $global_hovercolor . '!important; }';
			}
		
			if ($global_hovertextcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 input.submit, .essb-subscribe-form-content.essb-subscribe-from-design7 input.submit:hover { color: ' . $global_hovertextcolor . '!important;}';
			}
		
			if ($customizer_subscribe_emailcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 input.essb-subscribe-form-content-email-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 170, -170)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 .essb-subscribe-form-content-email-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 70, -70)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 input.essb-subscribe-form-content-name-field { background: '.$customizer_subscribe_emailcolor.'!important; color: '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 170, -170)).'!important;}';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 .essb-subscribe-form-content-name-field:focus { border-bottom: 3px solid '.essb_rs_adjust_brightness($customizer_subscribe_emailcolor, essb_rs_light_or_dark($customizer_subscribe_emailcolor, 70, -70)).'!important;}';
			}
		
			if ($customizer_subscribe_noborder == 'true') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design7 { border: 0px solid ' . $global_hovercolor . '!important; }';
					
			}
		}
		
		if ($active_customizers['design8']) {
			$bg_color1 = essb_option_value('customizer_subscribe_bgcolor8');
			$bg_color2 = essb_option_value('customizer_subscribe_bgcolor28');
			
			if ($bg_color1 != '' && $bg_color2 != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design8
				{
				background: '.$bg_color1.' !important;
background: -moz-linear-gradient(top, '.$bg_color1.' 0%, '.$bg_color2.' 100%) !important; 
background: -webkit-linear-gradient(top, '.$bg_color1.' 0%,'.$bg_color2.' 100%) !important;
background: linear-gradient(to bottom, '.$bg_color1.' 0%,'.$bg_color2.' 100%) !important; 
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\''.$bg_color1.'\', endColorstr=\''.$bg_color2.'\',GradientType=0 ) !important; 
				}';
			}
			
			$text_color = essb_option_value('customizer_subscribe_textcolor8');
			if ($text_color != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design8 h4, .essb-subscribe-form-content.essb-subscribe-from-design8 p { color: '.$text_color.'!important; }';
			}
			
			$bg_color_bottom = essb_option_value('customizer_subscribe_bgcolor8_bottom');
			if ($bg_color_bottom != '') {
				$snippet .= ' .essb-subscribe-form-content.essb-subscribe-from-design8 input.essb-subscribe-form-content-email-field,
.essb-subscribe-form-content.essb-subscribe-from-design8 input.essb-subscribe-form-content-name-field { background: '.$bg_color_bottom.'!important; }';
			}
			
			$text_color_bottom = essb_option_value('customizer_subscribe_textcolor8_bottom');
			if ($text_color_bottom != '') {
				$snippet .= ' .essb-subscribe-form-content.essb-subscribe-from-design8 input.essb-subscribe-form-content-email-field,
				.essb-subscribe-form-content.essb-subscribe-from-design8 input.essb-subscribe-form-content-name-field { color: '.$text_color_bottom.'!important; }';
			}
			
			$button_bg_color = essb_option_value('customizer_subscribe_buttoncolor8');
			if ($button_bg_color != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design8 input.submit { background: '.$button_bg_color.'!important; }';
				$button_bg_hover = essb_rs_adjust_brightness($button_bg_color, essb_rs_light_or_dark($button_bg_color));
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design8 input.submit:hover { background: '.$button_bg_hover.'!important; }';
			}
			$button_text_color = essb_option_value('customizer_subscribe_buttontextcolor8');
			if ($button_text_color != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design8 input.submit { color: '.$button_text_color.'!important; }';
			}
		}		
		
		if ($active_customizers['design9']) {
			$bgcolor = essb_option_value('customizer_subscribe_bgcolor9');
			$textcolor = essb_option_value('customizer_subscribe_textcolor9');
			$accentcolor = essb_option_value('customizer_subscribe_accent9');
			$buttoncolor = essb_option_value('customizer_subscribe_button9');
			
			if ($bgcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design9 { background-color: '.$bgcolor.' !important;}';				
			}
			if ($textcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design9, .essb-subscribe-form-content.essb-subscribe-from-design9 h4,
				.essb-subscribe-form-content.essb-subscribe-from-design9 input.essb-subscribe-form-content-email-field,
.essb-subscribe-form-content.essb-subscribe-from-design9 input.essb-subscribe-form-content-name-field { color: '.$textcolor.' !important;}';
			}
			
			if ($buttoncolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design9 input.submit { color: '.$buttoncolor.'!important; }';
			}
			
			if ($accentcolor != '') {
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design9 input.submit { background-color: '.$accentcolor.'!important; }';
				$snippet .= '.essb-subscribe-form-content.essb-subscribe-from-design9 input.submit:hover { background: ' . essb_rs_adjust_brightness($accentcolor, essb_rs_light_or_dark($accentcolor)) . '!important;}';
				$snippet .= '.essb-subscribe9-icon { color: '.$accentcolor.'!important; }';
			}
		}
		
		return $snippet;
	}
	
	function essb_rs_adjust_brightness($hex, $steps) {
		// Steps should be between -255 and 255. Negative = darker, positive =
		// lighter
		$steps = max ( - 255, min ( 255, $steps ) );
		
		// Normalize into a six character long hex string
		$hex = str_replace ( '#', '', $hex );
		if (strlen ( $hex ) == 3) {
			$hex = str_repeat ( substr ( $hex, 0, 1 ), 2 ) . str_repeat ( substr ( $hex, 1, 1 ), 2 ) . str_repeat ( substr ( $hex, 2, 1 ), 2 );
		}
		
		// Split into three parts: R, G and B
		$color_parts = str_split ( $hex, 2 );
		$return = '#';
		
		foreach ( $color_parts as $color ) {
			$color = hexdec ( $color ); // Convert to decimal
			$color = max ( 0, min ( 255, $color + $steps ) ); // Adjust color
			$return .= str_pad ( dechex ( $color ), 2, '0', STR_PAD_LEFT ); // Make two
			                                                          // char hex code
		}
		
		return $return;
	}
	
	function essb_rs_light_or_dark($color, $steps_light = 30, $steps_dark = -30) {
		$hex = str_replace( '#', '', $color );
		
		$c_r = hexdec( substr( $hex, 0, 2 ) );
		$c_g = hexdec( substr( $hex, 2, 2 ) );
		$c_b = hexdec( substr( $hex, 4, 2 ) );
		
		$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;
		
		return $brightness > 155 ? $steps_dark : $steps_light;
	}
}