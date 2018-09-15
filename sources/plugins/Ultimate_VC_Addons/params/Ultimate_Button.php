<?php
if(!class_exists('Ultimate_Button_Param'))
{
	class Ultimate_Button_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('ult_button' , array($this, 'button_prev_param'));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('ult_button' , array($this, 'button_prev_param'));
				}
			}
		}

		function button_prev_param($settings, $value){
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$json = isset($settings['json']) ? $settings['json'] : '';
			$jsonIterator = json_decode($json,true);
			$selector = '<select name="'.$param_name.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '">';
			foreach ($jsonIterator as $key => $val) {
				if(is_array($val)) {
					$labels = str_replace('_',' ', $key);
					$selector .= '<optgroup label="'.ucwords($labels).'">';
					foreach($val as $label => $style){
						$label = str_replace('_',' ', $label);
						if($style == $value)
							$selector .= '<option selected value="'.$style.'">'.__($label,'ultimate_vc').'</option>';
						else
							$selector .= '<option value="'.$style.'">'.__($label,'ultimate_vc').'</option>';
					}
				} else {
					if($val == $value)
						$selector .= "<option selected value=".$val.">".__($key,'ultimate_vc')."</option>";
					else
						$selector .= "<option value=".$val.">".__($key,'ultimate_vc')."</option>";
				}
			}
			$selector .= '<select>';

			$output = '';
			$output .= '<div class="select2_option" style="width: 45%; float: left;">';
			$output .= $selector;
			$output .= '</div>';
			$output .= '<div class="anim_prev" style="width: 45%; float: left; text-align: center; margin-left: 15px; margin-top: -15px;">';
			$output .= '<button class="ubtn ubtn-normal ubtn-sep-icon ubtn-center ubtn-sep-icon-left-rev" data-animation="ubtn-sep-icon-left-push" style="border-radius:3px; border-width:1px; border-color:#ffffff; border-style:solid; background: #2786ce;color: #ffffff;"><span class="ubtn-data ubtn-icon"><i class="Defaults-star" style="font-size:20px;color:;"></i></span><span class="ubtn-hover" style="background: rgb(30, 115, 190);"></span><span class="ubtn-data ubtn-text">'.__('Button','ultimate_vc').'</span></button>';
			$output .= '</div>';
			$output .= '<script type="text/javascript">
					jQuery(document).ready(function(){
						var animator = jQuery(".'.$param_name.'");
						var anim_target = jQuery(".ubtn");
						animator.on("change",function(){
							var anim = jQuery(this).val();
							var prev_anim = anim_target.data("animation");
							anim_target.removeClass().addClass("ubtn ubtn-normal ubtn-sep-icon ubtn-center ubtn-sep-icon-left-rev " + anim);
						});
					});
				</script>';
			return $output;
		}

	}
}

if(class_exists('Ultimate_Button_Param'))
{
	$Ultimate_Button_Param = new Ultimate_Button_Param();
}
