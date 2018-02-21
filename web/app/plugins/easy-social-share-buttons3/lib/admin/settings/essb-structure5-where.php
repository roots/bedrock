<?php
// -- Where to display buttons
$where_to_display = 'where';
/*
 * ESSBOptionsStructureHelper::menu_item($where_to_display, 'posts', __('Post Types & Plugins', 'essb'), ' ti-widget-alt');
ESSBOptionsStructureHelper::menu_item($where_to_display, 'display', __('Positions on Site', 'essb'), ' ti-layout-grid2-alt', 'activate_first', 'display-2');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-2', __('Positions', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item($where_to_display, 'display', __('Positions on Site', 'essb'), ' ti-layout-grid2-alt', 'activate_first', 'display-2');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-3', __('Display Position Settings', 'essb'), 'chevron-down', 'menu', 'title');

 */
ESSBOptionsStructureHelper::menu_item($where_to_display, 'posts', __('Post Types', 'essb'), ' ti-widget-alt');
//ESSBOptionsStructureHelper::menu_item($where_to_display, 'display', __('Positions on Site', 'essb'), ' ti-layout-grid2-alt', 'activate_first', 'display-2');
ESSBOptionsStructureHelper::menu_item($where_to_display, 'positions', __('Positions', 'essb'), ' ti-widget-alt');
ESSBOptionsStructureHelper::menu_item($where_to_display, 'display', __('Position Settings', 'essb'), ' ti-layout-grid2-alt', 'activate_first', 'display-4');
//ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-3', __('Display Position Settings', 'essb'), 'chevron-down', 'menu', 'title');

//ESSBOptionsStructureHelper::menu_item('display', 'locations', __('Display Position Settings', 'essb'), 'default', 'activate_first', 'positions-3');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-4', __('Content Top', 'essb'),  'default', 'menu');
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-5', __('Content Bottom', 'essb'),  'default', 'menu', '');
if (!essb_options_bool_value('deactivate_method_float')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-6', __('Float from top', 'essb'),  'default', 'menu', '');
}

if (!essb_options_bool_value('deactivate_method_followme')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-18', __('Follow me share bar', 'essb'),  'default', 'menu', '');
}

if (!essb_options_bool_value('deactivate_method_corner')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-19', __('Corner Bar', 'essb'),  'default', 'menu', '');
}

if (!essb_options_bool_value('deactivate_method_booster')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-20', __('Share Booster', 'essb'),  'default', 'menu', '');
}


if (!essb_options_bool_value('deactivate_method_postfloat')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-7', __('Post vertical float', 'essb'),  'default', 'menu', '');
}
if (!essb_options_bool_value('deactivate_method_sidebar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-8', __('Sidebar', 'essb'),  'default', 'menu', '');
}
if (!essb_options_bool_value('deactivate_method_topbar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-9', __('Top bar', 'essb'),  'default', 'menu', '');
}
if (!essb_options_bool_value('deactivate_method_bottombar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-10', __('Bottom bar', 'essb'),  'default', 'menu', '');
}

if (!essb_options_bool_value('deactivate_method_popup')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-11', __('Pop up', 'essb'),  'default', 'menu', '');
}

if (!essb_options_bool_value('deactivate_method_flyin')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-12', __('Fly in', 'essb'),  'default', 'menu', '');
}

if (!essb_option_bool_value('deactivate_method_image')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-13', __('On media', 'essb'),  'default', 'menu', '');
}

if (!essb_options_bool_value('deactivate_method_heroshare')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-14', __('Full screen hero share', 'essb'),  'default', 'menu', '');
}

if (!essb_options_bool_value('deactivate_method_postbar')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-15', __('Post share bar', 'essb'),  'default', 'menu', '');
}
if (!essb_options_bool_value('deactivate_method_point')) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-16', __('Point', 'essb'),  'default', 'menu', '');
}
ESSBOptionsStructureHelper::submenu_item($where_to_display, 'display-17', __('Excerpt', 'essb'),  'default', 'menu', '');

// @since 4.1 allow usage of external display methods
$essb_custom_methods = array();
$essb_custom_methods = apply_filters('essb4_custom_method_list', $essb_custom_methods);
foreach ($essb_custom_methods as $key => $title) {
	ESSBOptionsStructureHelper::submenu_item($where_to_display, $key, $title,  'default', 'menu', '');
}

if (essb_option_value('functions_mode_mobile') != 'auto' && essb_option_value('functions_mode_mobile') != 'deactivate') {
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
}

if (function_exists('is_amp_endpoint') && essb_option_value('functions_mode') != 'light') {
	ESSBOptionsStructureHelper::menu_item($where_to_display, 'amp', __('AMP Sharing', 'essb'), ' ti-widget-alt');
	
}

