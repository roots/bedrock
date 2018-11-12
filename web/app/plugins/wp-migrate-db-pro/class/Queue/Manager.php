<?php

namespace WPMDB\Queue;

class Manager {

	public $queue;
	public $worker;
	public $connection;
	public $prefix;
	public $jobs_table;
	public $failures_table;
	public $wpdb;
	public $intent;

	function __construct( $wpmdb ) {
		$this->wpdb           = $GLOBALS['wpdb'];
		$this->prefix         = $wpmdb->get( 'temp_prefix' );
		$this->jobs_table     = $this->prefix . "queue_jobs";
		$this->failures_table = $this->prefix . "queue_failures";
		$this->wpmdb          = $wpmdb;
		$this->intent         = $this->wpmdb->get( 'state_data' )['intent'];

		$this->connection = new Connection( $GLOBALS['wpdb'] );
		$this->queue      = new Queue( $this->connection, $this->prefix );
		$this->worker     = new Worker( $this->connection, 1 );

		add_action( 'wpmdb_initiate_migration', [ $this, 'ensure_tables_exist' ] );
	}

	function enqueue_file( $file ) {
		return $this->enqueue_job( new Jobs\WPMDB_Job( $file ) );
	}

	function enqueue_job( Job $job ) {
		return $this->queue->push( $job );
	}

	function process() {
		return $this->worker->process();
	}

	function ensure_tables_exist() {
		$state_data = $this->wpmdb->wpmdbpro->get( 'state_data' );
		$form_data  = $this->wpmdb->parse_migration_form_data( $state_data['form_data'] );

		if ( ! \in_array( $state_data['intent'], [ 'push', 'pull' ] ) ) {
			return;
		}

		if ( ! isset( $form_data['migrate_themes']) && ! isset( $form_data['migrate_plugins'] ) ) {
			return;
		}

		$this->create_tables( true );
	}

	function tables_exist() {
		return ( $this->wpdb->get_var( "SHOW TABLES LIKE '{$this->jobs_table}'" ) == $this->jobs_table && $this->wpdb->get_var( "SHOW TABLES LIKE '{$this->failures_table}'" ) == $this->failures_table );
	}

	function create_tables( $drop = false ) {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$this->wpdb->hide_errors();
		$charset_collate = $this->wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS {$this->jobs_table} (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				job longtext NOT NULL,
				attempts tinyint(3) NOT NULL DEFAULT 0,
				reserved_at datetime DEFAULT NULL,
				available_at datetime NOT NULL,
				created_at datetime NOT NULL,
				PRIMARY KEY  (id)
				) $charset_collate;";

		if ( $drop ) {
			$this->wpdb->query( "DROP TABLE IF EXISTS {$this->jobs_table}" );
		}

		$this->wpdb->query( $sql );

		$sql = "CREATE TABLE IF NOT EXISTS {$this->failures_table} (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				job longtext NOT NULL,
				error text DEFAULT NULL,
				failed_at datetime NOT NULL,
				PRIMARY KEY  (id)
				) $charset_collate;";

		if ( $drop ) {
			$this->wpdb->query( "DROP TABLE IF EXISTS {$this->failures_table}" );
		}

		$this->wpdb->query( $sql );
	}

	function drop_tables() {
		$this->wpdb->hide_errors();

		$sql = "DROP TABLE IF EXISTS {$this->jobs_table}";
		$this->wpdb->query( $sql );

		$sql = "DROP TABLE IF EXISTS {$this->failures_table}";
		$this->wpdb->query( $sql );

	}

	/**
	 * Wrapper for DatabaseConnection::jobs()
	 *
	 * @return int
	 */

	public function count_jobs() {
		return $this->connection->jobs();
	}

	/**
	 *
	 * @param     $count
	 * @param int $offset
	 *
	 * @return array|null|object
	 *
	 */
	public function delete_data_from_queue( $count = 99999999 ) {
		$sql = "DELETE FROM {$this->jobs_table} LIMIT {$count}";

		$results = $this->wpdb->query( $sql );

		return $results;
	}

	public function truncate_queue() {
		$sql = "TRUNCATE TABLE {$this->jobs_table}";

		$results = $this->wpdb->query( $sql );

		return $results;
	}

	/**
	 * Get list of jobs in queue
	 *
	 * @param int  $limit
	 * @param int  $offset
	 * @param bool $raw if true, method will return serialized instead of instantiated objects
	 *
	 * @return array
	 */
	public function list_jobs( $limit = 9999999, $offset = 0, $raw = false ) {
		return $this->connection->list_jobs( $limit, $offset, $raw );
	}
}
