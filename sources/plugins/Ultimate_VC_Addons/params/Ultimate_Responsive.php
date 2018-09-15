<?php
/*

# Param Use -
	array(
	  	"type" => "ultimate_responsive",
	  	"class" => "",
	  	"heading" => __("Font size", 'ultimate_vc'),
	  	"param_name" => "YOUR_PARAM_NAME_FONT_SIZE",
	  	"unit"  => "px",								// use '%' or 'px'
	  	"media" => array(
	  	    // "Large Screen"      => '',
	  	    "Desktop"           => '28', 				// Here '28' is default value set for 'Desktop'
	  	    "Tablet"            => '',
	  	    "Tablet Portrait"   => '',
	  	    "Mobile Landscape"  => '',
	  	    "Mobile"            => '',
	  	),
	  	"group" => "Typography"
	),

# Module implementation -

	1]  Create Data List -
		$args = array(
        	'target'      =>  '#ID .TARGET_element_CLASS, #ID #TARGET_element_ID',  // set targeted element e.g. unique class/id etc.
           	'media_sizes' => array(
				font-size' => $YOUR_PARAM_NAME_FONT_SIZE, 		//	Your PARAM_NAME which you set in array
			   'line-height' => $YOUR_PARAM_NAME_LINE_HEIGHT 	//	Your PARAM_NAME which you set in array
            ),
       	);
		$data_list = get_ultimate_vc_responsive_media_css($args);

	2] Add ID and class 'ult-responsive' and set data attribute - $data_list to targeted element
		<div id="#ID" class='ult-responsive' '.$data_list.' >
			<div class="TARGET_element_ID">
				...
			</div>
			<div class="TARGET_element_CLASS">
				...
			</div>
        	....
      	</div>

Note - Without .ult-responsive class on target resposive param will not work

*/

