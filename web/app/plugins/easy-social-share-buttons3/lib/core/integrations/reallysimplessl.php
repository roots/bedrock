<?php

function essb_rsssl_fix_output($code) {

	$code = str_replace(
			'"facebook_post_recovery_url":"https:\/\/',
			'"facebook_post_recovery_url":"http:\/\/',
			$code);
	return $code;
}
add_filter("rsssl_fixer_output","essb_rsssl_fix_output");