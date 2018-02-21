<?php
//---- quick setup wizard steps
ESSBOptionsStructureHelper::menu_item('quick', 'quick-1', __('1. Template', 'essb'), 'bolt');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-2', __('2. Button Style', 'essb'), 'bolt');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-3', __('3. Social Share Buttons', 'essb'), 'bolt');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-4', __('4. Counters', 'essb'), 'bolt');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-5', __('5. Display Buttons On', 'essb'), 'bolt');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-6', __('6. Position Of Buttons', 'essb'), 'bolt');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-7', __('7. Mobile', 'essb'), 'bolt');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-8', __('8. Final Settings', 'essb'), 'bolt');

//------- wizard menu
//ESSBOptionsStructureHelper::field_heading('quick', 'quick-1', 'heading1', __('1. Template', 'essb'));
ESSBOptionsStructureHelper::field_func('quick', 'quick-1', 'essb3_options_template_select', __('', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-1');

ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-1', 'c6', '', '');
ESSBOptionsStructureHelper::field_select('quick', 'quick-1', 'css_animations', __('Activate animations', 'essb'), __('Animations
		are provided with CSS transitions and work on best with retina
		templates.', 'essb'), essb_available_animations(), '', '6');
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-1');

ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-1', 'c6', '', '');
ESSBOptionsStructureHelper::field_switch('quick', 'quick-1', 'nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '9');
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-1');

ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-1');


ESSBOptionsStructureHelper::hint('quick', 'quick-2', __('Choose your default button styles', 'essb'), __('Default button style and width will be used if you did not make any customizations for position, post type or via shortcode. The previews below are rendered based on last saved template in settings (if you change the template but did not save options do it now to see how buttons will look with it).', 'essb'), 'fa32 ti-palette');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-2', __('Button presentation style', 'essb'), __('Choose general button placement and presentation styles that will be used as default if no customization is made', 'essb'), 'fa21 ti-layout-grid2-alt', array("mode" => "toggle"));
ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-2');

ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-2', 'c12', __('Buttons display style', 'essb'), __('Select your default button style', 'essb'));

$essb_available_buttons_style = array();
$essb_available_buttons_style ['button'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Display as share button with icon and network name</b>" );
$essb_available_buttons_style ['button_name'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button_name" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Display as share button with network name and without icon</b>" );
$essb_available_buttons_style ['icon'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="icon" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Display share buttons only as icon without network names</b>" );
$essb_available_buttons_style ['icon_hover'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="icon_hover" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Display share buttons as icon with network name appear when button is pointed</b>" );

ESSBOptionsStructureHelper::field_html_radio('quick', 'quick-2', 'button_style', '', __('Select your default button style', 'essb'), $essb_available_buttons_style, '', 'true', '300px');

ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-2');
ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-2');
ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-2');

ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-2', 'c12', __('Buttons align', 'essb'), __('Choose how buttons
		to be aligned. Default position is left but you can also select
		Right or Center', 'essb'));
$essb_available_buttons_align = array();
$essb_available_buttons_align [''] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Left</b>" );
$essb_available_buttons_align ['center'] = array ("image" => '<div style="text-align: center;">[easy-social-share buttons="facebook,twitter" counters=0 align="center" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]</div>', "label" => "<b>Center</b>" );
$essb_available_buttons_align ['right'] = array ("image" => '<div style="text-align: right;">[easy-social-share buttons="facebook,twitter" counters=0 align="right" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]</div>', "label" => "<b>Right</b>" );

ESSBOptionsStructureHelper::field_html_radio('quick', 'quick-2', 'button_pos', __('', 'essb'), __('Choose how buttons
		to be aligned. Default position is left but you can also select
		Right or Center', 'essb'), $essb_available_buttons_align, '', 'true', '300px');



ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-2');

ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-2');

ESSBOptionsStructureHelper::panel_end('quick', 'quick-2');

ESSBOptionsStructureHelper::panel_start('quick', 'quick-2', __('Width of share buttons', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), 'fa21 ti-layout-slider', array("mode" => "toggle"));

$essb_available_buttons_width = array();
$essb_available_buttons_width [''] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Automatic width</b> each button will have required to render width" );
$essb_available_buttons_width ['fixed'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="no" fixedwidth="yes" fixedwidth_px="100" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Fixed width - all buttons will have provided by you width in pixels</b>" );
$essb_available_buttons_width ['full'] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=0 align="left" style="button" fullwidth="yes" fixedwidth="no" column="no" facebook_text="Facebook" twitter_text="Twitter" flex="no" autowidth="yes"]', "label" => "<b>Full width - buttons will automatically stretch to fit width of content area</b>" );
$essb_available_buttons_width ['column'] = array ("image" => '[easy-social-share buttons="facebook,twitter,google,pinterest" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="yes" columns="2" facebook_text="Facebook" twitter_text="Twitter" google_text="Google" pinterest_text="Pinterest" flex="no" autowidth="yes"]', "label" => "<b>Display in columns - display in selected number of columns</b>" );
$essb_available_buttons_width ['flex'] = array ("image" => '[easy-social-share buttons="facebook,twitter,google" counters=0 align="left" style="button" fullwidth="no" fixedwidth="no" column="no" columns="2" facebook_text="Facebook" flex="yes" twitter_text="Twitter" google_text="Google"]', "label" => "<b>Flexible width - buttons will have automated width to take full content area</b>" );
ESSBOptionsStructureHelper::field_html_radio('quick', 'quick-2', 'button_width', __('', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), $essb_available_buttons_width, '', 'true', '400px');



ESSBOptionsStructureHelper::field_heading('quick', 'quick-2', 'heading5', __('Personalize settings for each width style that you can use for buttons', 'essb'));

ESSBOptionsStructureHelper::tabs_start('quick', 'quick-2', 'width-tabs', array("Fixed width sharing buttons", "Full width sharing buttons", "Display in columns"));
ESSBOptionsStructureHelper::tab_start('quick', 'quick-2', 'width-tabs-0', 'true');
ESSBOptionsStructureHelper::field_section_start_panels('quick', 'quick-2', '', __('Customize the fixed width options', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-2', 'fixed_width_value', __('Custom buttons width', 'essb'), __('Provide custom width of button in pixels without the px symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_select_panel('quick', 'quick-2', 'fixed_width_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name, when fixed button width is activated. When counter position is Inside or Inside name, that alignment will be applied for the counter. Default value is center.', 'essb'), array("" => "Center", "left" => "Left", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('quick', 'quick-2');
ESSBOptionsStructureHelper::tab_end('quick', 'quick-2');

ESSBOptionsStructureHelper::tab_start('quick', 'quick-2', 'width-tabs-1');
ESSBOptionsStructureHelper::field_section_start_panels('quick', 'quick-2', '', __('Full width option will make buttons to take the width of your post content area.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-2', 'fullwidth_share_buttons_correction', __('Max width of button on desktop', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-2', 'fullwidth_share_buttons_correction_mobile', __('Max width of button on mobile', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-2', 'fullwidth_share_buttons_container', __('Max width of buttons container element', 'essb'), __('If you wish to display total counter along with full width share buttons please provide custom max width of buttons container in percent without % (example: 90). Leave this field blank for default value of 100 (100%).', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_select_panel('quick', 'quick-2', 'fullwidth_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("left" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('quick', 'quick-2');
ESSBOptionsStructureHelper::field_section_start_panels('quick', 'quick-2', __('Customize width of first two buttons', 'essb'), __('Provide different width for the first two buttons in the row. The width should be entered as number in percents (without the % mark). You can fill only one of the values or both values.', 'essb'), '', 'true');
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-2', 'fullwidth_first_button', __('Width of first button', 'essb'), __('Provide custom width of first button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-2', 'fullwidth_second_button', __('Width of second button', 'essb'), __('Provide custom width of second button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_section_end_panels('quick', 'quick-2');
ESSBOptionsStructureHelper::tab_end('quick', 'quick-2');

ESSBOptionsStructureHelper::tab_start('quick', 'quick-2', 'width-tabs-2');
ESSBOptionsStructureHelper::field_section_start_panels('quick', 'quick-2', '', '');
$listOfOptions = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5");
ESSBOptionsStructureHelper::field_select_panel('quick', 'quick-2', 'fullwidth_share_buttons_columns', __('Number of columns', 'essb'), __('Choose the number of columns that buttons will be displayed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_select_panel('quick', 'quick-2', 'fullwidth_share_buttons_columns_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('quick', 'quick-2');
ESSBOptionsStructureHelper::tab_end('quick', 'quick-2');

ESSBOptionsStructureHelper::tabs_end('quick', 'quick-2');

ESSBOptionsStructureHelper::panel_end('quick', 'quick-2');


ESSBOptionsStructureHelper::field_func('quick', 'quick-3', 'essb3_network_selection', __('', 'essb'), __('', 'essb'));
$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up" );
ESSBOptionsStructureHelper::field_select('quick', 'quick-3', 'more_button_func', __('More button', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), $more_options);
$more_options = array ("plus" => "Plus icon", "dots" => "Dots icon" );
ESSBOptionsStructureHelper::field_select('quick', 'quick-3', 'more_button_icon', __('More button icon', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $more_options);

ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-4');
ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-4', 'c4');

ESSBOptionsStructureHelper::field_switch('quick', 'quick-4', 'show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-4');

ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-4', 'c8');
ESSBOptionsStructureHelper::field_select('quick', 'quick-4', 'counter_mode', __('Counter update mode', 'essb'), __('Choose how your counters will update. Real time share counter will update on each page load and on high traffic sites they can produce extreme load over admin-ajax WordPress component. Cached counters will update once on chosen interval (if you use cache plugin and they do not update frequently you can activate in advanced options cache compatible update mode).', 'essb'), essb_cached_counters_update(), '', '8');

ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-4');
ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-4');

ESSBOptionsStructureHelper::field_heading('quick', 'quick-4', 'heading5', __('Button Counters', 'essb'));
//ESSBOptionsStructureHelper::field_select('quick', 'quick-4', 'counter_pos', __('Position of counters', 'essb'), __('Choose your default button counter position', 'essb'), essb_avaliable_counter_positions());

$current_counter_positions = essb_avaliable_counter_positions();
$mixed_radio = array();
foreach ($current_counter_positions as $key => $text) {
	$mixed_radio [$key] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=1 demo_counter="yes" counter_pos="'.$key.'" total_counter_pos="hidden" align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Share" twitter_text="Tweet" flex="no" autowidth="yes"]', "label" => "<b>".$text."</b>" );	
}
ESSBOptionsStructureHelper::field_html_radio('quick', 'quick-4', 'counter_pos', __('', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), $mixed_radio, '', 'true', '300px');


ESSBOptionsStructureHelper::field_heading('quick', 'quick-4', 'heading5', __('Total Counter', 'essb'));

$current_counter_positions = essb_avaiable_total_counter_position();
$mixed_radio = array();
foreach ($current_counter_positions as $key => $text) {
	if ($key != 'hidden') {
		$mixed_radio [$key] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=1 demo_counter="yes" total_counter_pos="'.$key.'" counter_pos="hidden" align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Share" twitter_text="Tweet" flex="no" autowidth="yes"]', "label" => "<b>".$text."</b>" );
	}
	else {
		$mixed_radio [$key] = array ("image" => '[easy-social-share buttons="facebook,twitter" counters=1 demo_counter="yes" total_counter_pos="'.$key.'" counter_pos="insidename" align="left" style="button" fullwidth="no" fixedwidth="no" column="no" facebook_text="Share" twitter_text="Tweet" flex="no" autowidth="yes"]', "label" => "<b>".$text."</b>" );
	}
}
ESSBOptionsStructureHelper::field_html_radio('quick', 'quick-4', 'total_counter_pos', __('', 'essb'), __('Choose between automatic width, pre defined width or display in columns.', 'essb'), $mixed_radio, '', 'true', '300px');

ESSBOptionsStructureHelper::panel_start('quick', 'quick-4', __('Additional total counter settings', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-4');
ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-4', 'c6');
ESSBOptionsStructureHelper::field_textbox('quick', 'quick-4', 'counter_total_text', __('Change total text', 'essb'), __('This option allows you to change text Total that appear when left/right position of total counter is selected.', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-4');

ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-4', 'c6');
ESSBOptionsStructureHelper::field_textbox('quick', 'quick-4', 'activate_total_counter_text', __('Append text to total counter when big number styles are active', 'essb'), __('This option allows you to add custom text below counter when big number styles are active. For example you can add text shares.', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-4');
ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-4');

ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-4');
ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-4', 'c6');
ESSBOptionsStructureHelper::field_textbox('quick', 'quick-4', 'total_counter_afterbefore_text', __('Change total counter text when before/after styles are active', 'essb'), __('Customize the text that is displayed in before/after share buttons display method. To display the total share number use the string {TOTAL} in text. Example: {TOTAL} users share us', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-4');
ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-4', 'c6');
$essb_available_buttons_width = array();
$essb_available_buttons_width ['share'] = array ("image" => '<div class="fa21 essb_icon_share"></div>', "label" => "" );
$essb_available_buttons_width ['share-alt-square'] = array ("image" => '<div class="fa21 essb_icon_share-alt-square"></div>', "label" => "" );
$essb_available_buttons_width ['share-alt'] = array ("image" => '<div class="fa21 essb_icon_share-alt"></div>', "label" => "" );
$essb_available_buttons_width ['share-tiny'] = array ("image" => '<div class="fa21 essb_icon_share-tiny"></div>', "label" => "" );
$essb_available_buttons_width ['share-outline'] = array ("image" => '<div class="fa21 essb_icon_share-outline"></div>', "label" => "" );
ESSBOptionsStructureHelper::field_html_radio_buttons('quick', 'quick-4', 'activate_total_counter_icon', __('Total counter icon', 'essb'), __('Options is applied when total counter with icon is selected', 'essb'), $essb_available_buttons_width, '', '', '26px');

ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-4');
ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-4');
ESSBOptionsStructureHelper::panel_end('quick', 'quick-4');

ESSBOptionsStructureHelper::field_heading('quick', 'quick-4', 'heading5', __('Advanced counter settings', 'essb'));
ESSBOptionsStructureHelper::panel_start('quick', 'quick-4', __('Avoid social negative proof', 'essb'), __('Avoid social negative proof allows you to hide button counters or total counter till a defined value of shares is reached', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'social_proof_enable', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_textbox('quick', 'quick-4', 'button_counter_hidden_till', __('Display button counter after this value of shares is reached', 'essb'), __('You can hide your button counter until amount of shares is reached. This option is active only when you enter value in this field - if blank button counter is always displayed. (Example: 10 - this will make button counter appear when at least 10 shares are made).', 'essb'));
ESSBOptionsStructureHelper::field_textbox('quick', 'quick-4', 'total_counter_hidden_till', __('Display total counter after this value of shares is reached', 'essb'), __('You can hide your total counter until amount of shares is reached. This option is active only when you enter value in this field - if blank total counter is always displayed.', 'essb'));
ESSBOptionsStructureHelper::panel_end('quick', 'quick-4');

ESSBOptionsStructureHelper::field_heading('quick', 'quick-5', 'heading5', __('Choose post types to display buttons', 'essb'));
ESSBOptionsStructureHelper::field_func('quick', 'quick-5', 'essb3_post_type_select', __('Where to display buttons', 'essb'), __('Choose post types where you wish buttons to appear. If you are running WooCommerce store you can choose between post type Products which will display share buttons into product description or option to display buttons below price.', 'essb'));
ESSBOptionsStructureHelper::panel_start('quick', 'quick-5', __('Display in post excerpt', 'essb'), __('Activate this option if your theme is using excerpts and you wish to display share buttons in excerpts', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'display_excerpt', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
$listOfOptions = array("top" => "Before excerpt", "bottom" => "After excerpt");
ESSBOptionsStructureHelper::field_select('quick', 'quick-5', 'display_excerpt_pos', __('Buttons position in excerpt', 'essb'), __(''), $listOfOptions);
ESSBOptionsStructureHelper::panel_end('quick', 'quick-5');


ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-6');
ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-6', 'c12', __('Primary content display position', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'));
ESSBOptionsStructureHelper::field_image_radio('quick', 'quick-6', 'content_position', '', '', essb_avaliable_content_positions());
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-6');
ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-6');

ESSBOptionsStructureHelper::structure_row_start('quick', 'quick-6');
ESSBOptionsStructureHelper::structure_section_start('quick', 'quick-6', 'c12', __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'));
ESSBOptionsStructureHelper::field_image_checkbox('quick', 'quick-6', 'button_position', '', '', essb_available_button_positions());
ESSBOptionsStructureHelper::structure_section_end('quick', 'quick-6');
ESSBOptionsStructureHelper::structure_row_end('quick', 'quick-6');

ESSBOptionsStructureHelper::field_switch('quick', 'quick-7', 'mobile_positions', __('Change display positions on mobile', 'essb'), __('Activate this option to personalize display positions on mobile', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::title('quick', 'quick-7', __('Primary in content display positions', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_image_radio('quick', 'quick-7', 'content_position_mobile', '', '', essb_avaliable_content_positions_mobile());
ESSBOptionsStructureHelper::title('quick', 'quick-7', __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_image_checkbox('quick', 'quick-7', 'button_position_mobile', '', '', essb_available_button_positions_mobile());

global $essb_networks;
$checkbox_list_networks = array();
foreach ($essb_networks as $key => $object) {
	$checkbox_list_networks[$key] = $object['name'];
}
ESSBOptionsStructureHelper::field_checkbox_list_sortable('quick', 'quick-7', 'mobile_networks', __('Change active social networks', 'essb'), __('Do not select anything if you wish to use default network list'. 'essb'), $checkbox_list_networks);


ESSBOptionsStructureHelper::field_switch('quick', 'quick-7', 'mobile_exclude_tablet', __('Do not apply mobile settings for tablets', 'essb'), __('You can avoid mobile rules for settings for tablet devices.', 'essb'), 'recommeded', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_start('quick', 'quick-7', __('Share bar customization', 'essb'), '');
ESSBOptionsStructureHelper::field_textbox('quick', 'quick-7', 'mobile_sharebar_text', __('Text on share bar', 'essb'), __('Customize the default share bar text (default is Share).', 'essb'));
ESSBOptionsStructureHelper::field_section_end('quick', 'quick-7');
ESSBOptionsStructureHelper::field_section_start('quick', 'quick-7', __('Share buttons bar customization', 'essb'), '');
$listOfOptions = array("2" => "2 Buttons", "3" => "3 Buttons", "4" => "4 Buttons", "5" => "5 Buttons");
ESSBOptionsStructureHelper::field_select('quick', 'quick-7', 'mobile_sharebuttonsbar_count', __('Number of buttons in share buttons bar', 'essb'), __('Provide number of buttons you wish to see in buttons bar. If the number of activated buttons is greater than selected here the last button will be more button which will open pop up with all active buttons.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch('quick', 'quick-7', 'mobile_sharebuttonsbar_names', __('Display network names', 'essb'), __('Activate this option to display network names (default is display is icons only).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('quick', 'quick-7');

ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'quick_setup_recommended', __('Apply social networks recommended settings', 'essb'), __('Activate this option to activate recommended for each social network options (like Short URL for Twitter)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'opengraph_tags', __('Activate social share optimization meta tags', 'essb'), __('If you do not use SEO plugin or other plugin that insert social share optimization meta tags it is highly recommended to activate this option. It will generated required for better sharing meta tags and also will allow you to change the values that social network read from your site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'stats_active', __('Activate social share buttons click statistics', 'essb'), __('Click statistics hanlde click on share buttons and you are able to see detailed view of user activity. Please note that plugin log clicks of buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::hint('quick', 'quick-8', '', __('Use optimization options below if you do not use cache plugin or optimization plugin on your site. If you use such you can activate them but in case you see unexpected visual output please visit Advanced Settings -> Optimization options and turn them off', 'essb'));
ESSBOptionsStructureHelper::field_section_start('quick', 'quick-8', __('Optimizations', 'essb'), __('Select which optimization options you wish to use. If you use cache plugin or CDN on your site than those optimizations are already made. In this case we suggest to avoid activating these options.', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'quick_setup_static', __('Optimize static plugin resources load', 'essb'), __('Activate this option to apply the recommended options for static resources load.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'precompiled_resources', __('Use plugin precompiled resources', 'essb'), __('Activating this option will precompile and cache plugin dynamic resources to save load time. Precompiled resources can be used only when you use same configuration on your entire site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_section_end('quick', 'quick-8');

?>