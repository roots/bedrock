<?php

function essb_get_post_types() {
	global $wp_post_types;

	$pts = get_post_types ( array ('show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('show_ui' => true, '_builtin' => false ) );

	$current_posttypes = array();

	foreach ($pts as $pt) {
		$current_posttypes[$pt] = $wp_post_types [$pt]->label;
	}

	foreach ($cpts as $pt) {
		$current_posttypes[$pt] = $wp_post_types [$pt]->label;
	}

	return $current_posttypes;
}

if (!function_exists('essb5_available_content_positions')) {
	function essb5_available_content_positions($wizard_mode = false) {
		$essb_avaliable_content_positions = array ();
		$essb_avaliable_content_positions ['content_top'] = array ('image' => 'assets/images/display-positions-02.png', 'label' => 'Content top', 'desc' => 'Display share buttons at the top of content', 'link' => 'essb-menu-display|essb-menu-display-4' );
		$essb_avaliable_content_positions ['content_bottom'] = array ('image' => 'assets/images/display-positions-03.png', 'label' => 'Content bottom', 'desc' => 'Display share buttons at the bottom of content', 'link' => 'essb-menu-display|essb-menu-display-5' );
		$essb_avaliable_content_positions ['content_both'] = array ('image' => 'assets/images/display-positions-04.png', 'label' => 'Content top and bottom', 'desc' => 'Display share buttons on top and at the bottom of content' );
		if (!essb_options_bool_value('deactivate_method_float')) {
			$essb_avaliable_content_positions ['content_float'] = array ('image' => 'assets/images/display-positions-05.png', 'label' => 'Float from content top', 'desc' => 'Display share buttons initially on top of content and during scroll they will stick on the top of window', 'link' => 'essb-menu-display|essb-menu-display-6' );
			$essb_avaliable_content_positions ['content_floatboth'] = array ('image' => 'assets/images/display-positions-06.png', 'label' => 'Float from content top and bottom' , 'desc' => 'Display share buttons initially on top of content and during scroll they will stick on the top of window in combination with static bottom share buttons' );
		}

		if (!essb_options_bool_value('deactivate_method_followme')) {
			$essb_avaliable_content_positions ['content_followme'] = array ('image' => 'assets/images/display-positions-26.png', 'label' => 'Follow me bar' , 'desc' => 'Display share buttons inside content (top, bottom or both) in combination with fixed bar, appearing when you scroll down the post/page and in content buttons are not visible inside.', 'link' => 'essb-menu-display|essb-menu-display-18' );
		}
		
		if (!essb_option_bool_value('deactivate_method_native')) {
			$essb_avaliable_content_positions ['content_nativeshare'] = array ('image' => 'assets/images/display-positions-07.png', 'label' => 'Native social buttons top, share buttons bottom', 'desc' => 'This method will show activated inside Social Follow native buttons on top along with share buttons at the bottom' );
			$essb_avaliable_content_positions ['content_sharenative'] = array ('image' => 'assets/images/display-positions-08.png', 'label' => 'Share buttons top, native buttons bottom', 'desc' => 'This method will show activated inside Social Follow native buttons at the bottom of content along with share buttons on the top' );
		}
		$essb_avaliable_content_positions ['content_manual'] = array ('image' => 'assets/images/display-positions-09.png', 'label' => 'Manual display with shortcode only', 'desc' => 'Use this content position if you do not wish to have share buttons inside content or if you wish to add them manually' );

		if (has_filter('essb4_content_positions')) {
			$essb_avaliable_content_positions = apply_filters('essb4_content_positions', $essb_avaliable_content_positions);
		}
		
		if ($wizard_mode) {
			foreach ($essb_avaliable_content_positions as $key => $data) {
				$essb_avaliable_content_positions[$key]['link'] = '';
			}
		}

		return $essb_avaliable_content_positions;
	}
}


if (!function_exists('essb5_available_button_positions')) {
	function essb5_available_button_positions($wizard_mode = false) {
		$essb_available_button_positions = array ();
		if (!essb_options_bool_value('deactivate_method_sidebar')) {
			$essb_available_button_positions ['sidebar'] = array ('image' => 'assets/images/display-positions-10.png', 'label' => 'Sidebar', 'link' => 'essb-menu-display|essb-menu-display-8', 'desc' => 'Display share buttons attached on the left or right edge of your screen as sidebar'  );
		}
		if (!essb_options_bool_value('deactivate_method_popup')) {
			$essb_available_button_positions ['popup'] = array ('image' => 'assets/images/display-positions-11.png', 'label' => 'Pop up', 'link' => 'essb-menu-display|essb-menu-display-11', 'desc' => 'Display share buttons as pop up based on various conditions - time delay, scroll down, end of content and etc.'  );
		}
		if (!essb_options_bool_value('deactivate_method_flyin')) {
			$essb_available_button_positions ['flyin'] = array ('image' => 'assets/images/display-positions-12.png', 'label' => 'Fly in', 'link' => 'essb-menu-display|essb-menu-display-12'  );
		}
		if (!essb_options_bool_value('deactivate_method_postfloat')) {
			$essb_available_button_positions ['postfloat'] = array ('image' => 'assets/images/display-positions-13.png', 'label' => 'Post vertical float', 'link' => 'essb-menu-display|essb-menu-display-7'  );
		}
		if (!essb_options_bool_value('deactivate_method_topbar')) {
			$essb_available_button_positions ['topbar'] = array ('image' => 'assets/images/display-positions-14.png', 'label' => 'Top bar', 'link' => 'essb-menu-display|essb-menu-display-9'  );
		}
		if (!essb_options_bool_value('deactivate_method_bottombar')) {
			$essb_available_button_positions ['bottombar'] = array ('image' => 'assets/images/display-positions-15.png', 'label' => 'Bottom bar', 'link' => 'essb-menu-display|essb-menu-display-10'  );
		}

		if (!essb_option_bool_value('deactivate_method_image')) {
			$essb_available_button_positions ['onmedia'] = array ('image' => 'assets/images/display-positions-16.png', 'label' => 'On media', 'link' => 'essb-menu-display|essb-menu-display-13'  );
		}

		if (!essb_options_bool_value('deactivate_method_heroshare')) {
			$essb_available_button_positions ['heroshare'] = array ('image' => 'assets/images/display-positions-22.png', 'label' => 'Full screen hero share', 'link' => 'essb-menu-display|essb-menu-display-14'  );
		}
		if (!essb_options_bool_value('deactivate_method_postbar')) {
			$essb_available_button_positions ['postbar'] = array ('image' => 'assets/images/display-positions-23.png', 'label' => 'Post share bar', 'link' => 'essb-menu-display|essb-menu-display-15'  );
		}
		if (!essb_options_bool_value('deactivate_method_point')) {
			$essb_available_button_positions ['point'] = array ('image' => 'assets/images/display-positions-24.png', 'label' => 'Share Point (Advanced Version)', 'link' => 'essb-menu-display|essb-menu-display-16'  );
		}
		if (!essb_options_bool_value('deactivate_method_corner')) {
			$essb_available_button_positions ['cornerbar'] = array ('image' => 'assets/images/display-positions-27.png', 'label' => 'Corner Bar', 'link' => 'essb-menu-display|essb-menu-display-19'  );
		}
		
		if (!essb_options_bool_value('deactivate_method_booster')) {
			$essb_available_button_positions ['booster'] = array ('image' => 'assets/images/display-positions-28.png', 'label' => 'Share Booster', 'link' => 'essb-menu-display|essb-menu-display-20' );
		}
		
		$essb_available_button_positions ['widget'] = array ('image' => 'assets/images/display-positions-25.png', 'label' => 'Widget' );

		if (has_filter('essb4_button_positions')) {
			$essb_available_button_positions = apply_filters('essb4_button_positions', $essb_available_button_positions);
		}

		if ($wizard_mode) {
			foreach ($essb_available_button_positions as $key => $data) {
				$essb_available_button_positions[$key]['link'] = '';
			}
		}
		
		return $essb_available_button_positions;
	}
}

if (!function_exists('essb5_available_content_positions_mobile')) {
	function essb5_available_content_positions_mobile() {
		$essb_avaliable_content_positions_mobile = array ();
		$essb_avaliable_content_positions_mobile ['content_top'] = array ('image' => 'assets/images/display-positions-02.png', 'label' => 'Content top' );
		$essb_avaliable_content_positions_mobile ['content_bottom'] = array ('image' => 'assets/images/display-positions-03.png', 'label' => 'Content bottom' );
		$essb_avaliable_content_positions_mobile ['content_both'] = array ('image' => 'assets/images/display-positions-04.png', 'label' => 'Content top and bottom' );
		if (!essb_options_bool_value('deactivate_method_float')) {
			$essb_avaliable_content_positions_mobile ['content_float'] = array ('image' => 'assets/images/display-positions-05.png', 'label' => 'Float from content top' );
		}
		$essb_avaliable_content_positions_mobile ['content_manual'] = array ('image' => 'assets/images/display-positions-09.png', 'label' => 'No content share buttons' );

		if (has_filter('essb4_content_positions_mobile')) {
			$essb_avaliable_content_positions_mobile = apply_filters('essb4_content_positions_mobile', $essb_avaliable_content_positions_mobile);
		}

		return $essb_avaliable_content_positions_mobile;
	}
}

if (!function_exists('essb5_available_button_positions_mobile')) {
	function essb5_available_button_positions_mobile() {
		$essb_available_button_positions_mobile = array ();
		if (!essb_options_bool_value('deactivate_method_sidebar')) {
			$essb_available_button_positions_mobile ['sidebar'] = array ('image' => 'assets/images/display-positions-10.png', 'label' => 'Sidebar' );
		}
		if (!essb_options_bool_value('deactivate_method_topbar')) {
			$essb_available_button_positions_mobile ['topbar'] = array ('image' => 'assets/images/display-positions-14.png', 'label' => 'Top bar' );
		}
		if (!essb_options_bool_value('deactivate_method_bottombar')) {
			$essb_available_button_positions_mobile ['bottombar'] = array ('image' => 'assets/images/display-positions-15.png', 'label' => 'Bottom bar' );
		}
		$essb_available_button_positions_mobile ['sharebottom'] = array ('image' => 'assets/images/display-positions-17.png', 'label' => 'Share buttons bar (Mobile Only Display Method)' );
		$essb_available_button_positions_mobile ['sharebar'] = array ('image' => 'assets/images/display-positions-18.png', 'label' => 'Share bar (Mobile Only Display Method)' );
		$essb_available_button_positions_mobile ['sharepoint'] = array ('image' => 'assets/images/display-positions-19.png', 'label' => 'Share point (Mobile Only Display Method)' );
		if (!essb_options_bool_value('deactivate_method_point')) {
			$essb_available_button_positions_mobile ['point'] = array ('image' => 'assets/images/display-positions-24.png', 'label' => 'Share Point (Advanced Version)' );
		}
		$essb_available_button_positions_mobile ['widget'] = array ('image' => 'assets/images/display-positions-25.png', 'label' => 'Widget' );

		if (has_filter('essb4_button_positions_mobile')) {
			$essb_available_button_positions_mobile = apply_filters('essb4_button_positions_mobile', $essb_available_button_positions_mobile);
		}

		return $essb_available_button_positions_mobile;
	}
}


/**
 * Options Creator Helper Class
 * ---
 * @author appscreo
 *
 */
class ESSBOptionsStructureHelper {

	public static function capitalize($text) {
		return ucfirst($text);
	}

	public static function init() {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;

		$essb_navigation_tabs = array();
		$essb_sidebar_sections = array();
		$essb_sidebar_sections = array();
	}

	public static function tab($tab_id, $tab_text, $tab_title, $tab_icon = '', $align = '', $hide_update_button = false, $hide_in_navigation = false, $wizard_tab = false, $hide_menu = false) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;

		$essb_navigation_tabs[$tab_id] = $tab_text;
		$essb_sidebar_sections[$tab_id] = array(
				'title' => $tab_title,
				'fields' => array(),
				'hide_update_button' => $hide_update_button,
				'hide_in_navigation' => $hide_in_navigation,
				'wizard_tab' => $wizard_tab,
				'icon' => $tab_icon,
				'align' => $align,
				'hide_menu' => $hide_menu
		);

		$essb_section_options[$tab_id] = array();
	}

	public static function menu_item($tab_id, $id, $title, $icon = 'default', $action = '', $default_child = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;

		$essb_sidebar_sections[$tab_id]['fields'][] = array(
				'field_id' => $id,
				'title' => $title,
				'icon' => $icon,
				'type' => 'menu_item',
				'action' => $action,
				'default_child' => $default_child
		);
	}

	public static function submenu_item ($tab_id, $id, $title, $icon = 'default', $action = 'menu', $level2 = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_sidebar_sections[$tab_id]['fields'][] = array(
				'field_id' => $id,
				'title' => $title,
				'icon' => $icon,
				'type' => 'sub_menu_item',
				'action' => $action,
				'level2' => $level2
		);

		if ($action == 'menu') {
			$essb_section_options[$tab_id][$id] = array();
		}
	}

	public static function field_heading($tab_id, $menu_id, $level = 'heading1', $title = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => $level,
				'title' => $title
		);

	}

	public static function field_switch ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $on_label = '', $off_label = '', $default_value = '', $col_width = '', $switch_sumbit = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'switch',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended,
				'on_label' => $on_label,
				'off_label' => $off_label,
				'default_value' => $default_value,
				'col_width' => $col_width,
				'class' => $switch_sumbit
		);
	}

	public static function field_switch_panel ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $on_label = '', $off_label = '', $default_value = '', $switch_sumbit = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'switch-in-panel',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended,
				'on_label' => $on_label,
				'off_label' => $off_label,
				'default_value' => $default_value,
				'class' => $switch_sumbit
		);
	}

	public static function field_textbox ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '', $col_width = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'text',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'class' => $class,
				'icon' => $icon,
				'icon_position' => $icon_position,
				'col_width' => $col_width
		);
	}

	public static function field_textbox_panel ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'text-in-panel',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'class' => $class,
				'icon' => $icon,
				'icon_position' => $icon_position
		);
	}

	public static function field_textbox_stretched ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '', $col_width = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'text-stretched',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'class' => $class,
				'icon' => $icon,
				'icon_position' => $icon_position,
				'col_width' => $col_width
		);
	}

	public static function field_checkbox ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'checkbox',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public static function field_checkbox_list ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'checkbox_list',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public static function field_checkbox_list_sortable ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $style = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'checkbox_list_sortable',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'style' => $style
				
		);
	}

	public static function field_select ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $col_width = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'select',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'col_width' => $col_width
		);
	}

	public static function field_select_panel ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'select-in-panel',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public static function field_textarea ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'textarea',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public static function field_editor ($tab_id, $menu_id, $id, $title, $description, $mode = 'javascript', $recommended = '', $in_panel = false) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'editor',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'mode' => $mode
		);
	}

	public static function field_wpeditor ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'wpeditor',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public static function field_color ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $alpha = 'false') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'color',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'alpha' => $alpha
		);
	}

	public static function field_color_panel ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $alpha = 'false') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'color-in-panel',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'alpha' => $alpha
		);
	}

	public static function field_image_checkbox ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'image_checkbox',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}
	
	public static function field_html_checkbox_buttons ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $shortcode = 'false', $width = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'html_checkbox_buttons',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'shortcode' => $shortcode,
				'width' => $width
		);
	}

	public static function field_image_radio ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'image_radio',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public static function field_html_radio ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $shortcode = 'false', $width = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'html_radio',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'shortcode' => $shortcode,
				'width' => $width
		);
	}

	public static function field_html_radio_buttons ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $shortcode = 'false', $width = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'html_radio_buttons',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'shortcode' => $shortcode,
				'width' => $width
		);
	}
	
	public static function field_file ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'file',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public static function field_image ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $mode = '', $class = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'fileimage',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'mode' => $mode,
				'class' => $class
		);
	}
	
	
	public static function field_simplesort ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'simplesort',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public static function field_select2 ($tab_id, $menu_id, $id, $title, $description, $values, $multiple = false, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'select2',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'select2_options' => array('allow_clear' => false, 'multiple' => $multiple, 'placeholder' => '')
		);
	}

	public static function field_func ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $element_options = array()) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'func',
				'title' => $title,
				'description' => $description,
				'element_options' => $element_options
		);
	}

	//								array ('type' => 'section_start', 'title' => __('Section Start', 'essb'), 'description' => 'Demo section description'),
	public static function field_section_start ($tab_id, $menu_id, $title, $description, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_start',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended
		);
	}

	public static function field_section_end ($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_end'
		);
	}

	public static function field_section_start_panels ($tab_id, $menu_id, $title, $description, $recommended = '', $vertical = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_start_panels',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended,
				'title_position' => $vertical
		);
	}

	public static function field_section_end_panels ($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_end_panels'
		);
	}

	public static function field_section_end_full_panels ($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_end_full_panels'
		);
	}
	public static function field_section_start_full_panels ($tab_id, $menu_id, $css_class = '', $user_id = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_start_full_panels',
				'element_options' => array('css_class' => $css_class, 'id' => $user_id)
		);
	}

	public static function structure_section_start($tab_id, $menu_id, $width = '', $title = '', $description = '', $position = 'top', $colwidth = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_section_start',
				'width' => $width,
				'title' => $title,
				'description' => $description,
				'title_position' => $position,
				'colwidth' => $colwidth
		);
	}

	public static function structure_section_end($tab_id, $menu_id, $position = 'top') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_section_end',
				'position' => $position
		);
	}

	public static function structure_row_start($tab_id, $menu_id, $custom_class = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_row_start',
				'class' => $custom_class
		);
	}

	public static function structure_row_end($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_row_end'
		);
	}

	public static function hint($tab_id, $menu_id, $title = '', $description = '', $icon = '', $style = '', $in_section = 'false') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'hint',
				'title' => $title,
				'description' => $description,
				'icon' => $icon,
				'style' => $style,
				'in_section' => $in_section
		);
	}

	public static function panel_start($tab_id, $menu_id, $title = '', $description = '', $icon = '', $element_options = array()) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'panel_start',
				'title' => $title,
				'description' => $description,
				'icon' => $icon,
				'element_options' => $element_options
		);
	}

	public static function panel_end($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'panel_end'
		);
	}

	public static function tabs_start ($tab_id, $menu_id, $id, $values, $vertical = 'false', $full = 'false') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		
		$flexclass = ($full == 'true') ? 'essb-section-tabs-flex' : '';
		
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tabs_start',
				'values' => $values,
				'element_options' => array("vertical" => $vertical, "element_id" => $id, 'fullwidth' => $full, 'css_class' => $flexclass)
		);
	}

	public static function tabs_end($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tabs_end'
		);
	}

	public static function tab_start ($tab_id, $menu_id, $id, $active = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tab_start',
				'element_options' => array("element_id" => $id, 'active' => $active)
		);
	}

	public static function tab_end($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tab_end'
		);
	}
	
	public static function title($tab_id, $menu_id, $title = '', $description = '', $class = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'title',
				'title' => $title,
				'description' => $description,
				'class' => $class
		);
	}
	
	public static function holder_start($tab_id, $menu_id, $class = '', $user_id = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'holder_start',				
				'element_options' => array("class" => $class, 'user_id' => $user_id)
		);
	}
	
	public static function holder_end($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'holder_end'
		);
	}

	public static function field_toggle ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $col_width = '', $size = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'toggle',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'col_width' => $col_width,
				'element_options' => array('size' => $size)
		);
	}
	
	public static function field_toggle_panel ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $size = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'toggle-in-panel',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'element_options' => array('size' => $size)
		);
	}
	
	public static function field_group_select ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $col_width = '', $size = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'group-select',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'col_width' => $col_width,
				'element_options' => array('size' => $size)
		);
	}
	
	public static function field_group_select_panel ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $size = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'group-select-in-panel',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'element_options' => array('size' => $size)
		);
	}

	public static function field_network_select ($tab_id, $menu_id, $id, $position = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'network-select',
				'element_options' => array('position' => $position)
		);
	}

	public static function field_template_select ($tab_id, $menu_id, $id, $position = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'template-select',
				'element_options' => array('position' => $position)
		);
	}

	public static function field_buttonstyle_select ($tab_id, $menu_id, $id, $position = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'buttonstyle-select',
				'element_options' => array('position' => $position)
		);
	}

	public static function field_counterposition_select ($tab_id, $menu_id, $id, $position = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'counterposition-select',
				'element_options' => array('position' => $position)
		);
	}

	public static function field_totalcounterposition_select ($tab_id, $menu_id, $id, $position = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'totalcounterposition-select',
				'element_options' => array('position' => $position)
		);
	}

	public static function field_animation_select ($tab_id, $menu_id, $id, $position = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'animation-select',
				'element_options' => array('position' => $position)
		);
	}

	public static function field_single_position_select ($tab_id, $menu_id, $id, $values = array()) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'single-position-select',
				'element_options' => array('values' => $values)
		);
	}
	
	public static function field_multi_position_select ($tab_id, $menu_id, $id, $values = array()) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'multi-position-select',
				'element_options' => array('values' => $values)
		);
	}
}

