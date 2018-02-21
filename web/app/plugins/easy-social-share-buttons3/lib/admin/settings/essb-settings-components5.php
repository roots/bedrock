<?php

function essb_component_network_selection($position = '', $options_group = 'essb_options') {
	$active_networks = array();
	//$active_networks_order = array();
	$essb_networks = essb_available_social_networks();
	
	if ($position == '') {
		$active_networks = essb_option_value('networks');
		//$active_networks_order = essb_option_value('networks_order');
	}
	else {
		$active_networks = essb_option_value($position.'_networks');
	}
	
	//if (count($active_networks_order) > 0) {
	//	$network_order = apply_filters('essb4_social_networks_update_order', $active_networks_order);
	//}
	
	$salt = mt_rand();
	
	if (!is_array($active_networks)) {
		$active_networks = array();
	}
	
	echo '<ul class="essb-component-networkselect essb-sortable essb-componentkey-'.$salt.' essb-component-networkselect-'.$position.'" id="essb-componentkey-'.$salt.'" data-position="'.$position.'">';
	
	foreach ($active_networks as $network) {
	
		$current_network_name = isset($essb_networks[$network]) ? $essb_networks[$network]["name"] : $network;
		
		if ($position == '') {
			$user_network_name = essb_option_value('user_network_name_'.$network);
		
			if ($user_network_name == '') {
				$user_network_name = $current_network_name;
			}
		}
		else {
			$user_network_name = essb_option_value($position.'_'.$network.'_name');
		}
	
		echo '<li class="essb-admin-networkselect-single essb-network-color-'.$network.'" data-network="'.$network.'" data-key="'.$salt.'">';
		if ($position != '') {
			echo '<input type="hidden" name="'.$options_group.'['.$position.'_networks][]" value="'.$network.'"/>';
		}
		else {
			echo '<input type="hidden" name="'.$options_group.'[networks][]" value="'.$network.'"/>';
		}
		echo '<span class="essb-icon-remove fa fa-times" onclick="essbSettingsHelper.removeNetwork(this); return false;"></span>';
		echo '<span class="essb_icon essb_icon_'.$network.'"></span>';
		echo '<span class="essb-sns-name">'.$current_network_name.'</span>';
		echo '<span class="essb-single-network-name">';

		if ($position != '') {
			echo __('Personalize text on button:', 'essb').'<br/><input type="text" class="input-element" name="essb_options['.$position.'_'.$network.'_name]" value="'.$user_network_name.'"/>';
		}
		else {
			echo __('Personalize text on button:', 'essb').'<br/><input type="text" class="input-element" name="essb_options_names['.$network.']" value="'.$user_network_name.'"/>';
		}
		echo '</span>';	
		echo '</li>';
	}

	$network = 'add';
	echo '<li class="essb-admin-networkselect-single essb-network-color-'.$network.'" data-network="'.$network.'" data-key="'.$salt.'" onclick="essbSettingsHelper.startNetworkSelection(\''.$salt.'\'); return false;">';
	echo '<span class="essb_icon fa fa-plus-square"></span>';
	echo '<span class="essb-sns-name">'.__('Add more networks', 'essb').'</span>';
	echo '</li>';
	
	
	echo '</ul>';
}

function essb_component_base_dummy_share() {
	return array("url" => "", "title" => "", "image" => "", "description" => "", "twitter_user" => "",
			"twitter_hashtags" => "", "twitter_tweet" => "", "post_id" => 0, "user_image_url" => "", "title_plain" => "",
			'short_url_whatsapp' => '', 'short_url_twitter' => '', 'short_url' => '', 'pinterest_image' => "", "full_url" => "");
}

