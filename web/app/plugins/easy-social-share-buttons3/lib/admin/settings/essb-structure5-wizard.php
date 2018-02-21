<?php
//---- quick setup wizard steps
ESSBOptionsStructureHelper::menu_item('quick', 'quick-1', __('1. Mode', 'essb'), ' ti-wand');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-2', __('2. Networks', 'essb'), ' ti-sharethis');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-3', __('3. Style', 'essb'), ' ti-palette');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-4', __('4. Appear at', 'essb'), ' ti-layout');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-5', __('5. Mobile', 'essb'), ' ti-mobile');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-6', __('6. Subscribe', 'essb'), ' ti-email');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-7', __('7. Follow', 'essb'), ' ti-heart');
ESSBOptionsStructureHelper::menu_item('quick', 'quick-8', __('8. Final', 'essb'), 'bolt');

ESSBOptionsStructureHelper::field_heading('quick', 'quick-1', 'heading1', __('Plugin Functions', 'essb'));
ESSBOptionsStructureHelper::hint('quick', 'quick-1', '', __('Easy Social Share Buttons for WordPress is all-in-one social media plugin for WordPress packed with lot of options. In case you do not plan to use all of them it is easy to deactivate (or activate back) functions you do not need. To do this use one of preset operation modes or set on custom and remove functions you do not use.', 'essb'));

