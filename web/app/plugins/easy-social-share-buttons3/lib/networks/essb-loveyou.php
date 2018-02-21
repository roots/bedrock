<?php
/**
 * Love This button
 *
 * @since 5.0
 *
 * @package EasySocialShareButtons
 * @author  appscreo <http://codecanyon.net/user/appscreo/portfolio>
 */

add_filter('essb_js_buffer_footer', 'essb_js_build_lovethis_code');

function essb_js_build_lovethis_code($buffer) {
	// localization of messages;
	$message_loved = essb_option_value('translate_love_loved');
	$message_thanks = essb_option_value('translate_love_thanks');

	if ($message_loved == "") {
		$message_loved = __("You already love this today.", 'essb');
	}
	if ($message_thanks == "") {
		$message_thanks = __("Thank you for loving this.", 'essb');
	}


	$script = '
	var essb_clicked_lovethis = false;
	var essb_love_you_message_thanks = "'.$message_thanks.'";
	var essb_love_you_message_loved = "'.$message_loved.'";';

	$script = trim(preg_replace('/\s+/', ' ', $script));
	return $buffer.$script;

}
