<?php
/**
 * Class WPMDB_Compatibility_Plugin_Manager
 *
 * Class to handle the copying and removing of the Compatibility Mode MU plugin for WP Migrate DB Pro
 *
 */
class WPMDB_Compatibility_Plugin_Manager {

	protected $wpmdb;
	protected $mu_plugin_source;
	protected $mu_plugin_dest;
	protected $filesystem;
	protected $settings;
	protected $compatibility_plugin_version;
	protected $mu_plugin_dir;

	/**
	 * WPMDB_Compatibility_Plugin_Manager constructor.
	 *
	 * @param $wpmdb - WPMDB class passed as a constructor dependency
	 */
	public function __construct( $wpmdb ) {
		$this->wpmdb      = $wpmdb;
		$this->filesystem = $wpmdb->filesystem;
		$this->settings   = $wpmdb->get( 'settings' );

		//Version of the compatibility plugin, to force an update of the MU plugin, increment this value
		$this->compatibility_plugin_version = '1.1';

		$this->mu_plugin_dir    = $wpmdb->mu_plugin_dir;
		$this->mu_plugin_source = $wpmdb->mu_plugin_source;
		$this->mu_plugin_dest   = $wpmdb->mu_plugin_dest;

		//Checks the compatibility mode MU plugin version and updates if it's out of date
		add_action( 'wp_ajax_wpmdb_plugin_compatibility', array( $this, 'ajax_plugin_compatibility' ) );
		add_action( 'admin_init', array( $this, 'muplugin_version_check' ), 1 );
		add_action( 'wpmdb_notices', array( $this, 'template_muplugin_update_fail' ) );
		//Fired in the register_deactivation_hook() call in both the pro and non-pro plugins
		add_action( 'wp_migrate_db_remove_compatibility_plugin', array( $this, 'remove_muplugin_on_deactivation' ) );
	}

