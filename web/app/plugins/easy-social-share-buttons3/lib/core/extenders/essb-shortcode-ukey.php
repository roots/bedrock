<?php

if (!function_exists('essb_shortcode_ukey_options')) {
	function essb_shortcode_ukey_options($shortcode, $ukey) {
		essb_depend_load_class('ESSBShortcodeGenerator5', 'lib/admin/settings/essb-shortcode-generator5.php');
		
		$scg = new ESSBShortcodeGenerator5();
		$scg->activate($shortcode);
		$scg->get_stored_key($ukey);
		$scg->stored_values_loaded = true;
		
		return $scg->generate_as_options($scg->stored_shortcode_values);
	}
}