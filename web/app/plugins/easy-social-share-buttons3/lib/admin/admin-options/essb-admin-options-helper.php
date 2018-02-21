<?php


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

	public static function field_func ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'func',
				'title' => $title,
				'description' => $description
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
	public static function field_section_start_full_panels ($tab_id, $menu_id) {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_start_full_panels'
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

	public static function tabs_start ($tab_id, $menu_id, $id, $values, $vertical = 'false') {
		global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
		$essb_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tabs_start',
				'values' => $values,
				'element_options' => array("vertical" => $vertical, "element_id" => $id)
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
}
