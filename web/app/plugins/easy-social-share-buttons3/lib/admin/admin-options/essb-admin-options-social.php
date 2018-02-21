<?php
global $essb4_display_methods_count;
$essb4_display_methods_count = 17;

$positions_with_custom_settings = essb_postions_with_custom_options(true);


//---- social
ESSBOptionsStructureHelper::menu_item('social', 'sharing', __('Social Networks', 'essb'), ' ti-sharethis', 'activate_first', 'sharing-1');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-1', __('Networks', 'essb'));
//ESSBOptionsStructureHelper::submenu_item('social', 'sharing-2', __('Additional Network Settings', 'essb'));
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-20', __('Additional Network Settings', 'essb'), 'chevron-down', 'menu', 'title');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-21', __('More Button', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-22', __('Share Button', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-23', __('Twitter', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-24', __('Facebook', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-25', __('Facebook Messenger', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-26', __('VKontakte', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-27', __('Pinterest', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-28', __('Subscribe Button', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-29', __('Email', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-30', __('Print', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-31', __('StumbleUpon', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-32', __('Buffer', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-33', __('Telegram', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-34', __('Flattr', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item('social', 'sharing-35', __('Comment Button', 'essb'),  'default', 'menu', 'true');



ESSBOptionsStructureHelper::menu_item('social', 'style', __('Template & Style', 'essb'), ' ti-palette', 'activate_first', 'style-1');
ESSBOptionsStructureHelper::submenu_item('social', 'style-1', __('Template', 'essb'),  'default');
ESSBOptionsStructureHelper::submenu_item('social', 'style-2', __('Button Style', 'essb'), 'default');
ESSBOptionsStructureHelper::submenu_item('social', 'style-3', __('Align & Width', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('social', 'counters', __('Share Counters', 'essb'), ' ti-infinite', 'activate_first', 'counters-5');
//ESSBOptionsStructureHelper::submenu_item('social', 'style-4', __('Share Counters', 'essb'), 'chevron-down', 'menu', 'title');

ESSBOptionsStructureHelper::submenu_item('social', 'counters-5', __('Display Counters', 'essb'), 'default');
ESSBOptionsStructureHelper::submenu_item('social', 'counters-6', __('Single Button Counter', 'essb'), 'default');
ESSBOptionsStructureHelper::submenu_item('social', 'counters-7', __('Total Share Counter', 'essb'), 'default');
ESSBOptionsStructureHelper::submenu_item('social', 'counters-8', __('Advanced Options', 'essb'), 'default');

ESSBOptionsStructureHelper::menu_item('social', 'analytics-6', __('Analytics', 'essb'), ' ti-stats-up');
ESSBOptionsStructureHelper::menu_item('social', 'optimize-7', __('Sharing Optimization', 'essb'), ' ti-new-window');

if (!essb_option_bool_value('deactivate_module_aftershare')) {
	ESSBOptionsStructureHelper::menu_item('social', 'after-share', __('After Share Actions', 'essb'), ' ti-layout-cta-left', 'activate_first', 'after-share-1');
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-1', __('Action Type', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-2', __('Like/Follow Options', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-3', __('Custom HTML Message', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-4', __('Custom Code', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-5', __('Optin form from Easy Optin', 'essb'));
}

ESSBOptionsStructureHelper::menu_item('social', 'shorturl', __('Short URL', 'essb'), ' ti-cut');

ESSBOptionsStructureHelper::menu_item('social', 'advanced', __('Advanced Functions', 'essb'), ' ti-plug', 'activate_first', 'advanced-8');
ESSBOptionsStructureHelper::submenu_item('social', 'advanced-8', __('Custom Share', 'essb'));
ESSBOptionsStructureHelper::submenu_item('social', 'advanced-9', __('Affiliate & Point Plugin Integration', 'essb'));
ESSBOptionsStructureHelper::submenu_item('social', 'advanced-14', __('Message before/after/above buttons', 'essb'));


//ESSBOptionsStructureHelper::submenu_item('social', 'sharing-17', __('Affiliates Integration', 'essb'), 'default', 'menu', 'true');

// -- Where to display buttons
$where_to_display = 'where';
ESSBOptionsStructureHelper::menu_item($where_to_display, 'posts', __('Post Types & Plugins', 'essb'), ' ti-widget-alt');
ESSBOptionsStructureHelper::menu_item($where_to_display, 'display', __('Positions on Site', 'essb'), ' ti-layout-grid2-alt', 'activate_first', 'display-2');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-2', __('Positions', 'essb'), 'default');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-3', __('Display Position Settings', 'essb'), 'chevron-down', 'menu', 'title');

//ESSBOptionsStructureHelper::menu_item('display', 'locations', __('Display Position Settings', 'essb'), 'default', 'activate_first', 'positions-3');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-4', __('Content Top', 'essb'),  'default', 'menu', 'true');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-5', __('Content Bottom', 'essb'),  'default', 'menu', 'true');
if (!essb_options_bool_value('deactivate_method_float')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-6', __('Float from top', 'essb'),  'default', 'menu', 'true');
}

if (!essb_options_bool_value('deactivate_method_postfloat')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-7', __('Post vertical float', 'essb'),  'default', 'menu', 'true');
}
if (!essb_options_bool_value('deactivate_method_sidebar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-8', __('Sidebar', 'essb'),  'default', 'menu', 'true');
}
if (!essb_options_bool_value('deactivate_method_topbar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-9', __('Top bar', 'essb'),  'default', 'menu', 'true');
}
if (!essb_options_bool_value('deactivate_method_bottombar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-10', __('Bottom bar', 'essb'),  'default', 'menu', 'true');
}

if (!essb_options_bool_value('deactivate_method_popup')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-11', __('Pop up', 'essb'),  'default', 'menu', 'true');
}

if (!essb_options_bool_value('deactivate_method_flyin')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-12', __('Fly in', 'essb'),  'default', 'menu', 'true');
}
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-13', __('On media', 'essb'),  'default', 'menu', 'true');

if (!essb_options_bool_value('deactivate_method_heroshare')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-14', __('Full screen hero share', 'essb'),  'default', 'menu', 'true');
}

if (!essb_options_bool_value('deactivate_method_postbar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-15', __('Post share bar', 'essb'),  'default', 'menu', 'true');
}
if (!essb_options_bool_value('deactivate_method_point')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-16', __('Point', 'essb'),  'default', 'menu', 'true');
}
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-17', __('Excerpt', 'essb'),  'default', 'menu', 'true');

// @since 4.1 allow usage of external display methods
$essb_custom_methods = array();
$essb_custom_methods = apply_filters('essb4_custom_method_list', $essb_custom_methods);
foreach ($essb_custom_methods as $key => $title) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, $key, $title,  'default', 'menu', 'true');	
}

ESSBOptionsStructureHelper::menu_item($where_to_display, 'mobile', __('Mobile', 'essb'), ' ti-mobile', 'activate_first', 'mobile-1');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'mobile-1', __('Display Options', 'essb'));
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'mobile-2', __('Customize buttons when viewed from mobile device', 'essb'));
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'mobile-3', __('Share bar', 'essb'));
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'mobile-4', __('Share point', 'essb'));
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'mobile-5', __('Share buttons bar', 'essb'));

$essb_custom_methods = array();
$essb_custom_methods = apply_filters('essb4_custom_method_list_mobile', $essb_custom_methods);
foreach ($essb_custom_methods as $key => $title) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, $key, $title);
}

//** options
if ($positions_with_custom_settings != '') {
	ESSBOptionsStructureHelper::hint('social', 'style-1', __('Exist position based style settings', 'essb'), 'We found that you have personalized styles for position/s <b>'.$positions_with_custom_settings.'</b>. All changes that you made in here will not reflect <b>'.$positions_with_custom_settings.'</b> buttons style - to make a change for those positions you need to use location based settings (or deactivate personalization by location).', 'fa21 mr10 ti-info-alt', 'blue');
}
ESSBOptionsStructureHelper::field_func('social', 'style-1', 'essb3_options_template_select', __('', 'essb'), __('', 'essb'));


if ($positions_with_custom_settings != '') {
	ESSBOptionsStructureHelper::hint('social', 'style-2', __('Exist position based style settings', 'essb'), 'We found that you have personalized styles for position/s <b>'.$positions_with_custom_settings.'</b>. All changes that you made in here will not reflect <b>'.$positions_with_custom_settings.'</b> buttons style - to make a change for those positions you need to use location based settings (or deactivate personalization by location).', 'fa21 mr10 ti-info-alt', 'blue');
}
ESSBOptionsStructureHelper::hint('social', 'style-2', __('Choose your default button styles', 'essb'), __('Default button style and width will be used if you did not make any customizations for position, post type or via shortcode. The previews below are rendered based on last saved template in settings (if you change the template but did not save options do it now to see how buttons will look with it).', 'essb'), 'fa32 mr10 ti-palette');
//ESSBOptionsStructureHelper::panel_start('social', 'style-2', __('Button presentation style', 'essb'), __('Choose general button placement and presentation styles that will be used as default if no customization is made', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));

ESSBOptionsStructureHelper::structure_row_start('social', 'style-2');

ESSBOptionsStructureHelper::structure_section_start('social', 'style-2', 'c12', __('Buttons display style', 'essb'), __('Select your default button style', 'essb'));

$essb_available_buttons_style = array();
$essb_available_buttons_style ['button'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" message="no" url="http://socialsharingplugin.com"]', "label" => "<b>Display as share button with icon and network name</b>" );
$essb_available_buttons_style ['button_name'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button_name" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no"  url="http://socialsharingplugin.com"]', "label" => "<b>Display as share button with network name and without icon</b>" );
$essb_available_buttons_style ['icon'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="icon" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Display share buttons only as icon without network names</b>" );
$essb_available_buttons_style ['icon_hover'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="icon_hover" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Display share buttons as icon with network name appear when button is pointed</b>" );
$essb_available_buttons_style ['vertical'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="vertical" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Display icon above network name (vertical buttons)</b>" );

ESSBOptionsStructureHelper::field_html_radio('social', 'style-2', 'button_style', '', __('Select your default button style', 'essb'), $essb_available_buttons_style, '', 'true', '300px');

ESSBOptionsStructureHelper::structure_section_end('social', 'style-2');
ESSBOptionsStructureHelper::structure_row_end('social', 'style-2');
ESSBOptionsStructureHelper::structure_row_start('social', 'style-2');

ESSBOptionsStructureHelper::structure_section_start('social', 'style-2', 'c6', '', '');
ESSBOptionsStructureHelper::field_select('social', 'style-2', 'css_animations', __('Activate animations', 'essb'), __('Animations
		are provided with CSS transitions and work on best with retina
		templates.', 'essb'), essb_available_animations(), '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'style-2');

ESSBOptionsStructureHelper::structure_section_start('social', 'style-2', 'c6', '', '');
ESSBOptionsStructureHelper::field_switch('social', 'style-2', 'nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '9');
ESSBOptionsStructureHelper::structure_section_end('social', 'style-2');

ESSBOptionsStructureHelper::structure_row_end('social', 'style-2');

if ($positions_with_custom_settings != '') {
	ESSBOptionsStructureHelper::hint('social', 'style-3', __('Exist position based style settings', 'essb'), 'We found that you have personalized styles for position/s <b>'.$positions_with_custom_settings.'</b>. All changes that you made in here will not reflect <b>'.$positions_with_custom_settings.'</b> buttons style - to make a change for those positions you need to use location based settings (or deactivate personalization by location).', 'fa21 mr10 ti-info-alt', 'blue');
}

ESSBOptionsStructureHelper::structure_row_start('social', 'style-3');

ESSBOptionsStructureHelper::structure_section_start('social', 'style-3', 'c12', __('Buttons align', 'essb'), __('Choose how buttons
		to be aligned. Default position is left but you can also select
		Right or Center', 'essb'));
$essb_available_buttons_align = array();
$essb_available_buttons_align [''] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Left</b>" );
$essb_available_buttons_align ['center'] = array ("image" => '<div style="text-align: center;">[easy-social-share buttons="facebook,twitter" counters=0 align="center" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]</div>', "label" => "<b>Center</b>" );
$essb_available_buttons_align ['right'] = array ("image" => '<div style="text-align: right;">[easy-social-share buttons="facebook,twitter" counters=0 align="right" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]</div>', "label" => "<b>Right</b>" );

ESSBOptionsStructureHelper::field_html_radio('social', 'style-3', 'button_pos', __('', 'essb'), __('Choose how buttons
		to be aligned. Default position is left but you can also select
		Right or Center', 'essb'), $essb_available_buttons_align, '', 'true', '300px');



ESSBOptionsStructureHelper::structure_section_end('social', 'style-3');

ESSBOptionsStructureHelper::structure_row_end('social', 'style-3');




//ESSBOptionsStructureHelper::panel_end('social', 'style-3');

ESSBOptionsStructureHelper::panel_start('social', 'style-3', __('Width of share buttons', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), 'fa21 ti-layout-slider', array("mode" => "toggle"));

$essb_available_buttons_width = array();
$essb_available_buttons_width [''] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Automatic width</b> each button will have required to render width" );
$essb_available_buttons_width ['fixed'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="yes" fixedwidth_px="100" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="no" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Fixed width - all buttons will have provided by you width in pixels</b>" );
$essb_available_buttons_width ['full'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="yes" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="no" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Full width - buttons will automatically stretch to fit width of content area</b>" );
$essb_available_buttons_width ['column'] = array ("image" => '[easy-social-share buttons="facebook,twitter,google,pinterest" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="yes" columns="2" facebook_text="Facebook" twitter_text="Twitter" google_text="Google" pinterest_text="Pinterest" flex="no" autowidth="no" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Display in columns - display in selected number of columns</b>" );
$essb_available_buttons_width ['flex'] = array ("image" => '[easy-social-share buttons="facebook,twitter,google" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" columns="2" facebook_text="Facebook" flex="yes" twitter_text="Twitter" google_text="Google" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>Flexible width - buttons will have automated width to take full content area</b>" );
ESSBOptionsStructureHelper::field_html_radio('social', 'style-3', 'button_width', __('', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), $essb_available_buttons_width, '', 'true', '400px');



ESSBOptionsStructureHelper::field_heading('social', 'style-3', 'heading5', __('Personalize settings for each width style that you can use for buttons', 'essb'));

ESSBOptionsStructureHelper::tabs_start('social', 'style-3', 'width-tabs', array("Fixed width sharing buttons", "Full width sharing buttons", "Display in columns"));
ESSBOptionsStructureHelper::tab_start('social', 'style-3', 'width-tabs-0', 'true');
ESSBOptionsStructureHelper::field_section_start_panels('social', 'style-3', '', __('Customize the fixed width options', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'style-3', 'fixed_width_value', __('Custom buttons width', 'essb'), __('Provide custom width of button in pixels without the px symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_select_panel('social', 'style-3', 'fixed_width_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name, when fixed button width is activated. When counter position is Inside or Inside name, that alignment will be applied for the counter. Default value is center.', 'essb'), array("" => "Center", "left" => "Left", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'style-3');
ESSBOptionsStructureHelper::tab_end('social', 'style-3');

ESSBOptionsStructureHelper::tab_start('social', 'style-3', 'width-tabs-1');
ESSBOptionsStructureHelper::field_section_start_panels('social', 'style-3', '', __('Full width option will make buttons to take the width of your post content area.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'style-3', 'fullwidth_share_buttons_correction', __('Max width of button on desktop', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'style-3', 'fullwidth_share_buttons_correction_mobile', __('Max width of button on mobile', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'style-3', 'fullwidth_share_buttons_container', __('Max width of buttons container element', 'essb'), __('If you wish to display total counter along with full width share buttons please provide custom max width of buttons container in percent without % (example: 90). Leave this field blank for default value of 100 (100%).', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_select_panel('social', 'style-3', 'fullwidth_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("left" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'style-3');
ESSBOptionsStructureHelper::field_section_start_panels('social', 'style-3', __('Customize width of first two buttons', 'essb'), __('Provide different width for the first two buttons in the row. The width should be entered as number in percents (without the % mark). You can fill only one of the values or both values.', 'essb'), '', 'true');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'style-3', 'fullwidth_first_button', __('Width of first button', 'essb'), __('Provide custom width of first button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'style-3', 'fullwidth_second_button', __('Width of second button', 'essb'), __('Provide custom width of second button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_section_end_panels('social', 'style-3');
ESSBOptionsStructureHelper::tab_end('social', 'style-3');

ESSBOptionsStructureHelper::tab_start('social', 'style-3', 'width-tabs-2');
ESSBOptionsStructureHelper::field_section_start_panels('social', 'style-3', '', '');
$listOfOptions = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5");
ESSBOptionsStructureHelper::field_select_panel('social', 'style-3', 'fullwidth_share_buttons_columns', __('Number of columns', 'essb'), __('Choose the number of columns that buttons will be displayed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_select_panel('social', 'style-3', 'fullwidth_share_buttons_columns_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'style-3');
ESSBOptionsStructureHelper::tab_end('social', 'style-3');

ESSBOptionsStructureHelper::tabs_end('social', 'style-3');

ESSBOptionsStructureHelper::panel_end('social', 'style-3');

ESSBOptionsStructureHelper::field_heading('social', 'sharing-1', 'heading5', __('Social Networks', 'essb'));

$positions_with_networks = essb_postions_with_custom_networks(true);
//print_r($positions_with_networks);
if ($positions_with_networks != '') {
	ESSBOptionsStructureHelper::hint('social', 'sharing-1', __('Exist position based network settings', 'essb'), 'We found that you have personalized list of networks for position/s <b>'.$positions_with_networks.'</b>. All changes that you made in here will not reflect <b>'.$positions_with_networks.'</b> network selection - to make a change for those positions you need to use location based settings (or deactivate personalization by location).', 'fa21 mr10 ti-info-alt', 'blue');
}

ESSBOptionsStructureHelper::structure_row_start('social', 'sharing-1', 'inner-row');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharing-1', 'c6');
ESSBOptionsStructureHelper::hint('social', 'sharing-1', __('Additional network settings are available', 'essb'), __('Some of social networks has additional options that you can use to personalize their function. All that options you can find grouped by social network inside <b>Additional Network Settings</b> menu.', 'essb'), 'fa24 ti-widget');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharing-1');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharing-1', 'c6');
ESSBOptionsStructureHelper::hint('social', 'sharing-1', __('Personalize list of active social networks by device (desktop/mobile) or position', 'essb'), __('The list of global active social networks listed below you can easy personalize for each location or device using display position settings or mobile settings which you can find in <b>Where to display</b>.', 'essb'), 'fa24 ti-panel');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharing-1');
ESSBOptionsStructureHelper::structure_row_end('social', 'sharing-1');



ESSBOptionsStructureHelper::field_func('social', 'sharing-1', 'essb3_network_selection', '', '');
$network_sort_order = array("" => __("User provided order", "essb"), "shares" => __("Sort dynamically by number of shares", "essb"));
ESSBOptionsStructureHelper::field_select('social', 'sharing-1', 'user_sort', __('Share buttons ordering', 'essb'), __('If you decide to use dinamically order please note that it will not work with real time share counters.', 'essb'), $network_sort_order);

ESSBOptionsStructureHelper::field_heading('social', 'sharing-2', 'heading5', __('Additional network settings', 'essb'));

ESSBOptionsStructureHelper::hint('social', 'sharing-2', '', __('Click on network name to expand additional advanced settings', 'essb'));

ESSBOptionsStructureHelper::panel_start('social', 'sharing-21', __('More Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_more', array("mode" => "toggle", 'state' => 'opened'));
$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up", "4" => "Display all active networks after more button in popup" );
ESSBOptionsStructureHelper::field_select('social', 'sharing-21', 'more_button_func', __('More button', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands());
$more_options = array ("plus" => "Plus icon", "dots" => "Dots icon" );
ESSBOptionsStructureHelper::field_select('social', 'sharing-21', 'more_button_icon', __('More button icon', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $more_options);
ESSBOptionsStructureHelper::field_section_start_panels('social', 'sharing-21', '', '');
$more_options = array ("" => "Classic Style", "modern" => "Modern Style" );
ESSBOptionsStructureHelper::field_select_panel('social', 'sharing-21', 'more_button_popstyle', __('More button pop up style', 'essb'), __('Choose the style of your pop up with social networks', 'essb'), $more_options);
ESSBOptionsStructureHelper::field_select_panel('social', 'sharing-21', 'more_button_poptemplate', __('Template of social networks in more pop up', 'essb'), __('Choose different tempate of buttons in pop up with share buttons or leave usage of default template', 'essb'), essb_available_tempaltes4(true));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'sharing-21');
ESSBOptionsStructureHelper::panel_end('social', 'sharing-21');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-22', __('Share Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_share', array("mode" => "toggle", 'state' => 'opened'));
//$more_options = array ("1" => "Display all active networks after share button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up" );
$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up", "4" => "Display all active networks after more button in popup" );
ESSBOptionsStructureHelper::field_select('social', 'sharing-22', 'share_button_func', __('Share button function', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands());
ESSBOptionsStructureHelper::field_section_start_panels('social', 'sharing-22', '', '');
$more_options = array ("" => "Classic Style", "modern" => "Modern Style" );
ESSBOptionsStructureHelper::field_select_panel('social', 'sharing-22', 'share_button_popstyle', __('More button pop up style', 'essb'), __('Choose the style of your pop up with social networks', 'essb'), $more_options);
ESSBOptionsStructureHelper::field_select_panel('social', 'sharing-22', 'share_button_poptemplate', __('Template of social networks in more pop up', 'essb'), __('Choose different tempate of buttons in pop up with share buttons or leave usage of default template', 'essb'), essb_available_tempaltes4(true));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'sharing-22');

$essb_available_buttons_width = array();
$essb_available_buttons_width ['plus'] = array ("image" => '<div class="fa21 essb_icon_plus"></div>', "label" => "" );
$essb_available_buttons_width ['dots'] = array ("image" => '<div class="fa21 essb_icon_dots"></div>', "label" => "" );
$essb_available_buttons_width ['share'] = array ("image" => '<div class="fa21 essb_icon_share"></div>', "label" => "" );
$essb_available_buttons_width ['share-alt-square'] = array ("image" => '<div class="fa21 essb_icon_share-alt-square"></div>', "label" => "" );
$essb_available_buttons_width ['share-alt'] = array ("image" => '<div class="fa21 essb_icon_share-alt"></div>', "label" => "" );
$essb_available_buttons_width ['share-tiny'] = array ("image" => '<div class="fa21 essb_icon_share-tiny"></div>', "label" => "" );
$essb_available_buttons_width ['share-outline'] = array ("image" => '<div class="fa21 essb_icon_share-outline"></div>', "label" => "" );
ESSBOptionsStructureHelper::field_html_radio_buttons('social', 'sharing-22', 'share_button_icon', __('Share button icon', 'essb'), __('Choose the share button icon you will use (default is share if nothing is selected)', 'essb'), $essb_available_buttons_width, '', '', '26px');

$more_options = array ("" => "Default from settings (like other share buttons)", "icon" => "Icon only", "button" => "Button", "text" => "Text only" );
ESSBOptionsStructureHelper::field_select('social', 'sharing-22', 'share_button_style', __('Share button style', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $more_options);

$share_counter_pos = array("hidden" => "No counter", "inside" => "Inside button without text", "insidename" => "Inside button after text", "insidebeforename" => "Inside button before text", "topn" => "Top", "bottom" => "Bottom");
ESSBOptionsStructureHelper::field_select('social', 'sharing-22', 'share_button_counter', __('Display total counter with the following position', 'essb'), __('Choose where you wish to display total counter of shares assigned with this button. <br/> To view total counter you need to have share counters active and they should not be running in real time mode. Also you need to have your share button set with style button. When you use share button with counter we highly recommend to hide total counter by setting position to be hidden - this will avoid having two set of total value on screen.', 'essb'), $share_counter_pos);

ESSBOptionsStructureHelper::panel_end('social', 'sharing-22');


ESSBOptionsStructureHelper::panel_start('social', 'sharing-23', __('Twitter', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_twitter', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_section_start_panels('social', 'sharing-23', __('Username and Hashtags', 'essb'), __('Provide default Twitter username and hashtags to be included into messages.', 'essb'), 'yes');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'sharing-23', 'twitteruser', __('Username to be mentioned:', 'essb'), __('If you wish a twitter username to be mentioned in tweet write it here. Enter your username without @ - example twittername. This text will be appended to tweet message at the end. Please note that if you activate custom share address option this will be added to custom share message.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'sharing-23', 'twitterhashtags', __('Hashtags to be added:', 'essb'), __('If you wish hashtags to be added to message write them here. You can set one or more (if more then one separate them with comma (,)) Example: demotag1,demotag2.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('social', 'sharing-23', 'twitter_message_tags_to_hashtags', __('Use post tags as hashtags', 'essb'), __('Activate this option to use your current post tags as hashtags. When this option is active the default hashtags will be replaced with post tags when there are such post tags.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'sharing-23');

ESSBOptionsStructureHelper::field_section_start('social', 'sharing-23', __('Twitter message optimization', 'essb'), __('Twitter message optimization allows you to truncate your message if it exceeds the 240 characters length of message.', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'sharing-23', 'twitter_message_optimize', __('Activate', 'essb'), __('Activate message optimization.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("1" => "Remove hashtags, remove via username, truncate message", "2" => "Remove via username, remove hashtags, truncate message", "3" => "Remove via username, truncate message", "4" => "Remove hashtags, truncate message", "5" => "Truncate only message");
ESSBOptionsStructureHelper::field_select('social', 'sharing-23', 'twitter_message_optimize_method', __('Method of optimization', 'essb'), __('Choose the order of components to be removed till reaching the limit of characters', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch('social', 'sharing-23', 'twitter_message_optimize_dots', __('Add read more dots when truncate message', 'essb'), __('Add ... (read more dots) to truncated tweets.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'sharing-23');
ESSBOptionsStructureHelper::panel_end('social', 'sharing-23');


ESSBOptionsStructureHelper::panel_start('social', 'sharing-24', __('Facebook', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_facebook', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_section_start('social', 'sharing-24', __('Facebook Advanced Sharing', 'essb'), __('For proper work of advanced Facebook sharing you need to provide application id. If you don\'t have you need to create one. To create Facebook Application use this link: http://developers.facebook.com/apps/', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'sharing-24', 'facebookadvanced', __('Activate', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharing-24', 'facebookadvancedappid', __('Facebook Application ID:', 'essb'), '');
ESSBOptionsStructureHelper::field_section_end('social', 'sharing-24');
ESSBOptionsStructureHelper::panel_end('social', 'sharing-24');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-25', __('Facebook Messenger', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_messenger', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharing-25', 'fbmessengerapp', __('Facebook Application ID:', 'essb'), __('Facebook Application ID connected with your site is required to make messenger sharing work. If you use Facebook Advanced Sharing feature then it is not needed to fill this parameter as application is already applied into Facebook Advanced Sharing settings', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-25');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-26', __('VKontakte', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_vk', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_switch('social', 'sharing-26', 'vkontakte_fullshare', __('Send all sharable details for post/page:', 'essb'), __('VKontakte like most of social networks read data from socail share optimization tags that you have on page. In case when you share nothing appears please activate this option to allow plugin send all details to VKontakte. Please note that if this option is active the details from Social Share Optimization will not appear in share dialog!', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-26');


ESSBOptionsStructureHelper::panel_start('social', 'sharing-27', __('Pinterest', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_pinterest', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_switch('social', 'sharing-27', 'pinterest_sniff_disable', __('Disable Pinterest Pin any image:', 'essb'), __('If you disable Pinterest sniff for images plugin will use for share post featured image or custom share image you provide in post settings.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-27');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-28', __('Subscribe Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_subscribe', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::hint('social', 'sharing-28', __('', 'essb'), __('If you choose to use the build in opt-in module Easy Optin please pay attention of settings in <b>Subscribe Forms</b> menu. In that place you will find all required to setup options for mailing list service connection and you can also customize the design you choose.', 'essb'), 'fa21 mr10 fa fa-envelope-o');

$listOfValues = array ("form" => "Open content box", "link" => "Open subscribe link", "mailchimp" => "Easy Optin Subscribe Form (Ready made forms with automatic service integrations)" );
ESSBOptionsStructureHelper::field_select('social', 'sharing-28', 'subscribe_function', __('Specify subscribe button function', 'essb'), __('Specify if the subscribe button is opening a content box below the button or if the button is linked to the "subscribe url" below.', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharing-28', 'subscribe_link', __('Subscribe URL', 'essb'), __('Link the Subscribe button to this URL. This can be the url to your subscribe page, facebook fanpage, RSS feed etc. e.g. http://yoursite.com/subscribe', 'essb'));
ESSBOptionsStructureHelper::field_editor('social', 'sharing-28', 'subscribe_content', __('Subscribe content box', 'essb'), __('Define the content of the opening toggle subscribe window here. Use formulars, like button, links or any other text. Shortcodes are supported, e.g.: [contact-form-7]. Note that if you use subscribe button outside content display positions content will open as popup', 'essb'), 'htmlmixed');
$listOfValues = essb_optin_designs();
ESSBOptionsStructureHelper::field_select('social', 'sharing-28', 'subscribe_optin_design', __('Specify subscribe button Easy Optin design for content', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_select('social', 'sharing-28', 'subscribe_optin_design_popup', __('Specify subscribe button Easy Optin design for popup', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::panel_end('social', 'sharing-28');


ESSBOptionsStructureHelper::panel_start('social', 'sharing-29', __('Email', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_mail', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_section_start('social', 'sharing-29', __('Email button send options', 'essb'), __('', 'essb'), '');
$listOfValues = array ("form" => "Send mail using pop up form", "link" => "Send mail using mailto link and user mail client" );
ESSBOptionsStructureHelper::field_select('social', 'sharing-29', 'mail_function', __('Send to mail button function', 'essb'), __('Choose how you wish mail button to operate. By default it uses the build in pop up window with sendmail option but you can change this to link option to force use of client mail program.', 'essb'), $listOfValues);
//ESSBOptionsStructureHelper::field_switch('social', 'sharing-2', 'use_wpmandrill', __('Use wpMandrill for send mail', 'essb'), __('To be able to send messages with wpMandrill you need to have plugin installed.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharing-29', 'mail_copyaddress', __('Send copy of all messages to', 'essb'), __('Provide email address if you wish to get copy of each message that is sent via form', 'essb'));
//ESSBOptionsStructureHelper::field_switch('social', 'sharing-2', 'mail_inline_code', __('Append inline mail send code', 'essb'), __('Activate this option if you use Initite scroll plugin and mail button do not work', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'sharing-29');

ESSBOptionsStructureHelper::field_section_start('social', 'sharing-29', __('Pop up mail form options', 'essb'), __('', 'essb'), '');
$listOfValues = array ("host" => "Using host mail function", "wp" => "Using WordPress mail function" );
//ESSBOptionsStructureHelper::field_switch('social', 'sharing-2', 'mail_disable_editmessage', __('Disable editing of mail message', 'essb'), __('Activate this option to prevent users from changing the default message.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_select('social', 'sharing-2', 'mail_function_command', __('Use the following command to send mails when form is used', 'essb'), __('Choose the default function you will use to send mails when mail form is active. If you use external plugin in WordPress for send mail (like Easy WP SMTP) you need to choose WordPress mail function to get your messages sent.', 'essb'), $listOfValues);
$listOfValues = array ("level1" => "Advanced security check", "level2" => "Basic security check" );
ESSBOptionsStructureHelper::field_select('social', 'sharing-29', 'mail_function_security', __('Use the following security check when form is used', 'essb'), __('Security check is made to prevent unauthorized access to send mail function of plugin. The default option is to use advanced security check but if you get message invalid security key during send process switch to lower level check - Basic security check.', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_switch('social', 'sharing-29', 'mail_popup_mobile', __('Allow usage of pop up mail form on mobile devices', 'essb'), __('Activate this option to allow usage of pop up form when site is browsed with mobile device. Default setting is to use build in mobile device mail application.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'sharing-29');


ESSBOptionsStructureHelper::field_section_start('social', 'sharing-29', __('Antispam Captcha Verification', 'essb'), __('Fill both fields for question and answer to prevent sending message without entering the correct answer.', 'essb'), '');
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharing-29', 'mail_captcha', __('Captcha Message', 'essb'), __('Enter captcha question you wish to ask users to validate that they are human.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharing-29', 'mail_captcha_answer', __('Captcha Answer', 'essb'), __('Enter answer you wish users to put to verify them.', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'sharing-29');

ESSBOptionsStructureHelper::field_section_start('social', 'sharing-29', __('Customize default mail message', 'essb'), __('You can customize texts to display when visitors share your content by mail button. To perform customization, you can use %%title%%, %%siteurl%%, %%permalink%% or %%image%% variables.', 'essb'), '');
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharing-29', 'mail_subject', __('Subject', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textarea('social', 'sharing-29', 'mail_body', __('Message', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'sharing-29', 'mail_popup_preview', __('Display preview of mail message', 'essb'), __('Include non editable preview of mail message in the popup form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'sharing-29', 'mail_popup_edit', __('Allow custom user message', 'essb'), __('Activate this option to allow user include own custom message along with default.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'sharing-29');
ESSBOptionsStructureHelper::panel_end('social', 'sharing-29');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-30', __('Print', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_print', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_switch('social', 'sharing-30', 'print_use_printfriendly', __('Use for printing printfreidly.com', 'essb'), __('Activate that option to use printfriendly.com as printing service instead of default print function of browser', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-30');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-31', __('StumbleUpon', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_stumbleupon', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_switch('social', 'sharing-31', 'stumble_noshortlink', __('Do not generate shortlinks', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-31');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-32', __('Buffer', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_buffer', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_switch('social', 'sharing-32', 'buffer_twitter_user', __('Add Twitter username to buffer shares', 'essb'), __('Append also Twitter username into Buffer shares', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-32');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-33', __('Telegram', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_telegram', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_switch('social', 'sharing-33', 'telegram_alternative', __('Use alternative Telegram share', 'essb'), __('Alternative Telegram share method uses Telegram website to share data instead of direct call to mobile application. This method currently supports share to web application too.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-33');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-34', __('Flattr', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_flattr', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_textbox('social', 'sharing-34', 'flattr_username', __('Flattr Username', 'essb'), __('The Flattr account to which the buttons will be assigned.', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'sharing-34', 'flattr_tags', __('Additional Flattr tags for your posts', 'essb'), __('Comma separated list of additional tags to use in Flattr buttons.', 'essb'));
ESSBOptionsStructureHelper::field_select('social', 'sharing-34', 'flattr_cat', __('Default category for your posts', 'essb'), __('', 'essb'), ESSBNetworks_Flattr::getCategories());
ESSBOptionsStructureHelper::field_select('social', 'sharing-34', 'flattr_lang', __('Default language for your posts', 'essb'), __('', 'essb'), ESSBNetworks_Flattr::getLanguages());
ESSBOptionsStructureHelper::panel_end('social', 'sharing-34');

ESSBOptionsStructureHelper::panel_start('social', 'sharing-35', __('Comment Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_comments', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_textbox('social', 'sharing-35', 'comments_address', __('Comments button address', 'essb'), __('If you use external comment system like Disqus you may need to personalize address to comments element (default is #comments).', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharing-35');

ESSBOptionsStructureHelper::structure_row_start('social', 'counters-5');
ESSBOptionsStructureHelper::structure_section_start('social', 'counters-5', 'c4');

ESSBOptionsStructureHelper::field_switch('social', 'counters-5', 'show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-5');

ESSBOptionsStructureHelper::structure_section_start('social', 'counters-5', 'c8');
ESSBOptionsStructureHelper::field_select('social', 'counters-5', 'counter_mode', __('Counter update mode', 'essb'), __('Choose how your counters will update. Real-time share counter will update on each page load and usage on production site can produce extreme load over admin-ajax WordPress component - use it with caution. We strongly recommend using updated on interval counters. They will update once on chosen interval and ensure your site will work fast and smooth (if you use cache plugin and they do not update frequently you can activate in advanced options cache compatible update mode).', 'essb'), essb_cached_counters_update(), '', '8');

ESSBOptionsStructureHelper::structure_section_end('social', 'counters-5');
ESSBOptionsStructureHelper::structure_row_end('social', 'counters-5');

ESSBOptionsStructureHelper::panel_start('social', 'counters-5', __('Avoid social negative proof', 'essb'), __('Avoid social negative proof allows you to hide button counters or total counter till a defined value of shares is reached', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'social_proof_enable', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_textbox('social', 'counters-5', 'button_counter_hidden_till', __('Display button counter after this value of shares is reached', 'essb'), __('You can hide your button counter until amount of shares is reached. This option is active only when you enter value in this field - if blank button counter is always displayed. (Example: 10 - this will make button counter appear when at least 10 shares are made).', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'counters-5', 'total_counter_hidden_till', __('Display total counter after this value of shares is reached', 'essb'), __('You can hide your total counter until amount of shares is reached. This option is active only when you enter value in this field - if blank total counter is always displayed.', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'counters-5');

ESSBOptionsStructureHelper::panel_start('social', 'counters-5', __('Advanced counter update options', 'essb'), __('Configure different advanced counter update functions of plugin when you use non real time counters', 'essb'), 'fa21 fa fa-refresh', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::structure_row_start('social', 'counters-5');
ESSBOptionsStructureHelper::structure_section_start('social', 'counters-5', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'counters-5', 'cache_counter_refresh_cache', __('Cache plugin/server compatible mode', 'essb'), __('Recommended to be active on sites that uses cache plugin or cache server. Activation of this option will ensure your counters will update on background at the time you set but you will see the new share value once your cache expires (usually once per hour or once per day).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-5');

ESSBOptionsStructureHelper::structure_section_start('social', 'counters-5', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'counters-5', 'cache_counter_refresh_async', __('Speed up process of counters update', 'essb'), __('This option will activate asynchronous counter update mode which is up to 5 times faster than regular update. Option requires to have PHP 5.4 or newer.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-5');
ESSBOptionsStructureHelper::structure_row_end('social', 'counters-5');


ESSBOptionsStructureHelper::panel_end('social', 'counters-5');

ESSBOptionsStructureHelper::field_heading('social', 'counters-6', 'heading5', __('Button Counters', 'essb'));
if ($positions_with_custom_settings != '') {
	ESSBOptionsStructureHelper::hint('social', 'counters-6', __('Exist position based style settings', 'essb'), 'We found that you have personalized styles for position/s <b>'.$positions_with_custom_settings.'</b>. All changes that you made in here will not reflect <b>'.$positions_with_custom_settings.'</b> buttons style - to make a change for those positions you need to use location based settings (or deactivate personalization by location).', 'fa21 mr10 ti-info-alt', 'blue');
}
//ESSBOptionsStructureHelper::field_select('social', 'sharing-3', 'counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position', 'essb'), essb_avaliable_counter_positions());

$current_counter_positions = essb_avaliable_counter_positions();
$mixed_radio = array();
foreach ($current_counter_positions as $key => $text) {
	$mixed_radio [$key] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=1 demo_counter="yes" counter_pos="'.$key.'" total_counter_pos="hidden" align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Share" twitter_text="Tweet" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>".$text."</b>" );	
}
ESSBOptionsStructureHelper::field_html_radio('social', 'counters-6', 'counter_pos', __('', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), $mixed_radio, '', 'true', '300px');
ESSBOptionsStructureHelper::panel_start('social', 'counters-6', __('Additional social network counter settings that you need to pay attention', 'essb'), __('Depends on networks that are set on site you may need to configure additional fields in this section like Twitter counter function, usage of internal counters, number format or Facebook Token for consistent Facebook counter update', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::structure_row_start('social', 'counters-6');
//ESSBOptionsStructureHelper::structure_section_start('social', 'sharing-3', 'c6');
//ESSBOptionsStructureHelper::field_switch('social', 'sharing-3', 'facebooktotal', __('Display Facebook Total Count', 'essb'), __('Enable this option if you wish to display total count not only share count which is displayed by default.', 'essb'), 'yes', __('Yes', 'essb'), __('No', 'essb'), '', '6');
//ESSBOptionsStructureHelper::structure_section_end('social', 'sharing-3');

//ESSBOptionsStructureHelper::structure_section_start('social', 'sharing-3', 'c12');
$listOfOptions = array ("self" => "Self-hosted counter (internally counted by click on buttons)", "newsc" => "Using NewShareCounts.com", "opensc" => "Using OpenShareCount.com", "no" => "No counter for Twitter button" );
$counter_redirect = "";
$twitter_counters = ESSBOptionValuesHelper::options_value($essb_options, 'twitter_counters');
if ($twitter_counters == "self") {
	//$counter_redirect = "<br/><br/><a href='admin.php?page=essb_redirect_advanced&tab=advanced&section=twitter'>Click here</a> to preload your Twitter self-hosted counter with initial value.";
}
ESSBOptionsStructureHelper::field_select('social', 'counters-6', 'twitter_counters', __('Twitter share counter', 'essb'), __('Choose your Twitter counter working mode. If you select usage of NewShareCounts.com or OpenShareCount.com to make it work you need to visit their site and fill your site address and click sign in button using your Twitter account. Visit <a href="http://newsharecounts.com/" target="_blank">http://newsharecounts.com/</a> or <a href="http://opensharecount.com/" target="_blank">http://opensharecount.com/</a>'.$counter_redirect, 'essb'), $listOfOptions, '', '6');
//ESSBOptionsStructureHelper::structure_section_end('social', 'sharing-3');
ESSBOptionsStructureHelper::structure_row_end('social', 'counters-6');
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'counters-6', 'facebook_counter_token', __('Facebook access token key', 'essb'), __('To avoid missing Facebook share counter due to rate limits we recommend to fill access token key. Access token generation of counter can work only when you do not use real time counters. To generate your access token key please visit <a href="http://tools.creoworx.com/facebook/" target="_blank">http://tools.creoworx.com/facebook/</a> and follow instructions to generate application based token', 'essb'), '', '', '', '', '6');
$listOfOptions = array ("" => "API Endpoint #1", "api2" => "API Endpoint #2");
ESSBOptionsStructureHelper::field_select('social', 'counters-6', 'facebook_counter_api', __('Facebook counter update API', 'essb'), __('Facebook have right now several active API endpoints that you can use to get share counter. The default is API Endpoint #1 but if you experience issue with counters try also API Endpoint #2', 'essb'), $listOfOptions, '', '6');
ESSBOptionsStructureHelper::structure_row_start('social', 'counters-6');
ESSBOptionsStructureHelper::structure_row_end('social', 'counters-6');

ESSBOptionsStructureHelper::structure_row_start('social', 'counters-6');
ESSBOptionsStructureHelper::structure_section_start('social', 'counters-6', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'counters-6', 'active_internal_counters', __('Activate internal counters for all networks that does not support API count', 'essb'), __('Activate internal
		counters for all networks that does not have access to API
		counter functions. If this option is active counters are stored
		in each post/page options and may be different from actual', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '9');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-6');

ESSBOptionsStructureHelper::structure_section_start('social', 'counters-6', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'counters-6', 'deactive_internal_counters_mail', __('Deactivate counters for Mail & Print', 'essb'), __('Enable this option if you wish to deactivate internal counters for mail & print buttons. That buttons are in the list of default social networks that support counters. Deactivating them will lower down request to internal WordPress AJAX event.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '9');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-6');

ESSBOptionsStructureHelper::structure_row_end('social', 'counters-6');

$counter_value_mode = array("" => __('Automatically shorten values above 1000', 'essb'), 'full' => __('Always display full value (default server settings)', 'essb'), 'fulldot' => __('Always display full value - dot thousand separator (example 5.000)', 'essb'), 'fullcomma' => __('Always display full value - comma thousand separator (example 5,000)', 'essb'), 'fullspace' => __('Always display full value - space thousand separator (example 5 000)', 'essb'));
ESSBOptionsStructureHelper::field_select('social', 'counters-6', 'counter_format', __('Share counter format', 'essb'), __('Choose how you wish to present your share counter value - short number of full number. This option will not work if you use real time share counters - in this mode you will always see short number format.', 'essb'), $counter_value_mode, '', '6');
ESSBOptionsStructureHelper::field_switch('social', 'counters-6', 'animate_single_counter', __('Animate Numbers', 'essb'), __('Enable this option to apply nice animation of counters on appear.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');

ESSBOptionsStructureHelper::panel_end('social', 'counters-6');



ESSBOptionsStructureHelper::field_heading('social', 'counters-7', 'heading5', __('Total Counter', 'essb'));
if ($positions_with_custom_settings != '') {
	ESSBOptionsStructureHelper::hint('social', 'counters-7', __('Exist position based style settings', 'essb'), 'We found that you have personalized styles for position/s <b>'.$positions_with_custom_settings.'</b>. All changes that you made in here will not reflect <b>'.$positions_with_custom_settings.'</b> buttons style - to make a change for those positions you need to use location based settings (or deactivate personalization by location).', 'fa21 mr10 ti-info-alt', 'blue');
}
$current_counter_positions = essb_avaiable_total_counter_position();
$mixed_radio = array();
foreach ($current_counter_positions as $key => $text) {
	if ($key != 'hidden') {
		$mixed_radio [$key] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=1 demo_counter="yes" total_counter_pos="'.$key.'" counter_pos="hidden" align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Share" twitter_text="Tweet" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>".$text."</b>" );
	}
	else {
		$mixed_radio [$key] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=1 demo_counter="yes" total_counter_pos="'.$key.'" counter_pos="insidename" align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Share" twitter_text="Tweet" flex="no" autowidth="yes" native="no" url="http://socialsharingplugin.com"]', "label" => "<b>".$text."</b>" );
	}
}
ESSBOptionsStructureHelper::field_html_radio('social', 'counters-7', 'total_counter_pos', __('', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), $mixed_radio, '', 'true', '300px');

ESSBOptionsStructureHelper::panel_start('social', 'counters-7', __('Configure total counter', 'essb'), __('Once you choose your total counter position you will find here all required fields to customize its look (change of text, number format or icon)', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::structure_row_start('social', 'counters-7');
ESSBOptionsStructureHelper::structure_section_start('social', 'counters-7', 'c6');
ESSBOptionsStructureHelper::field_textbox('social', 'counters-7', 'counter_total_text', __('Change total text', 'essb'), __('This option allows you to change text Total that appear when left/right position of total counter is selected.', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-7');

ESSBOptionsStructureHelper::structure_section_start('social', 'counters-7', 'c6');
ESSBOptionsStructureHelper::field_textbox('social', 'counters-7', 'activate_total_counter_text', __('Append text to total counter when big number styles are active', 'essb'), __('This option allows you to add custom text below counter when big number styles are active. For example you can add text shares.', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-7');
ESSBOptionsStructureHelper::structure_row_end('social', 'counters-7');

ESSBOptionsStructureHelper::structure_row_start('social', 'counters-7');
ESSBOptionsStructureHelper::structure_section_start('social', 'counters-7', 'c6');
ESSBOptionsStructureHelper::field_textbox('social', 'counters-7', 'total_counter_afterbefore_text', __('Change total counter text when before/after styles are active', 'essb'), __('Customize the text that is displayed in before/after share buttons display method. To display the total share number use the string {TOTAL} in text. Example: {TOTAL} users share us', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'counters-7');
ESSBOptionsStructureHelper::structure_section_start('social', 'counters-7', 'c6');
$essb_available_buttons_width = array();
$essb_available_buttons_width ['share'] = array ("image" => '<div class="fa21 essb_icon_share"></div>', "label" => "" );
$essb_available_buttons_width ['share-alt-square'] = array ("image" => '<div class="fa21 essb_icon_share-alt-square"></div>', "label" => "" );
$essb_available_buttons_width ['share-alt'] = array ("image" => '<div class="fa21 essb_icon_share-alt"></div>', "label" => "" );
$essb_available_buttons_width ['share-tiny'] = array ("image" => '<div class="fa21 essb_icon_share-tiny"></div>', "label" => "" );
$essb_available_buttons_width ['share-outline'] = array ("image" => '<div class="fa21 essb_icon_share-outline"></div>', "label" => "" );
ESSBOptionsStructureHelper::field_html_radio_buttons('social', 'counters-7', 'activate_total_counter_icon', __('Total counter icon', 'essb'), __('Options is applied when total counter with icon is selected', 'essb'), $essb_available_buttons_width, '', '', '26px');

ESSBOptionsStructureHelper::structure_section_end('social', 'counters-7');
ESSBOptionsStructureHelper::structure_row_end('social', 'counters-7');
$counter_value_mode = array("" => __('Automatically shorten values above 1000', 'essb'), 'full' => __('Always display full value (default server settings)', 'essb'), 'fulldot' => __('Always display full value - dot thousand separator (example 5.000)', 'essb'), 'fullcomma' => __('Always display full value - comma thousand separator (example 5,000)', 'essb'), 'fullspace' => __('Always display full value - space thousand separator (example 5 000)', 'essb'));
ESSBOptionsStructureHelper::field_select('social', 'counters-7', 'total_counter_format', __('Total counter format', 'essb'), __('Choose how you wish to present your share counter value - short number of full number. This option will not work if you use real time share counters - in this mode you will always see short number format', 'essb'), $counter_value_mode);
ESSBOptionsStructureHelper::field_switch('social', 'counters-7', 'total_counter_all', __('Always generate total counter based on all social networks', 'essb'), __('Enable this option if you wish to see total counter generated based on all installed in plugin social networks no matter of ones you have active. Default plugin setup is made to show total counter based on active for display social networks only and using different social networks on different locations may cause to have difference in total counter. Use this option to make it always be the same.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');
ESSBOptionsStructureHelper::field_switch('social', 'counters-7', 'animate_total_counter', __('Animate Numbers', 'essb'), __('Enable this option to apply nice animation of counters on appear.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');

ESSBOptionsStructureHelper::panel_end('social', 'counters-7');

//ESSBOptionsStructureHelper::field_heading('social', 'sharing-3', 'heading5', __('Advanced counter settings', 'essb'));

ESSBOptionsStructureHelper::panel_start('social', 'counters-8', __('Advanced counter update options', 'essb'), __('Configure different advanced counter update functions of plugin when you use real time or cached counters', 'essb'), 'fa21 fa fa-refresh', array("mode" => "toggle", 'state' => 'opened'));
//ESSBOptionsStructureHelper::field_heading('social', 'counters-8', 'heading5', __('Cached counters', 'essb'));
//ESSBOptionsStructureHelper::field_switch('social', 'counters-8', 'cache_counter_refresh_cache', __('Activate cache plugin update mode', 'essb'), __('Activate this option if you use cache plugin and counters do not update often', 'essb'), 'yes', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_heading('social', 'counters-8', 'heading5', __('Real time counters', 'essb'));
ESSBOptionsStructureHelper::field_section_start('social', 'counters-8', __('Counter update options for all networks that does not provide direct access to counter API or does not have share counter and uses internal counters', 'essb'), __('', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'counters-8', 'force_counters_admin', __('Load counters for social networks without direct access to counter API with build-in WordPress AJAX functions (using AJAX settings)', 'essb'), __('This method is more secure and required by some hosting companies but may slow down page load.', 'essb'), 'yes', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("wp" => "Build in WordPress ajax handler", "light" => "Light Easy Social Share Buttons handler");
ESSBOptionsStructureHelper::field_select('social', 'counters-8', 'force_counters_admin_type', __('AJAX load method', 'essb'), __('Choose the default ajax method from build in WordPress or light handler', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch('social', 'counters-8', 'force_counters_admin_single', __('Use single request of counter load for all social networks that uses the ajax handler', 'essb'), __('This method will make single call to AJAX handler to get all counters instead of signle call for each network. The pros of this option is that you will make less calls to selected AJAX handler. We suggest to use this option in combination with counters cache.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'counters-8');

ESSBOptionsStructureHelper::field_section_start('social', 'counters-8', __('Counter cache for AJAX load method', 'essb'), __('This will reduce load because counters will be updated when cache expires', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'counters-8', 'admin_ajax_cache', __('Activate', 'essb'), __('', 'essb'), 'yes', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'counters-8', 'admin_ajax_cache_time', __('Cache expiration time', 'essb'), __('Amount of seconds for cache (default is 600 if nothing is provided)', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'counters-8');

ESSBOptionsStructureHelper::panel_end('social', 'counters-8');

ESSBOptionsStructureHelper::field_heading('social', 'analytics-6', 'heading5', __('Activate build-in analytics', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'analytics-6', 'stats_active', __('Activate analytics and collect data for click over buttons', 'essb'), __('Build-in analytics is exteremly powerful tool which will let you to track how your visitors interact with share buttons. Get reports by positions, device type, social networks, for periods or for content', 'essb'), 'recommended', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('social', 'analytics-6', 'heading5', __('Google Analytics Tracking', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'analytics-6', 'activate_ga_tracking', __('Activate Google Analytics Tracking', 'essb'), __('Activate tracking of social share buttons click using Google Analytics (requires Google Analytics to be active on this site).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array ("simple" => "Simple", "extended" => "Extended" );
ESSBOptionsStructureHelper::field_select('social', 'analytics-6', 'ga_tracking_mode', __('Google Analytics Tracking Method', 'essb'), __('Choose your tracking method: Simple - track clicks by social networks, Extended - track clicks on separate social networks by button display position.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch('social', 'analytics-6', 'activate_ga_layers', __('Use Google Tag Manager Data Layer Event Tracking', 'essb'), __('Activate this option if you use Google Tag Manager to add analytics code and you did not setup automatic event tracking.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'analytics-6', 'activate_ga_campaign_tracking', __('Add Custom Campaign parameters to your URLs', 'essb'), __('Paste your custom campaign parameters in this field and they will be automatically added to shared addresses on social networks. Please note as social networks count shares via URL as unique key this option is not compatible with active social share counters as it will make the start from zero.', 'essb'));
ESSBOptionsStructureHelper::hint('social', 'analytics-6', '', essb3_text_analytics());

ESSBOptionsStructureHelper::hint('social', 'optimize-7', __('Optimize your social share message on all social networks', 'essb'), __('Social Sharing Optimization is important for each site. Without using it you have no control over shared information on social networks. We highly recommend to activate it (Facebook sharing tags are used on almost all social networks so they are the minimal required).', 'essb'), 'fa21 mr10 fa fa-info');

ESSBOptionsStructureHelper::panel_start('social', 'optimize-7', __('Homepage settings', 'essb'), __('Configure global homepage share options that will be used on your homepage when it is not a static page (page generated from list of posts or dynamic generated page by theme). Those settings will work only when one of options below is active.', 'essb'), 'fa21 fa fa-home', array("mode" => "toggle", 'state' => 'closed-no'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize-7', 'sso_frontpage_title', __('Title', 'essb'), __('Title that will be displayed on frontpage.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize-7', 'sso_frontpage_description', __('Description', 'essb'), __('Description that will be displayed on frontpage', 'essb'));
ESSBOptionsStructureHelper::field_image('social', 'optimize-7', 'sso_frontpage_image', __('Image', 'essb'), __('Image that will be displayed on frontpage', 'essb'), '', 'vertical1');
ESSBOptionsStructureHelper::panel_end('social', 'optimize-7');

ESSBOptionsStructureHelper::panel_start('social', 'optimize-7', __('Facebook Open Graph Tags (Used by most social networks)', 'essb'), __('Open Graph meta tags are used to optimize social sharing. This option will include following tags og:title, og:description, og:url, og:image, og:type, og:site_name.', 'essb'), 'fa21 fa fa-facebook', array("mode" => "switch", 'switch_id' => 'opengraph_tags', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize-7', 'opengraph_tags_fbpage', __('Facebook Page URL', 'essb'), __('Provide your Facebook page address.', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'optimize-7', 'opengraph_tags_fbadmins', __('Facebook Admins', 'essb'), __('Enter IDs of Facebook Users that are admins of current page.', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'optimize-7', 'opengraph_tags_fbapp', __('Facebook Application ID', 'essb'), __('Enter ID of Facebook Application to be able to use Facebook Insights', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize-7', 'opengraph_tags_fbauthor', __('Facebook Author Profile', 'essb'), __('Add link to Facebook profile page of article author if you wish it to appear in shared information.', 'essb'));
ESSBOptionsStructureHelper::field_file('social', 'optimize-7', 'sso_default_image', __('Default share image', 'essb'), __('Default share image will be used when page or post doesn\'t have featured image or custom setting for share image.', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'optimize-7', 'sso_httpshttp', __('Use http version of page in social tags', 'essb'), __('If you recently move from http to https and realize that shares are gone please activate this option and check are they back. In case this does not help contact us in support system <a href="http://support.creoworx.com" target="_blank">http://support.creoworx.com</a> for addtional instructions', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'optimize-7', 'sso_apply_the_content', __('Extract full content when generating description', 'essb'), __('If you see shortcodes in your description activate this option to extract as full rendered content. <br/><b>Warning! Activation of this option may affect work of other plugins or may lead to missing share buttons. If you notice something that is not OK with site immediately deactivate it.</b>', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'optimize-7', 'sso_imagesize', __('Generate image size tags', 'essb'), __('Image size tags are not required - they are optional but in some cases without them Facebook may not recongnize the correct image. In case this happens to you try activating this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'optimize-7', 'sso_multipleimages', __('Allow more than one share image', 'essb'), __('This option will allow to choose up to 5 additional images on each post that will appear in social share optimization tags.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'optimize-7');

ESSBOptionsStructureHelper::panel_start('social', 'optimize-7', __('Automatically generate and insert Twitter Cards meta tags for post/pages', 'essb'), __('To allow Twitter Cards data appear in your Tweets you need to validate your site after activation of that option in Twitter Card Validator', 'essb'), 'fa21 fa fa-twitter', array("mode" => "switch", 'switch_id' => 'twitter_card', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_textbox('social', 'optimize-7', 'twitter_card_user', __('Twitter Site Username', 'essb'), __('Enter your Twitter site username.', 'essb'));
$listOfOptions = array ("summary" => "Summary", "summaryimage" => "Summary with image" );
ESSBOptionsStructureHelper::field_select('social', 'optimize-7', 'twitter_card_type', __('Twitter Card Type', 'essb'), __('Choose the default card type that should be generated.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::panel_end('social', 'optimize-7');

// Google Schema is removed in version 4
/*ESSBOptionsStructureHelper::field_heading('social', 'optimize-7', 'heading2', __('Google Schema.org', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'optimize-7', 'sso_google_author', __('Activate Google Authorship and Publisher Markup', 'essb'), __('When active Google Authorship will appear only on posts from your blog - usage of authorship requires you to sign up to Google Authoship program at this address: https://plus.google.com/authorship. Publisher markup will be included on all pages and posts where it is activated.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize-7', 'ss_google_author_profile', __('Google+ Author Page', 'essb'), __('Put link to your Goolge+ Profile (example: https://plus.google.com/[Google+_Profile]/posts)', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize-7', 'ss_google_author_publisher', __('Google+ Publisher Page', 'essb'), __('Put link to your Google+ Page (example: https://plus.google.com/[Google+_Page_Profile])', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'optimize-7', 'sso_google_markup', __('Include Google Schema.org base markup', 'essb'), __('This will include minimal needed markup for Google schema.org (name, description and image)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
*/

ESSBOptionsStructureHelper::panel_start('social', 'advanced-8', __('Activate custom share message', 'essb'), __('Activation of custom share message will make all social buttons that are automatically generated on site to share it.', 'essb'), 'fa21 fa fa-share', array("mode" => "switch", 'switch_id' => 'customshare', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::hint('social', 'advanced-8', '', 'Most of social share networks support only URL as option that is used to generated shared information. Puting custom share URL will be enough and all customizations that are needed should be made with social share optimization tags that will be applied on that address.');
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'advanced-8', 'customshare_text', __('Custom Share Message', 'essb'), __('This option allows you to pass custom message to share (not all networks support this).', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'advanced-8', 'customshare_url', __('Custom Share URL', 'essb'), __('This option allows you to pass custom url to share (all networks support this).', 'essb'));
ESSBOptionsStructureHelper::field_file('social', 'advanced-8', 'customshare_image', __('Custom Share Image', 'essb'), __('This option allows you to pass custom image to your share message (only Facebook and Pinterest support this).', 'essb'));
ESSBOptionsStructureHelper::field_textarea('social', 'advanced-8', 'customshare_description', __('Custom Share Description', 'essb'), __('This option allows you to pass custom extended description to your share message (only Facebok and Pinterest support this).', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'advanced-8');

ESSBOptionsStructureHelper::field_heading('social', 'advanced-9', 'heading4', __('myCred Integration', 'essb'));
ESSBOptionsStructureHelper::field_heading('social', 'advanced-9', 'heading5', __('Award users for clicking on share button', 'essb'));
ESSBOptionsStructureHelper::field_section_start_panels('social', 'advanced-9', __('Integration via points for click on links', 'essb'), __('Award users for click on share buttons using the build in hook for click on links inside myCred', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('social', 'advanced-9', 'mycred_activate', __('Activate myCred integration for click on links', 'essb'), __('In order to work the myCred integration you need to have myCred Points for click on links hook activated (if you use custom points group you need to activated inside custom points group settings).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'advanced-9', 'mycred_points', __('myCred reward points for share link click', 'essb'), __('Provide custom points to reward user when share link. If nothing is provided 1 point will be included.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'advanced-9', 'mycred_group', __('myCred custom point type', 'essb'), __('Provide custom meta key for the points that user will get to share link. To create your own please visit this tutorial: <a href="http://codex.mycred.me/get-started/multiple-point-types/" target="_blank">http://codex.mycred.me/get-started/multiple-point-types/</a>. Leave blank to use the default (mycred_default)', 'essb'));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'advanced-9');
ESSBOptionsStructureHelper::field_section_start_panels('social', 'advanced-9', __('Integration via Easy Social Share Buttons hook', 'essb'), __('Award users for click on share buttons using the custom hook for points for social sharing', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('social', 'advanced-9', 'mycred_activate_custom', __('Activate myCred integration for points for social sharing', 'essb'), __('Use Easy Social Share Buttons custom hook in myCred to award points for click on share buttons', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'advanced-9');
ESSBOptionsStructureHelper::field_heading('social', 'advanced-9', 'heading5', __('Award users when someone uses their share link', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'advanced-9', 'mycred_referral_activate', __('Activate myCred Referral usage', 'essb'), __('That option requires you to have the Points for referrals hook enabled. That option is not compatible with share counters because adding referral id to url will reset social share counters to zero.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'advanced-9', 'mycred_referral_activate_shortcode', __('Activate myCred Referral usage in shortcodes', 'essb'), __('Activate this option in combination with referrals hook to allow affiliate ID appear also when you use shortcodes.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('social', 'advanced-9', 'heading4', __('AffiliateWP Integration', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('social', 'advanced-9');
ESSBOptionsStructureHelper::field_switch_panel('social', 'advanced-9', 'affwp_active', __('Append Affiliate ID to shared address', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated. You need to have installed AffiliateWP plugin to use it: <a href="https://affiliatewp.com/" target="_blank">https://affiliatewp.com/</a>', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("id" => "User ID", "name" => "Username");
ESSBOptionsStructureHelper::field_select_panel('social', 'advanced-9', 'affwp_active_mode', __('ID Append Mode', 'essb'), __('Choose between usage of user id or username when you add affiliate id to outgoing shares.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch_panel('social', 'advanced-9', 'affwp_active_shortcode', __('Append Affiliate ID to custom shared address in shortcodes', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated when shortcode has a custom url parameter.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('social', 'advanced-9', 'affwp_active_pretty', __('Use pretty affiliate URLs', 'essb'), __('Activate this option if you already have make it active inside AffiliateWP to allow Easy Social Share Buttons generate pretty affiliate URLs.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('social', 'advanced-9');

ESSBOptionsStructureHelper::field_heading('social', 'advanced-9', 'heading4', __('Affiliates Integration', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('social', 'advanced-9');
ESSBOptionsStructureHelper::field_switch_panel('social', 'advanced-9', 'affs_active', __('Append Affiliate ID to shared address', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated. You need to have installed Affiliates plugin to use it: <a href="https://wordpress.org/plugins/affiliates/" target="_blank">https://wordpress.org/plugins/affiliates/</a>', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('social', 'advanced-9', 'affs_active_shortcode', __('Append Affiliate ID to custom shared address in shortcodes', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated when shortcode has a custom url parameter.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('social', 'advanced-9');


// message above/before buttons
ESSBOptionsStructureHelper::panel_start('social', 'advanced-14', __('User message before share buttons', 'essb'), __('Enter custom message that will appear before your share buttons (html code supported)', 'essb'), 'fa21 fa fa-comment-o', array("mode" => "toggle", 'state' => 'closed'));


//ESSBOptionsStructureHelper::field_heading('display', 'message-1', 'heading4', __('Static resource load optimizations', 'essb'));
ESSBOptionsStructureHelper::field_editor('social', 'advanced-14', 'message_share_before_buttons', __('Message before share buttons', 'essb'), __('You can use following variables to create personalized message: %%title%% - displays current post title, %%permalink%% - displays current post address.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_html_checkbox_buttons('social', 'advanced-14', 'message_share_before_buttons_on', __('Message will appear on', 'essb'), __('Choose device types where you wish message to appear. Leave blank for all type of devices', 'essb'), essb_device_select(), '', '', '26px');
ESSBOptionsStructureHelper::panel_end('social', 'advanced-14');

ESSBOptionsStructureHelper::panel_start('social', 'advanced-14', __('User message above share buttons', 'essb'), __('Enter custom message that will appear above your share buttons (html code supported)', 'essb'), 'fa21 fa fa-comment-o', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_editor('social', 'advanced-14', 'message_above_share_buttons', __('Message above share buttons', 'essb'), __('You can use following variables to create personalized message: %%title%% - displays current post title, %%permalink%% - displays current post address.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_html_checkbox_buttons('social', 'advanced-14', 'message_above_share_buttons_on', __('Message will appear on', 'essb'), __('Choose device types where you wish message to appear. Leave blank for all type of devices', 'essb'), essb_device_select(), '', '', '26px');
ESSBOptionsStructureHelper::panel_end('social', 'advanced-14');

ESSBOptionsStructureHelper::panel_start('social', 'advanced-14', __('User message above native buttons', 'essb'), __('Enter custom message that will appear above your native buttons (html code supported)', 'essb'), 'fa21 fa fa-comment-o', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_editor('social', 'advanced-14', 'message_like_buttons', __('Message above like buttons', 'essb'), __('You can use following variables to create personalized message: %%title%% - displays current post title, %%permalink%% - displays current post address.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_html_checkbox_buttons('social', 'advanced-14', 'message_like_buttons_on', __('Message will appear on', 'essb'), __('Choose device types where you wish message to appear. Leave blank for all type of devices', 'essb'), essb_device_select(), '', '', '26px');
ESSBOptionsStructureHelper::panel_end('social', 'advanced-14');

/*** Where to Display **/
ESSBOptionsStructureHelper::field_heading($where_to_display, 'posts', 'heading5', __('Choose post types to display buttons', 'essb'));
ESSBOptionsStructureHelper::field_func($where_to_display, 'posts', 'essb3_post_type_select', __('Where to display buttons', 'essb'), __('Choose post types where you wish buttons to appear. If you are running WooCommerce store you can choose between post type Products which will display share buttons into product description or option to display buttons below price.', 'essb'));
ESSBOptionsStructureHelper::panel_start($where_to_display, 'posts', __('Display in post excerpt', 'essb'), __('Activate this option if your theme is using excerpts and you wish to display share buttons in excerpts', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'display_excerpt', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
//ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'display_excerpt', __('Activate', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("top" => "Before excerpt", "bottom" => "After excerpt");
ESSBOptionsStructureHelper::field_select($where_to_display, 'posts', 'display_excerpt_pos', __('Buttons position in excerpt', 'essb'), __(''), $listOfOptions);
ESSBOptionsStructureHelper::panel_end($where_to_display, 'posts');

ESSBOptionsStructureHelper::field_heading($where_to_display, 'posts', 'heading5', __('Deactivate display on', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'posts', 'display_exclude_from', __('Exclude automatic display on', 'essb'), __('Exclude buttons on posts/pages with these IDs. Comma separated: "11, 15, 125". This will deactivate automated display of buttons on selected posts/pages but you are able to use shortcode on them.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'posts', 'display_deactivate_on', __('Deactivate plugin on', 'essb'), __('Deactivate buttons on posts/pages with these IDs. Comma separated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts. Plugin also allows to deactivate only specific functions on selected page/post ids. <a href="'.admin_url('admin.php?page=essb_redirect_advanced&tab=advanced&section=deactivate&subsection').'">Click here</a> to to that settings page.', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'deactivate_homepage', __('Deactivate buttons display on homepage', 'essb'), __('Exclude display of buttons on home page.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch('display', 'settings-1', 'deactivate_lists', __('Deactivate load of plugin resources on list of articles', 'essb'), __('Activate this option to stop load plugin resources on list of articles.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('social', 'settings-1', 'heading5', __('Automatic display on', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'posts', 'display_include_on', __('Automatic display buttons on', 'essb'), __('Provide list of post/page ids where buttons will display no matter that post type is active or not. Comma seperated values: "11, 15, 125". This will eactivate automated display of buttons on selected posts/pages even if post type that they use is not marked as active.', 'essb'));


ESSBOptionsStructureHelper::panel_start($where_to_display, 'posts', __('WooCommerce', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed"));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'woocommece_share', __('Default WooCommerce hook for share buttons (after product brief description)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'woocommerce_after_add_to_cart_form', __('After add to cart button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'woocommece_beforeprod', __('Display buttons on top of product (before product)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'woocommece_afterprod', __('Display buttons at the bottom of product (after product)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end($where_to_display, 'posts');

ESSBOptionsStructureHelper::panel_start($where_to_display, 'posts', __('WP e-Commerce', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed"));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'wpec_before_desc', __('Display before product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'wpec_after_desc', __('Display after product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'wpec_theme_footer', __('Display at the bottom of page', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end($where_to_display, 'posts');

ESSBOptionsStructureHelper::panel_start($where_to_display, 'posts', __('JigoShop', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed"));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'jigoshop_top', __('JigoShop Before Product', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'jigoshop_bottom', __('JigoShop After Product', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end($where_to_display, 'posts');

ESSBOptionsStructureHelper::panel_start($where_to_display, 'posts', __('iThemes Exchange', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed"));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'ithemes_after_title', __('Display after product title', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'ithemes_before_desc', __('Display before product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'ithemes_after_desc', __('Display after product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'ithemes_after_product', __('Display after product advanced content (after product information)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'ithemes_after_purchase', __('Display share buttons for each product after successful purchase (when shopping cart is used)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end($where_to_display, 'posts');

ESSBOptionsStructureHelper::panel_start($where_to_display, 'posts', __('bbPress', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed"));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'bbpress_forum', __('Display in forums', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'bbpress_topic', __('Display in topics', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end($where_to_display, 'posts');

ESSBOptionsStructureHelper::panel_start($where_to_display, 'posts', __('BuddyPress', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed"));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'buddypress_activity', __('Display in activity', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'buddypress_group', __('Display on group page', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end($where_to_display, 'posts');

// positions
ESSBOptionsStructureHelper::hint($where_to_display, 'display-2', __('Simplify interface and remove unused positions', 'essb'), __('Did you know that you can deactivate the positions you do not use on site. To do this go to <b>Advanced Settings -> Deactivate Functions & Modules</b>. Deactivating positions you do not use will simplify the settings screen and you can activate them again at any time from the same settings screen.', 'essb'), 'fa21 fa fa-info-circle');
ESSBOptionsStructureHelper::structure_row_start($where_to_display, 'display-2');
ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'display-2', 'c12', __('Primary content display position', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'));
ESSBOptionsStructureHelper::field_image_radio($where_to_display, 'display-2', 'content_position', '', '', essb_avaliable_content_positions());
ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'display-2');
ESSBOptionsStructureHelper::structure_row_end($where_to_display, 'display-2');

ESSBOptionsStructureHelper::structure_row_start($where_to_display, 'display-2');
ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'display-2', 'c12', __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'));
ESSBOptionsStructureHelper::field_image_checkbox($where_to_display, 'display-2', 'button_position', '', '', essb_available_button_positions());
ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'display-2');
ESSBOptionsStructureHelper::structure_row_end($where_to_display, 'display-2');

add_action('admin_init', 'essb3_register_positions_by_posttypes');
essb_prepare_location_advanced_customization($where_to_display, 'display-4', 'top');
essb_prepare_location_advanced_customization($where_to_display, 'display-5', 'bottom');

if (!essb_options_bool_value('deactivate_method_float')) {
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-6', __('Set custom top position of float bar', 'essb'), __('If your current theme has fixed bar or menu you may need to provide custom top position of float or it will be rendered below this sticked bar. For example you can try with value 40 (which is equal to 40px from top).', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_top', __('Top position for non logged in users', 'essb'), __('', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_top_loggedin', __('Top position for logged in users', 'essb'), __('If you display WordPress admin bar for logged in users you can correct float from top position for logged in users to avoid bar to be rendered below WordPress admin bar.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_top_disappear', __('Hide buttons after percent of content is viewed', 'essb'), __('Provide value in percent if you wish to hide float bar - for example 80 will make bar to disappear when 80% of page content is viewed from user.', 'essb'), '', 'input60', 'fa-sort-numeric-asc', 'right');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-6');
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-6', __('Background color', 'essb'), __('Change default background color of float bar (default is white #FFFFFF).', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-6', 'float_bg', __('Choose background color', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_bg_opacity', __('Change opacity of background color', 'essb'), __('Change default opacity of background color if you wish to have a semi-transparent effect (default is 1 full color). You can enter value between 0 and 1 (example: 0.7)', 'essb'), '', 'input60');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-6');
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-6', __('Width and positioning settings', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-6', 'float_full', __('Set full width of float bar', 'essb'), __('This option will make float bar to take full width of browser window.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_full_maxwidth', __('Max width of buttons area', 'essb'), __('Provide custom max width of buttons area when full width float bar is active. Provide number value in pixels without the px (example 960)', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-6', 'float_remove_margin', __('Remove top space', 'essb'), __('This option will clear the blank space that may appear according to theme settings between top of window and float bar.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-6');
	essb_prepare_location_advanced_customization($where_to_display, 'display-6', 'float');
}

if (!essb_options_bool_value('deactivate_method_postfloat')) {
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-7');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_initialtop', __('Custom top position of post float bar when loaded', 'essb'), __('Customize the initial top position of post float bar if you wish to be different from content start.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_top', __('Top position of post float buttons when they are fixed', 'essb'), __('Filled value to change the top position if you have another fixed element (example: fixed menu).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_marginleft', __('Horizontal offset from content', 'essb'), __('You can provide custom left offset from content. Leave blank to use default value.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_margintop', __('Vertical offset from content start', 'essb'), __('You can provide custom vertical offset from content start. Leave blank to use default value. (Negative values moves up, positve moves down).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_percent', __('Display after percent of content is passed', 'essb'), __('Provide percent of content to viewed when buttons will appear (default state if this field is provided will be hidden for that display method).', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-7', 'postfloat_always_visible', __('Do not hide post vertical float at the end of content', 'essb'), __('Activate this option to make post vertical float stay on screen when end of post content is reached.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-7');
	essb_prepare_location_advanced_customization($where_to_display, 'display-7', 'postfloat');
}

if (!essb_options_bool_value('deactivate_method_sidebar')) {
	$listOfOptions = array("" => "Left", "right" => "Right");
	ESSBOptionsStructureHelper::field_select($where_to_display, 'display-8', 'sidebar_pos', __('Sidebar Appearance', 'essb'), __('You choose different position for sidebar. Available options are Left (default), Right', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-8', __('Left or Right sidebar appearance options', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_fixedleft', __('Customize left/right position of sidebar', 'essb'), __('Use this field to change initial position of sidebar. You can use numeric value for example 10.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_fixedtop', __('Fixed top position of sidebar', 'essb'), __('You can provide custom top position of sidebar in pixels or percents (ex: 100px, 15%).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_leftright_percent', __('Display after percent of content is viewed', 'essb'), __('If you wish to make sidebar appear after percent of content is viewed enter value here (leave blank to appear immediately after load).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_leftright_percent_hide', __('Hide after percent of content is viewed', 'essb'), __('If you wish to make sidebar disappear after percent of content is viewed enter value here (leave blank to make it always be visible).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-8', 'sidebar_leftright_close', __('Add close sidebar button', 'essb'), __('Activate that option to add a close sidebar button.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	$sidebar_loading_animations = array("" => __("No animation", "essb"), "slide" => __("Slide", "essb"), "fade" => __("Fade", "essb"));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-8', 'sidebar_entry_ani', __('Display animation', 'essb'), __('Assign sidebar initial appearance animation - a nice way to catch visitors attention.', 'essb'), $sidebar_loading_animations);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-8');
	essb_prepare_location_advanced_customization($where_to_display, 'display-8', 'sidebar');
}

if (!essb_options_bool_value('deactivate_method_topbar')) {
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-9', __('Top bar appearance', 'essb'), __('If your current theme has fixed bar or menu you may need to provide custom top position of top bar or it will be rendered below this sticked bar. For example you can try with value 40 (which is equal to 40px from top).', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_top', __('Top position for non logged in users', 'essb'), __('', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_top_loggedin', __('Top position for logged in users', 'essb'), __('f you display WordPress admin bar for logged in users you can correct float from top position for logged in users to avoid bar to be rendered below WordPress admin bar.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_top_onscroll', __('Appear after percent of content is viewed', 'essb'), __('If you wish top bar to appear when user starts scrolling fill here percent of conent after is viewed it will be visible.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_hide', __('Hide buttons after percent of content is viewed', 'essb'), __('Provide value in percent if you wish to hide float bar - for example 80 will make bar to disappear when 80% of page content is viewed from user.', 'essb'), '', 'input60', 'fa-sort-numeric-asc', 'right');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-9');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-9', __('Background color', 'essb'), __('Change default background color of top bar (default is white #FFFFFF).', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-9', 'topbar_bg', __('Choose background color', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_bg_opacity', __('Change opacity of background color', 'essb'), __('Change default opacity of background color if you wish to have a semi-transparent effect (default is 1 full color). You can enter value between 0 and 1 (example: 0.7)', 'essb'), '', 'input60');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-9');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-9', __('Top bar width, height & placement', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_height', __('Height of top bar content area', 'essb'), __('Provide custom height of content area. Provide number value in pixels without the px (example 40). Leave blank for default height.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_maxwidth', __('Max width of content area', 'essb'), __('Provide custom max width of content area. Provide number value in pixels without the px (example 960). Leave blank for full width.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	$listOfOptions = array("left" => "Left", "center" => "Center", "right" => "Right");
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-9', 'topbar_buttons_align', __('Align buttons', 'essb'), __('Choose your button alignment', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-9');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-9', __('TOP BAR CUSTOM CONTENT SETTINGS', 'essb'), __('Include custom content into top bar along with your share buttons'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'topbar_contentarea', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-9', __('Background color', 'essb'), __('Change default background color of top bar (default is white #FFFFFF).', 'essb'));
	$listOfOptions = array("left" => "Left", "right" => "Right");
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_contentarea_width', __('Custom content area % width', 'essb'), __('Provide custom width of content area (default value if nothing is filled is 30 which means 30%). Fill number value without % mark - example 40.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-9', 'topbar_contentarea_pos', __('Custom content area position', 'essb'), __('Choose your content area alignment', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-9');
	ESSBOptionsStructureHelper::field_wpeditor($where_to_display, 'display-9', 'topbar_usercontent', __('Custom content', 'essb'), '', 'htmlmixed');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-9');
	//ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-9');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-9', 'topbar');
}

if (!essb_options_bool_value('deactivate_method_bottombar')) {

	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-10', __('Bottom bar appearance', 'essb'), __('Use to fit the buttons to the style of your footer area.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_top_onscroll', __('Appear after percent of content is viewed', 'essb'), __('If you wish bottom bar to appear when user starts scrolling fill here percent of conent after is viewed it will be visible.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_hide', __('Hide buttons after percent of content is viewed', 'essb'), __('Provide value in percent if you wish to hide float bar - for example 80 will make bar to disappear when 80% of page content is viewed from user.', 'essb'), '', 'input60', 'fa-sort-numeric-asc', 'right');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-10');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-10', __('Background color', 'essb'), __('Change default background color of bottom bar (default is white #FFFFFF).', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-10', 'bottombar_bg', __('Choose background color', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_bg_opacity', __('Change opacity of background color', 'essb'), __('Change default opacity of background color if you wish to have a semi-transparent effect (default is 1 full color). You can enter value between 0 and 1 (example: 0.7)', 'essb'), '', 'input60');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-10');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-10', __('Bottom bar width, height & placement', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_height', __('Height of top bar content area', 'essb'), __('Provide custom height of content area. Provide number value in pixels without the px (example 40). Leave blank for default value.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_maxwidth', __('Max width of content area', 'essb'), __('Provide custom max width of content area. Provide number value in pixels without the px (example 960). Leave blank for full width.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	$listOfOptions = array("left" => "Left", "center" => "Center", "right" => "Right");
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-10', 'bottombar_buttons_align', __('Align buttons', 'essb'), __('Choose your content area alignment', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-10');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-10', __('BOTTOM BAR CUSTOM CONTENT SETTINGS', 'essb'), __('Include custom content into bottom bar along with your share buttons'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'bottombar_contentarea', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-10', __('Bottom bar content settings', 'essb'), __('', 'essb'));
	$listOfOptions = array("left" => "Left", "right" => "Right");
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_contentarea_width', __('Custom content area % width', 'essb'), __('Provide custom width of content area (default value if nothing is filled is 30 which means 30%). Fill number value without % mark - example 40.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-10', 'bottombar_contentarea_pos', __('Custom content area position', 'essb'), __('Choose your button alignment', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::field_wpeditor($where_to_display, 'display-10', 'bottombar_usercontent', __('Custom content', 'essb'), '', 'htmlmixed');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-10');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-10', 'bottombar');
}

if (!essb_options_bool_value('deactivate_method_popup')) {
	ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-11', __('Pop up window settings', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-11', 'popup_window_title', __('Pop up window title', 'essb'), __('Set your custom pop up window title.', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'display-11', 'popup_user_message', __('Pop up window message', 'essb'), __('Set your custom message that will appear above buttons', 'essb'), "htmlmixed");
	ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-11', 'popup_user_width', __('Pop up window width', 'essb'), __('Set your custom window width (default is 800 or window width - 60). Value if provided should be numeric without px symbols.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-11');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-11', __('Pop up window display', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_window_popafter', __('Display pop up window after (sec)', 'essb'), __('If you wish pop up window to appear after amount of seconds you can provide theme here. Leave blank for immediate pop up after page load.', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_user_percent', __('Display pop up window after percent of content is viewed', 'essb'), __('Set amount of page content after which the pop up will appear.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_end', __('Display pop up at the end of content', 'essb'), __('Automatically display pop up when the content end is reached', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_exit', __('Display pop up on exit intent', 'essb'), __('Automatically display pop up when exit intent is detected', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_comment', __('Display pop up on user comment', 'essb'), __('Automatically display pop up when user leave a comment.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_purchase', __('Display pop up after WooCommerce purchase', 'essb'), __('Display on Thank You page of WooCommerce after purchase', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_user_manual_show', __('Manual window display mode', 'essb'), __('Activating manual display mode will allow you to show window when you decide with calling following javascript function essb_popup_show();', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_avoid_logged_users', __('Do not show pop up for logged in users', 'essb'), __('Activate this option to avoid display of pop up when user is logged in into site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-11');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-11', __('Pop up window close', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_window_close_after', __('Automatically close pop up after (sec)', 'essb'), __('You can provide seconds and after they expire window will close automatically. User can close this window manually by pressing close button.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_user_autoclose', __('Close up message customize', 'essb'), __('Set custom text announcement for closing the pop up. After your text there will be timer counting the seconds leaving.', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_user_notshow_onclose', __('After user close window do not show it again on this page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on this post/page', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_user_notshow_onclose_all', __('After user close window do not show it again on all page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on all posts/pages', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-11');
	essb_prepare_location_advanced_customization($where_to_display, 'display-11', 'popup');
}

if (!essb_options_bool_value('deactivate_method_flyin')) {
	ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-12', __('Fly In window settings', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-12', 'flyin_window_title', __('Fly in window title', 'essb'), __('Set your custom fly in window title.', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'display-12', 'flyin_user_message', __('Fly in window message', 'essb'), __('Set your custom message that will appear above buttons', 'essb'), "htmlmixed");
	ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-12', 'flyin_user_width', __('Fly in window width', 'essb'), __('Set your custom window width (default is 400 or window width - 60). If value is provided should be numeric without px symbols.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	$listOfOptions = array("right" => "Right", "left" => "Left");
	ESSBOptionsStructureHelper::field_select($where_to_display, 'display-12', 'flyin_position', __('Choose fly in display position', 'essb'), '', $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-12');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-12', __('Fly in window display', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_window_popafter', __('Display fly in window after (sec)', 'essb'), __('If you wish fly in window to appear after amount of seconds you can provide them here. Leave blank for immediate pop up after page load.', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_user_percent', __('Display fly in window after percent of content is viewed', 'essb'), __('Set amount of page content after which the pop up will appear.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_display_end', __('Display fly in at the end of content', 'essb'), __('Automatically display fly in when the content end is reached.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_display_comment', __('Display fly in on user comment', 'essb'), __('Automatically display fly in when user leaves a comment.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_user_manual_show', __('Manual fly in display mode', 'essb'), __('Activating manual display mode will allow you to show window when you decide with calling following javascript function essb_flyin_show();', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-12');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-12', __('Fly in window close', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_window_close_after', __('Automatically close fly in after (sec)', 'essb'), __('You can provide seconds and after they expire window will close automatically. User can close this window manually by pressing close button.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_user_autoclose', __('Close up message customize', 'essb'), __('Set custom text announcement for closing the fly in. After your text there will be timer counting the seconds leaving.', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_user_notshow_onclose', __('After user closes window do not show it again on this page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on this post/page', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_user_notshow_onclose_all', __('After user close window do not show it again on all page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on all posts/pages', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-12');
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'display-12', 'flyin_noshare', __('Do not show share buttons in fly in', 'essb'), __('Activating this you will get a fly in display without share buttons in it - only the custom content you have set.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	essb_prepare_location_advanced_customization($where_to_display, 'display-12', 'flyin');
}

ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-13', __('On media buttons appearance', 'essb'), __('Choose where you wish buttons to appear', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-13', __('Appearance', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_selector', __('Default image share selector', 'essb'), __('Provide your own custom image selector that will allow to pickup share images. Leave blank for use the default or use <b>.essbis_site img</b> to allow share of any image on site.', 'essb'));
//ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-13', 'sis_dontshow', __('Do not show on', 'essb'), __('Set image classes and IDs for which on media display buttons won\'t show. Separate several selectors with commas.', 'essb'));
//ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-13', 'sis_dontaddclass', __('Do not move following classes', 'essb'), __('Provide image classes that you wish not to be moved to on media sharing element. If you use multiple selectors separate them with ,', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_minWidth', __('Minimal width', 'essb'), __('Minimum width of image for sharing. Use value without px.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_minHeight', __('Minimal height', 'essb'), __('Minimum height of image for sharing. Use value without px.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-13', 'sis_on_mobile', __('Enable on mobile', 'essb'), __('Enable image sharing on mobile devices', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-13');
ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-13');


ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-13', __('Use the following social buttons', 'essb'), __('Choose social buttons that you will use on media images', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));
$listOfNetworks = array( "facebook", "twitter", "google", "linkedin", "pinterest", "tumblr", "reddit", "digg", "delicious", "vkontakte", "odnoklassniki");
$listOfNetworksAdvanced = array( "facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google", "linkedin" => "LinkedIn", "pinterest" => "Pinterest", "tumblr" => "Tumblr", "reddit" => "Reddit", "digg" => "Digg", "delicious" => "Delicious", "vkontakte" => "VKontakte", "odnoklassniki" => "Odnoklassniki");
ESSBOptionsStructureHelper::field_checkbox_list($where_to_display, 'display-13', 'sis_networks', __('Activate networks', 'essb'), __('Choose active social networks', 'essb'), $listOfNetworksAdvanced);
ESSBOptionsStructureHelper::field_simplesort($where_to_display, 'display-13', 'sis_network_order', __('Display order', 'essb'), __('Arrange network appearance using drag and drop', 'essb'), $listOfNetworks);
//ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-13', __('Share Options', 'essb'), __('', 'essb'));
//ESSBOptionsStructureHelper::field_switch($where_to_display, 'display-13', 'sis_sharer', __('Share selected image<div class="essb-new"><span></span></div><div class="essb-beta"><span></span></div>', 'essb'), __('Activate this option to make plugin include selected image into share. Please note that activating that option will make share counter not to include that shares in it because url structure will change.<br/><br/>Please note that if you have long descriptions, titles or urls you will need <a href="http://appscreo.com/self-hosted-short-urls/" target="_blank"><b>Self-Hosted Short URLs add-on</b></a> for proper sharing.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch($where_to_display, 'display-13', 'sis_pinterest_alt', __('Use provided image alternative text for Pinterest share<div class="essb-new"><span></span></div><div class="essb-beta"><span></span></div>', 'essb'), __('Activate this option to allow Pinterest share take image alternative text as share description. If no alternative texts is provided it will use post title. If this option is not active Pinterest share will use post title.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-13');
ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-13');
ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-13', __('Visual display setup', 'essb'), __('Customize look and feel of your social share buttons that appear on images', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));

ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-13', __('Display Options', 'essb'), __('', 'essb'));
//ESSBOptionsStructureHelper::field_switch($where_to_display, 'display-13', 'sis_always_show', __('Always visible', 'essb'), __('Activate this option to make image share buttons be always visible on images.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

$list_of_positions =  array(
					'top-left'      => __( 'Top left', 'essb' ),
					'top-middle'    => __( 'Top middle', 'essb' ),
					'top-right'     => __( 'Top right', 'essb' ),
					'middle-left'   => __( 'Middle left', 'essb' ),
					'middle-middle' => __( 'Middle', 'essb' ),
					'middle-right'  => __( 'Middle right', 'essb' ),
					'bottom-left'   => __( 'Bottom left', 'essb' ),
					'bottom-middle' => __( 'Bottom middle', 'essb' ),
					'bottom-right'  => __( 'Bottom right', 'essb' ));

ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-13', 'sis_position', __('Choose position of buttons on image', 'essb'), __('Select default position of buttons over image. Depends on active buttons and template select the best to fit them into images', 'essb'), $list_of_positions);

$listOfTemplates = array("tiny" => "Tiny", "flat-small" => "Small", "flat" => "Regular", "round" => "Round");
ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-13', 'sis_style', __('Template', 'essb'), __('Choose buttons template. You can use only build into module templates to avoid misconfiguration', 'essb'), $listOfTemplates);
//$listOfOptions = array("left" => "Left", "right" => "Right", "center-x" => "Center");
//ESSBOptionsStructureHelper::field_select($where_to_display, 'display-13', 'sis_align_x', __('Horizontal Align', 'essb'), '', $listOfOptions);
//$listOfOptions = array("top" => "Top", "bottom" => "Bottom", "center-y" => "Center");
//ESSBOptionsStructureHelper::field_select('social', 'positions-30', 'sis_align_y', __('Vertical Align', 'essb'), '', $listOfOptions);
$listOfOptions = array("horizontal" => __("Horizontal", 'essb'), "vertical" => __("Vertical", 'essb'));
ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-13', 'sis_orientation', __('Orientation', 'essb'), __('Display buttons aligned horizontal or vertical', 'essb'), $listOfOptions);
//ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-13', 'sis_offset_x', __('Move buttons horizontally', 'essb'), __('Provide custom value if you wish to move buttons horizontally from the edge of image', 'essb'));
//ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-13', 'sis_offset_y', __('Move buttons vertically', 'essb'), __('Provide custom value if you wish to move buttons vertically from the edge of image.', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-13');
ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-13');

if (!essb_options_bool_value('deactivate_method_heroshare')) {
	ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-14', 'heroshare_user_width', __('Custom window width', 'essb'), __('Set your custom window width (default is 960 or window width - 60). Value if provided should be numeric without px symbols.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-14', __('Primary content area', 'essb'), __('Primary content area is located above post information and share details. You can use it to add custom title or message that will appear on top. Leave it blank if you do not wish to have such', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-14', 'heroshare_window_title', __('Window title', 'essb'), __('Set your custom pop up window title.', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'display-14', 'heroshare_user_message', __('Window message', 'essb'), __('Set your custom message that will appear above buttons', 'essb'), "htmlmixed");
	ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-14');
	
	ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-14', __('Additional content area', 'essb'), __('Additional content area is located below share buttons and provide various message types. If you do not wish to display it choose data type to html message and leave field for message blank', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-14', 'heroshare_second_title', __('Title', 'essb'), __('Set your custom pop up window title for additional content area.', 'essb'));
	$listOfOptions = array("top" => "Top social posts (require build in analytics to be active)", "fans" => "Followers counter (require followers counter to be activated)", "html" => "Custom HTML message");
	ESSBOptionsStructureHelper::field_select($where_to_display, 'display-14', 'heroshare_second_type', __('Type of displayed data', 'essb'), __('Choose what you wish to be displayed into second widget area below share buttons. If you wish to leave it blank choose Custom HTML message and do not fill anything inside field for custom message.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-14', 'heroshare_second_fans', __('Followers counter shortcode', 'essb'), __('Fill in this field you followers counter shortcode that will be used if you select in second widget area to have followers counter. Shortcode can be generated using shortcode generator.', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'display-14', 'heroshare_second_message', __('Custom HTML message', 'essb'), __('Set your custom message (for example html code for opt-in form). This field supports shortcodes.', 'essb'), "htmlmixed");
	ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-14');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-14', __('Hero share window display', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-14', 'heroshare_window_popafter', __('Display pop up window after (sec)', 'essb'), __('If you wish pop up window to appear after amount of seconds you can provide theme here. Leave blank for immediate pop up after page load.', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-14', 'heroshare_user_percent', __('Display pop up window after percent of content is viewed', 'essb'), __('Set amount of page content after which the pop up will appear.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-14', 'heroshare_display_end', __('Display pop up at the end of content', 'essb'), __('Automatically display pop up when the content end is reached', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-14', 'heroshare_display_exit', __('Display pop up on exit intent', 'essb'), __('Automatically display pop up when exit intent is detected', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-14', 'heroshare_user_manual_show', __('Manual window display mode', 'essb'), __('Activating manual display mode will allow you to show window when you decide with calling following javascript function essb_heroshare_show();', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-14', 'heroshare_avoid_logged_users', __('Do not show pop up for logged in users', 'essb'), __('Activate this option to avoid display of pop up when user is logged in into site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-14');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-14', __('Window close', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-14', 'heroshare_user_notshow_onclose', __('After user close window do not show it again on this page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on this post/page', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-14', 'heroshare_user_notshow_onclose_all', __('After user close window do not show it again on all page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on all posts/pages', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-14');
	essb_prepare_location_advanced_customization($where_to_display, 'display-14', 'heroshare');
}

if (!essb_options_bool_value('deactivate_method_postbar')) {
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-15', __('Deactivate default components', 'essb'), __('Deactivate default active display elements', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_deactivate_prevnext', __('Deactivate previous/next articles', 'essb'), __('Activate this option if you wish to deactivate display of previous/next article buttons', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_deactivate_progress', __('Deactivate read progress bar', 'essb'), __('Activate this option if you wish to deactivate display of read progress', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_deactivate_title', __('Deactivate post title', 'essb'), __('Activate this option if you wish to deactivate display of post title', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-15');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-15', __('Activate additional components', 'essb'), __('Activate additional display elements', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_category', __('Activate display of category', 'essb'), __('Activate this option if you wish to activate display of category', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_author', __('Activate display of post author', 'essb'), __('Activate this option if you wish to activate display of post author', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_total', __('Activate display of total shares counter', 'essb'), __('Activate this option if you wish to activate display of total shares counter', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_comments', __('Activate display of comments counter', 'essb'), __('Activate this option if you wish to activate display of comments counter', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_time', __('Activate display of time to read', 'essb'), __('Activate this option if you wish to activate display of time to read', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-15', 'postbar_activate_time_words', __('Words per minuted for time to read', 'essb'), __('Customize the words per minute for time to read display', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-15');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-15', __('Customize colors', 'essb'), __('Customize default colors of core components', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_bgcolor', __('Change default background color', 'essb'), __('Customize the default post bar background color (#FFFFFF)', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_color', __('Change default text color', 'essb'), __('Customize the default post bar text color (#111111)', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_accentcolor', __('Change default accent color', 'essb'), __('Customize the default post bar accent color (#3D8EB9)', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_altcolor', __('Change default alt text color', 'essb'), __('Customize the default post bar alt text color (#FFFFFF) which is applied to elements with accent background color', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-15');
	
	ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-15', __('Customize button style', 'essb'), __('', 'essb'));
	$tab_id = $where_to_display;
	$menu_id = 'display-15';
	$location = 'postbar';
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_button_style', __('Buttons Style', 'essb'), __('Select your button display style.', 'essb'), essb_avaiable_button_style_with_recommend());
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_template', __('Template', 'essb'), __('Select your template for that display location.', 'essb'), essb_available_tempaltes4(true));
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position', 'essb'), essb_avaliable_counter_positions());
	
	ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-15');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-15', 'postbar');
}

if (!essb_options_bool_value('deactivate_method_point')) {

// Point
	ESSBOptionsStructureHelper::field_heading($where_to_display, 'display-16', 'heading1', __('Display Position Settings: Point', 'essb'));
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-16', __('Point display', 'essb'), __('Choose location of point and style', 'essb'));
	$point_positions = array("bottomright" => __('Bottom Right', 'essb'), 'bottomleft' => __('Bottom Left', 'essb'), 'topright' => __('Top Right', 'essb'), 'topleft' => __('Top Left', 'essb'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-16', 'point_position', __('Point will appear on', 'essb'), __('Choose where you wish sharing point to appear', 'essb'), $point_positions);
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-16', 'point_total', __('Display total counter', 'essb'), __('Activate this option if you wish to activate display of total counter on point', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	//ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-16', 'point_open_end', __('Automatic share point open at the end of content', 'essb'), __('Activate this option if you wish to automatic share point open at the end of post content', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	$point_open_triggers = array("no" => __("No", "essb"), "end" => __("At the end of content", "essb"), "middle" => __("After the middle of content", "essb"));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-16', 'point_open_auto', __('Automatic share point open', 'essb'), __('Select your button display style.', 'essb'), $point_open_triggers);
	
	$point_display_style = array("simple" => __('Simple icons', 'essb'), 'advanced' => __('Advanced Panel', 'essb'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-16', 'point_style', __('Share buttons action type', 'essb'), __('Choose your share buttons action type. Simple buttons will just open share buttons when you click the point. Advanced panel allows you also to include custom texts before/after buttons into nice flyout panel', 'essb'), $point_display_style);
	$point_display_style = array("round" => __('Round', 'essb'), 'square' => __('Square', 'essb'), 'rounded' => __('Rounded edges square', 'essb'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-16', 'point_shape', __('Point button shape', 'essb'), __('Choose the shape of share point - default is round', 'essb'), $point_display_style);

	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-16', 'point_allowall', __('Display share point anywhere on site', 'essb'), __('Default point setup is made to appear on posts, custom post types and pages but it will not appear on lists of posts, dynamic pages activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-16');
	
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-16', __('Customize colors', 'essb'), __('Customize default colors of core components', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_bgcolor', __('Change default background color', 'essb'), __('Customize the default point background color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_color', __('Change default text color', 'essb'), __('Customize the default point text color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_accentcolor', __('Change default total background color', 'essb'), __('Customize the default total background color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_altcolor', __('Change default total text color', 'essb'), __('Customize the default total text color', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-16');
	
	
	
	
	ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-16', __('Customize button style', 'essb'), __('', 'essb'));
	$tab_id = $where_to_display;
	$menu_id = 'display-16';
	$location = 'point';
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_button_style', __('Buttons Style', 'essb'), __('Select your button display style.', 'essb'), essb_avaiable_button_style_with_recommend());
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_template', __('Template', 'essb'), __('Select your template for that display location.', 'essb'), essb_available_tempaltes4());
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position. Please note that if you use Simple icons mode all Inside positions will act like Inside - network names will not appear because of visual limitations', 'essb'), essb_avaliable_counter_positions_point());
	ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-16');
	
	ESSBOptionsStructureHelper::field_section_start($where_to_display, 'display-16', __('Custom button content for Advanced panel display', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_wpeditor($where_to_display, 'display-16', 'point_top_content', __('Custom content above share buttons', 'essb'), __('Optional: Provide custom content that will appear above share buttons. You can use the variables to display post related content: %%title%%, %%url%%, %%image%%, %%permalink%%', 'essb'), 'htmlmixed');
	ESSBOptionsStructureHelper::field_wpeditor($where_to_display, 'display-16', 'point_bottom_content', __('Custom content below share buttons', 'essb'), __('Optional: Provide custom content that will appear below share buttons. You can use the variables to display post related content: %%title%%, %%url%%, %%image%%, %%permalink%%', 'essb'), 'htmlmixed');
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'display-16', 'point_articles', __('Display prev/next article', 'essb'), __('Activate this option to display prev/next article from same category', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end($where_to_display, 'display-16');
	
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-16', 'point');
}

essb_prepare_location_advanced_customization($where_to_display, 'display-17', 'excerpt');

//ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading1', __('Mobile: Display Options', 'essb'));
//ESSBOptionsStructureHelper::hint($where_to_display, 'mobile-1', __('', 'essb'), __('Please note that not all popular cache plugins support mobile cache (you have one version of site on all devices). If you use such cache plugin you may not see your mobile settings working. If that is so you can deactivate cache of for mobile devices and get full control of mobile sharing or activate client side mobile detection (a.k.a. responsive butons) which will control only mobile display methods (option is located at the bottom of this screen).<br/><br/><b>Recommended cache plugin for usage with mobile settings is <a href="http://wp-rocket.me" target="_blank">WP Rocket</a>. <a href="http://wp-rocket.me" target="_blank">WP Rocket</a> supports separate mobile caching and you will be able to gain the full power of our mobile share options.</b>.', 'essb'), '');
ESSBOptionsStructureHelper::panel_start($where_to_display, 'mobile-1', __('Personalize display of share buttons on mobile device', 'essb'), __('Activate this option to change your mobile displayed positions and style settings of sharing buttons', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'mobile_positions', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

ESSBOptionsStructureHelper::title($where_to_display, 'mobile-1', __('Primary in content display positions', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_image_radio($where_to_display, 'mobile-1', 'content_position_mobile', '', '', essb_avaliable_content_positions_mobile());
ESSBOptionsStructureHelper::title($where_to_display, 'mobile-1', __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_image_checkbox($where_to_display, 'mobile-1', 'button_position_mobile', '', '', essb_available_button_positions_mobile());

ESSBOptionsStructureHelper::field_switch($where_to_display, 'mobile-1', 'mobile_exclude_tablet', __('Do not apply mobile settings for tablets', 'essb'), __('You can avoid mobile rules for settings for tablet devices.', 'essb'), 'recommeded', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'mobile-1', 'mobile_avoid_newwindow', __('Open sharing window in same tab', 'essb'), __('Activate this option if you wish to make sharing on mobile open in same tab. Warning! Option may lead to loose visitor as once share dialog is opened with this option user will leave your site. Use with caution..', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

global $essb_networks;
$checkbox_list_networks = array();
foreach ($essb_networks as $key => $object) {
	//$checkbox_list_networks[$key] = '<i class="essb_icon_'.$key.'"></i> ' . $object['name'];
	$checkbox_list_networks[$key] = $object['name'];
}

ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading4', __('Customize active social networks', 'essb'));
ESSBOptionsStructureHelper::title($where_to_display, 'mobile-1', __('', 'essb'), __('Choose social networks that you wish to see on your site when it is opened from mobile device (make selection only if you wish to change the default network list).', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_checkbox_list_sortable($where_to_display, 'mobile-1', 'mobile_networks', '', '', $checkbox_list_networks, '', 'networks');

ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading4', __('Share bar customizations', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'mobile-1', 'mobile_sharebar_text', __('Text on share bar', 'essb'), __('Customize the default share bar text (default is Share).', 'essb'));
ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading4', __('Share buttons bar customizations', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'mobile-1', __('Share buttons bar customization', 'essb'), '');
$listOfOptions = array("1" => "1 Button", "2" => "2 Buttons", "3" => "3 Buttons", "4" => "4 Buttons", "5" => "5 Buttons", "6" => "6 Buttons");
ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_count', __('Number of buttons in share buttons bar', 'essb'), __('Provide number of buttons you wish to see in buttons bar. If the number of activated buttons is greater than selected here the last button will be more button which will open pop up with all active buttons.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_names', __('Display network names', 'essb'), __('Activate this option to display network names (default display is icons only).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_fix', __('Fix problem with buttons not displayed in full width', 'essb'), __('Some themes may overwrite the default buttons style and in this case buttons do not take the full width of screen. Activate this option to fix the overwritten styles.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_total', __('Display total share counter', 'essb'), __('Activate this option to display total share counter as first button. If you activate it please keep in mind that you need to set number of columns to be with one more than buttons you except to see (total counter will act as single button)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_hideend', __('Hide buttons bar before end of page', 'essb'), __('This option is made to hide buttons bar once you reach 90% of page content to allow the entire footer to be visible.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_hideend_percent', __('% of content is viewed to hide buttons bar before end of page', 'essb'), __('Customize the default percent 90 when buttons bar will hide. Enter value in percents without the % mark.', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'mobile-1');

ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading4', __('Client side mobile detection (Simple responsive buttons)', 'essb'));
ESSBOptionsStructureHelper::panel_start($where_to_display, 'mobile-1', __('Client side mobile detection', 'essb'), __('Client side mobile settings should be used only when you have a cache plugin that cannot be configured to work with both mobile and desktop version of site (see instructions on how to configure most popular cache plugins on the activate mobile settings switch). <br/><br/>All settings in this section use screen size of screen to detect a mobile device. If you use this mode of detection all desktop display methods cannot have different mobile settings on mobile device - they will display same buttons just like on desktop. Personalized settings will work for mobile optimized display methods only.<br/><br/>Quick note: After activating the client side detection if you see your mobile display methods twice you do not need a client side detection and you can turn it off.<br/><br/><b>Important! After you make change in that section after updating settings you need to clear cache of plugin you use to allow new css code that controls display to be added.</b>', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'mobile_css_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

//ESSBOptionsStructureHelper::field_switch($where_to_display, 'mobile-1', 'mobile_css_activate', __('Activate client side detection of mobile device', 'essb'), __('Activate this option to make settings below work', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'mobile-1');
ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'mobile-1', 'mobile_css_screensize', __('Width of screen', 'essb'), __('Leave blank to use the default width of 750. In case you wish to customize it fill value in numbers (without px) and all devices that have screen width below will be marked as mobile.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_css_readblock', __('Hide read blocking methods', 'essb'), __('Activate this option to remove all read blocking methods on mobile devices. Read blocking display methods are Sidebar and Post Vertical Float', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_css_all', __('Hide all share buttons on mobile', 'essb'), __('Activate this option to hide all share buttons on mobile devices including those made with shortcodes.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_css_optimized', __('Control mobile optimized display methods', 'essb'), __('Activate this option to display mobile optimized display methods when resolution meets the mobile size that is defined. Methods that are controlled with this option include: Share Buttons Bar, Share Bar and Share Point. At least one of those methods should be selected in the settings above for additional display methods.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'mobile-1');
ESSBOptionsStructureHelper::panel_end($where_to_display, 'mobile-1');

ESSBOptionsStructureHelper::panel_end($where_to_display, 'mobile-1');

essb_prepare_location_advanced_customization($where_to_display, 'mobile-2', 'mobile');
essb_prepare_location_advanced_customization_mobile($where_to_display, 'mobile-3', 'sharebar');
essb_prepare_location_advanced_customization_mobile($where_to_display, 'mobile-4', 'sharepoint');
essb_prepare_location_advanced_customization_mobile($where_to_display, 'mobile-5', 'sharebottom');

// after share actions
if (!essb_options_bool_value('deactivate_module_aftershare')) {
	ESSBOptionsStructureHelper::panel_start('social', 'after-share-1', __('Activate after social share action', 'essb'), __('Activate this option to start display message after share dialog is closed.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'afterclose_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_section_start_full_panels('social', 'after-share-1');
	ESSBOptionsStructureHelper::field_switch_panel('social', 'after-share-1', 'afterclose_deactive_mobile', __('Do not display after social share action for mobile devices', 'essb'), __('Avoid display after share actions on mobile devices', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'after-share-1', 'afterclose_activate_all', __('Include after share actions code on all pages', 'essb'), __('Activate this option if you plan to use after share actions on post types or pages where buttons are not assigned to appear automatically. This option usually is required when you use shortcodes to display buttons on specific parts of site (for example embed into theme and avoid automatic display)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'after-share-1', 'afterclose_deactive_sharedisable', __('Do not include after share actions code on pages where buttons are deactivated', 'essb'), __('Activate this option if you do not wish code for after share module to be added on pages where buttons are set to be off into settings (via on post/page options or from Display Settings).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'after-share-1', 'afterclose_activate_sharedisable', __('Always load after share code', 'essb'), __('Always load code of after share on each page.', 'essb'), __('Really usefull option when you plan to use after on pages where buttons for sharing are deactivated.', 'essb'), __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('social', 'after-share-1');
	$action_types = array ("follow" => "Like/Follow Box", "message" => "Custom html message (for example subscribe form)", "code" => "Custom user code", "optin" => "Optin form from Easy Optin", "popular" => "Popular social posts" );
	ESSBOptionsStructureHelper::field_select('social', 'after-share-1', 'afterclose_type', __('After close action type', 'essb'), __('Choose your after close action.', 'essb'), $action_types);
	ESSBOptionsStructureHelper::hint('social', 'after-share-1', '', __('If you choose popular posts to be displayed you need to choose counter update period that is different than Real Time counters. That display action will generate top 4 most shared posts over social networks from same category as original post is loaded.', 'essb'));
	ESSBOptionsStructureHelper::field_section_start('social', 'after-share-1', __('Pop up message settings', 'essb'), __('', 'essb'), '');
	ESSBOptionsStructureHelper::field_textbox('social', 'after-share-1', 'afterclose_popup_width', __('Pop up message width', 'essb'), __('Provide custom width in pixels for pop up window (number value with px in it. Example: 400). Default pop up width is 400.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_switch('social', 'after-share-1', 'afterclose_singledisplay', __('Display pop up message once for selected time', 'essb'), __('Activate this option to prevent pop up window display on every page load. This option will make it display once for selected period of days.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'after-share-1', 'afterclose_singledisplay_days', __('Days between pop up message display', 'essb'), __('Provide the value of days when pop up message will appear again. Leave blank for default value of 7 days.', 'essb'), '', 'input60', 'fa-calendar', 'right');
	ESSBOptionsStructureHelper::field_section_end('social', 'after-share-1');
	ESSBOptionsStructureHelper::panel_end('social', 'after-share-1');
	
	ESSBOptionsStructureHelper::field_editor('social', 'after-share-2', 'afterclose_like_text', __('Text before like/follow buttons', 'essb'), __('Message that will appear before buttons (html supported).', 'essb'), 'htmlmixed');
	$col_values = array("onecol" => "1 Column", "twocols" => "2 Columns", "threecols" => "3 Columns");
	ESSBOptionsStructureHelper::field_select('social', 'after-share-2', 'afterclose_like_cols', __('Display social profile in the following number of columns', 'essb'), __('Choose the number of columns that social profiles will appear. Please note that using greater value may require increase the pop up window width.', 'essb'), $col_values);
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'after-share-2', 'afterclose_like_fb_like_url', __('Include Facebook Like Button for the following url', 'essb'), __('Provide url address users to like. This can be you Facebook fan page, additional page or any other page you wish users to like.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'after-share-2', 'afterclose_like_fb_follow_url', __('Include Facebook Follow Profile button', 'essb'), __('Provide url address of profile users to follow.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'after-share-2', 'afterclose_like_google_url', __('Include Google +1 button for the following url', 'essb'), __('Provide url address of which you have to get +1.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'after-share-2', 'afterclose_like_google_follow_url', __('Include Google Follow Profile button', 'essb'), __('Provide url address of Google Plus profile users to follow.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'after-share-2', 'afterclose_like_twitter_profile', __('Include Twitter Follow Button', 'essb'), __('Provide Twitter username people to follow (without @)', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'after-share-2', 'afterclose_like_pin_follow_url', __('Include Pinterest Follow Profile button', 'essb'), __('Provide url address to a Pinterest profile.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'after-share-2', 'afterclose_like_youtube_channel', __('Include Youtube Subscribe Channel button', 'essb'), __('Provide your Youtube Channel ID.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'after-share-2', 'afterclose_like_youtube_user', __('Include Youtube Subscribe User button', 'essb'), __('Provide your Youtube Channel Username.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'after-share-2', 'afterclose_like_linkedin_company', __('Include LinkedIn Company follow button', 'essb'), __('Provide your LinkedIn company ID.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'after-share-2', 'afterclose_like_vk', __('Include VKontakte ID of Page or Group', 'essb'), __('To get this ID login to your vk profile and visit this page: <a href="https://vk.com/dev/Subscribe" target="_blank">https://vk.com/dev/Subscribe</a> (copy numbers after http://vk.com/id in the field).', 'essb'));
	
	ESSBOptionsStructureHelper::field_editor('social', 'after-share-3', 'afterclose_message_text', __('Custom html message', 'essb'), __('Put code of your custom message here. This can be subscribe form or anything you wish to display (html supported, shortcodes supported).', 'essb'), 'htmlmixed');
	
	ESSBOptionsStructureHelper::field_switch('social', 'after-share-4', 'afterclose_code_always_use', __('Always include custom code', 'essb'), __('Activate this option to make code always be executed even if a different message type is activated', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_editor('social', 'after-share-4', 'afterclose_code_text', __('Custom javascript code', 'essb'), __('Provide your custom javascript code that will be executed (available parameters: oService - social network clicked by user and oPostID for the post where button is clicked).', 'essb'), 'htmlmixed');
	
	$listOfValues = essb_optin_designs();
	ESSBOptionsStructureHelper::field_select('social', 'after-share-5', 'aftershare_optin_design', __('Specify subscribe button Easy Optin design for content', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
}

ESSBOptionsStructureHelper::panel_start('social', 'shorturl', __('Activate generation of short urls for sharing', 'essb'), __('Activate this option if you wish to allow generation of short urls when post is shared', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'shorturl_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

ESSBOptionsStructureHelper::field_select('social', 'shorturl', 'twitter_shareshort', __('Generate short urls for', 'essb'), __('Select networks you wish to generate short urls for - you can choose from recommended networks (Twitter, Mobile Messengers) or all social networks'), array( "true" => "Recommended social networks only (Twitter, Mobile Messengers)", "false" => "All social networks"));

$listOfOptions = array("wp" => "Build in WordPress function wp_get_shortlink()", "goo.gl" => "goo.gl", "bit.ly" => "bit.ly", 'rebrand.ly' => 'rebrand.ly', 'po.st' => 'po.st');
if (defined('ESSB3_SSU_VERSION')) {
	$listOfOptions['ssu'] = "Self-Short URL Add-on for Easy Social Share Buttons";
}

ESSBOptionsStructureHelper::field_select('social', 'shorturl', 'shorturl_type', __('Choose short url type', 'essb'), __('Please note that usage of bit.ly requires to fill additional fields below or short urls will not be generated. If you choose goo.gl as provider we also recommend to generate API key due to public quota limit provided by Google.'), $listOfOptions);
ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('bit.ly Access Configuration', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'shorturl', 'shorturl_bitlyuser', __('bit.ly Username', 'essb'), __('Provide your bit.ly username', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_bitlyapi', __('bit.ly API key/Access token key', 'essb'), __('Provide your bit.ly API key', 'essb'));
ESSBOptionsStructureHelper::field_select('social', 'shorturl', 'shorturl_bitlyapi_version', __('bit.ly API version', 'essb'), __('Choose version of bit.ly API you will use. We recommend to switch to new bit.ly API with access token'), array( "previous" => "Old API version with Username and Access Key", "new" => "New API with access token"));
ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('goo.gl Access Configuration', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_googlapi', __('goo.gl API key', 'essb'), __('Goo.gl short url service can work with or without API key. If you have a high traffic site it is recommended to use API key because when anonymous usage reach amount of request for time you will not get short urls. To generate such key you need to visit <a href="https://console.developers.google.com/project" target="_blank">Google Developer Console</a>', 'essb'));
ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('Rebrand.ly Access Configuration', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_rebrandpi', __('rebrand.ly API key', 'essb'), __('Rebrand.ly service require API key to generate your short URLs. To get such please visit this address <a href="https://www.rebrandly.com/api-settings" target="_blank">Rebrand.ly API Settings page</a>', 'essb'));
ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('po.st Access Configuration', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_postapi', __('po.st API Access Token', 'essb'), __('po.st service require API access token to generate your short URLs. To get such please visit this address <a href="http://re.po.st/register" target="_blank">http://re.po.st/register</a>', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'shorturl');

function essb3_register_positions_by_posttypes() {
	global $wp_post_types, $where_to_display;
	$where_to_display = 'where';
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-2', __('I wish to have different button position for different post types', 'essb'), __('Activate this option if you wish to setup different positions for each post type.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'positions_by_pt', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );
	$first_post_type = "";
	$key = 1;
	foreach ( $pts as $pt ) {

		ESSBOptionsStructureHelper::field_heading($where_to_display, 'display-2', 'heading5', __('Customize button positions for: '.$wp_post_types [$pt]->label, 'essb'));
		ESSBOptionsStructureHelper::structure_row_start($where_to_display, 'display-2');
		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'display-2', 'c6', __('Primary content display position', 'essb'), __('Choose default in content position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_select($where_to_display, 'display-2', 'content_position_'.$pt, '', '', essb_simplified_radio_check_list(essb_avaliable_content_positions(), true));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'display-2');

		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'display-2', 'c6', __('Additional button display positions', 'essb'), __('Choose additional site display position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_checkbox_list($where_to_display, 'display-2', 'button_position_'.$pt, '', '', essb_simplified_radio_check_list(essb_available_button_positions()));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'display-2');
		ESSBOptionsStructureHelper::structure_row_end($where_to_display, 'display-2');
	}

	foreach ( $cpts as $cpt ) {

		ESSBOptionsStructureHelper::field_heading($where_to_display, 'display-2', 'heading5', __('Customize button positions for: '.$wp_post_types [$cpt]->label, 'essb'));
		ESSBOptionsStructureHelper::structure_row_start($where_to_display, 'display-2');
		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'display-2', 'c6', __('Primary content display position', 'essb'), __('Choose default in content position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_select($where_to_display, 'display-2', 'content_position_'.$cpt, '', '', essb_simplified_radio_check_list(essb_avaliable_content_positions(), true));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'display-2');
		
		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'display-2', 'c6', __('Additional button display positions', 'essb'), __('Choose additional site display position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_checkbox_list($where_to_display, 'display-2', 'button_position_'.$cpt, '', '', essb_simplified_radio_check_list(essb_available_button_positions()));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'display-2');
		ESSBOptionsStructureHelper::structure_row_end($where_to_display, 'display-2');
		
	}
	
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-2');
}

function essb3_network_selection() {
	global $essb_admin_options, $essb_networks;
	$active_networks = array();

	$network_order = array();
	if (is_array($essb_admin_options)) {
		$active_networks = isset($essb_admin_options['networks']) ? $essb_admin_options['networks'] : array();
		$network_order = isset($essb_admin_options['networks_order']) ? $essb_admin_options['networks_order'] : array();
		
	}

	if (count($network_order) > 0) {
		$network_order = apply_filters('essb4_social_networks_update_order', $network_order);
	}

	// populate the default networks for sorting;
	if (count($network_order) == 0) {
		$network_order = array();
		foreach ($essb_networks as $key => $data) {
			$network_order[] = $key;
		}

	}
	
	echo '<input type="text" class="input-element input-filter stretched-50" placeholder="Quick Filter Networks ..." data-filter="essb-main-network-list"/>';
	
	print '<ul class="essb-main-network-order" id="essb-main-network-list">';

	foreach ($network_order as $network) {

		$current_network_name = isset($essb_networks[$network]) ? $essb_networks[$network]["name"] : $network;
		$current_network_supports = isset($essb_networks[$network]) ? $essb_networks[$network]["supports"] : $network;
		$user_network_name = isset($essb_admin_options['user_network_name_'.$network]) ? $essb_admin_options['user_network_name_'.$network] : '';
		
		if ($user_network_name == '') {
			$user_network_name = $current_network_name;
		}
		
		$supports = "";
		/*if ($current_network_supports != '') {
			$supports_object = explode(',', $current_network_supports);

			foreach ($supports_object as $singleSupportFeature) {
				$supports .= sprintf('<span class="essb-network-supports">%1$s</span>', $singleSupportFeature);
			}
		}*/

		$is_active_network = in_array($network, $active_networks) ? "checked=\"checked\"" : "";
		//echo '<li>'.$network.'</li>';
		printf('<li class="essb-network-select essb-network-select-%1$s '.($is_active_network != '' ? " active" : '').'" data-filter-value="'.$current_network_name.'">', $network);
		print '<span class="essb-single-network-select essb-single-network-select-'.$network.'">';
		print '<input type="checkbox" name="essb_options[networks][]" value="'.$network.'" '.$is_active_network.' class="essb-clickable-order"/>';
		print '<span class="essb_icon essb_icon_'.$network.'"></span>';
		print '<span class="essb-sns-name">'.$current_network_name.'</span>';
		print '<input type="checkbox" name="essb_options[networks_order][]" value="'.$network.'" checked="checked" style="display:none;"/>';
		print '<span class="essb-single-network-name">';
		print __('Personalize text on button:', 'essb').'<br/><input type="text" class="input-element" name="essb_options_names['.$network.']" value="'.$user_network_name.'"/>';
		print '</span>';
		print '</span>';

		//printf('<span class="essb-single-network-select essb-single-network-select-%1$s">', $network, $current_network_name, $is_active_network, $supports);

		//printf('<li class="essb-network-select essb-network-select-%1$s">', $network);

		//printf('<span class="essb-single-network-select essb-single-network-select-%1$s"><input type="checkbox" name="essb_options[networks][]" value="%1$s" %3$s/><span class="essb_icon essb_icon_%1$s"></span><span class="essb-sns-name">%2$s</span>%4$s<input type="checkbox" name="essb_options[networks_order][]" value="%1$s" checked="checked" style="display:none;"/></span>', $network, $current_network_name, $is_active_network, $supports);

		print '</li>';
		;
	}

	print '</ul>';

	echo '<script type="text/javascript">';
	echo 'jQuery(document).ready(function(){';
	echo 'jQuery("#essb-main-network-list").sortable2();';
	echo '});';
	echo '</script>';
}


function essb3_options_template_select() {
	global $essb_options;
	
	$selected_template = ESSBOptionValuesHelper::options_value($essb_options, 'style');
	
	$list_of_templates = essb_available_tempaltes4();
	if (empty($selected_template)) { $selected_template = '32'; }
	
	$button_style = essb_social_settings_dummy_style();
	
	ESSBOptionsFramework::draw_hint(__('Choose your default template', 'essb'), __('Default template will be used if no other personalization to selected button design is made. You can easy select different template for post types (via post type settings), button position (via button position settings) or add custom to your shortcodes.', 'essb'), 'fa32 ti-palette');
	
	ESSBOptionsFramework::draw_structure_row_start();
	$count = 0;
	foreach ($list_of_templates as $key => $name) {
		if ($count == 3) {
			ESSBOptionsFramework::draw_structure_row_end();
			ESSBOptionsFramework::draw_structure_row_start();
			$count = 0;
		}
		ESSBOptionsFramework::draw_structure_section_start('c4');
		
		$button_style['template'] = $key;
		
		echo '<div class="essb-template essb-template-'.$key.' '.($key == $selected_template ? ' essb-selected-template': '').'">';
		echo '<input type="radio" class="essb-template-radio" name="essb_options[style]" value="'.$key.'" '.($key == $selected_template ? 'checked="checked"': '').'/><b>'.$name.'</b><div class="essb-options-template-preview">';
		
		echo ESSBButtonHelper::draw_share_buttons(essb_social_settings_dummy_share(), $button_style, array("facebook","twitter","google"), array("facebook","twitter","google"), array("facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google"), "shortcode", "1112233");
		echo '</div></div>';
		
		ESSBOptionsFramework::draw_structure_section_end();
		$count++;
	}
	
	ESSBOptionsFramework::draw_structure_row_end();
	
	?>
	
	<script type="text/javascript">

	jQuery(document).ready(function($){
		$('.essb-template-radio').click(function(e) {
			if ($('.essb-selected-template').length) {
				$('.essb-selected-template').removeClass('essb-selected-template');
			}

			$(this).parent().addClass('essb-selected-template');

		});
	});
	</script>
	
	<?php 
}

function essb_social_settings_dummy_style($user_counter = false, $counter_pos = '', $total_counter_pos = '') {
	$style = array("button_style" => "button", "align" => "left", "button_width" => "auto", "counters" => false);
	
	if ($user_counter) {
		$style['show_counter'] = 1;
		$style['counters'] = true;
		if ($counter_pos != '') {
			$style['counter_pos'] = $counter_pos;
		}
		
		if ($total_counter_pos != '') {
			$style['total_counter_pos'] = $total_counter_pos;
		}
	}
	else {
		$style['show_counter'] = 0;
		$style['counter_pos'] = 'hidden';
		$style['total_counter_pos'] = 'hidden';
	}
	
	$style['button_align'] = 'left';
	$style['counter_pos'] = 'hidden';
	$style['total_counter_hidden_till'] = '';
	$style['nospace'] = false;
	$style['full_url'] = false;
	$style['message_share_buttons'] = '';
	$style['message_share_before_buttons'] = '';
	$style['is_mobile'] = false;
	$style['amp'] = false;
	$style['native'] = false;
	
	return $style;
}

function essb_social_settings_dummy_share() {
	return array("url" => "", "title" => "", "image" => "", "description" => "", "twitter_user" => "",
			"twitter_hashtags" => "", "twitter_tweet" => "", "post_id" => 0, "user_image_url" => "", "title_plain" => "",
			'short_url_whatsapp' => '', 'short_url_twitter' => '', 'short_url' => '', 'pinterest_image' => "", "full_url" => "");
}

function essb3_text_analytics() {
	$text = '
	You can
									visit
<a href="https://support.google.com/analytics/answer/1033867?hl=en"
	target="_blank">this page</a>
for more information on how to use and generate these parameters.
<br />
To include the social network into parameters use the following code
<b>{network}</b>
. When that code is reached it will be replaced with the network name (example: facebook). An example campaign trakcing code include network will look like this utm_source=essb_settings&utm_medium=needhelp&utm_campaign={network} - in this configuration when you press Facebook button {network} will be replaced with facebook, if you press Twitter button it will be replaced with twitter.
To include the post title into parameters use the following code
<b>{title}</b>
. When that code is reached it will be replaced with the post title.
';
	return $text;
}

function essb3_post_type_select() {
	global $essb_admin_options, $wp_post_types;

	$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );

	$current_posttypes = array();
	if (is_array($essb_admin_options)) {
		$current_posttypes = ESSBOptionValuesHelper::options_value($essb_admin_options, 'display_in_types', array());
	}

	//print_r($current_posttypes);

	if (!is_array($current_posttypes)) {
		$current_posttypes = array();
	}
	echo '<ul>';

	foreach ($pts as $pt) {
		$selected = in_array ( $pt, $current_posttypes ) ? 'checked="checked"' : '';
		printf('<li><input type="checkbox" name="essb_options[display_in_types][]" id="%1$s" value="%1$s" %2$s> <label for="%1$s">%3$s</label></li>', $pt, $selected, $wp_post_types [$pt]->label);
	}

	foreach ($cpts as $pt) {
		$selected = in_array ( $pt, $current_posttypes  ) ? 'checked="checked"' : '';
		printf('<li><input type="checkbox" name="essb_options[display_in_types][]" id="%1$s" value="%1$s" %2$s> <label for="%1$s">%3$s</label></li>', $pt, $selected, $wp_post_types [$pt]->label);
	}

	$selected = in_array ( 'all_lists', $current_posttypes  ) ? 'checked="checked"' : '';
	printf('<li><input type="checkbox" name="essb_options[display_in_types][]" id="%1$s" value="%1$s" %2$s> <label for="%1$s">%3$s</label></li>', 'all_lists', $selected, 'Lists of articles (blog, archives, search results, etc.)');

	echo '</ul>';
}


function essb_prepare_location_advanced_customization($tab_id, $menu_id, $location = '', $post_type = false) {
	global $essb_networks, $essb_options;

	$essb_networks = essb_available_social_networks();
	
	$checkbox_list_networks = array();
	foreach ($essb_networks as $key => $object) {
		//$checkbox_list_networks[$key] = '<i class="essb_icon_'.$key.'"></i> ' . $object['name'];
		$checkbox_list_networks[$key] = $object['name'];
	}

	if ($location != 'mobile') {
		ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading5', __('Deactivate display of functions', 'essb'));
		ESSBOptionsStructureHelper::field_section_start_full_panels($tab_id, $menu_id);

		ESSBOptionsStructureHelper::field_switch_panel($tab_id, $menu_id, $location.'_mobile_deactivate', __('Deactivate on mobile', 'essb'), __('Activate this option if you wish that method to be hidden when site is browsed with mobile device.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		ESSBOptionsStructureHelper::field_switch_panel($tab_id, $menu_id, $location.'_tablet_deactivate', __('Deactivate on tablet', 'essb'), __('Activate this option if you wish that method to be hidden when site is browsed with tablet device.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		
		if ($location != 'postbar' && $location != 'point') {
			ESSBOptionsStructureHelper::field_switch_panel($tab_id, $menu_id, $location.'_native_deactivate', __('Deactivate native buttons', 'essb'), __('Activate this option if you wish to deactivate native buttons for that display method.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

			if (!$post_type) {
				ESSBOptionsStructureHelper::field_switch_panel($tab_id, $menu_id, $location.'_text_deactivate', __('Hide message above, before or below', 'essb'), __('Activate this option if you wish to hide message above, before or below for that display.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
			}
		}
		ESSBOptionsStructureHelper::field_section_end_full_panels($tab_id, $menu_id);
	}

	if ($location == 'mobile') {
		//ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize active social networks', 'essb'), __('Apply selection only if you wish to modify the default network list that is used over site.', 'essb'), 'inner-row');
		//ESSBOptionsStructureHelper::field_checkbox_list_sortable($tab_id, $menu_id, $location.'_networks', '', '', $checkbox_list_networks);
	}

	$panel_title = "";
	if (!$post_type) {
		$panel_title = __('Personalize buttons on that display position', 'essb');
	}
	else {
		$panel_title = __('Personalize buttons for that post type', 'essb');
	}
	
	if ($location == 'mobile') {
		$panel_title = __('Personalize buttons that are displayed on mobile device', 'essb');
	}

	ESSBOptionsStructureHelper::hint($tab_id, $menu_id, __('Personalize buttons to get maximum impact', 'essb'), __('Not always global display styles or social networks are suitable for a location you use. Easy Social Share Buttons provide extended options to personalize everything for just that location. To do this activate the option that you wish to change styles or even easier is to use the unique front-end customization helper.', 'essb'), 'fa21 ti-ruler-pencil');
	
	ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, $panel_title, __('Activating this option will allow you to make full personalization of displayed buttons.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => $location.'_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb'), 'switch_submit' => 'true'));

	
	if (essb_option_bool_value($location.'_activate')) {	

	if ($location != 'postbar' && $location != 'point') {
		ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading5', __('Visual customizations', 'essb'));
		ESSBOptionsStructureHelper::tabs_start($tab_id, $menu_id, $location.'-visual', array('<i class="fa fa-square"></i> Button Style', '<i class="fa fa-plus"></i> More button', '<i class="fa fa-share-alt"></i> Share button', '<i class="fa fa-history"></i> Counters', '<i class="fa fa-arrows-h"></i> Width'));
		
		ESSBOptionsStructureHelper::tab_start($tab_id, $menu_id,  $location.'-visual-0', 'true');
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_button_style', __('Buttons Style', 'essb'), __('Select your button display style.', 'essb'), essb_avaiable_button_style());
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_button_pos', __('Buttons Align', 'essb'), __('Choose how buttons
				to be aligned. Default position is left but you can also select
				Right or Center', 'essb'), array("" => "Left", "center" => "Center", "right" => "Right"));
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_template', __('Template', 'essb'), __('Select your template for that display location.', 'essb'), essb_available_tempaltes4());
		ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		$animations_container = array ();
		$animations_container[""] = "Default value from settings";
		foreach (essb_available_animations() as $key => $text) {
			if ($key != '') {
				$animations_container[$key] = $text;
			}
			else {
				$animations_container['no'] = 'No amination';
			}
		}		
		
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_css_animations', __('Activate animations', 'essb'), __('Animations
				are provided with CSS transitions and work on best with retina
				templates.', 'essb'), $animations_container);
		
		ESSBOptionsStructureHelper::tab_end($tab_id, $menu_id);
		
		ESSBOptionsStructureHelper::tab_start($tab_id, $menu_id,  $location.'-visual-1');
		
		$more_options = array ("plus" => "Plus icon", "dots" => "Dots icon" );
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_more_button_icon', __('More button icon', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $more_options);

		$more_options = array ("" => "Default function", "1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up" );
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_more_button_func', __('More button function', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands(true));
		ESSBOptionsStructureHelper::tab_end($tab_id, $menu_id);
		ESSBOptionsStructureHelper::tab_start($tab_id, $menu_id,  $location.'-visual-2');
		//$more_options = array ("1" => "Display all active networks after share button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up" );
		$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up", "4" => "Display all active networks after more button in popup" );	
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_share_button_func', __('Share button function', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands(true));
		
		$essb_available_buttons_width = array();
		$essb_available_buttons_width ['plus'] = array ("image" => '<div class="fa21 essb_icon_plus"></div>', "label" => "" );
		$essb_available_buttons_width ['dots'] = array ("image" => '<div class="fa21 essb_icon_dots"></div>', "label" => "" );
		$essb_available_buttons_width ['share'] = array ("image" => '<div class="fa21 essb_icon_share"></div>', "label" => "" );
		$essb_available_buttons_width ['share-alt-square'] = array ("image" => '<div class="fa21 essb_icon_share-alt-square"></div>', "label" => "" );
		$essb_available_buttons_width ['share-alt'] = array ("image" => '<div class="fa21 essb_icon_share-alt"></div>', "label" => "" );
		$essb_available_buttons_width ['share-tiny'] = array ("image" => '<div class="fa21 essb_icon_share-tiny"></div>', "label" => "" );
		$essb_available_buttons_width ['share-outline'] = array ("image" => '<div class="fa21 essb_icon_share-outline"></div>', "label" => "" );
		ESSBOptionsStructureHelper::field_html_radio_buttons($tab_id, $menu_id, $location.'_share_button_icon', __('Share button icon', 'essb'), __('Choose the share button icon you will use (default is share if nothing is selected)', 'essb'), $essb_available_buttons_width, '', '', '26px');
		
		$more_options = array ("" => "Default from settings (like other share buttons)", "icon" => "Icon only", "button" => "Button", "text" => "Text only" );
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_share_button_style', __('Share button style', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $more_options);
		
		$share_counter_pos = array("hidden" => "No counter", "inside" => "Inside button without text", "insidename" => "Inside button after text", "insidebeforename" => "Inside button before text", "topn" => "Top", "bottom" => "Bottom");
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_share_button_counter', __('Display total counter with the following position', 'essb'), __('Choose where you wish to display total counter of shares assigned with this button. <br/> To view total counter you need to have share counters active and they should not be running in real time mode. Also you need to have your share button set with style button. When you use share button with counter we highly recommend to hide total counter by setting position to be hidden - this will avoid having two set of total value on screen.', 'essb'), $share_counter_pos);
		ESSBOptionsStructureHelper::tab_end($tab_id, $menu_id);
		
		

		
		
		ESSBOptionsStructureHelper::tab_start($tab_id, $menu_id,  $location.'-visual-3');
		ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position', 'essb'), essb_avaliable_counter_positions());
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_total_counter_pos', __('Position of total counter', 'essb'), __('For vertical display methods left means before buttons (top) and right means after buttons (bottom).', 'essb'), essb_avaiable_total_counter_position());
		ESSBOptionsStructureHelper::tab_end($tab_id, $menu_id);

		
		ESSBOptionsStructureHelper::tab_start($tab_id, $menu_id,  $location.'-visual-4');
		ESSBOptionsStructureHelper::field_section_start($tab_id, $menu_id, __('Set button width', 'essb'), __('', 'essb'));
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_button_width', __('Width of buttons'), __('Choose between automatic width, pre defined width or display in columns.'), array(''=>'Automatic Width', 'fixed' => 'Fixed Width', 'full' => 'Full Width', "column" => "Display in columns", "flex" => "Flex width"));
		ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);
		
		ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, __('Fixed width share buttons', 'essb'), __('Customize the fixed width options', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fixed_width_value', __('Custom buttons width', 'essb'), __('', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
		ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fixed_width_align', __('Choose alignment of network name', 'essb'), __('', 'essb'), array("" => "Center", "left" => "Left", "right" => "Right"));
		ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
		
		ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, __('Full width share buttons', 'essb'), __('Full width option will make buttons to take the width of your post content area.', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_correction', __('Max width of button on desktop', 'essb'), __('', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
		ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_correction_mobile', __('Max width of button on mobile', 'essb'), __('', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
		ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_container', __('Max width of buttons container element', 'essb'), __('', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
		ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fullwidth_align', __('Choose alignment of network name', 'essb'), __('', 'essb'), array("left" => "Left", "center" => "Center", "right" => "Right"));
		
		ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
		
		ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, __('Display in columns', 'essb'), '');
		$listOfOptions = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5");
		ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_columns', __('Number of columns', 'essb'), __('', 'essb'), $listOfOptions);
		ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_columns_align', __('Choose alignment of network name', 'essb'), __('', 'essb'), array("" => "Left", "center" => "Center", "right" => "Right"));
		ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
		
		
		ESSBOptionsStructureHelper::tab_end($tab_id, $menu_id);
		ESSBOptionsStructureHelper::tabs_end($tab_id, $menu_id);


	}
	//ESSBOptionsStructureHelper::field_section_start($tab_id, $menu_id, __('Personalize social networks', 'essb'), '');
	ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading5', __('Personalize social networks', 'essb'));

	if ($location != 'mobile') {
		ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize active social networks', 'essb'), __('Apply selection only if you wish to modify the default network list that is used over site.', 'essb'), 'inner-row');
		ESSBOptionsStructureHelper::field_checkbox_list_sortable($tab_id, $menu_id, $location.'_networks', '', '', $checkbox_list_networks, '', 'networks');
		
		
		//ESSBOptionsStructureHelper::structure_row_start($tab_id, $menu_id);
		//ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c12', __('Customize active social networks', 'essb'), __('Apply selection only if you wish to modify the default network list that is used over site.', 'essb'));
		//ESSBOptionsStructureHelper::field_checkbox_list_sortable($tab_id, $menu_id, $location.'_networks', '', '', $checkbox_list_networks);
		//ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
		//ESSBOptionsStructureHelper::structure_row_end($tab_id, $menu_id);
		
	}
	
	//ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize text of social network over button', 'essb'), __('Set texts that will appear on selected display method instead of default network names. Use dash (-) if you wish to remove text for that network name.', 'essb'));
	ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('Customize text of social network over button', 'essb'), __('Set texts that will appear on selected display method instead of default network names. Use dash (-) if you wish to remove text for that network name.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => $location.'_name_change', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
	ESSBOptionsStructureHelper::structure_row_start($tab_id, $menu_id, 'inner-row social-name-change');
	$count = 0;
	foreach ($checkbox_list_networks as $key => $text) {
		if ($count == 4) {
			ESSBOptionsStructureHelper::structure_row_end($tab_id, $menu_id);
			ESSBOptionsStructureHelper::structure_row_start($tab_id, $menu_id, 'inner-row social-name-change');
			$count = 0;
		}
		$count++;
		ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c3');
		ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_'.$key.'_name', $text, '', '', '', '', '', '6');
		ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
	}

	ESSBOptionsStructureHelper::structure_row_end($tab_id, $menu_id);
	ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id); // network names
	}
	ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id); // customization
	
	//ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);

}


function essb_prepare_location_advanced_customization_mobile($tab_id, $menu_id, $location = '') {
	global $essb_networks;

	$checkbox_list_networks = array();
	foreach ($essb_networks as $key => $object) {
		$checkbox_list_networks[$key] = $object['name'];
	}


	//ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading2', __('Change default button options for that display location', 'essb'));
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_activate', __('I wish to personalize global button settings for that location', 'essb'), __('Activate this option to apply personalized settings for that display location that will overwrite the global.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading5', __('Visual Changes', 'essb'));

	ESSBOptionsStructureHelper::field_section_start($tab_id, $menu_id, __('Set button style', 'essb'), __('', 'essb'));

	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_template', __('Template', 'essb'), __('Select your template for that display location.', 'essb'), essb_available_tempaltes4(true));

	if ($location != 'sharebottom') {
		ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	}

	ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);

	if ($location != 'sharebottom') {
		ESSBOptionsStructureHelper::field_section_start($tab_id, $menu_id, __('Counter settings', 'essb'), __('', 'essb'));
		ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position', 'essb'), essb_avaliable_counter_positions_mobile());
		ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_total_counter_pos', __('Position of total counter', 'essb'), __('For vertical display methods left means before buttons (top) and right means after buttons (bottom).', 'essb'), essb_avaiable_total_counter_position_mobile());
		ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);
	}
	ESSBOptionsStructureHelper::field_section_start($tab_id, $menu_id, __('Personalize social networks', 'essb'), '');
	ESSBOptionsStructureHelper::field_checkbox_list_sortable($tab_id, $menu_id, $location.'_networks', __('Change active social networks', 'essb'), __('Do not select anything if you wish to use default network list'. 'essb'), $checkbox_list_networks, '', 'networks');
	ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);
	
	//ESSBOptionsStructureHelper::field_section_start($tab_id, $menu_id, __('Rename displayed texts for network names', 'essb'), __('Set texts that will appear on selected display method instead of default network names. Use dash (-) if you wish to remove text for that network name.', 'essb'));

	//foreach ($checkbox_list_networks as $key => $text) {
	//	ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, $location.'_'.$key.'_name', $text, '');
	//}
	ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('Customize text of social network over button', 'essb'), __('Set texts that will appear on selected display method instead of default network names. Use dash (-) if you wish to remove text for that network name.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => $location.'_name_change', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
	ESSBOptionsStructureHelper::structure_row_start($tab_id, $menu_id, 'inner-row social-name-change');
	$count = 0;
	foreach ($checkbox_list_networks as $key => $text) {
		if ($count == 4) {
			ESSBOptionsStructureHelper::structure_row_end($tab_id, $menu_id);
			ESSBOptionsStructureHelper::structure_row_start($tab_id, $menu_id, 'inner-row social-name-change');
			$count = 0;
		}
		$count++;
		ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c3');
		ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_'.$key.'_name', $text, '', '', '', '', '', '6');
		ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
	}
	
	ESSBOptionsStructureHelper::structure_row_end($tab_id, $menu_id);
	ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id); // network names
	

	//ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);

}

function essb_postions_with_custom_networks($as_text = false) {
	$result = array();
	
	foreach ( essb_avaliable_content_positions () as $key => $data ) {
		$key = str_replace("content_", "", $key);
		$position_networks = essb_option_value ( $key.'_networks' );
		
		if (is_array($position_networks)) {
			$result[] = array('key' => $key, 'title' => $data ['label']);
		}
	}
	
	foreach ( essb_available_button_positions () as $key => $data ) {
		$position_networks = essb_option_value ( $key.'_networks' );
	
		if (is_array($position_networks)) {
			$result[] = array('key' => $key, 'title' => $data ['label']);
		}
	}
	
	$key = 'mobile';
	$position_networks = essb_option_value ( $key.'_networks' );
	if (is_array($position_networks)) {
		$result[] = array('key' => $key, 'title' => 'Mobile Devices');
	}

	$key = 'sharebar';
	$position_networks = essb_option_value ( $key.'_networks' );
	if (is_array($position_networks)) {
		$result[] = array('key' => $key, 'title' => 'Mobile Share Bar');
	}
	
	$key = 'sharepoint';
	$position_networks = essb_option_value ( $key.'_networks' );
	if (is_array($position_networks)) {
		$result[] = array('key' => $key, 'title' => 'Mobile Share Point');
	}

	$key = 'sharebottom';
	$position_networks = essb_option_value ( $key.'_networks' );
	if (is_array($position_networks)) {
		$result[] = array('key' => $key, 'title' => 'Mobile Share Buttons Bar');
	}
	
	if (!$as_text) {
		return $result;
	}
	else {
		$output = '';
		foreach ($result as $data) {
			$output .= ($output != '') ? ', '.$data['title'] : $data['title'];
		}
		
		return $output;
	}
}


function essb_postions_with_custom_options($as_text = false) {
	$result = array();

	foreach ( essb_avaliable_content_positions () as $key => $data ) {
		$key = str_replace("content_", "", $key);
		$position_networks = essb_option_value ( $key.'_activate' );

		if ($position_networks == 'true') {
			$result[] = array('key' => $key, 'title' => $data ['label']);
		}
	}

	foreach ( essb_available_button_positions () as $key => $data ) {
		$position_networks = essb_option_value ( $key.'_activate' );

		if ($position_networks == 'true') {
			$result[] = array('key' => $key, 'title' => $data ['label']);
		}
	}

	$key = 'mobile';
	$position_networks = essb_option_value ( $key.'_activate' );
	if ($position_networks == 'true') {
		$result[] = array('key' => $key, 'title' => 'Mobile Devices');
	}

	$key = 'sharebar';
	$position_networks = essb_option_value ( $key.'_activate' );
	if ($position_networks == 'true') {
		$result[] = array('key' => $key, 'title' => 'Mobile Share Bar');
	}

	$key = 'sharepoint';
	$position_networks = essb_option_value ( $key.'_activate' );
	if ($position_networks == 'true') {
		$result[] = array('key' => $key, 'title' => 'Mobile Share Point');
	}

	$key = 'sharebottom';
	$position_networks = essb_option_value ( $key.'_activate' );
	if ($position_networks == 'true') {
		$result[] = array('key' => $key, 'title' => 'Mobile Share Buttons Bar');
	}

	if (!$as_text) {
		return $result;
	}
	else {
		$output = '';
		foreach ($result as $data) {
			$output .= ($output != '') ? ', '.$data['title'] : $data['title'];
		}

		return $output;
	}
}
