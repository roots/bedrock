<?php
/*
Plugin Name: WP Migrate DB Pro Compatibility
Plugin URI: http://deliciousbrains.com/wp-migrate-db-pro/
Description: Prevents 3rd party plugins from being loaded during WP Migrate DB Pro specific operations
Author: Delicious Brains
Version: 1.1
Author URI: http://deliciousbrains.com
*/

$GLOBALS['wpmdb_compatibility'] = true;

/**
 * Remove TGM Plugin Activation 'force_activation' admin_init action hook if present.
 *
 * This is to stop excluded plugins being deactivated after a migration, when a theme uses TGMPA to require a plugin to be always active.
 */
function wpmdbc_tgmpa_compatibility() {
	$remove_function = false;

	// run on wpmdb page
	if ( isset( $_GET['page'] ) && 'wp-migrate-db-pro' == $_GET['page'] ) {
		$remove_function = true;
	}
	// run on wpmdb ajax requests
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && false !== strpos( $_POST['action'], 'wpmdb' ) ) {
		$remove_function = true;
	}

	if ( $remove_function ) {
		global $wp_filter;
		$admin_init_functions = $wp_filter['admin_init'];
		foreach ( $admin_init_functions as $priority => $functions ) {
			foreach ( $functions as $key => $function ) {
				// searching for function this way as can't rely on the calling class being named TGM_Plugin_Activation
				if ( false !== strpos( $key, 'force_activation' ) ) {
					unset( $wp_filter['admin_init'][ $priority ][ $key ] );

					return;
				}
			}
		}
	}
}

add_action( 'admin_init', 'wpmdbc_tgmpa_compatibility', 1 );

/**
 * remove blog-active plugins
 *
 * @param array $plugins numerically keyed array of plugin names
 *
 * @return array
 */
function wpmdbc_exclude_plugins( $plugins ) {
	if ( ! is_array( $plugins ) || empty( $plugins ) ) {
		return $plugins;
	}

	if ( ! wpmdbc_is_compatibility_mode_request() ) {
		return $plugins;
	}

	$blacklist_plugins = wpmdbc_get_blacklist_plugins();

	if ( ! empty( $blacklist_plugins ) ) {
		foreach ( $plugins as $key => $plugin ) {
			if ( false !== strpos( $plugin, 'wp-migrate-db-pro' ) || ! isset( $blacklist_plugins[ $plugin ] ) ) {
				continue;
			}
			unset( $plugins[ $key ] );
		}
	}

	return $plugins;
}

add_filter( 'option_active_plugins', 'wpmdbc_exclude_plugins' );

/**
 * remove network-active plugins
 *
 * @param array $plugins array of plugins keyed by name (name=>timestamp pairs)
 *
 * @return array
 */
function wpmdbc_exclude_site_plugins( $plugins ) {
	if ( ! is_array( $plugins ) || empty( $plugins ) ) {
		return $plugins;
	}

	if ( ! wpmdbc_is_compatibility_mode_request() ) {
		return $plugins;
	}

	$blacklist_plugins = wpmdbc_get_blacklist_plugins();

	if ( ! empty( $blacklist_plugins ) ) {
		foreach ( array_keys( $plugins ) as $plugin ) {
			if ( false !== strpos( $plugin, 'wp-migrate-db-pro' ) || ! isset( $blacklist_plugins[ $plugin ] ) ) {
				continue;
			}
			unset( $plugins[ $plugin ] );
		}
	}

	return $plugins;
}

add_filter( 'site_option_active_sitewide_plugins', 'wpmdbc_exclude_site_plugins' );

/**
 * Should the current request be processed by Compatibility Mode?
 *
 * @return bool
 */
function wpmdbc_is_compatibility_mode_request() {
	if ( ! defined( 'DOING_AJAX' ) ||
	     ! DOING_AJAX ||
	     ! isset( $_POST['action'] ) ||
	     false === strpos( $_POST['action'], 'wpmdb' ) ||
	     in_array( $_POST['action'], array( 'wpmdb_flush', 'wpmdb_remote_flush' ) )
	) {
		return false;
	}

	return true;
}

/**
 * Returns an array of plugin slugs to be blacklisted.
 *
 * @return array
 */
function wpmdbc_get_blacklist_plugins() {
	$blacklist_plugins = array();

	$wpmdb_settings = get_site_option( 'wpmdb_settings' );

	if ( ! empty( $wpmdb_settings['blacklist_plugins'] ) ) {
		$blacklist_plugins = array_flip( $wpmdb_settings['blacklist_plugins'] );
	}

	return $blacklist_plugins;
}
