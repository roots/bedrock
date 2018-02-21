<?php

//---- automatic updates
if (!defined('ESSB3_ACTIVATION')) {
	ESSBOptionsStructureHelper::menu_item('update', 'automatic', __('Activate Plugin', 'essb'), 'refresh');
	ESSBOptionsStructureHelper::field_textbox_stretched('update', 'automatic', 'purchase_code', __('Purchase code', 'essb'), __('To activate automatic plugin updates you need to fill your purchase code.', 'essb'));
	ESSBOptionsStructureHelper::field_func('update', 'automatic', 'essb3_text_automatic_updates', '', '');
}
else {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-admin-options-activation.php');
}

//---- import export
ESSBOptionsStructureHelper::menu_item('import', 'backup', __('Export Settings', 'essb'), 'download');
ESSBOptionsStructureHelper::menu_item('import', 'backupimport', __('Import Settings', 'essb'), 'upload');

ESSBOptionsStructureHelper::menu_item('import', 'backup2', __('Export Followers Counter Settings', 'essb'), 'database');
ESSBOptionsStructureHelper::menu_item('import', 'backupimport2', __('Import Followers Counter Settings', 'essb'), 'database');

//ESSBOptionsStructureHelper::menu_item('import', 'readymade', __('Apply Ready Made Style', 'essb'), 'square');
ESSBOptionsStructureHelper::field_heading('import', 'backup', 'heading5', __('Export Plugin Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backup', 'essb3_text_backup', __('Export plugin settings', 'essb'), '');
ESSBOptionsStructureHelper::field_func('import', 'backup', 'essb3_text_backup1', __('Save plugin settings to file', 'essb'), '');
ESSBOptionsStructureHelper::field_heading('import', 'backupimport', 'heading5', __('Import Plugin Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backupimport', 'essb3_text_backup_import', __('Import plugin settings', 'essb'), '');
ESSBOptionsStructureHelper::field_func('import', 'backupimport', 'essb3_text_backup_import1', __('Import plugin settings from file', 'essb'), '');

ESSBOptionsStructureHelper::field_heading('import', 'backup2', 'heading5', __('Export Followers Counter Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backup2', 'essb3_text_backup2', __('Export Followers Counter Settings', 'essb'), '');
ESSBOptionsStructureHelper::field_heading('import', 'backupimport2', 'heading5', __('Import Followers Counter Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backupimport2', 'essb3_text_backup_import2', __('Import Followers Counter Settings', 'essb'), '');

//ESSBOptionsStructureHelper::field_func('import', 'readymade', 'essb3_text_readymade', __('Ready made configurations', 'essb'), 'WARNING! Importing configuration will overwrite all existing option values that you have set and load the predefined in the ready made configuration.');




//---- display



//---- advanced
ESSBOptionsStructureHelper::menu_item('advanced', 'optimization', __('Optimizations', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('advanced', 'advanced', __('Advanced Options', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('advanced', 'administrative', __('Administrative Options', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('advanced', 'deactivate', __('Deactivate Functions & Modules', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('advanced', 'counterrecovery', __('Share Counter Recovery', 'essb'), 'sign-in');
ESSBOptionsStructureHelper::menu_item('advanced', 'social-metrics', __('Social Metrics Lite', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('advanced', 'localization', __('Translate Options', 'essb'), 'default');
if (ESSBOptionValuesHelper::options_bool_value($essb_options, 'advanced_custom_share')) {
	ESSBOptionsStructureHelper::menu_item('advanced', 'advancedshare', __('Advanced Custom Share', 'essb'), 'default');
	essb3_prepare_advanced_custom_share('advanced', 'advancedshare');
}
ESSBOptionsStructureHelper::menu_item('advanced', 'translate', __('Make Easy Social Share Buttons speak your language', 'essb'), 'flag-o');

ESSBOptionsStructureHelper::menu_item('style', 'buttons', __('Color Customization', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('style', 'fans', __('Followers Counter Color Customization', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('style', 'image', __('Image Share Color Customization', 'essb'), 'default');
//ESSBOptionsStructureHelper::menu_item('style', 'subscribe', __('MailChimp Subscribe Form', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('style', 'css', __('Additional CSS', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('style', 'css2', __('Additional Footer CSS', 'essb'), 'default');
//ESSBOptionsStructureHelper::menu_item('advanced', 'advancedpost', __('Display Settings by Post Type', 'essb'), 'default');
//ESSBOptionsStructureHelper::menu_item('advanced', 'advancedcat', __('Display Settings by Post Category', 'essb'), 'default');

// -- option fields: social


//ESSBOptionsStructureHelper::field_section_start('social', 'sharing-3', __('Twitter share short url', 'essb'), __('Activate this option to share short url with Twitter.', 'essb'), 'yes');
//ESSBOptionsStructureHelper::field_switch('social', 'sharing-3', 'twitter_shareshort', __('Activate', 'essb'), __('Activate short url usage.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//$listOfOptions = array("wp" => "Build in WordPress function wp_get_shortlink()", "goo.gl" => "goo.gl", "bit.ly" => "bit.ly");
//if (defined('ESSB3_SSU_VERSION')) {
//	$listOfOptions['ssu'] = "Self-Short URL Add-on for Easy Social Share Buttons";
//}
//ESSBOptionsStructureHelper::field_select('social', 'sharing-3', 'twitter_shareshort_service', __('Short URL service', 'essb'), __('Choose the url service for Twitter', 'essb'), $listOfOptions);
//ESSBOptionsStructureHelper::field_checkbox('social', 'sharing-3', 'twitter_always_count_full', __('Make Twitter always count full post/page address when using short url', 'essb'), '');
//ESSBOptionsStructureHelper::field_section_end('social', 'sharing-3');
















// Social Profiles

// translate
ESSBOptionsStructureHelper::field_func('advanced', 'translate', 'essb4_translate_guide', '', '');


//social-metrics
//ESSBOptionsStructureHelper::field_heading('advanced', 'social-metrics', 'heading1', __('Social Metrics Lite', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'social-metrics', 'esml_active', __('Activate Social Metrics Lite', 'essb'), __('Activate Social Metrics Lite to start collect information for social shares.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_func('advanced', 'social-metrics', 'essb3_esml_post_type_select', __('Monitor following post types', 'essb'), __('Choose for which
		post types you want to collect information.', 'essb'));

$data_refresh = array ();
$data_refresh ['1'] = '1 hour';
$data_refresh ['2'] = '2 hours';
$data_refresh ['4'] = '4 hours';
$data_refresh ['8'] = '8 hours';
$data_refresh ['12'] = '12 hours';
$data_refresh ['24'] = '24 hours';
$data_refresh ['36'] = '36 hours';
$data_refresh ['48'] = '2 days';
$data_refresh ['72'] = '3 days';
$data_refresh ['96'] = '4 days';
$data_refresh ['120'] = '5 days';
$data_refresh ['168'] = '7 days';
ESSBOptionsStructureHelper::field_select('advanced', 'social-metrics', 'esml_ttl', __('Data refresh time', 'essb'), __('Length of time to store
		the statistics locally before downloading new data. A lower
		value will use more server resources. High values are
		recommended for blogs with over 50 posts.', 'essb'), $data_refresh);

$provider = array ();
$provider ['sharedcount'] = 'using sharedcount.com service';
$provider ['self'] = 'from my WordPress site with call to each social network';
ESSBOptionsStructureHelper::field_select('advanced', 'social-metrics', 'esml_provider', __('Choose update provider', 'essb'), __('Choose default metrics update
		provider. You can use sharedcount.com where all data is
		extracted with single call. According to high load of
		sharedcount you can use the another update method with native
		calls from your WordPress instance.', 'essb'), $provider);
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'social-metrics', 'esml_sharedcount_api', __('SharedCount.com API key', 'essb'), __('Provide your free SharedCount.com API access key. To get this key create account in SharedCount.com (in case you do not have such) and login into <a href="https://admin.sharedcount.com/admin/user/home.php" target="_blank">your profile settings</a> to find it.', 'essb'));

$listOfOptions = array("manage_options" => "Administrator", "delete_pages" => "Editor", "publish_posts" => "Author", "edit_posts" => "Contributor");
ESSBOptionsStructureHelper::field_select('advanced', 'social-metrics', 'esml_access', __('Plugin access', 'essb'), __('Make settings available for the following user roles (if you use multiple user roles on your site we recommend to select Administrator to disallow other users change settings of plugin).', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_switch('advanced', 'social-metrics', 'esml_top_posts_widget', __('Activate top social posts widget', 'essb'), __('Activate usage of top social posts widget. Widget requires Social Metrics Lite to be active for data update.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));


//shorturl


// ------------------------------------------------------
// Display Settings
// ------------------------------------------------------




//'advanced', 'optimization'
ESSBOptionsStructureHelper::field_heading('advanced', 'optimization', 'heading5', __('Static resource optimizations', 'essb'));

ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('CSS Styles Optimizations', 'essb'), __('Activate option that will optimize load of static css resources', 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization', __('CSS Styles Optimizations', 'essb'), __('Activate option that will optimize load of static css resources', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'use_minified_css', __('Use minified CSS files', 'essb'), __('Minified CSS files will improve speed of load. Activate this option to use them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_css_footer', __('Load plugin inline styles into footer', 'essb'), __('Activating this option will load dynamic plugin inline styles into footer.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');

ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Scripts load Optimizations', 'essb'), __('Activate option that will optimize load of all scripts used by plugin', 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization', __('Scripts load optimization', 'essb'), __('Activate option that will optimize load of static resources - css and javascript', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'use_minified_js', __('Use minified javascript files', 'essb'), __('Minified javascript files will improve speed of load. Activate this option to use them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'scripts_in_head', __('Load scripts in head element', 'essb'), __('If you are using caching plugin like W3 Total Cache you may need to activate this option if counters, send mail form or float do not work.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_js_async', __('Load plugin javascript files asynchronous', 'essb'), __('This will load scripts during page load in non render blocking way', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_js_defer', __('Load plugin javascript files deferred', 'essb'), __('This will load scripts after page load in non render blocking way', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_js_delayed', __('Load plugin javascript files delayed', 'essb'), __('This will load scripts after 2 seconds when page is fully loaded', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');

ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Global Optimizations', 'essb'), __('Global optimizations applied on all type of static resources used by plugin', 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization', __('Global resource load optimizations', 'essb'), __('Activate option that will optimize load of static javascript resources', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'remove_ver_resource', __('Remove version number from static resource files', 'essb'), __('Activating this option will remove added to resources version number ?ver= which will allow these files to be cached.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'precompiled_resources', __('Use plugin precompiled resources', 'essb'), __('Activating this option will precompile and cache plugin dynamic resources to save load time. Precompiled resources can be used only when you use same configuration on your entire site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');

$cache_plugin_detected = "";
if (ESSBCacheDetector::is_cache_plugin_detected()) {
	$cache_plugin_detected = "<br/><br/> Cache plugin detected: <b>".ESSBCacheDetector::cache_plugin_name().'</b>. When you use cache plugin we recommend not to turn on the build in caching function because your cache plugin already does that.';
}

ESSBOptionsStructureHelper::field_heading('advanced', 'optimization', 'heading5', __('Build in cache', 'essb'));

ESSBOptionsStructureHelper::hint('advanced', 'optimization', __('', 'essb'), __('For a blazing fast loading site we recommend usage of cache plugin like <a href="http://wp-rocket.me" target="_blank">WP Rocket</a>. <a href="http://wp-rocket.me" target="_blank">WP Rocket</a> is simple to setup, works out of the box and has full mobile caching support.', 'essb'), '');
ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Build in plugin cache', 'essb'), __('Activate build in cache functions to improve speed of load. If you use a site cache plugin activation of those options is not needed as that plugin will do the cache work.'.$cache_plugin_detected, 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization', __('Build in cache', 'essb'), __('Activate build in cache functions to improve speed of load. If you use a site cache plugin activation of those options is not needed as that plugin will do the cache work.'.$cache_plugin_detected, 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache_runtime', __('Activate WordPress cache', 'essb'), __('Activating WordPress cache function usage will cache button generation via default WordPress cache or via the persistant cache plugin if you use such (like W3 Total Cache)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache', __('Activate cache', 'essb'), __('This option is in beta and if you find any problems using it please report at our <a href="http://support.creoworx.com" target="_blank">support portal</a>. To clear cache you can simply press Update Settings button in Main Settings (cache expiration time is 1 hour)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$cache_mode = array ("full" => "Cache button render and dynamic resources", "resource" => "Cache only dynamic resources", "buttons" => "Cache only buttons render" );
ESSBOptionsStructureHelper::field_select_panel('advanced', 'optimization', 'essb_cache_mode', __('Cache mode', 'essb'), __('Choose between caching full render of share buttons and resources or cache only dynamic resources (CSS and Javascript).', 'essb'), $cache_mode);
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization', __('Build in cache', 'essb'), __('Activate build in cache functions to improve speed of load. If you use a site cache plugin activation of those options is not needed as that plugin will do the cache work.'.$cache_plugin_detected, 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache_static', __('Combine into single file all plugin static CSS files', 'essb'), __('This option will combine all plugin static CSS files into single file.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache_static_js', __('Combine into single file all plugin static javascript files', 'essb'), __('This option will combine all plugin static javacsript files into single file. This option will not work if scripts are set to load asynchronous or deferred.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');

ESSBOptionsStructureHelper::field_textbox('advanced', 'advanced', 'priority_of_buttons', __('Change default priority of buttons', 'essb'), __('Provide custom value of priority when buttons will be included in content (default is 10). This will make code of plugin to execute before or after another plugin. Attention! Providing incorrect value may cause buttons not to display.', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'essb_avoid_nonmain', __('Prevent buttons from appearing on non associated parts of content', 'essb'), __('Very rear you may see buttons appearing on not associated parts of content. Activate this option to prevent it.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_start('advanced', 'advanced', __('Clean buttons from excerpts', 'essb'), __('Activate this option to avoid buttons included in excerpts as text FacebookTwiiter and so.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'apply_clean_buttons', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
$methods = array ("default" => "Clean network texts", "actionremove" => "Remove entire action", "clean2" => "Smart clean network texts", "remove2" => "Show buttons only on mail query" );
ESSBOptionsStructureHelper::field_select('advanced', 'advanced', 'apply_clean_buttons_method', __('Clean method', 'essb'), __('Choose method of buttons clean.', 'essb'), $methods);
ESSBOptionsStructureHelper::panel_end('advanced', 'advanced');

ESSBOptionsStructureHelper::panel_start('advanced', 'advanced', __('URL and Message encoding', 'essb'), __('Url and message encoding allows you to encode some parts of shared content if it is not properly send to social networks', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'essb_encode_url', __('Use encoded version of url for sharing', 'essb'), __('Activate this option to encode url used for sharing. This is option is recommended when you notice that parts of shared url are missing - usually when additional options are used like campaign tracking.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'essb_encode_text', __('Use encoded version of texts for sharing', 'essb'), __('Activate this option to encode texts used for sharing. You need to use this option when you have special characters which does not appear in share.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'essb_encode_text_plus', __('Fix problem with appearing + in text when shared via mobile', 'essb'), __('Activate this option to fix the problem with + sign that appears in share description (usually in Tweet when Twitter App is used).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('advanced', 'advanced');

ESSBOptionsStructureHelper::panel_start('advanced', 'advanced', __('Plugin does not share correct data', 'essb'), __('Various options that correct problems with shared information.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'avoid_nextpage', __('Avoid &lt;!--nextpage--&gt; and always share main post address', 'essb'), __('Activate this option if you use multi-page posts and wish to share only main page.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'force_wp_query_postid', __('Force get of current post/page', 'essb'), __('Activate this option if share doest not get correct page.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'reset_postdata', __('Reset WordPress loops', 'essb'), __('Activate this option if plugin does not detect properly post permalink.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'force_wp_fullurl', __('Allow usage of query string parameters in share address', 'essb'), __('Activate this option to allow usage of query string parameters in url (there are plugins that use this).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'force_archive_pages', __('Correct shared data when sidebar, top bar, bottom bar, pop up or fly in are used in archive pages', 'essb'), __('Activate this option if you se sidebar, top bar, bottom bar, pop up or fly in on archive pages (list of posts, posts by tag or category, homepage with latest posts) and plugin does not detect the correct shared information.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'deactivate_shorturl_cache', __('Deactivate short url cache', 'essb'), __('Activate this option to stop cache of short url (mainly it is used if incorrect address was initially cached).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'always_use_http', __('Make plugin share always http version of page', 'essb'), __('When you migrate from http to https all social share counters will go down to zero (0) because social networks count shares by the unique address of post/page. Making this will allow plugin always to use post/page http version of address.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('advanced', 'advanced');

ESSBOptionsStructureHelper::panel_start('advanced', 'advanced', __('Other rearly appear problems', 'essb'), __('Fixes for rearly appearing problems related to counters or button appearance.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'reset_posttype', __('Duplicate check to avoid buttons appear on not associated post types', 'essb'), __('Activate this option if buttons appear on post types that are not marked as active.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'counter_curl_fix', __('Fix counter problem with limited cURL configuration', 'essb'), __('Activate this option if have troubles displaying counters for networks that do not have native access to counter API (ex: Google). To make it work you also need to activate in Display Settings -> Counters to load with WordPress admin ajax function..', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'deactivate_fa', __('Do not load FontAwsome', 'essb'), __('Activate this option if your site already uses Font Awesome font.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'use_rel_me', __('Add rel="me" instead of rel="nofollow" to social share buttons', 'essb'), __('Activate this option if your SEO strategy requires this. Default is nofollow which is suggested value.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch('advanced', 'advanced', 'legacy_class', __('Include class names in CSS from version 2.x', 'essb'), __('Activate this option if you use class names for customization that do not exist in new version.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_end('advanced', 'advanced');


//ESSBOptionsStructureHelper::field_heading('advanced', 'administrative', 'heading1', __('Administrative Options', 'essb'));
//$admin_style = array ("" => "Dark", "light" => "Light" );
//ESSBOptionsStructureHelper::field_select('advanced', 'administrative', 'admin_template', __('Plugin Settings Style', 'essb'), __('Change plugin default options style', 'essb'), $admin_style);
ESSBOptionsStructureHelper::panel_start('advanced', 'administrative', __('Disable plugin functionalities', 'essb'), __('Disable special plugin functions that you will not use or you do not need.', 'essb'), 'fa21 fa fa-times', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative', __('Disable plugin functionalities', 'essb'), __('Disable special plugin functions that you will not use or you do not need.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'deactivate_appscreo', __('Deactivate checks for news and extensions', 'essb'), __('Plugin has build in option to display latest useful tips from our blogs and notifcations for add-ons that we release. If your server is located in zone that prevents access from specific country hosted servers than you may see delay in load of WordPress admin or strange notice messages. If that happens activate this option to turn off those checks.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'deactivate_ajaxsubmit', __('Deactivate AJAX submit of settings', 'essb'), __('Activate this option if for some reason your settings inside plugin do not save.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', 'true');
//disable_welcome
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'disable_welcome', __('Do not show Welcome screen', 'essb'), __('Use this option to deactivate display of Welcome screen with quick links to plugin functions', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
//live_customizer_disabled
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'live_customizer_disabled', __('Turn off front end Quick plugin setup', 'essb'), __('The front end quick setup is limited for usage by administrators only. Activate this option if you wish to remove it completely.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'disable_translation', __('Do not load translations of interface', 'essb'), __('All plugin translations are made with love from our customers. If you do not wish to use it activate this option and plugin will load with default English language.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'using_elementor', __('I am using Elementor Page Builder', 'essb'), __('Activate this option if you se Elementor page builder and your post customizations (or share buttons) disappear once you save page created with this builder.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::panel_end('advanced', 'administrative');

ESSBOptionsStructureHelper::panel_start('advanced', 'administrative', __('Advanced Display Options', 'essb'), __('Activate additional advanced options for customization and sharing', 'essb'), 'fa21 fa fa-television', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative', __('Disable plugin functionalities', 'essb'), __('Disable special plugin functions that you will not use or you do not need.', 'essb'));
//ESSBOptionsStructureHelper::field_switch('advanced', 'administrative', 'advanced_by_post_category', __('Activate custom style settings for post category', 'essb'), __('Activation of this option will add additional menu settings for each post category that you have which will allow to change style of buttons.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'advanced_custom_share', __('Activate custom share by social network', 'essb'), __('Activation of this option will add additional menu settings for message share customization by social network.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//float_onsingle_only
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'float_onsingle_only', __('Float display methods on single posts/pages only', 'essb'), __('Plugin will check and display float from top and post vertical float only when a single post/page is being displayed. In all other case method will be replaced with display method top.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::panel_end('advanced', 'administrative');


ESSBOptionsStructureHelper::panel_start('advanced', 'administrative', __('Plugin Settings Access', 'essb'), __('Control access to various plugin settings', 'essb'), 'fa21 fa fa-key', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative', __('Disable plugin functionalities', 'essb'), __('Disable special plugin functions that you will not use or you do not need.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'disable_adminbar_menu', __('Disable menu in WordPress admin bar', 'essb'), __('Activation of this option will remove the quick access plugin menu from WordPress top admin bar.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("manage_options" => "Administrator", "delete_pages" => "Editor", "publish_posts" => "Author", "edit_posts" => "Contributor");
ESSBOptionsStructureHelper::field_select_panel('advanced', 'administrative', 'essb_access', __('Plugin access', 'essb'), __('Make settings available for the following user roles (if you use multiple user roles on your site we recommend to select Administrator to disallow other users change settings of plugin).', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::panel_end('advanced', 'administrative');

ESSBOptionsStructureHelper::panel_start('advanced', 'administrative', __('Metabox visibiltiy', 'essb'), __('Show/hide plugin on post metaboxes', 'essb'), 'fa21 fa fa-eye', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative', __('Disable plugin functionalities', 'essb'), __('Disable special plugin functions that you will not use or you do not need.', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'turnoff_essb_advanced_box', __('Remove post advanced visual settings metabox', 'essb'), __('Activation of this option will remove the advanced meta box on each post that allow customizations of visual styles for post.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'turnoff_essb_optimize_box', __('Remove post share customization metabox', 'essb'), __('Activation of this option will remove the share customization meta box on each post (allows changing social share optimization tags, customize share and etc.).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'turnoff_essb_stats_box', __('Remove post detailed stats metabox', 'essb'), __('Activation of this option will remove the detailed stats meta box from each post/page when social share analytics option is activated.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::panel_end('advanced', 'administrative');


ESSBOptionsStructureHelper::field_func('advanced', 'administrative', 'essb3_reset_postdata', __('Reset plugin settings', 'essb'), __('Warning! Pressing this button will restore initial plugin configuration values and all settings that you apply after plugin activation will be removed.', 'essb'));

//ESSBOptionsStructureHelper::field_heading('advanced', 'deactivate', 'heading1', __('Deactivate Functions & Modules', 'essb'));

ESSBOptionsStructureHelper::panel_start('advanced', 'deactivate', __('Internal Modules', 'essb'), __('Turn off internal modules of plugin that does not have option inside their settings to do this.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'deactivate', __('Modules', 'essb'), __('Turn off build in modules that does not have option in their settings', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_ctt', __('Deactivate Sharable Quotes module', 'essb'), __('This option will deactivate and remove code used by click to tweet module', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_module_aftershare', __('Deactivate After Share module', 'essb'), __('This option will deactivate and remove code used by after share module', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_mobile', __('Deactivate plugin on mobile', 'essb'), __('Use this option to completely deactivate plugin usage on mobile devices inlcuding all of its modules.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_mobile_share', __('Deactivate social share buttons on mobile', 'essb'), __('This option will deactivate share function on mobile devices but it will keep up showing all other modules.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'deactivate');
ESSBOptionsStructureHelper::panel_end('advanced', 'deactivate');


ESSBOptionsStructureHelper::panel_start('advanced', 'deactivate', __('Display Methods', 'essb'), __('Easy Social Share Buttons has so many display methods but we suppose you will not use all at same time (or at least we hope so). As an advice from us to speed up work you can deactivate display methods that you will not use (you can activate them again at any time).', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'deactivate', __('Display methods', 'essb'), __('Easy Social Share Buttons has so many display methods but we suppose you will not use all at same time (or at least we hope so). As an advice from us to speed up work you can deactivate display methods that you will not use (you can activate them again at any time).', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_float', __('Turn off Float from Top', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_postfloat', __('Turn off Post Vertical Float', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_sidebar', __('Turn off Sidebar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_topbar', __('Turn off Top Bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_bottombar', __('Turn off Bottom Bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_popup', __('Turn off Pop Up', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_flyin', __('Turn off Fly In', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_heroshare', __('Turn off Full Screen Hero Share', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_postbar', __('Turn off Post Bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'deactivate', 'deactivate_method_point', __('Turn off Point', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'deactivate');
ESSBOptionsStructureHelper::panel_end('advanced', 'deactivate');


ESSBOptionsStructureHelper::panel_start('advanced', 'deactivate', __('Plugin Functions', 'essb'), __('Deactivate functions of plugin on selected posts/pages only', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_share', __('Social Share Buttons', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_native', __('Native Buttons', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_fanscounter', __('Social Following (Followers Counter)', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_ctt', __('Sharable Quotes (Click To Tweet)', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_sis', __('On Media Sharing (Social Image Share)', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_profiles', __('Social Profiles', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_sso', __('Social Share Optimization Meta Tags', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'deactivate', 'deactivate_on_aftershare', __('After Share Actions', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::panel_end('advanced', 'deactivate');

//ESSBOptionsStructureHelper::field_heading('advanced', 'counterrecovery', 'heading1', __('Share Counter Recovery', 'essb'));
if (!defined('ESSB3_CACHED_COUNTERS')) {
	//ESSBOptionsStructureHelper::field_func('advanced', 'counterrecovery', 'essb3_counter_recovery', __('Activate share counter recovery', 'essb'), __('Share counter recovery allows you recover share counters when you move to secure server or from different domain.', 'essb'));
	ESSBOptionsStructureHelper::hint('advanced', 'counterrecovery', __('Share counter recovery is not active untill you switch to cached share counters', 'essb'), __('Share counter recovery can work only when you activate cached update mode of share counters. Till you activate this options below will not work. This is required to prevent server from hangout when recovery connections are executed. <br/><br/><b>To change mode of share counters update please visit Social Sharing -> Counters and choose from top right corner update method to be something different from Real Time share counters</b>', 'essb'), 'fa32 ti-info-alt', 'red');
	
}
//else {
	ESSBOptionsStructureHelper::field_switch('advanced', 'counterrecovery', 'counter_recover_active', __('Activate share counter recovery', 'essb'), __('Share counter recovery allows you recover share counters when you move to secure server or from different domain.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

	$recover_type = array("unchanged" => "Unchanged", "default" => "Default", "dayname" => "Day and Name", "monthname" => "Month and Name", "numeric" => "Numeric", "postname" => "Post Name", "domain" => "Change domain name");
	ESSBOptionsStructureHelper::field_select('advanced', 'counterrecovery', 'counter_recover_mode', __('Previous url format or domain', 'essb'), __('Choose how your site address is changed', 'essb'), $recover_type);
	ESSBOptionsStructureHelper::field_switch('advanced', 'counterrecovery', 'counter_recover_slash', __('My previous url does not have trailing slash', 'essb'), __('Activate this option if your previous url does not contain trailing slash at the end.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));

	$recover_mode = array("unchanged" => "Unchanged", "http2https" => "Switch from http to https", "https2http" => "Switch from https to http");
	ESSBOptionsStructureHelper::field_select('advanced', 'counterrecovery', 'counter_recover_protocol', __('Change of connection protocol', 'essb'), __('If you change your connection protocol then choose here the option that describes it.', 'essb'), $recover_mode);
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'counterrecovery', 'counter_recover_domain', __('Previous domain name', 'essb'), __('If you have changed your domain name please fill in this field previous domain name with protocol (example http://example.com) and choose recovery mode to be <b>Change domain name</b>', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'counterrecovery', 'counter_recover_newdomain', __('New domain name', 'essb'), __('If plugin is not able to detect your new domain fill here its name with protocol (example http://example.com)', 'essb'));
	ESSBOptionsStructureHelper::field_textbox('advanced', 'counterrecovery', 'counter_recover_date', __('Date of change', 'essb'), __('Fill out date when change was made. Once you fill it share counter recovery will be made for all posts that are published before this date. Date shoud be filled in format <b>yyyy-mm-dd</b>.', 'essb'));
//}


//ESSBOptionsStructureHelper::field_heading('advanced', 'localization', 'heading1', __('Translation Options', 'essb'));
//ESSBOptionsStructureHelper::field_section_start('advanced', 'localization', __('Mail form texts', 'essb'), __('Translate mail form texts', 'essb'));
ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Mail form texts', 'essb'), __('Translate mail form texts', 'essb'), 'fa ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_title', __('Share this with a friend', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_email', __('Your Email', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_recipient', __('Recipient Email', 'essb'), __('', 'essb'));
//ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_subject', __('Subject', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_custom', __('Custom user message', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_cancel', __('Cancel', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_send', __('Send', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_captcha', __('Fill in captcha code text', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_message_sent', __('Message sent!', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_message_invalid_captcha', __('Invalid Captcha code!', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_message_error_send', __('Error sending message!', 'essb'), __('', 'essb'));
//ESSBOptionsStructureHelper::field_section_end('advanced', 'localization');
ESSBOptionsStructureHelper::panel_end('advanced', 'localization');

ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Love this button messages', 'essb'), __('Translate love this button messages', 'essb'), 'fa ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_love_thanks', __('Thank you for loving this.', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_love_loved', __('You already love this today.', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::panel_end('advanced', 'localization');

//ESSBOptionsStructureHelper::field_section_start('advanced', 'localization', __('Text on button hover', 'essb'), __('Provide texts that will appear when you hover a social share button (example: Share this article on Facebook). Texts will appear only when they are provided - leave blank for no text.', 'essb'));
ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Custom texts that will appear on button hover', 'essb'), __('Enter custom texts that will appear on button hover', 'essb'), 'fa ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
essb3_prepare_texts_on_button_hover('advanced', 'localization');
ESSBOptionsStructureHelper::panel_end('advanced', 'localization');

ESSBOptionsStructureHelper::field_section_start('advanced', 'localization', __('Plugin module texts', 'essb'), __('Include options to translate build in module texts that have no field in module settings', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_clicktotweet', __('Translate Click To Tweet text', 'essb'), __('', 'essb'));
ESSBOptionsStructureHelper::field_section_end('advanced', 'localization');


//--- Style Settings
//ESSBOptionsStructureHelper::field_heading('style', 'buttons', 'heading1', __('Color Customization', 'essb'));
//ESSBOptionsStructureHelper::field_switch('style', 'buttons', 'customizer_is_active', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option. You are able to activate customization on specific post/pages even if this option is not set to active.<br/><span class="essb-user-notice">After switching option to <b>Yes</b> press <b>Update Settings</b> button and advanced configuration fields will appear.</span>', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_start('style', 'buttons', __('Activate customization of template', 'essb'), __('Customization allows you to change colors of each button or total counter. Your are also able to activate customizer for specific pages only via on post styles.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'customizer_is_active', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb'), 'switch_submit' => 'true'));


$customizer_is_active = ESSBOptionValuesHelper::options_bool_value($essb_options, 'customizer_is_active');
if ($customizer_is_active) {
	ESSBOptionsStructureHelper::panel_start('style', 'buttons', __('Total counter style', 'essb'), __('Customize total counter colors and font size', 'essb'), 'fa21 ti-ruler-pencil', array("mode" => "toggle"));
	ESSBOptionsStructureHelper::field_section_start_full_panels('style', 'buttons', __('Total Counter', 'essb'), __('Customize the total counter', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel('style', 'buttons', 'customizer_totalbgcolor', __('Background color', 'essb'), __('Replace total counter background color', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('style', 'buttons', 'customizer_totalnobgcolor', __('Remove background color', 'essb'), __('Activate this option to remove the background color', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel('style', 'buttons', 'customizer_totalcolor', __('Text color', 'essb'), __('Replace total counter text color', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('style', 'buttons');
	ESSBOptionsStructureHelper::field_section_start_full_panels('style', 'buttons', __('Total Counter', 'essb'), __('Customize the total counter', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('style', 'buttons', 'customizer_totalfontsize', __('Total counter big style font-size', 'essb'), __('Enter value in px (ex: 21px) to change the total counter font-size', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('style', 'buttons', 'customizer_totalfontsize_after', __('Total counter big style shares text font-size', 'essb'), __('Enter value in px (ex: 10px) to change the total counter shares text font-size', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('style', 'buttons', 'customizer_totalfontsize_beforeafter', __('Total counter before/after share buttons text font-size', 'essb'), __('Enter value in px (ex: 14px) to change the total counter text font-size', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('style', 'buttons');
	ESSBOptionsStructureHelper::panel_end('style', 'buttons');
	
	ESSBOptionsStructureHelper::panel_start('style', 'buttons', __('Customization for all social networks', 'essb'), __('Provide settings that will be applied over all social networks at once. Below you can also customize settings for single network as well.', 'essb'), 'fa21 ti-ruler-pencil', array("mode" => "toggle"));
	ESSBOptionsStructureHelper::field_section_start_full_panels('style', 'buttons', __('Color customization for all social networks', 'essb'), __('Choose color settings that will be applied for all social networks', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel('style', 'buttons', 'customizer_bgcolor', __('Background color', 'essb'), __('Replace all buttons background color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel('style', 'buttons', 'customizer_textcolor', __('Text color', 'essb'), __('Replace all buttons text color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel('style', 'buttons', 'customizer_hovercolor', __('Hover background color', 'essb'), __('Replace all buttons hover background color', 'essb'));
	ESSBOptionsStructureHelper::field_color_panel('style', 'buttons', 'customizer_hovertextcolor', __('Hover text color', 'essb'), __('Replace all buttons hover text color', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('style', 'buttons', 'customizer_remove_bg_hover_effects', __('Remove effects applied from theme on hover', 'essb'), __('Activate this option to remove the default theme hover effects (like darken or lighten color).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('style', 'buttons');
	ESSBOptionsStructureHelper::field_section_start_full_panels('style', 'buttons', __('Total Counter', 'essb'), __('Customize the total counter', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('style', 'buttons', 'customizer_iconsize', __('Icon size', 'essb'), __('Provide custom icon size value. Default value for almost all templates is 18. Please enter value without any symbols before/after it - example: 22', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_panel('style', 'buttons', 'customizer_namesize', __('Network name font size', 'essb'), __('Enter value in px (ex: 10px) to change the network name text font-size', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('style', 'buttons', 'customizer_namebold', __('Make network name bold', 'essb'), __('Activate this option to apply bold style over network name', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_switch_panel('style', 'buttons', 'customizer_nameupper', __('Make network name upper case', 'essb'), __('Activate this option to apply automatic transform to upper case over network name', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
	ESSBOptionsStructureHelper::field_section_end_full_panels('style', 'buttons');
	ESSBOptionsStructureHelper::panel_end('style', 'buttons');
	
	ESSBOptionsStructureHelper::field_heading('style', 'buttons', 'heading5', __('Color customization for single social networks', 'essb'));
	essb3_prepare_color_customization_by_network('style', 'buttons');
}
ESSBOptionsStructureHelper::panel_end('style', 'buttons');
//ESSBOptionsStructureHelper::field_heading('style', 'css', 'heading1', __('Additional CSS', 'essb'));
ESSBOptionsStructureHelper::field_editor('style', 'css', 'customizer_css', __('Additional custom CSS', 'essb'), __('Provide your own custom CSS code that will be used only when plugin is active', 'essb'));

//ESSBOptionsStructureHelper::field_heading('style', 'css2', 'heading1', __('Additional Footer CSS', 'essb'));
ESSBOptionsStructureHelper::field_editor('style', 'css2', 'customizer_css_footer', __('Additional custom CSS that will be added to footer', 'essb'), __('Add custom CSS code here if you wish that code to be included into footer of site', 'essb'));

//ESSBOptionsStructureHelper::field_heading('style', 'fans', 'heading1', __('Followers Color Customization', 'essb'));
//ESSBOptionsStructureHelper::field_switch('style', 'fans', 'activate_fanscounter_customizer', __('Activate color customizer', 'essb'), __('Color customizations will not be included unless you activate this option. You are able to activate customization on specific post/pages even if this option is not set to active.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::panel_start('style', 'fans', __('Activate customization of followers counter colors', 'essb'), __('Activate this option to get range of options to change color for each network into followers counter. The change will be applied on selected template and on any instance of follower buttons', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'activate_fanscounter_customizer', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
essb3_draw_fanscounter_customization('style', 'fans');
ESSBOptionsStructureHelper::panel_end('style', 'fans');

ESSBOptionsStructureHelper::panel_start('style', 'image', __('Activate customization of on media sharing button colors', 'essb'), __('Activate this option to get range of options to change color for each network into on media sharing.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'activate_imageshare_customizer', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
essb3_draw_imageshare_customization('style', 'image');
ESSBOptionsStructureHelper::panel_end('style', 'image');

// Easy Optin


// settings by post type
$positions_by_pt = ESSBOptionValuesHelper::options_bool_value($essb_options, 'positions_by_pt');


add_action('admin_init', 'essb3_register_settings_by_posttypes');
function essb3_register_settings_by_posttypes() {
	global $wp_post_types;

	$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );
	$first_post_type = "";
	$key = 1;
	foreach ( $pts as $pt ) {
		if (empty ( $first_post_type )) {
			$first_post_type = $pt;
			ESSBOptionsStructureHelper::menu_item ( 'advanced', 'advancedpost', __ ( 'Display Settings by Post Type', 'essb' ), 'default', 'activate_first', 'advancedpost-1' );
		}
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedpost-' . $key, $wp_post_types [$pt]->label );

		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedpost-' . $key, 'heading1', __('Advanced settings for post type: '.$wp_post_types [$pt]->label, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedpost-' . $key, 'post-type-'.$pt, true );
		$key ++;
	}

	foreach ( $cpts as $cpt ) {
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedpost-' . $key, $wp_post_types [$cpt]->label );
		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedpost-' . $key, 'heading1', __('Advanced settings for post type: '.$wp_post_types [$cpt]->label, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedpost-' . $key, 'post-type-'.$cpt, true );
		$key ++;
	}

	ESSBOptionsStructureHelper::menu_item ( 'advanced', 'advancedmodule', __ ( 'Display Settings for Plugin Integration', 'essb' ), 'default', 'activate_first', 'advancedmodule-1' );
	$key = 1;
	$cpt = 'woocommerce';
	$cpt_title = 'WooCommerce';
	ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
	ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
	essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
	$key ++;

	$cpt = 'wpecommerce';
	$cpt_title = 'WP e-Commerce';
	ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
	ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
	essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
	$key ++;

	$cpt = 'jigoshop';
	$cpt_title = 'JigoShop';
	ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
	ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
	essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
	$key ++;

	$cpt = 'ithemes';
	$cpt_title = 'iThemes Exchange';
	ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
	ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
	essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
	$key ++;

	$cpt = 'bbpress';
	$cpt_title = 'bbPress';
	ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
	ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
	essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
	$key ++;

	$cpt = 'buddypress';
	$cpt_title = 'BuddyPress';
	ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
	ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
	essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
	$key ++;

}

function essb3_draw_imageshare_customization($tab_id, $menu_id) {
	$listOfNetworksAdvanced = array( "facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google", "linkedin" => "LinkedIn", "pinterest" => "Pinterest", "tumblr" => "Tumblr", "reddit" => "Reddit", "digg" => "Digg", "delicious" => "Delicious", "vkontakte" => "VKontakte", "odnoklassniki" => "Odnoklassniki");

	foreach ($listOfNetworksAdvanced as $network => $title) {
		ESSBOptionsStructureHelper::field_color($tab_id, $menu_id, 'imagecustomizer_'.$network, $title, '');
	}
}

function essb3_draw_fanscounter_customization($tab_id, $menu_id) {
	$network_list = ESSBSocialFollowersCounterHelper::available_social_networks();

	if (defined('ESSB3_SFCE_VERSION')) {
		$network_list = ESSBSocialFollowersCounterHelper::list_of_all_available_networks_extended();
	}

	foreach ($network_list as $network => $title) {
		ESSBOptionsStructureHelper::field_color($tab_id, $menu_id, 'fanscustomizer_'.$network, $title, '');
	}
}


function essb3_prepare_color_customization_by_network($tab_id, $menu_id) {
	global $essb_networks;

	$checkbox_list_networks = array();
	foreach ($essb_networks as $key => $object) {
		$checkbox_list_networks[$key] = $object['name'];
	}

	foreach ($checkbox_list_networks as $key => $text) {
		
		ESSBOptionsStructureHelper::panel_start($tab_id, $menu_id, $text, __('Configure additional options for this network', 'essb'), 'fa21 essb_icon_'.$key, array("mode" => "toggle", 'state' => 'closed'));		
		ESSBOptionsStructureHelper::field_section_start_full_panels($tab_id, $menu_id, $text, '');
		ESSBOptionsStructureHelper::field_color_panel($tab_id, $menu_id, 'customizer_'.$key.'_bgcolor', __('Background color', 'essb'), __('Replace all buttons background color', 'essb'));
		ESSBOptionsStructureHelper::field_color_panel($tab_id, $menu_id, 'customizer_'.$key.'_textcolor', __('Text color', 'essb'), __('Replace all buttons text color', 'essb'));
		ESSBOptionsStructureHelper::field_color_panel($tab_id, $menu_id, 'customizer_'.$key.'_hovercolor', __('Hover background color', 'essb'), __('Replace all buttons hover background color', 'essb'));
		ESSBOptionsStructureHelper::field_color_panel($tab_id, $menu_id, 'customizer_'.$key.'_hovertextcolor', __('Hover text color', 'essb'), __('Replace all buttons hover text color', 'essb'));
		ESSBOptionsStructureHelper::field_section_end_full_panels($tab_id, $menu_id);
		ESSBOptionsStructureHelper::field_file($tab_id, $menu_id, 'customizer_'.$key.'_icon', __('Icon', 'essb'), __('Replace social icon', 'essb'));
		ESSBOptionsStructureHelper::field_textbox($tab_id, $menu_id, 'customizer_'.$key.'_iconbgsize', __('Background size for regular icon', 'essb'), __('Provide custom background size if needed (for retina templates default used is 21px 21px)', 'essb'));
		ESSBOptionsStructureHelper::field_file($tab_id, $menu_id, 'customizer_'.$key.'_hovericon', __('Hover icon', 'essb'), __('Replace social icon', 'essb'));
		ESSBOptionsStructureHelper::field_textbox($tab_id, $menu_id, 'customizer_'.$key.'_hovericonbgsize', __('Hover background size for regular icon', 'essb'), __('Provide custom background size if needed (for retina templates default used is 21px 21px)', 'essb'));
		ESSBOptionsStructureHelper::panel_end($tab_id, $menu_id);
	}
}

function essb3_prepare_advanced_custom_share($tab_id, $menu_id) {
	global $essb_networks;

	ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading1', __('Advanced custom share message by social network', 'essb'));

	$checkbox_list_networks = array();
	foreach ($essb_networks as $key => $object) {
		$checkbox_list_networks[$key] = $object['name'];
	}

	foreach ($checkbox_list_networks as $key => $text) {
		if ($key == "more" || $key == "love" || $key == "mail" || $key == "print") {
			continue;
		}
		$k = $key;
		ESSBOptionsStructureHelper::field_heading($tab_id, $menu_id, 'heading2', $text);
		ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, 'as_'.$key.'_url', __('URL:', 'essb'), '');
		if ($k == "facebook" || $k == "twitter" || $k == "pinterest" || $k == "tumblr" || $k == "digg" || $k == "linkedin" || $k == "reddit" || $k == "del" || $k == "buffer" || $k == "whatsapp") {
			ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, 'as_'.$key.'_text', __('Message:', 'essb'), '');
		}
		if ($k == "facebook" || $k == "pinterest") {
			ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, 'as_'.$key.'_image', __('Image:', 'essb'), '');
			ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, 'as_'.$key.'_desc', __('Description:', 'essb'), '');
		}
	}
}

function essb3_prepare_texts_on_button_hover($tab_id, $menu_id) {
	global $essb_networks;

	$checkbox_list_networks = array();
	foreach ($essb_networks as $key => $object) {
		$checkbox_list_networks[$key] = $object['name'];
	}

	foreach ($checkbox_list_networks as $key => $text) {
		ESSBOptionsStructureHelper::field_textbox_stretched($tab_id, $menu_id, 'hovertext'.'_'.$key, $text, '');
	}

}

function essb_prepare_location_network_selection($tab_id, $menu_id, $location = '') {
	global $essb_networks, $essb_options;

	$checkbox_list_networks = array();
	foreach ($essb_networks as $key => $object) {
		$checkbox_list_networks[$key] = $object['name'];
	}

}



function essb3_reset_postdata() {
	echo '<a href="admin.php?page=essb_redirect_advanced&tab=advanced&reset_settings=true" class="essb-btn essb-btn-red">'.__('I want to reset plugin settings to default', 'essb').'</a>';
}


function essb3_network_rename() {
	global $essb_admin_options, $essb_networks;

	$network_order = array();

	if (is_array($essb_admin_options)) {
		$active_networks = isset($essb_admin_options['networks']) ? $essb_admin_options['networks'] : array();
		$network_order = isset($essb_admin_options['networks_order']) ? $essb_admin_options['networks_order'] : array();
	}

	// populate the default networks for sorting;
	if (count($network_order) == 0) {
		foreach ($essb_networks as $key => $data) {
			$network_order[] = $key;
		}
	}

	print '<ul class="essb-main-network-order" id="essb-main-network-list">';

	foreach ($network_order as $network) {

		$current_network_name = isset($essb_networks[$network]) ? $essb_networks[$network]["name"] : $network;
		$user_network_name = isset($essb_admin_options['user_network_name_'.$network]) ? $essb_admin_options['user_network_name_'.$network] : '';

		if ($user_network_name == '') {
			$user_network_name = $current_network_name;
		}
		//echo '<li>'.$network.'</li>';
		printf('<li class="essb-network-name-%1$s">', $network);

		printf('<span class="essb_icon essb_icon_%1$s"></span><input type="text" class="input-element" name="essb_options_names[%1$s]" value="%2$s"/>&nbsp;%3$s',$network,$user_network_name, $current_network_name);

		print '</li>';
	}

	print '</ul>';
}


function essb3_text_backup() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';
	
	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}
	
	$download_settings = "admin-ajax.php?action=essb_settings_save";
	
	?>
	
	<textarea id="essb_options_configuration" name="essb_backup[configuration]" class="input-element stretched" rows="15"><?php echo $backup_string; ?></textarea>
	<a href="<?php echo $goback; ?>" class="essb-btn essb-btn-blue">Export Settings</a>
	
	<?php 
}

function essb3_text_backup2() {
	global $essb_socialfans_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import&section=backup2'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_socialfans_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<textarea id="essb_options_configuration" name="essb_backup[configuration]" class="input-element stretched" rows="15"><?php echo $backup_string; ?></textarea>
	<a href="<?php echo $goback; ?>" class="essb-btn essb-btn-blue">Export Settings</a>
	
	<?php 
}


function essb3_text_backup_import() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<textarea id="essb_options_configuration1" name="essb_backup[configuration1]" class="input-element stretched" rows="15"></textarea>
	<input type="Submit" name="Submit" value="Import Settings" class="essb-btn essb-btn-blue">
		<?php 
}

function essb3_text_backup_import2() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<textarea id="essb_options_configuration1" name="essb_backup2[configuration1]" class="input-element stretched" rows="15"></textarea>
	<input type="Submit" name="Submit" value="Import Settings" class="essb-btn essb-btn-blue">
		<?php 
}


function essb3_text_backup_import1() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<input type="file" name="essb_backup_file" class="essb-btn essb-btn-light"/>
	<input type="Submit" name="Submit" value="Import Settings From File" class="essb-btn essb-btn-orange">
		<?php 
}


function essb3_text_backup1() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<a href="<?php echo $download_settings; ?>" class="essb-btn essb-btn-orange">Save Plugin Settings To File</a>&nbsp;
	<?php 
}
function essb3_text_readymade() {
	include_once(ESSB3_PLUGIN_ROOT . '/lib/admin/essb-readymade-styles.php');
	$goback = esc_url_raw(add_query_arg(array('import' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	essb_draw_readymade_list();
	
}

function essb3_text_automatic_updates() {
	
	if (!ESSBAdminActivate::is_activated()) {
		ESSBOptionsFramework::draw_hint(__('Plugin is not activated!', 'essb'), __('Please visit your Envato profile and fill in purchase code to activate plugin', 'essb'), 'fa fa-lock', 'status essb-status-activate essb-status-activate-presents');	
	}
	else {
		ESSBOptionsFramework::draw_hint(__('Your plugin is fully activated!', 'essb'), __('Thank you for choosing Easy Social Share Buttons for WordPress. Your plugin is fully activated.', 'essb'), 'fa fa-unlock', 'status essb-status-activate-presents');
	}
	
	
	?>
	<p>To activate plugin you need to fill in valid purchase code for Easy Social Share Buttons for WordPress. <b>If you have plugin bundled into theme that you bought to activate automatic updates, access to our add-ons library, full access to ready made presents library and our premium support you need to buy separate license for Easy Social Share Buttons for WordPress.</b>.</p>
	<p>Please note that one purchase key can be used on one domain only. If you wish to move your purchase key to another domain all you need is to remove it from purchase code field of old site and enter it in the new one. Usage of one purchase code on multiple sites at same time will block automatic updates for all of them and you will not be able to access restricted by activation functions of plugin.</p>
	<p><a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo&license=regular&open_purchase_for_item_id=6394476&purchasable=source" target="blank" class="essb-btn essb-btn-red">Purchase new copy of Easy Social Share Buttons for just $19</a></p>
	<h3>How to find my purchase code</h3>
	Here is how to find your purchase code: open <b>Easy Social Share Buttons for WordPress</b> page in CodeCanyon <a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo" target="_blank">http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476</a> and visit the <b>Support</b> tab.
	<br/><br/>
	<img src="<?php echo ESSB3_PLUGIN_URL ?>/assets/images/purchase_code1.png"/>
	<br/><br/>
	Scroll down on that page till you find Purchase code section
	<br/><br/>
	<img src="<?php echo ESSB3_PLUGIN_URL ?>/assets/images/purchase_code2.png"/>
	<?php 
}


function essb3_esml_post_type_select() {
	global $essb_admin_options, $wp_post_types;

	$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );

	$current_posttypes = array();
	if (is_array($essb_admin_options)) {
		$current_posttypes = ESSBOptionValuesHelper::options_value($essb_admin_options, 'esml_monitor_types', array());
	}

	if (!is_array($current_posttypes)) {
		$current_posttypes = array();
	}
	echo '<ul>';

	foreach ($pts as $pt) {
		$selected = in_array ( $pt, $current_posttypes ) ? 'checked="checked"' : '';
		printf('<li><input type="checkbox" name="essb_options[esml_monitor_types][]" id="%1$s" value="%1$s" %2$s> <label for="%1$s">%3$s</label></li>', $pt, $selected, $wp_post_types [$pt]->label);
	}

	foreach ($cpts as $pt) {
		$selected = in_array ( $pt, $current_posttypes  ) ? 'checked="checked"' : '';
		printf('<li><input type="checkbox" name="essb_options[esml_monitor_types][]" id="%1$s" value="%1$s" %2$s> <label for="%1$s">%3$s</label></li>', $pt, $selected, $wp_post_types [$pt]->label);
	}

	echo '</ul>';
}

function essb4_translate_guide() {
	?>
	
	<p><b>We are happy to announce that Easy Social Share Buttons starting from verison 4 has fully translatable admin panel.</b> Help us make Easy Social Share Buttons for WordPress speak your language and get special gift from us for your efforts.</p>
	<h3>How to translate Easy Social Share Buttons for WordPress in just few steps (the quick guide)</h3>
	
	<ul>
	
		<ol>1. Download and install free version of <a href="https://poedit.net/" target="_blank">POEdit</a> (you can also use your favourite tool or plugin like Loco Translate or WPML)</ol>
		<ol>2. Start POEdit and choose from menu File -> New from POT/PO file<br/>
		<img src="<?php echo ESSB3_PLUGIN_URL; ?>/assets/images/translate/translate1.png"/>
		</ol>
		<ol>
		3. Choose file <b>easy-social-share-buttons3/languages/essb.pot</b> and choose language that you will translate in<br/>
		<img src="<?php echo ESSB3_PLUGIN_URL; ?>/assets/images/translate/translate2.png"/>
		</ol>
		<ol>4. Make translation of plugin strings in your language and save them as file essb-(language_code) in same folder <b>easy-social-share-buttons3/languages/</b>. For example if you translate in Spanish file should have name essb-es_ES.po</ol>
		<ol>5. When you are ready or if you have additional questions please contact us using form <a href="http://socialsharingplugin.com/contact-us/" target="_blank"><b>http://socialsharingplugin.com/contact-us/</b></a></ol>
	</ul>
	<b><a href="http://codex.wordpress.org/Translating_WordPress" target="_blank">Official info about translation: http://codex.wordpress.org/Translating_WordPress</a></b>
	<?php 
}