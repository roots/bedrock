<?php

class WPMDB_Compatibility {

	protected $muplugin_class_dir;
	protected $muplugin_dir;
	protected $default_whitelisted_plugins;

	public function __construct() {

		$this->muplugin_class_dir = plugin_dir_path( __FILE__ );
		$this->muplugin_dir       = ( defined( 'WPMU_PLUGIN_DIR' ) && defined( 'WPMU_PLUGIN_URL' ) ) ? WPMU_PLUGIN_DIR : trailingslashit( WP_CONTENT_DIR ) . 'mu-plugins';

		add_action( 'admin_init', array( $this, 'wpmdbc_tgmpa_compatibility' ), 1 );
		add_filter( 'option_active_plugins', array( $this, 'wpmdbc_include_plugins' ) );
		add_filter( 'site_option_active_sitewide_plugins', array( $this, 'wpmdbc_include_site_plugins' ) );
		add_filter( 'stylesheet_directory', array( $this, 'wpmdbc_disable_theme' ) );
		add_filter( 'template_directory', array( $this, 'wpmdbc_disable_theme' ) );
		add_action( 'muplugins_loaded', array( $this, 'wpmdbc_set_default_whitelist' ), 5 );
		add_action( 'muplugins_loaded', array( $this, 'wpmdbc_plugins_loaded' ), 10 );
		add_action( 'after_setup_theme', array( $this, 'wpmdbc_after_theme_setup' ) );

		if ( ! class_exists( 'WPMDB_Utils' ) ) {
			require_once( dirname( __FILE__ ) . '/wpmdb-utils.php' );
		}
	}

	/**
	 * During the `wpmdb_flush` and `wpmdb_remote_flush` actions, start output buffer in case theme spits out errors
	 */
	public function wpmdbc_plugins_loaded() {
		if ( $this->wpmdbc_is_wpmdb_flush_call() ) {
			ob_start();
		}
	}

	/**
	 * During the `wpmdb_flush` and `wpmdb_remote_flush` actions, if buffer isn't empty, log content and flush buffer.
	 */
	public function wpmdbc_after_theme_setup() {
		if ( $this->wpmdbc_is_wpmdb_flush_call() ) {
			if ( ob_get_length() ) {
				error_log( ob_get_clean() );
			}
		}
	}

	/**
	 *
	 * Disables the theme during MDB AJAX requests
	 *
	 * Called from the `stylesheet_directory` hook
	 *
	 * @param $stylesheet_dir
	 *
	 * @return string
	 */
	public function wpmdbc_disable_theme( $stylesheet_dir ) {
		$force_enable_theme = apply_filters( 'wpmdb_compatibility_enable_theme', false );

		if ( $this->wpmdbc_is_compatibility_mode_request() && ! $force_enable_theme ) {
			$theme_dir  = realpath( dirname( __FILE__ ) . '/../compatibility' );
			$stylesheet = 'temp-theme';
			$theme_root = "$theme_dir/$stylesheet";

			return $theme_root;
		}

		return $stylesheet_dir;
	}

	public function wpmdbc_set_default_whitelist() {

		// Allow users to filter whitelisted plugins
		$filtered_plugins = apply_filters( 'wpmdb_compatibility_plugin_whitelist', array() );

		// List of default plugins that should be whitelisted. Can be partial names or slugs
		$wpmdb_plugins = array(
			'wpmdb', // Some tweaks plugins start with this string
			'wp-migrate-db',
		);

		$plugins                           = array_merge( $filtered_plugins, $wpmdb_plugins );
		$this->default_whitelisted_plugins = $plugins;
	}

