<?php

class WPMDB_Base {
	protected $settings;
	protected $plugin_file_path;
	protected $plugin_dir_path;
	protected $plugin_slug;
	protected $plugin_folder_name;
	protected $plugin_basename;
	protected $plugin_base;
	protected $plugin_version;
	protected $template_dir;
	protected $plugin_title;
	protected $dbrains_api_url;
	protected $transient_timeout;
	protected $transient_retry_timeout;
	protected $dbrains_api_status_url = 'http://s3.amazonaws.com/cdn.deliciousbrains.com/status.json';
	protected $multipart_boundary = 'bWH4JVmYCnf6GfXacrcc';
	protected $attempting_to_connect_to;
	protected $error;
	protected $invalid_content_verification_error;
	protected $addons;
	protected $doing_cli_migration = false;
	protected $is_pro = false;
	protected $is_addon = false;
	protected $core_slug;
	protected $error_log;
	protected $state_data;
	protected $form_data;
	protected $migration_state;
	protected $license_response_messages = array();
	protected $gettable_properties = array();
	protected $temp_prefix = '_mig_';
	public $mu_plugin_dir;
	public $mu_plugin_source;
	public $mu_plugin_dest;
	public $filesystem;

	const DBRAINS_API_BASE = 'https://api.deliciousbrains.com';

	function __construct( $plugin_file_path ) {
		$this->load_settings();

		$this->plugin_file_path   = $plugin_file_path;
		$this->plugin_dir_path    = plugin_dir_path( $plugin_file_path );
		$this->plugin_folder_name = basename( $this->plugin_dir_path );
		$this->plugin_basename    = plugin_basename( $plugin_file_path );
		$this->template_dir       = $this->plugin_dir_path . 'template' . DIRECTORY_SEPARATOR;
		$this->plugin_title       = ucwords( str_ireplace( '-', ' ', basename( $plugin_file_path ) ) );
		$this->plugin_title       = str_ireplace( array( 'db', 'wp', '.php' ), array( 'DB', 'WP', '' ), $this->plugin_title );
		$this->mu_plugin_dir      = ( defined( 'WPMU_PLUGIN_DIR' ) && defined( 'WPMU_PLUGIN_URL' ) ) ? WPMU_PLUGIN_DIR : trailingslashit( WP_CONTENT_DIR ) . 'mu-plugins';
		$this->mu_plugin_source   = trailingslashit( $this->plugin_dir_path ) . 'compatibility/wp-migrate-db-pro-compatibility.php';
		$this->mu_plugin_dest     = trailingslashit( $this->mu_plugin_dir ) . 'wp-migrate-db-pro-compatibility.php';

		// We need to set $this->plugin_slug here because it was set here
		// in Media Files prior to version 1.1.2. If we remove it the customer
		// cannot upgrade, view release notes, etc
		// used almost exclusively as a identifier for plugin version checking (both core and addons)
		$this->plugin_slug = basename( $plugin_file_path, '.php' );

		// used to add admin menus and to identify the core version in the $GLOBALS['wpmdb_meta'] variable for delicious brains api calls, version checking etc
		$this->core_slug = ( $this->is_pro || $this->is_addon ) ? 'wp-migrate-db-pro' : 'wp-migrate-db';

		if ( is_multisite() ) {
			$this->plugin_base = 'settings.php?page=' . $this->core_slug;
		} else {
			$this->plugin_base = 'tools.php?page=' . $this->core_slug;
		}

		if ( $this->is_addon || $this->is_pro ) {
			$this->pro_addon_construct();
		}

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'admin_init', array( $this, 'maybe_schema_update' ) );

		// in case admin_init isn't run (tests/cli), we'll just instantiate the fs class without wpfs and allow it to be overwritten when/if admin_init is run
		if ( class_exists( 'WPMDB_Filesystem' ) ) {
			$this->filesystem = new WPMDB_Filesystem( true );
			add_action( 'admin_init', array( $this, 'init_wpmdb_filesystem' ) );
		}

		// List of properties that can be accessed by the get() method
		//@TODO this needs to be refactored
		$this->gettable_properties = array(
			'settings',
			'plugin_base',
			'temp_prefix',
			'plugin_version',
			'error',
			'state_data',
			'is_pro',
			'default_profile',
			'doing_cli_migration',
		);

