<?php

require_once __DIR__ . '/wpmdb-cli.php';

class WPMDBPro_CLI_Export extends WPMDB_CLI {

	/**
	 * Instance of WPMDBPro.
	 *
	 * @var WPMDBPro
	 */
	protected $wpmdbpro;

	function __construct( $plugin_file_path ) {
		parent::__construct( $plugin_file_path );

		global $wpmdbpro;
		$this->wpmdb    = &$this->wpmdbpro;
		$this->wpmdbpro = $wpmdbpro;

		// add support for extra args
		add_filter( 'wpmdb_cli_filter_get_extra_args', array( $this, 'filter_extra_args_cli_export' ), 10, 1 );
		add_filter( 'wpmdb_cli_filter_get_profile_data_from_args', array( $this, 'add_extra_args_for_pro_export' ), 10, 3 );

		// extend get_tables_to_migrate with migrate_select
		add_filter( 'wpmdb_cli_tables_to_migrate', array( $this, 'tables_to_migrate_include_select' ), 10, 1 );
	}

	/**
	 * Add extra CLI args used by this plugin.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function filter_extra_args_cli_export( $args = array() ) {
		$args[] = 'include-tables';
		$args[] = 'exclude-post-types';

		return $args;
	}

	/**
	 * Add support for extra args in export
	 *
	 * @param array $profile
	 * @param array $args
	 * @param array $assoc_args
	 *
	 * @return array
	 */
	function add_extra_args_for_pro_export( $profile, $args, $assoc_args ) {
		if ( ! is_array( $profile ) ) {
			return $profile;
		}

		// --include-tables=<tables>
		if ( ! empty( $assoc_args['include-tables'] ) ) {
			$table_migrate_option = 'migrate_select';
			$select_tables        = explode( ',', $assoc_args['include-tables'] );
		} else {
			$select_tables        = array();
			$table_migrate_option = 'migrate_only_with_prefix';
		}

		// --exclude-post-types=<post-types>
		$select_post_types = array();
		if ( ! empty( $assoc_args['exclude-post-types'] ) ) {
			$select_post_types = explode( ',', $assoc_args['exclude-post-types'] );
		}

		$filtered_profile = compact(
			'table_migrate_option',
			'select_post_types',
			'select_tables'
		);

		return array_merge( $profile, $filtered_profile );
	}

	/**
	 * Use tables from --include-tables assoc arg if available
	 *
	 * @param array $tables_to_migrate
	 *
	 * @return array
	 */
	function tables_to_migrate_include_select( $tables_to_migrate ) {
		if ( 'savefile' === $this->profile['action'] &&
		     'migrate_select' === $this->profile['table_migrate_option'] &&
		     ! empty( $this->profile['select_tables'] )
		) {
			$tables_to_migrate = array_intersect( $this->profile['select_tables'], $this->get_tables() );
		}

		return $tables_to_migrate;
	}
}
