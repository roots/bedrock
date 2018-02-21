<?php
if (!function_exists('css_build_followerscounter_customizer')) {
	add_filter('essb_css_buffer_head', 'essb_rs_css_build_followerscounter_customizer');
	function essb_rs_css_build_followerscounter_customizer($buffer) {
		global $essb_options;
		
		$is_active = ESSBOptionValuesHelper::options_bool_value($essb_options, 'activate_fanscounter_customizer');
		if (!$is_active) {
			return $buffer;
		}
		
		$snippet = '';
		$network_list = ESSBSocialFollowersCounterHelper::available_social_networks();
		
		
		foreach ($network_list as $network => $title) {
			$color_isset = ESSBOptionValuesHelper::options_value($essb_options, 'fanscustomizer_'.$network);
			if ($color_isset == '' && $network == 'instagram') {
				$color_isset = essb_option_value('fanscustomizer_instgram');
			}
						
			if ($color_isset != '') {
				$snippet .= ('.essbfc-template-color .essbfc-icon-'.$network.', .essbfc-template-grey .essbfc-icon-'.$network.' { color: '.$color_isset.' !important; }');
				$snippet .= ('.essbfc-template-roundcolor .essbfc-icon-'.$network.', .essbfc-template-roundgrey .essbfc-icon-'.$network.' { background-color: '.$color_isset.' !important; } ');
				$snippet .= ('.essbfc-template-outlinecolor .essbfc-icon-'.$network.', .essbfc-template-outlinegrey .essbfc-icon-'.$network.'  { color: '.$color_isset.' !important; border-color: '.$color_isset.' !important; }');
				$snippet .= ('.essbfc-template-outlinecolor li:hover .essbfc-icon-'.$network.', .essbfc-template-outlinegrey li:hover .essbfc-icon-'.$network.' { background-color: '.$color_isset.' !important; }');
				$snippet .= ('.essbfc-template-metro .essbfc-'.$network.' .essbfc-network { background-color: '.$color_isset.' !important; }');
				$snippet .= ('.essbfc-template-flat .essbfc-'.$network.' .essbfc-network { background-color: '.$color_isset.' !important; }');
				$snippet .= ('.essbfc-template-dark .essbfc-'.$network.' .essbfc-network { background-color: '.$color_isset.' !important; }');
				$snippet .= ('.essbfc-template-modern .essbfc-'.$network.' .essbfc-network i { color: '.$color_isset.' !important; }');
				$snippet .= ('.essbfc-template-modern .essbfc-'.$network.' .essbfc-network { border-bottom: 3px solid '.$color_isset.' !important }');
				$snippet .= ('.essbfc-template-modern .essbfc-'.$network.':hover .essbfc-network { background-color: '.$color_isset.' !important }');
				
				if ($network == 'instgram') {
					$network1 = 'instagram';
					$snippet .= ('.essbfc-template-color .essbfc-icon-'.$network1.', .essbfc-template-grey .essbfc-icon-'.$network1.' { color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-roundcolor .essbfc-icon-'.$network1.', .essbfc-template-roundgrey .essbfc-icon-'.$network1.' { background-color: '.$color_isset.' !important; } ');
					$snippet .= ('.essbfc-template-outlinecolor .essbfc-icon-'.$network1.', .essbfc-template-outlinegrey .essbfc-icon-'.$network1.'  { color: '.$color_isset.' !important; border-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-outlinecolor li:hover .essbfc-icon-'.$network1.', .essbfc-template-outlinegrey li:hover .essbfc-icon-'.$network1.' { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-metro .essbfc-'.$network1.' .essbfc-network { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-flat .essbfc-'.$network1.' .essbfc-network { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-dark .essbfc-'.$network1.' .essbfc-network { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-modern .essbfc-'.$network1.' .essbfc-network i { color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-modern .essbfc-'.$network1.' .essbfc-network { border-bottom: 3px solid '.$color_isset.' !important }');
					$snippet .= ('.essbfc-template-modern .essbfc-'.$network1.':hover .essbfc-network { background-color: '.$color_isset.' !important }');
				}
				
				if ($network == 'instagram') {
					$network = 'instgram';
					$snippet .= ('.essbfc-template-color .essbfc-icon-'.$network.', .essbfc-template-grey .essbfc-icon-'.$network.' { color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-roundcolor .essbfc-icon-'.$network.', .essbfc-template-roundgrey .essbfc-icon-'.$network.' { background-color: '.$color_isset.' !important; } ');
					$snippet .= ('.essbfc-template-outlinecolor .essbfc-icon-'.$network.', .essbfc-template-outlinegrey .essbfc-icon-'.$network.'  { color: '.$color_isset.' !important; border-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-outlinecolor li:hover .essbfc-icon-'.$network.', .essbfc-template-outlinegrey li:hover .essbfc-icon-'.$network.' { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-metro .essbfc-'.$network.' .essbfc-network { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-flat .essbfc-'.$network.' .essbfc-network { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-dark .essbfc-'.$network.' .essbfc-network { background-color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-modern .essbfc-'.$network.' .essbfc-network i { color: '.$color_isset.' !important; }');
					$snippet .= ('.essbfc-template-modern .essbfc-'.$network.' .essbfc-network { border-bottom: 3px solid '.$color_isset.' !important }');
					$snippet .= ('.essbfc-template-modern .essbfc-'.$network.':hover .essbfc-network { background-color: '.$color_isset.' !important }');
				}
			}
		}
		return $buffer.$snippet;
	}
}