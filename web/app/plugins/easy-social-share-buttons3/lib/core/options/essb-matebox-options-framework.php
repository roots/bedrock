<?php

class ESSBMetaboxOptionsFramework {
	
	public static $color_fields = array();
	public static $was_lastrow_even = false;
	public static $section_active = false;
	
	public static function reset_row_status() {
		self::$was_lastrow_even = false;
	}
	
	public static function draw_options_field($option) {
		global $essb_admin_options, $essb_admin_options_fanscounter;
		
		
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
		
		$settings_group = "essb_metabox";
		$option_value = isset($essb_admin_options[$id]) ? $essb_admin_options[$id] : '';
		
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
			case "switch":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_switch_field($id, $settings_group, $option_value, $on_text, $off_text);
				self::draw_options_row_end();
				break;		
			case "text":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_input_field($id, false, $settings_group, $option_value, $icon, $class, $icon_position);
				self::draw_options_row_end();
				break;		
			case "text-stretched":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_input_field($id, true, $settings_group, $option_value, $icon, $class, $icon_position);
				self::draw_options_row_end();
				break;		
			case "checkbox":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_checkbox_field($id, $settings_group, $option_value);
				self::draw_options_row_end();
				break;		
			case "checkbox_list":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_checkbox_list_field($id, $listOfValues, $settings_group, $option_value);
				self::draw_options_row_end();
				break;		
			case "checkbox_list_sortable":
				
				$ordered_values = isset($essb_admin_options[$id.'_order']) ? $essb_admin_options[$id.'_order'] : array();
				//print_r($ordered_values);
				if (is_array($ordered_values)) {
					if (count($ordered_values) > 0) {
						$listOfValues = $ordered_values;
						$listOfValues = self::translate_key_array($listOfValues);
					}
				}
				
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_checkbox_list_sortable_field($id, $listOfValues, $settings_group, $option_value);
				self::draw_options_row_end();
				break;		
			case "select":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_select_field($id, $listOfValues, false, $settings_group, $option_value);
				self::draw_options_row_end();
				break;	
			case "textarea":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_textarea_field($id, $settings_group, $option_value);
				self::draw_options_row_end();
				break;
			case "editor":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_editor_field($id, $settings_group, $option_value, $mode);
				self::draw_options_row_end();
				break;
			case "wpeditor":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_wpeditor_field($id, $settings_group, $option_value);
				self::draw_options_row_end();
				break;
			case "color":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_color_field($id, $settings_group, $option_value);
				self::draw_options_row_end();
				break;
			case "image_checkbox":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_image_checkbox_field($id, $listOfValues, $settings_group, $option_value);
				//self::draw_image_checkbox_field($id, $listOfValues, 'essb_options', array("checkbox_option2" => true));
				self::draw_options_row_end();
				break;
			case "image_radio":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_image_radio_field($id, $listOfValues, $settings_group, $option_value);
				//self::draw_image_radio_field($id, $listOfValues, 'essb_options', 'checkbox_option1');
				self::draw_options_row_end();
				break;
			case "func":
				self::draw_options_row_start($title, $description, $recommended);
				if (function_exists($id)) {					
					$id($option);
				}
				self::draw_options_row_end();
				break;
				
			case "file":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_fileselect_field($id, $settings_group, $option_value, $icon, $class);
				self::draw_options_row_end();
				break;	
			case "simplesort":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_simplesort_field($id, $listOfValues, $settings_group, $option_value);
				self::draw_options_row_end();
				break;
			case 'section_start':
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_section_start();
				self::$section_active = true;
				break;
			case 'section_end':
				self::draw_section_end();
				self::draw_options_row_end();
				self::$section_active = false;
				break;
			case "select2":
				self::draw_options_row_start($title, $description, $recommended);
				self::draw_select2_field($id, $listOfValues, false, $settings_group, $option_value, $select2_options);
				self::draw_options_row_end();
				break;	
		}
	}
	
	public static function draw_options_row_start($title, $description = '', $recommended = '', $colspan = '', $rowborder = true) {
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
		
		if ($colspan != '') {
			$colspan = 'colspan="'.$colspan.'"';
		}
		
		$row_border_class = ($rowborder) ? "table-border-bottom" : '';
		
		printf('<tr class="%1$s %2$s">', $row_class, $row_border_class);
		if ($colspan != '') {
			printf('<td class="bold" valign="top" %4$s>%1$s%3$s%2$s', $title, $description, $recommended, $colspan);
		}
		else {
			printf('<td class="bold" valign="top" %4$s>%1$s%3$s%2$s</td>', $title, $description, $recommended, $colspan);
			echo '<td valign="top">';
		}
	}
	
	public static function draw_options_row_end() {
		echo '</td>';
		echo '</tr>';
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
			default:
				$css_class_heading = "sub";
				break;
		}
		
		if ($submenu_link != '') {
			$submenu_link = sprintf('id="essb-submenu-%1%s"', $submenu_link);
		}
		
		echo '<tr class="table-border-bottom">';
		printf('<td colspan="2" class="%1$s" %2$s>%3$s</td>', $css_class_heading, $submenu_link, $title);
		echo '</tr>';
	}
	
	public static function draw_simplesort_field($field, $listOfValues, $settings_group = 'essb_options', $value = '') {
		if ($value == '') {
			$value = $listOfValues; // initialize default values
		}
		
		printf('<ul class="essb_sortable" id="essb-sortable-%1$s">', $field);
		
		foreach ($value as $single) {
			printf('<li>%1$s<input type="hidden" name="%2$s[%3$s][]" value="%1$s"/></li>', $single, $settings_group, $field);
		}
		
		echo '</ul>';
	}
	
	public static function draw_image_checkbox_field($field, $listOfValues, $settings_group = 'essb_options', $value = '') {
		$exist_user_value = false;

		if ($value != '') {
			$exist_user_value = true;
		}		
		
		echo '<div class="essb_image_checkbox_container essb_image_checkbox_container_'.$field.'">';
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
			
			printf('<div class="essb_checkbox"><div class="essb_image_checkbox%6$s" data-field="%8$s_%3$s">
					<span class="checkbox-image"><img src="%1$s/%2$s"/></span>
					<span class="checkbox-state"><i class="fa fa-lg fa-check-circle"></i></span>
					<input type="checkbox" id="essb_options_%8$s_%3$s" name="%4$s[%8$s][]" value="%3$s"%7$s/>					
					</div>%5$s</div>', ESSB3_PLUGIN_URL, $singleValue['image'], $singleValueCode, $settings_group, $label, $active_state, $active_element, $field);
		}	
		echo '</div>';
	}

	public static function draw_image_radio_field($field, $listOfValues, $settings_group = 'essb_options', $value = '') {		
		$exist_user_value = false;
		
		if ($value != '') {
			$exist_user_value = true;
		}
		
		
		echo '<div class="essb_image_radio_container essb_image_radio_container_'.$field.'">';
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
				$label = sprintf('<div class="essb_radio_label">%1$s</div>', $label);
			}
				
			printf('<div class="essb_radio"><div class="essb_image_radio%8$s" data-field="%6$s_%7$s">
					<span class="checkbox-image"><img src="%1$s/%2$s"/></span>
					<span class="checkbox-state"><i class="fa fa-lg fa-check-circle"></i></span>
					<input type="radio" id="essb_options_%6$s_%7$s" name="%4$s[%6$s]" value="%3$s"%9$s/>
					</div>%5$s</div>', ESSB3_PLUGIN_URL, $singleValue['image'], $singleValueCode, $settings_group, $label, $field, $position, $active_state, $active_element);
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
		$editor_options = array('textarea_name' => $settings_group.'['.$field.']');
		wp_editor($value, sprintf('wpeditor_%1$s', $field), $editor_options);
	}
	
	public static function draw_editor_field($field, $settings_group = 'essb_options', $value = '', $mode = 'htmlmixed') {
		$value = esc_textarea ( stripslashes($value));
		printf('<textarea id="essb_options_%1$s" name="%2$s[%1$s]" class="input-element stretched is-code-editor" rows="5" data-function-activate="activate__%1$s">%3$s</textarea>', $field, $settings_group, $value);
		printf('<script>
				function activate__%1$s() {
				console.log("actiting %1$s");
    var editor_%1$s = CodeMirror.fromTextArea(document.getElementById("essb_options_%1$s"), {
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
	
	
	public static function draw_switch_field($field, $settings_group = 'essb_options', $value = '', $on_text = '', $off_text = '') {
		if ($settings_group == '') { $settings_group = "essb_options"; }
		
		if ($on_text == "") { $on_text = __('On', ESSB3_TEXT_DOMAIN); }
		if ($off_text == "") { $off_text = __('Off', ESSB3_TEXT_DOMAIN); }
		
		if ($value == "true") {
			$on_switch = " selected";
			$off_switch = "";				
		}
		else {
			$off_switch = " selected";
			$on_switch = "";
		}
		$is_checked = ($value == 'true') ? ' checked="checked"' : '';
		printf('<div class="essb-switch">
				<label class="cb-enable%6$s"><span>%4$s</span></label>
				<label class="cb-disable%7$s"><span>%5$s</span></label>
				<input id="essb_options_%1$s" type="checkbox" name="%2$s[%1$s]" value="true" class="input-element checkbox" %3$s />
				</div>', $field, $settings_group, $is_checked, $on_text, $off_text, $on_switch, $off_switch);
	}
	
	public static function draw_input_field($field_id, $fullwidth = false, $settings_group = 'essb_options', $value = '', $icon = '', $class = '', $icon_position = '') {
		if ($icon != '' && $icon_position != 'right') {
			printf('<span class="essb-input-prefix-icon"><i class="fa %1$s"></i></span>', $icon);
		}
		
		echo '<input id="essb_options_' . $field_id . '" type="text" name="' . $settings_group . '[' . $field_id . ']" value="' . $value . '" class="input-element' . ($fullwidth ? ' stretched' : '') . ' '.$class.'" />';

		if ($icon != '' && $icon_position == 'right') {
			printf('<span class="essb-input-suffix-icon"><i class="fa %1$s"></i></span>', $icon);
		}
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
		echo '<a href="#" class="button" id="essb_fileselect_' . $field_id . '">'.__('Select File', ESSB3_TEXT_DOMAIN).'</a>';
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
	
	public static function draw_checkbox_list_sortable_field($field, $listOfValues, $group = 'essb_options', $value = '') {
		if (!is_array($value)) {
			$value = array();
		}
	
		/*
		 * printf('<ul class="essb_sortable" id="essb-sortable-%1$s">', $field);
		
		foreach ($value as $single) {
			printf('<li>%1$s<input type="hidden" name="%2$s[%3$s][]" value="%1$s"/></li>', $single, $settings_group, $field);
		}
		
		echo '</ul>';
		 */
		printf('<ul class="essb_sortable" id="essb-sortable-%1$s">', $field);
		foreach ($listOfValues as $key => $text) {
			$is_checked = in_array($key, $value) ? ' checked="checked"' : '';
			echo '<li><span class="essb_checkbox_list_item"><input id="essb_options_' . $field . '" type="checkbox" name="' . $group . '[' . $field . '][]" value="'.$key.'" ' . $is_checked . ' />'.$text.'<input type="hidden" name="' . $group . '[' . $field . '_order][]" value="'.$key.'|'.$text.'"/></span></li>';
		}
		echo '</ul>';
	}
	
	public static function draw_color_field($field, $group = 'essb_options', $value = '') {
		
		$value = stripslashes ( $value );
		
		echo '<input id="essb_options_' . $field . '" type="text" name="' . $group . '[' . $field . ']" value="' . $value . '" class="input-element stretched" data-default-color="' . $value . '" />';
		
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
?>