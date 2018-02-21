<?php

class ESSBOptionsFramework {
	
	public static $color_fields = array();
	public static $was_lastrow_even = false;
	public static $section_active = false;
	public static $headings_count = 0;
	public static $heading_navigations = array();
	
	public static $default_settings_group = "essb_options";
	public static $options_cache = array();
	
	public static function reset_row_status() {
		self::$was_lastrow_even = false;
		self::$heading_navigations = array();
	}
	
	public static function external_options_value ($key, $param) {
		$value = '';
		if (!isset(self::$options_cache[$key])) {
			$settings_key = self::option_keys_to_settings($key);
			
			if (!empty($settings_key)) {
				self::$options_cache[$key] = get_option($settings_key);
			}						
		}
		
		if (isset(self::$options_cache[$key])) {
			$value = isset(self::$options_cache[$key][$param]) ? self::$options_cache[$key][$param] : '';
		}
		
		return $value;
	}
	
	public static function option_keys_to_settings($key) {
		$table = array('essb3_of' => 'essb3-of', 'essb3_ofob' => 'essb3-ofob', 'essb3_ofof' => 'essb3-ofof');
		
		return isset($table[$key]) ? $table[$key] : '';
	}
	
	public static function draw_options_field($option, $custom = false, $user_settings = array()) {
		global $essb_admin_options, $essb_admin_options_fanscounter, $essb_translate_options;
		
		
		$type = $option['type'];
		$title = isset($option['title']) ? $option['title'] : '';
		$submenu_link = isset($option['submenu_link']) ? $option['submenu_link'] : "";
		$description = isset($option['description']) ? $option['description'] : "";
		$id = isset($option['id']) ? $option['id'] : '';
		$icon = isset($option['icon']) ? $option['icon'] : '';
		$icon_position = isset($option['icon_position']) ? $option['icon_position'] : '';
		
		$on_text = isset($option['on_label']) ? $option['on_label'] : "";
		$off_text = isset($option['off_label']) ? $option['off_label'] : "";
		$listOfValues = isset($option['values']) ? $option['values'] : array();
		$class = isset($option['class']) ? $option['class'] : '';
		$mode = isset($option['mode']) ? $option['mode'] : 'htmlmixed';
		$recommended = isset($option['recommended']) ? $option['recommended'] : '';
		$select2_options = isset($option['select2_options']) ? $option['select2_options'] : array();
		
		$width = isset($option['width']) ? $option['width'] : '';
		$title_position = isset($option['title_position']) ? $option['title_position'] : '';
		$colwidth = isset($option['colwidth']) ? $option['colwidth'] : '';
		$style = isset($option['style']) ? $option['style'] : '';
		$in_section = isset($option['in_section']) ? $option['in_section'] : '';
		$element_options = isset($option['element_options']) ? $option['element_options']: array();
		$col_width = isset($option['col_width']) ? $option['col_width'] : '';
		$shortcode = isset($option['shortcode']) ? $option['shortcode'] : '';
		$alpha = isset($option['alpha']) ? $option['alpha'] : '';
		
		//$settings_group = "essb_options";
		$settings_group = self::$default_settings_group;
		$is_fans_counter = false;
		if (strpos($id, 'essb3fans_') !== false) {
			$option_value = isset($essb_admin_options_fanscounter[$id]) ? $essb_admin_options_fanscounter[$id] : '';
			$settings_group = "essb_options_fans";
			$is_fans_counter = true;
		}
		else if(strpos($id, 'wpml_') !== false) {
			$option_value = isset($essb_translate_options[$id]) ? $essb_translate_options[$id] : '';
		}
		else if(strpos($id, '|') !== false) {
			$data_components = explode('|', $id);
			$settings_group = $data_components[0];
			$id = $data_components[1];
			$option_value = self::external_options_value($settings_group, $id);
		}
		else {
			$option_value = isset($essb_admin_options[$id]) ? $essb_admin_options[$id] : '';
		}
		
		if ($custom) {
			$option_value = isset($user_settings[$id]) ? $user_settings[$id] : '';
		}
		
		switch ($type) {
			case "heading1":
				self::draw_heading($title, '1', $submenu_link);
				break;
			case "heading2":
				self::draw_heading($title, '2', $submenu_link);
				break;
			case "heading3":
				self::draw_heading($title, '3', $submenu_link);
				break;		
			case "heading4":
				self::draw_heading($title, '4', $submenu_link);
				break;		
			case "heading5":
				self::draw_heading($title, '5', $submenu_link);
				break;		
			case "switch":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_switch_field($id, $settings_group, $option_value, $on_text, $off_text, $class);
				self::draw_options_row_end();
				break;		
			case "switch-in-panel":
				self::draw_settings_panel_start($title);
				self::draw_switch_field($id, $settings_group, $option_value, $on_text, $off_text, $class);
				self::draw_settings_panel_end($description, $recommended, $col_width);
				break;		
			case "text":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_input_field($id, false, $settings_group, $option_value, $icon, $class, $icon_position);
				self::draw_options_row_end();
				break;		
			case "text-in-panel":
				self::draw_settings_panel_start($title);
				self::draw_input_field($id, false, $settings_group, $option_value, $icon, $class, $icon_position);
				self::draw_settings_panel_end( $description, $recommended);
				break;
				
			case "text-stretched":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_input_field($id, true, $settings_group, $option_value, $icon, $class, $icon_position);
				self::draw_options_row_end();
				break;		
			case "checkbox":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_checkbox_field($id, $settings_group, $option_value);
				self::draw_options_row_end();
				break;		
			case "checkbox_list":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_checkbox_list_field($id, $listOfValues, $settings_group, $option_value);
				self::draw_options_row_end();
				break;		
			case "checkbox_list_sortable":
				if (!$is_fans_counter) {
					$ordered_values = isset($essb_admin_options[$id.'_order']) ? $essb_admin_options[$id.'_order'] : array();
				}
				else {
					//$essb_admin_options_fanscounter
					$ordered_values = isset($essb_admin_options_fanscounter[$id.'_order']) ? $essb_admin_options_fanscounter[$id.'_order'] : array();
				}
				
				if (is_array($ordered_values)) {
					if (count($ordered_values) > 0) {
						$listOfValues = $ordered_values;
						
						if ($is_fans_counter) {
							if (!in_array('mailpoet|MailPoet', $listOfValues)) {
								$listOfValues[] = 'mailpoet|MailPoet';
							}
							if (!in_array('mymail|myMail', $listOfValues)) {
								$listOfValues[] = 'mymail|myMail';
							}
							if (!in_array('spotify|Spotify', $listOfValues)) {
								$listOfValues[] = 'spotify|Spotify';
							}
							if (!in_array('twitch|Twitch', $listOfValues)) {
								$listOfValues[] = 'twitch|Twitch';
							}
							
							if (!in_array('telegram|Telegram', $listOfValues)) {
								$listOfValues[] = 'telegram|Telegram';
							}
							if (!in_array('mailerlite|MailerLite', $listOfValues)) {
								$listOfValues[] = 'mailerlite|MailerLite';
							}
							
							if (has_filter('essb4_followers_networks_update_list')) {
								$listOfValues = apply_filters('essb4_followers_networks_update_list', $listOfValues);
							}
						}
						else {
							if (strpos($id, "profile_") === false) {
								if (has_filter('essb4_social_networks_update_list')) {
									$listOfValues = apply_filters('essb4_social_networks_update_list', $listOfValues);
								}
								
							}
							else {
								if (has_filter('essb4_profile_networks_update_list')) {
									$listOfValues = apply_filters('essb4_profile_networks_update_list', $listOfValues);
								}
							}
							
							if (strpos($id, "profile_") > -1) {
								if (!in_array('xing|Xing', $listOfValues)) {
									$listOfValues[] = 'xing|Xing';
								}
							}
						}
						$listOfValues = self::translate_key_array($listOfValues);
					}
				}
				
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_checkbox_list_sortable_field($id, $listOfValues, $settings_group, $option_value, $style);
				self::draw_options_row_end();
				break;		
			case "select":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_select_field($id, $listOfValues, false, $settings_group, $option_value);
				self::draw_options_row_end();
				break;	
			case "select-in-panel":
				self::draw_settings_panel_start($title);
				self::draw_select_field($id, $listOfValues, false, $settings_group, $option_value);
				self::draw_settings_panel_end( $description, $recommended);
				break;	
			case "textarea":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_textarea_field($id, $settings_group, $option_value);
				self::draw_options_row_end();
				break;
			case "editor":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_editor_field($id, $settings_group, $option_value, $mode);
				self::draw_options_row_end();
				break;
			case "wpeditor":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_wpeditor_field($id, $settings_group, $option_value);
				self::draw_options_row_end();
				break;
			case "color":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				if ($alpha == 'true') {
					self::draw_acolor_field($id, $settings_group, $option_value);
				}
				else {
					self::draw_color_field($id, $settings_group, $option_value);
				}
				self::draw_options_row_end();
				break;
			case "color-in-panel":
				self::draw_settings_panel_start($title);
				if ($alpha == 'true') {
					self::draw_acolor_field($id, $settings_group, $option_value);
				}
				else {
					self::draw_color_field($id, $settings_group, $option_value);
				}
				self::draw_settings_panel_end($description, $recommended);
				break;
			case "image_checkbox":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_image_checkbox_field($id, $listOfValues, $settings_group, $option_value);
				//self::draw_image_checkbox_field($id, $listOfValues, 'essb_options', array("checkbox_option2" => true));
				self::draw_options_row_end();
				break;
			case "html_checkbox_buttons":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_image_checkbox_field($id, $listOfValues, $settings_group, $option_value, array('html' => 'true', 'shortcode' => $shortcode, 'width' => $width, 'buttons' => 'true'));
				//self::draw_image_checkbox_field($id, $listOfValues, 'essb_options', array("checkbox_option2" => true));
				self::draw_options_row_end();
				break;
			case "image_radio":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_image_radio_field($id, $listOfValues, $settings_group, $option_value);
				//self::draw_image_radio_field($id, $listOfValues, 'essb_options', 'checkbox_option1');
				self::draw_options_row_end();
				break;
			case "html_radio":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_image_radio_field($id, $listOfValues, $settings_group, $option_value, array('html' => 'true', 'shortcode' => $shortcode, 'width' => $width));
				self::draw_options_row_end();
				break;
			case "html_radio_buttons":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_image_radio_field($id, $listOfValues, $settings_group, $option_value, array('html' => 'true', 'shortcode' => $shortcode, 'width' => $width, 'buttons' => 'true'));
				self::draw_options_row_end();
			break;
				case "func":
				if ($title != '') {
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				}
				else {
					self::draw_options_row_start_full();
				}
				if (function_exists($id)) {					
					$id($option);
				}
				if ($title != '') {
				self::draw_options_row_end();
				}
				else {
					self::draw_options_row_end();
				}
				break;
				
			case "file":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_fileselect_field($id, $settings_group, $option_value, $icon, $class);
				self::draw_options_row_end();
				break;	
			case "fileimage":
				if ($mode == 'vertical') {
					self::draw_title($title, $description, 'inner-row');
					self::draw_options_row_start_full($class);
					self::draw_fileselect_image_field($id, $settings_group, $option_value, $icon, $class);
					self::draw_options_row_end();
				}
				else {
					self::draw_options_row_start($title, $description, $recommended, $col_width);
					self::draw_fileselect_image_field($id, $settings_group, $option_value, $icon, $class);
					self::draw_options_row_end();
				}
				break;
			case "simplesort":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_simplesort_field($id, $listOfValues, $settings_group, $option_value);
				self::draw_options_row_end();
				break;
			case 'section_start':
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_section_start();
				self::$section_active = true;
				break;
			case 'section_end':
				self::draw_section_end();
				self::draw_options_row_end();
				self::$section_active = false;
				break;
			case "select2":
				self::draw_options_row_start($title, $description, $recommended, $col_width);
				self::draw_select2_field($id, $listOfValues, false, $settings_group, $option_value, $select2_options);
				self::draw_options_row_end();
				break;	
			case 'section_start_panels':
				self::draw_options_row_start($title, $description, $recommended, $col_width, $title_position);
				self::$section_active = true;
				break;
			case 'section_end_panels':
				self::draw_options_row_end();
				self::$section_active = false;
				break;

			case 'section_start_full_panels':
				self::draw_options_row_start_full();
				self::$section_active = true;
				break;
			case 'section_end_full_panels':
				self::draw_options_row_end();
				self::$section_active = false;
				break;
			case 'structure_section_start':
				self::draw_structure_section_start($width, $title, $description, $title_position, $colwidth);
				break;
			case 'structure_section_end':
				self::draw_structure_section_end($title_position);
				break;
			case 'structure_row_start':
				self::draw_structure_row_start($class);
				break;
			case 'structure_row_end':
				self::draw_structure_row_end();
				break;	
			case "hint":
				self::draw_hint($title, $description, $icon, $style, $in_section);
				break;	
			case "panel_start":
				self::draw_panel_start($title, $description, $icon, $element_options, $settings_group);
				break;
			case 'panel_end':
				self::draw_panel_end();
				break;	
			case "tabs_start":
				self::draw_tabs_start($listOfValues, $element_options);
				break;
			case 'tabs_end':
				self::draw_tabs_end();
				break;	
			case "tab_start":
				self::draw_tab_start($element_options);
				break;
			case 'tab_end':
				self::draw_tab_end();
				break;	
			case 'title':
				self::draw_title($title, $description, $class);
				break;
		}
	}
	
