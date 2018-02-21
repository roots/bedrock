<?php
/**
 * Resource Builder 
 * 
 * @author appscreo
 * @package EasySocialShareButtons
 * @since 3.0
 * @version 4.0
 *
 */

class ESSBResourceBuilder {

	private $class_version = '4.0';
	
	public $resource_version = ESSB3_VERSION;

	// resource builder options
	public $scripts_in_head = false;
	
	public $inline_css_footer = false;
	
	public $js_async = false;
	public $js_defer = false;
	public $js_head = false;
	
	// css code
	public $css_head = array();
	public $css_footer = array();
	public $css_static = array();
	public $css_static_footer = array();
	
	// javascript code
	public $js_code_head = array();
	public $js_code = array();
	public $js_code_noncachable = array();
	public $js_static = array();
	public $js_static_nonasync = array();
	public $js_static_footer = array();
	public $js_static_noasync_footer = array();
		
	public $js_social_apis = array();
	
	public $precompiled_css_queue = array();
	public $precompiled_js_queue = array();
	
	public $active_resources = array();
	
	private $precompile_css = false;
	private $precompile_js = false;
	
	private static $instance = null;
	
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	
	function __construct() {
		
		$this->inline_css_footer = essb_option_bool_value('load_css_footer');
		
		// dynamic CSS in footer
		$precompiled_mode = false;
		$precompiled_mode_css = false;
		$precompiled_mode_js = false;
		
		if (defined('ESSB3_PRECOMPILED_RESOURCE')) {
			$precompiled_mode_resources = essb_option_value('precompiled_mode');
			
			if ($precompiled_mode_resources == '' || $precompiled_mode_resources == 'css') {
				$precompiled_mode_css = true;
			}
			if ($precompiled_mode_resources == '' || $precompiled_mode_resources == 'js') {
				$precompiled_mode_js = true;
			}
				
			if ($precompiled_mode_css) {
				$this->inline_css_footer = true;
			}
			
			$precompiled_mode = true;
			
			$this->precompile_css = $precompiled_mode_css;
			$this->precompile_js = $precompiled_mode_js;
			
		}
		
		add_action('wp_head', array($this, 'header'));
		add_action('wp_footer', array($this, 'footer'), 999);
		
		if (!$precompiled_mode_css) {
			if ($this->inline_css_footer) {
				add_action('essb_rs_footer', array($this, 'generate_custom_css'), 997);
			}
			else {
				add_action('essb_rs_head', array($this, 'generate_custom_css'));
			}
			add_action('essb_rs_footer', array($this, 'generate_custom_footer_css'), 998);
		}
		else {
			add_action('essb_rs_footer', array($this, 'generate_custom_css_precompiled'), 996);
		}
		
		add_action('essb_rs_head', array($this, 'generate_custom_js'));

		if (!$precompiled_mode_js) {
			add_action('essb_rs_footer', array($this, 'generate_custom_footer_js'), 998);	
		}
		else {
			add_action('essb_rs_footer', array($this, 'generte_custom_js_precompiled'), 996);
		}
		// static CSS and javascripts sources enqueue
		add_action ( 'wp_enqueue_scripts', array ($this, 'register_front_assets' ), 10 );
		
		// initalize resource builder options based on settings
		$this->js_head = essb_option_bool_value('scripts_in_head');
		$this->js_async = essb_option_bool_value('load_js_async');
		$this->js_defer = essb_option_bool_value('load_js_defer');

				
		$remove_ver_resource = essb_option_bool_value('remove_ver_resource');
		if ($remove_ver_resource) { 
			$this->resource_version = '';
		}
	}
	
	public function header() {
		do_action('essb_rs_head');
	}
	
	public function footer() {
		// since version 4 we introduce new mail form code added here
		if ($this->is_activated('mail')) {
			essb_depend_load_function('essb_rs_mailform_build', 'lib/core/resource-snippets/essb_rs_code_mailform.php');				
		}
		
		do_action('essb_rs_footer');
	}
	
	
	/**
	 * Cloning disabled
	 */
	public function __clone() {
	}
	
	/**
	 * Serialization disabled
	 */
	public function __sleep() {
	}
	
