<?php 
/**
 * SMOF Options Machine Class
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.0.0
 * @author      Syamil MJ
 */
class Options_Machine {

	/**
	 * PHP5 contructor
	 *
	 * @since 1.0.0
	 */
	function __construct($options) {
		
		$return = $this->optionsframework_machine($options);
		
		$this->Inputs = $return[0];
		$this->Menu = $return[1];
		$this->Defaults = $return[2];
		$this->Load = $return[2];
	}

	/** 
	 * Sanitize option
	 *
	 * Sanitize & returns default values if don't exist
	 * 
	 * Notes:
	 	- For further uses, you can check for the $value['type'] and performs
	 	  more speficic sanitization on the option
	 	- The ultimate objective of this function is to prevent the "undefined index"
	 	  errors some authors are having due to malformed options array
	 */
	static function sanitize_option( $value ) {
		$defaults = array(
			"name" 		=> "",
			"desc" 		=> "",
			"id" 		=> "",
			"std" 		=> "",
			"mod"		=> "",
			"type" 		=> "",
			"dep"		=> ""
		);

		$value = wp_parse_args( $value, $defaults );

		return $value;

	}


	/**
	 * Process options data and build option fields
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function optionsframework_machine($options) {
		global $smof_output, $smof_details, $smof_data;
		if (empty($options))
			return;
		if (empty($smof_data))
			$smof_data = of_get_options();
		$data = $smof_data;

		$defaults = array();   
	    $counter = 0;
		$menu = '';
		$output = '';
		$update_data = false;

		do_action('optionsframework_machine_before', array(
				'options'	=> $options,
				'smof_data'	=> $smof_data,
			));
		if ($smof_output != "") {
			$output .= $smof_output;
			$smof_output = "";
		}
		
		

		foreach ($options as $value) {
			
			// sanitize option
			if ($value['type'] != "heading" && $value['type'] != "toggle_start" && $value['type'] != "toggle_end" && $value['type'] != "customizer_tab" && $value['type'] != "customizer_start" && $value['type'] != "customizer_end")
				$value = self::sanitize_option($value);

			$counter++;
			$val = '';
			
			//create array of defaults		
			if ($value['type'] == 'multicheck'){
				if (is_array($value['std'])){
					foreach($value['std'] as $i=>$key){
						$defaults[$value['id']][$key] = true;
					}
				} else {
						$defaults[$value['id']][$value['std']] = true;
				}
			} else {
				if (isset($value['id'])) $defaults[$value['id']] = $value['std'];
			}
			
			/* condition start */
			if(!empty($smof_data) || !empty($data)){
			
				if (array_key_exists('id', $value) && !isset($smof_data[$value['id']])) {
					$smof_data[$value['id']] = $value['std'];
					if ($value['type'] == "checkbox" && $value['std'] == 0) {
						$smof_data[$value['id']] = 0;
					} else {
						$update_data = true;
					}
				}
				if (array_key_exists('id', $value) && !isset($smof_details[$value['id']])) {
					$smof_details[$value['id']] = $smof_data[$value['id']];
				}

			//Start Heading
			 if ( $value['type'] != "heading" && $value['type'] != "customizer_tab" && $value['type'] != "toggle_start" && $value['type'] != "toggle_end" &&   $value['type'] != "customizer_start" && $value['type'] != "customizer_end"  )
			 {
			 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
				
				//hide items in checkbox group
				$fold='';
				if (array_key_exists("fold",$value) && !array_key_exists("folded",$value)) {
					if (isset($smof_data[$value['fold']]) && $smof_data[$value['fold']]) {
						$fold="f_".$value['fold']." ";
					} else {
						$fold="f_".$value['fold']." temphide ";
					}
				}
				
				$folded='';
				if (array_key_exists("folded",$value)) {	
								
					$fold_class = "folded-".$value['fold']." folded-".$value['fold']."-".$value['folded']." ";
					
					$fold .= $fold_class;
					
					$smof_data_value_fold = '';
					
					if( array_key_exists( $value['fold'], $smof_data ) ) {
						$smof_data_value_fold = $smof_data[ $value['fold'] ];
					}
					
					if($value['folded'] == "not_empty") {
						if(array_key_exists($value['fold'],$smof_data)) {
							if(!$smof_data[$value['fold']]) {
								$fold .= "temphide ";
							}
						}
					} elseif( $value['folded'] != $smof_data_value_fold ) {
						$fold .= "temphide ";
					}
				}
	
				$output .= '<div id="section-'.$value['id'].'" class="'.$fold.'section section-'.$value['type'].' '. $class .'">'."\n";
				
				//only show header if 'name' value exists
				if($value['name']) $output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
				
				if($value['type'] != 'theme_preview') {
					$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";
				} else {
					$output .= '<div class="option">'."\n" . '<div class="controls-full">'."\n";
				}
	
			 } 
			 //End Heading

			//if (!isset($smof_data[$value['id']]) && $value['type'] != "heading")
			//	continue;
			
			//switch statement to handle various options type                              
			switch ( $value['type'] ) {
			
				//text input
				case 'text':
					$t_value = '';
					$t_value = stripslashes($smof_data[$value['id']]);
					
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					
					$output .= '<input class="of-input '.$mini.' input-text" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $t_value .'" />';
				break;
				
				//select option
				case 'select':
					$mini ='';					
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="fld ";
					
					$extra_class = '';
					if (array_key_exists("class",$value)) $extra_class='select-'.$value['class'];
					
					$output .= '<select class="'.$fold.' '.$extra_class.' select of-input" name="'.$value['id'].'" id="'. $value['id'] .'" data-dependency="'.$value['dep'].'">';

					foreach ($value['options'] as $select_ID => $option) {
						$theValue = $option;
						if (!is_numeric($select_ID))
							$theValue = $select_ID;
						$output .= '<option id="' . $select_ID . '" value="'.$theValue.'" ' . selected($smof_data[$value['id']], $theValue, false) . ' />'.$option.'</option>';	 
					 } 
					$output .= '</select>';
				break;
				
				//textarea option
				case 'textarea':	
					$cols = '8';
					$ta_value = '';
					$rows = '';
					if(isset($value['rows'])) {
						$rows = $value['rows'];
					}
					
					if(isset($value['options'])){
							$ta_options = $value['options'];
							if(isset($ta_options['cols'])){
							$cols = $ta_options['cols'];
							} 
						}
						
						$ta_value = stripslashes($smof_data[$value['id']]);			
						$output .= '<textarea class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="'.$rows.'">'.$ta_value.'</textarea>';		
				break;
				
				case 'text_separator':						
		
				break;
				
				//radiobox option
				case "radio":
					$checked = (isset($smof_data[$value['id']])) ? checked($smof_data[$value['id']], $option, false) : '';
					 foreach($value['options'] as $option=>$name) {
						$output .= '<input class="of-input of-radio" name="'.$value['id'].'" type="radio" value="'.$option.'" ' . checked($smof_data[$value['id']], $option, false) . ' /><label class="radio">'.$name.'</label><br/>';				
					}
				break;
				
				//checkbox option
				case 'checkbox':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="fld ";
		
					$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
					$output .= '<input type="checkbox" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
				break;
				
				//multiple checkbox option
				case 'multicheck': 			
					(isset($smof_data[$value['id']]))? $multi_stored = $smof_data[$value['id']] : $multi_stored="";
								
					foreach ($value['options'] as $key => $option) {
						if (!isset($multi_stored[$key])) {$multi_stored[$key] = '';}
						$of_key_string = $value['id'] . '_' . $key;
						$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'['.$key.']'.'" id="'. $of_key_string .'" value="1" '. checked($multi_stored[$key], 1, false) .' /><label class="multicheck" for="'. $of_key_string .'">'. $option .'</label><br />';								
					}			 
				break;
				
				// Color picker
				case "color":
					$default_color = '';
					if ( isset($value['std']) ) {
						$default_color = ' data-default-color="' .$value['std'] . '" ';
					}
					$output .= '<input name="' . $value['id'] . '" id="' . $value['id'] . '" class="of-color" data-dependency="'.$value['dep'].'" type="text" value="' . $smof_data[$value['id']] . '"' . $default_color .' />';
		 	
				break;
				
				// Background color picker
					case "background-color":
						$default_color = '';
						if ( isset($value['std']) ) {
							$default_color = ' data-default-color="' .$value['std'] . '" ';
						}
						$output .= '<input name="' . $value['id'] . '" id="' . $value['id'] . '" class="of-bg-color" data-dependency="'.$value['dep'].'" type="text" value="' . $smof_data[$value['id']] . '"' . $default_color .' />';
				
					break;
					
				// Background color picker
					case "border-color":
						$default_color = '';
						if ( isset($value['std']) ) {
							$default_color = ' data-default-color="' .$value['std'] . '" ';
						}
						$output .= '<input name="' . $value['id'] . '" id="' . $value['id'] . '" class="of-border-color" data-dependency="'.$value['dep'].'" type="text" value="' . $smof_data[$value['id']] . '"' . $default_color .' />';
				
					break;

				//typography option	
				case 'typography':
				
					$typography_stored = isset($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					
					/* Font Size */
					
					if(isset($typography_stored['size'])) {
						$output .= '<select class="of-typography of-typography-size select" name="'.$value['id'].'[size]" id="'. $value['id'].'_size">';
							for ($i = 9; $i < 20; $i++){ 
								$test = $i.'px';
								$output .= '<option value="'. $i .'px" ' . selected($typography_stored['size'], $test, false) . '>'. $i .'px</option>'; 
								}
				
						$output .= '</select>';
					
					}
					
					/* Line Height */
					if(isset($typography_stored['height'])) {
					
						$output .= '<div class="select_wrapper typography-height" original-title="Line height">';
						$output .= '<select class="of-typography of-typography-height select" name="'.$value['id'].'[height]" id="'. $value['id'].'_height">';
							for ($i = 20; $i < 38; $i++){ 
								$test = $i.'px';
								$output .= '<option value="'. $i .'px" ' . selected($typography_stored['height'], $test, false) . '>'. $i .'px</option>'; 
								}
				
						$output .= '</select></div>';
					
					}
						
					/* Font Face */
					if(isset($typography_stored['face'])) {
					
						$output .= '<div class="select_wrapper typography-face" original-title="Font family">';
						$output .= '<select class="of-typography of-typography-face select" name="'.$value['id'].'[face]" id="'. $value['id'].'_face">';
						
						$faces = array('arial'=>'Arial',
										'verdana'=>'Verdana, Geneva',
										'trebuchet'=>'Trebuchet',
										'georgia' =>'Georgia',
										'times'=>'Times New Roman',
										'tahoma'=>'Tahoma, Geneva',
										'palatino'=>'Palatino',
										'helvetica'=>'Helvetica' );			
						foreach ($faces as $i=>$face) {
							$output .= '<option value="'. $i .'" ' . selected($typography_stored['face'], $i, false) . '>'. $face .'</option>';
						}			
										
						$output .= '</select></div>';
					
					}
					
					/* Font Weight */
					if(isset($typography_stored['style'])) {
					
						$output .= '<div class="select_wrapper typography-style" original-title="Font style">';
						$output .= '<select class="of-typography of-typography-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
						$styles = array('normal'=>'Normal',
										'italic'=>'Italic',
										'bold'=>'Bold',
										'bold italic'=>'Bold Italic');
										
						foreach ($styles as $i=>$style){
						
							$output .= '<option value="'. $i .'" ' . selected($typography_stored['style'], $i, false) . '>'. $style .'</option>';		
						}
						$output .= '</select></div>';
					
					}
					
					/* Font Color */
					if(isset($typography_stored['color'])) {
					
						$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector typography-color"><div style="background-color: '.$typography_stored['color'].'"></div></div>';
						$output .= '<input class="of-color of-typography of-typography-color" original-title="Font color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $typography_stored['color'] .'" />';
					
					}
					
				break;
				
				//border option
				case 'border':
						
					/* Border Width */
					$border_stored = $smof_data[$value['id']];
					
					$output .= '<div class="select_wrapper border-width">';
					$output .= '<select class="of-border of-border-width select" name="'.$value['id'].'[width]" id="'. $value['id'].'_width">';
						for ($i = 0; $i < 21; $i++){ 
						$output .= '<option value="'. $i .'" ' . selected($border_stored['width'], $i, false) . '>'. $i .'</option>';				 }
					$output .= '</select></div>';
					
					/* Border Style */
					$output .= '<div class="select_wrapper border-style">';
					$output .= '<select class="of-border of-border-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
					
					$styles = array('none'=>'None',
									'solid'=>'Solid',
									'dashed'=>'Dashed',
									'dotted'=>'Dotted');
									
					foreach ($styles as $i=>$style){
						$output .= '<option value="'. $i .'" ' . selected($border_stored['style'], $i, false) . '>'. $style .'</option>';		
					}
					
					$output .= '</select></div>';
					
					/* Border Color */		
					$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$border_stored['color'].'"></div></div>';
					$output .= '<input class="of-color of-border of-border-color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $border_stored['color'] .'" />';
					
				break;
				
				//images checkbox - use image as checkboxes
				case 'images':
				
					$i = 0;
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="fld ";
					
					$select_value = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : '';
					
					foreach ($value['options'] as $key => $option) 
					{ 
					$i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $key, false)) {
							$checked = checked($select_value, $key, false);
							$selected = 'of-radio-img-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-img-' . $value['id'] . $i . '" class="'.$fold.' checkbox of-radio-img-radio" value="'.$key.'" name="'.$value['id'].'" '.$checked.' />';
						$output .= '<div class="of-radio-img-label">'. $key .'</div>';
						$output .= '<img title="'.$key.'" src="'.$option.'" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
						$output .= '</span>';				
					}
					
				break;
				
				case 'color-blocks':
					$i = 0;
							
					$select_value = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : '';
					
					foreach ($value['options'] as $key => $option) 
					{ 
					$i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $key, false)) {
							$checked = checked($select_value, $key, false);
							$selected = 'color-block-selected';  
						}
						$output .= '<span class="color-block-holder">';
						$output .= '<input type="radio" id="color-block-' . $value['id'] . $i . '" class="checkbox color-block-radio" value="'.$key.'" name="'.$value['id'].'" '.$checked.' />';
						$output .= '<label for="color-block-' . $value['id'] . $i . '" class="color-block-label" style="background-color:'.$option.';">'. $key .'</label>';						
						//$output .= '<img title="'.$key.'" src="'.$option.'" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
						$output .= '</span>';				
					}
				break;
				