	public static function draw_title($title = '', $description = '', $class = '') {
		self::draw_options_row_start_full($class);
		
		if ($title != '') {
			print '<strong class="essb-title">'.$title.'</strong>';
		}
		
		if ($description != '') {
			if ($title != '') { print '<br/>'; }
			print '<span class="label">'.$description.'</span>';
		}
		
		self::draw_options_row_end();
	}

	public static function draw_tab_start($element_options = array()) {
		$element_id = isset($element_options['element_id']) ? $element_options['element_id'] : '';
		$active = isset($element_options['active']) ? $element_options['active'] : '';
	

		print '<div class="essb-section-tab ess-section-tab-'.$element_id.($active == 'true' ? " active": '').'" id="'.$element_id.'">';
		
	}
	
	public static function draw_tab_end() {
		print '</div>'; // tab
	}
	
	public static function draw_tabs_start($values, $element_options = array()) {
		$vertical = isset($element_options['vertical']) ? $element_options['vertical'] : '';
		$element_id = isset($element_options['element_id']) ? $element_options['element_id'] : '';
		$active_tab = isset($element_options['active_tab']) ? $element_options['active_tab'] : '';
		
		$mark_as_active = 0;
		
		if (intval($active_tab) != 0) {
			$mark_as_active = intval($active_tab);
		}
		
		print '<div class="essb-section-tabs '.($vertical == 'true' ? " essb-section-tabs-vertical" : " essb-section-tabs-linear").'">';
		print '<div class="essb-section-tabs-navigation">';
		
		$tab_count = 0;
		print '<ul>';
		foreach ($values as $tab) {
			print '<li class="essb-section-tabs-single'.($tab_count == $mark_as_active ? " active": "").'" data-tab="'.$element_id.'-'.$tab_count.'">'.$tab.'</li>';
			$tab_count++;
		}
		
		print '</ul>';
		print '</div>';
		
		print '<div class="essb-section-tabs-container">';
	}
	
