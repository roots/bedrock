<?php
if (!function_exists('essb_available_more_button_commands')) {
	function essb_available_more_button_commands($add_default = false) {
		$commands = array ();
		if ($add_default) {
			$commands[''] = __('Default value from settings', 'essb');
		}
		$commands['1'] = __('Display all active networks after more button', 'essb');
		$commands['2'] = __('Display all social networks as pop up', 'essb');
		$commands['3'] = __('Display only active social networks as pop up', 'essb');
		$commands['4'] = __('Inline pop of all active networks after more button (icon style)', 'essb');
		$commands['5'] = __('Inline pop of all active networks after more button (button style)', 'essb');

		return $commands;
	}
}

if (!function_exists('essb_avaliable_counter_positions_point')) {
	function essb_avaliable_counter_positions_point() {
		$essb_avaliable_counter_positions = array ();
		$essb_avaliable_counter_positions ['inside'] = 'Inside button instead of network name';
		$essb_avaliable_counter_positions ['insidename'] = 'Inside button after network name';
		$essb_avaliable_counter_positions ['insidebeforename'] = 'Inside button before network name';
		$essb_avaliable_counter_positions ['topm'] = 'Top Mini';
		$essb_avaliable_counter_positions ['bottom'] = 'Bottom';
		$essb_avaliable_counter_positions ['topn'] = 'Top';

		return $essb_avaliable_counter_positions;
	}
}


if (!function_exists('essb_avaliable_counter_positions_mobile')) {
	function essb_avaliable_counter_positions_mobile() {
		$essb_avaliable_counter_positions_mobile = array ();
		$essb_avaliable_counter_positions_mobile ['inside'] = 'Inside button instead of network name';
		$essb_avaliable_counter_positions_mobile ['insidename'] = 'Inside button after network name';
		$essb_avaliable_counter_positions_mobile ['insidebeforename'] = 'Inside button before network name';
		$essb_avaliable_counter_positions_mobile ['insidehover'] = 'Inside button and appear when you hover button over the network name';
		$essb_avaliable_counter_positions_mobile ['hidden'] = 'Hidden (use this position if you wish to have only total counter)';

		return $essb_avaliable_counter_positions_mobile;
	}
}


if (!function_exists('essb_avaiable_total_counter_position_mobile')) {
	function essb_avaiable_total_counter_position_mobile() {
		$essb_avaiable_total_counter_position_mobile = array ();
		$essb_avaiable_total_counter_position_mobile ['before'] = 'Before social share buttons';
		$essb_avaiable_total_counter_position_mobile ['after'] = 'After social share buttons';
		$essb_avaiable_total_counter_position_mobile ['hidden'] = 'This will hide the total counter and make only button counters be visible';

		return $essb_avaiable_total_counter_position_mobile;
	}
}

if (!function_exists('essb_avaiable_button_style_with_recommend')) {
	function essb_avaiable_button_style_with_recommend() {
		$essb_avaiable_button_style = array ();
		$essb_avaiable_button_style ['recommended'] = 'Recommended style for selected display method';
		$essb_avaiable_button_style ['button'] = 'Display as share button with icon and network name';
		$essb_avaiable_button_style ['button_name'] = 'Display as share button with network name and without icon';
		$essb_avaiable_button_style ['icon'] = 'Display share buttons only as icon without network names';
		$essb_avaiable_button_style ['icon_hover'] = 'Display share buttons as icon with network name appear when button is pointed';

		return $essb_avaiable_button_style;
	}
}

if (!function_exists('essb_simplified_radio_check_list')) {
	function essb_simplified_radio_check_list($list, $include_blank = false, $blank_text = '') {
		$result = array();

		if ($include_blank) {
			$result[''] = $blank_text;
		}

		foreach ($list as $key => $data) {
			$result[$key] = $data['label'];
		}

		return $result;
	}
}

