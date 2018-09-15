<?php
/**
 * Essential Grid.
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$esg_c_sort_direction = 'ASC';
$esg_c_sort_handle = 'title';
$esg_grid_serial = 0;
$esg_is_inited = false;

class Essential_Grid {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 */
	const VERSION = '2.1.0.2';
	const TABLE_GRID = 'eg_grids';
	const TABLE_ITEM_SKIN = 'eg_item_skins';
	const TABLE_ITEM_ELEMENTS = 'eg_item_elements';
	const TABLE_NAVIGATION_SKINS = 'eg_navigation_skins';
	
	private $grid_api_name = null;
	private $grid_div_name = null;
	private $grid_id = 0; //set to 0 at beginning for quick grids @since 2.0.2
	private $grid_name = null;
	private $grid_handle = null;
	private $grid_params = array();
	private $grid_postparams = array();
	private $grid_layers = array();
	private $grid_settings = array();
	private $grid_last_mod = '';
	private $grid_inline_js = '';
	
	public $custom_settings = null;
	public $custom_layers = null;
	public $custom_images = null;
	public $custom_posts = null;
	public $custom_special = null;
	
	//other changings
	private $filter_by_ids = array();
	private $load_more_post_array = array();
	
	/**
	 * Unique identifier for the plugin.
	 * The variable name is used as the text domain when internationalizing strings of text.
	 */
	protected $plugin_slug = 'essential-grid';

	
	/**
	 * Instance of this class.
	 */
	protected static $instance = null;

	
	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 */
	public function __construct() {
		global $esg_is_inited;
		
		if(!$esg_is_inited){
		
			$esg_is_inited = true;
			
			// Load plugin text domain
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
			
			$add_cpt = apply_filters('essgrid_set_cpt', get_option('tp_eg_enable_custom_post_type', 'true'));
			
			if($add_cpt == 'true' || $add_cpt === true)
				add_action( 'init', array( $this, 'register_custom_post_type' ) );
			
			// Load public-facing style sheet and JavaScript.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			
			add_action('wp_ajax_Essential_Grid_Front_request_ajax', array($this, 'on_front_ajax_action'));
			add_action('wp_ajax_nopriv_Essential_Grid_Front_request_ajax', array($this, 'on_front_ajax_action')); //for not logged in users
			
			//Gallery
			$gallery = get_option('tp_eg_overwrite_gallery','');
			if( !empty($gallery) && $gallery != "off"  ){
				remove_shortcode('gallery', 'gallery_shortcode');
				add_shortcode('gallery', array($this,'ess_grid_addon_gallery'),10,2);
			}

			//Woo Add to Cart Updater
			add_filter('add_to_cart_fragments', array('Essential_Grid_Woocommerce','woocommerce_header_add_to_cart_fragment'));
		}
	}

	
	/**
	 * Return the plugin slug.
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	
	/**
	 * Return an instance of this class.
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasnt been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}

	
	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters('plugin_locale', get_locale(), $domain );
		
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		
		load_plugin_textdomain( $domain, FALSE, dirname(dirname(plugin_basename( __FILE__ ))) . '/languages/' );
		//load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		
		do_action('essgrid_load_plugin_textdomain', $domain);
	}

	
	/**
	 * Register and enqueue public-facing style sheet.
	 */
	public function enqueue_styles() {
		
		$use_cache = (get_option('tp_eg_use_cache', 'false') == 'true') ? true : false;
		wp_register_style($this->plugin_slug . '-plugin-settings', EG_PLUGIN_URL . 'public/assets/css/settings.css', array(), self::VERSION);
		wp_enqueue_style( $this->plugin_slug .'-plugin-settings' );
		
		$font = new ThemePunch_Fonts();
		$font->register_fonts();
		
		wp_register_style('themepunchboxextcss', EG_PLUGIN_URL . 'public/assets/css/lightbox.css', array(), self::VERSION);
		
		// Enqueue Lightbox Style/Script
		if($use_cache){ 
			wp_enqueue_style('themepunchboxextcss');
		}

		do_action('essgrid_enqueue_styles', $use_cache, self::VERSION);
		
	}

	
	/**
	 * Register and enqueues public-facing JavaScript files.
	 */
	public function enqueue_scripts() {
		$use_cache = (get_option('tp_eg_use_cache', 'false') == 'true') ? true : false;
		$js_to_footer = (get_option('tp_eg_js_to_footer', 'false') == 'true') ? true : false;
		$enable_log = (get_option('tp_eg_enable_log', 'false') == 'true') ? true : false;
		
		wp_register_script( 'themepunchboxext', EG_PLUGIN_URL . 'public/assets/js/lightbox.js', array('jquery'), self::VERSION, $js_to_footer);
		
		$waitfor = array( 'jquery', 'themepunchboxext' );
		
		if($enable_log) wp_enqueue_script( 'enable-logs', EG_PLUGIN_URL . 'public/assets/js/jquery.themepunch.enablelog.js', $waitfor, self::VERSION, $js_to_footer );
		
		wp_register_script( 'tp-tools', EG_PLUGIN_URL . 'public/assets/js/jquery.themepunch.tools.min.js', $waitfor, self::VERSION, $js_to_footer );
		wp_register_script( $this->plugin_slug . '-essential-grid-script', EG_PLUGIN_URL . 'public/assets/js/jquery.themepunch.essential.min.js', array( 'jquery', 'tp-tools' ), self::VERSION, $js_to_footer );
		
		do_action('essgrid_enqueue_scripts', $use_cache, self::VERSION, $js_to_footer);
	}
	
	
	/**
	 * Register Shortcode
	 */
	public static function register_shortcode($args, $mid_content=null){
		//$dbg = new EssGridMemoryUsageInformation();
		//$dbg->setStart();
		//$dbg->setMemoryUsage('Before ShortCode');
		
		$args = apply_filters('essgrid_register_shortcode_pre', $args);
		
		$caching = get_option('tp_eg_use_cache', 'false');
		$use_cache = $caching == 'true' ? true : false;

		// Enqueue Scripts
		wp_enqueue_script( 'tp-tools' );
		wp_enqueue_script( 'essential-grid-essential-grid-script' );
		
		// Enqueue Lightbox Style/Script
		if($use_cache){ 
			wp_enqueue_script( 'themepunchboxext' );
		}

		$grid = new Essential_Grid;
		extract(shortcode_atts(array('alias' => '', 'settings' => '', 'layers' => '', 'images' => '', 'posts' => '', 'special' => ''), $args, 'ess_grid'));
        $eg_alias = ($alias != '') ? $alias : implode(' ', $args);
		
		if($settings !== '') $grid->custom_settings = json_decode(str_replace(array('({', '})', "'"), array('[', ']', '"'), $settings) ,true);
		if($layers !== '') $grid->custom_layers = json_decode(str_replace(array('({', '})', "'"), array('[', ']', '"'), $layers),true);
		if($images !== '') $grid->custom_images = explode(',', $images);
		if($posts !== '') $grid->custom_posts = explode(',', $posts);
		if($special !== '') $grid->custom_special = $special;
		
		if($settings !== '' || $layers !== '' || $images !== '' || $posts !== '' || $special !== ''){ //disable caching if one of this is set
			$caching = 'false';
		}
		
		$grid->check_for_shortcodes($mid_content); //check for example on gallery shortcode and do stuff
		
		if($eg_alias == '')
			$eg_alias = implode(' ', $args);
		
		$content = false;
		$grid_id = self::get_id_by_alias($eg_alias);
		
		if($grid_id == '0'){ //grid is created by custom settings. Check if layers and settings are set
			ob_start();
			$grid->output_essential_grid_by_settings();
			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
		}else{
		
			if($caching == 'true'){ //check if we use total caching
				//add wpml transient
				$lang_code = '';
				if(Essential_Grid_Wpml::is_wpml_exists()){
					$lang_code = Essential_Grid_Wpml::get_current_lang_code();
				}
				
				$content = get_transient( 'ess_grid_trans_full_grid_'.$grid_id.$lang_code );
			}
			
			if($content == false){
				ob_start();
				$grid->output_essential_grid_by_alias($eg_alias);
				$content = ob_get_contents();
				ob_clean();
				ob_end_clean();
				
				if($caching == 'true'){
					set_transient( 'ess_grid_trans_full_grid_'.$grid_id.$lang_code, $content, 60*60*24*7 );
				}
			}
			
		}
		
		$output_protection = get_option('tp_eg_output_protection', 'none');
		
		//$dbg->setMemoryUsage('After ShortCode');
		//$dbg->setEnd();
		//$dbg->printMemoryUsageInformation();
		
		//handle output types
		switch($output_protection){
			case 'compress':
				$content = str_replace("\n", '', $content);
				$content = str_replace("\r", '', $content);
				return($content);
			break;
			case 'echo':
				echo $content;		//bypass the filters
			break;
			default: //normal output
				return($content);
			break;
		}
		
	}
	
	
	/**
	 * Register Shortcode For Ajax Content
	 * @since: 1.5.0
	 */
	public static function register_shortcode_ajax_target($args, $mid_content=null){
		$args = apply_filters('essgrid_register_shortcode_ajax_target_pre', $args);

		extract(shortcode_atts(array('alias' => ''), $args, 'ess_grid_ajax_target'));
        
		if($alias == '') return false; //no alias found
		
		$output_protection = get_option('tp_eg_output_protection', 'none');

		$content = '';
		
		$grid = new Essential_Grid;
		
		$grid_id = self::get_id_by_alias($alias);
		if($grid_id > 0){
			
			$grid->init_by_id($grid_id);
			//check if shortcode is allowed
			
			$is_sc_allowed = $grid->get_param_by_handle('ajax-container-position');
			if($is_sc_allowed != 'shortcode') return false;
			
			$content = $grid->output_ajax_container();
			
		}
		
		//handle output types
		switch($output_protection){
			case 'compress':
				$content = str_replace("\n", '', $content);
				$content = str_replace("\r", '', $content);
				return($content);
			break;
			case 'echo':
				echo $content;		//bypass the filters
			break;
			default: //normal output
				return($content);
			break;
		}
		
	}
	
	
	/**
	 * Register Shortcode For Filter
	 * @since: 1.5.0
	 */
	public static function register_shortcode_filter($args, $mid_content=null){
		$args = apply_filters('essgrid_register_shortcode_filter_pre', $args);

		extract(shortcode_atts(array('alias' => '', 'id' => ''), $args, 'ess_grid_nav'));
		
		if($alias == '') return false; //no alias found
		if($id == '') return false; //no alias found
		$base = new Essential_Grid_Base();
		$meta_c = new Essential_Grid_Meta();
		$meta_link_c = new Essential_Grid_Meta_Linking();
		
		$output_protection = get_option('tp_eg_output_protection', 'none');

		$content = '';
		
		ob_start();
		
		$grid = new Essential_Grid;
		
		$grid_id = self::get_id_by_alias($alias);
		
		if($grid_id > 0){
			$navigation_c = new Essential_Grid_Navigation($grid_id);
			
			$grid->init_by_id($grid_id);
			
			$layout = $grid->get_param_by_handle('navigation-layout', array());
			$navig_special_class = $grid->get_param_by_handle('navigation-special-class', array()); //has all classes in an ordered list
			$navig_special_skin = $grid->get_param_by_handle('navigation-special-skin', array()); //has all classes in an ordered list
			
			$special_class = '';
			$special_skin = '';
			
			if($id == 'sort') $id = 'sorting';
			
			//Check if selected element is in external list and also get the key to use it to get class
			if(isset($layout[$id]) && isset($layout[$id]['external'])){
				$special_class = @$navig_special_class[$layout[$id]['external']];
				$special_skin = @$navig_special_skin[$layout[$id]['external']];
			}else{ //its not in external set so break since its only allowed to use each element one time
				return false;
			}
			
			$navigation_c->set_special_class($special_class);
			$navigation_c->set_special_class($special_skin);
			$navigation_c->set_special_class('esg-fgc-'.$grid_id);
			
			$filter = false;
			switch($id){
				case 'sorting':
					$order_by_start = $grid->get_param_by_handle('sorting-order-by-start', 'none');
					$sort_by_text = $grid->get_param_by_handle('sort-by-text', __('Sort By ', EG_TEXTDOMAIN));
					$order_by = explode(',', $grid->get_param_by_handle('sorting-order-by', 'date'));
					if(!is_array($order_by)) $order_by = array($order_by);
					//set order of filter
					$navigation_c->set_orders_text($sort_by_text);
					$navigation_c->set_orders_start($order_by_start);
					$navigation_c->set_orders($order_by); 
					$navigation_c->output_sorting();
				break;
				case 'cart':
					$navigation_c->output_cart();
				break;
				case 'left':
					$navigation_c->output_navigation_left();
				break;
				case 'right':
					$navigation_c->output_navigation_right();
				break;
				case 'pagination':
					$navigation_c->output_pagination();
				break;
				case 'search-input':
					$search_text = $grid->get_param_by_handle('search-text', __('Search...', EG_TEXTDOMAIN));
					$navigation_c->set_search_text($search_text);
					$navigation_c->output_search_input();
				break;
				case 'filter':
					$id = 1;
					$filter = true;
				break;
				default:
					//check for filter
					if(strpos($id, 'filter-') !== false){
						$id = intval(str_replace('filter-', '', $id));
						$filter = true;
					}else{
						return false;
					}
				break;
			}
			
			/*****
			 * Complex Filter Part
			 *****/
			$found_filter = array();
			 
			if($filter === true){
				switch($grid->get_postparam_by_handle('source-type')){
					case 'custom':
						
						if(!empty($grid->grid_layers) && count($grid->grid_layers) > 0){
							foreach($grid->grid_layers as $key => $entry){
								
								$filters = array();
								
								if(!empty($entry['custom-filter'])){
									$cats = explode(',', $entry['custom-filter']);
									if(!is_array($cats)) $cats = (array)$cats;
									foreach($cats as $category){
										$filters[sanitize_key($category)] = array('name' => $category, 'slug' => sanitize_key($category));
									}
								}
								
								$found_filter = $found_filter + $filters; //these are the found filters, only show filter that the posts have
								
							}
						}
					break;
					case 'post':
						$start_sortby = $grid->get_param_by_handle('sorting-order-by-start', 'none');
						$start_sortby_type = $grid->get_param_by_handle('sorting-order-type', 'ASC');
						$post_category = $grid->get_postparam_by_handle('post_category');
						$post_types = $grid->get_postparam_by_handle('post_types');
						$page_ids = explode(',',  $grid->get_postparam_by_handle('selected_pages', '-1'));
						
						$cat_relation = $grid->get_postparam_by_handle('category-relation',  'OR');
						
						$max_entries = $grid->get_maximum_entries($grid);
						
						$additional_query = $grid->get_postparam_by_handle('additional-query', '');
						if($additional_query !== '')
							$additional_query = wp_parse_args($additional_query);

						$cat_tax = Essential_Grid_Base::getCatAndTaxData($post_category);

						$posts = Essential_Grid_Base::getPostsByCategory($grid_id, $cat_tax['cats'], $post_types, $cat_tax['tax'], $page_ids, $start_sortby, $start_sortby_type, $max_entries, $additional_query, true, $cat_relation);
					
						$nav_filters = array();
						
						$taxes = array('post_tag');
						if(!empty($cat_tax['tax']))
							$taxes = explode(',', $cat_tax['tax']);
							
						if(!empty($cat_tax['cats'])){
							$cats = explode(',', $cat_tax['cats']);

							foreach($cats as $key => $cid){
								if(Essential_Grid_Wpml::is_wpml_exists() && isset($sitepress)){
									$new_id = icl_object_id($cid, 'category', true, $sitepress->get_default_language());
									$cat = get_category($new_id);
								}else{
									$cat = get_category($cid);
								}
								if(is_object($cat)){
									$nav_filters[$cid] = array('name' => $cat->cat_name, 'slug' => sanitize_key($cat->slug), 'parent' => $cat->category_parent);
								}
								
								foreach($taxes as $custom_tax){
									$term = get_term_by('id', $cid, $custom_tax);
									if(is_object($term)) $nav_filters[$cid] = array('name' => $term->name, 'slug' => sanitize_key($term->slug), 'parent' => $term->parent);
								}
							}
							
							if(!empty($filters_meta)){
								$nav_filters = $filters_meta + $nav_filters;
							}
							asort($nav_filters);
						}
						
						if($id == 1){
							$all_text = $grid->get_param_by_handle('filter-all-text');
							$listing_type = $grid->get_param_by_handle('filter-listing', 'list');
							$listing_text = $grid->get_param_by_handle('filter-dropdown-text');
							$show_count = $grid->get_param_by_handle('filter-counter', 'off');
							$selected = $grid->get_param_by_handle('filter-selected', array());
						}else{
							$all_text = $grid->get_param_by_handle('filter-all-text-'.$id);
							$listing_type = $grid->get_param_by_handle('filter-listing-'.$id, 'list');
							$listing_text = $grid->get_param_by_handle('filter-dropdown-text-'.$id);
							$show_count = $grid->get_param_by_handle('filter-counter-'.$id, 'off');
							$selected = $grid->get_param_by_handle('filter-selected-'.$id, array());
						}
						$filter_allow = $grid->get_param_by_handle('filter-arrows', 'single');
						$filter_start = $grid->get_param_by_handle('filter-start', '');
						$filter_grouping = $grid->get_param_by_handle('filter-grouping', 'false');
						
						//check the selected and change metas to correct fields
						$filters_arr['filter-grouping'] = $filter_grouping;
						$filters_arr['filter-listing'] = $listing_type;
						$filters_arr['filter-selected'] = $selected;
						
						if(!empty($filters_arr['filter-selected'])){
							if(!empty($posts) && count($posts) > 0){
								foreach($filters_arr['filter-selected'] as $fk => $filter){
									if(strpos($filter, 'meta-') === 0){
										unset($filters_arr['filter-selected'][$fk]); //delete entry
										
										foreach($posts as $key => $post){
											$fil = str_replace('meta-', '', $filter);
											$post_filter_meta = $meta_c->get_meta_value_by_handle($post['ID'], 'eg-'.$fil);
											$arr = json_decode($post_filter_meta, true);
											$cur_filter = (is_array($arr)) ? $arr : array($post_filter_meta);
											//$cur_filter = explode(',', $post_filter_meta);
											$add_filter = array();
											if(!empty($cur_filter)){
												foreach($cur_filter as $k => $v){
													if(trim($v) !== ''){
														$add_filter[sanitize_key($v)] = array('name' => $v, 'slug' => sanitize_key($v), 'parent' => '0');
														if(!empty($filters_arr['filter-selected'])){
															$filter_found = false;
															foreach($filters_arr['filter-selected'] as $fcheck){
																if($fcheck == sanitize_key($v)){
																	$filter_found = true;
																	break;
																}
															}
															if(!$filter_found){
																$filters_arr['filter-selected'][] = sanitize_key($v); //add found meta
															}
														}else{
															$filters_arr['filter-selected'][] = sanitize_key($v); //add found meta
														}
													}
												}
												if(!empty($add_filter)) $navigation_c->set_filter($add_filter);
											}
										}
									}
								}
							}
						}
						
						if($all_text == '' || $listing_type == '' || $listing_text == '' || empty($filters_arr['filter-selected'])) return false;
						
						$navigation_c->set_filter_settings('filter', $filters_arr);
						$navigation_c->set_filter_text($all_text);
						$navigation_c->set_dropdown_text($listing_text);
						$navigation_c->set_show_count($show_count);
						$navigation_c->set_filter_type($filter_allow);
						$navigation_c->set_filter_start_select($filter_start);
						
						if(!empty($posts) && count($posts) > 0){
							foreach($posts as $key => $post){
							
								//check if post should be visible or if its invisible on current grid settings
								$is_visible = $grid->check_if_visible($post['ID'], $grid_id);
								if($is_visible == false) continue; // continue if invisible
								
								$filters = array();
								
								//$categories = get_the_category($post['ID']);
								$categories = $base->get_custom_taxonomies_by_post_id($post['ID']);
								//$tags = wp_get_post_terms($post['ID']);
								$tags = get_the_tags($post['ID']);
								
								if(!empty($categories)){
									foreach($categories as $key => $category){
										$filters[$category->term_id] = array('name' => $category->name, 'slug' => sanitize_key($category->slug), 'parent' => $category->parent);
									}
								}
								
								if(!empty($tags)){
									foreach($tags as $key => $taxonomie){
										$filters[$taxonomie->term_id] = array('name' => $taxonomie->name, 'slug' => sanitize_key($taxonomie->slug), 'parent' => '0');
									}
								}
								
								$filter_meta_selected = $grid->get_param_by_handle('filter-selected', array());
								if(!empty($filter_meta_selected)){
									foreach($filter_meta_selected as $filter){
										if(strpos($filter, 'meta-') === 0){
											$fil = str_replace('meta-', '', $filter);
											$post_filter_meta = $meta_c->get_meta_value_by_handle($post['ID'], 'eg-'.$fil);
											$arr = json_decode($post_filter_meta, true);
											$cur_filter = (is_array($arr)) ? $arr : array($post_filter_meta);
											//$cur_filter = explode(',', $post_filter_meta);
											if(!empty($cur_filter)){
												foreach($cur_filter as $k => $v){
													if(trim($v) !== '')
														$filters[sanitize_key($v)] = array('name' => $v, 'slug' => sanitize_key($v), 'parent' => '0');
												}
											}
										}
									}
								}
								
								$found_filter = $found_filter + $filters; //these are the found filters, only show filter that the posts have
								
							}
						}
						
						$remove_filter = array_diff_key($nav_filters, $found_filter); //check if we have filter that no post has (comes through multilanguage)
						if(!empty($remove_filter)){
							foreach($remove_filter as $key => $rem){ //we have, so remove them from the filter list before setting the filter list
								unset($found_filter[$key]);
							}
						}
					break;
				}
				
				$navigation_c->set_filter($found_filter); //set filters $nav_filters $found_filter
			
				echo $navigation_c->output_filter_unwrapped();
				
			}
			
		}
		
		$content = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		//handle output types
		switch($output_protection){
			case 'compress':
				$content = str_replace("\n", '', $content);
				$content = str_replace("\r", '', $content);
				return($content);
			break;
			case 'echo':
				echo $content;		//bypass the filters
			break;
			default: //normal output
				return($content);
			break;
		}
	}
	
	
	/**
	 * We check the content for gallery shortcode. 
	 * If existing, create Grid based on the images
	 * @since: 1.2.0
	 * @moved: 1.5.4: moved to Essential_Grid_Base->get_all_gallery_images($mid_content);
	 **/
	public function check_for_shortcodes($mid_content){
		$mid_content = apply_filters('essgrid_check_for_shortcodes', $mid_content);

		$base = new Essential_Grid_Base();
		
		$img = $base->get_all_gallery_images($mid_content);
		
		$this->custom_images = (empty($img)) ? null : $img;
		
	}
	
	
	public static function fix_shortcodes($content){
		$content = apply_filters('essgrid_fix_shortcodes_pre', $content);

		$columns = array("ess_grid");
		$block = join("|",$columns);

		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)/","[/$2]",$rep);

		return apply_filters('essgrid_fix_shortcodes_post', $rep);
	}
	
	
	/**
	 * Register Custom Post Type & Taxonomy
	 */
	public function register_custom_post_type() {
		$postType = apply_filters('essgrid_PunchPost_custom_post_type', 'essential_grid');
		$taxonomy = apply_filters('essgrid_PunchPost_category', 'essential_grid_category');
		
		$taxArgs = array();
		$taxArgs["hierarchical"] = true;
		$taxArgs["label"] = __("Custom Categories", EG_TEXTDOMAIN);
		$taxArgs["singular_label"] = __("Custom Categorie", EG_TEXTDOMAIN);
		$taxArgs["rewrite"] = true;
		$taxArgs["public"] = true;
		$taxArgs["show_admin_column"] = true;
		
		$postArgs = array();
		$postArgs["label"] = __("Ess. Grid Example Posts", EG_TEXTDOMAIN);
		$postArgs["singular_label"] = __("Ess. Grid Post", EG_TEXTDOMAIN);
		$postArgs["public"] = true;
		$postArgs["capability_type"] = "post";
		$postArgs["hierarchical"] = false;
		$postArgs["show_ui"] = true;
		$postArgs["show_in_menu"] = true;
		$postArgs["supports"] = array('title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt');			
		$postArgs["show_in_admin_bar"] = false;			
		$postArgs["taxonomies"] = array($taxonomy, 'post_tag');
		
		$postArgs["rewrite"] = array("slug"=>$postType,"with_front"=>true);
		
		$d = apply_filters('essgrid_register_custom_post_type', array('postArgs' => $postArgs, 'taxArgs' => $taxArgs));
		$postArgs = $d['postArgs'];
		$taxArgs = $d['taxArgs'];
		
		register_taxonomy($taxonomy,array($postType),$taxArgs); 
		register_post_type($postType,$postArgs);
		
	}
	
	
	/**
	 * Create/Update Database Tables
	 */
	public static function create_tables($networkwide = false){
		global $wpdb;
		
		if(function_exists('is_multisite') && is_multisite() && $networkwide){ //do for each existing site
		
			$old_blog = $wpdb->blogid;
			
            // Get all blog ids and create tables
			$blogids = $wpdb->get_col("SELECT blog_id FROM ".$wpdb->blogs);
			
            foreach($blogids as $blog_id){
				switch_to_blog($blog_id);
				self::_create_tables();
            }
			
            switch_to_blog($old_blog); //go back to correct blog
			
		}else{  //no multisite, do normal installation
		
			self::_create_tables();
			
		}
		
	}
	
	
	/**
	 * Create Tables, edited for multisite
	 * @since 1.5.0
	 */
	public static function _create_tables(){
		
		global $wpdb;
		
		$charset_collate = $wpdb->get_charset_collate();
		
		//Create/Update Grids Database
		$grid_ver = get_option("tp_eg_grids_version", '0.99');
		
		if(version_compare($grid_ver, '1', '<')){
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$table_name = $wpdb->prefix . self::TABLE_GRID;
			$sql = "CREATE TABLE $table_name (
				  id mediumint(6) NOT NULL AUTO_INCREMENT,
				  name VARCHAR(191) NOT NULL,
				  handle VARCHAR(191) NOT NULL,
				  postparams TEXT NOT NULL,
				  params TEXT NOT NULL,
				  layers TEXT NOT NULL,
				  UNIQUE KEY id (id),
				  UNIQUE (handle)
				  ) $charset_collate;";
				  
			dbDelta($sql);
			
			$table_name = $wpdb->prefix . self::TABLE_ITEM_SKIN;
			$sql = "CREATE TABLE $table_name (
				  id mediumint(6) NOT NULL AUTO_INCREMENT,
				  name VARCHAR(191) NOT NULL,
				  handle VARCHAR(191) NOT NULL,
				  params TEXT NOT NULL,
				  layers TEXT NOT NULL,
				  settings TEXT,
				  UNIQUE KEY id (id),
				  UNIQUE (name),
				  UNIQUE (handle)
				  ) $charset_collate;";
			
			dbDelta($sql);
			
			$table_name = $wpdb->prefix . self::TABLE_ITEM_ELEMENTS;
			$sql = "CREATE TABLE $table_name (
				  id mediumint(6) NOT NULL AUTO_INCREMENT,
				  name VARCHAR(191) NOT NULL,
				  handle VARCHAR(191) NOT NULL,
				  settings TEXT NOT NULL,
				  UNIQUE KEY id (id),
				  UNIQUE (handle)
				  ) $charset_collate;";
				  
			dbDelta($sql);
			
			$table_name = $wpdb->prefix . self::TABLE_NAVIGATION_SKINS;
			$sql = "CREATE TABLE $table_name (
				  id mediumint(6) NOT NULL AUTO_INCREMENT,
				  name VARCHAR(191) NOT NULL,
				  handle VARCHAR(191) NOT NULL,
				  css TEXT NOT NULL,
				  UNIQUE KEY id (id),
				  UNIQUE (handle)
				  ) $charset_collate;";
			
			dbDelta($sql);

			update_option('tp_eg_grids_version', '1');
			
			$grid_ver = '1';
		}
		
		//Change database on certain release? No Problem, use the following:
		
		//change layers to MEDIUMTEXT from TEXT so that more layers can be added (fix for limited entries on custom grids)
		if(version_compare($grid_ver, '1.02', '<')){
			
			$table_name = $wpdb->prefix . self::TABLE_GRID;
			$sql = "CREATE TABLE $table_name (
				  layers MEDIUMTEXT NOT NULL
				  ) $charset_collate;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		 
			update_option('tp_eg_grids_version', '1.02');
			
			$grid_ver = '1.02';
			
		}
		
		//change more entries to MEDIUMTEXT so that can be stored to prevent loss of data/errors
		if(version_compare($grid_ver, '1.03', '<')){
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$table_name = $wpdb->prefix . self::TABLE_ITEM_SKIN;
			$sql = "CREATE TABLE $table_name (
				  layers MEDIUMTEXT NOT NULL
				  ) $charset_collate;";
				  
			dbDelta($sql);
			
			$table_name = $wpdb->prefix . self::TABLE_NAVIGATION_SKINS;
			$sql = "CREATE TABLE $table_name (
				  css MEDIUMTEXT NOT NULL
				  ) $charset_collate;";
				  
			dbDelta($sql);
			
			$table_name = $wpdb->prefix . self::TABLE_ITEM_ELEMENTS;
			$sql = "CREATE TABLE $table_name (
				  settings MEDIUMTEXT NOT NULL
				  ) $charset_collate;";
				  
			dbDelta($sql);
			
			update_option('tp_eg_grids_version', '1.03');
			
			$grid_ver = '1.03';
		}
		
		//Add new column settings, as for 2.0 you can add favorite grids
		if(version_compare($grid_ver, '2.1', '<')){
			$table_name = $wpdb->prefix . self::TABLE_GRID;
			$sql = "CREATE TABLE $table_name (
				  settings TEXT NULL
				  last_modified DATETIME
				  ) $charset_collate;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			update_option('tp_eg_grids_version', '2.1');
			
			$grid_ver = '2.1';
		}
		
		do_action('essgrid__create_tables', $grid_ver);
		
	}
	
	
	/**
	 * Register Custom Sidebars, created in Grids
	 * @since 1.0.6
	 */
	public static function register_custom_sidebars(){
	
		// Register custom Sidebars
		$sidebars = apply_filters('essgrid_register_custom_sidebars', get_option('esg-widget-areas', false));

		if(is_array($sidebars) && !empty($sidebars)){
			foreach($sidebars as $handle => $name){
				register_sidebar(
					array (
						'name'          => $name,
						'id'            => 'eg-'.$handle,
						'before_widget' => '',
						'after_widget'  => ''
					)
				);
			}
		}
	}
	
	
	/**
	 * Get all Grids in Database
	 */
	public static function get_essential_grids($order = false){
		global $wpdb;
		
		$order_fav = false;
		$additional = '';
		if($order !== false && !empty($order)){
			$ordertype = key($order);
			$orderby = reset($order);
			if($ordertype != 'favorite'){
				$additional .= ' ORDER BY '.$ordertype.' '.$orderby;
			}else{
				$order_fav = true;
			}
		}
		
		$table_name = $wpdb->prefix . self::TABLE_GRID;
		$grids = $wpdb->get_results("SELECT * FROM $table_name".$additional);
		
		//check if we order by favorites here
		if($order_fav === true){
			$temp = array();
			$temp_not = array();
			foreach($grids as $grid){
				$settings = json_decode($grid->settings, true);
				if(!isset($settings['favorite']) || $settings['favorite'] == 'false'){
					$temp_not[] = $grid;
				}else{
					$temp[] = $grid;
				}
			}
			$grids = array();
			
			$grids = ($orderby == 'ASC') ? array_merge($temp, $temp_not) : array_merge($temp_not, $temp);
		}
		
		return apply_filters('essgrid_get_essential_grids', $grids);
	}
	
	
	/**
	 * Get Grid by ID from Database
	 */
	public static function get_essential_grid_by_id($id = 0){
		global $wpdb;
		
		$id = intval($id);
		if($id == 0) return false;
		
		$table_name = $wpdb->prefix . self::TABLE_GRID;
		
		$grid = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
		
		if(!empty($grid)){
			$grid['postparams'] = @json_decode($grid['postparams'], true);
			$grid['params'] = @json_decode($grid['params'], true);
			$grid['layers'] = @json_decode($grid['layers'], true);
			$grid['settings'] = @json_decode($grid['settings'], true);
			$grid['last_modified'] = @$grid['last_modified'];
		}
		
		return apply_filters('essgrid_get_essential_grid_by_id', $grid, $id);
	}
	
	
	/**
	 * get array of id -> title
	 */		
	public static function get_grids_short($exceptID = null){
		$arrGrids = self::get_essential_grids();
		
		$arrShort = array();
		foreach($arrGrids as $grid){
			$id = $grid->id;
			$title = $grid->name;
			
			//filter by except
			if(!empty($exceptID) && $exceptID == $id)
				continue;
				
			$arrShort[$id] = $title;
		}
		
		return apply_filters('essgrid_get_grids_short', $arrShort, $exceptID);
	}
	
	
	/**
	 * get array of id -> handle
	 * @since 1.0.6
	 */		
	public static function get_grids_short_widgets($exceptID = null){
		$arrGrids = self::get_essential_grids();
		
		$arrShort = array();
		
		foreach($arrGrids as $grid){
			
			//filter by except
			if(!empty($exceptID) && $exceptID == $grid->id)
				continue;
				
			$arrShort[$grid->id] = $grid->handle;
		}
		
		return apply_filters('essgrid_get_grids_short_widgets', $arrShort, $exceptID);
	}
	
	
	/**
	 * get array of id -> title
	 */		
	public static function get_grids_short_vc($exceptID = null){
		$arrGrids = self::get_essential_grids();
		
		$arrShort = array();
		
		foreach($arrGrids as $grid){
			$alias = $grid->handle;
			$title = $grid->name;
			
			//filter by except
			if(!empty($exceptID) && $exceptID == $grid->id)
				continue;
				
			$arrShort[$title] = $alias;
		}
		
		return apply_filters('essgrid_get_grids_short_vc', $arrShort, $exceptID);
	}
	
	
	/**
	 * Get Choosen Item Skin
	 * @since: 1.2.0
	 */		
	public static function get_choosen_item_skin(){
		
		$base = new Essential_Grid_Base();
		
		return apply_filters('essgrid_get_choosen_item_skin', $base->getVar($this->grid_params, 'entry-skin', 0, 'i'));
		
	}
	
	
	/**
	 * Get Certain Parameter
	 * @since: 1.5.0
	 */		
	public function get_param_by_handle($handle, $default = ''){
		$d = apply_filters('essgrid_get_param_by_handle', array('handle' => $handle, 'default' => $default));
		$handle = $d['handle'];
		$default = $d['default'];
		
		$base = new Essential_Grid_Base();
		
		return $base->getVar($this->grid_params, $handle, $default);
		
	}
	
	
	/**
	 * Get Certain Post Parameter
	 * @since: 1.5.0
	 */		
	public function get_postparam_by_handle($handle, $default = ''){
		$d = apply_filters('essgrid_get_postparam_by_handle', array('handle' => $handle, 'default' => $default));
		$handle = $d['handle'];
		$default = $d['default'];
		
		$base = new Essential_Grid_Base();
		
		return $base->getVar($this->grid_postparams, $handle, $default);
		
	}
	
	
	/**
	 * Update Certain Parameter by Handle
	 * @since: 2.1.0
	 */	
	public function set_param_by_handle($handle, $param){
		$this->grid_params[$handle] = $param;
	}
	
	
	/**
	 * Update Certain Post Parameter by Handle
	 * @since: 2.1.0
	 */	
	public function set_postparam_by_handle($handle, $param){
		$this->grid_postparams[$handle] = $param;
	}
	
	
	/**
	 * Update Certain Post Parameter by Handle
	 * @since: 2.1.0
	 */	
	public function save_params(){
		global $wpdb;
		
		$table_name = $wpdb->prefix . Essential_Grid::TABLE_GRID;
		
		$wpdb->update($table_name,
			array(
				'postparams' => json_encode($this->grid_postparams),
				'params' => json_encode($this->grid_params)
			),
			array('id' => $this->grid_id)
		);
		
	}
	
	
	/**
	 * Output Essential Grid in Page by alias
	 */		
	public function output_essential_grid_by_alias($eg_alias){
		global $wpdb;
		
		$eg_alias = apply_filters('essgrid_output_essential_grid_by_alias', $eg_alias);
		
		$table_name = $wpdb->prefix . self::TABLE_GRID;
		
		$grid = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s", $eg_alias), ARRAY_A);
		
		if(!empty($grid)){
			$this->output_essential_grid($grid['id']);
		}else{
			return false;
		}
		
	}
	
	
	/**
	 * Output Essential Grid in Page by Custom Settings and Layers
	 * @since: 1.2.0
	 */		
	public function output_essential_grid_by_settings(){
		
		do_action('essgrid_output_essential_grid_by_settings', $this);
		
		if($this->custom_special !== null){
			if($this->custom_settings !== null) //custom settings got added. Overwrite Grid Settings and element settings
				$this->apply_custom_settings(true);
			
			$this->apply_all_media_types();
			
			$this->output_by_posts();
		}else{
			if($this->custom_settings == null || $this->custom_layers == null){ return false; }else{
				$this->output_essential_grid_custom();
			}
		}
		
	}
	
	
	/**
	 * Get Essential Grid ID by alias
	 * @since: 1.2.0
	 */		
	public static function get_id_by_alias($eg_alias){
		global $wpdb;
		
		$eg_alias = apply_filters('essgrid_get_id_by_alias', $eg_alias);
		
		$table_name = $wpdb->prefix . self::TABLE_GRID;
		
		$grid = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s", $eg_alias), ARRAY_A);
		
		if(!empty($grid)){
			return $grid['id'];
		}else{
			return '0';
		}
		
	}
	
	
	/**
	 * Get Essential Grid alias by ID
	 * @since: 2.0
	 */		
	public static function get_alias_by_id($eg_id){
		global $wpdb;
		
		$eg_id = apply_filters('essgrid_get_alias_by_id', $eg_id);
		
		$table_name = $wpdb->prefix . self::TABLE_GRID;
		
		$grid = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $eg_id), ARRAY_A);
		
		if(!empty($grid)){
			return $grid['handle'];
		}else{
			return '';
		}
		
	}
	
	
	/**
     * get all post values / layer values at custom grid
	 * @since: 2.1.0
     */
    public function get_layer_values(){
		
		return apply_filters('essgrid_get_layer_values', $this->grid_layers);
		
    }
	
	
    /**
	 * Init essential data by id
	 */	
    public function init_by_id($grid_id){
        global $wpdb;
		
		$grid_id = apply_filters('essgrid_init_by_id_pre', $grid_id);
		
		$table_name = $wpdb->prefix . self::TABLE_GRID;
		
		$grid = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $grid_id), ARRAY_A);
		
		if(empty($grid)) return false;
		
		$this->grid_id = @$grid['id'];
		$this->grid_name = @$grid['name'];
		$this->grid_handle = @$grid['handle'];
		$this->grid_postparams = @json_decode($grid['postparams'], true);
		$this->grid_params = @json_decode($grid['params'], true);
		$this->grid_settings = @json_decode($grid['settings'], true);
		$this->grid_last_mod = @$grid['last_modified'];
		
		if(!empty($grid['layers'])){
			$orig_layers = $grid['layers'];
			$grid['layers'] = @json_decode(stripslashes($orig_layers), true);
			if(empty($grid['layers']) || !is_array($grid['layers'])) $grid['layers'] = @json_decode($orig_layers, true);
			
			if(!empty($grid['layers'])){
				foreach($grid['layers'] as $key => $layer){
					$orig_layers_cur = $grid['layers'][$key];
					$grid['layers'][$key] = @json_decode($orig_layers_cur, true);
					if(empty($grid['layers'][$key]) || !is_array($grid['layers'][$key])) $grid['layers'][$key] = @json_decode(stripslashes($orig_layers_cur), true);
				}
			}
		}
        $this->grid_layers = @$grid['layers'];
		
		do_action('essgrid_init_by_id_post', $this, $grid);
		
		return true;
    }
	
	
    /**
	 * Init essential data by given data
	 */	
    public function init_by_data($grid_data){
        
		$grid_data = apply_filters('essgrid_init_by_data', $grid_data);
		
		$this->grid_id = @$grid_data['id'];
		$this->grid_name = @$grid_data['name'];
		$this->grid_handle = @$grid_data['handle'];
        $this->grid_postparams = @$grid_data['postparams'];
        $this->grid_params = @$grid_data['params'];
		$this->grid_settings = @$grid_data['settings'];
		$this->grid_last_mod = @$grid_data['last_modified'];
		
		
		$temp_layer = array();
		
		if(!empty($grid_data['layers'])){
			foreach($grid_data['layers'] as $key => $layer){
				$temp_layer = @json_decode(stripslashes($grid_data['layers'][$key]), true);
				if(!empty($temp_layer)){
					$grid_data['layers'][$key] = $temp_layer;
				}else{
					$temp_layer = @json_decode($grid_data['layers'][$key], true);
					if(!empty($temp_layer)){
						$grid_data['layers'][$key] = $temp_layer;
					}
				}
			}
		}
        $this->grid_layers = @$grid_data['layers'];
		
		return true;
    }
	
	
    /**
	 * Init essential data by id
	 */	
    public function set_loading_ids($ids){
        
		$this->filter_by_ids = apply_filters('essgrid_set_loading_ids', $ids);
		
    }
	
	
    /**
	 * Check if Grid is a Post
	 */	
    public function is_custom_grid(){
        
		do_action('essgrid_is_custom_grid');
		
		if(isset($this->grid_postparams['source-type']) && $this->grid_postparams['source-type'] == 'custom')
			return true;
		else
			return false;
		
    }
    
	
	
    /**
	 * Check if Grid is a Stream
	 */	
    public function is_stream_grid(){
        
		do_action('essgrid_is_stream_grid');
		
		if(isset($this->grid_postparams['source-type'])){
			switch($this->grid_postparams['source-type']){
				case 'stream':
				case 'twitter':
				case 'facebook':
				case 'flickr':
				case 'instagram':
				case 'youtube':
				case 'behance':
				case 'nextgen':
				case 'vimeo':
					return true;
			}
		}
		return false;
    }
    
    
	/**
	 * Output Essential Grid in Page
	 */		
	public function output_essential_grid($grid_id, $data = array(), $grid_preview = false, $by_id = false){

		try{
			
			do_action('essgrid_output_essential_grid', $grid_id, $data, $grid_preview, $by_id);
			
			if($grid_preview){
				$data['id'] = $grid_id;
				if($by_id == false){
					$init = $this->init_by_data($data);
				}else{
					$init = $this->init_by_id($grid_id);
				}
				if(!$init) return false; //be silent
			}else{
				$init = $this->init_by_id($grid_id);
				if(!$init) return false; //be silent
				Essential_Grid_Global_Css::output_global_css_styles_wrapped();
			}
			
			if($this->custom_posts !== null) //custom post IDs are added, so we change to post
				$this->grid_postparams['source-type'] = 'post';
			
			if($this->custom_images !== null) //custom images are added, so we change to gallery
				$this->grid_postparams['source-type'] = 'gallery';
				
			if($this->custom_settings !== null) //custom settings got added. Overwrite Grid Settings and element settings
				$this->apply_custom_settings();
				
			if($this->custom_layers !== null){ //custom layers got added. Overwrite Grid Layers
				$this->apply_custom_layers(true);
				$this->grid_postparams['source-type'] = 'custom';
			}
			
			$this->set_api_names(); //set correct names for javascript and div id
			switch($this->grid_postparams['source-type']){
				case 'post':
				case 'woocommerce':
					$this->output_by_posts($grid_preview);
				break;
				case 'custom':
					$this->output_by_custom($grid_preview);
				break;
				case 'gallery':
					$this->output_by_gallery($grid_preview);
				break;
				case 'stream':
				case 'twitter':
				case 'facebook':
				case 'flickr':
				case 'instagram':
				case 'youtube':
				case 'behance':
				case 'nextgen':
				case 'vimeo':
					$this->output_by_stream(false); //false, as we do not have any options to be changed 
				break;
			}
			
		}catch(Exception $e){
			$message = $e->getMessage();
			echo $message;
		}
	}
    
	
	/**
	 * set correct names for javascript and div id
	 * @since: 1.5.0
	 */
	public function set_api_names(){
		$ess_api = '';
		$ess_div = '';
		if($this->grid_id != null){
			$ess_api = $this->grid_id;
			$ess_div = $this->grid_id;
		}
		
		if($this->custom_special !== null){
			switch($this->custom_special){
				case 'related':
				case 'popular':
				case 'latest':
					$ess_api .= '_'.$this->custom_special;
					$ess_div .= '-'.$this->custom_special;
				break;
			}
		}
		if($this->custom_posts !== null){
			$ess_api .= '_custom_post';
			$ess_div .= '-custom_post';
		}
		if($this->custom_settings !== null){
			$ess_api .= '_custom';
			$ess_div .= '-custom';
		}
		if($this->custom_layers !== null){
			$ess_api .= '_layers';
			$ess_div .= '-layers';
		}
		if($this->custom_images !== null){
			$ess_api .= '_img';
			$ess_div .= '-img';
		}
		
		$this->grid_api_name = $ess_api;
		$this->grid_div_name = $ess_div;
		
		do_action('essgrid_set_api_names', $this);
		
	}
	
    
	/**
	 * Output Essential Grid in Page with Custom Layer and Settings
	 * @since: 1.2.0
	 */		
	public function output_essential_grid_custom($grid_preview = false){
		try{
			
			do_action('essgrid_output_essential_grid_custom', $this, $grid_preview);
			
			Essential_Grid_Global_Css::output_global_css_styles_wrapped();
			
			if($this->custom_settings !== null) //custom settings got added. Overwrite Grid Settings and element settings
				$this->apply_custom_settings(true);
			
			if($this->custom_layers !== null) //custom settings got added. Overwrite Grid Settings and element settings
				$this->apply_custom_layers(true);
			
			$this->apply_all_media_types();
			
			return $this->output_by_custom($grid_preview);
			
		}catch(Exception $e){
			$message = $e->getMessage();
			echo $message;
		}
	}
	
	
	/**
	 * Apply all media types for custom grids that have not much settings
	 * @since: 1.2.0
	 */
	public function apply_all_media_types(){
		/**
		 * Add settings that need to be set
		 * - use all media sources, sorting does not matter since we only set one thing in each entry
		 * - use all poster sources for videos, sorting does not matter since we only set one thing in each entry
		 * - use all lightbox sources, sorting does not matter since we only set one thing in each entry
		 */
		$media_orders = Essential_Grid_Base::get_media_source_order();
		foreach($media_orders as $handle => $vals){
			if($handle == 'featured-image' || $handle == 'alternate-image') continue;
			$this->grid_postparams['media-source-order'][] = $handle;
		}
		$this->grid_postparams['media-source-order'][] = 'featured-image'; //set this as the last entry
		$this->grid_postparams['media-source-order'][] = 'alternate-image'; //set this as the last entry
		
		$poster_orders = Essential_Grid_Base::get_poster_source_order();
		if(!empty($poster_orders)){
			foreach($poster_orders as $handle => $vals){
				$this->grid_params['poster-source-order'][] = $handle;
			}
		}
		
		$lb_orders = Essential_Grid_Base::get_lb_source_order();
		foreach($lb_orders as $handle => $vals){
			$this->grid_params['lb-source-order'][] = $handle;
		}
		
		do_action('essgrid_apply_all_media_types', $this);
	}
	
	
	/**
	 * Apply Custom Settings to the Grid, so users can change everything in the settings they want to
	 * This allows to modify grid_params and grid_post_params
	 * @since: 1.2.0
	 */
	private function apply_custom_settings($has_handle = false){
		
		if(empty($this->custom_settings) || !is_array($this->custom_settings)) return false;
		
		$base = new Essential_Grid_Base();
		
		$translate_variables = array('grid-layout' => 'layout');
		
		foreach($this->custom_settings as $handle => $new_setting){
		
			if(isset($translate_variables[$handle])){
				$handle = $translate_variables[$handle];
			}
			
			if($has_handle){ //p- is in front of postparameters
			
				if(strpos($handle, 'p-') === 0)
					$this->grid_postparams[substr($handle, 2)] = $new_setting;
				else
					$this->grid_params[$handle] = $new_setting;
					
			}else{
			
				if(isset($this->grid_params[$handle])){
					$this->grid_params[$handle] = $new_setting;
				}elseif(isset($this->grid_postparams[$handle])){
					$this->grid_postparams[$handle] = $new_setting;
				}else{
					$this->grid_params[$handle] = $new_setting;
				}
					
			}
		}
		
		if(isset($this->grid_params['columns'])){ //change columns
			$columns = $base->set_basic_colums_custom($this->grid_params['columns']);
			$this->grid_params['columns'] = $columns;
		}
		
		if(isset($this->grid_params['rows-unlimited']) && $this->grid_params['rows-unlimited'] == 'off'){ //add pagination 
			$this->grid_params['navigation-layout']['pagination']['bottom-1'] = '0';
			$this->grid_params['bottom-1-margin-top'] = '10';
		}
		
		do_action('essgrid_apply_custom_settings', $this);
		
		return true;
		
	}
	
	
	/**
	 * Apply Custom Layers to the Grid
	 * @since: 1.2.0
	 */
	private function apply_custom_layers(){
	
		$this->grid_layers = array();
		if(!empty($this->custom_layers) && is_array($this->custom_layers)){
			$add_poster_img = array();
			foreach($this->custom_layers as $handle => $val_arr){
				if(!empty($val_arr) && is_array($val_arr)){
					//$custom_poster = false;
					foreach($val_arr as $id => $value){
						//if($handle == 'custom-poster') $custom_poster = array($id, $value);
						if($handle == 'custom-poster'){
							$add_poster_img[$id] = $value;
							continue;
						}
						$this->grid_layers[$id][$handle] = $value;
					}
				}
			}
			
			if(!empty($add_poster_img)){
				foreach($add_poster_img as $id => $value){
					$this->grid_layers[$id]['custom-image'] = $value;
				}
			}
		}
		
		do_action('essgrid_apply_custom_layers', $this);
		
	}
	
	
	/**
	 * Output by Specific Stream
	 * @since: 2.1.0
	 */
	public function output_by_specific_stream(){
		ob_start();
		$this->output_by_stream(false, true, $this->filter_by_ids);
		$stream_html = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		return apply_filters('essgrid_output_by_specific_stream', $stream_html, $this);
	}
	
	
	/**
	 * Output by Stream
	 * @since: 2.1.0
	 */
	public function output_by_stream($grid_preview = false, $only_elements = false, $specific_ids = array()){
		
		do_action('essgrid_output_by_stream_pre', $grid_preview, $only_elements, $specific_ids);
		
		$this->grid_layers = array();
		
		$base = new Essential_Grid_Base();

		switch ($base->getVar($this->grid_postparams, 'stream-source-type')) {
			case 'twitter':
				$twitter = new Essential_Grid_Twitter($base->getVar($this->grid_postparams, 'twitter-consumer-key'),$base->getVar($this->grid_postparams, 'twitter-consumer-secret'),$base->getVar($this->grid_postparams, 'twitter-access-token'),$base->getVar($this->grid_postparams, 'twitter-access-secret'),$base->getVar($this->grid_postparams, 'twitter-transient-sec',86400));
				$tweets = $twitter->get_public_photos($base->getVar($this->grid_postparams, 'twitter-user-id'),$base->getVar($this->grid_postparams, 'twitter-include-retweets'),$base->getVar($this->grid_postparams, 'twitter-exclude-replies'),$base->getVar($this->grid_postparams, 'twitter-count'),$base->getVar($this->grid_postparams, 'twitter-image-only'));	
				
				if(is_array($tweets)){
					foreach ($tweets as $tweet) {
						if( empty($tweet['custom-image-url-full'][0]) ) {
							$default_image_id = $base->getVar($this->grid_postparams, 'default-image');
							$default_image_size = 'full';
							if(!empty($default_image_id)){
								$image =  wp_get_attachment_image_src($default_image_id,$default_image_size);
								$tweet['custom-image-url-full']= $image;
							}
						}
						if( empty($tweet['custom-image-url'][0]) ) {
							$default_image_id = $base->getVar($this->grid_postparams, 'default-image');
							$default_image_size = 'full';
							if(!empty($default_image_id)){
								$image =  wp_get_attachment_image_src($default_image_id,$default_image_size);
								$tweet['custom-image-url']= $image;
							}
						}
						//var_dump($tweet);
						$this->grid_layers[] = $tweet; //preg_replace("/[^0-9]/","",$tweet['id'])
					}
				}
				break;
			case 'instagram':
				$instagram = new Essential_Grid_Instagram($base->getVar($this->grid_postparams, 'instagram-transient-sec',86400));
				
				$public_photos = $instagram->get_public_photos($base->getVar($this->grid_postparams, 'instagram-user-id'),$base->getVar($this->grid_postparams, 'instagram-count'));

				$instagram_images_avail_sizes = array('Thumbnail','Low Resolution','Standard Resolution');

				if(is_array($public_photos)){
					foreach ($public_photos as $photo) {
						$photo['custom-image-url-full'] = $this->find_biggest_photo($photo['custom-image-url'],$base->getVar($this->grid_postparams, 'instagram-full-size'),$instagram_images_avail_sizes);
						$photo['custom-preload-image-url'] = $photo['custom-image-url']['Thumbnail'][0];
						$photo['custom-image-url'] = $this->find_biggest_photo($photo['custom-image-url'],$base->getVar($this->grid_postparams, 'instagram-thumb-size'),$instagram_images_avail_sizes);

						//if($photo['custom-type'] == 'html5') $photo['html5']['mp4'] = $photo['custom-html5-mp4'];

						$this->grid_layers[] = $photo; //preg_replace("/[^0-9]/","",$photo['id'])
					}
				}		
				break;
			case 'vimeo':
				$vimeo = new Essential_Grid_Vimeo($base->getVar($this->grid_postparams, 'vimeo-transient-sec',86400));
				$vimeo_type = $base->getVar($this->grid_postparams, 'vimeo-type-source');
				
				switch ($vimeo_type) {
					case 'user':
						$videos = $vimeo->get_vimeo_videos($vimeo_type,$base->getVar($this->grid_postparams, 'vimeo-username'),$base->getVar($this->grid_postparams, 'vimeo-count','50'));
						break;
					case 'channel':
						$videos = $vimeo->get_vimeo_videos($vimeo_type,$base->getVar($this->grid_postparams, 'vimeo-channelname'),$base->getVar($this->grid_postparams, 'vimeo-count','50'));
						break;
					case 'group':
						$videos = $vimeo->get_vimeo_videos($vimeo_type,$base->getVar($this->grid_postparams, 'vimeo-groupname'),$base->getVar($this->grid_postparams, 'vimeo-count','50'));
						break;
					case 'album':
						$videos = $vimeo->get_vimeo_videos($vimeo_type,$base->getVar($this->grid_postparams, 'vimeo-albumid'),$base->getVar($this->grid_postparams, 'vimeo-count','50'));
						break;
					default:
						break;

				}
				
				$vimeo_images_avail_sizes = array('thumbnail_small','thumbnail_medium','thumbnail_large');

				if(is_array($videos)){
					foreach ($videos as $video) {
						$video['custom-preload-image-url'] = $video['custom-image-url']['thumbnail_small'][0];
						$video['custom-image-url'] = $this->find_biggest_photo($video['custom-image-url'],$base->getVar($this->grid_postparams, 'vimeo-thumb-size','thumbnail_medium'),$vimeo_images_avail_sizes);
						$this->grid_layers[] = $video; //preg_replace("/[^0-9]/","",$video['id'])
					}
				}		
				break;
			case 'youtube':
				$channel_id = $base->getVar($this->grid_postparams, 'youtube-channel-id');
				$youtube = new Essential_Grid_Youtube($base->getVar($this->grid_postparams, 'youtube-api'),$channel_id,$base->getVar($this->grid_postparams, 'youtube-transient-sec',0));
				
				switch ($base->getVar($this->grid_postparams, 'youtube-type-source')) {
					case 'playlist':
						$videos = $youtube->show_playlist_videos($base->getVar($this->grid_postparams, 'youtube-playlist'),$base->getVar($this->grid_postparams, 'youtube-count'));
						break;
					case 'playlist_overview':
						$videos = $youtube->show_playlist_overview($base->getVar($this->grid_postparams, 'youtube-count'));
						break;
					default:
						$videos = $youtube->show_channel_videos($base->getVar($this->grid_postparams, 'youtube-count'));
						break;
				}

				$youtube_images_avail_sizes = array('default','medium','high','standard','maxres');

				if(is_array($videos)){
					foreach ($videos as $video) {
						$video['custom-preload-image-url'] = $video['custom-image-url']['default'][0];
						$video['custom-image-url-full'] = $this->find_biggest_photo($video['custom-image-url'],$base->getVar($this->grid_postparams, 'youtube-full-size'),$youtube_images_avail_sizes);
						$video['custom-image-url'] = $this->find_biggest_photo($video['custom-image-url'],$base->getVar($this->grid_postparams, 'youtube-thumb-size'),$youtube_images_avail_sizes);

						if(strpos($video['custom-image-url-full'][0], 'no_thumbnail') > 0) {
							$default_image_id = $base->getVar($this->grid_postparams, 'default-image');
							//$default_image_size = $base->getVar($this->grid_postparams, 'image-source-type');
							$default_image_size = 'full';
							if(!empty($default_image_id)){
								$image =  wp_get_attachment_image_src($default_image_id,$default_image_size);
								$video['custom-image-url-full']= $image;
							}
						}
						if(strpos($video['custom-image-url'][0], 'no_thumbnail') > 0) {
							$default_image_id = $base->getVar($this->grid_postparams, 'default-image');
							$default_image_size = $base->getVar($this->grid_postparams, 'image-source-type');
							if(!empty($default_image_id)){
								$image =  wp_get_attachment_image_src($default_image_id,$default_image_size);
								$video['custom-image-url']= $image;
							}
						}

						$this->grid_layers[] = $video; //preg_replace("/[^0-9]/","",$video['id'])
					}
				}		
				break;
			case 'facebook':
				$facebook = new Essential_Grid_Facebook($base->getVar($this->grid_postparams, 'facebook-transient-sec',86400));
				if($base->getVar($this->grid_postparams, 'facebook-type-source') == "album"){
					$photo_set_photos = $facebook->get_photo_set_photos($base->getVar($this->grid_postparams, 'facebook-album'),$base->getVar($this->grid_postparams, 'facebook-count',10),$base->getVar($this->grid_postparams, 'facebook-app-id'),$base->getVar($this->grid_postparams, 'facebook-app-secret'));
				}
				else{
					$user_id = $facebook->get_user_from_url($base->getVar($this->grid_postparams, 'facebook-page-url'));
					$photo_set_photos = $facebook->get_photo_feed($user_id,$base->getVar($this->grid_postparams, 'facebook-app-id'),$base->getVar($this->grid_postparams, 'facebook-app-secret'),$base->getVar($this->grid_postparams, 'facebook-count',10));
				}
				
				$facebook_images_avail_sizes = array("thumbnail","normal");

				if(is_array($photo_set_photos)){
					foreach ($photo_set_photos as $photo) {
						$photo['custom-preload-image-url'] = $photo['custom-image-url']['thumbnail'][0];
						$photo['custom-image-url-full'] = $photo['custom-image-url']['normal'];
						$photo['custom-image-url'] = $photo['custom-image-url']['normal'];
						$this->grid_layers[] = $photo;
					}
				}
				break;
			case 'flickr':
				$flickr = new Essential_Grid_Flickr($base->getVar($this->grid_postparams, 'flickr-api-key'),$base->getVar($this->grid_postparams, 'flickr-transient-sec',86400));

				switch($base->getVar($this->grid_postparams, 'flickr-type')){
					case 'publicphotos':
						$user_id = $flickr->get_user_from_url($base->getVar($this->grid_postparams, 'flickr-user-url'));
						$flickr_photos = $flickr->get_public_photos($user_id,$base->getVar($this->grid_postparams, 'flickr-count'));
						break;
					case 'gallery':
						$gallery_id = $flickr->get_gallery_from_url($base->getVar($this->grid_postparams, 'flickr-gallery-url'));
						$flickr_photos = $flickr->get_gallery_photos($gallery_id,$base->getVar($this->grid_postparams, 'flickr-count'));
						break;
					case 'group':
						$group_id = $flickr->get_group_from_url($base->getVar($this->grid_postparams, 'flickr-group-url'));
						$flickr_photos = $flickr->get_group_photos($group_id,$base->getVar($this->grid_postparams, 'flickr-count'));
						break;
					case 'photosets':
						$flickr_photos = $flickr->get_photo_set_photos($base->getVar($this->grid_postparams, 'flickr-photoset'),$base->getVar($this->grid_postparams, 'flickr-count'));
						break;
				}	
		
				$flickr_images_avail_sizes = array('Square','Thumbnail','Large Square','Small','Small 320','Medium','Medium 640','Medium 800','Large','Original');

				if(is_array($flickr_photos)){
					foreach ($flickr_photos as $photo) {
						$photo['custom-preload-image-url'] = $photo['custom-image-url']['Square'][0];
						$photo['custom-image-url-full'] = $this->find_biggest_photo($photo['custom-image-url'],$base->getVar($this->grid_postparams, 'flickr-full-size'),$flickr_images_avail_sizes);
						$photo['custom-image-url'] = $this->find_biggest_photo($photo['custom-image-url'],$base->getVar($this->grid_postparams, 'flickr-thumb-size'),$flickr_images_avail_sizes);
						$this->grid_layers[] = $photo; //preg_replace("/[^0-9]/","",$photo['id'])
					}
				}
				break;
				case 'behance':
					$behance = new Essential_Grid_Behance($base->getVar($this->grid_postparams, 'behance-api'),$base->getVar($this->grid_postparams, 'behance-user-id'),$base->getVar($this->grid_postparams, 'behance-transient-sec',0));
					if( $base->getVar($this->grid_postparams, 'behance-type','projects')=='projects' ){
						$images = $behance->get_behance_projects( $base->getVar($this->grid_postparams, 'behance-count',100) );
					}
					else {
						$images = $behance->get_behance_project_images($base->getVar($this->grid_postparams, 'behance-project',''), $base->getVar($this->grid_postparams, 'behance-count',100) );
					}

					$behance_images_avail_sizes = array('disp','max_86400','max_1240','original');
					$behance_project_images_avail_sizes = array('115','202','230','404','original');

					if(is_array($images)){
						foreach ($images as $image) {	
							if($base->getVar($this->grid_postparams, 'behance-type','projects')!='projects'){
								$image['custom-image-url-full'] = $this->find_biggest_photo($image['custom-image-url'],$base->getVar($this->grid_postparams, 'behance-project-full-size'),$behance_project_images_avail_sizes);
								$image['custom-image-url'] = $this->find_biggest_photo($image['custom-image-url'],$base->getVar($this->grid_postparams, 'behance-project-thumb-size'),$behance_project_images_avail_sizes);
							}
							else{
								$image['custom-image-url-full'] = $this->find_biggest_photo($image['custom-image-url'],$base->getVar($this->grid_postparams, 'behance-full-size'),$behance_images_avail_sizes);
								$image['custom-image-url'] = $this->find_biggest_photo($image['custom-image-url'],$base->getVar($this->grid_postparams, 'behance-thumb-size'),$behance_images_avail_sizes);	
							}
							$this->grid_layers[] = $image; //preg_replace("/[^0-9]/","",$image['id'])
						}
					}
				break;
				case 'nextgen':
					$nextgen = new Essential_Grid_Nextgen();
					switch ($base->getVar($this->grid_postparams, 'nextgen-type','album')) {
						case 'album':
							$images = $nextgen->get_album_images($base->getVar($this->grid_postparams, 'nextgen-album',''));
							break;
						case 'gallery':
							$images = $nextgen->get_gallery_images(array($base->getVar($this->grid_postparams, 'nextgen-gallery','')));
							break;
						case 'tags':
							$images = $nextgen->get_tags_images($base->getVar($this->grid_postparams, 'nextgen-tags',''));
							break;
					}
					
					if(is_array($images)){
						foreach ($images as $image) {	
							$image['custom-image-url-full'] = $image['custom-image-url']['original'];
							$image['custom-image-url'] = $image['custom-image-url'][$base->getVar($this->grid_postparams, 'nextgen-thumb-size','thumb')];
							$this->grid_layers[] = $image; //preg_replace("/[^0-9]/","",$image['id'])
						}	
					}
				break;
		}
		
		
		if(!empty($specific_ids)){ //remove all that we do not have in this array
			foreach($this->grid_layers as $key => $layer){
				if(!in_array($key, $specific_ids)) unset($this->grid_layers[$key]);
			}
		}
		
		/*
		$order_by = explode(',', $base->getVar($this->grid_params, 'sorting-order-by', 'date'));
		if(!is_array($order_by)) $order_by = array($order_by);
		$order_by_start = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		$order_by_dir = $base->getVar($this->grid_params, 'sorting-order-type', 'ASC');

		if(!empty($order_by_start) && !empty($this->grid_layers)){
			if(is_array($order_by_start)){
				$order_by_start = $order_by_start[0];
			}
			
			switch($order_by_start){
				case 'rand':
					$this->grid_layers = $base->shuffle_assoc($this->grid_layers);
				break;
				case 'title':
				case 'post_url':
				case 'excerpt':
				case 'meta':
				case 'alias':
				case 'name':
				case 'content':
				case 'author_name':
				case 'author':
				case 'cat_list':
				case 'tag_list':
					if($order_by_start == 'name') $order_by_start = 'alias';
					if($order_by_start == 'author') $order_by_start = 'author_name';
					//check if values are existing and if not, add them to the layers
					$this->set_custom_sorter($order_by_start, $order_by_dir);
					usort($this->grid_layers, array('Essential_Grid', 'custom_sorter'));
				break;
				case 'post_id':
				case 'ID':
				case 'num_comments':
				case 'comment_count':
				case 'date':
				case 'modified':
				case 'date_modified':
				case 'views':
				case 'likes':
				case 'dislikes':
				case 'retweets':
				case 'favorites':
				case 'itemCount':
				case 'duration':
					if($order_by_start == 'comment_count') $order_by_start = 'num_comments';
					if($order_by_start == 'modified') $order_by_start = 'date_modified';
					if($order_by_start == 'ID') $order_by_start = 'post_id';
					$this->set_custom_sorter($order_by_start, $order_by_dir);
					usort($this->grid_layers, array('Essential_Grid', 'custom_sorter_int'));
				break;
			}
		}

		//var_dump($order_by);

		/*
			$item_skin = new Essential_Grid_Item_Skin();
			$item_skin->grid_id = $this->grid_id;
			$item_skin->init_by_id($base->getVar($this->grid_params, 'entry-skin', 0, 'i'));
			$item_skin->set_grid_type($base->getVar($this->grid_params, 'layout','even'));
			$filters = array();
			if(!empty($this->grid_layers) && count($this->grid_layers) > 0){
				foreach($this->grid_layers as $key => $entry){
					if(is_array($order_by) && !empty($order_by)){
						$sort = $this->prepare_sorting_array_by_stream($entry, $order_by);
						$item_skin->set_sorting($sort);
					}
				}
			}
		*/
		do_action('essgrid_output_by_stream_post', $this, $grid_preview, $only_elements);
		
		$do_load_more = (!empty($specific_ids)) ? true : false;
		
		return $this->output_by_custom($grid_preview, $only_elements, $do_load_more);
	}
	

	public function find_biggest_photo($image_urls, $wanted_size, $avail_sizes){
		$d = apply_filters('essgrid_find_biggest_photo', array('image_urls' => $image_urls, 'wanted_size' => $wanted_size, 'avail_sizes' => $avail_sizes));
		
		$image_urls = $d['image_urls'];
		$wanted_size = $d['wanted_size'];
		$avail_sizes = $d['avail_sizes'];
		
		if(!$this->isEmpty($image_urls[$wanted_size])) return $image_urls[$wanted_size];	
		$wanted_size_pos = array_search($wanted_size, $avail_sizes);
		for ($i=$wanted_size_pos; $i < 7; $i++) { 
			if(isset($avail_sizes[$i]) && !$this->isEmpty($image_urls[$avail_sizes[$i]])) 
				return $image_urls[$avail_sizes[$i]];	
		}
		for ($i=$wanted_size_pos; $i >= 0 ; $i--) { 
			if(!$this->isEmpty($image_urls[$avail_sizes[$i]])) return $image_urls[$avail_sizes[$i]];	
		}
	}

	
	public function isEmpty($stringOrArray) {
		
		$stringOrArray = apply_filters('essgrid_isEmpty', $stringOrArray);
		
	    if(is_array($stringOrArray)) {
	        foreach($stringOrArray as $value) {
	            if(!$this->isEmpty($value)) {
	                return false;
	            }
	        }
	        return true;
	    }

	    return !strlen($stringOrArray);  // this properly checks on empty string ('')
	}
	
	
	/**
	 * Output by gallery
	 * Remove all custom elements, add image elements
	 * @since: 1.2.0
	 */
	public function output_by_gallery($grid_preview = false, $only_elements = false){

		$this->grid_layers = array();
		
		if(!empty($this->custom_images)){
			foreach($this->custom_images as $image_id){
				$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				$title = get_the_title($image_id);
				$excerpt = get_post_field('post_excerpt', $image_id);
				
				$this->grid_layers[] = array(
											'custom-image' => $image_id,
											'excerpt' => $excerpt,
											'caption' => $excerpt,
											'title' => $title
											);
											
			}
		}
		
		do_action('essgrid_output_by_gallery', $this, $grid_preview, $only_elements);
		
		return $this->output_by_custom($grid_preview, $only_elements);
		
	}
	
	
	/**
	 * Output by custom grid
	 */
	public function output_by_custom($grid_preview = false, $only_elements = false, $set_load_more = false){
		$post_limit = 99999;
		
		do_action('essgrid_output_by_custom_pre', $this, $grid_preview, $only_elements);
		
		$base = new Essential_Grid_Base();
		$navigation_c = new Essential_Grid_Navigation($this->grid_id);
		$item_skin = new Essential_Grid_Item_Skin();
		$item_skin->grid_id = $this->grid_id;
		$item_skin->set_grid_type($base->getVar($this->grid_params, 'layout','even'));
		
		$item_skin->set_default_image_by_id($base->getVar($this->grid_postparams, 'default-image', 0, 'i'));
		$item_skin->set_default_youtube_image_by_id($base->getVar($this->grid_params, 'youtube-default-image', 0, 'i'));
		$item_skin->set_default_vimeo_image_by_id($base->getVar($this->grid_params, 'vimeo-default-image', 0, 'i'));
		$item_skin->set_default_html_image_by_id($base->getVar($this->grid_params, 'html5-default-image', 0, 'i'));
		if($set_load_more)
			$item_skin->set_load_more();
		
		$m = new Essential_Grid_Meta();
		
		$skins_html = '';
		$skins_css = '';
		$filters = array();
		
		$rows_unlimited = $base->getVar($this->grid_params, 'rows-unlimited', 'on');
		$load_more = $base->getVar($this->grid_params, 'load-more', 'none');
		$load_more_start = $base->getVar($this->grid_params, 'load-more-start', 3, 'i');
		
		if($rows_unlimited == 'on' && $load_more !== 'none' && $grid_preview == false){ //grid_preview means disable load more in preview
			$post_limit = $load_more_start;
		}
		
		$nav_filters = array();
		
		$nav_layout = $base->getVar($this->grid_params, 'navigation-layout', array());
		$nav_skin = $base->getVar($this->grid_params, 'navigation-skin', 'minimal-light');
		$hover_animation = $base->getVar($this->grid_params, 'hover-animation', 'fade');
		$filter_allow = $base->getVar($this->grid_params, 'filter-arrows', 'single');
		$filter_start = $base->getVar($this->grid_params, 'filter-start', '');
		$filter_all_text = $base->getVar($this->grid_params, 'filter-all-text', __('Filter - All', EG_TEXTDOMAIN));
		$filter_dropdown_text = $base->getVar($this->grid_params, 'filter-dropdown-text', __('Filter Categories', EG_TEXTDOMAIN));
		$show_count = $base->getVar($this->grid_params, 'filter-counter', 'off');
		$search_text = $base->getVar($this->grid_params, 'search-text', __('Search...', EG_TEXTDOMAIN));
		
		$filter_grouping = $base->getVar($this->grid_params, 'filter-grouping', 'false');
		$listing_type = $base->getVar($this->grid_params, 'filter-listing', 'list');
		//$selected = $base->getVar($this->grid_params, 'filter-selected', array());
		$filters_arr['filter-grouping'] = $filter_grouping;
		$filters_arr['filter-listing'] = $listing_type;
		$filters_arr['filter-selected'] = array(); //always give empty array (metas ect. may still be checked if Grid was a post based grid before.
		
		$navigation_c->set_filter_settings('filter', $filters_arr);
		
		$nav_type = $base->getVar($this->grid_params, 'nagivation-type', 'internal');
		$do_nav = ($nav_type == 'internal') ? true : false;
		
		$order_by = explode(',', $base->getVar($this->grid_params, 'sorting-order-by', 'date'));
		if(!is_array($order_by)) $order_by = array($order_by);
		$order_by_start = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		$order_by_dir = $base->getVar($this->grid_params, 'sorting-order-type', 'ASC');
		
		$sort_by_text = $base->getVar($this->grid_params, 'sort-by-text', __('Sort By ', EG_TEXTDOMAIN));
		
		$module_spacings = $base->getVar($this->grid_params, 'module-spacings', '5');
		
		$top_1_align = $base->getVar($this->grid_params, 'top-1-align', 'center');
		$top_2_align = $base->getVar($this->grid_params, 'top-2-align', 'center');
		$bottom_1_align = $base->getVar($this->grid_params, 'bottom-1-align', 'center');
		$bottom_2_align = $base->getVar($this->grid_params, 'bottom-2-align', 'center');
		
		$top_1_margin = $base->getVar($this->grid_params, 'top-1-margin-bottom', 0, 'i');
		$top_2_margin = $base->getVar($this->grid_params, 'top-2-margin-bottom', 0, 'i');
		$bottom_1_margin = $base->getVar($this->grid_params, 'bottom-1-margin-top', 0, 'i');
		$bottom_2_margin = $base->getVar($this->grid_params, 'bottom-2-margin-top', 0, 'i');
		
		$left_margin = $base->getVar($this->grid_params, 'left-margin-left', 0, 'i');
		$right_margin = $base->getVar($this->grid_params, 'right-margin-right', 0, 'i');
		
		$nav_styles['top-1'] = array('margin-bottom' => $top_1_margin.'px', 'text-align' => $top_1_align);
		$nav_styles['top-2'] = array('margin-bottom' => $top_2_margin.'px', 'text-align' => $top_2_align);
		$nav_styles['left'] = array('margin-left' => $left_margin.'px');
		$nav_styles['right'] = array('margin-right' => $right_margin.'px');
		$nav_styles['bottom-1'] = array('margin-top' => $bottom_1_margin.'px', 'text-align' => $bottom_1_align);
		$nav_styles['bottom-2'] = array('margin-top' => $bottom_2_margin.'px', 'text-align' => $bottom_2_align);
		
		if($do_nav){ //only do if internal is selected
			$navigation_c->set_special_class('esg-fgc-'.$this->grid_id);
			$navigation_c->set_dropdown_text($filter_dropdown_text);
			$navigation_c->set_show_count($show_count);
			$navigation_c->set_filter_text($filter_all_text);
			$navigation_c->set_specific_styles($nav_styles);
			$navigation_c->set_search_text($search_text);
			$navigation_c->set_layout($nav_layout); //set the layout
			
			$navigation_c->set_orders($order_by); //set order of filter
			$navigation_c->set_orders_text($sort_by_text);
			$navigation_c->set_orders_start($order_by_start); //set order of filter
		}
        $item_skin->init_by_id($base->getVar($this->grid_params, 'entry-skin', 0, 'i'));
		
		$lazy_load = $base->getVar($this->grid_params, 'lazy-loading', 'off');
		if($lazy_load == 'on'){
			$item_skin->set_lazy_load(true);
			$lazy_load_blur = $base->getVar($this->grid_params, 'lazy-loading-blur', 'on');
			if($lazy_load_blur == 'on')
				$item_skin->set_lazy_load_blur(true);
		}
		
        $default_media_source_order = $base->getVar($this->grid_postparams, 'media-source-order', '');
		$item_skin->set_default_media_source_order($default_media_source_order);
		
        $default_lightbox_source_order = $base->getVar($this->grid_params, 'lb-source-order', '');
		$item_skin->set_default_lightbox_source_order($default_lightbox_source_order);
		
        $default_aj_source_order = $base->getVar($this->grid_params, 'aj-source-order', '');
		$item_skin->set_default_ajax_source_order($default_aj_source_order);
		
		$post_media_source_type = $base->getVar($this->grid_postparams, 'image-source-type', 'full');
		
		$default_video_poster_order = $base->getVar($this->grid_params, 'poster-source-order', '');
		if($default_video_poster_order == '')
			$default_video_poster_order = $base->getVar($this->grid_postparams, 'poster-source-order', '');
		
		$item_skin->set_default_video_poster_order($default_video_poster_order);
		
		$layout = $base->getVar($this->grid_params, 'layout','even');
        $layout_sizing = $base->getVar($this->grid_params, 'layout-sizing', 'boxed');
        
		$ajax_container_position = $base->getVar($this->grid_params, 'ajax-container-position', 'top');
		
		if($layout_sizing !== 'fullwidth' && $layout == 'masonry'){
			$item_skin->set_poster_cropping(true);
		}
		
		$skins_css = '';
		$skins_html = '';
		
		$found_filter = array();
		$i = 1;
		$this->order_by_custom($order_by_start, $order_by_dir);
		
		if(!empty($this->grid_layers) && count($this->grid_layers) > 0){
			foreach($this->grid_layers as $key => $entry){
				
				$post_media_source_data = $base->get_custom_media_source_data($entry, $post_media_source_type);
				$post_video_ratios = $m->get_custom_video_ratios($entry);
				$filters = array();
				
				if(is_array($order_by) && !empty($order_by)){
					$sort = $this->prepare_sorting_array_by_custom($entry, $order_by);
					$item_skin->set_sorting($sort);
				}
				if(!empty($entry['custom-filter'])){
					$cats = explode(',', $entry['custom-filter']);
					if(!is_array($cats)) $cats = (array)$cats;
					foreach($cats as $category){
						$filters[sanitize_key($category)] = array('name' => $category, 'slug' => sanitize_key($category));
					}
				}
				
				$found_filter = $found_filter + $filters; //these are the found filters, only show filter that the posts have
				
				//switch to different skin
				$use_item_skin_id = $base->getVar($entry, 'use-skin', '-1');
				if(intval($use_item_skin_id) === 0){
					$use_item_skin_id = -1;
				}
				$item_skin->switch_item_skin($use_item_skin_id);
				$item_skin->register_layer_css();
				$item_skin->register_skin_css();
				
				if($i > $post_limit){
					$this->load_more_post_array[$key] = $filters; //set for load more, only on elements that will not be loaded from beginning
					continue; //Load only selected numbers of items at start (for load more)
				}
				$i++;
				
				$item_skin->set_filter($filters);
				$item_skin->set_media_sources($post_media_source_data);
				$item_skin->set_media_sources_type($post_media_source_type);
				$item_skin->set_video_ratios($post_video_ratios);
				$item_skin->set_layer_values($entry);
				
				ob_start();
				$item_skin->output_item_skin($grid_preview);
				$skins_html.= ob_get_contents();
				ob_clean();
				ob_end_clean();
				
				if($only_elements == false && $grid_preview == false){
					ob_start();
					$id = (isset($entry['post_id'])) ? $entry['post_id'] : '';
					$item_skin->output_element_css_by_meta($id);
					$skins_css.= ob_get_contents();
					ob_clean();
					ob_end_clean();
				}
				
			}
		}
		
		
		if($grid_preview !== false && $only_elements == false){ //add the add more box at the end
			ob_start();
			$item_skin->output_add_more();
			$skins_html.= ob_get_contents();
			ob_clean();
			ob_end_clean();
		}
		
		if($do_nav){ //only do if internal is selected
			$navigation_c->set_filter($found_filter); //set filters $nav_filters $found_filter
			$navigation_c->set_filter_type($filter_allow);
			$navigation_c->set_filter_start_select($filter_start);
		}
		
		if($only_elements == false){
			ob_start();
			$item_skin->generate_element_css($grid_preview);
			$skins_css.= ob_get_contents();
			ob_clean();
			ob_end_clean();
		
		
			if($do_nav){ //only do if internal is selected
				$navigation_skin = $base->getVar($this->grid_params, 'navigation-skin', 'minimal-light');
				echo $navigation_c->output_navigation_skin($navigation_skin);
			}
			
			echo $skins_css;
			
			if($item_skin->ajax_loading == true && $ajax_container_position == 'top'){
				echo $this->output_ajax_container();
			}
			
			$this->output_wrapper_pre($grid_preview);
		
			if($do_nav){ //only do if internal is selected
				$navigation_c->output_layout('top-1', $module_spacings);
				$navigation_c->output_layout('top-2', $module_spacings);
			}
		
			$this->output_grid_pre();
		}
		
		echo $skins_html;
		
		if($only_elements == false){
			$this->output_grid_post();
		
			if($do_nav){ //only do if internal is selected
				$navigation_c->output_layout('bottom-1', $module_spacings);
				$navigation_c->output_layout('bottom-2', $module_spacings);
				$navigation_c->output_layout('left');
				$navigation_c->output_layout('right');
				
				//check if search was added. If yes, we also need to add the "Filter All" filter if not existing
				echo $navigation_c->check_for_search();
			}
		
			$this->output_wrapper_post();
			
			if($item_skin->ajax_loading == true && $ajax_container_position == 'bottom'){
				echo $this->output_ajax_container();
			}
			
			$load_lightbox = $item_skin->do_lightbox_loading();
			
			if($grid_preview === false){
				$this->output_grid_javascript($load_lightbox);
			}elseif($grid_preview !== 'preview' && $grid_preview !== 'custom'){
				$this->output_grid_javascript($load_lightbox, true);
			}
			
			do_action('essgrid_output_by_custom_post', $this, $grid_preview, $only_elements);
		}
	}
	
	
	/**
	 * Output by posts
	 */
	public function output_by_posts($grid_preview = false){
		global $sitepress;
		
		do_action('essgrid_output_by_posts_pre', $this, $grid_preview);
		
		$post_limit = 99999;
		
		$base = new Essential_Grid_Base();
		$navigation_c = new Essential_Grid_Navigation($this->grid_id);
		$meta_c = new Essential_Grid_Meta();
		$meta_link_c = new Essential_Grid_Meta_Linking();
		$item_skin = new Essential_Grid_Item_Skin();
		$item_skin->grid_id = $this->grid_id;
		$item_skin->set_grid_type($base->getVar($this->grid_params, 'layout','even'));
		
		$item_skin->set_default_image_by_id($base->getVar($this->grid_postparams, 'default-image', 0, 'i'));
		$item_skin->set_default_youtube_image_by_id($base->getVar($this->grid_params, 'youtube-default-image', 0, 'i'));
		$item_skin->set_default_vimeo_image_by_id($base->getVar($this->grid_params, 'vimeo-default-image', 0, 'i'));
		$item_skin->set_default_html_image_by_id($base->getVar($this->grid_params, 'html-default-image', 0, 'i'));

		
		$m = new Essential_Grid_Meta();
		
		$skins_html = '';
		$skins_css = '';
		$filters = array();
		
		$rows_unlimited = $base->getVar($this->grid_params, 'rows-unlimited', 'on');
		$load_more = $base->getVar($this->grid_params, 'load-more', 'none');
		$load_more_start = $base->getVar($this->grid_params, 'load-more-start', 3, 'i');
		
		if($rows_unlimited == 'on' && $load_more !== 'none' && $grid_preview == false){ //grid_preview means disable load more in preview
			$post_limit = $load_more_start;
		}
		
		$start_sortby = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		
		$start_sortby_type = $base->getVar($this->grid_params, 'sorting-order-type', 'ASC');
		
		$post_category = $base->getVar($this->grid_postparams, 'post_category');
		$post_types = $base->getVar($this->grid_postparams, 'post_types');
		$page_ids = explode(',', $base->getVar($this->grid_postparams, 'selected_pages', '-1'));
		$cat_relation = $base->getVar($this->grid_postparams, 'category-relation', 'OR');
		
		$max_entries = $this->get_maximum_entries($this);
		
		$additional_query = $base->getVar($this->grid_postparams, 'additional-query', '');
		if($additional_query !== '')
			$additional_query = wp_parse_args($additional_query);
		
		
		$cat_tax = array('cats' => '', 'tax' => '');
		
		if($this->custom_posts !== null){ //output by specific set posts
		
			$posts = Essential_Grid_Base::get_posts_by_ids($this->custom_posts, $start_sortby, $start_sortby_type);
			
			$cat_tax_obj = Essential_Grid_Base::get_categories_by_posts($posts);
			
			if(!empty($cat_tax_obj)){
				$cat_tax['cats'] = Essential_Grid_Base::translate_categories_to_string($cat_tax_obj);
			}
			//$cat_tax = Essential_Grid_Base::getCatAndTaxData($post_category); //get cats by posts
			
		}elseif($this->custom_special !== null){ //output by some special rule
			
			$max_entries = intval($base->getVar($this->grid_params, 'max-entries', '20'));
			if($max_entries == 0) $max_entries = 20;
			
			switch($this->custom_special){
				case 'related':
					$posts = Essential_Grid_Base::get_related_posts($max_entries);
				break;
				case 'popular':
					$posts = Essential_Grid_Base::get_popular_posts($max_entries);
				break;
				case 'latest':
				default:
					$posts = Essential_Grid_Base::get_latest_posts($max_entries);
				break;
			}
			
			$cat_tax_obj = Essential_Grid_Base::get_categories_by_posts($posts);
			
			if(!empty($cat_tax_obj)){
				$cat_tax['cats'] = Essential_Grid_Base::translate_categories_to_string($cat_tax_obj);
			}
			
			//$cat_tax = Essential_Grid_Base::getCatAndTaxData($post_category);  //get cats by posts
			
		}else{ //output with the grid settings from an existing grid
			
			$cat_tax = Essential_Grid_Base::getCatAndTaxData($post_category);
			
			$posts = Essential_Grid_Base::getPostsByCategory($this->grid_id, $cat_tax['cats'], $post_types, $cat_tax['tax'], $page_ids, $start_sortby, $start_sortby_type, $max_entries, $additional_query, true, $cat_relation);
			
		}
		
		$nav_layout = $base->getVar($this->grid_params, 'navigation-layout', array());
		$nav_skin = $base->getVar($this->grid_params, 'navigation-skin', 'minimal-light');
		$hover_animation = $base->getVar($this->grid_params, 'hover-animation', 'fade');
		$filter_allow = $base->getVar($this->grid_params, 'filter-arrows', 'single');
		$filter_start = $base->getVar($this->grid_params, 'filter-start', '');
		
		$nav_type = $base->getVar($this->grid_params, 'nagivation-type', 'internal');
		$do_nav = ($nav_type == 'internal') ? true : false;
		
		$order_by = explode(',', $base->getVar($this->grid_params, 'sorting-order-by', 'date'));
		if(!is_array($order_by)) $order_by = array($order_by);
		$order_by_start = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		if(strpos($order_by_start, 'eg-') === 0 || strpos($order_by_start, 'egl-') === 0){ //add meta at the end for meta sorting
			//if essential Meta, replace to meta name. Else -> replace - and _ with space, set each word uppercase
			$metas = $m->get_all_meta();
			$f = false;
			if(!empty($metas)){
				foreach($metas as $meta){
					if('eg-'.$meta['handle'] == $order_by_start || 'egl-'.$meta['handle'] == $order_by_start){
						$f = true;
						$order_by_start = $meta['name'];
						break;
					}
				}
			}
			
			if($f === false){
				$order_by_start = ucwords(str_replace(array('-', '_'), array(' ', ' '), $order_by_start));
			}
		}
		
		$sort_by_text = $base->getVar($this->grid_params, 'sort-by-text', __('Sort By ', EG_TEXTDOMAIN));
		$search_text = $base->getVar($this->grid_params, 'search-text', __('Search...', EG_TEXTDOMAIN));
		
		$module_spacings = $base->getVar($this->grid_params, 'module-spacings', '5');
		
		$top_1_align = $base->getVar($this->grid_params, 'top-1-align', 'center');
		$top_2_align = $base->getVar($this->grid_params, 'top-2-align', 'center');
		$bottom_1_align = $base->getVar($this->grid_params, 'bottom-1-align', 'center');
		$bottom_2_align = $base->getVar($this->grid_params, 'bottom-2-align', 'center');
		
		$top_1_margin = $base->getVar($this->grid_params, 'top-1-margin-bottom', 0, 'i');
		$top_2_margin = $base->getVar($this->grid_params, 'top-2-margin-bottom', 0, 'i');
		$bottom_1_margin = $base->getVar($this->grid_params, 'bottom-1-margin-top', 0, 'i');
		$bottom_2_margin = $base->getVar($this->grid_params, 'bottom-2-margin-top', 0, 'i');
		
		$left_margin = $base->getVar($this->grid_params, 'left-margin-left', 0, 'i');
		$right_margin = $base->getVar($this->grid_params, 'right-margin-right', 0, 'i');
		
		$nav_styles['top-1'] = array('margin-bottom' => $top_1_margin.'px', 'text-align' => $top_1_align);
		$nav_styles['top-2'] = array('margin-bottom' => $top_2_margin.'px', 'text-align' => $top_2_align);
		$nav_styles['left'] = array('margin-left' => $left_margin.'px');
		$nav_styles['right'] = array('margin-right' => $right_margin.'px');
		$nav_styles['bottom-1'] = array('margin-top' => $bottom_1_margin.'px', 'text-align' => $bottom_1_align);
		$nav_styles['bottom-2'] = array('margin-top' => $bottom_2_margin.'px', 'text-align' => $bottom_2_align);
		
		$ajax_container_position = $base->getVar($this->grid_params, 'ajax-container-position', 'top');
		
		if($do_nav){ //only do if internal is selected
			$navigation_c->set_special_class('esg-fgc-'.$this->grid_id);
			
			$filters_meta = array();
			$filters_extra = array();
			
			foreach($this->grid_params as $gkey => $gparam){
			
				if(strpos($gkey, 'filter-selected') === false) continue;
				
				$fil_id = intval(str_replace('filter-selected-', '', $gkey));
				$fil_id = ($fil_id == 0) ? '' : '-'.$fil_id;
				$filters_arr = array();
				
				$filters_arr['filter'.$fil_id]['filter-grouping'] = $base->getVar($this->grid_params, 'filter-grouping'.$fil_id, 'false');
				$filters_arr['filter'.$fil_id]['filter-listing'] = $base->getVar($this->grid_params, 'filter-listing'.$fil_id, 'list');
				$filters_arr['filter'.$fil_id]['filter-selected'] = $base->getVar($this->grid_params, 'filter-selected'.$fil_id, array());
				
				$filter_all_text = $base->getVar($this->grid_params, 'filter-all-text'.$fil_id, __('Filter - All', EG_TEXTDOMAIN));
				$filter_dropdown_text = $base->getVar($this->grid_params, 'filter-dropdown-text'.$fil_id, __('Filter Categories', EG_TEXTDOMAIN));
				$show_count = $base->getVar($this->grid_params, 'filter-counter'.$fil_id, 'off');
		
				if(!empty($filters_arr['filter'.$fil_id]['filter-selected'])){
					if(!empty($posts) && count($posts) > 0){
						foreach($filters_arr['filter'.$fil_id]['filter-selected'] as $fk => $filter){
							if(strpos($filter, 'meta-') === 0){
								unset($filters_arr['filter'.$fil_id]['filter-selected'][$fk]); //delete entry
								
								foreach($posts as $key => $post){
									$fil = str_replace('meta-', '', $filter);
									$post_filter_meta = $meta_c->get_meta_value_by_handle($post['ID'], 'eg-'.$fil);
									if($post_filter_meta == ''){ //check if we are linking
										$post_filter_meta = $meta_link_c->get_link_meta_value_by_handle($post['ID'], 'egl-'.$fil);
									}
									$arr = json_decode($post_filter_meta, true);
									$cur_filter = (is_array($arr)) ? $arr : array($post_filter_meta);
									//$cur_filter = explode(',', $post_filter_meta);
									$add_filter = array();
									if(!empty($cur_filter)){
										foreach($cur_filter as $k => $v){
											if(trim($v) !== ''){
												$add_filter[sanitize_key($v)] = array('name' => $v, 'slug' => sanitize_key($v), 'parent' => '0');
												if(!empty($filters_arr['filter'.$fil_id]['filter-selected'])){
													$filter_found = false;
													foreach($filters_arr['filter'.$fil_id]['filter-selected'] as $fcheck){
														if($fcheck == sanitize_key($v)){
															$filter_found = true;
															break;
														}
													}
													if(!$filter_found){
														$filters_arr['filter'.$fil_id]['filter-selected'][] = sanitize_key($v); //add found meta
													}
												}else{
													$filters_arr['filter'.$fil_id]['filter-selected'][] = sanitize_key($v); //add found meta
												}
											}
										}
										$filters_meta = $filters_meta + $add_filter;
										
										if(!empty($add_filter)) $navigation_c->set_filter($add_filter);
									}
								}
							}
						}
					}
					$filters_extra = $filters_arr['filter'.$fil_id]['filter-selected'] + $filters_extra;
				}

				$navigation_c->set_filter_settings('filter'.$fil_id, $filters_arr['filter'.$fil_id]);
				
				$navigation_c->set_filter_text($filter_all_text, $fil_id);
				$navigation_c->set_dropdown_text($filter_dropdown_text, $fil_id);
				$navigation_c->set_show_count($show_count, $fil_id);
			}
			
			
			$navigation_c->set_filter_type($filter_allow);
			$navigation_c->set_filter_start_select($filter_start);
			$navigation_c->set_specific_styles($nav_styles);
			
			$navigation_c->set_layout($nav_layout); //set the layout
			
			$navigation_c->set_orders($order_by); //set order of filter
			$navigation_c->set_orders_text($sort_by_text); //set order of filter
			$navigation_c->set_orders_start($order_by_start); //set order of filter
			$navigation_c->set_search_text($search_text);
			
		}
		
		$nav_filters = array();
		
		$taxes = array('post_tag');
		if(!empty($cat_tax['tax']))
			$taxes = explode(',', $cat_tax['tax']);
			
		if(!empty($cat_tax['cats'])){
			$cats = explode(',', $cat_tax['cats']);

			foreach($cats as $key => $id){
				if(Essential_Grid_Wpml::is_wpml_exists() && isset($sitepress)){
					$new_id = icl_object_id($id, 'category', true, $sitepress->get_default_language());
					$cat = get_category($new_id);
				}else{
					$cat = get_category($id);
				}
				if(is_object($cat)){
					$nav_filters[$id] = array('name' => $cat->cat_name, 'slug' => sanitize_key($cat->slug), 'parent' => $cat->category_parent);
				}
				
				foreach($taxes as $custom_tax){
					$term = get_term_by('id', $id, $custom_tax);
					if(is_object($term)) $nav_filters[$id] = array('name' => $term->name, 'slug' => sanitize_key($term->slug), 'parent' => $term->parent);
				}
			}
			
			if(!empty($filters_meta)){
				$nav_filters = $filters_meta + $nav_filters;
			}
			if(!empty($add_filter)){
				$nav_filters = $nav_filters + $add_filter;
			}
			asort($nav_filters);
		}
		
        $item_skin->init_by_id($base->getVar($this->grid_params, 'entry-skin', 0, 'i'));
		
		$lazy_load = $base->getVar($this->grid_params, 'lazy-loading', 'off');
		if($lazy_load == 'on'){
			$item_skin->set_lazy_load(true);
			$lazy_load_blur = $base->getVar($this->grid_params, 'lazy-loading-blur', 'on');
			if($lazy_load_blur == 'on')
				$item_skin->set_lazy_load_blur(true);
		}
		
        $default_media_source_order = $base->getVar($this->grid_postparams, 'media-source-order', '');
		$item_skin->set_default_media_source_order($default_media_source_order);
		
        $default_lightbox_source_order = $base->getVar($this->grid_params, 'lb-source-order', '');
		$item_skin->set_default_lightbox_source_order($default_lightbox_source_order);
		
		$default_aj_source_order = $base->getVar($this->grid_params, 'aj-source-order', '');
		$item_skin->set_default_ajax_source_order($default_aj_source_order);
		
		$lightbox_mode = $base->getVar($this->grid_params, 'lightbox-mode', 'single');
		$lightbox_include_media = $base->getVar($this->grid_params, 'lightbox-exclude-media', 'off');
		
		$post_media_source_type = $base->getVar($this->grid_postparams, 'image-source-type', 'full');
		
		$default_video_poster_order = $base->getVar($this->grid_params, 'poster-source-order', '');
		if($default_video_poster_order == '')
			$default_video_poster_order = $base->getVar($this->grid_postparams, 'poster-source-order', '');
		
		$item_skin->set_default_video_poster_order($default_video_poster_order);
		
		$layout = $base->getVar($this->grid_params, 'layout','even');
        $layout_sizing = $base->getVar($this->grid_params, 'layout-sizing', 'boxed');
		
		if($layout_sizing !== 'fullwidth' && $layout == 'masonry'){
			$item_skin->set_poster_cropping(true);
		}
		
		$found_filter = array();
		$i = 1;
		
		/*if($lightbox_mode == 'content' || $lightbox_mode == 'content-gallery' || $lightbox_mode == 'woocommerce-gallery'){
			$item_skin->set_lightbox_rel('ess-'.$this->grid_id);
		}
		*/
		if(!empty($posts) && count($posts) > 0){
			foreach($posts as $key => $post){
				if($grid_preview == false){
					//check if post should be visible or if its invisible on current grid settings
					$is_visible = $this->check_if_visible($post['ID'], $this->grid_id);
					if($is_visible == false) continue; // continue if invisible
				}

				if($lightbox_mode == 'content' || $lightbox_mode == 'content-gallery' || $lightbox_mode == 'woocommerce-gallery'){
					//$item_skin->set_lightbox_rel('ess-'.$this->grid_id);
					$item_skin->set_lightbox_rel('ess-'.$post['ID']);
				}
				
				$post_media_source_data = $base->get_post_media_source_data($post['ID'], $post_media_source_type);
				$post_video_ratios = $m->get_post_video_ratios($post['ID']);
				$filters = array();
				
				//$categories = get_the_category($post['ID']);
				$categories = $base->get_custom_taxonomies_by_post_id($post['ID']);
				//$tags = wp_get_post_terms($post['ID']);
				$tags = get_the_tags($post['ID']);
				
				if(!empty($categories)){
					foreach($categories as $key => $category){
						$filters[$category->term_id] = array('name' => $category->name, 'slug' => sanitize_key($category->slug), 'parent' => $category->parent);
					}
				}
				
				if(!empty($tags)){
					foreach($tags as $key => $taxonomie){
						$filters[$taxonomie->term_id] = array('name' => $taxonomie->name, 'slug' => sanitize_key($taxonomie->slug), 'parent' => '0');
					}
				}
				
				foreach($this->grid_params as $gp_handle => $gp_values){
					if(strpos($gp_handle, 'filter-selected') !== 0) continue;
					
					$filter_meta_selected = $base->getVar($this->grid_params, $gp_handle, array());
					
					if(!empty($filter_meta_selected)){
						foreach($filter_meta_selected as $filter){
							if(strpos($filter, 'meta-') === 0){
								$fil = str_replace('meta-', '', $filter);
								$post_filter_meta = $meta_c->get_meta_value_by_handle($post['ID'], 'eg-'.$fil);
								if($post_filter_meta == ''){ //check if we are linking
									$post_filter_meta = $meta_link_c->get_link_meta_value_by_handle($post['ID'], 'egl-'.$fil, 'asd');
								}
								
								$arr = json_decode($post_filter_meta, true);
								$cur_filter = (is_array($arr)) ? $arr : array($post_filter_meta);
								//$cur_filter = explode(',', $post_filter_meta);
								if(!empty($cur_filter)){
									foreach($cur_filter as $k => $v){
										if(trim($v) !== '')
											$filters[sanitize_key($v)] = array('name' => $v, 'slug' => sanitize_key($v), 'parent' => '0');
									}
								}
							}
						}
					}
				}
				
				if(is_array($order_by) && !empty($order_by)){
					$sort = $this->prepare_sorting_array_by_post($post, $order_by);
					$item_skin->set_sorting($sort);
				}
				
				$found_filter = $found_filter + $filters; //these are the found filters, only show filter that the posts have
				
				//switch to different skin
				$use_item_skin_id = json_decode(get_post_meta($post['ID'], 'eg_use_skin', true), true);
				if($use_item_skin_id !== false && isset($use_item_skin_id[$this->grid_id]['use-skin'])){
					$use_item_skin_id = $use_item_skin_id[$this->grid_id]['use-skin'];
				}else{
					$use_item_skin_id = -1;
				}
				
				$use_item_skin_id = apply_filters('essgrid_modify_post_item_skin', $use_item_skin_id, $post, $this->grid_id);
				
				$item_skin->switch_item_skin($use_item_skin_id);
				$item_skin->register_layer_css();
				$item_skin->register_skin_css();
				
				if($i > $post_limit){
					$this->load_more_post_array[$post['ID']] = $filters; //set for load more, only on elements that will not be loaded from beginning
					continue; //Load only selected numbers of items at start (for load more)
				}
				$i++;
				
				if($lightbox_mode == 'content' || $lightbox_mode == 'content-gallery' || $lightbox_mode == 'woocommerce-gallery'){
					switch($lightbox_mode){
						case 'content':
							$lb_add_images = $base->get_all_content_images($post['ID']);
						break;
						case 'content-gallery':
							$lb_add_images = $base->get_all_gallery_images($post['post_content'], true);
						break;
						case 'woocommerce-gallery':
							$lb_add_images = array();
							if(Essential_Grid_Woocommerce::is_woo_exists()){
								$lb_add_images = Essential_Grid_Woocommerce::get_image_attachements($post['ID'], true);
							}
						break;
					}
					
					$item_skin->set_lightbox_addition(array('items' => $lb_add_images, 'base' => $lightbox_include_media));
				}
				
				$item_skin->set_filter($filters);
				$item_skin->set_media_sources($post_media_source_data);
				$item_skin->set_media_sources_type($post_media_source_type);
				$item_skin->set_video_ratios($post_video_ratios);
				$item_skin->set_post_values($post);
				
				ob_start();
				$item_skin->output_item_skin($grid_preview);
				$skins_html.= ob_get_contents();
				ob_clean();
				ob_end_clean();
				
				if($grid_preview == false){
					ob_start();
					$item_skin->output_element_css_by_meta($post['ID']);
					$skins_css.= ob_get_contents();
					ob_clean();
					ob_end_clean();
				}
			}
		}else{
			return false;
		}
		
		if(!empty($filters_extra)){
			foreach($filters_extra as $f_extra){
				$f_extra = explode('_', $f_extra);
				if(is_array($f_extra) && !empty($f_extra)){
					$cid = end($f_extra);
					if(Essential_Grid_Wpml::is_wpml_exists() && isset($sitepress)){
						$new_id = icl_object_id($cid, 'category', true, $sitepress->get_default_language());
						$ncat = get_category($new_id);
						if(!is_wp_error($ncat)){
							$found_filter[$ncat->term_id] = array('name' => $ncat->name, 'slug' => $ncat->slug, 'parent' => $ncat->{'parent'});
							$nav_filters[$ncat->term_id] = array('name' => $ncat->name, 'slug' => $ncat->slug, 'parent' => $ncat->{'parent'});
						}
					}else{
						$ncat = get_category($cid);
						if(!is_wp_error($ncat)){
							$found_filter[$ncat->term_id] = array('name' => $ncat->name, 'slug' => $ncat->slug, 'parent' => $ncat->{'parent'});
							$nav_filters[$ncat->term_id] = array('name' => $ncat->name, 'slug' => $ncat->slug, 'parent' => $ncat->{'parent'});
						}
					}
				}
			}
		}
		
		$remove_filter = array_diff_key($nav_filters, $found_filter); //check if we have filter that no post has (comes through multilanguage)
		if(!empty($remove_filter)){
			foreach($remove_filter as $key => $rem){ //we have, so remove them from the filter list before setting the filter list
				unset($nav_filters[$key]);
			}
		}
		
		if($do_nav){ //only do if internal is selected
			$navigation_c->set_filter($nav_filters); //set filters $nav_filters $found_filter
			$navigation_c->set_filter_type($filter_allow);
			$navigation_c->set_filter_start_select($filter_start);
		}
		
		ob_start();
		$item_skin->generate_element_css();
		$skins_css.= ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		if($do_nav){ //only do if internal is selected
			$found_skin = array();
			$navigation_skin = $base->getVar($this->grid_params, 'navigation-skin', 'minimal-light');
			$navigation_special_skin = $base->getVar($this->grid_params, 'navigation-special-skin', array());
			ob_start();
			echo $navigation_c->output_navigation_skin($navigation_skin);
			$found_skin[$navigation_skin] = true;
			
			if(!empty($navigation_special_skin)){
				foreach($navigation_special_skin as $spec_skin){
					if(!isset($found_skin[$spec_skin])){
						echo $navigation_c->output_navigation_skin($spec_skin);
						$found_skin[$spec_skin] = true;
					}
				}
			}
			$nav_css = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			echo $nav_css;
		}
		
		echo $skins_css;
		
		if($item_skin->ajax_loading == true && $ajax_container_position == 'top'){
			echo $this->output_ajax_container();
		}
		
		$this->output_wrapper_pre($grid_preview);
		if($do_nav){ //only do if internal is selected
			$navigation_c->output_layout('top-1', $module_spacings);
			$navigation_c->output_layout('top-2', $module_spacings);
		}
		
		$this->output_grid_pre();
		
		echo $skins_html;
		
		$this->output_grid_post();
		if($do_nav){ //only do if internal is selected
			$navigation_c->output_layout('bottom-1', $module_spacings);
			$navigation_c->output_layout('bottom-2', $module_spacings);
			$navigation_c->output_layout('left');
			$navigation_c->output_layout('right');
			
			//check if search was added. If yes, we also need to add the "Filter All" filter if not existing
			echo $navigation_c->check_for_search();
		}
		
		$this->output_wrapper_post();
		
		if($item_skin->ajax_loading == true && $ajax_container_position == 'bottom'){
			echo $this->output_ajax_container();
		}
		
		$load_lightbox = $item_skin->do_lightbox_loading();
		
		if($grid_preview === false){
			$this->output_grid_javascript($load_lightbox);
		}elseif($grid_preview !== 'preview'){
			$this->output_grid_javascript($load_lightbox, true);
		}
		
		do_action('essgrid_output_by_posts_post', $this, $grid_preview);
	}
    
	
	/**
	 * Output by specific posts for load more
	 */
	public function output_by_specific_posts(){
		do_action('essgrid_output_by_specific_posts_pre', $this);
		
		$base = new Essential_Grid_Base();
		$item_skin = new Essential_Grid_Item_Skin();
		$item_skin->grid_id = $this->grid_id;
		$item_skin->set_grid_type($base->getVar($this->grid_params, 'layout','even'));
		$meta_c = new Essential_Grid_Meta();
		$meta_link_c = new Essential_Grid_Meta_Linking();
		
		$item_skin->set_default_image_by_id($base->getVar($this->grid_postparams, 'default-image', 0, 'i'));
		
		$m = new Essential_Grid_Meta();
		
		$start_sortby = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		
		$start_sortby_type = $base->getVar($this->grid_params, 'sorting-order-type', 'ASC');
		
		if(!empty($this->filter_by_ids)){
			$posts = Essential_Grid_Base::get_posts_by_ids($this->filter_by_ids, $start_sortby, $start_sortby_type);
		}else{
			return false;
		}
		
        $item_skin->init_by_id($base->getVar($this->grid_params, 'entry-skin', 0, 'i'));
		$order_by = explode(',', $base->getVar($this->grid_params, 'sorting-order-by', 'date'));
		if(!is_array($order_by)) $order_by = array($order_by);
		
		
		$lazy_load = $base->getVar($this->grid_params, 'lazy-loading', 'off');
		if($lazy_load == 'on'){
			$item_skin->set_lazy_load(true);
			$lazy_load_blur = $base->getVar($this->grid_params, 'lazy-loading-blur', 'on');
			if($lazy_load_blur == 'on')
				$item_skin->set_lazy_load_blur(true);
		}
		
        $default_media_source_order = $base->getVar($this->grid_postparams, 'media-source-order', '');
		$item_skin->set_default_media_source_order($default_media_source_order);
		
		$default_lightbox_source_order = $base->getVar($this->grid_params, 'lb-source-order', '');
		$item_skin->set_default_lightbox_source_order($default_lightbox_source_order);
		
		$lightbox_mode = $base->getVar($this->grid_params, 'lightbox-mode', 'single');
		$lightbox_include_media = $base->getVar($this->grid_params, 'lightbox-exclude-media', 'off');
		
        $default_aj_source_order = $base->getVar($this->grid_params, 'aj-source-order', '');
		$item_skin->set_default_ajax_source_order($default_aj_source_order);
		
		$post_media_source_type = $base->getVar($this->grid_postparams, 'image-source-type', 'full');
		
		$default_video_poster_order = $base->getVar($this->grid_params, 'poster-source-order', '');
		if($default_video_poster_order == '')
			$default_video_poster_order = $base->getVar($this->grid_postparams, 'poster-source-order', '');
		
		$item_skin->set_default_video_poster_order($default_video_poster_order);
		
		$layout = $base->getVar($this->grid_params, 'layout','even');
        $layout_sizing = $base->getVar($this->grid_params, 'layout-sizing', 'boxed');
		
		if($layout_sizing !== 'fullwidth' && $layout == 'masonry'){
			$item_skin->set_poster_cropping(true);
		}
		
		$skins_html = '';
		
		if($lightbox_mode == 'content' || $lightbox_mode == 'content-gallery' || $lightbox_mode == 'woocommerce-gallery'){
			$item_skin->set_lightbox_rel('ess-'.$this->grid_id);
		}
		
		if(!empty($posts) && count($posts) > 0){
			foreach($posts as $key => $post){
				//check if post should be visible or if its invisible on current grid settings
				$is_visible = $this->check_if_visible($post['ID'], $this->grid_id);
				
				if($is_visible == false) continue; // continue if invisible
				
				$post_media_source_data = $base->get_post_media_source_data($post['ID'], $post_media_source_type);
				$post_video_ratios = $m->get_post_video_ratios($post['ID']);
				
				$filters = array();
				
				//$categories = get_the_category($post['ID']);
				$categories = $base->get_custom_taxonomies_by_post_id($post['ID']);
				//$tags = wp_get_post_terms($post['ID']);
				$tags = get_the_tags($post['ID']);
				
				if(!empty($categories)){
					foreach($categories as $key => $category){
						$filters[$category->term_id] = array('name' => $category->name, 'slug' => sanitize_key($category->slug));
					}
				}
				
				if(!empty($tags)){
					foreach($tags as $key => $taxonomie){
						$filters[$taxonomie->term_id] = array('name' => $taxonomie->name, 'slug' => sanitize_key($taxonomie->slug));
					}
				}
				
				foreach($this->grid_params as $gp_handle => $gp_values){
					if(strpos($gp_handle, 'filter-selected') !== 0) continue;
					
					$filter_meta_selected = $base->getVar($this->grid_params, $gp_handle, array());
					
					if(!empty($filter_meta_selected)){
						foreach($filter_meta_selected as $filter){
							if(strpos($filter, 'meta-') === 0){
								$fil = str_replace('meta-', '', $filter);
								$post_filter_meta = $meta_c->get_meta_value_by_handle($post['ID'], 'eg-'.$fil);
								if($post_filter_meta == ''){ //check if we are linking
									$post_filter_meta = $meta_link_c->get_link_meta_value_by_handle($post['ID'], 'egl-'.$fil, 'asd');
								}
								
								$arr = json_decode($post_filter_meta, true);
								$cur_filter = (is_array($arr)) ? $arr : array($post_filter_meta);
								//$cur_filter = explode(',', $post_filter_meta);
								if(!empty($cur_filter)){
									foreach($cur_filter as $k => $v){
										if(trim($v) !== '')
											$filters[sanitize_key($v)] = array('name' => $v, 'slug' => sanitize_key($v), 'parent' => '0');
									}
								}
							}
						}
					}
				}
				
				if(is_array($order_by) && !empty($order_by)){
					$sort = $this->prepare_sorting_array_by_post($post, $order_by);
					$item_skin->set_sorting($sort);
				}
				
				if($lightbox_mode == 'content' || $lightbox_mode == 'content-gallery' || $lightbox_mode == 'woocommerce-gallery'){
					switch($lightbox_mode){
						case 'content':
							$lb_add_images = $base->get_all_content_images($post['ID']);
						break;
						case 'content-gallery':
							$lb_add_images = $base->get_all_gallery_images($post['post_content'], true);
						break;
						case 'woocommerce-gallery':
							$lb_add_images = array();
							if(Essential_Grid_Woocommerce::is_woo_exists()){
								$lb_add_images = Essential_Grid_Woocommerce::get_image_attachements($post['ID'], true);
							}
						break;
					}
					
					$item_skin->set_lightbox_addition(array('items' => $lb_add_images, 'base' => $lightbox_include_media));
				}
				
				$item_skin->set_filter($filters);
				$item_skin->set_media_sources($post_media_source_data);
				$item_skin->set_media_sources_type($post_media_source_type);
				$item_skin->set_video_ratios($post_video_ratios);
				$item_skin->set_post_values($post);
				$item_skin->set_load_more();
				
				//switch to different skin
				$use_item_skin_id = json_decode(get_post_meta($post['ID'], 'eg_use_skin', true), true);
				if($use_item_skin_id !== false && isset($use_item_skin_id[$this->grid_id]['use-skin'])){
					$use_item_skin_id = $use_item_skin_id[$this->grid_id]['use-skin'];
				}else{
					$use_item_skin_id = -1;
				}
				
				$use_item_skin_id = apply_filters('essgrid_modify_post_item_skin', $use_item_skin_id, $post, $this->grid_id);
				
				$item_skin->switch_item_skin($use_item_skin_id);
				$item_skin->register_layer_css();
				$item_skin->register_skin_css();
				
				ob_start();
				$item_skin->output_item_skin();
				$skins_html.= ob_get_contents();
				ob_clean();
				ob_end_clean();
				
			}
		}else{
			$skins_html = false;
		}
		
		do_action('essgrid_output_by_specific_posts_post', $this, $skins_html);
		
		return apply_filters('essgrid_output_by_specific_posts_return', $skins_html, $this);
		
	}
    
	
	/**
	 * Output by specific ids for load more custom grid
	 */
	public function output_by_specific_ids(){
		
		do_action('essgrid_output_by_specific_ids_pre', $this);
		
		$base = new Essential_Grid_Base();
		$item_skin = new Essential_Grid_Item_Skin();
		$item_skin->grid_id = $this->grid_id;
		$item_skin->set_grid_type($base->getVar($this->grid_params, 'layout','even'));
		
		$item_skin->set_default_image_by_id($base->getVar($this->grid_postparams, 'default-image', 0, 'i'));
		
		$m = new Essential_Grid_Meta();
		
		$filters = array();
		
		$order_by = explode(',', $base->getVar($this->grid_params, 'sorting-order-by', 'date'));
		if(!is_array($order_by)) $order_by = array($order_by);
		
        $item_skin->init_by_id($base->getVar($this->grid_params, 'entry-skin', 0, 'i'));
		
		$lazy_load = $base->getVar($this->grid_params, 'lazy-loading', 'off');
		if($lazy_load == 'on'){
			$item_skin->set_lazy_load(true);
			$lazy_load_blur = $base->getVar($this->grid_params, 'lazy-loading-blur', 'on');
			if($lazy_load_blur == 'on')
				$item_skin->set_lazy_load_blur(true);
		}
		
        $default_media_source_order = $base->getVar($this->grid_postparams, 'media-source-order', '');
		$item_skin->set_default_media_source_order($default_media_source_order);
		
        $default_lightbox_source_order = $base->getVar($this->grid_params, 'lb-source-order', '');
		$item_skin->set_default_lightbox_source_order($default_lightbox_source_order);
		
        $default_aj_source_order = $base->getVar($this->grid_params, 'aj-source-order', '');
		$item_skin->set_default_ajax_source_order($default_aj_source_order);
		
		$post_media_source_type = $base->getVar($this->grid_postparams, 'image-source-type', 'full');
		
		$default_video_poster_order = $base->getVar($this->grid_params, 'poster-source-order', '');
		if($default_video_poster_order == '')
			$default_video_poster_order = $base->getVar($this->grid_postparams, 'poster-source-order', '');
		
		$item_skin->set_default_video_poster_order($default_video_poster_order);
		
		$layout = $base->getVar($this->grid_params, 'layout','even');
        $layout_sizing = $base->getVar($this->grid_params, 'layout-sizing', 'boxed');
		
		if($layout_sizing !== 'fullwidth' && $layout == 'masonry'){
			$item_skin->set_poster_cropping(true);
		}
		
		$skins_html = '';
		
		$found_filter = array();
		
		$order_by_start = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		$order_by_dir = $base->getVar($this->grid_params, 'sorting-order-type', 'ASC');
		
		$this->order_by_custom($order_by_start, $order_by_dir);
		
		if(!empty($this->grid_layers) && count($this->grid_layers) > 0){
			foreach($this->grid_layers as $key => $entry){
				
				if(!in_array($key, $this->filter_by_ids)) continue;
			
				$post_media_source_data = $base->get_custom_media_source_data($entry, $post_media_source_type);
				$post_video_ratios = $m->get_custom_video_ratios($entry);
				$filters = array();
				
				if(is_array($order_by) && !empty($order_by)){
					//$sort = $this->prepare_sorting_array_by_post($post, $order_by);
					//$item_skin->set_sorting($sort);
				}
				if(!empty($entry['custom-filter'])){
					$cats = explode(',', $entry['custom-filter']);
					if(!is_array($cats)) $cats = (array)$cats;
					foreach($cats as $category){
						$filters[sanitize_key($category)] = array('name' => $category, 'slug' => sanitize_key($category));
					}
				}
				
				$found_filter = $found_filter + $filters; //these are the found filters, only show filter that the posts have
				
				$item_skin->set_filter($filters);
				$item_skin->set_media_sources($post_media_source_data);
				$item_skin->set_media_sources_type($post_media_source_type);
				$item_skin->set_video_ratios($post_video_ratios);
				$item_skin->set_layer_values($entry);
				$item_skin->set_load_more();
				
				//switch to different skin
				$use_item_skin_id = $base->getVar($entry, 'use-skin', '-1');
				if(intval($use_item_skin_id) === 0){
					$use_item_skin_id = -1;
				}
				$item_skin->switch_item_skin($use_item_skin_id);
				$item_skin->register_layer_css();
				$item_skin->register_skin_css();
				
				ob_start();
				$item_skin->output_item_skin();
				$skins_html.= ob_get_contents();
				ob_clean();
				ob_end_clean();
				
			}
		}else{
			$skins_html = false;
		}
		
		do_action('essgrid_output_by_specific_ids_post', $this, $skins_html);
		
		return apply_filters('essgrid_output_by_specific_ids_return', $skins_html, $this);
		
	}
	
	
	public function prepare_sorting_array_by_post($post, $order_by){
		$d = apply_filters('essgrid_prepare_sorting_array_by_post_pre', array('post' => $post, 'order_by' => $order_by));
		$post = $d['post'];
		$order_by = $d['order_by'];
		
		$base = new Essential_Grid_Base();
		$link_meta = new Essential_Grid_Meta_Linking();
		$meta = new Essential_Grid_Meta();
		
		$m = $meta->get_all_meta(false);
		$lm = $link_meta->get_all_link_meta(false);
		
		$sorts = array();
		foreach($order_by as $order){
			switch($order){
				case 'date':
					$sorts['date'] = strtotime($base->getVar($post, 'post_date'));
				break;
				case 'title':
					$sorts['title'] = substr($base->getVar($post, 'post_title', ''), 0, 10);
				break;
				case 'excerpt':
					$sorts['excerpt'] = substr(strip_tags($base->getVar($post, 'post_excerpt', '')), 0, 10);
				break;
				case 'id':
					$sorts['id'] = $base->getVar($post, 'ID');
				break;
				case 'slug':
					$sorts['slug'] = $base->getVar($post, 'post_name');
				break;
				case 'author':
					$authorID = $base->getVar($post, 'post_author');
					$sorts['author'] = get_the_author_meta('display_name', $authorID);
				break;
				case 'last-modified':
					$sorts['last-modified'] = strtotime($base->getVar($post, 'post_modified'));
				break;
				case 'number-of-comments':
					$sorts['number-of-comments'] = $base->getVar($post, 'comment_count');
				break;
				case 'random':
					$sorts['random'] = rand(0,9999);
				break;
				default: //check if meta. If yes, add meta values
					if(strpos($order, 'eg-') === 0){
						if(!empty($m)){
							foreach($m as $me){
								if('eg-'.$me['handle'] == $order){
									$sorts[$order] = $meta->get_meta_value_by_handle($post['ID'],$order);
									break;
								}
							}
						}
					}elseif(strpos($order, 'egl-') === 0){
						if(!empty($lm)){
							foreach($lm as $me){
								if('egl-'.$me['handle'] == $order){
									$sorts[$order] = $link_meta->get_link_meta_value_by_handle($post['ID'],$order);
									break;
								}
							}
						}
					}
				break;
			}
		}
		
		//add woocommerce sortings
		if(Essential_Grid_Woocommerce::is_woo_exists()){
			$product = get_product($post['ID']);
			if(!empty($product)){
				foreach($order_by as $order){
					switch($order){
						case 'meta_num_total_sales':
							$sorts['total-sales'] = get_post_meta($post['ID'],$order,true);
						break;
						case 'meta_num__regular_price':
							$sorts['regular-price'] = $product->get_price();
						break;
						//case 'meta_num__sale_price':
						//	$sorts['sale-price'] = $product->get_sale_price();
						//break;
						case 'meta__featured':
							$sorts['featured'] = ($product->is_featured()) ? '1' : '0';
						break;
						case 'meta__sku':
							$sorts['sku'] = $product->get_sku();
						break;
						case 'meta_num_stock':
							$sorts['in-stock'] = $product->get_stock_quantity();
						break;
					}
				}
			}
		}
		
		return apply_filters('essgrid_prepare_sorting_array_by_post_post', $sorts, $post, $order_by);
	}
	
	
	public function prepare_sorting_array_by_custom($post, $order_by){
		$d = apply_filters('essgrid_prepare_sorting_array_by_custom_pre', array('post' => $post, 'order_by' => $order_by));
		$post = $d['post'];
		$order_by = $d['order_by'];
		
		$base = new Essential_Grid_Base();
		$link_meta = new Essential_Grid_Meta_Linking();
		$meta = new Essential_Grid_Meta();
		
		$m = $meta->get_all_meta(false);
		$lm = $link_meta->get_all_link_meta(false);
		
		$sorts = array();
		foreach($order_by as $order){
			switch($order){
				case 'date':
					$sorts['date'] = strtotime($base->getVar($post, 'date'));
				break;
				case 'title':
					$sorts['title'] = substr($base->getVar($post, 'title', ''), 0, 10);
				break;
				case 'excerpt':
					$sorts['excerpt'] = substr(strip_tags($base->getVar($post, 'excerpt', '')), 0, 10);
				break;
				case 'id':
					$sorts['id'] = $base->getVar($post, 'post_id');
				break;
				case 'slug':
					$sorts['slug'] = $base->getVar($post, 'alias');
				break;
				case 'author':
					$sorts['author'] = $base->getVar($post, 'author_name');
				break;
				case 'last-modified':
					$sorts['last-modified'] = strtotime($base->getVar($post, 'date_modified'));
				break;
				case 'number-of-comments':
					$sorts['number-of-comments'] = $base->getVar($post, 'num_comments');
				break;
				case 'random':
					$sorts['random'] = rand(0,9999);
				break;
				case 'views':
					$sorts['views'] = $base->getVar($post, 'views');
				break;
				case 'likes':
					$sorts['likes'] = $base->getVar($post, 'likes');
				break;
				case 'dislikes':
					$sorts['dislikes'] = $base->getVar($post, 'dislikes');
				break;
				case 'retweets':
					$sorts['retweets'] = $base->getVar($post, 'retweets');
				break;
				case 'favorites':
					$sorts['favorites'] = $base->getVar($post, 'favorites');
				break;
				case 'itemCount':
					$sorts['itemCount'] = $base->getVar($post, 'itemCount');
				break;
				case 'duration':
					$sorts['duration'] = $base->getVar($post, 'duration');
				break;
				default: //check if meta. If yes, add meta values
					if(strpos($order, 'eg-') === 0 || strpos($order, 'egl-') === 0){
						$sorts[$order] = $base->getVar($post, $order);
					}
				break;
			}
		}
		
		return apply_filters('essgrid_prepare_sorting_array_by_custom_post', $sorts, $post, $order_by);
	}

	public function prepare_sorting_array_by_stream($post, $order_by){
		$d = apply_filters('essgrid_prepare_sorting_array_by_stream_pre', array('post' => $post, 'order_by' => $order_by));
		$post = $d['post'];
		$order_by = $d['order_by'];
		
		$base = new Essential_Grid_Base();
		$link_meta = new Essential_Grid_Meta_Linking();
		$meta = new Essential_Grid_Meta();
		
		$m = $meta->get_all_meta(false);
		$lm = $link_meta->get_all_link_meta(false);
		
		$sorts = array();
		foreach($order_by as $order){
			switch($order){
				case 'date':
					$sorts['date'] = strtotime($base->getVar($post, 'date'));
				break;
				case 'title':
					$sorts['title'] = substr($base->getVar($post, 'title', ''), 0, 10);
				break;
				case 'excerpt':
					$sorts['excerpt'] = substr(strip_tags($base->getVar($post, 'excerpt', '')), 0, 10);
				break;
				case 'id':
					$sorts['id'] = $base->getVar($post, 'post_id');
				break;
				case 'slug':
					$sorts['slug'] = $base->getVar($post, 'alias');
				break;
				case 'author':
					$sorts['author'] = $base->getVar($post, 'author_name');
				break;
				case 'last-modified':
					$sorts['last-modified'] = strtotime($base->getVar($post, 'date_modified'));
				break;
				case 'number-of-comments':
					$sorts['number-of-comments'] = $base->getVar($post, 'num_comments');
				break;
				case 'random':
					$sorts['random'] = rand(0,9999);
				break;
				case 'views':
					$sorts['views'] = $base->getVar($post, 'views');
				break;
				default: //check if meta. If yes, add meta values
					if(strpos($order, 'eg-') === 0 || strpos($order, 'egl-') === 0){
						$sorts[$order] = $base->getVar($post, $order);
					}
				break;
			}
		}
		
		return apply_filters('essgrid_prepare_sorting_array_by_stream_post', $sorts, $post, $order_by);
	}
	
	
    public function output_wrapper_pre($grid_preview = false){
		global $esg_grid_serial;
		
        $base = new Essential_Grid_Base();
        
		
        $esg_grid_serial++;
		
		if($this->grid_div_name === null) $this->grid_div_name = $this->grid_id;
		
		$grid_id = ($grid_preview !== false) ? 'esg-preview-grid' : 'esg-grid-'.$this->grid_div_name.'-'.$esg_grid_serial;
		$grid_id_wrap = $grid_id . '-wrap';
		$article_id = ($grid_preview !== false) ? ' esg-preview-skinlevel' : '';
		
        $hide_markup_before_load = $base->getVar($this->grid_params, 'hide-markup-before-load', 'off');
        $background_color = $base->getVar($this->grid_params, 'main-background-color', 'transparent');
        $navigation_skin = $base->getVar($this->grid_params, 'navigation-skin', 'minimal-light');
        $paddings = $base->getVar($this->grid_params, 'grid-padding', 0);
        $css_id = $base->getVar($this->grid_params, 'css-id', '');
		$source_type = $base->getVar($this->grid_postparams, 'source-type', 'post');
		
		$pad_style = '';
		
		if(is_array($paddings) && !empty($paddings)){
			$pad_style = 'padding: ';
			foreach($paddings as $size){
				$pad_style .= $size.'px ';
			}
			$pad_style .= ';';
			
			$pad_style .= ' box-sizing:border-box;';
			$pad_style .= ' -moz-box-sizing:border-box;';
			$pad_style .= ' -webkit-box-sizing:border-box;';
		}
		
		$div_style = ' style="';
		$div_style.= 'background-color: '.$background_color.';';
		$div_style.= $pad_style;
		if($hide_markup_before_load == 'on')
			$div_style.= ' display:none';
		
		$div_style.= '"';
        
		if($css_id == '') $css_id = $grid_id_wrap;
		
		$do_fix_height = $this->add_start_height_css($css_id);
		
		$this->remove_load_more_button($css_id);
		
		$fix_height_class = ($do_fix_height) ? ' eg-startheight' : '';
		
        $n = '<!-- THE ESSENTIAL GRID '. self::VERSION .' '.strtoupper($source_type).' -->'."\n\n";
        
		//$n .= '<!-- GRID WRAPPER FOR CONTAINER SIZING - HERE YOU CAN SET THE CONTAINER SIZE AND CONTAINER SKIN -->'."\n";
		$n .= '<article class="myportfolio-container '.$navigation_skin.$fix_height_class.'" id="'.$css_id.$article_id.'">'."\n\n"; //fullwidthcontainer-with-padding 
        
        //$n .= '    <!-- THE GRID ITSELF WITH FILTERS, PAGINATION, SORTING ETC -->'."\n";
		$n .= '    <div id="'.$grid_id.'" class="esg-grid"'.$div_style.'>'."\n";
        
		echo apply_filters('essgrid_output_wrapper_pre', $n, $grid_preview);
		
        
    }
    
    
    public function output_wrapper_post(){
        
        $n  = '    </div>'."\n\n"; //<!-- END OF THE GRID -->'."\n\n";
		$n .= '</article>'."\n";
		//$n .= '<!-- END OF THE GRID WRAPPER -->'."\n\n";
		$n .= '<div class="clear"></div>'."\n";
        
		echo apply_filters('essgrid_output_wrapper_post', $n);
        
    }
    
    
    public function output_grid_pre(){
        
		//$n  = '<!-- ############################ -->'."\n";
		//$n .= '<!-- THE GRID ITSELF WITH ENTRIES -->'."\n";
		//$n .= '<!-- ############################ -->'."\n";
        $n = '<ul>'."\n";
        
		echo apply_filters('essgrid_output_grid_pre', $n);
        
    }
    
    
    public function output_grid_post(){
        
        $n  = '</ul>'."\n";
        //$n .= '<!-- ############################ -->'."\n";
        //$n .= '<!--      END OF THE GRID         -->'."\n";
        //$n .= '<!-- ############################ -->'."\n";
        
		echo apply_filters('essgrid_output_grid_post', $n);
        
    }
    
    
    public function output_grid_javascript($load_lightbox = false, $is_demo = false){
		global $esg_grid_serial;
		
        $base = new Essential_Grid_Base();
		
		$hide_markup_before_load = $base->getVar($this->grid_params, 'hide-markup-before-load', 'off');
		
        $layout = $base->getVar($this->grid_params, 'layout','even');
        $force_full_width = $base->getVar($this->grid_params, 'force_full_width', 'off');
		
        $content_push = $base->getVar($this->grid_params, 'content-push', 'off');
        
        $rows_unlimited = $base->getVar($this->grid_params, 'rows-unlimited', 'on');
        $load_more_type = $base->getVar($this->grid_params, 'load-more', 'on');
		$rows = $base->getVar($this->grid_params, 'rows', 4, 'i');
		
        $columns = $base->getVar($this->grid_params, 'columns', '');
        $columns = $base->set_basic_colums($columns);
		
		$columns_advanced = $base->getVar($this->grid_params, 'columns-advanced', 'off');
        if($columns_advanced == 'on'){
            $columns_width = $base->getVar($this->grid_params, 'columns-width', '');
			if($layout == 'masonry'){
				$masonry_content_height = $base->getVar($this->grid_params, 'mascontent-height', '');
			}else{
				$masonry_content_height = array(); //get defaults
			}
        }else{
            $columns_width = array(); //get defaults
            $masonry_content_height = array(); //get defaults
		}
        
        $columns_width = $base->set_basic_colums_width($columns_width);
        $masonry_content_height = $base->set_basic_masonry_content_height($masonry_content_height);
        
        $space = $base->getVar($this->grid_params, 'spacings', 0, 'i');
        $page_animation = $base->getVar($this->grid_params, 'grid-animation', 'scale');
        $anim_speed = $base->getVar($this->grid_params, 'grid-animation-speed', 800, 'i');
        $delay_basic = $base->getVar($this->grid_params, 'grid-animation-delay', 1, 'i');
        $delay_hover = $base->getVar($this->grid_params, 'hover-animation-delay', 1, 'i');
        $filter_type = $base->getVar($this->grid_params, 'filter-arrows', 'single');
        $filter_logic = $base->getVar($this->grid_params, 'filter-logic', 'or');
        $filter_show_on = $base->getVar($this->grid_params, 'filter-show-on', 'hover');
		
        $lightbox_mode = $base->getVar($this->grid_params, 'lightbox-mode', 'single');
		$lightbox_mode = ($lightbox_mode == 'content' || $lightbox_mode == 'content-gallery' || $lightbox_mode == 'woocommerce-gallery') ? 'contentgroup' : $lightbox_mode;
		
        $layout_sizing = $base->getVar($this->grid_params, 'layout-sizing', 'boxed');
        $layout_offset_container = $base->getVar($this->grid_params, 'fullscreen-offset-container', '');
        
        $aspect_ratio_x = $base->getVar($this->grid_params, 'x-ratio', 4, 'i');
        $aspect_ratio_y = $base->getVar($this->grid_params, 'y-ratio', 3, 'i');
        $auto_ratio = $base->getVar($this->grid_params, 'auto-ratio', 'true');
        
        $lazy_load = $base->getVar($this->grid_params, 'lazy-loading', 'off');
        $lazy_load_color = $base->getVar($this->grid_params, 'lazy-load-color', '#FFFFFF');
		
		$spinner = $base->getVar($this->grid_params, 'use-spinner', '0');
		$spinner_color = $base->getVar($this->grid_params, 'spinner-color', '#FFFFFF');
		
		
		//LIGHTBOX VARIABLES
		$usetwitter = $base->getVar($this->grid_params, 'lightbox-twitter','off');
		$usefacebook = $base->getVar($this->grid_params, 'lightbox-facebook','off');		
		$lightbox_title_type = $base->getVar($this->grid_params, 'lightbox-type', "null");
		$lightbox_position = $base->getVar($this->grid_params, 'lightbox-position', 'bottom');		
		
		$lightbox_effect_open_close = $base->getVar($this->grid_params, 'lightbox-effect-open-close', 'fade');		
		$lightbox_effect_next_prev = $base->getVar($this->grid_params, 'lightbox-effect-next-prev', 'fade');		
		$lightbox_effect_open_close_speed = $base->getVar($this->grid_params, 'lightbox-effect-open-close-speed', 'normal');		
		$lightbox_effect_next_prev_speed = $base->getVar($this->grid_params, 'lightbox-effect-next-prev-speed', 'normal');		
		
		$lightbox_arrows = $base->getVar($this->grid_params, 'lightbox-arrows', 'on'); 
		$lightbox_thumbs = $base->getVar($this->grid_params, 'lightbox-thumbs', 'off');
		$lightbox_thumbs_w = $base->getVar($this->grid_params, 'lbox-thumb-w', '50');		
		$lightbox_thumbs_h = $base->getVar($this->grid_params, 'lbox-thumb-h', '50');
		$lightbox_jump_prevent = $base->getVar($this->grid_params, 'lightbox-jump-prevent', 'on');

		$lbox_width = $base->getVar($this->grid_params, 'lbox-width', '800');
		$lbox_height = $base->getVar($this->grid_params, 'lbox-height', '600');
		$lbox_minwidth = $base->getVar($this->grid_params, 'lbox-minwidth', '100');
		$lbox_minheight = $base->getVar($this->grid_params, 'lbox-minheight', '100');
		$lbox_maxwidth = $base->getVar($this->grid_params, 'lbox-maxwidth', '9999');
		$lbox_maxheight = $base->getVar($this->grid_params, 'lbox-maxheight', '9999');

		$lbox_autoplay = $base->getVar($this->grid_params, 'lbox-autplay', 'off');
		$lbox_playspeed = $base->getVar($this->grid_params, 'lbox-playspeed', '3000');
		$lbox_preload = $base->getVar($this->grid_params, 'lbox-preload', '3');

		
		$linebreak = '\'<br />\'';	
		$twitteraddon = '\'<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="\'+this.href+\'">'.__('Tweet', EG_TEXTDOMAIN).'</a>\'';
		$facebookaddon = '\'<iframe src="//www.facebook.com/plugins/like.php?href=\'+this.href+\'&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe>\'';

		$lbox_padding = $base->getVar($this->grid_params, 'lbox-padding', array('0','0','0','0'));

		$lbox_inpadding = $base->getVar($this->grid_params, 'lbox-inpadding', array('0','0','0','0'));
		
		$rtl = $base->getVar($this->grid_params, 'rtl', 'off');
		
		$media_filter_type = $base->getVar($this->grid_postparams, 'media-filter-type', 'none');
		
		$wait_for_fonts = get_option('tp_eg_wait_for_fonts', 'true');
		
		$pagination_numbers = $base->getVar($this->grid_params, 'pagination-numbers', 'smart');
		$pagination_scroll = $base->getVar($this->grid_params, 'pagination-scroll', 'off');
		$pagination_scroll_offset = $base->getVar($this->grid_params, 'pagination-scroll-offset', '0', 'i');
		
		$ajax_callback = $base->getVar($this->grid_params, 'ajax-callback', '');
		$ajax_css_url = $base->getVar($this->grid_params, 'ajax-css-url', '');
		$ajax_js_url = $base->getVar($this->grid_params, 'ajax-js-url', '');
		$ajax_scroll_onload = $base->getVar($this->grid_params, 'ajax-scroll-onload', 'on');
		$ajax_callback_argument = $base->getVar($this->grid_params, 'ajax-callback-arg', 'on');
		$ajax_content_id = $base->getVar($this->grid_params, 'ajax-container-id', '');
		$ajax_scrollto_offset = $base->getVar($this->grid_params, 'ajax-scrollto-offset', '0');
		$ajax_close_button = $base->getVar($this->grid_params, 'ajax-close-button', 'off');
		$ajax_button_nav = $base->getVar($this->grid_params, 'ajax-nav-button', 'off');
		$ajax_content_sliding = $base->getVar($this->grid_params, 'ajax-content-sliding', 'on');
		$ajax_button_type = $base->getVar($this->grid_params, 'ajax-button-type', 'button');
		if($ajax_button_type == 'type2'){
			$ajax_button_text = $base->getVar($this->grid_params, 'ajax-button-text', __('Close', EG_TEXTDOMAIN));
		}
		$ajax_button_skin = $base->getVar($this->grid_params, 'ajax-button-skin', 'light');
		$ajax_button_inner = $base->getVar($this->grid_params, 'ajax-button-inner', 'false');
		$ajax_button_h_pos = $base->getVar($this->grid_params, 'ajax-button-h-pos', 'r');
		$ajax_button_v_pos = $base->getVar($this->grid_params, 'ajax-button-v-pos', 't');
		
		$cobbles_pattern = $base->getVar($this->grid_params, 'cobbles-pattern', array());
		$use_cobbles_pattern = $base->getVar($this->grid_params, 'use-cobbles-pattern', 'off');
		
		$cookie_time = intval($base->getVar($this->grid_params, 'cookie-save-time', '30'));
		$cookie_search = $base->getVar($this->grid_params, 'cookie-save-search', 'off');
		$cookie_filter = $base->getVar($this->grid_params, 'cookie-save-filter', 'off');
		$cookie_pagination = $base->getVar($this->grid_params, 'cookie-save-pagination', 'off');
		
		$js_to_footer = (get_option('tp_eg_js_to_footer', 'false') == 'true') ? true : false;
		
		//add inline style into the footer
		if($js_to_footer && $is_demo == false){
			ob_start();
		}
		
        echo '<script type="text/javascript">'."\n";
        
        if($hide_markup_before_load == 'off') {
	        echo 'function eggbfc(winw,resultoption) {'."\n";
			echo '	var lasttop = winw,'."\n";
			echo '	lastbottom = 0,'."\n";
			echo '	smallest =9999,'."\n";
			echo '	largest = 0,'."\n";
			echo '	samount = 0,'."\n";
			echo '	lamoung = 0,'."\n";
			echo '	lastamount = 0,'."\n";
			echo '	resultid = 0,'."\n";
			echo '	resultidb = 0,'."\n";
			echo '	responsiveEntries = ['."\n";
	        echo '						{ width:'.$columns_width['0'].',amount:'.$columns['0'].',mmheight:'.$masonry_content_height['0'].'},'."\n";
	        echo '						{ width:'.$columns_width['1'].',amount:'.$columns['1'].',mmheight:'.$masonry_content_height['1'].'},'."\n";		
			echo '						{ width:'.$columns_width['2'].',amount:'.$columns['2'].',mmheight:'.$masonry_content_height['2'].'},'."\n";
			echo '						{ width:'.$columns_width['3'].',amount:'.$columns['3'].',mmheight:'.$masonry_content_height['3'].'},'."\n";
			echo '						{ width:'.$columns_width['4'].',amount:'.$columns['4'].',mmheight:'.$masonry_content_height['4'].'},'."\n";
			echo '						{ width:'.$columns_width['5'].',amount:'.$columns['5'].',mmheight:'.$masonry_content_height['5'].'},'."\n";
			echo '						{ width:'.$columns_width['6'].',amount:'.$columns['6'].',mmheight:'.$masonry_content_height['6'].'}'."\n";
	        echo '						];'."\n";
			echo '	if (responsiveEntries!=undefined && responsiveEntries.length>0)'."\n";
			echo '		jQuery.each(responsiveEntries, function(index,obj) {'."\n";
			echo '			var curw = obj.width != undefined ? obj.width : 0,'."\n";
			echo '				cura = obj.amount != undefined ? obj.amount : 0;'."\n";
			echo '			if (smallest>curw) {'."\n";
			echo '				smallest = curw;'."\n";
			echo '				samount = cura;'."\n";
			echo '				resultidb = index;'."\n";
			echo '			}'."\n";
			echo '			if (largest<curw) {'."\n";
			echo '				largest = curw;'."\n";
			echo '				lamount = cura;'."\n";
			echo '			}'."\n";
			echo '			if (curw>lastbottom && curw<=lasttop) {'."\n";
			echo '				lastbottom = curw;'."\n";
			echo '				lastamount = cura;'."\n";
			echo '				resultid = index;'."\n";
			echo '			}'."\n";
			echo '		});'."\n";
			echo '		if (smallest>winw) {'."\n";
			echo '			lastamount = samount;'."\n";
			echo '			resultid = resultidb;'."\n";
			echo '		}'."\n";
			echo '		var obj = new Object;'."\n";
			echo '		obj.index = resultid;'."\n";
			echo '		obj.column = lastamount;'."\n";
			echo '		if (resultoption=="id")'."\n";
			echo '			return obj;'."\n";
			echo '		else'."\n";
			echo '			return lastamount;'."\n";
			echo '	}'."\n";
	        echo 'if ("'.$layout.'"=="even") {'."\n";
			echo '	var coh=0,'."\n";
			echo '		container = jQuery("#esg-grid-'.$this->grid_div_name.'-'.$esg_grid_serial.'");'."\n";	
			if($layout_sizing == 'fullscreen'){
				echo 'coh = jQuery(window).height();'."\n";							

				if($layout_offset_container !== ''){
					echo 'try{'."\n";				
					echo '	var offcontainers = "'.$layout_offset_container.'".split(",");'."\n";
					echo '	jQuery.each(offcontainers,function(index,searchedcont) {'."\n";
					echo '		coh = coh - jQuery(searchedcont).outerHeight(true);'."\n";
					echo '	})'."\n";
					echo '} catch(e) {}'."\n";		
				}						
			} else {
				echo '	var	cwidth = container.width(),'."\n";
				echo '		ar = "'.$aspect_ratio_x.':'.$aspect_ratio_y.'",'."\n";
				echo '		gbfc = eggbfc(jQuery(window).width(),"id"),'."\n";
				if($rows_unlimited == 'on'){
					echo '	row = 2;'."\n";
				} else {
					echo '	row = '.$rows.';'."\n";
				}																		
				echo 'ar = ar.split(":");'."\n";
				echo 'aratio=parseInt(ar[0],0) / parseInt(ar[1],0);'."\n";
				echo 'coh = cwidth / aratio;'."\n";
				echo 'coh = coh/gbfc.column*row;'."\n";
			}
			echo '	var ul = container.find("ul").first();'."\n";
			echo '	ul.css({display:"block",height:coh+"px"});'."\n";
			echo '}'."\n";
		}
		
        echo 'var essapi_'.$this->grid_api_name.';'."\n";
        echo 'jQuery(document).ready(function() {'."\n";
        echo '	essapi_'.$this->grid_api_name.' = jQuery("#esg-grid-'.$this->grid_div_name.'-'.$esg_grid_serial.'").tpessential({'."\n";
		
		do_action('essgrid_output_grid_javascript_options', $this);
		
		echo '        gridID:'.$this->grid_id.','."\n";
        echo '        layout:"'.$layout.'",'."\n";
        
		if($rtl == 'on') echo '        rtl:"on",'."\n";
		
        echo '        forceFullWidth:"'.$force_full_width.'",'."\n";
        echo '        lazyLoad:"'.$lazy_load.'",'."\n";
		if($lazy_load == 'on')
			echo '        lazyLoadColor:"'.$lazy_load_color.'",'."\n";
		
        if($rows_unlimited == 'on'){
			$load_more		  = $base->getVar($this->grid_params, 'load-more', 'button');
			$load_more_amount = $base->getVar($this->grid_params, 'load-more-amount', 3, 'i');
			$load_more_show_number = $base->getVar($this->grid_params, 'load-more-show-number', 'on');
			
			if($load_more !== 'none'){
				$load_more_text = $base->getVar($this->grid_params, 'load-more-text', __('Load More', EG_TEXTDOMAIN));
				echo '        gridID:"'.$this->grid_id.'",'."\n";
				echo '        loadMoreType:"'.$load_more.'",'."\n";
				echo '        loadMoreAmount:'.$load_more_amount.','."\n";
				echo '        loadMoreTxt:"'.$load_more_text.'",'."\n";
				echo '        loadMoreNr:"'.$load_more_show_number.'",'."\n";
				echo '        loadMoreEndTxt:"'.__('No More Items for the Selected Filter', EG_TEXTDOMAIN).'",'."\n";   
				echo '        loadMoreItems:';
				$this->output_load_more_list();
				echo ','."\n";
			}
			echo '        row:9999,'."\n";
        }else{
			echo '        row:'.$rows.','."\n";
		}
		$token = wp_create_nonce('Essential_Grid_Front');
		echo '        loadMoreAjaxToken:"'.$token.'",'."\n";
		echo '        loadMoreAjaxUrl:"'.admin_url('admin-ajax.php').'",'."\n";
		echo '        loadMoreAjaxAction:"Essential_Grid_Front_request_ajax",'."\n";
		
		echo '        ajaxContentTarget:"'.$ajax_content_id.'",'."\n";
		echo '        ajaxScrollToOffset:"'.$ajax_scrollto_offset.'",'."\n";
		echo '        ajaxCloseButton:"'.$ajax_close_button.'",'."\n";
		echo '        ajaxContentSliding:"'.$ajax_content_sliding.'",'."\n";
		if($ajax_callback !== '') echo '        ajaxCallback:"'.stripslashes($ajax_callback).'",'."\n";
		if($ajax_css_url !== '') echo '        ajaxCssUrl:"'.$ajax_css_url.'",'."\n";
		if($ajax_js_url !== '') echo '        ajaxJsUrl:"'.$ajax_js_url.'",'."\n";
		if($ajax_scroll_onload !== 'off') echo  '        ajaxScrollToOnLoad:"on",'."\n";
		if($ajax_callback_argument == 'on') echo  '        ajaxCallbackArgument:"on",'."\n";
		
		echo '        ajaxNavButton:"'.$ajax_button_nav.'",'."\n";
		echo '        ajaxCloseType:"'.$ajax_button_type.'",'."\n";
		if($ajax_button_type == 'type2'){
			echo '        ajaxCloseTxt:"'.$ajax_button_text.'",'."\n";
		}
		echo '        ajaxCloseInner:"'.$ajax_button_inner.'",'."\n";
		echo '        ajaxCloseStyle:"'.$ajax_button_skin.'",'."\n";
		
		$ajax_button_h_pos = $base->getVar($this->grid_params, 'ajax-button-h-pos', 'r');
		$ajax_button_v_pos = $base->getVar($this->grid_params, 'ajax-button-v-pos', 't');
		if($ajax_button_h_pos == 'c'){
			echo '        ajaxClosePosition:"'.$ajax_button_v_pos.'",'."\n";
		}else{
			echo '        ajaxClosePosition:"'.$ajax_button_v_pos.$ajax_button_h_pos.'",'."\n";
		}
		
        echo '        space:'.$space.','."\n";
        echo '        pageAnimation:"'.$page_animation.'",'."\n";
		
		if($pagination_numbers == 'full')
			echo '        smartPagination:"off",'."\n";
		
		echo '        paginationScrollToTop:"'.$pagination_scroll.'",'."\n";
        if($pagination_scroll == 'on'){
			echo '        paginationScrollToOffset:'.$pagination_scroll_offset.','."\n";
		}
		
        echo '        spinner:"spinner'.$spinner.'",'."\n";
		if($media_filter_type != 'none') echo '        mediaFilter:"'.esc_attr($media_filter_type).'",'."\n";
		
		if($spinner != '0' && $spinner != '5')
			echo '        spinnerColor:"'.$spinner_color.'",'."\n";
		
        if($layout_sizing == 'fullwidth'){
			echo '        forceFullWidth:"on",'."\n";
		}elseif($layout_sizing == 'fullscreen'){
			echo '        forceFullScreen:"on",'."\n";
			if($layout_offset_container !== ''){
				echo '        fullScreenOffsetContainer:"'.$layout_offset_container.'",'."\n";
			}
		}
		
		if($layout == 'even')
			echo '        evenGridMasonrySkinPusher:"'.$content_push.'",'."\n";
		
        echo '        lightBoxMode:"'.$lightbox_mode.'",'."\n";
		
		if(!empty($cobbles_pattern) && $layout == 'cobbles' && $use_cobbles_pattern == 'on'){
			echo '        cobblesPattern:"'.implode(',', $cobbles_pattern).'",'."\n";
		}
        echo '        animSpeed:'.$anim_speed.','."\n";
        echo '        delayBasic:'.$delay_basic.','."\n";
        echo '        mainhoverdelay:'.$delay_hover.','."\n";
		
        echo '        filterType:"'.$filter_type.'",'."\n";
		
		if($filter_type == 'multi'){
			echo '        filterLogic:"'.$filter_logic.'",'."\n";
		}
		echo '        showDropFilter:"'.$filter_show_on.'",'."\n";
		
        echo '        filterGroupClass:"esg-fgc-'.$this->grid_id.'",'."\n";
		
		if($wait_for_fonts === 'true'){
			$tf_fonts = new ThemePunch_Fonts();
			$fonts = $tf_fonts->get_all_fonts();
			if(!empty($fonts)){
				$first = true;
				$font_string = '[';
				foreach($fonts as $font){
					if($first === false) $font_string.= ',';
					$font_string.= "'".esc_attr($font['url'])."'";
					$first = false;
				}
				$font_string.= ']';
				echo '        googleFonts:'.$font_string.','."\n";
			}
		}
		
		if($cookie_search === 'on' || $cookie_filter === 'on' || $cookie_pagination === 'on'){
			echo '        cookies: {'."\n";
			if($cookie_search == 'on') echo '                search:"'.$cookie_search.'",'."\n";
			if($cookie_filter == 'on') echo '                filter:"'.$cookie_filter.'",'."\n";
			if($cookie_pagination == 'on') echo '                pagination:"'.$cookie_pagination.'",'."\n";
			echo '                timetosave:"'.$cookie_time.'"'."\n";
			echo '        },'."\n";
		}
		
        if($layout != 'masonry' || $layout == 'masonry' && $auto_ratio != 'true'){
            echo '        aspectratio:"'.$aspect_ratio_x.':'.$aspect_ratio_y.'",'."\n";
        }
        echo '        responsiveEntries: ['."\n";
        echo '						{ width:'.$columns_width['0'].',amount:'.$columns['0'].',mmheight:'.$masonry_content_height['0'].'},'."\n";
        echo '						{ width:'.$columns_width['1'].',amount:'.$columns['1'].',mmheight:'.$masonry_content_height['1'].'},'."\n";		
		echo '						{ width:'.$columns_width['2'].',amount:'.$columns['2'].',mmheight:'.$masonry_content_height['2'].'},'."\n";
		echo '						{ width:'.$columns_width['3'].',amount:'.$columns['3'].',mmheight:'.$masonry_content_height['3'].'},'."\n";
		echo '						{ width:'.$columns_width['4'].',amount:'.$columns['4'].',mmheight:'.$masonry_content_height['4'].'},'."\n";
		echo '						{ width:'.$columns_width['5'].',amount:'.$columns['5'].',mmheight:'.$masonry_content_height['5'].'},'."\n";
		echo '						{ width:'.$columns_width['6'].',amount:'.$columns['6'].',mmheight:'.$masonry_content_height['6'].'}'."\n";
        echo '						]';
		
		if($columns_advanced == 'on')
			$this->output_ratio_list();
		
		echo "\n";
		
        echo '	});'."\n\n";
		
		//check if lightbox is active
		$opt = get_option('tp_eg_use_lightbox', 'false');
		if($load_lightbox && !Essential_Grid_Jackbox::is_active() && !Essential_Grid_Social_Gallery::is_active() && $opt !== 'disabled') {
			echo '	try{'."\n";
			echo '	jQuery("#esg-grid-'.$this->grid_div_name.'-'.$esg_grid_serial.' .esgbox").esgbox({'."\n";
			echo '		padding : ['.$lbox_padding[0].','.$lbox_padding[1].','.$lbox_padding[2].','.$lbox_padding[3].'],'."\n";
			echo ' 		width:'.$lbox_width.','."\n";
			echo ' 		height:'.$lbox_height.','."\n";
			echo ' 		minWidth:'.$lbox_minwidth.','."\n";
			echo ' 		minHeight:'.$lbox_minheight.','."\n";
			echo ' 		maxWidth:'.$lbox_maxwidth.','."\n";
			echo ' 		maxHeight:'.$lbox_maxheight.','."\n";

			echo ' 		autoPlay:';
			echo ($lbox_autoplay == 'on') ? 'true' : 'false';
			echo ','."\n";
			echo ' 		playSpeed:'.$lbox_playspeed.','."\n";
			echo ' 		preload:'.$lbox_preload.','."\n";

			echo '      beforeLoad:function() { '."\n";
			echo '		 },'."\n";
			echo '      afterLoad:function() { '."\n";
			echo ' 		if (this.element.hasClass("esgboxhtml5")) {'."\n";
			echo '			this.type ="html5";'."\n";
			echo '		   var mp = this.element.data("mp4"),'."\n";
			echo '		      ogv = this.element.data("ogv"),'."\n";
			echo '		      webm = this.element.data("webm");'."\n";
			echo '		      ratio = this.element.data("ratio");'."\n";
			echo '		      ratio = ratio==="16:9" ? "56.25%" : "75%"'."\n";
			echo '         this.content =\'<div class="esg-lb-video-wrapper" style="width:100%"><video autoplay="true" loop=""  poster="" width="100%" height="auto"><source src="\'+mp+\'" type="video/mp4"><source src="\'+webm+\'" type="video/webm"><source src="\'+ogv+\'" type="video/ogg"></video></div>\';'."\n";						
			echo '		   };'."\n";							
			echo '		 },'."\n";
		/*	echo '		ajax: { type:"post",url:'.admin_url('admin-ajax.php').',dataType:"json",data:{
										 action: "Essential_Grid_Front_request_ajax",
									     client_action: "load_more_content",
									     token: '.$token.',
									     postid:postid}, success:function(data) { jQuery.esgbox(data.data)} },'."\n";*/
			echo '		beforeShow : function () { '."\n";				
			echo '			this.title = jQuery(this.element).attr(\'lgtitle\');'."\n";
			echo '			if (this.title) {'."\n";
			if ($lightbox_title_type=="null") 
				echo '				this.title="";'."\n";
			if ($usetwitter=="on" || $usefacebook=="on")
				echo '				this.title += '.$linebreak.';'."\n";
			if ($usetwitter=="on")
				echo '				this.title += '.$twitteraddon.';'."\n";
			if ($usefacebook=="on")
				echo '				this.title += '.$facebookaddon.';'."\n";
			
			echo '   		this.title =  \'<div style="padding:'.$lbox_inpadding[0].'px '.$lbox_inpadding[1].'px '.$lbox_inpadding[2].'px '.$lbox_inpadding[3].'px">\'+this.title+\'</div>\';'."\n";										
			echo '			}'."\n";															

			echo '		},'."\n";
			
			
			

			echo '		afterShow : function() {'."\n";			
			
			if ($usetwitter=="on")
				echo '			twttr.widgets.load();'."\n";
			echo '		},'."\n";
			echo '		openEffect : \''.$lightbox_effect_open_close.'\','."\n";		
			echo '		closeEffect : \''.$lightbox_effect_open_close.'\','."\n";		
			echo '		nextEffect : \''.$lightbox_effect_next_prev.'\','."\n";		
			echo '		prevEffect : \''.$lightbox_effect_next_prev.'\','."\n";											
			echo '		openSpeed : \''.$lightbox_effect_open_close_speed.'\','."\n";		
			echo '		closeSpeed : \''.$lightbox_effect_open_close_speed.'\','."\n";		
			echo '		nextSpeed : \''.$lightbox_effect_next_prev_speed.'\','."\n";		
			echo '		prevSpeed : \''.$lightbox_effect_next_prev_speed.'\','."\n";
			echo '		helpers:{overlay:{locked:false}},'."\n";			
			if ($lightbox_arrows=="off")
				echo '		arrows : false,'."\n";													
			echo '		helpers : {'."\n";
			echo '			media : {},'."\n";
			if ($lightbox_jump_prevent == "on") {
				echo '			overlay: {'."\n";
				echo '				locked: false'."\n";
				echo '			},'."\n";
			}
			if ($lightbox_thumbs == "on") {
				echo '			thumbs: {'."\n";
				echo '				width : '.$lightbox_thumbs_w.','."\n";
				echo '				height : '.$lightbox_thumbs_h."\n";			
				echo '			},'."\n";			
			}
			echo '		    title : {'."\n";
			if ($lightbox_title_type!="null") 
				echo '				type:"'.$lightbox_title_type.'",'."\n";
			else
				echo '				type:""'."\n";
			if ($lightbox_title_type!="null") 
				echo '				position:"'.$lightbox_position.'",'."\n";			
			echo '			}'."\n";
			
			echo '		}'."\n";
			echo '});'."\n"."\n";
			echo ' } catch (e) {}'."\n"."\n";
		}		
		
		//output custom javascript if any is set
		$custom_javascript = stripslashes($base->getVar($this->grid_params, 'custom-javascript', ''));
		if($custom_javascript !== ''){
			echo $custom_javascript;
		}
		
		do_action('essgrid_output_grid_javascript_custom', $this);
		echo '});'."\n";
		echo '</script>'."\n";
		
		if($js_to_footer && $is_demo == false){
			$js_content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			$this->grid_inline_js = $js_content;
			
			add_action('wp_footer', array($this, 'add_inline_js'));
		}
        
    }
	
	
	/**
	 * Output the Load More list of posts
	 */
	public function output_load_more_list(){
		
		if(!empty($this->load_more_post_array)){
			$wrap_first = true;
			echo '[';
			
			foreach($this->load_more_post_array as $id => $filter){
				echo (!$wrap_first) ? ','."\n" : "\n";
				
				echo '				['.$id.', [-1, ';
				
				if(!empty($filter)){
					$slug_first = true;
					foreach($filter as $slug_id => $slug){
						echo (!$slug_first) ? ', ' : '';
						
						if(intval($slug_id == 0)) $slug_id = "'".$slug_id."'";
						echo $slug_id;
						
						$slug_first = false;
					}
				}
				
				echo ']]';
				
				$wrap_first = false;
			}
			
			echo ']';
		}else{
			echo '[]';
		}
	}
	
	
	/**
	 * Output the custom row sizes if its set
	 */
	public function output_ratio_list(){
		$base = new Essential_Grid_Base;
		
		$columns = $base->getVar($this->grid_params, 'columns', ''); //this is the first line
        $columns = $base->set_basic_colums($columns);
		
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-0', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-1', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-2', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-3', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-4', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-5', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-6', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-7', '');
		$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-8', '');
		//$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-9', '');
		
		$found_rows = 0;
		foreach($columns_advanced as $adv_key => $adv){
			if(empty($adv)) continue;
			$found_rows++;
		}
		
		if($found_rows > 0){
			echo ','."\n";
			echo '		rowItemMultiplier: ['."\n";
			
			echo '						[';
			echo $columns[0].',';
			echo $columns[1].',';
			echo $columns[2].',';
			echo $columns[3].',';
			echo $columns[4].',';
			echo $columns[5].',';
			echo $columns[6];
			echo ']';
			
			foreach($columns_advanced as $adv_key => $adv){
				if(empty($adv)) continue;
				
				echo ','."\n";
				echo '						[';
				
				$entry_first = true;
				foreach($adv as $val){
					echo (!$entry_first) ? ',' : '';
					echo $val;
					$entry_first = false;
				}
				
				echo ']';
			}
			
			echo "\n".'						]';
		}
	}
	
	
	/**
	 * check if post is visible in grid
	 */
	public function check_if_visible($post_id, $grid_id){
		$pr_visibility = json_decode(get_post_meta($post_id, 'eg_visibility', true), true);
		
		$is_visible = true;
		
		if(!empty($pr_visibility) && is_array($pr_visibility)){ //check if element is visible in grid
			foreach($pr_visibility as $pr_grid => $pr_setting){
				if($pr_grid == $grid_id){
					if($pr_setting == false)
						$is_visible = false;
					else
						$is_visible = true;
					break;
				}
			}
		}
		
		return apply_filters('essgrid_check_if_visible', $is_visible, $post_id, $grid_id);
	}
	
	
	/**
	 * Output Filter from current Grid (used for Widgets)
	 * @since 1.0.6
	 */
	public function output_grid_filter(){
		
		do_action('essgrid_output_grid_filter_pre', $this);
		
		switch($this->grid_postparams['source-type']){
			case 'post':
				$this->output_filter_by_posts();
			break;
			case 'custom':
				$this->output_filter_by_custom();
			break;
			case 'streams':
			break;
		}
		
		do_action('essgrid_output_grid_filter_post', $this);
		
	}
	
	
	/**
	 * Output Sorting from current Grid (used for Widgets)
	 * @since 1.0.6
	 */
	public function output_grid_sorting(){
		
		do_action('essgrid_output_grid_sorting_pre', $this);
		
		switch($this->grid_postparams['source-type']){
			case 'post':
				$this->output_sorting_by_posts();
			break;
			case 'custom':
				$this->output_sorting_by_custom();
			break;
			case 'streams':
			break;
		}
		
		do_action('essgrid_output_grid_sorting_post', $this);
		
	}
	
	
	/**
	 * Output Sorting from post based
	 * @since 1.0.6
	 */
	public function output_sorting_by_posts(){
		do_action('essgrid_output_sorting_by_posts_pre', $this);
		
		$this->output_sorting_by_all_types();
		
		do_action('essgrid_output_sorting_by_posts_post', $this);
	}
	
	
	/**
	 * Output Sorting from custom grid
	 * @since 1.0.6
	 */
	public function output_sorting_by_custom(){
		do_action('essgrid_output_sorting_by_custom_pre', $this);
		
		$this->output_sorting_by_all_types();
		
		do_action('essgrid_output_sorting_by_custom_post', $this);
	}
	
	
	/**
	 * Output Sorting from custom grid
	 * @since 1.0.6
	 */
	public function output_sorting_by_all_types(){
		do_action('essgrid_output_sorting_by_all_types', $this);
		
		$base = new Essential_Grid_Base();
		$nav = new Essential_Grid_Navigation();
		$m = new Essential_Grid_Meta();
		
		$order_by = explode(',', $base->getVar($this->grid_params, 'sorting-order-by', 'date'));
		if(!is_array($order_by)) $order_by = array($order_by);

		$order_by_start = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		if(strpos($order_by_start, 'eg-') === 0 || strpos($order_by_start, 'egl-') === 0){ //add meta at the end for meta sorting
			//if essential Meta, replace to meta name. Else -> replace - and _ with space, set each word uppercase
			$metas = $m->get_all_meta();
			$f = false;
			if(!empty($metas)){
				foreach($metas as $meta){
					if('eg-'.$meta['handle'] == $order_by_start || 'egl-'.$meta['handle'] == $order_by_start){
						$f = true;
						$order_by_start = $meta['name'];
						break;
					}
				}
			}
			
			if($f === false){
				$order_by_start = ucwords(str_replace(array('-', '_'), array(' ', ' '), $order_by_start));
			}
		}
		
		$nav->set_orders($order_by); //set order of filter
		$nav->set_orders_start($order_by_start); //set order of filter
		
		echo $nav->output_sorting();
	}
	
	
	/**
	 * Output Filter from post based
	 * @since 1.0.6
	 */
	public function output_filter_by_posts(){
		do_action('essgrid_output_filter_by_posts', $this);
		
		$base = new Essential_Grid_Base();
		$nav = new Essential_Grid_Navigation();
		
		$filter_allow = $base->getVar($this->grid_params, 'filter-arrows', 'single');
		$filter_start = $grid->getVar($this->grid_params,'filter-start', '');
		$filter_all_text = $base->getVar($this->grid_params, 'filter-all-text', __('Filter - All', EG_TEXTDOMAIN));
		$filter_dropdown_text = $base->getVar($this->grid_params, 'filter-dropdown-text', __('Filter Categories', EG_TEXTDOMAIN));
		$show_count = $base->getVar($this->grid_params, 'filter-counter', 'off');
		
		$nav->set_filter_text($filter_all_text);
		$nav->set_dropdown_text($filter_dropdown_text);
		$nav->set_show_count($show_count);

		$start_sortby = $base->getVar($this->grid_params, 'sorting-order-by-start', 'none');
		$start_sortby_type = $base->getVar($this->grid_params, 'sorting-order-type', 'ASC');
		
		$post_category = $base->getVar($this->grid_postparams, 'post_category');
		$post_types = $base->getVar($this->grid_postparams, 'post_types');
		$page_ids = explode(',', $base->getVar($this->grid_postparams, 'selected_pages', '-1'));
		$cat_relation = $base->getVar($this->grid_postparams, 'category-relation', 'OR');
		
		$additional_query = $base->getVar($this->grid_postparams, 'additional-query', '');
		if($additional_query !== '')
			$additional_query = wp_parse_args($additional_query);

		$cat_tax = Essential_Grid_Base::getCatAndTaxData($post_category);

		$posts = Essential_Grid_Base::getPostsByCategory($this->grid_id, $cat_tax['cats'], $post_types, $cat_tax['tax'], $page_ids, $start_sortby, $start_sortby_type, -1, $additional_query, true, $cat_relation);

		$nav_filters = array();

		$taxes = array('post_tag');
		if(!empty($cat_tax['tax']))
			$taxes = explode(',', $cat_tax['tax']);
			
		if(!empty($cat_tax['cats'])){
			$cats = explode(',', $cat_tax['cats']);
			
			foreach($cats as $key => $id){
				$cat = get_category($id);
				if(is_object($cat))	$nav_filters[$id] = array('name' => $cat->cat_name, 'slug' => sanitize_key($cat->slug));
				
				foreach($taxes as $custom_tax){
					$term = get_term_by('id', $id, $custom_tax);
					if(is_object($term)) $nav_filters[$id] = array('name' => $term->name, 'slug' => sanitize_key($term->slug));
				}
			}
			
			asort($nav_filters);
		}


		$found_filter = array();
		if(!empty($posts) && count($posts) > 0){
			foreach($posts as $key => $post){
				//check if post should be visible or if its invisible on current grid settings
				$is_visible = $this->check_if_visible($post['ID'], $this->grid_id);
				if($is_visible == false) continue; // continue if invisible
				
				$filters = array();
				
				//$categories = get_the_category($post['ID']);
				$categories = $base->get_custom_taxonomies_by_post_id($post['ID']);
				//$tags = wp_get_post_terms($post['ID']);
				$tags = get_the_tags($post['ID']);
				
				if(!empty($categories)){
					foreach($categories as $key => $category){
						$filters[$category->term_id] = array('name' => $category->name, 'slug' => sanitize_key($category->slug));
					}
				}
				
				if(!empty($tags)){
					foreach($tags as $key => $taxonomie){
						$filters[$taxonomie->term_id] = array('name' => $taxonomie->name, 'slug' => sanitize_key($taxonomie->slug));
					}
				}
				
				$found_filter = $found_filter + $filters; //these are the found filters, only show filter that the posts have
			}
		}

		$remove_filter = array_diff_key($nav_filters, $found_filter); //check if we have filter that no post has (comes through multilanguage)
		if(!empty($remove_filter)){
			foreach($remove_filter as $key => $rem){ //we have, so remove them from the filter list before setting the filter list
				unset($nav_filters[$key]);
			}
		}

		$nav->set_filter($nav_filters); //set filters $nav_filters $found_filter
		$nav->set_filter_type($filter_allow);
		$nav->set_filter_start_select($filter_start);
		
		echo $nav->output_filter();
		
	}
	
	
	/**
	 * Output Filter from custom grid
	 * @since 1.0.6
	 */
	public function output_filter_by_custom(){
		do_action('essgrid_output_filter_by_custom', $this);
		
		$base = new Essential_Grid_Base();
		$nav = new Essential_Grid_Navigation();
		
		$filter_allow = $base->getVar($this->grid_params, 'filter-arrows', 'single');
		$filter_start = $base->getVar($this->grid_params, 'filter-start', '');
		$filter_all_text = $base->getVar($this->grid_params, 'filter-all-text', __('Filter - All', EG_TEXTDOMAIN));
		$filter_dropdown_text = $base->getVar($this->grid_params, 'filter-dropdown-text', __('Filter Categories', EG_TEXTDOMAIN));
		$show_count = $base->getVar($this->grid_params, 'filter-counter', 'off');
		
		$nav->set_dropdown_text($filter_dropdown_text);
		$nav->set_show_count($show_count);
		
		$nav->set_filter_text($filter_all_text);

		$found_filter = array();

		if(!empty($this->grid_layers) && count($this->grid_layers) > 0){
			foreach($this->grid_layers as $key => $entry){
				$filters = array();
				
				if(!empty($entry['custom-filter'])){
					$cats = explode(',', $entry['custom-filter']);
					if(!is_array($cats)) $cats = (array)$cats;
					foreach($cats as $category){
						$filters[sanitize_key($category)] = array('name' => $category, 'slug' => sanitize_key($category));
						
						$found_filter = $found_filter + $filters; //these are the found filters, only show filter that the posts have
						
					}
				}
			}
		}
		
		$nav->set_filter($found_filter); //set filters $nav_filters $found_filter
		$nav->set_filter_type($filter_allow);
		$nav->set_filter_start_select($filter_start);
		
		echo $nav->output_filter();
		
	}
	
	/**
	 * Output Ajax Container
	 * @since 1.5.0
	 */
	public function output_ajax_container(){
	
		$base = new Essential_Grid_Base();
		
		$container_id = $base->getVar($this->grid_params, 'ajax-container-id', '');
		$container_css = $base->getVar($this->grid_params, 'ajax-container-css', ''); 
		
		$container_pre = $base->getVar($this->grid_params, 'ajax-container-pre', ''); 
		$container_post = $base->getVar($this->grid_params, 'ajax-container-post', ''); 
		
		$cont = '';
		$cont .= '<div class="eg-ajax-target-container-wrapper" id="'.$container_id.'">'."\n";
		//$cont .= '	<!-- CONTAINER FOR PREFIX -->'."\n";
		$cont .= '	<div class="eg-ajax-target-prefix-wrapper">'."\n";
		$cont .= html_entity_decode($container_pre);
		$cont .= '	</div>'."\n";
		//$cont .= '	<!-- CONTAINER FOR CONTENT TO LOAD -->'."\n";
		$cont .= '	<div class="eg-ajax-target"></div>'."\n";
		//$cont .= '	<!-- CONTAINER FOR SUFFIX -->'."\n";
		$cont .= '	<div class="eg-ajax-target-sufffix-wrapper">'."\n";
		$cont .= html_entity_decode($container_post);
		$cont .= '	</div>'."\n";
		$cont .= '</div>'."\n";
		
		if($container_css !== '' && $container_id !== ''){
			//$cont .= '<!-- CONTAINER CSS -->'."\n";
			$cont .= '<style type="text/css">'."\n";
			$cont .= '#'.$container_id.' {'."\n";
			$cont .= $container_css;
			$cont .= '}'."\n";
			$cont .= '</style>';
		}
		
		$cont = do_shortcode($cont);
		return apply_filters('essgrid_output_ajax_container', $cont, $this);
	}
	
	
	/**
	 * Output Inline JS
	 * @since 1.1.0
	 */
	public function add_inline_js(){
	
		echo apply_filters('essgrid_add_inline_js', $this->grid_inline_js);
		
	}
	
	
	/**
	 * Check the maximum entries that should be loaded
	 * @since: 1.5.3
	 */
	public function get_maximum_entries($grid){
		$base = new Essential_Grid_Base();
		
		$max_entries = intval($grid->get_postparam_by_handle('max_entries', '-1'));
		
		if($max_entries !== -1) return $max_entries;
		
		$layout = $grid->get_param_by_handle('navigation-layout', array());
		
		if(isset($layout['pagination']) || isset($layout['left']) || isset($layout['right'])) return $max_entries;
		
		$rows_unlimited = $grid->get_param_by_handle('rows-unlimited', 'on');
		$load_more = $grid->get_param_by_handle('load-more', 'none');
        $rows = intval($grid->get_param_by_handle('rows', '3'));
		
		$columns_advanced = $grid->get_param_by_handle('columns-advanced', 'off');
       
        $columns = $grid->get_param_by_handle('columns', ''); //this is the first line
        $columns = $base->set_basic_colums($columns);
		
		$max_column = 0;
		foreach($columns as $column){
			if($max_column < $column) $max_column = $column;
		}
		
		if($columns_advanced === 'on'){
			$columns_advanced = array();
			$columns_advanced[] = $columns;
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-0', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-1', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-2', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-3', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-4', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-5', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-6', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-7', '');
			$columns_advanced[] = $base->getVar($this->grid_params, 'columns-advanced-rows-8', '');
			
			$match = array(0,0,0,0,0,0,0);
			for($i=0;$i<=$rows;$i++){
				foreach($columns_advanced as $col_adv){
					if(!empty($col_adv)){
						foreach($col_adv as $key => $val){
							$match[$key] += $val;
						}
						$i++;
					}
					if($i>=$rows) break;
				}
			}
			
			foreach($match as $highest){
				if($max_column < $highest) $max_column = $highest;
			}
			
		}
		
		if($rows_unlimited === 'off'){
			if($columns_advanced === 'off'){
				$max_entries = $max_column * $rows;
			}else{
				$max_entries = $max_column;
			}
		}elseif($rows_unlimited === 'on' && $load_more === 'none'){
			//@disabled at 2.0 -> will not work as expeced, all elements should be loaded here
			//$max_entries = $max_column;
		}
		
		return apply_filters('essgrid_get_maximum_entries', $max_entries, $this, $grid);
	}
	
	
	/**
	 * Adds functionality for authors to modify things at activation of plugin
	 * @since 1.1.0
	 */
	public static function activation_hooks($networkwide = false){
		//set all starting options
		$options = array();
		$options = apply_filters('essgrid_mod_activation_option', $options);
		if(function_exists('is_multisite') && is_multisite() && $networkwide){ //do for each existing site
			global $wpdb;
			
			$old_blog = $wpdb->blogid;
			
            // Get all blog ids and create tables
			$blogids = $wpdb->get_col("SELECT blog_id FROM ".$wpdb->blogs);
			
            foreach($blogids as $blog_id){
			
				switch_to_blog($blog_id);
				
				foreach($options as $opt => $val){
					update_option('tp_eg_'.$opt, $val);
				}
				
            }
			
            switch_to_blog($old_blog); //go back to correct blog
			
		}else{
		
			foreach($options as $opt => $val){
				update_option('tp_eg_'.$opt, $val);
			}
			
		}
		
	}
	
	/**
	 * Adds default Grids at installation process 
	 * @since 1.5.0
	 */
	public static function propagate_default_grids(){
		
		$default_grids = array();
		
		$default_grids = apply_filters('essgrid_add_default_grids', $default_grids);
		
		if(!empty($default_grids)){
			$im = new Essential_Grid_Import();
			$im->import_grids($default_grids);
		}
		
	}
	
	
	/**
	 * Hide Load More button
	 * @since 2.1.0
	 */
	public function remove_load_more_button($grid_id_wrap){
		$base = new Essential_Grid_Base();
		
		$css = '';
		
		if($base->getVar($this->grid_params, 'load-more-hide', 'off') == 'on' && $base->getVar($this->grid_params, 'load-more', 'none') == 'scroll'){
			$css = '<style type="text/css">';
			$css .= '
#'.$grid_id_wrap.' .esg-loadmore { display: none !important; }';
			$css .= '</style>';
			
		}
		
		echo apply_filters('essgrid_remove_load_more_button', $css, $grid_id_wrap);
	}
	
	
	/**
	 * Adds start height CSS for the Grid, to prevent jumping of Site on loading
	 * @since 2.0.4
	 */
	public function add_start_height_css($grid_id_wrap){
		$base = new Essential_Grid_Base();
		
		$columns_advanced = $base->getVar($this->grid_params, 'columns-advanced', 'off');
        if($columns_advanced == 'on'){
            $columns_width = $base->getVar($this->grid_params, 'columns-width', '');
            $columns_height = $base->getVar($this->grid_params, 'columns-height', '');
            $columns_width = $base->set_basic_colums_height($columns_width);
			$columns_height = $base->set_basic_colums_height($columns_height);
			
			$col_height = array_reverse($columns_height); //reverse to start with lowest value
            $col_width = array_reverse($columns_width); //reverse to start with lowest value
			
			$first = true;
			
			$css = '<style type="text/css">';
			foreach($col_height as $key => $height){
				if($height > 0){
					$height = intval($height);
					$mw = intval($col_width[$key] - 1);
					if($first){ //first set up without restriction of width
						$first = false;
						$css .= '
#'.$grid_id_wrap.'.eg-startheight{ height: '.$height.'px; }';
					}else{
						$css .= '
@media only screen and (min-width: '.$mw.'px) {
	#'.$grid_id_wrap.'.eg-startheight{ height: '.$height.'px; }
}';
					}
				}
			}
			$css .= '</style>';
			
			echo $css."\n";
			
			if($css !== '<style type="text/css"></style>') return true;
			
        }
		
		return false;
	}
	
	
	/**
	 * Does the uninstall process, also multisite checks
	 * @since 1.5.0
	 */
	public static function uninstall_plugin($networkwide = false){
		// If uninstall not called from WordPress, then exit
		if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
			exit;
		}
		
		global $wpdb;
		
		if(function_exists('is_multisite') && is_multisite() && $networkwide){ //do for each existing site
			global $wpdb;
			
			$old_blog = $wpdb->blogid;
			
            // Get all blog ids and create tables
			$blogids = $wpdb->get_col("SELECT blog_id FROM ".$wpdb->blogs);
			
            foreach($blogids as $blog_id){
			
				switch_to_blog($blog_id);
				self::_uninstall_plugin();
				
            }
			
            switch_to_blog($old_blog); //go back to correct blog
			
		}else{
			self::_uninstall_plugin();
		}
		
	}
	
	
	/**
	 * Does the uninstall process
	 * @since 1.5.0
	 * @moved from uninstall.php
	 */
	public static function _uninstall_plugin(){
		// If uninstall not called from WordPress, then exit
		if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
			exit;
		}
		
		global $wpdb;

		//Delete Database Tables
		$wpdb->query( "DROP TABLE ". $wpdb->prefix . Essential_Grid::TABLE_GRID);
		$wpdb->query( "DROP TABLE ". $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN);
		$wpdb->query( "DROP TABLE ". $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS);
		$wpdb->query( "DROP TABLE ". $wpdb->prefix . Essential_Grid::TABLE_NAVIGATION_SKINS);

		//Delete Options
		delete_option('tp_eg_role');
		delete_option('tp_eg_grids_version');
		delete_option('tp_eg_custom_css');

		delete_option('tp_eg_output_protection');
		delete_option('tp_eg_tooltips');
		delete_option('tp_eg_wait_for_fonts');
		delete_option('tp_eg_js_to_footer');
		delete_option('tp_eg_use_cache');
		delete_option('tp_eg_query_type');
		delete_option('tp_eg_enable_log');
		delete_option('tp_eg_use_lightbox');

		delete_option('tp_eg_update-check');
		delete_option('tp_eg_update-check-short');
		delete_option('tp_eg_latest-version');
		delete_option('tp_eg_code');
		delete_option('tp_eg_valid');
		delete_option('tp_eg_valid-notice');

		delete_option('esg-widget-areas');
		delete_option('esg-custom-meta');
		delete_option('esg-custom-link-meta');
		delete_option('esg-search-settings');
		
		delete_option('tp_eg_custom_css_imported');
		
		do_action('essgrid__uninstall_plugin');
		
	}
	
	
	/**
	 * Handle Ajax Requests
	 */
	public static function on_front_ajax_action(){
		$base = new Essential_Grid_Base();
		
		$token = $base->getPostVar("token", false);
		
		//verify the token, removed in 2.1.0
		//$isVerified = apply_filters('essgrid_frontend_nonce', wp_verify_nonce($token, 'Essential_Grid_Front'));
		$isVerified = true;
		
		$error = false;
		if($isVerified){
			$data = $base->getPostVar('data', false);
			//client_action: load_more_items
			switch($base->getPostVar('client_action', false)){
				case 'load_more_items':
					$gridid = $base->getPostVar('gridid', 0, 'i');
					if(!empty($data) && $gridid > 0){
						$grid = new Essential_Grid();
						
						$result = $grid->init_by_id($gridid);
						if(!$result){
							$error = __('Grid not found', EG_TEXTDOMAIN);
						}else{
							$grid->set_loading_ids($data); //set to only load choosen items
							$html = false;
							
							//check if we are custom grid
							if($grid->is_custom_grid()){
								$html = $grid->output_by_specific_ids();
							}elseif($grid->is_stream_grid()){
								$html = $grid->output_by_specific_stream();
							}else{
								$html = $grid->output_by_specific_posts();
							}
							
							if($html !== false){
								self::ajaxResponseData($html);
							}else{
								$error = __('Items Not Found', EG_TEXTDOMAIN);
							}
						}
					}else{
						$error = __('No Data Received', EG_TEXTDOMAIN);
					}
				break;
				case 'load_more_content':
					$postid = $base->getPostVar('postid', 0, 'i');
					if($postid > 0){
						$raw_content = get_post_field('post_content', $postid);
						if(!is_wp_error($raw_content)){
							$content = apply_filters('essgrid_the_content', $raw_content); //filter apply for qTranslate and other
							
							if(method_exists('WPBMap','addAllMappedShortcodes')){
								WPBMap::addAllMappedShortcodes();
							}
							$content = do_shortcode($content);
							
							self::ajaxResponseData($content);
						}
					}
					$error = __('Post Not Found', EG_TEXTDOMAIN);
				break;
				case 'get_search_results':
					$search_string = $base->getVar($data, 'search', '');
					$search_skin = $base->getVar($data, 'skin', 0, 'i');
					if($search_string !== '' && $search_skin > 0){
						$search = new Essential_Grid_Search();
						
						$return = $search->output_search_result($search_string, $search_skin);
						
						self::ajaxResponseData($return);
					}
					$error = __('Not found', EG_TEXTDOMAIN);
				break;
				case 'get_grid_search_ids':
					$search_string = $base->getVar($data, 'search', '');
					$grid_id = $base->getVar($data, 'id', 0, 'i');
					if($search_string !== '' && $grid_id > 0){

						$return = Essential_Grid_Search::output_search_result_ids($search_string, $grid_id);
						if(!is_array($return)){
							$error = $return; 
						}else{
							self::ajaxResponseSuccess('', $return);
						}
					}
					$error = __('Not found', EG_TEXTDOMAIN);
				break;
			}
			
			$error = apply_filters('essgrid_on_front_ajax_action', $error, $data);
		}else{
			$error = true;
		}
		
		if($error !== false){
			$showError = __('Loading Error', EG_TEXTDOMAIN);
			if($error !== true)
				$showError = $error;
			
			self::ajaxResponseError($showError, false);
		}
		exit();
	}
	
	
	/**
	 * echo json ajax response
	 */
	public static function ajaxResponse($success,$message,$arrData = null){
		
		$response = array();
		$response["success"] = $success;				
		$response["message"] = $message;

		if(!empty($arrData)){
			
			if(gettype($arrData) == "string" || gettype($arrData) == "boolean")
				$arrData = array("data"=>$arrData);				
			
			$response = array_merge($response,$arrData);
		}
			
		$json = json_encode($response);
		
		echo $json;
		exit();
	}

	
	/**
	 * echo json ajax response, without message, only data
	 */
	public static function ajaxResponseData($arrData){
		if(gettype($arrData) == "string")
			$arrData = array("data"=>$arrData);
		
		self::ajaxResponse(true,"",$arrData);
	}
	
	
	/**
	 * echo json ajax response
	 */
	public static function ajaxResponseError($message,$arrData = null){
		
		self::ajaxResponse(false,$message,$arrData,true);
	}
	
	
	/**
	 * echo ajax success response
	 */
	public static function ajaxResponseSuccess($message,$arrData = null){
		
		self::ajaxResponse(true,$message,$arrData,true);
		
	}
	
	
	/**
	 * echo ajax success response
	 */
	public static function ajaxResponseSuccessRedirect($message,$url){
		$arrData = array("is_redirect"=>true,"redirect_url"=>$url);
		
		self::ajaxResponse(true,$message,$arrData,true);
	}

	
	/**
	 * Shortcode to wrap around the original gallery shortcode
	 *
	 * @since    1.0.0
	 * @version  1.0.1 : Exits when other revslider_function
	 */
	public function ess_grid_addon_gallery($output, $attr){
		//exits if other RevSlider functionality captures the gallery functionality
		if( isset($output["revslider_function"]) ) return false;

		// Columns and Grid Defaults
		$columns = isset($output['columns']) ? $output['columns'] : 3;
		$grid = isset($output['ess_grid_gal']) ? $output['ess_grid_gal'] : 'nogrid';
		$grid = isset($output['ess_grid_gal']) ? $output['ess_grid_gal'] : get_option('tp_eg_overwrite_gallery','');
		$grid = isset($output['ess_grid_custom_setting']) && $output['ess_grid_custom_setting']=='on' ? 'nogrid' : $grid;
		// Random Order
		if( isset($output['orderby']) &&  $output['orderby'] == "rand" ){
			$ids = explode(",", $output['ids']);
			shuffle($ids);
			$output['ids'] = implode(",", $ids);
		}
		
		// Parse for Attributes
		$return = array();
		foreach($output as $attr_key => $attr_value){
			$return[] = $attr_key.'="'.$attr_value.'"';
		}
		$return = implode(" ", $return);
		


		if( !empty($grid) ){
			if($grid=="nogrid"){
				
				// Defaults for Param
				$entryskin = !empty($output['entryskin']) ? $output['entryskin'] : 1; 
				$layoutsizing = !empty($output['layoutsizing']) ? $output['layoutsizing'] : 'boxed'; 
				$gridlayout = !empty($output['gridlayout']) ? $output['gridlayout'] : 'even'; 
				$spacings = !empty($output['spacings']) ? $output['spacings'] : 0; 
				$rowsunlimited = !empty($output['rowsunlimited']) ? $output['rowsunlimited'] : 'off'; 
				$rows = !empty($output['rows']) ? $output['rows'] : 3; 
				$gridanimation = !empty($output['gridanimation']) ? $output['gridanimation'] : 'fade'; 
				$usespinner = !empty($output['usespinner']) ? $output['usespinner'] : 0; 

				//echo '[ess_grid  settings=\'{"entry-skin":"'.$entryskin.'","layout-sizing":"'.$layoutsizing.'","grid-layout":"'.$gridlayout.'","spacings":"'.$spacings.'","rows-unlimited":"'.$rowsunlimited.'","columns":"'.$columns.'","rows":"'.$rows.'","grid-animation":"'.$gridanimation.'","use-spinner":"'.$usespinner.'"}\' alias="portfolio1"][gallery '.$return.'][/ess_grid]';
				return do_shortcode('[ess_grid  settings=\'{"entry-skin":"'.$entryskin.'","layout-sizing":"'.$layoutsizing.'","grid-layout":"'.$gridlayout.'","spacings":"'.$spacings.'","rows-unlimited":"'.$rowsunlimited.'","columns":"'.$columns.'","rows":"'.$rows.'","grid-animation":"'.$gridanimation.'","use-spinner":"'.$usespinner.'"}\' alias="'.get_option('tp_eg_overwrite_gallery').'"][gallery '.$return.'][/ess_grid]');
			}
			else{
				return do_shortcode('[ess_grid  settings=\'{"columns":"'.$columns.'"}\' alias="'.$grid.'"][gallery '.$return.'][/ess_grid]');
			}
		}
		else return false;
	}
	
	public static function custom_sorter_int($x, $y){
		global $esg_c_sort_direction, $esg_c_sort_handle;
		
		if(!isset($x[$esg_c_sort_handle])) $x[$esg_c_sort_handle] = 0;
		if(!isset($y[$esg_c_sort_handle])) $y[$esg_c_sort_handle] = 0;
		if(in_array($esg_c_sort_handle, array('date_modified','date','modified'))){
			$x[$esg_c_sort_handle] = strtotime($x[$esg_c_sort_handle]);
			$y[$esg_c_sort_handle] = strtotime($y[$esg_c_sort_handle]);
		} elseif ($esg_c_sort_handle == 'duration') {
			$x[$esg_c_sort_handle] = Essential_Grid::time_to_seconds($x[$esg_c_sort_handle]);
			$y[$esg_c_sort_handle] = Essential_Grid::time_to_seconds($y[$esg_c_sort_handle]);
		}

		
		if($esg_c_sort_direction == 'ASC'){
			return $x[$esg_c_sort_handle] - $y[$esg_c_sort_handle];
		}else{
			return $y[$esg_c_sort_handle] - $x[$esg_c_sort_handle];
		}
	}

	public static function time_to_seconds($time_string){
		$timeArr = array_reverse(explode(":", $time_string));
		$seconds = 0;
		foreach ($timeArr as $key => $value)
		{
		    if ($key > 2) break;
		    $seconds += pow(60, $key) * $value;
		}
		return $seconds;
	}
		
	public static function custom_sorter($x, $y){
		global $esg_c_sort_direction, $esg_c_sort_handle;
		
		if(!isset($x[$esg_c_sort_handle])) $x[$esg_c_sort_handle] = '';
		if(!isset($y[$esg_c_sort_handle])) $y[$esg_c_sort_handle] = '';
		
		if($esg_c_sort_direction == 'ASC'){
			return strcasecmp($x[$esg_c_sort_handle], $y[$esg_c_sort_handle]);
		}else{
			return strcasecmp($y[$esg_c_sort_handle], $x[$esg_c_sort_handle]);
		}
	}
	
	public function set_custom_sorter($handle, $direction){
		global $esg_c_sort_direction, $esg_c_sort_handle;
		
		$esg_c_sort_direction = $direction;
		$esg_c_sort_handle = $handle;
	}
	
	
	public function order_by_custom($order_by_start, $order_by_dir){
		$base = new Essential_Grid_Base();
		
		if(!empty($order_by_start) && !empty($this->grid_layers)){
			if(is_array($order_by_start)){
				$order_by_start = $order_by_start[0];
			}
			
			switch($order_by_start){
				case 'rand':
					$this->grid_layers = $base->shuffle_assoc($this->grid_layers);
				break;
				case 'title':
				case 'post_url':
				case 'excerpt':
				case 'meta':
				case 'alias':
				case 'name':
				case 'content':
				case 'author_name':
				case 'author':
				case 'cat_list':
				case 'tag_list':
					if($order_by_start == 'name') $order_by_start = 'alias';
					if($order_by_start == 'author') $order_by_start = 'author_name';
					//check if values are existing and if not, add them to the layers
					$this->set_custom_sorter($order_by_start, $order_by_dir);
					usort($this->grid_layers, array('Essential_Grid', 'custom_sorter'));
				break;
				case 'post_id':
				case 'ID':
				case 'num_comments':
				case 'comment_count':
				case 'date':
				case 'modified':
				case 'date_modified':
				case 'views':
				case 'likes':
				case 'dislikes':
				case 'retweets':
				case 'favorites':
				case 'itemCount':
				case 'duration':
					if($order_by_start == 'comment_count') $order_by_start = 'num_comments';
					if($order_by_start == 'modified') $order_by_start = 'date_modified';
					if($order_by_start == 'ID') $order_by_start = 'post_id';
					
					$this->set_custom_sorter($order_by_start, $order_by_dir);
					usort($this->grid_layers, array('Essential_Grid', 'custom_sorter_int'));
				break;
			}
		}
	}
	
}