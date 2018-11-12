<?php

namespace WPMDB\Queue;

use WPMDB\Queue\Connections\DatabaseConnection;
use WPMDB\Queue\Connections\RedisConnection;
use WPMDB\Queue\Exceptions\ConnectionNotFoundException;

class QueueManager {

	/**
	 * @var array
	 */
	protected static $instances = array();

	/**
	 * Resolve a Queue instance for required connection.
	 *
	 * @param string $connection
	 *
	 * @return Queue
	 */
	public static function resolve( $connection ) {
		if ( isset( static::$instances[ $connection ] ) ) {
			return static::$instances[ $connection ];
		}

		return static::build( $connection );
	}

	/**
	 * Build a queue instance.
	 *
	 * @param string $connection
	 *
	 * @return Queue
	 * @throws \Exception
	 */
	protected static function build( $connection ) {
		$connections = static::connections();

		if ( empty( $connections[ $connection ] ) ) {
			throw new ConnectionNotFoundException();
		}

		static::$instances[ $connection ] = new Queue( $connections[ $connection ] );

		return static::$instances[ $connection ];
	}

	/**
	 * Get available connections.
	 *
	 * @return array
	 */
	protected static function connections() {
		$connections = array(
			'database' => new DatabaseConnection( $GLOBALS['wpdb'] ),
			'redis'    => new RedisConnection(),
		);

		return apply_filters( 'wp_queue_connections', $connections );
	}
}
