<?php
/**
 * Migrate your DB using WP Migrate DB Pro.
 */

//require wpmdb-command.php from wp-migrate-db-pro
require_once __DIR__ . '/wpmdb-command.php';

class WPMDBPro_Command extends WPMDB_Command {
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
	 * [--include-tables=<tables>]
	 * : The comma separated list of tables to migrate. Excluding this parameter
	 * will migrate all tables in your database that begin with your
	 * installation's table prefix, e.g. wp_.
	 *
	 * [--exclude-post-types=<post-types>]
	 * : A comma separated list of post types to exclude. Excluding this parameter
	 * will migrate all post types.
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
	 * [--subsite=<blog-id|subsite-url>]
	 * : Export the given subsite as a single site install. Requires the Multisite Tools addon.
	 *
	 * [--prefix=<new-table-prefix>]
	 * : A new table prefix to be used for a subsite export.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migratedb export ./migratedb.sql \
	 *        --find=http://dev.bradt.ca,/Users/bradt/home/bradt.ca
	 *        --replace=http://bradt.ca,/home/bradt.ca
	 *        --include-tables=wp_posts,wp_postmeta
	 *
	 * @param array $args
	 * @param array $assoc_args
	 */
	public function export( $args, $assoc_args ) {
		parent::export( $args, $assoc_args );
	}
}

WP_CLI::add_command( 'migratedb', 'WPMDBPro_Command' );
