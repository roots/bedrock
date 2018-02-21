<?php

if (essb_option_bool_value('activate_fake')) {
	ESSBOptionsStructureHelper::menu_item('developer', 'fake', __('Fake Counter Setup', 'essb'), 'default');
	ESSBOptionsStructureHelper::field_heading ('developer', 'fake', 'heading5', __('Make Fake Counter Work for specific networks only', 'essb'));
	ESSBOptionsStructureHelper::hint('developer', 'fake', '', __('By default Fake Share Counter option will work for all social networks. If you wish to limit that function to specific networks only you can add those networks here and plugin will do the magic just for them (all other networks will continue to operate as usual). If you wish to restore back to all networks than just remove anything selected from the network list.', 'essb'), '', 'glow');
	ESSBOptionsStructureHelper::field_network_select('developer', 'fake', 'fake_networks', 'fake');
	
	
	ESSBOptionsStructureHelper::field_heading ('developer', 'fake', 'heading5', __('Minimal Fake Share Counter Values', 'essb'));
	ESSBOptionsStructureHelper::hint('developer', 'fake', __('What are minimal fake share counter values?', 'essb'), __('Those are share values that will appear initially as share values for all posts. If post has a setup of minimal values than those values will be taken in front of minial values no matter they are lower or greater.', 'essb'), '', 'glow');

	ESSBOptionsStructureHelper::field_section_start_full_panels('developer', 'fake');
	
	$list_of_networks = essb_available_social_networks();
	
	$fake_networks = essb_option_value('fake_networks');
	if (!is_array($fake_networks)) {
		$fake_networks = array();
	}
	
	if (count($fake_networks) > 0) {
		ESSBOptionsStructureHelper::hint('developer', 'fake', __('You are seeing the fields for only networks you select inside the list. If you wish to make fake counters work for all networks than remove any selected network in the field above.', 'essb'), '');		
	}
	
	ESSBOptionsStructureHelper::holder_start('developer', 'fake', 'essb-fake-holder', 'essb-fake-holder');
	
	foreach ($list_of_networks as $key => $data) {
		
		if (count($fake_networks) > 0 && !in_array($key, $fake_networks)) { continue; }
		
		ESSBOptionsStructureHelper::field_textbox_panel('developer', 'fake', 'essb_fake|fake_'.$key, $data['name'], '');
	}
	ESSBOptionsStructureHelper::holder_end('developer', 'fake');
	
	ESSBOptionsStructureHelper::field_section_end_full_panels('developer', 'fake');
}

if (essb_option_bool_value('activate_minimal')) {
	ESSBOptionsStructureHelper::menu_item('developer', 'minimal', __('Minimal Share Counts', 'essb'), 'default');
	ESSBOptionsStructureHelper::field_heading ('developer', 'minimal', 'heading5', __('Make minimal counter work for specific networks only', 'essb'));
	ESSBOptionsStructureHelper::hint('developer', 'minimal', '', __('By default Minimal Share Counter option will work for all social networks. If you wish to limit that function to specific networks only you can add those networks here and plugin will do the magic just for them (all other networks will continue to operate as usual). If you wish to restore back to all networks than just remove anything selected from the network list.', 'essb'), '', 'glow');
	ESSBOptionsStructureHelper::field_network_select('developer', 'minimal', 'minimal_networks', 'fake');
	
	
	ESSBOptionsStructureHelper::field_heading ('developer', 'minimal', 'heading5', __('Minimal Share Counter Values', 'essb'));
	ESSBOptionsStructureHelper::hint('developer', 'minimal', __('What are minimal share counter values?', 'essb'), __('Those are share values that will appear initially as share values for all posts.', 'essb'), '', 'glow');
	
	ESSBOptionsStructureHelper::field_section_start_full_panels('developer', 'minimal');
	
	$list_of_networks = essb_available_social_networks();
	
	$fake_networks = essb_option_value('minimal_networks');
	if (!is_array($fake_networks)) {
		$fake_networks = array();
	}
	
	if (count($fake_networks) > 0) {
		ESSBOptionsStructureHelper::hint('developer', 'minimal', __('You are seeing the fields for only networks you select inside the list. If you wish to make fake counters work for all networks than remove any selected network in the field above.', 'essb'), '');
	}
	
	ESSBOptionsStructureHelper::holder_start('developer', 'minimal', 'essb-minimal-holder', 'essb-minimal-holder');
	
	foreach ($list_of_networks as $key => $data) {
	
		if (count($fake_networks) > 0 && !in_array($key, $fake_networks)) {
			continue;
		}
	
		ESSBOptionsStructureHelper::field_textbox_panel('developer', 'minimal', 'essb_fake|minimal_'.$key, $data['name'], '');
	}
	ESSBOptionsStructureHelper::holder_end('developer', 'minimal');
	
	ESSBOptionsStructureHelper::field_section_end_full_panels('developer', 'minimal');
	
}

