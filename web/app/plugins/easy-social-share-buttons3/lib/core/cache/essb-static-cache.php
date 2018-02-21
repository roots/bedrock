<?php

$essb_cache_static_instance = ESSBStaticCache::instance();

class ESSBStaticCache {

	static $instance;
	private $essb_cache_static_done = array();
	private $async_queue = array();


	private function __construct() {
		global $essb_options;
				
		$essb_cache_static = ESSBOptionValuesHelper::options_bool_value($essb_options, 'essb_cache_static');
		$essb_cache_static_js = ESSBOptionValuesHelper::options_bool_value($essb_options, 'essb_cache_static_js');
		
		if ($essb_cache_static_js) {
			add_filter( 'print_scripts_array', array( $this, 'init_essb_cache_static_js' ) );
		}

		if ($essb_cache_static) {
			add_filter( 'print_styles_array', array( $this, 'init_essb_cache_static_css' ) );
		}

	}


	public static function instance() {

		if ( ! self::$instance )
			self::$instance = new ESSBStaticCache();

		return self::$instance;

	}


	function init_essb_cache_static_js( $todo ) {

		global $wp_scripts;

		return $this->essb_cache_static_objects( $wp_scripts, $todo, 'js' );

	}


	function init_essb_cache_static_css( $todo ) {

		global $wp_styles;

		return $this->essb_cache_static_objects( $wp_styles, $todo, 'css' );

	}


	function essb_cache_static_objects( &$object, $todo, $extension ) {

		// Don't run if on admin or already processed
		if ( is_admin() || empty( $todo ) )
			return $todo;

		// Allow files to be excluded from ESSBCacheStaticResources
		$essb_cache_static_exclude = (array) apply_filters( 'essb_cache_static-exclude-' . $extension, array() );

		// Exluce all essb_cache_static items by default
		$essb_cache_static_exclude = array_merge( $essb_cache_static_exclude, $this->get_done() );

		$essb_cache_static_todo = array_diff( $todo, $essb_cache_static_exclude );

		if ( empty( $essb_cache_static_todo ) )
			return $todo;

		$done = array();
		$ver = array();

		// Bust cache on ESSBCacheStaticResources plugin update
		$ver[] = 'essb_cache_static-ver-1.0.0';

		// Debug enable
		// $ver[] = 'debug-' . time();

		// Use different cache key for SSL and non-SSL
		$ver[] = 'is_ssl-' . is_ssl();

		// Use a global cache version key to purge cache
		$ver[] = 'essb_cache_static_cache_ver-' . get_option( 'essb_cache_static_cache_ver' );

		// Use script version to generate a cache key
		foreach ( $essb_cache_static_todo as $t => $script )
			$ver[] = sprintf( '%s-%s', $script, $object->registered[ $script ]->ver );

		$cache_ver = md5( 'essb_cache_static-' . implode( '-', $ver ) . $extension );

		// Try to get queue from cache
		$cache = get_transient( 'essb_cache_static-' . $cache_ver );

		if ( isset( $cache['cache_ver'] ) && $cache['cache_ver'] == $cache_ver && file_exists( $cache['file'] ) )
			return $this->essb_cache_static_enqueue_files( $object, $cache );

		foreach ( $essb_cache_static_todo as $script ) {

			$pos_easy_social = strpos($script, 'easy-social-');
			$pos_essb = strpos($script, 'essb');
				
			if ($pos_easy_social === false && $pos_essb === false) {
				continue;
			}
				
			// Get the relative URL of the asset
			$src = self::get_asset_relative_path(
					$object->base_url,
					$object->registered[ $script ]->src
			);

			// Add support for pseudo packages such as jquery which return src as empty string
			if ( empty( $object->registered[ $script ]->src ) || '' == $object->registered[ $script ]->src )
				$done[ $script ] = null;

			// Skip if the file is not hosted locally
			if ( ! $src || ! file_exists( ABSPATH . $src ) )
				continue;

			$script_content = apply_filters(
					'essb_cache_static-item-' . $extension,
					file_get_contents( ABSPATH . $src ),
					$object,
					$script
			);

			if ( false !== $script_content ) {
				if ($extension == "css") {
					$script_content = trim(preg_replace('/\s+/', ' ', $script_content));
				}
				$done[ $script ] = $script_content;
			}

		}

		if ( empty( $done ) )
			return $todo;

		$wp_upload_dir = wp_upload_dir();

		// Try to create the folder for cache
		if ( ! is_dir( $wp_upload_dir['basedir'] . '/essb_cache_static' ) )
			if ( ! mkdir( $wp_upload_dir['basedir'] . '/essb_cache_static' ) )
			return $todo;

		$combined_file_path = sprintf( '%s/essb_cache_static/%s.%s', $wp_upload_dir['basedir'], $cache_ver, $extension );
		$combined_file_url = sprintf( '%s/essb_cache_static/%s.%s', $wp_upload_dir['baseurl'], $cache_ver, $extension );

		// Allow other plugins to do something with the resulting URL
		$combined_file_url = apply_filters( 'essb_cache_static-url-' . $extension, $combined_file_url, $done );

		// Allow other plugins to minify and obfuscate
		$done_imploded = apply_filters( 'essb_cache_static-content-' . $extension, implode( "\n\n", $done ), $done );

		// Store the combined file on the filesystem
		if ( ! file_exists( $combined_file_path ) )
			if ( ! file_put_contents( $combined_file_path, $done_imploded ) )
			return $todo;

		$status = array(
				'cache_ver' => $cache_ver,
				'todo' => $todo,
				'done' => array_keys( $done ),
				'url' => $combined_file_url,
				'file' => $combined_file_path,
				'extension' => $extension
		);

		// Cache this set of scripts for 24 hours
		set_transient( 'essb_cache_static-' . $cache_ver, $status, YEAR_IN_SECONDS );

		$this->set_done( $cache_ver );

		return $this->essb_cache_static_enqueue_files( $object, $status );

	}


