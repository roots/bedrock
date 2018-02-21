<?php

// check for Visual Composer Added and Activated
if (! function_exists ( 'vc_map' )) {
	return;
}

// using shortcode generator options for better shortcode mapping
if (!class_exists('ESSBShortcodeGenerator5')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-shortcode-generator5.php');
}


global $essb_options, $essb_networks;

// creating instance of Shortcode Generator
$scg = new ESSBShortcodeGenerator5 ();

$listOfMappedShortcodes = array (
		"easy-social-share" => array ("name" => "Social share buttons", "description" => "Display social share buttons" ), 
		"easy-social-share-popup" => array ("name" => "Popup social share buttons", "description" => "Display social share buttons as popup" ), 
		"easy-social-share-flyin" => array ("name" => "Flyin social share buttons", "description" => "Display social share buttons as flyin" ), 
		"easy-social-like" => array ("name" => "Native Like, Follow & Subscribe buttons", "description" => "Display native buttons" ), 
		"easy-total-shares" => array ("name" => "Total social shares", "description" => "Display total social shares" ), 
		"easy-profiles" => array ("name" => "Social profiles", "description" => "Display links to social profiles" ), 
		"easy-followers" => array ("name" => "Social followers counter", "description" => "Display social followers counter" ), 
		"easy-followers-layout" => array ("name" => "Custom layout followers counter", "description" => "Display social followers counter using custom layout from layout builder" ), 
		"easy-total-followers" => array ("name" => "Total social followers counter", "description" => "Display number of total social followers" ), 
		"easy-popular-posts" => array ("name" => "List of popular posts", "description" => "Display popular posts by shares, loves or views" ),
		"easy-subscribe" => array ("name" => "Subscribe to mail list form", "description" => "Include subscribe to mail list form" ) );


$vc_shortcode_settings = array ();

foreach ( $listOfMappedShortcodes as $shortcode => $data ) {
	$scg->activate ( $shortcode );
	$last_used_group = $data ['name'];
	$vc_shortcode_settings [$shortcode] = array ();
	$exist_network_names = false;
	$exist_sections = false;
	foreach ( $scg->shortcodeOptions as $param => $settings ) {
		$type = isset ( $settings ['type'] ) ? $settings ['type'] : 'textbox';
		$text = isset ( $settings ['text'] ) ? $settings ['text'] : '';
		if ($type == "section" && ! empty ( $text )) {
			$exist_sections = true;
		}
	}
	
	foreach ( $scg->shortcodeOptions as $param => $settings ) {
		$type = isset ( $settings ['type'] ) ? $settings ['type'] : 'textbox';
		$text = isset ( $settings ['text'] ) ? $settings ['text'] : '';
		if ($type == "section" && ! empty ( $text )) {
			$last_used_group = $text;
		}
		if ($type == "section" || $type == "subsection") {
			continue;
		}
		
		// additional options
		
		$comment = isset ( $settings ['comment'] ) ? $settings ['comment'] : '';
		$default_value = isset ( $settings ['value'] ) ? $settings ['value'] : '';
		$values = isset ( $settings ['sourceOptions'] ) ? $settings ['sourceOptions'] : array ();
		
		$vc_type = $type;
		
		if ($vc_type == "textbox") {
			$vc_type = "textfield";
		}
		
		$is_networks_selection = false;
		
		if ($vc_type == "networks") {
			$vc_type = "checkbox";
			$is_networks_selection = true;
		}
		
		if ($vc_type == "network_names") {
			$exist_network_names = true;
		}
		
		// TODO: make network selection possible
		if ($vc_type == "networks" || $vc_type == "networks_sp" || $vc_type == "network_names") {
			continue;
		}
		
		$singleParam = array ();
		$singleParam ['type'] = $vc_type;
		$singleParam ['heading'] = $text;
		$singleParam ['param_name'] = $param;
		$singleParam ['description'] = $comment;
		if ($exist_sections) {
			$singleParam ['group'] = $last_used_group;
		}
		
		if ($param == "title" || $param == "columns" || $param == "template") {
			$singleParam ['admin_label'] = true;
		}
		
		if ($vc_type == "checkbox") {
			if (! $is_networks_selection) {
				$singleParam ['value'] = array ();
				$singleParam ['value'] ["Yes"] = $default_value;
			} else {
				$singleParam ['value'] = array ();
				$singleParam ['admin_label'] = true;
				if ($is_networks_selection) {
					foreach ( $essb_networks as $key => $value ) {
						$network_name = isset ( $value ['name'] ) ? $value ['name'] : $key;
						$singleParam ['value'] [$network_name] = $key;
					}
				}
			}
		}
		if ($vc_type == "dropdown") {
			$singleParam ['value'] = array ();
			foreach ( $values as $key => $value ) {
				$singleParam ['value'] [$value] = $key;
			}
		}
		
		$vc_shortcode_settings [$shortcode] [] = $singleParam;
	}
	
	if ($exist_network_names) {
		foreach ( $essb_networks as $key => $value ) {
			$network_name = isset ( $value ['name'] ) ? $value ['name'] : $key;
			$singleParam = array ();
			$singleParam ['type'] = 'textfield';
			$singleParam ['heading'] = $network_name . ' custom button text';
			$singleParam ['param_name'] = $key . '_text';
			$singleParam ['description'] = 'Customize text that will appear for network name';
			if ($exist_sections) {
				$singleParam ['group'] = $last_used_group;
			}
			$vc_shortcode_settings [$shortcode] [] = $singleParam;
		}
	}
	
	// if ($shortcode == "easy-total-shares") {
	// print_r($vc_shortcode_settings[$shortcode]);
	// }
	
	vc_map ( array (
			"name" => $data ['name'], 
			"base" => $shortcode, 
			"icon" => 'vc-' . $shortcode, 
			"category" => __ ( 'Easy Social Share Buttons', 'essb' ), 
			"description" => $data ['description'], 
			"value" => $data ['description'], 
			"params" => $vc_shortcode_settings [$shortcode] ) );
}