		//Setup strings for license responses
		$this->setup_license_responses();
	}

	public function setup_license_responses() {

		$disable_ssl_url         = network_admin_url( $this->plugin_base . '&nonce=' . WPMDB_Utils::create_nonce( 'wpmdb-disable-ssl' ) . '&wpmdb-disable-ssl=1' );
		$check_licence_again_url = network_admin_url( $this->plugin_base . '&nonce=' . WPMDB_Utils::create_nonce( 'wpmdb-check-licence' ) . '&wpmdb-check-licence=1' );

		// List of potential license responses. Keys must must exist in both arrays, otherwise the default error message will be shown.
		$this->license_response_messages = array(
			'connection_failed' => array(
				'ui'  => sprintf( __( '<strong>Could not connect to api.deliciousbrains.com</strong> &mdash; You will not receive update notifications or be able to activate your license until this is fixed. This issue is often caused by an improperly configured SSL server (https). We recommend <a href="%1$s" target="_blank">fixing the SSL configuration on your server</a>, but if you need a quick fix you can:%2$s', 'wp-migrate-db' ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/could-not-connect-deliciousbrains-com/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin', sprintf( '<p><a href="%1$s" class="temporarily-disable-ssl button">%2$s</a></p>', $disable_ssl_url, __( 'Temporarily disable SSL for connections to api.deliciousbrains.com', 'wp-migrate-db' ) ) ),
				'cli' => __( 'Could not connect to api.deliciousbrains.com - You will not receive update notifications or be able to activate your license until this is fixed. This issue is often caused by an improperly configured SSL server (https). We recommend fixing the SSL configuration on your server, but if you need a quick fix you can temporarily disable SSL for connections to api.deliciousbrains.com by adding `define( \'DBRAINS_API_BASE\', \'http://api.deliciousbrains.com\' );` to your wp-config.php file.', 'wp-migrate-db' ),
			),
			'http_block_external' => array(
				'ui'  => __( 'We\'ve detected that <code>WP_HTTP_BLOCK_EXTERNAL</code> is enabled and the host <strong>%1$s</strong> has not been added to <code>WP_ACCESSIBLE_HOSTS</code>. Please disable <code>WP_HTTP_BLOCK_EXTERNAL</code> or add <strong>%1$s</strong> to <code>WP_ACCESSIBLE_HOSTS</code> to continue. <a href="%2$s" target="_blank">More information</a>.', 'wp-migrate-db' ),
				'cli' => __( 'We\'ve detected that WP_HTTP_BLOCK_EXTERNAL is enabled and the host %1$s has not been added to WP_ACCESSIBLE_HOSTS. Please disable WP_HTTP_BLOCK_EXTERNAL or add %1$s to WP_ACCESSIBLE_HOSTS to continue.', 'wp-migrate-db' ),
			),
			'subscription_cancelled' => array(
				'ui'  => sprintf( __( '<strong>Your License Was Cancelled</strong> &mdash; Please visit <a href="%s" target="_blank">My Account</a> to renew or upgrade your license and enable push and pull. <br /><a href="%s" class="check-my-licence-again" >%s</a>', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/?utm_campaign=support%2Bdocs&utm_source=MDB%2BPaid&utm_medium=insideplugin', $check_licence_again_url, __( 'Check my license again', 'wp-migrate-db' ) ),
				'cli' => sprintf( __( 'Your License Was Cancelled - Please login to your account (%s) to renew or upgrade your license and enable push and pull.', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/?utm_campaign=support%2Bdocs&utm_source=MDB%2BPaid&utm_medium=insideplugin' ),
			),
			'subscription_expired_base' => array(
				'ui'  => sprintf( '<strong>%s</strong> &mdash; ', __( 'Your License Has Expired', 'wp-migrate-db' ) ),
				'cli' => sprintf( '%s - ', __( 'Your License Has Expired', 'wp-migrate-db' ) ),
			),
			'subscription_expired_end' => array(
				'ui'  => sprintf( __( 'Login to <a href="%s">My Account</a> to renew. <a href="%s" class="check-my-licence-again">%s</a>', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/?utm_campaign=support%2Bdocs&utm_source=MDB%2BPaid&utm_medium=insideplugin', $check_licence_again_url, __( 'Check my license again', 'wp-migrate-db' ) ),
				'cli' => sprintf( __( 'Login to your account to renew (%s)', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/' ),
			),
			'no_activations_left' => array(
				'ui'  => sprintf( __( '<strong>No Activations Left</strong> &mdash; Please visit <a href="%s" target="_blank">My Account</a> to upgrade your license or deactivate a previous activation and enable push and pull.  <a href="%s" class="check-my-licence-again">%s</a>', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/?utm_campaign=support%2Bdocs&utm_source=MDB%2BPaid&utm_medium=insideplugin', $check_licence_again_url, __( 'Check my license again', 'wp-migrate-db' ) ),
				'cli' => sprintf( __( 'No Activations Left - Please visit your account (%s) to upgrade your license or deactivate a previous activation and enable push and pull.', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/?utm_campaign=support%2Bdocs&utm_source=MDB%2BPaid&utm_medium=insideplugin' ),
			),
			'licence_not_found_api_failed' => array(
				'ui'  => sprintf( __( '<strong>Your License Was Not Found</strong> &mdash; Perhaps you made a typo when defining your WPMDB_LICENCE constant in your wp-config.php? Please visit <a href="%s" target="_blank">My Account</a> to double check your license key. <a href="%s" class="check-my-licence-again">%s</a>', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin', $check_licence_again_url, __( 'Check my license again', 'wp-migrate-db' ) ),
				'cli' => sprintf( __( 'Your License Was Not Found - Perhaps you made a typo when defining your WPMDB_LICENCE constant in your wp-config.php? Please visit your account (%s) to double check your license key.', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/' ),
			),
			'licence_not_found_api' => array(
				'ui'  => __( '<strong>Your License Was Not Found</strong> &mdash; %s', 'wp-migrate-db' ),
				'cli' => __( 'Your License Was Not Found - %s', 'wp-migrate-db' ),
			),
			'activation_deactivated' => array(
				'ui'  => sprintf( '<strong>%s</strong> &mdash; %s <a href="#" class="js-action-link reactivate-licence">%s</a>', __( 'Your License Is Inactive', 'wp-migrate-db' ), __( 'Your license has been deactivated for this install.', 'wp-migrate-db' ), __( 'Reactivate your license', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account' ),
				'cli' => sprintf( '%s - %s %s at %s', __( 'Your License Is Inactive', 'wp-migrate-db' ), __( 'Your license has been deactivated for this install.', 'wp-migrate-db' ), __( 'Reactivate your license', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account' ),
			),
			'default' => array(
				'ui'  => __( '<strong>An Unexpected Error Occurred</strong> &mdash; Please contact us at <a href="%1$s">%2$s</a> and quote the following: <p>%3$s</p>', 'wp-migrate-db' ),
				'cli' => __( 'An Unexpected Error Occurred - Please contact us at %2$s and quote the following: %3$s', 'wp-migrate-db' ),
			),
		);
	}

	/**
	 * Get the URL to wp-admin/admin-ajax.php for the intended WordPress site.
	 *
	 * The intended WordPress site URL is sent via Ajax, so to get a properly
	 * formatted URL to wp-admin/admin-ajax.php we can't count on the site
	 * URL being sent with a trailing slash.
	 *
	 * @return string URL to wp-admin/admin-ajax.php, e.g. http://example.com/wp-admin/admin-ajax.php
	 */
	function ajax_url() {
		static $ajax_url;

		if ( ! empty( $ajax_url ) ) {
			return $ajax_url;
		}

		$ajax_url = trailingslashit( $this->state_data['url'] ) . 'wp-admin/admin-ajax.php';

		return $ajax_url;
	}

	/**
	 * Sets $this->state_data from $_POST, potentially un-slashed and sanitized.
	 *
	 * @param array  $key_rules An optional associative array of expected keys and their sanitization rule(s).
	 * @param string $state_key The key in $_POST that contains the migration state id (defaults to 'migration_state_id').
	 * @param string $context   The method that is specifying the sanitization rules. Defaults to calling method.
	 *
	 * @return array
	 */
	function set_post_data( $key_rules = array(), $state_key = 'migration_state_id', $context = '' ) {
		if ( defined( 'DOING_WPMDB_TESTS' ) || $this->doing_cli_migration ) {
			$this->state_data = $_POST;
		} elseif ( is_null( $this->state_data ) ) {
			$this->state_data = WPMDB_Utils::safe_wp_unslash( $_POST );
		} else {
			return $this->state_data;
		}

		// From this point on we're handling data originating from $_POST, so original $key_rules apply.
		global $wpmdb_key_rules;

		if ( empty( $key_rules ) && ! empty( $wpmdb_key_rules ) ) {
			$key_rules = $wpmdb_key_rules;
		}

		// Sanitize the new state data.
		if ( ! empty( $key_rules ) ) {
			$wpmdb_key_rules = $key_rules;

			$context          = empty( $context ) ? $this->get_caller_function() : trim( $context );
			$this->state_data = WPMDB_Sanitize::sanitize_data( $this->state_data, $key_rules, $context );

			if ( false === $this->state_data ) {
				exit;
			}
		}

		$migration_state_id = null;
		if ( ! empty( $this->state_data[ $state_key ] ) ) {
			$migration_state_id = $this->state_data[ $state_key ];
		}

		// Always pass migration_state_id or $state_key with every AJAX request
		if ( true !== $this->get_migration_state( $migration_state_id ) ) {
			exit;
		}

		return $this->state_data;
	}

	/**
	 *  Utility method to access private and protected properties
	 *
	 * @param $property
	 *
	 * @return mixed
	 * @throws Exception
	 *
	 */
	public function get( $property ) {
		if ( ! in_array( $property, $this->gettable_properties ) ) {
			throw new Exception( $property . ' property not gettable' );
		}

		return $this->{$property};
	}

	function load_plugin_textdomain() {
		load_plugin_textdomain( 'wp-migrate-db', false, dirname( plugin_basename( $this->plugin_file_path ) ) . '/languages/' );
	}

	function init_wpmdb_filesystem() {
		if ( ! is_a( $this->filesystem, 'WPMDB_Filesystem' ) || ( is_a( $this->filesystem, 'WPMDB_Filesystem' ) && ! $this->filesystem->using_wp_filesystem() ) ) {
			$this->filesystem = new WPMDB_Filesystem();
		}
	}

	function pro_addon_construct() {
		$this->addons = array(
			'wp-migrate-db-pro-media-files/wp-migrate-db-pro-media-files.php'         => array(
				'name'             => 'Media Files',
				'required_version' => '1.4.10',
			),
			'wp-migrate-db-pro-cli/wp-migrate-db-pro-cli.php'                         => array(
				'name'             => 'CLI',
				'required_version' => '1.3.3',
			),
			'wp-migrate-db-pro-multisite-tools/wp-migrate-db-pro-multisite-tools.php' => array(
				'name'             => 'Multisite Tools',
				'required_version' => '1.2.1',
			),
			'wp-migrate-db-pro-theme-plugin-files/wp-migrate-db-pro-theme-plugin-files.php'   => array(
				'name'             => 'Theme & Plugin Files',
				'required_version' => '1.0.3',
			),
		);

		$this->invalid_content_verification_error = __( 'Invalid content verification signature, please verify the connection information on the remote site and try again.', 'wp-migrate-db' ) . sprintf( _x( ' Remote URL: %s ', 'Ex. Remote URL: http://wp.dev',  'wp-migrate-db' ), home_url() );

		$this->transient_timeout       = 60 * 60 * 12;
		$this->transient_retry_timeout = 60 * 60 * 2;

		$this->dbrains_api_url = $this->get_dbrains_api_base() . '/?wc-api=delicious-brains';

		// allow developers to change the temporary prefix applied to the tables
		$this->temp_prefix = apply_filters( 'wpmdb_temporary_prefix', $this->temp_prefix );

		// Adds a custom error message to the plugin install page if required (licence expired / invalid)
		add_filter( 'http_response', array( $this, 'verify_download' ), 10, 3 );

		add_action( 'wpmdb_notices', array( $this, 'version_update_notice' ) );
	}

	public function get_dbrains_api_base() {
		$dbrains_api_base = self::DBRAINS_API_BASE;

		if ( defined( 'DBRAINS_API_BASE' ) ) {
			$dbrains_api_base = DBRAINS_API_BASE;
		}

		if ( false === $this->open_ssl_enabled() ) {
			$dbrains_api_base = str_replace( 'https://', 'http://', $dbrains_api_base );
		}

		return $dbrains_api_base;
	}

	/**
	 * Loads the settings into the settings class property, sets some defaults if no existing settings are found.
	 */
	function load_settings() {
		if ( ! is_null( $this->settings ) ) {
			return;
		}

		$update_settings = false;
		$this->settings  = get_site_option( 'wpmdb_settings' );

		/*
		 * Settings were previously stored and retrieved using get_option and update_option respectively.
		 * Here we update the subsite option to a network wide option if applicable.
		 */
		if ( false === $this->settings && is_multisite() && is_network_admin() ) {
			$this->settings = get_option( 'wpmdb_settings' );
			if ( false !== $this->settings ) {
				$update_settings = true;
				delete_option( 'wpmdb_settings' );
			}
		}

		$default_settings = array(
			'key'                    => $this->generate_key(),
			'allow_pull'             => false,
			'allow_push'             => false,
			'profiles'               => array(),
			'licence'                => '',
			'verify_ssl'             => false,
			'whitelist_plugins'      => array(),
			'max_request'            => min( 1024 * 1024, $this->get_bottleneck( 'max' ) ),
			'delay_between_requests' => 0,
			'prog_tables_hidden'     => true,
			'pause_before_finalize'  => false,
			'allow_tracking'         => null,
		);

		// if we still don't have settings exist this must be a fresh install, set up some default settings
		if ( false === $this->settings ) {
			$this->settings  = $default_settings;
			$update_settings = true;
		} else {
			/*
			 * When new settings are added an existing customer's db won't have the new settings.
			 * They're added here to circumvent array index errors in debug mode.
			 */
			foreach ( $default_settings as $key => $value ) {
				if ( ! isset( $this->settings[ $key ] ) ) {
					$this->settings[ $key ] = $value;
					$update_settings        = true;
				}
			}
		}

		if ( $update_settings ) {
			update_site_option( 'wpmdb_settings', $this->settings );
		}
	}

	/**
	 * Loads the error log into the error log class property.
	 */
	function load_error_log() {
		if ( ! is_null( $this->error_log ) ) {
			return;
		}

		$this->error_log = get_site_option( 'wpmdb_error_log' );

		/*
		 * The error log was previously stored and retrieved using get_option and update_option respectively.
		 * Here we update the subsite option to a network wide option if applicable.
		 */
		if ( false === $this->error_log && is_multisite() && is_network_admin() ) {
			$this->error_log = get_option( 'wpmdb_error_log' );
			if ( false !== $this->error_log ) {
				update_site_option( 'wpmdb_error_log', $this->error_log );
				delete_option( 'wpmdb_error_log' );
			}
		}
	}

	function template( $template, $dir = '', $args = array() ) {
		global $wpdb;
		// @TODO: Refactor to remove extract().
		extract( $args, EXTR_OVERWRITE );
		$dir = ( ! empty( $dir ) ) ? trailingslashit( $dir ) : $dir;
		include $this->template_dir . $dir . $template . '.php';
	}

	function open_ssl_enabled() {
		if ( defined( 'OPENSSL_VERSION_TEXT' ) ) {
			return true;
		} else {
			return false;
		}
	}

	function set_time_limit() {
		if ( ! function_exists( 'ini_get' ) || ! ini_get( 'safe_mode' ) ) {
			@set_time_limit( 0 );
		}
	}

	/**
	 * Post data to a remote site with WP Migrate DB Pro and check the response.
	 *
	 * @param string $url The URL to post to.
	 * @param array $data The associative array of data to be posted to the remote.
	 * @param string $scope A string to be used in error messages defining the function that initiated the remote post.
	 * @param array $args An optional array of args to alter the timeout, blocking and sslverify options.
	 * @param bool $expecting_serial Verify that the response is a serialized string (defaults to false).
	 *
	 * @return bool|string
	 */
	function remote_post( $url, $data, $scope, $args = array(), $expecting_serial = false ) {
		$this->set_time_limit();
		$this->set_post_data();

		if ( function_exists( 'fsockopen' ) && 0 === strpos( $url, 'https://' ) && 'ajax_verify_connection_to_remote_site' == $scope ) {
			$url_parts = $this->parse_url( $url );
			$host      = $url_parts['host'];
			if ( $pf = @fsockopen( $host, 443, $err, $err_string, 1 ) ) {
				// worked
				fclose( $pf );
			} else {
				// failed
				$url = substr_replace( $url, 'http', 0, 5 );
			}
		}

		$sslverify = ( 1 == $this->settings['verify_ssl'] ? true : false );

		$default_remote_post_timeout = apply_filters( 'wpmdb_default_remote_post_timeout', 60 * 20 );

		$args = wp_parse_args( $args,
			array(
				'timeout'   => $default_remote_post_timeout,
				'blocking'  => true,
				'sslverify' => $sslverify,
			) );

		$args['method'] = 'POST';

		if ( ! isset( $args['body'] ) ) {
			$args['body'] = $this->array_to_multipart( $data );
		}

		$args['headers']['Content-Type'] = 'multipart/form-data; boundary=' . $this->multipart_boundary;
		$args['headers']['Referer']      = $this->referer_from_url( $url );

		$this->attempting_to_connect_to = $url;

		do_action( 'wpmdb_before_remote_post' );

		$response = wp_remote_post( $url, $args );

		if ( ! is_wp_error( $response ) ) {
			// Every response should be scrambled, but other processes may have been applied too so we use a filter.
			add_filter( 'wpmdb_after_response', array( $this, 'unscramble' ) );
			$response['body'] = apply_filters( 'wpmdb_after_response', trim( $response['body'], "\xef\xbb\xbf" ) );
			remove_filter( 'wpmdb_after_response', array( $this, 'unscramble' ) );
		}

		$response_status = $this->handle_remote_post_response( $response, $url, $scope, $expecting_serial, $this->state_data );

		if ( false === $response_status ) {
			return false;
		} else if ( true === $response_status ) {
			return $this->retry_remote_post( $url, $data, $scope, $expecting_serial );
		}

		return trim( $response['body'] );
	}

	function retry_remote_post( $url, $data, $scope, $args = array(), $expecting_serial = false ) {
		$url = substr_replace( $url, 'http', 0, 5 );
		if ( $response = $this->remote_post( $url, $data, $scope, $args, $expecting_serial ) ) {
			return $response;
		}

		return false;
	}

	/**
	 *
	 *
	 * Returns true, false or null
	 *
	 * False is an error, true triggers retry_remote_post() which tries the request on plain HTTP, and null is a successful response
	 *
	 * @param       $response
	 * @param       $url
	 * @param       $scope
	 * @param       $expecting_serial
	 * @param array $state_data
	 *
	 * @return bool|null
	 */
	public function handle_remote_post_response( $response, $url, $scope, $expecting_serial, $state_data = array() ) {
		if ( is_wp_error( $response ) ) {
			if ( 0 === strpos( $url, 'https://' ) && 'ajax_verify_connection_to_remote_site' == $scope ) {
				return true;
			} elseif ( isset( $response->errors['http_request_failed'][0] ) && strstr( $response->errors['http_request_failed'][0], 'timed out' ) ) {
				$this->error = sprintf( __( 'The connection to the remote server has timed out, no changes have been committed. (#134 - scope: %s)', 'wp-migrate-db' ), $scope );
			} elseif ( isset( $response->errors['http_request_failed'][0] ) && ( strstr( $response->errors['http_request_failed'][0], 'Could not resolve host' ) || strstr( $response->errors['http_request_failed'][0], "Couldn't resolve host" ) || strstr( $response->errors['http_request_failed'][0], "couldn't connect to host" ) ) ) {
				$this->error = sprintf( __( 'We could not find: %s. Are you sure this is the correct URL?', 'wp-migrate-db' ), $state_data['url'] );
				$url_bits    = $this->parse_url( $state_data['url'] );

				if ( strstr( $state_data['url'], 'dev.' ) || strstr( $state_data['url'], '.dev' ) || ! strstr( $url_bits['host'], '.' ) ) {
					$this->error .= '<br />';
					if ( 'pull' == $state_data['intent'] ) {
						$this->error .= __( 'It appears that you might be trying to pull from a local environment. This will not work if <u>this</u> website happens to be located on a remote server, it would be impossible for this server to contact your local environment.', 'wp-migrate-db' );
					} else {
						$this->error .= __( 'It appears that you might be trying to push to a local environment. This will not work if <u>this</u> website happens to be located on a remote server, it would be impossible for this server to contact your local environment.', 'wp-migrate-db' );
					}
				}
			} else {
				if ( defined( 'WP_HTTP_BLOCK_EXTERNAL' ) && WP_HTTP_BLOCK_EXTERNAL ) {
					$url_parts = $this->parse_url( $url );
					$host      = $url_parts['host'];
					if ( ! defined( 'WP_ACCESSIBLE_HOSTS' ) || ( defined( 'WP_ACCESSIBLE_HOSTS' ) && ! in_array( $host, explode( ',', WP_ACCESSIBLE_HOSTS ) ) ) ) {
						$this->error = sprintf( __( 'We\'ve detected that <code>WP_HTTP_BLOCK_EXTERNAL</code> is enabled and the host <strong>%1$s</strong> has not been added to <code>WP_ACCESSIBLE_HOSTS</code>. Please disable <code>WP_HTTP_BLOCK_EXTERNAL</code> or add <strong>%1$s</strong> to <code>WP_ACCESSIBLE_HOSTS</code> to continue. <a href="%2$s" target="_blank">More information</a>. (#147 - scope: %3$s)', 'wp-migrate-db' ), esc_attr( $host ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/wp_http_block_external/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin', $scope );
					}
				} elseif ( isset( $response->errors['http_request_failed'][0] ) && strstr( $response->errors['http_request_failed'][0], 'port 443: Connection refused' ) ) {
					$this->error = sprintf( __( 'Couldn\'t connect over HTTPS. You might want to try regular HTTP instead. (#121 - scope: %s)', 'wp-migrate-db' ), $scope );
				} elseif ( isset( $response->errors['http_request_failed'][0] ) && strstr( $response->errors['http_request_failed'][0], 'SSL' ) ) { // OpenSSL/cURL/MAMP Error
					$this->error = sprintf( __( '<strong>HTTPS Connection Error:</strong>  (#121 - scope: %s) This typically means that the version of OpenSSL that your local site is using to connect to the remote is incompatible or, more likely, being rejected by the remote server because it\'s insecure. <a href="%s" target="_blank">See our documentation</a> for possible solutions.', 'wp-migrate-db' ), $scope, 'https://deliciousbrains.com/wp-migrate-db-pro/doc/ssl-errors/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin' );
				} else {
					$this->error = sprintf( __( 'The connection failed, an unexpected error occurred, please contact support. (#121 - scope: %s)', 'wp-migrate-db' ), $scope );
				}
			}
			$this->log_error( $this->error, $response );

			return false;

		//Check response codes and respond accordingly
		} elseif ( 200 > (int) $response['response']['code'] || 399 < (int) $response['response']['code'] ) {

			$return = null;
			switch ( (int) $response['response']['code'] ) {
				case 401:
					$this->error = __( 'The remote site is protected with Basic Authentication. Please enter the username and password above to continue. (401 Unauthorized)', 'wp-migrate-db' );
					$this->log_error( $this->error, $response );

					$return = false;
					break;

				//Explicitly do no retry http URL if remote returns 500 error
				case 500:
					$this->error = $this->error = sprintf( __( 'Unable to connect to the remote server, the remote server responded with: %1$s %2$s (scope: %3$s)', 'wp-migrate-db' ), $response['response']['code'], $response['response']['message'], $scope );;
					$this->log_error( $this->error, $response );

					$return = false;
					break;

				case 0 === strpos( $url, 'https://' ) && 'ajax_verify_connection_to_remote_site' == $scope:
					$return = true;
					break;

				default:
					//other status codes less than 200 or over 400
					$this->error = sprintf( __( 'Unable to connect to the remote server, please check the connection details - %1$s %2$s (#129 - scope: %3$s)', 'wp-migrate-db' ), $response['response']['code'], $response['response']['message'], $scope );
					$this->log_error( $this->error, $response );

					$return = false;
					break;
			}

			if ( ! is_null( $return ) ) {
				return $return;
			}

		} elseif ( empty( $response['body'] ) ) {
			if ( '0' === $response['body'] && 'ajax_verify_connection_to_remote_site' == $scope ) {
				if ( 0 === strpos( $url, 'https://' ) ) {
					return true;
				} else {
					$this->error = sprintf( __( 'WP Migrate DB Pro does not seem to be installed or active on the remote site. (#131 - scope: %s)', 'wp-migrate-db' ), $scope );
				}
			} else {

				$url = 'https://deliciousbrains.com/wp-migrate-db-pro/doc/a-response-was-expected-from-the-remote/?utm_campaign=error+messages&utm_source=MDB+Paid&utm_medium=insideplugin';

				$this->error = sprintf( __( 'A response was expected from the remote, instead we got nothing. (#146 - scope: %1$s) Please review %2$s for possible solutions.', 'wp-migrate-db' ), $scope, sprintf( '<a href="%s" target="_blank">%s</a>', $url, __( 'our documentation', 'wp-migrate-db' ) ) );
			}
			$this->log_error( $this->error, $response );

			return false;

		} elseif ( $expecting_serial && false == is_serialized( $response['body'] ) ) {
			if ( 0 === strpos( $url, 'https://' ) && 'ajax_verify_connection_to_remote_site' == $scope ) {
				return true;
			}
			$this->error = __( 'There was a problem with the AJAX request, we were expecting a serialized response, instead we received:<br />', 'wp-migrate-db' ) . esc_html( $response['body'] );
			$this->log_error( $this->error, $response );

			return false;

		} elseif ( $expecting_serial && ( 'ajax_verify_connection_to_remote_site' == $scope || 'ajax_copy_licence_to_remote_site' == $scope ) ) {

			$unserialized_response = WPMDB_Utils::unserialize( $response['body'], __METHOD__ );

			if ( false !== $unserialized_response && isset( $unserialized_response['error'] ) && '1' == $unserialized_response['error'] && 0 === strpos( $url, 'https://' ) ) {

				if ( stristr( $unserialized_response['message'], 'Invalid content verification signature' ) ) {

					//Check if remote address returned is the same as what was requested. Apache sometimes returns a random HTTPS site.
					if ( false === strpos( $unserialized_response['message'], sprintf( 'Remote URL: %s', $state_data['url'] ) ) ) {
						return true;
					}
				}
			}
		}

		return null;
	}

	function array_to_multipart( $data ) {
		if ( ! $data || ! is_array( $data ) ) {
			return $data;
		}

		$result = '';

		foreach ( $data as $key => $value ) {
			$result .= '--' . $this->multipart_boundary . "\r\n" . sprintf( 'Content-Disposition: form-data; name="%s"', $key );

			if ( 'chunk' == $key ) {
				if ( $data['chunk_gzipped'] ) {
					$result .= "; filename=\"chunk.txt.gz\"\r\nContent-Type: application/x-gzip";
				} else {
					$result .= "; filename=\"chunk.txt\"\r\nContent-Type: text/plain;";
				}
			} else {
				$result .= "\r\nContent-Type: text/plain; charset=" . get_option( 'blog_charset' );
			}

			$result .= "\r\n\r\n" . $value . "\r\n";
		}

		$result .= '--' . $this->multipart_boundary . "--\r\n";

		return $result;
	}

	function file_to_multipart( $file ) {
		$result = '';

		if ( false == file_exists( $file ) ) {
			return false;
		}

		$filetype = wp_check_filetype( $file );
		$contents = file_get_contents( $file );

		$result .= '--' . $this->multipart_boundary . "\r\n" . sprintf( 'Content-Disposition: form-data; name="media[]"; filename="%s"', basename( $file ) );
		$result .= sprintf( "\r\nContent-Type: %s", $filetype['type'] );
		$result .= "\r\n\r\n" . $contents . "\r\n";
		$result .= '--' . $this->multipart_boundary . "--\r\n";

		return $result;
	}

	function log_error( $wpmdb_error, $additional_error_var = false ) {
		$error_header = "********************************************\n******  Log date: " . date( 'Y/m/d H:i:s' ) . " ******\n********************************************\n\n";
		$error        = $error_header;
		if ( isset( $this->state_data['intent'] ) ) {
			$error .= 'Intent: ' . $this->state_data['intent'] . "\n";
		}
		if ( isset( $this->state_data['action'] ) ) {
			$error .= 'Action: ' . $this->state_data['action'] . "\n";
		}
		if ( isset( $this->state_data['local'] ) && isset( $this->state_data['local']['site_url'] ) ) {
			$error .= 'Local: ' . $this->state_data['site_details']['local']['site_url'] . "\n";
		}
		if ( isset( $this->state_data['remote'] ) && isset( $this->state_data['remote']['site_url'] ) ) {
			$error .= 'Remote: ' . $this->state_data['site_details']['remote']['site_url'] . "\n\n";
		}
		$error .= 'WPMDB Error: ' . $wpmdb_error . "\n\n";

		if ( ! empty( $this->attempting_to_connect_to ) ) {
			$ip    = $this->get_remote_ip( $this->attempting_to_connect_to );
			$error .= 'Attempted to connect to: ' . $this->attempting_to_connect_to . ' (' . ( $ip ? $ip : 'ip lookup failed' ) . ')' . "\n\n";
		}

		if ( $additional_error_var !== false ) {

			// don't print the whole response object to the log
			if ( is_array( $additional_error_var ) && isset( $additional_error_var['http_response'] ) ) {
				if ( isset( $additional_error_var['http_response'] ) && ( $additional_error_var['http_response'] instanceof WP_HTTP_Requests_Response ) ) {
					$response                    = $additional_error_var['http_response']->get_response_object();
					$additional_error_var['url'] = $response->url;
				}
				unset( $additional_error_var['http_response'] );
			}

			$error .= print_r( $additional_error_var, true ) . "\n\n";
		}

		$this->load_error_log();

		// Error log length in bytes (default 1Mb)
		$max_log_length = apply_filters( 'wpmdb_max_error_log_length', 1000000 );
		$max_individual_log_length = apply_filters( 'wpmdb_max_individual_error_log_length', $max_log_length / 2.2 );

		// If error is longer than max individual log length, trim and add notice of doing so
		if ( strlen( $error ) > $max_individual_log_length ) {
			$length_trimmed = strlen( $error ) - $max_individual_log_length;
			$error = substr( $error, 0, $max_individual_log_length );
			$error .= "\n[$length_trimmed bytes were truncated from this error]\n\n";
		}

		// Trim existing log to accommodate new error if needed
		$existing_log_max_length = $max_log_length - strlen( $error );
		if ( strlen( $this->error_log ) > $existing_log_max_length ) {
			$this->error_log = substr( $this->error_log, -( $existing_log_max_length ) );

			// Crop at first log header
			$first_header_pos = strpos( $this->error_log, substr( $error_header, 0, strpos( $error_header, ' ' ) ) );
			if ( $first_header_pos ) {
				$this->error_log = substr( $this->error_log, $first_header_pos );
			}
		}

		if ( isset( $this->error_log ) ) {
			$this->error_log .= $error;
		} else {
			$this->error_log = $error;
		}

		update_site_option( 'wpmdb_error_log', $this->error_log );
	}

	function display_errors() {
		if ( ! empty( $this->error ) ) {
			echo $this->error;
			$this->error = '';

			return true;
		}

		return false;
	}

	function get_remote_ip( $url ) {
		$parsed_url = WPMDB_Utils::parse_url( $url );
		if ( ! isset( $parsed_url['host'] ) ) {
			return false;
		}
		// '.' appended to host name to avoid issues with nslookup caching - see documentation of gethostbyname for more info
		$host = $parsed_url['host'] . '.';

		$ip = gethostbyname( $host );

		return ( $ip === $host ) ? false : $ip;
	}

	function filter_post_elements( $post_array, $accepted_elements ) {
		$accepted_elements[] = 'sig';

		return array_intersect_key( $post_array, array_flip( $accepted_elements ) );
	}

	function sanitize_signature_data( $value ) {
		if ( is_bool( $value ) ) {
			$value = $value ? 'true' : 'false';
		}

		return $value;
	}

	/**
	 * Generate a signature string for the supplied data given a key.
	 *
	 * @param array  $data
	 * @param string $key
	 *
	 * @return string
	 */
	function create_signature( $data, $key ) {
		if ( isset( $data['sig'] ) ) {
			unset( $data['sig'] );
		}
		$data = array_map( array( $this, 'sanitize_signature_data' ), $data );
		ksort( $data );
		$flat_data = implode( '', $data );

		return base64_encode( hash_hmac( 'sha1', $flat_data, $key, true ) );
	}

	function verify_signature( $data, $key ) {
		if ( empty( $data['sig'] ) ) {
			return false;
		}

		if ( isset( $data['nonce'] ) ) {
			unset( $data['nonce'] );
		}

		$temp               = $data;
		$computed_signature = $this->create_signature( $temp, $key );

		return $computed_signature === $data['sig'];
	}

	function get_dbrains_api_url( $request, $args = array() ) {
		$url                       = $this->dbrains_api_url;
		$args['request']           = $request;
		$args['version']           = $GLOBALS['wpmdb_meta'][ $this->core_slug ]['version'];
		$args['php_version']       = urlencode( phpversion() );
		$args['locale']            = urlencode( get_locale() );
		$args['wordpress_version'] = urlencode( get_bloginfo( 'version' ) );

		if ( 'check_support_access' == $request || 'activate_licence' == $request ) {
			$args['last_used'] = urlencode( $this->get_last_usage_time() );
		}

		$url                 = add_query_arg( $args, $url );
		if ( false !== get_site_transient( 'wpmdb_temporarily_disable_ssl' ) && 0 === strpos( $this->dbrains_api_url, 'https://' ) ) {
			$url = substr_replace( $url, 'http', 0, 5 );
		}
		return $url;
	}

	/**
	 * Determines, sets up, and returns folder information for storing files.
	 *
	 * By default, the folder created will be `wp-migrate-db` and will be stored
	 * inside of the `uploads` folder in WordPress' current `WP_CONTENT_DIR`,
	 * usually `wp-content/uploads`
	 *
	 * To change the folder name of `wp-migrate-db` to something else, you can use
	 * the `wpmdb_upload_dir_name` filter to change it. e.g.:
	 *
	 *     function upload_dir_name() {
	 *        return 'database-dumps';
	 *     }
	 *
	 *     add_filter( 'wpmdb_upload_dir_name', 'upload_dir_name' );
	 *
	 * If `WP_CONTENT_DIR` was set to `wp-content` in this example,
	 * this would change the folder to `wp-content/uploads/database-dumps`.
	 *
	 * To change the entire path, for example to store these files outside of
	 * WordPress' `WP_CONTENT_DIR`, use the `wpmdb_upload_info` filter to do so. e.g.:
	 *
	 *     function upload_info() {
	 *         // The returned data needs to be in a very specific format, see below for example
	 *         return array(
	 *             'path' => '/path/to/custom/uploads/directory', // note missing end trailing slash
	 *             'url' => 'http://yourwebsite.com/custom/uploads/directory' // note missing end trailing slash
	 *         );
	 *     }
	 *
	 *    add_filter( 'wpmdb_upload_info', 'upload_info' );
	 *
	 * This would store files in `/path/to/custom/uploads/directory` with a
	 * URL to access files via `http://yourwebsite.com/custom/uploads/directory`
	 *
	 * @link https://github.com/deliciousbrains/wp-migrate-db-pro-tweaks
	 *
	 * @param string $type Either `path` or `url`.
	 *
	 * @return string The Path or the URL to the folder being used.
	 */
	function get_upload_info( $type = 'path' ) {
		$upload_info = apply_filters( 'wpmdb_upload_info', array() );

		// No need to create the directory structure since it should already exist.
		if ( ! empty( $upload_info ) ) {
			return $upload_info[ $type ];
		}

		$upload_dir = wp_upload_dir();

		$upload_info['path'] = $upload_dir['basedir'];
		$upload_info['url']  = $upload_dir['baseurl'];

		$upload_dir_name = apply_filters( 'wpmdb_upload_dir_name', 'wp-migrate-db' );

		if ( ! file_exists( $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $upload_dir_name ) ) {
			$url = wp_nonce_url( $this->plugin_base, 'wp-migrate-db-pro-nonce' );

			// Create the directory.
			// TODO: Do not silence errors, use wp_mkdir_p?
			if ( false === @mkdir( $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $upload_dir_name, 0755 ) ) {
				return $upload_info[ $type ];
			}

			// Protect from directory listings by making sure an index file exists.
			$filename = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $upload_dir_name . DIRECTORY_SEPARATOR . 'index.php';
			// TODO: Do not silence errors, use WP_Filesystem API?
			if ( false === @file_put_contents( $filename, "<?php\r\n// Silence is golden\r\n?>" ) ) {
				return $upload_info[ $type ];
			}
		}

		// Protect from directory listings by ensuring this folder does not allow Indexes if using Apache.
		$htaccess = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $upload_dir_name . DIRECTORY_SEPARATOR . '.htaccess';
		if ( ! file_exists( $htaccess ) ) {
			// TODO: Do not silence errors, use WP_Filesystem API?
			if ( false === @file_put_contents( $htaccess, "Options -Indexes\r\nDeny from all" ) ) {
				return $upload_info[ $type ];
			}
		}

		$upload_info['path'] .= DIRECTORY_SEPARATOR . $upload_dir_name;
		$upload_info['url'] .= '/' . $upload_dir_name;

		return $upload_info[ $type ];
	}

	/**
	 * Adds/updates the `wpmdb_usage` option with most recent 'qualified' plugin use,
	 * stores time as well as the action (push/pull/export/find-replace)
	 *
	 * @param string $action
	 */
	function log_usage( $action = '' ) {
		update_site_option( 'wpmdb_usage', array( 'action' => $action, 'time' => time() ) );
	}

	/**
	 * Gets just the timestamp of the latest usage to send with the API requests
	 *
	 * @return int
	 */
	function get_last_usage_time() {
		$option = get_site_option( 'wpmdb_usage' );
		return ( $option && $option['time'] ) ? $option['time'] : 0;
	}

	/**
	 * Main function for communicating with the Delicious Brains API.
	 *
	 * @param string $request
	 * @param array $args
	 *
	 * @return mixed
	 */
	function dbrains_api_request( $request, $args = array() ) {
		$trans = get_site_transient( 'wpmdb_dbrains_api_down' );

		if ( false !== $trans ) {
			$api_down_message = sprintf( '<div class="updated warning inline-message">%s</div>', $trans );

			return json_encode( array( 'dbrains_api_down' => $api_down_message ) );
		}

		$sslverify = ( $this->settings['verify_ssl'] == 1 ? true : false );

		$url      = $this->get_dbrains_api_url( $request, $args );
		$response = wp_remote_get(
			$url,
			array(
				'timeout'   => 30,
				'blocking'  => true,
				'sslverify' => $sslverify,
			)
		);

		if ( is_wp_error( $response ) || (int) $response['response']['code'] < 200 || (int) $response['response']['code'] > 399 ) {
			$this->log_error( print_r( $response, true ) );

			if ( true === $this->dbrains_api_down() ) {
				$trans = get_site_transient( 'wpmdb_dbrains_api_down' );

				if ( false !== $trans ) {
					$api_down_message = sprintf( '<div class="updated warning inline-message">%s</div>', $trans );

					return json_encode( array( 'dbrains_api_down' => $api_down_message ) );
				}
			}

			$disable_ssl_url           = network_admin_url( $this->plugin_base . '&nonce=' . WPMDB_Utils::create_nonce( 'wpmdb-disable-ssl' ) . '&wpmdb-disable-ssl=1' );
			$connection_failed_message = '<div class="updated warning inline-message">';
			$connection_failed_message .= sprintf( __( '<strong>Could not connect to api.deliciousbrains.com</strong> &mdash; You will not receive update notifications or be able to activate your license until this is fixed. This issue is often caused by an improperly configured SSL server (https). We recommend <a href="%1$s" target="_blank">fixing the SSL configuration on your server</a>, but if you need a quick fix you can:%2$s', 'wp-migrate-db' ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/could-not-connect-deliciousbrains-com/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin', sprintf( '<p><a href="%1$s" class="temporarily-disable-ssl button">%2$s</a></p>', $disable_ssl_url, __( 'Temporarily disable SSL for connections to api.deliciousbrains.com', 'wp-migrate-db' ) ) );
			$connection_failed_message .= '</div>';

			if ( defined( 'WP_HTTP_BLOCK_EXTERNAL' ) && WP_HTTP_BLOCK_EXTERNAL ) {
				$url_parts = $this->parse_url( $url );
				$host      = $url_parts['host'];
				if ( ! defined( 'WP_ACCESSIBLE_HOSTS' ) || strpos( WP_ACCESSIBLE_HOSTS, $host ) === false ) {
					$connection_failed_message = '<div class="updated warning inline-message">';
					$connection_failed_message .= sprintf( __( 'We\'ve detected that <code>WP_HTTP_BLOCK_EXTERNAL</code> is enabled and the host <strong>%1$s</strong> has not been added to <code>WP_ACCESSIBLE_HOSTS</code>. Please disable <code>WP_HTTP_BLOCK_EXTERNAL</code> or add <strong>%1$s</strong> to <code>WP_ACCESSIBLE_HOSTS</code> to continue. <a href="%2$s" target="_blank">More information</a>.', 'wp-migrate-db' ), esc_attr( $host ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/wp_http_block_external/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin' );
					$connection_failed_message .= '</div>';
				}
			}

			// Don't cache the license response so we can try again
			delete_site_transient( 'wpmdb_licence_response' );

			return json_encode( array( 'errors' => array( 'connection_failed' => $connection_failed_message ) ) );
		}

		return $response['body'];
	}

	/**
	 * Is the Delicious Brains API down?
	 *
	 * If not available then a 'wpmdb_dbrains_api_down' transient will be set with an appropriate message.
	 *
	 * @return bool
	 */
	function dbrains_api_down() {
		if ( false !== get_site_transient( 'wpmdb_dbrains_api_down' ) ) {
			return true;
		}

		$response = wp_remote_get( $this->dbrains_api_status_url, array( 'timeout' => 30 ) );

		// Can't get to api status url so fall back to normal failure handling.
		if ( is_wp_error( $response ) || 200 != (int) $response['response']['code'] || empty( $response['body'] ) ) {
			return false;
		}

		$json = json_decode( $response['body'], true );

		// Can't decode json so fall back to normal failure handling.
		if ( ! $json ) {
			return false;
		}

		// JSON doesn't seem to have the format we expect or is not down, so fall back to normal failure handling.
		if ( ! isset( $json['api']['status'] ) || 'down' != $json['api']['status'] ) {
			return false;
		}

		$message = __( "<strong>Delicious Brains API is Down — </strong>Unfortunately we're experiencing some problems with our server.", 'wp-migrate-db' );

		if ( ! empty( $json['api']['updated'] ) ) {
			$updated     = $json['api']['updated'];
			$updated_ago = sprintf( _x( '%s ago', 'ex. 2 hours ago', 'wp-migrate-db' ), human_time_diff( strtotime( $updated ) ) );
		}

		if ( ! empty( $json['api']['message'] ) ) {
			$message .= '<br />';
			$message .= __( "Here's the most recent update on its status", 'wp-migrate-db' );
			if ( ! empty( $updated_ago ) ) {
				$message .= ' (' . $updated_ago . ')';
			}
			$message .= ': <em>' . $json['api']['message'] . '</em>';
		}

		set_site_transient( 'wpmdb_dbrains_api_down', $message, $this->transient_retry_timeout );

		return true;
	}

	function verify_download( $response, $args, $url ) {
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$download_url = $this->get_plugin_update_download_url( $this->plugin_slug );

		if ( false === strpos( $url, $download_url ) || 402 != $response['response']['code'] ) {
			return $response;
		}

		// The $response['body'] is blank but output is actually saved to a file in this case
		$data = @file_get_contents( $response['filename'] );

		if ( ! $data ) {
			return new WP_Error( 'wpmdbpro_download_error_empty', sprintf( __( 'Error retrieving download from deliciousbrain.com. Please try again or download manually from <a href="%1$s">%2$s</a>.', 'wp-migrate-db' ), 'https://deliciousbrains.com/my-account/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin', _x( 'My Account', 'Delicious Brains account', 'wp-migrate-db' ) ) );
		}

		$decoded_data = json_decode( $data, true );

		// Can't decode the JSON errors, so just barf it all out
		if ( ! isset( $decoded_data['errors'] ) || ! $decoded_data['errors'] ) {
			return new WP_Error( 'wpmdbpro_download_error_raw', $data );
		}

		foreach ( $decoded_data['errors'] as $key => $msg ) {
			return new WP_Error( 'wpmdbpro_' . $key, $msg );
		}
	}

	function is_licence_constant() {
		return defined( 'WPMDB_LICENCE' );
	}

	function get_licence_key() {
		return $this->is_licence_constant() ? WPMDB_LICENCE : $this->settings['licence'];
	}

	/**
	 * Sets the licence index in the $settings array class property and updates the wpmdb_settings option.
	 *
	 * @param string $key
	 */
	function set_licence_key( $key ) {
		$this->settings['licence'] = $key;
		update_site_option( 'wpmdb_settings', $this->settings );
	}

	/**
	 * Checks whether the saved licence has expired or not.
	 *
	 * @param bool $skip_transient_check
	 *
	 * @return bool
	 */
	function is_valid_licence( $skip_transient_check = false ) {
		$response = $this->is_licence_expired( $skip_transient_check );

		if ( isset( $response['dbrains_api_down'] ) ) {
			return true;
		}

		// Don't cripple the plugin's functionality if the user's licence is expired
		if ( isset( $response['errors']['subscription_expired'] ) && 1 === count( $response['errors'] ) ) {
			return true;
		}

		return ( isset( $response['errors'] ) ) ? false : true;
	}

	function is_licence_expired( $skip_transient_check = false ) {
		$licence = $this->get_licence_key();

		if ( empty( $licence ) ) {
			$settings_link = sprintf( '<a href="%s">%s</a>', network_admin_url( $this->plugin_base ) . '#settings', _x( 'Settings', 'Plugin configuration and preferences', 'wp-migrate-db' ) );
			$message       = sprintf( __( 'To finish activating WP Migrate DB Pro, please go to %1$s and enter your license key. If you don\'t have a license key, you may <a href="%2$s">purchase one</a>.', 'wp-migrate-db' ), $settings_link, 'http://deliciousbrains.com/wp-migrate-db-pro/pricing/' );

			return array( 'errors' => array( 'no_licence' => $message ) );
		}

		if ( ! $skip_transient_check ) {
			$trans = get_site_transient( 'wpmdb_licence_response' );
			if ( false !== $trans ) {
				return json_decode( $trans, true );
			}
		}

		return json_decode( $this->check_licence( $licence ), true );
	}

	function check_licence( $licence_key ) {
		if ( empty( $licence_key ) ) {
			return false;
		}

		$args = array(
			'licence_key' => urlencode( $licence_key ),
			'site_url'    => urlencode( untrailingslashit( network_home_url( '', 'http' ) ) ),
		);

		$response = $this->dbrains_api_request( 'check_support_access', $args );

		set_site_transient( 'wpmdb_licence_response', $response, $this->transient_timeout );

		return $response;
	}

	/**
	 * Is the version a beta version?
	 *
	 * @param string $ver
	 *
	 * @return bool
	 */
	public function is_beta_version( $ver ) {
		if ( preg_match( '@b[0-9]+$@', $ver ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Has tbe beta optin been turned on?
	 *
	 * @return bool
	 */
	public function has_beta_optin() {
		if ( ! isset( $this->settings['beta_optin'] ) ) {
			return false;
		}

		return (bool) $this->settings['beta_optin'];
	}

	/**
	 * Sets the value of the beta optin setting
	 *
	 * @param bool $value
	 */
	function set_beta_optin( $value = true ) {
		$this->settings['beta_optin'] = $value;
		update_site_option( 'wpmdb_settings', $this->settings );
	}

	function get_required_version( $slug ) {
		$plugin_file = sprintf( '%1$s/%1$s.php', $slug );

		if ( isset( $this->addons[ $plugin_file ]['required_version'] ) ) {
			return $this->addons[ $plugin_file ]['required_version'];
		} else {
			return 0;
		}
	}

	function get_latest_version( $slug ) {
		$data = $this->get_upgrade_data();

		if ( ! isset( $data[ $slug ] ) ) {
			return false;
		}

		$latest_version = empty ( $data[ $slug ]['version'] ) ? false : $data[ $slug ]['version'];

		if ( ! isset( $data[ $slug ]['beta_version'] ) ) {
			// No beta version available
			return $latest_version;
		}

		if ( version_compare( $data[ $slug ]['version'], $data[ $slug ]['beta_version'], '>' ) ) {
			// Stable version greater than the beta
			return $latest_version;
		}

		if ( WPMDB_Beta_Manager::is_rolling_back_plugins() ) {
			// We are in the process of rolling back to stable versions
			return $latest_version;
		}

		if ( ! $this->has_beta_optin() ) {
			// Not opted in to beta updates
			// The required version isn't a beta version
			return $latest_version;
		}

		return $data[ $slug ]['beta_version'];
	}

	function get_upgrade_data() {
		$info = get_site_transient( 'wpmdb_upgrade_data' );

		if ( isset( $info['version'] ) ) {
			delete_site_transient( 'wpmdb_licence_response' );
			delete_site_transient( 'wpmdb_upgrade_data' );
			$info = false;
		}

		if ( $info ) {
			return $info;
		}

		$data = $this->dbrains_api_request( 'upgrade_data' );

		$data = json_decode( $data, true );

		/*
		We need to set the transient even when there's an error,
		otherwise we'll end up making API requests over and over again
		and slowing things down big time.
		*/
		$default_upgrade_data = array( 'wp-migrate-db-pro' => array( 'version' => $GLOBALS['wpmdb_meta'][ $this->core_slug ]['version'] ) );

		if ( ! $data ) {
			set_site_transient( 'wpmdb_upgrade_data', $default_upgrade_data, $this->transient_retry_timeout );
			$this->log_error( 'Error trying to decode JSON upgrade data.' );

			return false;
		}

		if ( isset( $data['errors'] ) ) {
			set_site_transient( 'wpmdb_upgrade_data', $default_upgrade_data, $this->transient_retry_timeout );
			$this->log_error( 'Error trying to get upgrade data.', $data['errors'] );

			return false;
		}

		set_site_transient( 'wpmdb_upgrade_data', $data, $this->transient_timeout );

		return $data;
	}

	function get_plugin_update_download_url( $plugin_slug, $is_beta = false ) {
		$licence    = $this->get_licence_key();
		$query_args = array(
			'request'     => 'download',
			'licence_key' => $licence,
			'slug'        => $plugin_slug,
			'site_url'    => home_url( '', 'http' ),
		);

		if ( $is_beta ) {
			$query_args['beta'] = '1';
		}

		return add_query_arg( $query_args, $this->dbrains_api_url );
	}

	function diverse_array( $vector ) {
		$result = array();

		foreach ( $vector as $key1 => $value1 ) {
			foreach ( $value1 as $key2 => $value2 ) {
				$result[ $key2 ][ $key1 ] = $value2;
			}
		}

		return $result;
	}

	function set_time_limit_available() {
		if ( ! function_exists( 'set_time_limit' ) || ! function_exists( 'ini_get' ) ) {
			return false;
		}

		$current_max_execution_time  = ini_get( 'max_execution_time' );
		$proposed_max_execution_time = ( $current_max_execution_time == 30 ) ? 31 : 30;
		@set_time_limit( $proposed_max_execution_time );
		$current_max_execution_time = ini_get( 'max_execution_time' );

		return $proposed_max_execution_time == $current_max_execution_time;
	}

	function get_plugin_name( $plugin = false ) {
		if ( ! is_admin() ) {
			return false;
		}

		$plugin_basename = ( false !== $plugin ? $plugin : $this->plugin_basename );

		$plugins = get_plugins();

		if ( ! isset( $plugins[ $plugin_basename ]['Name'] ) ) {
			return false;
		}

		return $plugins[ $plugin_basename ]['Name'];
	}

	function get_class_props() {
		return get_object_vars( $this );
	}

	/**
	 * Get only the tables beginning with our DB prefix or temporary prefix, also skip views and legacy wpmdb_alter_statements table.
	 *
	 * @param string $scope
	 *
	 * @return array
	 */
	function get_tables( $scope = 'regular' ) {
		global $wpdb;
		$prefix       = ( $scope == 'temp' ? $this->temp_prefix : $wpdb->base_prefix );
		$tables       = $wpdb->get_results( 'SHOW FULL TABLES', ARRAY_N );
		$clean_tables = array();

		foreach ( $tables as $table ) {
			if ( ( ( $scope == 'temp' || $scope == 'prefix' ) && 0 !== strpos( $table[0], $prefix ) ) || $table[1] == 'VIEW' ) {
				continue;
			}
			if ( $this->get_legacy_alter_table_name() == $table[0] ) {
				continue;
			}
			$clean_tables[] = $table[0];
		}

		return apply_filters( 'wpmdb_tables', $clean_tables, $scope );
	}

	function version_update_notice() {
		// We don't want to show both the "Update Required" and "Update Available" messages at the same time
		if ( isset( $this->addons[ $this->plugin_basename ] ) && true == $this->is_addon_outdated( $this->plugin_basename ) ) {
			return;
		}

		// To reduce UI clutter we hide addon update notices if the core plugin has updates available
		if ( isset( $this->addons[ $this->plugin_basename ] ) ) {
			$core_installed_version = $GLOBALS['wpmdb_meta'][ $this->core_slug ]['version'];
			$core_latest_version    = $this->get_latest_version( $this->core_slug );
			// Core update is available, don't show update notices for addons until core is updated
			if ( version_compare( $core_installed_version, $core_latest_version, '<' ) ) {
				return;
			}
		}

		$update_url = wp_nonce_url( network_admin_url( 'update.php?action=upgrade-plugin&plugin=' . urlencode( $this->plugin_basename ) ), 'upgrade-plugin_' . $this->plugin_basename );

		// If pre-1.1.2 version of Media Files addon, don't bother getting the versions
		if ( ! isset( $GLOBALS['wpmdb_meta'][ $this->plugin_slug ]['version'] ) ) {
			?>
			<div style="display: block;" class="updated warning inline-message">
				<strong><?php _ex( 'Update Available', 'A new version of the plugin is available', 'wp-migrate-db' ); ?></strong> &mdash;
				<?php printf( __( 'A new version of %1$s is now available. %2$s', 'wp-migrate-db' ), $this->plugin_title, sprintf( '<a href="%s">%s</a>', $update_url, _x( 'Update Now', 'Download and install a new version of the plugin', 'wp-migrate-db' ) ) ); ?>
			</div>
			<?php
		} else {
			$installed_version = $GLOBALS['wpmdb_meta'][ $this->plugin_slug ]['version'];
			$latest_version    = $this->get_latest_version( $this->plugin_slug );

			if ( version_compare( $installed_version, $latest_version, '<' ) ) { ?>
				<div style="display: block;" class="updated warning inline-message">
					<?php if ( $this->is_beta_version( $latest_version ) ) : ?>
						<strong><?php _ex( 'Beta Update Available', 'A new version of the plugin is available', 'wp-migrate-db' ); ?></strong> &mdash;
					<?php else: ?>
						<strong><?php _ex( 'Update Available', 'A new version of the plugin is available', 'wp-migrate-db' ); ?></strong> &mdash;
					<?php endif; ?>
					<?php printf( __( '%1$s %2$s is now available. You currently have %3$s installed. <a href="%4$s">%5$s</a>', 'wp-migrate-db' ), $this->plugin_title, $latest_version, $installed_version, $update_url, _x( 'Update Now', 'Download and install a new version of the plugin', 'wp-migrate-db' ) ); ?>
				</div>
				<?php
			}
		}
	}

	function plugins_dir() {
		$path = untrailingslashit( $this->plugin_dir_path );

		return substr( $path, 0, strrpos( $path, DIRECTORY_SEPARATOR ) ) . DIRECTORY_SEPARATOR;
	}

	function is_addon_outdated( $addon_basename ) {
		$addon_slug = current( explode( '/', $addon_basename ) );

		// If pre-1.1.2 version of Media Files addon, then it is outdated
		if ( ! isset( $GLOBALS['wpmdb_meta'][ $addon_slug ]['version'] ) ) {
			return true;
		}

		$installed_version = $GLOBALS['wpmdb_meta'][ $addon_slug ]['version'];
		$required_version  = $this->addons[ $addon_basename ]['required_version'];

		return version_compare( $installed_version, $required_version, '<' );
	}

	function get_plugin_file_path() {
		return $this->plugin_file_path;
	}

	/**
	 *
	 * Get a message from the $messages array parameter based on a context
	 *
	 * Assumes the $messages array exists in the format of a nested array.
	 *
	 * Also assumes the nested array of strings has a key of 'default'
	 *
	 *  Ex:
	 *
	 *  array(
	 *      'key1' => array(
	 *          'ui'   => 'Some message',
	 *          'cli'   => 'Another message',
	 *          ...
	 *       ),
	 *
	 *      'key2' => array(
	 *          'ui'   => 'Some message',
	 *          'cli'   => 'Another message',
	 *          ...
	 *       ),
	 *
	 *      'default' => array(
	 *          'ui'   => 'Some message',
	 *          'cli'   => 'Another message',
	 *          ...
	 *       ),
	 *  )
	 *
	 * @param array  $messages
	 * @param        $key
	 * @param string $context
	 *
	 * @return mixed
	 */
	function get_contextual_message_string( $messages, $key, $context = 'ui' ) {
		$message = $messages[ $key ];

		if ( isset( $message[ $context ] ) ) {
			return $message[ $context ];
		} else if ( isset( $message['default'] ) ) {
			return $message['default'];
		}

		return '';
	}

	/**
	 * Returns a formatted message dependant on the status of the licence.
	 *
	 * @param bool $trans
	 * @param string $context
	 *
	 * @return array|mixed|string
	 */
	function get_licence_status_message( $trans = false, $context = null ) {
		$licence               = $this->get_licence_key();
		$api_response_provided = true;
		$message_context       = 'ui';
		$messages              = $this->license_response_messages;
		$message               = '';

		if ( $this->doing_cli_migration ) {
			$message_context = 'cli';
		}

		if ( empty( $licence ) && ! $trans ) {
			$message = sprintf( __( '<strong>Activate Your License</strong> &mdash; Please <a href="%s" class="%s">enter your license key</a> to enable push and pull functionality, priority support and plugin updates.', 'wp-migrate-db' ), network_admin_url( $this->plugin_base . '#settings' ), 'js-action-link enter-licence' );

			return $message;
		}

		if ( ! $trans ) {
			$trans = get_site_transient( 'wpmdb_licence_response' );

			if ( false === $trans ) {
				$trans = $this->check_licence( $licence );
			}

			$trans                 = json_decode( $trans, true );
			$api_response_provided = false;
		}

		if ( isset( $trans['dbrains_api_down'] ) ) {
			return __( "<strong>We've temporarily activated your license and will complete the activation once the Delicious Brains API is available again.</strong>", 'wp-migrate-db' );
		}

		$errors = $trans['errors'];

		if ( isset( $errors['connection_failed'] ) ) {
			$message = $this->get_contextual_message_string( $messages, 'connection_failed', $message_context );

			if ( defined( 'WP_HTTP_BLOCK_EXTERNAL' ) && WP_HTTP_BLOCK_EXTERNAL ) {
				$url_parts = $this->parse_url( $this->get_dbrains_api_base() );
				$host      = $url_parts['host'];
				if ( ! defined( 'WP_ACCESSIBLE_HOSTS' ) || strpos( WP_ACCESSIBLE_HOSTS, $host ) === false ) {
					$message = sprintf( $this->get_contextual_message_string( $messages, 'http_block_external', $message_context ), esc_attr( $host ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/wp_http_block_external/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin' );
				}
			}

			// Don't cache the license response so we can try again
			delete_site_transient( 'wpmdb_licence_response' );
		} elseif ( isset( $errors['subscription_cancelled'] ) ) {

			$message = $this->get_contextual_message_string( $messages, 'subscription_cancelled', $message_context );

		} elseif ( isset( $errors['subscription_expired'] ) ) {

			$message_base = $this->get_contextual_message_string( $messages, 'subscription_expired_base', $message_context );
			$message_end  = $this->get_contextual_message_string( $messages, 'subscription_expired_end', $message_context );

			$contextual_messages = array(
				'default' => $message_base . $message_end,
				'update'  => $message_base . __( 'Updates are only available to those with an active license. ', 'wp-migrate-db' ) . $message_end,
				'addons'  => $message_base . __( 'Only active licenses can download and install addons. ', 'wp-migrate-db' ) . $message_end,
				'support' => $message_base . __( 'Only active licenses can submit support requests. ', 'wp-migrate-db' ) . $message_end,
				'licence' => $message_base . __( "All features will continue to work, but you won't be able to receive updates or email support. ", 'wp-migrate-db' ) . $message_end,
			);

			if ( empty( $context ) ) {
				$context = 'default';
			}
			if ( ! empty( $contextual_messages[ $context ] ) ) {
				$message = $contextual_messages[ $context ];
			} elseif ( 'all' === $context ) {
				$message = $contextual_messages;
			}

		} elseif ( isset( $errors['no_activations_left'] ) ) {

			$message = $this->get_contextual_message_string( $messages, 'no_activations_left', $message_context );

		} elseif ( isset( $errors['licence_not_found'] ) ) {

			if ( ! $api_response_provided ) {
				$message = $this->get_contextual_message_string( $messages, 'licence_not_found_api_failed', $message_context );
			} else {
				$error   = reset( $errors );
				$message = sprintf( $this->get_contextual_message_string( $messages, 'licence_not_found_api', $message_context ), $error );
			}

		} elseif ( isset( $errors['activation_deactivated'] ) ) {
			$message = $this->get_contextual_message_string( $messages, 'activation_deactivated', $message_context );

		} else {
			$error   = reset( $errors );
			$message = sprintf( $this->get_contextual_message_string( $messages, 'default', $message_context ), 'mailto:nom@deliciousbrains.com', 'nom@deliciousbrains.com', $error );
		}

		return $message;
	}

	function set_cli_migration() {
		$this->doing_cli_migration = true;
	}

	/**
	 * @param mixed $return Value to be returned as response.
	 *
	 * @return null
	 */
	function end_ajax( $return = false ) {
		$return = apply_filters( 'wpmdb_before_response', $return );

		if ( defined( 'DOING_WPMDB_TESTS' ) || $this->doing_cli_migration ) {
			// This function should signal the end of the PHP process, but for CLI it carries on so we need to reset our own usage
			// of the wpmdb_before_response filter before another respond_to_* function adds it again.
			remove_filter( 'wpmdb_before_response', array( $this, 'scramble' ) );

			return ( false === $return ) ? null : $return;
		}

		echo ( false === $return ) ? '' : $return;
		exit;
	}

	function check_ajax_referer( $action ) {
		if ( defined( 'DOING_WPMDB_TESTS' ) || $this->doing_cli_migration ) {
			return;
		}

		$result = WPMDB_Utils::check_ajax_referer( $action, 'nonce', false );

		if ( false === $result ) {
			$return = array( 'wpmdb_error' => 1, 'body' => sprintf( __( 'Invalid nonce for: %s', 'wp-migrate-db' ), $action ) );
			$this->end_ajax( json_encode( $return ) );
		}

		$cap = ( is_multisite() ) ? 'manage_network_options' : 'export';
		$cap = apply_filters( 'wpmdb_ajax_cap', $cap );

		if ( ! current_user_can( $cap ) ) {
			$return = array( 'wpmdb_error' => 1, 'body' => sprintf( __( 'Access denied for: %s', 'wp-migrate-db' ), $action ) );
			$this->end_ajax( json_encode( $return ) );
		}
	}

	// Generates our secret key
	function generate_key( $length = 40 ) {
		$keyset = 'abcdefghijklmnopqrstuvqxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/';
		$key    = '';

		for ( $i = 0; $i < $length; $i ++ ) {
			$key .= substr( $keyset, wp_rand( 0, strlen( $keyset ) - 1 ), 1 );
		}

		return $key;
	}

	/**
	 * Returns the wpmdb_bottleneck value in bytes
	 *
	 * @param string $type
	 *
	 * @return int
	 */
	function get_bottleneck( $type = 'regular' ) {
		$suhosin_limit         = false;
		$suhosin_request_limit = false;
		$suhosin_post_limit    = false;

		if ( function_exists( 'ini_get' ) ) {
			$suhosin_request_limit = trim( ini_get( 'suhosin.request.max_value_length' ) );
			$suhosin_post_limit    = trim( ini_get( 'suhosin.post.max_value_length' ) );
		}

		if ( $suhosin_request_limit && $suhosin_post_limit ) {
			$suhosin_limit = min( wp_convert_hr_to_bytes( $suhosin_request_limit ),  wp_convert_hr_to_bytes( $suhosin_post_limit ) );
		}

		$post_max_upper_size   = apply_filters( 'wpmdb_post_max_upper_size', 26214400 );

		// we have to account for HTTP headers and other bloating, here we minus 1kb for bloat
		$calculated_bottleneck = min( ( $this->get_post_max_size() - 1024 ), $post_max_upper_size );

		if( 0 >= $calculated_bottleneck ) {
			$calculated_bottleneck = $post_max_upper_size;
		}

		if ( $suhosin_limit ) {
			$calculated_bottleneck = min( $calculated_bottleneck, $suhosin_limit - 1024 );
		}

		if ( $type != 'max' ) {
			$calculated_bottleneck = min( $calculated_bottleneck, $this->settings['max_request'] );
		}

		return apply_filters( 'wpmdb_bottleneck', $calculated_bottleneck );
	}

	/**
	 * Returns the php ini value for post_max_size in bytes
	 *
	 * @return int
	 */
	function get_post_max_size() {
		$bytes = max( wp_convert_hr_to_bytes( trim( ini_get( 'post_max_size' ) ) ), wp_convert_hr_to_bytes( trim( ini_get( 'hhvm.server.max_post_size' ) ) ) );

		return $bytes;
	}

	/**
	 * Returns a url string given an associative array as per the output of parse_url.
	 *
	 * @param $parsed_url
	 *
	 * @return string
	 */
	function unparse_url( $parsed_url ) {
		$scheme   = isset( $parsed_url['scheme'] ) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset( $parsed_url['host'] ) ? $parsed_url['host'] : '';
		$port     = isset( $parsed_url['port'] ) ? ':' . $parsed_url['port'] : '';
		$user     = isset( $parsed_url['user'] ) ? $parsed_url['user'] : '';
		$pass     = isset( $parsed_url['pass'] ) ? ':' . $parsed_url['pass'] : '';
		$pass     = ( $user || $pass ) ? "$pass@" : '';
		$path     = isset( $parsed_url['path'] ) ? $parsed_url['path'] : '';
		$query    = isset( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : '';
		$fragment = isset( $parsed_url['fragment'] ) ? '#' . $parsed_url['fragment'] : '';

		return "$scheme$user$pass$host$port$path$query$fragment";
	}

	/**
	 * Get a simplified url for use as the referrer.
	 *
	 * @param $referer_url
	 *
	 * @return string
	 *
	 * NOTE: mis-spelling intentional to match usage.
	 */
	function referer_from_url( $referer_url ) {
		$url_parts = $this->parse_url( $referer_url );

		if ( false !== $url_parts ) {
			$reduced_url_parts = array_intersect_key( $url_parts, array_flip( array( 'scheme', 'host', 'port', 'path' ) ) );
			if ( ! empty( $reduced_url_parts ) ) {
				$referer_url = $this->unparse_url( $reduced_url_parts );
			}
		}

		return $referer_url;
	}

	/**
	 * Get a simplified base url without scheme.
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	function scheme_less_url( $url ) {
		$url_parts = $this->parse_url( $url );

		if ( false !== $url_parts ) {
			$reduced_url_parts = array_intersect_key( $url_parts, array_flip( array( 'host', 'port', 'path', 'user', 'pass' ) ) );
			if ( ! empty( $reduced_url_parts ) ) {
				$url = $this->unparse_url( $reduced_url_parts );
			}
		}

		return $url;
	}

	/**
	 * Parses a url into its components. Compatible with PHP < 5.4.7.
	 *
	 * @param $url string The url to parse.
	 *
	 * @return array|false The parsed components or false on error.
	 */
	function parse_url( $url ) {
		$url = trim( $url );
		if ( 0 === strpos( $url, '//' ) ) {
			$url       = 'http:' . $url;
			$no_scheme = true;
		} else {
			$no_scheme = false;
		}

		$parts = parse_url( $url );
		if ( $no_scheme ) {
			unset( $parts['scheme'] );
		}

		return $parts;
	}

	/**
	 * Standard notice display check
	 * Returns dismiss and reminder links html for templates where necessary
	 *
	 * @param string      $notice   The name of the notice e.g. license-key-warning
	 * @param bool|string $dismiss  If the notice has a dismiss link. Pass "SHOW_ONCE" to auto-dismiss after first presentation.
	 * @param bool|int    $reminder If the notice has a reminder link, this will be the number of seconds
	 *
	 * @return array|bool
	 */
	function check_notice( $notice, $dismiss = false, $reminder = false, $css_class = 'notice-link' ) {
		if ( true === apply_filters( 'wpmdb_hide_' . $notice, false ) ) {
			return false;
		}
		global $current_user;
		$notice_links = array();

		if ( $dismiss ) {
			if ( get_user_meta( $current_user->ID, 'wpmdb_dismiss_' . $notice ) ) {
				return false;
			}
			$notice_links['dismiss'] = '<a href="#" class="' . esc_attr( $css_class ) . '" data-notice="' . $notice . '" data-type="dismiss">' . _x( 'Dismiss', 'dismiss notice permanently', 'wp-migrate-db' ) . '</a>';

			if ( 'SHOW_ONCE' === $dismiss ) {
				update_user_meta( $current_user->ID, 'wpmdb_dismiss_' . $notice, true );
			}
		}

		if ( $reminder ) {
			if ( ( $reminder_set = get_user_meta( $current_user->ID, 'wpmdb_reminder_' . $notice, true ) ) ) {
				if ( strtotime( 'now' ) < $reminder_set ) {
					return false;
				}
			}
			$notice_links['reminder'] = '<a href="#"  class="' . esc_attr( $css_class ) . '" data-notice="' . $notice . '" data-type="reminder" data-reminder="' . $reminder . '">' . __( 'Remind Me Later', 'wp-migrate-db' ) . '</a>';
		}

		return ( count( $notice_links ) > 0 ) ? $notice_links : true;
	}

	/**
	 * Performs a schema update if required.
	 */
	public function maybe_schema_update() {
		if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
			return;
		}

		$schema_version = get_site_option( 'wpmdb_schema_version' );
		$update_schema  = false;

		/*
		 * Upgrade this option to a network wide option if the site has been upgraded
		 * from a regular WordPress installation to a multisite installation.
		 */
		if ( false === $schema_version && is_multisite() && is_network_admin() ) {
			$schema_version = get_option( 'wpmdb_schema_version' );
			if ( false !== $schema_version ) {
				update_site_option( 'wpmdb_schema_version', $schema_version );
				delete_option( 'wpmdb_schema_version' );
			}
		}

		if ( false === $schema_version ) {
			$schema_version = 0;
		}

		if ( $schema_version < 1 ) {
			$error_log = get_option( 'wpmdb_error_log' );
			// skip multisite installations as we can't use add_site_option because it doesn't include an 'autoload' argument
			if ( false !== $error_log && false === is_multisite() ) {
				delete_option( 'wpmdb_error_log' );
				add_option( 'wpmdb_error_log', $error_log, '', 'no' );
			}

			$update_schema  = true;
			$schema_version = 1;
		}

		if ( $schema_version < 2 ) {
			if ( $this->is_beta_version( $this->plugin_version ) ) {
				// If the current installed version is a beta version then turn on the beta optin
				$this->set_beta_optin();
				// Dismiss the notice also, so it won't keep coming back
				update_user_meta( get_current_user_id(), 'wpmdb_dismiss_beta_optin', true );
			}

			$update_schema  = true;
			$schema_version = 2;
		}

		if ( true === $update_schema ) {
			update_site_option( 'wpmdb_schema_version', $schema_version );
		}
	}

	/**
	 * Converts file paths that include mixed slashes to use the correct type of slash for the current operating system.
	 *
	 * @param $path string
	 *
	 * @return string
	 */
	function slash_one_direction( $path ) {
		return str_replace( array( '/', '\\' ), DIRECTORY_SEPARATOR, $path );
	}

	/**
	 * Returns the table name where the alter statements are held during the migration.
	 *
	 * @return string
	 */
	function get_alter_table_name() {
		static $alter_table_name;

		if ( ! empty( $alter_table_name ) ) {
			return $alter_table_name;
		}

		$alter_table_name = apply_filters( 'wpmdb_alter_table_name', $this->temp_prefix . 'wpmdb_alter_statements' );

		return $alter_table_name;
	}

	/**
	 * Returns the table name where the alter statements are held during the migration (old "wp_" prefixed style).
	 *
	 * @return string
	 */
	function get_legacy_alter_table_name() {
		static $alter_table_name;

		if ( ! empty( $alter_table_name ) ) {
			return $alter_table_name;
		}

		global $wpdb;
		$alter_table_name = apply_filters( 'wpmdb_alter_table_name', $wpdb->base_prefix . 'wpmdb_alter_statements' );

		return $alter_table_name;
	}

	/**
	 * Save the migration state, and replace the current item to be returned if there is an error.
	 *
	 * @param $state mixed
	 * @param $default mixed The default value to return on success, optional defaults to null.
	 *
	 * @return mixed
	 */
	function save_migration_state( $state, $default = null ) {
		if ( ! $this->migration_state->set( $state ) ) {
			$error_msg = __( 'Failed to save migration state. Please contact support.', 'wp-migrate-db' );
			$default   = array( 'wpmdb_error' => 1, 'body' => $error_msg );
			$this->log_error( $error_msg );
		}

		return $default;
	}

	/**
	 * Restore previous migration state and merge in new information or initialize new migration state.
	 *
	 * @param null $id
	 *
	 * @return array|bool|mixed|void
	 */
	function get_migration_state( $id = null ) {
		$return = true;

		if ( ! empty( $id ) ) {
			$this->migration_state = new WPMDB_Migration_State( $id );
			$state                 = $this->migration_state->get();

			if ( empty( $state ) || $this->migration_state->id() !== $id ) {
				$error_msg = __( 'Failed to retrieve migration state. Please contact support.', 'wp-migrate-db' );
				$return    = array( 'wpmdb_error' => 1, 'body' => $error_msg );
				$this->log_error( $error_msg );
				$return = $this->end_ajax( json_encode( $return ) );
			} else {
				$this->state_data = array_merge( $state, $this->state_data );

				$return = $this->save_migration_state( $this->state_data, $return );

				if ( ! empty( $return['wpmdb_error'] ) ) {
					$return = $this->end_ajax( json_encode( $return ) );
				}
			}
		} else {
			$this->migration_state = new WPMDB_Migration_State();
		}

		return $return;
	}

	/**
	 * Returns the absolute path to the root of the website.
	 *
	 * @return string
	 */
	function get_absolute_root_file_path() {
		static $absolute_path;

		if ( ! empty( $absolute_path ) ) {
			return $absolute_path;
		}

		$absolute_path = rtrim( ABSPATH, '\\/' );
		$site_url      = rtrim( site_url( '', 'http' ), '\\/' );
		$home_url      = rtrim( home_url( '', 'http' ), '\\/' );

		if ( $site_url != $home_url ) {
			$difference = str_replace( $home_url, '', $site_url );
			if ( strpos( $absolute_path, $difference ) !== false ) {
				$absolute_path = rtrim( substr( $absolute_path, 0, - strlen( $difference ) ), '\\/' );
			}
		}

		return $absolute_path;
	}

	/**
	 * Returns the function name that called the function using this function.
	 *
	 * @return string
	 */
	public function get_caller_function() {
		list( , , $caller ) = debug_backtrace( false );

		if ( ! empty( $caller['function'] ) ) {
			$caller = $caller['function'];
		} else {
			$caller = '';
		}

		return $caller;
	}

	/**
	 * Has a specific method been called in the stack trace.
	 *
	 * @param string $method
	 *
	 * @return bool
	 */
	public function has_method_been_called( $method ) {
		$stack = debug_backtrace();
		foreach ( $stack as $caller ) {
			if ( $method === $caller['function'] ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Scramble string.
	 *
	 * @param mixed $input String to be scrambled.
	 *
	 * @return mixed
	 */
	function scramble( $input ) {
		if ( ! empty( $input ) ) {
			$input = 'WPMDB-SCRAMBLED' . str_replace( array( '/', '\\' ), array( '%#047%', '%#092%' ), str_rot13( $input ) );
		}

		return $input;
	}

	/**
	 * Unscramble string.
	 *
	 * @param mixed $input String to be unscrambled.
	 *
	 * @return mixed
	 */
	function unscramble( $input ) {
		if ( ! empty( $input ) && is_string( $input ) ) {
			if ( 0 === strpos( $input, 'WPMDB-SCRAMBLED' ) ) {
				// If the string begins with WPMDB-SCRAMBED we can unscramble.
				// As the scrambled string could be multiple segments of scrambling (from stow) we remove indicators in one go.
				$input = str_replace( array( 'WPMDB-SCRAMBLED', '%#047%', '%#092%' ), array( '', '/', '\\' ), $input );
				$input = str_rot13( $input );
			} elseif ( false !== strpos( $input, 'WPMDB-SCRAMBLED' ) ) {
				// Starts with non-scrambled data (error), but with scrambled string following.
				$pos   = strpos( $input, 'WPMDB-SCRAMBLED' );
				$input = substr( $input, 0, $pos ) . $this->unscramble( substr( $input, $pos ) );
			}
		}

		return $input;
	}

	/**
	 * Returns HTML for setting a checkbox as checked depending on supplied option value.
	 *
	 * @param string|array $option      Options value or array containing $option_name as key.
	 * @param string       $option_name If $option is an array, the key that contains the value to be checked.
	 */
	public function maybe_checked( $option, $option_name = '' ) {
		if ( is_array( $option ) && ! empty( $option_name ) && ! empty( $option[ $option_name ] ) ) {
			$option = $option[ $option_name ];
		}
		echo esc_html( ( ! empty( $option ) && '1' == $option ) ? ' checked="checked"' : '' );
	}

	/**
	 * Get array of subsite simple urls keyed by their ID.
	 *
	 * @return array
	 */
	public function subsites_list() {
		$subsites = array();

		if ( ! is_multisite() ) {
			return $subsites;
		}


		if ( version_compare( $GLOBALS['wp_version'], '4.6', '>=' ) ) {
			$sites = get_sites( array( 'number' => false ) );
		} else {
			$sites = wp_get_sites( array( 'limit' => 0 ) );
		}

		if ( ! empty( $sites ) ) {
			foreach ( (array) $sites as $subsite ) {
				$subsite                         = (array) $subsite;
				$subsites[ $subsite['blog_id'] ] = $this->simple_site_url( get_blogaddress_by_id( $subsite['blog_id'] ) );
			}
		}

		return $subsites;
	}

	/**
	 * Returns uploads info for given subsite or primary site.
	 *
	 * @param int $blog_id Optional, defaults to primary.
	 *
	 * @return array
	 *
	 * NOTE: Must be run from primary site.
	 */
	public function uploads_info( $blog_id = 0 ) {
		static $primary_uploads = array();

		if ( ! empty( $blog_id ) && is_multisite() ) {
			switch_to_blog( $blog_id );
		}

		$uploads = wp_upload_dir();

		if ( ! empty( $blog_id ) && is_multisite() ) {
			restore_current_blog();

			if ( empty( $primary_uploads ) ) {
				$primary_uploads = $this->uploads_info();
			}
			$uploads['short_basedir'] = str_replace( trailingslashit( $primary_uploads['basedir'] ), '', trailingslashit( $uploads['basedir'] ) );
		}

		return $uploads;
	}

	/**
	 * Get array of subsite info keyed by their ID.
	 *
	 * @return array
	 */
	public function subsites_info() {
		$subsites = array();

		if ( ! is_multisite() ) {
			return $subsites;
		}

		if ( version_compare( $GLOBALS['wp_version'], '4.6', '>=' ) ) {
			$sites = get_sites( array( 'number' => false ) );
		} else {
			$sites = wp_get_sites( array( 'limit' => 0 ) );
		}

		if ( ! empty( $sites ) ) {
			// We to fix up the urls in uploads as they all use primary site's base!
			$primary_url = site_url();

			foreach ( $sites as $subsite ) {
				$subsite                                     = (array) $subsite;
				$subsites[ $subsite['blog_id'] ]['site_url'] = get_site_url( $subsite['blog_id'] );
				$subsites[ $subsite['blog_id'] ]['home_url'] = get_home_url( $subsite['blog_id'] );
				$subsites[ $subsite['blog_id'] ]['uploads']  = $this->uploads_info( $subsite['blog_id'] );

				$subsites[ $subsite['blog_id'] ]['uploads']['url']     = substr_replace( $subsites[ $subsite['blog_id'] ]['uploads']['url'], $subsites[ $subsite['blog_id'] ]['site_url'], 0, strlen( $primary_url ) );
				$subsites[ $subsite['blog_id'] ]['uploads']['baseurl'] = substr_replace( $subsites[ $subsite['blog_id'] ]['uploads']['baseurl'], $subsites[ $subsite['blog_id'] ]['site_url'], 0, strlen( $primary_url ) );
			}
		}

		return $subsites;
	}

	/**
	 * Returns validated and sanitized form data.
	 *
	 * @param array|string $data
	 *
	 * @return array|string
	 *
	 * This is a base implementation that should be overridden and included with a call to parent before validating form_data contents.
	 */
	function parse_migration_form_data( $data ) {
		parse_str( $data, $form_data );
		// As the magic_quotes_gpc setting affects the output of parse_str() we may need to remove any quote escaping.
		// (it uses the same mechanism that PHP > uses to populate the $_GET, $_POST, etc. variables)
		if ( get_magic_quotes_gpc() ) {
			$form_data = WPMDB_Utils::safe_wp_unslash( $form_data );
		}

		return $form_data;
	}

	/**
	 * Returns the profile value for a given key.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	function profile_value( $key ) {
		if ( ! empty( $key ) && ! empty( $this->form_data ) && isset( $this->form_data[ $key ] ) ) {
			return $this->form_data[ $key ];
		}

		return null;
	}

	/**
	 * Returns a simplified site url (good for identifying subsites).
	 *
	 * @param string $site_url
	 *
	 * @return string
	 */
	public function simple_site_url( $site_url ) {
		$site_url = untrailingslashit( $this->scheme_less_url( $site_url ) );

		return $site_url;
	}

	/**
	 * Checks given subsite id or url to see if it exists and returns its blog id.
	 *
	 * @param int|string $subsite       Blog ID or URL
	 * @param array      $subsites_list Optional array of blog_id => simple urls to use, defaults to result of subsites_list().
	 *
	 * @return bool|string
	 */
	public function get_subsite_id( $subsite, $subsites_list = array() ) {
		if ( ! is_numeric( $subsite ) ) {
			$subsite = $this->simple_site_url( $subsite );
		}

		if ( empty( $subsites_list ) ) {
			$subsites_list = $this->subsites_list();
		}

		foreach ( $subsites_list as $blog_id => $subsite_path ) {
			if ( is_numeric( $subsite ) ) {
				if ( $blog_id == $subsite ) {
					return $blog_id;
				}
			} elseif ( $subsite == $subsite_path ) {
				return $blog_id;
			}
		}

		return false;
	}

	/**
	 * Checks given array of subsite ids or urls to see if they exist and returns array of blog ids.
	 *
	 * @param array $subsites
	 * @param array $subsites_list Optional array of blog_id => simple urls to use, defaults to result of subsites_list().
	 *
	 * @return array
	 *
	 * Returned array element values will be false if the given value does not correspond to a subsite.
	 */
	public function get_subsite_ids( $subsites, $subsites_list = array() ) {
		if ( empty( $subsites ) ) {
			return array();
		}

		if ( ! is_array( $subsites ) ) {
			$subsites = array( $subsites );
		}

		foreach ( $subsites as $index => $subsite ) {
			$subsites[ $index ] = $this->get_subsite_id( $subsite, $subsites_list );
		}

		return $subsites;
	}

	/**
	 * Returns an associative array of html escaped useful information about the site.
	 *
	 * @return array
	 */
	public function site_details() {
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;
		$uploads      = wp_upload_dir();

		$site_details = array(
			'is_multisite'         => esc_html( is_multisite() ? 'true' : 'false' ),
			'site_url'             => esc_html( addslashes( site_url() ) ),
			'home_url'             => esc_html( addslashes( home_url() ) ),
			'prefix'               => esc_html( $table_prefix ),
			'uploads_baseurl'      => esc_html( addslashes( trailingslashit( $uploads['baseurl'] ) ) ),
			'uploads'              => $this->uploads_info(),
			'uploads_dir'          => esc_html( addslashes( $this->get_short_uploads_dir() ) ),
			'subsites'             => $this->subsites_list(),
			'subsites_info'        => $this->subsites_info(),
			'is_subdomain_install' => esc_html( ( is_multisite() && is_subdomain_install() ) ? 'true' : 'false' ),
		);

		$site_details = apply_filters( 'wpmdb_site_details', $site_details );

		return $site_details;
	}

	/**
	 * Returns an uploads dir without leading path to site.
	 *
	 * @return string
	 */
	public function get_short_uploads_dir() {
		$short_path = str_replace( $this->get_absolute_root_file_path(), '', $this->get_upload_info( 'path' ) );

		return trailingslashit( substr( str_replace( '\\', '/', $short_path ), 1 ) );
	}

	/**
	 * Returns max upload size in bytes, defaults to 25M if no limits set.
	 *
	 * @return int
	 */
	public function get_max_upload_size() {
		$bytes = wp_max_upload_size();

		if ( 1 > (int) $bytes ) {
			$p_bytes = wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) );
			$u_bytes = wp_convert_hr_to_bytes( ini_get( 'upload_max_filesize' ) );

			// If HHVM bug not returning either value, try its own settings.
			// If HHVM not involved, will drop through to default value.
			if ( empty( $p_bytes ) && empty( $u_bytes ) ) {
				$p_bytes = wp_convert_hr_to_bytes( ini_get( 'hhvm.server.max_post_size' ) );
				$u_bytes = wp_convert_hr_to_bytes( ini_get( 'hhvm.server.upload.upload_max_file_size' ) );

				$bytes = min( $p_bytes, $u_bytes );

				if ( 0 < (int) $bytes ) {
					return $bytes;
				}
			}

			if ( 0 < (int) $p_bytes ) {
				$bytes = $p_bytes;
			} elseif ( 0 < (int) $u_bytes ) {
				$bytes = $u_bytes;
			} else {
				$bytes = wp_convert_hr_to_bytes( '25M' );
			}
		}

		return $bytes;
	}

	/**
	 * Verify a remote response is valid
	 *
	 * @param mixed $response Response
	 *
	 * @return mixed Response if valid, error otherwise
	 */
	public function verify_remote_post_response( $response ) {
		if ( false === $response ) {
			$return    = array( 'wpmdb_error' => 1, 'body' => $this->error );
			$error_msg = 'Failed attempting to verify remote post response (#114mf)';
			$this->log_error( $error_msg, $this->error );
			$result = $this->end_ajax( json_encode( $return ) );

			return $result;
		}

		if ( ! is_serialized( trim( $response ) ) ) {
			$return    = array( 'wpmdb_error' => 1, 'body' => $response );
			$error_msg = 'Failed as the response is not serialized string (#115mf)';
			$this->log_error( $error_msg, $response );
			$result = $this->end_ajax( json_encode( $return ) );

			return $result;
		}

		$response = unserialize( trim( $response ) );

		if ( isset( $response['wpmdb_error'] ) ) {
			$this->log_error( $response['wpmdb_error'], $response );
			$result = $this->end_ajax( json_encode( $response ) );

			return $result;
		}

		return $response;
	}
}