ESSBOptionsStructureHelper::title('quick', 'quick-1', __('Share buttons on mobile devices', 'essb'), __('Easy Social Share Buttons for WordPress has advanced mobile display options to get a fully personalized mobile appearance. If you do not wish to do this by yourself you can set automatic configuration and plugin will do the job for you.', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_func('quick', 'quick-1', 'essb5_functions_mode_choose_mobile_quick', '', '');

ESSBOptionsStructureHelper::title('quick', 'quick-1', __('Plugin Mode', 'essb'), __('Using selector you can choose which components of plugin you will use. Anytime later you can change teh selection using Plugin Functions menu. If you are not sure which mode to select, please check the table below', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_func('quick', 'quick-1', 'essb5_functions_mode_choose_quick', '', '');


function essb5_functions_mode_choose_quick() {
	$value = essb_option_value('functions_mode');

	$select_values = array('' => array('title' => 'Customized setup of used modules', 'content' => '<i class="ti-panel" style="margin-right: 5px;"></i> <span class="title">Custom</span>', 'isText'=>true),
			'light' => array('title' => 'Light sharing with only most popular share functions', 'content' => '<i class="ti-star" style="margin-right: 5px;"></i><span class="title">Lite Share Buttons</span>', 'isText'=>true),
			'medium' => array('title' => 'Extended share functionality', 'content' => '<i class="ti-sharethis-alt" style="margin-right: 5px;"></i> <span class="title">Medium Sharing & Subscribe</span>', 'isText'=>true),
			'advanced' => array('title' => 'Power social sharing', 'content' => '<i class="ti-new-window" style="margin-right: 5px;"></i><span class="title">Advanced Sharing & Subscribe</span>', 'isText'=>true),
			'sharefollow' => array('title' => 'All the best to share your content and grow your followers', 'content' => '<i class="ti-heart" style="margin-right: 5px;"></i><span class="title">Sharing, Subscribe & Following</span>', 'isText'=>true),
			'full' => array('title' => 'All plugin functions', 'content' => '<i class="ti-package" style="margin-right: 5px;"></i><span class="title">Everything</span>', 'isText'=>true));
		
	essb_component_options_group_select('functions_mode', $select_values, '', $value);
	
	include_once(ESSB3_PLUGIN_ROOT.'lib/admin/helpers/mode-information.php');
	
	echo '<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".essb-button-openmodes").hide();
		$(".essb-feature-mode").removeClass("closed");
	});
	</script>
	';
}

function essb5_functions_mode_choose_mobile_quick() {
	$value = essb_option_value('functions_mode_mobile');

	$select_values = array('' => array('title' => 'Manual Setup', 'content' => '<i class="ti-panel" style="margin-right: 5px;"></i> <span class="title">Manual Setup</span><span class="desc">Allows full control over share buttons on mobile device</span>', 'isText'=>true),
			'auto' => array('title' => 'Plugin will automatically setup share buttons', 'content' => '<i class="ti-star" style="margin-right: 5px;"></i><span class="title">Automatic Setup</span><span class="desc">Plugin will automatically setup share buttons for mobile</span>', 'isText'=>true),
			'deactivate' => array('title' => 'Deactivate mobile settings and do not show buttons on mobile devices', 'content' => '<i class="ti-close" style="margin-right: 5px;"></i><span class="title">Deactivate on Mobile</span><span class="desc">Plugin will not show buttons on mobile devices</span>', 'isText'=>true));
	
	essb_component_options_group_select('functions_mode_mobile', $select_values, '', $value);
}

//------- wizard menu
ESSBOptionsStructureHelper::field_heading('quick', 'quick-2', 'heading1', __('Social Networks', 'essb'));
ESSBOptionsStructureHelper::hint('quick', 'quick-2', '', __('Choose primary list of social networks you will use on your site. That list you can change later inside plugin settings. You can also setup different social networks of each plugin location.<br/><br/>More isn\'t always better! The fewer networks you use on your site can lead to more actions. It is called the paradox of choice. We recommend to select for usage only networks that you wish to be shared instead of all or combine additional networks after more button and leave on screen only those that are really important for you.', 'essb'));
ESSBOptionsStructureHelper::field_network_select('quick', 'quick-2', 'networks', '');
ESSBOptionsStructureHelper::field_switch('quick', 'quick-2', 'wizard_networks_all', __('Set selected social networks everywhere', 'essb'), __('Plugin support different setup configuration for each plugin location. Use this option to apply selected social networks on all plugin locations and overwrite selection if such was made. This option will not change mobile selected social networks!', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '10');

ESSBOptionsStructureHelper::field_heading('quick', 'quick-3', 'heading1', __('Buttons Style', 'essb'));
ESSBOptionsStructureHelper::hint('quick', 'quick-3', '', __('Choose how your share buttons will look on site. Those styles will appear inside global settings. If you have position based setup or ready made styles applied they will not be overwritten by the wizard.', 'essb'));

$tab_id = 'quick';
$menu_id = 'quick-3';
$location = '';

ESSBOptionsStructureHelper::structure_row_start($tab_id, $menu_id);
ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c4');
	
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Template', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_template_select($tab_id, $menu_id, 'style', '');
	
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Buttons style', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_buttonstyle_select($tab_id, $menu_id, 'button_style', '');

//essb5_main_alignment_choose
$select_values = array('' => array('title' => 'Left', 'content' => '<i class="ti-align-left"></i>'),
		'center' => array('title' => 'Center', 'content' => '<i class="ti-align-center"></i>'),
		'right' => array('title' => 'Right', 'content' => '<i class="ti-align-right"></i>'));
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Buttons align', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_toggle($tab_id, $menu_id, 'button_pos', '', '', $select_values);

	
ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, 'nospace', __('Without space between buttons', 'essb'), __('Activate this option if you wish to connect share buttons without any space between them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
//essb5_main_animation_selection
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Animate share buttons', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_animation_select($tab_id, $menu_id, 'css_animations', $location);
	
	
ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c4');
	
ESSBOptionsStructureHelper::field_switch($tab_id, $menu_id, 'show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
//essb5_main_singlecounter_selection
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Single button share counter position', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_counterposition_select($tab_id, $menu_id, 'counter_pos', $location);
	
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Total share counter position', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_totalcounterposition_select($tab_id, $menu_id, 'total_counter_pos', $location);
	
//essb5_main_totalcoutner_selection
	
ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
ESSBOptionsStructureHelper::structure_section_start($tab_id, $menu_id, 'c4');
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Button width', 'essb'), '', 'inner-row');
	
$select_values = array('' => array('title' => 'Automatic Width', 'content' => 'AUTO', 'isText'=>true),
		'fixed' => array('title' => 'Fixed Width', 'content' => 'Fixed', 'isText'=>true),
		'full' => array('title' => 'Full Width', 'content' => 'Full', 'isText'=>true),
		'flex' => array('title' => 'Fluid', 'content' => 'Fluid', 'isText'=>true),
		'column' => array('title' => 'Columns', 'content' => 'Columns', 'isText'=>true),);
ESSBOptionsStructureHelper::field_toggle($tab_id, $menu_id, 'button_width', '', '', $select_values);
	
	
ESSBOptionsStructureHelper::holder_start($tab_id, $menu_id, 'essb-fixed-width essb-hidden-open', 'essb-fixed-width');
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize fixed width display', 'essb'), __('In fixed width mode buttons will have exactly same width defined by you no matter of device or screen resolution (not responsive).', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, '', __('Customize the fixed width options', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, 'fixed_width_value', __('Custom buttons width', 'essb'), __('Provide custom width of button in pixels without the px symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, 'fixed_width_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name, when fixed button width is activated. When counter position is Inside or Inside name, that alignment will be applied for the counter. Default value is center.', 'essb'), array("" => "Center", "left" => "Left", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
ESSBOptionsStructureHelper::holder_end($tab_id, $menu_id);
	
ESSBOptionsStructureHelper::holder_start($tab_id, $menu_id, 'essb-full-width essb-hidden-open', 'essb-full-width');
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize full width display', 'essb'), __('In full width mode buttons will distribute over the entire screen width on each device (responsive).', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, 'fullwidth_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("left" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, __('Customize width of first two buttons', 'essb'), __('Provide different width for the first two buttons in the row. The width should be entered as number in percents (without the % mark). You can fill only one of the values or both values.', 'essb'), '', 'true');
ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, 'fullwidth_first_button', __('Width of first button', 'essb'), __('Provide custom width of first button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, 'fullwidth_second_button', __('Width of second button', 'essb'), __('Provide custom width of second button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
	
ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, __('Fix button apperance', 'essb'), __('Full width share buttons uses formula to calculate the best width of buttons. In some cases based on other site styles you may need to personalize some of the values in here', 'essb'), '', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, '', __('Full width option will make buttons to take the width of your post content area.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, 'fullwidth_share_buttons_correction', __('Max width of button on desktop', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, 'fullwidth_share_buttons_correction_mobile', __('Max width of button on mobile', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel($tab_id, $menu_id, 'fullwidth_share_buttons_container', __('Max width of buttons container element', 'essb'), __('If you wish to display total counter along with full width share buttons please provide custom max width of buttons container in percent without % (example: 90). Leave this field blank for default value of 100 (100%).', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
ESSBOptionsStructureHelper::holder_end($tab_id, $menu_id);
	
ESSBOptionsStructureHelper::holder_start($tab_id, $menu_id, 'essb-column-width essb-hidden-open', 'essb-column-width');
ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Customize column display', 'essb'), __('In column mode buttons will distribute over the entire screen width on each device in the number of columns you setup (responsive).', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_section_start_panels($tab_id, $menu_id, '', '');
$listOfOptions = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5");
ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, 'fullwidth_share_buttons_columns', __('Number of columns', 'essb'), __('Choose the number of columns that buttons will be displayed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_select_panel($tab_id, $menu_id, 'fullwidth_share_buttons_columns_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels($tab_id, $menu_id);
ESSBOptionsStructureHelper::holder_end($tab_id, $menu_id);
	
	
	
ESSBOptionsStructureHelper::structure_section_end($tab_id, $menu_id);
ESSBOptionsStructureHelper::structure_row_end($tab_id, $menu_id);

ESSBOptionsStructureHelper::title($tab_id, $menu_id, __('Live Style Preview', 'essb'), __('This style preview is illustrative showing how your buttons will look. All displayed share counters are random generated for preview purpose - real share values will appear on each post. Once you save settings you will be able to test the exact preview on site with networks you choose', 'essb'));
ESSBOptionsStructureHelper::field_func($tab_id, $menu_id, 'essb5_live_preview_wizard_position', '', '', '', array('position' => 'wizard'));

ESSBOptionsStructureHelper::field_heading('quick', 'quick-4', 'heading1', __('Choose Where Social Share Buttons Will Appear Automatically', 'essb'));
ESSBOptionsStructureHelper::hint('quick', 'quick-4', '', __('Setup where share buttons will appear on your site. More detailed and advanced setup you can find inside Where to Dislpay menu.', 'essb'));
ESSBOptionsStructureHelper::field_func('quick', 'quick-4', 'essb3_post_type_select', __('Post Types', 'essb'), __('Choose post types where you wish buttons to appear. If you are running WooCommerce store you can choose between post type Products which will display share buttons into product description or option to display buttons below price.', 'essb'));

ESSBOptionsStructureHelper::title('quick', 'quick-4',  __('Primary content display position', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'));
ESSBOptionsStructureHelper::field_single_position_select('quick', 'quick-4', 'content_position', essb5_available_content_positions(true));

ESSBOptionsStructureHelper::title('quick', 'quick-4',  __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'));
ESSBOptionsStructureHelper::field_multi_position_select('quick', 'quick-4', 'button_position', essb5_available_button_positions(true));


ESSBOptionsStructureHelper::field_heading('quick', 'quick-5', 'heading1', __('Mobile Setup', 'essb'));
ESSBOptionsStructureHelper::holder_start('quick', 'quick-5', 'essb-wizard-mobile-auto', 'essb-wizard-mobile-auto');
ESSBOptionsStructureHelper::hint('quick', 'quick-5', __('Automatic Mobile Options are working'), __('You are using automated mobile setup method to display or deactivate share buttons on mobile devices. If you wish to personalize appearance of buttons on mobile or have full control you need to choose manual display.', 'essb'));
ESSBOptionsStructureHelper::holder_end('quick', 'quick-5');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-5', 'essb-wizard-mobile-manual', 'essb-wizard-mobile-manual');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-5', __('Personalize display of share buttons on mobile device', 'essb'), __('Activate this option to change your mobile displayed positions and style settings of sharing buttons', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'mobile_positions', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

ESSBOptionsStructureHelper::title('quick', 'quick-5',  __('Primary content display position', 'essb'), __('Choose default method that will be used to render buttons inside content', 'essb'));
ESSBOptionsStructureHelper::field_single_position_select('quick', 'quick-5', 'content_position_mobile', essb5_available_content_positions_mobile());

ESSBOptionsStructureHelper::title('quick', 'quick-5',  __('Additional button display positions', 'essb'), __('Choose additional display methods that can be used to display buttons.', 'essb'));
ESSBOptionsStructureHelper::field_multi_position_select('quick', 'quick-5', 'button_position_mobile', essb5_available_button_positions_mobile());

ESSBOptionsStructureHelper::field_section_start_full_panels('quick', 'quick-5');
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_exclude_tablet', __('Do not apply mobile settings for tablets', 'essb'), __('You can avoid mobile rules for settings for tablet devices.', 'essb'), 'recommeded', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_avoid_newwindow', __('Open sharing window in same tab', 'essb'), __('Activate this option if you wish to make sharing on mobile open in same tab. Warning! Option may lead to loose visitor as once share dialog is opened with this option user will leave your site. Use with caution..', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('quick', 'quick-5');

ESSBOptionsStructureHelper::field_heading('quick', 'quick-5', 'heading4', __('Customize active social networks', 'essb'));
ESSBOptionsStructureHelper::title('quick', 'quick-5', __('', 'essb'), __('Choose social networks you wish to see appearing when your site is opened from a mobile device. This list is optional and you can use it in case you need to set a personalized mobile network list. Otherwise leave it blank for faster update of settings.', 'essb'), 'inner-row');

ESSBOptionsStructureHelper::field_network_select('quick', 'quick-5', 'mobile_networks', 'mobile');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-5', 'essb-panel-sharebar', 'essb-panel-sharebar');
ESSBOptionsStructureHelper::field_heading('quick', 'quick-5', 'heading4', __('Share bar customizations', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-5', 'mobile_sharebar_text', __('Text on share bar', 'essb'), __('Customize the default share bar text (default is Share).', 'essb'));
ESSBOptionsStructureHelper::holder_end('quick', 'quick-5');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-5', 'essb-panel-sharebuttons', 'essb-panel-sharebuttons');
ESSBOptionsStructureHelper::field_heading('quick', 'quick-5', 'heading4', __('Share buttons bar customizations', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('quick', 'quick-5');
$listOfOptions = array("1" => "1 Button", "2" => "2 Buttons", "3" => "3 Buttons", "4" => "4 Buttons", "5" => "5 Buttons", "6" => "6 Buttons");
ESSBOptionsStructureHelper::field_select_panel('quick', 'quick-5', 'mobile_sharebuttonsbar_count', __('Number of buttons in share buttons bar', 'essb'), __('Provide number of buttons you wish to see in buttons bar. If the number of activated buttons is greater than selected here the last button will be more button which will open pop up with all active buttons.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_sharebuttonsbar_names', __('Display network names', 'essb'), __('Activate this option to display network names (default display is icons only).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_sharebuttonsbar_fix', __('Fix problem with buttons not displayed in full width', 'essb'), __('Some themes may overwrite the default buttons style and in this case buttons do not take the full width of screen. Activate this option to fix the overwritten styles.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_sharebuttonsbar_total', __('Display total share counter', 'essb'), __('Activate this option to display total share counter as first button. If you activate it please keep in mind that you need to set number of columns to be with one more than buttons you except to see (total counter will act as single button)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_sharebuttonsbar_hideend', __('Hide buttons bar before end of page', 'essb'), __('This option is made to hide buttons bar once you reach 90% of page content to allow the entire footer to be visible.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-5', 'mobile_sharebuttonsbar_hideend_percent', __('% of content is viewed to hide buttons bar before end of page', 'essb'), __('Customize the default percent 90 when buttons bar will hide. Enter value in percents without the % mark.', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('quick', 'quick-5');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-5');

ESSBOptionsStructureHelper::field_heading('quick', 'quick-5', 'heading4', __('Client side mobile detection (Simple responsive buttons)', 'essb'));
ESSBOptionsStructureHelper::panel_start('quick', 'quick-5', __('Client side mobile detection', 'essb'), __('Client side mobile settings should be used only when you have a cache plugin that cannot be configured to work with both mobile and desktop version of site (see instructions on how to configure most popular cache plugins on the activate mobile settings switch). <br/><br/>All settings in this section use screen size of screen to detect a mobile device. If you use this mode of detection all desktop display methods cannot have different mobile settings on mobile device - they will display same buttons just like on desktop. Personalized settings will work for mobile optimized display methods only.<br/><br/>Quick note: After activating the client side detection if you see your mobile display methods twice you do not need a client side detection and you can turn it off.<br/><br/><b>Important! After you make change in that section after updating settings you need to clear cache of plugin you use to allow new css code that controls display to be added.</b>', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'mobile_css_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

ESSBOptionsStructureHelper::field_section_start_full_panels('quick', 'quick-5');
ESSBOptionsStructureHelper::field_textbox_panel('quick', 'quick-5', 'mobile_css_screensize', __('Width of screen', 'essb'), __('Leave blank to use the default width of 750. In case you wish to customize it fill value in numbers (without px) and all devices that have screen width below will be marked as mobile.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_css_readblock', __('Hide read blocking methods', 'essb'), __('Activate this option to remove all read blocking methods on mobile devices. Read blocking display methods are Sidebar and Post Vertical Float', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_css_all', __('Hide all share buttons on mobile', 'essb'), __('Activate this option to hide all share buttons on mobile devices including those made with shortcodes.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-5', 'mobile_css_optimized', __('Control mobile optimized display methods', 'essb'), __('Activate this option to display mobile optimized display methods when resolution meets the mobile size that is defined. Methods that are controlled with this option include: Share Buttons Bar, Share Bar and Share Point. At least one of those methods should be selected in the settings above for additional display methods.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_panels('quick', 'quick-5');
ESSBOptionsStructureHelper::panel_end('quick', 'quick-5');

ESSBOptionsStructureHelper::panel_end('quick', 'quick-5');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-5');


ESSBOptionsStructureHelper::field_heading('quick', 'quick-6', 'heading1', __('Subscribe Forms', 'essb'));
ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-wizard-subscribe-auto', 'essb-wizard-subscribe-auto');
ESSBOptionsStructureHelper::hint('quick', 'quick-6', __('Function is deactivated'), __('Plugin functions mode you are using has deactivated usage of that module.', 'essb'));
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-wizard-subscribe-manual', 'essb-wizard-subscribe-manual');

// subscribe
// Easy Optin
$optin_connectors = array("mailchimp" => "MailChimp",
		"getresponse" => "GetResponse",
		"mymail" => "MyMail",
		"mailpoet" => "MailPoet",
		"mailerlite" => "MailerLite",
		"activecampaign" => "ActiveCampaign",
		"campaignmonitor" => "CampaignMonitor",
		"sendinblue" => "SendinBlue");

if (has_filter('essb_external_subscribe_connectors')) {
	$optin_connectors = apply_filters('essb_external_subscribe_connectors', $optin_connectors);
}
ESSBOptionsStructureHelper::field_switch('quick', 'quick-6', 'subscribe_widget', __('Activate subscribe widget & shortcode', 'essb'), __('Activation of this option will allow you to use subscribe widget and shortcode anywhere on your site not connected with subscribe button inside share buttons', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('Subscribe Button in Share Buttons', 'essb'), __('Configure functionality of subscribe button that you can add along with your share buttons', 'essb'), 'fa21 essb_icon_subscribe', array("mode" => "toggle", 'state' => 'opened'));

$listOfValues = array ("form" => "Open content box", "link" => "Open subscribe link", "mailchimp" => "Easy Optin Subscribe Form (Ready made forms with automatic service integrations)" );
ESSBOptionsStructureHelper::field_select('quick', 'quick-6', 'subscribe_function', __('Specify subscribe button function', 'essb'), __('Specify if the subscribe button is opening a content box below the button or if the button is linked to the "subscribe url" below.', 'essb'), $listOfValues);

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', '', 'essb-subscribe-link');
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_link', __('Subscribe URL', 'essb'), __('Link the Subscribe button to this URL. This can be the url to your subscribe page, facebook fanpage, RSS feed etc. e.g. http://yoursite.com/subscribe', 'essb'));
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', '', 'essb-subscribe-content');
ESSBOptionsStructureHelper::field_editor('quick', 'quick-6', 'subscribe_content', __('Subscribe content box', 'essb'), __('Define the content of the opening toggle subscribe window here. Use formulars, like button, links or any other text. Shortcodes are supported, e.g.: [contact-form-7]. Note that if you use subscribe button outside content display positions content will open as popup', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', '', 'essb-subscribe-form');
$listOfValues = essb_optin_designs();
ESSBOptionsStructureHelper::field_select('quick', 'quick-6', 'subscribe_optin_design', __('Specify subscribe button Easy Optin design for content', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_select('quick', 'quick-6', 'subscribe_optin_design_popup', __('Specify subscribe button Easy Optin design for popup', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::field_select('quick', 'quick-6', 'subscribe_connector', __('Choose your service', 'essb'), __('Select service that you wish to integrate with Easy Optin forms. Please note that for correct work you need to fill all required authorizations details for it below', 'essb'), $optin_connectors);

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-mailchimp');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('MailChimp', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_mc_api', __('Mailchimp API key', 'essb'), __('<a href="http://kb.mailchimp.com/accounts/management/about-api-keys#Finding-or-generating-your-API-key" target="_blank">Find your API key</a>', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_mc_list', __('Mailchimp List ID', 'essb'), __('<a href="http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id" target="_blank">Find your List ID</a>', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('quick', 'quick-6');
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-6', 'subscribe_mc_welcome', __('Send welcome message:', 'essb'), __('Allow Mailchimp send welcome mssage upon subscribe.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-6', 'subscribe_mc_double', __('Use double opt in:', 'essb'), __('The MailChimp double opt-in process is a two-step process, where a subscriber fills out your signup form and receives an email with a link to confirm their subscription. MailChimp also includes some additional thank you and confirmation pages you can customize with your brand and messaging.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-6', 'subscribe_mc_namefield', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('quick', 'quick-6');
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-getresponse');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('GetResponse', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_gr_api', __('GetReponse API key', 'essb'), __('<a href="http://support.getresponse.com/faq/where-i-find-api-key" target="_blank">Find your API key</a>', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_gr_list', __('GetReponse Campaign Name', 'essb'), __('<a href="http://support.getresponse.com/faq/can-i-change-the-name-of-a-campaign" target="_blank">Find your campaign name</a>', 'essb'));
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-mailerlite');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('MailerLite', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_ml_api', __('MailerLite API key', 'essb'), __('Entery your MailerLite API key. To get your key visit this page <a href="https://app.mailerlite.com/subscribe/api" target="_blank">https://app.mailerlite.com/subscribe/api</a> and look under API key.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_ml_list', __('MailerLite List ID (Group ID)', 'essb'), __('Enter your list id (aka Group ID). To find your group id visit again the page for API key generation and you will see all list you have with their ids.', 'essb'));
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-activecampaign');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('ActiveCampaign', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_ac_api_url', __('ActiveCampaign API URL', 'essb'), __('Enter your ActiveCampaign API URL. To get API URL please go to your ActiveCampaign Account >> My Settings >> Developer.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_ac_api', __('ActiveCampaign API Key', 'essb'), __('Enter your ActiveCampaign API Key. To get API Key please go to your ActiveCampaign Account >> My Settings >> Developer.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_ac_list', __('ActiveCapaign List ID', 'essb'), __('Entery your ActiveCampaign List ID. To get your list ID visit lists pages and copy ID that you see in browser when you open list ?listid=<yourid>.', 'essb'));
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');


ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-campaignmonitor');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('CampaignMonitor', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_cm_api', __('CampaignMonitor API Key', 'essb'), __('Enter your Campaign Monitor API Key. You can get your API Key from the Account Settings page when logged into your Campaign Monitor account.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_cm_list', __('CampaignMonitor List ID', 'essb'), __('Enter your List ID. You can get List ID from the list editor page when logged into your Campaign Monitor account.', 'essb'));
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-mymail');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('MyMail', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
$listOfOptions = array();
if (function_exists('mymail')) {
	$lists = mymail('lists')->get();
	foreach ($lists as $list) {
		if (function_exists('mymail')) $id = $list->ID;
		else $id = $list->term_id;

		$listOfOptions[$id] = $list->name;
	}
}
ESSBOptionsStructureHelper::field_select('quick', 'quick-6', 'subscribe_mm_list', __('MyMail List', 'essb'), __('Select your list. Please ensure that MyMail plugin is installed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch_panel('quick', 'quick-6', 'subscribe_mm_double', __('Use pending state for new subscribers', 'essb'), __('Use this to setup Pending state of all your new subscribers and manually review at later.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');


ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-mailpoet');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('MailPoet', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
$listOfOptions = array();
if (class_exists('WYSIJA')) {
	$model_list = WYSIJA::get('list', 'model');
	$mailpoet_lists = $model_list->get(array('name', 'list_id'), array('is_enabled'=>1));
	if (sizeof($mailpoet_lists) > 0) {
		foreach ($mailpoet_lists as $list) {
			$listOfOptions[$list['list_id']] = $list['name'];
		}
	}
}
ESSBOptionsStructureHelper::field_select('quick', 'quick-6', 'subscribe_mp_list', __('MailPoet List', 'essb'), __('Select your list. Please ensure that MailPoet plugin is installed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-6', 'essb-subscribe-connector', 'essb-subscribe-connector-sendinblue');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-6', __('SendinBlue', 'essb'), __('SendinBlue mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_sib_api', __('SendinBlue API Key', 'essb'), __('Enter your SendinBlue API Key. You can get your API Key from <a href="https://my.sendinblue.com/advanced/apikey" target="_blank">here</a> (API key version 2.0).', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('quick', 'quick-6', 'subscribe_sib_list', __('SendinBlue List ID', 'essb'), __('Enter your list ID.', 'essb'));
ESSBOptionsStructureHelper::panel_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');
ESSBOptionsStructureHelper::holder_end('quick', 'quick-6');


ESSBOptionsStructureHelper::field_heading('quick', 'quick-7', 'heading1', __('Social Followers Counter', 'essb'));
ESSBOptionsStructureHelper::holder_start('quick', 'quick-7', 'essb-wizard-follow-auto', 'essb-wizard-follow-auto');
ESSBOptionsStructureHelper::hint('quick', 'quick-7', __('Function is deactivated'), __('Plugin functions mode you are using has deactivated usage of that module.', 'essb'));
ESSBOptionsStructureHelper::holder_end('quick', 'quick-7');

ESSBOptionsStructureHelper::holder_start('quick', 'quick-7', 'essb-wizard-follow-manual', 'essb-wizard-follow-manual');
ESSBOptionsStructureHelper::panel_start('quick', 'quick-7', __('Activate Social Followers Counter', 'essb'), __('Activate this option to use followers counter widget and shortcodes', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'fanscounter_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-7', 'fanscounter_widget_deactivate', __('I will not use Followers Counter widget', 'essb'), __('Activate this option in case you do not plan to use followers widget but just a shortcode call. Deactivation of widget when it is not used will save server resources on high traffic sites.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_select('quick', 'quick-7', 'essb3fans_update', __('Update period', 'essb'), __('Choose the time when counters will be updated. Default is 1 day if nothing is selected.', 'essb'), ESSBSocialFollowersCounterHelper::available_cache_periods());
ESSBOptionsStructureHelper::field_select('quick', 'quick-7', 'essb3fans_format', __('Number format', 'essb'), __('Choose default number format', 'essb'), ESSBSocialFollowersCounterHelper::available_number_formats());
ESSBOptionsStructureHelper::field_switch('quick', 'quick-7', 'essb3fans_uservalues', __('Allow user values', 'essb'), __('Activate this option to allow enter of user values for each social network. In this case when automatic value is less than user value the user value will be used', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-7', 'fanscounter_clear_on_save', __('Clear stored values on settings update', 'essb'), __('Mark yes to tell plugin clear previous updated values that are stored into database. You need this option if current stored value in database is greater than your current value of followers and you wish to make it update.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('quick', 'quick-7', 'heading5', __('Social Networks', 'essb'));
ESSBOptionsStructureHelper::field_checkbox_list_sortable('quick', 'quick-7', 'essb3fans_networks', __('Social Networks', 'essb'), __('Order and activate networks you wish to use in widget and shortcodes'), ESSBSocialFollowersCounterHelper::available_social_networks(false));
//essb3fans_

essb3_draw_fanscounter_settings_wizard('quick', 'quick-7');

ESSBOptionsStructureHelper::panel_end('quick', 'quick-7');


ESSBOptionsStructureHelper::holder_end('quick', 'quick-7');



ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'quick_setup_recommended', __('Apply social networks recommended settings', 'essb'), __('Activate this option to activate recommended for each social network options (like Short URL for Twitter)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'opengraph_tags', __('Activate social share optimization meta tags', 'essb'), __('If you do not use SEO plugin or other plugin that insert social share optimization meta tags it is highly recommended to activate this option. It will generated required for better sharing meta tags and also will allow you to change the values that social network read from your site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'stats_active', __('Activate social share buttons click statistics', 'essb'), __('Click statistics hanlde click on share buttons and you are able to see detailed view of user activity. Please note that plugin log clicks of buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::hint('quick', 'quick-8', '', __('Use optimization options below if you do not use cache plugin or optimization plugin on your site. If you use such you can activate them but in case you see unexpected visual output please visit Advanced Settings -> Optimization options and turn them off', 'essb'));
ESSBOptionsStructureHelper::field_section_start('quick', 'quick-8', __('Optimizations', 'essb'), __('Select which optimization options you wish to use. If you use cache plugin or CDN on your site than those optimizations are already made. In this case we suggest to avoid activating these options.', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'quick_setup_static', __('Optimize static plugin resources load', 'essb'), __('Activate this option to apply the recommended options for static resources load.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('quick', 'quick-8', 'precompiled_resources', __('Use plugin precompiled resources', 'essb'), __('Activating this option will precompile and cache plugin dynamic resources to save load time. Precompiled resources can be used only when you use same configuration on your entire site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_section_end('quick', 'quick-8');


function essb5_live_preview_wizard_position($options) {
	$element_options = isset($options['element_options']) ? $options['element_options'] : array();
	$position = isset($element_options['position']) ? $element_options['position'] : '';

	// if there is no position we cannot display live preview
	if ($position == '') {
		return;
	}

	$code = '<div class="essb-component-buttons-livepreview" data-settings="essb_'.$position.'_global_preview">';
	$code .= '</div>';

	$code .= "<script type=\"text/javascript\">

	var essb_".$position."_global_preview = {
	'networks': [ {'key': 'facebook', 'name': 'Facebook'}, {'key': 'twitter', 'name': 'Twitter'}, {'key': 'google', 'name': 'Google'}, {'key': 'pinterest', 'name': 'Pinterest'}, {'key': 'linkedin', 'name': 'LinkedIn'}],
	'template': 'essb_field_style',
	'button_style': 'essb_field_button_style',
	'align': 'essb_options_button_pos',
	'nospace': 'essb_field_nospace',
	'counter': 'essb_field_show_counter',
	'counter_pos': 'essb_field_counter_pos',
	'total_counter_pos': 'essb_field_total_counter_pos',
	'width': 'essb_options_button_width',
	'animation': 'essb_field_css_animations',
	'fixed_width': 'essb_options_fixed_width_value',
	'fixed_align': 'essb_options_fixed_width_align',
	'columns_count': 'essb_options_fullwidth_share_buttons_columns',
	'columns_align': 'essb_options_fullwidth_share_buttons_columns_align',
	'full_button': 'essb_options_fullwidth_share_buttons_correction',
	'full_align': 'essb_options_fullwidth_align',
	'full_first': 'essb_options_fullwidth_first_button',
	'full_second': 'essb_options_fullwidth_second_button'
};

</script>";

	echo $code;
}

function essb3_draw_fanscounter_settings_wizard($tab_id, $menu_id) {
	$setting_fields = ESSBSocialFollowersCounterHelper::options_structure();
	$network_list = ESSBSocialFollowersCounterHelper::available_social_networks();

	$networks_same_authentication = array();

	// @since 3.2.2 Integration with Social Followers Counter Extended
	if (defined('ESSB3_SFCE_OPTIONS_NAME')) {
		$fanscounter_extended_options = get_option(ESSB3_SFCE_OPTIONS_NAME);
		$extended_list = array();
		foreach ($network_list as $network => $title) {
			$is_active_extended = ESSBOptionValuesHelper::options_bool_value($fanscounter_extended_options, 'activate_'.$network);
			$use_same_api = ESSBOptionValuesHelper::options_bool_value($fanscounter_extended_options, 'same_access_'.$network);
			$count_extended = ESSBOptionValuesHelper::options_value($fanscounter_extended_options, 'profile_count_'.$network);
			$count_extended = intval($count_extended);

			$extended_list[$network] = $title;

			if ($is_active_extended) {
				if ($use_same_api) {
					$networks_same_authentication[$network] = "yes";
				}

				for ($i=1;$i<=$count_extended;$i++) {
					$extended_list[$network."_".$i] = $title." Additional Profile ".$i;
				}
			}
		}
		$network_list = array();
		foreach ($extended_list as $network => $title) {
			$network_list[$network] = $title;
		}

		//asort($network_list);
	}

	foreach ($network_list as $network => $title) {
		ESSBOptionsStructureHelper::holder_start($tab_id, $menu_id, 'essb-followers-panel essb-followers-'.$network, 'essb-followers-'.$network);
		ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, $title, __('Configure social network details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));

		$default_options_key = $network;
		$is_extended_key = false;

		if (strpos($default_options_key, '_') !== false && $default_options_key != 'wp_posts' && $default_options_key != 'wp_comments' && $default_options_key != 'wp_users') {
			$key_array = explode('_', $default_options_key);
			$default_options_key = $key_array[0];
			$is_extended_key = true;
		}

		$single_network_options = isset($setting_fields[$default_options_key]) ? $setting_fields[$default_options_key] : array();

		foreach ($single_network_options as $field => $options) {
			$field_id = "essb3fans_".$network."_".$field;

			$field_type = isset($options['type']) ? $options['type'] : 'textbox';
			$field_text = isset($options['text']) ? $options['text'] : '';
			$field_description = isset($options['description']) ? $options['description'] : '';
			$field_values = isset($options['values']) ? $options['values'] : array();

			$is_authfield = isset($options['authfield']) ? $options['authfield'] : false;

			if ($is_extended_key && $is_authfield) {
				if (isset($networks_same_authentication[$default_options_key])) {
					continue;
				}
			}

			if ($field_type == "textbox") {
				ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, $field_id, $field_text, $field_description);
			}
			if ($field_type == "select") {
				ESSBOptionsStructureHelper::field_select($tab_id, $menu_id, $field_id, $field_text, $field_description, $field_values);
			}
		}

		ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
		ESSBOptionsStructureHelper::holder_end($tab_id, $menu_id);
	}
}
?>