<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Import {
	
	private $overwrite_data = false;
	
	public function set_overwrite_data($data){
		$this->overwrite_data = $data;
	}
	
	
	public function import_grids($import_grids, $import_ids = true, $check_append = true){
		$d = apply_filters('essgrid_import_grids', array('import_grids' => $import_grids, 'import_ids' => $import_ids, 'check_append' => $check_append));
		$import_grids = $d['import_grids'];
		$import_ids = $d['import_ids'];
		$check_append = $d['check_append'];
		
		if($import_grids !== false && !empty($import_grids)){
			global $wpdb;
			$c_grid = new Essential_Grid();
			$base = new Essential_Grid_Base();
			$table_name = $wpdb->prefix . Essential_Grid::TABLE_GRID;
			$item_skin = new Essential_Grid_Item_Skin();
		
			$grids = $c_grid->get_essential_grids();
			
			foreach($import_grids as $i_grid){
				if(!empty($import_ids) && is_array($import_ids)){
					$found = false;
					foreach($import_ids as $id){
						if($i_grid['id'] == $id){
							$found = true;
							break;
						}
					}
					if(!$found) continue;
				}else{
					if($import_ids != true) //only break if we do not want to import all
						break;
				}
				
				//create/get category and tags if there are some selected
				$check = json_decode($i_grid['postparams'], true);
				if(isset($check['post_category']) && !empty($check['post_category'])){
					$slug_cats = array();
					$the_cats = explode(',', $check['post_category']);
					foreach($the_cats as $cat){
						$raw = explode('_', $cat);
						$catSlug = $raw[count($raw)-1];
						unset($raw[count($raw)-1]);
						$cat = implode('_', $raw);
						
						$category = $base->get_create_category_by_slug($catSlug, $cat);
						
						if($category !== false) //only add if we have a ID
							$slug_cats[] = $cat.'_'.$category;
					}
					$check['post_category'] = implode(',', $slug_cats);
					
					$i_grid['postparams'] = json_encode($check);
					
				}
				
				$check = json_decode($i_grid['params'], true);
				if(isset($check['entry-skin']) && !empty($check['entry-skin'])){
					$skin = $item_skin->get_id_by_handle($check['entry-skin']);
					if(!empty($skin)){
						$check['entry-skin'] = $skin['id'];
					}
					$i_grid['params'] = json_encode($check);
				}
				
				$exist = false;
				if(!empty($grids)){
					foreach($grids as $grid){
						if($grid->handle == $i_grid['handle']){
							$i_grid['id'] = $grid->id; //this will force an update
							$exist = true;
							break;
						}
					}
				}
			
				if($import_ids === true){ //do not insert if handle exists. This is for the import demo data process
					if($exist) continue;
				}
				
				$append = true;
				if($exist){ //skin exists - append or overwrite
					if($check_append){ //check in data if append or overwrite
						$do = $base->getVar($this->overwrite_data, 'element-overwrite-'.$i_grid['id'], 'append');
						$append = ($do == 'append') ? true : false;
					}
				}
				
				
				if($import_ids !== true){
					if($append){ //append
						if($exist){
							$i_grid['handle'] = $i_grid['handle'].'-'.date('His');
							$i_grid['name'] = $i_grid['name'].'-'.date('His');
						}
						
						$response = $wpdb->insert($table_name, array('name' => $i_grid['name'], 'handle' => $i_grid['handle'], 'postparams' => $i_grid['postparams'], 'params' => $i_grid['params'], 'layers' => $i_grid['layers']));
						
					}else{ //overwrite
						$response = $wpdb->update($table_name, array('name' => $i_grid['name'], 'handle' => $i_grid['handle'], 'postparams' => $i_grid['postparams'], 'params' => $i_grid['params'], 'layers' => $i_grid['layers']), array('id' => $i_grid['id']));
						
					}
				}else{ //create or overwrite
					if($exist){
						$response = $wpdb->update($table_name, array('name' => $i_grid['name'], 'handle' => $i_grid['handle'], 'postparams' => $i_grid['postparams'], 'params' => $i_grid['params'], 'layers' => $i_grid['layers']), array('id' => $i_grid['id']));
					}else{
						$response = $wpdb->insert($table_name, array('name' => $i_grid['name'], 'handle' => $i_grid['handle'], 'postparams' => $i_grid['postparams'], 'params' => $i_grid['params'], 'layers' => $i_grid['layers']));
					}
				}
			}
		}
		
	}
	
	
	public function import_skins($import_skins, $import_ids, $check_append = true){
		$d = apply_filters('essgrid_import_skins', array('import_skins' => $import_skins, 'import_ids' => $import_ids, 'check_append' => $check_append));
		$import_skins = $d['import_skins'];
		$import_ids = $d['import_ids'];
		$check_append = $d['check_append'];
		
		if($import_skins !== false && !empty($import_skins)){
			global $wpdb;
			$item_skin = new Essential_Grid_Item_Skin();
			$base = new Essential_Grid_Base();
			$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;
		
			$skins = $item_skin->get_essential_item_skins('all', false); //false = do not decode params
			
			foreach($import_skins as $i_skin){
				if(!empty($import_ids) && is_array($import_ids)){
					$found = false;
					foreach($import_ids as $id){
						if($i_skin['id'] == $id){
							$found = true;
							break;
						}
					}
					if(!$found) continue;
				}else{
					break;
				}
				
				$exist = false;
				if(!empty($skins)){
					foreach($skins as $skin){
						if($skin['handle'] == $i_skin['handle']){
							$i_skin['id'] = $skin['id']; //this will force an update
							$exist = true;
							break;
						}
					}
				}
				
				$append = true;
				if($exist){ //skin exists - append or overwrite
					if($check_append){ //check in data if append or overwrite
						$do = $base->getVar($this->overwrite_data, 'skin-overwrite-'.$i_skin['id'], 'append');
						$append = ($do == 'append') ? true : false;
					}
				}
				
				if($append){ //append
					if($exist){
						$i_skin['handle'] = $i_skin['handle'].'-'.date('His');
						$i_skin['name'] = $i_skin['name'].'-'.date('His');
					}
					$response = $wpdb->insert($table_name, array('name' => $i_skin['name'], 'handle' => $i_skin['handle'], 'params' => $i_skin['params'], 'layers' => $i_skin['layers']));
					
				}else{ //overwrite
					
					$response = $wpdb->update($table_name, array('name' => $i_skin['name'], 'handle' => $i_skin['handle'], 'params' => $i_skin['params'], 'layers' => $i_skin['layers']), array('id' => $i_skin['id']));
				}
				
			}
		}
		
	}
	
	
	public function import_elements($import_elements, $import_ids, $check_append = true){
		$d = apply_filters('essgrid_import_elements', array('import_elements' => $import_elements, 'import_ids' => $import_ids, 'check_append' => $check_append));
		$import_elements = $d['import_elements'];
		$import_ids = $d['import_ids'];
		$check_append = $d['check_append'];
		
		if($import_elements !== false && !empty($import_elements)){
			global $wpdb;
			$c_elements = new Essential_Grid_Item_Element();
			$base = new Essential_Grid_Base();
			$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		
			$elements = $c_elements->get_essential_item_elements();
			
			foreach($import_elements as $i_element){
				if(!empty($import_ids) && is_array($import_ids)){
					$found = false;
					foreach($import_ids as $id){
						if($i_element['id'] == $id){
							$found = true;
							break;
						}
					}
					if(!$found) continue;
				}else{
					break;
				}
				
				$exist = false;
				if(!empty($elements)){
					foreach($elements as $element){
						if($element['handle'] == $i_element['handle']){
							$i_element['id'] = $element['id']; //this will force an update
							$exist = true;
							break;
						}
					}
				}
				
				$append = true;
				if($exist){ //skin exists - append or overwrite
					if($check_append){ //check in data if append or overwrite
						$do = $base->getVar($this->overwrite_data, 'element-overwrite-'.$i_element['id'], 'append');
						$append = ($do == 'append') ? true : false;
					}
				}
				
				if($append){ //append
					if($exist){
						$i_element['handle'] = $i_element['handle'].'-'.date('His');
						$i_element['name'] = $i_element['name'].'-'.date('His');
					}
					$response = $wpdb->insert($table_name, array('name' => $i_element['name'], 'handle' => $i_element['handle'], 'settings' => $i_element['settings']));
					
				}else{ //overwrite
					
					$response = $wpdb->update($table_name, array('name' => $i_element['name'], 'handle' => $i_element['handle'], 'settings' => $i_element['settings']), array('id' => $i_element['id']));
				}
				
			}
		}
		
	}
	
	
	public function import_navigation_skins($import_navigation_skins, $import_ids, $check_append = true){
		$d = apply_filters('essgrid_import_navigation_skins', array('import_navigation_skins' => $import_navigation_skins, 'import_ids' => $import_ids, 'check_append' => $check_append));
		$import_navigation_skins = $d['import_navigation_skins'];
		$import_ids = $d['import_ids'];
		$check_append = $d['check_append'];

		if($import_navigation_skins !== false && !empty($import_navigation_skins)){
			global $wpdb;
			$c_nav = new Essential_Grid_Navigation();
			$base = new Essential_Grid_Base();
			$table_name = $wpdb->prefix . Essential_Grid::TABLE_NAVIGATION_SKINS;
		
			$nav_skins = $c_nav->get_essential_navigation_skins();
			
			foreach($import_navigation_skins as $i_nav_skin){
				if(!empty($import_ids) && is_array($import_ids)){
					$found = false;
					foreach($import_ids as $id){
						if($i_nav_skin['id'] == $id){
							$found = true;
							break;
						}
					}
					if(!$found) continue;
				}else{
					break;
				}
				
				$exist = false;
				if(!empty($nav_skins)){
					foreach($nav_skins as $nav_skin){
						if($nav_skin['handle'] == $i_nav_skin['handle']){
							$i_nav_skin['id'] = $nav_skin['id']; //this will force an update
							$exist = true;
							break;
						}
					}
				}
				
				$append = true;
				if($exist){ //skin exists - append or overwrite
					if($check_append){ //check in $_POST if append or overwrite
						$do = $base->getVar($this->overwrite_data, 'nav-skin-overwrite-'.$i_nav_skin['id'], 'append');
						$append = ($do == 'append') ? true : false;
					}
				}
				
				$i_nav_skin['css'] = str_replace(array('\n', '\t'), array(chr(13), chr(9)), $i_nav_skin['css']);
				//remove first and last "
				if(substr($i_nav_skin['css'], 0, 1) == '"') $i_nav_skin['css'] = substr($i_nav_skin['css'], 1);
				if(substr($i_nav_skin['css'], -1) == '"') $i_nav_skin['css'] = substr($i_nav_skin['css'], 0, -1);
				
				$i_nav_skin['css'] = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', array('Essential_Grid_Import', 'mb_convert_string'), $i_nav_skin['css']);
				
				
				if($append){ //append
					if($exist){
						$orig_handle = $i_nav_skin['handle'];
						$i_nav_skin['handle'] = $i_nav_skin['handle'].'-'.date('His');
						$i_nav_skin['name'] = $i_nav_skin['name'].'-'.date('His');
						$i_nav_skin['css'] = str_replace($orig_handle, $i_nav_skin['handle'], $i_nav_skin['css']); //replace the class name to the new name
					}
					
					$response = $wpdb->insert($table_name, array('name' => $i_nav_skin['name'], 'handle' => $i_nav_skin['handle'], 'css' => $i_nav_skin['css']));
					
				}else{ //overwrite
					
					$response = $wpdb->update($table_name, array('css' => $i_nav_skin['css']), array('id' => $i_nav_skin['id']));
					
				}
				
			}
		}
		
	}
	
	
	public static function mb_convert_string($match) {
		return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
	}
	
	
	public function import_custom_meta($import_custom_meta, $import_handles = true, $check_append = true){
		$d = apply_filters('essgrid_import_custom_meta', array('import_custom_meta' => $import_custom_meta, 'import_handles' => $import_handles, 'check_append' => $check_append));
		$import_custom_meta = $d['import_custom_meta'];
		$import_handles = $d['import_handles'];
		$check_append = $d['check_append'];
		
		$base = new Essential_Grid_Base();
		$metas = new Essential_Grid_Meta();
		$link_metas = new Essential_Grid_Meta_Linking();
		$custom_metas = $metas->get_all_meta();
		
		foreach($import_custom_meta as $i_custom_meta){
			$type = (isset($i_custom_meta['m_type']) && $i_custom_meta['m_type'] == 'link') ? 'link' : 'meta';
			
			if(!empty($import_handles) && is_array($import_handles)){
				$found = false;
				foreach($import_handles as $handle){
					if($i_custom_meta['handle'] == $handle){
						$found = true;
						break;
					}
				}
				if(!$found) continue;
			}else{
				if($import_handles !== true)
					break;
			}
			
			$exist = false;
			if(!empty($custom_metas)){
				foreach($custom_metas as $meta){
					if($meta['handle'] == $i_custom_meta['handle']){
						if($type == $meta['m_type']){
							$exist = true;
							break;
						}
					}
				}
			}
			
			if($import_handles == true) //do not insert if handle exists. This is for the import demo data process
				if($exist) continue;
				
			$append = true;
			if($exist){ //skin exists - append or overwrite
				if($check_append){ //check in $_POST if append or overwrite
					$do = $base->getVar($this->overwrite_data, 'custom-meta-overwrite-'.$i_custom_meta['handle'], 'append');
					$append = ($do == 'append') ? true : false;
				}
			}
			
			if($import_handles !== true){
				if($append){ //append
					if($exist){
						$orig_handle = $i_custom_meta['handle'];
						$i_custom_meta['handle'] = $i_custom_meta['handle'].'-'.date('His');
						$i_custom_meta['name'] = $i_custom_meta['name'].'-'.date('His');
					}
					
					if($type == 'meta'){
						$metas->add_new_meta($i_custom_meta);
					}elseif($type == 'link'){
						$link_metas->add_new_link_meta($i_custom_meta);
					}
				}else{ //overwrite
					if($type == 'meta'){
						$metas->edit_meta_by_handle($i_custom_meta);
					}elseif($type == 'link'){
						$link_metas->edit_link_meta_by_handle($i_custom_meta);
					}
				}
			}else{ //create or overwrite
				if($exist){
					if($type == 'meta'){
						$metas->edit_meta_by_handle($i_custom_meta);
					}elseif($type == 'link'){
						$link_metas->edit_link_meta_by_handle($i_custom_meta);
					}
				}else{
					if($type == 'meta'){
						$metas->add_new_meta($i_custom_meta);
					}elseif($type == 'link'){
						$link_metas->add_new_link_meta($i_custom_meta);
					}
				}
			}
		}
		
	}
	
	
	public function import_punch_fonts($import_punch_fonts, $import_handles = true, $check_append = true){
		$d = apply_filters('essgrid_import_punch_fonts', array('import_punch_fonts' => $import_punch_fonts, 'import_handles' => $import_handles, 'check_append' => $check_append));
		$import_punch_fonts = $d['import_punch_fonts'];
		$import_handles = $d['import_handles'];
		$check_append = $d['check_append'];

		$base = new Essential_Grid_Base();
		$fonts = new ThemePunch_Fonts();
		$punch_fonts = $fonts->get_all_fonts();
		
		foreach($import_punch_fonts as $i_punch_font){
			if(!empty($import_handles) && is_array($import_handles)){
				$found = false;
				foreach($import_handles as $handle){
					if($i_punch_font['handle'] == $handle){
						$found = true;
						break;
					}
				}
				if(!$found) continue;
			}else{
				if($import_handles !== true)
					break;
			}
			
			$exist = false;
			if(!empty($punch_fonts)){
				foreach($punch_fonts as $font){
					if($font['handle'] == $i_punch_font['handle']){
						$exist = true;
						break;
					}
				}
			}
			
			if($import_handles == true) //do not insert if handle exists. This is for the import demo data process
				if($exist) continue;
			
			$append = true;
			if($exist){ //skin exists - append or overwrite
				if($check_append){ //check in $_POST if append or overwrite
					$do = $base->getVar($this->overwrite_data, 'punch-fonts-overwrite-'.$i_punch_font['handle'], 'append');
					$append = ($do == 'append') ? true : false;
				}
			}
			
			if($import_handles !== true){
				if($append){ //append
					if($exist){
						$orig_handle = $i_punch_font['handle'];
						$i_punch_font['handle'] = $i_punch_font['handle'].'-'.date('His');
					}
					$fonts->add_new_font($i_punch_font);
				}else{ //overwrite
					$fonts->edit_font_by_handle($i_punch_font);
				}
			}else{ //create or overwrite
				if($exist){
					$fonts->edit_font_by_handle($i_punch_font);
				}else{
					$fonts->add_new_font($i_punch_font);
				}
			}
		}
		
	}
	
	
	public function import_global_styles($import_global_styles, $check_append = true){
		$d = apply_filters('essgrid_import_global_styles', array('import_global_styles' => $import_global_styles, 'import_handles' => $import_handles, 'check_append' => $check_append));
		$import_global_styles = $d['import_global_styles'];
		$check_append = $d['check_append'];
		
		$base = new Essential_Grid_Base();
		$c_css = new Essential_Grid_Global_Css();
		
		$append = true;
		if($check_append){ //check in $_POST if append or overwrite
			$do = $base->getVar($this->overwrite_data, 'global-styles-overwrite', 'append');
			$append = ($do == 'append') ? true : false;
		}
		
		$import_global_styles = str_replace(array('\n', '\t'), array(chr(13), chr(9)), $import_global_styles);
		//remove first and last "
		if(substr($import_global_styles, 0, 1) == '"') $import_global_styles = substr($import_global_styles, 1);
		if(substr($import_global_styles, -1) == '"') $import_global_styles = substr($import_global_styles, 0, -1);
		
		$import_global_styles = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', array('Essential_Grid_Import', 'mb_convert_string'), $import_global_styles);
		
		if($append){ //append
			$global_styles = $c_css->get_global_css_styles();
			$import_global_styles = $global_styles.$import_global_styles;
			
		}
		
		$c_css->set_global_css_styles($import_global_styles);
		
	}
	
}

?>