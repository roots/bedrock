<?php

if (essb_option_bool_value('deactivate_module_subscribe')) {
	return;
}

ESSBOptionsStructureHelper::menu_item('optin', 'optin-0', __('Activate Usage', 'essb'), ' ti-widget-alt');
ESSBOptionsStructureHelper::menu_item('optin', 'optin-1', __('Mailing List Platforms', 'essb'), ' ti-email');
ESSBOptionsStructureHelper::menu_item('optin', 'optin-14', __('Subscribe forms below content', 'essb'), ' ti-layout-media-overlay');
ESSBOptionsStructureHelper::menu_item('optin', 'optin-11', __('Subscribers Booster', 'essb'), ' ti-rocket');
ESSBOptionsStructureHelper::menu_item('optin', 'optin-12', __('Subscribers Flyout', 'essb'), ' ti-layout-media-center-alt');



ESSBOptionsStructureHelper::menu_item('optin', 'optin', __('Customize Form Designs', 'essb'), ' ti-ruler-pencil', 'activate_first', 'optin-2');
//ESSBOptionsStructureHelper::submenu_item('optin', 'optin-1', __('Connectors', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-2', __('Customize Design #1', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-3', __('Customize Design #2', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-4', __('Customize Design #3', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-5', __('Customize Design #4', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-6', __('Customize Design #5', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-7', __('Customize Design #6', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-8', __('Customize Design #7', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-9', __('Customize Design #8', 'essb'));
ESSBOptionsStructureHelper::submenu_item('optin', 'optin-10', __('Customize Design #9', 'essb'));


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

