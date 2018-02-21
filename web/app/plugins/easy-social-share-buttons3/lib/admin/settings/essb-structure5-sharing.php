<?php
//ESSBOptionsStructureHelper::menu_item('social', 'share', __('Share Buttons', 'essb'), ' ti-sharethis', 'activate_first', 'share-1');
//ESSBOptionsStructureHelper::submenu_item('social', 'share-1', __('Networks', 'essb'));
//ESSBOptionsStructureHelper::submenu_item('social', 'share-2', __('Template & Style', 'essb'));

ESSBOptionsStructureHelper::menu_item('social', 'share-1', __('Networks', 'essb'), ' ti-sharethis');
ESSBOptionsStructureHelper::menu_item('social', 'share-2', __('Template & Style', 'essb'), ' ti-sharethis');


ESSBOptionsStructureHelper::menu_item('social', 'sharecnt', __('Share Counters Setup', 'essb'), ' ti-stats-up');
if (!essb_option_bool_value('deactivate_module_shareoptimize')) {
	ESSBOptionsStructureHelper::menu_item('social', 'optimize', __('Sharing Optimization', 'essb'), ' ti-new-window');
}
if (!essb_option_bool_value('deactivate_module_aftershare')) {
	ESSBOptionsStructureHelper::menu_item('social', 'after-share', __('After Share Events', 'essb'), ' ti-layout-cta-left', 'activate_first', 'after-share-1');
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-1', __('Action Type', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-2', __('Like/Follow Options', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-3', __('Custom HTML Message', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-4', __('Custom Code', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('social', 'after-share-5', __('Optin form from Easy Optin', 'essb'));
}

if (!essb_option_bool_value('deactivate_module_shorturl')) {
	ESSBOptionsStructureHelper::menu_item('social', 'shorturl', __('Short URL', 'essb'), ' ti-new-window');
}

if (!essb_option_bool_value('deactivate_module_analytics')) {
	ESSBOptionsStructureHelper::menu_item('social', 'analytics', __('Analytics', 'essb'), ' ti-stats-up');
}

if (!essb_option_bool_value('deactivate_module_metrics')) {
	ESSBOptionsStructureHelper::menu_item('social', 'social-metrics', __('Social Metrics', 'essb'), ' ti-new-window');
}


if (!essb_option_bool_value('deactivate_module_affiliate')) {
	ESSBOptionsStructureHelper::menu_item('social', 'affiliate', __('Affiliate Integration', 'essb'), ' ti-new-window');
}

if (!essb_option_bool_value('deactivate_module_customshare')) {
	ESSBOptionsStructureHelper::menu_item('social', 'customshare', __('Custom Share', 'essb'), ' ti-new-window');
}

if (!essb_option_bool_value('deactivate_module_message')) {
	ESSBOptionsStructureHelper::menu_item('social', 'message', __('Message Before/Above Buttons', 'essb'), ' ti-new-window');
}

if (!essb_option_bool_value('deactivate_module_conversions')) {
	ESSBOptionsStructureHelper::menu_item('conversions', 'share', __('Share Buttons', 'essb'), ' ti-new-window');
	ESSBOptionsStructureHelper::menu_item('conversions', 'subscribe', __('Subscribe Forms', 'essb'), ' ti-new-window');
	
}

// share-1 stucture
ESSBOptionsStructureHelper::hint('social', 'share-1', __('Additional network settings are available', 'essb'), __('Some of social networks has additional options that you can use to personalize their function. All that options you can find grouped by social network inside <b>Additional Network Options</b> tab.', 'essb'), 'fa24 ti-widget', 'glow');

ESSBOptionsStructureHelper::tabs_start('social', 'share-1', 'buttons-tabs', array('<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Social Networks', 'essb'), '<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Additional Network Options', 'essb')), 'false', 'true');
ESSBOptionsStructureHelper::tab_start('social', 'share-1', 'buttons-tabs-0', 'true');
ESSBOptionsStructureHelper::field_func('social', 'share-1', 'essb5_custom_position_networks', '', '');

ESSBOptionsStructureHelper::field_func('social', 'share-1', 'essb5_main_network_selection', '', '');
$network_sort_order = array("" => __("User provided order", "essb"), "shares" => __("Sort dynamically by number of shares", "essb"));
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'user_sort', __('Share buttons ordering', 'essb'), __('If you decide to use dinamically order please note that it will not work with real time share counters.', 'essb'), $network_sort_order);

ESSBOptionsStructureHelper::tab_end('social', 'share-1');

ESSBOptionsStructureHelper::tab_start('social', 'share-1', 'buttons-tabs-1');
ESSBOptionsStructureHelper::hint('social', 'share-1', '', __('Few social networks has additional network options. Below you can make adjustments for all networks that you will use on your site.', 'essb'));

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('More Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_more', array("mode" => "toggle", 'state' => 'closed'));
$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up", "4" => "Display all active networks after more button in popup" );
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'more_button_func', __('More button', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands());
$more_options = array ("plus" => "Plus icon", "dots" => "Dots icon" );

$select_values = array('plus' => array('title' => 'Plus Icon', 'content' => '<i class="essb_icon_more"></i>'),
		'dots' => array('title' => 'Dots Icon', 'content' => '<i class="essb_icon_more_dots"></i>'));
ESSBOptionsStructureHelper::field_toggle('social', 'share-1', 'more_button_icon', __('More button icon', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $select_values);


ESSBOptionsStructureHelper::field_section_start_panels('social', 'share-1', '', '');
$more_options = array ("" => "Classic Style", "modern" => "Modern Style" );
ESSBOptionsStructureHelper::field_select_panel('social', 'share-1', 'more_button_popstyle', __('More button pop up style', 'essb'), __('Choose the style of your pop up with social networks', 'essb'), $more_options);
ESSBOptionsStructureHelper::field_select_panel('social', 'share-1', 'more_button_poptemplate', __('Template of social networks in more pop up', 'essb'), __('Choose different tempate of buttons in pop up with share buttons or leave usage of default template', 'essb'), essb_available_tempaltes4(true));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'share-1');
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Share Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_share', array("mode" => "toggle", 'state' => 'closed'));
//$more_options = array ("1" => "Display all active networks after share button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up" );
$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as pop up", "3" => "Display only active social networks as pop up", "4" => "Display all active networks after more button in popup" );
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'share_button_func', __('Share button function', 'essb'), __('Select networks that you wish to appear in your list. With drag and drop you can rearrange them.', 'essb'), essb_available_more_button_commands());
ESSBOptionsStructureHelper::field_section_start_panels('social', 'share-1', '', '');
$more_options = array ("" => "Classic Style", "modern" => "Modern Style" );
ESSBOptionsStructureHelper::field_select_panel('social', 'share-1', 'share_button_popstyle', __('More button pop up style', 'essb'), __('Choose the style of your pop up with social networks', 'essb'), $more_options);
ESSBOptionsStructureHelper::field_select_panel('social', 'share-1', 'share_button_poptemplate', __('Template of social networks in more pop up', 'essb'), __('Choose different tempate of buttons in pop up with share buttons or leave usage of default template', 'essb'), essb_available_tempaltes4(true));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'share-1');


$select_values = array('plus' => array('title' => '', 'content' => '<i class="essb_icon_more"></i>'),
		'dots' => array('title' => '', 'content' => '<i class="essb_icon_more_dots"></i>'),
				'share' => array('title' => '', 'content' => '<i class="essb_icon_share"></i>'),
				'share-alt-square' => array('title' => '', 'content' => '<i class="essb_icon_share-alt-square"></i>'),
		'share-alt' => array('title' => '', 'content' => '<i class="essb_icon_share-alt"></i>'),
		'share-tiny' => array('title' => '', 'content' => '<i class="essb_icon_share-tiny"></i>'),
		'share-outline' => array('title' => '', 'content' => '<i class="essb_icon_share-outline"></i>')
		);
ESSBOptionsStructureHelper::field_toggle('social', 'share-1', 'share_button_icon', __('Share button icon', 'essb'), __('Choose the share button icon you will use (default is share if nothing is selected)', 'essb'), $select_values);


$more_options = array ("" => "Default from settings (like other share buttons)", "icon" => "Icon only", "button" => "Button", "text" => "Text only" );
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'share_button_style', __('Share button style', 'essb'), __('Select more button icon style. You can choose from default + symbol or dots symbol', 'essb'), $more_options);

$share_counter_pos = array("hidden" => "No counter", "inside" => "Inside button without text", "insidename" => "Inside button after text", "insidebeforename" => "Inside button before text", "topn" => "Top", "bottom" => "Bottom");
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'share_button_counter', __('Display total counter with the following position', 'essb'), __('Choose where you wish to display total counter of shares assigned with this button. <br/> To view total counter you need to have share counters active and they should not be running in real time mode. Also you need to have your share button set with style button. When you use share button with counter we highly recommend to hide total counter by setting position to be hidden - this will avoid having two set of total value on screen.', 'essb'), $share_counter_pos);

