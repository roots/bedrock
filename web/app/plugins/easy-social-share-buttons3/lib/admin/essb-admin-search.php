<?php
global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;

function essb_find_section_name($tab, $id) {
	global $essb_sidebar_sections;
	
	$options = $essb_sidebar_sections[$tab]; 
	$result = array('title' => '', 'type' => '');
	foreach ($options['fields'] as $data) {
		if ($data['field_id'] == $id) {
			$result['title'] = $data['title'];
			$result['type'] = $data['type'];
			break;
		}
	}
	
	return $result;
}

function essb_search_format_value($id) {
	$value = essb_option_value($id);
	
	return $value;
}

$search = isset ( $_REQUEST ['search'] ) ? $_REQUEST ['search'] : '';

$search = strtolower($search);

$result = array();

foreach ($essb_navigation_tabs as $current_tab => $tab_name) {
	$options = $essb_section_options[$current_tab];
	
	if ($current_tab == 'shortcode' || $current_tab == 'analytics' || $current_tab == 'import' ||
			$current_tab == 'update' || $current_tab == 'quick' || $current_tab == 'readymade' || $current_tab == 'status') {
		continue;
	}
	//print $current_tab.'|';
	
	foreach($options as $section => $fields) {
		$section_options = $fields;
		
		$section_data = essb_find_section_name($current_tab, $section);
		
		
		$section_name = $section_data['title'];
		$section_type = $section_data['type'];
		$section_id = $section;
		$subsection_id = '';
		
		if ($section_type == 'sub_menu_item') {
			$subsection_id = $section_id;
			$section_split = explode('-', $section_id);
			$section_id = $section_split[0];
		}
			
		foreach ($section_options as $option) {
			$type = $option['type'];
			$id = isset($option['id']) ? $option['id'] : '';
			$title = isset($option['title']) ? $option['title'] : '';
			$description = isset($option['description']) ? $option['description'] : '';
			
			$s_title = strtolower($title);
			$s_description = strtolower($description);
			
			if (strpos($s_title, $search) !== false || strpos($s_description, $search) !== false) {
				$result[] = array('id' => $id, 'type' => $type, 'title' => $title, 'description' => $description, 'tab_id' => $current_tab, 'tab_name' => $tab_name, 'section_id' => $section_id, 'section_name' => $section_name, 'subsection_id' => $subsection_id);
			}
		}
	}
}

if (count($result) == 0) {
	echo '<h3>'.__('Nothing found ...', 'essb').'</h3>';
}
else {
	$last_tab = ''; 
	$last_section = '';
	
	foreach ($result as $data) {
		if ($last_tab != $data['tab_id']) {
			echo '<div class="tab-row">';
			echo '<h3>'.$data['tab_name'].'</h3>';
			echo '</div>';
			$last_tab = $data['tab_id'];
		}

		if ($last_section != $data['section_id']) {
			echo '<div class="section-row">';
			echo '<h4>'.$data['section_name'].'</h4>';
			echo '</div>';
			
			$last_section = $data['section_id'];
		}
		
		echo '<div class="result-row" data-tab="'.$data['tab_id'].'" data-section="'.$data['section_id'].'" data-subsection="'.$data['subsection_id'].'" data-param="'.$data['id'].'">';
		echo '<div class="parameter">';
		echo '<b>'.$data['title'].'</b><span>'.$data['description'].'</span>';
		echo '</div>';
		echo '<div class="value">';
		echo essb_search_format_value($data['id']);
		echo '</div>';
		echo '</div>';
	}
}

die ();
