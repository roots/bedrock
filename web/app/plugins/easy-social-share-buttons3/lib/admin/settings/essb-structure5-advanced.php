<?php

ESSBOptionsStructureHelper::menu_item('advanced', 'optimization', __('Optimizations', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('advanced', 'advanced', __('Advanced Options', 'essb'), 'default');
ESSBOptionsStructureHelper::menu_item('advanced', 'administrative', __('Administrative Options', 'essb'), 'default');


if (!essb_options_bool_value('deactivate_module_translate')) {
	ESSBOptionsStructureHelper::menu_item('advanced', 'localization', __('Translate Options', 'essb'), 'default');
}


ESSBOptionsStructureHelper::title('advanced', 'optimization', __('Optimization Level', 'essb'), __('With plugin predefined optimization levels it is easy to setup best optimziation options for your site. And best is that you still have custom mode which will let you tune everything by yourself.', 'essb'));
$select_values = array('' => array('title' => 'Custom - Allows user select desired options', 'content' => '<i class="fa fa-sliders"></i><span class="title">Custom</span><span class="desc">You can control all optimization options based on your entire setup and other plugins. Recommended for advanced users.</span>', 'isText' => true),
		'level0' => array('title' => 'No optimizations', 'content' => '<i class="fa fa-battery-0"></i><span class="title">No optimizations</span><span class="desc">Plugin will not use any of build in optimizations - use under development or when you have other plugins to do the job</span>', 'isText' => true),
		'level1' => array('title' => 'Only basic style and script optimizations', 'content' => '<i class="fa fa-battery-1"></i><span class="title">Basic</span><span class="desc">Minified resources and optimized script load</span>', 'isText' => true),
		'level2' => array('title' => 'Medium optimizations for most sites', 'content' => '<i class="fa fa-battery-2"></i><span class="title">Medium</span><span class="desc">Minified resources, optimized script load and packed resources into fewer files</span>', 'isText' => true),
		'level3' => array('title' => 'Advanced Optimizations', 'content' => '<i class="fa fa-battery-4"></i><span class="title">Advanced</span><span class="desc">Minified resources, optimized script load, selective style builder and packed into single javascript files - best for high traffic sites and advanced users</span>', 'isText' => true));
ESSBOptionsStructureHelper::field_toggle('advanced', 'optimization', 'optimization_level', '', '', $select_values, '', '', '');

//ESSBOptionsStructureHelper::field_heading('advanced', 'optimization', 'heading5', __('Static resource optimizations', 'essb'));

ESSBOptionsStructureHelper::holder_start('advanced', 'optimization', 'optimizations-css', 'optimizations-css');
ESSBOptionsStructureHelper::field_heading('advanced', 'optimization', 'heading4', __('CSS Styles Optimization', 'essb'));
//ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('CSS Styles Optimizations', 'essb'), __('Activate option that will optimize load of static css resources', 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'use_minified_css', __('Use minified CSS files', 'essb'), __('Minified CSS files will improve speed of load. Activate this option to use them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_css_footer', __('Load plugin inline styles into footer', 'essb'), __('Activating this option will load dynamic plugin inline styles into footer.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::holder_end('advanced', 'optimization');

ESSBOptionsStructureHelper::holder_start('advanced', 'optimization', 'optimizations-css-builder', 'optimizations-css-builder');
ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Use style builder', 'essb'), __('Style builder allows to generate personalized file with used styles. Once activated all you need is to selected components you will use on site and plugin will do the rest. <b>Style builder should be used in combination with precompiled mode (when CSS files are active in the selected mode) or build in cache functions of plugin</b>', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'use_stylebuilder', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_func('advanced', 'optimization', 'essb5_stylebuilder_select', '', '');
ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');
ESSBOptionsStructureHelper::holder_end('advanced', 'optimization');


//ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');



//ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Scripts load Optimizations', 'essb'), __('Activate option that will optimize load of all scripts used by plugin', 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::holder_start('advanced', 'optimization', 'optimizations-other', 'optimizations-other');
ESSBOptionsStructureHelper::field_heading('advanced', 'optimization', 'heading4', __('Scripts Optimization', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'use_minified_js', __('Use minified javascript files', 'essb'), __('Minified javascript files will improve speed of load. Activate this option to use them.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'scripts_in_head', __('Load scripts in head element', 'essb'), __('If you are using caching plugin like W3 Total Cache you may need to activate this option if counters, send mail form or float do not work.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_js_async', __('Load plugin javascript files asynchronous', 'essb'), __('This will load scripts during page load in non render blocking way', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_js_defer', __('Load plugin javascript files deferred', 'essb'), __('This will load scripts after page load in non render blocking way', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'load_js_delayed', __('Load plugin javascript files delayed', 'essb'), __('This will load scripts after 2 seconds when page is fully loaded', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');

/*ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Use script builder', 'essb'), __('Script builder allows to generate personalized file with used scripts. Once activated all you need is to selected components you will use on site and plugin will do the rest. <b>Script builder should be used in combination with precompiled mode or build in cache</b>', 'essb'), 'fa21 fa fa-cogs', array("mode" => "switch", 'switch_id' => 'use_scriptbuilder', 'switch_on' => __('Yes', 'essb'), 'switch_off' => __('No', 'essb')));
ESSBOptionsStructureHelper::field_func('advanced', 'optimization', 'essb5_scriptbuilder_select', '', '');
ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');
*/
//ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');

//ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Global Optimizations', 'essb'), __('Global optimizations applied on all type of static resources used by plugin', 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_heading('advanced', 'optimization', 'heading4', __('Global Optimization', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'remove_ver_resource', __('Remove version number of static files', 'essb'), __('Activating this option will remove added to resources version number ?ver= which will allow these files to be cached.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'precompiled_resources', __('Use plugin precompiled resources', 'essb'), __('Activating this option will precompile and cache plugin dynamic resources to save load time. Precompiled resources can be used only when you use same configuration on your entire site.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_select_panel('advanced', 'optimization', 'precompiled_mode', __('Precompiled mode', 'essb'), __('Using mode control you can select which type of resources to include inside precompiled resources - CSS, javascript or both (default).', 'essb'), array('' => 'CSS and Javascript', 'css' => 'CSS Only', 'js' => 'Javascript Only'));
ESSBOptionsStructureHelper::field_select_panel('advanced', 'optimization', 'precompiled_folder', __('Precompiled data storage', 'essb'), __('Choose where you wish to store the cached data. If you wish to use custom path there are filters available.', 'essb'), array('' => 'WordPress Content Folder', 'uploads' => 'WordPress Uploads Folder', 'plugin' => 'Plugin Folder'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
//ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');


ESSBOptionsStructureHelper::field_heading('advanced', 'optimization', 'heading4', __('Build in cache', 'essb'));

$cache_plugin_detected = "";
if (ESSBCacheDetector::is_cache_plugin_detected()) {
	ESSBOptionsStructureHelper::hint('advanced', 'optimization', __('Cache plugin detected: ', 'essb').ESSBCacheDetector::cache_plugin_name(), __('Easy Social Share Buttons for WordPress detect that you are using cache plugin on your site. Activation of any of options inside build in cache may lead to visual issues or missing share buttons. Please use them with caution', 'essb'), 'fa32 ti-info-alt', 'orange');

}

ESSBOptionsStructureHelper::hint('advanced', 'optimization', __('', 'essb'), __('For a blazing fast loading site we recommend usage of cache plugin like <a href="http://wp-rocket.me" target="_blank">WP Rocket</a>. <a href="http://wp-rocket.me" target="_blank">WP Rocket</a> is simple to setup, works out of the box and has full mobile caching support.', 'essb'), '');
ESSBOptionsStructureHelper::panel_start('advanced', 'optimization', __('Build in plugin cache', 'essb'), __('Activate build in cache functions to improve speed of load. If you use a site cache plugin activation of those options is not needed as that plugin will do the cache work.'.$cache_plugin_detected, 'essb'), 'fa21 fa fa-rocket', array("mode" => "toggle", 'state' => 'opened'));

ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache_runtime', __('Activate WordPress cache', 'essb'), __('Activating WordPress cache function usage will cache button generation via default WordPress cache or via the persistant cache plugin if you use such (like W3 Total Cache)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache', __('Activate cache', 'essb'), __('This option is in beta and if you find any problems using it please report at our <a href="http://support.creoworx.com" target="_blank">support portal</a>. To clear cache you can simply press Update Settings button in Main Settings (cache expiration time is 1 hour)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$cache_mode = array ("full" => "Cache button render and dynamic resources", "resource" => "Cache only dynamic resources", "buttons" => "Cache only buttons render" );
ESSBOptionsStructureHelper::field_select_panel('advanced', 'optimization', 'essb_cache_mode', __('Cache mode', 'essb'), __('Choose between caching full render of share buttons and resources or cache only dynamic resources (CSS and Javascript).', 'essb'), $cache_mode);
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache_static', __('Combine into single file all plugin static CSS files', 'essb'), __('This option will combine all plugin static CSS files into single file.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'optimization', 'essb_cache_static_js', __('Combine into single file all plugin static javascript files', 'essb'), __('This option will combine all plugin static javacsript files into single file. This option will not work if scripts are set to load asynchronous or deferred.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'optimization');
ESSBOptionsStructureHelper::panel_end('advanced', 'optimization');
ESSBOptionsStructureHelper::holder_end('advanced', 'optimization');


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

ESSBOptionsStructureHelper::panel_start('advanced', 'advanced', __('Advanced Display Options', 'essb'), __('Activate additional advanced options for customization and sharing', 'essb'), 'fa21 fa fa-television', array("mode" => "toggle", 'state' => 'closed'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'advanced');
//ESSBOptionsStructureHelper::field_switch_panel('advanced', 'advanced', 'advanced_custom_share', __('Activate custom share by social network', 'essb'), __('Activation of this option will add additional menu settings for message share customization by social network.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
//float_onsingle_only
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'advanced', 'float_onsingle_only', __('Float display methods on single posts/pages only', 'essb'), __('Plugin will check and display float from top and post vertical float only when a single post/page is being displayed. In all other case method will be replaced with display method top.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'advanced');
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
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'deactivate_ajaxsubmit', __('Deactivate AJAX submit of settings', 'essb'), __('Activate this option if for some reason your settings inside plugin do not save.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', 'true');
//disable_welcome
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'disable_welcome', __('Do not show Welcome screen', 'essb'), __('Use this option to deactivate display of Welcome screen with quick links to plugin functions', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'disable_settings_rollback', __('Do not save history of settings change', 'essb'), __('Set this option to Yes to avoid save of previous configuration settings of plugin (without that option plugin stores automatically last 10 saves of settings)', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'using_elementor', __('I am using Elementor Page Builder', 'essb'), __('Activate this option if you se Elementor page builder and your post customizations (or share buttons) disappear once you save page created with this builder.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');
//live_customizer_disabled

ESSBOptionsStructureHelper::title('advanced', 'functions', __('Deactivate additional functions', 'essb'), __('Use this options to turn off other core features of plugin', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative', 'lightgrey-bg');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'deactivate_appscreo', __('Deactivate checks for news and extensions', 'essb'), __('Plugin has build in option to display latest useful tips from our blogs and notifcations for add-ons that we release. If your server is located in zone that prevents access from specific country hosted servers than you may see delay in load of WordPress admin or strange notice messages. If that happens activate this option to turn off those checks.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'live_customizer_disabled', __('Turn off front end Quick plugin setup', 'essb'), __('The front end quick setup is limited for usage by administrators only. Activate this option if you wish to remove it completely.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'disable_translation', __('Do not load translations of interface', 'essb'), __('All plugin translations are made with love from our customers. If you do not wish to use it activate this option and plugin will load with default English language.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'), '', '');
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');


ESSBOptionsStructureHelper::panel_end('advanced', 'administrative');



ESSBOptionsStructureHelper::panel_start('advanced', 'administrative', __('Plugin Settings Access', 'essb'), __('Control access to various plugin settings', 'essb'), 'fa21 fa fa-key', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'disable_adminbar_menu', __('Disable menu in WordPress admin bar', 'essb'), __('Activation of this option will remove the quick access plugin menu from WordPress top admin bar.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
$listOfOptions = array("manage_options" => "Administrator", "delete_pages" => "Editor", "publish_posts" => "Author", "edit_posts" => "Contributor");
ESSBOptionsStructureHelper::field_select_panel('advanced', 'administrative', 'essb_access', __('Plugin access', 'essb'), __('Make settings available for the following user roles (if you use multiple user roles on your site we recommend to select Administrator to disallow other users change settings of plugin).', 'essb'), $listOfOptions);
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::panel_end('advanced', 'administrative');

ESSBOptionsStructureHelper::panel_start('advanced', 'administrative', __('Metabox visibiltiy', 'essb'), __('Show/hide plugin on post metaboxes', 'essb'), 'fa21 fa fa-eye', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::field_section_start_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'turnoff_essb_advanced_box', __('Remove post advanced visual settings metabox', 'essb'), __('Activation of this option will remove the advanced meta box on each post that allow customizations of visual styles for post.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'turnoff_essb_optimize_box', __('Remove post share customization metabox', 'essb'), __('Activation of this option will remove the share customization meta box on each post (allows changing social share optimization tags, customize share and etc.).', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('advanced', 'administrative', 'turnoff_essb_stats_box', __('Remove post detailed stats metabox', 'essb'), __('Activation of this option will remove the detailed stats meta box from each post/page when social share analytics option is activated.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('advanced', 'administrative');
ESSBOptionsStructureHelper::panel_end('advanced', 'administrative');


ESSBOptionsStructureHelper::field_func('advanced', 'administrative', 'essb3_reset_postdata', __('Reset plugin settings', 'essb'), __('Warning! Pressing this button will restore initial plugin configuration values and all settings that you apply after plugin activation will be removed.', 'essb'));


//ESSBOptionsStructureHelper::field_heading('advanced', 'counterrecovery', 'heading1', __('Share Counter Recovery', 'essb'));
//}


if (!essb_option_bool_value('deactivate_module_translate')) {
	ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Mail form texts', 'essb'), __('Translate mail form texts', 'essb'), 'ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_title', __('Share this with a friend', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_email', __('Your Email', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_recipient', __('Recipient Email', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_custom', __('Custom user message', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_cancel', __('Cancel', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_send', __('Send', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_captcha', __('Fill in captcha code text', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_message_sent', __('Message sent!', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_message_invalid_captcha', __('Invalid Captcha code!', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_mail_message_error_send', __('Error sending message!', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('advanced', 'localization');
	
	ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Love this button messages', 'essb'), __('Translate love this button messages', 'essb'), 'ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_love_thanks', __('Thank you for loving this.', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_love_loved', __('You already love this today.', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('advanced', 'localization');
	
	ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Subscribe Forms', 'essb'), __('Translate subscribe forms module texts', 'essb'), 'ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_subscribe_invalidemail', __('Invalid email address', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('advanced', 'localization');
	
	
	ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Custom texts that will appear on button hover', 'essb'), __('Enter custom texts that will appear on button hover', 'essb'), 'fa ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
	essb3_prepare_texts_on_button_hover('advanced', 'localization');
	ESSBOptionsStructureHelper::panel_end('advanced', 'localization');
	
	ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('Click to Tweet', 'essb'), __('Translate click-to-tweet module texts', 'essb'), 'ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_clicktotweet', __('Translate Click To Tweet text', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('advanced', 'localization');

	ESSBOptionsStructureHelper::panel_start('advanced', 'localization', __('After Share Actions', 'essb'), __('Translate after share specific texts', 'essb'), 'ti-world fa21', array("mode" => "toggle", 'state'=> 'closed1'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_as_popular_title', __('Popular Posts Title', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('advanced', 'localization', 'translate_as_popular_shares', __('Popular Posts shares text', 'essb'), __('', 'essb'));
	ESSBOptionsStructureHelper::panel_end('advanced', 'localization');
}

add_action('admin_init', 'essb3_register_settings_by_posttypes');
function essb3_register_settings_by_posttypes() {
	global $wp_post_types;

	if (essb_option_value('functions_mode') != 'light') {
	
		$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
		$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );
		$first_post_type = "";
		$key = 1;
		foreach ( $pts as $pt ) {
			if (empty ( $first_post_type )) {
				$first_post_type = $pt;
				ESSBOptionsStructureHelper::menu_item ( 'advanced', 'advancedpost', __ ( 'Settings by Post Type', 'essb' ), 'default', 'activate_first', 'advancedpost-1' );
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
	}

	if (!essb_options_bool_value('deactivate_method_integrations')) {
		ESSBOptionsStructureHelper::menu_item ( 'advanced', 'advancedmodule', __ ( 'Settings for Plugin Integration', 'essb' ), 'default', 'activate_first', 'advancedmodule-1' );
		$key = 1;
		$cpt = 'woocommerce';
		$cpt_title = 'WooCommerce';
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
		$key ++;
	
		$cpt = 'wpecommerce';
		$cpt_title = 'WP e-Commerce';
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
		$key ++;
	
		$cpt = 'jigoshop';
		$cpt_title = 'JigoShop';
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
		$key ++;
	
		$cpt = 'ithemes';
		$cpt_title = 'iThemes Exchange';
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
		$key ++;
	
		$cpt = 'bbpress';
		$cpt_title = 'bbPress';
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
		$key ++;
	
		$cpt = 'buddypress';
		$cpt_title = 'BuddyPress';
		ESSBOptionsStructureHelper::submenu_item ( 'advanced', 'advancedmodule-' . $key, $cpt_title );
		//ESSBOptionsStructureHelper::field_heading('advanced', 'advancedmodule-' . $key, 'heading1', __('Advanced settings for plugin: '.$cpt_title, 'essb'));
		essb_prepare_location_advanced_customization ( 'advanced', 'advancedmodule-' . $key, 'post-type-'.$cpt, true );
		$key ++;
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


function essb3_reset_postdata() {
	echo '<script type="text/javascript">';
	echo 'function essb_reset_confirmation() {
	var redirect_url = "admin.php?page=essb_redirect_advanced&tab=advanced&reset_settings=true";
	if (confirm("Are you sure you want to reset settings to default?")) location.href = redirect_url;
	} 
	';
	echo '</script>';
	
	echo '<a href="#" class="essb-btn essb-btn-red" onclick="essb_reset_confirmation(); return false;">'.__('I want to reset plugin settings to default', 'essb').'</a>';
}

function essb5_stylebuilder_select() {
	$current_selection = essb_option_value('stylebuilder_css');
	if (!is_array($current_selection)) {
		$current_selection = array();
	}
	
	$styles = essb_stylebuilder_css_files();
	
	foreach ($styles as $key => $data) {
		echo '<span class="essb_checkbox_list_item"><input type="checkbox" name="essb_options[stylebuilder_css][]" id="stylebuilder-'.$key.'" class="stylebuilder-key" value="'.$key.'" '.(in_array($key, $current_selection) ? 'checked="checked"' : '').'/> '.($data['default'] == 'true' ? '<b>' : '').$data['name'].($data['default'] == 'true' ? '</b>' : '').'</span>';
	}
	
	echo '<div style="background: #f3f5f7; padding: 10px; margin-top: 10px;">'.__('If you wish to load only your own styles than leave all checkboxes be off. Once you do this you can add inside plugin settings or in theme just the code you need.', 'essb').'</div>';
}

function essb5_scriptbuilder_select() {
	$current_selection = essb_option_value('stylebuilder_js');
	if (!is_array($current_selection)) {
		$current_selection = array();
	}

	$styles = essb_stylebuilder_js_files();

	foreach ($styles as $key => $data) {
		echo '<span class="essb_checkbox_list_item"><input type="checkbox" name="essb_options[stylebuilder_js][]" value="'.$key.'" '.(in_array($key, $current_selection) ? 'checked="checked"' : '').'/> '.($data['default'] == 'true' ? '<b>' : '').$data['name'].($data['default'] == 'true' ? '</b>' : '').'</span>';
	}

	echo '<div style="background: #f3f5f7; padding: 10px; margin-top: 10px;">'.__('If you wish to load only your own styles than leave all checkboxes be off. Once you do this you can add inside plugin settings or in theme just the code you need.', 'essb').'</div>';
}
