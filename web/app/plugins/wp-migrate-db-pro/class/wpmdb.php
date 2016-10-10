<?php

class WPMDB extends WPMDB_Base {
	protected $fp;
	protected $form_defaults;
	protected $accepted_fields;
	protected $default_profile;
	protected $maximum_chunk_size;
	protected $current_chunk = '';
	protected $connection_details;
	protected $max_insert_string_len;
	protected $row_tracker;
	protected $rows_per_segment = 100;
	protected $create_alter_table_query;
	protected $session_salt;
	protected $primary_keys;
	protected $unhook_templates = array();
	protected $plugin_tabs;
	protected $lock_url_find_replace_row = false;
	protected $subdomain_replaces_on;
	protected $domain_replace;
	protected $checkbox_options;
	protected $find_replace_pairs = array();

	function __construct( $plugin_file_path ) {
		parent::__construct( $plugin_file_path );

		$this->plugin_version = $GLOBALS['wpmdb_meta'][ $this->core_slug ]['version'];

		$this->max_insert_string_len = 50000; // 50000 is the default as defined by PhpMyAdmin

		add_filter( 'plugin_action_links_' . $this->plugin_basename, array( $this, 'plugin_action_links' ) );
		add_filter( 'network_admin_plugin_action_links_' . $this->plugin_basename, array( $this, 'plugin_action_links' ) );

		// internal AJAX handlers
		add_action( 'wp_ajax_wpmdb_delete_migration_profile', array( $this, 'ajax_delete_migration_profile' ) );
		add_action( 'wp_ajax_wpmdb_save_profile', array( $this, 'ajax_save_profile' ) );
		add_action( 'wp_ajax_wpmdb_save_setting', array( $this, 'ajax_save_setting' ) );
		add_action( 'wp_ajax_wpmdb_initiate_migration', array( $this, 'ajax_initiate_migration' ) );
		add_action( 'wp_ajax_wpmdb_migrate_table', array( $this, 'ajax_migrate_table' ) );
		add_action( 'wp_ajax_wpmdb_clear_log', array( $this, 'ajax_clear_log' ) );
		add_action( 'wp_ajax_wpmdb_get_log', array( $this, 'ajax_get_log' ) );
		add_action( 'wp_ajax_wpmdb_plugin_compatibility', array( $this, 'ajax_plugin_compatibility' ) );
		add_action( 'wp_ajax_wpmdb_blacklist_plugins', array( $this, 'ajax_blacklist_plugins' ) );
		add_action( 'wp_ajax_wpmdb_update_max_request_size', array( $this, 'ajax_update_max_request_size' ) );
		add_action( 'wp_ajax_wpmdb_update_delay_between_requests', array( $this, 'ajax_update_delay_between_requests' ) );
		add_action( 'wp_ajax_wpmdb_cancel_migration', array( $this, 'ajax_cancel_migration' ) );

		$this->accepted_fields = array(
			'action',
			'save_computer',
			'gzip_file',
			'connection_info',
			'replace_old',
			'replace_new',
			'table_migrate_option',
			'select_tables',
			'replace_guids',
			'exclude_spam',
			'save_migration_profile',
			'save_migration_profile_option',
			'create_new_profile',
			'create_backup',
			'remove_backup',
			'keep_active_plugins',
			'select_post_types',
			'backup_option',
			'select_backup',
			'exclude_transients',
			'exclude_post_types',
			'exclude_post_revisions',
			'compatibility_older_mysql',
			'export_dest',
		);

		$this->default_profile = array(
			'action'                    => 'savefile',
			'save_computer'             => '1',
			'gzip_file'                 => '1',
			'table_migrate_option'      => 'migrate_only_with_prefix',
			'replace_guids'             => '1',
			'default_profile'           => true,
			'name'                      => '',
			'select_tables'             => array(),
			'select_post_types'         => array(),
			'backup_option'             => 'backup_only_with_prefix',
			'exclude_transients'        => '1',
			'compatibility_older_mysql' => '1',
		);

		$this->checkbox_options = array(
			'save_computer'             => '0',
			'gzip_file'                 => '0',
			'replace_guids'             => '0',
			'exclude_spam'              => '0',
			'keep_active_plugins'       => '0',
			'create_backup'             => '0',
			'exclude_post_types'        => '0',
			'exclude_transients'        => '0',
			'compatibility_older_mysql' => '0',
		);

		$this->plugin_tabs = array(
			'<a href="#" class="nav-tab nav-tab-active js-action-link migrate" data-div-name="migrate-tab">' . esc_html( _x( 'Migrate', 'Configure a migration or export', 'wp-migrate-db' ) ) . '</a>',
			'<a href="#" class="nav-tab js-action-link settings" data-div-name="settings-tab">' . esc_html( _x( 'Settings', 'Plugin configuration and preferences', 'wp-migrate-db' ) ) . '</a>',
			'<a href="#" class="nav-tab js-action-link addons" data-div-name="addons-tab">' . esc_html( _x( 'Addons', 'Plugin extensions', 'wp-migrate-db' ) ) . '</a>',
			'<a href="#" class="nav-tab js-action-link help" data-div-name="help-tab">' . esc_html( _x( 'Help', 'Get help or contact support', 'wp-migrate-db' ) ) . '</a>',
		);

		// display a notice when either WP Migrate DB or WP Migrate DB Pro is automatically deactivated
		add_action( 'pre_current_active_plugins', array( $this, 'plugin_deactivated_notice' ) );

		// check if WP Engine is filtering the buffer and prevent it
		add_action( 'plugins_loaded', array( $this, 'maybe_disable_wp_engine_filtering' ) );

		// this is how many DB rows are processed at a time, allow devs to change this value
		$this->rows_per_segment = apply_filters( 'wpmdb_rows_per_segment', $this->rows_per_segment );

		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'network_admin_menu' ) );
			add_action( 'admin_menu', array( $this, 'network_tools_admin_menu' ) );
			/*
			 * The URL find & replace is locked down (delete & reorder disabled) on multisite installations as we require the URL
			 * of the remote site for export migrations. This URL is parsed into its various components and
			 * used to change values in the 'domain' & 'path' columns in the wp_blogs and wp_site tables.
			 */
			$this->lock_url_find_replace_row = true;
		} else {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}
	}

	/**
	 * Returns a fragment of SQL for creating the table where the alter statements are held during the migration.
	 *
	 * @return string
	 */
	function get_create_alter_table_query() {
		if ( ! is_null( $this->create_alter_table_query ) ) {
			return $this->create_alter_table_query;
		}

		$legacy_alter_table_name        = $this->get_legacy_alter_table_name();
		$this->create_alter_table_query = sprintf( "DROP TABLE IF EXISTS `%s`;\n", $legacy_alter_table_name );

		$alter_table_name = $this->get_alter_table_name();
		$this->create_alter_table_query .= sprintf( "DROP TABLE IF EXISTS `%s`;\n", $alter_table_name );
		$this->create_alter_table_query .= sprintf( "CREATE TABLE `%s` ( `query` LONGTEXT NOT NULL );\n", $alter_table_name );
		$this->create_alter_table_query = apply_filters( 'wpmdb_create_alter_table_query', $this->create_alter_table_query );

		return $this->create_alter_table_query;
	}

	/**
	 * Handler for ajax request to turn on or off Compatibility Mode.
	 */
	function ajax_plugin_compatibility() {
		$this->check_ajax_referer( 'plugin_compatibility' );

		$key_rules = array(
			'action'  => 'key',
			'install' => 'numeric',
		);
		$this->set_post_data( $key_rules );

		$mu_dir = ( defined( 'WPMU_PLUGIN_DIR' ) && defined( 'WPMU_PLUGIN_URL' ) ) ? WPMU_PLUGIN_DIR : trailingslashit( WP_CONTENT_DIR ) . 'mu-plugins';
		$source = trailingslashit( $this->plugin_dir_path ) . 'compatibility/wp-migrate-db-pro-compatibility.php';
		$dest   = trailingslashit( $mu_dir ) . 'wp-migrate-db-pro-compatibility.php';
		if ( '1' === trim( $this->state_data['install'] ) ) { // install MU plugin
			if ( ! wp_mkdir_p( $mu_dir ) ) {
				printf( esc_html__( 'The following directory could not be created: %s', 'wp-migrate-db' ), $mu_dir );
				exit;
			}

			if ( ! @copy( $source, $dest ) ) {
				printf( esc_html__( 'Could not copy the compatibility plugin from %1$s to %2$s', 'wp-migrate-db' ), $source, $dest );
				exit;
			}
		} else { // uninstall MU plugin
			// TODO: Use WP_Filesystem API.
			if ( file_exists( $dest ) && ! @unlink( $dest ) ) {
				printf( esc_html__( 'Could not remove the compatibility plugin from %s', 'wp-migrate-db' ), $dest );
				exit;
			}
		}
		exit;
	}

	/**
	 * Handler for updating the plugins that are not to be loaded during a request (Compatibility Mode).
	 */
	function ajax_blacklist_plugins() {
		$this->check_ajax_referer( 'blacklist_plugins' );

		$key_rules = array(
			'action'            => 'key',
			'blacklist_plugins' => 'array',
		);
		$this->set_post_data( $key_rules );

		$this->settings['blacklist_plugins'] = (array) $this->state_data['blacklist_plugins'];
		update_site_option( 'wpmdb_settings', $this->settings );
		exit;
	}

	/**
	 * Updates the Maximum Request Size setting.
	 *
	 * @return void
	 */
	function ajax_update_max_request_size() {
		$this->check_ajax_referer( 'update-max-request-size' );

		$key_rules = array(
			'action'           => 'key',
			'max_request_size' => 'positive_int',
			'nonce'            => 'key',
		);
		$this->set_post_data( $key_rules );

		$this->settings['max_request'] = (int) $this->state_data['max_request_size'] * 1024;
		$result                        = update_site_option( 'wpmdb_settings', $this->settings );
		$this->end_ajax( $result );
	}

	/**
	 * Updates the Delay Between Requests setting.
	 *
	 * @return void
	 */
	function ajax_update_delay_between_requests() {
		$this->check_ajax_referer( 'update-delay-between-requests' );

		$key_rules = array(
			'action'                 => 'key',
			'delay_between_requests' => 'positive_int',
			'nonce'                  => 'key',
		);
		$this->set_post_data( $key_rules );

		$this->settings['delay_between_requests'] = (int) $this->state_data['delay_between_requests'];
		$result                                   = update_site_option( 'wpmdb_settings', $this->settings );
		$this->end_ajax( $result );
	}

	static function is_json( $string, $strict = false ) {
		$json = @json_decode( $string, true );
		if ( $strict == true && ! is_array( $json ) ) {
			return false;
		}

		return ! ( $json == null || $json == false );
	}

	function get_sql_dump_info( $migration_type, $info_type ) {
		if ( empty( $this->session_salt ) ) {
			$this->session_salt = strtolower( wp_generate_password( 5, false, false ) );
		}
		$datetime  = date( 'YmdHis' );
		$ds        = ( $info_type == 'path' ? DIRECTORY_SEPARATOR : '/' );
		$dump_info = sprintf( '%s%s%s-%s-%s-%s.sql', $this->get_upload_info( $info_type ), $ds, sanitize_title_with_dashes( DB_NAME ), $migration_type, $datetime, $this->session_salt );

		return ( $info_type == 'path' ? $this->slash_one_direction( $dump_info ) : $dump_info );
	}

	/**
	 * Returns validated and sanitized form data.
	 *
	 * @param array|string $data
	 *
	 * @return array|string
	 */
	function parse_migration_form_data( $data ) {
		$form_data = parent::parse_migration_form_data( $data );

		$this->accepted_fields = apply_filters( 'wpmdb_accepted_profile_fields', $this->accepted_fields );
		$form_data             = array_intersect_key( $form_data, array_flip( $this->accepted_fields ) );
		unset( $form_data['replace_old'][0] );
		unset( $form_data['replace_new'][0] );

		if ( ! isset( $form_data['replace_old'] ) ) {
			$form_data['replace_old'] = array();
		}
		if ( ! isset( $form_data['replace_new'] ) ) {
			$form_data['replace_new'] = array();
		}

		if ( isset( $form_data['exclude_post_revisions'] ) ) {
			$form_data['exclude_post_types']  = '1';
			$form_data['select_post_types'][] = 'revision';
			$form_data['select_post_types']   = array_unique( $form_data['select_post_types'] );
			unset( $form_data['exclude_post_revisions'] );
		}

		return $form_data;
	}

	/**
	 * Adds settings link to plugin page
	 *
	 * @param  array $links
	 *
	 * @return array $links
	 */
	function plugin_action_links( $links ) {
		$link = sprintf( '<a href="%s">%s</a>', network_admin_url( $this->plugin_base ) . '#settings', _x( 'Settings', 'Plugin configuration and preferences', 'wp-migrate-db' ) );
		array_unshift( $links, $link );

		return $links;
	}

	function ajax_clear_log() {
		$this->check_ajax_referer( 'clear-log' );
		delete_site_option( 'wpmdb_error_log' );
		$result = $this->end_ajax();

		return $result;
	}

	function ajax_get_log() {
		$this->check_ajax_referer( 'get-log' );
		ob_start();
		$this->output_diagnostic_info();
		$this->output_log_file();
		$return = ob_get_clean();
		$result = $this->end_ajax( $return );

		return $result;
	}

	function output_log_file() {
		$this->load_error_log();
		if ( isset( $this->error_log ) ) {
			echo $this->error_log;
		}
	}

	/**
	 * Outputs diagnostic info for debugging.
	 *
	 * Outputs useful diagnostic info text at the Diagnostic Info & Error Log
	 * section under the Help tab so the information can be viewed or
	 * downloaded and shared for debugging.
	 *
	 * If you would like to add additional diagnostic information use the
	 * `wpmdb_diagnostic_info` action hook (see {@link https://developer.wordpress.org/reference/functions/add_action/}).
	 *
	 * <code>
	 * add_action( 'wpmdb_diagnostic_info', 'my_diagnostic_info' ) {
	 *     echo "Additional Diagnostic Info: \r\n";
	 *     echo "...\r\n";
	 * }
	 * </code>
	 *
	 * @return void
	 */
	function output_diagnostic_info() {
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;

		echo 'site_url(): ';
		echo esc_html( site_url() );
		echo "\r\n";

		echo 'home_url(): ';
		echo esc_html( home_url() );
		echo "\r\n";

		echo 'Database Name: ';
		echo esc_html( $wpdb->dbname );
		echo "\r\n";

		echo 'Table Prefix: ';
		echo esc_html( $table_prefix );
		echo "\r\n";

		echo 'WordPress: ';
		echo bloginfo( 'version' );
		if ( is_multisite() ) {
			echo ' Multisite';
		}
		echo "\r\n";

		echo 'Web Server: ';
		echo esc_html( ! empty( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE'] : '' );
		echo "\r\n";

		echo 'PHP: ';
		if ( function_exists( 'phpversion' ) ) {
			echo esc_html( phpversion() );
		}
		echo "\r\n";

		echo 'MySQL: ';
		echo esc_html( empty( $wpdb->use_mysqli ) ? mysql_get_server_info() : mysqli_get_server_info( $wpdb->dbh ) );
		echo "\r\n";

		echo 'ext/mysqli: ';
		echo empty( $wpdb->use_mysqli ) ? 'no' : 'yes';
		echo "\r\n";

		echo 'WP Memory Limit: ';
		echo esc_html( WP_MEMORY_LIMIT );
		echo "\r\n";

		echo 'Blocked External HTTP Requests: ';
		if ( ! defined( 'WP_HTTP_BLOCK_EXTERNAL' ) || ! WP_HTTP_BLOCK_EXTERNAL ) {
			echo 'None';
		} else {
			$accessible_hosts = ( defined( 'WP_ACCESSIBLE_HOSTS' ) ) ? WP_ACCESSIBLE_HOSTS : '';

			if ( empty( $accessible_hosts ) ) {
				echo 'ALL';
			} else {
				echo 'Partially (Accessible Hosts: ' . esc_html( $accessible_hosts ) . ')';
			}
		}
		echo "\r\n";

		echo 'WPMDB Bottleneck: ';
		echo esc_html( size_format( $this->get_bottleneck() ) );
		echo "\r\n";

		echo 'WP Locale: ';
		echo esc_html( get_locale() );
		echo "\r\n";

		echo 'DB Charset: ';
		echo esc_html( DB_CHARSET );
		echo "\r\n";

		if ( function_exists( 'ini_get' ) && $suhosin_limit = ini_get( 'suhosin.post.max_value_length' ) ) {
			echo 'Suhosin Post Max Value Length: ';
			echo esc_html( is_numeric( $suhosin_limit ) ? size_format( $suhosin_limit ) : $suhosin_limit );
			echo "\r\n";
		}

		if ( function_exists( 'ini_get' ) && $suhosin_limit = ini_get( 'suhosin.request.max_value_length' ) ) {
			echo 'Suhosin Request Max Value Length: ';
			echo esc_html( is_numeric( $suhosin_limit ) ? size_format( $suhosin_limit ) : $suhosin_limit );
			echo "\r\n";
		}

		echo 'Debug Mode: ';
		echo esc_html( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'Yes' : 'No' );
		echo "\r\n";

		echo 'WP Max Upload Size: ';
		echo esc_html( size_format( wp_max_upload_size() ) );
		echo "\r\n";

		echo 'PHP Post Max Size: ';
		echo esc_html( size_format( $this->get_post_max_size() ) );
		echo "\r\n";

		echo 'PHP Time Limit: ';
		if ( function_exists( 'ini_get' ) ) {
			echo esc_html( ini_get( 'max_execution_time' ) );
		}
		echo "\r\n";

		echo 'PHP Error Log: ';
		if ( function_exists( 'ini_get' ) ) {
			echo esc_html( ini_get( 'error_log' ) );
		}
		echo "\r\n";

		echo 'fsockopen: ';
		if ( function_exists( 'fsockopen' ) ) {
			echo 'Enabled';
		} else {
			echo 'Disabled';
		}
		echo "\r\n";

		echo 'OpenSSL: ';
		if ( $this->open_ssl_enabled() ) {
			echo esc_html( OPENSSL_VERSION_TEXT );
		} else {
			echo 'Disabled';
		}
		echo "\r\n";

		echo 'cURL: ';
		if ( function_exists( 'curl_init' ) ) {
			echo 'Enabled';
		} else {
			echo 'Disabled';
		}
		echo "\r\n";

		echo 'Enable SSL verification setting: ';
		if ( 1 == $this->settings['verify_ssl'] ) {
			echo 'Yes';
		} else {
			echo 'No';
		}
		echo "\r\n";

		echo 'Compatibility Mode: ';
		if ( isset( $GLOBALS['wpmdb_compatibility'] ) ) {
			echo 'Yes';
		} else {
			echo 'No';
		}
		echo "\r\n";

		echo 'Delay Between Requests: ';
		$delay_between_requests = $this->settings['delay_between_requests'];
		$delay_between_requests = $delay_between_requests > 0 ? $delay_between_requests / 1000 : $delay_between_requests;
		echo esc_html( $delay_between_requests ) . ' s';
		echo "\r\n\r\n";

		do_action( 'wpmdb_diagnostic_info' );
		if ( has_action( 'wpmdb_diagnostic_info' ) ) {
			echo "\r\n";
		}

		$theme_info = wp_get_theme();
		echo "Active Theme Name: " . esc_html( $theme_info->Name ) . "\r\n";
		echo "Active Theme Folder: " . esc_html( basename( $theme_info->get_stylesheet_directory() ) ) . "\r\n";
		if ( $theme_info->get( 'Template' ) ) {
			echo "Parent Theme Folder: " . esc_html( $theme_info->get( 'Template' ) ) . "\r\n";
		}
		if ( ! file_exists( $theme_info->get_stylesheet_directory() ) ) {
			echo "WARNING: Active Theme Folder Not Found\r\n";
		}

		echo "\r\n";

		echo "Active Plugins:\r\n";

		if ( isset( $GLOBALS['wpmdb_compatibility'] ) ) {
			remove_filter( 'option_active_plugins', 'wpmdbc_exclude_plugins' );
			remove_filter( 'site_option_active_sitewide_plugins', 'wpmdbc_exclude_site_plugins' );
			$blacklist = array_flip( (array) $this->settings['blacklist_plugins'] );
		} else {
			$blacklist = array();
		}

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$network_active_plugins = wp_get_active_network_plugins();
			$active_plugins         = array_map( array( $this, 'remove_wp_plugin_dir' ), $network_active_plugins );
		}

		foreach ( $active_plugins as $plugin ) {
			$suffix = ( isset( $blacklist[ $plugin ] ) ) ? '*' : '';
			$this->print_plugin_details( WP_PLUGIN_DIR . '/' . $plugin, $suffix );
		}

		if ( isset( $GLOBALS['wpmdb_compatibility'] ) ) {
			add_filter( 'option_active_plugins', 'wpmdbc_exclude_plugins' );
			add_filter( 'site_option_active_sitewide_plugins', 'wpmdbc_exclude_site_plugins' );
		}

		$mu_plugins = wp_get_mu_plugins();
		if ( $mu_plugins ) {
			echo "\r\n";

			echo "Must-use Plugins:\r\n";

			foreach ( $mu_plugins as $mu_plugin ) {
				$this->print_plugin_details( $mu_plugin );
			}
		}
	}

	function print_plugin_details( $plugin_path, $suffix = '' ) {
		$plugin_data = get_plugin_data( $plugin_path );
		if ( empty( $plugin_data['Name'] ) ) {
			return;
		}

		printf( "%s%s (v%s) by %s\r\n", $plugin_data['Name'], $suffix, $plugin_data['Version'], $plugin_data['AuthorName'] );
	}

	function remove_wp_plugin_dir( $name ) {
		$plugin = str_replace( WP_PLUGIN_DIR, '', $name );

		return substr( $plugin, 1 );
	}

	function get_alter_queries() {
		global $wpdb;
		$alter_table_name = $this->get_alter_table_name();
		$sql              = '';
		$alter_queries    = $wpdb->get_results( "SELECT * FROM `{$alter_table_name}`", ARRAY_A );

		$alter_queries = apply_filters( 'wpmdb_get_alter_queries', $alter_queries );

		if ( ! empty( $alter_queries ) ) {
			foreach ( $alter_queries as $alter_query ) {
				$sql .= $alter_query['query'] . "\n";
			}
		}

		return $sql;
	}

	function process_chunk( $chunk ) {
		// prepare db
		global $wpdb;
		$this->set_time_limit();

		$queries = array_filter( explode( ";\n", $chunk ) );
		array_unshift( $queries, "SET sql_mode='NO_AUTO_VALUE_ON_ZERO';" );

		ob_start();
		$wpdb->show_errors();

		if ( empty( $wpdb->charset ) ) {
			$charset       = ( defined( 'DB_CHARSET' ) ? DB_CHARSET : 'utf8' );
			$wpdb->charset = $charset;
			$wpdb->set_charset( $wpdb->dbh, $wpdb->charset );
		}

		foreach ( $queries as $query ) {
			if ( false === $wpdb->query( $query ) ) {
				$return = ob_get_clean();
				$return = array( 'wpmdb_error' => 1, 'body' => $return );
				$result = $this->end_ajax( json_encode( $return ) );

				return $result;
			}
		}

		return true;
	}

	/**
	 * Called for each database table to be migrated.
	 *
	 * @return string
	 */
	function ajax_migrate_table() {
		$this->check_ajax_referer( 'migrate-table' );

		$key_rules = array(
			'action'              => 'key',
			'migration_state_id'  => 'key',
			'table'               => 'string',
			'stage'               => 'key',
			'current_row'         => 'numeric',
			'last_table'          => 'string',
			'primary_keys'        => 'string',
			'gzip'                => 'int',
			'nonce'               => 'key',
			'bottleneck'          => 'positive_int',
			'prefix'              => 'string',
			'path_current_site'   => 'string',
			'domain_current_site' => 'text',
		);
		$this->set_post_data( $key_rules );

		global $wpdb;

		$this->form_data = $this->parse_migration_form_data( $this->state_data['form_data'] );

		$result = '';

		// checks if we're performing a backup, if so, continue with the backup and exit immediately after
		if ( $this->state_data['stage'] == 'backup' && $this->state_data['intent'] != 'savefile' ) {
			// if performing a push we need to backup the REMOTE machine's DB
			if ( $this->state_data['intent'] == 'push' ) {
				$data = $this->filter_post_elements(
					$this->state_data,
					array(
						'action',
						'remote_state_id',
						'url',
						'table',
						'form_data',
						'stage',
						'bottleneck',
						'prefix',
						'current_row',
						'last_table',
						'gzip',
						'primary_keys',
						'path_current_site',
						'domain_current_site',
					)
				);

				$data['action']       = 'wpmdb_backup_remote_table';
				$data['intent']       = 'pull';
				$data['sig']          = $this->create_signature( $data, $this->state_data['key'] );
				$data['primary_keys'] = addslashes( $data['primary_keys'] );
				$ajax_url             = $this->ajax_url();
				$response             = $this->remote_post( $ajax_url, $data, __FUNCTION__ );
				ob_start();
				$this->display_errors();
				$maybe_errors = ob_get_clean();

				if ( false === empty( $maybe_errors ) ) {
					$maybe_errors = array( 'wpmdb_error' => 1, 'body' => $maybe_errors );
					$return       = json_encode( $maybe_errors );
				} else {
					$return = $response;
				}
			} else {
				$return = $this->handle_table_backup();
			}

			$result = $this->end_ajax( $return );

			return $result;
		}

		// Pull and push need to be handled differently for obvious reasons, trigger different code depending on the migration intent (push or pull)
		if ( $this->state_data['intent'] == 'push' || $this->state_data['intent'] == 'savefile' ) {
			$this->maximum_chunk_size = $this->get_bottleneck();

			if ( isset( $this->state_data['bottleneck'] ) ) {
				$this->maximum_chunk_size = (int) $this->state_data['bottleneck'];
			}

			$sql_dump_file_name = $this->get_upload_info( 'path' ) . DIRECTORY_SEPARATOR;
			$sql_dump_file_name .= $this->format_dump_name( $this->state_data['dump_filename'] );

			if ( $this->state_data['intent'] == 'savefile' ) {
				$this->fp = $this->open( $sql_dump_file_name );
			}

			$db_version = '';
			if ( ! empty( $this->state_data['db_version'] ) ) {
				$db_version = $this->state_data['db_version'];

				if ( 'push' == $this->state_data['intent'] ) {
					// $db_version has been set to remote database's version.
					add_filter( 'wpmdb_create_table_query', array( $this, 'mysql_compat_filter' ), 10, 5 );
				} elseif ( 'savefile' == $this->state_data['intent'] && ! empty( $this->form_data['compatibility_older_mysql'] ) ) {
					// compatibility_older_mysql is currently a checkbox meaning pre-5.5 compatibility (we play safe and target 5.1),
					// this may change in the future to be a dropdown or radiobox returning the version to be compatible with.
					$db_version = '5.1';
					add_filter( 'wpmdb_create_table_query', array( $this, 'mysql_compat_filter' ), 10, 5 );
				}
			}

			if ( ! empty( $this->state_data['find_replace_pairs'] ) ) {
				$this->find_replace_pairs = $this->state_data['find_replace_pairs'];
			}

			ob_start();
			$result = $this->export_table( $this->state_data['table'], $db_version );

			if ( $this->state_data['intent'] == 'savefile' && isset( $this->fp ) ) {
				$this->close( $this->fp );
			}

			$this->display_errors();
			$maybe_errors = trim( ob_get_clean() );
			if ( false === empty( $maybe_errors ) ) {
				$return = array( 'wpmdb_error' => 1, 'body' => $maybe_errors );
				$result = $this->end_ajax( json_encode( $return ) );

				return $result;
			}

			return $result;
		} else {
			$data = $this->filter_post_elements(
				$this->state_data,
				array(
					'remote_state_id',
					'intent',
					'url',
					'table',
					'form_data',
					'stage',
					'bottleneck',
					'current_row',
					'last_table',
					'gzip',
					'primary_keys',
					'site_url',
					'find_replace_pairs',
				)
			);

			$data['action']     = 'wpmdb_process_pull_request';
			$data['pull_limit'] = $this->get_sensible_pull_limit();
			$data['db_version'] = $wpdb->db_version();

			if ( is_multisite() ) {
				$data['path_current_site']   = $this->get_path_current_site();
				$data['domain_current_site'] = $this->get_domain_current_site();
			}

			$data['prefix'] = $wpdb->base_prefix;

			if ( isset( $data['find_replace_pairs'] ) ) {
				$data['find_replace_pairs'] = serialize( $data['find_replace_pairs'] );
			}

			if ( isset( $data['sig'] ) ) {
				unset( $data['sig'] );
			}

			$data['sig']                = $this->create_signature( $data, $this->state_data['key'] );
			$data['primary_keys']       = addslashes( $data['primary_keys'] );
			$data['find_replace_pairs'] = addslashes( $data['find_replace_pairs'] );
			$ajax_url                   = $this->ajax_url();

			$response = $this->remote_post( $ajax_url, $data, __FUNCTION__ );
			ob_start();
			$this->display_errors();
			$maybe_errors = trim( ob_get_clean() );

			if ( false === empty( $maybe_errors ) ) {
				$return = array( 'wpmdb_error' => 1, 'body' => $maybe_errors );
				$result = $this->end_ajax( json_encode( $return ) );

				return $result;
			}

			if ( strpos( $response, ';' ) === false ) {
				$result = $this->end_ajax( $response );

				return $result;
			}

			// returned data is just a big string like this query;query;query;33
			// need to split this up into a chunk and row_tracker
			$row_information = trim( substr( strrchr( $response, "\n" ), 1 ) );
			$row_information = explode( ',', $row_information );
			$chunk           = substr( $response, 0, strrpos( $response, ";\n" ) + 1 );

			if ( ! empty( $chunk ) ) {
				$process_chunk_result = $this->process_chunk( $chunk );
				if ( true !== $process_chunk_result ) {
					$result = $this->end_ajax( $process_chunk_result );

					return $result;
				}
			}

			$result = array(
				'current_row'  => $row_information[0],
				'primary_keys' => $row_information[1],
			);

			$result = $this->end_ajax( json_encode( $result ) );
		}

		return $result;
	}

	/**
	 * Occurs right before the first table is migrated / backed up during the migration process.
	 *
	 * @return string
	 *
	 * Does a quick check to make sure the verification string is valid and also opens / creates files for writing to (if required).
	 */
	function ajax_initiate_migration() {
		global $wpdb;

		$this->check_ajax_referer( 'initiate-migration' );

		$key_rules = array(
			'action'       => 'key',
			'intent'       => 'key',
			'url'          => 'url',
			'key'          => 'string',
			'form_data'    => 'string',
			'stage'        => 'key',
			'nonce'        => 'key',
			'temp_prefix'  => 'string',
			'site_details' => 'json_array',
			'export_dest'  => 'string',
		);
		$this->set_post_data( $key_rules );

		$this->form_data = $this->parse_migration_form_data( $this->state_data['form_data'] );

		// A little bit of house keeping.
		WPMDB_Migration_State::cleanup();

		if ( $this->state_data['intent'] == 'savefile' ) {
			$return = array(
				'code'    => 200,
				'message' => 'OK',
				'body'    => json_encode( array( 'error' => 0 ) ),
			);

			$return['dump_path']        = $this->get_sql_dump_info( 'migrate', 'path' );
			$return['dump_filename']    = basename( $return['dump_path'] );
			$return['dump_url']         = $this->get_sql_dump_info( 'migrate', 'url' );
			$dump_filename_no_extension = substr( $return['dump_filename'], 0, -4 );

			$create_alter_table_query = $this->get_create_alter_table_query();
			// sets up our table to store 'ALTER' queries
			$process_chunk_result = $this->process_chunk( $create_alter_table_query );

			if ( true !== $process_chunk_result ) {
				$result = $this->end_ajax( $process_chunk_result );

				return $result;
			}

			if ( $this->gzip() && isset( $this->form_data['gzip_file'] ) && $this->form_data['gzip_file'] ) {
				$return['dump_path'] .= '.gz';
				$return['dump_filename'] .= '.gz';
				$return['dump_url'] .= '.gz';
			}

			$this->fp = $this->open( $this->get_upload_info( 'path' ) . DIRECTORY_SEPARATOR . $return['dump_filename'] );
			$this->db_backup_header();
			$this->close( $this->fp );

			$return['dump_filename'] = $dump_filename_no_extension;
		} else { // does one last check that our verification string is valid
			$data = array(
				'action'       => 'wpmdb_remote_initiate_migration',
				'intent'       => $this->state_data['intent'],
				'form_data'    => $this->state_data['form_data'],
				'site_details' => $this->state_data['site_details'],
			);

			$data['site_details'] = serialize( $data['site_details'] );

			$data['sig']          = $this->create_signature( $data, $this->state_data['key'] );
			$data['site_details'] = addslashes( $data['site_details'] );
			$ajax_url             = $this->ajax_url();
			$response             = $this->remote_post( $ajax_url, $data, __FUNCTION__ );

			if ( false === $response ) {
				$return = array( 'wpmdb_error' => 1, 'body' => $this->error );
				$result = $this->end_ajax( json_encode( $return ) );

				return $result;
			}

			$return = WPMDB_Utils::unserialize( $response, __METHOD__ );

			if ( false === $return ) {
				$error_msg = __( 'Failed attempting to unserialize the response from the remote server. Please contact support.', 'wp-migrate-db' );
				$return    = array( 'wpmdb_error' => 1, 'body' => $error_msg );
				$this->log_error( $error_msg, $response );
				$result = $this->end_ajax( json_encode( $return ) );

				return $result;
			}

			if ( isset( $return['error'] ) && $return['error'] == 1 ) {
				$return = array( 'wpmdb_error' => 1, 'body' => $return['message'] );
				$result = $this->end_ajax( json_encode( $return ) );

				return $result;
			}

			if ( $this->state_data['intent'] == 'pull' ) {
				// sets up our table to store 'ALTER' queries
				$create_alter_table_query = $this->get_create_alter_table_query();
				$process_chunk_result     = $this->process_chunk( $create_alter_table_query );
				if ( true !== $process_chunk_result ) {
					$result = $this->end_ajax( $process_chunk_result );

					return $result;
				}
			}

			if ( ! empty( $this->form_data['create_backup'] ) && $this->state_data['intent'] == 'pull' ) {
				$return['dump_filename'] = basename( $this->get_sql_dump_info( 'backup', 'path' ) );
				$return['dump_filename'] = substr( $return['dump_filename'], 0, -4 );
				$return['dump_url']      = $this->get_sql_dump_info( 'backup', 'url' );
			}
		}

		$return['dump_filename'] = ( empty( $return['dump_filename'] ) ) ? '' : $return['dump_filename'];
		$return['dump_url']      = ( empty( $return['dump_url'] ) ) ? '' : $return['dump_url'];

		// A successful call to wpmdb_remote_initiate_migration for a Push migration will have set db_version.
		// Otherwise ensure it is set with own db_version so that we always return one.
		$return['db_version'] = ( empty( $return['db_version'] ) ) ? $wpdb->db_version() : $return['db_version'];

		// A successful call to wpmdb_remote_initiate_migration for a Push migration will have set site_url.
		// Otherwise ensure it is set with own site_url so that we always return one.
		$return['site_url'] = ( empty( $return['site_url'] ) ) ? site_url() : $return['site_url'];

		$return['find_replace_pairs'] = $this->parse_find_replace_pairs( $this->state_data['intent'], $return['site_url'] );

		// Store current migration state and return its id.
		$state = array_merge( $this->state_data, $return );
		unset( $return );
		$return['migration_state_id'] = $this->migration_state->id();
		$return                       = $this->save_migration_state( $state, $return );

		$result = $this->end_ajax( json_encode( $return ) );

		return $result;
	}

	/**
	 * Handler for the ajax request to save a migration profile.
	 *
	 * @return bool|null
	 */
	function ajax_save_profile() {
		$this->check_ajax_referer( 'save-profile' );

		$key_rules = array(
			'action'  => 'key',
			'profile' => 'string',
			'nonce'   => 'key',
		);
		$this->set_post_data( $key_rules );

		$profile = $this->parse_migration_form_data( $this->state_data['profile'] );
		$profile = wp_parse_args( $profile, $this->checkbox_options );

		if ( isset( $profile['save_migration_profile_option'] ) && $profile['save_migration_profile_option'] == 'new' ) {
			$profile['name']              = $profile['create_new_profile'];
			$this->settings['profiles'][] = $profile;
		} else {
			$key                                        = $profile['save_migration_profile_option'];
			$name                                       = $this->settings['profiles'][ $key ]['name'];
			$this->settings['profiles'][ $key ]         = $profile;
			$this->settings['profiles'][ $key ]['name'] = $name;
		}

		update_site_option( 'wpmdb_settings', $this->settings );
		end( $this->settings['profiles'] );
		$key    = key( $this->settings['profiles'] );
		$result = $this->end_ajax( $key );

		return $result;
	}

	/**
	 * Handler for deleting a migration profile.
	 *
	 * @return bool|null
	 */
	function ajax_delete_migration_profile() {
		$this->check_ajax_referer( 'delete-migration-profile' );

		$key_rules = array(
			'action'     => 'key',
			'profile_id' => 'positive_int',
			'nonce'      => 'key',
		);
		$this->set_post_data( $key_rules );

		$key = absint( $this->state_data['profile_id'] );
		--$key;
		$return = '';

		if ( isset( $this->settings['profiles'][ $key ] ) ) {
			unset( $this->settings['profiles'][ $key ] );
			update_site_option( 'wpmdb_settings', $this->settings );
		} else {
			$return = '-1';
		}

		$result = $this->end_ajax( $return );

		return $result;
	}

	/**
	 * Handler for ajax request to save a setting, e.g. accept pull/push requests setting.
	 *
	 * @return bool|null
	 */
	function ajax_save_setting() {
		$this->check_ajax_referer( 'save-setting' );

		$key_rules = array(
			'action'  => 'key',
			'checked' => 'bool',
			'setting' => 'key',
			'nonce'   => 'key',
		);
		$this->set_post_data( $key_rules );

		$this->settings[ $this->state_data['setting'] ] = ( $this->state_data['checked'] == 'false' ) ? false : true;
		update_site_option( 'wpmdb_settings', $this->settings );
		$result = $this->end_ajax();

		return $result;
	}

	function format_table_sizes( $size ) {
		$size *= 1024;

		return size_format( $size );
	}

	/**
	 * Return array of post type slugs stored within DB.
	 *
	 * @return array List of post types
	 */
	function get_post_types() {
		global $wpdb;

		if ( is_multisite() ) {
			$tables         = $this->get_tables( 'prefix' );
			$sql            = "SELECT `post_type` FROM `{$wpdb->base_prefix}posts` ";
			$prefix_escaped = preg_quote( $wpdb->base_prefix, '/' );

			foreach ( $tables as $table ) {
				if ( 0 == preg_match( '/' . $prefix_escaped . '[0-9]+_posts/', $table ) ) {
					continue;
				}
				$blog_id = str_replace( array( $wpdb->base_prefix, '_posts' ), array( '', '' ), $table );
				$sql .= "UNION SELECT `post_type` FROM `{$wpdb->base_prefix}" . $blog_id . '_posts` ';
			}
			$sql .= ';';
			$post_types = $wpdb->get_results( $sql, ARRAY_A );
		} else {
			$post_types = $wpdb->get_results(
				"SELECT DISTINCT `post_type`
				FROM `{$wpdb->base_prefix}posts`
				WHERE 1;",
				ARRAY_A
			);
		}

		$return = array( 'revision' );

		foreach ( $post_types as $post_type ) {
			$return[] = $post_type['post_type'];
		}

		return apply_filters( 'wpmdb_post_types', array_unique( $return ) );
	}

	// Retrieves the specified profile, if -1, returns the default profile
	function get_profile( $profile_id ) {
		--$profile_id;

		if ( $profile_id == '-1' || ! isset( $this->settings['profiles'][ $profile_id ] ) ) {
			return $this->default_profile;
		}

		return $this->settings['profiles'][ $profile_id ];
	}

	/**
	 * Returns an array of table names with their associated row counts.
	 *
	 * @return array
	 */
	function get_table_row_count() {
		global $wpdb;

		$sql     = $wpdb->prepare( 'SELECT table_name, TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = %s ORDER BY table_name', DB_NAME );
		$results = $wpdb->get_results( $sql, ARRAY_A );

		$return = array();

		foreach ( $results as $result ) {
			if ( $this->get_legacy_alter_table_name() == $result['table_name'] ) {
				continue;
			}
			$return[ $result['table_name'] ] = ( $result['TABLE_ROWS'] == 0 ? 1 : $result['TABLE_ROWS'] );
		}

		return $return;
	}

	/**
	 * Returns an array of table names with associated size in kilobytes.
	 *
	 * @return mixed
	 *
	 * NOTE: Returned array may have been altered by wpmdb_table_sizes filter.
	 */
	function get_table_sizes() {
		global $wpdb;

		static $return;

		if ( ! empty( $return ) ) {
			return $return;
		}

		$return = array();

		$sql = $wpdb->prepare(
			"SELECT TABLE_NAME AS 'table',
			ROUND( ( data_length + index_length ) / 1024, 0 ) AS 'size'
			FROM INFORMATION_SCHEMA.TABLES
			WHERE INFORMATION_SCHEMA.TABLES.table_schema = %s
			AND INFORMATION_SCHEMA.TABLES.table_type = %s
			ORDER BY TABLE_NAME",
			DB_NAME,
			'BASE TABLE'
		);

		$results = $wpdb->get_results( $sql, ARRAY_A );

		if ( ! empty( $results ) ) {
			foreach ( $results as $result ) {
				if ( $this->get_legacy_alter_table_name() == $result['table'] ) {
					continue;
				}
				$return[ $result['table'] ] = $result['size'];
			}
		}

		// "regular" is passed to the filter as the scope for backwards compatibility (a possible but never used scope was "temp").
		return apply_filters( 'wpmdb_table_sizes', $return, 'regular' );
	}

	function format_dump_name( $dump_name ) {
		$extension = '.sql';
		$dump_name = sanitize_file_name( $dump_name );

		if ( $this->gzip() && isset( $this->form_data['gzip_file'] ) && $this->form_data['gzip_file'] ) {
			$extension .= '.gz';
		}

		return $dump_name . $extension;
	}

	function options_page() {
		$this->template( 'options' );
	}
	
	/**
	 * Load Tools HTML template for tools menu on sites in a Network to help users find WPMDB in Multisite
	 *
	 */
	function subsite_tools_options_page() {
		$this->template( 'options-tools-subsite' );
	}

	/**
	 * Get the remote site's base domain for subdomain multisite search/replace.
	 *
	 * @return string|bool The remote site's domain or false on error.
	 */
	function get_domain_replace() {
		$this->set_post_data();

		if ( ! isset( $this->domain_replace ) ) {
			if ( is_multisite() && ! empty( $this->state_data['domain_current_site'] ) ) {
				$this->domain_replace = $this->state_data['domain_current_site'];
			} elseif ( is_multisite() && ! empty( $this->form_data['replace_new'][1] ) ) {
				$url = $this->form_data['replace_new'][1];
				$url = $this->parse_url( $url );

				if ( isset( $url['host'] ) ) {
					$this->domain_replace = $url['host'];
				} else {
					$this->domain_replace = false;
				}
			} else {
				$this->domain_replace = false;
			}
		}

		return $this->domain_replace;
	}

	function process_sql_constraint( $create_query, $table, &$alter_table_query ) {
		if ( preg_match( '@CONSTRAINT|FOREIGN[\s]+KEY@', $create_query ) ) {
			$sql_constraints_query = '';

			$nl_nix = "\n";
			$nl_win = "\r\n";
			$nl_mac = "\r";

			if ( strpos( $create_query, $nl_win ) !== false ) {
				$crlf = $nl_win;
			} elseif ( strpos( $create_query, $nl_mac ) !== false ) {
				$crlf = $nl_mac;
			} else {
				$crlf = $nl_nix;
			}

			// Split the query into lines, so we can easily handle it.
			// We know lines are separated by $crlf (done few lines above).
			$sql_lines = explode( $crlf, $create_query );
			$sql_count = count( $sql_lines );

			// lets find first line with constraints
			for ( $i = 0; $i < $sql_count; $i++ ) {
				if ( preg_match(
					'@^[\s]*(CONSTRAINT|FOREIGN[\s]+KEY)@',
					$sql_lines[ $i ]
				) ) {
					break;
				}
			}

			// If we really found a constraint
			if ( $i != $sql_count ) {
				// remove, from the end of create statement
				$sql_lines[ $i - 1 ] = preg_replace(
					'@,$@',
					'',
					$sql_lines[ $i - 1 ]
				);

				// let's do the work
				$sql_constraints_query .= 'ALTER TABLE ' . $this->backquote( $table ) . $crlf;

				$first = true;
				for ( $j = $i; $j < $sql_count; $j++ ) {
					if ( preg_match(
						'@CONSTRAINT|FOREIGN[\s]+KEY@',
						$sql_lines[ $j ]
					) ) {
						if ( strpos( $sql_lines[ $j ], 'CONSTRAINT' ) === false ) {
							$tmp_str = preg_replace(
								'/(FOREIGN[\s]+KEY)/',
								'ADD \1',
								$sql_lines[ $j ]
							);
							$sql_constraints_query .= $tmp_str;
						} else {
							$tmp_str = preg_replace(
								'/(CONSTRAINT)/',
								'ADD \1',
								$sql_lines[ $j ]
							);
							$sql_constraints_query .= $tmp_str;
							preg_match(
								'/(CONSTRAINT)([\s])([\S]*)([\s])/',
								$sql_lines[ $j ],
								$matches
							);
						}
						$first = false;
					} else {
						break;
					}
				}

				$sql_constraints_query .= ";\n";

				$create_query = implode(
					                $crlf,
					                array_slice( $sql_lines, 0, $i )
				                )
				                . $crlf
				                . implode(
					                $crlf,
					                array_slice( $sql_lines, $j, $sql_count - 1 )
				                );
				unset( $sql_lines );

				$alter_table_query = $sql_constraints_query;

				return $create_query;
			}
		}

		return $create_query;
	}

	/**
	 * Taken partially from phpMyAdmin and partially from
	 * Alain Wolf, Zurich - Switzerland
	 * Website: http://restkultur.ch/personal/wolf/scripts/db_backup/
	 * Modified by Scott Merrill (http://www.skippy.net/)
	 * to use the WordPress $wpdb object
	 *
	 * @param string $table
	 * @param string $db_version
	 *
	 * @return mixed
	 */
	function export_table( $table, $db_version = '' ) {
		global $wpdb;
		$this->set_time_limit();
		$this->set_post_data();

		if ( empty( $this->form_data ) ) {
			$this->form_data = $this->parse_migration_form_data( $this->state_data['form_data'] );
		}

		$temp_prefix = ( isset( $this->state_data['temp_prefix'] ) ? $this->state_data['temp_prefix'] : $this->temp_prefix );

		$table_structure = $wpdb->get_results( 'DESCRIBE ' . $this->backquote( $table ) );

		if ( ! $table_structure ) {
			$this->error = __( 'Failed to retrieve table structure, please ensure your database is online. (#125)', 'wp-migrate-db' );

			return false;
		}

		$table_name        = $table;
		$site_details      = empty( $this->state_data['site_details'] ) ? array() : $this->state_data['site_details'];
		$target_table_name = apply_filters( 'wpmdb_target_table_name', $table_name, $this->form_data['action'], $this->state_data['stage'], $site_details );
		$table_name        = $target_table_name;

		if ( 'savefile' !== $this->form_data['action'] && 'backup' !== $this->state_data['stage'] ) {
			$table_name = $temp_prefix . $table_name;
		}

		$current_row = -1;

		if ( ! empty( $this->state_data['current_row'] ) ) {
			$temp_current_row = trim( $this->state_data['current_row'] );
			if ( ! empty( $temp_current_row ) ) {
				$current_row = (int) $temp_current_row;
			}
		}

		if ( $current_row == -1 ) {
			// Don't stow data until after `wpmdb_create_table_query` filter is applied as mysql_compat_filter() can return an error
			$stow = '';

			// Add SQL statement to drop existing table
			if ( $this->form_data['action'] == 'savefile' || $this->state_data['stage'] == 'backup' ) {
				$stow .= ( "\n\n" );
				$stow .= ( "#\n" );
				$stow .= ( '# ' . sprintf( __( 'Delete any existing table %s', 'wp-migrate-db' ), $this->backquote( $table_name ) ) . "\n" );
				$stow .= ( "#\n" );
				$stow .= ( "\n" );
			}
			$stow .= ( 'DROP TABLE IF EXISTS ' . $this->backquote( $table_name ) . ";\n" );

			// Table structure
			// Comment in SQL-file
			if ( $this->form_data['action'] == 'savefile' || $this->state_data['stage'] == 'backup' ) {
				$stow .= ( "\n\n" );
				$stow .= ( "#\n" );
				$stow .= ( '# ' . sprintf( __( 'Table structure of table %s', 'wp-migrate-db' ), $this->backquote( $table_name ) ) . "\n" );
				$stow .= ( "#\n" );
				$stow .= ( "\n" );
			}

			$create_table = $wpdb->get_results( 'SHOW CREATE TABLE ' . $this->backquote( $table ), ARRAY_N );

			if ( false === $create_table ) {
				$this->error = __( 'Failed to generate the create table query, please ensure your database is online. (#126)', 'wp-migrate-db' );

				return false;
			}
			$create_table[0][1] = str_replace( 'CREATE TABLE `' . $table . '`', 'CREATE TABLE `' . $table_name . '`', $create_table[0][1] );

			$create_table[0][1] = str_replace( 'TYPE=', 'ENGINE=', $create_table[0][1] );

			$alter_table_query  = '';
			$create_table[0][1] = $this->process_sql_constraint( $create_table[0][1], $target_table_name, $alter_table_query );

			$create_table[0][1] = apply_filters( 'wpmdb_create_table_query', $create_table[0][1], $table_name, $db_version, $this->form_data['action'], $this->state_data['stage'] );
			$stow .= ( $create_table[0][1] . ";\n" );

			$this->stow( $stow );

			if ( ! empty( $alter_table_query ) ) {
				$alter_table_name = $this->get_alter_table_name();
				$insert           = sprintf( "INSERT INTO %s ( `query` ) VALUES ( '%s' );\n", $this->backquote( $alter_table_name ), esc_sql( $alter_table_query ) );
				if ( $this->form_data['action'] == 'savefile' || $this->state_data['stage'] == 'backup' ) {
					$process_chunk_result = $this->process_chunk( $insert );
					if ( true !== $process_chunk_result ) {
						$result = $this->end_ajax( $process_chunk_result );

						return $result;
					}
				} else {
					$this->stow( $insert );
				}
			}

			$alter_data_queries = array();
			$alter_data_queries = apply_filters( 'wpmdb_alter_data_queries', $alter_data_queries, $table_name, $this->form_data['action'], $this->state_data['stage'] );

			if ( ! empty( $alter_data_queries ) ) {
				$alter_table_name = $this->get_alter_table_name();
				$insert           = '';
				foreach ( $alter_data_queries as $alter_data_query ) {
					$insert .= sprintf( "INSERT INTO %s ( `query` ) VALUES ( '%s' );\n", $this->backquote( $alter_table_name ), esc_sql( $alter_data_query ) );
				}
				if ( 'savefile' == $this->form_data['action'] || 'backup' == $this->state_data['stage'] ) {
					$process_chunk_result = $this->process_chunk( $insert );
					if ( true !== $process_chunk_result ) {
						$result = $this->end_ajax( $process_chunk_result );

						return $result;
					}
				} else {
					$this->stow( $insert );
				}
			}

			// Comment in SQL-file
			if ( $this->form_data['action'] == 'savefile' || $this->state_data['stage'] == 'backup' ) {
				$this->stow( "\n\n" );
				$this->stow( "#\n" );
				$this->stow( '# ' . sprintf( __( 'Data contents of table %s', 'wp-migrate-db' ), $this->backquote( $table_name ) ) . "\n" );
				$this->stow( "#\n" );
			}
		}

		// $defs = mysql defaults, looks up the default for that particular column, used later on to prevent empty inserts values for that column
		// $ints = holds a list of the possible integer types so as to not wrap them in quotation marks later in the insert statements
		$defs = array();
		$ints = array();
		$bins = array();
		$bits = array();
		foreach ( $table_structure as $struct ) {
			if ( ( 0 === strpos( $struct->Type, 'tinyint' ) ) ||
			     ( 0 === strpos( strtolower( $struct->Type ), 'smallint' ) ) ||
			     ( 0 === strpos( strtolower( $struct->Type ), 'mediumint' ) ) ||
			     ( 0 === strpos( strtolower( $struct->Type ), 'int' ) ) ||
			     ( 0 === strpos( strtolower( $struct->Type ), 'bigint' ) )
			) {
				$defs[ strtolower( $struct->Field ) ] = ( null === $struct->Default ) ? 'NULL' : $struct->Default;
				$ints[ strtolower( $struct->Field ) ] = '1';
			} elseif ( 0 === strpos( $struct->Type, 'binary' ) ) {
				$bins[ strtolower( $struct->Field ) ] = '1';
			} elseif ( 0 === strpos( $struct->Type, 'bit' ) ) {
				$bits[ strtolower( $struct->Field ) ] = '1';
			}
		}

		// Batch by $row_inc

		$row_inc   = $this->rows_per_segment;
		$row_start = 0;
		if ( $current_row != -1 ) {
			$row_start = $current_row;
		}

		$this->row_tracker = $row_start;

		// \x08\\x09, not required
		$multibyte_search  = array( "\x00", "\x0a", "\x0d", "\x1a" );
		$multibyte_replace = array( '\0', '\n', '\r', '\Z' );

		$query_size = 0;

		$this->primary_keys = array();
		$field_set          = array();
		$use_primary_keys   = true;

		foreach ( $table_structure as $col ) {
			$field_set[] = $this->backquote( $col->Field );
			if ( $col->Key == 'PRI' && true == $use_primary_keys ) {
				if ( false === strpos( $col->Type, 'int' ) ) {
					$use_primary_keys   = false;
					$this->primary_keys = array();
					continue;
				}
				$this->primary_keys[ $col->Field ] = 0;
			}
		}

		$first_select = true;
		if ( ! empty( $this->state_data['primary_keys'] ) ) {
			$this->state_data['primary_keys'] = trim( $this->state_data['primary_keys'] );
			$this->primary_keys = WPMDB_Utils::unserialize( stripslashes( $this->state_data['primary_keys'] ), __METHOD__ );
			if ( false !== $this->primary_keys && ! empty( $this->state_data['primary_keys'] ) ) {
				$first_select       = false;
			}
		}

		$fields = implode( ', ', $field_set );

		$insert_buffer = $insert_query_template = 'INSERT INTO ' . $this->backquote( $table_name ) . ' ( ' . $fields . ") VALUES\n";

		do {
			$join     = array();
			$where    = 'WHERE 1=1';
			$order_by = '';
			// We need ORDER BY here because with LIMIT, sometimes it will return
			// the same results from the previous query and we'll have duplicate insert statements
			if ( 'backup' != $this->state_data['stage'] && false === empty( $this->form_data['exclude_spam'] ) ) {
				if ( $this->table_is( 'comments', $table ) ) {
					$where .= ' AND comment_approved != "spam"';
				} elseif ( $this->table_is( 'commentmeta', $table ) ) {
					$tables = $this->get_ms_compat_table_names( array( 'commentmeta', 'comments' ), $table );
					$join[] = sprintf( 'INNER JOIN %1$s ON %1$s.comment_ID = %2$s.comment_id', $this->backquote( $tables['comments_table'] ), $this->backquote( $tables['commentmeta_table'] ) );
					$where .= sprintf( ' AND %1$s.comment_approved != \'spam\'', $this->backquote( $tables['comments_table'] ) );
				}
			}

			if ( 'backup' != $this->state_data['stage'] && isset( $this->form_data['exclude_post_types'] ) && ! empty( $this->form_data['select_post_types'] ) ) {
				$post_types = '\'' . implode( '\', \'', $this->form_data['select_post_types'] ) . '\'';
				if ( $this->table_is( 'posts', $table ) ) {
					$where .= ' AND `post_type` NOT IN ( ' . $post_types . ' )';
				} elseif ( $this->table_is( 'postmeta', $table ) ) {
					$tables = $this->get_ms_compat_table_names( array( 'postmeta', 'posts' ), $table );
					$join[] = sprintf( 'INNER JOIN %1$s ON %1$s.ID = %2$s.post_id', $this->backquote( $tables['posts_table'] ), $this->backquote( $tables['postmeta_table'] ) );
					$where .= sprintf( ' AND %1$s.post_type NOT IN ( ' . $post_types . ' )', $this->backquote( $tables['posts_table'] ) );
				} elseif ( $this->table_is( 'comments', $table ) ) {
					$tables = $this->get_ms_compat_table_names( array( 'comments', 'posts' ), $table );
					$join[] = sprintf( 'INNER JOIN %1$s ON %1$s.ID = %2$s.comment_post_ID', $this->backquote( $tables['posts_table'] ), $this->backquote( $tables['comments_table'] ) );
					$where .= sprintf( ' AND %1$s.post_type NOT IN ( ' . $post_types . ' )', $this->backquote( $tables['posts_table'] ) );
				} elseif ( $this->table_is( 'commentmeta', $table ) ) {
					$tables = $this->get_ms_compat_table_names( array( 'commentmeta', 'posts', 'comments' ), $table );
					$join[] = sprintf( 'INNER JOIN %1$s ON %1$s.comment_ID = %2$s.comment_id', $this->backquote( $tables['comments_table'] ), $this->backquote( $tables['commentmeta_table'] ) );
					$join[] = sprintf( 'INNER JOIN %2$s ON %2$s.ID = %1$s.comment_post_ID', $this->backquote( $tables['comments_table'] ), $this->backquote( $tables['posts_table'] ) );
					$where .= sprintf( ' AND %1$s.post_type NOT IN ( ' . $post_types . ' )', $this->backquote( $tables['posts_table'] ) );
				}
			}

			if ( 'backup' != $this->state_data['stage'] && true === apply_filters( 'wpmdb_exclude_transients', true ) && isset( $this->form_data['exclude_transients'] ) && '1' === $this->form_data['exclude_transients'] && ( $this->table_is( 'options', $table ) || ( isset( $wpdb->sitemeta ) && $wpdb->sitemeta == $table ) ) ) {
				$col_name = 'option_name';

				if ( isset( $wpdb->sitemeta ) && $wpdb->sitemeta == $table ) {
					$col_name = 'meta_key';
				}

				$where .= " AND `{$col_name}` NOT LIKE '\_transient\_%' AND `{$col_name}` NOT LIKE '\_site\_transient\_%'";
			}

			// don't export/migrate wpmdb specific option rows unless we're performing a backup
			if ( 'backup' != $this->state_data['stage'] && ( $this->table_is( 'options', $table ) || ( isset( $wpdb->sitemeta ) && $wpdb->sitemeta == $table ) ) ) {
				$col_name = 'option_name';

				if ( isset( $wpdb->sitemeta ) && $wpdb->sitemeta == $table ) {
					$col_name = 'meta_key';
				}

				$where .= " AND `{$col_name}` != 'wpmdb_settings'";
				$where .= " AND `{$col_name}` != 'wpmdb_error_log'";
				$where .= " AND `{$col_name}` != 'wpmdb_schema_version'";
				$where .= " AND `{$col_name}` NOT LIKE 'wpmdb_state_%'";
			}

			$limit = "LIMIT {$row_start}, {$row_inc}";

			if ( ! empty( $this->primary_keys ) ) {
				$primary_keys_keys = array_keys( $this->primary_keys );
				$primary_keys_keys = array_map( array( $this, 'backquote' ), $primary_keys_keys );

				$order_by = 'ORDER BY ' . implode( ',', $primary_keys_keys );
				$limit    = "LIMIT $row_inc";

				if ( false == $first_select ) {
					$where .= ' AND ';

					$temp_primary_keys = $this->primary_keys;
					$primary_key_count = count( $temp_primary_keys );

					// build a list of clauses, iteratively reducing the number of fields compared in the compound key
					// e.g. (a = 1 AND b = 2 AND c > 3) OR (a = 1 AND b > 2) OR (a > 1)
					$clauses = array();
					for ( $j = 0; $j < $primary_key_count; $j++ ) {
						// build a subclause for each field in the compound index
						$subclauses = array();
						$i          = 0;
						foreach ( $temp_primary_keys as $primary_key => $value ) {
							// only the last field in the key should be different in this subclause
							$operator     = ( count( $temp_primary_keys ) - 1 == $i ? '>' : '=' );
							$subclauses[] = sprintf( '%s %s %s', $this->backquote( $primary_key ), $operator, $wpdb->prepare( '%s', $value ) );
							++$i;
						}

						// remove last field from array to reduce fields in next clause
						array_pop( $temp_primary_keys );

						// join subclauses into a single clause
						// NB: AND needs to be wrapped in () as it has higher precedence than OR
						$clauses[] = '( ' . implode( ' AND ', $subclauses ) . ' )';
					}
					// join clauses into a single clause
					// NB: OR needs to be wrapped in () as it has lower precedence than AND
					$where .= '( ' . implode( ' OR ', $clauses ) . ' )';
				}

				$first_select = false;
			}

			$sel = $this->backquote( $table ) . '.*';
			if ( ! empty( $bins ) ) {
				foreach ( $bins as $key => $bin ) {
					$hex_key = strtolower( $key ) . '__hex';
					$sel .= ', HEX(' . $this->backquote( $key ) . ') as ' . $this->backquote( $hex_key );
				}
			}
			if ( ! empty( $bits ) ) {
				foreach ( $bits as $key => $bit ) {
					$bit_key = strtolower( $key ) . '__bit';
					$sel .= ', ' . $this->backquote( $key ) . '+0 as ' . $this->backquote( $bit_key );
				}
			}
			$join     = implode( ' ', array_unique( $join ) );
			$join     = apply_filters( 'wpmdb_rows_join', $join, $table );
			$where    = apply_filters( 'wpmdb_rows_where', $where, $table );
			$order_by = apply_filters( 'wpmdb_rows_order_by', $order_by, $table );
			$limit    = apply_filters( 'wpmdb_rows_limit', $limit, $table );

			$sql = 'SELECT ' . $sel . ' FROM ' . $this->backquote( $table ) . " $join $where $order_by $limit";
			$sql = apply_filters( 'wpmdb_rows_sql', $sql, $table );

			$table_data = $wpdb->get_results( $sql );

			if ( $table_data ) {
				$to_search  = isset( $this->find_replace_pairs['replace_old'] ) ? $this->find_replace_pairs['replace_old'] : '';
				$to_replace = isset( $this->find_replace_pairs['replace_new'] ) ? $this->find_replace_pairs['replace_new'] : '';
				$replacer   = new WPMDB_Replace( array(
					'table'       => $table,
					'search'      => $to_search,
					'replace'     => $to_replace,
					'intent'      => $this->state_data['intent'],
					'base_domain' => $this->get_domain_replace(),
					'site_domain' => $this->get_domain_current_site(),
					'wpmdb'       => $this,
				) );

				foreach ( $table_data as $row ) {
					$skip_row = false;

					if ( ! apply_filters( 'wpmdb_table_row', $row, $table, $this->form_data['action'], $this->state_data['stage'] ) ) {
						$skip_row = true;
					}

					if ( ! $skip_row ) {
						$replacer->set_row( $row );
						$values = array();

						foreach ( $row as $key => $value ) {
							$replacer->set_column( $key );

							if ( isset( $ints[ strtolower( $key ) ] ) && $ints[ strtolower( $key ) ] ) {
								// make sure there are no blank spots in the insert syntax,
								// yet try to avoid quotation marks around integers
								$value    = ( null === $value || '' === $value ) ? $defs[ strtolower( $key ) ] : $value;
								$values[] = ( '' === $value ) ? "''" : $value;
								continue;
							}

							if ( null === $value ) {
								$values[] = 'NULL';
								continue;
							}

							// If we have binary data, substitute in hex encoded version and remove hex encoded version from row.
							$hex_key = strtolower( $key ) . '__hex';
							if ( isset( $bins[ strtolower( $key ) ] ) && $bins[ strtolower( $key ) ] && isset( $row->$hex_key ) ) {
								$value    = "UNHEX('" . $row->$hex_key . "')";
								$values[] = $value;
								unset( $row->$hex_key );
								continue;
							}

							// If we have bit data, substitute in properly bit encoded version.
							$bit_key = strtolower( $key ) . '__bit';
							if ( isset( $bits[ strtolower( $key ) ] ) && $bits[ strtolower( $key ) ] && isset( $row->$bit_key ) ) {
								$value    = "b'" . $row->$bit_key . "'";
								$values[] = $value;
								unset( $row->$bit_key );
								continue;
							}

							if ( is_multisite() && 'path' == $key && $this->state_data['stage'] != 'backup' && ( $wpdb->site == $table || $wpdb->blogs == $table ) ) {
								$old_path_current_site = $this->get_path_current_site();
								$new_path_current_site = '';

								if ( ! empty( $this->state_data['path_current_site'] ) ) {
									$new_path_current_site = $this->state_data['path_current_site'];
								} elseif ( ! empty ( $this->form_data['replace_new'][1] ) ) {
									$new_path_current_site = $this->get_path_from_url( $this->form_data['replace_new'][1] );
								}

								$new_path_current_site = apply_filters( 'wpmdb_new_path_current_site', $new_path_current_site );

								if ( ! empty( $new_path_current_site ) && $old_path_current_site != $new_path_current_site ) {
									$pos   = strpos( $value, $old_path_current_site );
									$value = substr_replace( $value, $new_path_current_site, $pos, strlen( $old_path_current_site ) );
								}
							}

							if ( is_multisite() && 'domain' == $key && $this->state_data['stage'] != 'backup' && ( $wpdb->site == $table || $wpdb->blogs == $table ) ) {
								if ( ! empty( $this->state_data['domain_current_site'] ) ) {
									$main_domain_replace = $this->state_data['domain_current_site'];
								} elseif ( ! empty ( $this->form_data['replace_new'][1] ) ) {
									$url                 = $this->parse_url( $this->form_data['replace_new'][1] );
									$main_domain_replace = $url['host'];
								}

								$domain_replaces  = array();
								$main_domain_find = sprintf( '/%s/', preg_quote( $this->get_domain_current_site(), '/' ) );
								if ( isset( $main_domain_replace ) ) {
									$domain_replaces[ $main_domain_find ] = $main_domain_replace;
								}

								$domain_replaces = apply_filters( 'wpmdb_domain_replaces', $domain_replaces );

								$value = preg_replace( array_keys( $domain_replaces ), array_values( $domain_replaces ), $value );
							}

							if ( 'guid' != $key || ( false === empty( $this->form_data['replace_guids'] ) && $this->table_is( 'posts', $table ) ) ) {
								if ( $this->state_data['stage'] != 'backup' ) {
									$value = $replacer->recursive_unserialize_replace( $value );
								}
							}

							$value = $this->sql_addslashes( $value );
							$value = str_replace( $multibyte_search, $multibyte_replace, $value );

							$values[] = "'" . $value . "'";
						}

						$insert_line = '(' . implode( ', ', $values ) . '),';
						$insert_line .= "\n";
					} else {
						$insert_line = '';
					}

					if ( ( strlen( $this->current_chunk ) + strlen( $insert_line ) + strlen( $insert_buffer ) + 30 ) > $this->maximum_chunk_size ) {
						if ( $insert_buffer == $insert_query_template ) {
							$insert_buffer .= $insert_line;

							++$this->row_tracker;

							if ( ! empty( $this->primary_keys ) ) {
								foreach ( $this->primary_keys as $primary_key => $value ) {
									$this->primary_keys[ $primary_key ] = $row->$primary_key;
								}
							}
						}

						$insert_buffer = rtrim( $insert_buffer, "\n," );
						$insert_buffer .= " ;\n";
						$this->stow( $insert_buffer );
						$insert_buffer = $insert_query_template;
						$query_size    = 0;

						return $this->transfer_chunk();
					}

					if ( ( $query_size + strlen( $insert_line ) ) > $this->max_insert_string_len && $insert_buffer != $insert_query_template ) {
						$insert_buffer = rtrim( $insert_buffer, "\n," );
						$insert_buffer .= " ;\n";
						$this->stow( $insert_buffer );
						$insert_buffer = $insert_query_template;
						$query_size    = 0;
					}

					$insert_buffer .= $insert_line;
					$query_size += strlen( $insert_line );

					++$this->row_tracker;

					if ( ! empty( $this->primary_keys ) ) {
						foreach ( $this->primary_keys as $primary_key => $value ) {
							$this->primary_keys[ $primary_key ] = $row->$primary_key;
						}
					}
				}

				$row_start += $row_inc;

				if ( $insert_buffer != $insert_query_template ) {
					$insert_buffer = rtrim( $insert_buffer, "\n," );
					$insert_buffer .= " ;\n";
					$this->stow( $insert_buffer );
					$insert_buffer = $insert_query_template;
					$query_size    = 0;
				}
			}
		} while ( count( $table_data ) > 0 );

		// Create footer/closing comment in SQL-file
		if ( 'savefile' == $this->form_data['action'] || 'backup' == $this->state_data['stage'] ) {
			$this->stow( "\n" );
			$this->stow( "#\n" );
			$this->stow( '# ' . sprintf( __( 'End of data contents of table %s', 'wp-migrate-db' ), $this->backquote( $table_name ) ) . "\n" );
			$this->stow( "# --------------------------------------------------------\n" );
			$this->stow( "\n" );

			if ( $this->state_data['last_table'] == '1' ) {
				$this->stow( "#\n" );
				$this->stow( "# Add constraints back in and apply any alter data queries.\n" );
				$this->stow( "#\n\n" );
				$this->stow( $this->get_alter_queries() );
				$alter_table_name = $this->get_alter_table_name();

				$wpdb->query( 'DROP TABLE IF EXISTS ' . $this->backquote( $alter_table_name ) . ';' );

				if ( 'backup' == $this->state_data['stage'] ) {
					// Re-create our table to store 'ALTER' queries so we don't get duplicates.
					$create_alter_table_query = $this->get_create_alter_table_query();
					$process_chunk_result     = $this->process_chunk( $create_alter_table_query );
					if ( true !== $process_chunk_result ) {
						$result = $this->end_ajax( $process_chunk_result );

						return $result;
					}
				}
			}
		}

		$this->row_tracker = -1;

		return $this->transfer_chunk();
	} // end export_table()

	/**
	 * Check that the given table is of the desired type,
	 * including single and multisite installs.
	 * eg: wp_posts, wp_2_posts
	 *
	 * The scope argument can take one of the following:
	 *
	 * 'table' - Match on the un-prefixed table name, this is the default.
	 * 'all' - Match on 'blog' and 'global' tables. No old tables are returned.
	 * 'blog' - Match the blog-level tables for the queried blog.
	 * 'global' - Match the global tables for the installation, matching multisite tables only if running multisite.
	 * 'ms_global' - Match the multisite global tables, regardless if current installation is multisite.
	 * 'non_ms_global' - Match the non multisite global tables, regardless if current installation is multisite.
	 * 'old' - Matches tables which are deprecated.
	 *
	 * @param string $desired_table Can be empty to match on tables from scopes other than 'table'.
	 * @param string $given_table
	 * @param string $scope         Optional type of table to match against, default is 'table'.
	 * @param string $new_prefix    Optional new prefix already added to $given_table.
	 * @param int    $blog_id       Optional Only used with 'blog' scope to test against a specific subsite's tables other than current for $wpdb.
	 *
	 * @return boolean
	 */
	function table_is( $desired_table, $given_table, $scope = 'table', $new_prefix = '', $blog_id = 0 ) {
		global $wpdb;

		$scopes = array( 'all', 'blog', 'global', 'ms_global', 'non_ms_global', 'old' );

		if ( ! in_array( $scope, $scopes ) ) {
			$scope = 'table';
		}

		if ( empty( $desired_table ) && 'table' === $scope ) {
			return false;
		}

		if ( ! empty( $new_prefix ) && 0 === stripos( $given_table, $new_prefix ) ) {
			$given_table = substr_replace( $given_table, $wpdb->base_prefix, 0, strlen( $new_prefix ) );
		}

		$match                 = false;
		$prefix_escaped        = preg_quote( $wpdb->base_prefix, '/' );
		$desired_table_escaped = preg_quote( $desired_table, '/' );

		if ( 'table' === $scope ) {
			if ( $wpdb->{$desired_table} == $given_table ||
			     preg_match( '/' . $prefix_escaped . '[0-9]+_' . $desired_table_escaped . '/', $given_table )
			) {
				$match = true;
			}
		} else {
			if ( 'non_ms_global' === $scope ) {
				$tables = array_diff_key( $wpdb->tables( 'global', true, $blog_id ), $wpdb->tables( 'ms_global', true, $blog_id ) );
			} else {
				$tables = $wpdb->tables( $scope, true, $blog_id );
			}

			if ( ! empty( $desired_table ) ) {
				$tables = array_intersect_key( $tables, array( $desired_table => '' ) );
			}

			if ( ! empty( $tables ) ) {
				foreach ( $tables as $table_name ) {
					if ( ! empty( $table_name ) && strtolower( $table_name ) === strtolower( $given_table ) ) {
						$match = true;
						break;
					}
				}
			}
		}

		return $match;
	}

	/**
	 * Return multisite-compatible names for requested
	 * tables, based on queried table name
	 *
	 * @param array  $tables        List of table names required
	 * @param string $queried_table Name of table from which to derive the blog ID
	 *
	 * @return array List of table names altered for multisite compatibility
	 */
	function get_ms_compat_table_names( $tables, $queried_table ) {
		global $wpdb;

		// default table prefix
		$prefix         = $wpdb->base_prefix;
		$prefix_escaped = preg_quote( $prefix, '/' );

		// if multisite, extract blog ID from queried table name and add to prefix
		// won't match for primary blog because it uses standard table names, i.e. blog_id will never be 1
		if ( is_multisite() && preg_match( '/^' . $prefix_escaped . '([0-9]+)_/', $queried_table, $matches ) ) {
			$blog_id = $matches[1];
			$prefix .= $blog_id . '_';
		}

		// build table names
		$ms_compat_table_names = array();

		foreach ( $tables as $table ) {
			$ms_compat_table_names[ $table . '_table' ] = $prefix . $table;
		}

		return $ms_compat_table_names;
	}

	function db_backup_header() {
		$charset = ( defined( 'DB_CHARSET' ) ? DB_CHARSET : 'utf8' );
		$this->stow( '# ' . __( 'WordPress MySQL database migration', 'wp-migrate-db' ) . "\n", false );
		$this->stow( "#\n", false );
		$this->stow( '# ' . sprintf( __( 'Generated: %s', 'wp-migrate-db' ), date( 'l j. F Y H:i T' ) ) . "\n", false );
		$this->stow( '# ' . sprintf( __( 'Hostname: %s', 'wp-migrate-db' ), DB_HOST ) . "\n", false );
		$this->stow( '# ' . sprintf( __( 'Database: %s', 'wp-migrate-db' ), $this->backquote( DB_NAME ) ) . "\n", false );
		$this->stow( "# --------------------------------------------------------\n\n", false );
		$this->stow( "/*!40101 SET NAMES $charset */;\n\n", false );
		$this->stow( "SET sql_mode='NO_AUTO_VALUE_ON_ZERO';\n\n", false );
	}

	function gzip() {
		return function_exists( 'gzopen' );
	}

	function open( $filename = '', $mode = 'a' ) {
		if ( '' == $filename ) {
			return false;
		}

		if ( $this->gzip() && isset( $this->form_data['gzip_file'] ) && $this->form_data['gzip_file'] ) {
			$fp = gzopen( $filename, $mode );
		} else {
			$fp = fopen( $filename, $mode );
		}

		return $fp;
	}

	function close( $fp ) {
		if ( $this->gzip() && isset( $this->form_data['gzip_file'] ) && $this->form_data['gzip_file'] ) {
			gzclose( $fp );
		} else {
			fclose( $fp );
		}

		unset( $this->fp );
	}

	/**
	 * Write query line to chunk, file pointer, or buffer depending on migration stage/action.
	 *
	 * @param string $query_line
	 * @param bool   $replace
	 *
	 * @return bool
	 */
	function stow( $query_line, $replace = true ) {
		$this->set_post_data();
		$this->current_chunk .= $query_line;

		if ( 0 === strlen( $query_line ) ) {
			return true;
		}

		if ( $this->form_data['action'] == 'savefile' || $this->state_data['stage'] == 'backup' ) {
			if ( $this->gzip() && isset( $this->form_data['gzip_file'] ) && $this->form_data['gzip_file'] ) {
				if ( ! @gzwrite( $this->fp, $query_line ) ) {
					$this->error = __( 'Failed to write the gzipped SQL data to the file. (#127)', 'wp-migrate-db' );

					return false;
				}
			} else {
				// TODO: Use WP_Filesystem API.
				if ( false === @fwrite( $this->fp, $query_line ) ) {
					$this->error = __( 'Failed to write the SQL data to the file. (#128)', 'wp-migrate-db' );

					return false;
				}
			}
		} elseif ( $this->state_data['intent'] == 'pull' ) {
			echo apply_filters( 'wpmdb_before_response', $query_line );
		}
	}

	/**
	 * Called once our chunk buffer is full, will transfer the SQL to the remote server for importing
	 *
	 * @return array|void
	 */
	function transfer_chunk() {
		$this->set_post_data();

		if ( $this->state_data['intent'] == 'savefile' || $this->state_data['stage'] == 'backup' ) {
			$this->close( $this->fp );

			$result = array(
				'current_row'  => $this->row_tracker,
				'primary_keys' => serialize( $this->primary_keys ),
			);

			if ( $this->state_data['intent'] == 'savefile' && $this->state_data['last_table'] == '1' ) {
				$result['dump_filename'] = $this->state_data['dump_filename'];
				$result['dump_path']     = $this->state_data['dump_path'];
			}

			$result = $this->end_ajax( json_encode( $result ) );

			return $result;
		}

		if ( $this->state_data['intent'] == 'pull' ) {
			$result = $this->end_ajax( $this->row_tracker . ',' . serialize( $this->primary_keys ) );

			return $result;
		}

		$chunk_gzipped = '0';
		if ( isset( $this->state_data['gzip'] ) && $this->state_data['gzip'] == '1' && $this->gzip() ) {
			$this->current_chunk = gzcompress( $this->current_chunk );
			$chunk_gzipped       = '1';
		}

		$data = array(
			'action'          => 'wpmdb_process_chunk',
			'remote_state_id' => $this->state_data['remote_state_id'],
			'table'           => $this->state_data['table'],
			'chunk_gzipped'   => $chunk_gzipped,
			'chunk'           => $this->current_chunk,
			// NEEDS TO BE the last element in this array because of adding it back into the array in ajax_process_chunk()
		);

		$data['sig'] = $this->create_signature( $data, $this->state_data['key'] );

		$ajax_url = $this->ajax_url();
		$response = $this->remote_post( $ajax_url, $data, __FUNCTION__ );

		ob_start();
		$this->display_errors();
		$maybe_errors = trim( ob_get_clean() );

		if ( false === empty( $maybe_errors ) ) {
			$maybe_errors = array( 'wpmdb_error' => 1, 'body' => $maybe_errors );
			$result       = $this->end_ajax( json_encode( $maybe_errors ) );

			return $result;
		}

		if ( '1' !== $response ) {
			$return = array( 'wpmdb_error' => 1, 'body' => $response );
			$result = $this->end_ajax( json_encode( $return ) );

			return $result;
		}

		$result = $this->end_ajax( json_encode(
			array(
				'current_row'  => $this->row_tracker,
				'primary_keys' => serialize( $this->primary_keys ),
			)
		) );

		return $result;
	}

	/**
	 * Add backquotes to tables and db-names in
	 * SQL queries. Taken from phpMyAdmin.
	 *
	 * @param $a_name
	 *
	 * @return array|string
	 */
	function backquote( $a_name ) {
		if ( ! empty( $a_name ) && $a_name != '*' ) {
			if ( is_array( $a_name ) ) {
				$result = array();
				reset( $a_name );
				while ( list( $key, $val ) = each( $a_name ) ) {
					$result[ $key ] = '`' . $val . '`';
				}

				return $result;
			} else {
				return '`' . $a_name . '`';
			}
		} else {
			return $a_name;
		}
	}

	/**
	 * Better addslashes for SQL queries.
	 * Taken from phpMyAdmin.
	 *
	 * @param string $a_string
	 * @param bool   $is_like
	 *
	 * @return mixed
	 */
	function sql_addslashes( $a_string = '', $is_like = false ) {
		if ( $is_like ) {
			$a_string = str_replace( '\\', '\\\\\\\\', $a_string );
		} else {
			$a_string = str_replace( '\\', '\\\\', $a_string );
		}

		return str_replace( '\'', '\\\'', $a_string );
	}

	function network_admin_menu() {
		$title       = ( $this->is_pro ) ? __( 'Migrate DB Pro', 'wp-migrate-db' ) : __( 'Migrate DB', 'wp-migrate-db' );
		$hook_suffix = add_submenu_page( 'settings.php',
			$title,
			$title,
			'manage_network_options',
			$this->core_slug,
			array( $this, 'options_page' ) );
		$this->after_admin_menu( $hook_suffix );
	}
	
	/**
	 * Add a tools menu item to sites on a Multisite network
	 *
	 */
	function network_tools_admin_menu() {
		add_management_page( 
			$this->get_plugin_title(),
			$this->get_plugin_title(),
			'manage_network_options',
			$this->core_slug,
			array( $this, 'subsite_tools_options_page' ) 
		);
	}

	function admin_menu() {
		$title       = ( $this->is_pro ) ? __( 'Migrate DB Pro', 'wp-migrate-db' ) : __( 'Migrate DB', 'wp-migrate-db' );
		$hook_suffix = add_management_page( $title,
			$title,
			'export',
			$this->core_slug,
			array( $this, 'options_page' ) );
		$this->after_admin_menu( $hook_suffix );
	}

	function after_admin_menu( $hook_suffix ) {
		add_action( 'admin_head-' . $hook_suffix, array( $this, 'admin_head_connection_info' ) );
		add_action( 'load-' . $hook_suffix, array( $this, 'load_assets' ) );

		// Remove licence from the database if constant is set
		if ( $this->is_licence_constant() && ! empty( $this->settings['licence'] ) ) {
			$this->settings['licence'] = '';
			update_site_option( 'wpmdb_settings', $this->settings );
		}
	}

	function admin_body_class( $classes ) {
		if ( ! $classes ) {
			$classes = array();
		} else {
			$classes = explode( ' ', $classes );
		}

		$version_class = 'wpmdb-not-pro';
		if ( true == $this->is_pro ) {
			$version_class = 'wpmdb-pro';
		}

		$classes[] = $version_class;

		// Recommended way to target WP 3.8+
		// http://make.wordpress.org/ui/2013/11/19/targeting-the-new-dashboard-design-in-a-post-mp6-world/
		if ( version_compare( $GLOBALS['wp_version'], '3.8-alpha', '>' ) ) {
			if ( ! in_array( 'mp6', $classes ) ) {
				$classes[] = 'mp6';
			}
		}

		return implode( ' ', $classes );
	}

	/**
	 * Check for download
	 * if found prepare file for download
	 *
	 * @return void
	 */
	function http_verify_download() {
		if ( ! empty( $_GET['download'] ) ) {
			$this->download_file();
		}
	}

	/**
	 * Check for wpmdb-download-log and related nonce
	 * if found begin diagnostic logging
	 *
	 * @return void
	 */
	function http_prepare_download_log() {
		if ( isset( $_GET['wpmdb-download-log'] ) && wp_verify_nonce( $_GET['nonce'], 'wpmdb-download-log' ) ) {
			ob_start();
			$this->output_diagnostic_info();
			$this->output_log_file();
			$log      = ob_get_clean();
			$url      = $this->parse_url( home_url() );
			$host     = sanitize_file_name( $url['host'] );
			$filename = sprintf( '%s-diagnostic-log-%s.txt', $host, date( 'YmdHis' ) );
			header( 'Content-Description: File Transfer' );
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Length: ' . strlen( $log ) );
			header( 'Content-Disposition: attachment; filename=' . $filename );
			echo $log;
			exit;
		}
	}

	/**
	 * Check for wpmdb-remove-licence and related nonce
	 * if found cleanup routines related to licenced product
	 *
	 * @return void
	 */
	function http_remove_license() {
		if ( isset( $_GET['wpmdb-remove-licence'] ) && wp_verify_nonce( $_GET['nonce'], 'wpmdb-remove-licence' ) ) {
			$this->settings['licence'] = '';
			update_site_option( 'wpmdb_settings', $this->settings );
			// delete these transients as they contain information only valid for authenticated licence holders
			delete_site_transient( 'update_plugins' );
			delete_site_transient( 'wpmdb_upgrade_data' );
			delete_site_transient( 'wpmdb_licence_response' );
			// redirecting here because we don't want to keep the query string in the web browsers address bar
			wp_redirect( network_admin_url( $this->plugin_base . '#settings' ) );
			exit;
		}
	}

	/**
	 * Check for wpmdb-disable-ssl and related nonce
	 * if found temporaily disable ssl via transient
	 *
	 * @return void
	 */
	function http_disable_ssl() {
		if ( isset( $_GET['wpmdb-disable-ssl'] ) && wp_verify_nonce( $_GET['nonce'], 'wpmdb-disable-ssl' ) ) {
			set_site_transient( 'wpmdb_temporarily_disable_ssl', '1', 60 * 60 * 24 * 30 ); // 30 days
			$hash = ( isset( $_GET['hash'] ) ) ? '#' . sanitize_title( $_GET['hash'] ) : '';
			// delete the licence transient as we want to attempt to fetch the licence details again
			delete_site_transient( 'wpmdb_licence_response' );
			// redirecting here because we don't want to keep the query string in the web browsers address bar
			wp_redirect( network_admin_url( $this->plugin_base . $hash ) );
			exit;
		}
	}

	/**
	 * Check for wpmdb-check-licence and related nonce
	 * if found refresh licence details
	 *
	 * @return void
	 */
	function http_refresh_licence() {
		if ( isset( $_GET['wpmdb-check-licence'] ) && wp_verify_nonce( $_GET['nonce'], 'wpmdb-check-licence' ) ) {
			$hash = ( isset( $_GET['hash'] ) ) ? '#' . sanitize_title( $_GET['hash'] ) : '';
			// delete the licence transient as we want to attempt to fetch the licence details again
			delete_site_transient( 'wpmdb_licence_response' );
			// redirecting here because we don't want to keep the query string in the web browsers address bar
			wp_redirect( network_admin_url( $this->plugin_base . $hash ) );
			exit;
		}
	}

	/**
	 * Checks and sets up plugin assets.
	 * Filter actions, enqueue scripts, define configuration, and constants.
	 *
	 * @return void
	 */
	function load_assets() {
		$this->http_verify_download();
		$this->http_prepare_download_log();
		$this->http_remove_license();
		$this->http_disable_ssl();
		$this->http_refresh_licence();

		// add our custom CSS classes to <body>
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );

		$plugins_url = trailingslashit( plugins_url( $this->plugin_folder_name ) );
		$version     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? time() : $this->plugin_version;
		$ver_string  = '-' . str_replace( '.', '', $this->plugin_version );
		$min         = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$src = $plugins_url . 'asset/dist/css/styles.css';
		wp_enqueue_style( 'wp-migrate-db-pro-styles', $src, array(), $version );

		$src = $plugins_url . "asset/dist/js/common{$ver_string}{$min}.js";
		wp_enqueue_script( 'wp-migrate-db-pro-common', $src, null, $version, true );

		$src = $plugins_url . "asset/dist/js/hook{$ver_string}{$min}.js";
		wp_enqueue_script( 'wp-migrate-db-pro-hook', $src, null, $version, true );

		$src = $plugins_url . "asset/dist/js/multisite{$ver_string}{$min}.js";
		wp_enqueue_script( 'wp-migrate-db-pro-multisite', $src, array( 'jquery' ), $version, true );

		do_action( 'wpmdb_load_assets' );

		$src = $plugins_url . "asset/dist/js/script{$ver_string}{$min}.js";
		wp_enqueue_script( 'wp-migrate-db-pro-script', $src, array( 'jquery', 'backbone' ), $version, true );

		wp_localize_script( 'wp-migrate-db-pro-script',
			'wpmdb_strings',
			array(
				'max_request_size_problem'              => __( 'A problem occurred when trying to change the maximum request size, please try again.', 'wp-migrate-db' ),
				'license_check_problem'                 => __( 'A problem occurred when trying to check the license, please try again.', 'wp-migrate-db' ),
				'establishing_remote_connection'        => __( 'Establishing connection to remote server, please wait', 'wp-migrate-db' ),
				'connection_local_server_problem'       => __( 'A problem occurred when attempting to connect to the local server, please check the details and try again.', 'wp-migrate-db' ),
				'enter_license_key'                     => __( 'Please enter your license key.', 'wp-migrate-db' ),
				'register_license_problem'              => __( 'A problem occurred when trying to register the license, please try again.', 'wp-migrate-db' ),
				'license_registered'                    => __( 'Your license has been activated. You will now receive automatic updates and access to email support.', 'wp-migrate-db' ),
				'fetching_license'                      => __( 'Fetching license details, please wait…', 'wp-migrate-db' ),
				'clear_log_problem'                     => __( 'An error occurred when trying to clear the debug log. Please contact support. (#132)', 'wp-migrate-db' ),
				'update_log_problem'                    => __( 'An error occurred when trying to update the debug log. Please contact support. (#133)', 'wp-migrate-db' ),
				'please_select_one_table'               => __( 'Please select at least one table to migrate.', 'wp-migrate-db' ),
				'please_select_one_table_backup'        => __( 'Please select at least one table for backup.', 'wp-migrate-db' ),
				'enter_name_for_profile'                => __( 'Please enter a name for your migration profile.', 'wp-migrate-db' ),
				'save_profile_problem'                  => __( 'An error occurred when attempting to save the migration profile. Please see the Help tab for details on how to request support. (#118)', 'wp-migrate-db' ),
				'exporting_complete'                    => _x( 'Export complete', 'Data has been successfully exported', 'wp-migrate-db' ),
				'exporting_please_wait'                 => __( 'Exporting, please wait…', 'wp-migrate-db' ),
				'please_wait'                           => __( 'please wait…', 'wp-migrate-db' ),
				'complete'                              => _x( 'complete', 'Finished successfully', 'wp-migrate-db' ),
				'migration_failed'                      => _x( 'Migration failed', 'Copy of data between servers did not complete', 'wp-migrate-db' ),
				'backing_up'                            => _x( 'Backing up', 'Saving a copy of the data before import', 'wp-migrate-db' ),
				'queued'                                => _x( 'Queued', 'In line to be processed', 'wp-migrate-db' ),
				'migrating'                             => _x( 'Migrating', 'Copying data between servers', 'wp-migrate-db' ),
				'running'                               => _x( 'Running', 'Process is active', 'wp-migrate-db'),
				'status'                                => _x( 'Status', 'Current request status', 'wp-migrate-db' ),
				'response'                              => _x( 'Response', 'The message the server responded with', 'wp-migrate-db' ),
				'table_process_problem'                 => __( 'A problem occurred when attempting to process the following table (#113)', 'wp-migrate-db' ),
				'table_process_problem_empty_response'  => __( 'A problem occurred when processing the following table. We were expecting a response in JSON format but instead received an empty response.', 'wp-migrate-db' ),
				'completed_with_some_errors'            => __( 'Migration completed with some errors', 'wp-migrate-db' ),
				'completed_dump_located_at'             => __( 'Migration complete, your backup is located at:', 'wp-migrate-db' ),
				'finalize_tables_problem'               => __( 'A problem occurred when finalizing the backup. (#140)', 'wp-migrate-db' ),
				'saved'                                 => _x( 'Saved', 'The settings were saved successfully', 'wp-migrate-db' ),
				'reset_api_key'                         => __( 'Any sites setup to use the current secret key will no longer be able to connect. You will need to update those sites with the newly generated secret key. Do you wish to continue?', 'wp-migrate-db' ),
				'reset_api_key_problem'                 => __( 'An error occurred when trying to generate the secret key. Please see the Help tab for details on how to request support. (#105)', 'wp-migrate-db' ),
				'remove_profile'                        => __( 'You are about to remove the migration profile "{{profile}}". This cannot be undone. Do you wish to continue?', 'wp-migrate-db' ),
				'remove_profile_problem'                => __( 'An error occurred when trying to delete the profile. Please see the Help tab for details on how to request support. (#106)', 'wp-migrate-db' ),
				'remove_profile_not_found'              => __( "The selected migration profile could not be deleted because it was not found.\nPlease refresh this page to see an accurate list of the currently available migration profiles.", 'wp-migrate-db' ),
				'change_connection_info'                => __( 'If you change the connection details, you will lose any replaces and table selections you have made below. Do you wish to continue?', 'wp-migrate-db' ),
				'enter_connection_info'                 => __( 'Please enter the connection information above to continue.', 'wp-migrate-db' ),
				'save_settings_problem'                 => __( 'An error occurred when trying to save the settings. Please try again. If the problem persists, please see the Help tab for details on how to request support. (#108)', 'wp-migrate-db' ),
				'connection_info_missing'               => __( 'The connection information appears to be missing, please enter it to continue.', 'wp-migrate-db' ),
				'connection_info_incorrect'             => __( "The connection information appears to be incorrect, it should consist of two lines. The first being the remote server's URL and the second being the secret key.", 'wp-migrate-db' ),
				'connection_info_url_invalid'           => __( 'The URL on the first line appears to be invalid, please check it and try again.', 'wp-migrate-db' ),
				'connection_info_key_invalid'           => __( 'The secret key on the second line appears to be invalid. It should be a 40 character string that consists of letters, numbers and special characters only.', 'wp-migrate-db' ),
				'connection_info_local_url'             => __( "It appears you've entered the URL for this website, you need to provide the URL of the remote website instead.", 'wp-migrate-db' ),
				'connection_info_local_key'             => __( 'Looks like your remote secret key is the same as the secret key for this site. To fix this, go to the <a href="#settings">Settings tab</a> and click "Reset Secret Key"', 'wp-migrate-db' ),
				'time_elapsed'                          => __( 'Time Elapsed:', 'wp-migrate-db' ),
				'pause'                                 => _x( 'Pause', 'Temporarily stop migrating', 'wp-migrate-db' ),
				'migration_paused'                      => _x( 'Migration Paused', 'The migration has been temporarily stopped', 'wp-migrate-db' ),
				'resume'                                => _x( 'Resume', 'Restart migrating after it was paused', 'wp-migrate-db' ),
				'completing_current_request'            => __( 'Completing current request', 'wp-migrate-db' ),
				'cancelling_migration'                  => _x( 'Cancelling migration', 'The migration is being cancelled', 'wp-migrate-db' ),
				'paused'                                => _x( 'Paused', 'The migration has been temporarily stopped', 'wp-migrate-db' ),
				'paused_before_finalize'                => __( 'Automatically paused before migrated tables are replaced. Click "Resume" or "Cancel" when ready.', 'wp-migrate-db' ),
				'removing_local_sql'                    => __( 'Removing the local MySQL export file', 'wp-migrate-db' ),
				'removing_local_backup'                 => __( 'Removing the local backup MySQL export file', 'wp-migrate-db' ),
				'removing_local_temp_tables'            => __( 'Removing the local temporary tables', 'wp-migrate-db' ),
				'removing_remote_sql'                   => __( 'Removing the remote backup MySQL export file', 'wp-migrate-db' ),
				'removing_remote_temp_tables'           => __( 'Removing the remote temporary tables', 'wp-migrate-db' ),
				'migration_cancellation_failed'         => __( 'Migration cancellation failed', 'wp-migrate-db' ),
				'manually_remove_temp_files'            => __( 'A problem occurred while cancelling the migration, you may have to manually delete some temporary files / tables.', 'wp-migrate-db' ),
				'migration_cancelled'                   => _x( 'Migration cancelled', 'The migration has been cancelled', 'wp-migrate-db' ),
				'migration_cancelled_success'           => __( 'The migration has been stopped and all temporary files and data have been cleaned up.', 'wp-migrate-db' ),
				'migration_complete'                    => _x( 'Migration complete', 'The migration completed successfully', 'wp-migrate-db' ),
				'finalizing_migration'                  => _x( 'Finalizing migration', 'The migration is in the last stages', 'wp-migrate-db' ),
				'flushing'                              => _x( 'Flushing caches and rewrite rules', 'The caches and rewrite rules for the target are being flushed', 'wp-migrate-db' ),
				'blacklist_problem'                     => __( 'A problem occurred when trying to add plugins to backlist.', 'wp-migrate-db' ),
				'mu_plugin_confirmation'                => __( "If confirmed we will install an additional WordPress 'Must Use' plugin. This plugin will allow us to control which plugins are loaded during WP Migrate DB Pro specific operations. Do you wish to continue?", 'wp-migrate-db' ),
				'plugin_compatibility_settings_problem' => __( 'A problem occurred when trying to change the plugin compatibility setting.', 'wp-migrate-db' ),
				'sure'                                  => _x( 'Sure?', 'Confirmation required', 'wp-migrate-db' ),
				'pull_migration_label_migrating'        => __( 'Pulling from %s…', 'wp-migrate-db' ),
				'pull_migration_label_completed'        => __( 'Pull from %s complete', 'wp-migrate-db' ),
				'push_migration_label_migrating'        => __( 'Pushing to %s…', 'wp-migrate-db' ),
				'push_migration_label_completed'        => __( 'Push to %s complete', 'wp-migrate-db' ),
				'copying_license'                       => __( 'Copying license to the remote site, please wait', 'wp-migrate-db' ),
				'attempting_to_activate_licence'        => __( 'Attempting to activate your license, please wait…', 'wp-migrate-db' ),
				'licence_reactivated'                   => __( 'License successfully activated, please wait…', 'wp-migrate-db' ),
				'activate_licence_problem'              => __( 'An error occurred when trying to reactivate your license. Please provide the following information when requesting support:', 'wp-migrate-db' ),
				'temporarily_activated_licence'         => __( "<strong>We've temporarily activated your licence and will complete the activation once the Delicious Brains API is available again.</strong><br />Please refresh this page to continue.", 'wp-migrate-db' ),
				'ajax_json_message'                     => __( 'JSON Decoding Failure', 'wp-migrate-db' ),
				'ajax_json_errors'                      => __( 'Our AJAX request was expecting JSON but we received something else. Often this is caused by your theme and/or plugins spitting out PHP errors. If you can edit the theme or plugins causing the errors, you should be able to fix them up, but if not, you can set WP_DEBUG to false in wp-config.php to disable errors from showing up.', 'wp-migrate-db' ),
				'view_error_messages'                   => __( 'View error messages', 'wp-migrate-db' ),
				'delaying_next_request'                 => __( 'Waiting %s seconds before executing next step', 'wp-migrate-db' ),
				'delay_between_requests_problem'        => __( 'A problem occurred when trying to change the delay between requests, please try again.', 'wp-migrate-db' ),
				'flush_problem'                         => __( 'A problem occurred when flushing caches and rewrite rules. (#145)', 'wp-migrate-db' ),
				'migrate_button_push'                   => _x( 'Push', 'Transfer this database to the remote site', 'wp-migrate-db' ),
				'migrate_button_push_save'              => _x( 'Push &amp; Save', 'Transfer this database to the remote site and save migration profile', 'wp-migrate-db' ),
				'migrate_button_pull'                   => _x( 'Pull', 'Transfer the remote database to this site', 'wp-migrate-db' ),
				'migrate_button_pull_save'              => _x( 'Pull &amp; Save', 'Transfer the remote database to this site and save migration profile', 'wp-migrate-db' ),
				'migrate_button_export'                 => _x( 'Export', 'Download a copy of the database', 'wp-migrate-db' ),
				'migrate_button_export_save'            => _x( 'Export &amp; Save', 'Download a copy of the database and save migration profile', 'wp-migrate-db' ),
				'tables'                                => _x( 'Tables', 'database tables', 'wp-migrate-db'),
				'files'                                 => __( 'Files', 'wp-migrate-db'),
				'migrated'                              => _x( 'Migrated', 'Transferred', 'wp-migrate-db' ),
				'backed_up'                             => __( 'Backed Up', 'wp-migrate-db' ),
				'hide'                                  => _x( 'Hide', 'Obscure from view', 'wp-migrate-db' ),
				'show'                                  => _x( 'Show', 'Reveal', 'wp-migrate-db' ),
				'welcome_title'                         => __( 'Welcome to WP Migrate DB Pro! &#127881;', 'wp-migrate-db' ),
				'welcome_text'                          => __( 'Hey, this is the first time activating your license, nice! Your migrations are about to get awesome! If you haven’t already, you should check out our <a href="%1$s">Quick Start Guide</a> and <a href="%2$s">Videos</a>. If you run into any trouble at all, use the <strong>Help tab</strong> above to submit a support request.', 'wp-migrate-db' ),
				'title_progress'                        => __( '%1$s Stage %2$s of %3$s', 'wp-migrate-db' ),
				'title_paused'                          => __( 'Paused', 'wp-migrate-db' ),
				'title_cancelling'                      => __( 'Cancelling', 'wp-migrate-db' ),
				'title_cancelled'                       => __( 'Cancelled', 'wp-migrate-db' ),
				'title_finalizing'                      => __( 'Finalizing', 'wp-migrate-db' ),
				'title_complete'                        => __( 'Complete', 'wp-migrate-db' ),
				'title_error'                           => __( 'Failed', 'wp-migrate-db' ),
				'progress_items_truncated_msg'          => __( '%1$s items are not shown to maintain browser performance', 'wp-migrate-db' ),
			)
		);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	function download_file() {
		// don't need to check for user permissions as our 'add_management_page' already takes care of this
		$this->set_time_limit();

		$dump_name = $this->format_dump_name( $_GET['download'] );

		if ( isset( $_GET['gzip'] ) ) {
			$dump_name .= '.gz';
		}

		$diskfile         = $this->get_upload_info( 'path' ) . DIRECTORY_SEPARATOR . $dump_name;
		$filename         = basename( $diskfile );
		$last_dash        = strrpos( $filename, '-' );
		$salt             = substr( $filename, $last_dash, 6 );
		$filename_no_salt = str_replace( $salt, '', $filename );

		if ( file_exists( $diskfile ) ) {
			header( 'Content-Description: File Transfer' );
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Length: ' . filesize( $diskfile ) );
			header( 'Content-Disposition: attachment; filename=' . $filename_no_salt );
			$success = readfile( $diskfile );
			// TODO: Use WP_Filesystem API.
			unlink( $diskfile );
			exit;
		} else {
			wp_die( __( 'Could not find the file to download:', 'wp-migrate-db' ) . '<br />' . esc_html( $diskfile ) );
		}
	}

	/**
	 * Supply inline JS data and nonces for enqueued scripts.
	 *
	 * @return void
	 */
	function admin_head_connection_info() {
		$site_details = $this->site_details();

		$nonces = apply_filters( 'wpmdb_nonces', array(
			'update_max_request_size'          => wp_create_nonce( 'update-max-request-size' ),
			'update_delay_between_requests'    => wp_create_nonce( 'update-delay-between-requests' ),
			'check_licence'                    => wp_create_nonce( 'check-licence' ),
			'verify_connection_to_remote_site' => wp_create_nonce( 'verify-connection-to-remote-site' ),
			'activate_licence'                 => wp_create_nonce( 'activate-licence' ),
			'clear_log'                        => wp_create_nonce( 'clear-log' ),
			'get_log'                          => wp_create_nonce( 'get-log' ),
			'save_profile'                     => wp_create_nonce( 'save-profile' ),
			'initiate_migration'               => wp_create_nonce( 'initiate-migration' ),
			'migrate_table'                    => wp_create_nonce( 'migrate-table' ),
			'finalize_migration'               => wp_create_nonce( 'finalize-migration' ),
			'reset_api_key'                    => wp_create_nonce( 'reset-api-key' ),
			'delete_migration_profile'         => wp_create_nonce( 'delete-migration-profile' ),
			'save_setting'                     => wp_create_nonce( 'save-setting' ),
			'copy_licence_to_remote_site'      => wp_create_nonce( 'copy-licence-to-remote-site' ),
			'reactivate_licence'               => wp_create_nonce( 'reactivate-licence' ),
			'process_notice_link'              => wp_create_nonce( 'process-notice-link' ),
			'flush'                            => wp_create_nonce( 'flush' ),
			'plugin_compatibility'             => wp_create_nonce( 'plugin_compatibility' ),
			'blacklist_plugins'                => wp_create_nonce( 'blacklist_plugins' ),
			'cancel_migration'                 => wp_create_nonce( 'cancel_migration' )
		) );

		$data = apply_filters( 'wpmdb_data', array(
			'connection_info'        => array( site_url( '', 'https' ), $this->settings['key'] ),
			'this_url'               => esc_html( addslashes( home_url() ) ),
			'this_path'              => esc_html( addslashes( $this->get_absolute_root_file_path() ) ),
			'this_domain'            => esc_html( $this->get_domain_current_site() ),
			'this_tables'            => $this->get_tables(),
			'this_prefixed_tables'   => $this->get_tables( 'prefix' ),
			'this_table_sizes'       => $this->get_table_sizes(),
			'this_table_sizes_hr'    => array_map( array( $this, 'format_table_sizes' ), $this->get_table_sizes() ),
			'this_table_rows'        => $this->get_table_row_count(),
			'this_upload_url'        => esc_html( addslashes( trailingslashit( $this->get_upload_info( 'url' ) ) ) ),
			'this_upload_dir_long'   => esc_html( addslashes( trailingslashit( $this->get_upload_info( 'path' ) ) ) ),
			'this_uploads_dir'       => $site_details['uploads_dir'], // TODO: Remove backwards compatibility.
			'this_plugin_url'        => trailingslashit( plugins_url( $this->plugin_folder_name ) ),
			'this_website_name'      => sanitize_title_with_dashes( DB_NAME ),
			'this_download_url'      => network_admin_url( $this->plugin_base . '&download=' ),
			'this_prefix'            => $site_details['prefix'], // TODO: Remove backwards compatibility.
			'this_temp_prefix'       => $this->temp_prefix,
			'this_plugin_base'       => esc_html( $this->plugin_base ),
			'is_multisite'           => $site_details['is_multisite'], // TODO: Remove backwards compatibility.
			'openssl_available'      => esc_html( $this->open_ssl_enabled() ? 'true' : 'false' ),
			'max_request'            => esc_html( $this->settings['max_request'] ),
			'delay_between_requests' => esc_html( $this->settings['delay_between_requests'] ),
			'prog_tables_hidden'     => ( bool ) $this->settings['prog_tables_hidden'],
			'pause_before_finalize'  => ( bool ) $this->settings['pause_before_finalize'],
			'bottleneck'             => esc_html( $this->get_bottleneck( 'max' ) ),
			'has_licence'            => esc_html( $this->get_licence_key() == '' ? '0' : '1' ),
			// TODO: Use WP_Filesystem API.
			'write_permission'       => esc_html( is_writeable( $this->get_upload_info( 'path' ) ) ? 'true' : 'false' ),
			'nonces'                 => $nonces,
			'valid_licence'          => ( $this->is_valid_licence() ) ? '1' : '0',
			'profile'                => isset( $_GET['wpmdb-profile'] ) ? $_GET['wpmdb-profile'] : '-1',
			'is_pro'                 => esc_html( ( $this->is_pro ) ? 'true' : 'false' ),
			'lower_case_table_names' => esc_html( $this->get_lower_case_table_names_setting() ),
			'subsites'               => $site_details['subsites'], // TODO: Remove backwards compatibility.
			'site_details'           => $this->site_details(),
		) );

		wp_localize_script( 'wp-migrate-db-pro-script', 'wpmdb_data', $data );
	}

	function maybe_update_profile( $profile, $profile_id ) {
		$profile_changed = false;

		if ( isset( $profile['exclude_revisions'] ) ) {
			unset( $profile['exclude_revisions'] );
			$profile['select_post_types'] = array( 'revision' );
			$profile_changed              = true;
		}

		if ( isset( $profile['post_type_migrate_option'] ) && 'migrate_select_post_types' == $profile['post_type_migrate_option'] && 'pull' != $profile['action'] ) {
			unset( $profile['post_type_migrate_option'] );
			$profile['exclude_post_types'] = '1';
			$all_post_types                = $this->get_post_types();
			$profile['select_post_types']  = array_diff( $all_post_types, $profile['select_post_types'] );
			$profile_changed               = true;
		}

		if ( $profile_changed ) {
			$this->settings['profiles'][ $profile_id ] = $profile;
			update_site_option( 'wpmdb_settings', $this->settings );
		}

		return $profile;
	}

	function get_path_from_url( $url ) {
		$parts = $this->parse_url( $url );

		return ( ! empty( $parts['path'] ) ) ? trailingslashit( $parts['path'] ) : '/';
	}

	function get_path_current_site() {
		if ( ! is_multisite() ) {
			return '';
		}

		$current_site = get_current_site();

		return $current_site->path;
	}

	/**
	 * Get the domain for the current site.
	 *
	 * @return string
	 */
	function get_domain_current_site() {
		if ( ! is_multisite() ) {
			return '';
		}

		$current_site = get_current_site();

		return $current_site->domain;
	}

	/**
	 * Called to cancel an in-progress migration.
	 */
	function ajax_cancel_migration() {
		$this->check_ajax_referer( 'cancel_migration' );

		$key_rules = array(
			'action'             => 'key',
			'migration_state_id' => 'key',
		);
		$this->set_post_data( $key_rules );

		$this->form_data = $this->parse_migration_form_data( $this->state_data['form_data'] );

		switch ( $this->state_data['intent'] ) {
			case 'savefile' :
				$this->delete_export_file( $this->state_data['dump_filename'], false );
				break;
			case 'push' :
				$data = $this->filter_post_elements(
					$this->state_data,
					array(
						'remote_state_id',
						'intent',
						'url',
						'form_data',
						'temp_prefix',
						'stage',
						'dump_filename',
					)
				);

				$data['action'] = 'wpmdb_process_push_migration_cancellation';
				$data['sig']    = $this->create_signature( $data, $this->state_data['key'] );
				$ajax_url       = $this->ajax_url();

				$response = $this->remote_post( $ajax_url, $data, __FUNCTION__ );
				$this->display_errors();

				echo esc_html( trim( $response ) );
				break;
			case 'pull' :
				if ( $this->state_data['stage'] == 'backup' ) {
					if ( ! empty( $this->state_data['dumpfile_created'] ) ) {
						$this->delete_export_file( $this->state_data['dump_filename'], true );
					}
				} else {
					$this->delete_temporary_tables( $this->state_data['temp_prefix'] );
				}
				break;
			default:
				break;
		}

		if ( ! $this->migration_state->delete() ) {
			$this->log_error( 'Could not delete migration state.' );
		}

		exit;
	}

	function delete_export_file( $filename, $is_backup ) {
		$dump_file = $this->format_dump_name( $filename );

		if ( true == $is_backup ) {
			$dump_file = preg_replace( '/.gz$/', '', $dump_file );
		}

		$dump_file = $this->get_upload_info( 'path' ) . DIRECTORY_SEPARATOR . $dump_file;

		if ( empty( $dump_file ) || false == file_exists( $dump_file ) ) {
			_e( 'MySQL export file not found.', 'wp-migrate-db' );
			exit;
		}

		// TODO: Use WP_Filesystem API.
		if ( false === @unlink( $dump_file ) ) {
			_e( 'Could not delete the MySQL export file.', 'wp-migrate-db' );
			exit;
		}
	}

	function empty_current_chunk() {
		$this->current_chunk = '';
	}

	function template_compatibility() {
		$args = array(
			'plugin_compatibility_checked' => ( isset( $GLOBALS['wpmdb_compatibility'] ) ? true : false ),
		);
		$this->template( 'compatibility', 'common', $args );
	}

	function template_max_request_size() {
		$this->template( 'max-request-size', 'common' );
	}

	function template_debug_info() {
		$this->template( 'debug-info', 'common' );
	}

	function template_exclude_post_revisions( $loaded_profile ) {
		$args = array(
			'loaded_profile' => $loaded_profile,
		);
		$this->template( 'exclude-post-revisions', 'wpmdb', $args );
	}

	function template_wordpress_org_support() {
		$this->template( 'wordpress-org-support', 'wpmdb' );
	}

	function template_progress_upgrade() {
		$this->template( 'progress-upgrade', 'wpmdb' );
	}

	function template_sidebar() {
		$this->template( 'sidebar', 'wpmdb' );
	}

	function template_part( $methods, $args = false ) {
		$methods = array_diff( $methods, $this->unhook_templates );

		foreach ( $methods as $method ) {
			$method_name = 'template_' . $method;

			if ( method_exists( $this, $method_name ) ) {
				call_user_func( array( $this, $method_name ), $args );
			}
		}
	}

	function plugin_tabs() {
		echo implode( '', $this->plugin_tabs );
	}

	function get_plugin_title() {
		return __( 'Migrate DB', 'wp-migrate-db' );
	}

	function plugin_deactivated_notice() {
		if ( false !== ( $deactivated_notice_id = get_transient( 'wp_migrate_db_deactivated_notice_id' ) ) ) {
			if ( '1' === $deactivated_notice_id ) {
				$message = __( "WP Migrate DB and WP Migrate DB Pro cannot both be active. We've automatically deactivated WP Migrate DB.", 'wp-migrate-db' );
			} else {
				$message = __( "WP Migrate DB and WP Migrate DB Pro cannot both be active. We've automatically deactivated WP Migrate DB Pro.", 'wp-migrate-db' );
			} ?>

			<div class="updated" style="border-left: 4px solid #ffba00;">
				<p><?php echo esc_html( $message ); ?></p>
			</div> <?php

			delete_transient( 'wp_migrate_db_deactivated_notice_id' );
		}
	}

	/**
	 * When the "Use SSL for WP-admin and WP-login" option is checked in the
	 * WP Engine settings, the WP Engine must-use plugin buffers the output and
	 * does a find & replace for URLs. When we return PHP serialized data, it
	 * replaces http:// with https:// and corrupts the serialization.
	 * So here, we disable this filtering for our requests.
	 */
	function maybe_disable_wp_engine_filtering() {
		// Detect if the must-use WP Engine plugin is running
		if ( ! defined( 'WPE_PLUGIN_BASE' ) ) {
			return;
		}

		// Make sure this is a WP Migrate DB Ajax request
		if ( ! class_exists( 'WPMDB_Utils' ) || ! WPMDB_Utils::is_ajax() ) {
			return;
		}

		// Turn off WP Engine's output filtering
		if ( ! defined( 'WPE_NO_HTML_FILTER' ) ) {
			define( 'WPE_NO_HTML_FILTER', true );
		}
	}

	/**
	 * Ensures that the given create table sql string is compatible with the target database server version.
	 *
	 * @param string $create_table
	 * @param string $table
	 * @param string $db_version
	 * @param string $action
	 * @param string $stage
	 *
	 * @return mixed
	 */
	function mysql_compat_filter( $create_table, $table, $db_version, $action, $stage ) {
		if ( empty( $db_version ) || empty( $action ) || empty( $stage ) ) {
			return $create_table;
		}

		if ( version_compare( $db_version, '5.5.3', '<' ) ) {
			// Remove index comments introduced in MySQL 5.5.3.
			// Following regex matches any PRIMARY KEY or KEY statement on a table definition that has a COMMENT statement attached.
			// The regex is then reset (\K) to return just the COMMENT, its string and any leading whitespace for replacing with nothing.
			$create_table = preg_replace( '/(?-i)KEY\s.*`.*`\).*\K\sCOMMENT\s\'.*\'/', '', $create_table );

			// Replace utf8mb4 introduced in MySQL 5.5.3 with utf8. As of WordPress 4.2 utf8mb4 is used by default on supported MySQL versions
			// but causes migrations to fail when the remote site uses MySQL < 5.5.3.
			$abort_utf8mb4 = false;
			if ( 'savefile' !== $action && 'backup' !== $stage ) {
				$abort_utf8mb4 = true;
			}
			// Escape hatch if user knows that site content is utf8 safe.
			$abort_utf8mb4 = apply_filters( 'wpmdb_abort_utf8mb4_to_utf8', $abort_utf8mb4 );

			$replace_count = 0;
			$create_table  = preg_replace( '/(COLLATE\s)utf8mb4/', '$1utf8', $create_table, -1, $replace_count ); // Column collation

			if ( false === $abort_utf8mb4 || 0 === $replace_count ) {
				$create_table = preg_replace( '/(COLLATE=)utf8mb4/', '$1utf8', $create_table, -1, $replace_count ); // Table collation
			}

			if ( false === $abort_utf8mb4 || 0 === $replace_count ) {
				$create_table = preg_replace( '/(CHARSET\s?=\s?)utf8mb4/', '$1utf8', $create_table, -1, $replace_count ); // Table charset
			}

			if ( true === $abort_utf8mb4 && 0 !== $replace_count ) {
				$return = sprintf( __( 'The source site supports utf8mb4 data but the target does not, aborting migration to avoid possible data corruption. Please see %1$s for more information. (#148)', 'wp-migrate-db-pro' ), sprintf( '<a href="https://deliciousbrains.com/wp-migrate-db-pro/doc/source-site-supports-utf8mb4/">%1$s</a>', __( 'our documentation', 'wp-migrate-db-pro' ) ) );
				$return = array( 'wpmdb_error' => 1, 'body' => $return );
				$result = $this->end_ajax( json_encode( $return ) );

				return $result;
			}
		}

		return $create_table;
	}

	/**
	 * Provides find/replace pairs with wpmdb_find_and_replace filter applied.
	 *
	 * @param string $intent
	 * @param string $site_url
	 *
	 * @return array
	 */
	function parse_find_replace_pairs( $intent = '', $site_url = '' ) {
		$find_replace_pairs     = array();
		$tmp_find_replace_pairs = array();
		if ( ! empty( $this->form_data['replace_old'] ) && ! empty( $this->form_data['replace_new'] ) ) {
			$tmp_find_replace_pairs = array_combine( $this->form_data['replace_old'], $this->form_data['replace_new'] );
		}

		$tmp_find_replace_pairs = apply_filters( 'wpmdb_find_and_replace', $tmp_find_replace_pairs, $intent, $site_url );

		if ( ! empty( $tmp_find_replace_pairs ) ) {
			$i = 1;
			foreach ( $tmp_find_replace_pairs as $replace_old => $replace_new ) {
				$find_replace_pairs['replace_old'][ $i ] = $replace_old;
				$find_replace_pairs['replace_new'][ $i ] = $replace_new;
				$i++;
			}
		}

		return $find_replace_pairs;
	}

	function get_lower_case_table_names_setting() {
		global $wpdb;

		$setting = $wpdb->get_var( "SHOW VARIABLES LIKE 'lower_case_table_names'", 1 );

		return empty( $setting ) ? '-1' : $setting;
	}

	function mixed_case_table_name_warning( $migration_type ) {
		ob_start();
		?>
		<h4><?php _e( "Warning: Mixed Case Table Names", 'wp-migrate-db' ); ?></h4>

		<?php if ( 'pull' === $migration_type ) : ?>
			<p><?php _e( "Whoa! We've detected that your <b>local</b> site has the MySQL setting <code>lower_case_table_names</code> set to <code>1</code>.", 'wp-migrate-db' ); ?></p>
		<?php else : ?>
			<p><?php _e( "Whoa! We've detected that your <b>remote</b> site has the MySQL setting <code>lower_case_table_names</code> set to <code>1</code>.", 'wp-migrate-db' ); ?></p>
		<?php endif; ?>

		<p><?php _e( "As a result, uppercase characters in table names will be converted to lowercase during the migration.", 'wp-migrate-db' ); ?></p>

		<p><?php printf( __( 'You can read more about this in <a href="%s">our documentation</a>, proceed with caution.', 'wp-migrate-db' ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/mixed-case-table-names/' ); ?></p>
		<?php
		return wptexturize( ob_get_clean() );
	}
}
