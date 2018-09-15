<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Meta {
	
	
	/**
	 * Add a new Meta 
	 */
	public function add_new_meta($new_meta){
		
		$new_meta = apply_filters('essgrid_add_new_meta', $new_meta);
		
		if(!isset($new_meta['handle']) || strlen($new_meta['handle']) < 3) return __('Wrong Handle received', EG_TEXTDOMAIN);
		if(!isset($new_meta['name']) || strlen($new_meta['name']) < 3) return __('Wrong Name received', EG_TEXTDOMAIN);
		if(!isset($new_meta['sort-type'])) $new_meta['sort-type'] = 'alphabetic';
		
		$metas = $this->get_all_meta(false);
		
		foreach($metas as $meta){
			if($meta['handle'] == $new_meta['handle']) return __('Meta with handle already exist, choose a different handle', EG_TEXTDOMAIN);
		}
		
		$new = array('handle' => $new_meta['handle'], 'name' => $new_meta['name'], 'type' => $new_meta['type'], 'sort-type' => $new_meta['sort-type'], 'default' => @$new_meta['default']);
		
		if($new_meta['type'] == 'select' || $new_meta['type'] == 'multi-select'){
			if(!isset($new_meta['sel']) || strlen($new_meta['sel']) < 3) return __('Wrong Select received', EG_TEXTDOMAIN);
			
			$new['select'] = $new_meta['sel'];
		}
		
		$metas[] = $new;
		
		$do = update_option('esg-custom-meta', apply_filters('essgrid_add_new_meta_update', $metas));
		
		return true;
	}
	
	
	/**
	 * change meta by handle
	 */
	public function edit_meta_by_handle($edit_meta){
		
		$edit_meta = apply_filters('essgrid_edit_meta_by_handle', $edit_meta);
		
		if(!isset($edit_meta['handle']) || strlen($edit_meta['handle']) < 3) return __('Wrong Handle received', EG_TEXTDOMAIN);
		if(!isset($edit_meta['name']) || strlen($edit_meta['name']) < 3) return __('Wrong Name received', EG_TEXTDOMAIN);
		
		$metas = $this->get_all_meta(false);
		
		foreach($metas as $key => $meta){
			if($meta['handle'] == $edit_meta['handle']){
				$metas[$key]['select'] = @$edit_meta['sel'];
				$metas[$key]['name'] = $edit_meta['name'];
				$metas[$key]['default'] = @$edit_meta['default'];
				$do = update_option('esg-custom-meta', apply_filters('essgrid_edit_meta_by_handle_update', $metas, $edit_meta));
				return true;
			}
		}
		
		return false;
	}
	
	
	/**
	 * Remove Meta 
	 */
	public function remove_meta_by_handle($handle){
		
		$handle = apply_filters('essgrid_remove_meta_by_handle', $handle);
		
		$metas = $this->get_all_meta(false);
		
		foreach($metas as $key => $meta){
			if($meta['handle'] == $handle){
				unset($metas[$key]);
				
				$do = update_option('esg-custom-meta', apply_filters('essgrid_remove_meta_by_handle_update', $metas));
				return true;
			}
		}
		
		return __('Meta not found! Wrong handle given.', EG_TEXTDOMAIN);
	}
	
	
	/**
	 * get all custom metas
	 */
	public function get_all_meta($links = true){
	
		$meta = get_option('esg-custom-meta', array());

		if($links === true){ //add the meta links to the array
			if(!empty($meta)){
				foreach($meta as $key => $m){
					$meta[$key]['m_type'] = 'meta';
				}
			}
			$meta_link = new Essential_Grid_Meta_Linking();
			$link_metas = $meta_link->get_all_link_meta();
			if(!empty($link_metas)){
				foreach($link_metas as $key => $m){
					$link_metas[$key]['m_type'] = 'link';
				}
			}
			$meta = array_merge($meta, $link_metas);
		}
		
		return apply_filters('essgrid_get_all_meta', $meta, $links);
	}
	
	
	/**
	 * get all handle of custom metas 
	 */
	public function get_all_meta_handle(){
		$metas = array();
		
		$meta = get_option('esg-custom-meta', array());
		
		if(!empty($meta)){
			foreach($meta as $m){
				$metas[] = 'eg-'.$m['handle'];
			}
		}
		
		if(Essential_Grid_Woocommerce::is_woo_exists()){
			$meta = Essential_Grid_Woocommerce::get_meta_array();
			
			if(!empty($meta)){
				foreach($meta as $handle => $name){
					$metas[] = $handle;
				}
			}
			
		}

		return apply_filters('essgrid_get_all_meta_handle', $metas);
	}
	
	
	/**
	 * insert comma seperated string, it will return an array of it
	 */
	public function prepare_select_by_string($string){
		
		return apply_filters('essgrid_prepare_select_by_string', explode(',', $string), $string);
		
	}
	
	
	/**
	 * check if post has meta
	 */
	public function get_meta_value_by_handle($post_id, $handle){
		if(trim($handle) === '' || intval($post_id) === 0) return '';
		
		$metas = get_post_meta($post_id,$handle,true);
		if(is_array($metas))
			$text = @$metas[$handle];
		else
			$text = $metas;
		
		//check if custom meta from us and if it is an image. If yes, output URL instead of ID
		$cmeta = $this->get_all_meta(false);
		
		if(!empty($cmeta)){
			foreach($cmeta as $me){
				if('eg-'.$me['handle'] == $handle){
					if($me['type'] == 'image'){
						if(intval($text) > 0){
							//get URL to Image
							$img = wp_get_attachment_image_src($text, 'full');
							if($img !== false){
								$text = $img[0];
							}else{
								$text = '';
							}
						}else{
							$text = '';
						}
					}
					if($text == '' && isset($me['default'])){
						$text = $me['default'];
					}
					break;
				}
			}
		}
		
		//check woocommerce
		if(Essential_Grid_Woocommerce::is_woo_exists()){
			$wc_text = Essential_Grid_Woocommerce::get_value_by_meta($post_id, $handle);
			if($wc_text !== '') $text = $wc_text;
		}
		
		if($text == ''){ //check if we have a linking
			$meta_link = new Essential_Grid_Meta_Linking();
			$text = $meta_link->get_link_meta_value_by_handle($post_id, $handle);
		}
		
		$text = str_replace('","', ',', str_replace(array('["', '"]'), '', $text));
		
		return apply_filters('essgrid_get_meta_value_by_handle', $text, $post_id, $handle);
	}
	
	
	/**
	 * replace all metas with corresponding text
	 */
	public function replace_all_meta_in_text($post_id, $text){
		if(trim($text) === '' || intval($post_id) === 0) return '';
		
		$base = new Essential_Grid_Base();
		$meta_link = new Essential_Grid_Meta_Linking();
		$cmeta = $this->get_all_meta();
		
		//process meta tags:
		$arr_matches = array();

		preg_match_all("/%[^%]*%/", $text, $arr_matches);
		
		if(!empty($arr_matches)){
			$my_post = get_post($post_id, ARRAY_A);
			
			foreach($arr_matches as $matches){
				if(is_array($matches)){
					foreach($matches as $match){
						$meta = trim(str_replace('%', '', $match));
						$meta_value = get_post_meta($post_id, $meta, true);
						if(!empty($cmeta)){
							foreach($cmeta as $me){
								if('eg-'.$me['handle'] == $meta){
									if($me['type'] == 'image'){
										if(intval($meta_value) > 0){
											//get URL to Image
											$img = wp_get_attachment_image_src($meta_value, 'full');
											if($img !== false){
												$meta_value = $img[0];
											}else{
												$meta_value = '';
											}
										}else{
											$meta_value = '';
										}
									}
									if($meta_value == '' && isset($me['default'])){
										$meta_value = $me['default'];
									}
									break;
								}
							}
						}
						
						//check woocommerce
						if(Essential_Grid_Woocommerce::is_woo_exists()){
							$wc_text = Essential_Grid_Woocommerce::get_value_by_meta($post_id, $meta);
							if($wc_text !== '') $meta_value = $wc_text;
						}
						
						if(empty($meta_value) && !empty($my_post)){ //try to get from post
							switch($meta){
								//Post elements
								case 'post_url':
									$post_id = $base->getVar($my_post, 'ID', '');
									$meta_value = get_permalink($post_id);
									break;
								case 'post_id':
									$meta_value = $base->getVar($my_post, 'ID', '');
									break;
								case 'title':
									$meta_value = $base->getVar($my_post, 'post_title', '');
									break;
								case 'caption':
								case 'excerpt':
									$meta_value = trim($base->getVar($my_post, 'post_excerpt'));
									if(empty($meta_value))
										$meta_value = trim($base->getVar($my_post, 'post_content'));
										
									$meta_value = strip_tags($meta_value); //,"<b><br><br/><i><strong><small>"
									break;
								case 'meta':
									$m = new Essential_Grid_Meta();
									$meta_value = $m->get_meta_value_by_handle($my_post['ID'],$meta);
									break;
								case 'alias':
									$meta_value = $base->getVar($my_post, 'post_name');
									break;
								case 'content':
									$meta_value = $base->getVar($my_post, 'post_content');
									break;
								case 'link':
									$meta_value = get_permalink($my_post['ID']);
									break;
								case 'date':
									$postDate = $base->getVar($my_post, "post_date_gmt");
									$meta_value = $base->convert_post_date($postDate);
									break;
								case 'date_modified':
									$dateModified = $base->getVar($my_post, "post_modified");
									$meta_value = $base->convert_post_date($dateModified);
									break;
								case 'author_name':
									$authorID = $base->getVar($my_post, 'post_author');
									$meta_value =  get_the_author_meta('display_name', $authorID);
									break;
								case 'num_comments':
									$meta_value = $base->getVar($my_post, 'comment_count');
									break;
								case 'cat_list':
									$use_taxonomies = false;
									$postCatsIDs = $base->getVar($my_post, 'post_category');
									if(empty($postCatsIDs) && isset($my_post['post_type'])){
										$postCatsIDs = array();
										$obj = get_object_taxonomies($my_post['post_type']);
										if(!empty($obj) && is_array($obj)){
											foreach($obj as $tax){
												$use_taxonomies[] = $tax;
												$new_terms = get_the_terms($my_post['ID'], $tax);
												if(is_array($new_terms) && !empty($new_terms)){
													foreach($new_terms as $term){
														$postCatsIDs[$term->term_id] = $term->term_id;
													}
												}
											}
										}
									}
									$meta_value = $base->get_categories_html_list($postCatsIDs, true, ',', $use_taxonomies);
									break;
								case 'tag_list':
									$meta_value = $base->get_tags_html_list($my_post['ID']);	
									break;
								default:
									$meta_value = apply_filters('essgrid_post_meta_content', $meta_value, $meta, $my_post['ID'], $my_post);
									break;
								break;
							}
							
							if(empty($meta_value)){ //check if its linking
								$meta_value = $meta_link->get_link_meta_value_by_handle($my_post['ID'], $meta);
							}
						}
						
						$text = str_replace($match,$meta_value,$text);
					}
				}
			}
			
			
		}
		
		$text = str_replace('","', ',', str_replace(array('["', '"]'), '', $text));
		
		return apply_filters('essgrid_replace_all_meta_in_text', $text, $post_id, $arr_matches);
	}
	
	
	/**
	 * replace all metas with corresponding text
	 */
	public function replace_all_custom_element_meta_in_text($values, $text){
		$cmeta = $this->get_all_meta();
		
		//process meta tags:
		$arr_matches = array();

		preg_match_all("/%[^%]*%/", $text, $arr_matches);
		
		if(!empty($arr_matches)){
			foreach($arr_matches as $matches){
				if(is_array($matches)){
					foreach($matches as $match){
						$meta = str_replace('%', '', $match);
						$meta_value = @$values[$meta];
						
						if(!empty($cmeta)){
							foreach($cmeta as $me){
								if('eg-'.$me['handle'] == $meta){
									if($me['type'] == 'image'){
										if(intval($meta_value) > 0){
											//get URL to Image
											$img = wp_get_attachment_image_src($meta_value, 'full');
											if($img !== false){
												$meta_value = $img[0];
											}else{
												$meta_value = '';
											}
										}else{
											$meta_value = '';
										}
									}
									break;
								}
							}
						}
						
						$text = str_replace($match,$meta_value,$text);
					}
				}
			}
		}
		
		return apply_filters('essgrid_replace_all_custom_element_meta_in_text', $text, $values, $arr_matches);
	}
	
	
	/**
	 * get video ratios from post
	 */
	public function get_post_video_ratios($post_id){
	
		$ratio['vimeo'] = get_post_meta($post_id, 'eg_vimeo_ratio', true);
		$ratio['youtube'] = get_post_meta($post_id, 'eg_youtube_ratio', true);
		$ratio['wistia'] = get_post_meta($post_id, 'eg_wistia_ratio', true);
		$ratio['html5'] = get_post_meta($post_id, 'eg_html5_ratio', true);
		$ratio['soundcloud'] = get_post_meta($post_id, 'eg_soundcloud_ratio', true);
		
		return apply_filters('essgrid_get_post_video_ratios', $ratio, $post_id);
	}
	
	
	/**
	 * get video ratios from custom element
	 */
	public function get_custom_video_ratios($values){
		if(!isset($values['custom-ratio'])) $values['custom-ratio'] = '0';
		
		$ratio['vimeo'] = $values['custom-ratio'];
		$ratio['youtube'] = $values['custom-ratio'];
		$ratio['wistia'] = $values['custom-ratio'];
		$ratio['html5'] = $values['custom-ratio'];
		$ratio['soundcloud'] = $values['custom-ratio'];
		
		return apply_filters('essgrid_get_custom_video_ratios', $ratio, $values);
	}
	
}