	public static function draw_tabs_end() {
		print '</div>'; // container
		print '</div>'; // tab
	}
	
	public static function draw_panel_start($title = '', $description = '', $icon = '', $element_options = array(), $settings_group = 'essb_options') {
		global $essb_admin_options;
		
		self::draw_options_row_start_full();
		
		$style = isset($element_options['style']) ? $element_options['style'] : '';
		$mode = isset($element_options['mode']) ? $element_options['mode'] : '';
		$state = isset($element_options['state']) ? $element_options['state'] : '';
		$switch_id = isset($element_options['switch_id']) ? $element_options['switch_id'] : '';
		$switch_value = ($switch_id != '') ? isset($essb_admin_options[$switch_id]) ? $essb_admin_options[$switch_id] : '' : '';
		$switch_on = isset($element_options['switch_on']) ? $element_options['switch_on'] : '';
		$switch_off = isset($element_options['switch_off']) ? $element_options['switch_off'] : '';
		$switch_submit = isset($element_options['switch_submit']) ? $element_options['switch_submit'] : '';

		print '<div class="essb-portlet'.($style != "" ? " essb-portlet-".$style : "").($mode != '' ? ' essb-portlet-'.$mode : '').($switch_submit == 'true' ? ' essb-portlet-submit' : '').'">';
		
		print '<div class="essb-portlet-heading'.($state == 'closed' ? ' essb-portlet-heading-closed' : '').($switch_submit == 'true' ? ' essb-portlet-submit' : '').'">';

		if ($mode != '') {
			if ($mode == 'toggle') {
				print '<div class="essb-portlet-state">';
				if ($state == 'closed') {
					print '<i class="fa fa-chevron-right"></i>';
				}
				else {
					print '<i class="fa fa-chevron-down"></i>';
				}
				print '</div>';
			}
			
			if ($mode == 'switch') {
				print '<div class="essb-portlet-state essb-portlet-state-switch">';
				self::draw_switch_field($switch_id, $settings_group, $switch_value, $switch_on, $switch_off);
				print '</div>';
				
				if ($switch_value != 'true') {
					$state = 'closed';
				}
			}
		}
		
		if ($icon != '') {
			print '<div class="essb-portlet-heading-icon"><i class="'.$icon.'"></i></div>';
		}
		print "<h3>".$title.'</h3>';
			if ($description != '') {
			print '<div class="essb-portlet-description">'.$description.'</div>';
		}
		
 		
		print '</div>';		
		// end: heading
		
		print '<div class="essb-portlet-content'.($state == 'closed' ? ' essb-portlet-content-closed' : '').'">';
		
		print '<div class="essb-portlet-content-separator"></div>';
		
		
	}
	
	public static function draw_panel_end() {
		print '</div>'; // content
		print '</div>'; // panel
		
		self::draw_options_row_end();
	}
	