function essb_component_base_dummy_style($user_counter = false, $counter_pos = '', $total_counter_pos = '') {
	$style = array("button_style" => "button", "align" => "left", "button_width" => "auto", "counters" => false);

	if ($user_counter) {
		$style['show_counter'] = 1;
		$style['counters'] = true;
		if ($counter_pos != '') {
			$style['counter_pos'] = $counter_pos;
		}

		if ($total_counter_pos != '') {
			$style['total_counter_pos'] = $total_counter_pos;
		}
		$style['demo_counter'] = "yes";
	}
	else {
		$style['show_counter'] = 0;
		$style['counter_pos'] = 'hidden';
		$style['total_counter_pos'] = 'hidden';
	}

	$style['button_align'] = 'left';
	$style['counter_pos'] = 'hidden';
	$style['total_counter_hidden_till'] = '';
	$style['nospace'] = false;
	$style['full_url'] = false;
	$style['message_share_buttons'] = '';
	$style['message_share_before_buttons'] = '';
	$style['is_mobile'] = false;
	$style['amp'] = false;
	$style['native'] = false;
	$style['total_counter_afterbefore_text'] = '';

	return $style;
}

function essb_component_template_select($position = '', $options_group = 'essb_options') {
	$value_field_id = 'style';
	// position 
	if ($position != '') {
		$value_field_id = $position.'_template';
	}
	$value_text_id = $value_field_id.'_text';
	
	// selected value
	$selected = essb_option_value('style');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_template');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}
	
	if ($selected == '') {
		$selected = '32';
	}
	$selected_name = '';
	
	$templates = essb_available_tempaltes4();
	foreach ($templates as $key => $name) {
		if ($key == $selected ) {
			$selected_name = $name;
		}
	}
	
	echo '<div class="essb-popup-select essb-popup-select-'.$value_field_id.'" data-field="'.$value_field_id.'" data-field-text="'.$value_text_id.'" data-field-window="#essb-templateselect">';
	echo '<input type="hidden" id="essb_field_'.$value_field_id.'" class="essb_field_'.$value_field_id.'" value="'.$selected.'" name="'.$options_group.'['.$value_field_id.']">';
	echo '<div class="inner" id="'.$value_field_id.'_text">';
	echo $selected_name;
	echo '</div>';
	echo '<div class="picker"><i class="fa fa-ellipsis-h"></i></div>';
	echo '</div>';
}

function essb_component_base_template_selection($position = '', $field_id = '', $field_text_id = '') {
	$list_of_templates = essb_available_tempaltes4();
	
	$selected = essb_option_value('style');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_template');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}
	
	if ($selected == '') {
		$selected = '32';
	}
	
	$button_style = essb_component_base_dummy_style();
	
	echo '<div class="essb-component-clickholder" data-field="'.$field_id.'" data-field-text="'.$field_text_id.'">';
	
	foreach ($list_of_templates as $key => $name) {
		
		$button_style['template'] = $key;
		
		echo '<div class="essb-component-clickselect'.($selected == $key ? ' active': '').' essb-template-select-'.$key.'" data-value="'.$key.'" data-text="'.$name.'">';
		echo '<div class="inner-title">'.$name.'</div>';
		echo '<div class="inner-content">'.ESSBButtonHelper::draw_share_buttons(essb_component_base_dummy_share(), $button_style, array("facebook","twitter"), array("facebook","twitter","google"), array("facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google"), "shortcode", "1112233").'</div>';
		echo '</div>';
	}
	
	echo '</div>';
}

function essb_component_base_button_style_selection($position = '') {
	$essb_available_buttons_style = array();
	$essb_available_buttons_style ['button'] = __('Regular share buttons with icon & name/text', 'essb'); 
	$essb_available_buttons_style ['button_name'] = __('Share button with name/text only (no icon)', 'essb');
	$essb_available_buttons_style ['icon'] = __('Share button with icon only', 'essb');
	$essb_available_buttons_style ['icon_hover'] = __('Share button with icon and name/text appearing on hover', 'essb');
	$essb_available_buttons_style ['vertical'] = __('Vertical button', 'essb');
	
	$selected = essb_option_value('button_style');
	$template = essb_option_value('style');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_button_style');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}
	
	if ($selected == '') {
		$selected = 'button';
	}
	
	$button_style = essb_component_base_dummy_style();
	
	echo '<div class="essb-component-clickholder" data-field="" data-field-text="">';
	
	foreach ($essb_available_buttons_style as $key => $name) {
	
		$button_style['template'] = $template;
		$button_style['button_style'] = $key;
	
		echo '<div class="essb-component-clickselect'.($selected == $key ? ' active': '').' essb-template-select-'.$key.'" data-value="'.$key.'" data-text="'.$name.'">';
		echo '<div class="inner-title">'.$name.'</div>';
		echo '<div class="inner-content">'.ESSBButtonHelper::draw_share_buttons(essb_component_base_dummy_share(), $button_style, array("facebook","twitter"), array("facebook","twitter","google"), array("facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google"), "shortcode", "1112233").'</div>';
		echo '</div>';
	}
	
	echo '</div>';
}

