<?php

class WPMDB_CLI extends WPMDB_Base {

	/**
	 * Instance of WPMDB.
	 *
	 * @var WPMDB
	 */
	protected $wpmdb;

	/**
	 * Migration profile.
	 *
	 * @var array
	 */
	protected $profile;

	/**
	 * Data to post during migration.
	 *
	 * @var array
	 */
	protected $post_data = array();

	/**
	 * Required PHP version
	 *
	 * @var string
	 */
	protected $php_version_required;

	/**
	 * Migration Data
	 *
	 * @var array
	 */
	protected $migration;

	function __construct( $plugin_file_path ) {
		parent::__construct( $plugin_file_path );

		if ( ! version_compare( PHP_VERSION, $this->php_version_required, '>=' ) ) {
			return;
		}

		global $wpmdb;
		$this->wpmdb = $wpmdb;

		add_filter( 'wpmdb_cli_finalize_migration_response', array( $this, 'finalize_ajax' ), 10, 1 );
	}

	/**
	 * Checks profile data before CLI migration.
	 *
	 * @param int|array $profile Profile key or array.
	 *
	 * @return mixed|WP_Error
	 */
	public function pre_cli_migration_check( $profile ) {
		if ( ! version_compare( PHP_VERSION, $this->php_version_required, '>=' ) ) {
			return $this->cli_error( sprintf( __( 'CLI addon requires PHP %1$s+', 'wp-migrate-db-cli' ), $this->php_version_required ) );
		}

		if ( is_array( $profile ) ) {
			$query_str = http_build_query( $profile );
			$profile   = $this->wpmdb->parse_migration_form_data( $query_str );
			$profile   = wp_parse_args( $profile, array(
				'save_computer'             => '0',
				'gzip_file'                 => '0',
				'replace_guids'             => '0',
				'exclude_transients'        => '0',
				'exclude_spam'              => '0',
				'keep_active_plugins'       => '0',
				'compatibility_older_mysql' => '0',
			) );
		}

		$this->profile = $profile = apply_filters( 'wpmdb_cli_profile_before_migration', $profile );

		if ( is_wp_error( $profile ) ) {
			return $profile;
		}

		return true;
	}

