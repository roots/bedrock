<?php

namespace WPMDB\Queue;


class Connection extends \WPMDB\Queue\Connections\DatabaseConnection {

	public function __construct( $wpdb = null, $prefix = null ) {
		if ( null === $wpdb ) {
			$wpdb = $GLOBALS['wpdb'];
		}
		if ( null === $prefix ) {
			$prefix = $GLOBALS['wpmdbpro']->get( 'temp_prefix' );
		}

		$this->database       = $wpdb;
		$this->jobs_table     = $prefix . 'queue_jobs';
		$this->failures_table = $prefix . 'queue_failures';
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
	public function list_jobs( $limit, $offset, $raw = false ) {
		$offset  = null === $offset ? 0 : $offset;
		$limit   = null === $limit ? 9999999 : $limit;
		$raw_sql = "
			SELECT * FROM {$this->jobs_table}
			WHERE reserved_at IS NULL
			AND available_at <= %s
			LIMIT %d,%d
		";
		$sql     = $this->database->prepare( $raw_sql, $this->datetime(), $offset, $limit );
		$results = $this->database->get_results( $sql );

		if ( $raw ) {
			return $results;
		}

		$jobs = [];
		foreach ( $results as $raw_job ) {
			$jobs[ $raw_job->id ] = $this->vitalize_job( $raw_job );
		}

		return $jobs;
	}
}