ESSBOptionsStructureHelper::field_switch('optin', 'optin-0', 'subscribe_widget', __('Activate subscribe widget & shortcode', 'essb'), __('Activation of this option will allow you to use subscribe widget and shortcode anywhere on your site not connected with subscribe button inside share buttons', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::panel_start('optin', 'optin-0', __('Subscribe Button in Share Buttons', 'essb'), __('Configure functionality of subscribe button that you can add along with your share buttons', 'essb'), 'fa21 essb_icon_subscribe', array("mode" => "toggle", 'state' => 'opened'));

$listOfValues = array ("form" => "Open content box", "link" => "Open subscribe link", "mailchimp" => "Easy Optin Subscribe Form (Ready made forms with automatic service integrations)" );
ESSBOptionsStructureHelper::field_select('optin', 'optin-0', 'subscribe_function', __('Specify subscribe button function', 'essb'), __('Specify if the subscribe button is opening a content box below the button or if the button is linked to the "subscribe url" below.', 'essb'), $listOfValues);

ESSBOptionsStructureHelper::holder_start('optin', 'optin-0', '', 'essb-subscribe-link');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-0', 'subscribe_link', __('Subscribe URL', 'essb'), __('Link the Subscribe button to this URL. This can be the url to your subscribe page, facebook fanpage, RSS feed etc. e.g. http://yoursite.com/subscribe', 'essb'));
ESSBOptionsStructureHelper::holder_end('optin', 'optin-0');

ESSBOptionsStructureHelper::holder_start('optin', 'optin-0', '', 'essb-subscribe-content');
ESSBOptionsStructureHelper::field_editor('optin', 'optin-0', 'subscribe_content', __('Subscribe content box', 'essb'), __('Define the content of the opening toggle subscribe window here. Use formulars, like button, links or any other text. Shortcodes are supported, e.g.: [contact-form-7]. Note that if you use subscribe button outside content display positions content will open as popup', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-0');

ESSBOptionsStructureHelper::holder_start('optin', 'optin-0', '', 'essb-subscribe-form');
$listOfValues = essb_optin_designs();
ESSBOptionsStructureHelper::field_select('optin', 'optin-0', 'subscribe_optin_design', __('Specify subscribe button Easy Optin design for content', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_select('optin', 'optin-0', 'subscribe_optin_design_popup', __('Specify subscribe button Easy Optin design for popup', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::panel_end('optin', 'optin-0');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-0');

ESSBOptionsStructureHelper::panel_start('optin', 'optin-14', __('Automatically add opt-in form below content', 'essb'), __('Activate of this option will allow to include forms on posts or pages to get more subscribers.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'optin_content_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

ESSBOptionsStructureHelper::field_section_start_full_panels('optin', 'optin-14');
ESSBOptionsStructureHelper::field_switch_panel('optin', 'optin-14', 'essb3_of|of_posts', __('Display on posts', 'essb'), __('Automatically display subscribe form on posts below content.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('optin', 'optin-14', 'essb3_of|of_pages', __('Display on pages', 'essb'), __('Automatically display subscribe form on pages below content.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-14', 'essb3_of|of_design', __('Use followin template', 'essb'), __('Choose the design of optin forms that you wish to use for automatically generated forms', 'essb'), essb_optin_designs());
ESSBOptionsStructureHelper::field_section_end_full_panels('optin', 'optin-14');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-14', 'essb3_of|of_exclude', __('Exclude display on', 'essb'), __('Exclude buttons on posts/pages with these IDs. Comma separated: "11, 15, 125". This will deactivate automated display of buttons on selected posts/pages but you are able to use shortcode on them.', 'essb'), '');

ESSBOptionsStructureHelper::field_switch('optin', 'optin-14', 'essb3_of|of_creditlink', __('Include credit link', 'essb'), __('Include tiny credit link below your form to allow others know what you are using to generate subscribe forms. Activate this option to show your appreciation for our efforts and allow you earn money from Envato affiliate program.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox('optin', 'optin-14', 'essb3_of|of_creditlink_user', __('Your Envato username', 'essb'), __('Include credit link and earn 30% of users first purchase via Envato Affiliate Program. Learn more <a href="https://themeforest.net/affiliate_program" target="_blank">here</a> for Envato affiliate program.', 'essb'), '');

ESSBOptionsStructureHelper::panel_end('optin', 'optin-14');

ESSBOptionsStructureHelper::panel_start('optin', 'optin-11', __('Automatically add pop up opt-in form (boost subscribers)', 'essb'), __('Activate of this option will allow to include forms on posts or pages to get more subscribers.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'optin_booster_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

ESSBOptionsStructureHelper::panel_start('optin', 'optin-11', __('Limit display on selected post types only', 'essb'), __('Use this area if you wish to make function work for selected post types only. Otherwise it will appear everywhere on your site.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'optin_booster_activate_posttypes', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_checkbox_list('optin', 'optin-11', 'essb3_ofob|posttypes', __('Appear only on selected post types', 'essb'), __('Limit function to work only on selected post types. Leave non option selected to make it work on all', 'essb'), essb_get_post_types());
ESSBOptionsStructureHelper::field_switch('optin', 'optin-11', 'essb3_ofob|deactivate_homepage', __('Deactivate display on homepage', 'essb'), __('Exclude display of function on home page of your site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-11');

	ESSBOptionsStructureHelper::field_switch('optin', 'optin-11', 'essb3_ofob|ofob_single', __('Appear once for user', 'easy-optin-booster'), __('Activate this option if you wish to make event appear only once for user in the next 14 days. ', 'easy-optin-booster'), '', __('Yes', 'easy-optin-booster'), __('No', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-11', 'essb3_ofob|ofob_exclude', __('Exclude display on', 'essb'), __('Exclude buttons on posts/pages with these IDs. Comma separated: "11, 15, 125". This will deactivate automated display of buttons on selected posts/pages but you are able to use shortcode on them.', 'essb'), '');
	
	ESSBOptionsStructureHelper::panel_start('optin', 'optin-11', __('Display after amount of seconds', 'easy-optin-booster'), __('Automatically display selected opt-in form after amount of seconds. If you wish to trigger immediately after load then you can use 1 as value', 'easy-optin-booster'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'switch_id' => '', 'switch_on' => __('Yes', 'easy-optin-booster'), 'switch_off' => __('No', 'easy-optin-booster')));
	ESSBOptionsStructureHelper::field_switch('optin', 'optin-11', 'essb3_ofob|ofob_time', __('Activate', 'easy-optin-booster'), __('Set this option to Yes to use this event', 'easy-optin-booster'), '', __('Yes', 'easy-optin-booster'), __('No', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-11', 'essb3_ofob|ofob_time_delay', __('Display after seconds', 'easy-optin-booster'), __('If you wish to display it immediately after load use 1 as value. Otherwise provide value of seconds you wish to use. Blank field will avoid display of opt-in form', 'easy-optin-booster'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-11', 'essb3_ofob|of_time_design', __('Choose design for that event', 'easy-facebook-comments'), __('Choose design which will be used for that event. You can have different design on each event', 'easy-facebook-comments'), essb_optin_designs());
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-11', 'essb3_ofob|of_time_bgcolor', __('Overlay background color', 'easy-optin-booster'), __('Change overlay background color that will be used for that event. You may need to replace the color if you customize design of chosen template.', 'easy-optin-booster'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-11', 'essb3_ofob|of_time_close', __('Choose close type', 'easy-facebook-comments'), __('Choose how you wish to close the pop up form - with close icon or text link.', 'essb-optin-booster'), array("icon" => "Close Icon", "text" => "Text close link"));
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-11', 'essb3_ofob|of_time_closecolor', __('Close action color', 'easy-optin-booster'), __('Customize close action color in case you change overlay color. Otherwise you can leave the default', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-11', 'essb3_ofob|of_time_closetext', __('Custom close text', 'easy-optin-booster'), __('Enter custom close text when you choose text mode of close function.', 'easy-optin-booster'), '');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::panel_end('optin', 'optin-11');

	ESSBOptionsStructureHelper::panel_start('optin', 'optin-11', __('Display on scroll', 'easy-optin-booster'), __('Automatically display selected opt-in form when percent of content is viewed', 'easy-optin-booster'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'switch_id' => '', 'switch_on' => __('Yes', 'easy-optin-booster'), 'switch_off' => __('No', 'easy-optin-booster')));
	ESSBOptionsStructureHelper::field_switch('optin', 'optin-11', 'essb3_ofob|ofob_scroll', __('Activate', 'easy-optin-booster'), __('Set this option to Yes to use this event', 'easy-optin-booster'), '', __('Yes', 'easy-optin-booster'), __('No', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-11', 'essb3_ofob|ofob_scroll_percent', __('Percent of content', 'easy-optin-booster'), __('Use numeric value without symbols. Exmaple: 40', 'easy-optin-booster'), '', 'input60', 'fa-long-arrow-down', 'right');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-11', 'essb3_ofob|of_scroll_design', __('Choose design for that event', 'easy-facebook-comments'), __('Choose design which will be used for that event. You can have different design on each event', 'easy-facebook-comments'), essb_optin_designs());
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-11', 'essb3_ofob|of_scroll_bgcolor', __('Overlay background color', 'easy-optin-booster'), __('Change overlay background color that will be used for that event. You may need to replace the color if you customize design of chosen template.', 'easy-optin-booster'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-11', 'essb3_ofob|of_scroll_close', __('Choose close type', 'easy-facebook-comments'), __('Choose how you wish to close the pop up form - with close icon or text link.', 'essb-optin-booster'), array("icon" => "Close Icon", "text" => "Text close link"));
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-11', 'essb3_ofob|of_scroll_closecolor', __('Close action color', 'easy-optin-booster'), __('Customize close action color in case you change overlay color. Otherwise you can leave the default', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-11', 'essb3_ofob|of_scroll_closetext', __('Custom close text', 'easy-optin-booster'), __('Enter custom close text when you choose text mode of close function.', 'easy-optin-booster'), '');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::panel_end('optin', 'optin-11');

	ESSBOptionsStructureHelper::panel_start('optin', 'optin-11', __('Display on exit intent', 'easy-optin-booster'), __('Automatically display selected opt-in form when user try to leave window', 'easy-optin-booster'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'switch_id' => '', 'switch_on' => __('Yes', 'easy-optin-booster'), 'switch_off' => __('No', 'easy-optin-booster')));
	ESSBOptionsStructureHelper::field_switch('optin', 'optin-11', 'essb3_ofob|ofob_exit', __('Activate', 'easy-optin-booster'), __('Set this option to Yes to use this event', 'easy-optin-booster'), '', __('Yes', 'easy-optin-booster'), __('No', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-11', 'essb3_ofob|of_exit_design', __('Choose design for that event', 'easy-facebook-comments'), __('Choose design which will be used for that event. You can have different design on each event', 'easy-facebook-comments'), essb_optin_designs());
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-11', 'essb3_ofob|of_exit_bgcolor', __('Overlay background color', 'easy-optin-booster'), __('Change overlay background color that will be used for that event. You may need to replace the color if you customize design of chosen template.', 'easy-optin-booster'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-11', 'essb3_ofob|of_exit_close', __('Choose close type', 'easy-facebook-comments'), __('Choose how you wish to close the pop up form - with close icon or text link.', 'essb-optin-booster'), array("icon" => "Close Icon", "text" => "Text close link"));
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-11', 'essb3_ofob|of_exit_closecolor', __('Close action color', 'easy-optin-booster'), __('Customize close action color in case you change overlay color. Otherwise you can leave the default', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-11', 'essb3_ofob|of_exit_closetext', __('Custom close text', 'easy-optin-booster'), __('Enter custom close text when you choose text mode of close function.', 'easy-optin-booster'), '');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-11', '', '');
	ESSBOptionsStructureHelper::panel_end('optin', 'optin-11');


	ESSBOptionsStructureHelper::field_switch('optin', 'optin-11', 'essb3_ofob|ofob_creditlink', __('Include credit link', 'easy-optin-booster'), __('Include tiny credit link below your comments box to allow others know what you are using to generate Facebook Comments. Activate this option to show your appreciation for our efforts.', 'easy-optin-booster'), '', __('Yes', 'easy-optin-booster'), __('No', 'easy-optin-booster'));
	ESSBOptionsStructureHelper::field_textbox('optin', 'optin-11', 'essb3_ofob|ofob_creditlink_user', __('Your Envato username', 'easy-optin-booster'), __('Include credit link and earn 30% of users first purchase via Envato Affiliate Program. Learn more <a href="https://themeforest.net/affiliate_program" target="_blank">here</a> for Envato affiliate program.', 'easy-optin-booster'), '');
	


ESSBOptionsStructureHelper::panel_end('optin', 'optin-11');

ESSBOptionsStructureHelper::panel_start('optin', 'optin-12', __('Automatically add fly out opt-in form', 'essb'), __('Activate of this option will allow to include forms on posts or pages to get more subscribers.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'optin_flyout_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

ESSBOptionsStructureHelper::panel_start('optin', 'optin-12', __('Limit display on selected post types only', 'essb'), __('Use this area if you wish to make function work for selected post types only. Otherwise it will appear everywhere on your site.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'optin_flyout_activate_posttypes', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_checkbox_list('optin', 'optin-12', 'essb3_ofof|posttypes', __('Appear only on selected post types', 'essb'), __('Limit function to work only on selected post types. Leave non option selected to make it work on all', 'essb'), essb_get_post_types());
ESSBOptionsStructureHelper::field_switch('optin', 'optin-12', 'essb3_ofof|of_deactivate_homepage', __('Deactivate display on homepage', 'essb'), __('Exclude display of function on home page of your site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-12');


	ESSBOptionsStructureHelper::field_switch('optin', 'optin-12', 'essb3_ofof|ofof_single', __('Appear once for user', 'easy-optin-flyout'), __('Activate this option if you wish to make event appear only once for user in the next 14 days. ', 'easy-optin-flyout'), '', __('Yes', 'easy-optin-flyout'), __('No', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_select('optin', 'optin-12', 'essb3_ofof|ofof_position', __('Appear at', 'easy-optin-flyout'), __('Choose position where the fly out will appear', 'easy-optin-flyout'), array("bottom-right" => __('Bottom Right', 'easy-optin-flyout'), "bottom-left" => __('Bottom Left', 'easy-optin-flyout'), "top-right" => __('Top Right', 'easy-optin-flyout'), "top-left" => __('Top Left', 'easy-optin-flyout')));
	ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-12', 'essb3_ofof|ofof_exclude', __('Exclude display on', 'essb'), __('Exclude buttons on posts/pages with these IDs. Comma separated: "11, 15, 125". This will deactivate automated display of buttons on selected posts/pages but you are able to use shortcode on them.', 'essb'), '');
	
	ESSBOptionsStructureHelper::panel_start('optin', 'optin-12', __('Display after amount of seconds', 'easy-optin-flyout'), __('Automatically display selected opt-in form after amount of seconds. If you wish to trigger immediately after load then you can use 1 as value', 'easy-optin-flyout'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'switch_id' => '', 'switch_on' => __('Yes', 'easy-optin-flyout'), 'switch_off' => __('No', 'easy-optin-flyout')));
	ESSBOptionsStructureHelper::field_switch('optin', 'optin-12', 'essb3_ofof|ofof_time', __('Activate', 'easy-optin-flyout'), __('Set this option to Yes to use this event', 'easy-optin-flyout'), '', __('Yes', 'easy-optin-flyout'), __('No', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-12', 'essb3_ofof|ofof_time_delay', __('Display after seconds', 'easy-optin-flyout'), __('If you wish to display it immediately after load use 1 as value. Otherwise provide value of seconds you wish to use. Blank field will avoid display of opt-in form', 'easy-optin-flyout'), '', 'input60', 'fa-clock-o', 'right');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-12', 'essb3_ofof|of_time_design', __('Choose design for that event', 'easy-optin-flyout'), __('Choose design which will be used for that event. You can have different design on each event', 'easy-optin-flyout'), essb_optin_designs());
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-12', 'essb3_ofof|of_time_bgcolor', __('Overlay background color', 'easy-optin-flyout'), __('Change overlay background color that will be used for that event. You may need to replace the color if you customize design of chosen template.', 'easy-optin-flyout'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-12', 'essb3_ofof|of_time_close', __('Choose close type', 'easy-optin-flyout'), __('Choose how you wish to close the pop up form - with close icon or text link.', 'essb-optin-booster'), array("icon" => "Close Icon", "text" => "Text close link"));
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-12', 'essb3_ofof|of_time_closecolor', __('Close action color', 'easy-optin-flyout'), __('Customize close action color in case you change overlay color. Otherwise you can leave the default', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-12', 'essb3_ofof|of_time_closetext', __('Custom close text', 'easy-optin-flyout'), __('Enter custom close text when you choose text mode of close function.', 'easy-optin-flyout'), '');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::panel_end('optin', 'optin-12');

	ESSBOptionsStructureHelper::panel_start('optin', 'optin-12', __('Display on scroll', 'easy-optin-flyout'), __('Automatically display selected opt-in form when percent of content is viewed', 'easy-optin-flyout'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'switch_id' => '', 'switch_on' => __('Yes', 'easy-optin-flyout'), 'switch_off' => __('No', 'easy-optin-flyout')));
	ESSBOptionsStructureHelper::field_switch('optin', 'optin-12', 'essb3_ofof|ofof_scroll', __('Activate', 'easy-optin-flyout'), __('Set this option to Yes to use this event', 'easy-optin-flyout'), '', __('Yes', 'easy-optin-flyout'), __('No', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-12', 'essb3_ofof|ofof_scroll_percent', __('Percent of content', 'easy-optin-flyout'), __('Use numeric value without symbols. Exmaple: 40', 'easy-optin-flyout'), '', 'input60', 'fa-long-arrow-down', 'right');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-12', 'essb3_ofof|of_scroll_design', __('Choose design for that event', 'easy-optin-flyout'), __('Choose design which will be used for that event. You can have different design on each event', 'easy-optin-flyout'), essb_optin_designs());
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-12', 'essb3_ofof|of_scroll_bgcolor', __('Overlay background color', 'easy-optin-flyout'), __('Change overlay background color that will be used for that event. You may need to replace the color if you customize design of chosen template.', 'easy-optin-flyout'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-12', 'essb3_ofof|of_scroll_close', __('Choose close type', 'easy-optin-flyout'), __('Choose how you wish to close the pop up form - with close icon or text link.', 'essb-optin-booster'), array("icon" => "Close Icon", "text" => "Text close link"));
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-12', 'essb3_ofof|of_scroll_closecolor', __('Close action color', 'easy-optin-flyout'), __('Customize close action color in case you change overlay color. Otherwise you can leave the default', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-12', 'essb3_ofof|of_scroll_closetext', __('Custom close text', 'easy-optin-flyout'), __('Enter custom close text when you choose text mode of close function.', 'easy-optin-flyout'), '');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::panel_end('optin', 'optin-12');

	ESSBOptionsStructureHelper::panel_start('optin', 'optin-12', __('Display on exit intent', 'easy-optin-flyout'), __('Automatically display selected opt-in form when user try to leave window', 'easy-optin-flyout'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'switch_id' => '', 'switch_on' => __('Yes', 'easy-optin-flyout'), 'switch_off' => __('No', 'easy-optin-flyout')));
	ESSBOptionsStructureHelper::field_switch('optin', 'optin-12', 'essb3_ofof|ofof_exit', __('Activate', 'easy-optin-flyout'), __('Set this option to Yes to use this event', 'easy-optin-flyout'), '', __('Yes', 'easy-optin-flyout'), __('No', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-12', 'essb3_ofof|of_exit_design', __('Choose design for that event', 'easy-optin-flyout'), __('Choose design which will be used for that event. You can have different design on each event', 'easy-optin-flyout'), essb_optin_designs());
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-12', 'essb3_ofof|of_exit_bgcolor', __('Overlay background color', 'easy-optin-flyout'), __('Change overlay background color that will be used for that event. You may need to replace the color if you customize design of chosen template.', 'easy-optin-flyout'), '', 'true');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_section_start_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::field_select_panel('optin', 'optin-12', 'essb3_ofof|of_exit_close', __('Choose close type', 'easy-optin-flyout'), __('Choose how you wish to close the pop up form - with close icon or text link.', 'essb-optin-booster'), array("icon" => "Close Icon", "text" => "Text close link"));
	ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-12', 'essb3_ofof|of_exit_closecolor', __('Close action color', 'easy-optin-flyout'), __('Customize close action color in case you change overlay color. Otherwise you can leave the default', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_textbox_panel('optin', 'optin-12', 'essb3_ofof|of_exit_closetext', __('Custom close text', 'easy-optin-flyout'), __('Enter custom close text when you choose text mode of close function.', 'easy-optin-flyout'), '');
	ESSBOptionsStructureHelper::field_section_end_panels('optin', 'optin-12', '', '');
	ESSBOptionsStructureHelper::panel_end('optin', 'optin-12');

	
	ESSBOptionsStructureHelper::field_switch('optin', 'optin-12', 'essb3_ofof|ofof_creditlink', __('Include credit link', 'easy-optin-flyout'), __('Include tiny credit link below your comments box to allow others know what you are using to generate Facebook Comments. Activate this option to show your appreciation for our efforts.', 'easy-optin-flyout'), '', __('Yes', 'easy-optin-flyout'), __('No', 'easy-optin-flyout'));
	ESSBOptionsStructureHelper::field_textbox('optin', 'optin-12', 'essb3_ofof|ofof_creditlink_user', __('Your Envato username', 'easy-optin-flyout'), __('Include credit link and earn 30% of users first purchase via Envato Affiliate Program. Learn more <a href="https://themeforest.net/affiliate_program" target="_blank">here</a> for Envato affiliate program.', 'easy-optin-flyout'), '');

	ESSBOptionsStructureHelper::panel_end('optin', 'optin-12');

ESSBOptionsStructureHelper::field_select('optin', 'optin-1', 'subscribe_connector', __('Choose your service', 'essb'), __('Select service that you wish to integrate with Easy Optin forms. Please note that for correct work you need to fill all required authorizations details for it below', 'essb'), $optin_connectors);
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_success', __('Redirect to page on successful subscribe', 'essb'), __('If you wish to redirect users to page (example: Thank you page) fill its URL here. If field is blank plugin will not redirect. The URL should be filled in full - example: https://socialsharingplugin.com/thank-you/', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-1', 'subscribe_success_new', __('Open successful redirect in a new window', 'essb'), __('Set to Yes if you wish the successful URL to appear in a popup instead of redirect on same page.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));


ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-mailchimp');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('MailChimp', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_mc_api', __('Mailchimp API key', 'essb'), __('<a href="http://kb.mailchimp.com/accounts/management/about-api-keys#Finding-or-generating-your-API-key" target="_blank">Find your API key</a>', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_mc_list', __('Mailchimp List ID', 'essb'), __('<a href="http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id" target="_blank">Find your List ID</a>', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('optin', 'optin-1');
ESSBOptionsStructureHelper::field_switch_panel('optin', 'optin-1', 'subscribe_mc_welcome', __('Send welcome message:', 'essb'), __('Allow Mailchimp send welcome mssage upon subscribe.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('optin', 'optin-1', 'subscribe_mc_double', __('Use double opt in:', 'essb'), __('The MailChimp double opt-in process is a two-step process, where a subscriber fills out your signup form and receives an email with a link to confirm their subscription. MailChimp also includes some additional thank you and confirmation pages you can customize with your brand and messaging.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch_panel('optin', 'optin-1', 'subscribe_mc_namefield', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('optin', 'optin-1');
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');

ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-getresponse');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('GetResponse', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_gr_api', __('GetReponse API key', 'essb'), __('<a href="http://support.getresponse.com/faq/where-i-find-api-key" target="_blank">Find your API key</a>', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_gr_list', __('GetReponse Campaign Name', 'essb'), __('<a href="http://support.getresponse.com/faq/can-i-change-the-name-of-a-campaign" target="_blank">Find your campaign name</a>', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');

ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-mailerlite');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('MailerLite', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_ml_api', __('MailerLite API key', 'essb'), __('Entery your MailerLite API key. To get your key visit this page <a href="https://app.mailerlite.com/subscribe/api" target="_blank">https://app.mailerlite.com/subscribe/api</a> and look under API key.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_ml_list', __('MailerLite List ID (Group ID)', 'essb'), __('Enter your list id (aka Group ID). To find your group id visit again the page for API key generation and you will see all list you have with their ids.', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');

ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-activecampaign');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('ActiveCampaign', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_ac_api_url', __('ActiveCampaign API URL', 'essb'), __('Enter your ActiveCampaign API URL. To get API URL please go to your ActiveCampaign Account >> My Settings >> Developer.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_ac_api', __('ActiveCampaign API Key', 'essb'), __('Enter your ActiveCampaign API Key. To get API Key please go to your ActiveCampaign Account >> My Settings >> Developer.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_ac_list', __('ActiveCapaign List ID', 'essb'), __('Entery your ActiveCampaign List ID. To get your list ID visit lists pages and copy ID that you see in browser when you open list ?listid=<yourid>.', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');


ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-campaignmonitor');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('CampaignMonitor', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_cm_api', __('CampaignMonitor API Key', 'essb'), __('Enter your Campaign Monitor API Key. You can get your API Key from the Account Settings page when logged into your Campaign Monitor account.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_cm_list', __('CampaignMonitor List ID', 'essb'), __('Enter your List ID. You can get List ID from the list editor page when logged into your Campaign Monitor account.', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');

ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-mymail');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('MyMail', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
$listOfOptions = array();
if (function_exists('mymail')) {
	$lists = mymail('lists')->get();
	foreach ($lists as $list) {
		if (function_exists('mymail')) $id = $list->ID;
		else $id = $list->term_id;

		$listOfOptions[$id] = $list->name;
	}
}
ESSBOptionsStructureHelper::field_select('optin', 'optin-1', 'subscribe_mm_list', __('MyMail List', 'essb'), __('Select your list. Please ensure that MyMail plugin is installed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch_panel('optin', 'optin-1', 'subscribe_mm_double', __('Use pending state for new subscribers', 'essb'), __('Use this to setup Pending state of all your new subscribers and manually review at later.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');


ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-mailpoet');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('MailPoet', 'essb'), __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
$listOfOptions = array();
try {
	if (class_exists('WYSIJA')) {
		$model_list = WYSIJA::get('list', 'model');
		$mailpoet_lists = $model_list->get(array('name', 'list_id'), array('is_enabled'=>1));
		if (sizeof($mailpoet_lists) > 0) {
			foreach ($mailpoet_lists as $list) {
				$listOfOptions[$list['list_id']] = $list['name'];
			}
		}
	}
	if (class_exists('\MailPoet\API\API')) {
		$subscription_lists = \MailPoet\API\API::MP('v1')->getLists();
		if (is_array($subscription_lists)) {
			foreach ($subscription_lists as $list) {
				$listOfOptions[$list['id']] = $list['name'];
			}
		}
	}
}
catch (Exception $e) {
	
}

ESSBOptionsStructureHelper::field_select('optin', 'optin-1', 'subscribe_mp_list', __('MailPoet List', 'essb'), __('Select your list. Please ensure that MailPoet plugin is installed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');

ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-sendinblue');
ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', __('SendinBlue', 'essb'), __('SendinBlue mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_sib_api', __('SendinBlue API Key', 'essb'), __('Enter your SendinBlue API Key. You can get your API Key from <a href="https://my.sendinblue.com/advanced/apikey" target="_blank">here</a> (API key version 2.0).', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', 'subscribe_sib_list', __('SendinBlue List ID', 'essb'), __('Enter your list ID.', 'essb'));
ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');

$custom_connectors = array();
$custom_connectors_options = array();

if (has_filter('essb_external_subscribe_connectors')) {
	$custom_connectors = apply_filters('essb_external_subscribe_connectors', $custom_connectors);
}
if (has_filter('essb_external_subscribe_connectors_options')) {
	$custom_connectors_options = apply_filters('essb_external_subscribe_connectors_options', $custom_connectors_options);
}

foreach ($custom_connectors as $connector => $service_name) {
	if (isset($custom_connectors_options[$connector])) {
		ESSBOptionsStructureHelper::holder_start('optin', 'optin-1', 'essb-subscribe-connector', 'essb-subscribe-connector-'.$connector);
		ESSBOptionsStructureHelper::panel_start('optin', 'optin-1', $service_name, __('Configure mailing list service access details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle"));
		
		foreach ($custom_connectors_options[$connector] as $field => $settings) {
			$type = isset($settings['type']) ? $settings['type'] : 'text';
			$title = isset($settings['title']) ? $settings['title'] : '';
			$desc = isset($settings['desc']) ? $settings['desc'] : '';
			$values = isset($settings['values']) ? $settings['values'] : array();
			
			if ($type == 'text') {
				ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-1', $field, $title, $desc);				
			}
			if ($type == 'switch') {
				ESSBOptionsStructureHelper::field_switch('optin', 'optin-1', $field, $title, $desc, '', __('Yes', 'essb'), __('No', 'essb'));				
			}
			
			if ($type == 'select') {
				ESSBOptionsStructureHelper::field_select('optin', 'optin-1', $field, $title, $desc, $values);
			}
		}
		
		ESSBOptionsStructureHelper::panel_end('optin', 'optin-1');
		ESSBOptionsStructureHelper::holder_end('optin', 'optin-1');
		
	}
}


ESSBOptionsStructureHelper::field_heading('optin', 'optin-2', 'heading5', __('Customize Design #1', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-2', 'subscribe_mc_namefield', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-2', 'subscribe_mc_title', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-2', 'subscribe_mc_text', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-2', 'subscribe_mc_name', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-2', 'subscribe_mc_email', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-2', 'subscribe_mc_button', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-2', 'subscribe_mc_footer', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-2', 'subscribe_mc_success', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-2', 'subscribe_mc_error', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-2', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-2', 'activate_mailchimp_customizer', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-2', 'customizer_subscribe_bgcolor1', __('Background color', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-2', 'customizer_subscribe_textcolor1', __('Text color', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-2', 'customizer_subscribe_hovercolor1', __('Accent color', 'essb'), __('Replace form accent color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-2', 'customizer_subscribe_hovertextcolor1', __('Accent text color', 'essb'), __('Replace form accent text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-2', 'customizer_subscribe_emailcolor1', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-2', 'customizer_subscribe_noborder1', __('Remove top border of form', 'essb'), __('Activate this option if you wish to remove the tiny top border from the top of form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));


ESSBOptionsStructureHelper::field_heading('optin', 'optin-3', 'heading5', __('Customize Design #2', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-3', 'subscribe_mc_namefield2', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-3', 'subscribe_mc_title2', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-3', 'subscribe_mc_text2', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-3', 'subscribe_mc_name2', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-3', 'subscribe_mc_email2', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-3', 'subscribe_mc_button2', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-3', 'subscribe_mc_footer2', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-3', 'subscribe_mc_success2', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-3', 'subscribe_mc_error2', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-3', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-3', 'activate_mailchimp_customizer2', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-3', 'customizer_subscribe_bgcolor2', __('Background color', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-3', 'customizer_subscribe_textcolor2', __('Text color', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-3', 'customizer_subscribe_hovercolor2', __('Accent color', 'essb'), __('Replace form accent color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-3', 'customizer_subscribe_hovertextcolor2', __('Accent text color', 'essb'), __('Replace form accent text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-3', 'customizer_subscribe_emailcolor2', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-3', 'customizer_subscribe_noborder2', __('Remove border of form', 'essb'), __('Activate this option if you wish to remove the tiny border from the form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-4', 'heading5', __('Customize Design #3', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-4', 'subscribe_mc_namefield3', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_file('optin', 'optin-4', 'subscribe_mc_image3', __('Choose image', 'essb'), __('Image parameter is optional but if you choose such it will appear in the top part of form on the left or right side of content.', 'essb'));
$optin_connectors = array("left" => __("Left side", "essb"), "right" => __("Right side", "essb"));
ESSBOptionsStructureHelper::field_select('optin', 'optin-4', 'subscribe_mc_imagealign3', __('Image will appear on:', 'essb'), __('Choose where image will appear according to your top content', 'essb'), $optin_connectors);
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-4', 'subscribe_mc_title3', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-4', 'subscribe_mc_text3', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-4', 'subscribe_mc_name3', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-4', 'subscribe_mc_email3', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-4', 'subscribe_mc_button3', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-4', 'subscribe_mc_footer3', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-4', 'subscribe_mc_success3', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-4', 'subscribe_mc_error3', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-4', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-4', 'activate_mailchimp_customizer3', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-4', 'customizer_subscribe_bgcolor3', __('Background color top area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-4', 'customizer_subscribe_textcolor3', __('Text color top area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-4', 'customizer_subscribe_bgcolor3_bottom', __('Background color bottom area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-4', 'customizer_subscribe_textcolor3_bottom', __('Text color bottom area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-4', 'customizer_subscribe_hovercolor3', __('Accent color', 'essb'), __('Replace form accent color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-4', 'customizer_subscribe_hovertextcolor3', __('Accent text color', 'essb'), __('Replace form accent text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-4', 'customizer_subscribe_emailcolor3', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-4', 'customizer_subscribe_noborder3', __('Remove border of form', 'essb'), __('Activate this option if you wish to remove the tiny border from the form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-5', 'heading5', __('Customize Design #4', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-5', 'subscribe_mc_namefield4', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_file('optin', 'optin-5', 'subscribe_mc_image4', __('Choose image', 'essb'), __('Image parameter is optional but if you choose such it will appear in the top part of form on the left or right side of content.', 'essb'));
$optin_connectors = array("left" => __("Left side", "essb"), "right" => __("Right side", "essb"));
ESSBOptionsStructureHelper::field_select('optin', 'optin-5', 'subscribe_mc_imagealign4', __('Image will appear on:', 'essb'), __('Choose where image will appear according to your top content', 'essb'), $optin_connectors);
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-5', 'subscribe_mc_title4', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-5', 'subscribe_mc_text4', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-5', 'subscribe_mc_name4', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-5', 'subscribe_mc_email4', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-5', 'subscribe_mc_button4', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-5', 'subscribe_mc_footer4', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-5', 'subscribe_mc_success4', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-5', 'subscribe_mc_error4', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-5', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-5', 'activate_mailchimp_customizer4', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-5', 'customizer_subscribe_bgcolor4', __('Background color of content area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-5', 'customizer_subscribe_textcolor4', __('Text color of content area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-5', 'customizer_subscribe_bgcolor4_bottom', __('Background color subscribe area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-5', 'customizer_subscribe_textcolor4_bottom', __('Text color subscribe area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-5', 'customizer_subscribe_hovercolor4', __('Accent color', 'essb'), __('Replace form accent color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-5', 'customizer_subscribe_hovertextcolor4', __('Accent text color', 'essb'), __('Replace form accent text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-5', 'customizer_subscribe_emailcolor4', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-5', 'customizer_subscribe_noborder4', __('Remove border of form', 'essb'), __('Activate this option if you wish to remove the tiny border from the form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-6', 'heading5', __('Customize Design #5', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-6', 'subscribe_mc_namefield5', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-6', 'subscribe_mc_title5', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-6', 'subscribe_mc_text5', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-6', 'subscribe_mc_name5', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-6', 'subscribe_mc_email5', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-6', 'subscribe_mc_button5', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-6', 'subscribe_mc_footer5', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-6', 'subscribe_mc_success5', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-6', 'subscribe_mc_error5', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-6', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-6', 'activate_mailchimp_customizer5', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-6', 'customizer_subscribe_bgcolor5', __('Background color of content area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-6', 'customizer_subscribe_textcolor5', __('Text color of content area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-6', 'customizer_subscribe_bgcolor5_bottom', __('Background color subscribe area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-6', 'customizer_subscribe_textcolor5_bottom', __('Text color subscribe area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-6', 'customizer_subscribe_hovercolor5', __('Accent color', 'essb'), __('Replace form accent color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-6', 'customizer_subscribe_hovertextcolor5', __('Accent text color', 'essb'), __('Replace form accent text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-6', 'customizer_subscribe_emailcolor5', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-6', 'customizer_subscribe_noborder5', __('Remove border of form', 'essb'), __('Activate this option if you wish to remove the tiny border from the form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));


ESSBOptionsStructureHelper::field_heading('optin', 'optin-7', 'heading5', __('Customize Design #6', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-7', 'subscribe_mc_namefield6', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_file('optin', 'optin-7', 'subscribe_mc_image6', __('Choose image', 'essb'), __('Image parameter is optional but if you choose such it will appear in the top part of form on the left or right side of content.', 'essb'));
$optin_connectors = array("left" => __("Left side", "essb"), "right" => __("Right side", "essb"));
ESSBOptionsStructureHelper::field_select('optin', 'optin-7', 'subscribe_mc_imagealign6', __('Image will appear on:', 'essb'), __('Choose where image will appear according to your top content', 'essb'), $optin_connectors);
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-7', 'subscribe_mc_title6', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-7', 'subscribe_mc_text6', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-7', 'subscribe_mc_name6', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-7', 'subscribe_mc_email6', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-7', 'subscribe_mc_button6', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-7', 'subscribe_mc_footer6', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-7', 'subscribe_mc_success6', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-7', 'subscribe_mc_error6', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-7', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-7', 'activate_mailchimp_customizer6', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-7', 'customizer_subscribe_bgcolor6', __('Background color of content area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-7', 'customizer_subscribe_textcolor6', __('Text color of content area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-7', 'customizer_subscribe_bgcolor6_bottom', __('Background color subscribe area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-7', 'customizer_subscribe_textcolor6_bottom', __('Text color subscribe area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-7', 'customizer_subscribe_hovercolor6', __('Accent color', 'essb'), __('Replace form accent color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-7', 'customizer_subscribe_hovertextcolor6', __('Accent text color', 'essb'), __('Replace form accent text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-7', 'customizer_subscribe_emailcolor6', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-7', 'customizer_subscribe_noborder6', __('Remove border of form', 'essb'), __('Activate this option if you wish to remove the tiny border from the form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-8', 'heading5', __('Customize Design #7', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-8', 'subscribe_mc_namefield7', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_file('optin', 'optin-8', 'subscribe_mc_image7', __('Choose image', 'essb'), __('Image parameter is optional but if you choose such it will appear in the top part of form on the left or right side of content.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-8', 'subscribe_mc_title7', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-8', 'subscribe_mc_text7', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-8', 'subscribe_mc_name7', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-8', 'subscribe_mc_email7', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-8', 'subscribe_mc_button7', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-8', 'subscribe_mc_footer7', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-8', 'subscribe_mc_success7', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-8', 'subscribe_mc_error7', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-8', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-8', 'activate_mailchimp_customizer7', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-8', 'customizer_subscribe_bgcolor7', __('Background color of content area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-8', 'customizer_subscribe_textcolor7', __('Text color of content area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-8', 'customizer_subscribe_bgcolor7_bottom', __('Background color subscribe area', 'essb'), __('Replace form background color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-8', 'customizer_subscribe_textcolor7_bottom', __('Text color subscribe area', 'essb'), __('Replace form text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-8', 'customizer_subscribe_hovercolor7', __('Accent color', 'essb'), __('Replace form accent color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-8', 'customizer_subscribe_hovertextcolor7', __('Accent text color', 'essb'), __('Replace form accent text color', 'essb'));
ESSBOptionsStructureHelper::field_color('optin', 'optin-8', 'customizer_subscribe_emailcolor7', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-8', 'customizer_subscribe_noborder7', __('Remove border of form', 'essb'), __('Activate this option if you wish to remove the tiny border from the form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));


ESSBOptionsStructureHelper::field_heading('optin', 'optin-9', 'heading5', __('Customize Design #8', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-9', 'subscribe_mc_namefield8', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-9', 'subscribe_mc_title8', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-9', 'subscribe_mc_text8', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-9', 'subscribe_mc_name8', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-9', 'subscribe_mc_email8', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-9', 'subscribe_mc_button8', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-9', 'subscribe_mc_footer8', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-9', 'subscribe_mc_success8', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-9', 'subscribe_mc_error8', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-9', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-9', 'activate_mailchimp_customizer8', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('optin', 'optin-9');
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-9', 'customizer_subscribe_bgcolor8', __('Background Color #1', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-9', 'customizer_subscribe_bgcolor28', __('Background Color #2', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-9', 'customizer_subscribe_textcolor8', __('Text color of content area', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-9', 'customizer_subscribe_bgcolor8_bottom', __('Email/Name Fields Background Overlay', 'essb'), __('', 'essb'), '', 'true');
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-9', 'customizer_subscribe_textcolor8_bottom', __('Text color of Email/Name fields', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-9', 'customizer_subscribe_buttoncolor8', __('Subscribe button background', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-9', 'customizer_subscribe_buttontextcolor8', __('Subscribe button text color', 'essb'), __('', 'essb'));
//ESSBOptionsStructureHelper::field_color('optin', 'optin-9', 'customizer_subscribe_emailcolor8', __('Email field background color', 'essb'), __('Replace email field background color', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('optin', 'optin-9');

ESSBOptionsStructureHelper::field_heading('optin', 'optin-10', 'heading5', __('Customize Design #9', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-10', 'subscribe_mc_namefield9', __('Display name field:', 'essb'), __('Activate this option to allow customers enter their name.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-10', 'subscribe_mc_title9', __('Title', 'essb'), __('Customize default title: Join our list', 'essb'));
ESSBOptionsStructureHelper::field_editor('optin', 'optin-10', 'subscribe_mc_text9', __('Text', 'essb'), __('Customize default text: Subscribe to our mailing list and get interesting stuff and updates to your email inbox.', 'essb'), 'htmlmixed');
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-10', 'subscribe_mc_name9', __('Name placeholder text', 'essb'), __('Customize default name placeholder text: Enter your name here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-10', 'subscribe_mc_email9', __('Email placeholder text', 'essb'), __('Customize default email placeholder text: Enter your email here', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-10', 'subscribe_mc_button9', __('Subscribe button text', 'essb'), __('Customize default button text: Sign Up Now', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-10', 'subscribe_mc_footer9', __('Footer text', 'essb'), __('Customize default footer text: We respect your privacy and take protecting it seriously', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-10', 'subscribe_mc_success9', __('Success messsage', 'essb'), __('Customize Success Message: Thank you for subscribing.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('optin', 'optin-10', 'subscribe_mc_error9', __('Error message', 'essb'), __('Customize Error Message: Something went wrong.', 'essb'));

ESSBOptionsStructureHelper::field_heading('optin', 'optin-10', 'heading4', __('Style Customization', 'essb'));
ESSBOptionsStructureHelper::field_switch('optin', 'optin-10', 'activate_mailchimp_customizer9', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('optin', 'optin-10');
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-10', 'customizer_subscribe_bgcolor9', __('Background Color', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-10', 'customizer_subscribe_textcolor9', __('Text color of content area', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-10', 'customizer_subscribe_accent9', __('Accent color', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_color_panel('optin', 'optin-10', 'customizer_subscribe_button9', __('Button text color', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('optin', 'optin-10');