<?php
if(!class_exists('Ultimate_Animator_Param'))
{
	class Ultimate_Animator_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('animator' , array($this, 'animator_param'));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('animator' , array($this, 'animator_param'));
				}
			}
		}

		function animator_param($settings, $value){
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$json = ultimate_get_animation_json();
			$jsonIterator = json_decode($json,true);

			$animators = '<select name="'.$param_name.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '">';

			foreach ($jsonIterator as $key => $val) {
				if(is_array($val)) {
					$labels = str_replace('_',' ', $key);
					$animators .= '<optgroup label="'.ucwords(__($labels,'ultimate_vc')).'">';
					foreach($val as $label => $style){
						$label = str_replace('_',' ', $label);
						if($label == $value)
							$animators .= '<option selected value="'.$label.'">'.__($label,'ultimate_vc').'</option>';
						else
							$animators .= '<option value="'.$label.'">'.__($label,'ultimate_vc').'</option>';
					}
				} else {
					if($key == $value)
						$animators .= "<option selected value=".$key.">".__($key,'ultimate_vc')."</option>";
					else
						$animators .= "<option value=".$key.">".__($key,'ultimate_vc')."</option>";
				}
			}
			$animators .= '<select>';

			$output = '';
			$output .= '<div class="select_anim" style="width: 45%; float: left;">';
			$output .= $animators;
			$output .= '</div>';
			$output .= '<div class="anim_prev" style=" padding: 8px; width: 45%; float: left; text-align: center; margin-left: 15px;"> <span id="animate-me" style="padding: 15px; background: #1C8FCF; color: #FFF;">Animation Preview</span></div>';
			$output .= '<script type="text/javascript">
					jQuery(document).ready(function(){
						var animator = jQuery(".'.$param_name.'");
						var anim_target = jQuery("#animate-me");
						animator.on("change",function(){
							var anim = jQuery(this).val();
							anim_target.removeClass().addClass(anim + " animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function(){jQuery(this).removeClass();
							});
						});
					});
				</script>';
			return $output;
		}

	}
}

if(class_exists('Ultimate_Animator_Param'))
{
	$Ultimate_Animator_Param = new Ultimate_Animator_Param();
}
