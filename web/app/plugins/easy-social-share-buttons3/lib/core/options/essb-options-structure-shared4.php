<?php


/**
 * ESSBOptionsStructureHelperShared4
 * 
 * Shared configuration fields holder for version 4
 * 
 * @author appscreo
 * @package EasySocialShareButtons
 * @since 4.0
 *
 */
class ESSBOptionsStructureHelperShared4 {

	public $tabs = array();
	public $sidebar_sections = array();
	public $sidebar_section_options = array();
	
	function __construct() {		
		
		add_action ( 'admin_enqueue_scripts', array ($this, 'register_admin_assets' ), 99 );
		
	}
	
	public function register_admin_assets($hook) {
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
		
		
		if ($page == 'essb_fc' || $page == 'essb_pv' || $page == 'essb_ssu' || $page == 'essb_vse' || $page == 'essb_ab') {
		
			wp_register_style ( 'essb-admin4', ESSB3_PLUGIN_URL . '/assets/admin/essb-admin42.css', array (), ESSB3_VERSION );
			wp_enqueue_style ( 'essb-admin4' );
		}
		
	}
	
	public function capitalize($text) {
		return ucfirst($text);
	}
	
	public function first_tab() {
		$tab_1 = "";
		if (count ( $this->tabs ) > 0) {
	
			$tab_1 = key ( $this->tabs );
		}
	
		return $tab_1;
	}	

	public function init() {
		$this->tabs = array();
		$this->sidebar_sections = array();
		$this->sidebar_section_options = array();
	}

	public function tab($tab_id, $tab_text, $tab_title, $tab_icon = '', $align = '', $hide_update_button = false, $hide_in_navigation = false, $wizard_tab = false, $hide_menu = false) {

		$this->tabs[$tab_id] = $tab_text;
		$this->sidebar_sections[$tab_id] = array(
				'title' => $tab_title,
				'fields' => array(),
				'hide_update_button' => $hide_update_button,
				'hide_in_navigation' => $hide_in_navigation,
				'wizard_tab' => $wizard_tab,
				'icon' => $tab_icon,
				'align' => $align,
				'hide_menu' => $hide_menu
		);

		$this->sidebar_section_options[$tab_id] = array();
	}

	public function menu_item($tab_id, $id, $title, $icon = 'default', $action = '', $default_child = '') {

		$this->sidebar_sections[$tab_id]['fields'][] = array(
				'field_id' => $id,
				'title' => $title,
				'icon' => $icon,
				'type' => 'menu_item',
				'action' => $action,
				'default_child' => $default_child
		);
	}

	public function submenu_item ($tab_id, $id, $title, $icon = 'default', $action = 'menu', $level2 = '') {
		$this->sidebar_sections[$tab_id]['fields'][] = array(
				'field_id' => $id,
				'title' => $title,
				'icon' => $icon,
				'type' => 'sub_menu_item',
				'action' => $action,
				'level2' => $level2
		);

		if ($action == 'menu') {
			$this->sidebar_section_options[$tab_id][$id] = array();
		}
	}

