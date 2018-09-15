<?php
/*
# Use

	1] Previous Icon
		Use param_name = prev_icon

	2] Next Icon
		Use param_name = next_icon

	3] Dots
		Use param_name = dots_icon
*/
if(!class_exists('Ultimate_Navigation'))
{
	class Ultimate_Navigation
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('ultimate_navigation' , array(&$this, 'icon_settings_field' ) );
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('ultimate_navigation' , array(&$this, 'icon_settings_field' ) );
				}
			}
		}

		function icon_settings_field($settings, $value)
		{
			$dependency = '';
			$uid = uniqid();
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			if($param_name == "next_icon"){
				$icons = array('ultsl-arrow-right','ultsl-arrow-right2','ultsl-arrow-right3','ultsl-arrow-right4','ultsl-arrow-right6');
			}
			if($param_name == "prev_icon"){
				$icons = array('ultsl-arrow-left','ultsl-arrow-left2','ultsl-arrow-left3','ultsl-arrow-left4','ultsl-arrow-left6');
			}

			if($param_name == "dots_icon"){
				$icons = array('ultsl-checkbox-unchecked','ultsl-checkbox-partial','ultsl-stop','ultsl-radio-checked','ultsl-radio-unchecked','ultsl-record');
			}
			/*if($param_name == "exp_icon"){
				//$icons = array('ultsl-checkbox-unchecked','ultsl-checkbox-partial','ultsl-stop','ultsl-radio-checked','ultsl-radio-unchecked','ultsl-record');
				$icons = array('Defaults-circle-arrow-down','Defaults-arrow-down','Defaults-chevron-down','Defaults-hand-down','Defaults-circle-arrow-down','Defaults-angle-down','Defaults-chevron-sign-down');
			}*/


			$output = '<input type="hidden" name="'.$param_name.'" class="wpb_vc_param_value '.$param_name.' '.$type.' '.$class.'" value="'.$value.'" id="trace-'.$uid.'"/>';
			//$output .= '<div class="ult-icon-preview icon-preview-'.$uid.'"><i class="'.$value.'"></i></div>';
			//$output .='<input class="search" type="text" placeholder="Search" />';
			$output .='<div id="icon-dropdown-'.$uid.'" >';
			$output .= '<ul class="icon-list">';
			$n = 1;
			foreach($icons as $icon)
			{
				$selected = ($icon == $value) ? 'class="selected"' : '';
				$id = 'icon-'.$n;
				$output .= '<li '.$selected.' data-ac-icon="'.$icon.'"><i class="ult-icon '.$icon.'"></i><label class="ult-icon">'.$icon.'</label></li>';
				$n++;
			}
			$output .='</ul>';
			$output .='</div>';
			$output .= '<script type="text/javascript">
					jQuery("#icon-dropdown-'.$uid.' li").click(function() {
						jQuery(this).attr("class","selected").siblings().removeAttr("class");
						var icon = jQuery(this).attr("data-ac-icon");
						jQuery("#trace-'.$uid.'").val(icon);
						jQuery(".icon-preview-'.$uid.'").html("<i class=\'ult-icon "+icon+"\'></i>");
					});
			</script>';
			$output .= '<style type="text/css">';
			$output .= 'ul.icon-list li {
							display: inline-block;
							float: left;
							padding: 5px;
							border: 1px solid #ddd;
							font-size: 18px;
							width: 18px;
							height: 18px;
							line-height: 18px;
							margin: 0 auto;
						}
						ul.icon-list li label.ult-icon {
							display: none;
						}
						.ult-icon-preview {
							padding: 5px;
							font-size: 24px;
							border: 1px solid #ddd;
							display: inline-block;
						}
						ul.icon-list li.selected {
							background: #3486D1;
							padding: 10px;
							margin: 0 -1px;
							margin-top: -7px;
							color: #fff;
							font-size: 24px;
							width: 24px;
							height: 24px;
						}';
			$output .= '</style>';
			return $output;
		}

	}
}

if(class_exists('Ultimate_Navigation'))
{
	$Ultimate_Navigation = new Ultimate_Navigation();
}