function essb_component_buttonstyle_select($position = '', $options_group = 'essb_options') {
	$value_field_id = 'button_style';
	// position
	if ($position != '') {
		$value_field_id = $position.'_button_style';
	}
	$value_text_id = $value_field_id.'_text';

	// selected value
	$selected = essb_option_value('button_style');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_button_style');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}

	if ($selected == '') {
		$selected = 'button';
	}
	$selected_name = '';

	$essb_available_buttons_style = array();
	$essb_available_buttons_style ['button'] = __('Regular share buttons with icon & name/text', 'essb'); 
	$essb_available_buttons_style ['button_name'] = __('Share button with name/text only (no icon)', 'essb');
	$essb_available_buttons_style ['icon'] = __('Share button with icon only', 'essb');
	$essb_available_buttons_style ['icon_hover'] = __('Share button with icon and name/text appearing on hover', 'essb');
	$essb_available_buttons_style ['vertical'] = __('Vertical button', 'essb');
	foreach ($essb_available_buttons_style as $key => $name) {
		if ($key == $selected ) {
			$selected_name = $name;
		}
	}

	echo '<div class="essb-popup-select essb-popup-select-'.$value_field_id.'" data-field="'.$value_field_id.'" data-field-text="'.$value_text_id.'" data-field-window="#essb-buttonstyleselect">';
	echo '<input type="hidden" id="essb_field_'.$value_field_id.'" class="essb_field_'.$value_field_id.'" value="'.$selected.'" name="'.$options_group.'['.$value_field_id.']">';
	echo '<div class="inner" id="'.$value_field_id.'_text">';
	echo $selected_name;
	echo '</div>';
	echo '<div class="picker"><i class="fa fa-ellipsis-h"></i></div>';
	echo '</div>';
}


function essb_component_base_counter_position_selection($position = '', $field_id = '', $field_text_id = '') {
	$list_of_templates = essb_avaliable_counter_positions();

	$selected = essb_option_value('counter_pos');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_counter_pos');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}

	$template = essb_option_value('style');
	if ($selected == '') {
		$selected = 'hidden';
	}


	echo '<div class="essb-component-clickholder" data-field="'.$field_id.'" data-field-text="'.$field_text_id.'">';

	foreach ($list_of_templates as $key => $name) {

		$button_style = essb_component_base_dummy_style(true, $key, 'hidden');
		$button_style['template'] = $template;
		$button_style['counter_pos'] = $key;

		echo '<div class="essb-component-clickselect'.($selected == $key ? ' active': '').' essb-counterpos-select-'.$key.'" data-value="'.$key.'" data-text="'.$name.'">';
		echo '<div class="inner-title">'.$name.'</div>';
		echo '<div class="inner-content">'.ESSBButtonHelper::draw_share_buttons(essb_component_base_dummy_share(), $button_style, array("facebook","twitter"), array("facebook","twitter","google"), array("facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google"), "shortcode", "1112233").'</div>';
		echo '</div>';
	}

	echo '</div>';
}

function essb_component_counterpos_select($position = '', $options_group = 'essb_options') {
	$value_field_id = 'counter_pos';
	// position
	if ($position != '') {
		$value_field_id = $position.'_counter_pos';
	}
	$value_text_id = $value_field_id.'_text';

	// selected value
	$selected = essb_option_value('counter_pos');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_counter_pos');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}

	if ($selected == '') {
		$selected = 'hidden';
	}
	$selected_name = '';

	$list = essb_avaliable_counter_positions();
	foreach ($list as $key => $name) {
		if ($key == $selected ) {
			$selected_name = $name;
		}
	}

	echo '<div class="essb-popup-select essb-popup-select-'.$value_field_id.'" data-field="'.$value_field_id.'" data-field-text="'.$value_text_id.'" data-field-window="#essb-counterposselect">';
	echo '<input type="hidden" id="essb_field_'.$value_field_id.'" class="essb_field_'.$value_field_id.'" value="'.$selected.'" name="'.$options_group.'['.$value_field_id.']">';
	echo '<div class="inner" id="'.$value_field_id.'_text">';
	echo $selected_name;
	echo '</div>';
	echo '<div class="picker"><i class="fa fa-ellipsis-h"></i></div>';
	echo '</div>';
}