//add_filter( 'vc_grid_item_shortcodes', 'essb_register_grid_shortcodes' );
function essb_register_grid_shortcodes($shortcodes) {
	$scg = new ESSBShortcodeGenerator3 ();
	$listOfGridShortcodes = array(
			"easy-social-share-grid" => array ("name" => "Social share buttons", "description" => "Display social share buttons", "base" => "easy-social-share" ));
	
	$vc_shortcode_settings = array ();
	
	foreach ( $listOfGridShortcodes as $shortcode => $data ) {
		$scg->activate ( $data['base'] );
		$last_used_group = $data ['name'];
		$vc_shortcode_settings [$shortcode] = array ();
		$exist_network_names = false;
		$exist_sections = false;
		foreach ( $scg->shortcodeOptions as $param => $settings ) {
			$type = isset ( $settings ['type'] ) ? $settings ['type'] : 'textbox';
			$text = isset ( $settings ['text'] ) ? $settings ['text'] : '';
			if ($type == "section" && ! empty ( $text )) {
				$exist_sections = true;
			}
		}
	
		foreach ( $scg->shortcodeOptions as $param => $settings ) {
			$type = isset ( $settings ['type'] ) ? $settings ['type'] : 'textbox';
			$text = isset ( $settings ['text'] ) ? $settings ['text'] : '';
			if ($type == "section" && ! empty ( $text )) {
				$last_used_group = $text;
			}
			if ($type == "section" || $type == "subsection") {
				continue;
			}
	
			// additional options
	
			$comment = isset ( $settings ['comment'] ) ? $settings ['comment'] : '';
			$default_value = isset ( $settings ['value'] ) ? $settings ['value'] : '';
			$values = isset ( $settings ['sourceOptions'] ) ? $settings ['sourceOptions'] : array ();
	
			$vc_type = $type;
	
			if ($vc_type == "textbox") {
				$vc_type = "textfield";
			}
	
			$is_networks_selection = false;
	
			if ($vc_type == "networks") {
				$vc_type = "checkbox";
				$is_networks_selection = true;
			}
	
			if ($vc_type == "network_names") {
				$exist_network_names = true;
			}
	
			// TODO: make network selection possible
			if ($vc_type == "networks" || $vc_type == "networks_sp" || $vc_type == "network_names") {
				continue;
			}
	
			$singleParam = array ();
			$singleParam ['type'] = $vc_type;
			$singleParam ['heading'] = $text;
			$singleParam ['param_name'] = $param;
			$singleParam ['description'] = $comment;
			if ($exist_sections) {
				$singleParam ['group'] = $last_used_group;
			}
	
			if ($param == "title" || $param == "columns" || $param == "template") {
				$singleParam ['admin_label'] = true;
			}
	
			if ($vc_type == "checkbox") {
				if (! $is_networks_selection) {
					$singleParam ['value'] = array ();
					$singleParam ['value'] ["Yes"] = $default_value;
				} else {
					$singleParam ['value'] = array ();
					$singleParam ['admin_label'] = true;
					if ($is_networks_selection) {
						foreach ( essb_available_social_networks() as $key => $value ) {
							$network_name = isset ( $value ['name'] ) ? $value ['name'] : $key;
							$singleParam ['value'] [$network_name] = $key;
						}
					}
				}
			}
			if ($vc_type == "dropdown") {
				$singleParam ['value'] = array ();
				foreach ( $values as $key => $value ) {
					$singleParam ['value'] [$value] = $key;
				}
			}
	
			$vc_shortcode_settings [$shortcode] [] = $singleParam;
		}
	
		if ($exist_network_names) {
			foreach ( essb_available_social_networks() as $key => $value ) {
				$network_name = isset ( $value ['name'] ) ? $value ['name'] : $key;
				$singleParam = array ();
				$singleParam ['type'] = 'textfield';
				$singleParam ['heading'] = $network_name . ' custom button text';
				$singleParam ['param_name'] = $key . '_text';
				$singleParam ['description'] = 'Customize text that will appear for network name';
				if ($exist_sections) {
					$singleParam ['group'] = $last_used_group;
				}
				$vc_shortcode_settings [$shortcode] [] = $singleParam;
			}
		}
	
		// if ($shortcode == "easy-total-shares") {
		// print_r($vc_shortcode_settings[$shortcode]);
		// }
	
		$shortcodes[$shortcode] = array (
				"name" => $data ['name'],
				"base" => $shortcode,
				"icon" => 'vc-' . $shortcode,
				"category" => __ ( 'Easy Social Share Buttons', 'essb' ),
				"description" => $data ['description'],
				"value" => $data ['description'],
				'post_type' => Vc_Grid_Item_Editor::postType(),
				"params" => $vc_shortcode_settings [$shortcode] );
	}
	
	return $shortcodes;
}

add_shortcode("easy-social-share-grid", "essb3_parse_grid_share_shortcode");

function essb3_parse_grid_share_shortcode($atts) {
	$atts['vc_grid_post'] = '{{ post_data:ID }}';
	
	
}


?>