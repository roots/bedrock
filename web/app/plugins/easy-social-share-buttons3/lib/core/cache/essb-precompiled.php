<?php

class ESSBPrecompiledResources {
	public static $cacheFolder = "";
	public static $cacheURL = "";
	public static $cacheTime = YEAR_IN_SECONDS;//2592000;//3600; // @ since 2.0.3 cache is made to 1 month expiration
	public static $isActive = false;
	
	public static function activate() {
	
		//$upload_dir = wp_upload_dir ();
	
		// since version version 5 all details are moved inside content folder of ESSB
		//$base_path = $upload_dir ['basedir'] . '/essb_compiled/';
		//$base_url = $upload_dir['baseurl'] . '/essb_compiled/';
		
		$base_path = ABSPATH.'wp-content/easysocialsharebuttons-assets/compiled/';
		$base_url = content_url('easysocialsharebuttons-assets/compiled/');
		
		$store_folder = essb_option_value('precompiled_folder');
		if ($store_folder == 'uploads') {
			$upload_dir = wp_upload_dir ();
			
			$base_path = $upload_dir ['basedir'] . '/essb-cache/';
			$base_url = $upload_dir['baseurl'] . '/essb-cache/';
		}
		
		if ($store_folder == 'plugin') {
			$base_path = ESSB3_PLUGIN_ROOT. 'essb-cache/';
			$base_url = ESSB3_PLUGIN_URL . '/essb-cache/';
		}
		
		
		if (has_filter('essb_precompiled_folder')) {
			$base_path = apply_filters('essb_precompiled_folder', $base_path);
		}
		
		if (has_filter('essb_precompiled_url')) {
			$base_url = apply_filters('essb_precompiled_url', $base_url);
		}
		
	
		if ( is_ssl()) {
			$base_url = str_replace( 'http://', 'https://', $base_url );
		}
	
		if (! is_dir ( $base_path )) {
			if (! wp_mkdir_p ( $base_path, 0777 )) {
	
				return false;
			}
	
		}
		self::$cacheFolder = $base_path;
		self::$cacheURL = $base_url;
		
		define('ESSB3_PRECOMPILED_RESOURCE', true);
		self::$isActive = true;
		return true;
	}
	
	public static function put($id = '', $data = '') {
		if (!self::$isActive) {
			return;
		}
		$id = self::key_parser ( $id );
	
		$filename = self::$cacheFolder . $id . '_cache.txt';
	
		if (! file_put_contents ( $filename, $data )) {
			return false;
		}
	
		return true;
	}
	
	public static function put_resource($id = '', $data = '', $type = 'css') {
		if (!self::$isActive) {
			return;
		}
		$id = self::key_parser ( $id );
	
		$filename = self::$cacheFolder . $id . '.'.$type;
	
		if (! file_put_contents ( $filename, $data )) {
			return false;
		}
		else {
			set_transient( 'essb_precache_static-' . $id.'.'.$type, $id, YEAR_IN_SECONDS );				
		}
	
		return true;
	}
	
	public static function key_parser($id) {
		$id = strtolower ( $id );
		$id = str_replace ( ' ', '_', $id );
		$id = md5($id);
		return $id;
	}
	
	public static function get($id = '', $data = '') {
		if (!self::$isActive) {
			return "";
		}
		$id = self::key_parser ( $id );
	
		$filename = self::$cacheFolder . $id . '_cache.txt';
		if (file_exists ( $filename )) {
			$expires = self::$cacheTime;
			$age = (time() - filemtime ($filename));
			if ($age < $expires) {
				$data = file_get_contents ($filename);
				return $data;
			}
			else {
				return "";
			}
		}
		else {
			return "";
		}
	}
	
	public static function get_resource($id = '', $type = 'css') {
		if (!self::$isActive) {
			return "";
		}
		$id = self::key_parser ( $id );
		
		$cached_file = get_transient( 'essb_precache_static-' . $id.'.'.$type );
		
		if ($cached_file != '') {
			$data = self::$cacheURL. $cached_file . '.'.$type;
			return $data;
		}
		else {
			$filename = self::$cacheFolder . $id . '.'.$type;
			if (file_exists ( $filename )) {
				$expires = self::$cacheTime;
				$age = (time() - filemtime ($filename));
				if ($age < $expires) {
					$data = self::$cacheURL. $id . '.'.$type;
					return $data;
				}
				else {
					return "";
				}
			}
			else {
				return "";
			}
		}
	}
	
	public static function flush() {
		if (!self::$isActive) {
			return;
		}
		$base_path = self::$cacheFolder;
	
		if (is_dir ( $base_path )) {
			self::recursiveRemoveDirectory ( $base_path );
		}
		self::purge_essb_cache_static_transients();
		
		return false;
	}
	
	public static function flush_single($id) {
		if (!self::$isActive) {
			return "";
		}
		$id = self::key_parser ( $id );
	
		$filename = self::$cacheFolder . $id . '_cache.txt';
		if (file_exists ( $filename )) {
			unlink ( $filename );
		}
	}
	
	public static function recursiveRemoveDirectory($directory) {
		foreach ( glob ( "{$directory}/*" ) as $file ) {
			if (is_dir ( $file )) {
				self::recursiveRemoveDirectory ( $file );
			} else {
				unlink ( $file );
			}
		}
		//rmdir ( $directory );
	}
	
	public static function get_asset_relative_path( $base_url, $item_url ) {
	
		// Remove protocol reference from the local base URL
		$base_url = preg_replace( '/^(https?:\/\/|\/\/)/i', '', $base_url );
	
		// Check if this is a local asset which we can include
		$src_parts = explode( $base_url, $item_url );
	
		// Get the trailing part of the local URL
		$maybe_relative = end( $src_parts );
	
		if ( ! file_exists( ABSPATH . $maybe_relative ) )
			return false;
	
		return $maybe_relative;
	
	}
	
	public static function purge_essb_cache_static_transients() {
		global $wpdb;
	
		$time_now = time();
		$expired  = $wpdb->get_col( "SELECT option_name FROM $wpdb->options where (option_name LIKE '_transient_timeout_essb_precache_static-%') OR (option_name LIKE '_transient_essb_precache_static-%')" );
		if( empty( $expired ) ) {
			return false;
		}
	
		foreach( $expired as $transient ) {
	
			$name = str_replace( '_transient_timeout_', '', $transient );
			$name = str_replace( '_transient_', '', $transient );
			delete_transient( $name );
	
		}
	
		return true;
	}
}

?>