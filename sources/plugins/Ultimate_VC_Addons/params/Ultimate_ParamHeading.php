<?php
if(!class_exists('Ultimate_ParamHeading_Param'))
{
	class Ultimate_ParamHeading_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('ult_param_heading' , array($this, 'ult_param_heading_callback'));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('ult_param_heading' , array($this, 'ult_param_heading_callback'));
				}
			}
		}

		function ult_param_heading_callback($settings, $value)
		{
			$dependency = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$text = isset($settings['text']) ? $settings['text'] : '';
			$output = '<h4 '.$dependency.' class="wpb_vc_param_value '.$class.'">'.$text.'</h4>';
			$output .= '<input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value ultimate-param-heading '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.'/>';
			return $output;
		}

	}
}

if(class_exists('Ultimate_ParamHeading_Param'))
{
	$Ultimate_ParamHeading_Param = new Ultimate_ParamHeading_Param();
}