	/**
	 * Performs CLI migration given a profile data.
	 *
	 * @param  int|array $profile Profile key or array.
	 * @param  array     $assoc_args
	 *
	 * @return bool|WP_Error Returns true if succeed or WP_Error if failed.
	 */
	public function cli_migration( $profile, $assoc_args = array() ) {
		$pre_check = $this->pre_cli_migration_check( $profile );
		if ( is_wp_error( $pre_check ) ) {
			return $pre_check;
		}

		// At this point, $profile has been checked a retrieved into $this->profile, so should not be used in this function any further.
		if ( empty( $this->profile ) ) {
			return $this->cli_error( __( 'Profile not found or unable to be generated from params.', 'wp-migrate-db-cli' ) );
		}
		unset( $profile );

		$this->set_time_limit();
		$this->wpmdb->set_cli_migration();

		if ( 'savefile' === $this->profile['action'] ) {
			$this->post_data['intent'] = 'savefile';
			if ( ! empty( $this->profile['export_dest'] ) ) {
				$this->post_data['export_dest'] = $this->profile['export_dest'];
			} else {
				$this->post_data['export_dest'] = 'ORIGIN';
			}
		}

		if ( 'find_replace' === $this->profile['action'] ) {
			$this->post_data['intent'] = 'find_replace';
		}

		if ( 'import' === $this->profile['action'] ) {
			$this->post_data['intent'] = 'import';

			if ( ! isset( $this->profile['import_file'] ) ) {
				if ( isset( $assoc_args['import-file'] ) ) {
					$this->profile['import_file'] = $assoc_args['import-file'];
				} else {
					return $this->cli_error( __( 'Missing path to import file. Use --import-file=/path/to/import.sql.gz', 'wp-migrate-db' ) );
				}
			}
		}

		// Ensure local site_details available.
		$this->post_data['site_details']['local'] = $this->site_details();

		// Check for tables specified in migration profile that do not exist in the source database
		if ( ! empty( $this->profile['select_tables'] ) && 'import' !== $this->profile['action'] ) {
			$source_tables = apply_filters( 'wpmdb_cli_filter_source_tables', $this->get_tables() );

			if ( ! empty( $source_tables ) ) {
				// Return error if selected tables do not exist in source database
				$nonexistent_tables = array();
				foreach ( $this->profile['select_tables'] as $table ) {
					if ( ! in_array( $table, $source_tables ) ) {
						$nonexistent_tables[] = $table;
					}
				}

				if ( ! empty( $nonexistent_tables ) ) {
					$local_or_remote = ( 'pull' === $this->profile['action'] ) ? 'remote' : 'local';

					return $this->cli_error( sprintf( __( 'The following table(s) do not exist in the %1$s database: %2$s', 'wp-migrate-db-cli' ), $local_or_remote, implode( ', ', $nonexistent_tables ) ) );
				}
			}
		}

		$this->profile = apply_filters( 'wpmdb_cli_filter_before_cli_initiate_migration', $this->profile );
		if ( is_wp_error( $this->profile ) ) {
			return $this->profile;
		}

		do_action( 'wpmdb_cli_before_migration', $this->post_data, $this->profile );
		$this->migration = $this->cli_initiate_migration();

		if ( is_wp_error( $this->migration ) ) {
			return $this->migration;
		}

		$this->post_data['migration_state_id'] = $this->migration['migration_state_id'];

		if ( 'import' === $this->profile['action'] ) {
			if ( $this->profile['create_backup'] ) {
				$tables_to_process = $this->migrate_tables();
			} else {
				$tables_to_process = $this->get_tables_to_migrate();
			}
		} else {
			$tables_to_process = $this->migrate_tables();
		}

		if ( is_wp_error( $tables_to_process ) ) {
			return $tables_to_process;
		}

		$this->post_data['tables'] = implode( ',', $tables_to_process );

		do_action( 'wpmdb_cli_during_cli_migration', $this->post_data, $this->profile );

		$finalize = $this->finalize_migration();
		if ( is_wp_error( $finalize ) || 'savefile' === $this->profile['action'] ) {
			return $finalize;
		}

		return true;
	}

	/**
	 * Verify CLI response from endpoint.
	 *
	 * @param  string $response      Response from endpoint.
	 * @param  string $function_name Name of called function.
	 *
	 * @return WP_Error|string
	 */
	function verify_cli_response( $response, $function_name ) {
		$response = trim( $response );
		if ( false === $response ) {
			return $this->cli_error( $this->error );
		}

		if ( false === $this->wpmdb->is_json( $response ) ) {
			return $this->cli_error( sprintf( __( 'We were expecting a JSON response, instead we received: %2$s (function name: %1$s)', 'wp-migrate-db-cli' ), $function_name, $response ) );
		}

		$response = json_decode( $response, true );
		if ( isset( $response['wpmdb_error'] ) ) {
			return $this->cli_error( $response['body'] );
		}

		// Display warnings and non fatal error messages as CLI warnings without aborting.
		if ( isset( $response['wpmdb_warning'] ) || isset( $response['wpmdb_non_fatal_error'] ) ) {
			$body     = ( isset ( $response['cli_body'] ) ) ? $response['cli_body'] : $response['body'];
			$messages = maybe_unserialize( $body );
			foreach ( ( array ) $messages as $message ) {
				if ( $message ) {
					WP_CLI::warning( self::cleanup_message( $message ) );
				}
			}
		}

		return $response;
	}

	/**
	 * Return instance of WP_Error.
	 *
	 * @param  string $message Error message.
	 *
	 * @return WP_Error.
	 */
	function cli_error( $message ) {
		return new WP_Error( 'wpmdb_cli_error', self::cleanup_message( $message ) );
	}

	/**
	 * Cleanup message, replacing <br> with \n and removing HTML.
	 *
	 * @param  string $message Error message.
	 *
	 * @return string $message.
	 */
	static function cleanup_message( $message ) {
		$message = html_entity_decode( $message, ENT_QUOTES );
		$message = preg_replace( '#<br\s*/?>#', "\n", $message );
		$message = trim( strip_tags( $message ) );

		return $message;
	}

