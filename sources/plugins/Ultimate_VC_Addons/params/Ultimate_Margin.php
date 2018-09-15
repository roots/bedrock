<?php
/*

# Usage -
	array(
		"type" => "ultimate_margins",
		"positions" => array(
			"Top" => "top",
			"Bottom" => "bottom",
			"Left" => "left",
			"Right" => "right"
		),
	),

*/
if(!class_exists('Ultimate_Margin_Param'))
{
	class Ultimate_Margin_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('ultimate_margins', array($this, 'ultimate_margins_param'), plugins_url('../admin/vc_extend/js/vc-headings-param.js',__FILE__));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('ultimate_margins', array($this, 'ultimate_margins_param'), plugins_url('../admin/vc_extend/js/vc-headings-param.js',__FILE__));
				}
			}
		}

		function ultimate_margins_param($settings, $value)
		{
			$dependency = '';
			$positions = $settings['positions'];
			$html = '<div class="ultimate-margins">
						<input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value ultimate-margin-value '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.'/>';
					foreach($positions as $key => $position)
						$html .= $key.' <input type="text" style="width:50px;padding:3px" data-hmargin="'.$position.'" class="ultimate-margin-inputs" id="margin-'.$key.'" /> &nbsp;&nbsp;';
			$html .= '</div>';
			return $html;
		}

	}
}

if(class_exists('Ultimate_Margin_Param'))
{
	$Ultimate_Margin_Param = new Ultimate_Margin_Param();
}