	/**
	 * De-serialization disabled
	 */
	public function __wakeup() {
	}
	
		
	public function deactivate_actions() { 
		
		remove_action('wp_head', array($this, 'header'));
		remove_action('wp_footer', array($this, 'footer'), 999);
		remove_action ('wp_enqueue_scripts', array ($this, 'register_front_assets' ), 10 );
		
		
	}
	
	public function activate_resource($key) {
		$this->active_resources[$key] = 'loaded';
	}
	
	public function is_activated($key) {
		return isset($this->active_resources[$key]) ? true : false;
	}
	
	/**
	 * add_static_resource
	 * 
	 * @param unknown_type $file_with_path
	 * @param unknown_type $key
	 * @param unknown_type $type
	 */
	public function add_static_resource($file_with_path, $key, $type = '', $noasync = false) {
		if ($type == 'css') {
			$this->css_static[$key] = $file_with_path;
		}
		if ($type == 'js') {
			if ($noasync) {
				$this->js_static_nonasync[$key] = $file_with_path;
			}
			else {
				$this->js_static[$key] = $file_with_path;
			}
		}
	}
	
	public function add_static_resource_footer($file_with_path, $key, $type = '', $noasync = false) {
		if ($type == 'css') {
			$this->css_static_footer[$key] = $file_with_path;
		}
		if ($type == 'js') {
			if ($noasync) {
				// @since 3.0.4 - double check for the twice counter load script
				if (!isset($this->js_static_nonasync[$key])) {
					$this->js_static_noasync_footer[$key] = $file_with_path;
				}
			}
			else {
				// @since 3.0.4 - double check for the twice counter load script
				if (!isset($this->js_static[$key])) {
					$this->js_static_footer[$key] = $file_with_path;
				}
			}
		}
	}
	
	public function add_static_footer_css($file_with_path, $key) {
		$this->css_static_footer[$key] = $file_with_path;
 	}
	
	/**
	 * add_css
	 * 
	 * @param string $code
	 * @param string $key
	 * @param string $location
	 */
	public function add_css($code, $key = '', $location = 'head') {
		if ($key != '') {
			if ($location == 'head') {
				$this->css_head[$key] = $code;
			}
			else {
				$this->css_footer[$key] = $code;
			}
		}
		else {
			if ($location == 'head') {
				$this->css_head[] = $code;
			}
			else {
				$this->css_footer[] = $code;
			}
		}
	}	
	
	public function add_social_api($key) {
		$this->js_social_apis[$key] = 'loaded';
	}
	
	/**
	 * add_js
	 * 
	 * @param string $code
	 * @param bool $minify
	 * @param string $key
	 * @param string $position
	 */
	public function add_js($code, $minify = false, $key = '', $position = 'footer', $noncachble = false) {
		if ($minify) {
			$code = trim(preg_replace('/\s+/', ' ', $code));
		}	
		
		if ($key != '') {
			if ($position == 'footer') {
				if ($noncachble) {
					$this->js_code_noncachable[$key] = $code;
				}
				else {
					$this->js_code[$key] = $code;
				}
			}
			else {
				$this->js_code_head[$key] = $code;
			}
		}
		else {
			if ($position == 'footer') {
				if ($noncachble) {
					$this->js_code_noncachable[] = $code;
				}
				else {
					$this->js_code[] = $code;
				}				
			}
			else {
				$this->js_code_head[] = $code;
			}				
		}
	}
	
	/*
	 * Enqueue all front CSS and javascript files
	 */
	
	
	function enqueue_style_single_css($key, $file, $version) {
		if (!$this->precompile_css) {
			wp_enqueue_style ( $key, $file, false, $this->resource_version, 'all' );
		}
		else {
			$this->precompiled_css_queue[$key] = $file;
		}
	}
		