	/**
	 * Initiates migration and verifies result
	 *
	 * @return array|WP_Error
	 */
	function cli_initiate_migration() {
		do_action( 'wpmdb_cli_before_initiate_migration', $this->profile );

		WP_CLI::log( __( 'Initiating migration...', 'wp-migrate-db-cli' ) );

		$migration_args                          = $this->post_data;
		$migration_args['form_data']             = http_build_query( $this->profile );
		$migration_args['stage']                 = 'migrate';
		$migration_args['site_details']['local'] = $this->site_details();

		if ( 'find_replace' === $this->profile['action'] ) {
			$migration_args['stage'] = 'find_replace';

		}

		$this->post_data = apply_filters( 'wpmdb_cli_initiate_migration_args', $migration_args, $this->profile );

		$this->post_data['site_details'] = json_encode( $this->post_data['site_details'] );

		$response = $this->initiate_migration( $this->post_data );

		$initiate_migration_response = $this->verify_cli_response( $response, 'initiate_migration()' );
		if ( ! is_wp_error( $initiate_migration_response ) ) {
			$initiate_migration_response = apply_filters( 'wpmdb_cli_initiate_migration_response', $initiate_migration_response );
		}

		return $initiate_migration_response;
	}

	/**
	 * Determine which tables to migrate
	 *
	 * @return array|WP_Error
	 */
	function get_tables_to_migrate() {
		$tables_to_migrate = $this->get_tables( 'prefix' );

		return apply_filters( 'wpmdb_cli_tables_to_migrate', $tables_to_migrate, $this->profile, $this->migration );
	}

	/**
	 * Returns a WP-CLI progress bar instance
	 *
	 * @param array $tables
	 * @param int   $stage
	 *
	 * @return cli\progress\Bar|WP_CLI\NoOp
	 */
	function get_progress_bar( $tables, $stage ) {

		$progress_label = __( 'Exporting tables', 'wp-migrate-db-cli' );

		if ( 'find_replace' === $this->profile['action'] ) {
			$progress_label = __( 'Running find & replace', 'wp-migrate-db-cli' );
		}

		$progress_label = apply_filters( 'wpmdb_cli_progress_label', $progress_label, $stage, $tables );

		$progress_label = str_pad( $progress_label, 20, ' ' );

		$count = $this->get_total_rows_from_table_list( $tables, $stage );

		return WP_CLI\Utils\make_progress_bar( $progress_label, $count );
	}

	/**
	 * Returns total rows from list of tables
	 *
	 * @param array $tables
	 * @param int   $stage
	 *
	 * @return Int
	 */
	function get_total_rows_from_table_list( $tables, $stage ) {
		static $cached_results = array();

		if ( isset( $cached_results[ $stage ] ) ) {
			return $cached_results[ $stage ];
		}

		$table_rows               = $this->get_row_counts_from_table_list( $tables, $stage );
		$cached_results[ $stage ] = array_sum( array_intersect_key( $table_rows, array_flip( $tables ) ) );

		return $cached_results[ $stage ];
	}

	/**
	 * Returns row counts from list of tables
	 *
	 * @param array $tables
	 * @param int   $stage
	 *
	 * @return mixed
	 */
	function get_row_counts_from_table_list( $tables, $stage ) {
		static $cached_results = array();

		if ( isset( $cached_results[ $stage ] ) ) {
			return $cached_results[ $stage ];
		}

		$local_table_rows         = $this->wpmdb->get_table_row_count();
		$cached_results[ $stage ] = apply_filters( 'wpmdb_cli_get_row_counts_from_table_list', $local_table_rows, $stage );

		return $cached_results[ $stage ];
	}