/**
 * Essential_Grid_Meta_Linking
 * @since: 1.5.0
 **/
class Essential_Grid_Meta_Linking {
	
	/**
	 * Add a new Meta 
	 */
	public function add_new_link_meta($new_meta){
		
		if(!isset($new_meta['handle']) || strlen($new_meta['handle']) < 3) return __('Wrong Handle received', EG_TEXTDOMAIN);
		if(!isset($new_meta['name']) || strlen($new_meta['name']) < 3) return __('Wrong Name received', EG_TEXTDOMAIN);
		if(!isset($new_meta['original']) || strlen($new_meta['original']) < 3) return __('Wrong Linking received', EG_TEXTDOMAIN);
		
		if(!isset($new_meta['sort-type'])) $new_meta['sort-type'] = 'alphabetic';
		
		$metas = $this->get_all_link_meta();
		
		foreach($metas as $meta){
			if($meta['handle'] == $new_meta['handle']) return __('Meta with handle already exist, choose a different handle', EG_TEXTDOMAIN);
		}
		
		$new = array('handle' => $new_meta['handle'], 'name' => $new_meta['name'], 'sort-type' => $new_meta['sort-type'], 'original' => $new_meta['original']);
		
		$metas[] = $new;
		
		$do = update_option('esg-custom-link-meta', apply_filters('essgrid_add_new_link_meta', $metas, $new_meta, $new));
		
		return true;
	}
	
	
	/**
	 * change meta by handle
	 */
	public function edit_link_meta_by_handle($edit_meta){
		
		if(!isset($edit_meta['handle']) || strlen($edit_meta['handle']) < 3) return __('Wrong Handle received', EG_TEXTDOMAIN);
		if(!isset($edit_meta['name']) || strlen($edit_meta['name']) < 3) return __('Wrong Name received', EG_TEXTDOMAIN);
		if(!isset($edit_meta['original']) || strlen($edit_meta['original']) < 3) return __('Wrong Linking received', EG_TEXTDOMAIN);
		
		$metas = $this->get_all_link_meta();
		
		foreach($metas as $key => $meta){
			if($meta['handle'] == $edit_meta['handle']){
				$before = $metas[$key];
				$metas[$key]['name'] = $edit_meta['name'];
				$metas[$key]['original'] = @$edit_meta['original'];
				$do = update_option('esg-custom-link-meta', apply_filters('essgrid_edit_link_meta_by_handle', $metas, $edit_meta, $before));
				return true;
			}
		}
		
		return false;
	}
	
	
	/**
	 * Remove Meta 
	 */
	public function remove_link_meta_by_handle($handle){
		
		$metas = $this->get_all_link_meta();
		
		foreach($metas as $key => $meta){
			if($meta['handle'] == $handle){
				$before = $metas[$key];
				unset($metas[$key]);
				$do = update_option('esg-custom-link-meta', apply_filters('essgrid_edit_link_meta_by_handle', $metas, $handle, $before));
				return true;
			}
		}
		
		return __('Meta not found! Wrong handle given.', EG_TEXTDOMAIN);
	}
	
	
	/**
	 * get all custom metas
	 */
	public function get_all_link_meta(){
	
		$meta = get_option('esg-custom-link-meta', array());
		
		return apply_filters('essgrid_get_all_link_meta', $meta);
	}
	
	
	/**
	 * get all handle of custom metas 
	 */
	public function get_all_link_meta_handle(){
		$metas = array();
		
		$meta = get_option('esg-custom-link-meta', array());
		
		if(!empty($meta)){
			foreach($meta as $m){
				$metas[] = 'egl-'.$m['handle'];
			}
		}
		
		return apply_filters('essgrid_get_all_link_meta_handle', $metas);
	}
	
	
	/**
	 * translate by handle to original handle and get the value
	 */
	public function get_link_meta_value_by_handle($post_id, $handle){
		if(trim($handle) === '' || intval($post_id) === 0) return '';
		
		$orig = false;
		
		$metas = $this->get_all_link_meta();
		
		if(!empty($metas)){
			foreach($metas as $m){
				if($handle == 'egl-'.$m['handle']){
					$orig = $m['original'];
					break;
				}
			}
		}
		
		if($orig === false) return '';
		
		$metas = get_post_meta($post_id,$orig,true);
		if(is_array($metas))
			$text = @$metas[$orig];
		else
			$text = $metas;
		
		return apply_filters('essgrid_get_link_meta_value_by_handle', $text, $post_id, $handle);
	}
	
}

?>