	public static function draw_hint($title = '', $description = '', $icon = '', $style = '', $in_section = 'false') {
		
		self::draw_options_row_start_full();
		
		print '<div class="essb-options-hint'.($style != "" ? " essb-options-hint-".$style : "").'">';
		
		if ($icon != '') {
			print '<div class="essb-options-hint-icon"><i class="'.$icon.'"></i></div>';
			print '<div class="essb-options-hint-withicon">';
		}
		
		if ($title != '') {
			printf('<div class="essb-options-hint-title">%1$s</div>', $title);
		}
		if ($description != '') {
			printf('<div class="essb-options-hint-desc">%1$s</div>', $description);
		}
		
		if ($icon != '') { print '</div>'; }
		
		print '</div>';
		
		self::draw_options_row_end();
	}
	
	public static function draw_structure_row_start($class = '') {
		$row_class = "";
		if (!self::$section_active) {
			$row_class = (self::$was_lastrow_even) ? "odd" : "even";
			self::$was_lastrow_even = !self::$was_lastrow_even;
		}
		
		if ($class != '') { $row_class .= ' '.$class; }
		
		printf('<div class="essb-flex-grid-r %1$s table-border-bottom">', $row_class);
	}
	
	public static function draw_structure_row_end() {
		print '</div>';
	}
	
	public static function draw_structure_section_end($position = 'top') {
		if ($position == 'left') {
			print '</div>';
		}
		
		print '</div>';
	}
	
	public static function draw_structure_section_start($width = '', $title = '', $description = '', $position = 'top', $colwidth = '') {
		if ($width == '') {
			$width = 'c12'; // full row if no custom width is applied;
		}

		printf('<div class="essb-flex-grid-c %1$s">', $width);
		
		if ($position == '') { $position = 'top'; }
		
		if ($title != '') {
			print '<div class="essb-flex-grid-r">';
			
			if ($position == 'top') {
				print '<div class="essb-flex-grid-c c12 bold">';
				print $title;
				
				if ($description != '') {
					print '<br/><span class="label">'.$description.'</span>';
				}
				print '</div>';
				
				print '</div>';
			}
			if ($position == 'left') {
				
				$col1 = '3';
				$col2 = '9';
				
				if (intval($colwidth) > 0) {
					$col1 = $colwidth;
					$col2 = 12 - intval($col1);
				} 
				
				print '<div class="essb-flex-grid-c c'.$col1.' bold">';
				print $title;
				
				if ($description != '') {
					print '<br/><span class="label">'.$description.'</span>';
				}
				print '</div>';
				echo '<div class="essb-flex-grid-c c'.$col2.'">';
			}
		}
	}
	
	public static function draw_options_row_start($title, $description = '', $recommended = '', $col_width = '', $vertical = '') {
		
		// @new 4.0 - if field has no title than we use it in full width
		if (empty($title)) {
			self::draw_options_row_start_full();
			return;
		}
		
		$basic_param_col = '3';
		$basic_value_col = '9';
		
		if (intval($col_width) > 0) {
			$basic_param_col = $col_width;
			$basic_value_col = 12 - $col_width;
		}
		
		$row_class = "";
		if (!self::$section_active) {
			$row_class = (self::$was_lastrow_even) ? "odd" : "even";
			self::$was_lastrow_even = !self::$was_lastrow_even;
		}
		if ($description != '') {
			$new_line = "<br/>";
			if ($recommended != '') { $new_line = ''; }
			$description = sprintf('%2$s<span class="label">%1$s', $description, $new_line);
		}
		
		if ($recommended != '') {
			$recommended = '<br />
								<div class="essb-recommended">
									<i class="fa fa-check"></i><span></span>
								</div>';
		}
		
		//printf('<tr class="%1$s table-border-bottom">', $row_class);
		//printf('<td class="bold" valign="top">%1$s%3$s%2$s</td>', $title, $description, $recommended);
		//echo '<td valign="top">';
		if ($vertical == 'true') {
			printf('<div class="essb-flex-grid-r %1$s table-border-bottom essb-flex-grid-nomargin">', $row_class);
			printf('<div class="essb-flex-grid-c c12 bold">%1$s%3$s%2$s</div>', $title, $description, $recommended);
			echo '</div>';
			printf('<div class="essb-flex-grid-r %1$s table-border-bottom">', $row_class);
			echo '<div class="essb-flex-grid-c c12">';
				
		}
		else {
			printf('<div class="essb-flex-grid-r %1$s table-border-bottom">', $row_class);
			printf('<div class="essb-flex-grid-c c'.$basic_param_col.' bold">%1$s%3$s%2$s</div>', $title, $description, $recommended);
			echo '<div class="essb-flex-grid-c c'.$basic_value_col.'">';
		}
	}
	
	public static function draw_options_row_start_full($class = '') {
		$row_class = "";
		if (!self::$section_active) {
			$row_class = (self::$was_lastrow_even) ? "odd" : "even";
			self::$was_lastrow_even = !self::$was_lastrow_even;
		}
		
		if ($class != '') { $row_class .= ' '.$class; }
		
		//printf('<tr class="%1$s table-border-bottom">', $row_class);
		//echo '<td valign="top" colspan="2">';
		printf('<div class="essb-flex-grid-r %1$s table-border-bottom">', $row_class);
		print '<div class="essb-flex-grid-c c12">';
	}
	
	public static function draw_options_row_end() {
		echo '</div>';
		echo '</div>';
	}

	public static function draw_settings_panel_start($title) {
		print '<div class="essb-admin-options-panel">';
		
		printf('<div class="essb-admin-options-panel-title">%1$s</div>', $title);
		print '<div class="essb-admin-options-panel-content">';
	}
	
	public static function draw_settings_panel_end($description = '', $recommended = '') {
		if ($description != '') {
			$new_line = "<br/>";
			if ($recommended != '') {
				$new_line = '';
			}
			$description = sprintf('%2$s<span class="label">%1$s', $description, $new_line);
		}
		
		if ($recommended != '') {
			$recommended = '<br />
			<div class="essb-recommended">
			<i class="fa fa-check"></i><span></span>
			</div>';
		}
		
		print '</div>';
		printf('<div class="essb-admin-options-panel-desc">%1$s</div>', $description);
		print '</div>';
	}
	
	public static function draw_section_start() {
		echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">
		<col width="35%" />
		<col width="65%" />';
	}
	
	public static function draw_section_end() {
		echo '</table>';
	}
	