	/**
	 * @return array|mixed|string|void|WP_Error
	 */
	function migrate_tables() {
		$tables_to_migrate = $this->get_tables_to_migrate();

		$tables         = $tables_to_migrate;
		$stage_iterator = 2;

		$filtered_vars = apply_filters( 'wpmdb_cli_filter_before_migrate_tables', array(
			'tables'         => $tables,
			'stage_iterator' => $stage_iterator,
		) );
		if ( ! is_array( $filtered_vars ) ) {
			return $filtered_vars;
		} else {
			extract( $filtered_vars, EXTR_OVERWRITE );
		}

		if ( empty( $tables ) ) {
			return $this->cli_error( __( 'No tables selected for migration.', 'wp-migrate-db' ) );
		}

		$table_rows = $this->get_row_counts_from_table_list( $tables, $stage_iterator );

		do_action( 'wpmdb_cli_before_migrate_tables', $this->profile, $this->migration );

		$notify = $this->get_progress_bar( $tables, $stage_iterator );
		$args   = $this->post_data;

		do {
			$migration_progress = 0;

			foreach ( $tables as $key => $table ) {
				$current_row         = -1;
				$primary_keys        = '';
				$table_progress      = 0;
				$table_progress_last = 0;

				$args['table']      = $table;
				$args['last_table'] = ( $key == count( $tables ) - 1 ) ? '1' : '0';

				do {
					// reset the current chunk
					$this->wpmdb->empty_current_chunk();

					$args['current_row']  = $current_row;
					$args['primary_keys'] = $primary_keys;
					$args                 = apply_filters( 'wpmdb_cli_migrate_table_args', $args, $this->profile, $this->migration );

					$response = $this->migrate_table( $args );

					$migrate_table_response = $this->verify_cli_response( $response, 'migrate_table()' );

					if ( is_wp_error( $migrate_table_response ) ) {
						return $migrate_table_response;
					}

					$migrate_table_response = apply_filters( 'wpmdb_cli_migrate_table_response', $migrate_table_response, $_POST, $this->profile, $this->migration );

					$current_row  = $migrate_table_response['current_row'];
					$primary_keys = $migrate_table_response['primary_keys'];

					$last_migration_progress = $migration_progress;

					if ( -1 == $current_row ) {
						$migration_progress -= $table_progress;
						$migration_progress += $table_rows[ $table ];
					} else {
						if ( 0 === $table_progress_last ) {
							$table_progress_last = $current_row;
							$table_progress      = $table_progress_last;
							$migration_progress += $table_progress_last;
						} else {
							$iteration_progress  = $current_row - $table_progress_last;
							$table_progress_last = $current_row;
							$table_progress += $iteration_progress;
							$migration_progress += $iteration_progress;
						}
					}

					$increment = $migration_progress - $last_migration_progress;

					$notify->tick( $increment );

				} while ( -1 != $current_row );
			}

			$notify->finish();

			++$stage_iterator;
			$args['stage'] = 'migrate';

			if ( 'import' === $args['intent'] ) {
				break;
			}

			$tables        = $tables_to_migrate;
			$table_rows    = $this->get_row_counts_from_table_list( $tables, $stage_iterator );

			if ( $stage_iterator < 3 ) {
				$notify = $this->get_progress_bar( $tables, $stage_iterator );
			}
		} while ( $stage_iterator < 3 );

		$this->post_data = $args;

		return $tables;
	}

	/**
	 * Finalize migration
	 *
	 * @return bool|WP_Error
	 */
	function finalize_migration() {
		do_action( 'wpmdb_cli_before_finalize_migration', $this->profile, $this->migration );

		WP_CLI::log( __( 'Cleaning up...', 'wp-migrate-db-cli' ) );

		$finalize = apply_filters( 'wpmdb_cli_finalize_migration', true, $this->profile, $this->migration );
		if ( is_wp_error( $finalize ) ) {
			return $finalize;
		}

		$this->post_data = apply_filters( 'wpmdb_cli_finalize_migration_args', $this->post_data, $this->profile, $this->migration );

		if ( 'savefile' === $this->post_data['intent'] ) {
			return $this->finalize_export();
		}

		$response = null;
		$response = apply_filters( 'wpmdb_cli_finalize_migration_response', $response );
		if ( ! empty( $response ) && '1' !== $response ) {
			return $this->cli_error( $response );
		}

		do_action( 'wpmdb_cli_after_finalize_migration', $this->profile, $this->migration );

		return true;
	}

