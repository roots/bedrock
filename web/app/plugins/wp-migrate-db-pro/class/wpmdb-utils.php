<?php

class WPMDB_Utils {

	/**
	 * Test to see if executing an AJAX call specific to the WP Migrate DB family of plugins.
	 *
	 * @return bool
	 */
	public static function is_ajax() {
		// must be doing AJAX the WordPress way
		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
			return false;
		}

		// must be one of our actions -- e.g. core plugin (wpmdb_*), media files (wpmdbmf_*)
		if ( ! isset( $_POST['action'] ) || 0 !== strpos( $_POST['action'], 'wpmdb' ) ) {
			return false;
		}

		// must be on blog #1 (first site) if multisite
		if ( is_multisite() && 1 != get_current_site()->id ) {
			return false;
		}

		return true;
	}

	/**
	 * Checks if another version of WPMDB(Pro) is active and deactivates it.
	 * To be hooked on `activated_plugin` so other plugin is deactivated when current plugin is activated.
	 *
	 * @param string $plugin
	 *
	 */
	public static function deactivate_other_instances( $plugin ) {
		if ( ! in_array( basename( $plugin ), array( 'wp-migrate-db-pro.php', 'wp-migrate-db.php' ) ) ) {
			return;
		}

		$plugin_to_deactivate  = 'wp-migrate-db.php';
		$deactivated_notice_id = '1';
		if ( basename( $plugin ) == $plugin_to_deactivate ) {
			$plugin_to_deactivate  = 'wp-migrate-db-pro.php';
			$deactivated_notice_id = '2';
		}

		if ( is_multisite() ) {
			$active_plugins = (array) get_site_option( 'active_sitewide_plugins', array() );
			$active_plugins = array_keys( $active_plugins );
		} else {
			$active_plugins = (array) get_option( 'active_plugins', array() );
		}

		foreach ( $active_plugins as $basename ) {
			if ( false !== strpos( $basename, $plugin_to_deactivate ) ) {
				set_transient( 'wp_migrate_db_deactivated_notice_id', $deactivated_notice_id, 1 * HOUR_IN_SECONDS );
				deactivate_plugins( $basename );

				return;
			}
		}
	}

	/**
	 * Return unserialized object or array
	 *
	 * @param string $serialized_string Serialized string.
	 * @param string $method            The name of the caller method.
	 *
	 * @return mixed, false on failure
	 */
	public static function unserialize( $serialized_string, $method = '' ) {
		if ( ! is_serialized( $serialized_string ) ) {
			return false;
		}

		$serialized_string   = trim( $serialized_string );
		$unserialized_string = @unserialize( $serialized_string );

		if ( false === $unserialized_string && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			$scope = $method ? sprintf( __( 'Scope: %s().', 'wp-migrate-db' ), $method ) : false;
			$error = sprintf( __( 'WPMDB Error: Data cannot be unserialized. %s', 'wp-migrate-db' ), $scope );
			error_log( $error );
		}

		return $unserialized_string;
	}

	/**
	 * Use wp_unslash if available, otherwise fall back to stripslashes_deep
	 *
	 * @param string|array $arg
	 *
	 * @return string|array
	 */
	public static function safe_wp_unslash( $arg ) {
		if ( function_exists( 'wp_unslash' ) ) {
			return wp_unslash( $arg );
		} else {
			return stripslashes_deep( $arg );
		}
	}

	/**
	 * Use gzdecode if available, otherwise fall back to gzinflate
	 *
	 * @param string $data
	 *
	 * @return string|bool
	 */
	public static function gzdecode( $data ) {
		if ( ! function_exists( 'gzdecode' ) ) {
			return @gzinflate( substr( $data, 10, -8 ) );
		}

		return @gzdecode( $data );
	}

	/**
	 * Require wpmdb-wpdb and create new instance
	 *
	 * @return WPMDB_WPDB
	 */
	public static function make_wpmdb_wpdb_instance() {
		if ( ! class_exists( 'WPMDB_WPDB' ) ) {
			require_once dirname( __FILE__ ) . '/wpmdb-wpdb.php';
		}

		return new WPMDB_WPDB();
	}

	/**
	 * Wrapper for replacing first instance of string
	 *
	 * @return string
	 */
	public static function str_replace_first( $search, $replace, $string ) {
		$pos = strpos( $string, $search );

		if ( false !== $pos ) {
			$string = substr_replace( $string, $replace, $pos, strlen( $search ) );
		}

		return $string;
	}

	/**
	 * Runs WPs create nonce with all filters removed
	 *
	 * @param string|int $action Scalar value to add context to the nonce.
	 *
	 * @return string The Token
	 */
	public static function create_nonce( $action = - 1 ) {
		global $wp_filter;
		$filter_backup = $wp_filter;
		static::filter_nonce_filters();
		$return    = wp_create_nonce( $action );
		$wp_filter = $filter_backup;

		return $return;
	}

	/**
	 * Runs WPs check ajax_referer [sic] with all filters removed
	 *
	 * @param int|string   $action    Action nonce.
	 * @param false|string $query_arg Optional. Key to check for the nonce in `$_REQUEST` (since 2.5). If false,
	 *                                `$_REQUEST` values will be evaluated for '_ajax_nonce', and '_wpnonce'
	 *                                (in that order). Default false.
	 * @param bool         $die       Optional. Whether to die early when the nonce cannot be verified.
	 *                                Default true.
	 *
	 * @return false|int False if the nonce is invalid, 1 if the nonce is valid and generated between
	 *                   0-12 hours ago, 2 if the nonce is valid and generated between 12-24 hours ago.
	 */
	public static function check_ajax_referer( $action = - 1, $query_arg = false, $die = true ) {
		global $wp_filter;
		$filter_backup = $wp_filter;
		static::filter_nonce_filters();
		$return    = check_ajax_referer( $action, $query_arg, $die );
		$wp_filter = $filter_backup;

		return $return;
	}

	/**
	 * Removes filters from $wp_filter that might interfere with wpmdb nonce generation/checking
	 */
	private static function filter_nonce_filters() {
		global $wp_filter;
		$filtered_filters = apply_filters( 'wpmdb_filtered_filters', array(
			'nonce_life',
		) );
		foreach ( $filtered_filters as $filter ) {
			unset( $wp_filter[ $filter ] );
		}
	}

	/**
	 *
	 * Checks if the current request is a WPMDB request
	 *
	 * @return bool
	 */
	public static function is_wpmdb_ajax_call() {
		if (
			( defined( 'DOING_AJAX' ) && DOING_AJAX )
			&& ( isset( $_POST['action'] )
			&& false !== strpos( $_POST['action'], 'wpmdb' ) )
		) {
			return true;
		}

		return false;
	}

	/**
	 *
	 * Sets 'Expect' header to an empty string which some server/host setups require
	 *
	 * Called from the `http_request_args` filter
	 *
	 * @param $r
	 * @param $url
	 *
	 * @return mixed
	 */
	public static function preempt_expect_header( $r, $url ) {
		if ( self::is_wpmdb_ajax_call() ) {
			$r['headers']['Expect'] = '';
		}

		return $r;
	}
}