	/**
	 * Triggered with the `admin_init` hook on the WP Migrate DB Pro dashboard page
	 *
	 * The 'compatibility_plugin_version' option key signifies that the latest compatibility plugin has been installed. If it's not present, copy the plugin, enabling it by default.
	 *
	 * Otherwise check the 'compatibility_plugin_version' option to see if the MU plugin needs updating.
	 *
	 * @return bool|string
	 */
	public function muplugin_version_check() {
		if ( isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'wp-migrate-db-pro', 'wp-migrate-db' ) ) ) {
			if ( true === $this->is_muplugin_update_required() ) {
				return $this->copy_muplugin();
			}
		}

		return false;
	}

	/**
	 * Checks if the compatibility mu-plugin is installed
	 *
	 * @return bool $installed
	 */
	public function is_muplugin_installed() {
		$plugins           = wp_get_mu_plugins();
		$muplugin_filename = basename( $this->mu_plugin_dest );
		$installed         = false;

		foreach ( $plugins as $plugin ) {
			if ( false !== strpos( $plugin, $muplugin_filename ) ) {
				$installed = true;
			}
		}

		return $installed;
	}

	/**
	 *
	 * Utility function to check if the mu-plugin directory and compatibility plugin are both writable
	 *
	 *
	 * @return bool
	 */
	public function is_muplugin_writable() {
		//Assumes by default we can create the mu-plugins folder and compatibility plugin if they don't exist
		$mu_folder_writable = true;
		$mu_plugin_writable = true;

		//If the mu-plugins folder exists, make sure it's writable.
		if ( true === $this->filesystem->is_dir( $this->mu_plugin_dir ) ) {
			$mu_folder_writable = $this->filesystem->is_writable( $this->mu_plugin_dir );
		}

		//If the mu-plugins/wp-migrate-db-pro-compatibility.php file exists, make sure it's writable.
		if ( true === $this->filesystem->file_exists( $this->mu_plugin_dest ) ) {
			$mu_plugin_writable = $this->filesystem->is_writable( $this->mu_plugin_dest );
		}

		if ( false === $mu_folder_writable || false === $mu_plugin_writable ) {
			return false;
		}

		return true;
	}

	/**
	 * Checks if the compatibility mu-plugin requires an update based on the 'compatibility_plugin_version' setting in
	 * the database
	 *
	 * @param $wpmdb_settings
	 *
	 * @return bool
	 */
	public function is_muplugin_update_required( $wpmdb_settings = false ) {
		$update_required = false;

		if ( false === $wpmdb_settings ) {
			$wpmdb_settings = $this->settings;
		}

		if ( ! isset( $wpmdb_settings['compatibility_plugin_version'] ) ) {
			$update_required = true;
		} else if ( version_compare( $this->compatibility_plugin_version, $wpmdb_settings['compatibility_plugin_version'], '>' ) && $this->is_muplugin_installed() ) {
			$update_required = true;
		}

		return $update_required;
	}

	/**
	 * Preemptively shows a warning warning on WPMDB pages if the mu-plugins folder isn't writable
	 */
	function template_muplugin_update_fail() {
		if ( $this->is_muplugin_update_required() && false === $this->is_muplugin_writable() ) {
			$notice_links = $this->wpmdb->check_notice( 'muplugin_failed_update_' . $this->compatibility_plugin_version , 'SHOW_ONCE' );
			if ( is_array( $notice_links ) ) {
				$this->wpmdb->template( 'muplugin-failed-update-warning', 'common', $notice_links );
			}
		}
	}

	/**
	 * Handler for ajax request to turn on or off Compatibility Mode.
	 */
	public function ajax_plugin_compatibility() {
		$this->wpmdb->check_ajax_referer( 'plugin_compatibility' );
		$message = false;

		$key_rules      = array(
			'action'  => 'key',
			'install' => 'numeric',
		);
		$state_data     = $this->wpmdb->set_post_data( $key_rules );
		$do_install     = ( '1' === trim( $state_data['install'] ) ) ? true : false;
		$plugin_toggled = $this->toggle_muplugin( $do_install );

		//If there's an error message, display it
		if ( true !== $plugin_toggled ) {
			$message = $plugin_toggled;
		}

		$this->wpmdb->end_ajax( $message );
	}


	/**
	 *
	 * Toggles the compatibility plugin based on the $do_install param.
	 *
	 * @param $do_install
	 *
	 * @return bool|string|void
	 */
	public function toggle_muplugin( $do_install ) {
		if ( true === $do_install ) {
			return $this->copy_muplugin();
		} else {
			return $this->remove_muplugin();
		}
	}

	/**
	 *
	 * Copies the compatibility plugin as well as updates the version number in the database
	 *
	 * @return bool|string
	 */
	public function copy_muplugin() {
		$wpmdb_settings = $this->settings;

		// Make the mu-plugins folder if it doesn't already exist, if the folder does exist it's left as-is.
		if ( ! $this->filesystem->mkdir( $this->mu_plugin_dir ) ) {
			return sprintf( esc_html__( 'The following directory could not be created: %s', 'wp-migrate-db' ), $this->mu_plugin_dir );
		}

		if ( ! $this->filesystem->copy( $this->mu_plugin_source, $this->mu_plugin_dest ) ) {
			return sprintf( __( 'The compatibility plugin could not be activated because your mu-plugin directory is currently not writable.  Please update the permissions of the mu-plugins folder:  %s', 'wp-migrate-db' ), $this->mu_plugin_dir );
		}

		//Rename muplugin in header
		if ( ! $this->wpmdb->get( 'is_pro' ) ) {
			$mu_contents = file_get_contents( $this->mu_plugin_dest );
			$mu_contents = str_replace( 'Plugin Name: WP Migrate DB Pro Compatibility', 'Plugin Name: WP Migrate DB Compatibility', $mu_contents );
			file_put_contents( $this->mu_plugin_dest, $mu_contents );
		}

		if ( $this->is_muplugin_update_required() ) {
			// Update version number in the database
			$wpmdb_settings['compatibility_plugin_version'] = $this->compatibility_plugin_version;

			// Remove blacklist_plugins key as it's no longer used.
			if ( isset( $wpmdb_settings['blacklist_plugins'] ) ) {
				unset( $wpmdb_settings['blacklist_plugins'] );
			}

			update_site_option( 'wpmdb_settings', $wpmdb_settings );
		}

		return true;
	}

	/**
	 *
	 * Removes the compatibility plugin
	 *
	 * @return bool|string
	 */
	public function remove_muplugin() {
		if ( $this->filesystem->file_exists( $this->mu_plugin_dest ) && ! $this->filesystem->unlink( $this->mu_plugin_dest ) ) {
			return sprintf( __( 'The compatibility plugin could not be deactivated because your mu-plugin directory is currently not writable.  Please update the permissions of the mu-plugins folder: %s', 'wp-migrate-db' ), $this->mu_plugin_dir );
		}

		return true;
	}

	/**
	 *
	 * Fired on the `wp_migrate_db_remove_compatibility_plugin` action. Removes the compatibility plugin on deactivation
	 *
	 * @return bool|string
	 */
	public function remove_muplugin_on_deactivation() {
		$plugin_removed = $this->remove_muplugin();

		if ( true === $plugin_removed ) {
			$wpmdb_settings = $this->settings;
			unset( $wpmdb_settings['compatibility_plugin_version'] );

			update_site_option( 'wpmdb_settings', $wpmdb_settings );
			return true;
		}

		return $plugin_removed;
	}
}