	/**
	 * Stub for ajax_initiate_migration()
	 *
	 * @param array|bool $args
	 *
	 * @return string
	 */
	function initiate_migration( $args = false ) {
		$_POST    = $args;
		$response = $this->wpmdb->ajax_initiate_migration();

		return $response;
	}

	/**
	 * stub for ajax_migrate_table()
	 *
	 * @param array|bool $args
	 *
	 * @return string
	 */
	function migrate_table( $args = false ) {
		$_POST    = $args;
		$response = $this->wpmdb->ajax_migrate_table();

		return $response;
	}

	/**
	 * Stub for ajax_finalize_migration()
	 * hooks on: wpmdb_cli_finalize_migration_response
	 *
	 * @param string $response
	 *
	 * @return string
	 */
	function finalize_ajax( $response ) {
		// don't send redundant POST variables
		$args     = $this->filter_post_elements( $this->post_data, array( 'action', 'migration_state_id', 'prefix', 'tables' ) );
		$_POST    = $args;
		$response = $this->wpmdb->ajax_finalize_migration();

		return trim( $response );
	}

	/**
	 * Finalize Export by moving file to specified destination
	 *
	 * @return string|error
	 */
	function finalize_export() {
		$state_data = $this->wpmdb->state_data;
		$temp_file  = $state_data['dump_path'];
		if ( 'ORIGIN' === $state_data['export_dest'] ) {
			$response = $temp_file;
		} else {
			$dest_file = $state_data['export_dest'];
			if ( file_exists( $temp_file ) && rename( $temp_file, $dest_file ) ) {
				$response = $dest_file;
			} else {
				$response = $this->cli_error( __( 'Unable to move exported file.', 'wp-migrate-db' ) );
			}
		}

		return $response;
	}
	/**
	 * Returns array of CLI options that are unknown to plugin and addons.
	 *
	 * @param array $assoc_args
	 *
	 * @return array
	 */
	public function get_unknown_args( $assoc_args = array() ) {
		$unknown_args = array();

		if ( empty( $assoc_args ) ) {
			return $unknown_args;
		}

		$known_args = array(
			'action',
			'export_dest',
			'find',
			'replace',
			'exclude-spam',
			'gzip-file',
			'exclude-post-revisions',
			'skip-replace-guids',
			'include-transients',
		);

		$known_args = apply_filters( 'wpmdb_cli_filter_get_extra_args', $known_args );
		$unknown_args = array_diff( array_keys( $assoc_args ), $known_args );
		
		return $unknown_args;
	}

