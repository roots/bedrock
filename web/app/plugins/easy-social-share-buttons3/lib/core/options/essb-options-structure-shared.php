<?php
/**
 * Options Creator Helper Class
 * ---
 * @author appscreo
 *
 */
class ESSBOptionsStructureHelperShared {

	public $tabs = array();
	public $sidebar_sections = array();
	public $sidebar_section_options = array();
	
	function __construct() {
		
	}
	
	public static function capitalize($text) {
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

	public function tab($tab_id, $tab_text, $tab_title, $tab_icon = '', $align = '', $hide_update_button = false, $hide_in_navigation = false, $wizard_tab = false) {
		
		if ($tab_icon == '') { $tab_icon = 'ti-settings'; }
		
		$this->tabs[$tab_id] = $tab_text;
		$this->sidebar_sections[$tab_id] = array(
				'title' => $tab_title,
				'fields' => array(),
				'hide_update_button' => $hide_update_button,
				'hide_in_navigation' => $hide_in_navigation,
				'wizard_tab' => $wizard_tab,
				'icon' => $tab_icon,
				'align' => $align
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

	public function submenu_item ($tab_id, $id, $title, $icon = 'default', $action = 'menu') {
		
		$this->sidebar_sections[$tab_id]['fields'][] = array(
				'field_id' => $id,
				'title' => $title,
				'icon' => $icon,
				'type' => 'sub_menu_item',
				'action' => $action
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

	public function field_switch ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $on_label = '', $off_label = '', $default_value = '') {
		
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'switch',
				'title' => $title,
				'description' => $description,
				'recommended' => $recommended,
				'on_label' => $on_label,
				'off_label' => $off_label,
				'default_value' => $default_value
		);
	}
	public function field_textbox ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '') {
		
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'text',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'class' => $class,
				'icon' => $icon,
				'icon_position' => $icon_position
		);
	}

	public function field_textbox_stretched ($tab_id, $menu_id, $id, $title, $description, $recommended = '', $class = '', $icon = '', $icon_position = '') {
		
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'text-stretched',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended,
				'class' => $class,
				'icon' => $icon,
				'icon_position' => $icon_position
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

	public function field_select ($tab_id, $menu_id, $id, $title, $description, $values, $recommended = '') {
		
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'select',
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

	public function field_color ($tab_id, $menu_id, $id, $title, $description, $recommended = '') {
		
		$this->sidebar_section_options[$tab_id][$menu_id][] = array(
				'id' => $id,
				'type' => 'color',
				'title' => $title,
				'description' => $description,
				'recommeded' => $recommended
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

	//								array ('type' => 'section_start', 'title' => __('Section Start', ESSB3_TEXT_DOMAIN), 'description' => 'Demo section description'),
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
}

?>