	public static function draw_heading($title, $level = '1', $submenu_link = '') {
		$css_class_heading = "";
		//print $title.'|'.$level.'|'.$submenu_link;
		switch ($level) {
			case "1":
				$css_class_heading = "sub";
				break;
			case "2":
				$css_class_heading = "sub2";
				break;
			case "3":
				$css_class_heading = "sub3";
				break;
			case "4":
				$css_class_heading = "sub4";
				break;
			case "5":
				$css_class_heading = "sub5";
				break;
			default:
				$css_class_heading = "sub";
				break;
		}
		
		if ($submenu_link != '') {
			$submenu_link = sprintf('id="essb-submenu-%1%s"', $submenu_link);
		}
		
		if (empty($submenu_link) && $level != '1') {
			self::$headings_count++;
			$navigation_id = "essb-internal-".self::$headings_count;
			self::$heading_navigations[] = array("id" => $navigation_id, "title" => $title, "level" => $level);
			$submenu_link = sprintf('id="%1$s"', $navigation_id);
		}
		
		/*printf( '<tr class="table-border-bottom" %1$s>', $submenu_link);
		printf('<td colspan="2" class="%1$s"><div>%2$s</div></td>', $css_class_heading, $title);
		echo '</tr>';*/
		printf('<div class="essb-flex-grid-r" %1$s>', $submenu_link);
		printf('<div class="essb-flex-grid-c c12 essb-heading %1$s"><div>%2$s</div></div>', $css_class_heading, $title);
		print '</div>';
	}
	
	public static function draw_simplesort_field($field, $listOfValues, $settings_group = 'essb_options', $value = '') {
		if ($value == '') {
			$value = $listOfValues; // initialize default values
		}
		
		printf('<ul class="essb_sortable" id="essb-sortable-%1$s">', $field);
		
		foreach ($value as $single) {
			printf('<li><i class="fa fa-bars" style="margin-right: 3px; margin-left: 3px;"></i> %1$s<input type="hidden" name="%2$s[%3$s][]" value="%1$s"/></li>', $single, $settings_group, $field);
		}
		
		echo '</ul>';
	}
	
