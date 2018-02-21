<?php

class ESSBMetaboxInterface {
	
	public static function draw_form_start($metabox_id) {
		global $essb_options;
		
		$admin_template = ESSBOptionValuesHelper::options_value($essb_options, 'admin_template');
		if (!empty($admin_template)) {
			$admin_template = "essb-template-".$admin_template;
		}
		
		echo '<div class="essb-options essb-metabox-options '.$admin_template.'" id="'.$metabox_id.'">';
	}
		
	public static function draw_sidebar($options = array(), $data_instance_id = '') {
		
		$data_instance_class = "";
		$data_instance_menu_class = "";
		if ($data_instance_id != '') {
			$data_instance_class = " essb-options-sidebar-".$data_instance_id;
			$data_instance_menu_class = " essb-options-group-menu-".$data_instance_id;
		}
		
		echo '<div class="essb-options-sidebar essb-settings-panel-navigation'.$data_instance_class.'" id="essb-options-sidebar" data-instance="'.$data_instance_id.'">';

		echo '<ul class="essb-plugin-menu essb-options-group-menu'.$data_instance_menu_class.'" id="sticky-navigation">';
		
		foreach ($options as $single) {
			$type = $single['type'];
			$field_id = isset($single['field_id']) ? $single['field_id'] : '';
			$title = isset($single['title']) ? $single['title'] : '';
			$sub_menuaction = isset($single['action']) ? $single['action'] : '';
			$default_child = isset($single['default_child']) ? $single['default_child'] : '';
			$icon = isset($single['icon']) ? $single['icon'] : '';
			
			if ($icon == 'default') {
				$icon = 'gear';
			}
			
			if ($icon != '') {
				$icon = sprintf('<i class="essb-sidebar-icon fa fa-%1$s"></i>', $icon);
			}
			
			$css_class = "";
			switch ($type) {
				case "menu_item":
					$css_class = "essb-menu-item";
					
					if ($sub_menuaction == "activate_first") {
						$css_class .= " essb-activate-first";
					}
					break;
				case "sub_menu_item":
					$css_class = "essb-submenu-item";
					
					if ($sub_menuaction == 'menu') {
						$css_class .= " essb-submenu-menuitem";
					}
					break;
				case "heading":
					$css_class = "essb-title";
					break;
				default:
					$css_class = "essb-menu-item";
					break;
			}
			
			printf('<li class="%1$s" data-menu="%2$s" data-activate-child="%4$s" id="essb-menu-%2$s"><a href="#" class="essb-nav-tab">%5$s<span>%3$s</span></a></li>', $css_class, $field_id, $title, $default_child, $icon);
		}
		
		echo '</ul>';
		
		echo '</div>';
		
	}
	
	public static function draw_content_start($min_height = '300', $data_instance_id = '') {
		$data_instance_class = "";
		if ($data_instance_id != '') {
			$data_instance_class = " essb-options-container-".$data_instance_id;
		}
		echo '<div class="essb-options-container'.$data_instance_class.'" style="min-height: '.$min_height.'px;" data-instance="'.$data_instance_id.'">';
	}
	
	public static function draw_content_end() {
		echo '</div>';
	}
	
	public static function draw_content_section_start($section = '') {
		printf('<div id="essb-container-%1$s" class="essb-data-container">',$section);
			
		echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">
		<col width="25%" />
		<col width="75%" />';
		
		
	}
	
	public static function draw_content_section_end() {
		
		echo '</table>';
			
		echo '</div>';
	}	
	
	public static function draw_first_menu_activate($data_instance_id = '') {
		if ($data_instance_id != '') {
			?>
			<script type="text/javascript">
			jQuery(document).ready(function($){
				$(".essb-options-group-menu-<?php echo $data_instance_id; ?>").find(".essb-menu-item").first().addClass('active');
				var container_key = $(".essb-options-group-menu-<?php echo $data_instance_id; ?>").find(".essb-menu-item").first().attr('data-menu') || '';

				if (container_key != '') 
					$('#essb-container-'+container_key).fadeIn();
			});
			</script>
			<?php 
		}
	}
	
	public static function draw_content($options = array(), $min_height = '840') {
		echo '<div class="essb-options-container" style="min-height: '.$min_height.'px;">';
		
		//print_r($options);
		
		foreach($options as $section => $fields) {
			printf('<div id="essb-container-%1$s" class="essb-data-container">',$section);
			
			echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">
						<col width="25%" />
						<col width="75%" />';
			
			$section_options = $fields;
			
			ESSBOptionsFramework::reset_row_status();
			
			foreach ($section_options as $option) {
				ESSBMetaboxOptionsFramework::draw_options_field($option);
			}
			
			echo '</table>';
			
			echo '</div>';
		}
		
		echo '</div>';
	}	
	
	public static function draw_form_end() {
		echo '</div>';
	}
	
}

?>