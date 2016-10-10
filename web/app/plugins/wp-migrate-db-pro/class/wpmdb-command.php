<?php

/**
 * Migrate your DB using WP Migrate DB.
 */
class WPMDB_Command extends WP_CLI_Command {

	/**
	 * Export local DB to file.
	 *
	 * ## OPTIONS
	 *
	 * <output-file>
	 * : A file path to export to. Filename will be modified to end in .sql or
	 * .sql.gz if necessary.
	 *
	 * [--find=<strings>]
	 * : A comma separated list of strings to find when performing a string find
	 * and replace across the database.
	 *
	 *     Table names should be quoted as needed, i.e. when using a comma in the
	 *     find/replace string.
	 *
	 *     The --replace=<strings> argument should be used in conjunction to specify
	 *     the replace values for the strings found using this argument. The number
	 *     of strings specified in this argument should match the number passed into
	 *     --replace=<strings> argument.
	 *
	 * [--replace=<strings>]
	 * : A comma separated list of replace value strings to implement when
	 * performing a string find & replace across the database.
	 *
	 *     Should be used in conjunction with the --find=<strings> argument, see it's
	 *     documentation for further explanation of the find & replace functionality.
	 *
	 * [--exclude-post-revisions]
	 * : Exclude post revisions from export.
	 *
	 * [--skip-replace-guids]
	 * : Do not perform a find & replace on the guid column in the wp_posts table.
	 *
	 * [--exclude-spam]
	 * : Exclude spam comments.
	 *
	 * [--gzip-file]
	 * : GZip compress export file.
	 *
	 * [--include-transients]
	 * : Include transients (temporary cached data).
	 *
	 * ## EXAMPLES
	 *
	 *     wp migratedb export ./migratedb.sql \
	 *        --find=http://dev.bradt.ca,/Users/bradt/home/bradt.ca
	 *        --replace=http://bradt.ca,/home/bradt.ca
	 *
	 * @param array $args
	 * @param array $assoc_args
	 */
	public function export( $args, $assoc_args ) {

		$assoc_args['action']      = 'savefile';
		$assoc_args['export_dest'] = trim( $args[0] );

		if ( empty( $assoc_args['export_dest'] ) ) {
			WP_CLI::error( WPMDB_CLI::cleanup_message( __( 'You must provide a destination filename.', 'wp-migrate-db-cli' ) ) );
		}

		$profile = $this->_get_profile_data_from_args( $args, $assoc_args );

		if ( is_wp_error( $profile ) ) {
			WP_CLI::error( $profile );
		}

		$this->_perform_cli_migration( $profile );
	}

	/**
	 * Returns array of CLI options that are unknown to plugin and addons.
	 *
	 * @param array $assoc_args
	 *
	 * @return array
	 */
	private function _get_unknown_args( $assoc_args = array() ) {
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
	protected function _get_profile_data_from_args( $args, $assoc_args ) {

		//load correct cli class
		if ( function_exists( 'wp_migrate_db_pro_cli_addon' ) ) {
			$wpmdb_cli = wp_migrate_db_pro_cli_addon();
		} elseif ( function_exists( 'wpmdb_pro_cli' ) ) {
			$wpmdb_cli = wpmdb_pro_cli();
		} else {
			$wpmdb_cli = wpmdb_cli();
		}

		$unknown_args = $this->_get_unknown_args( $assoc_args );

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
		}
		if ( ! empty( $assoc_args['replace'] ) ) {
			$replace_new = str_getcsv( $assoc_args['replace'] );
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

		$profile = compact(
			'action',
			'replace_old',
			'table_migrate_option',
			'replace_new',
			'select_tables',
			'exclude_post_types',
			'select_post_types',
			'replace_guids',
			'exclude_spam',
			'gzip_file',
			'exclude_transients',
			'export_dest'
		);

		$profile = apply_filters( 'wpmdb_cli_filter_get_profile_data_from_args', $profile, $args, $assoc_args );

		return $profile;
	}


	/**
	 * Perform CLI migration.
	 *
	 * @param mixed $profile Profile key or array
	 *
	 * @return void
	 */
	protected function _perform_cli_migration( $profile ) {
		$wpmdb_cli = null;

		//load correct cli class
		if ( function_exists( 'wpmdb_pro_cli' ) ) {
			$wpmdb_cli = wpmdb_pro_cli();
		} else {
			$wpmdb_cli = wpmdb_cli();
		}

		if ( empty( $wpmdb_cli ) ) {
			WP_CLI::error( __( 'WP Migrate DB CLI class not available.', 'wp-migrate-db-cli' ) );
			return;
		}

		$result = $wpmdb_cli->cli_migration( $profile );

		if ( ! is_wp_error( $result ) ) {
			WP_CLI::success( sprintf( __( 'Export saved to: %s', 'wp-migrate-db-cli' ), $result ) );
		} elseif ( is_wp_error( $result ) ) {
			WP_CLI::error( WPMDB_CLI::cleanup_message( $result->get_error_message() ) );
		}
	}

}

WP_CLI::add_command( 'migratedb', 'WPMDB_Command' );