	function essb_cache_static_enqueue_files( &$object, $status ) {

		extract( $status );

		switch ( $extension ) {

			case 'css':

				wp_enqueue_style(
				'essb_cache_static-' . $cache_ver,
				$url,
				null,
				null
				);

				// Add inline styles for all essb_cache_staticed styles
				foreach ( $done as $script ) {

					$inline_style = $object->get_data( $script, 'after' );

					if ( ! empty( $inline_style ) )
						$object->add_inline_style( 'essb_cache_static-' . $cache_ver, $inline_style );

				}

				break;

			case 'js':

				wp_enqueue_script(
				'essb_cache_static-' . $cache_ver,
				$url,
				null,
				null,
				apply_filters( 'essb_cache_static-js-in-footer', true )
				);

				// Add to the correct
				$object->set_group(
						'essb_cache_static-' . $cache_ver,
						false,
						apply_filters( 'essb_cache_static-js-in-footer', true )
				);

				$inline_data = array();

				// Add inline scripts for all essb_cache_staticed scripts
				foreach ( $done as $script )
					$inline_data[] = $object->get_data( $script, 'data' );

				// Filter out empty elements
				$inline_data = array_filter( $inline_data );

				if ( ! empty( $inline_data ) )
					$object->add_data( 'essb_cache_static-' . $cache_ver, 'data', implode( "\n", $inline_data ) );

				break;

			default:

				return $todo;

		}

		// Remove scripts that were merged
		$todo = array_diff( $todo, $done );

		$todo[] = 'essb_cache_static-' . $cache_ver;

		// Mark these items as done
		$object->done = array_merge( $object->done, $done );

		// Remove ESSBCacheStaticResources items from the queue
		$object->queue = array_diff( $object->queue, $done );

		return $todo;

	}