// Total Counter Position
function essb_component_base_total_counter_position_selection($position = '', $field_id = '', $field_text_id = '') {
	$list_of_templates = essb_avaiable_total_counter_position();

	$selected = essb_option_value('total_counter_pos');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_total_counter_pos');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}

	$template = essb_option_value('style');
	if ($selected == '') {
		$selected = 'hidden';
	}


	echo '<div class="essb-component-clickholder" data-field="'.$field_id.'" data-field-text="'.$field_text_id.'">';

	foreach ($list_of_templates as $key => $name) {

		$button_style = essb_component_base_dummy_style(true, $key, 'hidden');
		$button_style['template'] = $template;
		$button_style['total_counter_pos'] = $key;

		echo '<div class="essb-component-clickselect'.($selected == $key ? ' active': '').' essb-counterpos-select-'.$key.'" data-value="'.$key.'" data-text="'.$name.'">';
		echo '<div class="inner-title">'.$name.'</div>';
		echo '<div class="inner-content">'.ESSBButtonHelper::draw_share_buttons(essb_component_base_dummy_share(), $button_style, array("facebook","twitter"), array("facebook","twitter","google"), array("facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google"), "shortcode", "1112233").'</div>';
		echo '</div>';
	}

	echo '</div>';
}

function essb_component_totalcounterpos_select($position = '', $options_group = 'essb_options') {
	$value_field_id = 'total_counter_pos';
	// position
	if ($position != '') {
		$value_field_id = $position.'_total_counter_pos';
	}
	$value_text_id = $value_field_id.'_text';

	// selected value
	$selected = essb_option_value('total_counter_pos');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_total_counter_pos');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}

	if ($selected == '') {
		$selected = 'hidden';
	}
	$selected_name = '';

	$list = essb_avaiable_total_counter_position();
	foreach ($list as $key => $name) {
		if ($key == $selected ) {
			$selected_name = $name;
		}
	}

	echo '<div class="essb-popup-select essb-popup-select-'.$value_field_id.'" data-field="'.$value_field_id.'" data-field-text="'.$value_text_id.'" data-field-window="#essb-totalcounterposselect">';
	echo '<input type="hidden" id="essb_field_'.$value_field_id.'" class="essb_field_'.$value_field_id.'" value="'.$selected.'" name="'.$options_group.'['.$value_field_id.']">';
	echo '<div class="inner" id="'.$value_field_id.'_text">';
	echo $selected_name;
	echo '</div>';
	echo '<div class="picker"><i class="fa fa-ellipsis-h"></i></div>';
	echo '</div>';
}

function essb_component_options_group_select($field = '', $values = array(), $size = '', $default_value = '', $options_group = 'essb_options') {
	$value = essb_option_value($field);
	
	if ($default_value != '' && $value == '') {
		$value = $default_value;
	}
	
	if ($size != '') {
		$size = ' '.$size;
	}
	
	echo '<div class="essb-component-toggleselect essb-component-'.$field.$size.'">';
	echo '<input type="hidden" name="'.$options_group.'['.$field.']" id="essb_options_'.$field.'" value="'.$value.'" class="toggleselect-holder"/>';
	
	foreach ($values as $key => $data) {
		$title = isset($data['title']) ? $data['title'] : '';
		$content = isset($data['content']) ? $data['content'] : '';
		$isText = isset($data['isText']) ? true: false;
		$customPadding = isset($data['padding']) ? $data['padding'] : '';
		
		if ($customPadding != '') {
			$customPadding = ' style="padding:'.$customPadding.'"';
		}
		
		if ($isText) {
			$content = '<span class="text">'.$content.'</span>';
		}
		
		echo '<span class="toggleselect-item'.($key == $value ? ' active': '').'" data-value="'.$key.'" title="'.$title.'"'.$customPadding.'>';
		echo $content;
		echo '</span>';
	}
	
	echo '</div>';
}

