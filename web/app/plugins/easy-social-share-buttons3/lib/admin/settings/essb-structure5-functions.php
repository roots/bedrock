<?php

ESSBOptionsStructureHelper::title('modes', 'modes', __('Share buttons on mobile devices', 'essb'), __('Easy Social Share Buttons for WordPress has advanced mobile display options to get a fully personalized mobile appearance. If you do not wish to do this by yourself you can set automatic configuration and plugin will do the job for you.', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_func('modes', 'modes', 'essb5_functions_mode_choose_mobile', '', '');

ESSBOptionsStructureHelper::title('modes', 'modes', __('Plugin Mode', 'essb'), __('Easy Social Share Buttons for WordPress is all-in-one social media plugin for WordPress packed with lot of options. In case you do not plan to use all of them it is easy to deactivate (or activate back) functions you do not need. To do this use one of preset operation modes or set on custom and remove functions you do not use.', 'essb'), 'inner-row');
ESSBOptionsStructureHelper::field_func('modes', 'modes', 'essb5_functions_mode_choose', '', '');

ESSBOptionsStructureHelper::tabs_start('functions', 'functions', 'buttons-tabs', array('<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Deactivate Modules', 'essb'), '<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Deactivate Display Methods', 'essb'), '<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Developer Functions', 'essb'), '<i class="ti-settings" style="margin-right: 5px;"></i>'.__('Exclude Display of Functions', 'essb')), 'false', 'true');
ESSBOptionsStructureHelper::tab_start('functions', 'functions', 'buttons-tabs-0', 'true');
ESSBOptionsStructureHelper::panel_start('functions', 'functions', __('Plugin Modules', 'essb'), __('Deactivate usage of specific plugin modules. Switching option to yes will deactivate code used by this module and remove its settings from plugin. At any time when you need you can reactivate it again.', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::title('functions', 'functions', __('Deactivate share related modules', 'essb'), __('Those modules are related to share functionality of plugin. If you do not use any of them it is recommended to turn them off to get a clear user interface', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('functions', 'functions', 'lightgrey-bg');
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_ctt', __('Deactivate Sharable Quotes module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_aftershare', __('Deactivate After Share module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_shareoptimize', __('Deactivate Share Optmizations module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_analytics', __('Deactivate Analytics module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_shorturl', __('Deactivate Short URL module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_affiliate', __('Deactivate Affiliate & Point integration', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_customshare', __('Deactivate Custom Share function', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_message', __('Deactivate User Message before buttons', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_metrics', __('Deactivate Social Metrics', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_translate', __('Deactivate Translations', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_conversions', __('Deactivate Conversions Lite', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('functions', 'functions');

ESSBOptionsStructureHelper::title('functions', 'functions', __('Deactivate following and subscribe modules', 'essb'), __('Those modules are related to follow & subscribe functionality of plugin. If you do not use any of them it is recommended to turn them off to get a clear user interface', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('functions', 'functions', 'lightgrey-bg');
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_followers', __('Deactivate Followers Counter module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_profiles', __('Deactivate Profile Links module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_natives', __('Deactivate Native Social Buttons module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_subscribe', __('Deactivate Subscribe Forms module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_facebookchat', __('Deactivate Facebook Messenger Live Chat module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_module_skypechat', __('Deactivate Skype Live Chate module', 'essb'), '', '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('functions', 'functions');

ESSBOptionsStructureHelper::panel_end('functions', 'functions');
ESSBOptionsStructureHelper::tab_end('functions', 'functions');

ESSBOptionsStructureHelper::tab_start('functions', 'functions', 'buttons-tabs-1', 'false');
ESSBOptionsStructureHelper::panel_start('functions', 'functions', __('Plugin Display', 'essb'), __('Easy Social Share Buttons has so many display methods but we suppose you will not use all at same time (or at least we hope so). As an advice from us to speed up work you can deactivate display methods that you will not use (you can activate them again at any time).', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'opened'));
ESSBOptionsStructureHelper::title('functions', 'functions', __('Mobile Appearance', 'essb'), __('Use those options to deactivate plugin on mobile', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('functions', 'functions', 'lightgrey-bg');
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_mobile', __('Deactivate plugin on mobile', 'essb'), __('Use this option to completely deactivate plugin usage on mobile devices inlcuding all of its modules.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_mobile_share', __('Deactivate social share buttons on mobile', 'essb'), __('This option will deactivate share function on mobile devices but it will keep up showing all other modules.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('functions', 'functions');

ESSBOptionsStructureHelper::title('functions', 'functions', __('Display Methods', 'essb'), __('Switch off display methods you will not use on site', 'essb'));
ESSBOptionsStructureHelper::field_section_start_full_panels('functions', 'functions', 'lightgrey-bg');
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_float', __('Turn off Float from Top', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_postfloat', __('Turn off Post Vertical Float', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_sidebar', __('Turn off Sidebar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_topbar', __('Turn off Top Bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_bottombar', __('Turn off Bottom Bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_popup', __('Turn off Pop Up', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_flyin', __('Turn off Fly In', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_heroshare', __('Turn off Full Screen Hero Share', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_postbar', __('Turn off Post Bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_point', __('Turn off Point', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_image', __('Turn off On Media', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_native', __('Turn off Methods with native buttons', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_followme', __('Turn off Follow me bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_corner', __('Turn off Corner Bar', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_booster', __('Turn off Share Booster', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'deactivate_method_integrations', __('Turn off Plugin Integrations', 'essb'), __('', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('functions', 'functions');
ESSBOptionsStructureHelper::panel_end('functions', 'functions');
ESSBOptionsStructureHelper::tab_end('functions', 'functions');

ESSBOptionsStructureHelper::tab_start('functions', 'functions', 'buttons-tabs-2', 'false');
ESSBOptionsStructureHelper::panel_start('functions', 'functions', __('Developer Functions', 'essb'), __('Easy Social Share Buttons for WordPress has advanced actions and filters for various things. Using developer functions you can integrate some of them diretly inside plugin settings and avoid touching code (when possible).', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'closed1'));
ESSBOptionsStructureHelper::field_section_start_full_panels('functions', 'functions', 'lightgrey-bg');
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'activate_fake', __('Activate fake/internal share counters', 'essb'), __('Fake or internal counters will make all share counters being tracked internally. This will also allow to setup custom values by social network. All counters will update and increase on each button click without being related to actual (official) counter. At any time you can deactivate the option and see the official counter but keep in mind that this counter will be lower than internal', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'activate_hooks', __('Activate filter/actions integration', 'essb'), __('Use this option to include menu where you can assign calls to custom actions or filters for generation of share buttons. This method will integrate them just like the other automatic display methods.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_switch_panel('functions', 'functions', 'activate_minimal', __('Activate minimal share counters', 'essb'), __('Use this option to setup minimal share counter values for each social network. If real shares are below that value you will see the minimal. As soon your shares reach the minimal you will start seeing the real value.', 'essb'), '', __('Yes', 'essb'), __('No', 'essb'));
ESSBOptionsStructureHelper::field_section_end_full_panels('functions', 'functions');
ESSBOptionsStructureHelper::panel_end('functions', 'functions');
ESSBOptionsStructureHelper::tab_end('functions', 'functions');

ESSBOptionsStructureHelper::tab_start('functions', 'functions', 'buttons-tabs-3', 'false');
ESSBOptionsStructureHelper::panel_start('functions', 'functions', __('Deactivate Plugin Functions on Specific Places', 'essb'), __('Deactivate functions of plugin on selected posts/pages only', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'state' => 'closed1', "css_class" => "essb-auto-open"));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_share', __('Social Share Buttons', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_native', __('Native Buttons', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_fanscounter', __('Social Following (Followers Counter)', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_ctt', __('Sharable Quotes (Click To Tweet)', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_sis', __('On Media Sharing (Social Image Share)', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_profiles', __('Social Profiles', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_sso', __('Social Share Optimization Meta Tags', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_aftershare', __('After Share Actions', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::field_textbox_stretched('functions', 'functions', 'deactivate_on_mobile', __('Mobile Display of Share Buttons', 'essb'), __('Deactivate function on posts/pages with these IDs? Comma seperated: "11, 15, 125". Deactivating plugin will make no style or scripts to be executed for those pages/posts related to this function', 'essb'));
ESSBOptionsStructureHelper::panel_end('functions', 'functions');
ESSBOptionsStructureHelper::tab_end('functions', 'functions');


ESSBOptionsStructureHelper::tabs_end('functions', 'functions');

function essb5_functions_mode_choose() {
	$value = essb_option_value('functions_mode');

	$select_values = array('' => array('title' => 'Customized setup of used modules', 'content' => '<i class="ti-panel" style="margin-right: 5px;"></i> <span class="title">Custom</span>', 'isText'=>true),
			'light' => array('title' => 'Light sharing with only most popular share functions', 'content' => '<i class="ti-star" style="margin-right: 5px;"></i><span class="title">Lite Share Buttons</span>', 'isText'=>true),
			'medium' => array('title' => 'Extended share functionality', 'content' => '<i class="ti-sharethis-alt" style="margin-right: 5px;"></i> <span class="title">Medium Sharing & Subscribe</span>', 'isText'=>true),
			'advanced' => array('title' => 'Power social sharing', 'content' => '<i class="ti-new-window" style="margin-right: 5px;"></i><span class="title">Advanced Sharing & Subscribe</span>', 'isText'=>true),
			'sharefollow' => array('title' => 'All the best to share your content and grow your followers', 'content' => '<i class="ti-heart" style="margin-right: 5px;"></i><span class="title">Sharing, Subscribe & Following</span>', 'isText'=>true),
			'full' => array('title' => 'All plugin functions', 'content' => '<i class="ti-package" style="margin-right: 5px;"></i><span class="title">Everything</span>', 'isText'=>true));

	essb_component_options_group_select('functions_mode', $select_values, '', $value);
	
	include_once(ESSB3_PLUGIN_ROOT.'lib/admin/helpers/mode-information.php');
}

function essb5_functions_mode_choose_mobile() {
	$value = essb_option_value('functions_mode_mobile');

	$select_values = array('' => array('title' => 'Manual Setup', 'content' => '<i class="ti-panel" style="margin-right: 5px;"></i> <span class="title">Manual Setup</span><span class="desc">Allows full control over share buttons on mobile device</span>', 'isText'=>true),
			'auto' => array('title' => 'Plugin will automatically setup share buttons', 'content' => '<i class="ti-star" style="margin-right: 5px;"></i><span class="title">Automatic Setup</span><span class="desc">Plugin will automatically setup share buttons for mobile</span>', 'isText'=>true),
			'deactivate' => array('title' => 'Deactivate mobile settings and do not show buttons on mobile devices', 'content' => '<i class="ti-close" style="margin-right: 5px;"></i><span class="title">Deactivate on Mobile</span><span class="desc">Plugin will not show buttons on mobile devices</span>', 'isText'=>true));

	essb_component_options_group_select('functions_mode_mobile', $select_values, '', $value);
	
	echo '<script type="text/javascript">
	jQuery(document).ready(function($){
	$(".essb-button-openmodes").hide();
	$(".essb-feature-mode").removeClass("closed");
	});
	</script>
	';
}