if (!function_exists('essb_avaliable_content_positions_light')) {
	function essb_avaliable_content_positions_light() {
		$essb_avaliable_content_positions = array ();
		$essb_avaliable_content_positions ['content_top'] = array ('image' => 'assets/images/display-positions-02.png', 'label' => 'Content top' );
		$essb_avaliable_content_positions ['content_bottom'] = array ('image' => 'assets/images/display-positions-03.png', 'label' => 'Content bottom' );
		$essb_avaliable_content_positions ['content_both'] = array ('image' => 'assets/images/display-positions-04.png', 'label' => 'Content top and bottom' );
		$essb_avaliable_content_positions ['content_float'] = array ('image' => 'assets/images/display-positions-05.png', 'label' => 'Float from content top' );
		$essb_avaliable_content_positions ['content_floatboth'] = array ('image' => 'assets/images/display-positions-06.png', 'label' => 'Float from content top and bottom' );
		$essb_avaliable_content_positions ['content_manual'] = array ('image' => 'assets/images/display-positions-09.png', 'label' => 'Manual display with shortcode only' );

		return $essb_avaliable_content_positions;
	}
}

if (!function_exists('essb_avaliable_content_positions_mobile')) {
	function essb_avaliable_content_positions_mobile() {
		$essb_avaliable_content_positions_mobile = array ();
		$essb_avaliable_content_positions_mobile ['content_top'] = array ('image' => 'assets/images/display-positions-02.png', 'label' => 'Content top' );
		$essb_avaliable_content_positions_mobile ['content_bottom'] = array ('image' => 'assets/images/display-positions-03.png', 'label' => 'Content bottom' );
		$essb_avaliable_content_positions_mobile ['content_both'] = array ('image' => 'assets/images/display-positions-04.png', 'label' => 'Content top and bottom' );
		if (!essb_options_bool_value('deactivate_method_float')) {
			$essb_avaliable_content_positions_mobile ['content_float'] = array ('image' => 'assets/images/display-positions-05.png', 'label' => 'Float from content top' );
		}
		$essb_avaliable_content_positions_mobile ['content_manual'] = array ('image' => 'assets/images/display-positions-09.png', 'label' => 'Manual display with shortcode only' );

		if (has_filter('essb4_content_positions_mobile')) {
			$essb_avaliable_content_positions_mobile = apply_filters('essb4_content_positions_mobile', $essb_avaliable_content_positions_mobile);
		}

		return $essb_avaliable_content_positions_mobile;
	}
}

if (!function_exists('essb_avaliable_content_positions_amp')) {
	function essb_avaliable_content_positions_amp() {
		$essb_avaliable_content_positions_mobile = array ();
		$essb_avaliable_content_positions_mobile ['content_top'] = array ('image' => 'assets/images/display-positions-02.png', 'label' => 'Content top' );
		$essb_avaliable_content_positions_mobile ['content_bottom'] = array ('image' => 'assets/images/display-positions-03.png', 'label' => 'Content bottom' );
		$essb_avaliable_content_positions_mobile ['content_both'] = array ('image' => 'assets/images/display-positions-04.png', 'label' => 'Content top and bottom' );

		return $essb_avaliable_content_positions_mobile;
	}
}

if (!function_exists('essb_available_button_positions_light')) {
	function essb_available_button_positions_light() {
		$essb_available_button_positions = array ();
		$essb_available_button_positions ['sidebar'] = array ('image' => 'assets/images/display-positions-10.png', 'label' => 'Sidebar' );
		$essb_available_button_positions ['popup'] = array ('image' => 'assets/images/display-positions-11.png', 'label' => 'Pop up' );
		$essb_available_button_positions ['flyin'] = array ('image' => 'assets/images/display-positions-12.png', 'label' => 'Fly in' );
		$essb_available_button_positions ['postfloat'] = array ('image' => 'assets/images/display-positions-13.png', 'label' => 'Post vertical float' );
		$essb_available_button_positions ['topbar'] = array ('image' => 'assets/images/display-positions-14.png', 'label' => 'Top bar' );
		$essb_available_button_positions ['bottombar'] = array ('image' => 'assets/images/display-positions-15.png', 'label' => 'Bottom bar' );
		$essb_available_button_positions ['onmedia'] = array ('image' => 'assets/images/display-positions-16.png', 'label' => 'On media' );

		return $essb_available_button_positions;
	}
}