	/**
	 * Remove TGM Plugin Activation 'force_activation' admin_init action hook if present.
	 *
	 * This is to stop excluded plugins being deactivated after a migration, when a theme uses TGMPA to require a
	 * plugin to be always active. Also applies to the WDS-Required-Plugins by removing `activate_if_not` action
	 */
	public function wpmdbc_tgmpa_compatibility() {
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
					if ( false !== strpos( $key, 'force_activation' ) || false !== strpos( $key, 'activate_if_not' ) ) {

						if ( is_array( $wp_filter['admin_init'] ) ) {
							// for core versions prior to WP 4.7
							unset( $wp_filter['admin_init'][ $priority ][ $key ] );
						} else {
							unset( $wp_filter['admin_init']->callbacks[ $priority ][ $key ] );
						}

						return;
					}
				}
			}
		}
	}

	/**
	 * remove blog-active plugins
	 *
	 * @param array $plugins numerically keyed array of plugin names
	 *
	 * @return array
	 */
	public function wpmdbc_include_plugins( $plugins ) {
		if ( ! is_array( $plugins ) || empty( $plugins ) ) {
			return $plugins;
		}

		if ( ! $this->wpmdbc_is_compatibility_mode_request() ) {
			return $plugins;
		}

		$whitelist_plugins = $this->wpmdbc_get_whitelist_plugins();
		$default_whitelist = $this->default_whitelisted_plugins;

		foreach ( $plugins as $key => $plugin ) {
			if ( true === $this->wpmdbc_plugin_in_default_whitelist( $plugin, $default_whitelist ) || isset( $whitelist_plugins[ $plugin ] ) ) {
				continue;
			}

			unset( $plugins[ $key ] );
		}

		return $plugins;
	}

	/**
	 * remove network-active plugins
	 *
	 * @param array $plugins array of plugins keyed by name (name=>timestamp pairs)
	 *
	 * @return array
	 */
	public function wpmdbc_include_site_plugins( $plugins ) {
		if ( ! is_array( $plugins ) || empty( $plugins ) ) {
			return $plugins;
		}

		if ( ! $this->wpmdbc_is_compatibility_mode_request() ) {
			return $plugins;
		}

		$whitelist_plugins = $this->wpmdbc_get_whitelist_plugins();

		if ( ! $this->default_whitelisted_plugins ) {
			$this->wpmdbc_set_default_whitelist();
		}

		$default_whitelist = $this->default_whitelisted_plugins;

		foreach ( array_keys( $plugins ) as $plugin ) {
			if ( true === $this->wpmdbc_plugin_in_default_whitelist( $plugin, $default_whitelist ) || isset( $whitelist_plugins[ $plugin ] ) ) {
				continue;
			}
			unset( $plugins[ $plugin ] );
		}

		return $plugins;
	}

	/**
	 * @return bool
	 */
	public function wpmdbc_is_wpmdb_ajax_call() {
		return WPMDB_Utils::is_wpmdb_ajax_call();
	}

	/**
	 * @return bool
	 */
	public function wpmdbc_is_wpmdb_flush_call() {
		if ( $this->wpmdbc_is_wpmdb_ajax_call() && in_array( $_POST['action'], array(
				'wpmdb_flush',
				'wpmdb_remote_flush',
			) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Should the current request be processed by Compatibility Mode?
	 *
	 * @return bool
	 */
	public function wpmdbc_is_compatibility_mode_request() {
		//Requests that shouldn't be handled by compatibility mode
		if ( ! $this->wpmdbc_is_wpmdb_ajax_call() || in_array( $_POST['action'], array(
				'wpmdb_get_log',
				'wpmdb_flush',
				'wpmdb_remote_flush',
				'wpmdb_get_themes',
				'wpmdb_get_plugins',
			) ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Returns an array of plugin slugs to be blacklisted.
	 *
	 * @return array
	 */
	public function wpmdbc_get_whitelist_plugins() {
		$whitelist_plugins = array();

		$wpmdb_settings = get_site_option( 'wpmdb_settings' );

		if ( ! empty( $wpmdb_settings['whitelist_plugins'] ) ) {
			$whitelist_plugins = array_flip( $wpmdb_settings['whitelist_plugins'] );
		}

		return $whitelist_plugins;
	}

	/**
	 *
	 * Checks if $plugin is in the $whitelisted_plugins property array
	 *
	 * @param $plugin
	 * @param $whitelisted_plugins
	 *
	 * @return bool
	 */
	public function wpmdbc_plugin_in_default_whitelist( $plugin, $whitelisted_plugins ) {

		if ( ! is_array( $whitelisted_plugins ) ) {
			return false;
		}

		if ( in_array( $plugin, $whitelisted_plugins ) ) {
			return true;
		}

		// strpos() check to see if the item slug is in the current $plugin name
		foreach ( $whitelisted_plugins as $item ) {
			if ( false !== strpos( $plugin, $item ) ) {
				return true;
			}
		}

		return false;
	}
}