				//info (for small intro box etc)
				case "info":
					$info_text = $value['std'];
					$output .= '<div class="of-info">'.$info_text.'</div>';
				break;
				
				//display a single image
				case "image":
					$src = $value['std'];
					$output .= '<img src="'.$src.'">';
				break;
				
				//tab heading
				case 'heading':
					if($counter >= 2){
					   $output .= '</div>'."\n";
					}

					$header_class = str_replace(' ','',strtolower($value['name']));
					$jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
					$jquery_click_hook = "of-option-" . trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($jquery_click_hook))))));
					$icon = $visible = '';
					
					if($header_class == 'general') {
						$header_class .= ' current';
						$visible = 'style="display:block;"';						
					}
					
					$menu .= '<li class="'. $header_class .'"><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'"'. $icon .'><i class="fa fa-'.$value['icon'].'"></i>'.  $value['name'] .'</a></li>';
					$output .= '<div class="group" id="'. $jquery_click_hook  .'"'.$visible.'><h2>'.$value['name'].'</h2>'."\n";
				break;
				
				
				//drag & drop slide manager
				case 'slider':
					$output .= '<div class="slider"><ul id="'.$value['id'].'">';

					$slides = $smof_data[$value['id']];
					$count = count($slides);

					if ($count < 1) {
						$oldorder = 1;
						$order = 1;
						//$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order);
					} else if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order);
						}
					}		
					$output .= '</ul>';
					$output .= '<a class="button slide_add_button">Add New Sidebar</a></div>';
					
				break;
				
				case 'socials':
					$_id = strip_tags( strtolower($value['id']) );
					$output .= '<div class="slider"><ul id="'.$value['id'].'">';
					
					$slides = $smof_data[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_socials_function($value['id'],$value['std'],$oldorder,$order);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_socials_function($value['id'],$value['std'],$oldorder,$order);
						}
					}			
					$output .= '</ul>';
					$output .= '<a href="#" class="button socials_add_button">Add New Icon</a></div>';
					
				break;
				
				
				case 'custom_headers':
					$_id = strip_tags( strtolower($value['id']) );
					$output .= '<div class="slider"><ul id="'.$value['id'].'">';
					
					$slides = $smof_data[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_headers_function($value['id'],$value['std'],$oldorder,$order);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_headers_function($value['id'],$value['std'],$oldorder,$order);
						}
					}			
					$output .= '</ul>';
					$output .= '<a href="#" class="button headers_add_button">Add New</a></div>';
					
				break;
				
				//drag & drop block manager
				case 'sorter':

				    // Make sure to get list of all the default blocks first
				    $all_blocks = $value['std'];

				    $temp = array(); // holds default blocks
				    $temp2 = array(); // holds saved blocks

					foreach($all_blocks as $blocks) {
					    $temp = array_merge($temp, $blocks);
					}

				    $sortlists = isset($data[$value['id']]) && !empty($data[$value['id']]) ? $data[$value['id']] : $value['std'];

				    foreach( $sortlists as $sortlist ) {
					$temp2 = array_merge($temp2, $sortlist);
				    }

				    // now let's compare if we have anything missing
				    foreach($temp as $k => $v) {
					if(!array_key_exists($k, $temp2)) {
					    $sortlists['disabled'][$k] = $v;
					}
				    }

				    // now check if saved blocks has blocks not registered under default blocks
				    foreach( $sortlists as $key => $sortlist ) {
					foreach($sortlist as $k => $v) {
					    if(!array_key_exists($k, $temp)) {
						unset($sortlist[$k]);
					    }
					}
					$sortlists[$key] = $sortlist;
				    }

				    // assuming all sync'ed, now get the correct naming for each block
				    foreach( $sortlists as $key => $sortlist ) {
					foreach($sortlist as $k => $v) {
					    $sortlist[$k] = $temp[$k];
					}
					$sortlists[$key] = $sortlist;
				    }

				    $output .= '<div id="'.$value['id'].'" class="sorter">';


				    if ($sortlists) {

					foreach ($sortlists as $group=>$sortlist) {

					    $output .= '<ul id="'.$value['id'].'_'.$group.'" class="sortlist_'.$value['id'].'">';
					    $output .= '<h3>'.$group.'</h3>';

					    foreach ($sortlist as $key => $list) {

						$output .= '<input class="sorter-placebo" type="hidden" name="'.$value['id'].'['.$group.'][placebo]" value="placebo">';

						if ($key != "placebo") {

						    $output .= '<li id="'.$key.'" class="sortee">';
						    $output .= '<input class="position" type="hidden" name="'.$value['id'].'['.$group.']['.$key.']" value="'.$list.'">';
						    $output .= $list;
						    $output .= '</li>';

						}

					    }

					    $output .= '</ul>';
					}
				    }

				    $output .= '</div>';
				break;
				
				//background images option
				case 'tiles':
					
					$i = 0;
					$select_value = isset($smof_data[$value['id']]) && !empty($smof_data[$value['id']]) ? $smof_data[$value['id']] : '';
					if (is_array($value['options'])) {
						foreach ($value['options'] as $key => $option) { 
						$i++;
				
							$checked = '';
							$selected = '';
							if(NULL!=checked($select_value, $option, false)) {
								$checked = checked($select_value, $option, false);
								$selected = 'of-radio-tile-selected';  
							}
							$output .= '<span>';
							$output .= '<input type="radio" id="of-radio-tile-' . $value['id'] . $i . '" class="checkbox of-radio-tile-radio" value="'.$option.'" name="'.$value['id'].'" '.$checked.' />';
							$output .= '<div class="of-radio-tile-img '. $selected .'" style="background: url('.$option.')" onClick="document.getElementById(\'of-radio-tile-'. $value['id'] . $i.'\').checked = true;"></div>';
							$output .= '</span>';				
						}
					}
					
				break;
				
				//backup and restore options data
				case 'backup':
				
					$instructions = $value['desc'];
					$backup = of_get_options(BACKUPS);
					$init = of_get_options('smof_init');


					if(!isset($backup['backup_log'])) {
						$log = 'No backups yet';
					} else {
						$log = $backup['backup_log'];
					}
					
					$output .= '<div class="backup-box">';
					$output .= '<div class="instructions">'.$instructions."\n";
					$output .= '<p><strong>'. __('Last Backup', 'north').': <span class="backup-log">'.$log.'</span></strong></p></div>'."\n";
					$output .= '<a href="#" id="of_backup_button" class="button" title="Backup Options">Backup Options</a>';
					$output .= '<a href="#" id="of_restore_button" class="button" title="Restore Options">Restore Options</a>';
					$output .= '</div>';
				
				break;
				
				//export or import data between different installs
				case 'transfer':
				
					$instructions = $value['desc'];
					$output .= '<textarea id="export_data" rows="8">'.base64_encode(serialize($smof_data)) /* 100% safe - ignore theme check nag */ .'</textarea>'."\n";
					$output .= '<a href="#" id="of_import_button" class="button" title="Restore Options">Import Options</a>';
				
				break;
				
				// google font field
				case 'select_google_font':
					$output .= '<select class="select of-input google_font_select" name="'.$value['id'].'" id="'. $value['id'] .'" data-dependency='.$value['dep'].'>';
					foreach ($value['options'] as $select_key => $option) {
						$output .= '<option value="'.$select_key.'" ' . selected((isset($smof_data[$value['id']]))? $smof_data[$value['id']] : "", $option, false) . ' />'.$option.'</option>';
					} 
					$output .= '</select>';
					
					if(isset($value['preview']['text'])){
						$g_text = $value['preview']['text'];
					} else {
						$g_text = '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz';
					}
					if(isset($value['preview']['size'])) {
						$g_size = 'style="font-size: '. $value['preview']['size'] .';"';
					} else { 
						$g_size = '';
					}
					$hide = " hide";
					if ($smof_data[$value['id']] != "none" && $smof_data[$value['id']] != "")
						$hide = "";
					
					//$output .= '<p class="'.$value['id'].'_ggf_previewer google_font_preview'.$hide.'" '. $g_size .'>'. $g_text .'</p>';
				break;
				
				//JQuery UI Slider
				case 'sliderui':
					$s_val = $s_min = $s_max = $s_step = $s_edit = '';//no errors, please
					
					$s_val  = stripslashes($smof_data[$value['id']]);
					
					if(!isset($value['min'])){ $s_min  = '0'; }else{ $s_min = $value['min']; }
					if(!isset($value['max'])){ $s_max  = $s_min + 1; }else{ $s_max = $value['max']; }
					if(!isset($value['step'])){ $s_step  = '1'; }else{ $s_step = $value['step']; }
					
					if(!isset($value['edit'])){ 
						$s_edit  = ' readonly="readonly"'; 
					}
					else
					{
						$s_edit  = '';
					}
					
					if ($s_val == '') $s_val = $s_min;
					
					//values
					$s_data = 'data-id="'.$value['id'].'" data-val="'.$s_val.'" data-min="'.$s_min.'" data-max="'.$s_max.'" data-step="'.$s_step.'"';
					
					//html output
					$output .= '<input type="text" name="'.$value['id'].'" id="'.$value['id'].'" data-dependency="'.$value['dep'].'" value="'. $s_val .'" class="mini" '. $s_edit .' />';
					$output .= '<div id="'.$value['id'].'-slider" class="smof_sliderui" style="margin-left: 7px;" '. $s_data .'></div>';
					
				break;
				
				//text input
				case 'theme_preview':
					$t_value = '';
					$t_value = stripslashes($smof_data[$value['id']]);
					
					$mini = $boxed_styling = $topbar_disabled = '';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					global $smof_data;
					
					if(array_key_exists('vntd_website_layout',$smof_data)) {
						if($smof_data['vntd_website_layout'] == 'boxed') {
							$boxed_styling = '#theme-preview .browser-wrapper { width:85%; border-width:0 1px 0 1px; }#theme-preview .browser-wrapper > div { padding:15px 30px; }';
						}
					}
					if(array_key_exists('vntd_topbar',$smof_data)) {
						if(!$smof_data['vntd_topbar']) $topbar_disabled = 'style="display:none;"';
					}
					if(array_key_exists('vntd_accent_color',$smof_data)) {
					
					$output .= '
					<style type="text/css">
						
						'.$boxed_styling.'
						#theme-preview .accent { color: '.$smof_data['vntd_accent_color'].'; }
						#theme-preview .browser-content {
							background-color: '.$smof_data['vntd_bg_color'].';';
							$output .= '
							
						}
						
						#theme-preview .header {
							background-color: '.$smof_data['vntd_header_bg_color'].';';
							$output .= '							
							
						}
						#theme-preview .preview-navigation {
							color: '.$smof_data['vntd_header_nav_color'].';
							font-size: '.$smof_data['vntd_fs_navigation'].'px;
							font-weight: '.$smof_data['vntd_navigation_font_weight'].';
							text-transform: '.$smof_data['vntd_navigation_font_transform'].';
						}
						
						#theme-preview .page-title {
							background-color: '.$smof_data['vntd_pagetitle_bg_color'].';
							font-size: '.$smof_data['vntd_fs_page_title'].'px;
							border-color: '.$smof_data['vntd_pagetitle_border_color'].';';
							$output .= '
							
						}
						
						#theme-preview .preview-page-title { color: '.$smof_data['vntd_pagetitle_color'].'; }
						#theme-preview .preview-page-tagline {
							color: '.$smof_data['vntd_pagetitle_tagline_color'].';
							font-size: '.$smof_data['vntd_fs_page_tagline'].'px;
						}
						#theme-preview .preview-breadcrumbs {
							color: '.$smof_data['vntd_breadcrumbs_color'].';
							font-size: '.$smof_data['vntd_fs_breadcrumbs'].'px;
						}
						
						#theme-preview .body {
							color: '.$smof_data['vntd_body_color'].';
							font-size: '.$smof_data['vntd_fs_body'].'px;';
							$output .= '
							
						}
						
						#theme-preview .preview-heading { 
							color: '.$smof_data['vntd_heading_color'].'; 
							text-transform:'.$smof_data['vntd_heading_font_transform'].'; 
							font-weight:'.$smof_data['vntd_heading_font_weight'].'; 
						} 
						#theme-preview .body-hover-color { color: '.$smof_data['vntd_content_hover_color'].'; }
						
						#theme-preview .footer {
							color: '.$smof_data['vntd_footer_color'].';
							background-color: '.$smof_data['vntd_footer_bg_color'].';
							border-color: '.$smof_data['vntd_footer_border_color'].';							
							font-size: '.$smof_data['vntd_fs_copyright'].'px;
							
						}					

						#theme-preview .preview-special-heading { font-size: '.$smof_data['vntd_fs_special'].'px; } 
						#theme-preview .preview-h1 { font-size: '.$smof_data['vntd_fs_h1'].'px; } 
						#theme-preview .preview-h2 { font-size: '.$smof_data['vntd_fs_h2'].'px; } 
						#theme-preview .preview-h3 { font-size: '.$smof_data['vntd_fs_h3'].'px; } 
						#theme-preview .preview-h4 { font-size: '.$smof_data['vntd_fs_h4'].'px; } 
						#theme-preview .preview-h5 { font-size: '.$smof_data['vntd_fs_h5'].'px; } 
						#theme-preview .preview-h6 { font-size: '.$smof_data['vntd_fs_h6'].'px; } 
					</style>';
					
					}
					
					$output .= '<div id="theme-preview" class="browser-window">
									
									<div class="browser-header">'.get_bloginfo('name').'</div>
									<div class="browser-content">
									<div class="browser-wrapper">										
										<div class="header">'.get_bloginfo('name').'											
											<div class="preview-navigation primary-font"><ul><li class="accent">Home</li><li>Blog</li><li>Contact</li></ul></div>
										</div>
										
										<div class="page-title">
											<h2 class="preview-page-title primary-font">Page Title</h2><span class="preview-breadcrumbs">back to home</span>
											<div class="preview-page-tagline">Beautiful page tagline</div>											
										</div>
										
										<div class="body">
											<div class="two-third">
											<h1 class="primary-font preview-special-heading preview-heading">Special</h1>
											<p class="body">The first parameter is a unique ID for the section that you\'ll need later (when you’re putting controls into it).</p>
											<h1 class="primary-font preview-h1 preview-heading">Heading 1</h1>
											<p class="body">The first parameter is a unique ID for the section that you\'ll need later (when you’re putting controls into it).</p>
											<h2 class="primary-font preview-h2 preview-heading">Heading 2</h2>
											<p class="body"><span class="accent">This is a link</span> and <span class="body-hover-color">this is a link hover color</span></p>
											<h3 class="primary-font preview-h3 preview-heading">Heading 3</h3>			
											
											</div>
											<div class="one-third">
												<h3 class="sidebar-heading primary-font preview-heading preview-h3">Widget Title</h3>
												<p class="widget-content body">Fusce a odio in neque congue feugiat fusce a odio in neque congue feugiat.</p>
												<h4 class="primary-font preview-h4 preview-heading">Heading 4</h4>
												<h5 class="primary-font preview-h5 preview-heading">Heading 5</h5>
												<h6 class="primary-font preview-h6 preview-heading">Heading 6</h6>												
											</div>
										</div>
										
										<div class="footer">
											2014 Your Site - All rights reserved. <span class="subfooter-link">Link</span> and <span class="subfooter-hover">Hover state</span>.
										</div>
									</div>
									</div>

							</div>';
							
					
				break;
				
				// Theme Customizer Start
				case 'customizer_start':
					$output .= '<div class="theme-customizer-nav"><ul class="customizer-tabs-nav">
						<li class="tab-current"><span>General</span></li>																		
						<li><span>Header</span></li>
						<li><span>Page Title</span></li>
						<li><span>Page Content</span></li>									
						<li><span>Footer</span></li>
						<li><span>Typography</span></li>					
					</ul><div class="clear"></div></div>
					<div class="theme-customizer">								
								<div class="customizer-tabs-content" onmouseover="document.body.style.overflow=\'hidden\';" onmouseout="document.body.style.overflow=\'auto\';">';
				break;
				
				// Theme Customizer Single Tab
				case 'customizer_tab':
					if($value['name'] != 'General') $output .= '</div>';
					$output .= '<div id="customizer-tab-'.$value['name'].'" class="customizer-tab">';
				break;
				
				// Theme Customizer End
				case 'customizer_end':
					$output .= '</div></div></div>';
				break;
				
				// Toggle Start
				case 'toggle_start':
					$output .= '<div class="of-toggle-wrap f_st_custom_headers"><div class="of-toggle-heading">'.$value['name'].'<i class="icon-plus"></i></div><div class="of-toggle-content">';
				break;
				
				// Toggle End
				case 'toggle_end':
					$output .= '</div></div>';
				break;
				
				
				//Switch option
				case 'switch':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = 0;
					}
					
					$fold = $fold_checkbox = '';
					if (array_key_exists("folds",$value)) {
						$fold="s_fld ";
						$fold_checkbox = "fld ";	
					}
					
					$cb_enabled = $cb_disabled = '';//no errors, please
					
					//Get selected
					if ($smof_data[$value['id']] == 1){
						$cb_enabled = ' selected';
						$cb_disabled = '';
					}else{
						$cb_enabled = '';
						$cb_disabled = ' selected';
					}
					
					//Label ON
					if(!isset($value['on'])){
						$on = "On";
					}else{
						$on = $value['on'];
					}
					
					//Label OFF
					if(!isset($value['off'])){
						$off = "Off";
					}else{
						$off = $value['off'];
					}
					
					//$output .= '<p class="switch-options">';
					$output .= '<p>';