if (!essb_option_bool_value('deactivate_method_integrations')) {
	ESSBOptionsStructureHelper::menu_item($where_to_display, 'plugins', __('Plugin Integrations', 'essb'), ' ti-widget-alt');
}


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
ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'posts', 'display_deactivate_on', __('Deactivate plugin on', 'essb'), __('Deactivate buttons on posts/pages with these IDs. Comma separated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts. Plugin also allows to deactivate only specific functions on selected page/post ids. <a href="'.admin_url('admin.php?page=essb_redirect_functions&tab=functions').'">Click here</a> to to that settings page.', 'essb'));
ESSBOptionsStructureHelper::field_switch($where_to_display, 'posts', 'deactivate_homepage', __('Deactivate buttons display on homepage', 'essb'), __('Exclude display of buttons on home page.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch('display', 'settings-1', 'deactivate_lists', __('Deactivate load of plugin resources on list of articles', 'essb'), __('Activate this option to stop load plugin resources on list of articles.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('social', 'settings-1', 'heading5', __('Automatic display on', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'posts', 'display_include_on', __('Automatic display buttons on', 'essb'), __('Provide list of post/page ids where buttons will display no matter that post type is active or not. Comma seperated values: "11, 15, 125". This will eactivate automated display of buttons on selected posts/pages even if post type that they use is not marked as active.', 'essb'));


if (!essb_options_bool_value('deactivate_method_integrations')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'plugins', __('WooCommerce', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'woocommece_share', __('Default WooCommerce hook for share buttons (after product brief description)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'woocommerce_after_add_to_cart_form', __('After add to cart button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'woocommece_beforeprod', __('Display buttons on top of product (before product)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'woocommece_afterprod', __('Display buttons at the bottom of product (after product)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'plugins');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'plugins', __('WP e-Commerce', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'wpec_before_desc', __('Display before product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'wpec_after_desc', __('Display after product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'wpec_theme_footer', __('Display at the bottom of page', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'plugins');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'plugins', __('JigoShop', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'jigoshop_top', __('JigoShop Before Product', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'jigoshop_bottom', __('JigoShop After Product', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'plugins');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'plugins', __('iThemes Exchange', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'ithemes_after_title', __('Display after product title', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'ithemes_before_desc', __('Display before product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'ithemes_after_desc', __('Display after product description', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'ithemes_after_product', __('Display after product advanced content (after product information)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'ithemes_after_purchase', __('Display share buttons for each product after successful purchase (when shopping cart is used)', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'plugins');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'plugins', __('bbPress', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'bbpress_forum', __('Display in forums', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'bbpress_topic', __('Display in topics', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'plugins');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'plugins', __('BuddyPress', 'essb'), __('Activate specific locations related to this plugin', 'essb'), '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'buddypress_activity', __('Display in activity', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'plugins', 'buddypress_group', __('Display on group page', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'plugins');
}

// positions

ESSBOptionsStructureHelper::title($where_to_display, 'positions',  __('Primary content display position', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'));
ESSBOptionsStructureHelper::field_single_position_select($where_to_display, 'positions', 'content_position', essb5_available_content_positions());

ESSBOptionsStructureHelper::title($where_to_display, 'positions',  __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'));
ESSBOptionsStructureHelper::field_multi_position_select($where_to_display, 'positions', 'button_position', essb5_available_button_positions());


add_action('admin_init', 'essb3_register_positions_by_posttypes');

essb_prepare_location_advanced_customization($where_to_display, 'display-4', 'top');
essb_prepare_location_advanced_customization($where_to_display, 'display-5', 'bottom');

if (!essb_options_bool_value('deactivate_method_float')) {
	//ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-6', __('Set custom top position of float bar', 'essb'), __('If your current theme has fixed bar or menu you may need to provide custom top position of float or it will be rendered below this sticked bar. For example you can try with value 40 (which is equal to 40px from top).', 'essb'));
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-6', __('Floating Bar Fixed Position & Auto Hide', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-6');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_top', __('Top position for non logged in users', 'essb'), __('Customize default fixed position of floating bar. You may need to enter value here if your site has a fixed menu or other top fixed element (numeric value)', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_top_loggedin', __('Top position for logged in users', 'essb'), __('If you display WordPress admin bar for logged in users you can correct float from top position for logged in users to avoid bar to be rendered below WordPress admin bar.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_top_disappear', __('Autohide after percent of content is viewed', 'essb'), __('Provide value in percent if you wish to hide float bar - for example 80 will make bar to disappear when 80% of page content is viewed from user.', 'essb'), '', 'input60', 'fa-sort-numeric-asc', 'right');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-6');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-6');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-6', __('Background color of floating bar', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_panels($where_to_display, 'display-6', __('Background color', 'essb'), __('Change default background color of float bar (default is white #FFFFFF).', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-6', 'float_bg', __('Choose background color', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_bg_opacity', __('Change opacity of background color', 'essb'), __('Change default opacity of background color if you wish to have a semi-transparent effect (default is 1 full color). You can enter value between 0 and 1 (example: 0.7)', 'essb'), '', 'input60');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-6');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-6');
	
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-6', __('Content width inside floating bar & margins', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-6');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-6', 'float_full', __('Set full width of float bar', 'essb'), __('This option will make float bar to take full width of browser window.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-6', 'float_full_maxwidth', __('Max width of buttons area', 'essb'), __('Provide custom max width of buttons area when full width float bar is active. Provide number value in pixels without the px (example 960)', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-6', 'float_remove_margin', __('Remove top space', 'essb'), __('This option will clear the blank space that may appear according to theme settings between top of window and float bar.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-6');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-6');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-6', 'float');
}

if (!essb_options_bool_value('deactivate_method_postfloat')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-7', __('Correct Initial & Fixed Top Position', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-7');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_initialtop', __('Custom top position of post float bar when loaded', 'essb'), __('Customize the initial top position of post float bar if you wish to be different from content start.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_top', __('Top position of post float buttons when they are fixed', 'essb'), __('Filled value to change the top position if you have another fixed element (example: fixed menu).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-7');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-7');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-7', __('Change Horizontal & Vertical Offset from Content', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-7');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_marginleft', __('Horizontal offset from content', 'essb'), __('You can provide custom left offset from content. Leave blank to use default value.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_margintop', __('Vertical offset from content start', 'essb'), __('You can provide custom vertical offset from content start. Leave blank to use default value. (Negative values moves up, positve moves down).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-7');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-7');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-7', __('Automatica Appear or Disappear On', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-7');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-7', 'postfloat_percent', __('Display after percent of content is passed', 'essb'), __('Provide percent of content to viewed when buttons will appear (default state if this field is provided will be hidden for that display method).', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-7', 'postfloat_always_visible', __('Do not hide post vertical float at the end of content', 'essb'), __('Activate this option to make post vertical float stay on screen when end of post content is reached.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-7');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-7');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-7', 'postfloat');
}

if (!essb_options_bool_value('deactivate_method_sidebar')) {
	$listOfOptions = array("" => "Left", "right" => "Right");
	$sidebar_loading_animations = array("" => __("No animation", "essb"), "slide" => __("Slide", "essb"), "fade" => __("Fade", "essb"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-8');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-8', 'sidebar_pos', __('Sidebar Appearance', 'essb'), __('You choose different position for sidebar. Available options are Left (default), Right', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-8', 'sidebar_entry_ani', __('Display animation', 'essb'), __('Assign sidebar initial appearance animation - a nice way to catch visitors attention.', 'essb'), $sidebar_loading_animations);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-8');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-8', __('Customize Top & Left/Right Position of Sidebar', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-8');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_fixedleft', __('Customize left/right position of sidebar', 'essb'), __('Use this field to change initial position of sidebar. You can use numeric value for example 10.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_fixedtop', __('Fixed top position of sidebar', 'essb'), __('You can provide custom top position of sidebar in pixels or percents (ex: 100px, 15%).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-8');	
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-8');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-8', __('Sidebar Appear/Disappear on Scroll and Close Sidebar Button', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-8');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_leftright_percent', __('Display after amount of content is viewed', 'essb'), __('If you wish to make sidebar appear after percent of content is viewed enter value here (leave blank to appear immediately after load).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-8', 'sidebar_appear_unit', __('Measuring unit of appear value', 'essb'), __('Default appearance value is % but you can change it here to px', 'essb'), array('' => '%', 'px' => 'px'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-8', 'sidebar_leftright_percent_hide', __('Hide after percent of content is viewed', 'essb'), __('If you wish to make sidebar disappear after percent of content is viewed enter value here (leave blank to make it always be visible).', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-8', 'sidebar_leftright_close', __('Add close sidebar button', 'essb'), __('Activate that option to add a close sidebar button.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-8');	
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-8');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-8', 'sidebar');
}

if (!essb_options_bool_value('deactivate_method_topbar')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-9', __('Top Bar Appearance & Position', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-9');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_top', __('Top position for non logged in users', 'essb'), __('The bar has a default initial position but if your site has a fixed top element you can use this field to change the initial top position and avoid bar appear before/above that fixed element', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_top_loggedin', __('Top position for logged in users', 'essb'), __('If you display WordPress admin bar for logged in users you can correct float from top position for logged in users to avoid bar to be rendered below WordPress admin bar.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_top_onscroll', __('Appear after percent of content is viewed', 'essb'), __('If you wish top bar to appear when user starts scrolling fill here percent of conent after is viewed it will be visible.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_hide', __('Hide after percent of content is viewed', 'essb'), __('Provide value in percent if you wish to hide float bar - for example 80 will make bar to disappear when 80% of page content is viewed from user.', 'essb'), '', 'input60', 'fa-sort-numeric-asc', 'right');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-9');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-9');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-9', __('Background Color', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-9');
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-9', 'topbar_bg', __('Choose background color', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_bg_opacity', __('Change opacity of background color', 'essb'), __('Change default opacity of background color if you wish to have a semi-transparent effect (default is 1 full color). You can enter value between 0 and 1 (example: 0.7)', 'essb'), '', 'input60');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-9');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-9');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-9', __('Width, Height & Button Placement', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-9');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_height', __('Height of top bar content area', 'essb'), __('Provide custom height of content area. Provide number value in pixels without the px (example 40). Leave blank for default height.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-9', 'topbar_maxwidth', __('Max width of content area', 'essb'), __('Provide custom max width of content area. Provide number value in pixels without the px (example 960). Leave blank for full width.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	$listOfOptions = array("" => "Left", "center" => "Center", "right" => "Right");
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-9', 'topbar_buttons_align', __('Align buttons', 'essb'), __('Choose your button alignment', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-9');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-9');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-9', __('INCLUDE CUSTOM CONTENT', 'essb'), __('Inside bar you can add custom content along with your share buttons.'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'topbar_contentarea', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-9');
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

	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-10', __('Bottom Bar Appear/Disappear on Scroll', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_top_onscroll', __('Appear after percent of content is viewed', 'essb'), __('If you wish bottom bar to appear when user starts scrolling fill here percent of conent after is viewed it will be visible.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_hide', __('Hide after percent of content is viewed', 'essb'), __('Provide value in percent if you wish to hide float bar - for example 80 will make bar to disappear when 80% of page content is viewed from user.', 'essb'), '', 'input60', 'fa-sort-numeric-asc', 'right');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-10');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-10', __('Background Color of Bar', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-10', 'bottombar_bg', __('Choose background color', 'essb'), __('Overwrite default bar background color #ffffff (white)', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_bg_opacity', __('Change opacity of background color', 'essb'), __('Change default opacity of background color if you wish to have a semi-transparent effect (default is 1 full color). You can enter value between 0 and 1 (example: 0.7)', 'essb'), '', 'input60');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-10');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-10', __('Width, Height & Buttons Placement', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_height', __('Height of top bar content area', 'essb'), __('Provide custom height of content area. Provide number value in pixels without the px (example 40). Leave blank for default value.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_maxwidth', __('Max width of content area', 'essb'), __('Provide custom max width of content area. Provide number value in pixels without the px (example 960). Leave blank for full width.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	$listOfOptions = array("" => "Left", "center" => "Center", "right" => "Right");
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-10', 'bottombar_buttons_align', __('Align buttons', 'essb'), __('Choose your content area alignment', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-10');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-10', __('BOTTOM BAR CUSTOM CONTENT SETTINGS', 'essb'), __('Include custom content into bottom bar along with your share buttons'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'bottombar_contentarea', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-10');
	$listOfOptions = array("left" => "Left", "right" => "Right");
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-10', 'bottombar_contentarea_width', __('Custom content area % width', 'essb'), __('Provide custom width of content area (default value if nothing is filled is 30 which means 30%). Fill number value without % mark - example 40.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-10', 'bottombar_contentarea_pos', __('Custom content area position', 'essb'), __('Choose your button alignment', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-10');
	ESSBOptionsStructureHelper::field_wpeditor($where_to_display, 'display-10', 'bottombar_usercontent', __('Custom content', 'essb'), '', 'htmlmixed');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-10');

	essb_prepare_location_advanced_customization($where_to_display, 'display-10', 'bottombar');
}

if (!essb_options_bool_value('deactivate_method_popup')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-11', __('Custom Pop Up Content Settings', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-11', 'popup_window_title', __('Pop up window title', 'essb'), __('Set your custom pop up window title.', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'display-11', 'popup_user_message', __('Pop up window message', 'essb'), __('Set your custom message that will appear above buttons', 'essb'), "htmlmixed");
	ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-11', 'popup_user_width', __('Pop up window width', 'essb'), __('Set your custom window width (default is 800 or window width - 60). Value if provided should be numeric without px symbols.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-11');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-11', __('Display On The Following Events', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-11');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_window_popafter', __('Display pop up window after (sec)', 'essb'), __('If you wish pop up window to appear after amount of seconds you can provide theme here. Leave blank for immediate pop up after page load.', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_user_percent', __('Display pop up window after percent of content is viewed', 'essb'), __('Set amount of page content after which the pop up will appear.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_end', __('Display pop up at the end of content', 'essb'), __('Automatically display pop up when the content end is reached', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_exit', __('Display pop up on exit intent', 'essb'), __('Automatically display pop up when exit intent is detected', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_comment', __('Display pop up on user comment', 'essb'), __('Automatically display pop up when user leave a comment.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_display_purchase', __('Display pop up after WooCommerce purchase', 'essb'), __('Display on Thank You page of WooCommerce after purchase', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_user_manual_show', __('Manual window display mode', 'essb'), __('Activating manual display mode will allow you to show window when you decide with calling following javascript function essb_popup_show();', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_avoid_logged_users', __('Do not show pop up for logged in users', 'essb'), __('Activate this option to avoid display of pop up when user is logged in into site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-11');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-11');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-11', __('Automatic close & do not show again', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-11');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_window_close_after', __('Automatically close pop up after (sec)', 'essb'), __('You can provide seconds and after they expire window will close automatically. User can close this window manually by pressing close button.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-11', 'popup_user_autoclose', __('Close up message customize', 'essb'), __('Set custom text announcement for closing the pop up. After your text there will be timer counting the seconds leaving.', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_user_notshow_onclose', __('After user close window do not show it again on this page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on this post/page', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-11', 'popup_user_notshow_onclose_all', __('After user close window do not show it again on all page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on all posts/pages', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-11');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-11');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-11', 'popup');
}

if (!essb_options_bool_value('deactivate_method_flyin')) {

	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-12', __('Fly in Custom content and Position', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-12', 'flyin_window_title', __('Fly in window title', 'essb'), __('Set your custom fly in window title.', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'display-12', 'flyin_user_message', __('Fly in window message', 'essb'), __('Set your custom message that will appear above buttons', 'essb'), "htmlmixed");
	ESSBOptionsStructureHelper::field_textbox($where_to_display, 'display-12', 'flyin_user_width', __('Fly in window width', 'essb'), __('Set your custom window width (default is 400 or window width - 60). If value is provided should be numeric without px symbols.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	$listOfOptions = array("right" => "Right", "left" => "Left");
	ESSBOptionsStructureHelper::field_select($where_to_display, 'display-12', 'flyin_position', __('Choose fly in display position', 'essb'), '', $listOfOptions);
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'display-12', 'flyin_noshare', __('Do not show share buttons in fly in', 'essb'), __('Activating this you will get a fly in display without share buttons in it - only the custom content you have set.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-12');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-12', __('Display on the following events', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-12');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_window_popafter', __('Display fly in window after (sec)', 'essb'), __('If you wish fly in window to appear after amount of seconds you can provide them here. Leave blank for immediate pop up after page load.', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_user_percent', __('Display fly in window after percent of content is viewed', 'essb'), __('Set amount of page content after which the pop up will appear.', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_display_end', __('Display fly in at the end of content', 'essb'), __('Automatically display fly in when the content end is reached.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_display_comment', __('Display fly in on user comment', 'essb'), __('Automatically display fly in when user leaves a comment.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_user_manual_show', __('Manual fly in display mode', 'essb'), __('Activating manual display mode will allow you to show window when you decide with calling following javascript function essb_flyin_show();', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-12');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-12');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-12', __('Automatic Close & do not show again', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-12');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_window_close_after', __('Automatically close fly in after (sec)', 'essb'), __('You can provide seconds and after they expire window will close automatically. User can close this window manually by pressing close button.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-12', 'flyin_user_autoclose', __('Close up message customize', 'essb'), __('Set custom text announcement for closing the fly in. After your text there will be timer counting the seconds leaving.', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_user_notshow_onclose', __('After user closes window do not show it again on this page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on this post/page', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-12', 'flyin_user_notshow_onclose_all', __('After user close window do not show it again on all page/post for him', 'essb'), __('Activating this option will set cookie that will not show again pop up message for next 7 days for user on all posts/pages', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-12');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-12');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-12', 'flyin');
}

if (!essb_option_bool_value('deactivate_method_image')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-13', __('On media buttons appearance', 'essb'), __('Choose where you wish buttons to appear', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-13');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_selector', __('Default image share selector', 'essb'), __('Provide your own custom image selector that will allow to pickup share images. Leave blank for use the default or use <b>.essbis_site img</b> to allow share of any image on site.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_dontshow', __('Do not show on', 'essb'), __('Set image classes and IDs for which on media display buttons won\'t show. Separate several selectors with commas. (example: .notshow or .notshow,#notshow', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-13');

	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-13');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_minWidth', __('Minimal width', 'essb'), __('Minimum width of image for sharing. Use value without px.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_minHeight', __('Minimal height', 'essb'), __('Minimum height of image for sharing. Use value without px.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_minWidthMobile', __('Minimal width on Mobile', 'essb'), __('Minimum width of image for sharing. Use value without px.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_minHeightMobile', __('Minimal height on Mobile', 'essb'), __('Minimum height of image for sharing. Use value without px.', 'essb'));
	
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-13', 'sis_always_visible', __('Always visible share icons', 'essb'), __('Use this option to make on media share buttons always visible on desktop. The function may not work if you have lazy loading images.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-13', 'sis_facebookapp', __('Facebook Application ID', 'essb'), __('If you wish to make plugin selected image on Facebook you need to create application and make it public to use advanced sharing. Advanced sharing will allow to post any image on Facebook but it will allow share on personal timeline only.', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-13');
	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-13');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-13', 'sis_on_mobile', __('Enable on mobile', 'essb'), __('Enable image sharing on mobile devices', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-13', 'sis_on_mobile_click', __('Appear on mobile with click', 'essb'), __('The on media buttons are always visible when you open site with mobile device. Use this option if you wish to make the appear with click over image.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-13');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-13');
	
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-13', __('Use the following social buttons', 'essb'), __('Choose social buttons that you will use on media images', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));
	$listOfNetworks = array( "facebook", "twitter", "google", "linkedin", "pinterest", "tumblr", "reddit", "digg", "delicious", "vkontakte", "odnoklassniki");
	$listOfNetworksAdvanced = array( "facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google", "linkedin" => "LinkedIn", "pinterest" => "Pinterest", "tumblr" => "Tumblr", "reddit" => "Reddit", "digg" => "Digg", "delicious" => "Delicious", "vkontakte" => "VKontakte", "odnoklassniki" => "Odnoklassniki");
	ESSBOptionsStructureHelper::field_checkbox_list($where_to_display, 'display-13', 'sis_networks', __('Activate networks', 'essb'), __('Choose active social networks', 'essb'), $listOfNetworksAdvanced);
	ESSBOptionsStructureHelper::field_simplesort($where_to_display, 'display-13', 'sis_network_order', __('Display order', 'essb'), __('Arrange network appearance using drag and drop', 'essb'), $listOfNetworks);
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-13');
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-13', __('Visual display setup', 'essb'), __('Customize look and feel of your social share buttons that appear on images', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));
	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-13');
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
	$listOfTemplates = array("" => "Default", "tiny" => "Tiny", "flat-small" => "Small", "flat" => "Regular", "round" => "Round");
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-13', 'sis_mobile_style', __('Template on Mobile', 'essb'), __('Choose buttons template that will be used on a mobile device. You can use only build into module templates to avoid misconfiguration', 'essb'), $listOfTemplates);
	$listOfOptions = array("horizontal" => __("Horizontal", 'essb'), "vertical" => __("Vertical", 'essb'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-13', 'sis_orientation', __('Orientation', 'essb'), __('Display buttons aligned horizontal or vertical', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-13');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-13');
}
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
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-15', __('Deactivate Post Bar Default Components', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-15');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_deactivate_prevnext', __('Deactivate previous/next articles', 'essb'), __('Activate this option if you wish to deactivate display of previous/next article buttons', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_deactivate_progress', __('Deactivate read progress bar', 'essb'), __('Activate this option if you wish to deactivate display of read progress', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_deactivate_title', __('Deactivate post title', 'essb'), __('Activate this option if you wish to deactivate display of post title', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-15');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-15');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-15', __('Activate Additional Components', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-15');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_category', __('Activate display of category', 'essb'), __('Activate this option if you wish to activate display of category', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_author', __('Activate display of post author', 'essb'), __('Activate this option if you wish to activate display of post author', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_total', __('Activate display of total shares counter', 'essb'), __('Activate this option if you wish to activate display of total shares counter', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_comments', __('Activate display of comments counter', 'essb'), __('Activate this option if you wish to activate display of comments counter', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-15', 'postbar_activate_time', __('Activate display of time to read', 'essb'), __('Activate this option if you wish to activate display of time to read', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-15', 'postbar_activate_time_words', __('Words per minuted for time to read', 'essb'), __('Customize the words per minute for time to read display', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-15');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-15');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-15', __('Personalize Colors', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-15');
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_bgcolor', __('Change default background color', 'essb'), __('Customize the default post bar background color (#FFFFFF)', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_color', __('Change default text color', 'essb'), __('Customize the default post bar text color (#111111)', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_accentcolor', __('Change default accent color', 'essb'), __('Customize the default post bar accent color (#3D8EB9)', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-15', 'postbar_altcolor', __('Change default alt text color', 'essb'), __('Customize the default post bar alt text color (#FFFFFF) which is applied to elements with accent background color', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-15');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-15');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-15', __('Customize Buttons Style', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	$tab_id = $where_to_display;
	$menu_id = 'display-15';
	$location = 'postbar';
	
	
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_button_style', __('Buttons Style', 'essb'), __('Select your button display style.', 'essb'), essb_avaiable_button_style_with_recommend());
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_template', __('Template', 'essb'), __('Select your template for that display location.', 'essb'), essb_available_tempaltes4(true));
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position', 'essb'), essb_avaliable_counter_positions());

	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-15');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-15', 'postbar');
}

if (!essb_options_bool_value('deactivate_method_point')) {

	// Point
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-16', __('Point Appearance & Style', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-16');
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
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-16', 'point_close', __('Automatic close after seconds', 'essb'), __('Enter a value if you wish to setup automated close of the point display method once it is is opened on screen (numeric value, example: 5 (5 seconds))', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-16');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-16');
	

	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-16', __('Personalize Colors', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-16');
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_bgcolor', __('Change default background color', 'essb'), __('Customize the default point background color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_color', __('Change default text color', 'essb'), __('Customize the default point text color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_accentcolor', __('Change default total background color', 'essb'), __('Customize the default total background color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-16', 'point_altcolor', __('Change default total text color', 'essb'), __('Customize the default total text color', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'display-16');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-16');
	



	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-16', __('Customize Buttons Style', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));	
	$tab_id = $where_to_display;
	$menu_id = 'display-16';
	$location = 'point';
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_button_style', __('Buttons Style', 'essb'), __('Select your button display style.', 'essb'), essb_avaiable_button_style_with_recommend());
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_template', __('Template', 'essb'), __('Select your template for that display location.', 'essb'), essb_available_tempaltes4());
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position. Please note that if you use Simple icons mode all Inside positions will act like Inside - network names will not appear because of visual limitations', 'essb'), essb_avaliable_counter_positions_point());
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-16');
	
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-16', __('Custom Content for Advanced Point Display', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));	
	ESSBOptionsStructureHelper::field_wpeditor($where_to_display, 'display-16', 'point_top_content', __('Custom content above share buttons', 'essb'), __('Optional: Provide custom content that will appear above share buttons. You can use the variables to display post related content: %%title%%, %%url%%, %%image%%, %%permalink%%', 'essb'), 'htmlmixed');
	ESSBOptionsStructureHelper::field_wpeditor($where_to_display, 'display-16', 'point_bottom_content', __('Custom content below share buttons', 'essb'), __('Optional: Provide custom content that will appear below share buttons. You can use the variables to display post related content: %%title%%, %%url%%, %%image%%, %%permalink%%', 'essb'), 'htmlmixed');
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'display-16', 'point_articles', __('Display prev/next article', 'essb'), __('Activate this option to display prev/next article from same category', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-16');

	essb_prepare_location_advanced_customization($where_to_display, 'display-16', 'point');
}

essb_prepare_location_advanced_customization($where_to_display, 'display-17', 'excerpt');

if (!essb_options_bool_value('deactivate_method_followme')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-18', __('Follow me bar appearance', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-18');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-18', 'followme_pos', __('Follow me bar appearance', 'essb'), __('Set where the bar will appear when user scroll down on content. Default appearance is bottom but you can change to top too.', 'essb'), array('' => 'Bottom', 'top' => 'Top'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-18', 'followme_content', __('Static content share buttons position', 'essb'), __('Choose where you wish to display the static content share buttons in content. The default is above and below content but you can set above or bottom only too.', 'essb'), array('' => 'Above & Below Content', 'above' => 'Above Content Only', 'below' => 'Below Content Only'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-18', 'followme_full', __('Display buttons on full screen width', 'essb'), __('The default width of buttons area inside follow me bar will be the width of buttons inside content. Set this option if you wish to make it take the full width of screen.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-18', 'followme_top', __('Custom top position', 'essb'), __('Only when top appearance is selected. Use this field if you have a fixed top element and you wish to avoid appearance of bar over it. (numeric value, example: 50)', 'essb'), '', 'input60', 'fa-arrows-v', 'right');

	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-18', 'followme_nomargin', __('Remove top/bottom space', 'essb'), __('The bar has little top and bottom space added to get a better look. On some designs you may wish to remove it - if so just activate the option (or you can add your own custom code).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-18', 'followme_noleftmargin', __('My bar does not appear centered on screen', 'essb'), __('If you experience that type of problem just activate this option to fix it.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-18', 'followme_hide', __('Hide before end of page', 'essb'), __('Set this option to yes if you wish the bar to disappear before end of page.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-18');

	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-18', 'followme_bg', __('Customize bar background', 'essb'), __('The follow me bar has solid white color as background. If you wish to change that color use this field and set your own (alpha colors supported)', 'essb'), '', 'true');
	
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-18');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-18', 'followme');
}

if (!essb_options_bool_value('deactivate_method_corner')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-19', __('Corner Bar Apperance', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-19');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-19', 'cornerbar_pos', __('Position on screen', 'essb'), __('Choose the edge of screen where buttons will appear. Default is bottom right corner', 'essb'), array('' => 'Bottom Right', 'bottom-left' => 'Bottom Left', 'top-right' => 'Top Right', 'top-left' => 'Top Left'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-19', 'cornerbar_style', __('Bar style', 'essb'), __('Choose a style of bar that contains share buttons', 'essb'), array('' => 'Transparent', 'light' => 'Light', 'dark' => 'Dark', 'glow' => 'Glow'));
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-19', 'cornerbar_bg', __('Customize bar background', 'essb'), __('Set custom background color when you are using different style than transparent', 'essb'), '', 'true');
	
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-19', 'cornerbar_width', __('Set custom max-width of bar', 'essb'), __('Bar has default max-width that can be use of 640px. Use this field to change that by entering your custom value: example: 400px, 50%', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-19');
	
	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-19');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-19', 'cornerbar_hide', __('Hide before end of page', 'essb'), __('Set this option to yes if you wish the bar to disappear before end of page.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-19', 'cornerbar_show', __('Visibility on screen', 'essb'), __('Choose when bar will be visible based on various conditions', 'essb'), array('' => 'Immediately after page load', 'onscroll' => 'Appear on scroll', 'onscroll50' => 'Appear on scroll when at least 50% of content is viewed', 'content' => 'Appear when content buttons are not visible (static positions for above/below content)'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-19');
	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-19');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-19', 'cornerbar_text', __('Custom text before share buttons', 'essb'), __('Enter custom text to engage shares. Example: Share', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-19', 'cornerbar_arrow', __('Add arrow after text', 'essb'), __('Include nice styled arrow pointing share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-19', 'cornerbar_small', __('Small size text', 'essb'), __('Text will appear by default using the theme font size. Set this option to make it looks time (12px).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-19');
	
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-19');
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-19', 'cornerbar');
	
}

if (!essb_options_bool_value('deactivate_method_booster')) {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-20', __('Booster Appearance', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-20');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-20', 'booster_trigger', __('Appear', 'essb'), __('Choose when share booster will overtake window', 'essb'), array('' => 'Immediately', 'time' => 'Time Delayed', 'scroll' => 'On Scroll'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-20', 'booster_time', __('Delay in seconds', 'essb'), __('Set amount of seconds to wait before booster appear', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-20', 'booster_scroll', __('Percent of content read', 'essb'), __('Set percent of content to be read before booster appear', 'essb'), '', 'input60', 'fa-arrows-v', 'right');
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-20', 'booster_bg', __('Overlay background color', 'essb'), __('Setup custom overlay color that will appear over content.', 'essb'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-20');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-20');

	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-20', __('Booster Disappear', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-20');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-20', 'booster_donotshow', __('Do not show again for', 'essb'), __('Set custom number of days when booster will remain inactive once appear for user', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'display-20', 'booster_donotshow_on', __('Do not show on', 'essb'), __('Customize hide of booster for current post/page or all posts/pages', 'essb'), array('' => 'Current post/page only', 'all' => 'All posts/pages on site'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-20', 'booster_autoclose', __('Automatically close if no action', 'essb'), __('Make booster overlay close automatically after amount of seconds. Leave blank to remain constantly on screen waiting for action.', 'essb'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'display-20', 'booster_manualclose', __('Allow user manually close the screen', 'essb'), __('Set this option to Yes if you wish to allow user manually close the screen. This will not raise do not show action and this visitor will see again the booster screen when post is loaded till an action of sharing is made.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'display-20', 'booster_manualclose_text', __('Close link text', 'essb'), __('Set a custom close text that will change the default (only if the manual close link is active).', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-20');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-20');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'display-20', __('Booster Window Content', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'display-20');
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-20', 'booster_window_bg', __('Content background', 'essb'), __('Custom content background color.', 'essb'), '', 'true');
	ESSBOptionsStructureHelper::field_color_panel($where_to_display, 'display-20', 'booster_window_color', __('Content text color', 'essb'), __('Custom content text color.', 'essb'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels($where_to_display, 'display-20');
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'display-20', 'booster_title', __('Title', 'essb'), __('Set own personalized title.', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'display-20', 'booster_message', __('Custom message', 'essb'), __('Set your custom message that will appear above buttons (shortcodes supported)', 'essb'), "htmlmixed");
	ESSBOptionsStructureHelper::field_image($where_to_display, 'display-20', 'booster_bg_image', __('Background image', 'essb'), __('Set custom background image that will appear on the content screen', 'essb'), '', 'vertical1');	
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'display-20');
	
	
	essb_prepare_location_advanced_customization($where_to_display, 'display-20', 'booster');
}
//ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading1', __('Mobile: Display Options', 'essb'));
//ESSBOptionsStructureHelper::hint($where_to_display, 'mobile-1', __('', 'essb'), __('Please note that not all popular cache plugins support mobile cache (you have one version of site on all devices). If you use such cache plugin you may not see your mobile settings working. If that is so you can deactivate cache of for mobile devices and get full control of mobile sharing or activate client side mobile detection (a.k.a. responsive butons) which will control only mobile display methods (option is located at the bottom of this screen).<br/><br/><b>Recommended cache plugin for usage with mobile settings is <a href="http://wp-rocket.me" target="_blank">WP Rocket</a>. <a href="http://wp-rocket.me" target="_blank">WP Rocket</a> supports separate mobile caching and you will be able to gain the full power of our mobile share options.</b>.', 'essb'), '');
if (essb_option_value('functions_mode_mobile') != 'auto' && essb_option_value('functions_mode_mobile') != 'deactivate') {

	ESSBOptionsStructureHelper::panel_start($where_to_display, 'mobile-1', __('Personalize display of share buttons on mobile device', 'essb'), __('Activate this option to change your mobile displayed positions and style settings of sharing buttons', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'mobile_positions', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
	ESSBOptionsStructureHelper::title($where_to_display, 'mobile-1',  __('Primary content display position', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'));
	ESSBOptionsStructureHelper::field_single_position_select($where_to_display, 'mobile-1', 'content_position_mobile', essb5_available_content_positions_mobile());
	
	ESSBOptionsStructureHelper::title($where_to_display, 'mobile-1',  __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'));
	ESSBOptionsStructureHelper::field_multi_position_select($where_to_display, 'mobile-1', 'button_position_mobile', essb5_available_button_positions_mobile());
	
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'mobile-1');
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_exclude_tablet', __('Do not apply mobile settings for tablets', 'essb'), __('You can avoid mobile rules for settings for tablet devices.', 'essb'), 'recommeded', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_avoid_newwindow', __('Open sharing window in same tab', 'essb'), __('Activate this option if you wish to make sharing on mobile open in same tab. Warning! Option may lead to loose visitor as once share dialog is opened with this option user will leave your site. Use with caution..', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'mobile-1');
	
	ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading4', __('Customize active social networks', 'essb'));
	ESSBOptionsStructureHelper::title($where_to_display, 'mobile-1', __('', 'essb'), __('Choose social networks you wish to see appearing when your site is opened from a mobile device. This list is optional and you can use it in case you need to set a personalized mobile network list. Otherwise leave it blank for faster update of settings.', 'essb'), 'inner-row');
	
	ESSBOptionsStructureHelper::field_network_select($where_to_display, 'mobile-1', 'mobile_networks', 'mobile');
	
	ESSBOptionsStructureHelper::holder_start($where_to_display, 'mobile-1', 'essb-panel-sharebar', 'essb-panel-sharebar');
	ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading4', __('Share bar customizations', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched($where_to_display, 'mobile-1', 'mobile_sharebar_text', __('Text on share bar', 'essb'), __('Customize the default share bar text (default is Share).', 'essb'));
	ESSBOptionsStructureHelper::holder_end($where_to_display, 'mobile-1');
	
	ESSBOptionsStructureHelper::holder_start($where_to_display, 'mobile-1', 'essb-panel-sharebuttons', 'essb-panel-sharebuttons');
	ESSBOptionsStructureHelper::field_heading($where_to_display, 'mobile-1', 'heading4', __('Share buttons bar customizations', 'essb'));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'mobile-1');
	$listOfOptions = array("1" => "1 Button", "2" => "2 Buttons", "3" => "3 Buttons", "4" => "4 Buttons", "5" => "5 Buttons", "6" => "6 Buttons", "7" => "7 Buttons", "8" => "8 Buttons");
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_count', __('Number of buttons in share buttons bar', 'essb'), __('Provide number of buttons you wish to see in buttons bar. If the number of activated buttons is greater than selected here the last button will be more button which will open pop up with all active buttons.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_names', __('Display network names', 'essb'), __('Activate this option to display network names (default display is icons only).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	//ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_fix', __('Fix problem with buttons not displayed in full width', 'essb'), __('Some themes may overwrite the default buttons style and in this case buttons do not take the full width of screen. Activate this option to fix the overwritten styles.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_total', __('Display total counter', 'essb'), __('Activate this option to display total share counter as first button. If you activate it please keep in mind that you need to set number of columns to be with one more than buttons you except to see (total counter will act as single button)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_total_source', __('Total value source', 'essb'), __('Choose the source of total values that you will see - shares or views/reads (require views/reads extension)', 'essb'), array('' => 'Shares', 'views' => 'Views/Reads'));
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'mobile-1');
	
	ESSBOptionsStructureHelper::title($where_to_display, 'mobile-1', __('Bar appearance', 'essb'), __('By default share bar will be visible after page is fully loaded. If you wish using fields below you can set to appear/disappear on scroll.', 'essb'));
	ESSBOptionsStructureHelper::field_section_start_full_panels($where_to_display, 'mobile-1');
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_showscroll', __('Show after % of content', 'essb'), __('Fill a numeric value of percent (example 10) if you wish the bar to appear on scroll.', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_hideend', __('Hide buttons bar before end of page', 'essb'), __('This option is made to hide buttons bar once you reach 90% of page content to allow the entire footer to be visible.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_hideend_percent', __('% of content is viewed to hide buttons bar before end of page', 'essb'), __('Customize the default percent 90 when buttons bar will hide. Enter value in percents without the % mark.', 'essb'));
	$listOfOptions = array("" => "Bottom", "top" => "Top");
	ESSBOptionsStructureHelper::field_select_panel($where_to_display, 'mobile-1', 'mobile_sharebuttonsbar_pos', __('Bar position on screen', 'essb'), __('Default position of bar on screen is bottom but you can swap it to top using this field.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_section_end_full_panels($where_to_display, 'mobile-1');
	
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'mobile-1', __('Include Bottom Ad Code', 'essb'), __('Activate this option if you wish to make your mobile bar include also custom ad code below share buttons when display bottom or at the bottom when share buttons are displayed on top. The custom ad code will be always visible no matter of bar appearance rules when they are displayed separately.'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'sharebottom_adarea', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_color($where_to_display, 'mobile-1', 'sharebottom_usercontent_bg', __('Setup custom background color', 'essb'), __('Enter custom background color which will apply over the ad bar. That field is required only if you wish to set such. By default bar is transparent when you see it separate from share buttons or it will have background related to bar with buttons', 'essb'));
	ESSBOptionsStructureHelper::field_switch($where_to_display, 'mobile-1', 'sharebottom_usercontent_control', __('Apply bar appearance rules', 'essb'), __('Activate this option to make ad bar appear/disappear based on share bar rules. If option is not set bar will be always visible on screen', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_editor($where_to_display, 'mobile-1', 'sharebottom_usercontent', __('Ad code/custom code', 'essb'), __('Shortcodes supported', 'essb'), 'htmlmixed');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'mobile-1');
	
	ESSBOptionsStructureHelper::holder_end($where_to_display, 'mobile-1');
	
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
}

if (function_exists('is_amp_endpoint') && essb_option_value('functions_mode') != 'light') {
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'amp', __('Personalize display of share buttons on AMP pages/posts', 'essb'), __('Activate this option to change your mobile displayed positions and style settings of sharing buttons', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'amp_positions', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
	ESSBOptionsStructureHelper::title($where_to_display, 'amp',  __('Primary content display position', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'));
	ESSBOptionsStructureHelper::field_single_position_select($where_to_display, 'amp', 'content_position_amp', essb_avaliable_content_positions_amp());
		
	ESSBOptionsStructureHelper::field_heading($where_to_display, 'amp', 'heading4', __('Customize active social networks', 'essb'));
	ESSBOptionsStructureHelper::title($where_to_display, 'amp', __('', 'essb'), __('Choose social networks you wish to see appearing when your site is opened from a mobile device. This list is optional and you can use it in case you need to set a personalized mobile network list. Otherwise leave it blank for faster update of settings.', 'essb'), 'inner-row');
	
	ESSBOptionsStructureHelper::field_network_select($where_to_display, 'amp', 'amp_networks', 'amp');
	ESSBOptionsStructureHelper::panel_end($where_to_display, 'amp');
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
		ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('Deactivate display on device or specific components', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
		
		//ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading5', __('Deactivate display of functions', 'essb'));
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
		ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
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

	if (!essb_option_bool_value($location.'_activate')) {
		ESSBOptionsStructureHelper::hint($tab_id, $menu_id, __('Personalize buttons to get maximum impact', 'essb'), __('Not always global display styles or social networks are suitable for a location you use. Easy Social Share Buttons provide extended options to personalize everything for just that location. To do this activate the option that you wish to change styles or even easier is to use the unique front-end customization helper.', 'essb'), 'fa21 ti-ruler-pencil', 'glow');
	}
	
	ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, $panel_title, __('Activating this option will allow you to make full personalization of displayed buttons.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => $location.'_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb'), 'switch_submit' => 'true'));


	if (essb_option_bool_value($location.'_activate')) {

		if ($location != 'postbar' && $location != 'point') {
			// Position Style Settings version 5
			ESSBOptionsStructureHelper::structure_row_start($tab_id, $menu_id);
			ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c4');
			
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Template', 'essb'), '', 'inner-row');
			ESSBOptionsStructureHelper::field_template_select($tab_id, $menu_id, $location.'_template', $location);
			
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Buttons style', 'essb'), '', 'inner-row');
			ESSBOptionsStructureHelper::field_buttonstyle_select($tab_id, $menu_id, $location.'_button_style', $location);

			//essb5_main_alignment_choose
			$select_values = array('' => array('title' => 'Left', 'content' => '<i class="ti-align-left"></i>'),
					'center' => array('title' => 'Center', 'content' => '<i class="ti-align-center"></i>'),
					'right' => array('title' => 'Right', 'content' => '<i class="ti-align-right"></i>'));
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Buttons align', 'essb'), '', 'inner-row');
			ESSBOptionsStructureHelper::field_toggle($tab_id, $menu_id, $location.'_button_pos', '', '', $select_values);
				
			
			ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_nospace', __('Without space between buttons', 'essb'), __('Activate this option if you wish to connect share buttons without any space between them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
			//essb5_main_animation_selection
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Animate share buttons', 'essb'), '', 'inner-row');
			ESSBOptionsStructureHelper::field_animation_select($tab_id, $menu_id, $location.'_css_animations', $location);
			
			
			ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
			ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c4');
			
			ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, $location.'_show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
			//essb5_main_singlecounter_selection
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Single button share counter position', 'essb'), '', 'inner-row');
			ESSBOptionsStructureHelper::field_counterposition_select($tab_id, $menu_id, $location.'_counter_pos', $location);
			
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Total share counter position', 'essb'), '', 'inner-row');
			ESSBOptionsStructureHelper::field_totalcounterposition_select($tab_id, $menu_id, $location.'_total_counter_pos', $location);
			
			//essb5_main_totalcoutner_selection
			
			ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
			ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c4');
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Button width', 'essb'), '', 'inner-row');
			
			$select_values = array('' => array('title' => 'Automatic Width', 'content' => 'AUTO', 'isText'=>true),
					'fixed' => array('title' => 'Fixed Width', 'content' => 'Fixed', 'isText'=>true),
					'full' => array('title' => 'Full Width', 'content' => 'Full', 'isText'=>true),
					'flex' => array('title' => 'Fluid', 'content' => 'Fluid', 'isText'=>true),
					'column' => array('title' => 'Columns', 'content' => 'Columns', 'isText'=>true),);
			ESSBOptionsStructureHelper::field_toggle($tab_id, $menu_id, $location.'_button_width', '', '', $select_values);
			
			
			ESSBOptionsStructureHelper::holder_start($tab_id, $menu_id, $location.'-essb-fixed-width essb-hidden-open', $location.'-essb-fixed-width');
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize fixed width display', 'essb'), __('In fixed width mode buttons will have exactly same width defined by you no matter of device or screen resolution (not responsive).', 'essb'), 'inner-row');
			ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, '', __('Customize the fixed width options', 'essb'));
			ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fixed_width_value', __('Custom buttons width', 'essb'), __('Provide custom width of button in pixels without the px symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
			ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fixed_width_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name, when fixed button width is activated. When counter position is Inside or Inside name, that alignment will be applied for the counter. Default value is center.', 'essb'), array("" => "Center", "left" => "Left", "right" => "Right"));
			ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
			ESSBOptionsStructureHelper::holder_end($tab_id, $menu_id);
			
			ESSBOptionsStructureHelper::holder_start($tab_id, $menu_id, $location.'-essb-full-width essb-hidden-open', $location.'-essb-full-width');
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize full width display', 'essb'), __('In full width mode buttons will distribute over the entire screen width on each device (responsive).', 'essb'), 'inner-row');
			ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fullwidth_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("left" => "Left", "center" => "Center", "right" => "Right"));
			ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, __('Customize width of first two buttons', 'essb'), __('Provide different width for the first two buttons in the row. The width should be entered as number in percents (without the % mark). You can fill only one of the values or both values.', 'essb'), '', 'true');
			ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_first_button', __('Width of first button', 'essb'), __('Provide custom width of first button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
			ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_second_button', __('Width of second button', 'essb'), __('Provide custom width of second button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
			ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
			
			ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('Fix button apperance', 'essb'), __('Full width share buttons uses formula to calculate the best width of buttons. In some cases based on other site styles you may need to personalize some of the values in here', 'essb'), '', array("mode" => "toggle", 'state' => 'closed'));
			ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, '', __('Full width option will make buttons to take the width of your post content area.', 'essb'));
			ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_correction', __('Max width of button on desktop', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
			ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_correction_mobile', __('Max width of button on mobile', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
			ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_container', __('Max width of buttons container element', 'essb'), __('If you wish to display total counter along with full width share buttons please provide custom max width of buttons container in percent without % (example: 90). Leave this field blank for default value of 100 (100%).', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
			ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
			ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
			ESSBOptionsStructureHelper::holder_end($tab_id, $menu_id);
			
			ESSBOptionsStructureHelper::holder_start($tab_id, $menu_id, $location.'-essb-column-width essb-hidden-open', $location.'-essb-column-width');
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize column display', 'essb'), __('In column mode buttons will distribute over the entire screen width on each device in the number of columns you setup (responsive).', 'essb'), 'inner-row');
			ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, '', '');
			$listOfOptions = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10");			
			ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_columns', __('Number of columns', 'essb'), __('Choose the number of columns that buttons will be displayed.', 'essb'), $listOfOptions);
			ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, $location.'_fullwidth_share_buttons_columns_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("" => "Left", "center" => "Center", "right" => "Right"));
			ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
			ESSBOptionsStructureHelper::holder_end($tab_id, $menu_id);
			
			
			
			ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
			ESSBOptionsStructureHelper::structure_row_end($tab_id, $menu_id);
				
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Live Style Preview', 'essb'), __('This style preview is illustrative showing how your buttons will look. All displayed share counters are random generated for preview purpose - real share values will appear on each post. Once you save settings you will be able to test the exact preview on site with networks you choose', 'essb'));				
			ESSBOptionsStructureHelper::field_func($tab_id, $menu_id, 'essb5_live_preview_single_position', '', '', '', array('position' => $location));
				


		}

		if ($location != 'mobile') {
			ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading5', __('Personalize social networks', 'essb'));
			ESSBOptionsStructureHelper::tabs_start($tab_id, $menu_id, $location.'buttons-tabs', array('<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Social Networks', 'essb'), '<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Additional Network Options', 'essb')), 'false', 'true');
			ESSBOptionsStructureHelper::tab_start($tab_id, $menu_id, $location.'buttons-tabs-0', 'true');
				
			ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Personalize Displayed Social Networks', 'essb'), __('Choose a personalized list of social networks that will run for this display only (different than global set). Leave blank to use the global set list of social networks', 'essb'));
			ESSBOptionsStructureHelper::field_network_select($tab_id, $menu_id, $location.'_networks', $location);
				
			ESSBOptionsStructureHelper::tab_end($tab_id, $menu_id);
			
			ESSBOptionsStructureHelper::tab_start($tab_id, $menu_id, $location.'buttons-tabs-1');
				
			ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('More Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_more', array("mode" => "toggle", 'state' => 'opened'));
			$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up", "4" => "Display all active networks after more button in popup" );
			ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_more_button_func', __('More button', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands());
			$more_options = array ("plus" => "Plus icon", "dots" => "Dots icon" );
			
			$select_values = array('plus' => array('title' => 'Plus Icon', 'content' => '<i class="essb_icon_more"></i>'),
					'dots' => array('title' => 'Dots Icon', 'content' => '<i class="essb_icon_more_dots"></i>'));
			ESSBOptionsStructureHelper::field_toggle($tab_id, $menu_id, $location.'_more_button_icon', __('More button icon', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $select_values);
			
			
			ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
			
			ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('Share Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_share', array("mode" => "toggle", 'state' => 'opened'));
			$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up", "4" => "Display all active networks after more button in popup" );
			ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_share_button_func', __('Share button function', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands());
			
			
			$select_values = array('plus' => array('title' => '', 'content' => '<i class="essb_icon_more"></i>'),
					'dots' => array('title' => '', 'content' => '<i class="essb_icon_more_dots"></i>'),
					'share' => array('title' => '', 'content' => '<i class="essb_icon_share"></i>'),
					'share-alt-square' => array('title' => '', 'content' => '<i class="essb_icon_share-alt-square"></i>'),
					'share-alt' => array('title' => '', 'content' => '<i class="essb_icon_share-alt"></i>'),
					'share-tiny' => array('title' => '', 'content' => '<i class="essb_icon_share-tiny"></i>'),
					'share-outline' => array('title' => '', 'content' => '<i class="essb_icon_share-outline"></i>')
			);
			ESSBOptionsStructureHelper::field_toggle($tab_id, $menu_id, $location.'_share_button_icon', __('Share button icon', 'essb'), __('Choose the share button icon you will use (default is share if nothing is selected)', 'essb'), $select_values);
			
			
			$more_options = array ("" => "Default from settings (like other share buttons)", "icon" => "Icon only", "button" => "Button", "text" => "Text only" );
			ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_share_button_style', __('Share button style', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $more_options);
			
			$share_counter_pos = array("hidden" => "No counter", "inside" => "Inside button without text", "insidename" => "Inside button after text", "insidebeforename" => "Inside button before text", "topn" => "Top", "bottom" => "Bottom");
			ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $location.'_share_button_counter', __('Display total counter with the following position', 'essb'), __('Choose where you wish to display total counter of shares assigned with this button. <br/> To view total counter you need to have share counters active and they should not be running in real time mode. Also you need to have your share button set with style button. When you use share button with counter we highly recommend to hide total counter by setting position to be hidden - this will avoid having two set of total value on screen.', 'essb'), $share_counter_pos);
			
			ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
				
			ESSBOptionsStructureHelper::tab_end($tab_id, $menu_id);
			ESSBOptionsStructureHelper::tabs_end($tab_id, $menu_id);
				

		}
	}
	ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id); // customization

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
	
	// Replace default network selection with the personalized component of network selection
	//ESSBOptionsStructureHelper::field_checkbox_list_sortable($tab_id, $menu_id, $location.'_networks', __('Change active social networks', 'essb'), __('Do not select anything if you wish to use default network list'. 'essb'), $checkbox_list_networks, '', 'networks');
	ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Personalize Displayed Social Networks', 'essb'), __('Choose a personalized list of social networks that will run for this display only (different than global set). Leave blank to use the global set list of social networks', 'essb'));
	ESSBOptionsStructureHelper::field_network_select($tab_id, $menu_id, $location.'_networks', $location);
	ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);

	//ESSBOptionsStructureHelper::field_section_start($tab_id, $menu_id, __('Rename displayed texts for network names', 'essb'), __('Set texts that will appear on selected display method instead of default network names. Use dash (-) if you wish to remove text for that network name.', 'essb'));

	//foreach ($checkbox_list_networks as $key => $text) {
	//	ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, $location.'_'.$key.'_name', $text, '');
	//}
	/*ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('Customize text of social network over button', 'essb'), __('Set texts that will appear on selected display method instead of default network names. Use dash (-) if you wish to remove text for that network name.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => $location.'_name_change', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

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
	*/

	//ESSBOptionsStructureHelper::field_section_end($tab_id, $menu_id);

}


function essb3_register_positions_by_posttypes() {
	global $wp_post_types, $where_to_display;
	$where_to_display = 'where';
	ESSBOptionsStructureHelper::panel_start($where_to_display, 'positions', __('I wish to have different button position for different post types', 'essb'), __('Activate this option if you wish to setup different positions for each post type.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'positions_by_pt', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );
	$first_post_type = "";
	$key = 1;
	foreach ( $pts as $pt ) {

		ESSBOptionsStructureHelper::field_heading($where_to_display, 'positions', 'heading5', __('Customize button positions for: '.$wp_post_types [$pt]->label, 'essb'));
		ESSBOptionsStructureHelper::structure_row_start($where_to_display, 'positions');
		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'positions', 'c6', __('Primary content display position', 'essb'), __('Choose default in content position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_select($where_to_display, 'positions', 'content_position_'.$pt, '', '', essb_simplified_radio_check_list(essb_avaliable_content_positions(), true));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'positions');

		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'positions', 'c6', __('Additional button display positions', 'essb'), __('Choose additional site display position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_checkbox_list($where_to_display, 'positions', 'button_position_'.$pt, '', '', essb_simplified_radio_check_list(essb_available_button_positions()));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'positions');
		ESSBOptionsStructureHelper::structure_row_end($where_to_display, 'positions');
	}

	foreach ( $cpts as $cpt ) {

		ESSBOptionsStructureHelper::field_heading($where_to_display, 'positions', 'heading5', __('Customize button positions for: '.$wp_post_types [$cpt]->label, 'essb'));
		ESSBOptionsStructureHelper::structure_row_start($where_to_display, 'positions');
		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'positions', 'c6', __('Primary content display position', 'essb'), __('Choose default in content position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_select($where_to_display, 'positions', 'content_position_'.$cpt, '', '', essb_simplified_radio_check_list(essb_avaliable_content_positions(), true));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'positions');

		ESSBOptionsStructureHelper::structure_section_start($where_to_display, 'positions', 'c6', __('Additional button display positions', 'essb'), __('Choose additional site display position that will be used for that post type', 'essb'));
		ESSBOptionsStructureHelper::field_checkbox_list($where_to_display, 'positions', 'button_position_'.$cpt, '', '', essb_simplified_radio_check_list(essb_available_button_positions()));
		ESSBOptionsStructureHelper::structure_section_end($where_to_display, 'positions');
		ESSBOptionsStructureHelper::structure_row_end($where_to_display, 'positions');

	}

	ESSBOptionsStructureHelper::panel_end($where_to_display, 'positions');
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

function essb5_live_preview_single_position($options) {
	$element_options = isset($options['element_options']) ? $options['element_options'] : array();
	$position = isset($element_options['position']) ? $element_options['position'] : '';
	
	// if there is no position we cannot display live preview
	if ($position == '') { return; }
	
	$code = '<div class="essb-component-buttons-livepreview" data-settings="essb_'.$position.'_global_preview">';
	$code .= '</div>';
	
	$code .= "<script type=\"text/javascript\">
	
	var essb_".$position."_global_preview = {
	'networks': [ {'key': 'facebook', 'name': 'Facebook'}, {'key': 'twitter', 'name': 'Twitter'}, {'key': 'google', 'name': 'Google'}, {'key': 'pinterest', 'name': 'Pinterest'}, {'key': 'linkedin', 'name': 'LinkedIn'}],
	'template': 'essb_field_".$position."_template',
	'button_style': 'essb_field_".$position."_button_style',
	'align': 'essb_options_".$position."_button_pos',
	'nospace': 'essb_field_".$position."_nospace',
	'counter': 'essb_field_".$position."_show_counter',
	'counter_pos': 'essb_field_".$position."_counter_pos',
	'total_counter_pos': 'essb_field_".$position."_total_counter_pos',
	'width': 'essb_options_".$position."_button_width',
	'animation': 'essb_field_".$position."_css_animations',
	'fixed_width': 'essb_options_".$position."_fixed_width_value',
	'fixed_align': 'essb_options_".$position."_fixed_width_align',
	'columns_count': 'essb_options_".$position."_fullwidth_share_buttons_columns',
	'columns_align': 'essb_options_".$position."_fullwidth_share_buttons_columns_align',
	'full_button': 'essb_options_".$position."_fullwidth_share_buttons_correction',
	'full_align': 'essb_options_".$position."_fullwidth_align',
	'full_first': 'essb_options_".$position."_fullwidth_first_button',
	'full_second': 'essb_options_".$position."_fullwidth_second_button'
	};
	
	</script>";
	
	echo $code;
}