<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Item_Element {

    
    /**
     * Return all Item Elements
     */
    public static function get_essential_item_elements(){
        global $wpdb;
		
		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
        
        $item_elements = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        
		return apply_filters('essgrid_get_essential_item_elements', $item_elements);
    }
    
    
    /**
	 * Get Item Element by ID from Database
	 */
	public static function get_essential_item_element_by_id($id = 0){
		global $wpdb;
		
		$id = intval($id);
		if($id == 0) return false;
		
		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		
		$element = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
		
		if(!empty($element)){
			$element['settings'] = @json_decode($element['params'], true);
		}
		
		return apply_filters('essgrid_get_essential_item_element_by_id', $element, $id);
	}
    
    
    /**
	 * Get Item Element by handle from Database
	 */
	public static function check_existence_by_handle($handle){
		global $wpdb;
		
		if(trim($handle) == '') return __('Chosen name is too short', EG_TEXTDOMAIN);
		
		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		
		$element = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s", $handle), ARRAY_A);
		
		$return = false;
		
		if(!empty($element)){
			$return = true;
		}
		
		return apply_filters('essgrid_check_existence_by_handle', $return, $handle);
	}
    
    
    /**
	 * Update Item Element by ID from Database
	 */
    public static function update_create_essential_item_element($data){
        global $wpdb;
        
        $table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
        
        if(!isset($data['name']) || empty($data['name'])) return __('Name not received', EG_TEXTDOMAIN);
        
        $element = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE name = %s", $data['name']), ARRAY_A);
        
        if(!empty($element)){
            $success = self::update_essential_item_element(apply_filters('essgrid_update_create_essential_item_element', $data, 'update'));
        }else{
            $success = self::insert_essential_item_element(apply_filters('essgrid_update_create_essential_item_element', $data, 'insert'));
        }
        
        return $success;
    }
    
    
    /**
	 * Update Item Element by ID from Database
	 */
	public static function update_essential_item_element($data){
		global $wpdb;
		
        $table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
        
        if(empty($data['settings'])) return __('Element Item has no attributes', EG_TEXTDOMAIN);
        
        //check if element is default element (these are not deletable)
        $default = self::getDefaultElementsArray();
        
        $is_default = false;
        foreach($default as $handle => $settings){
            if($handle == sanitize_title($data['name'])){
                $is_default = true;
                break;
            }
        }
        
        $data['settings'] = self::clean_settings_from_elements($data['settings']);
        
        if($is_default) return __('Choosen name is reserved for default Item Elements. Please choose a different name', EG_TEXTDOMAIN);
        
		$data = apply_filters('essgrid_update_essential_item_element', $data);
        
		$response = $wpdb->update($table_name,
                                    array(
                                        'settings' => json_encode($data['settings'])
                                        ), array('handle' => sanitize_title($data['name'])));
                                    
        if($response === false) return __('Element Item could not be changed', EG_TEXTDOMAIN);
        
        return true;
	}
    
    
    /**
	 * Insert Item Element by ID from Database
	 */
	public static function insert_essential_item_element($data){
		global $wpdb;
		
		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		
        if(empty($data['settings'])) return __('Element Item has no attributes', EG_TEXTDOMAIN);
        
        //check if element is default element (these are not deletable)
        $default = self::getDefaultElementsArray();
        
        $is_default = false;
        foreach($default as $handle => $settings){
            if($handle == sanitize_title($data['name'])){
                $is_default = true;
                break;
            }
        }
        
        if($is_default) return __('Choosen name is reserved for default Item Elements. Please choose a different name', EG_TEXTDOMAIN);
            
        $data['settings'] = self::clean_settings_from_elements($data['settings']);
        
		$data = apply_filters('essgrid_insert_essential_item_element', $data);
		
		$response = $wpdb->insert($table_name, array('name' => $data['name'], 'handle' => sanitize_title($data['name']), 'settings' => json_encode($data['settings'])));
		
		if($response === false) return false;
		
        return true;
	}
    
    
    /**
	 * Delete Item Element by handle from Database
	 */
    public static function delete_element_by_handle($data){
        global $wpdb;
		
		$data = apply_filters('essgrid_delete_element_by_handle', $data);
		
		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
        
        if(empty($data['handle'])) return __('Element Item does not exist', EG_TEXTDOMAIN);
        
        //check if element is default element (these are not deletable)
        $default = self::getDefaultElementsArray();
        
        $is_default = false;
        foreach($default as $handle => $settings){
            if($handle == $data['handle']){
                $is_default = true;
                break;
            }
        }
        
        if($is_default) return __('Default Item Elements can\'t be deleted', EG_TEXTDOMAIN);
            
        $response = $wpdb->delete($table_name, array('handle' => $data['handle']));
		if($response === false) return __('Element Item could not be deleted', EG_TEXTDOMAIN);
        
        return true;
    }
    
    
    /**
	 * Clean the element- from the settings
	 */
    public static function clean_settings_from_elements($settings){
        if(empty($settings)) return $settings;
        if(!is_array($settings)) return str_replace('element-', '', $settings);
        
        $clean_setting = array();
        
        foreach($settings as $key => $value){
            $clean_setting[str_replace('element-', '', $key)] = $value;
        }
        
        return apply_filters('essgrid_clean_settings_from_elements', $clean_setting, $settings);
    }
    
    /**
	 * Get Array of Text Elements
	 */
	public static function getTextElementsArray(){
		global $wpdb;
		
		$custom = array();
		
        $elements = self::get_essential_item_elements();
        
		if(!empty($elements)){
			foreach($elements as $element){
				$custom[$element['handle']] = array('id' => $element['id'], 'name' => $element['name'], 'settings' => json_decode($element['settings'], true));
			}
		}
		
		Essential_Grid_Base::stripslashes_deep($custom);
		
		return apply_filters('essgrid_getTextElementsArray', $custom, $elements);
	}
    
    
	/**
	 * Get Array of Special Elements
	 */
	public static function getSpecialElementsArray(){
        
		$default = array(
            'eg-line-break' => array(
                'id' => '-1',
                'name' => 'eg-line-break',
                'display' => '<i class="eg-icon-level-down"></i><span>'.__('LINEBREAK ELEMENT', EG_TEXTDOMAIN).'</span>',
                'settings' => array(
                    'background-color' => '#FFFFFF',
                    'bg-alpha' => '20',
                    'clear' => 'both',
                    'border-width' => '0',
                    'color' => 'transparent',
                    'display' => 'block',
                    'font-size' => '10',
                    'font-style' => 'italic',
                    'font-weight' => '700',
                    'line-height' => '5',
                    'margin' => array('0', '0', '0', '0'),
                    'padding' => array('0', '0', '0', '0'),
                    'text-align' => 'center',
                    'transition' => 'none',
                    'text-transform' => 'uppercase',
                    'source' => 'text',
                    'source-text' => __('LINE-BREAK', EG_TEXTDOMAIN),
                    'special' => 'true',
					'special-type' => 'line-break'
                )
            )
		);
		
		return apply_filters('essgrid_getSpecialElementsArray', $default);
	}
	
	
	/**
	 * Get Array of Additional Elements
	 * @since: 2.0
	 */
	public static function getAdditionalElementsArray(){
        
		$default = array(
			'eg-blank-element' => array(
                'id' => '-2',
                'name' => 'eg-blank-element',
                'display' => '<i class="eg-icon-doc"></i><span>'.__('Blank HTML', EG_TEXTDOMAIN).'</span>',
                'settings' => array(
                    'background-color' => 'transparent',
                    'source-text-style-disable' => 'true',
                    'bg-alpha' => '20',
                    'clear' => 'both',
                    'border-width' => '0',
                    'color' => '#000000',
                    'display' => 'block',
                    'font-size' => '13',
                    'font-weight' => '400',
                    'line-height' => '15',
                    'margin' => array('0', '0', '0', '0'),
                    'padding' => array('0', '0', '0', '0'),
                    'text-align' => 'center',
                    'transition' => 'none',
                    'source' => 'text',
                    'source-text' => __('Blank HTML', EG_TEXTDOMAIN),
					'special' => 'true',
					'special-type' => 'blank-element'
                )
            )
		);
		
		return apply_filters('essgrid_getAdditionalElementsArray', $default);
	}
	
	
	/**
	 * Get Array of Post Elements
	 */
	public static function getPostElementsArray(){
		
		$post = array(
			'post_id' => array('name' => __('ID', EG_TEXTDOMAIN)),
			'post_url' => array('name' => __('URL', EG_TEXTDOMAIN)),
			'title' => array('name' => __('Title', EG_TEXTDOMAIN)),
			'excerpt' => array('name' => __('Excerpt', EG_TEXTDOMAIN)),
			'meta' => array('name' => __('Meta', EG_TEXTDOMAIN)),
			'alias' => array('name' => __('Alias', EG_TEXTDOMAIN)),
			'content' => array('name' => __('Content', EG_TEXTDOMAIN)),
			'date' => array('name' => __('Date', EG_TEXTDOMAIN)),
			'date_modified' => array('name' => __('Date Modified', EG_TEXTDOMAIN)),
			'author_name' => array('name' => __('Author Name', EG_TEXTDOMAIN)),
			'num_comments' => array('name' => __('Num. Comments', EG_TEXTDOMAIN)),
			'cat_list' => array('name' => __('Cat. List', EG_TEXTDOMAIN)),
			'tag_list' => array('name' => __('Tag List', EG_TEXTDOMAIN)),
			'caption' => array('name' => __('Caption', EG_TEXTDOMAIN)),
			'likes' => array('name' => __('Likes (Facebook,Twitter,YouTube,Vimeo,Instagram)', EG_TEXTDOMAIN)),
			'likes_short' => array('name' => __('Likes Short (Facebook,Twitter,YouTube,Vimeo,Instagram)', EG_TEXTDOMAIN)),
			'dislikes' => array('name' => __('Dislikes (YouTube)', EG_TEXTDOMAIN)),
			'dislikes_short' => array('name' => __('Dislikes Short (YouTube)', EG_TEXTDOMAIN)),
			'favorites' => array('name' => __('Favorites (YouTube, flickr)', EG_TEXTDOMAIN)),
			'favorites_short' => array('name' => __('Favorites Short (YouTube, flickr)', EG_TEXTDOMAIN)),
			'retweets' => array('name' => __('Retweets (Twitter)', EG_TEXTDOMAIN)),
			'retweets_short' => array('name' => __('Retweets Short (Twitter)', EG_TEXTDOMAIN)),
			'views'	=> array('name' => __('Views (flickr,YouTube, Vimeo)', EG_TEXTDOMAIN)),
			'views_short'	=> array('name' => __('Views Short (flickr,YouTube, Vimeo)', EG_TEXTDOMAIN)),
			'itemCount' => array('name' => __('Playlist Item Count (YouTube)', EG_TEXTDOMAIN)),
			'channel_title' => array('name' => __('Channel Title (YouTube)', EG_TEXTDOMAIN)),
			'duration' => array('name' => __('Duration (Vimeo)', EG_TEXTDOMAIN)),
		);
		
		$post = apply_filters('essgrid_post_meta_handle', $post); //stays for backwards compatibility
		$post = apply_filters('essgrid_getPostElementsArray', $post);
		
		return $post;
	}
	
	
	/**
	 * Get Array of Event Elements
	 */
	public static function getEventElementsArray(){
		
		$event = array(
			'event_start_date' => array('name' => __('Event Start Date', EG_TEXTDOMAIN)),
			'event_end_date' => array('name' => __('Event End Date', EG_TEXTDOMAIN)),
			'event_start_time' => array('name' => __('Event Start Time', EG_TEXTDOMAIN)),
			'event_end_time' => array('name' => __('Event End Time', EG_TEXTDOMAIN)),
			'event_event_id' => array('name' => __('Event Event ID', EG_TEXTDOMAIN)),
			'event_location_name' => array('name' => __('Event Location Name', EG_TEXTDOMAIN)),
			'event_location_slug' => array('name' => __('Event Location Slug', EG_TEXTDOMAIN)),
			'event_location_address' => array('name' => __('Event Location Address', EG_TEXTDOMAIN)),
			'event_location_town' => array('name' => __('Event Location Town', EG_TEXTDOMAIN)),
			'event_location_state' => array('name' => __('Event Location State', EG_TEXTDOMAIN)),
			'event_location_postcode' => array('name' => __('Event Location Postcode', EG_TEXTDOMAIN)),
			'event_location_region' => array('name' => __('Event Location Region', EG_TEXTDOMAIN)),
			'event_location_country' => array('name' => __('Event Location Country', EG_TEXTDOMAIN))
		);
		
		return apply_filters('essgrid_getEventElementsArray', $event);
	}
	
	
	/**
	 * Get Array of Default Elements
	 */
	public static function getDefaultElementsArray(){
		
        $default = array();
		
		include('assets/default-item-elements.php');
		
		$default = apply_filters('essgrid_add_default_item_elements', $default); //stays for backwards compatibility
		$default = apply_filters('essgrid_getDefaultElementsArray', $default);
		
		return $default;
	}
	
	
	/**
	 * Get Array of Elements
	 */
	public static function prepareElementsForEditor($elements, $set_loaded = false){
		$html = '';
		$load_class = '';
		
        if($set_loaded == true)
			$load_class = ' eg-newli';
		
		foreach($elements as $handle => $element){
            $styles = '';
            $filter_type = 'text';
            $data_id = 1;
            if(isset($element['settings']) && !empty($element['settings'])){
                //$styles = self::get_css_from_settings($element['settings']);
                
                if($element['settings']['source'] == 'icon'){
                    $text = '<i class="'.$element['settings']['source-icon'].'"></i>';
                }elseif($element['settings']['source'] == 'text'){
                    $text = $element['settings']['source-text'];
                }else{
                    $text = $element['name'];
                }
                
                if($element['settings']['source'] == 'icon') $filter_type = 'icon';
                
                $data_id = $element['id'];
                
            }else{
                $text = $element['name'];
            }
            
            $sort_title = strip_tags($text);
            if(trim($sort_title) == ''){
                $sort_title = 'unsorted';
            }else{
                $sort_title = strtolower(substr($sort_title, 0, 1));
            }
            
			
			
            if(isset($element['default']) && $element['default'] == 'true') $filter_type.= ' filter-default';
            
            $html.= '<li class="filterall filter-'.$filter_type.$load_class.'" data-title="'.$sort_title.'" data-date="'.$data_id.'">'."\n";
            $html.= '   <div class="esg-entry-content">';
            $html.= '       <div class="eg-elements-format-wrapper"><div class="skin-dz-elements" data-handle="'.$handle.'"'.$styles.'>';
            $html.= $text;
			$html.= '       </div></div>'."\n";
            $html.= '   </div>'."\n";
            $html.= '</li>'."\n";
			
		}
		
		return apply_filters('essgrid_prepareElementsForEditor', $html, $elements, $set_loaded);
	}
	
	/**
	 * Get Array of Special Elements
	 */
	public static function prepareSpecialElementsForEditor(){
		$html = '';
        
        $elements = self::getSpecialElementsArray();
        
		foreach($elements as $handle => $element){
            $styles = '';
            
            if(isset($element['settings']) && !empty($element['settings'])){
                //$styles = self::get_css_from_settings($element['settings']);
                
                $text = $element['display'];
                
            }else{
                $text = $element['name'];
            }
            
            
            $html.= '<div class="skin-dz-elements eg-special-element" data-handle="'.$handle.'"'.$styles.'>';
            $html.= $text;
			$html.= '</div>'."\n";
			
		}
		
		return apply_filters('essgrid_prepareSpecialElementsForEditor', $html, $elements);
	}
	
	
	/**
	 * Get Array of Additional Elements
	 */
	public static function prepareAdditionalElementsForEditor(){
		$html = '';
        
        $elements = self::getAdditionalElementsArray();
        
		foreach($elements as $handle => $element){
            $styles = '';
            
            if(isset($element['settings']) && !empty($element['settings'])){
                //$styles = self::get_css_from_settings($element['settings']);
                
                $text = $element['display'];
				
            }else{
				$text = $element['name'];
			}
            
            
            $html.= '<div style="margin-left: 15px;" class="skin-dz-elements eg-special-blank-element eg-additional-element" data-handle="'.$handle.'"'.$styles.'>';
            $html.= $text;
			$html.= '</div>'."\n";
			
		}
		
		return apply_filters('essgrid_prepareAdditionalElementsForEditor', $html, $elements);
	}
	
	
	/**
	 * Get Array of Default Elements
	 */
	public static function prepareDefaultElementsForEditor(){
		$elements = self::getDefaultElementsArray();
		$elements = apply_filters('essgrid_prepareDefaultElementsForEditor', $elements);
		
		return self::prepareElementsForEditor($elements, true);
	}
	
	/**
	 * Get Array of Post Elements
	 */
	public static function prepareTextElementsForEditor(){
		$elements = self::getTextElementsArray();
		$elements = apply_filters('essgrid_prepareTextElementsForEditor', $elements);
		
		return self::prepareElementsForEditor($elements, true);
	}
	
	
	/**
	 * Get Array of Elements
	 */
	public static function getElementsForJavascript(){
		$default = self::getDefaultElementsArray();
		$text = self::getTextElementsArray();
		$special = self::getSpecialElementsArray();
		$additional = self::getAdditionalElementsArray();
		
		$all = array_merge($default, $text, $special, $additional);
		
		return apply_filters('essgrid_getElementsForJavascript', $all);
	}
	
	/**
	 * Get Array of Elements
	 */
	public static function getElementsForDropdown(){
		$post = self::getPostElementsArray();
		//$event = self::getEventElementsArray();
		
		$all['post'] = $post;
		//$all['event'] = $event;
		
		if(Essential_Grid_Woocommerce::is_woo_exists()){
			$woocommerce = array();
			$tmp_wc = Essential_Grid_Woocommerce::get_meta_array();
			
			foreach($tmp_wc as $handle => $name){
				$woocommerce[$handle]['name'] = $name;
			}
			
			$all['woocommerce'] = $woocommerce;
		}
		
		return apply_filters('essgrid_getElementsForDropdown', $all);
	}
    
    /**
	 * create css from settings
	 */
    /*public static function get_css_from_settings($settings){
        $existing = self::get_existing_elements(true);
        
        $styles = ' style="';
        
        foreach($settings as $setting => $value){
            $style = str_replace('element-', '', $setting);
            if(isset($existing[$style])){
                if($existing[$style]['value'] == 'int') $value = intval($value);
                
                if($value != '') $styles .= $style.': '.$value.$existing[$style]['unit'].'; ';
                
            }
        }
        
        $styles .= '" ';
        
        return $styles;
    }*/
    
    /**
	 * create css from settings
	 */
    public static function get_existing_elements($only_styles = false){
		
        $styles = array(
                'font-size'         => array('value' => 'int',
                                             'type' => 'text-slider',
                                             'values' => array('min' =>'6', 'max' =>'120', 'step' =>'1', 'default' =>'12'),
                                             'style' => 'idle',
                                             'unit' => 'px'),
                                             
                'line-height'       => array('value' => 'int',
                                             'type' => 'text-slider',
                                             'values' => array('min' =>'7', 'max' =>'150', 'step' =>'1', 'default' =>'14'),
                                             'style' => 'idle',
                                             'unit' => 'px'),
                                             
                'color'             => array('value' => 'string',
                                             'type' => 'colorpicker',
                                             'values' => array('default' =>'#000'),
                                             'style' => 'idle',
                                             'unit' => ''),
                                             
                'font-family'       => array('value' => 'string',
                                             'values' => array('default' =>''),
                                             'style' => 'idle',
                                             'type' => 'text',
                                             'unit' => ''),
                                             
                'font-weight'       => array('value' => 'string',
                                             'values' => array('default' =>'400'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'text-decoration'  => array('value' => 'string',
                                             'values' => array('default' =>'none'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'font-style'        => array('value' => 'string',
                                             'values' => array('default' =>false),
                                             'style' => 'idle',
                                             'type' => 'checkbox',
                                             'unit' => ''),
                
                'text-transform'    => array('value' => 'string',
                                             'values' => array('default' =>'none'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                
                'display'           => array('value' => 'string',
                                             'values' => array('default' =>'inline-block'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'float'             => array('value' => 'string',
                                             'values' => array('default' =>'none'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
            
                'text-align'        => array('value' => 'string',
                                             'values' => array('default' =>'center'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'clear'             => array('value' => 'string',
                                             'values' => array('default' =>'none'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'margin'            => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'idle',
                                             'unit' => 'px'),
                                             
                'padding'           => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'idle',
                                             'unit' => 'px'),
                                             
                'border'            => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'idle',
                                             'unit' => 'px'),      
                                             
                'border-radius'     => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'idle',
                                             'unit' => array('px', 'percentage')),
                                             
                'border-color'      => array('value' => 'string',
                                             'values' => array('default' =>'transparent'),
                                             'style' => 'idle',
                                             'type' => 'colorpicker',
                                             'unit' => ''),
                                             
                'border-style'      => array('value' => 'string',
                                             'values' => array('default' =>'solid'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),                            
                                             
                'background-color'  => array('value' => 'string',
                                             'type' => 'colorpicker',
                                             'values' => array('default' =>'#FFF'),
                                             'style' => 'idle',
                                             'unit' => ''),
                                             
                'bg-alpha'          => array('value' => 'string',
                                             'values' => array('min' =>'0', 'max' =>'100', 'step' =>'1', 'default' =>'100'),
                                             'style' => 'false',
                                             'type' => 'text-slider',
                                             'unit' => ''),
                                             
                /*'background-size'   => array('value' => 'string',
                                             'values' => array('default' =>'cover'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'background-repeat'  => array('value' => 'string',
                                             'values' => array('default' =>'no-repeat'),
                                             'style' => 'idle',
                                             'type' => 'select',
                                             'unit' => ''),
                 */                            
                'shadow-color'       => array('value' => 'string',
                                             'type' => 'colorpicker',
                                             'values' => array('default' =>'#000'),
                                             'style' => 'false',
                                             'unit' => ''),   
                                             
                'shadow-alpha'       => array('value' => 'string',
                                             'values' => array('min' =>'0', 'max' =>'100', 'step' =>'1', 'default' =>'100'),
                                             'style' => 'false',
                                             'type' => 'text-slider',
                                             'unit' => ''),
                                             
                'box-shadow'         => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'idle',
                                             'unit' => 'px'),
                                             
                'position'         	=> array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' => 'relative'),
                                             'style' => 'idle',
                                             'unit' => ''),
                                             
                'top-bottom'	=> array('value' => 'int',
                                             'type' => 'text',
                                             'values' => array('default' => '0'),
                                             'style' => 'false',
                                             'unit' => 'px'),
                                             //'unit' => array('px', 'percentage')),
											 
                'left-right'	=> array('value' => 'int',
                                             'type' => 'text',
                                             'values' => array('default' => '0'),
                                             'style' => 'false',
                                             'unit' => 'px')
                                             
            );
			
        $styles = apply_filters('essgrid_get_existing_elements_styles', $styles, $only_styles);
		
        $hover_styles = array(
                'font-size-hover'         => array('value' => 'int',
                                             'type' => 'text-slider',
                                             'values' => array('min' =>'6', 'max' =>'120', 'step' =>'1', 'default' =>'12'),
                                             'style' => 'hover',
                                             'unit' => 'px'),
                                             
                'line-height-hover'       => array('value' => 'int',
                                             'type' => 'text-slider',
                                             'values' => array('min' =>'7', 'max' =>'150', 'step' =>'1', 'default' =>'14'),
                                             'style' => 'hover',
                                             'unit' => 'px'),
                                             
                'color-hover'             => array('value' => 'string',
                                             'type' => 'colorpicker',
                                             'values' => array('default' =>'#000'),
                                             'style' => 'hover',
                                             'unit' => ''),
                                             
                'font-family-hover'       => array('value' => 'string',
                                             'values' => array('default' =>''),
                                             'style' => 'hover',
                                             'type' => 'text',
                                             'unit' => ''),
                                             
                'font-weight-hover'       => array('value' => 'string',
                                             'values' => array('default' =>'400'),
                                             'style' => 'hover',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'text-decoration-hover'  => array('value' => 'string',
                                             'values' => array('default' =>'none'),
                                             'style' => 'hover',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'font-style-hover'        => array('value' => 'string',
                                             'values' => array('default' =>false),
                                             'style' => 'hover',
                                             'type' => 'checkbox',
                                             'unit' => ''),
                
                'text-transform-hover'    => array('value' => 'string',
                                             'values' => array('default' =>'none'),
                                             'style' => 'hover',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'border-hover'            => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'hover',
                                             'unit' => 'px'),      
                                             
                'border-radius-hover'     => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'hover',
                                             'unit' => array('px', 'percentage')),
                                             
                'border-color-hover'      => array('value' => 'string',
                                             'values' => array('default' =>'transparent'),
                                             'style' => 'hover',
                                             'type' => 'colorpicker',
                                             'unit' => ''),
                                             
                'border-style-hover'      => array('value' => 'string',
                                             'values' => array('default' =>'solid'),
                                             'style' => 'hover',
                                             'type' => 'select',
                                             'unit' => ''),                            
                                             
                'background-color-hover'  => array('value' => 'string',
                                             'type' => 'colorpicker',
                                             'values' => array('default' =>'#FFF'),
                                             'style' => 'hover',
                                             'unit' => ''),
                                             
                'bg-alpha-hover'          => array('value' => 'string',
                                             'values' => array('min' =>'0', 'max' =>'100', 'step' =>'1', 'default' =>'100'),
                                             'style' => 'false',
                                             'type' => 'text-slider',
                                             'unit' => ''),
                                             
                /*'background-size-hover'   => array('value' => 'string',
                                             'values' => array('default' =>'cover'),
                                             'style' => 'hover',
                                             'type' => 'select',
                                             'unit' => ''),
                                             
                'background-repeat-hover'  => array('value' => 'string',
                                             'values' => array('default' =>'no-repeat'),
                                             'style' => 'hover',
                                             'type' => 'select',
                                             'unit' => ''),
                 */                            
                'shadow-color-hover'       => array('value' => 'string',
                                             'type' => 'colorpicker',
                                             'values' => array('default' =>'#000'),
                                             'style' => 'false',
                                             'unit' => ''),   
                                             
                'shadow-alpha-hover'       => array('value' => 'string',
                                             'values' => array('min' =>'0', 'max' =>'100', 'step' =>'1', 'default' =>'100'),
                                             'style' => 'false',
                                             'type' => 'text-slider',
                                             'unit' => ''),
                                             
                'box-shadow-hover'         => array('value' => 'int',
                                             'type' => 'multi-text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'hover',
                                             'unit' => 'px')
            );
			
        $hover_styles = apply_filters('essgrid_get_existing_elements_hover_styles', $hover_styles, $only_styles);
		
        $other = array();
            
        if(!$only_styles){
            $other = array(
                'source'            => array('value' => 'string', 
                                             'type' => 'select',
                                             'values' => array('default' =>'post'),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'transition'        => array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'fade'),
                                             'style' => 'attribute',
                                             'unit' => ''),
                
                'source-separate'	=> array('value' => 'string',
                                             'type' => 'text',
                                             'values' => array('default' =>','),
                                             'style' => 'attribute',
                                             'unit' => ''),
                
                'source-function'	=> array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'link'),
                                             'style' => 'attribute',
                                             'unit' => ''),
                
                'limit-type'        	=> array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'none'),
                                             'style' => 'attribute',
                                             'unit' => ''),
                
                'limit-num'        	=> array('value' => 'string',
                                             'type' => 'text',
                                             'values' => array('default' =>'10'),
                                             'style' => 'attribute',
                                             'unit' => ''),
											 
                /*'split'       		=> array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'full'),
                                             'style' => 'attribute',
                                             'unit' => ''), */
                
                'transition-type'   => array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>''),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'delay'             => array('value' => 'string',
                                             'type' => 'text-slider',
                                             'values' => array('min' =>'0', 'max' =>'60', 'step' =>'1', 'default' =>'10'),
                                             'style' => 'attribute',
                                             'unit' => ''),
                
                'link-type'             => array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'none'),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'hideunder'         => array('value' => 'string',
                                             'type' => 'text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'hideunderheight'         => array('value' => 'string',
                                             'type' => 'text',
                                             'values' => array('default' =>'0'),
                                             'style' => 'false',
                                             'unit' => ''),
											 
                'hidetype'    	     => array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'visibility'),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'hide-on-video'		=> array('value' => 'string',
                                             'type' => 'select', //was checkbock before with values 'false', 'true'
                                             'values' => array('default' => false),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'show-on-lightbox-video'=> array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' => false),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'enable-hover' => array('value' => 'string',
                                             'type' => 'checkbox',
                                             'values' => array('default' =>false),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'attribute' => array('value' => 'string',
                                             'type' => 'text',
                                             'values' => array('default' =>''),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'class' => array('value' => 'string',
                                             'type' => 'text',
                                             'values' => array('default' =>''),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'rel' => array('value' => 'string',
                                             'type' => 'text',
                                             'values' => array('default' =>''),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'tag-type' => array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'div'),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'force-important' => array('value' => 'string',
                                             'type' => 'checkbox',
                                             'values' => array('default' =>true),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'align' => array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'t_l'),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'link-target' => array('value' => 'string',
                                             'type' => 'select',
                                             'values' => array('default' =>'_self'),
                                             'style' => 'false',
                                             'unit' => ''),
                
                'source-text-style-disable' => array('value' => 'string',
                                             'type' => 'checkbox',
                                             'values' => array('default' =>false),
                                             'style' => 'false',
                                             'unit' => '')
            );
			
			if(Essential_Grid_Woocommerce::is_woo_exists()){
				$other['show-on-sale']		= array('value' => 'string',
																'type' => 'checkbox',
																'values' => array('default' => false),
																'style' => 'false',
																'unit' => '');
				$other['show-if-featured']	= array('value' => 'string',
																'type' => 'checkbox',
																'values' => array('default' => false),
																'style' => 'false',
																'unit' => '');
			}
			
			$other = apply_filters('essgrid_get_existing_elements_other', $other, $only_styles);
        }
        
        $styles = array_merge($styles, $other, $hover_styles);
        
        return apply_filters('essgrid_get_existing_elements', $styles, $only_styles);
    }
	
	
	/**
	 * get list of allowed styles on tags
	 */
    public static function get_allowed_styles_for_tags(){
		
		return apply_filters('essgrid_get_allowed_styles_for_tags',
			array(
				'font-size',
                'line-height',
                'color',
                'font-family',
                'font-weight',
                'text-decoration',
                'font-style',
                'text-transform',
                'background-color'
			)
		);
		
	}
	
	
	/**
	 * get list of allowed styles on tags
	 */
    public static function get_allowed_styles_for_cat_tag(){
		
		return apply_filters('essgrid_get_allowed_styles_for_cat_tag',
			array(
				'font-size',
                'line-height',
                'color',
                'font-family',
                'font-weight',
                'text-decoration',
                'font-style',
                'text-transform'
			)
		);
		
	}
	
	
	/**
	 * get list of allowed styles on wrap
	 */
    public static function get_allowed_styles_for_wrap(){
		
		return apply_filters('essgrid_get_allowed_styles_for_wrap',
			array(
				'display',
				'clear',
                'position',
                'text-align',
                'margin',
                'float',
                'left',
                'top',
                'right',
                'bottom'
			)
		);
		
	}
	
	
	/**
	 * get list of allowed styles on wrap
	 */
    public static function get_wait_until_output_styles(){
		
		return apply_filters('essgrid_get_wait_until_output_styles',
			array(
				'border-style' => array(
						'wait' => array('border', 'border-color', 'border-style', 'border-top-width', 'border-right-width', 'border-bottom-width', 'border-left-width'),
						'not-if' => 'none'
					),
				'border-style-hover' => array(
						'wait' => array('border-hover', 'border-color-hover', 'border-style-hover', 'border-top-width-hover', 'border-right-width-hover', 'border-bottom-width-hover', 'border-left-width-hover'),
						'not-if' => 'none'
					),
				'box-shadow' => array(
						'wait' => array('box-shadow'),
						'not-if' => array('0px 0px 0px 0px', '0)')
					),
				'-moz-box-shadow' => array(
						'wait' => array('-moz-box-shadow'),
						'not-if' => array('0px 0px 0px 0px', '0)')
					),
				'-webkit-box-shadow' => array(
						'wait' => array('-webkit-box-shadow'),
						'not-if' => array('0px 0px 0px 0px', '0)')
					),
				'text-decoration' => array(
						'wait' => array('text-decoration'),
						'not-if' => 'none'
					),
				'text-transform' => array(
						'wait' => array('text-transform'),
						'not-if' => 'none'
					),
				'font-family' => array(
						'wait' => array('font-family'),
						'not-if' => ''
					)
			)
		);
		
	}
	
	
	/**
	 * get list of allowed things on meta
	 */
    public function get_allowed_meta(){
		$base = new Essential_Grid_Base();
		
		$transitions_media = $base->get_hover_animations(true); //true will get with in/out
		
		return apply_filters('essgrid_get_allowed_meta',
			array(
				array(
					'name' => array('handle' => 'color', 'text' => __('Font Color', EG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'font-style', 'text' => __('Font Style', EG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'normal',
					'values' => array('normal'=>__('Normal', EG_TEXTDOMAIN),'italic'=>__('Italic', EG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'text-decoration', 'text' => __('Text Decoration', EG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'none',
					'values' => array('none'=>__('None', EG_TEXTDOMAIN),'underline'=>__('Underline', EG_TEXTDOMAIN),'overline'=>__('Overline', EG_TEXTDOMAIN),'line-through'=>__('Line Through', EG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'text-transform', 'text' => __('Text Transform', EG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'none',
					'values' => array('none'=>__('None', EG_TEXTDOMAIN),'capitalize'=>__('Capitalize', EG_TEXTDOMAIN),'uppercase'=>__('Uppercase', EG_TEXTDOMAIN),'lowercase'=>__('Lowercase', EG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'border-color', 'text' => __('Border Color', EG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'border-style', 'text' => __('Border Style', EG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'none',
					'values' => array('none'=>__('None', EG_TEXTDOMAIN),'solid'=>__('solid', EG_TEXTDOMAIN),'dotted'=>__('dotted', EG_TEXTDOMAIN),'dashed'=>__('dashed', EG_TEXTDOMAIN),'double'=>__('double', EG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'background', 'text' => __('Background Color', EG_TEXTDOMAIN)),
					'type' => 'text',
					'default' => 'repeat center center #FFFFFF',
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'box-shadow', 'text' => __('Box Shadow', EG_TEXTDOMAIN)),
					'type' => 'text',
					'default' => '0px 0px 0px 0px #000000',
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'transition', 'text' => __('Transition', EG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'fade',
					'values' => $transitions_media,
					'container' => 'anim'
				),
				array(
					'name' => array('handle' => 'transition-delay', 'text' => __('Transition Delay', EG_TEXTDOMAIN)),
					'type' => 'number',
					'default' => '0',
					'values' => array('0', '60', '1'),
					'container' => 'anim'
				),
				array(
					'name' => array('handle' => 'cover-bg-color', 'text' => __('Cover BG Color', EG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'layout'
				),
				array(
					'name' => array('handle' => 'cover-bg-opacity', 'text' => __('Cover BG Opacity', EG_TEXTDOMAIN)),
					'type' => 'number',
					'default' => '100',
					'container' => 'layout'
				),
				array(
					'name' => array('handle' => 'item-bg-color', 'text' => __('Item BG Color', EG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'layout'
				),
				array(
					'name' => array('handle' => 'content-bg-color', 'text' => __('Content BG Color', EG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'layout'
				)
				
			)
		);
		
	}
}