function essb_component_options_group_select_multiple($field = '', $values = array(), $size = '', $default_value = array(), $options_group = 'essb_options') {
	$value = essb_option_value($field);

	if (!is_array($default_value)) {
		$default_value = array();
	}
	
	if ($size != '') {
		$size = ' '.$size;
	}

	echo '<div class="essb-component-groupselect essb-component-'.$field.$size.'">';	

	foreach ($values as $key => $data) {
		$title = isset($data['title']) ? $data['title'] : '';
		$content = isset($data['content']) ? $data['content'] : '';
		$isText = isset($data['isText']) ? true: false;
		$customPadding = isset($data['padding']) ? $data['padding'] : '';

		if ($customPadding != '') {
			$customPadding = ' style="padding:'.$customPadding.'"';
		}

		if ($isText) {
			$content = '<span class="text">'.$content.'</span>';
		}

		$isChecked = in_array($key, $default_value);
		
		echo '<span class="toggleselect-item'.($isChecked ? ' active': '').'" data-value="'.$key.'" title="'.$title.'"'.$customPadding.'>';
		echo $content;
		echo '<input type="checkbox" name="'.$options_group.'['.$field.'][]" id="essb_options_'.$field.'_'.$key.'" value="'.$key.'" class="toggleselect-holder" '.($isChecked ? 'checked="checked"': '').'/>';
		echo '</span>';
	}

	echo '</div>';
}

// Animations
function essb_component_base_animation_selection($position = '', $field_id = '', $field_text_id = '') {
	$list_of_templates = essb_available_animations(true);

	$selected = essb_option_value('css_animations');

	$template = essb_option_value('style');
	if ($selected == '') {
		$selected = '';
	}


	echo '<div class="essb-component-clickholder" data-field="'.$field_id.'" data-field-text="'.$field_text_id.'">';

	foreach ($list_of_templates as $key => $name) {

		$button_style = essb_component_base_dummy_style(false, $key, 'hidden');
		$button_style['template'] = $template;
		$button_style['button_animation'] = $key;

		echo '<div class="essb-component-clickselect'.($selected == $key ? ' active': '').' essb-counterpos-select-'.$key.'" data-value="'.$key.'" data-text="'.$name.'">';
		echo '<div class="inner-title">'.$name.'</div>';
		echo '<div class="inner-content">'.ESSBButtonHelper::draw_share_buttons(essb_component_base_dummy_share(), $button_style, array("facebook","twitter"), array("facebook","twitter","google"), array("facebook" => "Facebook", "twitter" => "Twitter", "google" => "Google"), "shortcode", "1112233").'</div>';
		echo '</div>';
	}

	echo '</div>';
}

function essb_component_animation_select($position = '', $options_group = 'essb_options') {
	$value_field_id = 'css_animations';
	// position
	if ($position != '') {
		$value_field_id = $position.'_css_animations';
	}
	$value_text_id = $value_field_id.'_text';

	// selected value
	$selected = essb_option_value('css_animations');
	if ($position != '') {
		$position_selected = essb_option_value($position.'_css_animations');
		if ($position_selected != '') {
			$selected = $position_selected;
		}
	}

	if ($selected == '') {
		$selected = '';
	}
	$selected_name = '';

	$list = essb_available_animations(true);
	foreach ($list as $key => $name) {
		if ($key == $selected ) {
			$selected_name = $name;
		}
	}

	echo '<div class="essb-popup-select essb-popup-select-'.$value_field_id.'" data-field="'.$value_field_id.'" data-field-text="'.$value_text_id.'" data-field-window="#essb-animationsselect">';
	echo '<input type="hidden" id="essb_field_'.$value_field_id.'" class="essb_field_'.$value_field_id.'" value="'.$selected.'" name="'.$options_group.'['.$value_field_id.']">';
	echo '<div class="inner" id="'.$value_field_id.'_text">';
	echo $selected_name;
	echo '</div>';
	echo '<div class="picker"><i class="fa fa-ellipsis-h"></i></div>';
	echo '</div>';
}

