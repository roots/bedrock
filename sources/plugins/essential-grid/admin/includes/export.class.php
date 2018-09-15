<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Export {
	
	public function export_grids($export_grids){
		$export_grids = apply_filters('essgrid_export_grids_pre', $export_grids);

		$return_grids = array();
		if($export_grids !== false && !empty($export_grids)){
			$c_grid = new Essential_Grid();
			$base = new Essential_Grid_Base();
			$item_skin = new Essential_Grid_Item_Skin();
			
			$grids = $c_grid->get_essential_grids();
			if(!empty($grids)){
				foreach($export_grids as $e_grid_id){
					foreach($grids as $grid){
						$grid = (array)$grid;
						if($e_grid_id == $grid['id']){
							//change categories/tags id to slug
							$check = json_decode($grid['postparams'], true);
							if(isset($check['post_category']) && !empty($check['post_category'])){
								$slug_cats = array();
								$the_cats = explode(',', $check['post_category']);
								foreach($the_cats as $cat){
									$raw = explode('_', $cat);
									$catSlug = $raw[count($raw)-1];
									unset($raw[count($raw)-1]);
									$cat = implode('_', $raw);
									
									$category = $base->get_categories_by_ids((array)$catSlug, $cat);
									foreach($category as $cat_obj){
										$slug_cats[] = $cat.'_'.$cat_obj->slug;
									}
								}
								$check['post_category'] = implode(',', $slug_cats);
								
								$grid['postparams'] = json_encode($check);
								
							}
							
							//change choosen skinid to skinhandle
							$check = json_decode($grid['params'], true);
							if(isset($check['entry-skin']) && !empty($check['entry-skin']) && intval($check['entry-skin']) != 0){
								$skin = $item_skin->get_handle_by_id($check['entry-skin']);
								if(!empty($skin)){
									$check['entry-skin'] = $skin['handle'];
									
								}
								$grid['params'] = json_encode($check);
							}
							
							$return_grids[] = $grid;
							break;
						}
					}
				}
			}
		}
		
		return apply_filters('essgrid_export_grids_post', $return_grids);
	}
	
	
	public function export_skins($export_skins){
		$export_skins = apply_filters('essgrid_export_skins_pre', $export_skins);

		$return_skins = array();
		if($export_skins !== false && !empty($export_skins)){
			$item_skin = new Essential_Grid_Item_Skin();
			$skins = $item_skin->get_essential_item_skins('all', false); //false = do not decode params
			
			if(!empty($skins)){
				foreach($export_skins as $e_skin_id){
					foreach($skins as $skin){
						if($e_skin_id == $skin['id']){
							$return_skins[] = $skin;
							break;
						}
					}
				}
			}
		}
		
		return apply_filters('essgrid_export_skins_post', $return_skins);
	}
	
	
	public function export_elements($export_elements){
		$export_elements = apply_filters('essgrid_export_elements_pre', $export_elements);

		$return_elements = array();
		if($export_elements !== false && !empty($export_elements)){
			$c_elements = new Essential_Grid_Item_Element();
			$elements = $c_elements->get_essential_item_elements();
			
			if(!empty($elements)){
				foreach($export_elements as $e_ele_id){
					foreach($elements as $element){
						if($e_ele_id == $element['id']){
							$return_elements[] = $element;
							break;
						}
					}
				}
			}
		}
		
		return apply_filters('essgrid_export_elements_post', $return_elements);
	}
	
	
	public function export_navigation_skins($export_navigation_skins){
		$export_navigation_skins = apply_filters('essgrid_export_navigation_skins_pre', $export_navigation_skins);
		
		$return_nav_skins = array();
		if($export_navigation_skins !== false && !empty($export_navigation_skins)){
			$c_skins = new Essential_Grid_Navigation();
			$skins = $c_skins->get_essential_navigation_skins();
			
			if(!empty($skins)){
				foreach($export_navigation_skins as $e_skin_id){
					foreach($skins as $skin){
						if($e_skin_id == $skin['id']){
							$return_nav_skins[] = $skin;
							break;
						}
					}
				}
			}
		}
		
		return apply_filters('essgrid_export_navigation_skins_post', $return_nav_skins);
	}
	
	
	public function export_custom_meta($export_custom_meta){
		$export_custom_meta = apply_filters('essgrid_export_custom_meta_pre', $export_custom_meta);
		
		$return_metas = array();
		if($export_custom_meta !== false && !empty($export_custom_meta)){
			$metas = new Essential_Grid_Meta();
			$custom_metas = $metas->get_all_meta();
			
			if(!empty($export_custom_meta)){
				foreach($custom_metas as $c_meta){
					foreach($export_custom_meta as $meta){
						if($c_meta['handle'] == $meta){
							$return_metas[] = $c_meta;
							break;
						}
					}
				}
			}
		}
		
		return apply_filters('essgrid_export_custom_meta_prost', $return_metas);
	}
	
	
	public function export_punch_fonts($export_punch_fonts){
		$export_punch_fonts = apply_filters('essgrid_export_punch_fonts_pre', $export_punch_fonts);
		
		$return_metas = array();
		if($export_punch_fonts !== false && !empty($export_punch_fonts)){
			$fonts = new ThemePunch_Fonts();
			$custom_fonts = $fonts->get_all_fonts();
			
			if(!empty($export_punch_fonts)){
				foreach($custom_fonts as $c_font){
					foreach($export_punch_fonts as $font){
						if($c_font['handle'] == $font){
							$return_metas[] = $c_font;
							break;
						}
					}
				}
			}
		}
		
		return apply_filters('essgrid_export_punch_fonts_post', $return_metas);
	}
	
	
	public function export_global_styles($export_global_styles){
		$export_global_styles = apply_filters('essgrid_export_global_styles_pre', $export_global_styles);

		$global_styles = '';
		
		if($export_global_styles == 'on'){
			$c_css = new Essential_Grid_Global_Css();
			$global_styles = $c_css->get_global_css_styles();
		}
		
		return apply_filters('essgrid_export_global_styles_post', $global_styles);
	}
	
}
?>