	function register_front_assets() {
		if (essb_is_plugin_deactivated_on()) {
			return;
		}	
		
		$load_in_footer = ($this->js_head) ? false : true;
		
		if (!essb_option_bool_value('use_stylebuilder')) {
			// enqueue all css registered files
			foreach ($this->css_static as $key => $file) {
				if ($key == 'easy-social-share-buttons-profles') {
					if (!essb_is_module_deactivated_on('profiles')) {
						$this->enqueue_style_single_css($key, $file, $this->resource_version);
					}
				}
				else if ($key == 'easy-social-share-buttons-nativeskinned' || $key == 'essb-fontawsome' || $key == 'essb-native-privacy') {
					if (!essb_is_module_deactivated_on('native')) {
						$this->enqueue_style_single_css($key, $file, $this->resource_version);						
					}
				}
				else {
					$this->enqueue_style_single_css($key, $file, $this->resource_version);
				}				
			}
		}
		else {
			// using build in builder styles
			$user_styles = essb_option_value('stylebuilder_css');
			if (!is_array($user_styles)) {
				$user_styles = array();
			}
			
			if (count($user_styles) > 0) {
				$this->enqueue_style_single_css('essb-userstyles', content_url('easysocialsharebuttons-assets/essb-userselection.min.css'), $this->resource_version);
			}
		}
		
		foreach ($this->js_static_nonasync as $key => $file) {
			wp_enqueue_script ( $key, $file, array ( 'jquery' ), $this->resource_version, $load_in_footer );
		}
		
		// load scripts when no async or deferred is selected
		if (!$this->js_async && !$this->js_defer) {
			foreach ($this->js_static as $key => $file) {
				if (!$this->precompile_js) {
					wp_enqueue_script ( $key, $file, array ( 'jquery' ), $this->resource_version, $load_in_footer );
				}
				else {
					$this->precompiled_js_queue[$key] = $file;
				}
			}
		}
	}
	
	/*
	 *  Code generation functions: CSS
	 */
	
	/**
	 * generate_custom_css
	 */
	function generate_custom_css() {
		global $post;
		
		if (essb_is_plugin_deactivated_on ()) {
			return;
		}
		
		//$this->add_css ( ESSBResourceBuilderSnippets::css_build_customizer (), 'essb-customcss-header' );
		
		$cache_slug = 'essb-css-head';
		
		if (defined ( 'ESSB3_CACHE_ACTIVE_RESOURCE' )) {
			if (isset ( $post )) {
				$cache_key = $cache_slug . $post->ID;
				
				if (essb_dynamic_cache_load_css ( $cache_key )) {
					return;
				}
			}
		}
		
		// if (count($this->css_head) > 0) {
		$css_code = '';
		foreach ( $this->css_head as $single ) {
			$css_code .= $single;
		}
		
		$css_code = apply_filters ( 'essb_css_buffer_head', $css_code );
		//print "header css = ".$css_code;
		$css_code = trim ( preg_replace ( '/\s+/', ' ', $css_code ) );
		

		
		if ($css_code != '') {
			if (defined ( 'ESSB3_CACHE_ACTIVE_RESOURCE' )) {
				if (isset ( $post )) {
					$cache_key = $cache_slug . $post->ID;
					ESSBDynamicCache::put_resource ( $cache_key, $css_code, 'css' );
					essb_dynamic_cache_load_css ( $cache_key );
					return;
				}
			}
			
			echo '<style type="text/css">';
			echo $css_code;
			echo '</style>';
		}
		// }
	}
	
