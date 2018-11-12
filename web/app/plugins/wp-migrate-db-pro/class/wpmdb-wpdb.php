<?php

class WPMDB_WPDB extends WPDB {

	/**
	 * @var string
	 */
	public $last_stripped_query;

	public function __construct() {
		global $wpdb;
		parent::__construct( $wpdb->dbuser, $wpdb->dbpassword, $wpdb->dbname, $wpdb->dbhost );

		// TODO: Determine if it's better to extend $wpdb or just rep some of its methods
	}

	/**
	 * Find the first table name referenced in a query.
	 *
	 * @param string $query The query to search.
	 *
	 * @return string|false $table The table name found, or false if a table couldn't be found.
	 */
	public function get_table_from_query( $query ) {
		return parent::get_table_from_query( $query );
	}

	/**
	 * Strips any invalid characters from the query and caches the stripped query for later use
	 *
	 * @param string $query Query to convert.
	 *
	 * @return string|WP_Error The converted query, or a WP_Error object if the conversion fails.
	 */
	public function strip_invalid_text_from_query( $query ) {
		$query    = apply_filters( 'wpmdb_before_strip_invalid_text_from_query', $query );
		$fallback = false;
		if ( method_exists( $this, 'strip_invalid_text_from_query' ) ) {
			$query = parent::strip_invalid_text_from_query( $query );
			$this->flush();
		} else {
			$fallback = true;
		}
		$this->last_stripped_query = apply_filters( 'wpmdb_after_strip_invalid_text_from_query', $query, $fallback );

		return $this->last_stripped_query;
	}

	/**
	 * Determine if a query has invalid text.
	 *
	 * @param $query query to check
	 *
	 * @return bool
	 */
	public function query_has_invalid_text( $query ) {
		return ( $query !== $this->strip_invalid_text_from_query( $query ) );
	}

}