if (!function_exists('essb_available_buttons_align')) {
	function essb_available_buttons_align() {
		$essb_available_buttons_align = array();
		$essb_available_buttons_align [''] = array ('image' => 'assets/images/button-align-01.png', 'label' => '<b>Left</b>' );
		$essb_available_buttons_align ['center'] = array ('image' => 'assets/images/button-align-03.png', 'label' => '<b>Center</b>' );
		$essb_available_buttons_align ['right'] = array ('image' => 'assets/images/button-align-02.png', 'label' => '<b>Right</b>' );

		return $essb_available_buttons_align;
	}
}


if (!function_exists('essb_available_buttons_style')) {
	function essb_available_buttons_style() {
		$essb_available_buttons_style = array();
		$essb_available_buttons_style ['button'] = array ('image' => 'assets/images/button-style-01.png', 'label' => '<b>Display as share button with icon and network name</b>' );
		$essb_available_buttons_style ['button_name'] = array ('image' => 'assets/images/button-style-04.png', 'label' => '<b>Display as share button with network name and without icon</b>' );
		$essb_available_buttons_style ['icon'] = array ('image' => 'assets/images/button-style-02.png', 'label' => '<b>Display share buttons only as icon without network names</b>' );
		$essb_available_buttons_style ['icon_hover'] = array ('image' => 'assets/images/button-style-03.png', 'label' => '<b>Display share buttons as icon with network name appear when button is pointed</b>' );

		return $essb_available_buttons_style;
	}
}

if (!function_exists('essb_available_buttons_width')) {
	function essb_available_buttons_width() {
		$essb_available_buttons_width = array();
		$essb_available_buttons_width [''] = array ('image' => 'assets/images/button-width-01.png', 'label' => '<b style="padding-bottom:10px;">Automatic width</b><br/>' );
		$essb_available_buttons_width ['fixed'] = array ('image' => 'assets/images/button-width-04.png', 'label' => '<b>Fixed width</b><br/>' );
		$essb_available_buttons_width ['full'] = array ('image' => 'assets/images/button-width-02.png', 'label' => '<b>Full width</b>' );
		$essb_available_buttons_width ['column'] = array ('image' => 'assets/images/button-width-03.png', 'label' => '<b>Display in columns</b>' );

		return $essb_available_buttons_width;
	}
}

if (! function_exists ( 'essb_optin_designs' )) {
	function essb_optin_designs() {
		$periods = array ();
		$periods ['design1'] = 'Design #1';
		$periods ['design2'] = 'Design #2';
		$periods ['design3'] = 'Design #3';
		$periods ['design4'] = 'Design #4';
		$periods ['design5'] = 'Design #5';
		$periods ['design6'] = 'Design #6';
		$periods ['design7'] = 'Design #7';
		$periods ['design8'] = 'Design #8';
		$periods ['design9'] = 'Design #9';
 		return $periods;
	}
}

if (!function_exists('essb_device_select')) {
	function essb_device_select() {
		$devices = array();
		$devices['desktop'] = array ('image' => '<div class="fa21 fa fa-desktop" title="Desktop"></div>', 'label' => '' );
		$devices['mobile'] = array ('image' => '<div class="fa21 fa fa-mobile" title="Mobile"></div>', 'label' => '' );
		$devices['tablet'] = array ('image' => '<div class="fa21 fa fa-tablet" title="Tablet"></div>', 'label' => '' );

		return $devices;
	}
}