//						$output .= '<label class="'.$fold.'cb-enable'. $cb_enabled .'" data-id="'.$value['id'].'"><span>'. $on .'</span></label>';
//						$output .= '<label class="'.$fold.'cb-disable'. $cb_disabled .'" data-id="'.$value['id'].'"><span>'. $off .'</span></label>';
						
						//$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
						$output .= '<div class="toggle-checkbox"></div>';
						$output .= '<input type="checkbox" id="'.$value['id'].'" class="'.$fold_checkbox.'checkbox of-input main_checkbox hidden" data-dependency="'.$value['dep'].'" name="'.$value['id'].'"  value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
						
						
						
					$output .= '</p>';
					
					
					
				break;

				// Uploader 3.5
				case "upload":
				case "media":

					if(!isset($value['mod'])) $value['mod'] = '';
					
					$u_val = '';
					if($smof_data[$value['id']]){
						$u_val = stripslashes($smof_data[$value['id']]);
					}

					$output .= Options_Machine::optionsframework_media_uploader_function($value['id'],$u_val, $value['mod'], $value['dep']);
					
				break;
				
			}

			do_action('optionsframework_machine_loop', array(
					'options'	=> $options,
					'smof_data'	=> $smof_data,
					'defaults'	=> $defaults,
					'counter'	=> $counter,
					'menu'		=> $menu,
					'output'	=> $output,
					'value'		=> $value
				));
			if ($smof_output != "") {
				$output .= $smof_output;
				$smof_output = "";
			}
			
			//description of each option
			if ( $value['type'] != 'heading' && $value['type'] != "toggle_start" && $value['type'] != "toggle_end" && $value['type'] != "customizer_tab" && $value['type'] != "customizer_start" && $value['type'] != "customizer_end") { 
				if(!isset($value['desc'])){ $explain_value = ''; } else{ 
					$explain_value = '<div class="explain">'. $value['desc'] .'</div>'."\n"; 
				} 
				$output .= '</div>'.$explain_value."\n";
				$output .= '<div class="clear"> </div></div></div>'."\n";
				}
			
			} /* condition empty end */
		   
		}

		if ($update_data == true) {
			of_save_options($smof_data);
		}
		
	    $output .= '</div>';

	    do_action('optionsframework_machine_after', array(
					'options'		=> $options,
					'smof_data'		=> $smof_data,
					'defaults'		=> $defaults,
					'counter'		=> $counter,
					'menu'			=> $menu,
					'output'		=> $output,
					'value'			=> $value
				));
		if ($smof_output != "") {
			$output .= $smof_output;
			$smof_output = "";
		}
	    
	    return array($output,$menu,$defaults);
	    
	}


	/**
	 * Native media library uploader
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_media_uploader_function($id,$std,$mod,$dep){

	    $data = of_get_options();
	    $smof_data = of_get_options();
		
		$uploader = '';
		$upload = "";
		if (isset($smof_data[$id]))
	    	$upload = $smof_data[$id];
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.$hide.' upload of-input input-text" name="'. $id .'" id="'. $id .'_upload" data-dependency="'.$dep.'" value="'. $val .'" />';	
		
		//Upload controls DIV
		$uploader .= '<div class="upload_button_div">';
		//If the user has WP3.5+ show upload/remove button
		if ( function_exists( 'wp_enqueue_media' ) ) {
			$uploader .= '<span class="button media_upload_button" id="'.$id.'">Upload</span>';
			
			if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
			$uploader .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		}
		else 
		{
			$output .= '<p class="upload-notice"><i>Upgrade your version of WordPress for full media support.</i></p>';
		}

		$uploader .='</div>' . "\n";

		//Preview
		$uploader .= '<div class="screenshot">';
		if(!empty($upload)){	
	    	$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
	    	$uploader .= '</a>';			
			}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
		
	}

	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_slider_function($id,$std,$oldorder,$order){
		
	    $data = of_get_options();
	    $smof_data = of_get_options();
		
		$slider = '';
		$slide = array();
		if (isset($smof_data[$id]))
	    	$slide = $smof_data[$id];
		
	    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
		
		//initialize all vars
		$slidevars = array('title','url','link','description');
		
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		
		
		//begin slider interface	
		if (!empty($val['title'])) {
			$slider .= '<li><div class="slide_header">'.stripslashes($val['title']);
		} else {
			$slider .= '<li><div class="slide_header">New Sidebar '.$order;
		}
		
		$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';
	
		$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
		
		$slider .= '<div class="slide_body">';
		
		$slider .= '<label>Title</label>';
		if (!empty($val['title'])) {
			$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($val['title']) .'" />';
		} else {
			$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="New Sidebar '.$order.'" />';
		}
		if($id != 'sidebar_generator') {
			
			$slider .= '<label>Image URL</label>';
			$slider .= '<input class="upload slide of-input" name="'. $id .'['.$order.'][url]" id="'. $id .'_'.$order .'_slide_url" value="'. $val['url'] .'" />';
			
			$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'_'.$order .'">Upload</span>';
			
			if(!empty($val['url'])) {$hide = '';} else { $hide = 'hide';}
			$slider .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'_'.$order .'" title="' . $id . '_'.$order .'">Remove</span>';
			$slider .='</div>' . "\n";
			$slider .= '<div class="screenshot">';
			if(!empty($val['url'])){
				
		    	$slider .= '<a class="of-uploaded-image" href="'. $val['url'] . '">';
		    	$slider .= '<img class="of-option-image" id="image_'.$id.'_'.$order .'" src="'.$val['url'].'" alt="" />';
		    	$slider .= '</a>';
				
				}
			$slider .= '</div>';	
			$slider .= '<label>Link URL (optional)</label>';
			$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][link]" id="'. $id .'_'.$order .'_slide_link" value="'. $val['link'] .'" />';
			
			$slider .= '<label>Description (optional)</label>';
			$slider .= '<textarea class="slide of-input" name="'. $id .'['.$order.'][description]" id="'. $id .'_'.$order .'_slide_description" cols="8" rows="8">'.stripslashes($val['description']).'</textarea>';
		
		}
	
		$slider .= '<a class="slide_remove_button" href="#">Delete</a>';
	    $slider .= '<div class="clear"></div>' . "\n";
	
		$slider .= '</div>';
		$slider .= '</li>';
	
		return $slider;
		
	}
	
	/**
	 * Drag and drop social icons manager
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_socials_function($id,$std,$oldorder,$order){
		
	    $data = of_get_options();
	    $smof_data = of_get_options();
		
		$slider = '';
		$slide = array();
		if(array_key_exists($id,$smof_data)) {
	    	$slide = $smof_data[$id];
		}
		
	    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
		
		//initialize all vars
		$slidevars = array('title','url','link','description');
		
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		
		//begin slider interface	
		if (!empty($val['icon_name'])) {
			$slider .= '<li><div class="slide_header">'.$val['icon_name'];
		} else {
			$slider .= '<li><div class="slide_header">Social Icon '.$order;
		}
		
		$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';
	
		$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
		
		$slider .= '<div class="slide_body">';
		
		$slider .= '<label>Social Icon</label>';
		$slider .= '<select class="select" name="'. $id .'['.$order.'][icon_name]">';
		
		$social_icons = array(
			'facebook' => 'Facebook',
			'twitter' => 'Twitter',
			'google-plus' => 'Google Plus',
			'linkedin' => 'LinkedIn',
			'dribbble' => 'Dribbble',
			'pinterest' => 'Pinterest',
			'skype' => 'Skype',
			'tumblr' => 'Tumblr',
			'dropbox' => 'Dropbox',
			'rss' => 'RSS',
			'weibo' => 'Weibo',
			'flickr' => 'Flickr',
			'instagram' => 'Instagram',
			'vimeo' => 'Vimeo',
			'youtube' => 'YouTube',
			'stack-exchange' => 'Stack Exchange',
			'stack-overflow' => 'Stack Overflow',
			'github' => 'Github',
			'maxcdns' => 'Maxcdn',
			'snapchat' => 'Snapchat',
			'soundcloud' => 'Soundcloud',
			'envelope' => 'E-Mail'			
		);
		
		foreach($social_icons as $social_icon => $key){
			$selected = '';	
			if(array_key_exists('icon_name',$val)) {	
				if($val['icon_name'] == $social_icon) $selected = 'selected="selected"';
			}	
			$slider .= '<option value="'.$social_icon.'"'.$selected.'>'.$key.'</option>';
		}
		
		$slider .= '</select>';
		
		$slider .= '<label>URL</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][url]" id="'. $id .'_'.$order .'_slide_url" placeholder="http://" value="'. $val['url'] .'" />';
	
		$slider .= '<a class="slide_remove_button" href="#">Remove</a>';
	    $slider .= '<div class="clear"></div>' . "\n";
	
		$slider .= '</div>';
		$slider .= '</li>';
	
		return $slider;
		
	}
	
	
/**
 * Drag and drop custom headers generator
 *
 * @uses get_option()
 *
 * @access public
 * @since 1.0.0
 *
 * @return string
 */
