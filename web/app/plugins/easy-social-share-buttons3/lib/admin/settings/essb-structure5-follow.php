<?php

if (!essb_option_bool_value('deactivate_module_followers')) {
	ESSBOptionsStructureHelper::menu_item('display', 'follow', __('Social Followers Counter', 'essb'), ' ti-heart', 'activate_first', 'follow-1');
	ESSBOptionsStructureHelper::submenu_item('display', 'follow-1', __('Settings', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('display', 'follow-2', __('Social Networks', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('display', 'follow-3', __('Followers Sidebar', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('display', 'follow-4', __('Custom Layout Builder', 'essb'));
}

if (!essb_option_bool_value('deactivate_module_profiles')) {
	ESSBOptionsStructureHelper::menu_item('display', 'profiles', __('Social Profiles', 'essb'), ' ti-user', 'activate_first', 'profiles-1');
	ESSBOptionsStructureHelper::submenu_item('display', 'profiles-1', __('Settings', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('display', 'profiles-2', __('Social Networks', 'essb'));
}

if (!essb_option_bool_value('deactivate_module_natives')) {
	ESSBOptionsStructureHelper::menu_item('display', 'native', __('Like, Follow & Subscribe', 'essb'), ' ti-thumb-up', 'activate_first', 'native-1');
	ESSBOptionsStructureHelper::submenu_item('display', 'native-1', __('Social Networks', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('display', 'native-2', __('Skinned buttons', 'essb'));
	ESSBOptionsStructureHelper::submenu_item('display', 'native-3', __('Social Privacy', 'essb'));
}

if (!essb_option_bool_value('deactivate_module_facebookchat')) {
	ESSBOptionsStructureHelper::menu_item('display', 'facebookchat', __('Facebook Messenger Live Chat', 'essb'), 'ti-facebook');

	if (!ESSBActivationManager::isActivated()) {
		if (!ESSBActivationManager::isThemeIntegrated()) {
			ESSBOptionsStructureHelper::hint('display', 'facebookchat', __('Activate Plugin To Use This Feature', 'essb'), 'Hello! Please <a href="admin.php?page=essb_redirect_update&tab=update">activate your copy</a> of Easy Social Share Buttons for WordPress to unlock and use this feature.', 'fa24 fa fa-lock', 'glow');
		}
		else {
			ESSBOptionsStructureHelper::hint('display', 'facebookchat', __('Direct Customer Benefit ', 'essb'), sprintf(__('Access to one click ready made styles install is benefit for direct plugin customers. <a href="%s" target="_blank"><b>See all direct customer benefits</b></a>', 'essb'), ESSBActivationManager::getBenefitURL()), 'fa24 fa fa-lock', 'glow');
		}
	
	}
	else {
		ESSBOptionsStructureHelper::panel_start('display', 'facebookchat', __('Activate display of Facebook Messenger Customer Live Chat', 'essb'), __('The Messenger Platform\'s customer chat plugin allows you to integrate your Messenger experience directly into your website. This allows your customers to interact with your business anytime with the same personalized, rich-media experience they get in Messenger.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'fbmessenger_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
		ESSBOptionsStructureHelper::field_checkbox_list('display', 'facebookchat', 'fbmessenger_posttypes', __('Appear only on selected post types', 'essb'), __('Limit function to work only on selected post types. Leave non option selected to make it work on all', 'essb'), essb_get_post_types());
		ESSBOptionsStructureHelper::field_switch('display', 'facebookchat', 'fbmessenger_deactivate_homepage', __('Deactivate display on homepage', 'essb'), __('Exclude display of function on home page of your site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'facebookchat', 'fbmessenger_pageid', __('Facebook Page ID', 'essb'), __('Enter your Facebook Page ID to connect live page with it (live chat cannot connect to personal profiles). To use live chat you also need to whitelist your domain in the Page settings. To do this visit your Facebook Page Settings and add/remove whitelisted domains (you need to add a valid domain - example: https://socialsharingplugin.com). Live chat works only if your site uses SSL protocol and can run only on a real domain (no IP address or localhost enviroment).', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'facebookchat', 'fbmessenger_appid', __('Facebook Application ID', 'essb'), __('Required to load Facebook API. To create one visit Facebook Developer Center.', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'facebookchat', 'fbmessenger_exclude', __('Exclude display on', 'essb'), __('Exclude appearance on posts/pages with these IDs. Comma separated: "11, 15, 125".', 'essb'), '');
		ESSBOptionsStructureHelper::field_switch('display', 'facebookchat', 'fbmessenger_minimized', __('Appear minimized', 'essb'), __('Set this option if you wish the chat to appear minimized', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		ESSBOptionsStructureHelper::field_switch('display', 'facebookchat', 'fbmessenger_left', __('Appear on the left', 'essb'), __('Change default appearance position to Left', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		
		
		ESSBOptionsStructureHelper::panel_end('display', 'facebookchat');
	}
}

if (!essb_option_bool_value('deactivate_module_skypechat')) {
	ESSBOptionsStructureHelper::menu_item('display', 'skypechat', __('Skype Live Chat', 'essb'), 'ti-facebook');

	if (!ESSBActivationManager::isActivated()) {
		if (!ESSBActivationManager::isThemeIntegrated()) {
			ESSBOptionsStructureHelper::hint('display', 'skypechat', __('Activate Plugin To Use This Feature', 'essb'), 'Hello! Please <a href="admin.php?page=essb_redirect_update&tab=update">activate your copy</a> of Easy Social Share Buttons for WordPress to unlock and use this feature.', 'fa24 fa fa-lock', 'glow');
		}
		else {
			ESSBOptionsStructureHelper::hint('display', 'skypechat', __('Direct Customer Benefit ', 'essb'), sprintf(__('Access to one click ready made styles install is benefit for direct plugin customers. <a href="%s" target="_blank"><b>See all direct customer benefits</b></a>', 'essb'), ESSBActivationManager::getBenefitURL()), 'fa24 fa fa-lock', 'glow');
		}

	}
	else {
		ESSBOptionsStructureHelper::panel_start('display', 'skypechat', __('Activate display of Skype Live Chat', 'essb'), __('Connect with your customers like never before', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'skype_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

		ESSBOptionsStructureHelper::field_checkbox_list('display', 'skypechat', 'skype_posttypes', __('Appear only on selected post types', 'essb'), __('Limit function to work only on selected post types. Leave non option selected to make it work on all', 'essb'), essb_get_post_types());
		ESSBOptionsStructureHelper::field_switch('display', 'skypechat', 'skype_deactivate_homepage', __('Deactivate display on homepage', 'essb'), __('Exclude display of function on home page of your site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'skypechat', 'skype_user', __('Your Skype UserID', 'essb'), __('Enter your user ID to start a chat with your visitors.', 'essb'));
		ESSBOptionsStructureHelper::field_select('display', 'skypechat', 'skype_type', __('Chat Button Style', 'essb'), __('Choose the initial chat style.', 'essb'), array('bubble' => 'Chat Bubble', 'rounded' => 'Rounded Button With Text'));
		
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'skypechat', 'skype_text', __('Custom chat button text', 'essb'), __('The custom chat button text will appear only if you select a rounded button style.', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'skypechat', 'skype_exclude', __('Exclude display on', 'essb'), __('Exclude appearance on posts/pages with these IDs. Comma separated: "11, 15, 125".', 'essb'), '');

		ESSBOptionsStructureHelper::panel_end('display', 'skypechat');
	}
}


if (!essb_option_bool_value('deactivate_module_natives')) {
	// native buttons
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('Activate usage of native like, follow and subscribe buttons', 'essb'), __('Native social buttons are great way to encourage more like, shares and follows as they are easy recognizable by users. Usage of them may affect site loading speed because they add additional calls and code to page load once they are initialized. Use them with caution.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'native_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_section_start_full_panels('display', 'native-1');
	ESSBOptionsStructureHelper::field_switch_panel('display', 'native-1', 'otherbuttons_sameline', __('Display on same line', 'essb'), __('Activate this option to display native buttons on same line with the share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('display', 'native-1', 'allow_native_mobile', __('Allow display of native buttons on mobile devices', 'essb'), __('The native buttons are set off by default on mobile devices because they may affect speed of mobile site version. If you wish to use them on mobile devices set this option to <b>Yes</b>.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('display', 'native-1', 'allnative_counters', __('Activate native buttons counter', 'essb'), __('Activate this option to display counters for native buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('display', 'native-1');
	ESSBOptionsStructureHelper::field_simplesort('display', 'native-1', 'native_order', __('Drag and Drop change position of display', 'essb'), __('Change order of native button display', 'essb'), essb_default_native_buttons());
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('Facebook button', 'essb'), __('Include Facebook native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_section_start_full_panels('display', 'native-1');
	ESSBOptionsStructureHelper::field_switch_panel('display', 'native-1', 'facebook_like_button', __('Include Facebook Like/Follow Button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('display', 'native-1', 'facebook_like_button_share', __('Include also Facebook Share Button', 'essb'), __('Since latest Facebook API changes like button makes only Like action. If you wish to allow users share we can recommend to activate this option too.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('display', 'native-1', 'facebook_like_button_api', __('My site already uses Facebook Api', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('display', 'native-1', 'facebook_like_button_api_async', __('Load Facebook API asynchronous', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('display', 'native-1', 'facebook_like_button_width', __('Set custom width of Facebook like button to fix problem with not rendering correct. Value must be number without px in it.', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('display', 'native-1', 'facebook_like_button_height', __('Set custom height of Facebook like button to fix problem with not rendering correct. Value must be number without px in it.', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('display', 'native-1', 'facebook_like_button_margin_top', __('Set custom margin-top (to move up use negative value) of Facebook like button to fix problem with not rendering correct. Value must be number without px in it.', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('display', 'native-1', 'facebook_like_button_lang', __('Custom language code for you native Facebook button', 'essb'), __('If you wish to change your native Facebook button language code from English you need to enter here your own code like es_ES. Full list of code can be found here: <a href="https://www.facebook.com/translations/FacebookLocales.xml" target="_blank">https://www.facebook.com/translations/FacebookLocales.xml</a>', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('display', 'native-1');
	$listOfOptions = array ("like" => "Like page", "follow" => "Profile follow" );
	
	ESSBOptionsStructureHelper::field_select('display', 'native-1', 'facebook_like_type', __('Button type', 'essb'), __('Choose button type you wish to use.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'facebook_follow_profile', __('Facebook Follow Profile Page URL', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'custom_url_like_address', __('Custom Facebook like button address', 'essb'), __('Provide custom address in case you wish likes to be added to that page - example fan page. Otherwise likes will be counted to page where button is displayed.', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('Google button', 'essb'), __('Include Google native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_switch('display', 'native-1', 'googleplus', __('Include Google +1/Follow Button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	$listOfOptions = array ("plus" => "+1 to page", "follow" => "Profile follow" );
	ESSBOptionsStructureHelper::field_select('display', 'native-1', 'google_like_type', __('Button type', 'essb'), __('Choose button type you wish to use.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'google_follow_profile', __('Google+ Follow Profile Page URL', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'custom_url_plusone_address', __('Custom Google +1 button address', 'essb'), __('Provide custom address in case you wish +1 to be added to that page - example profile page. Otherwise +1s will be counted to page where button is displayed.', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('Twitter button', 'essb'), __('Include Twitter native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_switch('display', 'native-1', 'twitterfollow', __('Twitter Tweet/Follow Button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	$listOfOptions = array ("follow" => "Follow user", "tweet" => "Tweet" );
	ESSBOptionsStructureHelper::field_select('display', 'native-1', 'twitter_tweet', __('Button type', 'essb'), __('Choose button type you wish to use.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'twitterfollowuser', __('Twitter Follow User', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('YouTube button', 'essb'), __('Include YouTube native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_switch('display', 'native-1', 'youtubesub', __('YouTube channel subscribe button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'youtubechannel', __('Channel ID', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('Pinterest button', 'essb'), __('Include Pinterest native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_switch('display', 'native-1', 'pinterestfollow', __('Include Pinterest Pin/Follow Button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	$listOfOptions = array ("follow" => "Profile follow", "pin" => "Pin button" );
	ESSBOptionsStructureHelper::field_select('display', 'native-1', 'pinterest_native_type', __('Button type', 'essb'), __('Choose button type you wish to use.', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'pinterestfollow_disp', __('Text on button when follow type is selected', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'pinterestfollow_url', __('Profile url when follow type is selected', 'essb'), __('Provide your Pinterest URL as it is seen at the browser, for example https://www.pinterest.com/appscreo.', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('LinkedIn button', 'essb'), __('Include LinkedIn native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_switch('display', 'native-1', 'linkedin_follow', __('Include LinkedIn button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'linkedin_follow_id', __('Company ID', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('ManagedWP button', 'essb'), __('Include ManagedWP native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_switch('display', 'native-1', 'managedwp_button', __('Include ManagedWP.org Upvote Button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-1', __('VKontankte (vk.com) button', 'essb'), __('Include VKontankte (vk.com) native button in your site', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	ESSBOptionsStructureHelper::field_switch('display', 'native-1', 'vklike', __('Include VK.com Like Button', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-1', 'vklikeappid', __('VKontakte (vk.com) Application ID', 'essb'), __('If you don\'t have application id for your site you need to generate one on VKontakte (vk.com) Dev Site. To do this visit this page http://vk.com/dev.php?method=Like and follow instructions on page', 'essb'));
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_end('display', 'native-1');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-2', __('Activate usage of skinned native buttons', 'essb'), __('This option will hide
			native buttons inside nice flat style boxes and show them on
			hover.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'skin_native', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	
	$skin_list = array ("flat" => "Flat", "metro" => "Metro" );
	ESSBOptionsStructureHelper::field_select('display', 'native-2', 'skin_native_skin', __('Native buttons skin', 'essb'), __('Choose skin for native buttons. It will be applied only when option above is activated.', 'essb'), $skin_list);
	
	foreach (essb_default_native_buttons() as $network) {
		ESSBOptionsStructureHelper::panel_start('display', 'native-2', ESSBOptionsStructureHelper::capitalize($network), __('Skinned settings for that social network', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
	
		ESSBOptionsStructureHelper::field_color('display', 'native-2', 'skinned_'.$network.'_color', __('Skinned button color replace', 'essb'), __('', 'essb'));
		ESSBOptionsStructureHelper::field_color('display', 'native-2', 'skinned_'.$network.'_hovercolor', __('Skinned button hover color replace', 'essb'), __('', 'essb'));
		ESSBOptionsStructureHelper::field_color('display', 'native-2', 'skinned_'.$network.'_textcolor', __('Skinned button text color replace', 'essb'), __('', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-2', 'skinned_'.$network.'_text', __('Skinned button text replace', 'essb'), '');
		ESSBOptionsStructureHelper::field_textbox('display', 'native-2', 'skinned_'.$network.'_width', __('Skinned button width replace', 'essb'), '', '', 'input60', 'fa-arrows-h', 'right');
		ESSBOptionsStructureHelper::panel_end('display', 'native-2');
	
	}
	ESSBOptionsStructureHelper::panel_end('display', 'native-2');
	
	ESSBOptionsStructureHelper::panel_start('display', 'native-3', __('Activate social privacy native buttons', 'essb'), __('When used in social privacy mode native buttons will not load until user click and request their activation. Usage in this mode is great way to avoid delay of load when you use natives and also this is the only way to use them in countries where native buttons should be used in two-click mode', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'native_privacy_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	foreach (essb_default_native_buttons() as $network) {
		ESSBOptionsStructureHelper::panel_start('display', 'native-3', ESSBOptionsStructureHelper::capitalize($network), __('Privacy settings for that social network', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));
		ESSBOptionsStructureHelper::field_textbox_stretched('display', 'native-3', 'skinned_'.$network.'_privacy_text', __('Privacy button text replace', 'essb'), '');
		ESSBOptionsStructureHelper::field_textbox('display', 'native-3', 'skinned_'.$network.'_privacy_width', __('Privacy button width replace', 'essb'), '', '', 'input60', 'fa-arrows-h', 'right');
		ESSBOptionsStructureHelper::panel_end('display', 'native-3');
	}
	ESSBOptionsStructureHelper::panel_end('display', 'native-3');
}

// Followers Counter
if (!essb_option_bool_value('deactivate_module_followers')) {
	ESSBOptionsStructureHelper::panel_start('display', 'follow-1', __('Activate Social Followers Counter', 'essb'), __('Activate this option to use followers counter widget and shortcodes', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'fanscounter_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	ESSBOptionsStructureHelper::field_switch('display', 'follow-1', 'fanscounter_widget_deactivate', __('I will not use Followers Counter widget', 'essb'), __('Activate this option in case you do not plan to use followers widget but just a shortcode call. Deactivation of widget when it is not used will save server resources on high traffic sites.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select('display', 'follow-1', 'essb3fans_update', __('Update period', 'essb'), __('Choose the time when counters will be updated. Default is 1 day if nothing is selected.', 'essb'), ESSBSocialFollowersCounterHelper::available_cache_periods());
	ESSBOptionsStructureHelper::field_select('display', 'follow-1', 'essb3fans_format', __('Number format', 'essb'), __('Choose default number format', 'essb'), ESSBSocialFollowersCounterHelper::available_number_formats());
	ESSBOptionsStructureHelper::field_switch('display', 'follow-1', 'essb3fans_uservalues', __('Allow user values', 'essb'), __('Activate this option to allow enter of user values for each social network. In this case when automatic value is less than user value the user value will be used', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch('display', 'follow-1', 'fanscounter_clear_on_save', __('Clear stored values on settings update', 'essb'), __('Mark yes to tell plugin clear previous updated values that are stored into database. You need this option if current stored value in database is greater than your current value of followers and you wish to make it update.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	
	ESSBOptionsStructureHelper::field_heading('display', 'follow-1', 'heading5', __('Social Networks', 'essb'));
	ESSBOptionsStructureHelper::field_checkbox_list_sortable('display', 'follow-1', 'essb3fans_networks', __('Social Networks', 'essb'), __('Order and activate networks you wish to use in widget and shortcodes'), ESSBSocialFollowersCounterHelper::available_social_networks(false));
	//essb3fans_
	
	ESSBOptionsStructureHelper::panel_end('display', 'follow-1');
	
	//ESSBOptionsStructureHelper::field_heading('display', 'follow-2', 'heading1', __('Social Profile Details', 'essb'));
	essb3_draw_fanscounter_settings('display', 'follow-2');
	
	ESSBOptionsStructureHelper::panel_start('display', 'follow-3', __('Display social followers as sidebar', 'essb'), __('Activate this option to get followers counter appear as sidebar attached to left or right side of screen. This is a great way to encorage users visit your social profiles (profile buttons on steroids).', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'fanscounter_sidebar', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	$defaults = ESSBSocialFollowersCounterHelper::default_instance_settings();
	$followers_default_options = ESSBSocialFollowersCounterHelper::default_options_structure(true, $defaults);
	ESSBOptionsStructureHelper::field_select('display', 'follow-3', 'essb3fans_sidebar_template', __('Template', 'essb'), __('Choose template that you will use on followers sidebar', 'essb'), $followers_default_options['template']['values']);
	ESSBOptionsStructureHelper::field_select('display', 'follow-3', 'essb3fans_sidebar_animation', __('Apply animation', 'essb'), __('Animation is a great way to grab visitors attention', 'essb'), $followers_default_options['animation']['values']);
	ESSBOptionsStructureHelper::field_switch('display', 'follow-3', 'essb3fans_sidebar_nospace', __('Without space between buttons', 'essb'), __('Activate this option to connect follower buttons and remove tiny space between them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select('display', 'follow-3', 'essb3fans_sidebar_orientation', __('Choose button layout style', 'essb'), __('Buttons can be horizontal or vertical. Choose the style that fits best into selected networks and site', 'essb'), array("h" => __("Horizontal", "essb"), "v" => __("Vertical", "essb")));
	ESSBOptionsStructureHelper::field_select('display', 'follow-3', 'essb3fans_sidebar_position', __('Choose position on screen', 'essb'), __('Choose position where you wish to appear sidebar display', 'essb'), array("left" => __("Left", "essb"), "right" => __("Right", "essb")));
	ESSBOptionsStructureHelper::field_textbox('display', 'follow-3', 'essb3fans_sidebar_width', __('Customize width of button', 'essb'), __('We choose default optimal width that fits in almost all sites. In some cases based on text you may need to shrink or extend button. Use this field to enter custom width (example: 100)', 'essb'), '', 'input60', 'fa-arrows-h', 'right');
	ESSBOptionsStructureHelper::panel_end('display', 'follow-3');

	// Custom Layout Builder
	ESSBOptionsStructureHelper::panel_start('display', 'follow-4', __('Create Custom Followers Counter Layout', 'essb'), __('Activate this option if you wish to build a custom layout of the followers counter. You will be able to choose a separate columns style for each network and include an eye catching cover box.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'fanscounter_layout', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));

	ESSBOptionsStructureHelper::panel_start('display', 'follow-4', __('Header Cover Box', 'essb'), '', '', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"));
	ESSBOptionsStructureHelper::field_switch_panel('display', 'follow-4', 'essb3fans_coverbox_show', __('Display cover box above networks', 'essb'), __('Set Yes to display the configured cover box.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select_panel('display', 'follow-4', 'essb3fans_coverbox_style', __('Main style', 'essb'), __('Main style choose the accent color that will be used to draw texts', 'essb'), array('' => 'Light', 'dark' => 'Dark'));
	ESSBOptionsStructureHelper::field_color_panel('display', 'follow-4', 'essb3fans_coverbox_bg', __('Custom background color', 'essb'), __('Setup custom background color that will appear in the cover box.', 'essb'), '', 'true');

	ESSBOptionsStructureHelper::field_image('display', 'follow-4', 'essb3fans_coverbox_profile', __('Profile image', 'essb'), __('Optional you can set a custom profile image that will appear', 'essb'), '', 'vertical1');
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'follow-4', 'essb3fans_coverbox_title', __('Title', 'essb'), __('Set own personalized title (shortcodes supported). Use [easy-total-followers] if you wish to display total number of followers in text', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('display', 'follow-4', 'essb3fans_coverbox_desc', __('Description text', 'essb'), __('Appearing in smaller text below title (shortcodes supported). Use [easy-total-followers] if you wish to display total number of followers in text', 'essb'));
	
	ESSBOptionsStructureHelper::panel_end('display', 'follow-4');
	
	//
	ESSBOptionsStructureHelper::field_select('display', 'follow-4', 'essb3fans_layout_cols', __('Columns', 'essb'), __('Choose the number of columns that will be used for custom layout.', 'essb'), array('2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns', '5' => '5 Columns', '6' => '6 Columns'));
	ESSBOptionsStructureHelper::field_select('display', 'follow-4', 'essb3fans_layout_total', __('Display total number of followers', 'essb'), __('Change option if you wish to make the total value appear.', 'essb'), array('' => 'Do not display total number block', 'top' => 'Block above networks', 'bottom' => 'Block below networks'));
	ESSBOptionsStructureHelper::hint('display', 'follow-4', '', __('The custom layout will display social networks that you activate from global plugin settings along with their order. In the block size setup you will see netowrks appearing in the deafult order from settings.', 'essb'), 'fa21 ti-ruler-pencil', 'glow');
	
	$network_list = ESSBSocialFollowersCounterHelper::available_social_networks(false);
	foreach ($network_list as $key => $network) {
		ESSBOptionsStructureHelper::field_select_panel('display', 'follow-4', 'essb3fans_layout_cols_'.$key, $network, __('Width of block for this social network inside layout or leave default for a single size.', 'essb'), array('' => 'Default column size from layout', '2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns', '5' => '5 Columns', '6' => '6 Columns'));
	}
	
	ESSBOptionsStructureHelper::panel_end('display', 'follow-4');
	
}

// Profiles
//ESSBOptionsStructureHelper::field_heading('display', 'profiles-1', 'heading5', __('Social Profile Settings', 'essb'));
if (!essb_option_bool_value('deactivate_module_profiles')) {
	ESSBOptionsStructureHelper::field_switch('display', 'profiles-1', 'profiles_widget', __('Activate social profiles widget and shortcode', 'essb'), __('Activate this option to install and use social profiles widget.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	
	ESSBOptionsStructureHelper::panel_start('display', 'profiles-1', __('Automatically generate and assing social profiles as sidebar', 'essb'), __('Activate this option to automatically generate sidebar with your social profile links', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'profiles_display', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
	$listOfOptions = array("left" => __("Left", "essb"), "right" => __("Right", "essb"), "topleft" => __("Top left", "essb"), "topright" => __("Top right", "essb"), "bottomleft" => __("Bottom left", "essb"), "bottomright" => __("Bottom right", "essb"));
	ESSBOptionsStructureHelper::field_select('display', 'profiles-1', 'profiles_display_position', __('Position of social profiles', 'essb'), __('Choose your social profiles position', 'essb'), $listOfOptions);
	ESSBOptionsStructureHelper::field_switch('display', 'profiles-1', 'profiles_mobile_deactivate', __('Deactivate social profiles on mobile', 'essb'), __('Activate this option to turn off display on mobile devices.', 'essb'), 'recommended', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch('display', 'profiles-1', 'profiles_nospace', __('Remove spacing between buttons', 'essb'), __('Activate this option to remove default space between share buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_select('display', 'profiles-1', 'profiles_template', __('Choose template that you will use for sidebar', 'essb'), __('Template assigned here will be used for sidebar and also for default template for widget and shortcodes if you use such. Each widget or shortcode includes options to personalize it.', 'essb'), ESSBSocialProfilesHelper::available_templates());
	ESSBOptionsStructureHelper::field_select('display', 'profiles-1', 'profiles_animation', __('Choose animation that you will use for sidebar', 'essb'), __('Animation assigned here will be used for sidebar and also for default template for widget and shortcodes if you use such. Each widget or shortcode includes options to personalize it.', 'essb'), ESSBSocialProfilesHelper::available_animations());
	ESSBOptionsStructureHelper::panel_end('display', 'profiles-1');
	
	
	ESSBOptionsStructureHelper::field_heading('display', 'profiles-1', 'heading5', __('Change the order of social profiles', 'essb'));
	ESSBOptionsStructureHelper::title('display', 'profiles-1', __('Customize order of social profile networks', 'essb'), '', 'inner-row');
	ESSBOptionsStructureHelper::field_checkbox_list_sortable('display', 'profiles-1', 'profile_networks', __('Social Networks', 'essb'), __('Order and activate networks you wish to use in widget and shortcodes'), ESSBSocialProfilesHelper::available_social_networks());
	
	essb_prepare_social_profiles_fields('display', 'profiles-2');
}

function essb3_draw_fanscounter_settings($tab_id, $menu_id) {
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

function essb_prepare_social_profiles_fields($tab_id, $menu_id) {

	foreach (essb_available_social_profiles() as $key => $text) {
		
		ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, $text, __('Configure social network details', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", "state" => "closed"));

		ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, 'profile_'.$key, __('Full address to profile', 'essb'), __('Enter address to your profile in social network', 'essb'));
		ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, 'profile_text_'.$key, __('Display text with icon', 'essb'), __('Enter custom text that will be displayed with link to your social profile. Example: Follow us on '.$text, 'essb'));
		ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
	}
}
