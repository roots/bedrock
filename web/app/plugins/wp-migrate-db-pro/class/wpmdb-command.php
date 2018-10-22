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
	 * Run a find/replace on the database.
	 *
	 * ## OPTIONS
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
	 * [--backup=<prefix|selected|table_one,table_two,table_etc>]
	 * : Perform a backup of the destination site's database tables before replacing it.
	 *
	 *     Accepted values:
	 *
	 *     * prefix - Backup only tables that begin with your installation's
	 *                table prefix (e.g. wp_)
	 *     * selected - Backup only tables selected for migration (as in --include-tables)
	 *     * A comma separated list of the tables to backup.
	 *
	 * [--exclude-post-revisions]
	 * : Exclude post revisions from the find & replace.
	 *
	 * [--skip-replace-guids]
	 * : Do not perform a find & replace on the guid column in the wp_posts table.
	 *
	 * [--exclude-spam]
	 * : Exclude spam comments.
	 *
	 * [--include-transients]
	 * : Include transients (temporary cached data).
	 *
	 * ## EXAMPLES
	 *
	 *     wp migratedb find-replace
	 *        --find=http://dev.bradt.ca,/Users/bradt/home/bradt.ca
	 *        --replace=http://bradt.ca,/home/bradt.ca
	 *
	 * @param array $args
	 * @param array $assoc_args
	 *
	 * @subcommand find-replace
	 */
	public function find_replace( $args, $assoc_args ) {

		$assoc_args['action'] = 'find_replace';

		$profile = $this->_get_profile_data_from_args( $args, $assoc_args );

		if ( is_wp_error( $profile ) ) {
			WP_CLI::error( $profile );
		}

		$this->_perform_cli_migration( $profile );
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
		// Load the correct CLI class
		if ( function_exists( 'wpmdb_pro_cli' ) ) {
			if ( function_exists( 'wp_migrate_db_pro_cli_addon' ) ) {
				$wpmdb_cli = wp_migrate_db_pro_cli_addon();
			} else {
				$wpmdb_cli = wpmdb_pro_cli();
			}
		} else {
			$wpmdb_cli = wpmdb_cli();
		}

		return $wpmdb_cli->get_profile_data_from_args( $args, $assoc_args );
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
			$success_msg = sprintf( __( 'Export saved to: %s', 'wp-migrate-db-cli' ), $result );

			if ( 'find_replace' === $profile['action'] ) {
				$success_msg = __( 'Find & Replace complete', 'wp-migrate-db-cli' );
			}

			WP_CLI::success( $success_msg );
		} elseif ( is_wp_error( $result ) ) {
			WP_CLI::error( WPMDB_CLI::cleanup_message( $result->get_error_message() ) );
		}
	}
}

WP_CLI::add_command( 'migratedb', 'WPMDB_Command' );