ESSBOptionsStructureHelper::panel_end('social', 'share-1');


ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Twitter', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_twitter', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_section_start_panels('social', 'share-1', __('Username and Hashtags', 'essb'), __('Provide default Twitter username and hashtags to be included into messages.', 'essb'), 'yes');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-1', 'twitteruser', __('Username to be mentioned:', 'essb'), __('If you wish a twitter username to be mentioned in tweet write it here. Enter your username without @ - example twittername. This text will be appended to tweet message at the end. Please note that if you activate custom share address option this will be added to custom share message.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-1', 'twitterhashtags', __('Hashtags to be added:', 'essb'), __('If you wish hashtags to be added to message write them here. You can set one or more (if more then one separate them with comma (,)) Example: demotag1,demotag2.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('social', 'share-1', 'twitter_message_tags_to_hashtags', __('Use post tags as hashtags', 'essb'), __('Activate this option to use your current post tags as hashtags. When this option is active the default hashtags will be replaced with post tags when there are such post tags.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'share-1');

ESSBOptionsStructureHelper::field_section_start('social', 'share-1', __('Twitter message optimization', 'essb'), __('Twitter message optimization allows you to truncate your message if it exceeds the 240 characters length of message.', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'twitter_message_optimize', __('Activate', 'essb'), __('Activate message optimization.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("1" => "Remove hashtags, remove via username, truncate message", "2" => "Remove via username, remove hashtags, truncate message", "3" => "Remove via username, truncate message", "4" => "Remove hashtags, truncate message", "5" => "Truncate only message");
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'twitter_message_optimize_method', __('Method of optimization', 'essb'), __('Choose the order of components to be removed till reaching the limit of characters', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'twitter_message_optimize_dots', __('Add read more dots when truncate message', 'essb'), __('Add ... (read more dots) to truncated tweets.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'share-1');
ESSBOptionsStructureHelper::panel_end('social', 'share-1');


ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Facebook', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_facebook', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_section_start('social', 'share-1', __('Facebook Advanced Sharing', 'essb'), __('For proper work of advanced Facebook sharing you need to provide application id. If you don\'t have you need to create one. To create Facebook Application use this link: http://developers.facebook.com/apps/', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'facebookadvanced', __('Activate', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'share-1', 'facebookadvancedappid', __('Facebook Application ID:', 'essb'), '');
ESSBOptionsStructureHelper::field_section_end('social', 'share-1');
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Facebook Messenger', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_messenger', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'share-1', 'fbmessengerapp', __('Facebook Application ID:', 'essb'), __('Facebook Application ID connected with your site is required to make messenger sharing work. If you use Facebook Advanced Sharing feature then it is not needed to fill this parameter as application is already applied into Facebook Advanced Sharing settings', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('VKontakte', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_vk', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'vkontakte_fullshare', __('Send all sharable details for post/page:', 'essb'), __('VKontakte like most of social networks read data from socail share optimization tags that you have on page. In case when you share nothing appears please activate this option to allow plugin send all details to VKontakte. Please note that if this option is active the details from Social Share Optimization will not appear in share dialog!', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'share-1');


ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Pinterest', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_pinterest', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::structure_row_start('social', 'share-1');
ESSBOptionsStructureHelper::structure_section_start('social', 'share-1', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'pinterest_sniff_disable', __('Disable Pinterest Pin any image:', 'essb'), __('If you disable Pinterest sniff for images plugin will use for share post featured image or custom share image you provide in post settings.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'share-1');
ESSBOptionsStructureHelper::structure_section_start('social', 'share-1', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'pinterest_save_anyimage', __('Include Pinterest Save Any Image Button:', 'essb'), __('Use this option to include save of any image on site to Pinterest. That is the quick image share function. If you wish to use more than one social network than you can take a look of the On Media sharing function inside Where to Display.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'share-1');
ESSBOptionsStructureHelper::structure_row_end('social', 'share-1');
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Subscribe Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_subscribe', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::hint('social', 'share-1', __('', 'essb'), __('If you choose to use the build in opt-in module Easy Optin please pay attention of settings in <b>Subscribe Forms</b> menu. In that place you will find all required to setup options for mailing list service connection and you can also customize the design you choose.', 'essb'), 'fa21 mr10 fa fa-envelope-o');

$listOfValues = array ("form" => "Open content box", "link" => "Open subscribe link", "mailchimp" => "Easy Optin Subscribe Form (Ready made forms with automatic service integrations)" );
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'subscribe_function', __('Specify subscribe button function', 'essb'), __('Specify if the subscribe button is opening a content box below the button or if the button is linked to the "subscribe url" below.', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'share-1', 'subscribe_link', __('Subscribe URL', 'essb'), __('Link the Subscribe button to this URL. This can be the url to your subscribe page, facebook fanpage, RSS feed etc. e.g. http://yoursite.com/subscribe', 'essb'));
ESSBOptionsStructureHelper::field_editor('social', 'share-1', 'subscribe_content', __('Subscribe content box', 'essb'), __('Define the content of the opening toggle subscribe window here. Use formulars, like button, links or any other text. Shortcodes are supported, e.g.: [contact-form-7]. Note that if you use subscribe button outside content display positions content will open as popup', 'essb'), 'htmlmixed');
$listOfValues = essb_optin_designs();
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'subscribe_optin_design', __('Specify subscribe button Easy Optin design for content', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'subscribe_optin_design_popup', __('Specify subscribe button Easy Optin design for popup', 'essb'), __('Choose default design that you will use with Easy Optin for content display methods', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::panel_end('social', 'share-1');


ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Email', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_mail', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_section_start('social', 'share-1', __('Email button send options', 'essb'), __('', 'essb'), '');
$listOfValues = array ("form" => "Send mail using pop up form", "link" => "Send mail using mailto link and user mail client" );
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'mail_function', __('Send to mail button function', 'essb'), __('Choose how you wish mail button to operate. By default it uses the build in pop up window with sendmail option but you can change this to link option to force use of client mail program.', 'essb'), $listOfValues);
//ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'use_wpmandrill', __('Use wpMandrill for send mail', 'essb'), __('To be able to send messages with wpMandrill you need to have plugin installed.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'share-1', 'mail_copyaddress', __('Send copy of all messages to', 'essb'), __('Provide email address if you wish to get copy of each message that is sent via form', 'essb'));
//ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'mail_inline_code', __('Append inline mail send code', 'essb'), __('Activate this option if you use Initite scroll plugin and mail button do not work', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'share-1');

ESSBOptionsStructureHelper::field_section_start('social', 'share-1', __('Pop up mail form options', 'essb'), __('', 'essb'), '');
$listOfValues = array ("host" => "Using host mail function", "wp" => "Using WordPress mail function" );
//ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'mail_disable_editmessage', __('Disable editing of mail message', 'essb'), __('Activate this option to prevent users from changing the default message.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_select('social', 'share-1', 'mail_function_command', __('Use the following command to send mails when form is used', 'essb'), __('Choose the default function you will use to send mails when mail form is active. If you use external plugin in WordPress for send mail (like Easy WP SMTP) you need to choose WordPress mail function to get your messages sent.', 'essb'), $listOfValues);
$listOfValues = array ("level1" => "Advanced security check", "level2" => "Basic security check" );
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'mail_function_security', __('Use the following security check when form is used', 'essb'), __('Security check is made to prevent unauthorized access to send mail function of plugin. The default option is to use advanced security check but if you get message invalid security key during send process switch to lower level check - Basic security check.', 'essb'), $listOfValues);
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'mail_popup_mobile', __('Allow usage of pop up mail form on mobile devices', 'essb'), __('Activate this option to allow usage of pop up form when site is browsed with mobile device. Default setting is to use build in mobile device mail application.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'share-1');


ESSBOptionsStructureHelper::field_section_start('social', 'share-1', __('Antispam Captcha Verification', 'essb'), __('Fill both fields for question and answer to prevent sending message without entering the correct answer.', 'essb'), '');
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'share-1', 'mail_captcha', __('Captcha Message', 'essb'), __('Enter captcha question you wish to ask users to validate that they are human.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'share-1', 'mail_captcha_answer', __('Captcha Answer', 'essb'), __('Enter answer you wish users to put to verify them.', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'share-1');

ESSBOptionsStructureHelper::field_section_start('social', 'share-1', __('Customize default mail message', 'essb'), __('You can customize texts to display when visitors share your content by mail button. To perform customization, you can use %%title%%, %%siteurl%%, %%permalink%% or %%image%% variables.', 'essb'), '');
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'share-1', 'mail_subject', __('Subject', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textarea('social', 'share-1', 'mail_body', __('Message', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'mail_popup_preview', __('Display preview of mail message', 'essb'), __('Include non editable preview of mail message in the popup form.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'mail_popup_edit', __('Allow custom user message', 'essb'), __('Activate this option to allow user include own custom message along with default.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'share-1');
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Print', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_print', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'print_use_printfriendly', __('Use for printing printfriendly.com', 'essb'), __('Activate that option to use printfriendly.com as printing service instead of default print function of browser', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('StumbleUpon', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_stumbleupon', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'stumble_noshortlink', __('Do not generate shortlinks', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Buffer', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_buffer', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'buffer_twitter_user', __('Add Twitter username to buffer shares', 'essb'), __('Append also Twitter username into Buffer shares', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Telegram', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_telegram', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('social', 'share-1', 'telegram_alternative', __('Use alternative Telegram share', 'essb'), __('Alternative Telegram share method uses Telegram website to share data instead of direct call to mobile application. This method currently supports share to web application too.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Flattr', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_flattr', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_textbox('social', 'share-1', 'flattr_username', __('Flattr Username', 'essb'), __('The Flattr account to which the buttons will be assigned.', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'share-1', 'flattr_tags', __('Additional Flattr tags for your posts', 'essb'), __('Comma separated list of additional tags to use in Flattr buttons.', 'essb'));
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'flattr_cat', __('Default category for your posts', 'essb'), __('', 'essb'), ESSBNetworks_Flattr::getCategories());
ESSBOptionsStructureHelper::field_select('social', 'share-1', 'flattr_lang', __('Default language for your posts', 'essb'), __('', 'essb'), ESSBNetworks_Flattr::getLanguages());
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::panel_start('social', 'share-1', __('Comment Button', 'essb'), __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_comments', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_textbox('social', 'share-1', 'comments_address', __('Comments button address', 'essb'), __('If you use external comment system like Disqus you may need to personalize address to comments element (default is #comments).', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'share-1');

ESSBOptionsStructureHelper::tab_end('social', 'share-1');
ESSBOptionsStructureHelper::tabs_end('social', 'share-1');

// share-2 button styles
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_custom_position_settings', '', '');

ESSBOptionsStructureHelper::structure_row_start('social', 'share-2');
ESSBOptionsStructureHelper::structure_section_start('social', 'share-2', 'c4');

ESSBOptionsStructureHelper::title('social', 'share-2', __('Template', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_main_template_selection', '', '');

ESSBOptionsStructureHelper::title('social', 'share-2', __('Buttons style', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_main_buttonstyle_selection', '', '');
//essb5_main_alignment_choose
ESSBOptionsStructureHelper::title('social', 'share-2', __('Buttons align', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_main_alignment_choose', '', '');

ESSBOptionsStructureHelper::field_switch('social', 'share-2', 'nospace', __('Without space between buttons', 'essb'), __('Activate this option if you wish to connect share buttons without any space between them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
//essb5_main_animation_selection
ESSBOptionsStructureHelper::title('social', 'share-2', __('Animate share buttons', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_main_animation_selection', '', '');


ESSBOptionsStructureHelper::structure_section_end('social', 'share-2');
ESSBOptionsStructureHelper::structure_section_start('social', 'share-2', 'c4');

ESSBOptionsStructureHelper::field_switch('social', 'share-2', 'show_counter', __('Display counter of sharing', 'essb'), __('Activate display of share counters.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
//essb5_main_singlecounter_selection
ESSBOptionsStructureHelper::title('social', 'share-2', __('Single button share counter position', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_main_singlecounter_selection', '', '');

ESSBOptionsStructureHelper::title('social', 'share-2', __('Total share counter position', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_main_totalcoutner_selection', '', '');

ESSBOptionsStructureHelper::hint('social', 'share-2', '', __('Additional counter options are available inside Share Counters Setup menu (total counter icon, single network update settings, share recovery, avoid negative proof and etc.)', 'essb'));

//essb5_main_totalcoutner_selection

ESSBOptionsStructureHelper::structure_section_end('social', 'share-2');
ESSBOptionsStructureHelper::structure_section_start('social', 'share-2', 'c4');
ESSBOptionsStructureHelper::title('social', 'share-2', __('Button width', 'essb'), '', 'inner-row');
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_main_button_width_choose', '', '');

ESSBOptionsStructureHelper::holder_start('social', 'share-2', 'essb-fixed-width', 'essb-fixed-width');
ESSBOptionsStructureHelper::title('social', 'share-2', __('Customize fixed width display', 'essb'), __('In fixed width mode buttons will have exactly same width defined by you no matter of device or screen resolution (not responsive).', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_section_start_panels('social', 'share-2', '', __('Customize the fixed width options', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-2', 'fixed_width_value', __('Custom buttons width', 'essb'), __('Provide custom width of button in pixels without the px symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_select_panel('social', 'share-2', 'fixed_width_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name, when fixed button width is activated. When counter position is Inside or Inside name, that alignment will be applied for the counter. Default value is center.', 'essb'), array("" => "Center", "left" => "Left", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'share-2');
ESSBOptionsStructureHelper::holder_end('social', 'share-2');

ESSBOptionsStructureHelper::holder_start('social', 'share-2', 'essb-full-width', 'essb-full-width');
ESSBOptionsStructureHelper::title('social', 'share-2', __('Customize full width display', 'essb'), __('In full width mode buttons will distribute over the entire screen width on each device (responsive).', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_select_panel('social', 'share-2', 'fullwidth_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("left" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_start_panels('social', 'share-2', __('Customize width of first two buttons', 'essb'), __('Provide different width for the first two buttons in the row. The width should be entered as number in percents (without the % mark). You can fill only one of the values or both values.', 'essb'), '', 'true');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-2', 'fullwidth_first_button', __('Width of first button', 'essb'), __('Provide custom width of first button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-2', 'fullwidth_second_button', __('Width of second button', 'essb'), __('Provide custom width of second button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_section_end_panels('social', 'share-2');

ESSBOptionsStructureHelper::panel_start('social', 'share-2', __('Fix button apperance', 'essb'), __('Full width share buttons uses formula to calculate the best width of buttons. In some cases based on other site styles you may need to personalize some of the values in here', 'essb'), '', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_section_start_panels('social', 'share-2', '', __('Full width option will make buttons to take the width of your post content area.', 'essb'));
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-2', 'fullwidth_share_buttons_correction', __('Max width of button on desktop', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-2', 'fullwidth_share_buttons_correction_mobile', __('Max width of button on mobile', 'essb'), __('Provide custom width of single button when full width is active. This value is number in percents without the % symbol.', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_textbox_panel('social', 'share-2', 'fullwidth_share_buttons_container', __('Max width of buttons container element', 'essb'), __('If you wish to display total counter along with full width share buttons please provide custom max width of buttons container in percent without % (example: 90). Leave this field blank for default value of 100 (100%).', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
ESSBOptionsStructureHelper::field_section_end_panels('social', 'share-2');
ESSBOptionsStructureHelper::panel_end('social', 'share-2');
ESSBOptionsStructureHelper::holder_end('social', 'share-2');

ESSBOptionsStructureHelper::holder_start('social', 'share-2', 'essb-column-width', 'essb-column-width');
ESSBOptionsStructureHelper::title('social', 'share-2', __('Customize column display', 'essb'), __('In column mode buttons will distribute over the entire screen width on each device in the number of columns you setup (responsive).', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_section_start_panels('social', 'share-2', '', '');
$listOfOptions = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10");
ESSBOptionsStructureHelper::field_select_panel('social', 'share-2', 'fullwidth_share_buttons_columns', __('Number of columns', 'essb'), __('Choose the number of columns that buttons will be displayed.', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_select_panel('social', 'share-2', 'fullwidth_share_buttons_columns_align', __('Choose alignment of network name', 'essb'), __('Provide different alignment of network name (counter when position inside or inside name). Default value is left.', 'essb'), array("" => "Left", "center" => "Center", "right" => "Right"));
ESSBOptionsStructureHelper::field_section_end_panels('social', 'share-2');
ESSBOptionsStructureHelper::holder_end('social', 'share-2');



ESSBOptionsStructureHelper::structure_section_end('social', 'share-2');
ESSBOptionsStructureHelper::structure_row_end('social', 'share-2');

ESSBOptionsStructureHelper::title('social', 'share-2', __('Live Style Preview', 'essb'), __('This style preview is illustrative showing how your buttons will look. All displayed share counters are random generated for preview purpose - real share values will appear on each post. Once you save settings you will be able to test the exact preview on site with networks you choose', 'essb'));				
ESSBOptionsStructureHelper::field_func('social', 'share-2', 'essb5_live_preview', '', '');

/** Share Counters **/
ESSBOptionsStructureHelper::tabs_start('social', 'sharecnt', 'counter-tabs', array('<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Counter Update', 'essb'), 
		'<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Single Button Counter', 'essb'),
		'<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Total Counter', 'essb'),
		'<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Advanced Update Settings', 'essb')), 'false', 'true');

ESSBOptionsStructureHelper::tab_start('social', 'sharecnt', 'counter-tabs-0', 'true');
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'counter_mode', __('Counter update interval', 'essb'), __('Choose how your counters will update. Real-time share counter will update on each page load and usage on production site can produce extreme load over admin-ajax WordPress component - use it with caution. We strongly recommend using updated on interval counters. They will update once on chosen interval and ensure your site will work fast and smooth (if you use cache plugin and they do not update frequently you can activate in advanced options cache compatible update mode).', 'essb'), essb_cached_counters_update(), '', '8');

ESSBOptionsStructureHelper::panel_start('social', 'sharecnt', __('Avoid social negative proof', 'essb'), __('Avoid social negative proof allows you to hide button counters or total counter till a defined value of shares is reached', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'social_proof_enable', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_textbox('social', 'sharecnt', 'button_counter_hidden_till', __('Display button counter after this value of shares is reached', 'essb'), __('You can hide your button counter until amount of shares is reached. This option is active only when you enter value in this field - if blank button counter is always displayed. (Example: 10 - this will make button counter appear when at least 10 shares are made).', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'sharecnt', 'total_counter_hidden_till', __('Display total counter after this value of shares is reached', 'essb'), __('You can hide your total counter until amount of shares is reached. This option is active only when you enter value in this field - if blank total counter is always displayed.', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharecnt');

ESSBOptionsStructureHelper::panel_start('social', 'sharecnt', __('Advanced counter update options', 'essb'), __('Configure different advanced counter update functions of plugin when you use non real time counters', 'essb'), 'fa21 fa fa-refresh', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::structure_row_start('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'cache_counter_refresh_cache', __('Cache plugin/server compatible mode', 'essb'), __('Recommended to be active on sites that uses cache plugin or cache server. Activation of this option will ensure your counters will update on background at the time you set but you will see the new share value once your cache expires (usually once per hour or once per day).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'cache_counter_refresh_async', __('Speed up process of counters update', 'essb'), __('This option will activate asynchronous counter update mode which is up to 5 times faster than regular update. Option requires to have PHP 5.4 or newer.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_row_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_row_start('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'cache_counter_increase', __('Increase update period for older posts', 'essb'), __('Use this option to increase progressive update counter interval for older posts of your site. This will make less calls to social APIs and make counters update faster.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'cache_counter_force', __('Force save new shares', 'essb'), __('If the API share count request returns a lower number than previously recorded, we ignore the new number and retain the original higher number from the previous request. Activating this will force the new share number to be accepted even if it is a lower number than previously recorded.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_row_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_row_start('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'cache_counter_facebook_async', __('Client side Facebook counter update', 'essb'), __('Use client side Facebook counter update to eliminate Facebook rate policy for number of connection you can send. The client side update will ensure your counters will frequently update. Option is compatible with share recovery.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'cache_counter_pinterest_async', __('Client side Pinterest counter update', 'essb'), __('TPinterest apply restrictions when you are using few hosts that avoid Pinterest counter extraction. In such case please activate this option to avoid missing Pinterest counters. Due to Pinterest rate limitations this option cannot work with share recovery.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '8');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_row_end('social', 'sharecnt');



ESSBOptionsStructureHelper::panel_end('social', 'sharecnt');

// recovery
ESSBOptionsStructureHelper::panel_start('social', 'sharecnt', __('Recover my shares', 'essb'), __('Share counter recovery allows you restore back shares once you make a permalink change (including installing a SSL certificate). Share recovery will show back shares only if they are present for both versions of URL (before and after change).', 'essb'), 'fa21 fa fa-magic', array("mode" => "switch", 'switch_id' => 'counter_recover_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

if (!defined('ESSB3_CACHED_COUNTERS')) {
	ESSBOptionsStructureHelper::hint('social', 'sharecnt', __('Share counter recovery is not active untill you switch to cached share counters', 'essb'), __('Share counter recovery can work only when you activate cached update mode of share counters. Till you activate this options below will not work. This is required to prevent server from hangout when recovery connections are executed. <br/><br/><b>To change mode of share counters update please visit Social Sharing -> Counters and choose from top right corner update method to be something different from Real Time share counters</b>', 'essb'), 'fa32 ti-info-alt', 'red');

}

$recover_type = array(
				'unchanged'			=> __( 'Unchanged' , 'essb' ),
				'default' 			=> __( 'Plain' , 'essb' ),
				'day_and_name' 		=> __( 'Day and Name' , 'essb' ),
				'month_and_name' 	=> __( 'Month and Name' , 'essb' ),
				'numeric' 			=> __( 'Numeric' , 'essb' ),
				'post_name' 		=> __( 'Post Name' , 'essb' ),
				'custom'			=> __( 'Custom' , 'essb' )
			);

ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'counter_recover_mode', __('Previous url format', 'essb'), __('Choose how your site address is changed. If you choose custom use the field below to setup your URL structure', 'essb'), $recover_type);
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharecnt', 'counter_recover_custom', __('Custom Permalink Format', 'essb'), __('', 'essb'));

//ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'counter_recover_slash', __('My previous url does not have trailing slash', 'essb'), __('Activate this option if your previous url does not contain trailing slash at the end.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

$recover_mode = array("unchanged" => "Unchanged", "http2https" => "Switch from http to https", "https2http" => "Switch from https to http");
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'counter_recover_protocol', __('Change of connection protocol', 'essb'), __('If you change your connection protocol then choose here the option that describes it.', 'essb'), $recover_mode);

$recover_domain = array(
				'unchanged'			=> __( 'Unchanged' , 'essb' ),
				'www'				=> __( 'www' , 'essb' ),
				'nonwww'			=> __( 'non-www' , 'essb' ));
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'counter_recover_prefixdomain', __('Previous Domain Prefix', 'essb'), __('If you make a change of your domain prefix than you need to describe it here.', 'essb'), $recover_domain);
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharecnt', 'counter_recover_subdomain', __('Subdomain', 'essb'), __('If you move your site to a subdomain enter here its name (without previx and extra symbols', 'essb'));

ESSBOptionsStructureHelper::hint('social', 'sharecnt', __('Cross-domain recovery', 'essb'), __('If you\'ve migrated your website from one domain to another, fill in these two fields to activate cross-domain share recovery', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharecnt', 'counter_recover_domain', __('Previous domain name', 'essb'), __('If you have changed your domain name please fill in this field previous domain name with protocol (example http://example.com) and choose recovery mode to be <b>Change domain name</b>', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharecnt', 'counter_recover_newdomain', __('New domain name', 'essb'), __('If plugin is not able to detect your new domain fill here its name with protocol (example http://example.com)', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'sharecnt', 'counter_recover_date', __('Date of change', 'essb'), __('Fill out date when change was made. Once you fill it share counter recovery will be made for all posts that are published before this date. Date shoud be filled in format <b>yyyy-mm-dd</b>.', 'essb'));
ESSBOptionsStructureHelper::panel_end('social', 'sharecnt');

ESSBOptionsStructureHelper::tab_end('social', 'sharecnt');

ESSBOptionsStructureHelper::tab_start('social', 'sharecnt', 'counter-tabs-1');
ESSBOptionsStructureHelper::field_heading('social', 'sharecnt', 'heading5', __('Button Counters', 'essb'));
ESSBOptionsStructureHelper::panel_start('social', 'sharecnt', __('Additional social network counter settings that you need to pay attention', 'essb'), __('Depends on networks that are set on site you may need to configure additional fields in this section like Twitter counter function, usage of internal counters, number format or Facebook Token for consistent Facebook counter update', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::structure_row_start('social', 'sharecnt');
$listOfOptions = array ("self" => "Self-hosted counter (internally counted by click on buttons)", "newsc" => "Using NewShareCounts.com", "opensc" => "Using OpenShareCount.com", "no" => "No counter for Twitter button" );
$counter_redirect = "";
$twitter_counters = ESSBOptionValuesHelper::options_value($essb_options, 'twitter_counters');
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'twitter_counters', __('Twitter share counter', 'essb'), __('Choose your Twitter counter working mode. If you select usage of NewShareCounts.com or OpenShareCount.com to make it work you need to visit their site and fill your site address and click sign in button using your Twitter account. Visit <a href="http://newsharecounts.com/" target="_blank">http://newsharecounts.com/</a> or <a href="http://opensharecount.com/" target="_blank">http://opensharecount.com/</a>'.$counter_redirect, 'essb'), $listOfOptions, '', '6');
ESSBOptionsStructureHelper::structure_row_end('social', 'sharecnt');

ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharecnt', 'facebook_counter_token', __('Facebook access token key', 'essb'), __('To avoid missing Facebook share counter due to rate limits we recommend to fill access token key. Access token generation of counter can work only when you do not use real time counters. To generate your access token key please visit <a href="http://tools.creoworx.com/facebook/" target="_blank">http://tools.creoworx.com/facebook/</a> and follow instructions to generate application based token', 'essb'), '', '', '', '', '6');
$listOfOptions = array ("" => "API Endpoint #1", "api2" => "API Endpoint #2", "api3" => "API Endpoint #3");
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'facebook_counter_api', __('Facebook counter update API', 'essb'), __('Facebook have right now several active API endpoints that you can use to get share counter. The default is API Endpoint #1 but if you experience issue with counters try also API Endpoint #2', 'essb'), $listOfOptions, '', '6');

$listOfOptions = array ("" => "Google+ Official Counter (till it is available)", "self" => "Self-hosted counter (internally counted by click on buttons)");
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'google_counter_type', __('Google+ share counter', 'essb'), __('Google+ recenly <a href="https://plus.google.com/110610523830483756510/posts/Z1FfzduveUo" target="_blank">announced that they are removing share counters</a> from their button and API. When that become globally you can switch to internal counter.', 'essb'), $listOfOptions, '', '6');

ESSBOptionsStructureHelper::field_textbox_stretched('social', 'sharecnt', 'google_counter_token', __('Google+ API key', 'essb'), __('Very rear Google+ may not show out counter because of too many connections to their API. In this case you will need to build access key and paste it here inside Google Developer Console', 'essb'), '', '', '', '', '6');

ESSBOptionsStructureHelper::structure_row_start('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'active_internal_counters', __('Activate internal counters for all networks that do not support API count', 'essb'), __('Activate internal
		counters for all networks that does not have access to API
		counter functions. If this option is active counters are stored
		in each post/page options and may be different from actual', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '9');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'deactive_internal_counters_mail', __('Deactivate counters for Mail & Print', 'essb'), __('Enable this option if you wish to deactivate internal counters for mail & print buttons. That buttons are in the list of default social networks that support counters. Deactivating them will lower down request to internal WordPress AJAX event.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '9');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_row_end('social', 'sharecnt');

$counter_value_mode = array("" => __('Automatically shorten values above 1000', 'essb'), 'full' => __('Always display full value (default server settings)', 'essb'), 'fulldot' => __('Always display full value - dot thousand separator (example 5.000)', 'essb'), 'fullcomma' => __('Always display full value - comma thousand separator (example 5,000)', 'essb'), 'fullspace' => __('Always display full value - space thousand separator (example 5 000)', 'essb'));
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'counter_format', __('Share counter format', 'essb'), __('Choose how you wish to present your share counter value - short number of full number. This option will not work if you use real time share counters - in this mode you will always see short number format.', 'essb'), $counter_value_mode, '', '6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'animate_single_counter', __('Animate Numbers', 'essb'), __('Enable this option to apply nice animation of counters on appear.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');

ESSBOptionsStructureHelper::panel_end('social', 'sharecnt');

ESSBOptionsStructureHelper::tab_end('social', 'sharecnt');

ESSBOptionsStructureHelper::tab_start('social', 'sharecnt', 'counter-tabs-2');
ESSBOptionsStructureHelper::field_heading('social', 'sharecnt', 'heading5', __('Total Counter', 'essb'));

ESSBOptionsStructureHelper::panel_start('social', 'sharecnt', __('Configure total counter', 'essb'), __('Once you choose your total counter position you will find here all required fields to customize its look (change of text, number format or icon)', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::structure_row_start('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_textbox('social', 'sharecnt', 'counter_total_text', __('Change total text', 'essb'), __('This option allows you to change text Total that appear when left/right position of total counter is selected.', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_textbox('social', 'sharecnt', 'activate_total_counter_text', __('Append text to total counter when big number styles are active', 'essb'), __('This option allows you to add custom text below counter when big number styles are active. For example you can add text shares.', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_row_end('social', 'sharecnt');

ESSBOptionsStructureHelper::structure_row_start('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');
ESSBOptionsStructureHelper::field_textbox('social', 'sharecnt', 'total_counter_afterbefore_text', __('Change total counter text when before/after styles are active', 'essb'), __('Customize the text that is displayed in before/after share buttons display method. To display the total share number use the string {TOTAL} in text. Example: {TOTAL} users share us', 'essb'), '', '', '', '', '6');
ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_section_start('social', 'sharecnt', 'c6');

$select_values = array(
		'share' => array('title' => '', 'content' => '<i class="essb_icon_share"></i>'),
		'share-alt-square' => array('title' => '', 'content' => '<i class="essb_icon_share-alt-square"></i>'),
		'share-alt' => array('title' => '', 'content' => '<i class="essb_icon_share-alt"></i>'),
		'share-tiny' => array('title' => '', 'content' => '<i class="essb_icon_share-tiny"></i>'),
		'share-outline' => array('title' => '', 'content' => '<i class="essb_icon_share-outline"></i>')
);
ESSBOptionsStructureHelper::field_toggle('social', 'sharecnt', 'activate_total_counter_icon', __('Total counter icon', 'essb'), __('Choose icon displayed on total counter when position with such is selected', 'essb'), $select_values);


ESSBOptionsStructureHelper::structure_section_end('social', 'sharecnt');
ESSBOptionsStructureHelper::structure_row_end('social', 'sharecnt');
$counter_value_mode = array("" => __('Automatically shorten values above 1000', 'essb'), 'full' => __('Always display full value (default server settings)', 'essb'), 'fulldot' => __('Always display full value - dot thousand separator (example 5.000)', 'essb'), 'fullcomma' => __('Always display full value - comma thousand separator (example 5,000)', 'essb'), 'fullspace' => __('Always display full value - space thousand separator (example 5 000)', 'essb'));
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'total_counter_format', __('Total counter format', 'essb'), __('Choose how you wish to present your share counter value - short number of full number. This option will not work if you use real time share counters - in this mode you will always see short number format', 'essb'), $counter_value_mode);
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'total_counter_all', __('Always generate total counter based on all social networks', 'essb'), __('Enable this option if you wish to see total counter generated based on all installed in plugin social networks no matter of ones you have active. Default plugin setup is made to show total counter based on active for display social networks only and using different social networks on different locations may cause to have difference in total counter. Use this option to make it always be the same.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'animate_total_counter', __('Animate Numbers', 'essb'), __('Enable this option to apply nice animation of counters on appear.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '6');

ESSBOptionsStructureHelper::panel_end('social', 'sharecnt');

ESSBOptionsStructureHelper::tab_end('social', 'sharecnt');


ESSBOptionsStructureHelper::tab_start('social', 'sharecnt', 'counter-tabs-3');

ESSBOptionsStructureHelper::panel_start('social', 'sharecnt', __('Advanced counter update options', 'essb'), __('Configure different advanced counter update functions of plugin when you use real time or cached counters', 'essb'), 'fa21 fa fa-refresh', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_heading('social', 'sharecnt', 'heading5', __('Real time counters', 'essb'));
ESSBOptionsStructureHelper::field_section_start('social', 'sharecnt', __('Counter update options for all networks that does not provide direct access to counter API or does not have share counter and uses internal counters', 'essb'), __('', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'force_counters_admin', __('Load counters for social networks without direct access to counter API with build-in WordPress AJAX functions (using AJAX settings)', 'essb'), __('This method is more secure and required by some hosting companies but may slow down page load.', 'essb'), 'yes', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("wp" => "Build in WordPress ajax handler", "light" => "Light Easy Social Share Buttons handler");
ESSBOptionsStructureHelper::field_select('social', 'sharecnt', 'force_counters_admin_type', __('AJAX load method', 'essb'), __('Choose the default ajax method from build in WordPress or light handler', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'force_counters_admin_single', __('Use single request of counter load for all social networks that uses the ajax handler', 'essb'), __('This method will make single call to AJAX handler to get all counters instead of signle call for each network. The pros of this option is that you will make less calls to selected AJAX handler. We suggest to use this option in combination with counters cache.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::field_section_start('social', 'sharecnt', __('Counter cache for AJAX load method', 'essb'), __('This will reduce load because counters will be updated when cache expires', 'essb'), '');
ESSBOptionsStructureHelper::field_switch('social', 'sharecnt', 'admin_ajax_cache', __('Activate', 'essb'), __('', 'essb'), 'yes', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_textbox('social', 'sharecnt', 'admin_ajax_cache_time', __('Cache expiration time', 'essb'), __('Amount of seconds for cache (default is 600 if nothing is provided)', 'essb'));
ESSBOptionsStructureHelper::field_section_end('social', 'sharecnt');

ESSBOptionsStructureHelper::panel_end('social', 'sharecnt');

ESSBOptionsStructureHelper::tab_end('social', 'sharecnt');

ESSBOptionsStructureHelper::tabs_end('social', 'sharecnt');


/** Analytics **/
if (!essb_option_bool_value('deactivate_module_analytics')) {
	ESSBOptionsStructureHelper::field_heading('social', 'analytics', 'heading5', __('Activate build-in analytics', 'essb'));
	ESSBOptionsStructureHelper::field_switch('social', 'analytics', 'stats_active', __('Activate analytics and collect data for click over buttons', 'essb'), __('Build-in analytics is exteremly powerful tool which will let you to track how your visitors interact with share buttons. Get reports by positions, device type, social networks, for periods or for content', 'essb'), 'recommended', __('Yes', 'essb'), __('No', 'essb'));
	
	ESSBOptionsStructureHelper::field_heading('social', 'analytics', 'heading5', __('Google Analytics Tracking', 'essb'));
	ESSBOptionsStructureHelper::field_switch('social', 'analytics', 'activate_ga_tracking', __('Activate Google Analytics Tracking', 'essb'), __('Activate tracking of social share buttons click using Google Analytics (requires Google Analytics to be active on this site).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	$listOfOptions = array ("simple" => "Simple", "extended" => "Extended" );
	ESSBOptionsStructureHelper::field_select('social', 'analytics', 'ga_tracking_mode', __('Google Analytics Tracking Method', 'essb'), __('Choose your tracking method: Simple - track clicks by social networks, Extended - track clicks on separate social networks by button display position.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_switch('social', 'analytics', 'activate_ga_layers', __('Use Google Tag Manager Data Layer Event Tracking', 'essb'), __('Activate this option if you use Google Tag Manager to add analytics code and you did not setup automatic event tracking.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'analytics', 'activate_ga_campaign_tracking', __('Add Custom Campaign parameters to your URLs', 'essb'), __('Paste your custom campaign parameters in this field and they will be automatically added to shared addresses on social networks. Please note as social networks count shares via URL as unique key this option is not compatible with active social share counters as it will make the start from zero.', 'essb'));
	ESSBOptionsStructureHelper::hint('social', 'analytics', '', essb3_text_analytics());
}

/** Metrics **/
if (!essb_option_bool_value('deactivate_module_metrics')) {
	ESSBOptionsStructureHelper::hint('social', 'social-metrics', '', __('Social Metrics data collection require to have share counters active on your site. All data will be updated and stored inside metrics dashboard on each share counter update. Metrics data cannot be collected if you use real time share counters.', 'essb'), 'fa24 ti-widget', 'glow');
	ESSBOptionsStructureHelper::field_switch('social', 'social-metrics', 'esml_active', __('Activate social metrics data collection', 'essb'), __('Switch this option to yes to start collecting data for your shares. Data collection requires to have share counters active on your site with mode different than real time. All data will be updated with each counter update request.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

	$data_history = array();
	$data_history['1'] = __('1 day', 'essb');
	$data_history['7'] = __('1 week', 'essb');
	$data_history['14'] = __('2 weeks', 'essb');
	$data_history['30'] = __('1 month', 'essb');

	ESSBOptionsStructureHelper::field_select('social', 'social-metrics', 'esml_history', __('Keep history for', 'essb'), __('Choose how long plugin to store history data inside cache. All data that is collected will be saved inside post meta fields and choosing a greater period will generate a bigger record.', 'essb'), $data_history);


	$listOfOptions = array("manage_options" => "Administrator", "delete_pages" => "Editor", "publish_posts" => "Author", "edit_posts" => "Contributor");
	ESSBOptionsStructureHelper::field_select('social', 'social-metrics', 'esml_access', __('Metrics report access', 'essb'), __('Access role will limit which type of users can see the metrics data inside WordPress admin panel. If you are not sure what to choose leave Administrator selected.', 'essb'), $listOfOptions);
}


/** Optimize **/
if (!essb_option_bool_value('deactivate_module_shareoptimize')) {
	ESSBOptionsStructureHelper::hint('social', 'optimize', __('Optimize your social share message on all social networks', 'essb'), __('Social Sharing Optimization is important for each site. Without using it you have no control over shared information on social networks. We highly recommend to activate it (Facebook sharing tags are used on almost all social networks so they are the minimal required).', 'essb'), 'fa21 mr10 fa fa-info', 'glow');
	
	ESSBOptionsStructureHelper::panel_start('social', 'optimize', __('Homepage settings', 'essb'), __('Configure global homepage share options that will be used on your homepage when it is not a static page (page generated from list of posts or dynamic generated page by theme). Those settings will work only when one of options below is active.', 'essb'), 'fa21 fa fa-home', array("mode" => "toggle", 'state' => 'closed-no'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize', 'sso_frontpage_title', __('Title', 'essb'), __('Title that will be displayed on frontpage.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize', 'sso_frontpage_description', __('Description', 'essb'), __('Description that will be displayed on frontpage', 'essb'));
	ESSBOptionsStructureHelper::field_image('social', 'optimize', 'sso_frontpage_image', __('Image', 'essb'), __('Image that will be displayed on frontpage', 'essb'), '', 'vertical1');
	ESSBOptionsStructureHelper::panel_end('social', 'optimize');
	
	ESSBOptionsStructureHelper::panel_start('social', 'optimize', __('Facebook Open Graph Tags (Used by most social networks)', 'essb'), __('Open Graph meta tags are used to optimize social sharing. This option will include following tags og:title, og:description, og:url, og:image, og:type, og:site_name.', 'essb'), 'fa21 fa fa-facebook', array("mode" => "switch", 'switch_id' => 'opengraph_tags', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
	ESSBOptionsStructureHelper::field_section_start_full_panels('social', 'optimize');
	ESSBOptionsStructureHelper::field_switch_panel('social', 'optimize', 'sso_imagesize', __('Generate image size tags', 'essb'), __('Image size tags are not required - they are optional but in some cases without them Facebook may not recongnize the correct image. In case this happens to you try activating this option.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'optimize', 'sso_gifimages', __('GIF images support', 'essb'), __('Set this to Yes if your site uses GIF images as featured or optimized for sharing and you wish to see that appearing inside Facebook sharing', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'optimize', 'sso_multipleimages', __('Allow more than one share image', 'essb'), __('This option will allow to choose up to 5 additional images on each post that will appear in social share optimization tags.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('social', 'optimize');
	
	
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize', 'opengraph_tags_fbpage', __('Facebook Page URL', 'essb'), __('Provide your Facebook page address.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'optimize', 'opengraph_tags_fbadmins', __('Facebook Admins', 'essb'), __('Enter IDs of Facebook Users that are admins of current page.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'optimize', 'opengraph_tags_fbapp', __('Facebook Application ID', 'essb'), __('Enter ID of Facebook Application to be able to use Facebook Insights', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'optimize', 'opengraph_tags_fbauthor', __('Facebook Author Profile', 'essb'), __('Add link to Facebook profile page of article author if you wish it to appear in shared information.', 'essb'));
	ESSBOptionsStructureHelper::field_file('social', 'optimize', 'sso_default_image', __('Default share image', 'essb'), __('Default share image will be used when page or post doesn\'t have featured image or custom setting for share image.', 'essb'));
	ESSBOptionsStructureHelper::field_switch('social', 'optimize', 'sso_httpshttp', __('Use http version of page in social tags', 'essb'), __('If you recently move from http to https and realize that shares are gone please activate this option and check are they back. In case this does not help contact us in support system <a href="http://support.creoworx.com" target="_blank">http://support.creoworx.com</a> for addtional instructions', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch('social', 'optimize', 'sso_apply_the_content', __('Extract full content when generating description', 'essb'), __('If you see shortcodes in your description activate this option to extract as full rendered content. <br/><b>Warning! Activation of this option may affect work of other plugins or may lead to missing share buttons. If you notice something that is not OK with site immediately deactivate it.</b>', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end('social', 'optimize');
	
	ESSBOptionsStructureHelper::panel_start('social', 'optimize', __('Automatically generate and insert Twitter Cards meta tags for post/pages', 'essb'), __('To allow Twitter Cards data appear in your Tweets you need to validate your site after activation of that option in Twitter Card Validator', 'essb'), 'fa21 fa fa-twitter', array("mode" => "switch", 'switch_id' => 'twitter_card', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_textbox('social', 'optimize', 'twitter_card_user', __('Twitter Site Username', 'essb'), __('Enter your Twitter site username.', 'essb'));
	$listOfOptions = array ("summary" => "Summary", "summaryimage" => "Summary with image" );
	ESSBOptionsStructureHelper::field_select('social', 'optimize', 'twitter_card_type', __('Twitter Card Type', 'essb'), __('Choose the default card type that should be generated.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::panel_end('social', 'optimize');
}

/** Short URL **/
if (!essb_option_bool_value('deactivate_module_shorturl')) {
	ESSBOptionsStructureHelper::panel_start('social', 'shorturl', __('Activate generation of short urls for sharing', 'essb'), __('Activate this option if you wish to allow generation of short urls when post is shared', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'shorturl_activate', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
	ESSBOptionsStructureHelper::field_select('social', 'shorturl', 'twitter_shareshort', __('Generate short urls for', 'essb'), __('Select networks you wish to generate short urls for - you can choose from recommended networks (Twitter, Mobile Messengers) or all social networks'), array( "true" => "Recommended social networks only (Twitter, Mobile Messengers)", "false" => "All social networks"));
	
	$listOfOptions = array("wp" => "Build in WordPress function wp_get_shortlink()", "goo.gl" => "goo.gl", "bit.ly" => "bit.ly", 'rebrand.ly' => 'Rebrandly', 'po.st' => 'po.st');
	if (defined('ESSB3_SSU_VERSION')) {
		$listOfOptions['ssu'] = "Self-Short URL Add-on for Easy Social Share Buttons";
	}
	
	ESSBOptionsStructureHelper::field_select('social', 'shorturl', 'shorturl_type', __('Choose short url type', 'essb'), __('Please note that usage of bit.ly requires to fill additional fields below or short urls will not be generated. If you choose goo.gl as provider we also recommend to generate API key due to public quota limit provided by Google.'), $listOfOptions);
	
	ESSBOptionsStructureHelper::holder_start('social', 'shorturl', 'essb-short-bitly', 'essb-short-bitly');
	ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('bit.ly Access Configuration', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('social', 'shorturl', 'shorturl_bitlyuser', __('bit.ly Username', 'essb'), __('Provide your bit.ly username', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_bitlyapi', __('bit.ly API key/Access token key', 'essb'), __('Provide your bit.ly API key', 'essb'));
	ESSBOptionsStructureHelper::field_select('social', 'shorturl', 'shorturl_bitlyapi_version', __('bit.ly API version', 'essb'), __('Choose version of bit.ly API you will use. We recommend to switch to new bit.ly API with access token'), array( "previous" => "Old API version with Username and Access Key", "new" => "New API with access token"));
	ESSBOptionsStructureHelper::holder_end('social', 'shorturl');
	
	ESSBOptionsStructureHelper::holder_start('social', 'shorturl', 'essb-short-googl', 'essb-short-googl');
	ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('goo.gl Access Configuration', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_googlapi', __('goo.gl API key', 'essb'), __('Goo.gl short url service can work with or without API key. If you have a high traffic site it is recommended to use API key because when anonymous usage reach amount of request for time you will not get short urls. To generate such key you need to visit <a href="https://console.developers.google.com/project" target="_blank">Google Developer Console</a>', 'essb'));
	ESSBOptionsStructureHelper::holder_end('social', 'shorturl');
	ESSBOptionsStructureHelper::holder_start('social', 'shorturl', 'essb-short-rebrandly', 'essb-short-rebrandly');
	ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('Rebrandly Access Configuration', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_rebrandpi', __('Rebrandly API key', 'essb'), __('Rebrandly service require API key to generate your short URLs. To get such please visit this address <a href="https://www.rebrandly.com/api-settings" target="_blank">Rebrandly API Settings page</a>', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_rebrandpi_domain', __('Rebrandly Domain ID', 'essb'), __('If you have your own branded domain name fill in here its ID. To get domian ID visit <a href="https://www.rebrandly.com/domains/all" target="_blank">Rebrandly Domain list page</a> and copy from URL its ID. ID is the bold part marked in here https://www.rebrandly.com/domains/<b>1234334343asda34adsa</b>', 'essb'));
	ESSBOptionsStructureHelper::holder_end('social', 'shorturl');
	ESSBOptionsStructureHelper::holder_start('social', 'shorturl', 'essb-short-post', 'essb-short-post');
	ESSBOptionsStructureHelper::field_heading('social', 'shorturl', 'heading5', __('po.st Access Configuration', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'shorturl', 'shorturl_postapi', __('po.st API Access Token', 'essb'), __('po.st service require API access token to generate your short URLs. To get such please visit this address <a href="http://re.po.st/register" target="_blank">http://re.po.st/register</a>', 'essb'));
	ESSBOptionsStructureHelper::holder_end('social', 'shorturl');
	ESSBOptionsStructureHelper::panel_end('social', 'shorturl');
}

/** After Share Events **/
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

/** Affiliate & Point **/
if (!essb_option_bool_value('deactivate_module_affiliate')) {
	ESSBOptionsStructureHelper::field_heading('social', 'affiliate', 'heading4', __('myCred Integration', 'essb'));
	ESSBOptionsStructureHelper::field_heading('social', 'affiliate', 'heading5', __('Award users for clicking on share button', 'essb'));
	ESSBOptionsStructureHelper::field_section_start_panels('social', 'affiliate', __('Integration via points for click on links', 'essb'), __('Award users for click on share buttons using the build in hook for click on links inside myCred', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'affiliate', 'mycred_activate', __('Activate myCred integration for click on links', 'essb'), __('In order to work the myCred integration you need to have myCred Points for click on links hook activated (if you use custom points group you need to activated inside custom points group settings).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('social', 'affiliate', 'mycred_points', __('myCred reward points for share link click', 'essb'), __('Provide custom points to reward user when share link. If nothing is provided 1 point will be included.', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('social', 'affiliate', 'mycred_group', __('myCred custom point type', 'essb'), __('Provide custom meta key for the points that user will get to share link. To create your own please visit this tutorial: <a href="http://codex.mycred.me/get-started/multiple-point-types/" target="_blank">http://codex.mycred.me/get-started/multiple-point-types/</a>. Leave blank to use the default (mycred_default)', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels('social', 'affiliate');
	ESSBOptionsStructureHelper::field_section_start_panels('social', 'affiliate', __('Integration via Easy Social Share Buttons hook', 'essb'), __('Award users for click on share buttons using the custom hook for points for social sharing', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'affiliate', 'mycred_activate_custom', __('Activate myCred integration for points for social sharing', 'essb'), __('Use Easy Social Share Buttons custom hook in myCred to award points for click on share buttons', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_panels('social', 'affiliate');
	ESSBOptionsStructureHelper::field_heading('social', 'affiliate', 'heading5', __('Award users when someone uses their share link', 'essb'));
	ESSBOptionsStructureHelper::field_switch('social', 'affiliate', 'mycred_referral_activate', __('Activate myCred Referral usage', 'essb'), __('That option requires you to have the Points for referrals hook enabled. That option is not compatible with share counters because adding referral id to url will reset social share counters to zero.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch('social', 'affiliate', 'mycred_referral_activate_shortcode', __('Activate myCred Referral usage in shortcodes', 'essb'), __('Activate this option in combination with referrals hook to allow affiliate ID appear also when you use shortcodes.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	
	ESSBOptionsStructureHelper::field_heading('social', 'affiliate', 'heading4', __('AffiliateWP Integration', 'essb'));
	ESSBOptionsStructureHelper::field_section_start_full_panels('social', 'affiliate');
	ESSBOptionsStructureHelper::field_switch_panel('social', 'affiliate', 'affwp_active', __('Append Affiliate ID to shared address', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated. You need to have installed AffiliateWP plugin to use it: <a href="https://affiliatewp.com/" target="_blank">https://affiliatewp.com/</a>', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	$listOfOptions = array("id" => "User ID", "name" => "Username");
	ESSBOptionsStructureHelper::field_select_panel('social', 'affiliate', 'affwp_active_mode', __('ID Append Mode', 'essb'), __('Choose between usage of user id or username when you add affiliate id to outgoing shares.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_switch_panel('social', 'affiliate', 'affwp_active_shortcode', __('Append Affiliate ID to shortcodes', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated when shortcode has a custom url parameter.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'affiliate', 'affwp_active_pretty', __('Use pretty affiliate URLs', 'essb'), __('Activate this option if you already have make it active inside AffiliateWP to allow Easy Social Share Buttons generate pretty affiliate URLs.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('social', 'affiliate');
	
	ESSBOptionsStructureHelper::field_heading('social', 'affiliate', 'heading4', __('Affiliates Integration', 'essb'));
	ESSBOptionsStructureHelper::field_section_start_full_panels('social', 'affiliate');
	ESSBOptionsStructureHelper::field_switch_panel('social', 'affiliate', 'affs_active', __('Append Affiliate ID to shared address', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated. You need to have installed Affiliates plugin to use it: <a href="https://wordpress.org/plugins/affiliates/" target="_blank">https://wordpress.org/plugins/affiliates/</a>', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('social', 'affiliate', 'affs_active_shortcode', __('Append Affiliate ID to shortcodes', 'essb'), __('Automatically appends an affiliate\'s ID to Easy Social Share Buttons sharing links that are generated when shortcode has a custom url parameter.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('social', 'affiliate');
}

/** Custom Share **/
if (!essb_option_bool_value('deactivate_module_customshare')) {
	ESSBOptionsStructureHelper::panel_start('social', 'customshare', __('Activate custom share message', 'essb'), __('Activation of custom share message will make all social buttons that are automatically generated on site to share it.', 'essb'), 'fa21 fa fa-share', array("mode" => "switch", 'switch_id' => 'customshare', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::hint('social', 'customshare', '', 'Most of social share networks support only URL as option that is used to generated shared information. Puting custom share URL will be enough and all customizations that are needed should be made with social share optimization tags that will be applied on that address.');
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'customshare', 'customshare_text', __('Custom Share Message', 'essb'), __('This option allows you to pass custom message to share (not all networks support this).', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('social', 'customshare', 'customshare_url', __('Custom Share URL', 'essb'), __('This option allows you to pass custom url to share (all networks support this).', 'essb'));
	ESSBOptionsStructureHelper::field_file('social', 'customshare', 'customshare_image', __('Custom Share Image', 'essb'), __('This option allows you to pass custom image to your share message (only Facebook and Pinterest support this).', 'essb'));
	ESSBOptionsStructureHelper::field_textarea('social', 'customshare', 'customshare_description', __('Custom Share Description', 'essb'), __('This option allows you to pass custom extended description to your share message (only Facebok and Pinterest support this).', 'essb'));
	ESSBOptionsStructureHelper::panel_end('social', 'customshare');
}

/** Message Before Share **/
if (!essb_option_bool_value('deactivate_module_message')) {
	ESSBOptionsStructureHelper::panel_start('social', 'message', __('User message before share buttons', 'essb'), __('Enter custom message that will appear before your share buttons (html code supported)', 'essb'), 'fa21 fa fa-comment-o', array("mode" => "toggle", 'state' => 'closed'));
	
	
	ESSBOptionsStructureHelper::field_editor('social', 'message', 'message_share_before_buttons', __('Message before share buttons', 'essb'), __('You can use following variables to create personalized message: %%title%% - displays current post title, %%permalink%% - displays current post address.', 'essb'), 'htmlmixed');
	
	$select_values = array('desktop' => array('title' => 'Desktop', 'content' => '<i class="fa fa-desktop"></i>'),
			'mobile' => array('title' => 'Mobile', 'content' => '<i class="fa fa-mobile"></i>', 'padding' => '12px 16px'),	
			'tablet' => array('title' => 'Tablet', 'content' => '<i class="fa fa-tablet"></i>', 'padding' => '12px 13px'));
	ESSBOptionsStructureHelper::field_group_select('social', 'message', 'message_share_before_buttons_on', __('Message will appear on', 'essb'), __('Choose device types where you wish message to appear. Leave blank for all type of devices', 'essb'), $select_values, '', '', '');
	ESSBOptionsStructureHelper::panel_end('social', 'message');
	
	ESSBOptionsStructureHelper::panel_start('social', 'message', __('User message above share buttons', 'essb'), __('Enter custom message that will appear above your share buttons (html code supported)', 'essb'), 'fa21 fa fa-comment-o', array("mode" => "toggle", 'state' => 'closed'));
	ESSBOptionsStructureHelper::field_editor('social', 'message', 'message_above_share_buttons', __('Message above share buttons', 'essb'), __('You can use following variables to create personalized message: %%title%% - displays current post title, %%permalink%% - displays current post address.', 'essb'), 'htmlmixed');
	ESSBOptionsStructureHelper::field_group_select('social', 'message', 'message_above_share_buttons_on', __('Message will appear on', 'essb'), __('Choose device types where you wish message to appear. Leave blank for all type of devices', 'essb'), $select_values, '', '', '');
	ESSBOptionsStructureHelper::panel_end('social', 'message');
	
	ESSBOptionsStructureHelper::panel_start('social', 'message', __('User message above native buttons', 'essb'), __('Enter custom message that will appear above your native buttons (html code supported)', 'essb'), 'fa21 fa fa-comment-o', array("mode" => "toggle", 'state' => 'closed'));
	ESSBOptionsStructureHelper::field_editor('social', 'message', 'message_like_buttons', __('Message above like buttons', 'essb'), __('You can use following variables to create personalized message: %%title%% - displays current post title, %%permalink%% - displays current post address.', 'essb'), 'htmlmixed');
	ESSBOptionsStructureHelper::field_group_select('social', 'message', 'message_like_buttons_on', __('Message will appear on', 'essb'), __('Choose device types where you wish message to appear. Leave blank for all type of devices', 'essb'), $select_values, '', '', '');
	ESSBOptionsStructureHelper::panel_end('social', 'message');
}

if (!essb_option_bool_value('deactivate_module_conversions')) {
	ESSBOptionsStructureHelper::field_section_start_full_panels('conversions', 'share');
	ESSBOptionsStructureHelper::field_switch('conversions', 'share', 'conversions_lite_run', __('Track Social Share Buttons Conversion', 'essb'), __('Share buttons conversion is an easy way to manage and optimize display of share buttons on your site. Once active plugin will collect data for each displayed position and social networks along with click on each. All that data you will see in easy to understand dashboard. With such information you can easy make a decision of what you really need on your site. You have also access to past 7 days historical data. <a href="https://socialsharingplugin.com/share-conversions-lite/" target="_blank">Learn more for social share conversions lite</a>.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '10', 'true');
	ESSBOptionsStructureHelper::field_section_end_full_panels('conversions', 'share');
	
	if (!ESSBActivationManager::isActivated()) {
		if (!ESSBActivationManager::isThemeIntegrated()) {
			ESSBOptionsStructureHelper::hint('conversions', 'share', __('Activate Plugin to Get Access to Conversions Lite Reports', 'essb'), __('Thank you for choosing Easy Social Share Buttons for WordPress. To unlock view of conversions lite reports dashboard please activate plugin by filling your purchase code in Activation Page. <a href="admin.php?page=essb_redirect_update">Click here to visit Activation Page</a>', 'essb'), 'fa fa-lock fa21', 'glow');
		}
		else {
			ESSBOptionsStructureHelper::hint('conversions', 'share',__('Direct Customer Benefit ', 'essb'), sprintf(__('Access to Conversions Lite report dashboard is benefit for direct plugin customers. You can activate collection of data at any time but to view report you need to purchase a separate plugin license. <a href="%s" target="_blank">See all direct customer benefits</a>', 'essb'), ESSBActivationManager::getBenefitURL()), 'fa fa-lock fa21', 'glow');
		}
	}
	else {
		if (essb_option_bool_value('conversions_lite_run')) {
			//ESSBOptionsStructureHelper::field_heading('social', 'conversions', 'heading5', __('Conversions Result', 'essb'));
			
			if (!function_exists('essb_conversions_dashboard_report')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/conversions-lite/functions-conversions-lite.php');
			}
			
			ESSBOptionsStructureHelper::field_func('conversions', 'share', 'essb_conversions_dashboard_report', '', '');
		}
	}

	ESSBOptionsStructureHelper::field_section_start_full_panels('conversions', 'subscribe');
	ESSBOptionsStructureHelper::field_switch('conversions', 'subscribe', 'conversions_subscribe_lite_run', __('Track Subscribe Forms Conversion', 'essb'), __('Subscribe forms conversion is an easy way to manage and optimize display of subscribe forms on your site. Once active plugin will collect data for each displayed position and subscribes. You have also access to past 7 days historical data. <a href="https://socialsharingplugin.com/subscribe-conversions-lite/" target="_blank">Learn more for subscribe conversions lite</a>.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '10', 'true');
	ESSBOptionsStructureHelper::field_section_end_full_panels('conversions', 'subscribe');
	
	if (!ESSBActivationManager::isActivated()) {
		if (!ESSBActivationManager::isThemeIntegrated()) {
			ESSBOptionsStructureHelper::hint('conversions', 'subscribe', __('Activate Plugin to Get Access to Conversions Lite Reports', 'essb'), __('Thank you for choosing Easy Social Share Buttons for WordPress. To unlock view of conversions lite reports dashboard please activate plugin by filling your purchase code in Activation Page. <a href="admin.php?page=essb_redirect_update">Click here to visit Activation Page</a>', 'essb'), 'fa fa-lock fa21', 'glow');
		}
		else {
			ESSBOptionsStructureHelper::hint('conversions', 'subscribe',__('Direct Customer Benefit ', 'essb'), sprintf(__('Access to Conversions Lite report dashboard is benefit for direct plugin customers. You can activate collection of data at any time but to view report you need to purchase a separate plugin license. <a href="%s" target="_blank">See all direct customer benefits</a>', 'essb'), ESSBActivationManager::getBenefitURL()), 'fa fa-lock fa21', 'glow');
		}
	}
	else {
		if (essb_option_bool_value('conversions_subscribe_lite_run')) {
				
			if (!function_exists('essb_subscribe_conversions_dashboard_report')) {
				include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/conversions-lite/functions-subscribe-conversions-lite.php');
			}
				
			ESSBOptionsStructureHelper::field_func('conversions', 'subscribe', 'essb_subscribe_conversions_dashboard_report', '', '');
		}
	}
	
}

//*** Help Functions of that settings screen
function essb_postions_with_custom_networks5($as_text = false) {
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

function essb_postions_with_custom_options5($as_text = false) {
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

function essb5_main_network_selection() {
	essb_component_network_selection();
}

function essb5_main_template_selection() {
	essb_component_template_select();
}

function essb5_main_buttonstyle_selection() {
	essb_component_buttonstyle_select();
}

function essb5_main_animation_selection() {
	essb_component_animation_select();
}

function essb5_main_singlecounter_selection() {
	essb_component_counterpos_select();
}

function essb5_main_totalcoutner_selection() {
	essb_component_totalcounterpos_select();
}

function essb5_main_alignment_choose() {
	$select_values = array('' => array('title' => 'Left', 'content' => '<i class="ti-align-left"></i>'),
			'center' => array('title' => 'Center', 'content' => '<i class="ti-align-center"></i>'),
			'right' => array('title' => 'Right', 'content' => '<i class="ti-align-right"></i>'));
	
	$value = essb_option_value('button_pos');
	
	essb_component_options_group_select('button_pos', $select_values, '', $value);
	
}

function essb5_main_button_width_choose() {
	$value = essb_option_value('button_width');
	
	$select_values = array('' => array('title' => 'Automatic Width', 'content' => 'AUTO', 'isText'=>true),
			'fixed' => array('title' => 'Fixed Width', 'content' => 'Fixed', 'isText'=>true),
			'full' => array('title' => 'Full Width', 'content' => 'Full', 'isText'=>true),
			'flex' => array('title' => 'Fluid', 'content' => 'Fluid', 'isText'=>true),
			'column' => array('title' => 'Columns', 'content' => 'Columns', 'isText'=>true),);
	
	essb_component_options_group_select('button_width', $select_values, '', $value);
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

function essb5_live_preview() {
	
	$code = '<div class="essb-component-buttons-livepreview" data-settings="essb_global_preview">';
	$code .= '</div>';
	
	$code .= "<script type=\"text/javascript\">

	var essb_global_preview = {
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

function essb5_custom_position_networks() {
	$positions_with_networks = essb_postions_with_custom_networks5(true);
	if ($positions_with_networks != '') {
		
		$position_hint = 'Easy Social Share Buttons detect that you set a personalized list of social networks for the following positions <b>'.$positions_with_networks.'</b>. For that locations change in social network list will not take place automatically. If you wish to personalize list of networks for those locations you can do this on the location settings screen or tick options below to assign changes here also on all affected locations.';
		$position_hint .= '<br/><br/><b>Apply selected here social networks also on the following locations with personalized setup:</b><br/>';

		$positions_with_networks_list = essb_postions_with_custom_networks5();
		foreach ($positions_with_networks_list as $data) {
			$key = isset($data['key']) ? $data['key'] : '';
			$title = isset($data['title']) ? $data['title'] : '';
			
			$position_hint .= '<span class="essb_checkbox_list_item"><input type="checkbox" name="essb_options[autoset_networks][]" value="'.$key.'"/>'.$title.'</span>';
		}
		
		ESSBOptionsFramework::draw_hint(__('You have custom social networks list set on display positions', 'essb'), $position_hint, '', 'glow');
	}
	
}

function essb5_custom_position_settings() {
	$positions_with_networks = essb_postions_with_custom_options5(true);
	if ($positions_with_networks != '') {
	
		$position_hint = 'Easy Social Share Buttons detect that you set a personalized styles for the following positions <b>'.$positions_with_networks.'</b>. For that locations change in social network list will not take place automatically. If you wish to personalize style for those locations you can do this on the location settings screen.';
		$position_hint .= '<br/><br/><b>Apply selected here template only also on the following locations with personalized setup:</b><br/>';
	
		$positions_with_networks_list = essb_postions_with_custom_options5();
		foreach ($positions_with_networks_list as $data) {
			$key = isset($data['key']) ? $data['key'] : '';
			$title = isset($data['title']) ? $data['title'] : '';
				
			$position_hint .= '<span class="essb_checkbox_list_item"><input type="checkbox" name="essb_options[autoset_template][]" value="'.$key.'"/>'.$title.'</span>';
		}
	
		ESSBOptionsFramework::draw_hint(__('You have custom styles on display positions', 'essb'), $position_hint, '', 'glow');
		//ESSBOptionsStructureHelper::hint('social', 'share-1', __('Exist position based network settings', 'essb'), 'We found that you have personalized list of networks for position/s <b>'.$positions_with_networks.'</b>. All changes that you made in here will not reflect <b>'.$positions_with_networks.'</b> network selection - to make a change for those positions you need to use location based settings (or deactivate personalization by location).', 'fa21 mr10 ti-info-alt', 'blue');
	}
}

global $essb5_options_translate;
$essb5_options_translate = array();
$essb5_options_translate['essb5_main_template_selection'] = 'style';
$essb5_options_translate['essb5_main_buttonstyle_selection'] = 'button_style';
$essb5_options_translate['essb5_main_animation_selection'] = 'css_animations';
$essb5_options_translate['essb5_main_singlecounter_selection'] = 'counter_pos';
$essb5_options_translate['essb5_main_totalcoutner_selection'] = 'total_counter_pos';