function essb_component_single_position_select($positions, $field_id = '', $options_group = 'essb_options') {
	//var_dump($positions);
	$value = essb_option_value($field_id);
	
	echo '<div class="essb-position-select essb-single-position-select">';
	
	foreach ($positions as $key => $data) {
		
		$image = isset($data['image']) ? $data['image'] : '';
		$label = isset($data['label']) ? $data['label'] : '';
		$desc = isset($data['desc']) ? $data['desc'] : '';
		$link = isset($data['link']) ? $data['link'] : '';
		
		//$link = 'test';
		//$desc = 'Display share buttons at the begining of post content';
		
		$pathToImages = ESSB3_PLUGIN_URL.'/';
		if (strpos($image, 'http://') !== false || strpos($image, 'https://') !== false) {
			$pathToImages = '';
		}
		
		echo '<div class="essb-single essb-single-'.$key.($key == $value ? ' active' : '').'" data-value="'.$key.'">';
		echo '<div class="icon"><img src="'.$pathToImages.$image.'" title="'.$label.'"/>';
		echo '<div class="active-mark" title="Active Position"><i class="ti-check-box"></i></div>';

		if ($link != '') {
			$link_parts = explode('|', $link);
			echo '<div class="customize" title="Personalize Display Options" data-menu="'.$link_parts[0].'" data-sub-menu="'.$link_parts[1].'"><i class="ti-settings"></i></div>';
		}
		
		
		
		echo '</div>';
		echo '<div class="title">'.$label;
		
		if ($desc != '') {
			echo '<div class="description">'.$desc.'</div>';
		}
		echo '</div>';
		
		echo '</div>';
	}
	
	echo '<input type="hidden" name="'.$options_group.'['.$field_id.']" id="essb_component_'.$field_id.'" value="'.$value.'" class="value-holder"/>';
	
	echo '</div>';
}

function essb_component_multi_position_select($positions, $field_id = '', $options_group = 'essb_options') {
	//var_dump($positions);
	$value = essb_option_value($field_id);
	if (!is_array($value)) {
		$value = array();
	}

	echo '<div class="essb-position-select essb-multi-position-select">';

	foreach ($positions as $key => $data) {

		$image = isset($data['image']) ? $data['image'] : '';
		$label = isset($data['label']) ? $data['label'] : '';
		$desc = isset($data['desc']) ? $data['desc'] : '';
		$link = isset($data['link']) ? $data['link'] : '';
		$active = in_array($key, $value);

		//$link = 'test';
		//$desc = 'Display share buttons at the begining of post content';

		$pathToImages = ESSB3_PLUGIN_URL.'/';
		if (strpos($image, 'http://') !== false || strpos($image, 'https://') !== false) {
			$pathToImages = '';
		}

		echo '<div class="essb-single essb-single-'.$key.($active ? ' active' : '').'" data-value="'.$key.'">';
		echo '<div class="icon"><img src="'.$pathToImages.$image.'" title="'.$label.'"/>';
		echo '<div class="active-mark" title="Active Position"><i class="ti-check-box"></i></div>';

		if ($link != '') {
			$link_parts = explode('|', $link);
			echo '<div class="customize" title="Personalize Display Options" data-menu="'.$link_parts[0].'" data-sub-menu="'.$link_parts[1].'"><i class="ti-settings"></i></div>';
		}


		echo '</div>';
		echo '<div class="title">'.$label;

		if ($desc != '') {
			echo '<div class="description">'.$desc.'</div>';
		}
		echo '</div>';

		echo '<input type="checkbox" name="'.$options_group.'['.$field_id.'][]" id="essb_component_'.$field_id.'_'.$key.'" value="'.$key.'" class="value-holder" '.($active ? 'checked="checked"' : '').'/>';
		
		echo '</div>';
	}

	//echo '<input type="hidden" name="'.$options_group.'['.$field_id.']" id="essb_component_'.$field_id.'" value="'.$value.'" class="value-holder"/>';

	echo '</div>';
}