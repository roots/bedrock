<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Wpml{
	
	/**
	 * 
	 * true / false if the wpml plugin exists
	 */
	public static function is_wpml_exists(){
		
		if(class_exists("SitePress"))
			return(true);
		else
			return(false);
	}
	
	/**
	 * valdiate that wpml exists
	 */
	private static function validate_wpml_exists(){
		if(!self::is_wpml_exists())
			Essential_Grid_Base::throw_error(__("The wpml plugin don't exists", EG_TEXTDOMAIN));
	}
	
	/**
	 * get current language
	 */
	public static function get_current_lang(){
		self::validate_wpml_exists();
		$wpml = new SitePress();

		if(is_admin())
			$lang = $wpml->get_default_language();
		else
			$lang = self::get_current_lang_code();
		
		return(apply_filters('essgrid_wpml_get_current_lang', $lang));
	}
	
	/**
	 * get current language code
	 */
	public static function get_current_lang_code(){
		$langTag = ICL_LANGUAGE_CODE;

		return(apply_filters('essgrid_wpml_get_current_lang_code', $langTag));
	}
	
	/**
	 * disable the language filtering
	 */
	public static function disable_language_filtering(){
		self::validate_wpml_exists();
		global $sitepress;
		remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
	}
	
	/**
	 * enable the language filtering
	 */
	public static function enable_language_filtering(){
		self::validate_wpml_exists();
		global $sitepress;
		add_filter('terms_clauses', array($sitepress, 'terms_clauses'));
	}
	
	
	
	/**
	 * get default language id of tag / category
	 */
	public static function get_id_from_lang_id($id, $type = 'category'){
		
		$mid = $id;
		
		if(self::is_wpml_exists()){
			
			$lang = self::get_current_lang_code();
			$real_id = icl_object_id($id, $type, true, $lang);
			
			$mid = $real_id;
			
		}
		
		return apply_filters('essgrid_wpml_get_id_from_lang_id', $mid, $id, $type);
	}
	
	
	/**
	 * get current language id of tag / category
	 */
	public static function get_lang_id_from_id($id, $type = 'category'){
		
		$mid = $id;
		
		if(self::is_wpml_exists()){
			
			$real_id = icl_object_id($id, $type, true);
			
			$mid = $real_id;
			
		}
		
		return apply_filters('essgrid_wpml_get_lang_id_from_id', $mid, $id, $type);
		
	}
	
	
	/**
	 * change cat / tag ids in String to current language
	 */
	public static function change_cat_id_by_lang($catID, $type = 'category'){
		
		$mid = $catID;
		
		if(self::is_wpml_exists()){
			
			$real_id = icl_object_id($catID, $type, true);
			
			$mid = $real_id;
			
		}
		
		return apply_filters('essgrid_wpml_change_cat_id_by_lang', $mid, $catID, $type);
		
	}
	
	
	/**
	 * remove for example @en from categories
	 * @since: 2.1
	 */
	public static function strip_category_additions($text){
		$mtext = $text;
		$mid = $text;

		if(self::is_wpml_exists()){
			$mtext = str_replace('@'.ICL_LANGUAGE_CODE, '', $text);
		}
		
		return apply_filters('essgrid_wpml_strip_category_additions', $mid, $text);
	}
	
}