	public function field_heading($tab_id, $menu_id, $level = 'heading1', $title = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => $level,
				'title' => $title
		);

	}

	public function field_switch ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $on_label = '', $off_label = '', $default_value = '', $col_width = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'switch',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended,
				'on_label' => $on_label,
				'off_label' => $off_label,
				'default_value' => $default_value,
				'col_width' => $col_width
		);
	}

	public function field_switch_panel ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $on_label = '', $off_label = '', $default_value = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'switch-in-panel',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended,
				'on_label' => $on_label,
				'off_label' => $off_label,
				'default_value' => $default_value
		);
	}

	public function field_textbox ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '', $col_width = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
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

	public function field_textbox_panel ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
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

	public function field_textbox_stretched ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '', $col_width = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
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

	public function field_checkbox ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'checkbox',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public function field_checkbox_list ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'checkbox_list',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public function field_checkbox_list_sortable ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'checkbox_list_sortable',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public function field_select ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $col_width = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'select',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'col_width' => $col_width
		);
	}

	public function field_select_panel ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'select-in-panel',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public function field_textarea ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'textarea',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public function field_editor ($tab_id, $menu_id, $id, $title, $description, $mode = 'javascript', $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'editor',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'mode' => $mode
		);
	}

	public function field_wpeditor ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'wpeditor',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public function field_color ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $alpha = 'false') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'color',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'alpha' => $alpha
		);
	}

	public function field_color_panel ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $alpha = 'false') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'color-in-panel',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'alpha' => $alpha
		);
	}

	public function field_image_checkbox ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'image_checkbox',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}
	
	public function field_html_checkbox_buttons ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $shortcode = 'false', $width = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
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

	public function field_image_radio ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'image_radio',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public function field_html_radio ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $shortcode = 'false', $width = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
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

	public function field_html_radio_buttons ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '', $shortcode = 'false', $width = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
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
	
	public function field_file ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'file',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
		);
	}

	public function field_simplesort ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'simplesort',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values
		);
	}

	public function field_select2 ($tab_id, $menu_id, $id, $title, $description, $values, $multiple = false, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'select2',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'values' => $values,
				'select2_options' => array('allow_clear' => false, 'multiple' => $multiple, 'placeholder' => '')
		);
	}

	public function field_func ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'func',
				'title' => $title,
				'description' => $description
		);
	}

	//								array ('type' => 'section_start', 'title' => __('Section Start', 'essb'), 'description' => 'Demo section description'),
	public function field_section_start ($tab_id, $menu_id, $title, $description, $recommended = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_start',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended
		);
	}

	public function field_section_end ($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_end'
		);
	}

	public function field_section_start_panels ($tab_id, $menu_id, $title, $description, $recommended = '', $vertical = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_start_panels',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended,
				'title_position' => $vertical
		);
	}

	public function field_section_end_panels ($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_end_panels'
		);
	}

	public function field_section_end_full_panels ($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_end_full_panels'
		);
	}
	public function field_section_start_full_panels ($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'section_start_full_panels'
		);
	}

	public function structure_section_start($tab_id, $menu_id, $width = '', $title = '', $description = '', $position = 'top', $colwidth = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_section_start',
				'width' => $width,
				'title' => $title,
				'description' => $description,
				'title_position' => $position,
				'colwidth' => $colwidth
		);
	}

	public function structure_section_end($tab_id, $menu_id, $position = 'top') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_section_end',
				'position' => $position
		);
	}

	public function structure_row_start($tab_id, $menu_id, $custom_class = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_row_start',
				'class' => $custom_class
		);
	}

	public function structure_row_end($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'structure_row_end'
		);
	}

	public function hint($tab_id, $menu_id, $title = '', $description = '', $icon = '', $style = '', $in_section = 'false') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'hint',
				'title' => $title,
				'description' => $description,
				'icon' => $icon,
				'style' => $style,
				'in_section' => $in_section
		);
	}

	public function panel_start($tab_id, $menu_id, $title = '', $description = '', $icon = '', $element_options = array()) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'panel_start',
				'title' => $title,
				'description' => $description,
				'icon' => $icon,
				'element_options' => $element_options
		);
	}

	public function panel_end($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'panel_end'
		);
	}

	public function tabs_start ($tab_id, $menu_id, $id, $values, $vertical = 'false') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tabs_start',
				'values' => $values,
				'element_options' => array("vertical" => $vertical, "element_id" => $id)
		);
	}

	public function tabs_end($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tabs_end'
		);
	}

	public function tab_start ($tab_id, $menu_id, $id, $active = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tab_start',
				'element_options' => array("element_id" => $id, 'active' => $active)
		);
	}

	public function tab_end($tab_id, $menu_id) {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'tab_end'
		);
	}
	
	public function title($tab_id, $menu_id, $title = '', $description = '', $class = '') {
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'type' => 'title',
				'title' => $title,
				'description' => $description,
				'class' => $class
		);
	}
}