	/**
	 * Get profile data from CLI args.
	 *
	 * @param array $args
	 * @param array $assoc_args
	 *
	 * @return array|WP_Error
	 */
	public function get_profile_data_from_args( $args, $assoc_args ) {

		//load correct cli class
		if ( function_exists( 'wp_migrate_db_pro_cli_addon' ) && function_exists( 'wp_migrate_db_pro' ) ) {
			$wpmdb_cli = wp_migrate_db_pro_cli_addon();
		} elseif ( function_exists( 'wpmdb_pro_cli' ) ) {
			$wpmdb_cli = wpmdb_pro_cli();
		} else {
			$wpmdb_cli = wpmdb_cli();
		}

		$unknown_args = $this->get_unknown_args( $assoc_args );

		if ( ! empty( $unknown_args ) ) {
			$message = __( 'Parameter errors: ', 'wp-migrate-db-cli' );
			foreach ( $unknown_args as $unknown_arg ) {
				$message .= "\n " . sprintf( __( 'unknown %s parameter', 'wp-migrate-db-cli' ), '--' . $unknown_arg );
			}

			if ( is_a( $wpmdb_cli, 'WPMDBPro_CLI' ) ) {
				$message .= "\n" . __( 'Please make sure that you have activated the appropriate addons for WP Migrate DB Pro.', 'wp-migrate-db-cli' );
			}

			return $wpmdb_cli->cli_error( $message );
		}

		foreach ( $assoc_args as $key => $value ) {
			if ( empty( $value) ) {
				WP_CLI::warning( __( '--' . $key . ' parameter needs a value.', 'wp-migrate-db-cli' ) );
			}
		}

		if ( empty( $assoc_args['action'] ) ) {
			return $wpmdb_cli->cli_error( __( 'Missing action parameter', 'wp-migrate-db-cli' ) );
		}

		if ( 'savefile' === $assoc_args['action'] && ! empty( $assoc_args['export_dest'] ) ) {
			$export_dest = $assoc_args['export_dest'];
		}

		$action = $assoc_args['action'];

		// --find=<old> and --replace=<new>
		$replace_old = array();
		$replace_new = array();
		if ( ! empty( $assoc_args['find'] ) ) {
			$replace_old = str_getcsv( $assoc_args['find'] );
		} else {
			if ( 'find_replace' === $assoc_args['action'] ) {
				if ( empty( $assoc_args['replace'] ) ) {
					return $wpmdb_cli->cli_error( __( 'Missing find and replace values.', 'wp-migrate-db-cli' ) );
				}
				return $wpmdb_cli->cli_error( __( 'Find value is required.', 'wp-migrate-db-cli' ) );
			}
		}
		if ( ! empty( $assoc_args['replace'] ) ) {
			$replace_new = str_getcsv( $assoc_args['replace'] );
		} else {
			if ( 'find_replace' === $assoc_args['action'] ) {
				return $wpmdb_cli->cli_error( __( 'Replace value is required.', 'wp-migrate-db-cli' ) );
			}
		}
		if ( count( $replace_old ) !== count( $replace_new ) ) {
			return $wpmdb_cli->cli_error( sprintf( __( '%1$s and %2$s must contain the same number of values', 'wp-migrate-db-cli' ), '--find', '--replace' ) );
		}
		array_unshift( $replace_old, '' );
		array_unshift( $replace_new, '' );

		// --exclude-spam
		$exclude_spam = intval( isset( $assoc_args['exclude-spam'] ) );

		// --gzip-file
		$gzip_file = intval( isset( $assoc_args['gzip-file'] ) );

		$select_post_types = array();

		// --exclude-post-revisions
		if ( ! empty( $assoc_args['exclude-post-revisions'] ) ) {
			$select_post_types[] = 'revision';
		}

		$exclude_post_types = count( $select_post_types ) > 0 ? 1 : 0;

		// --skip-replace-guids
		$replace_guids = 1;
		if ( isset( $assoc_args['skip-replace-guids'] ) ) {
			$replace_guids = 0;
		}

		$select_tables        = array();
		$table_migrate_option = 'migrate_only_with_prefix';

		// --include-transients.
		$exclude_transients = intval( ! isset( $assoc_args['include-transients'] ) );

		//cleanup filename for exports
		if ( ! empty( $export_dest ) ) {
			if ( $gzip_file ) {
				if ( 'gz' !== pathinfo( $export_dest, PATHINFO_EXTENSION ) ) {
					if ( 'sql' === pathinfo( $export_dest, PATHINFO_EXTENSION ) ) {
						$export_dest .= '.gz';
					} else {
						$export_dest .= '.sql.gz';
					}
				}
			} elseif ( 'sql' !== pathinfo( $export_dest, PATHINFO_EXTENSION ) ) {
				$export_dest = preg_replace( '/(\.sql)?(\.gz)?$/i', '', $export_dest ) . '.sql';
			}

			// ensure export destination is writable
			if ( ! @touch( $export_dest ) ) {
				return $wpmdb_cli->cli_error( sprintf( __( 'Cannot write to file "%1$s". Please ensure that the specified directory exists and is writable.', 'wp-migrate-db-cli' ), $export_dest ) );
			}
		}

		$profile = compact( 'action', 'replace_old', 'table_migrate_option', 'replace_new', 'select_tables', 'exclude_post_types', 'select_post_types', 'replace_guids', 'exclude_spam', 'gzip_file', 'exclude_transients', 'export_dest' );

		$profile = apply_filters( 'wpmdb_cli_filter_get_profile_data_from_args', $profile, $args, $assoc_args );

		return $profile;
	}
}