	function set_done( $handle ) {

		$this->essb_cache_static_done[] = 'essb_cache_static-' . $handle;

	}


	function get_done() {

		return $this->essb_cache_static_done;

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


	public function async_init() {

		global $wp_scripts;

		if ( ! is_object( $wp_scripts ) || empty( $wp_scripts->queue ) )
			return;

		$base_url = site_url();
		$essb_cache_static_exclude = (array) apply_filters( 'essb_cache_static-exclude-js', array() );

		foreach ( $wp_scripts->queue as $handle ) {

			// Skip asyncing explicitly excluded script handles
			if ( in_array( $handle, $essb_cache_static_exclude ) ) {
				continue;
			}

			$script_relative_path = ESSBStaticCache::get_asset_relative_path(
					$base_url,
					$wp_scripts->registered[$handle]->src
			);

			if ( ! $script_relative_path ) {
				// Add this script to our async queue
				$this->async_queue[] = $handle;

				// Remove this script from being printed the regular way
				wp_dequeue_script( $handle );
			}

		}

	}


	public function async_print() {

		global $wp_scripts;

		if ( empty( $this->async_queue ) )
			return;

		?>
		<!-- Asynchronous scripts by ESSBCacheStaticResources -->
		<script id="essb_cache_static-async-scripts" type="text/javascript">
		(function() {
			var js, fjs = document.getElementById('essb_cache_static-async-scripts'),
				add = function( url, id ) {
					js = document.createElement('script');
					js.type = 'text/javascript';
					js.src = url;
					js.async = true;
					js.id = id;
					fjs.parentNode.insertBefore(js, fjs);
				};
			<?php
			foreach ( $this->async_queue as $handle ) {
				printf(
					'add("%s", "%s"); ',
					$wp_scripts->registered[$handle]->src,
					'async-script-' . esc_attr( $handle )
				);
			}
			?>
		})();
		</script>
		<?php

	}


}


// Prepend the filename of the file being included
add_filter( 'essb_cache_static-item-css', 'essb_cache_static_comment_combined', 15, 3 );
add_filter( 'essb_cache_static-item-js', 'essb_cache_static_comment_combined', 15, 3 );

function essb_cache_static_comment_combined( $content, $object, $script ) {

	if ( ! $content )
		return $content;

	return sprintf(
			"\n\n/* ESSBCacheStaticResources: %s */\n",
			$object->registered[ $script ]->src
		) . $content;

}


// Add table of contents at the top of the ESSBCacheStaticResources file
add_filter( 'essb_cache_static-content-css', 'essb_cache_static_add_toc', 100, 2 );
add_filter( 'essb_cache_static-content-js', 'essb_cache_static_add_toc', 100, 2 );

function essb_cache_static_add_toc( $content, $items ) {

	if ( ! $content || empty( $items ) )
		return $content;

	$toc = array();

	foreach ( $items as $handle => $item_content )
		$toc[] = sprintf( ' - %s', $handle );

	return sprintf( "/* TOC:\n%s\n*/", implode( "\n", $toc ) ) . $content;

}


// Turn all local asset URLs into absolute URLs
add_filter( 'essb_cache_static-item-css', 'essb_cache_static_resolve_css_urls', 10, 3 );

function essb_cache_static_resolve_css_urls( $content, $object, $script ) {

	if ( ! $content )
		return $content;

	$src = ESSBStaticCache::get_asset_relative_path(
			$object->base_url,
			$object->registered[ $script ]->src
		);

	// Make all local asset URLs absolute
	$content = preg_replace(
			'/url\(["\' ]?+(?!data:|https?:|\/\/)(.*?)["\' ]?\)/i',
			sprintf( "url('%s/$1')", $object->base_url . dirname( $src ) ),
			$content
		);

	return $content;

}


// Add support for relative CSS imports
add_filter( 'essb_cache_static-item-css', 'essb_cache_static_resolve_css_imports', 10, 3 );

function essb_cache_static_resolve_css_imports( $content, $object, $script ) {

	if ( ! $content )
		return $content;

	$src = ESSBStaticCache::get_asset_relative_path(
			$object->base_url,
			$object->registered[ $script ]->src
		);

	// Make all import asset URLs absolute
	$content = preg_replace(
			'/@import\s+(url\()?["\'](?!https?:|\/\/)(.*?)["\'](\)?)/i',
			sprintf( "@import url('%s/$2')", $object->base_url . dirname( $src ) ),
			$content
		);

	return $content;

}


// Exclude styles with media queries from being included in ESSBCacheStaticResources
add_filter( 'essb_cache_static-item-css', 'essb_cache_static_exclude_css_with_media_query', 10, 3 );

function essb_cache_static_exclude_css_with_media_query( $content, $object, $script ) {

	if ( ! $content )
		return $content;

	$whitelist = array( '', 'all', 'screen' );

	// Exclude from ESSBCacheStaticResources if media query specified
	if ( ! in_array( $object->registered[ $script ]->args, $whitelist ) )
		return false;

	return $content;

}


// Make sure that all ESSBCacheStaticResources files are served from the correct protocol
add_filter( 'essb_cache_static-url-css', 'essb_cache_static_maybe_ssl_url' );
add_filter( 'essb_cache_static-url-js', 'essb_cache_static_maybe_ssl_url' );

function essb_cache_static_maybe_ssl_url( $url ) {

	if ( is_ssl() )
		return str_replace( 'http://', 'https://', $url );

	return $url;

}


// Add a Purge Cache link to the plugin list
//add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'essb_cache_static_cache_purge_admin_link' );

//function essb_cache_static_cache_purge_admin_link( $links ) {

//	$links[] = sprintf(
//			'<a href="%s">%s</a>',
//			wp_nonce_url( add_query_arg( 'purge_essb_cache_static', true ), 'purge_essb_cache_static' ),
//			__( 'Purge cache', 'essb_cache_static' )
//		);

//	return $links;

//}


/**
 * Maybe purge essb_cache_static cache
 */
//add_action( 'admin_init', 'purge_essb_cache_static_cache' );

function purge_essb_cache_static_cache() {

	//if ( ! isset( $_GET['purge_essb_cache_static'] ) )
	//	return;

	//if ( ! check_admin_referer( 'purge_essb_cache_static' ) )
	//	return;

	// Use this as a global cache version number
	update_option( 'essb_cache_static_cache_ver', time() );
	
	purge_essb_cache_static_transients();

	add_action( 'admin_notices', 'essb_cache_static_cache_purged_success' );

	// Allow other plugins to know that we purged
	do_action( 'essb_cache_static-cache-purge-delete' );

}

// @since 2.0.3 Clearing transients
function purge_essb_cache_static_transients() {
	global $wpdb;
	
	$time_now = time();
	$expired  = $wpdb->get_col( "SELECT option_name FROM $wpdb->options where (option_name LIKE '_transient_timeout_essb_cache_static-%') OR (option_name LIKE '_transient_essb_cache_static-%')" );
	//print_r($expired);
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


function essb_cache_static_cache_purged_success() {

	printf(
		'<div class="updated"><p>%s</p></div>',
		__( 'Success: ESSBCacheStaticResources cache purged.', 'essb_cache_static' )
	);

}


// This can used from cron to delete all ESSBCacheStaticResources cache files
add_action( 'essb_cache_static-cache-purge-delete', 'essb_cache_static_cache_delete_files' );

function essb_cache_static_cache_delete_files() {

	$wp_upload_dir = wp_upload_dir();
	$essb_cache_static_files = glob( $wp_upload_dir['basedir'] . '/essb_cache_static/*' );

	if ( $essb_cache_static_files ) {
		foreach ( $essb_cache_static_files as $essb_cache_static_file ) {
			unlink( $essb_cache_static_file );
		}
	}

}