public static function optionsframework_headers_function($id,$std,$oldorder,$order){
	
    $data = of_get_options();
    $smof_data = of_get_options();
	
	$slider = '';
	$slide = array();
    $slide = $smof_data[$id];
	
    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
	
	//initialize all vars
	$slidevars = array('title','url','link','description');
	
	foreach ($slidevars as $slidevar) {
		if (!isset($val[$slidevar])) {
			$val[$slidevar] = '';
		}
	}
	
	//begin slider interface	
	if (!empty($val['icon_name'])) {
		$slider .= '<li><div class="slide_header">'.$val['icon_name'];
	} else {
		$slider .= '<li><div class="slide_header">Social Icon '.$order;
	}
	
	$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';

	$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
	
	$slider .= '<div class="slide_body">';
	
	$slider .= '<label>Header Name</label>';
	$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($val['title']) .'" />';
	
	$slider .= '<label>Background Image URL</label>';
	$slider .= '<input class="upload slide of-input" name="'. $id .'['.$order.'][url]" id="'. $id .'_'.$order .'_slide_url" value="'. $val['url'] .'" />';
	
	$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'_'.$order .'">Upload</span>';
	
	if(!empty($val['url'])) {$hide = '';} else { $hide = 'hide';}
	$slider .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'_'.$order .'" title="' . $id . '_'.$order .'">Remove</span>';
	$slider .='</div>' . "\n";
	$slider .= '<div class="screenshot">';
	if(!empty($val['url'])){
		
		$slider .= '<a class="of-uploaded-image" href="'. $val['url'] . '">';
		$slider .= '<img class="of-option-image" id="image_'.$id.'_'.$order .'" src="'.$val['url'].'" alt="" />';
		$slider .= '</a>';
		
		}
	$slider .= '</div>';	
	$slider .= '<label>Title Font Size</label>';
	$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][title_fs]" id="'. $id .'_'.$order .'_title_fs" value="'. $val['link'] .'" />';
	
	$slider .= '<label>Title Color</label>';
	$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][title_color]" id="'. $id .'_'.$order .'_title_color" value="'. $val['link'] .'" />';
	
	$slider .= '<label>Tagline Color</label>';
	$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][tagline_color]" id="'. $id .'_'.$order .'_tagline_color" value="'. $val['link'] .'" />';
	
	$slider .= '<label>Text Align</label>';
	$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][align]" id="'. $id .'_'.$order .'_align" value="'. $val['link'] .'" />';

	$slider .= '<a class="slide_delete_button" href="#">Delete</a>';
    $slider .= '<div class="clear"></div>' . "\n";

	$slider .= '</div>';
	$slider .= '</li>';

	return $slider;
	
}

	
}//end Options Machine class

?>