	function generate_custom_footer_css() {
		global $post;
		
		if (essb_is_plugin_deactivated_on ()) {
			return;
		}
		
		//$this->add_css ( ESSBResourceBuilderSnippets::css_build_footer_css (), 'essb-footer-css', 'footer' );
		
		if (count ( $this->css_static_footer ) > 0) {
			foreach ( $this->css_static_footer as $key => $file ) {
				printf ( '<link rel="stylesheet" id="%1$s"  href="%2$s" type="text/css" media="all" />', $key, $file );
			}
		}
		
		$cache_slug = 'essb-css-footer';
		
		if (isset ( $post )) {
			
			if (defined ( 'ESSB3_CACHE_ACTIVE_RESOURCE' )) {
				$cache_key = $cache_slug . $post->ID;
				
				if (essb_dynamic_cache_load_css ( $cache_key )) {
					return;
				}
			}
		}
		
		// $css_code = implode(" ", $this->css_footer);
		$css_code = '';
		foreach ( $this->css_footer as $single ) {
			$css_code .= $single;
		}
		
		//print "footer code = ".$css_code;
		
		$css_code = apply_filters ( 'essb_css_buffer_footer', $css_code );
		
		$css_code = trim ( preg_replace ( '/\s+/', ' ', $css_code ) );
		
		if ($css_code != '') {
			if (isset ( $post )) {
				
				if (defined ( 'ESSB3_CACHE_ACTIVE_RESOURCE' )) {
					$cache_key = $cache_slug . $post->ID;
					
					ESSBDynamicCache::put_resource ( $cache_key, $css_code, 'css' );
					
					essb_dynamic_cache_load_css ( $cache_key );
					return;
				}
			}
			echo '<style type="text/css">';
			echo $css_code;
			echo '</style>';
		}
	
	}
	
	
	function generate_custom_css_precompiled() {
		if (essb_is_plugin_deactivated_on()) {
			return;
		}
		
		$cache_key = 'essb-precompiled'.(essb_is_mobile() ? '-mobile': '');
		
		$cached_data = ESSBPrecompiledResources::get_resource($cache_key, 'css');
			
		if ($cached_data != '') {
			echo "<link rel='stylesheet' id='essb-compiled-css'  href='".$cached_data."' type='text/css' media='all' />";
			return;
		}
		
		// generation of all styles
		//$this->add_css(ESSBResourceBuilderSnippets::css_build_customizer(), 'essb-customcss-header');
		//$this->add_css(ESSBResourceBuilderSnippets::css_build_footer_css(), 'essb-footer-css', 'footer');
		
		$static_content = array();
		
		$styles = array();
		/*if (count($this->css_head) > 0) {
			$css_code = implode(" ", $this->css_head);
			$css_code = trim(preg_replace('/\s+/', ' ', $css_code));
			$styles[] = $css_code;
		}*/
		$css_code = '';
		foreach ( $this->css_head as $single ) {
			$css_code .= $single;
		}
		
		$css_code = apply_filters ( 'essb_css_buffer_head', $css_code );
		$css_code = trim ( preg_replace ( '/\s+/', ' ', $css_code ) );
		$styles[] = $css_code;
		
		// parsing inlinde enqueue styles
		$current_site_url = get_site_url();
		foreach ($this->precompiled_css_queue as $key => $file) {
			$relative_path = ESSBPrecompiledResources::get_asset_relative_path($current_site_url, $file);
			$css_code = file_get_contents( ABSPATH . $relative_path );
			$css_code = trim(preg_replace('/\s+/', ' ', $css_code));
			
			if ($key == "essb-social-image-share") {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/lib/modules/social-image-share/assets/', $css_code);
			}
			if ($key == "easy-social-share-buttons-profiles" || $key == "easy-social-share-buttons-display-methods" || $key == 'easy-social-share-buttons') {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/assets/', $css_code);
			}
			if ($key == "essb-social-followers-counter") {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/', $css_code);
			}
			
			$styles[] = $css_code;
			
			$static_content[$key] = $file;
		}
		
		foreach ($this->css_static_footer as $key => $file) {
			$relative_path = ESSBPrecompiledResources::get_asset_relative_path($current_site_url, $file);
			$css_code = file_get_contents( ABSPATH . $relative_path );
			$css_code = trim(preg_replace('/\s+/', ' ', $css_code));
			
			if ($key == "essb-social-image-share") {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/lib/modules/social-image-share/assets/', $css_code);
			}
			if ($key == "easy-social-share-buttons-profiles" || $key == "easy-social-share-buttons-display-methods" || $key == 'easy-social-share-buttons') {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/assets/', $css_code);
			}
			if ($key == "essb-social-followers-counter") {
				$css_code = str_replace('../', ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/', $css_code);
			}
			
			$styles[] = $css_code;
				
			$static_content[$key] = $file;
		}

		/*if (count($this->css_footer) > 0) {
			$css_code = implode(" ", $this->css_footer);
			$css_code = trim(preg_replace('/\s+/', ' ', $css_code));
			$styles[] = $css_code;
		}*/
		$css_code = '';
		foreach ( $this->css_footer as $single ) {
			$css_code .= $single;
		}
		
		$css_code = apply_filters ( 'essb_css_buffer_footer', $css_code );
		$css_code = trim ( preg_replace ( '/\s+/', ' ', $css_code ) );
		$styles[] = $css_code;
		
		$toc = array();
		
		foreach ( $static_content as $handle => $item_content )
			$toc[] = sprintf( ' - %s', $handle.'-'.$item_content );
		
		$styles[] = sprintf( "\n\n\n/* TOC:\n%s\n*/", implode( "\n", $toc ) );
		
		ESSBPrecompiledResources::put_resource($cache_key, implode(' ', $styles), 'css');
		
		$cached_data = ESSBPrecompiledResources::get_resource($cache_key, 'css');
		
		if ($cached_data != '') {
			echo "<link rel='stylesheet' id='essb-compiled-css'  href='".$cached_data."' type='text/css' media='all' />";
			return;
		}
	}

	/*
	 *  Code generation functions: Javascript
	*/
	
	/**
	 * generate_custom_js
	 * 
	 * Generate custom javascript code in head of page that will not be cached
	 */
	
	function generte_custom_js_precompiled() {
		if (essb_is_plugin_deactivated_on()) {
			return;
		}
	
		// -- loading non cachble and noasync code first
		if (count($this->js_social_apis) > 0) {
			if (!essb_is_module_deactivated_on('native')) {
				essb_depend_load_function('essb_load_social_api_code', 'lib/core/resource-snippets/essb-rb-socialapi.php');
				foreach ($this->js_social_apis as $network => $loaded) {
					essb_load_social_api_code($network);
				}
			}
		}
		
		if (count($this->js_static_noasync_footer)) {
			foreach ($this->js_static_noasync_footer as $key => $file) {
				$this->manual_script_load($key, $file);
			}
		}
		
		// loading in precompiled cache mode
		$cache_key = "essb-precompiled".(essb_is_mobile() ? "-mobile": "");
		
		$cached_data = ESSBPrecompiledResources::get_resource($cache_key, 'js');
			
		if ($cached_data != '') {
			echo "<script type='text/javascript' src='".$cached_data."' async></script>";
			return;
		}
				
		$static_content = array();		
		$scripts = array();
		$current_site_url = get_site_url();
		
		$scripts[] = implode(" ", $this->js_code);
		
		if (count($this->js_static) > 0) {
			foreach ($this->js_static as $key => $file) {
				$relative_path = ESSBPrecompiledResources::get_asset_relative_path($current_site_url, $file);
				$code = file_get_contents( ABSPATH . $relative_path );
				
				$scripts[] = $code;
					
				$static_content[$key] = $file;
			}
		}
		
		if (count($this->js_static_footer)) {
			foreach ($this->js_static_footer as $key => $file) {
				$relative_path = ESSBPrecompiledResources::get_asset_relative_path($current_site_url, $file);
				$code = file_get_contents( ABSPATH . $relative_path );
			
				$scripts[] = $code;
					
				$static_content[$key] = $file;
			}
		}
		
		$js_code = '';
		$js_code = apply_filters('essb_js_buffer_footer', $js_code);
		$scripts[] = $js_code;
		
		$toc = array();
		
		foreach ( $static_content as $handle => $item_content )
			$toc[] = sprintf( ' - %s', $handle.'-'.$item_content );
		
		$scripts[] = sprintf( "\n\n\n/* TOC:\n%s\n*/", implode( "\n", $toc ) );
		
		ESSBPrecompiledResources::put_resource($cache_key, implode(' ', $scripts), 'js');
		
		$cached_data = ESSBPrecompiledResources::get_resource($cache_key, 'js');
		
		if ($cached_data != '') {
			echo "<script type='text/javascript' src='".$cached_data."' async></script>";
		}
	}
	
	function generate_custom_js() {
		if (essb_is_plugin_deactivated_on()) {
			return;
		}		
		
		$js_code = '';
		
		if (count($this->js_code_head) > 0) {
			//$js_code = implode(" ", $this->js_code_head);
			$js_code = '';
			foreach ($this->js_code_head as $code) {
				$js_code .= $code;
			}
			
			
		}
		$js_code = apply_filters('essb_js_buffer_head', $js_code);
			
		if ($js_code != '') {
			print "\n";
			printf('<script type="text/javascript">%1$s</script>', $js_code);
		}
	}
	
	function generate_custom_footer_js() {
		global $post;
		
		if (essb_is_plugin_deactivated_on()) {
			return;
		}
		
		$cache_slug = "essb-js-footer";
		if (count($this->js_social_apis) > 0) {
			if (!essb_is_module_deactivated_on('native')) {
				essb_depend_load_function('essb_load_social_api_code', 'lib/core/resource-snippets/essb-rb-socialapi.php');				
				foreach ($this->js_social_apis as $network => $loaded) {
					essb_load_social_api_code($network);
				}
			}
		}
		// load of static scripts async or deferred
		if (count($this->js_static) > 0) {
			if ($this->js_defer || $this->js_async) {
				essb_load_static_script($this->js_static, $this->js_async);
			}
		}
		
		if (count($this->js_static_footer)) {
			if ($this->js_defer || $this->js_async) {
				essb_load_static_script($this->js_static_footer, $this->js_async);
			}
			else {
				foreach ($this->js_static_footer as $key => $file) {
					$this->manual_script_load($key, $file);
				}
			}
		}
		
		if (count($this->js_static_noasync_footer)) {
			foreach ($this->js_static_noasync_footer as $key => $file) {
				$this->manual_script_load($key, $file);
			}
		}
		
		if (count($this->js_code_noncachable)) {
			echo implode(" ", $this->js_code_noncachable);
		}
		
		// dynamic footer javascript that can be cached
		$cache_slug = "essb-js-footer";
		
		if (isset($post)) {
			if (defined('ESSB3_CACHE_ACTIVE_RESOURCE')) {
				$cache_key = $cache_slug.$post->ID;
		
				if (essb_dynamic_cache_load_js($cache_key)) { return; }
			}
		}
			
			
		//$js_code = implode(" ", $this->js_code);
		$js_code = '';
		foreach ($this->js_code as $single) {
			$js_code .= $single;
		}
		$js_code = apply_filters('essb_js_buffer_footer', $js_code);
		if (isset($post)) {
			if (defined('ESSB3_CACHE_ACTIVE_RESOURCE')) {
				$cache_key = $cache_slug.$post->ID;
		
				ESSBDynamicCache::put_resource($cache_key, $js_code, 'js');
		
				essb_dynamic_cache_load_js($cache_key);
				return;
			}
		}
		echo '<script type="text/javascript">';
		echo $js_code;
		echo '</script>';	
			
	}
	
	public function manual_script_load($key, $file) {
		$ver_string = "";
		
		if (!empty($this->resource_version)) {
			$ver_string = "?ver=".$this->resource_version;
		}
		
		essb_manual_script_load($key, $file, $ver_string);
	}
}

/** static called functions for resource generation **/

function essb_manual_script_load($key, $file, $ver_string = '') {
	echo '<script type="text/javascript" src="'.$file.$ver_string.'"></script>';
}

function essb_dynamic_cache_load_css($cache_key = '') {
	$cached_data = ESSBDynamicCache::get_resource($cache_key, 'css');
	
	if ($cached_data != '') {
		echo "<link rel='stylesheet' id='".$cache_key."'  href='".$cached_data."' type='text/css' media='all' />";
		return true;
	}
	else {
		return false;
	}
	
}

function essb_dynamic_cache_load_js($cache_key) {
	$cached_data = ESSBDynamicCache::get_resource($cache_key, 'js');
	
	if ($cached_data != '') {
		echo "<script type='text/javascript' src='".$cached_data."' defer></script>";
		return true;
	}
	else {
		return false;
	}
}

function essb_load_static_script($list, $async) {
	$result = '';
	$load_mode = ($async) ? "po.async=true;" : "po.defer=true;";
	
	foreach ($list as $key => $file) {
		$result .= ('
				(function() {
				var po = document.createElement(\'script\'); po.type = \'text/javascript\'; '.$load_mode.';
				po.src = \''.$file.'\';
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
		})();');
	}
	
	if ($result != '') {
		echo '<script type="text/javascript">'.$result.'</script>';
	}
}

?>