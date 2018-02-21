<?php

global $essb_section_options;

function essb_find_current_optiondata($key, $tab_id = '', $menu_id = '') {
	global $essb_section_options;
	
	$result = array();
	
	foreach ($essb_section_options as $tab => $tab_data) {
		foreach ($tab_data as $menu => $menu_data) {
			foreach ($menu_data as $field_data) {
				$field_key = isset($field_data['id']) ? $field_data['id'] : '';
				if ($field_key == $key) {
					$result = $field_data;
					break;
				}
			}
		}
	}
	
	return $result;
}

function essb_find_current_optiondata1($key, $tab_id, $menu_id) {
	global $essb_section_options;
	
	$result = array();
	
	if (!isset($essb_section_options[$tab_id])) {
		return $result;
	}
	
	if (!isset($essb_section_options[$tab_id][$menu_id]))
		return $result;
	
	foreach ($essb_section_options[$tab_id][$menu_id] as $field_data) {
		$field_key = isset($field_data['id']) ? $field_data['id'] : '';
		if ($field_key == $key) {
			$result = $field_data;
		}
 	}
 	
 	return $result;
}

$wpml_options = essb_wpml_translatable_fields();
$wpml_langs = ESSBWpmlBridge::getLanguages();
$wpml_langs_tabs = ESSBWpmlBridge::getLanguagesSimplified();

foreach ($wpml_options as $key => $data) {
	$type = isset($data['type']) ? $data['type'] : '';
	$title = isset($data['title']) ? $data['title'] : '';
	$group = isset($data['group']) ? $data['group'] : '';
	$tab_id = isset($data['tab_id']) ? $data['tab_id'] : '';
	$menu_id = isset($data['menu_id']) ? $data['menu_id'] : '';
	
	
	if ($type == 'menu') {
		ESSBOptionsStructureHelper::menu_item('translate', $key, $title, 'globe');		
		
		if (!ESSBActivationManager::isActivated()) {
			//ESSBOptionsFramework::draw_hint(__('Unlock the full power of ready made styles!', 'essb'), 'Hello! Please <a href="admin.php?page=essb_redirect_update&tab=update">activate your copy</a> of Easy Social Share Buttons for WordPress to unlock all 35+ ready made presents that you will be able to install on your site.', 'fa fa-lock', 'status essb-status-activate essb-status-activate-presents');
			ESSBOptionsStructureHelper::hint('translate', $key, __('Unlock usage of Multilangual Translate!', 'essb'), 'Hello! Please <a href="admin.php?page=essb_redirect_update&tab=update">activate your copy</a> of Easy Social Share Buttons for WordPress to unlock all 35+ ready made presents that you will be able to install on your site.', 'fa fa-lock', 'status essb-status-activate essb-status-activate-presents');		
		}
		
	}
	
	if ($type == 'heading') {
		ESSBOptionsStructureHelper::field_heading('translate', $group, 'heading5', $title);
	}
	
	if ($type == 'networks') {
		//generate translations by social networks
		$networks_list = essb_available_social_networks();
		foreach ($networks_list as $network => $data) {
			$name = isset($data['name']) ? $data['name'] : $network;
			$key = 'translate_'.$network;
			
			ESSBOptionsStructureHelper::panel_start('translate', $group, $name, __('Customize texts for this social network'), 'fa21 fa fa-globe', array("mode" => "toggle", 'state' => 'closed'));
				
			ESSBOptionsStructureHelper::tabs_start('translate', $group, $key.'-translate', $wpml_langs_tabs);
			
			$tab_count = 0;
			foreach ($wpml_langs as $lang => $lang_name) {
				ESSBOptionsStructureHelper::tab_start('translate', $group, $key.'-translate-'.$tab_count, ($tab_count == 0 ? true: false));
			
				ESSBOptionsStructureHelper::field_textbox_stretched('translate', $group, 'wpml_user_network_name_'.$network.'_'.$lang, __('Network name', 'essb'), __('Customize text that is used as network name on button', 'essb'));
				ESSBOptionsStructureHelper::field_textbox_stretched('translate', $group, 'wpml_hovertext_'.$network.'_'.$lang, __('Hover text', 'essb'), __('Customize text that will appear on button hover', 'essb'));				
				
				ESSBOptionsStructureHelper::tab_end('translate', $group);
				$tab_count++;
			}
			ESSBOptionsStructureHelper::tabs_end('translate', $group);
			ESSBOptionsStructureHelper::panel_end('translate', $group);
				
		}
	}
	
	if ($type == 'field') {


		$field_data = essb_find_current_optiondata($key, $tab_id, $menu_id);
		$field_type = isset($field_data['type']) ? $field_data['type'] : '';

		if ($field_type != '') {
			ESSBOptionsStructureHelper::panel_start('translate', $group, $field_data['title'], $field_data['description'], 'fa21 fa fa-globe', array("mode" => "toggle", 'state' => 'closed'));
			
			ESSBOptionsStructureHelper::tabs_start('translate', $group, $key.'-translate', $wpml_langs_tabs);
				
			$tab_count = 0;
			foreach ($wpml_langs as $lang => $lang_name) {
				ESSBOptionsStructureHelper::tab_start('translate', $group, $key.'-translate-'.$tab_count, ($tab_count == 0 ? true: false));
				
				
				$new_field_data = array();
				foreach ($field_data as $fkey => $fvalue) {
					$new_field_data[$fkey] = $fvalue;
				}
				$new_field_data['title'] = '';
				$new_field_data['description'] = '';
				$new_field_data['id'] = 'wpml_'.$key.'_'.$lang;
				$essb_section_options['translate'][$group][] = $new_field_data;
				
				ESSBOptionsStructureHelper::tab_end('translate', $group);
				$tab_count++;
			}
			ESSBOptionsStructureHelper::tabs_end('translate', $group);
			ESSBOptionsStructureHelper::panel_end('translate', $group);
		}
	}
}