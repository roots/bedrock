<?php

class WPMDB_Migration_State {
	const OPTION_PREFIX = 'wpmdb_state_';
	const TIMEOUT_PREFIX = 'wpmdb_state_timeout_';
	const EXPIRATION = 86400; // 60s * 60m * 24h

	private $_value = null;
	private $_id = null;

	/**
	 * @param string $id
	 */
	function __construct( $id = '' ) {
		if ( ! empty( $id ) ) {
			$value = get_site_option( $this->_option( $id ), false, false );

			if ( false !== $value ) {
				$this->_id    = $id;
				$this->_value = $value;
			}
		}
	}

	/**
	 * Returns the unique id of the instance.
	 *
	 * @return string
	 */
	function id() {
		if ( empty( $this->_id ) ) {
			$this->_id = uniqid();
		}

		return $this->_id;
	}

	/**
	 * Returns the site option string used to save the migration state.
	 *
	 * @param string $id
	 *
	 * @return string
	 */
	private function _option( $id = null ) {
		if ( empty( $id ) ) {
			$id = $this->id();
		}

		return self::OPTION_PREFIX . $id;
	}

	/**
	 * Returns the site option string used to save the migration state timeout.
	 *
	 * @param string $id
	 *
	 * @return string
	 */
	private function _timeout_option( $id = null ) {
		if ( empty( $id ) ) {
			$id = $this->id();
		}

		return self::TIMEOUT_PREFIX . $id;
	}

	/**
	 * Set the migration state.
	 *
	 * @param $value
	 *
	 * @return bool
	 */
	function set( $value ) {
		if ( $this->_update_timeout() && update_site_option( $this->_option(), $value ) ) {
			return true;
		}

		// If nothing changed it's still OK.
		if ( $this->get() === $value ) {
			return true;
		}

		return false;
	}

	/**
	 * Updates the companion timeout setting to the current migration state option.
	 *
	 * @return bool
	 */
	private function _update_timeout() {
		$value = time() + self::EXPIRATION;

		if ( update_site_option( $this->_timeout_option(), $value ) ) {
			return true;
		}

		// If nothing changed it's still OK.
		if ( get_site_option( $this->_timeout_option(), false, false ) == $value ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns the current saved migration state.
	 *
	 * @return mixed
	 */
	function get() {
		return get_site_option( $this->_option(), false, false );
	}

	/**
	 * Deletes the site options for migration state and its companion timeout record.
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	private static function _delete_id( $id ) {
		if ( false === get_site_option( self::OPTION_PREFIX . $id, false, false ) || delete_site_option( self::OPTION_PREFIX . $id ) ) {
			delete_site_option( self::TIMEOUT_PREFIX . $id );

			return true;
		}

		return false;
	}

	/**
	 * Delete the current migration state.
	 *
	 * @return bool
	 */
	function delete() {
		return $this->_delete_id( $this->id() );
	}

	/**
	 * Get all migration state ids that have timed out.
	 *
	 * @param int $timeout Optional UNIX timestamp for timeout, default of 0 uses current timestamp.
	 *
	 * @return array
	 */
	private static function _timed_out_ids( $timeout = 0 ) {
		global $wpdb;

		$ids = array();

		if ( empty( $timeout ) ) {
			$timeout = time();
		}

		if ( is_multisite() ) {
			$timeout_keys = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT meta_key FROM {$wpdb->sitemeta} WHERE site_id = %d AND meta_key like %s AND meta_value < %d",
					$wpdb->siteid,
					addcslashes( self::TIMEOUT_PREFIX, '_' ) . '%',
					$timeout
				)
			);
		} else {
			$timeout_keys = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s and option_value < %d",
					addcslashes( self::TIMEOUT_PREFIX, '_' ) . '%',
					$timeout
				)
			);
		}

		if ( ! empty( $timeout_keys ) ) {
			$id_start = strlen( self::TIMEOUT_PREFIX );

			foreach ( $timeout_keys as $timeout_key ) {
				$ids[] = substr( $timeout_key, $id_start );
			}
		}

		return $ids;
	}

	/**
	 * Get all migration state ids that have no time out companion.
	 *
	 * @return array
	 */
	private static function _orphaned_ids() {
		global $wpdb;

		$ids = array();

		if ( is_multisite() ) {
			$keys = $wpdb->get_col(
				$wpdb->prepare( "
					SELECT meta_key
					FROM {$wpdb->sitemeta}
					WHERE site_id = %d
					AND meta_key LIKE %s
					AND meta_key NOT LIKE %s
					AND meta_key NOT IN (
						SELECT CONCAT(%s, SUBSTR(meta_key, %d))
						FROM {$wpdb->sitemeta}
						WHERE site_id = %d
						AND meta_key LIKE %s
					)
					",
					$wpdb->siteid,
					addcslashes( self::OPTION_PREFIX, '_' ) . '%',
					addcslashes( self::TIMEOUT_PREFIX, '_' ) . '%',
					self::OPTION_PREFIX,
					strlen( self::TIMEOUT_PREFIX ) + 1,
					$wpdb->siteid,
					addcslashes( self::TIMEOUT_PREFIX, '_' ) . '%'
				)
			);
		} else {
			$keys = $wpdb->get_col(
				$wpdb->prepare( "
					SELECT option_name
					FROM $wpdb->options
					WHERE option_name LIKE %s
					AND option_name NOT LIKE %s
					AND option_name NOT IN (
						SELECT CONCAT(%s, SUBSTR(option_name, %d))
						FROM $wpdb->options
						WHERE option_name LIKE %s
					)
					",
					addcslashes( self::OPTION_PREFIX, '_' ) . '%',
					addcslashes( self::TIMEOUT_PREFIX, '_' ) . '%',
					self::OPTION_PREFIX,
					strlen( self::TIMEOUT_PREFIX ) + 1,
					addcslashes( self::TIMEOUT_PREFIX, '_' ) . '%'
				)
			);
		}

		if ( ! empty( $keys ) ) {
			$id_start = strlen( self::OPTION_PREFIX );

			foreach ( $keys as $key ) {
				$ids[] = substr( $key, $id_start );
			}
		}

		return $ids;
	}

	/**
	 * returns count of all migration state records that have timed out.
	 *
	 * @param int $timeout Optional UNIX timestamp for timeout, default of 0 uses current timestamp.
	 *
	 * @return int
	 */
	static function cleanup_count( $timeout = 0 ) {
		return count( self::_timed_out_ids( $timeout ) ) + count( self::_orphaned_ids() );
	}

	/**
	 * Remove all migration state records that have timed out or are orphaned from their timeout companion.
	 *
	 * @param int $timeout Optional UNIX timestamp for timeout, default of 0 uses current timestamp.
	 *
	 * @return int Count of successfully cleaned up options.
	 */
	static function cleanup( $timeout = 0 ) {
		$count = 0;

		$timed_out_ids = self::_timed_out_ids( $timeout );

		if ( ! empty( $timed_out_ids ) ) {
			foreach ( $timed_out_ids as $id ) {
				if ( self::_delete_id( $id ) ) {
					$count ++;
				}
			}
		}

		$orphaned_ids = self::_orphaned_ids();

		if ( ! empty( $orphaned_ids ) ) {
			foreach ( $orphaned_ids as $id ) {
				if ( self::_delete_id( $id ) ) {
					$count ++;
				}
			}
		}

		return $count;
	}
}