if(!class_exists('Ultimate_Responsive'))
{
	class Ultimate_Responsive
	{
		function __construct()
		{
			add_action( 'admin_enqueue_scripts', array( $this, 'ultimate_admin_responsive_param_scripts' ) );

			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('ultimate_responsive', array($this, 'ultimate_responsive_callback'), plugins_url('../admin/vc_extend/js/ultimate-responsive.js',__FILE__));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('ultimate_responsive', array($this, 'ultimate_responsive_callback'), plugins_url('../admin/vc_extend/js/ultimate-responsive.js',__FILE__));
				}
			}
		}

		function ultimate_responsive_callback($settings, $value)
		{
			$dependency = '';
			$unit = $settings['unit'];
			$medias = $settings['media'];

			if(is_numeric($value)){
				$value = "desktop:".$value.'px;';
			}

			$uid = 'ultimate-responsive-'. rand(1000, 9999);

			$html  = '<div class="ultimate-responsive-wrapper" id="'.$uid.'" >';
				$html .= '  <div class="ultimate-responsive-items" >';

				foreach($medias as $key => $default_value ) {
					//$html .= $key;
					switch ($key) {
						/*case 'Large Screen':
							$data_id  = strtolower((preg_replace('/\s+/', '_', $key)));
							$class = 'required';
							$dashicon = "<i class='dashicons dashicons-welcome-view-site'></i>";
							$html .= $this->ultimate_responsive_param_media($class, $dashicon, $key, $default_value ,$unit, $data_id);
						break;*/
						case 'Desktop':
							$class = 'required';
							$data_id  = strtolower((preg_replace('/\s+/', '_', $key)));
							$dashicon = "<i class='dashicons dashicons-desktop'></i>";
							$html .= $this->ultimate_responsive_param_media($class, $dashicon, $key, $default_value ,$unit, $data_id);
							$html .= "<div class='simplify'>
										<div class='ult-tooltip simplify-options'>".__("Responsive Options","ultimate_vc")."</div>
										<i class='simplify-icon dashicons dashicons-arrow-right-alt2'></i>
									  </div>";
						break;
						case 'Tablet':
							$class = 'optional';
							$data_id  = strtolower((preg_replace('/\s+/', '_', $key)));
							$dashicon = "<i class='dashicons dashicons-tablet' style='transform: rotate(90deg);'></i>";
							$html .= $this->ultimate_responsive_param_media($class, $dashicon, $key, $default_value ,$unit, $data_id);
						break;
						case 'Tablet Portrait':
							$class = 'optional';
							$data_id  = strtolower((preg_replace('/\s+/', '_', $key)));
							$dashicon = "<i class='dashicons dashicons-tablet'></i>";
							$html .= $this->ultimate_responsive_param_media($class, $dashicon, $key, $default_value ,$unit, $data_id);
						break;
						case 'Mobile Landscape':
							$class = 'optional';
							$data_id  = strtolower((preg_replace('/\s+/', '_', $key)));
							$dashicon = "<i class='dashicons dashicons-smartphone' style='transform: rotate(90deg);'></i>";
							$html .= $this->ultimate_responsive_param_media($class, $dashicon, $key, $default_value ,$unit, $data_id);
						break;
						case 'Mobile':
							$class = 'optional';
							$data_id  = strtolower((preg_replace('/\s+/', '_', $key)));
							$dashicon = "<i class='dashicons dashicons-smartphone'></i>";
							$html .= $this->ultimate_responsive_param_media($class, $dashicon, $key, $default_value ,$unit, $data_id);
						break;
					}
				}
			$html .= '  </div>';
			$html .= $this->get_units($unit);
			$html .= '  <input type="hidden" data-unit="'.$unit.'"  name="'.$settings['param_name'].'" class="wpb_vc_param_value ultimate-responsive-value '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />';

			$html .= '</div>';

			return $html;
		}
		function ultimate_responsive_param_media($class, $dashicon, $key, $default_value, $unit, $data_id) {
			$tooltipVal  = str_replace('_', ' ', $data_id);
			$html  = '  <div class="ult-responsive-item '.$class.' '.$data_id.' ">';
			$html .= '    <span class="ult-icon">';
        	$html .= '    	<div class="ult-tooltip '.$class.' '.$data_id.'">'.ucwords($tooltipVal).'</div>';
			$html .=          $dashicon;
			$html .= '     </span>';
			$html .= '    <input type="text" class="ult-responsive-input" data-default="'.$default_value.'" data-unit="'.$unit.'" data-id="'.$data_id.'" />';
			$html .= '  </div>';
			return $html;
		}
		function get_units($unit) {
			//  set units - px, em, %
			$html  = '<div class="ultimate-unit-section">';
			$html .= '  <label>'.$unit.'</label>';
			$html .= '</div>';
			return $html;
		}
		// admin scripts
		function ultimate_admin_responsive_param_scripts($hook) {
			if($hook == "post.php" || $hook == "post-new.php"){
				wp_enqueue_style( 'wp-color-picker' );
				$bsf_dev_mode = bsf_get_option('dev_mode');
				if($bsf_dev_mode === 'enable') {
					wp_register_style('ultimate_responsive_param_css', plugins_url('../admin/vc_extend/css/ultimate_responsive.min.css', __FILE__ ));
					wp_enqueue_style( 'ultimate_responsive_param_css');
				}
			}
		}
	}
}

if(class_exists('Ultimate_Responsive'))
{
	$Ultimate_Responsive = new Ultimate_Responsive();
}

// return responsive data
function get_ultimate_vc_responsive_media_css($args) {
	$content = '';
	if(isset($args) && is_array($args)) {
		//  get targeted css class/id from array
		if (array_key_exists('target',$args)) {
			if(!empty($args['target'])) {
				$content .=  " data-ultimate-target='".$args['target']."' ";
			}
		}

		//  get media sizes
		if (array_key_exists('media_sizes',$args)) {
			if(!empty($args['media_sizes'])) {
				$content .=  " data-responsive-json-new='".json_encode($args['media_sizes'])."' ";
			}
		}
	}
	return $content;
}