if (!function_exists('essb_stylebuilder_css_files')) {
	function essb_stylebuilder_css_files() {
		$files = array();

		$files['easy-social-share-buttons'] = array(
				'name' => __('Main styles (including templates, mobile display, social networks)', 'essb'),
				'default' => 'true',
				'file' => 'assets/css/easy-social-share-buttons.min.css');

		$files['essb-aftershare'] = array(
				'name' => __('After share actions', 'essb'),
				'default' => 'false',
				'file' => 'assets/css/essb-after-share-close.min.css');

		$files['essb-animations'] = array(
				'name' => __('Button animations', 'essb'),
				'default' => 'false',
				'file' => 'assets/css/essb-animations.min.css');

		$files['essb-displaymethods'] = array(
				'name' => __('Additional display method styles - Sidebar, Post Vertical Float, Fly in, Pop up, Hero share, Point, Post Bar', 'essb'),
				'default' => 'false',
				'file' => 'assets/css/essb-display-methods.min.css');

		$files['essb-subscribe'] = array(
				'name' => __('Subscribe Forms', 'essb'),
				'default' => 'false',
				'file' => 'assets/css/essb-subscribe.min.css');

		$files['essb-imageshare'] = array(
				'name' => __('On media sharing', 'essb'),
				'default' => 'false',
				'file' => 'lib/modules/social-image-share/assets/css/easy-social-image-share.min.css');

		$files['essb-followers'] = array(
				'name' => __('Followers counter, Social Profiles', 'essb'),
				'default' => 'false',
				'file' => 'lib/modules/social-followers-counter/assets/css/essb-followers-counter.min.css');

		$files['essb-clicktotweet'] = array(
				'name' => __('Click to Tweet', 'essb'),
				'default' => 'false',
				'file' => 'lib/modules/click-to-tweet/assets/css/styles.css');

		$files['essb-nativebuttons'] = array(
				'name' => __('Native social buttons', 'essb'),
				'default' => 'false',
				'file' => 'assets/css/essb-social-like-buttons.min.css');

		$files['essb-nativebuttons-skin'] = array(
				'name' => __('Native social buttons - skinned mode', 'essb'),
				'default' => 'false',
				'file' => 'assets/css/essb-native-skinned.min.css');

		$files['essb-nativebuttons-privacy'] = array(
				'name' => __('Native social buttons - privacy mode', 'essb'),
				'default' => 'false',
				'file' => 'assets/css/essb-native-privacy.min.css');

		return $files;
	}

}

if (!function_exists('essb_stylebuilder_js_files')) {
	function essb_stylebuilder_js_files() {
		$files = array();

		$files['essb-core'] = array(
				'name' => __('Core Script (required to run properly plugin)', 'essb'),
				'default' => 'true',
				'file' => 'assets/js/essb-core.min.js');

		$files['essb-realtime-counter'] = array(
				'name' => __('Real time share counters script (required only if you are using real time share counters)', 'essb'),
				'default' => 'false',
				'file' => 'assets/js/easy-social-share-buttons.min.js');

		$files['essb-realtime-counter-total'] = array(
				'name' => __('Real time total share counter script (required only if you are using real time share counters)', 'essb'),
				'default' => 'false',
				'file' => 'assets/js/easy-social-share-buttons-total.min.js');

		$files['essb-aftershare'] = array(
				'name' => __('After share actions', 'essb'),
				'default' => 'false',
				'file' => 'assets/js/essb-after-share-close.min.js');

		$files['essb-heroshare'] = array(
				'name' => __('Hero share display method (activate only if you use this display method)', 'essb'),
				'default' => 'false',
				'file' => 'assets/js/essb-heroshare.min.js');

		$files['essb-animatecounter'] = array(
				'name' => __('Animated share counters (activate only if you use this plugin function)', 'essb'),
				'default' => 'false',
				'file' => 'assets/js/jquery.animateNumber.min.js');
		
		$files['essb-onmedia'] = array(
				'name' => __('On media sharing script (activate only if you will use this plugin function)', 'essb'),
				'default' => 'false',
				'file' => 'lib/modules/social-image-share/assets/js/easy-social-image-share.min.js');

		$files['essb-mycred'] = array(
				'name' => __('MyCred integration (activate only if you use myCred integration)', 'essb'),
				'default' => 'false',
				'file' => 'assets/js/essb-mycred.js');
		
		$files['essb-socialprivacy'] = array(
				'name' => __('Privacy Native Buttons (activate only if you use Native Social Buttons and you activate Privacy option)', 'essb'),
				'default' => 'false',
				'file' => 'assets/js/essb-social-privacy.min.js');
		
		return $files;
	}

}