if (essb_option_bool_value('activate_hooks')) {
	ESSBOptionsStructureHelper::menu_item('developer', 'hooks', __('Custom Hooks Integration', 'essb'), 'default');
	
	ESSBOptionsStructureHelper::hint('developer', 'hooks', __('Welcome to custom hook integration', 'essb'), __('Custom hook integration allows to create link to existing action or filter that will act like a regular display method on the site. This allows integrateion of share buttons almost anywhere when that is supported by theme and custom plugins without touching code. The method can also be used to create a custom hook that can be easy embed inside theme.<br/></br><b>Important! Once a hook integration is created it will not show on site only if you activate it for display. Each hook runs as a display position and to see it on site you need to activate it from Positions menu inside Where to Display. This allows to switch on or off any of integrations when needed</b>', 'essb'));
	
	ESSBOptionsStructureHelper::title('developer', 'hooks', __('Registered Integrations', 'essb'));
	ESSBOptionsStructureHelper::field_func('developer', 'hooks', 'essb_display_user_hooks', '', '');
	
	
	ESSBOptionsStructureHelper::panel_start('developer', 'hooks', __('Create new integration hook', 'essb'), __('', 'essb'), 'fa21 fa fa-cogs', array("mode" => "toggle", 'switch_id' => '', 'switch_on' => __('Yes', 'easy-optin-booster'), 'switch_off' => __('No', 'easy-optin-booster')));
	ESSBOptionsStructureHelper::field_textbox('developer', 'hooks', 'essb_hook_add|hook_id', __('Integration ID', 'essb'), __('The integration ID is used internally to identify the integration. Please use only lowercase latin letters and numbers (no special characters or spaces). The value should be unique. If you use it more than once you will get settings overwritten. Example: hook1', 'essb'));
	ESSBOptionsStructureHelper::field_textbox_stretched('developer', 'hooks', 'essb_hook_add|hook_name', __('Integration Name', 'essb'), __('The integration name is used to identify the method in list of positions and position settings. Free text allowed. Example: Shop above the cart button', 'essb'));
	ESSBOptionsStructureHelper::field_select('developer', 'hooks', 'essb_hook_add|hook_type', __('Integration Type', 'essb'), __('Use integration type to setup how the display of buttons work. The usage of filter or action depends on how plugin/theme you are using is made. You can also setup just a custom position to get a ready to use hook for custom theme integration.', 'essb'), array("action" => "Action", "filter" => "Filter", "position" => "Custom Position"));
	ESSBOptionsStructureHelper::field_textbox_stretched('developer', 'hooks', 'essb_hook_add|hook_action', __('Action/Filter name', 'essb'), __('Enter action or filter that will be used when you choose action or filter integration. Example: the_content', 'essb'));
	ESSBOptionsStructureHelper::hint('developer', 'hooks', '', __('When you are adding a new integration, please fill all required details in the panel and press update options to register it.', 'essb'));	
	ESSBOptionsStructureHelper::panel_end('developer', 'hooks');
	
}

function essb_display_user_hooks() {
	$existing_hooks = get_option('essb-hook');
		
	if (!is_array($existing_hooks)) {
		$existing_hooks = array();
	}
	
	$rukey = isset($_REQUEST['rukey']) ? $_REQUEST['rukey'] : '';
	if ($rukey != '') {
		unset($existing_hooks[$rukey]);
		update_option('essb-hook', $existing_hooks);
	}
	
	$button_positions = essb_option_value('button_position');
	if (!is_array($button_positions)) {
		$button_positions = array();
	}
	
	
	$has_one = false;
	
	echo '<div class="essb-shortcode-stored">';
	
	foreach ($existing_hooks as $key => $data) {
		echo '<div class="essb-stored-sc">';
		echo $data['name'].', ID: '.$key;
		echo '<span class="generated">Type: ' . $data['type'].', Status: '.(in_array($key, $button_positions) ? '<b>RUNNING</b>': 'NOT RUNNING').'</span>';
		
		if (!isset($data['action'])) {
			$data['action'] = '';
		}
		
		if ($data['type'] == 'position') {
			echo '<span class="shortcode" contenteditable="true"><code>
			&lt;?php
			if (function_exists("essb_hook_integration_draw")) {
				essb_hook_integration_draw("'.$key.'");
			}
			?&gt;
			</code></span>';
		}
		else {
			echo '<span class="shortcode"><code>'.$data['action'].'</code></span>';
		}
		
		echo '<a href="'.admin_url('admin.php?page=essb_redirect_developer&tab=developer&section=hooks&subsection').'&rukey='.$key.'" class="remove">Remove</a>';
		echo '</div>';
		$has_one = true;
	}
	
	if (!$has_one) {
		echo '<div class="generated">No custom user integrations are found</div>';
	}
	
	echo '</div>';
}