	public static function draw_image_checkbox_field($field, $listOfValues, $settings_group = 'essb_options', $value = '', $element_options = array()) {
		$exist_user_value = false;

		if ($value != '') {
			$exist_user_value = true;
		}		
		
		if (!isset($element_options)) {
			$element_options = array();
		}
		$html_values = isset($element_options['html']) ? $element_options['html'] : '';
		$shortcode = isset($element_options['shortcode']) ? $element_options['shortcode'] : '';
		$width = isset($element_options['width']) ? $element_options['width'] : '';
		$buttons = isset($element_options['buttons']) ? $element_options['buttons'] : '';
		
		echo '<div class="essb_image_checkbox_container essb_image_checkbox_container_'.$field.' '.($html_values == 'true' ? 'essb_radio_container_html' : '').' '.($buttons == 'true' ? 'essb_radio_container_buttons' : '').'">';
		foreach ( $listOfValues as $singleValueCode => $singleValue ) {
			$label = isset($singleValue['label']) ? $singleValue['label'] : '';
			
			$active_state = "";
			$active_element = "";
			
			if ($exist_user_value) {
				$key = $singleValueCode;
				if (in_array($key, $value)) {
					$active_state = " active";
					$active_element = ' checked="checked"';
				}
			}
			
			if ($label != '') {
				$label = sprintf('<div class="essb_checkbox_label">%1$s</div>', $label);
			}	
			
			if ($html_values == 'true') {
				if ($shortcode == 'true') {
					$singleValue['image'] = do_shortcode($singleValue['image']);
				}
				
				printf('<div class="essb_checkbox"><div class="essb_image_checkbox%6$s" data-field="%8$s_%3$s" '.($width != '' ? ' style="width:'.$width.';"' : '').'>
						<span class="checkbox-image">%5$s%2$s</span>
						<span class="checkbox-state"><i class="fa fa-lg fa-check-circle"></i></span>
						<input type="checkbox" id="essb_options_%8$s_%3$s" name="%4$s[%8$s][]" value="%3$s"%7$s/>
						</div>%5$s</div>', ESSB3_PLUGIN_URL, $singleValue['image'], $singleValueCode, $settings_group, $label, $active_state, $active_element, $field);
			}
			else {
				$pathToImages = ESSB3_PLUGIN_URL.'/';
				if (strpos($singleValue['image'], 'http://') !== false || strpos($singleValue['image'], 'https://') !== false) {
					$pathToImages = '';
				}
				printf('<div class="essb_checkbox"><div class="essb_image_checkbox%6$s" data-field="%8$s_%3$s">
						<span class="checkbox-image"><img src="%1$s%2$s"/></span>
						<span class="checkbox-state"><i class="fa fa-lg fa-check-circle"></i></span>
						<input type="checkbox" id="essb_options_%8$s_%3$s" name="%4$s[%8$s][]" value="%3$s"%7$s/>					
						</div>%5$s</div>', $pathToImages, $singleValue['image'], $singleValueCode, $settings_group, $label, $active_state, $active_element, $field);
			}
		}	
		echo '</div>';
	}

	public static function draw_image_radio_field($field, $listOfValues, $settings_group = 'essb_options', $value = '', $element_options = array()) {		
		$exist_user_value = false;
		
		//if ($value != '') {
			$exist_user_value = true;
		//}
		
		if (!isset($element_options)) { $element_options = array(); }
		$html_values = isset($element_options['html']) ? $element_options['html'] : '';
		$shortcode = isset($element_options['shortcode']) ? $element_options['shortcode'] : '';
		$width = isset($element_options['width']) ? $element_options['width'] : '';
		$buttons = isset($element_options['buttons']) ? $element_options['buttons'] : '';
		
		echo '<div class="essb_image_radio_container essb_image_radio_container_'.$field.' '.($html_values == 'true' ? 'essb_radio_container_html' : '').' '.($buttons == 'true' ? 'essb_radio_container_buttons' : '').'">';
		$position = 1;
		foreach ( $listOfValues as $singleValueCode => $singleValue ) {
			$label = isset($singleValue['label']) ? $singleValue['label'] : '';
				
			$active_state = "";
			$active_element = "";
				
			if ($exist_user_value) {				
				if ($value == $singleValueCode) {
					$active_state = " active";
					$active_element = ' checked="checked"';
				}
			}				
			
			if ($label != '') {
				if ($html_values == 'true') {
					$label = sprintf('<div class="essb_radio_label_html">%1$s</div>', $label);
				}
				else {
					$label = sprintf('<div class="essb_radio_label">%1$s</div>', $label);
				}
			}
				
			if ($html_values == 'true') {
				if ($shortcode == 'true') {
					$singleValue['image'] = do_shortcode($singleValue['image']);
				}
				printf('<div class="essb_radio"><div class="essb_image_radio%8$s" data-field="%6$s_%7$s" '.($width != '' ? ' style="width:'.$width.';"' : '').'>
						<span class="checkbox-image">%5$s%2$s</span>
						<span class="checkbox-state"><i class="fa fa-lg fa-check-circle"></i></span>
						<input type="radio" id="essb_options_%6$s_%7$s" name="%4$s[%6$s]" value="%3$s"%9$s/>
						</div></div>', ESSB3_PLUGIN_URL, $singleValue['image'], $singleValueCode, $settings_group, $label, $field, $position, $active_state, $active_element);
			}
			else {
				
				$pathToImages = ESSB3_PLUGIN_URL.'/';
				if (strpos($singleValue['image'], 'http://') !== false || strpos($singleValue['image'], 'https://') !== false) {
					$pathToImages = '';
				}
				
				printf('<div class="essb_radio"><div class="essb_image_radio%8$s" data-field="%6$s_%7$s">
						<span class="checkbox-image"><img src="%1$s%2$s"/></span>
						<span class="checkbox-state"><i class="fa fa-lg fa-check-circle"></i></span>
						<input type="radio" id="essb_options_%6$s_%7$s" name="%4$s[%6$s]" value="%3$s"%9$s/>
						</div>%5$s</div>', $pathToImages, $singleValue['image'], $singleValueCode, $settings_group, $label, $field, $position, $active_state, $active_element);
			}
			$position++;
		}
		echo '</div>';
	}
	
	
	public static function draw_textarea_field($field, $settings_group = 'essb_options', $value = '') {
		$value = esc_textarea ( stripslashes($value));
		printf('<textarea id="essb_options_%1$s" name="%2$s[%1$s]" class="input-element stretched" rows="5">%3$s</textarea>', $field, $settings_group, $value);
	}

	public static function draw_wpeditor_field($field, $settings_group = 'essb_options', $value = '') {
		$value =  ( stripslashes($value));

		
		//printf('<div id="wpeditor_%1$s"></div>', $field);
		printf('<textarea id="essb_options_%1$s" name="%2$s[%1$s]" class="input-element stretched essb-hidden-element" rows="5">%3$s</textarea>', $field, $settings_group, $value);
		$editor_options = array('textarea_name' => $settings_group.'['.$field.']', 'editor_height' => '200');
		wp_editor($value, sprintf('wpeditor_%1$s', $field), $editor_options);
	}
	
	public static function draw_editor_field($field, $settings_group = 'essb_options', $value = '', $mode = 'htmlmixed') {
		$value = esc_textarea ( stripslashes($value));
		printf('<textarea id="essb_options_%1$s" name="%2$s[%1$s]" class="input-element stretched is-code-editor" rows="5" data-function-activate="activate__%1$s" data-editor-key="editor_%1$s">%3$s</textarea>', $field, $settings_group, $value);
		printf('<script>
				var editor_%1$s;
				function activate__%1$s() {
				console.log("actiting %1$s");
      loadedEditorControls["editor_%1$s"] = CodeMirror.fromTextArea(document.getElementById("essb_options_%1$s"), {
      lineNumbers: true,
      mode: "%2$s",
				lineWrapping: true,      
      matchBrackets: true,
      foldGutter: true,
      gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
    });
				};
  </script>', $field, $mode);
  		/*printf('<script>
				function activate__%1$s() {
				console.log("activating %1$s");
    var editor_%1$s = CodeMirror.fromTextArea(document.getElementById("essb_options_%1$s"), {
      lineNumbers: true,
      mode: "%2$s",
      lineWrapping: true,      
      matchBrackets: true,
      foldGutter: true,
      gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
    });
				};
  </script>', $field, $mode);*/
	}
	
	
	public static function draw_switch_field($field, $settings_group = 'essb_options', $value = '', $on_text = '', $off_text = '', $switch_submit = '') {
		if ($settings_group == '') { $settings_group = "essb_options"; }
		
		if ($on_text == "") { $on_text = __('On', 'essb'); }
		if ($off_text == "") { $off_text = __('Off', 'essb'); }
		
		if ($value == "true") {
			$on_switch = " selected";
			$off_switch = "";				
		}
		else {
			$off_switch = " selected";
			$on_switch = "";
		}
		$is_checked = ($value == 'true') ? ' checked="checked"' : '';
		printf('<div class="essb-switch'.($switch_submit == 'true' ? ' essb-switch-submit' : '').'">
				<label class="cb-enable%6$s'.($switch_submit == 'true' ? ' essb-switch-submit' : '').'"><span>%4$s</span></label>
				<label class="cb-disable%7$s'.($switch_submit == 'true' ? ' essb-switch-submit' : '').'"><span>%5$s</span></label>
				<input id="essb_options_%1$s" type="checkbox" name="%2$s[%1$s]" value="true" class="input-element checkbox" %3$s />
				</div>', $field, $settings_group, $is_checked, $on_text, $off_text, $on_switch, $off_switch);
	}
	
	public static function draw_input_field($field_id, $fullwidth = false, $settings_group = 'essb_options', $value = '', $icon = '', $class = '', $icon_position = '') {
		
		$value = esc_attr ( stripslashes($value));
		if ($icon != '' && $icon_position != 'right') {
			printf('<span class="essb-input-prefix-icon"><i class="fa %1$s"></i></span>', $icon);
		}
		
		echo '<input id="essb_options_' . $field_id . '" type="text" name="' . $settings_group . '[' . $field_id . ']" value="' . $value . '" class="input-element' . ($fullwidth ? ' stretched' : '') . ' '.$class.'" />';

		if ($icon != '' && $icon_position == 'right') {
			printf('<span class="essb-input-suffix-icon"><i class="fa %1$s"></i></span>', $icon);
		}
	}
	
	public static function draw_fileselect_image_field($field_id, $settings_group = 'essb_options', $value = '', $icon = '', $class = '') {
		if ($icon != '') {
			printf('<span class="essb-input-prefix-icon"><i class="fa %1$s"></i></span>', $icon);
		}
	
		if (function_exists ( 'wp_enqueue_media' )) {
			wp_enqueue_media ();
		} else {
			wp_enqueue_style ( 'thickbox' );
			wp_enqueue_script ( 'media-upload' );
			wp_enqueue_script ( 'thickbox' );
		}
		
		
		$css_background = '';
		if ($value != '') {
			$css_background = 'style="background-image: url('.$value.');"';
		}
	
		echo '<div class="default-preview-image '.$field_id.'">
			<div class="'.$field_id.'-placeholder image-placeholder"'.$css_background.'>&nbsp;</div>
			<a href="#" class="essb-btn essb-btn-blue image-picker-button" id="essb_fileselect_' . $field_id . '" title="'.__('Select Image', 'essb').'"><i class="fa fa-picture-o"></i></a>
			<a href="#" class="essb-btn essb-btn-red image-picker-clear-button" id="essb_clearselect_' . $field_id . '"  title="'.__('Remove Image', 'essb').'"><i class="fa fa-times"></i></a>
			</div>';
		echo '<input id="essb_options_' . $field_id . '" type="text" name="' . $settings_group . '[' . $field_id . ']" value="' . $value . '" class="input-element small-stretched media-select '.$class.'" />';
		?>
			
			<script type="text/javascript">
	
			jQuery(document).ready(function($){
				 
				 
			    var custom_uploader;

			    $('#essb_clearselect_<?php echo $field_id; ?>').click(function(e) {
			    	  e.preventDefault();
			    	$('#essb_options_<?php echo $field_id; ?>').val('');
		            if ($('.<?php echo $field_id; ?>-placeholder').length) {
			            $('.<?php echo $field_id; ?>-placeholder').css('background-image', '');
		            }
			    });
			 
			    $('#essb_fileselect_<?php echo $field_id; ?>').click(function(e) {
			 
			        e.preventDefault();
			 
			        //If the uploader object has already been created, reopen the dialog
			        if (custom_uploader) {
			            custom_uploader.open();
			            return;
			        }
			 
			        //Extend the wp.media object
			        custom_uploader = wp.media.frames.file_frame = wp.media({
			            title: 'Select File',
			            button: {
			                text: 'Select File'
			            },
			            multiple: false
			        });
			 
			        //When a file is selected, grab the URL and set it as the text field's value
			        custom_uploader.on('select', function() {
			            attachment = custom_uploader.state().get('selection').first().toJSON();
			            $('#essb_options_<?php echo $field_id; ?>').val(attachment.url);
			            if ($('.<?php echo $field_id; ?>-placeholder').length) {
				            console.log('set image');
				            $('.<?php echo $field_id; ?>-placeholder').css('background-image', 'url('+attachment.url+')');
			            }
			        });
			 
			        //Open the uploader dialog
			        custom_uploader.open();
			 
			    });

			    $('.<?php echo $field_id; ?>-placeholder').click(function(e) {
					 
			        e.preventDefault();
			 
			        //If the uploader object has already been created, reopen the dialog
			        if (custom_uploader) {
			            custom_uploader.open();
			            return;
			        }
			 
			        //Extend the wp.media object
			        custom_uploader = wp.media.frames.file_frame = wp.media({
			            title: 'Select File',
			            button: {
			                text: 'Select File'
			            },
			            multiple: false
			        });
			 
			        //When a file is selected, grab the URL and set it as the text field's value
			        custom_uploader.on('select', function() {
			            attachment = custom_uploader.state().get('selection').first().toJSON();
			            $('#essb_options_<?php echo $field_id; ?>').val(attachment.url);
			            if ($('.<?php echo $field_id; ?>-placeholder').length) {
				            console.log('set image');
				            $('.<?php echo $field_id; ?>-placeholder').css('background-image', 'url('+attachment.url+')');
			            }
			        });
			 
			        //Open the uploader dialog
			        custom_uploader.open();
			 
			    });
			});
	
			</script>
			
			<?php 
		}

	public static function draw_fileselect_field($field_id, $settings_group = 'essb_options', $value = '', $icon = '', $class = '') {
		if ($icon != '') {
			printf('<span class="essb-input-prefix-icon"><i class="fa %1$s"></i></span>', $icon);
		}
	
		if (function_exists ( 'wp_enqueue_media' )) {
			wp_enqueue_media ();
		} else {
			wp_enqueue_style ( 'thickbox' );
			wp_enqueue_script ( 'media-upload' );
			wp_enqueue_script ( 'thickbox' );
		}
		
		echo '<input id="essb_options_' . $field_id . '" type="text" name="' . $settings_group . '[' . $field_id . ']" value="' . $value . '" class="input-element small-stretched '.$class.'" />';
		echo '<a href="#" class="essb-btn essb-btn-blue" id="essb_fileselect_' . $field_id . '" style="margin-left: 5px; margin-top: -2px;">'.__('Select File', 'essb').'</a>';
		?>
		
		<script type="text/javascript">

		jQuery(document).ready(function($){
			 
			 
		    var custom_uploader;
		 
		 
		    $('#essb_fileselect_<?php echo $field_id; ?>').click(function(e) {
		 
		        e.preventDefault();
		 
		        //If the uploader object has already been created, reopen the dialog
		        if (custom_uploader) {
		            custom_uploader.open();
		            return;
		        }
		 
		        //Extend the wp.media object
		        custom_uploader = wp.media.frames.file_frame = wp.media({
		            title: 'Select File',
		            button: {
		                text: 'Select File'
		            },
		            multiple: false
		        });
		 
		        //When a file is selected, grab the URL and set it as the text field's value
		        custom_uploader.on('select', function() {
		            attachment = custom_uploader.state().get('selection').first().toJSON();
		            $('#essb_options_<?php echo $field_id; ?>').val(attachment.url);
		        });
		 
		        //Open the uploader dialog
		        custom_uploader.open();
		 
		    });
		});

		</script>
		
		<?php 
	}
	
	
	public static function draw_select_field($field, $listOfValues, $simpleList = false, $group = 'essb_options', $value = '') {
		
		echo '<select name="' . $group . '[' . $field . ']" class="input-element" id="essb_options_' . $field . '">';
		
		if ($simpleList) {
			foreach ( $listOfValues as $singleValue ) {
				printf ( '<option value="%1$s" %2$s>%1$s</option>', $singleValue, ($singleValue == $value ? 'selected' : '') );
			}
		} else {
			foreach ( $listOfValues as $singleValueCode => $singleValue ) {
				printf ( '<option value="%s" %s>%s</option>', $singleValueCode, ($singleValueCode == $value ? 'selected' : ''), $singleValue );
			}
		}
		
		echo '</select>';
	}

	public static function draw_select2_field($field, $listOfValues, $simpleList = false, $group = 'essb_options', $value = '', $select2_options = array()) {
	
		$allow_clear = isset($select2_options['allow_clear']) ? $select2_options['allow_clear'] : false;
		$multiple = isset($select2_options['multiple']) ? $select2_options['multiple'] : false;
		$placeholder = isset($select2_options['placeholder']) ? $select2_options['placeholder'] : false;
		
		$allow_clear_state = ($allow_clear) ? "true" : "false";
		
		echo '<select name="' . $group . '[' . $field . ']" class="input-element '.($multiple ? 'stretched' : "").'" id="essb_options_' . $field . '" '.($multiple ? 'multiple="multiple"' : "").'>';
	
		if ($simpleList) {
			foreach ( $listOfValues as $singleValue ) {
				printf ( '<option value="%1$s" %2$s>%1$s</option>', $singleValue, ($singleValue == $value ? 'selected' : '') );
			}
		} else {
			foreach ( $listOfValues as $singleValueCode => $singleValue ) {
				printf ( '<option value="%s" %s>%s</option>', $singleValueCode, ($singleValueCode == $value ? 'selected' : ''), $singleValue );
			}
		}
	
		echo '</select>';
		
		echo '<script type="text/javascript">jQuery(document).ready(function($){
		jQuery("#essb_options_' . $field . '").select2({
  placeholder: "'.$placeholder.'",
  allowClear: '.$allow_clear_state.'
});});</script>';
	}
	
	public static function draw_checkbox_field($field, $group = 'essb_options', $value = '') {
		$is_checked = ($value == 'true') ? ' checked="checked"' : '';
		echo '<input id="essb_options_' . $field . '" type="checkbox" name="' . $group . '[' . $field . ']" value="true" ' . $is_checked . ' />';
	}

	public static function draw_checkbox_list_field($field, $listOfValues, $group = 'essb_options', $value = '') {
		if (!is_array($value)) { $value = array(); }
		
		foreach ($listOfValues as $key => $text) {
			$is_checked = in_array($key, $value) ? ' checked="checked"' : '';
			echo '<span class="essb_checkbox_list_item"><input id="essb_options_' . $field . '" type="checkbox" name="' . $group . '[' . $field . '][]" value="'.$key.'" ' . $is_checked . ' />'.$text.'</span>';
		}
	}
	
	public static function draw_checkbox_list_sortable_field($field, $listOfValues, $group = 'essb_options', $value = '', $style = '') {
		if (!is_array($value)) {
			$value = array();
		}
	
		$id_field = $field;
		if ($style != '' && $style == 'networks') {
			echo '<input type="text" class="input-element input-filter stretched-50" placeholder="Quick Filter Networks ..." data-filter="essb-sortable-'.$field.'"/>';
				
		}
		
		printf('<ul class="essb_sortable" id="essb-sortable-%1$s">', $id_field);
		foreach ($listOfValues as $key => $text) {
			$is_checked = in_array($key, $value) ? ' checked="checked"' : '';
			
			if ($style == 'networks') {
				echo '<li data-filter-value="'.$text.'"><i class="essb_icon_'.$key.'" style="margin-right: 3px; margin-left: 3px;"></i><span class="essb_checkbox_list_item"><input id="essb_options_' . $field . '" type="checkbox" name="' . $group . '[' . $field . '][]" value="'.$key.'" ' . $is_checked . ' />'.$text.'<input type="hidden" name="' . $group . '[' . $field . '_order][]" value="'.$key.'|'.$text.'"/></span></li>';
			}
			else {
				echo '<li><i class="fa fa-bars" style="margin-right: 3px; margin-left: 3px;"></i><span class="essb_checkbox_list_item"><input id="essb_options_' . $field . '" type="checkbox" name="' . $group . '[' . $field . '][]" value="'.$key.'" ' . $is_checked . ' />'.$text.'<input type="hidden" name="' . $group . '[' . $field . '_order][]" value="'.$key.'|'.$text.'"/></span></li>';
			}
		}
		echo '</ul>';
	}
	
	public static function draw_color_field($field, $group = 'essb_options', $value = '') {
		
		$value = stripslashes ( $value );
		
		echo '<input id="essb_options_' . $field . '" type="text" name="' . $group . '[' . $field . ']" value="' . $value . '" class="input-element stretched" data-default-color="' . $value . '" />';
		
		array_push ( self::$color_fields, 'essb_options_' . $field );
	}
	
	public static function draw_acolor_field($field, $group = 'essb_options', $value = '') {
	
		$value = stripslashes ( $value );
	
		echo '<input id="essb_options_' . $field . '" type="text" name="' . $group . '[' . $field . ']" value="' . $value . '" class="input-element stretched" data-default-color="' . $value . '" data-alpha="true" />';
	
		array_push ( self::$color_fields, 'essb_options_' . $field );
	}
	
	public static function reset_color_selector() {
		self::$color_fields = array();
	}
	
	public static function register_color_selector() {
		?>
<div id="colorpicker"></div>
<script type="text/javascript">		
			
			
			jQuery(document).ready(function($){
				<?php
		
		foreach ( self::$color_fields as $single ) {
			print "$('#" . $single . "').wpColorPicker();";
		}
		
		?>
			});
			
			</script>
<?php
	}
	
	public static function translate_key_array($array) {
		if (!is_array($array)) { return array(); }
		
		$key_array = array();
		
		foreach ($array as $text_value) {
			$keys = explode('|', $text_value);
			
			$key = $keys[0];
			$text = $keys[1];
			
			$key_array[$key] = $text;
		}
		
		return $key_array;
	}

}

function essb_options_function1($options) {
	echo "user function is working";
	print_r($options);

}

?>